# IGA — Iron Gorilla Army WordPress Theme

A classic WordPress theme (PHP templates + Tailwind CSS v4) converted from the
original Next.js/React site. Every front-page section is editable from the
WordPress dashboard — and **every section ships with the original site content
as built-in defaults**, so the site looks complete the moment the theme is
activated. Nothing renders empty.

---

## Table of contents

1. [Requirements & installation](#1-requirements--installation)
2. [Building the CSS](#2-building-the-css-required)
3. [How content editing works](#3-how-content-editing-works)
4. [Dashboard content sections (post types)](#4-dashboard-content-sections)
   - [Hero Slides](#41-hero-slides)
   - [Distinction Cards](#42-distinction-cards)
   - [Forge Pillars](#43-forge-pillars)
   - [Pricing Tiers](#44-pricing-tiers)
   - [Testimonials](#45-testimonials)
5. [Customizer sections](#5-customizer-sections-appearance--customize)
   - [Hero Slider](#51-hero-slider)
   - [Mission Section](#52-mission-section)
   - [Forge Section](#53-forge-section)
   - [Pricing Section](#54-pricing-section)
   - [Testimonials Section](#55-testimonials-section)
   - [Contact Section](#56-contact-section)
   - [Instagram URL (Site Identity)](#57-instagram-url-site-identity)
6. [Stats bar](#6-stats-bar)
7. [Footer](#7-footer)
8. [Modals](#8-modals)
9. [Contact form (dispatch)](#9-contact-form-dispatch)
10. [Front-page layout](#10-front-page-layout)
11. [Developer reference](#11-developer-reference)
12. [Troubleshooting](#12-troubleshooting)
13. [File map](#13-file-map)

---

## 1. Requirements & installation

**Requirements:** WordPress 6.0+, PHP 7.4+ (no plugins required; no jQuery).

**Install:**

1. Copy the `iga-theme` folder into `wp-content/themes/`.
2. In wp-admin: **Appearance → Themes → activate "IGA"**.
3. **Settings → Reading** → set *Your homepage displays* → **A static page**,
   and choose your front page. The theme ships `front-page.php`, so the
   converted sections will render on it automatically.
4. Build the CSS (next section) — **the site looks unstyled until you do this
   once.**
5. Upload your real photography under **Media** (or keep the bundled demo
   images in `assets/img/` while building).

Fonts (Bebas Neue + DM Sans) and Font Awesome are enqueued from CDNs in
`functions.php` — nothing to install.

---

## 2. Building the CSS (required)

Tailwind v4 compiles `assets/css/input.css` → `assets/css/main.css`, scanning
**all PHP and JS files in the theme** for class names automatically.

```bash
cd wp-content/themes/iga-theme

# One-off production build:
npx @tailwindcss/cli -i assets/css/input.css -o assets/css/main.css --minify

# While developing (rebuilds on save):
npx @tailwindcss/cli -i assets/css/input.css -o assets/css/main.css --watch
```

**You must rebuild after editing any template's classes** or after editing
`input.css`. Deploy `main.css` with the theme.

Design tokens (brand colors, fonts) live in `@theme` inside
`assets/css/input.css`; the dark page background / base typography lives in the
`@layer base` block of the same file.

---

## 3. How content editing works

Two dashboards, one rule:

- **Repeated content** (slides, cards, pillars, tiers, testimonials) is managed
  under its own **left-hand admin menu** as posts. Each has an **Order** field
  (Page Attributes box, also editable via Quick Edit) that sets its sequence.
- **Fixed text** (section headers, HQ details, form recipient) lives in
  **Appearance → Customize**.

> **The golden rule — defaults:** until you publish your first item in a given
> menu (or change a Customizer field), the original site content renders for
> that module. Once you publish one item in a menu, that menu's defaults stop
> rendering and your items take over completely (all-or-nothing per module).

Everything is sanitized on save and escaped on output; plain text only — no
HTML in fields unless a field says otherwise.

---

## 4. Dashboard content sections

### 4.1 Hero Slides

**Where:** Dashboard → **Hero Slides** → Add New Slide.

| Field | Renders as |
|---|---|
| **Title** | Headline line 1 (white), e.g. `IRON GORILLA` |
| **Featured image** ("Slide background image") | Full-screen slide background |
| Slide Text → **Eyebrow** | Small green label above the headline |
| Slide Text → **Headline line 2 (green)** | Second headline line in green |
| Slide Text → **Body copy** | Paragraph under the headline (~140 chars recommended) |
| **Order** (Page Attributes) | Slide sequence, ascending |

Notes:

- A slide **without a featured image is skipped** instead of rendering broken.
- The first slide loads eagerly (`fetchpriority="high"`); the rest lazy-load.
- Autoplay speed is a Customizer setting — see §5.1.
- Fallback: the original 3 slides (Brotherhood / Forge / Standard).

### 4.2 Distinction Cards

**Where:** Dashboard → **Distinction Cards** → Add New Card.

| Field | Renders as |
|---|---|
| **Title** | Card heading, e.g. `The Forge Gym` |
| **Featured image** | Card image. **Leave empty to make it a map card** (Google Maps embed, like the HQ card) |
| Card Settings → **Tag** + **Tag icon** | Green pill — overlaid on the image, or above the heading on map cards (empty = hidden) |
| Card Settings → **Body copy** | Paragraph text |
| Card Settings → **CTA label** + **CTA icon** | The bottom button (empty label = no button) |
| Card Settings → **CTA action** | Link to a page (uses URL field) · Google Maps directions · open Enlist / Packages / Booking modal |
| Card Settings → **CTA link URL** | Used with "Link to a page" — `/training` or full URL |
| Card Settings → **Featured card** | Green gradient bg, green border + glow, green CTA |
| **Order** | Card sequence |

- The grid is 3-up on wide screens and flows to 1 column below 1080px — any
  number of cards works.
- Fallback: the original 3 cards (Movement / Facility / Headquarters).

### 4.3 Forge Pillars

**Where:** Dashboard → **Forge Pillars** → Add New Pillar.

| Field | Renders as |
|---|---|
| **Title** | Pillar name, e.g. `Movement` |
| Pillar Settings → **Icon** | Font Awesome class, e.g. `fa-dumbbell` |
| Pillar Settings → **Body copy** | Paragraph under the pillar name |
| **Order** | Pillar sequence |

The section header (eyebrow/title/subtitle) is in the Customizer (§5.3).
Fallback: Movement / Holistic Wellness / Brotherhood.

### 4.4 Pricing Tiers

**Where:** Dashboard → **Pricing Tiers** → Add New Tier.

| Field | Renders as |
|---|---|
| **Title** | Plan rank, e.g. `Platoons` |
| Tier Settings → **Group (tab)** | Puts the tier into the **Monthly Memberships** or **Drop-In Sessions** tab |
| Tier Settings → **Label above plan name** | `Open Gym · Monthly`, etc. |
| Tier Settings → **Price** / **Cadence** | `R 800` / `per month` |
| Tier Settings → **Description** | Short paragraph |
| Tier Settings → **Features** | One per line (each becomes a check-marked item) |
| Tier Settings → **Badge** | Top ribbon, e.g. `Most Popular` (optional) |
| Tier Settings → **Primary tier** | Green gradient card, green accents, green CTA |
| Tier Settings → **CTA label + action + URL** | Link to a page, or open Enlist / Packages / Booking modal |
| **Order** | Sequence within its tab |

- Monthly tab auto-sizes its grid; the Drop-In tab is a max-2-wide grid —
  both handle any number of tiers.
- Header text lives in the Customizer (§5.4).
- Fallback: all 5 original tiers (3 monthly + 2 drop-in). Remember the
  all-or-nothing rule: publish one tier and you own **both** tabs.

### 4.5 Testimonials

**Where:** Dashboard → **Testimonials** → Add New Testimonial.

| Field | Renders as |
|---|---|
| **Title** | Member name, e.g. `Kamva` |
| Testimonial Settings → **Initials** | Round avatar text. Empty = first letter of the name |
| Testimonial Settings → **Location** | Under the name, e.g. `Khayelitsha` |
| Testimonial Settings → **Quote** | The testimonial — quotation marks are added automatically, don't include your own |
| Testimonial Settings → **Result badge** | Green pill bottom-right, e.g. `Lost 10kg · Since 2020` (optional) |
| **Order** | Card sequence |

Header text in the Customizer (§5.5). Fallback: the 3 original testimonials.

---

## 5. Customizer sections (Appearance → Customize)

All theme sections sit in one place in the Customizer sidebar. Every field is
pre-filled with the original content — change only what you need.

### 5.1 Hero Slider

| Setting | Default |
|---|---|
| Autoplay interval (ms) | `6000` (minimum enforced: 2000) |

Slide content itself is managed under Dashboard → Hero Slides (§4.1).

### 5.2 Mission Section

| Field | Default |
|---|---|
| Eyebrow | `The Origin` |
| Heading | `We Built What We Couldn't Find` |
| Paragraph 1 / Paragraph 2 | Original story copy (empty paragraph is skipped) |
| **Value pills** | One per line as `fa-icon \| Label`, e.g. `fa-dumbbell \| Iron Discipline`. A line without `\|` = label only, no icon. Add/remove lines freely |
| Button label / Button link | `Read Our Story` → `/blog/iron-gorilla-origin-story` (site path or full URL; empty hides the button) |
| Image | Media library picker; empty = bundled `cover_2.jpg`. Portrait (4:5) works best |
| Image caption | `Salt River, Cape Town` |

### 5.3 Forge Section

Eyebrow / Heading / Subtitle (defaults: *What We Offer* / *Built on Three
Pillars* / original subtitle). The pillar cards are posts — §4.3.

### 5.4 Pricing Section

Eyebrow / Heading / Subtitle (defaults: *Membership* / *Choose Your Rank* /
original subtitle). The tiers are posts — §4.4.

### 5.5 Testimonials Section

Eyebrow / Heading / Subtitle (defaults: *What Members Say* / *The Brotherhood
Speaks* / original subtitle). The quotes are posts — §4.5.

### 5.6 Contact Section

| Field | Notes |
|---|---|
| Eyebrow / Heading / Subtitle | Defaults: *Dispatch* / *Establish Contact* / original subtitle |
| HQ location | Textarea — line breaks are kept on the front end |
| HQ email (displayed) | Validated; also used for the `mailto:` link |
| HQ phone | Displayed, auto-formatted `+27790614906 → 079 061 4906`; `tel:` link uses the raw number |
| **Form recipient email** | Where dispatch submissions are emailed. Blank = the site admin email (Settings → General) |

### 5.7 Instagram URL (Site Identity)

Under **Site Identity** in the Customizer — feeds the footer social icon.
Default: `https://www.instagram.com/irongorillaarmy`.

---

## 6. Stats bar

The four stats under the hero (`120+ Active Members`, etc.) are intentionally
**not** a dashboard UI — they change rarely and are edited in code with one
small filter. In `functions.php` (or a tiny custom plugin):

```php
add_filter( 'iga_stats', function ( $stats ) {
	$stats[0]['value'] = '150+';
	$stats[0]['label'] = 'Active Members';
	return $stats;
} );
```

Replace the whole array to fully customize (same `value`/`label` shape).

---

## 7. Footer

| Content | Where to edit |
|---|---|
| **Navigate** column | **Appearance → Menus** → assign a menu to the **Footer Navigation** location. Until one is assigned, the original 5 links render (The Forge, Armory, Legends, About, FAQ) |
| Logo | **Appearance → Customize → Site Identity → Logo** (custom logo support; else bundled `assets/img/logo.png`) |
| Get In column | "Enlist Now" opens the enlist modal; Book/Contact links are fixed in `footer.php` |
| Find Us (address + hours) | Static in `footer.php` |
| Legal links (Terms/Privacy/Refunds) | Fixed links to `/terms`, `/privacy`, `/refund` — point them at real pages as you create them |
| Social icon | Customizer → Site Identity → Instagram URL (§5.7) |
| Copyright year | Automatic (`date_i18n( 'Y' )`) |

Google Maps URLs used by the Distinction map card / directions CTA are
centralized in two filters (`iga_directions_url`, `iga_map_embed_url`) in
`inc/distinction-cards.php` — override there if the address ever changes.

---

## 8. Modals

One modal ships converted: **Enlist Now** (`template-parts/modal-enlist.php`,
rendered from `footer.php` so it's available on every page).

**The wiring contract — use it anywhere in any template:**

```html
<!-- Trigger -->
<button type="button" data-modal-open="enlist-modal">Enlist Now</button>

<!-- Modal element -->
<div data-modal="enlist-modal"> … <button data-modal-close>×</button> … </div>
```

`assets/js/modal.js` (event-delegated, no inline JS needed) handles open,
close button, backdrop click, **Escape**, and body scroll-lock. Many dashboard
CTA dropdowns already output these triggers (Distinction Cards, Pricing
Tiers).

> ⚠️ `packages-modal` and `booking-modal` triggers exist in CTA dropdowns but
> their template parts aren't built yet — those options stay inert until the
> Packages/Booking modals are converted. Use "Enlist Now modal" or links
> meanwhile.

---

## 9. Contact form (dispatch)

- Submits via classic POST to `admin-post.php` (action `iga_contact`) with a
  nonce — **works with JS disabled**.
- Emails via `wp_mail()` to the **Form recipient email** (§5.6; blank = site
  admin email), with the sender as `Reply-To`.
- Redirects back to `#contact`: `?iga-contact=sent` shows the *"Dispatch
  Received"* panel; `?iga-contact=error` keeps the form and shows the error
  line with a `mailto:` fallback.
- **Anti-spam:** built-in honeypot (hidden field) — bot submissions get a fake
  success and no email is sent.

> **Deliverability:** if messages don't arrive, install an SMTP plugin (e.g.
> *WP Mail SMTP*) pointed at the domain mailbox. The handler needs no changes.

---

## 10. Front-page layout

`front-page.php` renders, in order:

1. Hero slider
2. Stats bar
3. Distinction
4. Mission
5. Forge (Three Pillars)
6. Pricing (tabbed)
7. Testimonials
8. Contact
9. (Footer, from `get_footer()`)

To reorder/remove a section, move or delete its
`get_template_part( 'template-parts/…' )` line in `front-page.php`. To place a
section on another page template, use the same call — e.g.
`get_template_part( 'template-parts/Pricing' );`.

The Pricing part accepts per-placement overrides (its React props):

```php
get_template_part( 'template-parts/Pricing', null, [
	'eyebrow'    => 'Drop-In',
	'title'      => 'Book a Session',
	'forced_tab' => 'dropin', // 'monthly' | 'dropin'
] );
```

The shared `section-header` part accepts `eyebrow`, `title`, `subtitle`,
`align` (`center`|`left`), `max_width` (px) args — reuse it for new sections.

---

## 11. Developer reference

**Template-part data flow:** every module in `inc/` exposes a getter that the
template part calls. DB content → getter → defaults fallback → final filter →
template. Sane customization = use the filter, don't edit the template.

| Filter | Shape it returns |
|---|---|
| `iga_hero_slides` | `image, eyebrow, line_1, line_2, body` |
| `iga_distinction_cards` | `tag, tag_icon, title, body, image, image_alt, cta_label, cta_icon, cta_action, cta_href, featured` |
| `iga_mission` | `eyebrow, heading, paragraphs[], values[], story_label, story_href, image, image_alt, caption` |
| `iga_forge_pillars` / `iga_forge_header` | `icon, title, body` / `eyebrow, title, subtitle` |
| `iga_pricing_tiers` / `iga_pricing_header` | `monthly[]/dropin[]` tier arrays / header triple |
| `iga_testimonials` / `iga_testimonials_header` | `initials, name, location, quote, result` / header triple |
| `iga_contact_section` | `header[]` + `hq[]` (location, email, phone) |
| `iga_stats` | `value, label` |
| `iga_directions_url`, `iga_map_embed_url` | URL strings |

**JS hooks** (all event-delegated, site-wide):

- `data-modal-open="…"`, `data-modal="…"`, `data-modal-close` + `.is-open`
- `data-reveal` + `.is-revealed` (IntersectionObserver; `motion-reduce` safe)
- `[data-hero-slider]` with `[data-hero-slide]`, `[data-hero-prev/next]`,
  `[data-hero-dot]`, `[data-hero-progress(-fill)]`, `data-hero-interval`
- `[data-pricing-tabs]` with `[data-pricing-tab/panel/goto]` + `.is-active`

**Design tokens:** see `@theme` in `assets/css/input.css`
(`s1/s2/s3`, `green/green-l/green-d`, `amber`, `off`, `muted/muted-l`,
`line/line-strong`, `ink`, `font-display`, `animate-slide-progress`).

**Not converted yet:** `header.php`/nav (build it before launch — the original
site's `body { padding-top: 80px }` offset for the fixed header should be
added to `@layer base` at the same time), packages/booking modals, events
carousel, FAQ, armory/blog pages, WhatsApp float.

---

## 12. Troubleshooting

| Symptom | Fix |
|---|---|
| Whole page renders **white/unstyled** | Build the CSS (§2) and hard-refresh (Ctrl/Cmd+Shift+R). The dark background lives in compiled `main.css` |
| Style/class edits don't show | Rebuild the CSS — class names are compiled from PHP into `main.css` |
| My new slide/tier/card doesn't appear | Check it's **Published** (not draft), and remember the all-or-nothing rule (§3) |
| Hero slide missing but others show | That slide has no featured image — image-less slides are skipped |
| A Distinction card shows a map instead of its image | It has no featured image — empty image = map card by design |
| Contact form "Dispatch Received" but no email arrives | Server mail issue — add an SMTP plugin (§9) |
| A CTA button does nothing | Its action points at `packages-modal`/`booking-modal` — not built yet (§8); switch to Enlist modal or a link |
| 80px gap expectation / header missing | `header.php` isn't converted yet (§11) |
| Dashboard changes to a header don't show | Those fields are in the **Customizer**, not the post menus (§5) |

---

## 13. File map

```
iga-theme/
├── style.css                      # Theme header only (all styles are compiled Tailwind)
├── index.php                      # Fallback template
├── front-page.php                 # Section order for the home page
├── functions.php                  # Setup, enqueues, menus, Instagram setting; loads inc/
├── footer.php                     # Footer + renders the enlist modal
├── README.md                      # ← you are here
├── inc/                           # One module per content area; never edit templates to change content
│   ├── hero-slides.php
│   ├── distinction-cards.php      # + directions/map URL filters
│   ├── mission.php                # Customizer-only module
│   ├── forge-pillars.php
│   ├── pricing-tiers.php
│   ├── testimonials.php
│   └── contact-section.php        # + admin-post form handler (wp_mail)
├── template-parts/
│   ├── hero.php                   # data-hero-slider
│   ├── statsBar.php
│   ├── Distinction.php
│   ├── Mission.php
│   ├── Forge.php
│   ├── Pricing.php                # data-pricing-tabs; supports forced_tab arg
│   ├── pricing-card.php           # sub-part (per-tier markup)
│   ├── section-header.php         # shared: eyebrow/title/subtitle
│   ├── Testimonials.php
│   ├── Contact.php                # dispatch form, ?iga-contact states
│   └── modal-enlist.php           # data-modal="enlist-modal"
└── assets/
    ├── css/
    │   ├── input.css              # Tailwind source: @theme tokens + base layer
    │   └── main.css               # COMPILED output (do not edit by hand)
    ├── img/                       # Bundled demo images for the defaults
    └── js/
        ├── hero-slider.js         # autoplay/pause/swipe/dots/progress
        ├── reveal.js              # scroll reveals
        ├── modal.js               # modal open/close
        └── pricing-tabs.js        # pricing tab toggle
```

**Handing over to the client:** give them this README and point them at §3–§9.
Everything they can break is guarded: empty fields hide elements, image-less
slides/cards degrade gracefully, and the original content always renders
underneath.
