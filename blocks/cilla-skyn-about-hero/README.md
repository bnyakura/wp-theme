# Cilla Skyn About Hero Block

Centered brand-statement intro, meant for the top of the About page. Sourced from the "Hero Statement" copy in `NewProject/Cilla Skyn Website Layout.docx`'s About Us section (this section isn't in the homepage mockup — it's the first block on the About page, above [Our Story](../cilla-skyn-our-story/README.md)).

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Background Image** | Image | No | Optional. Renders full-bleed behind the text, with **Background Overlay Color** washed over it so the copy stays readable. Leave empty for a plain cream panel. |
| **Background Overlay Color** | Color picker (with opacity) | No | Always visible, but only has a visible effect once a Background Image is set (an intentional conditional-show for this field turned out to be unreliable in the block editor for Image fields, so it's just always shown instead — see Notes). Wash colour + opacity placed over the photo — click the swatch and use the picker's own opacity slider. Default: cream at 80% opacity, matching the original design. Set the opacity all the way down for the photo untouched, or up to ~100% to hide it almost entirely behind a solid colour. |
| **Text Color** | Color picker | No | Overrides the colour of Heading, Intro, Description and Tagline (including headings/bold text typed inside Intro/Description). Doesn't affect Eyebrow, which always stays the brand gold accent. Default: the theme's standard ink colour (`#1B1712`) — same as not setting it. |
| **Eyebrow** | Text | No | Small uppercase label above the heading. Default: "About Cilla Skyn". |
| **Heading** | Text | No | Main serif headline (`<h1>`). Default: "Skincare with Purpose". |
| **Intro** | WYSIWYG | No | First, short brand-statement paragraph. Rich-text editor: bold/italic, headings, lists, links, and (via "Add Media") images and file links, or an embedded video from a pasted YouTube/Vimeo URL. |
| **Description** | WYSIWYG | No | Second, supporting paragraph. Same rich-text editor as Intro. |
| **Tagline** | Text | No | Small uppercase closing line, flanked by rules, e.g. "Thoughtfully formulated. Purposefully layered. Inspired by nature." |

## Notes

- **No bundled fallback photo** — unlike the [Hero](../cilla-skyn-hero/README.md) block, this one has no default image shipped with the theme (there wasn't one for this section in the source document). Leaving Background Image empty renders the original copy-only cream panel; the block never looks broken either way.
- **Background Overlay Color** replaces what used to be a fixed `bg-cream/80` class — it's now a real color-picker field (`render.php` writes it straight into an inline `background-color` style), so you can match the wash to a specific photo, switch to a dark wash for light text, or dial the opacity down to let a lot more of the photo show through. It's **not conditionally hidden** even though it only does anything once Background Image is set — ACF's conditional logic ("show this field only when that Image field has a value") doesn't reliably fire inside ACF Blocks' editor form, so this field originally shipped hidden-until-an-image-is-picked and that hid it *permanently* for some users. Showing it unconditionally is less tidy but actually works.
- **Text Color** is applied as an inline `color` style on Heading, and on the Intro/Description/Tagline wrapper elements — anything typed inside Intro/Description without its own explicit colour (via the editor's own text-colour tool) inherits it too, including headings and bold text (`style.css` uses `color: inherit` for those rather than a fixed value). The relative light/dark hierarchy between Intro, Description and Tagline is preserved via `opacity`, not colour, so they still look layered at any colour you pick. Eyebrow is intentionally excluded — it's a brand accent (always gold), not body copy.
- **Intro and Description are rich-text (WYSIWYG) fields**, following the exact same pattern as the [Contact Info](../cilla-skyn-contact-info/README.md) block's Subheading — see that block's README for the technical detail (`render.php` reads them unformatted and runs them through WordPress's `the_content` filter to avoid double-wrapped paragraphs; their rendered HTML is styled in this block's own `style.css`, scoped under `.cilla-skyn-about-hero-content`). **Eyebrow, Heading and Tagline stay plain text on purpose** — they render inside an `<h1>` and small uppercase caption lines, which aren't suited to multi-paragraph or embedded content.
- All fields fall back to the docx's original copy/colours via `default_value` in `acf-json/group_cilla_skyn_about_hero.json` — an empty field never leaves the section blank or unstyled.
