# Book a Drop-In Block

Booking page with two flows: quick sign-up (pick a class) and calendar (pick a date + session). Includes the shared booking form handler and email notification. Falls back to the original Iron Gorilla content when fields are left empty.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Hero Eyebrow** | Text | No | Small label above the heading (e.g. "Book a Drop-In") |
| **Hero Title** | Text | No | Main heading |
| **Hero Subtitle** | Textarea | No | Intro paragraph |
| **WhatsApp Number** | Text | No | Used for the Saturday "WhatsApp to Book" link |

## Shared Data (inc/page-forms.php)

The class cards, weekly timetable, and next bookable dates ship with the original content and are filterable:

| Data | Filter | Description |
|---|---|---|
| Quick classes | `iga_booking_quick_classes` | Class cards (name, coach, schedule, duration, icon, colours) |
| Weekly schedule | `iga_booking_schedule` | Timetable keyed by ISO weekday (1 = Monday) |
| Booking recipient | `iga_booking_recipient` | Email address bookings are sent to (defaults to the admin email) |

## Form Behaviour

- **State** is resolved by `iga_booking_form_state()` on `template_redirect`, so POST redirects keep working even though the block renders after the header.
- **Success** shows a booking summary keyed by the reference in `?booking=success&booking_ref=...` (transient-backed, 15 min).
- **Spam protection**: nonce `iga_submit_booking` + honeypot `website` field.
- **Actions/hooks**: `iga_booking_submitted` fires after the email attempt.

## Layout

- **Mobile:** single column
- **Quick flow:** class list → details form
- **Calendar flow:** swipeable date strip → session list → details form

## Notes

- Bookings are confirmed manually via WhatsApp within 24 hours.
