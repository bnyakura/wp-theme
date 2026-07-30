# Testimonials Block

Responsive grid of member testimonial cards with quotes, initials, names, locations, and result badges.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Eyebrow** | Text | No | Small label above heading |
| **Title** | Text | Yes | Section heading (e.g. "The Brotherhood Speaks") |
| **Subtitle** | Textarea | No | Supporting text below heading |
| **Testimonials** | Repeater | Yes | Add each testimonial card |
| — Initials | Text | Yes | Avatar initials (e.g. "KV") |
| — Name | Text | Yes | Member name |
| — Location | Text | No | Member location |
| — Quote | Textarea | Yes | Testimonial text |
| — Result | Text | No | Green result badge (e.g. "-12kg") |

## Layout

Responsive grid: 1 col on mobile, 2 on tablet (481px+), 1 on small desktop (768px+), 3 on large (1081px+). Cards have a staggered scroll-reveal (i × 100ms delay).
