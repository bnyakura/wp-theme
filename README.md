# Cilla Skyn — WordPress Theme

A custom classic WordPress theme (`custom-theme`) built on **Advanced
Custom Fields (ACF) Pro / Secure Custom Fields (SCF) Gutenberg blocks** and
**Tailwind CSS v4**. Pages are assembled in the Block Editor from the
theme's own blocks — there are no page-builder plugins and no custom post
types driving the front end.

This theme was originally built for a gym brand ("Iron Gorilla Army") and
has since been rebranded and re-blocked for **Cilla Skyn**, a skincare
brand. The block library (`blocks/cilla-skyn-*`) implements both the
Cilla Skyn homepage design (`NewProject/cilla-skyn-homepage.html`) and the
About page copy from `NewProject/Cilla Skyn Website Layout.docx` (there's
no static mockup for the About page — only the docx). A substantial amount
of code from the earlier gym-site build still exists in `inc/` and
`template-parts/` as **unused legacy content** — see
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
16. [Adding a block section: full walkthrough](#16-adding-a-block-section-full-walkthrough)
17. [Content & product catalog reference (source docx)](#17-content--product-catalog-reference-source-docx)

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
4. Go to **Custom Fields → Field Groups** and confirm the 18 groups listed
   under [§6](#6-field-groups-acfscf-local-json) show up (they load
   automatically from `acf-json/`, no manual sync needed on a fresh
   install).
5. Create a homepage and add the 5 homepage `cilla-skyn-*` blocks from
   [§5](#5-block-reference) to it, in order: Hero, Best Sellers, Shop by
   Concern, Feature Strip, Follow Along.
6. Create an About page and add the 3 About-page `cilla-skyn-*` blocks
   from [§5](#5-block-reference) to it, in order: About Hero, Our Story,
   Formulation Approach. Add a Contact Info block to that page (or a
   separate Contact page) too. See [§16](#16-adding-a-block-section-full-walkthrough)
   for the full add-a-block walkthrough if you're adding any block for the
   first time.
7. **Settings → Reading** → set the homepage to the homepage you built in
   step 5.
8. **Appearance → Menus** → assign a menu to the **Primary Navigation**
   location (registered in `inc/theme-setup.php`). See
   [§17](#17-content--product-catalog-reference-source-docx) for the
   client's intended nav structure (Shop All / Face Care / Body Care / Hero
   Ingredients / About Us). The footer has no menu location of its own —
   see step 10.
9. Set the WhatsApp number under **Appearance → Customize → Site
   Identity** (§8).
10. **Theme Options → Footer** → fill in the Shop Links, Social Links,
    Help Links, About Links, Legal Links and newsletter copy (§7/§8) — the
    footer renders its original design content until this is saved once.

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

The block library is two stacks of **page section blocks**, each meant to
be stacked top-to-bottom on its own page:

- **Homepage**: Hero → Best Sellers → Shop by Concern → Feature Strip →
  Follow Along (ported from `NewProject/cilla-skyn-homepage.html`).
- **About page**: About Hero → Our Story → Formulation Approach, plus
  Contact Info wherever contact details should appear (ported from
  `NewProject/Cilla Skyn Website Layout.docx`'s About Us copy — there's no
  About section in the homepage HTML mockup, only in the docx).

Every block:

- Auto-registers from its `block.json` — `inc/acf-blocks.php` globs
  `blocks/*/block.json` and calls `register_block_type()` on each; adding a
  new block folder is enough, no extra PHP required.
- Renders via ACF's `renderTemplate` (`render.php` in the block folder),
  reading fields with `get_field()`.
- **Falls back to the source copy** — the homepage mockup
  (`NewProject/cilla-skyn-homepage.html`) for homepage blocks, the docx
  (`NewProject/Cilla Skyn Website Layout.docx`) for About-page and Contact
  Info blocks — for any field left empty. This works via each field's
  `default_value` in its `acf-json/group_*.json`, and via
  `inc/block-defaults/<slug>.php` for repeater fields (ACF has no
  `default_value` support for repeaters — see `inc/acf-block-defaults.php`
  for how those are stitched together) — so a freshly-added block is never
  blank.
- Has its own `README.md` inside the block folder documenting every field —
  treat those as the field-level reference; this file gives the overview.

---

## 5. Block reference

**Homepage** (order matches `NewProject/cilla-skyn-homepage.html`):

| Block | Folder | What it renders |
|---|---|---|
| **Hero** | `blocks/cilla-skyn-hero` | Full-bleed cream hero: background image with a configurable overlay (gradient/solid/none, colour-picker), eyebrow, heading, description, two buttons, vertical side-label list |
| **Best Sellers** | `blocks/cilla-skyn-best-sellers` | WooCommerce product grid, built from the native `[products]` shortcode with editor-configurable heading/visibility/sort/limit/columns |
| **Shop by Concern** | `blocks/cilla-skyn-shop-by-concern` | Grid of skin-concern category tiles (product photo, title, subtitle, link) |
| **Feature Strip** | `blocks/cilla-skyn-feature-strip` | Row of icon + text trust badges |
| **Follow Along** | `blocks/cilla-skyn-follow-along` | Instagram-style tile grid mixing product/colour-block captions and a quote tile |

**About page** (order matches the About Us copy in
`NewProject/Cilla Skyn Website Layout.docx`; there's no static mockup for
this page):

| Block | Folder | What it renders |
|---|---|---|
| **About Hero** | `blocks/cilla-skyn-about-hero` | Centered brand-statement intro: optional background image with a colour-picker overlay wash, a colour-picker text colour, eyebrow, heading, two rich-text (WYSIWYG) paragraphs, closing tagline |
| **Our Story** | `blocks/cilla-skyn-our-story` | Founder-story section: eyebrow, heading, paragraph repeater, pronunciation note, closing line |
| **Formulation Approach** | `blocks/cilla-skyn-formulation-approach` | Formulation-philosophy section: eyebrow, heading, paragraph repeater, three-line principles strip |
| **Contact Info** | `blocks/cilla-skyn-contact-info` | Heading + rich-text subheading (WYSIWYG — bold, headings, images, video embeds, files) + row of contact-method cards (WhatsApp, Instagram, Email, Phone) with icon, label, value, link — usable on any page |

**About page, additional pages** (Our Ingredients / Sustainability / The
Edit / Press aren't in the docx's About Us copy, but each has its own nav
entry — see §17 — so each gets its own page built from one of these):

| Block | Folder | Page | What it renders |
|---|---|---|---|
| **Ingredients** | `blocks/cilla-skyn-ingredients` | Our Ingredients | Grid of hero-ingredient cards: photo, name, description |
| **Pillars** | `blocks/cilla-skyn-pillars` | Sustainability | Grid of icon + title + description commitment cards |
| **Editorial Grid** | `blocks/cilla-skyn-editorial-grid` | The Edit | Grid of article/journal teaser tiles: photo, tag, title, excerpt, link |
| **Press** | `blocks/cilla-skyn-press` | Press | "As Seen In" logo strip + press quote mentions — ships empty, see the block's own README before adding content |

**Help pages** (none of these are in the docx or homepage mockup — the
docx only lists Help as 5 nav labels with no page content, so every
default below was written for these blocks, not supplied by the client):

| Block | Folder | Page | What it renders |
|---|---|---|---|
| **Content Sections** | `blocks/cilla-skyn-content-sections` | Shipping & Delivery, Returns & Exchanges | Generic narrow-column policy content: heading, intro, titled sections |
| **FAQ** | `blocks/cilla-skyn-faq` | FAQs | No-JS accordion of question/answer pairs |
| **Order Tracking** | `blocks/cilla-skyn-order-tracking` | Track Your Order | Heading/description + button to WooCommerce's My Account → Orders |
| **Contact Form** | `blocks/cilla-skyn-contact-form` | Contact Us | Working contact form (name/email/phone/subject/message) that emails the site admin — pair with Contact Info above |

To edit a block's fields, add it in the Block Editor and open the block
settings panel — every field has a label and description pulled straight
from its ACF field group. **Before publishing any of the pages above**,
read that block's own README — several ship with placeholder content
that's explicitly flagged as needing review (generic shipping-policy
copy, example FAQs, etc.), and the Press and Pillars blocks specifically
warn against publishing unverified claims (see their READMEs).

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
Comments) with three sub-pages:

- **General** — empty, ready for future site-wide fields.
- **Header** — empty, ready for future site-wide fields.
- **Footer** — the **Cilla Skyn Footer** field group
  (`acf-json/group_cilla_skyn_footer_options.json`): Shop Links, Social
  Links, Help Links, About Links, Legal Links and the newsletter
  heading/description — see §8 for what each controls. This is the **only**
  way to edit the footer's links; unlike the header, the footer has no
  WordPress nav menu of its own.

Add more field groups located to `options`/a specific sub-page's
`menu_slug` (`theme-options-general`, `theme-options-header`,
`theme-options-footer`) in ACF and they'll appear on the matching
sub-page.

Site-wide settings that already exist live in the **Customizer** instead
(§8): logo, WhatsApp number, footer brand tagline/description.

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

**Footer** (`footer.php`) — 5 columns matching the design. Everything
except Brand's wordmark/tagline is now editable from
**Theme Options → Footer** in wp-admin (the **Cilla Skyn Footer** field
group, §7) — no code changes needed to add/remove a link, swap a URL, or
show/hide a social icon. Unlike the header's `primary_navigation`, the
footer has **no WordPress nav menu of its own** — every column is an ACF
repeater on that one options page:

| Column | Where to edit |
|---|---|
| **Brand** | Wordmark (site title, automatic) and tagline (`cilla_skyn_tagline` theme mod — **Customize → Site Identity**, shared with the header announcement bar) stay Customizer-controlled. Description (`iga_footer_tagline` theme mod, same Customizer section) and **Social Links** (Theme Options → Footer — one row per icon: pick a **Platform** from Instagram/Facebook/TikTok/Pinterest/YouTube and its **URL**; a row with no URL, or no row at all for a platform, simply doesn't render that icon — no more dead `#` links) |
| **Shop** | **Theme Options → Footer → Shop Links** — same repeater pattern as Help/About. Ships with `All Products` → the real Shop page, plus 4 `#` placeholders (`Best Sellers`/`The Baby Collection`/`Bundles & Sets`/`Gift Cards`) as the fallback shown until the field is first saved |
| **Help** | **Theme Options → Footer → Help Links** — a repeater of **Label** + **URL** rows, add/remove/reorder freely. Ships with the design's original 5 links (`Shipping & Delivery`/`Returns & Exchanges`/`FAQs`/`Track Your Order` as `#` placeholders, `Contact Us` → `/contact/`) as the fallback shown until the field is first saved |
| **About** | **Theme Options → Footer → About Links** — same repeater pattern. Ships with `Our Story` → `/about/` (the About page built from the blocks in §5) plus 4 `#` placeholders (`Our Ingredients`/`Sustainability`/`The Edit`/`Press`) |
| **Newsletter** | **Theme Options → Footer → Newsletter Heading/Description** (plain text fields). The form itself has no ESP wired up (`onsubmit="return false"` like the design mockup) — connect it to Mailchimp/Klaviyo/etc. before relying on it |
| Legal links | **Theme Options → Footer → Legal Links** — repeater, ships with Terms/Privacy/Cookies pointing at `/terms/`, `/privacy/`, `/cookies/` (create those pages) |
| Copyright | Automatic (`date_i18n( 'Y' )` + site title) |

All five footer repeaters (Shop Links, Social Links, Help Links, About
Links, Legal Links) fall back to the design's original content — hardcoded
directly in `footer.php`, not via `inc/block-defaults/` — until the field
group is saved for the first time on **Theme Options → Footer**, exactly
like a block's fields never render blank (§4). Two things that used to
control parts of the footer were retired since they're now covered by
these repeaters: the `iga_instagram_url` Customizer setting (the
Instagram icon is now just the `instagram` row in Social Links), and the
**Footer Navigation** nav menu location (the Shop column is now Shop
Links, alongside every other column, instead of being the one column
edited via **Appearance → Menus**) — along with its
`iga_footer_nav_fallback()` and `iga_footer_menu_link_atts()` helpers in
`inc/theme-setup.php`, which had no other purpose.

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
- **Contact Form block** (§5) has its own, unrelated handler —
  `inc/cilla-skyn-contact-form.php` — following the same
  `template_redirect` + nonce + honeypot + `wp_mail()` pattern as
  `page-forms.php` above, but written fresh for Cilla Skyn rather than
  reviving that gym-era file (its subject options don't fit a skincare
  store). Emails `get_option( 'admin_email' )` by default (filterable via
  `cilla_skyn_contact_recipient`) — **requires working outgoing mail on
  the host** (an SMTP plugin, on most setups) to actually arrive; see the
  block's own README.

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
| `inc/cilla-skyn-contact-form.php` | Contact Form block's handler (§5/§9) — active, unrelated to `page-forms.php` above |
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
| WhatsApp number needs updating | The header/footer no longer show a WhatsApp icon (§8 — removed, didn't fit the Cilla Skyn design). WhatsApp now only appears via the **Contact Info** block's **Methods** repeater (§5) — edit the WhatsApp row's Value/URL directly on that block instance, not in the Customizer |
| Footer links go nowhere or point at pages that don't exist | That row's URL is still the shipped `#` placeholder — edit it on **Theme Options → Footer** (§8) |
| Footer Shop/Help/About/Legal links or social icons don't match what's saved in Theme Options → Footer | Click **Sync** on the **Cilla Skyn Footer** field group under **Custom Fields → Field Groups**, then re-save Theme Options → Footer |
| A footer social icon isn't showing | That platform's row in **Theme Options → Footer → Social Links** has no URL, or there's no row for it at all — a platform only renders once it has a URL (§8) |
| Clicking "View Memberships" in the mobile menu does nothing / console error | Known issue — see [§13](#13-known-legacyorphaned-code) |
| A WooCommerce-looking `.hidden` utility fights with the header nav on non-WooCommerce pages | Already handled — `cilla_skyn_dequeue_preorders_sitewide_assets()` in `inc/theme-styles.php` dequeues the offending plugin CSS outside WooCommerce pages |
| Contact Form block always shows an error, or messages never arrive | `wp_mail()` needs working outgoing mail on the host — install/configure an SMTP plugin (e.g. WP Mail SMTP) with real credentials, then send a test submission. Check spam too |
| Contact Form block shows "Your session expired" immediately | A page-caching plugin is caching the nonce in the form's HTML — exclude that page from caching, or exclude the block's markup |
| A field shows literal `<br>`/HTML tags as visible text instead of formatting | That field is a plain Text/Textarea field (intentionally escaped with `esc_html()` — see every block's `render.php`), not rich text — typing HTML into it doesn't do anything. The fields in this theme that support real formatting (bold, headings, images, video embeds, files) are the **Contact Info** block's **Subheading** and the **About Hero** block's **Intro**/**Description** (§5) — use their "Add Media"/toolbar buttons rather than typing tags by hand. See either block's own README for how to add the same capability to another field |

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
├── NewProject/                    # Design source: cilla-skyn-homepage.html (homepage mockup) +
│                                   # "Cilla Skyn Website Layout.docx" (About page copy + product
│                                   # catalog reference — see §17)
└── assets/
    ├── css/tailwind.css           # COMPILED output (do not edit by hand)
    ├── images/                    # Bundled fallback/demo images
    └── js/                        # header.js (active), modal.js/hero-slider.js/pricing-tabs.js (orphaned), reveal.js — §10
```

---

## 16. Adding a block section: full walkthrough

Every `cilla-skyn-*` block follows the exact same 6-file recipe. Use this
if you need to add another section beyond the ones in [§5](#5-block-reference)
(e.g. a Testimonials or FAQ block) — it's also exactly how the 4 About-page
blocks in this repo were added.

1. **`blocks/cilla-skyn-<slug>/block.json`** — copy an existing block's
   file and change `name`, `title`, `icon`, `description`, `keywords`.
   Keep `"acf": { "mode": "auto", "renderTemplate": "render.php" }` and
   `"style": "file:./style.css"` — no registration code is needed anywhere
   else, `inc/acf-blocks.php` auto-discovers every `blocks/*/block.json`
   on `acf/init`.
2. **`blocks/cilla-skyn-<slug>/render.php`** — read fields with
   `get_field( 'name' ) ?: 'fallback copy'` for scalar fields (text,
   textarea, image, url, select), and `get_field( 'name' )` + `foreach`
   for Repeaters. Wrap the section in
   `get_block_wrapper_attributes( array( 'class' => 'wp-theme-cilla-skyn-<slug> ...' ) )`
   so the block gets a stable CSS hook and picks up `align`/`spacing`
   block supports. Use the existing `cilla-skyn-*` Tailwind tokens
   (§12) — `bg-cream`/`bg-cream-dark`, `text-cs-ink`, `text-gold`,
   `font-serif`/`font-sans-cs` — never the dark gym-era tokens.
3. **`blocks/cilla-skyn-<slug>/style.css`** — leave as the placeholder
   comment (`/* Styled via Tailwind utility classes in render.php. */`)
   unless the block genuinely needs CSS Tailwind can't express (like Best
   Sellers' WooCommerce shortcode overrides, which live in `src/input.css`
   instead — see that block's own README).
4. **`blocks/cilla-skyn-<slug>/README.md`** — a fields table (name, type,
   required, description) plus a short **Notes** section. This is the
   file a client or another developer reads to understand the block
   without opening the code.
5. **`acf-json/group_cilla_skyn_<slug>.json`** — the field definitions.
   Copy an existing group, rename `key`/`title`, and change the
   `location` block's `value` to `wp-theme/cilla-skyn-<slug>`. Give every
   scalar field a `default_value` with real fallback copy (never leave a
   field blank on purpose) — `inc/acf-json.php` makes this load
   automatically, no manual Sync needed on a fresh install. Field keys
   only need to be unique across the whole site; the `field_cilla_skyn_<slug>_<name>`
   convention just avoids collisions by construction.
6. **`inc/block-defaults/cilla-skyn-<slug>.php`** — **only needed if the
   block has a Repeater field.** ACF's `default_value` setting doesn't
   support Repeaters at all, so this file returns a
   `'field_<repeater_key>' => array( array( 'sub_field_name' => 'value', ... ), ... )`
   map instead; `inc/acf-block-defaults.php` globs every file in this
   directory and serves the rows whenever that Repeater is still empty.
   Use `sub_field_name` (not `sub_field_key`) here — `custom_theme_remap_repeater_row_keys()`
   converts it internally. Skip this file entirely for blocks with only
   scalar fields (e.g. [About Hero](blocks/cilla-skyn-about-hero/README.md)).

Then just add the block in the Block Editor — it appears in the inserter
under the "design" category, prefixed "Cilla Skyn" so it's easy to find.

**Avoid `conditional_logic` on a field that depends on an Image/File/
Gallery field's value** (e.g. "only show Field B once Image Field A has a
value") **inside an ACF Block.** It's the standard, documented ACF pattern
and works fine on normal post-edit screens, but it doesn't reliably fire
inside a Block's own settings form — the field can end up permanently
hidden even after the image is set (see [About Hero](blocks/cilla-skyn-about-hero/README.md)'s
Background Overlay Color, which shipped this way and had to be changed to
always-visible). If a field only makes sense once another field has a
value, say so in its `instructions` text instead of trying to hide it.

---

## 17. Content & product catalog reference (source docx)

`NewProject/Cilla Skyn Website Layout.docx` is the client's own content
brief. Everything in it that describes a **page section** is now a block
(§5); everything else in it describes **WooCommerce setup** (products,
categories, navigation) that has to be done in wp-admin rather than in a
block, since this theme has no custom post types for products — it's all
native WooCommerce. This section is a map from that document to where its
content actually lives in this theme, for whoever populates the store.

**Top navigation** (docx: "Top Navigation") — set up as the **Primary
Navigation** menu (§8):

| Menu item | Notes |
|---|---|
| Shop All | Link to the Shop page — should list every product |
| Face Care | Sub-items: Serums, Face Cleanser, Moisturisers — create these as WooCommerce product categories and link to their archive pages |
| Body Care | Sub-items: Body Cleanser, Body Lotion, Body Cream, Body Scrubs, Bath Salts — same, as product categories |
| Hero Ingredients | No content supplied yet in the docx ("I will share in a separate sheet") — link to a placeholder page until that's provided |
| About Us | Link to the About page built from the blocks in §5 |

The header's nav menu (`header.php`) renders a flat `wp_nav_menu()` with no
dropdown styling for nested items yet — if you assign a menu with
Face Care/Body Care sub-items, style the resulting `.sub-menu` markup
before relying on it to show dropdowns.

**Product catalog** (docx: "Cilla Skyn product list by category") — the
full SKU list (Face Cleansers, Facial Serums & Treatments, Face
Moisturisers & Creams, Facial Oils, Face + Body Treatments/Masks, Body
Lotions & Creams, Body Oils, Body Cleansers, Body Scrubs & Polishes, Bath
Soaks & Bath Treatments) is the client's real product range. Create each
as a WooCommerce product, assigned to a matching product category — the
**Best Sellers** block (§5) and the **Shop by Concern** block's tile
**Product** field (§5) both pull directly from real WooCommerce products,
so nothing on the front end shows real content until these exist.

**Shop by concern mapping** (docx: "Shop by concerns") — the document maps
specific products to 7 concern groupings, each with a "Primary Role"/
"Positioning" note (e.g. under "Oily & Acne Prone": Clarity Reset
Clarifying Gel Face Wash → "Oil, congestion, blemishes"). The
**Shop by Concern** block (§5) ships with the 6-tile version of this from
the docx's own "Recommended website 'Shop by Concern'" summary (Oily &
Acne Prone, Sensitive & Eczema Prone, Dry & Dehydrated, Uneven Tone & Dark
Marks, Texture & Ageing, Firmness & Body Texture) — once products exist,
pick one representative product per tile in the block editor (the block's
own README explains the **Product**/**Title**/**Subtitle** fields). The
7th grouping in the docx, "Body Wellness & Bath Rituals", isn't one of the
6 recommended tiles — fold it into an existing tile's product pick, or add
a 7th row in the block editor (the Repeater has no row limit).

**Contact information** (docx: "Contact Information") — WhatsApp
`+27 64 911 1932`, Instagram `@Cillaskyn`, Email `Info@cillaskyn.co.za`.
These already ship as the **Contact Info** block's (§5) default rows, and
as the **Social Links**/WhatsApp defaults on **Theme Options → Footer**
(§7/§8). The `cilla_skyn_whatsapp` Customizer setting also still exists
but nothing currently surfaces it (§8) — don't rely on it.

**About Us copy** (docx: "About Us — Hero Statement / Our Story /
Our Formulation Approach") — this is the About-page block stack in §5
(About Hero → Our Story → Formulation Approach) verbatim; no further setup
needed beyond adding the 3 blocks to the About page.

**Footer's Help/About columns** (§8) point at `#` placeholders, or in
About's case, `/about/`, until the pages below exist — once you've built
each page, go back to **Theme Options → Footer** and update the matching
**Help Links**/**About Links** row's URL to the real page:

| Footer link | Build with |
|---|---|
| Help → Shipping & Delivery | Content Sections block (§5), duplicated/relabelled |
| Help → Returns & Exchanges | Content Sections block (§5), duplicated/relabelled |
| Help → FAQs | FAQ block (§5) |
| Help → Track Your Order | Order Tracking block (§5) |
| Help → Contact Us | Contact Info + Contact Form blocks (§5) |
| About → Our Ingredients | Ingredients block (§5) |
| About → Sustainability | Pillars block (§5) |
| About → The Edit | Editorial Grid block (§5) |
| About → Press | Press block (§5) — **read its README before adding content** |

None of this content is in the docx — these 9 pages match the footer's
existing Help/About column link *labels* (§8), which were already in this
codebase as `#` placeholders before any page content existed for them.
Every block above ships with clearly-flagged placeholder content (see each
block's own README) precisely because there was nothing in the source
document to draw from.

---

**Handing over to the client:** give them this README plus, for any block
they're actively editing, that block's own `README.md` for the field-level
detail. Empty fields fall back to the source design's own content (the
homepage mockup or the docx — §16/§17), so nothing a client does in the
Block Editor can leave a page blank.
