# Cilla Skyn Follow Along Block

An Instagram-style tile grid, reusable anywhere in the block editor. Ported from `NewProject/cilla-skyn-homepage.html`'s "Follow Along" section.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Heading** | Text | No | Default: "Follow Along". |
| **Handle** | Text | No | Displayed under the heading, e.g. "@cillaskyn". |
| **CTA Label / URL** | Text / URL | No | Top-right link, e.g. "Follow us on Instagram". |
| **Tiles** | Repeater | No | One tile per row — see below. |

### Tile sub-fields

| Field | Type | Description |
|---|---|---|
| **Type** | Select | `Caption` (colour block + short caption) or `Quote` (centred italic quote). |
| **Color** | Text | Hex background colour. |
| **Caption** | Textarea | Shown for `Caption` tiles. One line break renders as `<br>`. |
| **Quote** / **Attribution** | Textarea / Text | Shown for `Quote` tiles. |
| **Show Instagram Icon** | True/False | Shown for `Caption` tiles only. |

## Notes

- No real Instagram API integration — this is a manually curated flat-colour tile grid, matching the mockup exactly (no image uploads required).
- Grid is 6 columns on desktop, 2 on mobile.
