# Homepage – Mission Block

Two-column mission/origin story section with text on the left and a portrait image on the right.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Eyebrow** | Text | No | Small label above heading (e.g. "The Origin") |
| **Heading** | Text | Yes | Main section heading |
| **Paragraphs** | Repeater | No | Story paragraphs |
| — Paragraph | Textarea | No | One paragraph of text |
| **Values** | Repeater | No | Pill badges (icon + label) |
| — Icon | Text | No | Font Awesome class (e.g. `fa-dumbbell`) |
| — Label | Text | No | Pill label text |
| **Story Label** | Text | No | Link button text (e.g. "Read Our Story") |
| **Story URL** | URL | No | Story link destination |
| **Image** | Image | No | Portrait/featured image |
| **Caption** | Text | No | Image caption overlay |

## Layout

- **Mobile:** stacked single column
- **Desktop (769px+):** 2-column grid with 4:5 aspect ratio image
