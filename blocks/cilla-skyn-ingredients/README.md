# Cilla Skyn Ingredients Block

A grid of hero-ingredient cards (photo, name, description), reusable anywhere in the block editor. Built for the **Our Ingredients** page.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Eyebrow** | Text | No | Small uppercase label above the heading. Default: "Our Ingredients". |
| **Heading** | Text | No | Default: "Nature, Refined by Science". |
| **Intro** | Textarea | No | Centered supporting paragraph. |
| **Ingredients** | Repeater | No | One card per ingredient: **Image**, **Name**, **Description**. |

### Ingredients row sub-fields

| Field | Type | Description |
|---|---|---|
| **Image** | Image | Falls back to a plain colour swatch when empty — no dependency on a stock photo library. |
| **Name** | Text | Ingredient name, e.g. "Bakuchiol". |
| **Description** | Textarea | 1–2 sentences on what it does. |

## Notes

- Grid is 3 → 2 → 1 columns at the theme's standard breakpoints.
- **Ships with 6 example ingredients** (`inc/block-defaults/cilla-skyn-ingredients.php`) — these picks and descriptions were written for this block, not supplied by the client. `NewProject/Cilla Skyn Website Layout.docx` only mentions ingredients as part of product names (e.g. "Bakuchi Renewal Facial Oil", "Pure Rosehip Oil"), with no standalone ingredient copy. **Review the selection and descriptions — and add real photography — before launch.**
