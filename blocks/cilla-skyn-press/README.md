# Cilla Skyn Press Block

An "As Seen In" publication logo strip plus press quote mentions, reusable anywhere in the block editor. Built for the **Press** page.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Eyebrow** | Text | No | Small uppercase label above the heading. Default: "Press". |
| **Heading** | Text | No | Default: "As Seen In". |
| **Intro** | Textarea | No | Centered supporting paragraph. |
| **Logos** | Repeater | No | "As Seen In" logo strip: **Logo** image, **Publication Name**, **URL**. |
| **Mentions** | Repeater | No | Quote cards below the logo strip: **Quote**, **Publication**, **URL**. |
| **Empty State Text** | Text | No | Shown only while both Logos and Mentions are empty, so the page never looks broken before the first press placement is secured. |

## Notes

- **This block ships with no default logos or mentions — on purpose.** Every other block in this theme ships with realistic-looking placeholder content because that content is either the client's real copy or an obviously-generic marketing line. A press logo or quote is different: it's a factual claim that a specific, real publication featured Cilla Skyn. Inventing one — even labelled as an "example" — risks it going live by accident and misleading visitors. **Only add a row here once a placement is real and confirmed.**
- Until then, the block shows the **Empty State Text** instead, so the Press page still looks intentional rather than broken.
- Logos render at reduced opacity/grayscale, brightening on hover — a common "as seen in" treatment. Logo images should be roughly the same visual weight/height for a clean row; the block doesn't normalize aspect ratios for you.
