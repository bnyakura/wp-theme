# Cilla Skyn Products Block

The Shop page's own WooCommerce product grid (bordered cards, result count, sort dropdown, pagination), reusable anywhere in the block editor, with one addition: a Categories field to filter which products show. Leave Categories empty and the block is visually and functionally identical to `/shop`. The editor configures content and query settings; the block builds a native WooCommerce `[products]` shortcode from those values (with `paginate="true"`, so WooCommerce fires the same hooks the real shop archive fires) and renders it with `do_shortcode()` — WooCommerce still owns the product query and card markup.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Heading** | Text | No | Displayed above the grid. Leave empty to match the Shop page, which has no on-page heading. |
| **Subheading** | Textarea | No | Displayed underneath the heading. |
| **Categories** | Taxonomy (checkbox) | No | One or more WooCommerce product categories. Leave empty to show every visible product, same as `/shop`. |
| **Sort** | Select | No | Editor-friendly sort label, mapped in `render.php` to a valid `orderby`/`order` pair. Default: `Default` → `menu_order`/`ASC`. Visitors can still change this from the on-page sort dropdown, same as `/shop`. |
| **Products Per Page** | Number | No | Maps to `limit`. Clamped 1–48. Default: `12`. |

## Styling

This block reuses the Shop page's exact bordered-card grid styling — same 4:5→square image treatment, pill "Add to cart" button, result count, sort dropdown, and pagination controls — instead of the plain borderless-card treatment used by the Best Sellers block. Those overrides live in `src/input.css`, scoped under `.wp-theme-cilla-skyn-products`, and are a direct copy of the `.wp-theme-shop-page .woocommerce` ruleset so the two surfaces stay visually identical. Grid columns are fixed at the same 2/3/4 responsive breakpoints as the Shop page rather than being editor-configurable, since matching `/shop` (not arbitrary column counts) is the point of this block.
