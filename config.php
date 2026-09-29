<?php
/**
 * config.php
 * Central configuration — database credentials and admin login.
 *
 * IMPORTANT: Update the DB_* values below before deploying, and change
 * ADMIN_USERNAME / ADMIN_PASSWORD to something private.
 */

// ── Database connection ─────────────────────────────────────────────
define('DB_HOST', 'localhost');
define('DB_NAME', 'docscompanynautilus');
define('DB_USER', 'ivistaz');
define('DB_PASS', 'e0D^L56D2xpp#09$$');
define('DB_CHARSET', 'utf8mb4');

// ── Admin panel login ────────────────────────────────────────────────
// Generate a new hash with: php -r "echo password_hash('yourpassword', PASSWORD_DEFAULT);"
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD_HASH', '$2y$10$I.X61AomkriZtq.PjsX4DOrgDWeWBa4ZlpZNRnvJA6cXWapQ8h9C.'); // default: "changeme123"

// ── Feedback table ───────────────────────────────────────────────────
// Single unified quarterly form — all comment areas stored in one table.
define('FEEDBACK_TABLE', 'feedback_submissions');

// ── Misc ─────────────────────────────────────────────────────────────
define('TICKET_PREFIX', 'TCK');
date_default_timezone_set('Asia/Kolkata');
