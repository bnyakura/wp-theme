# League Page Block

League of Legends honour roll page: coming-soon banner, hero, and bank transfer card. Falls back to the original Iron Gorilla content when fields are left empty.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Banner Text** | Text | No | Coming-soon banner copy at the top of the page |
| **Hero Eyebrow** | Text | No | Small label above the heading (e.g. "Honour Roll") |
| **Hero Title Line 1** | Text | No | First heading line (e.g. "League of") |
| **Hero Title Accent** | Text | No | Accent-coloured heading line (e.g. "Legends") |
| **Hero Subtitle** | Textarea | No | Intro paragraph |
| **Bank Label** | Text | No | Small label on the bank card (e.g. "Bank Transfer") |
| **Bank Name** | Text | No | Account holder name shown on the card |
| **Bank Reference Note** | Text | No | Reference format to use for transfers |
| **Bank Footnote** | Text | No | Text before the contact link (e.g. "Bank details shared on request —") |
| **Bank Contact Link Label** | Text | No | Link text (e.g. "reach out here") |

## Notes

- The contact link always points to `/contact/?subject=league-of-legends`.
- No online store or full league page yet — this is a coming-soon placeholder with a manual bank-transfer flow.
