# IronGorilla Featured Products Block

White-section WooCommerce product grid, reusable anywhere in the block editor. Brand-prefixed so it stays distinct from WooCommerce's own core blocks in the inserter. The editor configures content and query settings; the block builds a native WooCommerce `[products]` shortcode from those values and renders it with `do_shortcode()` — WooCommerce still owns the product query and card markup.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Heading** | Text | No | Displayed above the grid. |
| **Subheading** | Textarea | No | Displayed underneath the heading. |
| **Visibility** | Select | No | Which products are eligible (`visible`, `catalog`, `search`, `hidden`, `featured`). Maps to the shortcode's `visibility` attribute. Default: `visible`. |
| **Sort** | Select | No | Editor-friendly sort label, mapped in `render.php` to a valid `orderby`/`order` pair. Default: `Default` → `menu_order`/`ASC`. |
| **Number of Products** | Number | No | Maps to `limit`. Clamped 1–24. Default: `8`. |
| **Columns** | Select | No | Desktop grid columns, maps to `columns`. WooCommerce's own responsive CSS collapses this to 2 columns under 768px. Default: `4`. |

## Sort → orderby/order mapping

| Sort option | orderby | order |
|---|---|---|
| Default | `menu_order` | `ASC` |
| Newest | `date` | `DESC` |
| Oldest | `date` | `ASC` |
| Price: Low to High | `price` | `ASC` |
| Price: High to Low | `price` | `DESC` |
| Popularity | `popularity` | `DESC` |
| Average Rating | `rating` | `DESC` |
| Product Title (A–Z) | `title` | `ASC` |
| Product Title (Z–A) | `title` | `DESC` |

## Example generated shortcode (default field values)

```
[products limit="8" columns="4" visibility="visible" orderby="menu_order" order="ASC"]
```

## Styling

This block always renders on a white background regardless of the surrounding dark theme. The heading/subheading reuse the site's existing `font-display` heading treatment and container width (`max-w-[1280px]`, same as the Armory Products block), recoloured for a light section (`text-ink` / `text-ink/65`).

The product cards match Armory Products' visual language — rounded bordered card, full-bleed square image that scales on hover, uppercase display-font title, pill sale badge, pill add-to-cart button — but since this block renders through WooCommerce's `[products]` shortcode rather than hand-built card markup, that look is reproduced by restyling WooCommerce's own hooks/classes (`.woocommerce-loop-product__title`, `span.onsale`, `a.button`, etc.) instead of duplicating markup. Those overrides are scoped under `.wp-theme-irongorilla-featured-products` in `src/input.css`. Grid layout and responsive column collapsing are left to WooCommerce's own stylesheet — no custom breakpoints are introduced.
