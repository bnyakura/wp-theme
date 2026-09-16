# Cilla Skyn Sticky Banner Block

A full-bleed banner meant to be placed **between two other sections/blocks on a page**, to mark a deliberate break between them. Its content (image, eyebrow, heading, etc.) `position: sticky` at the top of the viewport and holds still there while the section above scrolls away, staying visible for a stretch of extra scrolling before finally releasing and letting the section below take over. While it's stuck, it also fades to a chosen transparency so the next section becomes visible sliding up underneath it — a "reveal" transition, not just a pause.

Same field set as the [Cilla Skyn Banner](../cilla-skyn-banner/README.md) block (background image with fit/focal point, overlay, text colour, eyebrow, heading, two rich-text paragraphs, tagline), plus two new controls: **Pin Duration** and **Opacity While Stuck**.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Pin Duration** | Range (100–200%) | No | How long the banner holds still, as a percentage of the viewport height. 100% turns off the pinning effect (acts like a normal full-height section, and Opacity While Stuck has nothing to do). Default 150% — the banner stays locked in place for an extra half a screen's worth of scrolling before releasing; that same stretch is how long the next section spends sliding up underneath it. **Keep this no larger than the actual height of the block(s) that follow it on the page** — see "How the pin + reveal effect works" below for why. |
| **Opacity While Stuck** | Range (10–100%) | No | Once the banner locks to the top of the screen, it fades to this opacity, so the next section becomes visible sliding up underneath it, right through the banner, until the pin releases. Default 45%. 100% keeps the banner fully solid the whole time it's stuck — the plain divider look, no reveal. |
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

## How the pin + reveal effect works

`render.php` renders:

1. An **outer `<section>`**, `z-10` so it paints above whatever comes after it on the page, with `min-height: {Pin Duration}vh` and `margin-bottom: -{Pin Duration − 100}vh` (both inline styles, since they're free-form percentages — same reasoning as the Focal Point fields going out as inline styles instead of pre-built Tailwind classes).
2. Two 1px **sentinel divs**, invisible (see below for what each one detects).
3. The **pinned content box** itself (`.cilla-skyn-sticky-banner-pin`, `sticky top-0 h-screen`), holding the image/overlay and the centered eyebrow/heading/text/tagline.

The negative margin is the key piece: it shrinks how much space the section reserves for the *next* block on the page by exactly the same "extra" distance Pin Duration adds beyond one viewport (50vh at the 150% default) — so that next block starts overlapping underneath the still-pinned banner during that stretch, instead of only appearing after the banner fully releases. `z-10` keeps the banner painting on top of it during that overlap (otherwise the later, unrelated block would just cover the banner outright, since later DOM elements paint over earlier ones by default).

Two separate moments get detected, each via `assets/js/sticky-banner-reveal.js` watching a sentinel with `IntersectionObserver` (the standard trick: the instant a zero-footprint marker scrolls out of view, something specific just happened):

- **`.cilla-skyn-sticky-banner-sentinel`** sits at the banner's own natural (un-stuck) position. The instant it scrolls out of view, the banner must have just locked to the top of the viewport, so JS adds `.is-stuck` to the pin box, and `style.css`'s transition fades it to the configured Opacity While Stuck over 0.7s.
- **`.cilla-skyn-sticky-banner-bottom-sentinel`** sits `{Pin Duration − 100}vh` down from the wrapper's top — **not** the wrapper's own bottom edge. That distinction matters: CSS `position: sticky`, once released, doesn't jump back to its original position — per spec it settles flush against the *bottom* of its containing block, which (deliberately, so the next block can overlap it while it's still stuck) is the exact same spot that next block was pulled up to. Left alone, the released banner would sit there **permanently**, ghosting over that block's content indefinitely instead of handing off cleanly — this was a real bug during development, caught by scripting a headless-browser scroll-through of the actual rendered page rather than reasoning about the CSS alone. The fix: the instant this second sentinel scrolls out of view (i.e. the moment the pin genuinely releases), JS adds `.is-past`, which forces the banner fully invisible right then, so the hand-off to the next block is clean.

No JS / no `IntersectionObserver` support: neither class ever gets added, so the banner just stays fully opaque and visible the whole time it's on screen — a safe fallback, not a broken transparent block.

Set Pin Duration to 100% if you just want a normal (non-pinning, non-revealing) full-height banner — Opacity While Stuck becomes moot at that setting, since there's no overlap distance for anything to show through.

This was the **first block in the theme to use `position: sticky`**, and this reveal effect is the first scroll-driven JS beyond `assets/js/reveal.js`'s simple fade-in (confirmed via a repo-wide search before building either — there was no existing pattern to match against, and no sticky site header to worry about offsetting around).

## Notes

- **Blank-friendly, same as Banner**: no field carries a `default_value`, nothing falls back to placeholder copy, and every section (image, overlay, eyebrow, heading, intro, description, tagline) is wrapped in its own `if`. The pin/reveal effect itself doesn't depend on any of them being filled in — even a blank cream panel will hold still and fade on schedule.
- Structurally mirrors Banner otherwise: same ACF field types (image/select/range/color_picker/wysiwyg/text), same `the_content` pipeline for Intro/Description, same rich-text styling approach (`style.css`, scoped under `.cilla-skyn-sticky-banner-content` instead of `.cilla-skyn-banner-content`, centered).
- No `inc/block-defaults/` file — no Repeater fields, only scalars, and none of them need a bootstrapped default.
