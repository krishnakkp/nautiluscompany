<?php
require_once __DIR__ . '/auth.php';
require_login();
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/helpers.php';

$map = THEME_TABLE_MAP; // a/b/c/d => [table, label]
$tab = $_GET['tab'] ?? 'a';
if (!isset($map[$tab])) $tab = 'a';
$table = $map[$tab]['table'];

$search      = trim($_GET['q'] ?? '');
$ticketsOnly = isset($_GET['tickets_only']);

$pdo = get_db_connection();

// ── Build query for the selected tab's table ──
$where  = [];
$params = [];
if ($search !== '') {
    $where[] = '(contact_name LIKE :q OR company LIKE :q OR ticket_id LIKE :q)';
    $params[':q'] = '%' . $search . '%';
}
if ($ticketsOnly) {
    $where[] = 'ticket_id IS NOT NULL';
}
$whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

$stmt = $pdo->prepare("SELECT * FROM `{$table}` {$whereSql} ORDER BY submitted_at DESC LIMIT 300");
$stmt->execute($params);
$rows = $stmt->fetchAll();

// ── Stats for this tab ──
$totalStmt = $pdo->query("SELECT COUNT(*) AS c FROM `{$table}`");
$total = (int) $totalStmt->fetch()['c'];

$openStmt = $pdo->query("SELECT COUNT(*) AS c FROM `{$table}` WHERE ticket_id IS NOT NULL");
$openTickets = (int) $openStmt->fetch()['c'];

function score_num(?string $val): ?int
{
    if (!$val) return null;
    if (preg_match('/^(\d+)/', $val, $m)) return (int) $m[1];
    return null;
}

$avgStmt = $pdo->query("SELECT overall_satisfaction FROM `{$table}`");
$scores = array_filter(array_map(fn($r) => score_num($r['overall_satisfaction']), $avgStmt->fetchAll()));
$avgScore = count($scores) ? round(array_sum($scores) / count($scores), 1) : null;

