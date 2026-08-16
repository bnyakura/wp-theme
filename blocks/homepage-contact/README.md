# Homepage – Contact Block

Condensed contact section for the homepage: section header, a headquarters card, and a dispatch form (name, email, message). A lighter sibling of the full Contact page block — same headquarters data and email handler, no hero/testimonials/CTA.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Eyebrow** | Text | No | Small label above heading (defaults to "Dispatch") |
| **Title** | Text | No | Section heading (defaults to "Establish Contact") |
| **Subtitle** | Textarea | No | Supporting text below the heading |
| **Location** | Text | No | Headquarters address. Blank falls back to the site-wide contact details |
| **Email** | Email | No | Headquarters email. Blank falls back to the site-wide contact details |
| **Comm-Line** | Text | No | Headquarters phone, international format (e.g. "+27790614906"). Blank falls back to the site-wide contact details. Displayed formatted automatically (e.g. "079 061 4906") |

## Shared Data (inc/page-forms.php, inc/contact-section.php)

The form handler is shared with the Contact page block (`blocks/contact`) so both stay in sync, and the Location/Email/Comm-Line fields above default to the same site-wide contact details when left blank:

| Data | Source | Description |
|---|---|---|
| Headquarters details (fallback) | `iga_contact_details()` filter | Email, phone, address |
| Phone display format | `iga_format_phone_display()` | Formats the raw phone number for display (e.g. "079 061 4906") |
| Form state | `iga_contact_form_state()` | Validation, email send, and the `?dispatch=received` success redirect |

## Form Behaviour

- **State** is resolved by `iga_contact_form_state()` on `template_redirect` (shared with the Contact page block), so POST redirects keep working even though this block renders after the header.
- **Success** is shown via `?dispatch=received`.
- **Spam protection**: nonce `iga_submit_contact` + honeypot `website` field.
- No phone or subject fields — submissions default to the "Other" subject.

## Layout

- **Mobile:** stacked single column
- **Desktop (1081px+):** 2-column grid (headquarters left, form right)
- **Scroll reveal:** fades/slides in via the shared `data-reveal` behaviour (assets/js/reveal.js)
