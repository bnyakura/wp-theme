# Cilla Skyn Contact Form Block

A working contact form — Name, Email, Phone (optional), Subject, Message — reusable anywhere in the block editor. Built for the **Contact Us** page, alongside the [Contact Info](../cilla-skyn-contact-info/README.md) block (WhatsApp/Instagram/Email cards).

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Heading** | Text | No | Default: "Send Us a Message". |
| **Description** | Textarea | No | Supporting paragraph above the form. |
| **Success Message** | Text | No | Shown in place of the form after a successful submission. |

The Subject dropdown's options (Order Enquiry, Product Question, Returns & Exchanges, Wholesale / Stockist, Press / Collaboration, Other) aren't ACF fields — they're hardcoded in `cilla_skyn_contact_form_subjects()` in `inc/cilla-skyn-contact-form.php`, since they're a fixed, short list. Edit that function to change them.

## How it works

- **`inc/cilla-skyn-contact-form.php`** (required by `functions.php`) processes the POST on WordPress's `template_redirect` hook — before any HTML is sent — so it can `wp_safe_redirect()` on success. This mirrors the pattern already used by `inc/page-forms.php`'s booking/contact handlers, but is a **fresh implementation**, not a revival of that file: its subject options ("Membership Enquiry", "Armory / Product Order", "League of Legends", ...) are leftovers from the theme's original gym-brand build and don't fit a skincare store (see the main theme README §13).
- On submit: validates name/email/message are present, checks a nonce (`cilla_skyn_submit_contact`) and a hidden honeypot field (`cilla_skyn_website` — real visitors never fill it in; visually hidden off-screen, not `display:none`, so it still catches simple bots that only skip hidden-via-CSS fields... in practice most spam bots fill every field regardless, the nonce is the stronger defense here) to block spam.
- On success: emails `get_option( 'admin_email' )` (filterable via `cilla_skyn_contact_recipient`) with the submission, fires a `cilla_skyn_contact_submitted` action, then redirects back to the same page with `?cilla_skyn_contact=sent` — refreshing the page never resubmits the form.
- On error: the form re-renders with the entered values still filled in and an error message above the form.

## Notes

- **Requires outgoing mail to work** (`wp_mail()`) — on many hosts this needs an SMTP plugin (e.g. WP Mail SMTP) configured with real credentials, or messages may silently fail to arrive/land in spam. Test a real submission after launch.
- No ACF field for the recipient email — it defaults to the site's **Settings → General → Administration Email Address**. Change that, or hook the `cilla_skyn_contact_recipient` filter for something more specific (e.g. a dedicated support inbox).
