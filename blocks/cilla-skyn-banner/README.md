# Cilla Skyn Banner Block

Same centered layout as the [About Hero](../cilla-skyn-about-hero/README.md) block — optional background image, eyebrow, heading, two rich-text paragraphs, closing tagline — but usable on any page, and every field is genuinely optional.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Background Image** | Image | No | Renders full-bleed behind the text. Leave empty for a plain cream panel. |
| **Background Overlay Color** | Color picker (with opacity) | No | Wash placed over the Background Image so text stays readable. Leave empty for no wash at all — the photo shows untouched. Has no effect until a Background Image is set. |
| **Text Color** | Color picker | No | Overrides the colour of Heading, Intro, Description and Tagline. Leave empty to use the theme's standard ink colour. Doesn't affect Eyebrow, which always stays the brand gold accent. |
| **Eyebrow** | Text | No | Small uppercase label above the heading. Leave empty to omit it. |
| **Heading** | Text | No | Main serif headline (`<h1>`). Leave empty to omit it. |
| **Intro** | WYSIWYG | No | First, short paragraph. Rich-text editor: bold/italic, headings, lists, links, and (via "Add Media") images and file links, or an embedded video from a pasted YouTube/Vimeo URL. Leave empty to omit it. |
| **Description** | WYSIWYG | No | Second, supporting paragraph. Same rich-text editor as Intro. Leave empty to omit it. |
| **Tagline** | Text | No | Small uppercase closing line, flanked by rules. Leave empty to omit it. |

## Notes

- **This is the deliberately "blank-friendly" sibling of About Hero.** About Hero gives every field a `default_value` so the section never looks broken or empty (see that block's README). This block does the opposite on purpose: no field carries a `default_value`, and `render.php` never falls back to placeholder copy — every section (image, overlay, eyebrow, heading, intro, description, tagline) is wrapped in its own `if` and simply doesn't render when its field is empty. Leaving everything empty renders a blank cream panel with only the block's own padding — that's expected, not a bug.
- Use **About Hero** when you want the docx's original brand-statement copy to show by default until someone overrides it (e.g. the top of the About page). Use **Banner** when you want a page section that can be as minimal as "just an image" or "just a heading," with nothing else showing unless it's explicitly filled in.
- Structurally and visually identical to About Hero otherwise — same Tailwind classes, same rich-text styling (`style.css`, scoped under `.cilla-skyn-banner-content` instead of `.cilla-skyn-about-hero-content`), same ACF field types. If About Hero ever changes its markup, mirror the change here too.
- No `inc/block-defaults/` file — no Repeater fields, only scalars, and none of them need a bootstrapped default.
