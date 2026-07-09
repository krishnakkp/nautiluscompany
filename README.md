# Client Feedback System — Setup Guide

A multi-step feedback form (AJAX, no page reloads) backed by core PHP + MySQL,
with a password-protected admin panel to review submissions.

## How it fits together

- **`index.php`** — the site's landing page: your logo, a short line of copy, and
  4 buttons (one per tab) linking straight to `feedback-form.html?t=a/b/c/d`.
  This is what loads when someone visits the bare domain.
- **`feedback-form.html`** — the public form. Which tab (theme) it shows is driven
  by a `?t=` query parameter: `?t=a` (Operations), `?t=b` (Communication),
  `?t=c` (Commercial), `?t=d` (Relationship). Send clients the specific URL for
  whichever theme is active that month — there's no visible tab switcher on the
  live form; that was only in the earlier mockup to preview all 4 versions.
- **4 submission endpoints**, one per tab, each writing to its own table:
  - `submit-operations.php` → `feedback_operations`
  - `submit-communication.php` → `feedback_communication`
  - `submit-commercial.php` → `feedback_commercial`
  - `submit-relationship.php` → `feedback_relationship`
- **`admin/`** — a password-protected panel to browse, search, and filter
  submissions for each tab.

Keeping a separate table per tab means if the themed questions for, say, the
Commercial tab change next quarter, nothing needs to be altered on the other
3 tabs, and the table itself doesn't need a schema change either — any field
that isn't one of the shared core fields (name, company, ratings, positive
feedback, issues/concerns) is automatically captured into an `extra_data` JSON
column, whatever its name.

## Ticket IDs

The **"Any issues or concerns?"** field is optional. If a client leaves it
blank, no ticket is created. If they fill it in, a ticket ID like
`TCK-20260709-3146` is generated automatically and shown back to them on the
thank-you screen, and stored alongside their submission for the admin panel.

## Setup steps

1. **Create the database and tables** — import `schema.sql`:
   ```
   mysql -u your_user -p < schema.sql
   ```
2. **Configure `config.php`**:
   - Set `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS` to your real credentials.
   - Change `ADMIN_USERNAME` and generate a new `ADMIN_PASSWORD_HASH`:
     ```
     php -r "echo password_hash('your-new-password', PASSWORD_DEFAULT);"
     ```
     Paste the result in as `ADMIN_PASSWORD_HASH`.
   - The default login shipped here is username `admin` / password `changeme123`
     — change this before going live.
3. **Upload all files** to your PHP host, keeping the folder structure intact
   (`includes/`, `admin/`, `assets/` all need to stay alongside `config.php`).
   Checklist of what should exist on the server, all inside the site root:
   ```
   index.php
   feedback-form.html
   config.php
   db-check.php
   submit-operations.php
   submit-communication.php
   submit-commercial.php
   submit-relationship.php
   includes/db.php
   includes/handler.php
   includes/helpers.php
   admin/auth.php
   admin/login.php
   admin/logout.php
   admin/index.php
   assets/logo-white.webp
   ```
4. **Test the form** by visiting `feedback-form.html?t=a` (and `?t=b`, `?t=c`,
   `?t=d`) and submitting a test entry for each.
5. **Log into the admin panel** at `admin/login.php`.

## Notes

- The form posts via `fetch()`/AJAX — no page reload, matching the existing
  multi-step UX.
- Basic server-side validation runs in `includes/handler.php` for all required
  fields; the issues/concerns field is the only optional one.
- The admin panel is server-rendered PHP (search + "tickets only" filter via
  the URL), so no separate JS build step is needed.
- Font: [Merriweather](https://fonts.google.com/specimen/Merriweather) (loaded
  from Google Fonts). Brand colors: `#00222f` (navy), `#008e9c` (teal), plus
  white/black, defined as CSS variables at the top of `feedback-form.html`.
- Replace `assets/logo-white.webp` with an updated logo any time — same
  filename, same folder.
