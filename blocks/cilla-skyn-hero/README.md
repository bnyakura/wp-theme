# Cilla Skyn Hero Block

Full-bleed cream hero banner reusable anywhere in the block editor. Brand-prefixed so it stays distinct from core/other plugin cover blocks in the inserter. Ported from `NewProject/cilla-skyn-homepage.html`'s hero section.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Background Image (Desktop)** | Image | No | Full-bleed background, used at 1920px and wider, and as the ultimate fallback at every size for whichever of the 3 fields below are left empty. Recommended size: **2560×1024**. Falls back to a placeholder image when empty. |
| **Background Image (Laptop)** | Image | No | Optional. Used from 1280px up to 1919px wide. Recommended size: **1920×768**. Leave empty to fall through to Desktop. |
| **Background Image (Tablet)** | Image | No | Optional. Used from 768px up to 1279px wide. Recommended size: **1536×1024**. Leave empty to fall through to Laptop, then Desktop. |
| **Background Image (Mobile)** | Image | No | Optional. Used below 768px wide. Recommended size: **1024×1820** (portrait — taller than it is wide, since `object-cover` on a wide desktop photo tends to crop the subject out on a narrow phone screen). Leave empty to fall through to Tablet, then Laptop, then Desktop. |
| **Background Overlay Style** | Select (Gradient / Solid Colour / None) | No | What sits over the Background Image. Default: Gradient, matching the original design. |
| **Overlay Color** | Color picker (with opacity) | No | Used when Background Overlay Style is "Solid Colour". |
| **Gradient Start Colour** | Color picker (with opacity) | No | Used when Background Overlay Style is "Gradient" — the end nearest the text. |
| **Gradient End Colour** | Color picker (with opacity) | No | Used when Background Overlay Style is "Gradient" — the end where the photo shows through most. |
| **Gradient Direction** | Select | No | Used when Background Overlay Style is "Gradient" — Left→Right (default, original design), Right→Left, Top→Bottom, Bottom→Top, or one of 2 diagonals. |
| **Eyebrow** | Text | No | Small uppercase label above the heading. |
| **Heading** | Text | No | Main serif headline. |
| **Description** | Textarea | No | Supporting paragraph under the heading. |
| **Primary Button Label / URL** | Text / URL | No | Solid dark button. |
| **Secondary Button Label / URL** | Text / URL | No | Outline button. |
| **Footer Note** | Text | No | Small uppercase line under the buttons, e.g. "African Roots. Radiant Tomorrows." |
| **Side Items** | Repeater (Label) | No | Vertical uppercase label list on the right, desktop only. |

## Notes

- Uses the `cilla-skyn-*` design tokens (`--color-cream`, `--color-cs-ink`, `--color-gold`, `--font-serif`, `--font-sans-cs`) added to `src/input.css`'s `@theme`, kept separate from the site-wide dark/gym tokens so this block always renders its own light cream palette regardless of the surrounding page.
- The 4 background-image breakpoints are **real art direction, not just smaller files of the same photo** — a genuinely different crop/composition per tier (the mobile shot in particular is usually a different, portrait-oriented photo, not the desktop one scaled down). `render.php` renders a `<picture>` element with one `<source media="(max-width: ...)">` per tier that has an image set:

  | Field | Applies at | `media` query |
  |---|---|---|
  | Mobile | up to 767px wide | `(max-width: 767px)` |
  | Tablet | 768px–1279px wide | `(max-width: 1279px)` |
  | Laptop | 1280px–1919px wide | `(max-width: 1919px)` |
  | Desktop | 1920px and up | *(the `<img>` itself — always the fallback)* |

  Sources are listed narrowest-first and the browser uses the first one whose `media` matches, so **leaving a tier empty isn't a gap** — its viewport range just falls through to the next size up automatically (e.g. no Tablet image set → tablet-width screens get the Laptop image; no Laptop either → they get Desktop). You don't have to fill in all 4; Desktop alone reproduces the block's original single-image behaviour exactly.
- No custom Tailwind breakpoints are introduced for layout — the text/button grid still switches at `min-[768px]:`, same as before; only the background-image tiers above use the extra breakpoints.
- **Background Overlay Style replaces what used to be a fixed `bg-gradient-to-r from-cream via-cream/85 to-cream/20` class.** `render.php` builds the overlay `<div>`'s whole `style` attribute from the ACF fields (`background-color: ...` for Solid, `background-image: linear-gradient(...)` for Gradient) instead — picking "None" renders the raw photo with no overlay `<div>` at all. Nothing changes visually if you leave these fields at their defaults; they reproduce the original gradient exactly.
- Unlike the [About Hero](../cilla-skyn-about-hero/README.md) block's Background Overlay Color (which had to be made *always* visible after ACF's conditional logic proved unreliable for a field depending on an *Image* field), the show/hide here is driven by **Background Overlay Style**, a plain Select field — conditional logic keyed off a Select is the well-tested, reliable case (also used by the [Follow Along](../cilla-skyn-follow-along/README.md) block's per-row Product field), so Overlay Color/Gradient Start/Gradient End/Gradient Direction correctly only appear once you've picked the matching style. See the main theme README §16 for the general rule on this.
