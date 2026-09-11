# Cilla Skyn Banner Block

Same centered layout as the [About Hero](../cilla-skyn-about-hero/README.md) block — optional background image, eyebrow, heading, two rich-text paragraphs, closing tagline — but usable on any page, and every field is genuinely optional.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Background Image (Desktop)** | Image | No | Renders full-bleed behind the text at 1280px and wider. Also used as the fallback for Tablet/Mobile when either is left empty, so a single image here still shows at every screen size. Leave all three image fields empty for a plain cream panel. |
| **Background Image (Tablet)** | Image | No | Optional separate crop/photo used from 768px up to 1279px wide, in place of Desktop — art direction, not just a smaller file. Leave empty to just use Desktop at this size too. |
| **Background Image (Mobile)** | Image | No | Optional separate crop/photo used below 768px wide, in place of Desktop/Tablet. Pick a taller, portrait-friendly crop since a wide photo often crops out the subject on a narrow phone screen. Leave empty to just use Tablet or Desktop at this size too. |
| **Background Overlay Color** | Color picker (with opacity) | No | Wash placed over the background image so text stays readable, at every screen size. Leave empty for no wash at all — the photo shows untouched. Has no effect until at least one background image is set. |
| **Text Color** | Color picker | No | Overrides the colour of Heading, Intro, Description and Tagline. Leave empty to use the theme's standard ink colour. Doesn't affect Eyebrow, which always stays the brand gold accent. |
| **Eyebrow** | Text | No | Small uppercase label above the heading. Leave empty to omit it. |
| **Heading** | Text | No | Main serif headline (`<h1>`). Leave empty to omit it. |
| **Intro** | WYSIWYG | No | First, short paragraph. Rich-text editor: bold/italic, headings, lists, links, and (via "Add Media") images and file links, or an embedded video from a pasted YouTube/Vimeo URL. Leave empty to omit it. |
| **Description** | WYSIWYG | No | Second, supporting paragraph. Same rich-text editor as Intro. Leave empty to omit it. |
| **Tagline** | Text | No | Small uppercase closing line, flanked by rules. Leave empty to omit it. |

## Notes

- **Responsive background images** follow the same `<picture>`/`<source>` art-direction pattern as the [Hero](../cilla-skyn-hero/README.md) block (Desktop/Tablet/Mobile here, vs. Hero's Desktop/Laptop/Tablet/Mobile) — the browser picks whichever `<source>` matches the viewport, evaluated top-to-bottom, so an empty tier is simply skipped and the next size up is used. Unlike Hero, none of the three tiers is required or defaults to a bundled photo: `render.php` resolves Desktop ?: Tablet ?: Mobile for the base `<img>` fallback, so setting just one of the three still shows that image everywhere, and setting none renders no image area at all.
- **This is the deliberately "blank-friendly" sibling of About Hero.** About Hero gives every field a `default_value` so the section never looks broken or empty (see that block's README). This block does the opposite on purpose: no field carries a `default_value`, and `render.php` never falls back to placeholder copy — every section (image, overlay, eyebrow, heading, intro, description, tagline) is wrapped in its own `if` and simply doesn't render when its field is empty. Leaving everything empty renders a blank cream panel with only the block's own padding — that's expected, not a bug.
- Use **About Hero** when you want the docx's original brand-statement copy to show by default until someone overrides it (e.g. the top of the About page). Use **Banner** when you want a page section that can be as minimal as "just an image" or "just a heading," with nothing else showing unless it's explicitly filled in.
- Structurally and visually identical to About Hero otherwise — same Tailwind classes, same rich-text styling (`style.css`, scoped under `.cilla-skyn-banner-content` instead of `.cilla-skyn-about-hero-content`), same ACF field types. If About Hero ever changes its markup, mirror the change here too.
- No `inc/block-defaults/` file — no Repeater fields, only scalars, and none of them need a bootstrapped default.
