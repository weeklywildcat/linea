import { readFileSync, readdirSync, statSync } from 'node:fs';
import { join, relative } from 'node:path';
import { parse } from '@wordpress/block-serialization-default-parser';

const root = process.cwd();
const checkedDirs = [ 'templates', 'parts', 'patterns' ];
const errors = [];

function filesIn(dir, extensions) {
	const out = [];
	for (const entry of readdirSync(join(root, dir))) {
		const full = join(root, dir, entry);
		if (statSync(full).isDirectory()) {
			continue;
		}
		if (extensions.some((ext) => entry.endsWith(ext))) {
			out.push(full);
		}
	}
	return out;
}

function stripPatternHeader(content) {
	return content.replace(/^<\?php[\s\S]*?\?>\s*/, '');
}

function walkBlocks(blocks, visitor) {
	for (const block of blocks) {
		visitor(block);
		if (block.innerBlocks?.length) {
			walkBlocks(block.innerBlocks, visitor);
		}
	}
}

const patternFiles = filesIn('patterns', [ '.php' ]);
const patternSlugs = new Set();

for (const file of patternFiles) {
	const content = readFileSync(file, 'utf8');
	const slug = content.match(/^\s*\*\s*Slug:\s*(.+)$/m)?.[1]?.trim();
	if (!slug) {
		errors.push(`${relative(root, file)} is missing a pattern Slug header.`);
		continue;
	}
	patternSlugs.add(slug);
}

const templateParts = new Set(
	filesIn('parts', [ '.html' ]).map((file) => relative(join(root, 'parts'), file).replace(/\.html$/, ''))
);

for (const dir of checkedDirs) {
	const extensions = dir === 'patterns' ? [ '.php' ] : [ '.html' ];
	for (const file of filesIn(dir, extensions)) {
		const rel = relative(root, file);
		let content = readFileSync(file, 'utf8');
		if (dir === 'patterns') {
			content = stripPatternHeader(content);
		}

		if (content.includes('weekly-wildcat') || content.includes('Weekly Wildcat')) {
			errors.push(`${rel} still contains the old Weekly Wildcat name or slug.`);
		}

		if (content.includes('Most Read') && content.includes('"orderBy":"comment_count"')) {
			errors.push(`${rel} labels a comment-count query as Most Read. Use Most Discussed or add real view tracking.`);
		}

		if (content.includes('wp:button') && /<a\s+class="wp-block-button__link(?![^>]*\shref=)/.test(content)) {
			errors.push(`${rel} contains a button link without an href.`);
		}

		let blocks;
		try {
			blocks = parse(content);
		} catch (error) {
			errors.push(`${rel} could not be parsed as serialized blocks: ${error.message}`);
			continue;
		}

		walkBlocks(blocks, (block) => {
			if (block.blockName === 'core/pattern') {
				const slug = block.attrs?.slug;
				if (!slug) {
					errors.push(`${rel} contains a pattern block without a slug.`);
				} else if (!patternSlugs.has(slug)) {
					errors.push(`${rel} references missing pattern slug "${slug}".`);
				}
			}

			if (block.blockName === 'core/template-part') {
				const slug = block.attrs?.slug;
				if (!slug) {
					errors.push(`${rel} contains a template part block without a slug.`);
				} else if (!templateParts.has(slug)) {
					errors.push(`${rel} references missing template part "${slug}".`);
				}
			}
		});
	}
}

if (errors.length) {
	console.error(errors.map((error) => `- ${error}`).join('\n'));
	process.exit(1);
}

console.log(`Validated ${checkedDirs.join(', ')} block markup and references.`);
