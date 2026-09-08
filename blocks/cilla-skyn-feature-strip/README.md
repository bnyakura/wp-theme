# Cilla Skyn Feature Strip Block

A row of icon + text trust badges, reusable anywhere in the block editor. Ported from `NewProject/cilla-skyn-homepage.html`'s feature strip section.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Features** | Repeater | No | One row per badge: **Icon** (select: Leaf, Drop, Shield, Wave), **Title**, **Description**. |

## Notes

- Icons are a small fixed set of inline SVGs baked into `render.php` (matching the mockup's hand-drawn icon set), selected per row rather than uploaded — keeps the strip lightweight with no image requests.
- Grid is 4 columns on desktop, 2 on mobile, matching the mockup exactly.
