# Book Assessment Page Block

A short lead-capture form (first name, last name, email, phone, date of birth,
gender). On submit the details are saved to a Google Sheet and the visitor is
handed off to WhatsApp with the details pre-filled so a coach can confirm the
booking.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Hero Eyebrow** | Text | No | Small label above the heading (e.g. "Book Assessment") |
| **Hero Title** | Text | No | Main heading |
| **Hero Subtitle** | Textarea | No | Intro paragraph |

## Google Sheets

Submissions are POSTed to the Google Apps Script Web App URL set in
**Appearance → Customize → Site Identity → Book Assessment — Google Sheet
Webhook URL**. See `docs/book-assessment-google-sheet.md` (project root) for
the Apps Script setup. If the field is left empty, the Sheet sync is skipped
and the booking still goes through to WhatsApp.

## WhatsApp

Uses the WhatsApp number configured in **Appearance → Customize → Site
Identity → WhatsApp Number** (`iga_get_whatsapp_number_url()`).

## Form Behaviour

- **State** is resolved by `iga_assessment_form_state()` on `template_redirect`,
  so POST redirects keep working even though the block renders after the header.
- **Success** shows a confirmation with the submitted details, keyed by the
  reference in `?assessment=success&assessment_ref=...` (transient-backed, 15
  min), then auto-redirects to WhatsApp (with a manual "Continue to WhatsApp"
  button as a fallback for browsers that block the auto-redirect).
- **Spam protection**: nonce `iga_submit_assessment` + honeypot `website` field.
- **Actions/hooks**: `iga_assessment_sheet_synced( $booking, $response )` fires
  after the Google Sheet webhook call; `iga_assessment_submitted( $booking )`
  fires once the submission is fully processed.
