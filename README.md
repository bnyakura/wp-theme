# Iron Gorilla Army — WordPress Theme

A custom classic WordPress theme (`custom-theme` / "IGA") built on **Advanced
Custom Fields (ACF) Pro / Secure Custom Fields (SCF) Gutenberg blocks** and
**Tailwind CSS v4**. Every page on the site is assembled in the Block Editor
from the theme's own blocks — there are no page-builder plugins and no
custom post types driving the front end. Each block ships with the original
site's copy as built-in fallback content, so a block renders fully styled
the moment it's added, even before any fields are filled in.

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
9. [Forms: booking & contact](#9-forms-booking--contact)
10. [Modals](#10-modals)
11. [Front-end JavaScript](#11-front-end-javascript)
12. [Theme structure (`inc/`)](#12-theme-structure-inc)
13. [Design tokens](#13-design-tokens)
14. [Troubleshooting](#14-troubleshooting)
15. [File map](#15-file-map)

---

## 1. Requirements

- WordPress 6.0+
- PHP 7.4+
- **Advanced Custom Fields Pro** (or the free **Secure Custom Fields**
  plugin) — **required**. The theme calls `wp_die()` on the front end and
  shows an admin notice in wp-admin if it isn't active
  (`inc/acf-requirements.php`).
- Node.js (for building the Tailwind CSS during development — not needed at
  runtime once `assets/css/tailwind.css` is built and committed).

---

## 2. Installation

1. Copy this folder into `wp-content/themes/` and activate **ACF
   Pro/SCF**.
2. In wp-admin: **Appearance → Themes → Activate**.
3. Build the CSS (next section) — the site is unstyled until this has run
   at least once.
4. Go to **Custom Fields → Field Groups** and confirm the groups listed
   under [§6](#6-field-groups-acfscf-local-json) show **"Sync available"**
   is *not* pending drift (they load automatically from `acf-json/`, no
   manual sync needed on a fresh install).
5. Create your pages (Home, About, Contact, Book, FAQ, Armory, League,
   Training, …) and add the matching block from [§5](#5-block-reference) to
   each in the Block Editor.
6. **Settings → Reading** → set the homepage to the page you built with the
   homepage blocks (Hero, Stats Bar, Distinction, Mission, Forge, Pricing,
   Homepage Contact).
7. **Appearance → Menus** → assign menus to the **Primary Navigation** and
   **Footer Navigation** locations (registered in `inc/theme-setup.php`).
8. Set the WhatsApp number and Instagram URL under **Appearance → Customize
   → Site Identity** (§8).

Fonts (Bebas Neue + DM Sans) and Font Awesome are enqueued from CDNs — no
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
colors, fonts, the hero progress-bar animation) live in the `@theme` block
of `src/input.css` — see [§13](#13-design-tokens).

Each block also ships its own `style.css` (`file:./style.css` in its
`block.json`), auto-enqueued by WordPress only on pages where that block is
used — no build step needed for those.

---

## 4. How the site is built: blocks, not pages

There is **no `front-page.php`** and **no page templates** — every page in
this theme (including the homepage) is just a normal WordPress page whose
content is one or more of this theme's Gutenberg blocks, added and arranged
in the Block Editor like any other block. `index.php` simply calls
`the_content()`.

Two kinds of blocks:

- **Homepage section blocks** — Hero, Stats Bar, Distinction, Mission,
  Forge, Pricing, Testimonials, Homepage Contact — meant to be stacked on
  one page to build the homepage.
- **Full-page blocks** — About, Armory, Book, Contact, FAQ, League,
  Training — each is a complete, self-contained page (hero through footer
  CTA) meant to be the *only* block on its page.

Every block:

- Auto-registers from its `block.json` — `inc/acf-blocks.php` globs
  `blocks/*/block.json` and calls `register_block_type()` on each; adding a
  new block folder is enough, no extra PHP required.
- Renders via ACF's `renderTemplate` (`render.php` in the block folder),
  reading fields with `get_field()`.
- **Falls back to the original Iron Gorilla Army site copy** for any field
  left empty, so a freshly-added block is never blank.
- Has its own `README.md` inside the block folder documenting every field —
  treat those as the field-level reference; this file gives the overview.

---

## 5. Block reference

| Block | Folder | Type | What it renders |
|---|---|---|---|
| **Hero** | `blocks/hero` | Homepage section | Autoplaying slide carousel (repeater field: background image, eyebrow, title, accent line, description, CTA button) |
| **Stats Bar** | `blocks/stats-bar` | Homepage section | Row of stat value/label pairs |
| **Distinction** | `blocks/distinction` | Homepage section | 3-column info cards (image, tag, CTA) |
| **Mission** | `blocks/mission` | Homepage section | Two-column origin-story text + portrait image |
| **Forge** | `blocks/forge` | Homepage section | Three-pillar icon cards + CTA buttons |
| **Pricing** | `blocks/pricing` | Homepage section | Tabbed pricing: Monthly Memberships / Drop-In Sessions |
| **Testimonials** | `blocks/testimonials` | Homepage section | Grid of member quote cards |
| **Homepage Contact** | `blocks/homepage-contact` | Homepage section | Condensed dispatch form + HQ card (lighter sibling of the Contact block) |
| **About** | `blocks/about` | Full page | Hero, origin story, core values, coaches grid, testimonials, final CTA |
| **Armory** | `blocks/armory` | Full page | Video hero, heading, CTAs, "coming soon" badge |
| **Book** | `blocks/book` | Full page | Booking page — quick sign-up class cards or a date/session picker, with the booking form handler |
| **Contact** | `blocks/contact` | Full page | Hero, HQ details, full dispatch form, testimonials, final CTA |
| **FAQ** | `blocks/faq` | Full page | Hero, categorised Q&A, testimonials, final CTA |
| **League** | `blocks/league` | Full page | Coming-soon honour-roll page + bank transfer details |
| **Training** | `blocks/training` | Full page | Hero, pillars, training tracks, weekly schedule, testimonials, pricing tabs, coaches, onboarding steps, final CTA |
| **Toaster** | `blocks/toaster` | Utility | Configurable toast/notification block |

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
by every page.

**Header** (`header.php`):

- Fixed, blurred-glass bar with logo, primary nav (`primary_navigation`
  menu location), a hardcoded **Legends** link to `/league`, a **Book Free
  Assessment** button, an optional WhatsApp icon, and a mobile drawer menu.
- WhatsApp number: **Appearance → Customize → Site Identity → WhatsApp
  Number** (`iron_gorilla_whatsapp` theme mod). Empty = icon hidden.
- Mobile menu open/close is handled by `assets/js/header.js`.

**Footer** (`footer.php`):

| Content | Where to edit |
|---|---|
| Footer tagline | Customizer → Site Identity → **Footer Tagline** |
| Logo | Customizer → Site Identity → **Logo** (falls back to `assets/images/logo.png`) |
| **Navigate** column | **Appearance → Menus** → assign a menu to **Footer Navigation**. Until one is assigned, a hardcoded fallback (`iga_footer_nav_fallback()` in `inc/theme-setup.php`) renders: About, The Forge, Armory, FAQ, Contact, Legends |
| **Get In** column | "Enlist Now" opens the enlist modal; Book/Contact links point at `/book/` and `/contact/` |
| **Find Us** (address + hours) | Static markup in `footer.php` — edit directly if the address/hours change |
| Legal links | Fixed links to `/terms/`, `/privacy/`, `/refund/` — create those pages |
| Social icon | Customizer → Site Identity → **Instagram URL** (`iga_instagram_url`, defaults to the club's Instagram) |
| Copyright year | Automatic (`date_i18n( 'Y' )`) |

Both navigation menu locations (`primary_navigation`, `footer`) are
registered in `inc/theme-setup.php`.

---

## 9. Forms: booking & contact

Handled by `inc/page-forms.php`, shared by the **Book**, **Contact**, and
**Homepage Contact** blocks:

- Both the booking form and the dispatch (contact) form process via
  classic POST, hooked on `template_redirect` (before any HTML is output,
  since the blocks render mid-`the_content()`) — **works with JS
  disabled**.
- Sends email via `wp_mail()`.
- Quick sign-up classes (`iga_booking_quick_classes`), the weekly schedule
  (`iga_booking_schedule`), and available booking dates
  (`iga_booking_next_dates`) are all filterable PHP arrays in
  `inc/page-forms.php` — override via the matching `add_filter()` in
  `functions.php` rather than editing the block templates.
- Contact subjects/aliases (`iga_contact_subjects`,
  `iga_contact_subject_aliases`) and HQ details (`iga_contact_details`) are
  filterable the same way.

> **Deliverability:** if messages don't arrive, install an SMTP plugin
> (e.g. *WP Mail SMTP*) — the handlers need no changes.

---

## 10. Modals

The **Enlist Now** modal (`template-parts/modal-enlist.php`) is rendered
once from `footer.php`, so it's available on every page.

**Wiring contract — reuse it anywhere:**

```html
<!-- Trigger -->
<button type="button" data-modal-open="enlist-modal">Enlist Now</button>

<!-- Modal element -->
<div data-modal="enlist-modal"> … <button data-modal-close>×</button> … </div>
```

`assets/js/modal.js` is event-delegated (no inline JS needed) and handles
open, close button, backdrop click, **Escape**, and body scroll-lock.

---

## 11. Front-end JavaScript

Enqueued in `inc/theme-js.php` (and mirrored into the block editor canvas
by `inc/theme-styles.php` so previews match the live site):

| Script | Purpose |
|---|---|
| `assets/js/header.js` | Mobile menu open/close |
| `assets/js/modal.js` | Modal open/close, backdrop, Escape, scroll-lock (§10) |
| `assets/js/hero-slider.js` | Hero autoplay, hover-pause, swipe, arrows, dots, progress bar |
| `assets/js/reveal.js` | Scroll-triggered reveal animations (`.reveal`/`.active`) — also loaded in the block editor so section previews aren't stuck at `opacity:0` |
| `assets/js/pricing-tabs.js` | Pricing block's Monthly / Drop-In tab toggle |

---

## 12. Theme structure (`inc/`)

`functions.php` requires files in this order via `inc/theme-setup.php`:

| File | Responsibility |
|---|---|
| `inc/acf-requirements.php` | Blocks the site / warns in wp-admin if ACF isn't active |
| `inc/theme-setup.php` | `add_theme_support`, nav menu registration, SVG uploads, Customizer settings (WhatsApp, Instagram, footer tagline, hero interval), footer nav fallback |
| `inc/theme-styles.php` | Enqueues compiled Tailwind CSS, Font Awesome, editor-canvas styles; dequeues a conflicting WooCommerce Pre-Orders stylesheet outside WooCommerce pages |
| `inc/theme-js.php` | Enqueues all front-end scripts (§11) + Google Fonts |
| `inc/acf-blocks.php` | Auto-registers every `blocks/*/block.json` |
| `inc/acf-json.php` | Points ACF's local-JSON load/save path at `acf-json/` |
| `inc/acf-options.php` | Registers the Theme Options menu + General/Header/Footer sub-pages |
| `inc/page-forms.php` | Booking + contact form handlers and their shared filterable data (§9) |

`inc/hero-slides.php`, `distinction-cards.php`, `mission.php`,
`forge-pillars.php`, `pricing-tiers.php`, `testimonials.php`, and
`contact-section.php` are **legacy** — they register unused custom post
types from an earlier custom-post-type architecture that predates the
block-based rebuild. They're still `require`d by `inc/theme-setup.php` but
nothing on the front end renders their post types anymore; the equivalent
content is now owned by the matching block's ACF fields instead. Safe to
ignore (or remove, along with `template-parts/` and `hero_tutorial.md`,
which document that same earlier architecture) in a future cleanup.

---

## 13. Design tokens

Defined in the `@theme` block of `src/input.css`:

| Token | Value | Use |
|---|---|---|
| `--color-ink` | `#0A0A0A` | Page background |
| `--color-s1` / `s2` / `s3` | `#141414` / `#1C1C1C` / `#242424` | Surface layers |
| `--color-green` / `green-l` / `green-d` | `#3A7D44` / `#4E9E5A` / `#2A5C32` | Brand green + hover/dark variants |
| `--color-amber` | `#C47B2B` | Accent (Legends link) |
| `--color-off` | `#F2F2F2` | Body text |
| `--color-muted` / `muted-l` | `#888888` / `#AAAAAA` | Secondary text |
| `--color-line` / `line-strong` | `rgba(255,255,255,.07/.14)` | Hairline borders |
| `--font-sans` | DM Sans | Body |
| `--font-display` | Bebas Neue | Headings |
| `--animate-slide-progress` | 6s linear | Hero autoplay progress bar |

The `@layer base` block restores the dark page background and base
typography that Tailwind's preflight doesn't set — without a CSS build,
the site renders on a plain white page.

---

## 14. Troubleshooting

| Symptom | Fix |
|---|---|
| Whole page renders **white/unstyled** | Build the CSS (§3) and hard-refresh. `inc/theme-styles.php` shows an admin notice when `assets/css/tailwind.css` is missing |
| A block's Tailwind classes changed but nothing shows | Rebuild the CSS — class names are compiled from the PHP source into `tailwind.css` |
| A block preview is blank in the editor until you click | `assets/js/reveal.js` (scroll-reveal) must be loaded in the editor canvas — check `custom_theme_enqueue_editor_styles()` in `inc/theme-styles.php` is still hooked to `enqueue_block_editor_assets` |
| Front end shows "Missing Required Plugin" | ACF Pro / SCF isn't active — install and activate it (§1) |
| A block renders its **fallback/demo content** instead of your edits | You haven't filled in that block's fields yet, or a required field (e.g. an image) is empty — check the block's own `README.md` for which fields are required |
| Field group changes don't appear on the front end | Click **Sync** on the field group under **Custom Fields → Field Groups** |
| Contact/booking form submits but no email arrives | Server mail issue — add an SMTP plugin (§9) |
| WhatsApp icon missing | Set **WhatsApp Number** under Customize → Site Identity |
| Footer nav shows the wrong links | No menu assigned to the **Footer Navigation** location yet — assign one, or edit the fallback in `iga_footer_nav_fallback()` |
| A WooCommerce-looking `.hidden` utility fights with the header nav on non-WooCommerce pages | Already handled — `iron_gorilla_dequeue_preorders_sitewide_assets()` in `inc/theme-styles.php` dequeues the offending plugin CSS outside WooCommerce pages |

---

## 15. File map

```
wp-theme/
├── style.css                      # Theme header only (all styles are compiled Tailwind)
├── index.php                      # Generic fallback template — the_content() renders the blocks
├── 404.php                        # 404 template
├── header.php / footer.php        # Shared chrome: nav, WhatsApp, footer, enlist modal
├── functions.php                  # Requires everything under inc/
├── package.json                   # Tailwind build scripts (npm run dev / build)
├── src/
│   └── input.css                  # Tailwind source: @theme design tokens + @layer base
├── inc/                           # See §12 for what each file does
│   ├── acf-requirements.php
│   ├── theme-setup.php
│   ├── theme-styles.php
│   ├── theme-js.php
│   ├── acf-blocks.php
│   ├── acf-json.php
│   ├── acf-options.php
│   ├── page-forms.php
│   └── (legacy CPT files — see §12)
├── acf-json/                      # group_<block>.json field-group definitions, one per block
├── blocks/                        # One folder per Gutenberg block — see §5
│   └── <block>/
│       ├── block.json             # Registration + acf.renderTemplate
│       ├── render.php             # get_field() + markup, with fallback content
│       ├── style.css              # Block-scoped styles, auto-enqueued when the block is used
│       └── README.md              # Field-by-field reference for that block
└── assets/
    ├── css/tailwind.css           # COMPILED output (do not edit by hand)
    ├── images/                    # Bundled fallback/demo images
    ├── videos/                    # Bundled fallback video (Armory block)
    └── js/                        # header.js, modal.js, hero-slider.js, reveal.js, pricing-tabs.js — §11
```

**Handing over to the client:** give them this README plus, for any block
they're actively editing, that block's own `README.md` for the field-level
detail. Empty fields fall back to the original site content, so nothing a
client does in the Block Editor can leave a page blank.
