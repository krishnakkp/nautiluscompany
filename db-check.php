<?php
/**
 * db-check.php
 *
 * Quick standalone script to verify the MySQL connection and that the
 * 4 feedback tables exist. Upload this to the project root (same folder
 * as config.php) and visit it in the browser, e.g.:
 *
 *     https://company.nautilusshipping.com/db-check.php
 *
 * IMPORTANT: This file reveals server/DB details useful to an attacker.
 * Delete it (or rename it to something unguessable) once you've confirmed
 * the connection works — don't leave it live permanently.
 */

require_once __DIR__ . '/config.php';

header('Content-Type: text/html; charset=utf-8');

function row(string $label, string $status, string $detail = '', bool $ok = true): string
{
    $color = $ok ? '#16a34a' : '#dc2626';
    $icon  = $ok ? '✓' : '✗';
    return "<tr>
        <td style='padding:8px 12px;font-weight:600'>{$label}</td>
        <td style='padding:8px 12px;color:{$color};font-weight:700'>{$icon} {$status}</td>
        <td style='padding:8px 12px;color:#5b6a6d;font-size:12px'>{$detail}</td>
    </tr>";
}

$rows = [];
$overallOk = true;

// ── 1. Can we even reach MySQL with these credentials? ──
$pdo = null;
try {
    $dsn = 'mysql:host=' . DB_HOST . ';charset=' . DB_CHARSET; // no dbname yet — test server reachability first
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5,
    ]);
    $rows[] = row('MySQL server connection', 'Connected', 'Host: ' . DB_HOST);
} catch (PDOException $e) {
    $overallOk = false;
    $rows[] = row('MySQL server connection', 'Failed', h_safe($e->getMessage()), false);
}

// ── 2. Does the configured database exist and is it selectable? ──
if ($pdo) {
    try {
        $pdo->exec('USE `' . DB_NAME . '`');
        $rows[] = row('Database selected', 'OK', 'Database: ' . DB_NAME);
    } catch (PDOException $e) {
        $overallOk = false;
        $rows[] = row('Database selected', 'Failed', h_safe($e->getMessage()), false);
        $pdo = null; // no point checking tables if the DB itself failed
    }
}

// ── 3. Do the 4 expected tables exist, and how many rows in each? ──
$expectedTables = [
    'feedback_operations'    => 'A — Operations',
    'feedback_communication' => 'B — Communication',
    'feedback_commercial'    => 'C — Commercial',
    'feedback_relationship'  => 'D — Relationship',
];

if ($pdo) {
    foreach ($expectedTables as $table => $label) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) AS c FROM `{$table}`");
            $count = $stmt->fetch(PDO::FETCH_ASSOC)['c'];
            $rows[] = row("Table: {$table}", 'Exists', "{$label} — {$count} row(s)");
        } catch (PDOException $e) {
            $overallOk = false;
            $rows[] = row("Table: {$table}", 'Missing / error', h_safe($e->getMessage()), false);
        }
    }
}

// ── 4. Basic PHP environment info (helpful for debugging) ──
$phpInfo = 'PHP ' . PHP_VERSION . ' — PDO MySQL driver: ' . (extension_loaded('pdo_mysql') ? 'loaded' : 'NOT loaded');

function h_safe(string $v): string
{
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>DB Connection Check</title>
<style>
  body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background:#f4f6f7; padding:40px; color:#101010; }
  .box { max-width:720px; margin:0 auto; background:#fff; border-radius:10px; border:1px solid #dde4e6; overflow:hidden; }
  .head { background:#00222f; color:#fff; padding:18px 22px; border-bottom:3px solid #008e9c; }
  .head h1 { font-size:16px; }
  .head p { font-size:12px; opacity:0.7; margin-top:4px; }
  table { width:100%; border-collapse:collapse; }
  tr:not(:last-child) td { border-bottom:1px solid #f0f2f3; }
  .footer { padding:14px 22px; font-size:11px; color:#5b6a6d; background:#fafbfb; }
  .banner { padding:12px 22px; font-weight:700; font-size:13px; }
  .banner.ok { background:#dcfce7; color:#15803d; }
  .banner.fail { background:#fee2e2; color:#b91c1c; }
</style>
</head>
<body>
  <div class="box">
    <div class="head">
      <h1>Database Connection Check</h1>
      <p><?= h_safe($phpInfo) ?></p>
    </div>
    <div class="banner <?= $overallOk ? 'ok' : 'fail' ?>">
      <?= $overallOk ? '✓ All checks passed' : '✗ One or more checks failed — see details below' ?>
    </div>
    <table>
      <?= implode('', $rows) ?>
    </table>
    <div class="footer">
      Generated <?= date('d M Y, H:i:s') ?> — delete this file once verified.
    </div>
  </div>
</body>
</html>
