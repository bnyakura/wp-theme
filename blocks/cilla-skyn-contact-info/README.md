# Cilla Skyn Contact Info Block

A row of contact-method cards (icon, label, value, link), reusable anywhere in the block editor. Sourced from the "Contact Information" list in `NewProject/Cilla Skyn Website Layout.docx` (WhatsApp, Instagram, Email) — meant for the About or a dedicated Contact page.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Heading** | Text | No | Section heading. Default: "Get in Touch". |
| **Subheading** | WYSIWYG | No | Rich-text supporting content under the heading — bold/italic, headings, lists, links, and (via the editor's "Add Media" button) images and file links, or an embedded video from a pasted YouTube/Vimeo URL. |
| **Methods** | Repeater | No | One card per contact method: **Icon**, **Label**, **Value**, **URL**. |

### Methods row sub-fields

| Field | Type | Description |
|---|---|---|
| **Icon** | Select (WhatsApp, Instagram, Email, Phone) | Picks one of 4 inline SVG icons baked into `render.php`. |
| **Label** | Text | Small uppercase label, e.g. "WhatsApp". |
| **Value** | Text | The displayed text, e.g. "+27 64 911 1932" or "@Cillaskyn". |
| **URL** | URL | Where the card links to, e.g. `https://wa.me/27649111932`, `mailto:Info@cillaskyn.co.za`. Leave empty to render the card as plain (non-clickable) text. |

## Notes

- Ships with the 3 default methods from the source document — WhatsApp, Instagram, Email — via `inc/block-defaults/cilla-skyn-contact-info.php` (ACF Repeater fields don't support `default_value`, see the main theme README §4/§11).
- Icons follow the same pattern as the [Feature Strip](../cilla-skyn-feature-strip/README.md) block: a small fixed set of inline SVGs selected per row, no image uploads.
- This is separate from the header/footer's own WhatsApp/Instagram Customizer settings (main theme README §8) — those control the header chrome and footer social icons; this block is for a page section that needs its own contact list (e.g. an About or Contact page).
- **Subheading is a rich-text (WYSIWYG) field**, one of a handful in this theme's block library — the [About Hero](../cilla-skyn-about-hero/README.md) block's Intro/Description use the identical pattern; every other field in every other block is still plain Text/Textarea (see the main theme README §16). `render.php` reads it unformatted and runs it through WordPress's own `the_content` filter — the same pipeline core post content goes through — so pasted shortcodes, a bare YouTube/Vimeo URL on its own line, and paragraph spacing all work exactly like they would in a normal page. Its rendered HTML (headings, bold, lists, links, images, embeds) is styled in this block's own `style.css`, scoped under `.cilla-skyn-contact-info-subheading` — Tailwind's preflight strips default heading/paragraph styling, and this content can't carry Tailwind utility classes since it comes from the block editor, not `render.php`.
- **If you need this same rich-text capability on another block's field**, that's a manual per-field change (ACF field type → `wysiwyg`, `render.php` → the `get_field( name, false, false )` + `apply_filters( 'the_content', ... )` pattern above, plus scoped CSS in that block's `style.css`) — it wasn't rolled out theme-wide, since most other fields (labels, eyebrows, one-line captions) are intentionally plain text.
