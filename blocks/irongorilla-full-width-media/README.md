# IronGorilla Full Width Image / Video Block

A full-bleed image or self-hosted background video section, with an optional heading/caption overlay. Reusable anywhere in the block editor. Brand-prefixed so it stays distinct from core/other plugin media blocks in the inserter.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Media Type** | Select | No | `Image` or `Video`. Default: `Image`. |
| **Image** | Image | No | Shown when Media Type is `Image`. Falls back to a placeholder image when empty. |
| **Video File** | File | No | Shown when Media Type is `Video`. Self-hosted MP4/WebM/etc — no oEmbed/YouTube support, matching WordPress core's Cover block. |
| **Poster Image** | Image | No | Shown when Media Type is `Video`. Displayed while the video loads and on browsers that block autoplay. |
| **Autoplay as Background Video** | True/False | No | Shown when Media Type is `Video`. On: muted, looped, no controls (ambient background video). Off: standard controls, click to play. Default: on. |
| **Section Height** | Select | No | `Auto (16:9)`, `Large` (matches the homepage Hero block's `90vh`), or `Full Screen` (`100vh`). Default: `Large`. |
| **Darken Overlay** | True/False | No | Dark gradient over the media for text legibility. Only rendered when Heading or Caption is set. Default: on. |
| **Heading** | Text | No | Optional. Overlaid on the media. |
| **Caption** | Textarea | No | Optional. Displayed underneath the heading. |

## Notes

- If Media Type is `Video` but no video file has been uploaded, the block falls back to the Image path (which itself always has a default placeholder), so the section never renders empty.
- The image's `alt` text comes from the attachment's own Alt Text field in the media library; if none is set, it renders as an empty (decorative) `alt=""`, since the image is a backdrop rather than meaningful content here.
- No custom breakpoints are introduced — sizing uses the same Tailwind utilities (`min-h-screen`, `aspect-video`) as the rest of the theme.
