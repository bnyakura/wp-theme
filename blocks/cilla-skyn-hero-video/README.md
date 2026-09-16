# Cilla Skyn Hero Video Block

Full-bleed cream hero banner, same shell as the [Cilla Skyn Hero](../cilla-skyn-hero/README.md) block but with a looping background video instead of a responsive image. Brand-prefixed so it stays distinct from core/other plugin cover blocks in the inserter.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Background Video (Desktop)** | File (mp4/webm/mov) | No | Looping, muted background video. Used at 768px and wider, and as the fallback below that if Background Video (Mobile) is empty. |
| **Background Video (Mobile)** | File (mp4/webm/mov) | No | Optional lighter/shorter file for under 768px wide, so phones aren't served the full desktop video. Leave empty to fall through to Desktop. |
| **Poster / Fallback Image** | Image | No | Shown while the video loads (`<video poster>`), and rendered as a static background instead if no video is set at all. Leave empty and nothing renders until the video is ready — there's no placeholder image. |
| **Video Fit** | Select | No | CSS `object-fit` for the video/poster. Default: Cover. |
| **Video Position** | Select | No | CSS `object-position` for the video/poster. Default: Center. |
| **Background Overlay Style** | Select (Gradient / Solid Colour / None) | No | What sits over the video to keep the text readable. Default: Gradient. |
| **Overlay Color** | Color picker (with opacity) | No | Used when Background Overlay Style is "Solid Colour". |
| **Gradient Start / End Colour** | Color picker (with opacity) | No | Used when Background Overlay Style is "Gradient". |
| **Gradient Direction** | Select | No | Used when Background Overlay Style is "Gradient". |
| **Heading** | Text | No | Main serif headline. |
| **Text Color** | Color picker | No | Colour of the heading, footer note, and side list — pick a light colour for a dark video, dark for a light video. |
| **Text & Button Alignment** | Select (Left / Center / Right) | No | Horizontal alignment of the heading, button, and footer note within their column. |
| **Button Label / URL** | Text / URL | No | Solid dark button. |
| **Footer Note** | Text | No | Small uppercase line under the button. |
| **Side Items** | Repeater (Label) | No | Vertical uppercase label list on the right, desktop only. |

## Differences from Cilla Skyn Hero

- **Background is video, not image**: no Laptop/Tablet image tiers — just one Desktop video and an optional Mobile video, switched via a `<source media>` breakpoint inside a single `<video>` element (autoplay, muted, loop, `playsinline`). If no video is set, the Poster / Fallback Image renders as a plain `<img>` instead; if that's empty too, nothing renders at the block's own choosing — no bundled placeholder photo, unlike the image Hero.
- **Eyebrow, Description, Secondary Button Label/URL removed** — this block ships with just a Heading and a single (primary) Button.
- **Text Color and Text & Button Alignment are new.** `render.php` sets `color` as an inline style on the heading/button/footer-note column (and the Side Items column) so Text Color applies via `currentColor`/`opacity-*` utilities rather than the fixed `text-cs-ink` classes the image Hero uses. Text & Button Alignment maps to `text-left|center|right`, `items-start|center|end`, and `justify-start|center|end` together so the heading, the button row, and the footer note all shift as one unit.
- **Left alignment keeps the original 7/5 column split** (text column on the left, Side Items on the right). **Center and Right alignment give the text column the full row instead** — otherwise "Center" would only center within the left 7 columns, landing visibly off-center on the overall banner. Side Items is skipped when Center or Right is selected, since it assumes a left-aligned block sitting next to it.
