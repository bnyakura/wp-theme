# Cilla Skyn Hero Video Block

Full-bleed cream hero banner, same shell as the [Cilla Skyn Hero](../cilla-skyn-hero/README.md) block but with a looping background video instead of a responsive image. Brand-prefixed so it stays distinct from core/other plugin cover blocks in the inserter.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Background Video (Desktop)** | File (mp4/webm/mov) | No | Looping, muted background video. Used at 768px and wider, and as the fallback below that if Background Video (Mobile) is empty. |
| **Background Video (Mobile)** | File (mp4/webm/mov) | No | Optional lighter/shorter file for under 768px wide, so phones aren't served the full desktop video. Leave empty to fall through to Desktop. |
| **Mobile Section Height** | Select (Auto / Short / Medium / Tall / Full Screen) | No | Minimum height of the section below 768px wide. Default: Tall (1320px). Doesn't affect 768px and up, which is always a fixed 560px minimum. |
| **Poster / Fallback Image** | Image | No | Shown while the video loads (`<video poster>`), and rendered as a static background instead if no video is set at all. Leave empty and nothing renders until the video is ready — there's no placeholder image. |
| **Video Fit** | Select | No | CSS `object-fit` for the video/poster. Default: Cover. |
| **Video Position** | Select | No | CSS `object-position` for the video/poster. Default: Center. |
| **Background Overlay Style** | Select (Gradient / Solid Colour / None) | No | What sits over the video to keep the text readable. Default: Gradient. |
| **Overlay Color** | Color picker (with opacity) | No | Used when Background Overlay Style is "Solid Colour". |
| **Gradient Start / End Colour** | Color picker (with opacity) | No | Used when Background Overlay Style is "Gradient". |
| **Gradient Direction** | Select | No | Used when Background Overlay Style is "Gradient". |
| **Heading** | Text | No | Main serif headline. Leave empty to omit it. |
| **Text Color** | Color picker | No | Colour of the heading, footer note, and side list — pick a light colour for a dark video, dark for a light video. |
| **Text & Button Alignment** | Select (Left / Center / Right) | No | Horizontal alignment of the heading, button, and footer note within their column. |
| **Button Label / URL** | Text / URL | No | Solid dark button. Leave Label empty to hide the button entirely. |
| **Footer Note** | Text | No | Small uppercase line under the button. Leave empty to omit it. |
| **Side Items** | Repeater (Label) | No | Vertical uppercase label list on the right, desktop only. |

## Notes

- **Heading, Button Label/URL and Footer Note carry no `default_value` and no placeholder-copy fallback in `render.php`** — each is wrapped in its own `if`, so clearing one in the editor genuinely omits that line instead of silently falling back to the original mockup copy ("Layered in the Essence of Nature.", "Shop Best Sellers", "African Roots. Radiant Tomorrows."). Leaving all of them empty (with no video/poster either) renders an empty section with only its own padding — the opposite of [About Hero](../cilla-skyn-about-hero/README.md), which deliberately always shows its docx copy by default. Unlike those three, Video Fit/Position, Overlay Style, Gradient Direction and Text & Button Alignment keep their defaults — those are "pick one of N visual styles" fields where an empty state isn't meaningful, not optional content lines.

## Differences from Cilla Skyn Hero

- **Background is video, not image**: no Laptop/Tablet image tiers — just one Desktop video and an optional Mobile video, switched via a `<source media>` breakpoint inside a single `<video>` element (autoplay, muted, loop, `playsinline`). If no video is set, the Poster / Fallback Image renders as a plain `<img>` instead; if that's empty too, nothing renders at the block's own choosing — no bundled placeholder photo, unlike the image Hero.
- **Mobile Section Height is new and editable, not fixed.** The image Hero's `min-h-[1320px]` below 768px is deliberately tuned (per that block's own README) to a specific portrait photo with a face positioned low in the frame — this block's shell originally just carried the same fixed value over even though a video doesn't have that same cropping problem. It's now a Select (`render.php` maps it to a literal `min-h-*` class the same way as Video Fit/Position, since a class built from the raw field value at runtime would be invisible to Tailwind's build) so a shorter or taller video can pick whatever mobile height actually fits it, without touching code.
- **Eyebrow, Description, Secondary Button Label/URL removed** — this block ships with just a Heading and a single (primary) Button.
- **Text Color and Text & Button Alignment are new.** `render.php` sets `color` as an inline style on the heading/button/footer-note column (and the Side Items column) so Text Color applies via `currentColor`/`opacity-*` utilities rather than the fixed `text-cs-ink` classes the image Hero uses. Text & Button Alignment maps to `text-left|center|right`, `items-start|center|end`, and `justify-start|center|end` together so the heading, the button row, and the footer note all shift as one unit.
- **Left alignment keeps the original 7/5 column split** (text column on the left, Side Items on the right). **Center and Right alignment give the text column the full row instead** — otherwise "Center" would only center within the left 7 columns, landing visibly off-center on the overall banner. Side Items is skipped when Center or Right is selected, since it assumes a left-aligned block sitting next to it.
