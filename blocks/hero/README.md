# Hero Block

A custom slider/carousel block powered by **Secure Custom Fields (SCF)**.

## Field Group

The block uses a **repeater field** called **Slides**. Sync the field group in `acf-json/group_hero.json`:

1. Go to **Custom Fields → Sync** in the WordPress admin
2. Locate the **Hero** field group and click **Sync**

## Adding Slides

1. Add (or edit) the **Hero** block in the Block Editor
2. Under **Slides**, click **Add Slide** to create a new slide
3. Fill in the fields for each slide:

| Field | Type | Required | Description |
|---|---|---|---|
| **Background Image** | Image | Yes | Full-width background for the slide |
| **Eyebrow** | Text | No | Small uppercase label above the headline |
| **Title** | Text | Yes | Main headline (line 1, white) |
| **Line 2 (accent)** | Text | No | Second headline rendered in the accent colour |
| **Description** | Textarea | No | Short paragraph under the headline |
| **Button Text** | Text | No | Call-to-action button label |
| **Button URL** | URL | No | CTA button destination (shown when Button Text is set) |

4. Use **Content Layout** to align the text: Left, Center, or Right
5. **Publish/Update** the post to see the slider on the frontend

## Slider Behaviour

- Autoplay with a 6-second interval (set via `data-hero-interval` on the root)
- Pauses on hover (progress bar hides, resumes on mouseleave)
- Swipe support on touch devices (40 px threshold)
- Navigation: arrow buttons, dot indicators, and a progress bar
- The slider wraps around (infinite loop)

These are handled by `assets/js/hero-slider.js`, which is enqueued automatically by the theme.

## Dependencies

- **Secure Custom Fields** (SCF) plugin — uses standard ACF-compatible APIs
- `assets/js/hero-slider.js` — in the theme, enqueued via `inc/theme-js.php`
- Tailwind CSS (optional) — `.animate-slide-progress` keyframe is defined in the theme's CSS

## Development

Edit `acf-json/group_hero.json` to add/remove fields, then sync in the admin.

The block auto-registers through `inc/acf-blocks.php` which scans the `/blocks/` directory for `block.json` files — no additional registration code is needed.
