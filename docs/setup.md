# Weekly Wildcat Theme Setup

## Local testing

1. Install WordPress locally or use a staging site.
2. Put this repository in `wp-content/themes/weekly-wildcat/`.
3. Activate **Weekly Wildcat** in **Appearance → Themes**.
4. Open **Appearance → Editor** to adjust templates, template parts, styles, and patterns.

## Recommended first WordPress setup

- Set the site title to the newspaper name.
- Set the tagline to a short publication tagline.
- Create a primary navigation menu with common sections like News, Features, Opinion, Sports, Arts, and Multimedia.
- Add featured images to posts so the homepage and archive cards fill in naturally.
- Use categories as newspaper sections.
- Fill out user bios for staff writers so author pages and article author cards have useful content.

## Native theme workflow

This theme avoids a custom page builder. Most layout work should happen through native WordPress tools:

- `theme.json` for colors, typography, spacing, and layout widths.
- `templates/` for site templates.
- `parts/` for the header, footer, and comments.
- `patterns/` for reusable newspaper modules.
- `styles/` for native style variations.
- Query Loop blocks for story lists and grids.

## Style variations

The theme includes style variations that can be selected from the WordPress Site Editor. Use these to quickly test a more classic newsprint look or a higher contrast version without changing templates.
