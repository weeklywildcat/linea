# Linea WordPress Theme

A modern WordPress block theme for student newspaper and school journalism websites.

## Status

Early development. The theme is built around native WordPress features first: block templates, template parts, block patterns, Query Loop blocks, and `theme.json` design tokens.

## Goals

- Native Full Site Editing support
- Fast, responsive newspaper layouts
- Flexible homepage patterns that editors can customize in the Site Editor
- Clean article, archive, search, page, 404, author, category, tag, and posts-index templates
- Minimal JavaScript and minimal custom PHP
- Design tokens and style variations managed through `theme.json`

## Theme structure

```text
parts/       Reusable header, footer, and comments template parts
templates/   Native block templates for the site
patterns/    Reusable newspaper layouts and query sections
styles/      Style variations for alternate looks
theme.json   Global styles, typography, spacing, colors, and layout settings
style.css    Theme metadata and small responsive helpers
```

## Local testing

1. Install WordPress locally or on a staging site.
2. Copy this theme into `wp-content/themes/linea/`.
3. In WordPress Admin, go to **Appearance → Themes**.
4. Activate **Linea**.
5. Customize templates in **Appearance → Editor**.

## Demo content

Linea includes demo content helpers so a fresh WordPress install does not show an empty or default blog homepage.

- Pull request previews use a WordPress Playground Blueprint that installs the theme and runs the bundled importer automatically.
- Local developers with WP-CLI can run `wp linea import-demo` after activating the theme.
- Sites using the One Click Demo Import plugin will see a **Linea student newspaper demo** import option backed by `demo-content/linea-demo-content.xml`.

The programmatic importer creates lorem ipsum newspaper stories, section categories, comments, navigation items, and plain color placeholder featured media.

## Validation

This repo includes GitHub Actions workflows for theme maintenance:

- `Theme checks` validates PHP syntax, JSON files, required block-theme files, pattern headers, accessibility anchors, search labels, and placeholder links.
- `WordPress theme review` runs the official WordPress Theme Check action in CI.
- `Build theme ZIP` creates a clean installable ZIP artifact on pull requests.
- `PR Preview - Build` and `PR Preview - Publish` build a public installable ZIP and add a working WordPress Playground preview button to pull requests.
- `Release theme ZIP` publishes a packaged ZIP when a `v*` tag is pushed.

## Release workflow

1. Update the version in `style.css`, `functions.php`, and `readme.txt`.
2. Create a tag such as `v0.5.0`.
3. Push the tag to GitHub.
4. Download `linea.zip` from the generated GitHub release.

## License

GPL-2.0-or-later.
