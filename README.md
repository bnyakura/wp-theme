# Cilla Skyn — WordPress Theme

A custom classic WordPress theme (`custom-theme`) built on **Advanced
Custom Fields (ACF) Pro / Secure Custom Fields (SCF) Gutenberg blocks** and
**Tailwind CSS v4**. Pages are assembled in the Block Editor from the
theme's own blocks — there are no page-builder plugins and no custom post
types driving the front end.

This theme was originally built for a gym brand ("Iron Gorilla Army") and
has since been rebranded and re-blocked for **Cilla Skyn**, a skincare
brand. The current block library (`blocks/cilla-skyn-*`) implements the
Cilla Skyn homepage design (`NewProject/cilla-skyn-homepage.html`). A
substantial amount of code from the earlier gym-site build still exists in
`inc/` and `template-parts/` as **unused legacy content** — see
[§12](#12-theme-structure-inc) for exactly what's still wired up versus
orphaned.

---

## Table of contents

1. [Requirements](#1-requirements)
2. [Installation](#2-installation)
3. [Building the CSS](#3-building-the-css-required)
4. [How the site is built: blocks, not pages](#4-how-the-site-is-built-blocks-not-pages)
5. [Block reference](#5-block-reference)
6. [Field groups (ACF/SCF local JSON)](#6-field-groups-acfscf-local-json)
7. [Theme Options (ACF options pages)](#7-theme-options-acf-options-pages)
8. [Header, footer & navigation](#8-header-footer--navigation)
9. [WooCommerce & forms](#9-woocommerce--forms)
10. [Front-end JavaScript](#10-front-end-javascript)
11. [Theme structure (`inc/`)](#11-theme-structure-inc)
12. [Design tokens](#12-design-tokens)
13. [Known legacy/orphaned code](#13-known-legacyorphaned-code)
14. [Troubleshooting](#14-troubleshooting)
15. [File map](#15-file-map)

---

## 1. Requirements

- WordPress 6.0+
- PHP 7.4+
- **WooCommerce** — the header cart icon and the Best Sellers block both
  depend on it (both degrade gracefully if it's inactive: the cart icon
  hides, the shortcode renders nothing).
- **Advanced Custom Fields Pro** (or the free **Secure Custom Fields**
  plugin) — **required**. The theme calls `wp_die()` on the front end and
  shows an admin notice in wp-admin if it isn't active
  (`inc/acf-requirements.php`).
- Node.js (for building the Tailwind CSS during development — not needed at
  runtime once `assets/css/tailwind.css` is built and committed).

---

## 2. Installation

1. Copy this folder into `wp-content/themes/` and activate **ACF
   Pro/SCF** and **WooCommerce**.
2. In wp-admin: **Appearance → Themes → Activate**.
3. Build the CSS (next section) — the site is unstyled until this has run
   at least once.
4. Go to **Custom Fields → Field Groups** and confirm the 5 groups listed
   under [§6](#6-field-groups-acfscf-local-json) show up (they load
   automatically from `acf-json/`, no manual sync needed on a fresh
   install).
5. Create a homepage and add the 5 `cilla-skyn-*` blocks from
   [§5](#5-block-reference) to it, in order: Hero, Best Sellers, Shop by
   Concern, Feature Strip, Follow Along.
6. **Settings → Reading** → set the homepage to that page.
7. **Appearance → Menus** → assign menus to the **Primary Navigation** and
   **Footer Navigation** locations (registered in `inc/theme-setup.php`).
8. Set the WhatsApp number and Instagram URL under **Appearance → Customize
   → Site Identity** (§8).

Fonts (Bebas Neue + DM Sans for the site chrome, Cormorant Garamond + Jost
for the Cilla Skyn blocks) and Font Awesome are enqueued from CDNs — no
local install needed.

---

## 3. Building the CSS (required)

Tailwind v4 compiles `src/input.css` → `assets/css/tailwind.css`, scanning
all `.php` files in the theme for class names automatically.

```bash
cd wp-content/themes/wp-theme
npm install

# One-off production build:
npm run build

# While developing (rebuilds on save):
npm run dev
```

These map to the scripts in `package.json`:

```json
"dev":   "tailwindcss -i ./src/input.css -o ./assets/css/tailwind.css --watch",
"build": "tailwindcss -i ./src/input.css -o ./assets/css/tailwind.css --minify"
```

**Rebuild after editing any template's Tailwind classes**, any block's
`style.css`, or `src/input.css`. `inc/theme-styles.php` will show an admin
notice if `assets/css/tailwind.css` is missing. Design tokens (brand
colors, fonts) live in the `@theme` block of `src/input.css` — see
[§12](#12-design-tokens).

Each block also ships its own `style.css` (`file:./style.css` in its
`block.json`), auto-enqueued by WordPress only on pages where that block is
used. For the current blocks these files are placeholders (styling is
Tailwind classes in `render.php`), except the Best Sellers block, whose
WooCommerce shortcode-markup overrides live in `src/input.css` (they can't
carry Tailwind classes directly — see that block's own `README.md`).

---

## 4. How the site is built: blocks, not pages

There is **no `front-page.php`** and **no page templates** — every page in
this theme (including the homepage) is just a normal WordPress page whose
content is one or more of this theme's Gutenberg blocks, added and arranged
in the Block Editor like any other block. `index.php` simply calls
`the_content()`.

The current block library is a single set of **homepage section blocks**,
meant to be stacked on one page top-to-bottom to build the Cilla Skyn
homepage: Hero → Best Sellers → Shop by Concern → Feature Strip → Follow
Along.

Every block:

- Auto-registers from its `block.json` — `inc/acf-blocks.php` globs
  `blocks/*/block.json` and calls `register_block_type()` on each; adding a
  new block folder is enough, no extra PHP required.
- Renders via ACF's `renderTemplate` (`render.php` in the block folder),
  reading fields with `get_field()`.
- **Falls back to the Cilla Skyn mockup's copy**
  (`NewProject/cilla-skyn-homepage.html`) for any field left empty — via
  each field's `default_value` in its `acf-json/group_*.json`, and via
  `inc/block-defaults/<slug>.php` for repeater fields (ACF has no
  `default_value` support for repeaters — see `inc/acf-block-defaults.php`
  for how those are stitched together) — so a freshly-added block is never
  blank.
- Has its own `README.md` inside the block folder documenting every field —
  treat those as the field-level reference; this file gives the overview.

---

## 5. Block reference

| Block | Folder | What it renders |
|---|---|---|
| **Hero** | `blocks/cilla-skyn-hero` | Full-bleed cream hero: background image, eyebrow, heading, description, two buttons, vertical side-label list |
| **Best Sellers** | `blocks/cilla-skyn-best-sellers` | WooCommerce product grid, built from the native `[products]` shortcode with editor-configurable heading/visibility/sort/limit/columns |
| **Shop by Concern** | `blocks/cilla-skyn-shop-by-concern` | Grid of skin-concern category tiles (colour swatch, title, subtitle, link) |
| **Feature Strip** | `blocks/cilla-skyn-feature-strip` | Row of icon + text trust badges |
| **Follow Along** | `blocks/cilla-skyn-follow-along` | Instagram-style tile grid mixing colour-block captions and a quote tile |

To edit a block's fields, add it in the Block Editor and open the block
settings panel — every field has a label and description pulled straight
from its ACF field group.

---

## 6. Field groups (ACF/SCF local JSON)

Field definitions live as local JSON under `acf-json/` (one
`group_<block>.json` per block) and are version-controlled with the theme.
`inc/acf-json.php` points ACF's load/save paths at this folder, so:

- Field groups appear automatically in **Custom Fields → Field Groups** —
  **no manual import needed** on a fresh install.
- If you edit a field group in wp-admin, ACF writes the change straight
  back into the matching `acf-json/group_*.json` file — commit that file.
- If you edit the JSON by hand, go to **Custom Fields → Field Groups** and
  click **Sync** on the group to load your changes into the database.

---

## 7. Theme Options (ACF options pages)

`inc/acf-options.php` registers a **Theme Options** menu (top-level, below
Comments) with three empty sub-pages ready for future site-wide fields:

- **General**
- **Header**
- **Footer**

(No fields are attached to these pages yet — add field groups located to
`options` in ACF and they'll appear here.)

Site-wide settings that already exist live in the **Customizer** instead
(§8): logo, Instagram URL, WhatsApp number, footer tagline.

---

## 8. Header, footer & navigation

`header.php` and `footer.php` are hand-built (not block-based) and shared
by every page. Both were redesigned to match the Cilla Skyn homepage design
(`NewProject/Cilla Skyn Website Layout.docx` / `cilla-skyn-homepage.html`)
— cream background, serif wordmark, the same `cilla-skyn-*` design tokens
(§12) as the blocks. Unlike the old dark chrome, the header is a normal
static-flow element (not `fixed`), so it no longer overlaps page content —
see the note on WooCommerce template padding in §13 if you're wondering why
`page-cart.php`/`page-checkout.php`/`single-product.php` use `pt-16`
instead of the old `pt-32`.

**Header** (`header.php`):

- A thin announcement bar (`cilla_skyn_announcement` theme mod, editable
  only via `set_theme_mod()`/a future Customizer control — no UI for it
  yet) above a cream header bar with the logo + wordmark, centred primary
  nav (`primary_navigation` menu location), and search / account / cart
  icons.
- **Search** is a no-JS `<details>` dropdown that submits to WordPress's
  normal search (`?s=`).
- **Account** links to the WooCommerce My Account page if WooCommerce is
  active, otherwise `wp_login_url()`.
- **Cart** links to `wc_get_cart_url()` with a live item-count badge;
  hidden entirely if WooCommerce is inactive.
- Below `lg:`, a hamburger button opens a slide-in cream drawer with the
  same nav menu. Mobile open/close is handled by `assets/js/header.js`
  (same `#mobile-menu-btn` / `#mobile-overlay` / `#mobile-drawer` /
  `#mobile-close-btn` IDs as before — the script no longer needs a
  scroll-triggered background swap, since the header isn't `fixed`
  anymore).
- The old **Book Free Assessment** button, WhatsApp icon, and the broken
  **View Memberships** button (§13 in the previous revision of this file)
  were all removed — none of them appear in the Cilla Skyn design, and the
  last one referenced a modal from the now-deleted `pricing` block.

**Footer** (`footer.php`) — 5 columns matching the design:

| Column | Where to edit |
|---|---|
| **Brand** | Wordmark (site title), tagline (`cilla_skyn_tagline` theme mod), description (`iga_footer_tagline` theme mod), social links (Instagram from `iga_instagram_url`; Facebook/TikTok/Pinterest/YouTube are static `#` placeholders — no theme mods yet) |
| **Shop** | **Appearance → Menus** → assign a menu to **Footer Navigation**. Until one is assigned, a fallback (`iga_footer_nav_fallback()` in `inc/theme-setup.php`) renders: All Products (links to the real Shop page), Best Sellers, The Baby Collection, Bundles & Sets, Gift Cards (the last four are `#` placeholders) |
| **Help** | Static links in `footer.php` (`#` placeholders except **Contact Us**, which points at `/contact/`) — edit directly, or wire up real pages |
| **About** | Static `#` placeholder links in `footer.php` — edit directly |
| **Newsletter** | Static form, no ESP wired up (`onsubmit="return false"` like the design mockup) — connect it to Mailchimp/Klaviyo/etc. before relying on it |
| Legal links | `/terms/`, `/privacy/`, `/cookies/` — create those pages |
| Copyright | Automatic (`date_i18n( 'Y' )` + site title) |

Both navigation menu locations (`primary_navigation`, `footer`) are
registered in `inc/theme-setup.php`. The `cilla_skyn_whatsapp` /
`cilla_skyn_whatsapp_group` Customizer settings still exist
(`inc/theme-setup.php`) but nothing in the header/footer surfaces them
anymore — the WhatsApp UI didn't fit the Cilla Skyn design and was removed.

---

## 9. WooCommerce & forms

- **Cart icon** (`header.php`) links to `wc_get_cart_url()` and shows the
  live cart count when WooCommerce is active.
- **Best Sellers block** (§5) builds a `[products]` shortcode from its
  fields and renders it with `do_shortcode()` — WooCommerce owns the
  product query and card markup; `src/input.css` restyles WooCommerce's
  own hooks/classes to match the Cilla Skyn palette (scoped under
  `.wp-theme-cilla-skyn-best-sellers`, so it doesn't leak into the
  shop/cart/checkout pages).
- `inc/theme-setup.php`'s `iga_prevent_duplicate_shop_products()` removes
  WooCommerce's auto-appended shop grid when the Shop page's content
  already contains the Best Sellers block (this theme has no
  `add_theme_support('woocommerce')`, so WooCommerce would otherwise render
  its own grid a second time on that page).
- `inc/page-forms.php` still contains booking and contact form POST
  handlers (`template_redirect`-hooked, `wp_mail()`-based, no-JS-required)
  from the earlier gym-site build. **They currently have no block or
  template that renders their `<form>` markup** — the Book/Contact/Homepage
  Contact blocks that used them were removed. See
  [§13](#13-known-legacyorphaned-code).

---

## 10. Front-end JavaScript

Enqueued in `inc/theme-js.php` (and mirrored into the block editor canvas
by `inc/theme-styles.php` so previews match the live site):

| Script | Purpose | Status |
|---|---|---|
| `assets/js/header.js` | Mobile menu open/close | Active |
| `assets/js/modal.js` | Generic modal open/close, backdrop, Escape, scroll-lock | Enqueued, but no modal markup currently exists on the front end — see §13 |
| `assets/js/hero-slider.js` | Autoplay slide carousel behaviour | Enqueued, but the `hero` block that used it was removed — see §13 |
| `assets/js/reveal.js` | Scroll-triggered reveal animations (`.reveal`/`.active`) | Enqueued; harmless if unused (no-ops without `.reveal` elements) |
| `assets/js/pricing-tabs.js` | Monthly / Drop-In tab toggle | Enqueued, but the `pricing` block that used it was removed — see §13 |

---

## 11. Theme structure (`inc/`)

`functions.php` requires files in this order:

| File | Responsibility |
|---|---|
| `inc/acf-requirements.php` | Blocks the site / warns in wp-admin if ACF isn't active |
| `inc/theme-setup.php` | `add_theme_support`, nav menu registration, SVG uploads, Customizer settings (WhatsApp, Instagram, footer tagline), footer nav fallback, WooCommerce shop-page duplicate-grid guard. Also `require`s the legacy CPT files below |
| `inc/theme-styles.php` | Enqueues compiled Tailwind CSS, Cilla Skyn Google Fonts, Font Awesome, editor-canvas styles; dequeues a conflicting WooCommerce Pre-Orders stylesheet outside WooCommerce pages |
| `inc/theme-js.php` | Enqueues all front-end scripts (§10) + Bebas Neue/DM Sans Google Fonts |
| `inc/acf-blocks.php` | Auto-registers every `blocks/*/block.json` |
| `inc/acf-json.php` | Points ACF's local-JSON load/save path at `acf-json/` |
| `inc/acf-options.php` | Registers the Theme Options menu + General/Header/Footer sub-pages |
| `inc/page-forms.php` | Booking + contact form handlers (§9) — currently orphaned, see §13 |
| `inc/acf-block-defaults.php` | Pre-fills block editor forms with each block's shipped fallback content (§4) |
| `inc/single-product.php` | WooCommerce single-product related-products renderer + tab fixes |

`inc/hero-slides.php`, `distinction-cards.php`, `mission.php`,
`forge-pillars.php`, `pricing-tiers.php`, `testimonials.php`, and
`contact-section.php` are `require`d by `inc/theme-setup.php` but register
**unused custom post types** from an even earlier custom-post-type
architecture — nothing on the front end renders their post types. See
[§13](#13-known-legacyorphaned-code).

---

## 12. Design tokens

Defined in the `@theme` block of `src/input.css`. There are two token sets,
used by different parts of the theme:

**Cilla Skyn** (header, footer, and all current blocks — also the `body`
default in `@layer base`, so it's what a fresh page renders in by default):

| Token | Value | Use |
|---|---|---|
| `--color-cream` / `cream-dark` | `#F4ECE0` / `#ECE0CD` | Section backgrounds |
| `--color-cs-ink` | `#1B1712` | Text on cream |
| `--color-gold` / `gold-light` | `#B08D57` / `#D8BE93` | Accents |
| `--font-serif` | Cormorant Garamond | Headings |
| `--font-sans-cs` | Jost | Body |

**Dark gym-era palette** (only used now by WooCommerce's own
shop/cart/checkout/single-product templates, which opt back into it
explicitly — see §13):

| Token | Value | Use |
|---|---|---|
| `--color-ink` | `#0A0A0A` | Page background |
| `--color-s1` / `s2` / `s3` | `#141414` / `#1C1C1C` / `#242424` | Surface layers |
| `--color-green` / `green-l` / `green-d` | `#3A7D44` / `#4E9E5A` / `#2A5C32` | Brand green + hover/dark variants |
| `--color-amber` | `#C47B2B` | Accent |
| `--color-off` | `#F2F2F2` | Body text |
| `--color-muted` / `muted-l` | `#888888` / `#AAAAAA` | Secondary text |
| `--color-line` / `line-strong` | `rgba(255,255,255,.07/.14)` | Hairline borders |
| `--font-sans` | DM Sans | Body |
| `--font-display` | Bebas Neue | Headings |

The `@layer base` block restores the page background and base typography
that Tailwind's preflight doesn't set — without a CSS build, the site
renders on a plain white page.

---

## 13. Known legacy/orphaned code

The block library was cut down from ~35 blocks (an earlier gym-site build)
to the 5 current Cilla Skyn blocks. The following was intentionally left in
place rather than deleted, since removing it touches functionality beyond
the block library itself — flagging it here so it isn't mistaken for
currently-wired functionality:

- **`inc/page-forms.php`** — booking/contact form POST handlers with no
  block or template left that renders the `<form>` markup they process.
- **`inc/hero-slides.php`, `distinction-cards.php`, `mission.php`,
  `forge-pillars.php`, `pricing-tiers.php`, `testimonials.php`,
  `contact-section.php`** — register unused custom post types from a
  pre-block architecture; still `require`d by `inc/theme-setup.php`.
- **`template-parts/*.php`** (`hero.php`, `Mission.php`, `Testimonials.php`,
  `Distinction.php`, `Pricing.php`, `pricing-card.php`, `Contact.php`,
  `Forge.php`, `statsBar.php`) — markup for the same removed blocks;
  nothing calls `get_template_part()` for these anymore.
- **`assets/js/modal.js`, `hero-slider.js`, `pricing-tabs.js`** — still
  enqueued site-wide by `inc/theme-js.php`, but no markup on the front end
  triggers them anymore (harmless no-ops, just dead weight).
- **WooCommerce templates keep the old dark theme on purpose** —
  `page-cart.php`, `page-checkout.php`, `single-product.php`, and
  index.php's WooCommerce product-title branch all wrap themselves in their
  own `bg-ink` section rather than adopting the Cilla Skyn cream palette;
  restyling the shop/cart/checkout/product experience wasn't part of the
  header/footer redesign. Their top padding was changed from `pt-32` to
  `pt-16` when the header stopped being `fixed` (§8) — the old value
  compensated for the header being removed from document flow, which no
  longer applies.
- **`cilla_skyn_whatsapp` / `cilla_skyn_whatsapp_group` Customizer
  settings** (`inc/theme-setup.php`) — still registered, but nothing in
  the header or footer surfaces them since the WhatsApp UI was removed
  (§8). Harmless if left as-is; remove the `add_setting`/`add_control`
  calls if you want them gone from the Customizer entirely.

None of this causes PHP errors or blocks the site from working — it's
inert weight left over from the block-library cleanup and the header/footer
redesign. Removing it fully would mean also touching `functions.php`,
`inc/theme-setup.php`, and `inc/theme-js.php`, which goes beyond either of
those two tasks and wasn't done here.

---

## 14. Troubleshooting

| Symptom | Fix |
|---|---|
| Whole page renders **white/unstyled** | Build the CSS (§3) and hard-refresh. `inc/theme-styles.php` shows an admin notice when `assets/css/tailwind.css` is missing |
| A block's Tailwind classes changed but nothing shows | Rebuild the CSS — class names are compiled from the PHP source into `tailwind.css` |
| Front end shows "Missing Required Plugin" | ACF Pro / SCF isn't active — install and activate it (§1) |
| A block renders its **fallback/demo content** instead of your edits | You haven't filled in that block's fields yet, or a required field (e.g. an image) is empty — check the block's own `README.md` for which fields are required |
| Field group changes don't appear on the front end | Click **Sync** on the field group under **Custom Fields → Field Groups** |
| Best Sellers block shows no products | WooCommerce isn't active, or no products match the block's Visibility/Sort settings |
| Products render twice on the Shop page | Make sure only one Best Sellers block is on that page — `iga_prevent_duplicate_shop_products()` only guards against WooCommerce's own auto-appended grid, not duplicate blocks |
| WhatsApp icon missing | Set **WhatsApp Number** under Customize → Site Identity |
| Footer nav shows links to pages that don't exist | No menu assigned to the **Footer Navigation** location yet — assign one, or edit the fallback in `iga_footer_nav_fallback()` (§8) |
| Clicking "View Memberships" in the mobile menu does nothing / console error | Known issue — see [§13](#13-known-legacyorphaned-code) |
| A WooCommerce-looking `.hidden` utility fights with the header nav on non-WooCommerce pages | Already handled — `cilla_skyn_dequeue_preorders_sitewide_assets()` in `inc/theme-styles.php` dequeues the offending plugin CSS outside WooCommerce pages |

---

## 15. File map

```
wp-theme/
├── style.css                      # Theme header only (all styles are compiled Tailwind)
├── index.php                      # Generic fallback template — the_content() renders the blocks
├── 404.php                        # 404 template
├── header.php / footer.php        # Shared cream chrome: nav, search/account/cart, footer columns (§8)
├── functions.php                  # Requires everything under inc/
├── package.json                   # Tailwind build scripts (npm run dev / build)
├── src/
│   └── input.css                  # Tailwind source: @theme design tokens (§12) + @layer base
├── inc/                           # See §11 for what each file does
│   ├── acf-requirements.php
│   ├── theme-setup.php
│   ├── theme-styles.php
│   ├── theme-js.php
│   ├── acf-blocks.php
│   ├── acf-json.php
│   ├── acf-options.php
│   ├── page-forms.php             # Orphaned — see §13
│   ├── acf-block-defaults.php
│   ├── single-product.php
│   ├── block-defaults/            # Repeater-field defaults, one file per block with a repeater
│   └── (legacy CPT files — see §13)
├── acf-json/                      # group_<block>.json field-group definitions, one per block
├── blocks/                        # One folder per Gutenberg block — see §5
│   └── cilla-skyn-<name>/
│       ├── block.json             # Registration + acf.renderTemplate
│       ├── render.php             # get_field() + markup, with fallback content
│       ├── style.css              # Block-scoped styles, auto-enqueued when the block is used
│       └── README.md              # Field-by-field reference for that block
├── template-parts/                # Orphaned legacy markup — see §13
├── NewProject/                    # Cilla Skyn homepage design reference (static HTML mockup)
└── assets/
    ├── css/tailwind.css           # COMPILED output (do not edit by hand)
    ├── images/                    # Bundled fallback/demo images
    └── js/                        # header.js (active), modal.js/hero-slider.js/pricing-tabs.js (orphaned), reveal.js — §10
```

**Handing over to the client:** give them this README plus, for any block
they're actively editing, that block's own `README.md` for the field-level
detail. Empty fields fall back to the Cilla Skyn mockup content, so nothing
a client does in the Block Editor can leave a page blank.
