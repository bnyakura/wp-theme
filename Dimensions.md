# Image Dimensions Reference

Every place in the theme where an image can be uploaded, what size it actually renders at (from the block's CSS), and the recommended upload dimensions (sized for retina/2x screens, since every image here is displayed via CSS `object-fit`, not printed at its native size). Organised by where you'd find each field in the block editor.

Flagged with ⚠️ are real, currently-live images in this install that are undersized or missing — worth fixing regardless of any other changes.

---

## Site-wide

| Location | Renders at | Recommended upload | Notes |
|---|---|---|---|
| **Header logo** (Customize → Site Identity → Logo) | `height: 40px`, width auto | **~240×110px**, transparent PNG or SVG | ⚠️ Current logo is a 100×46px WhatsApp-compressed JPEG — well below the ~80px-tall source needed for a sharp 40px display on retina screens. Re-upload from an original/vector source if one exists. |
| **Footer logo** (same Customize field, reused) | `height: 45px`, width auto | Same file as header logo | Both use the one Customize → Logo field. |
| **Site icon / favicon** (Customize → Site Identity → Site Icon) | Browser tab / bookmark | **512×512px**, square, transparent PNG | ⚠️ Not set at all currently (`site_icon` option is empty) — the site has no favicon. |

---

## Homepage blocks

### Cilla Skyn Hero
Full-bleed background, 4 responsive tiers via `<picture>`. **These dimensions are already documented directly in the block editor's field labels** — shown here for reference:

| Field | Shown at | Recommended upload |
|---|---|---|
| Background Image (Desktop) | ≥1920px viewport | **2560×1024px** |
| Background Image (Laptop) | 1280–1919px | **1920×768px** |
| Background Image (Tablet) | 768–1279px | **1536×1024px** |
| Background Image (Mobile) | <768px | **1024×1820px** (tall — the mobile hero section is ~1320px min-height, portrait-oriented) |

All four are optional except Desktop (falls back to a bundled theme image if empty). Each is a genuinely different crop, not just a smaller export of the same file — a portrait-friendly mobile shot, not the desktop landscape shrunk down.

### Cilla Skyn Best Sellers
Pulls product photos automatically via the `[products]` shortcode — no manual image field. See **WooCommerce product images** below for the dimensions that actually matter here.

### Cilla Skyn Cards (concern/category tiles)
Grid tiles, `aspect-square`, 2 cols mobile → 3 cols tablet → 6 cols desktop.

| Field | Renders at (desktop, 6-col, 1400px container) | Recommended upload |
|---|---|---|
| Concerns → Image (used only when Product isn't set) | ~210×210px | **800×800px**, square |

### Cilla Skyn Feature Strip
Icon-based (predefined icon names, not image uploads) — nothing to size here.

### Cilla Skyn Follow Along
Tiles pull product photos from the selected WooCommerce Product automatically (`aspect-square`, 2 cols mobile → 6 cols desktop) — no manual image upload. Same guidance as **WooCommerce product images** below. Quote tiles use a flat colour swatch, no image.

---

## About page blocks

### Cilla Skyn Banner
Full-bleed background image behind centred text, height is **content-driven** (no fixed min-height, unlike Hero) — typically renders around 500–700px tall depending on how much text is in Eyebrow/Heading/Intro/Description/Tagline. 3 responsive tiers.

| Field | Shown at | Recommended upload |
|---|---|---|
| Background Image (Desktop) | ≥1280px viewport | **2400×1000px** |
| Background Image (Tablet) | 768–1279px | **1600×1000px** |
| Background Image (Mobile) | <768px | **1000×1200px** (portrait — mobile banners read taller relative to width) |

⚠️ The About page's current Banner image (`masks-treatments.jpg`) is only **1200×901px** — a repurposed product photo, not a proper banner shot. At full-bleed widths above ~1200px it's being upscaled past its native resolution, which will look soft on anything wider than a small laptop. Worth replacing with an actual lifestyle/brand photo at the size above.

Also has an **Image Fit** (cover/contain/fill/none/scale-down) and a **Focal Point** picker (drag the crosshair on the image preview) — use Focal Point to keep the subject centred if the photo gets cropped tighter than expected on some screens.

### Cilla Skyn About Hero
Single background image (no responsive tiers — one file covers every breakpoint via `object-cover`), section height is also content-driven, similar range to Banner.

| Field | Recommended upload |
|---|---|
| Background Image | **1920×1080px** (16:9) — crops reasonably at both very wide desktop and narrow mobile since there's only one file for every screen size |

Leave empty for a plain cream panel — this field is optional by design.

### Cilla Skyn General Information
Rich-text (WYSIWYG) field — images are inserted inline via "Add Media" inside the editor, not a dedicated image field. The content column is capped at **672px wide** (`max-w-2xl`) and images scale to fit via `max-width: 100%`.

| Use case | Recommended upload |
|---|---|
| Inline image inside the story text | **1344×900px** or similar (2x the 672px column width, any reasonable aspect ratio) |

### Cilla Skyn Formulation Approach
Text/repeater only — no image fields.

### Cilla Skyn Products
Pulls WooCommerce product photos automatically (same grid as the Shop page) — no manual image field. See **WooCommerce product images** below.

---

## Other page blocks

### Cilla Skyn Editorial Grid (The Edit page)
Article tiles, `aspect-[4/3]`, 1 col mobile → 2 cols tablet → 3 cols desktop.

| Field | Renders at (desktop, 3-col, 1400px container) | Recommended upload |
|---|---|---|
| Articles → Image | ~440×330px | **1200×900px** (4:3) |

### Cilla Skyn Ingredients (Our Ingredients page)
Ingredient cards, `aspect-square`, 1 col mobile → 2 cols tablet → 3 cols desktop.

| Field | Renders at (desktop, 3-col) | Recommended upload |
|---|---|---|
| Ingredients → Image | ~440×440px | **1000×1000px**, square |

### Cilla Skyn Press (Press page)
Publication logos, fixed height only.

| Field | Renders at | Recommended upload |
|---|---|---|
| Logos → Logo | `height: 32px` mobile / `40px` desktop, width auto | **~300px tall**, transparent PNG/SVG, any width — upload at whatever width keeps the logo's real proportions |

---

## WooCommerce product images

Every product photo across the site (Shop page, Best Sellers, Cards, Follow Along, Products block, single product gallery) — all rendered **square (1:1)** via this theme's CSS, regardless of WooCommerce's own admin settings.

| Context | Current WooCommerce setting | Renders at | Recommended upload |
|---|---|---|---|
| Shop grid / product cards (Shop page, Best Sellers, Products block) | `woocommerce_thumbnail_image_width` = 300px, hard-cropped square | ~250–330px per card depending on grid columns | **1000×1000px**, square |
| Single product main gallery image | `woocommerce_single_image_width` = 600px | Up to ~600px, square (`aspect-ratio: 1/1` in CSS) | **1200×1200px**, square |

Product photos should be shot or cropped square (1:1) at the source — WooCommerce's hard-crop setting (`thumbnail_crop` is on) will center-crop anything else, which can cut off product labels on tall/narrow bottle shots.

---

## Quick reference — recommended upload sizes

| Use | Dimensions |
|---|---|
| Header/footer logo | 240×110px transparent PNG/SVG |
| Favicon | 512×512px square |
| Hero background (desktop/laptop/tablet/mobile) | 2560×1024 / 1920×768 / 1536×1024 / 1024×1820 |
| Banner background (desktop/tablet/mobile) | 2400×1000 / 1600×1000 / 1000×1200 |
| About Hero background | 1920×1080 |
| Concern/category card (Cards block) | 800×800 |
| Editorial Grid article tile | 1200×900 |
| Ingredient card | 1000×1000 |
| Press logo | ~300px tall, transparent |
| Product photos (grid + gallery) | 1000×1000 (grid) / 1200×1200 (single product) |
| Inline WYSIWYG image | 1344×900 (or any 2x-column-width equivalent) |
