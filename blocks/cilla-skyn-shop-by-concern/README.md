# Cilla Skyn Shop by Concern Block

A grid of skin-concern category tiles, reusable anywhere in the block editor. Ported from `NewProject/cilla-skyn-homepage.html`'s "Shop by Concern" section. Each tile can be backed by a real WooCommerce product, or by a manually uploaded image + link for a concern that isn't represented by a single product yet.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Heading** | Text | No | Section heading. Default: "Shop by Concern". |
| **Subheading** | Textarea | No | Supporting text under the heading. |
| **Concerns** | Repeater | No | One row per tile: **Product**, **Image**, **Link URL**, **Title**, **Subtitle**. |

### Concerns row sub-fields

| Field | Type | Description |
|---|---|---|
| **Product** | Post Object (WooCommerce Product) | The tile shows this product's image and links to its product page. **Takes priority over Image/Link URL below when set.** Leave empty to use a manually uploaded image instead. |
| **Image** | Image | Used only when **Product** is left empty. Falls back to WooCommerce's placeholder image if both are empty. |
| **Link URL** | URL | Used only when **Product** is left empty — a Product tile always links to that product's page instead. Leave empty for a non-clickable tile. |
| **Title** | Text | The concern/category label, e.g. "Dryness & Dehydration" — independent of the picked product's own name, so the tile can frame a skin concern rather than a specific SKU. |
| **Subtitle** | Text | Short supporting line, e.g. "Replenish. Restore. Rebalance." |

## Notes

- **Product vs. Image/Link URL is a "pick one" choice per row, not both at once.** If a Product is selected, its image and permalink always win — Image and Link URL are simply ignored for that row. Clear the Product field to switch a tile to a manual image, e.g. for a concern that doesn't map to one specific SKU yet, or a category landing page instead of a product page.
- **Image/Link URL fields are always visible in the block editor, not conditionally hidden behind Product being empty.** An earlier attempt at conditionally hiding a color field based on another field's emptiness (on the About Hero block) turned out to be unreliable inside ACF Blocks — see the main theme README §16 — so this block avoids that pattern entirely and just documents the "Product wins" behaviour in each field's instructions instead.
- Title/Subtitle stay manual rather than pulling from the product, since a concern tile is meant to frame a skin problem/solution, not display a product name.
- Grid collapses 6 → 3 → 2 columns at the theme's standard breakpoints, no custom breakpoints introduced.
- The 6 default titles (`inc/block-defaults/cilla-skyn-shop-by-concern.php`) — Oily & Acne Prone, Sensitive & Eczema Prone, Dry & Dehydrated, Uneven Tone & Dark Marks, Texture & Ageing, Firmness & Body Texture — match the client's own "Recommended website 'Shop by Concern'" list in `NewProject/Cilla Skyn Website Layout.docx`. That same document has a per-category product table (which SKU addresses which concern) — see the main theme README §16 for where that's documented.
