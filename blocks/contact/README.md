# Contact Block

Contact page with hero, headquarters details, dispatch form (with email handler and subject preselection), testimonials, and final CTA. Falls back to the original Iron Gorilla content when fields are left empty.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Hero Eyebrow** | Text | No | Small label above the heading (e.g. "Dispatch") |
| **Hero Title** | Text | No | Main heading |
| **Hero Subtitle** | Textarea | No | Intro paragraph |
| **Hours** | Text | No | Opening hours row (defaults to Mon–Sat 6AM–9PM, Sunday closed) |
| **Testimonials** | Repeater | No | Member quotes |
| — Initials | Text | No | Avatar initials |
| — Name | Text | No | Member name |
| — Location | Text | No | Suburb / area |
| — Quote | Textarea | Yes | Testimonial text |
| — Result | Text | No | Result badge |
| **CTA Title** | Text | No | Final call-to-action heading |
| **CTA Subtitle** | Textarea | No | Final call-to-action intro |

## Shared Data (inc/page-forms.php)

The headquarters details and subject options ship with the original content and are filterable:

| Data | Filter | Description |
|---|---|---|
| Contact details | `iga_contact_details` | Email, phone, WhatsApp, Instagram, address |
| Subjects | `iga_contact_subjects` | Dispatch subject options |
| Recipient | `iga_contact_recipient` | Email address dispatches are sent to (defaults to the admin email) |

## Form Behaviour

- **State** is resolved by `iga_contact_form_state()` on `template_redirect`, so POST redirects keep working even though the block renders after the header.
- **Subject preselection** — links with `?subject=enlist`, `?subject=armory-early-access`, `?plan=...`, etc. are mapped via `iga_contact_subject_aliases()`.
- **Success** is shown via `?dispatch=received`.
- **Spam protection**: nonce `iga_submit_contact` + honeypot `website` field.
- **Actions/hooks**: `iga_contact_submitted` fires after the email attempt.

## Layout

- **Mobile:** stacked single column
- **Desktop (1024px+):** 2-column grid (headquarters left, form right)
- **Testimonials:** 1 col mobile, 3 cols desktop

## Notes

- All address/contact values can be overridden site-wide via the `iga_contact_details` filter or the theme Customizer's contact section.
