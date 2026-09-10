# Cilla Skyn Order Tracking Block

Centered heading, description and a button to the customer's own order history, reusable anywhere in the block editor. Built for the **Track Your Order** page.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Eyebrow** | Text | No | Small uppercase label above the heading. Default: "Help". |
| **Heading** | Text | No | Main heading. Default: "Track Your Order". |
| **Description** | Textarea | No | Supporting paragraph. |
| **Button Label** | Text | No | Default: "View My Orders". |
| **Button URL** | URL | No | Leave empty to auto-link to WooCommerce's My Account → Orders page (`wc_get_account_endpoint_url( 'orders' )`). |
| **Contact Text** | Textarea | No | Small fallback line under the button, for guest checkouts that have no account to sign into. |

## Notes

- **This is deliberately not a custom order-lookup form.** There's no shipment-tracking plugin installed on this site, so there's no real tracking-number data for a guest lookup to query — building one would just be a fake form that goes nowhere. Instead this block points signed-in customers at WooCommerce's own order history (My Account → Orders), which already shows order status and will show tracking numbers automatically once a shipping/tracking plugin is added later.
- If/when a real tracking plugin (e.g. one that adds tracking numbers to WooCommerce order emails/My Account) is installed, this block still works unchanged — the button still points at My Account → Orders, which the plugin enhances.
- The Button URL field lets you point this at something else entirely (e.g. a courier's own tracking page) if that fits better later.
