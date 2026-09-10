# Cilla Skyn Formulation Approach Block

Narrow-column formulation-philosophy section for the About page, sourced from the "Our Formulation Approach — Every Ingredient Should Have a Purpose" copy in `NewProject/Cilla Skyn Website Layout.docx`'s About Us section. Meant to sit below [Our Story](../cilla-skyn-our-story/README.md) as the last block on the About page.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Eyebrow** | Text | No | Small uppercase label above the heading. Default: "Our Formulation Approach". |
| **Heading** | Text | No | Main serif headline. Default: "Every Ingredient Should Have a Purpose". |
| **Paragraphs** | Repeater | No | One row per paragraph, rendered in order. Ships with the 6 paragraphs from the source document. |
| **Principles** | Repeater | No | Short three-line strip under the paragraphs, one **Label** per row. Ships with "Support the barrier.", "Target with intention.", "Formulate with purpose." |

## Notes

- Both Repeaters follow the same "one row = one line" pattern as [Our Story](../cilla-skyn-our-story/README.md)'s Paragraphs field, so the client can add/remove/reorder without fighting blank-line formatting.
- Default rows for both Repeaters live in `inc/block-defaults/cilla-skyn-formulation-approach.php` (ACF Repeater fields don't support `default_value`, see the main theme README §4/§11).
- Principles render as a plain 3-column text strip (no icons) — deliberately simpler than the [Feature Strip](../cilla-skyn-feature-strip/README.md) block, since the source document presents these as three short closing lines rather than icon badges.
