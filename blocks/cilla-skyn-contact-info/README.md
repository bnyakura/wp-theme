# Cilla Skyn Contact Info Block

A row of contact-method cards (icon, label, value, link), reusable anywhere in the block editor. Sourced from the "Contact Information" list in `NewProject/Cilla Skyn Website Layout.docx` (WhatsApp, Instagram, Email) — meant for the About or a dedicated Contact page.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Heading** | Text | No | Section heading. Default: "Get in Touch". |
| **Subheading** | Textarea | No | Supporting text under the heading. |
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