function score_color(?int $s): string
{
    if ($s === null) return '#9ca3af';
    if ($s >= 4) return '#16a34a';
    if ($s == 3) return '#c2410c';
    return '#dc2626';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Client Feedback — Admin Panel</title>
<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700;900&display=swap" rel="stylesheet">
<style>
  :root {
    --navy:#00222f; --navy-dark:#00161e; --teal:#008e9c; --bg:#f0f3f4; --white:#fff;
    --border:#dde4e6; --text:#101010; --muted:#5b6a6d; --green:#16a34a; --red:#dc2626; --orange:#c2410c;
  }
  * { box-sizing:border-box; margin:0; padding:0; }
  body { font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif; background:var(--bg); color:var(--text); font-size:13px; }
  header { background:var(--navy); border-bottom:3px solid var(--teal); padding:0 28px; display:flex; align-items:center; justify-content:space-between; height:60px; }
  .hd-left { display:flex; align-items:center; gap:12px; }
  .hd-title { font-family:'Merriweather',serif; font-size:15px; font-weight:700; color:#fff; letter-spacing:0.03em; }
  .hd-sub { font-size:10px; color:rgba(255,255,255,0.55); margin-top:1px; letter-spacing:0.05em; text-transform:uppercase; }
  .hd-right { display:flex; align-items:center; gap:10px; }
  .hd-user { font-size:11px; color:rgba(255,255,255,0.7); }
  .hd-logout { font-size:11px; color:#fff; background:rgba(255,255,255,0.12); padding:6px 14px; border-radius:20px; text-decoration:none; }
  .hd-logout:hover { background:rgba(255,255,255,0.22); }

  .page { padding:22px 28px; max-width:1200px; margin:0 auto; }

  .tabs { display:flex; gap:8px; margin-bottom:18px; flex-wrap:wrap; }
  .tab-btn { padding:9px 18px; border-radius:20px; font-size:12px; font-weight:700; border:1.5px solid var(--border); background:#fff; color:var(--muted); text-decoration:none; }
  .tab-btn:hover { border-color:var(--navy); color:var(--navy); }
  .tab-btn.active { background:var(--teal); border-color:var(--teal); color:#fff; }

  .stats { display:grid; grid-template-columns:repeat(3,1fr); gap:14px; margin-bottom:18px; }
  .stat { background:#fff; border-radius:10px; border:1px solid var(--border); padding:16px 18px; position:relative; overflow:hidden; }
  .stat::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background:var(--navy); }
  .stat.s-warn::before { background:var(--red); }
  .stat.s-good::before { background:var(--green); }
  .stat .lbl { font-size:10px; color:var(--muted); text-transform:uppercase; letter-spacing:0.06em; font-weight:700; margin-bottom:6px; }
  .stat .val { font-size:26px; font-weight:800; color:var(--navy); line-height:1; }

  .filter-bar { display:flex; gap:8px; margin-bottom:16px; flex-wrap:wrap; align-items:center; }
  .filter-bar input[type="text"] { padding:8px 12px; border:1.5px solid var(--border); border-radius:7px; font-size:12px; min-width:220px; }
  .chip-btn { font-size:11px; font-weight:600; padding:7px 14px; border-radius:20px; border:1.5px solid var(--border); background:#fff; color:var(--muted); cursor:pointer; text-decoration:none; }
  .chip-btn.active { background:var(--navy); border-color:var(--navy); color:#fff; }
  .filter-bar button.go { background:var(--navy); color:#fff; border:none; padding:8px 16px; border-radius:7px; font-size:12px; font-weight:700; cursor:pointer; }

  .card { background:#fff; border-radius:10px; border:1px solid var(--border); }
  .card-head { padding:14px 18px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; }
  .card-head h3 { font-size:11px; font-weight:700; color:var(--muted); text-transform:uppercase; letter-spacing:0.06em; }
  .card-head .count { font-size:11px; font-weight:700; color:var(--navy); background:#eef4f5; padding:3px 10px; border-radius:10px; }

  .tbl-wrap { overflow-x:auto; }
  table { width:100%; border-collapse:collapse; font-size:12px; }
  th { font-size:10px; color:var(--muted); text-transform:uppercase; letter-spacing:0.05em; text-align:left; padding:9px 12px; border-bottom:2px solid var(--border); white-space:nowrap; font-weight:700; }
  td { padding:10px 12px; border-bottom:1px solid #f2f4f5; vertical-align:top; }
  tr:hover td { background:#fafbfb; }
  .td-name { font-weight:700; white-space:nowrap; }
  .td-muted { color:var(--muted); font-size:11px; white-space:nowrap; }
  .td-text { max-width:220px; color:#333; }
  .score-pill { font-weight:800; }

  .ticket-tag { display:inline-block; background:#eef4f5; border:1px solid var(--teal); color:var(--navy); font-size:10px; font-weight:700; padding:2px 8px; border-radius:8px; white-space:nowrap; }
  .no-ticket { color:#9ca3af; font-size:11px; }

  details.extra summary { cursor:pointer; color:var(--teal); font-size:11px; font-weight:600; list-style:none; }
  details.extra summary::-webkit-details-marker { display:none; }
  details.extra div { margin-top:6px; font-size:11px; color:#374151; background:#f7f9f9; border-radius:6px; padding:8px 10px; }
  details.extra div p { margin-bottom:4px; }
  details.extra div p b { color:var(--navy); }

  .empty { text-align:center; padding:40px 16px; color:var(--muted); }

  @media (max-width:768px) {
    .stats { grid-template-columns:1fr; }
    .page { padding:14px; }
  }
</style>
</head>
<body>

<header>
  <div class="hd-left">
    <div>
      <div class="hd-title">CLIENT FEEDBACK — ADMIN PANEL</div>
      <div class="hd-sub">Internal View</div>
    </div>
  </div>
  <div class="hd-right">
    <span class="hd-user">Logged in as <?= h($_SESSION['admin_username'] ?? '') ?></span>
    <a class="hd-logout" href="logout.php">Log out</a>
  </div>
</header>

<div class="page">

  <div class="tabs">
    <?php foreach ($map as $key => $info): ?>
      <a class="tab-btn <?= $key === $tab ? 'active' : '' ?>" href="?tab=<?= h($key) ?>"><?= h($info['label']) ?></a>
    <?php endforeach; ?>
  </div>

  <div class="stats">
    <div class="stat">
      <div class="lbl">Total Responses</div>
      <div class="val"><?= $total ?></div>
    </div>
    <div class="stat <?= $openTickets > 0 ? 's-warn' : 's-good' ?>">
      <div class="lbl">Open Tickets (Issues Flagged)</div>
      <div class="val"><?= $openTickets ?></div>
    </div>
    <div class="stat">
      <div class="lbl">Avg. Overall Satisfaction</div>
      <div class="val" style="color:<?= score_color($avgScore !== null ? (int) round($avgScore) : null) ?>">
        <?= $avgScore !== null ? $avgScore . ' / 5' : '—' ?>
      </div>
    </div>
  </div>

  <form class="filter-bar" method="GET">
    <input type="hidden" name="tab" value="<?= h($tab) ?>">
    <input type="text" name="q" placeholder="Search name, company, or ticket ID..." value="<?= h($search) ?>">
    <a class="chip-btn <?= $ticketsOnly ? 'active' : '' ?>"
       href="?tab=<?= h($tab) ?>&q=<?= urlencode($search) ?><?= $ticketsOnly ? '' : '&tickets_only=1' ?>">
       Tickets only
    </a>
    <button type="submit" class="go">Filter</button>
    <?php if ($search !== '' || $ticketsOnly): ?>
      <a class="chip-btn" href="?tab=<?= h($tab) ?>">Clear</a>
    <?php endif; ?>
  </form>

  <div class="card">
    <div class="card-head">
      <h3><?= h($map[$tab]['label']) ?> — Responses</h3>
      <span class="count"><?= count($rows) ?> shown</span>
    </div>
    <div class="tbl-wrap">
      <?php if (empty($rows)): ?>
        <div class="empty">No responses yet for this tab.</div>
      <?php else: ?>
        <table>
          <thead>
            <tr>
              <th>Date</th>
              <th>Ticket</th>
              <th>Name / Company</th>
              <th>Overall</th>
              <th>Service</th>
              <th>Comms</th>
              <th>Confidence</th>
              <th>What Went Well</th>
              <th>Issues / Concerns</th>
              <th>Themed Q&amp;A</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($rows as $r): ?>
              <?php
                $extra = [];
                if (!empty($r['extra_data'])) {
                    $decoded = json_decode($r['extra_data'], true);
                    if (is_array($decoded)) $extra = $decoded;
                }
              ?>
              <tr>
                <td class="td-muted"><?= h(date('d M Y, H:i', strtotime($r['submitted_at']))) ?></td>
                <td>
                  <?php if (!empty($r['ticket_id'])): ?>
                    <span class="ticket-tag"><?= h($r['ticket_id']) ?></span>
                  <?php else: ?>
                    <span class="no-ticket">—</span>
                  <?php endif; ?>
                </td>
                <td class="td-name"><?= h($r['contact_name']) ?><br><span class="td-muted"><?= h($r['company']) ?></span></td>
                <td><span class="score-pill" style="color:<?= score_color(score_num($r['overall_satisfaction'])) ?>"><?= h($r['overall_satisfaction']) ?></span></td>
                <td><span class="score-pill" style="color:<?= score_color(score_num($r['service_quality'])) ?>"><?= h($r['service_quality']) ?></span></td>
                <td><span class="score-pill" style="color:<?= score_color(score_num($r['communication'])) ?>"><?= h($r['communication']) ?></span></td>
                <td class="td-muted"><?= h($r['confidence']) ?></td>
                <td class="td-text"><?= nl2br(h($r['positive_feedback'])) ?></td>
                <td class="td-text">
                  <?php if (!empty($r['issues_concerns'])): ?>
                    <span style="color:#b91c1c"><?= nl2br(h($r['issues_concerns'])) ?></span>
                  <?php else: ?>
                    <span class="no-ticket">None</span>
                  <?php endif; ?>
                </td>
                <td class="td-text">
                  <?php if (!empty($extra)): ?>
                    <details class="extra">
                      <summary>View answers (<?= count($extra) ?>)</summary>
                      <div>
                        <?php foreach ($extra as $k => $v): ?>
                          <p><b><?= h($k) ?>:</b> <?= h(is_scalar($v) ? (string) $v : json_encode($v)) ?></p>
                        <?php endforeach; ?>
                      </div>
                    </details>
                  <?php else: ?>
                    <span class="no-ticket">—</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>
  </div>

</div>

</body>
</html>
