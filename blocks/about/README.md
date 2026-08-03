# About Block

Full About page: hero, origin story, core values, brotherhood image, coaches grid, testimonials, and final CTA. Falls back to the original Iron Gorilla content when fields are left empty.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Hero Eyebrow** | Text | No | Small label above hero heading (e.g. "Our Story") |
| **Hero Title** | Text | No | Main hero heading |
| **Hero Subtitle** | Textarea | No | Hero intro paragraph |
| **Origin Eyebrow** | Text | No | Small label above origin heading (e.g. "The Origin") |
| **Origin Title** | Text | No | Origin section heading |
| **Origin Paragraphs** | Repeater | No | Origin story paragraphs |
| — Paragraph | Textarea | No | One paragraph of text |
| **Origin Image** | Image | No | Gym interior photo (falls back to placeholder) |
| **Values** | Repeater | No | Core value cards |
| — Icon | Select | No | `dumbbell`, `heart` or `users` |
| — Title | Text | No | Value name (e.g. "Iron Discipline") |
| — Description | Textarea | No | Value description |
| **Brotherhood Eyebrow** | Text | No | Small label above values heading |
| **Brotherhood Title** | Text | No | Values section heading |
| **Brotherhood Subtitle** | Textarea | No | Optional values intro |
| **Brotherhood Image** | Image | No | Group shot (falls back to placeholder) |
| **Coaches** | Repeater | No | Team member cards |
| — Initials | Text | No | Avatar initials (e.g. "PA") |
| — Name | Text | Yes | Coach name |
| — Role | Text | No | Role / specialism badge |
| — Bio | Textarea | No | Short bio |
| — Image | Image | No | Coach photo (falls back to initials) |
| — Object Position | Text | No | CSS `object-position` (e.g. `center 22%`) |
| **Testimonials** | Repeater | No | Member quotes |
| — Initials | Text | No | Avatar initials |
| — Name | Text | No | Member name |
| — Location | Text | No | Suburb / area |
| — Quote | Textarea | Yes | Testimonial text |
| — Result | Text | No | Result badge (e.g. "Lost 10kg · Since 2020") |
| **CTA Title** | Text | No | Final call-to-action heading |
| **CTA Subtitle** | Textarea | No | Final call-to-action intro |

## Layout

- **Hero:** centered full-width band
- **Values:** 1 col mobile, 2 cols tablet, 3 cols desktop
- **Coaches:** 1 col mobile, 2 cols tablet, 3 cols desktop with portrait image
- **Testimonials:** 1 col mobile, 3 cols desktop

## Notes

- Coach/hero images default to `/assets/images/coaches/coach-{rhema,othniel,bongi}.jpg` or a placeholder until files are added.
- Image fields accept either an ACF image ID (converted via `wp_get_attachment_image_url()`) or a raw URL.
