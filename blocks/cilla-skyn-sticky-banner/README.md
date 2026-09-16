# Cilla Skyn Sticky Banner Block

A full-bleed parallax banner: the background image stays visually fixed to the browser window while the page scrolls past it, then the next block on the page covers it normally once this section ends. The classic CSS-only technique (`background-attachment: fixed`) — no JS, no `position: sticky`, no negative margins, no z-index.

Same field set as the [Cilla Skyn Banner](../cilla-skyn-banner/README.md) block (background image with focal point, overlay, text colour, eyebrow, heading, two rich-text paragraphs, tagline), plus one new control: **Section Height**.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Section Height** | Range (40–200%) | No | How tall this section is, as a percentage of the viewport height — also how long the parallax effect lasts, since the background stays fixed for as long as this section is scrolling past. Default 80%. |
| **Background Image (Desktop)** | Image | No | Fills the section as a fixed background at 768px and wider. Also used as the fallback for Tablet/Mobile when either is left empty. Leave all three empty for a plain cream panel. |
| **Background Image (Tablet)** | Image | No | Optional separate crop/photo used from 768px up to 1279px wide, in place of Desktop. |
| **Background Image (Mobile)** | Image | No | Optional separate crop/photo used below 768px wide. The parallax effect itself is switched off below 768px regardless (see below), so this just renders as a normal scrolling background. |
| **Image Focal Point** (X) / **(Y)** | Range sliders | No | CSS `background-position` as free-form X/Y percentages. 50/50 (default) is centered. |
| **Background Overlay Color** | Color picker (with opacity) | No | Wash placed over the background image so the centered text stays readable. Leave empty for no wash. |
| **Text Color** | Color picker | No | Overrides Heading/Intro/Description/Tagline colour. Doesn't affect Eyebrow (always brand gold). |
| **Eyebrow** | Text | No | Small uppercase label above the heading. |
| **Heading** | Text | No | Main serif headline (`<h1>`). |
| **Intro** | WYSIWYG | No | First, short paragraph. |
| **Description** | WYSIWYG | No | Second, supporting paragraph. |
| **Tagline** | Text | No | Small uppercase closing line, flanked by rules. |

## How the parallax effect works

`render.php` gives the `<section>` itself a `background-image` (not an `<img>` tag) and sets `background-attachment: fixed` on it via a small inline `<style>` block scoped to that block instance's unique ID — a CSS background-image can't respond to a `<picture>`'s `<source media>` the way the Hero/Banner blocks' responsive images do, so the Desktop/Tablet/Mobile swap happens via `@media`-scoped rules in that same `<style>` block instead.

With `background-attachment: fixed`, the image is painted relative to the *browser window*, not the section's own box — so as the page scrolls, the section's content scrolls normally while the image underneath it appears to stay still, creating the parallax illusion. There's no separate "pin" or "release" step to manage: the effect is simply active for as long as the section's own box (Section Height tall) is on screen, and the moment it scrolls past, whatever block comes next on the page covers it exactly like any other pair of adjacent sections — no lingering ghost, no overlap math.

**Mobile note**: `background-attachment: fixed` is a long-documented unreliable/janky effect on iOS Safari, so it's automatically turned off below 768px (falls back to `background-attachment: scroll`, a normal scrolling background) rather than shipping a broken effect to most phones. This is a platform limitation, not a bug.

## Notes

- **This replaced an earlier `position: sticky` + negative-margin version of this block** (visible in git history) that tried to pin the banner in place for extra scroll distance while fading it to reveal the next section underneath. That approach had a real bug — `position: sticky`, once released, settles flush against the *bottom* of its containing block rather than back at its original position, which caused the banner to ghost permanently over the next block's content — and was generally more fragile (needed two IntersectionObserver sentinels, careful z-index/overlap math, and a content-length caveat) for a similar visual result. `background-attachment: fixed` gets a comparable "something's happening as you scroll past this banner" effect with none of that complexity.
- **Blank-friendly, same as Banner**: no field carries a `default_value`, nothing falls back to placeholder copy, and every section (image, overlay, eyebrow, heading, intro, description, tagline) is wrapped in its own `if`.
- Structurally mirrors Banner otherwise: same ACF field types (image/range/color_picker/wysiwyg/text), same `the_content` pipeline for Intro/Description, same rich-text styling approach (`style.css`, scoped under `.cilla-skyn-sticky-banner-content` instead of `.cilla-skyn-banner-content`, centered).
- No `inc/block-defaults/` file — no Repeater fields, only scalars, and none of them need a bootstrapped default.
