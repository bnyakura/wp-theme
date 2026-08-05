# Training Block

Full Training page: hero, three pillars, training tracks, weekly schedule, testimonials, monthly/drop-in pricing tabs, coaches, onboarding steps, and final CTA. Falls back to the original Iron Gorilla content when fields are left empty.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Hero Eyebrow** | Text | No | Small label above the heading |
| **Hero Title Line 1** | Text | No | First heading line (e.g. "Forge Unbreakable") |
| **Hero Title Accent** | Text | No | Accent-coloured middle line (e.g. "Strength & Discipline") |
| **Hero Title Line 2** | Text | No | Third heading line (e.g. "Without the Chaos") |
| **Hero Subtitle** | Textarea | No | Hero intro paragraph |
| **Hero Location** | Text | No | Address line shown under the hero CTAs and in the final CTA |
| **Hero Image** | Image | No | Hero background photo (falls back to `forge-gym.png`) |
| **Pillars** | Repeater | No | "Built on Three Pillars" cards |
| — Icon | Select | No | `dumbbell`, `heart` or `users` |
| — Title | Text | Yes | Pillar name |
| — Description | Textarea | No | Pillar description |
| — Items | Textarea | No | One bullet per line |
| **Tracks** | Repeater | No | "Training Tracks" rows |
| — Number | Text | No | Row number (auto-generated if empty) |
| — Tier | Text | No | Small label (e.g. "Squads Tier") |
| — Title | Text | Yes | Track name |
| — Description | Textarea | No | Track description |
| — Plan Label | Text | No | Pricing chip text (e.g. "Platoons · R800/mo — See plan") |
| — Tab | Select | No | Pricing tab the chip scrolls to: `monthly` or `dropin` |
| — Icon | Select | No | `users`, `shield` or `run` |
| — Reverse Layout | True/False | No | Mirror the image/text columns |
| — Primary Label | Text | No | Primary button text |
| — Primary URL | Text | No | Primary button destination (defaults to `/book/`) |
| — Secondary Label | Text | No | Secondary button text (hidden if empty) |
| **Schedule** | Repeater | No | Weekly timetable rows |
| — Day | Text | Yes | Day name |
| — Classes | Textarea | No | One class time per line |
| **Testimonials** | Repeater | No | Member quotes |
| — Initials / Name / Location / Quote / Result | Text/Textarea | Quote required | Same shape as other blocks |
| **Monthly Plans** | Repeater | No | Pricing cards under the "Monthly Memberships" tab |
| — Rank / Subtitle / Price / Cadence / Description | Text/Textarea | Rank required | Card header and copy |
| — Features | Textarea | No | One feature per line |
| — CTA Label / URL | Text | No | Button text and destination (defaults to `/contact/`) |
| — Primary | True/False | No | Highlight with the green gradient card style |
| — Badge | Text | No | Ribbon text (e.g. "Most Popular") |
| **Drop-In Plans** | Repeater | No | Same shape as Monthly Plans, defaults CTA URL to `/book/` |
| **Coaches** | Repeater | No | Team member cards |
| — Initials / Name / Role / Bio / Image / Object Position | Text/Textarea/Image | Name required | Same shape as the About block |
| **Steps** | Repeater | No | "Your Path Into The Brotherhood" steps |
| — Number / Icon / Title / Description | Text/Select/Textarea | Title required | `clipboard`, `fire` or `users` icons |
| **CTA Eyebrow** | Text | No | Final call-to-action label (e.g. "Ready?") |
| **CTA Title** | Text | No | Final call-to-action heading |
| **CTA Subtitle** | Textarea | No | Final call-to-action intro |

## Layout

- **Hero:** full-bleed image with gradient overlay
- **Pillars:** 1 col mobile, 2 cols tablet, 3 cols desktop
- **Tracks:** alternating image/text rows, full width
- **Pricing:** tabbed monthly/drop-in cards, scoped to this block instance
- **Coaches:** 1–2 cols mobile/tablet, up to 5 cols desktop

## Notes

- The pricing tab toggle script is scoped to each block instance (via a generated wrapper id), so multiple Training blocks on one page won't interfere with each other.
- Coach/hero images default to `/assets/images/coaches/coach-{rhema,othniel,bongi}.jpg` and `/assets/images/forge-gym.png` until replaced.
- Each repeater is all-or-nothing: adding a single row replaces the entire default list for that section.
