# Cilla Skyn Sticky Banner Block

A full-bleed banner meant to be placed **between two other sections/blocks on a page**, to mark a deliberate break between them. Its content (image, eyebrow, heading, etc.) `position: sticky` at the top of the viewport and holds still there while the section above scrolls away, staying visible for a stretch of extra scrolling before finally releasing and letting the section below take over — that pause is what reads as a divider, rather than the banner just going by like any other section.

Same field set as the [Cilla Skyn Banner](../cilla-skyn-banner/README.md) block (background image with fit/focal point, overlay, text colour, eyebrow, heading, two rich-text paragraphs, tagline), plus one new control: **Pin Duration**.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Pin Duration** | Range (100–300%) | No | How long the banner holds still, as a percentage of the viewport height. 100% turns off the pinning effect (acts like a normal full-height section). Default 150% — the banner stays locked in place for an extra half a screen's worth of scrolling before releasing. Higher values make the divider pause longer and more obvious. |
| **Background Image (Desktop)** | Image | No | Fills the pinned banner at 1280px and wider. Also used as the fallback for Tablet/Mobile when either is left empty. Leave all three empty for a plain cream panel — the pinning effect still applies to whatever text fields are filled in. |
| **Background Image (Tablet)** | Image | No | Optional separate crop/photo used from 768px up to 1279px wide, in place of Desktop. |
| **Background Image (Mobile)** | Image | No | Optional separate crop/photo used below 768px wide — pick a taller, portrait-friendly crop. |
| **Image Fit** | Select | No | CSS `object-fit` for the background image. Default: Cover. |
| **Image Focal Point** (X) / **(Y)** | Range sliders | No | CSS `object-position` as free-form X/Y percentages. 50/50 (default) is centered. No drag-to-position crosshair overlay on this block (unlike Banner) — use the sliders directly. |
| **Background Overlay Color** | Color picker (with opacity) | No | Wash placed over the background image so the centered text stays readable. Leave empty for no wash. |
| **Text Color** | Color picker | No | Overrides Heading/Intro/Description/Tagline colour. Doesn't affect Eyebrow (always brand gold). |
| **Eyebrow** | Text | No | Small uppercase label above the heading. |
| **Heading** | Text | No | Main serif headline (`<h1>`). |
| **Intro** | WYSIWYG | No | First, short paragraph. |
| **Description** | WYSIWYG | No | Second, supporting paragraph. |
| **Tagline** | Text | No | Small uppercase closing line, flanked by rules. |

## How the pin effect works

`render.php` renders two nested boxes:

1. An **outer `<section>`** with `min-height: {Pin Duration}vh` (an inline style, since it's a free-form percentage — same reasoning as the Focal Point fields going out as inline styles instead of pre-built Tailwind classes).
2. An **inner content box**, `sticky top-0 h-screen`, holding the image/overlay and the centered eyebrow/heading/text/tagline.

Because the inner box is always exactly one viewport tall but the outer section is taller (150vh by default), the inner box sticks to the top of the viewport for the difference — 50vh of extra scrolling at the default setting — before the outer section ends and the next block on the page continues normally. No JS, no negative margins, no z-index tricks: this is the standard CSS-only "sticky reveal" pattern, and it's the **first block in the theme to use `position: sticky`** (confirmed via a repo-wide search before building — there was no existing sticky/scroll pattern to match against, and no sticky site header to worry about offsetting around).

Set Pin Duration to 100% if you just want a normal (non-pinning) full-height banner — everything else about the block still works the same.

## Notes

- **Blank-friendly, same as Banner**: no field carries a `default_value`, nothing falls back to placeholder copy, and every section (image, overlay, eyebrow, heading, intro, description, tagline) is wrapped in its own `if`. The pin effect itself doesn't depend on any of them being filled in — even a blank cream panel will hold still for the configured Pin Duration.
- Structurally mirrors Banner otherwise: same ACF field types (image/select/range/color_picker/wysiwyg/text), same `the_content` pipeline for Intro/Description, same rich-text styling approach (`style.css`, scoped under `.cilla-skyn-sticky-banner-content` instead of `.cilla-skyn-banner-content`, centered).
- If you want a scroll-triggered fade-in on the text as the banner locks into place, `assets/js/reveal.js` + `data-reveal`/`.is-revealed` is the theme's existing scroll-effect convention — not wired up here by default, since the pin/divider effect alone was the ask.
- No `inc/block-defaults/` file — no Repeater fields, only scalars, and none of them need a bootstrapped default.
