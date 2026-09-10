# Cilla Skyn Pillars Block

A grid of larger icon + title + description commitment cards, reusable anywhere in the block editor. Built for the **Sustainability** page — distinct from the [Feature Strip](../cilla-skyn-feature-strip/README.md) block, which is a thin row of small trust badges; this one carries real paragraph copy per item.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Eyebrow** | Text | No | Small uppercase label above the heading. Default: "Sustainability". |
| **Heading** | Text | No | Default: "Skincare With a Conscience". |
| **Intro** | Textarea | No | Centered supporting paragraph. |
| **Pillars** | Repeater | No | One card per commitment: **Icon**, **Title**, **Description**. |

### Pillars row sub-fields

| Field | Type | Description |
|---|---|---|
| **Icon** | Select (Leaf, Recycle, Heart, Shield, Drop) | Picks one of 5 inline SVG icons baked into `render.php`. |
| **Title** | Text | Short commitment name, e.g. "Thoughtful Sourcing". |
| **Description** | Textarea | 1–2 sentences. |

## Notes

- Grid is 4 → 2 → 1 columns at the theme's standard breakpoints.
- **⚠️ The 4 default pillars are intentionally vague placeholder text** (`inc/block-defaults/cilla-skyn-pillars.php`) — sustainability wasn't part of `NewProject/Cilla Skyn Website Layout.docx`, so nothing here was supplied or verified by the client. The defaults deliberately avoid concrete, regulated claims like "cruelty-free," "recyclable," "carbon neutral" or "vegan" — those are specific factual claims that need to be true and verifiable before publishing (making an unsubstantiated sustainability claim can create real legal/reputational risk). **Do not publish this block without replacing its content with commitments the client has actually confirmed.**
