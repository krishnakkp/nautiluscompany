<?php
/**
 * config.php
 * Central configuration — database credentials, admin login, and
 * the "theme map" that ties each of the 4 form tabs to its own table.
 *
 * IMPORTANT: Update the DB_* values below before deploying, and change
 * ADMIN_USERNAME / ADMIN_PASSWORD to something private (see admin/README
 * notes at the bottom of this file for how to generate a password hash).
 */

// ── Database connection ─────────────────────────────────────────────
define('DB_HOST', 'localhost');
define('DB_NAME', 'u186687036_nautform');
define('DB_USER', 'u186687036_nautform');
define('DB_PASS', '>Gg>vvWJlIb4');
define('DB_CHARSET', 'utf8mb4');

// ── Admin panel login ────────────────────────────────────────────────
// Generate a new hash with: php -r "echo password_hash('yourpassword', PASSWORD_DEFAULT);"
define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD_HASH', '$2y$10$I.X61AomkriZtq.PjsX4DOrgDWeWBa4ZlpZNRnvJA6cXWapQ8h9C.'); // default: "changeme123"

// ── Theme / tab -> table map ────────────────────────────────────────
// Each tab on the form (A/B/C/D) writes to its own table, since the
// question set for each tab can change independently over time.
define('THEME_TABLE_MAP', [
    'a' => ['table' => 'feedback_operations',     'label' => 'A — Operations'],
    'b' => ['table' => 'feedback_communication',  'label' => 'B — Communication'],
    'c' => ['table' => 'feedback_commercial',      'label' => 'C — Commercial'],
    'd' => ['table' => 'feedback_relationship',    'label' => 'D — Relationship'],
]);

// ── Misc ─────────────────────────────────────────────────────────────
define('TICKET_PREFIX', 'TCK');
date_default_timezone_set('Asia/Kolkata');
