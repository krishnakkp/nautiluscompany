# Client Feedback System — Setup Guide

A multi-step quarterly feedback form (AJAX, no page reloads) backed by core PHP + MySQL,
with a password-protected admin panel to review submissions.

## How it fits together

- **`index.php`** — the public 3-step quarterly feedback form (loads on the bare domain):
  1. About you (name, company)
  2. Ratings (overall, service, communication, confidence)
  3. Comments covering all areas in one go (general, operations, communication,
     commercial, partnership + optional other comments)
  Optional survey period via URL: `?q=Q1&y=2026`
- **`feedback-form.html`** — legacy redirect to `index.php` (keeps old links working).
- **`submit-feedback.php`** — single submission endpoint writing to
  `feedback_submissions`.
- **`admin/`** — password-protected panel to browse, search, and filter
  submissions (including by survey period).

## Ticket IDs

The **"Any issues or concerns?"** field is required. A ticket ID like
`TCK-20260709-3146` is generated automatically and stored alongside the
submission for the admin panel.

## Setup steps

1. **Create the database and tables** — import `schema.sql` (or
   `docscompanynautilus.sql`):
   ```
   mysql -u your_user -p < schema.sql
   ```
   If you already have the old 4 theme tables, run `migrate-to-unified.sql`
   instead to add the new table without dropping the old ones.
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
   feedback-form.html   (optional legacy redirect)
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
4. **Test the form** by visiting the site root (optionally with
   `?q=Q1&y=2026`) and submitting a test entry.
5. **Log into the admin panel** at `admin/login.php`.

## Notes

- The form posts via `fetch()`/AJAX — no page reload, matching the existing
  multi-step UX.
- Basic server-side validation runs in `includes/handler.php` for all required
  fields; only `other_comments` is optional.
- The admin panel is server-rendered PHP (search + "tickets only" + period
  filter via the URL), so no separate JS build step is needed.
- Font: [Merriweather](https://fonts.google.com/specimen/Merriweather) (loaded
  from Google Fonts). Brand colors: `#00222f` (navy), `#008e9c` (teal), plus
  white/black, defined as CSS variables at the top of `index.php`.
- Replace `assets/logo-white.webp` with an updated logo any time — same
  filename, same folder.
