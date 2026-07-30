# Forge Block

Three-pillar section with icon cards, a section header, and bottom call-to-action buttons.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Eyebrow** | Text | No | Small label above heading (e.g. "What We Offer") |
| **Title** | Text | Yes | Section heading (e.g. "Built on Three Pillars") |
| **Subtitle** | Textarea | No | Supporting text below the heading |
| **Pillars** | Repeater | Yes | Add each pillar card |
| — Icon | Text | No | Font Awesome class (e.g. `fa-dumbbell`) |
| — Title | Text | Yes | Pillar card heading |
| — Body | Textarea | Yes | Pillar card description |
| **Primary CTA Label** | Text | No | Green button text (default: "Enlist Now") |
| **Primary CTA Action** | Select | No | Modal name or "link" |
| **Secondary CTA Label** | Text | No | Outline button text (default: "Explore Programs") |
| **Secondary CTA URL** | URL | No | Outline button destination |

## Behaviour

- Cards have a staggered scroll-reveal animation (i × 100ms delay)
- Each card has a green bottom-border animation on hover
- Primary CTA opens a modal (via `data-modal-open`) by default
