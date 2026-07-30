# Pricing Block

Tabbed pricing section with **Monthly Memberships** and **Drop-In Sessions** tabs.

## Fields

| Field | Type | Required | Description |
|---|---|---|---|
| **Eyebrow** | Text | No | Small label above heading |
| **Title** | Text | Yes | Section heading (e.g. "Choose Your Rank") |
| **Subtitle** | Textarea | No | Supporting text below heading |
| **Monthly Tiers** | Repeater | No | Monthly membership pricing cards |
| **Drop-In Tiers** | Repeater | No | Drop-in session pricing cards |

Each tier has the following sub-fields:

| Sub-Field | Type | Required | Description |
|---|---|---|---|
| **Rank** | Text | Yes | Tier name (e.g. "Platoons") |
| **Sub** | Text | No | Small label above rank (e.g. "Group Training · Monthly") |
| **Price** | Text | Yes | Price display (e.g. "R 800") |
| **Cadence** | Text | No | Frequency label (e.g. "per month") |
| **Description** | Textarea | No | Short paragraph describing the tier |
| **Features** | Textarea | No | One feature per line |
| **Badge** | Text | No | Badge text (e.g. "Most Popular") |
| **Primary** | True/False | No | Highlights with green gradient styling |
| **CTA Label** | Text | No | Button text |
| **CTA Action** | Select | No | `link` (URL) or modal name |
| **CTA URL** | URL | No | Required when action is `link` |

## Tab Behaviour

Tab switching is handled by `assets/js/pricing-tabs.js` (enqueued automatically).
