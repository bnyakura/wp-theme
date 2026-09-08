# Cilla Skyn Best Sellers Block

Cream-section WooCommerce product grid, reusable anywhere in the block editor. Replaces the removed IronGorilla Featured Products block with the same `[products]`-shortcode approach, restyled to the Cilla Skyn cream/gold palette. The editor configures content and query settings; the block builds a native WooCommerce `[products]` shortcode from those values and renders it with `do_shortcode()` — WooCommerce still owns the product query and card markup.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Heading** | Text | No | Displayed above the grid, e.g. "Best Sellers". |
| **Subheading** | Textarea | No | Displayed underneath the heading. |
| **View All Label** | Text | No | Label for the top-right link. Default: "View All Products". |
| **View All URL** | URL | No | Optional. Falls back to the WooCommerce Shop page. |
| **Visibility** | Select | No | Which products are eligible (`visible`, `catalog`, `search`, `hidden`, `featured`). Maps to the shortcode's `visibility` attribute. Default: `visible`. |
| **Sort** | Select | No | Editor-friendly sort label, mapped in `render.php` to a valid `orderby`/`order` pair. Default: `Default` → `menu_order`/`ASC`. |
| **Number of Products** | Number | No | Maps to `limit`. Clamped 1–24. Default: `8`. |
| **Columns** | Select | No | Desktop grid columns, maps to `columns`. WooCommerce's own responsive CSS collapses this to 2 columns under 768px. Default: `4`. |

## Styling

This block always renders on the theme's cream section background regardless of the surrounding page. The heading/subheading use the `font-serif` (Cormorant Garamond) treatment shared by the other Cilla Skyn blocks. Product cards reproduce the mockup's bordered, uppercase-free look by restyling WooCommerce's own hooks/classes (`.woocommerce-loop-product__title`, `span.onsale`, `a.button`, etc.) instead of duplicating markup — those overrides are scoped under `.wp-theme-cilla-skyn-best-sellers` in `src/input.css`. Grid layout and responsive column collapsing are left to WooCommerce's own stylesheet.
