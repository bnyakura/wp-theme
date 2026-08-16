# Armory Page Block

Full-width armory hero with a background video, heading, CTA buttons, and a "coming soon" badge. Falls back to the original Iron Gorilla content when fields are left empty.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Hero Eyebrow** | Text | No | Small label above the heading (e.g. "The Armory") |
| **Hero Title Line 1** | Text | No | First heading line (e.g. "Gear For") |
| **Hero Title Accent** | Text | No | Accent-coloured heading line (e.g. "The Grind") |
| **Hero Subtitle** | Textarea | No | Intro paragraph |
| **Hero Poster** | Image | No | Poster image shown while the video loads (defaults to `assets/images/forge-gym.png`) |
| **Hero Video** | File | No | Background MP4 (defaults to `assets/videos/iga-apparel.mp4`) |
| **Early Access Label** | Text | No | Primary CTA text (links to contact with `?subject=armory-early-access`) |
| **Memberships Label** | Text | No | Secondary CTA text (links to `/training/#pricing`) |
| **Coming Soon Label** | Text | No | Amber badge text |

## Layout

- **Mobile:** 560px min-height hero
- **Desktop (1024px+):** 90vh hero with left-aligned content over the background video

## Notes

- The poster and video fall back to theme assets unless the filter `iga_armory_media` is used or the fields are set.
- Image fields accept either an ACF image ID (converted via `wp_get_attachment_image_url()`) or a raw URL.
