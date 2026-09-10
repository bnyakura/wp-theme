# Cilla Skyn Our Story Block

Narrow-column founder-story section for the About page, sourced from the "Our Story — A Name Rooted in Love & Legacy" copy in `NewProject/Cilla Skyn Website Layout.docx`'s About Us section. Meant to sit below [About Hero](../cilla-skyn-about-hero/README.md) and above [Formulation Approach](../cilla-skyn-formulation-approach/README.md) on the About page.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Eyebrow** | Text | No | Small uppercase label above the heading. Default: "Our Story". |
| **Heading** | Text | No | Main serif headline. Default: "A Name Rooted in Love & Legacy". |
| **Paragraphs** | Repeater | No | One row per paragraph, rendered in order. Ships with the 5 paragraphs from the source document. |
| **Pronunciation Note** | Text | No | Small italic line, e.g. "CILLA SKYN™ is pronounced SILL-UH SKIN." |
| **Closing Line** | Textarea | No | Small uppercase closing line under a short rule. One line break renders as `<br>`. |

## Notes

- Paragraphs use a Repeater (one row = one paragraph) rather than a single long Textarea, so the client can add/remove/reorder paragraphs from the block editor without fighting blank-line formatting.
- Default paragraph rows live in `inc/block-defaults/cilla-skyn-our-story.php` (ACF Repeater fields don't support `default_value`, see the main theme README §4/§11).
- No image field — the source document doesn't include one for this section; add an image block above/below in the editor if the client wants a founder photo.
