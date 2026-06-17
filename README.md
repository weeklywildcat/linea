# Weekly Wildcat WordPress Theme

A modern WordPress block theme for student newspaper and school journalism websites.

## Status

Early development. The theme is built around native WordPress features first: block templates, template parts, block patterns, Query Loop blocks, and `theme.json` design tokens.

## Goals

- Native Full Site Editing support
- Fast, responsive newspaper layouts
- Flexible homepage patterns that editors can customize in the Site Editor
- Clean article, archive, search, page, 404, and posts-index templates
- Minimal JavaScript and minimal custom PHP
- Design tokens managed through `theme.json`

## Theme structure

```text
parts/       Reusable header and footer template parts
templates/   Native block templates for the site
patterns/    Reusable newspaper layouts and query sections
theme.json   Global styles, typography, spacing, colors, and layout settings
style.css    Theme metadata and small responsive helpers
```

## Local testing

1. Install WordPress locally or on a staging site.
2. Copy this theme into `wp-content/themes/weekly-wildcat/`.
3. In WordPress Admin, go to **Appearance → Themes**.
4. Activate **Weekly Wildcat**.
5. Customize templates in **Appearance → Editor**.

## License

GPL-2.0-or-later.
