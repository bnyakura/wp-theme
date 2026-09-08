# Cilla Skyn Shop by Concern Block

A grid of skin-concern category tiles, reusable anywhere in the block editor. Ported from `NewProject/cilla-skyn-homepage.html`'s "Shop by Concern" section.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Heading** | Text | No | Section heading. Default: "Shop by Concern". |
| **Subheading** | Textarea | No | Supporting text under the heading. |
| **Concerns** | Repeater | No | One row per tile: **Swatch Color** (hex, e.g. `#E4CDBB`), **Title**, **Subtitle**, **URL**. |

## Notes

- Tiles use a flat colour swatch (no imagery), matching the mockup exactly — set `swatch_color` to a hex value.
- Grid collapses 6 → 3 → 2 columns at the theme's standard breakpoints, no custom breakpoints introduced.
