# Cilla Skyn Hero Block

Full-bleed cream hero banner reusable anywhere in the block editor. Brand-prefixed so it stays distinct from core/other plugin cover blocks in the inserter. Ported from `NewProject/cilla-skyn-homepage.html`'s hero section.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Background Image** | Image | No | Full-bleed background, fades into the cream section colour on the left. Falls back to a placeholder image when empty. |
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
