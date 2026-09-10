# Cilla Skyn Hero Block

Full-bleed cream hero banner reusable anywhere in the block editor. Brand-prefixed so it stays distinct from core/other plugin cover blocks in the inserter. Ported from `NewProject/cilla-skyn-homepage.html`'s hero section.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Background Image** | Image | No | Full-bleed background. Falls back to a placeholder image when empty. |
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
- No custom breakpoints are introduced — sizing uses the same Tailwind utilities as the rest of the theme.
- **Background Overlay Style replaces what used to be a fixed `bg-gradient-to-r from-cream via-cream/85 to-cream/20` class.** `render.php` builds the overlay `<div>`'s whole `style` attribute from the ACF fields (`background-color: ...` for Solid, `background-image: linear-gradient(...)` for Gradient) instead — picking "None" renders the raw photo with no overlay `<div>` at all. Nothing changes visually if you leave these fields at their defaults; they reproduce the original gradient exactly.
- Unlike the [About Hero](../cilla-skyn-about-hero/README.md) block's Background Overlay Color (which had to be made *always* visible after ACF's conditional logic proved unreliable for a field depending on an *Image* field), the show/hide here is driven by **Background Overlay Style**, a plain Select field — conditional logic keyed off a Select is the well-tested, reliable case (also used by the [Follow Along](../cilla-skyn-follow-along/README.md) block's per-row Product field), so Overlay Color/Gradient Start/Gradient End/Gradient Direction correctly only appear once you've picked the matching style. See the main theme README §16 for the general rule on this.
