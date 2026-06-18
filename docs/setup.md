# Linea Theme Setup

## Local testing

1. Install WordPress locally or use a staging site.
2. Put this repository in `wp-content/themes/linea/`.
3. Activate **Linea** in **Appearance → Themes**.
4. Open **Appearance → Editor** to adjust templates, template parts, styles, and patterns.

## Recommended first WordPress setup

- Set the site title to the newspaper name.
- Set the tagline to a short publication tagline.
- Create a primary navigation menu with common sections like News, Features, Opinion, Sports, Arts, and Multimedia.
- Add featured images to posts so the homepage and archive cards fill in naturally.
- Use categories as newspaper sections.
- Fill out user bios for staff writers so author pages and article author cards have useful content.

## Demo content

Linea ships with a lightweight demo importer for fresh installs and previews. It uses lorem ipsum story text and plain color placeholder featured media, so the homepage demonstrates the layout without bundling generated or stock photography.

### WP-CLI

After activating the theme, run:

```bash
wp linea import-demo
```

The command creates section categories, sample posts, comments, a navigation menu, and placeholder media. It is safe to run more than once because generated posts and media are tracked with theme-specific metadata.

### One Click Demo Import

The theme registers `demo-content/linea-demo-content.xml` with the One Click Demo Import plugin. Install and activate that plugin, then choose **Linea student newspaper demo** from the import screen.

### WordPress Playground

Pull request preview links use a custom Blueprint that installs the ZIP artifact and runs the same importer automatically. This keeps previews from opening with only the default “Hello world!” post.

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

## Pull request previews and releases

Pull requests receive a WordPress Playground preview button so editors and contributors can test the theme without setting up a local WordPress install. Every pull request also builds an installable ZIP artifact.

For releases, update the version numbers, create a `v*` tag, and push it. The release workflow packages the theme into `linea.zip` and attaches it to a GitHub release.

## Troubleshooting stale templates

If WordPress still shows an older layout after a theme update, check **Appearance → Editor → Templates**. WordPress stores Site Editor customizations in the database, and those saved templates override updated files from the theme. Use the template actions menu to reset the customized template back to the theme default, then reload the site.
