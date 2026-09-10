# Cilla Skyn Editorial Grid Block

A grid of article/journal teaser tiles (image, tag, title, excerpt, link), reusable anywhere in the block editor. Built for **The Edit** page.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Eyebrow** | Text | No | Small uppercase label above the heading. Default: "The Edit". |
| **Heading** | Text | No | Default: "Stories, Rituals & Skin Wisdom". |
| **Intro** | Textarea | No | Centered supporting paragraph. |
| **Articles** | Repeater | No | One tile per article: **Image**, **Tag**, **Title**, **Excerpt**, **URL**. |

### Articles row sub-fields

| Field | Type | Description |
|---|---|---|
| **Image** | Image | Falls back to a plain colour swatch when empty. |
| **Tag** | Text | Small category label, e.g. "Rituals". |
| **Title** | Text | |
| **Excerpt** | Textarea | 1–2 sentence teaser. |
| **URL** | URL | Leave empty until the article exists — the tile renders without a "Read More" link rather than a dead one. |

## Notes

- **There's no blog/journal post type in this theme.** Each tile is a manually-entered Repeater row, not a query of real WordPress posts — this keeps the block usable immediately, but means adding an article means adding both the article's own page/post *and* a matching row here. If The Edit grows into a real, frequently-updated journal, consider having someone set up a proper CPT/archive query instead of hand-maintaining rows.
- **Ships with 3 example teasers** (`inc/block-defaults/cilla-skyn-editorial-grid.php`) — generic, illustrative titles written for this block, not real articles (there's no journal content in `NewProject/Cilla Skyn Website Layout.docx`). None have a URL set, so they render as non-clickable placeholders until real content exists. **Replace with real articles before launch.**
- Grid is 3 → 2 → 1 columns at the theme's standard breakpoints, image tiles are 4:3.
