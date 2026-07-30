# Distinction Block

Three-column info cards with images, tags, and call-to-action buttons.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Cards** | Repeater | Yes | Add each card |
| — Background Image | Image | No | Card header image (fallback: Google Maps embed) |
| — Tag | Text | No | Small label (e.g. "The Movement") |
| — Tag Icon | Text | No | Font Awesome class for the tag (e.g. `fa-users`) |
| — Title | Text | Yes | Card heading |
| — Body | Textarea | Yes | Card description |
| — Featured | True/False | No | Highlights with green border + gradient background |
| — CTA Label | Text | No | Button text |
| — CTA Icon | Text | No | Font Awesome class for the button icon |
| — CTA Action | Select | No | `link` (URL), `directions` (Google Maps), or modal name |
| — CTA URL | URL | No | Required when action is `link` |

## Featured Cards

Cards marked **Featured** get a green border, green gradient background, and a green CTA button. Use for the most important card.
