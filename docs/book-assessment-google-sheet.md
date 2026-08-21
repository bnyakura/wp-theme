# Book Assessment → Google Sheet setup

The `/book/` page (the `wp-theme/book` block) sends every submission's first
name, last name, email, phone, DOB, and gender to a Google Sheet via a small
Google Apps Script "Web App" — no API keys are stored in WordPress. Follow
these steps once:

## 1. Create the Sheet

1. Create a new Google Sheet (e.g. "Assessment Bookings").
2. In row 1, add headers: `Timestamp | First Name | Last Name | Email | Phone | DOB | Gender`.

## 2. Add the Apps Script

1. In the Sheet, go to **Extensions → Apps Script**.
2. Delete any starter code and paste:

   ```javascript
   var SHEET_ID = 'PASTE_YOUR_SPREADSHEET_ID_HERE';

   function doPost(e) {
     try {
       var sheet = SpreadsheetApp.openById(SHEET_ID).getSheets()[0];
       var p = e.parameter;

       sheet.appendRow([
         p.submitted || new Date(),
         p.first_name || '',
         p.last_name || '',
         p.email || '',
         p.phone || '',
         p.dob || '',
         p.gender || ''
       ]);

       return ContentService
         .createTextOutput(JSON.stringify({ status: 'ok' }))
         .setMimeType(ContentService.MimeType.JSON);
     } catch (err) {
       return ContentService
         .createTextOutput(JSON.stringify({ status: 'error', message: err.message }))
         .setMimeType(ContentService.MimeType.JSON);
     }
   }
   ```

   Replace `PASTE_YOUR_SPREADSHEET_ID_HERE` with the ID from your Sheet's
   URL — the long string between `/d/` and `/edit`, e.g. for
   `https://docs.google.com/spreadsheets/d/1M5cB.../edit` the ID is `1M5cB...`.

   Using `openById()` instead of `getActiveSpreadsheet()` means this works
   whether the script is bound to the Sheet (opened via Extensions → Apps
   Script) or a standalone script project — `getActiveSpreadsheet()` throws
   with no useful error in the standalone case, which silently breaks the
   sync.

3. Click **Save**.

## 3. Deploy as a Web App

1. Click **Deploy → New deployment**.
2. Click the gear icon next to "Select type" and choose **Web app**.
3. Set:
   - **Execute as**: Me
   - **Who has access**: Anyone
4. Click **Deploy**, authorize the script when prompted, and copy the
   **Web app URL** it gives you (ends in `/exec`).

## 4. Add the URL to WordPress

1. In WP Admin, go to **Appearance → Customize → Site Identity**.
2. Paste the URL into **Book Assessment — Google Sheet Webhook URL**.
3. Publish.

That's it — every `/book/` submission now appends a row to the Sheet in
addition to handing the visitor off to WhatsApp. If the field is left empty,
the Sheet step is silently skipped and WhatsApp handoff still works.

## Notes

- The theme posts via `wp_remote_post()` server-side (see
  `iga_assessment_form_state()` in `inc/page-forms.php`), so the Apps Script
  URL is never exposed in page source and there are no CORS concerns.
- If you ever need to redeploy the script (e.g. after editing the code), use
  **Deploy → Manage deployments → Edit → New version**, otherwise the old
  `/exec` URL keeps running the old code.
