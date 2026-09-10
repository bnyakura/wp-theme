# Cilla Skyn Content Sections Block

A generic narrow-column policy/info page block, reusable anywhere in the block editor: eyebrow, heading, intro paragraph and a Repeater of titled sections. Built for pages that have no design mockup of their own — **Shipping & Delivery** and **Returns & Exchanges** — but works for any similar text-heavy page.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Eyebrow** | Text | No | Small uppercase label above the heading, e.g. "Help". |
| **Heading** | Text | No | Page heading, rendered as an `<h1>`. |
| **Intro** | Textarea | No | Short supporting paragraph under the heading. |
| **Sections** | Repeater | No | One row per subsection: **Title**, **Body**. |

### Sections row sub-fields

| Field | Type | Description |
|---|---|---|
| **Title** | Text | Subsection heading, e.g. "Delivery Times". |
| **Body** | Textarea | Plain text. Leave a blank line between paragraphs — each becomes its own `<p>`; a single line break within a paragraph renders as `<br>`. |

## Notes

- **Ships with example Shipping & Delivery copy** (`inc/block-defaults/cilla-skyn-content-sections.php`) — this is placeholder content written for this block, not something the client supplied (there's no shipping/returns policy in `NewProject/Cilla Skyn Website Layout.docx`). **Review and replace with the real policy before launch.**
- To build a **Returns & Exchanges** page, add a second instance of this block and replace Heading/Intro/Sections with the real returns policy — there's no separate "Returns" block, this one is meant to be reused.
- Body text is plain text, not rich text (no bold/links) — matches every other block in this theme (none use ACF's WYSIWYG field type). If a policy needs a link, consider linking from the Eyebrow/heading area or a nearby block instead.
