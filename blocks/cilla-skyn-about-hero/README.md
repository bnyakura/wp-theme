# Cilla Skyn About Hero Block

Centered brand-statement intro, meant for the top of the About page. Sourced from the "Hero Statement" copy in `NewProject/Cilla Skyn Website Layout.docx`'s About Us section (this section isn't in the homepage mockup — it's the first block on the About page, above [Our Story](../cilla-skyn-our-story/README.md)).

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Eyebrow** | Text | No | Small uppercase label above the heading. Default: "About Cilla Skyn". |
| **Heading** | Text | No | Main serif headline. Default: "Skincare with Purpose". |
| **Intro** | Textarea | No | First, short brand-statement paragraph. |
| **Description** | Textarea | No | Second, supporting paragraph. |
| **Tagline** | Text | No | Small uppercase closing line, flanked by rules, e.g. "Thoughtfully formulated. Purposefully layered. Inspired by nature." |

## Notes

- No image — this block is copy-only by design, matching the source document (the visual interest on the About page comes from [Our Story](../cilla-skyn-our-story/README.md) and [Formulation Approach](../cilla-skyn-formulation-approach/README.md) below it).
- All fields fall back to the docx's original copy via `default_value` in `acf-json/group_cilla_skyn_about_hero.json` — an empty field never leaves the section blank.
