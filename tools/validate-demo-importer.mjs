import { readFileSync } from 'node:fs';

const importerPath = 'demo-content/importer.php';
const wxrPath = 'demo-content/linea-demo-content.xml';
const importer = readFileSync(importerPath, 'utf8');
const wxr = readFileSync(wxrPath, 'utf8');
const errors = [];

const definitions = new Set(
	[...importer.matchAll(/function\s+(linea_(?:import_demo_content|demo_[a-z0-9_]+))\s*\(/g)].map((match) => match[1])
);
const calls = new Set(
	[...importer.matchAll(/\b(linea_(?:import_demo_content|demo_[a-z0-9_]+))\s*\(/g)].map((match) => match[1])
);

for (const call of calls) {
	if (!definitions.has(call)) {
		errors.push(`${importerPath} calls ${call}() but does not define it.`);
	}
}

for (const required of [
	'linea_import_demo_content',
	'linea_demo_create_categories',
	'linea_demo_create_placeholder_attachments',
	'linea_demo_create_posts',
	'linea_demo_create_comments',
	'linea_demo_create_navigation',
	'linea_demo_story_data',
]) {
	if (!definitions.has(required)) {
		errors.push(`${importerPath} is missing required function ${required}().`);
	}
}

for (const marker of ['_linea_demo_story', '_linea_demo_placeholder']) {
	if (!importer.includes(marker)) {
		errors.push(`${importerPath} is missing idempotency marker ${marker}.`);
	}
}

for (const requiredXml of ['<rss', '<channel>', '<wp:wxr_version>1.2</wp:wxr_version>', '</channel>', '</rss>']) {
	if (!wxr.includes(requiredXml)) {
		errors.push(`${wxrPath} is missing ${requiredXml}.`);
	}
}

if (!/<item>[\s\S]*<wp:post_type><!\[CDATA\[post\]\]><\/wp:post_type>[\s\S]*<\/item>/.test(wxr)) {
	errors.push(`${wxrPath} must include at least one post item.`);
}

if (errors.length) {
	console.error(errors.map((error) => `- ${error}`).join('\n'));
	process.exit(1);
}

console.log(`Validated ${importerPath} helpers and ${wxrPath} structure.`);
