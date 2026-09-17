# Cilla Skyn Ingredients Block

A centered ingredient index rendered as an accordion list, reusable anywhere in the block editor. Follows the layout of [Yearn Skin's Ingredient Library](https://www.yearnskin.co.za/pages/ingredient-library) — a list of collapsed rows, one per ingredient, expanding to its Description, Benefits, Best For and Find It In copy, plus an optional link. Uses the same no-JS `<details>`/`<summary>` idiom as the [FAQ](../cilla-skyn-faq/README.md) block instead of a card grid with photography, since this design has no images at all.

The row's field shape (Description / Benefits / Best For / Find It In) mirrors the "Featured Hero Ingredients" card structure in `Hero Ingredients.xlsx` so that document's copy drops in directly — see the block-defaults file for a worked example.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Background** | Select (Cream / Cream Dark) | No | Default: Cream. Alternate this with neighbouring sections (Cream → Cream Dark → Cream…) for the same banded page rhythm as the About page — e.g. [General Information](../cilla-skyn-general-information/README.md) sits on Cream Dark between two Cream sections. |
| **Eyebrow** | Text | No | Small uppercase label above the heading. Default: "Our Ingredients". |
| **Heading** | Text | No | Default: "Key Ingredients". |
| **Intro** | Textarea | No | Centered supporting line under the heading. |
| **Ingredients** | Repeater | No | One accordion row per ingredient — see below. |

### Ingredients row sub-fields

| Field | Type | Description |
|---|---|---|
| **Name** | Text | Ingredient name, e.g. "Niacinamide". Shown in the closed row; the only sub-field that needs a value for a row to render at all. |
| **Description** | Textarea | What it is, in a sentence or two. Omitted when empty. |
| **Benefits** | Textarea | One short benefit per line, e.g. "Barrier Support". Renders as a dash-bulleted list; omitted entirely when empty. |
| **Best For** | Text | Skin types/concerns, e.g. "Dry • Sensitive • Barrier-Compromised Skin". Omitted when empty. |
| **Find It In** | Text | Product names this ingredient appears in, comma-separated, e.g. "Ceramide Cocoon, Cera-Ectoin Barrier Balance Mist". Plain text, not linked per-product — pair with Link URL below for a single clickable destination. Omitted when empty. |
| **Link Label / URL** | Text / URL | Optional link at the bottom of the expanded content (e.g. to a matching product page). Only renders when URL is set; defaults to "Learn More" if Label is left blank. |

## Notes

- **Every field is optional and every part of a row degrades independently** — no Description, Benefits, Best For, Find It In or link all just omit that line instead of leaving a broken-looking gap. A row with only a Name still renders as a plain, unexpandable heading. An entirely empty block renders nothing but its own section padding.
- Rows use `<details>`/`<summary>` — no JavaScript, keyboard- and screen-reader-accessible by default, same pattern as the FAQ block and the site header's search dropdown.
- **Ships with 6 example ingredients** (`inc/block-defaults/cilla-skyn-ingredients.php`) — real copy from `Hero Ingredients.xlsx`'s A–Z library, not placeholder text.
