# Cilla Skyn Shop by Concern Block

A grid of skin-concern category tiles, reusable anywhere in the block editor. Ported from `NewProject/cilla-skyn-homepage.html`'s "Shop by Concern" section, with each tile backed by a real WooCommerce product instead of a flat colour swatch.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Heading** | Text | No | Section heading. Default: "Shop by Concern". |
| **Subheading** | Textarea | No | Supporting text under the heading. |
| **Concerns** | Repeater | No | One row per tile: **Product**, **Title**, **Subtitle**. |

### Concerns row sub-fields

| Field | Type | Description |
|---|---|---|
| **Product** | Post Object (WooCommerce Product) | The tile shows this product's image and links to its product page. Falls back to WooCommerce's placeholder image if left empty. |
| **Title** | Text | The concern/category label, e.g. "Dryness & Dehydration" — independent of the picked product's own name, so the tile can frame a skin concern rather than a specific SKU. |
| **Subtitle** | Text | Short supporting line, e.g. "Replenish. Restore. Rebalance." |

## Notes

- The tile image and link both come from the selected **Product** — there's no separate URL field. Point a tile at whichever product best represents that concern (or a "starter" product for that category).
- Title/Subtitle stay manual rather than pulling from the product, since a concern tile is meant to frame a skin problem/solution, not display a product name.
- Grid collapses 6 → 3 → 2 columns at the theme's standard breakpoints, no custom breakpoints introduced.
