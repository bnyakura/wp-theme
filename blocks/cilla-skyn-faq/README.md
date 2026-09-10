# Cilla Skyn FAQ Block

A no-JS accordion of frequently asked questions, reusable anywhere in the block editor. Built for the **FAQs** page.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Heading** | Text | No | Page heading, rendered as an `<h1>`. |
| **Subheading** | Textarea | No | Supporting text under the heading. |
| **FAQs** | Repeater | No | One row per question: **Question**, **Answer**. |

## Notes

- Each row renders as a native `<details>`/`<summary>` — no JavaScript, expands/collapses natively in every browser, and is keyboard/screen-reader accessible out of the box. This is the same no-JS pattern `header.php` already uses for its search dropdown.
- Multiple answers can be open at once (they're independent `<details>` elements, not grouped/exclusive) — matches how most FAQ pages behave.
- **Ships with example questions** (`inc/block-defaults/cilla-skyn-faq.php`) — these are placeholder content written for this block, not something the client supplied (FAQs weren't part of the source design brief). **Review and replace with real questions before launch.**
