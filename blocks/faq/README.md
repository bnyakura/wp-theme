# FAQ Page Block

Full FAQ page: hero, categorised questions, testimonials, and final CTA. Falls back to the original Iron Gorilla content when fields are left empty.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Hero Eyebrow** | Text | No | Small label above the heading (e.g. "Questions") |
| **Hero Title** | Text | No | Main heading |
| **Hero Subtitle** | Textarea | No | Intro paragraph |
| **Categories** | Repeater | No | FAQ category groups |
| — Category | Text | Yes | Category name (e.g. "Getting Started") |
| — Icon | Select | No | `door`, `dumbbell`, `medal`, `location` or `heart` |
| — FAQs | Repeater | No | Questions within the category |
| —— Question | Text | Yes | The question |
| —— Answer | Textarea | No | The answer |
| **Testimonials Eyebrow** | Text | No | Small label above the testimonials heading |
| **Testimonials Title** | Text | No | Testimonials section heading |
| **Testimonials Subtitle** | Textarea | No | Testimonials intro |
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
- **Categories:** single column, accordion-style `<details>` per question
- **Testimonials:** 1 col mobile, 3 cols desktop

## Notes

- A category is skipped entirely if it has no questions with text.
- Adding any row to Categories replaces the full default question set for that block instance.
