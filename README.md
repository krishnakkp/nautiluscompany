# Client Feedback System — Setup Guide

A multi-step quarterly feedback form (AJAX, no page reloads) backed by core PHP + MySQL,
with a password-protected admin panel to review submissions.

## How it fits together

- **`index.php`** — the public 3-step quarterly feedback form:
  1. About you (name, company)
  2. Ratings (overall, service, communication, confidence)
  3. Comments covering all areas (general, operations, communication,
     commercial, partnership + optional other comments)
  Optional survey period via URL: `?q=Q1&y=2026`
- **`submit-feedback.php`** — submission endpoint writing to `feedback_submissions`
- **`admin/`** — password-protected panel to browse, search, and filter submissions

## Ticket IDs

A ticket ID like `TCK-20260709-3146` is created only when **Any issues or
concerns?** and/or the **Operations** question is filled in. Otherwise no
ticket is generated.

Step 3 required fields: **What went well this quarter?** and **If you could
change one thing about how we work together…**. All other Step 3 questions
are optional.

## Setup steps

1. **Create the database and table** — import `schema.sql` or `docscompanynautilus.sql`:
   ```
   mysql -u your_user -p < schema.sql
   ```
   Both scripts also drop the old theme-split tables if they still exist.
2. **Configure `config.php`**:
   - Set `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`.
   - Change `ADMIN_USERNAME` and generate a new `ADMIN_PASSWORD_HASH`:
     ```
     php -r "echo password_hash('your-new-password', PASSWORD_DEFAULT);"
     ```
   - Default login is `admin` / `changeme123` — change before going live.
3. **Upload files** keeping this structure:
   ```
   index.php
   config.php
   db-check.php
   submit-feedback.php
   includes/db.php
   includes/handler.php
   includes/helpers.php
   admin/auth.php
   admin/login.php
   admin/logout.php
   admin/index.php
   assets/logo-white.webp
   ```
4. **Test** by visiting the site root (optionally `?q=Q1&y=2026`).
5. **Admin panel** at `admin/login.php`.

## Notes

- Form posts via `fetch()`/AJAX — no page reload.
- Server-side validation is in `includes/handler.php`; only `other_comments` is optional.
- Brand colors: `#00222f` (navy), `#008e9c` (teal).
