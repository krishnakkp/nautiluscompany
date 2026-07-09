<?php
/**
 * includes/handler.php
 *
 * Shared logic for handling a feedback submission into a specific table.
 * Each of the 4 public endpoints (submit-operations.php, submit-communication.php,
 * submit-commercial.php, submit-relationship.php) calls handle_feedback_submission()
 * with its own fixed $themeKey — the table itself is never taken from user input,
 * so one endpoint can never be tricked into writing into another tab's table.
 *
 * Core fields (name, company, the 3 star ratings, confidence, positive feedback,
 * issues/concerns) are stored in dedicated columns since they're common to every
 * tab today. Everything else posted by the form (themed_q1, themed_q2, and any
 * new/renamed fields added in future form revisions) is captured automatically
 * into the `extra_data` JSON column, so the table does not need to be altered
 * whenever the themed questions change.
 */

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/db.php';

function handle_feedback_submission(string $themeKey): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        json_response(['success' => false, 'message' => 'Invalid request method.'], 405);
    }

    $map = THEME_TABLE_MAP;
    if (!isset($map[$themeKey])) {
        json_response(['success' => false, 'message' => 'Unknown form tab.'], 400);
    }
    $table = $map[$themeKey]['table'];
    $themeLabel = $map[$themeKey]['label'];

    // ── Core fields, common across all 4 tabs today ──
    $contactName   = clean_text($_POST['contact_name'] ?? '');
    $company       = clean_text($_POST['company'] ?? '');
    $overall       = clean_text($_POST['overall_satisfaction'] ?? '');
    $serviceQ      = clean_text($_POST['service_quality'] ?? '');
    $commsQ        = clean_text($_POST['communication'] ?? '');
    $confidence    = clean_text($_POST['confidence'] ?? '');
    $positive      = clean_text($_POST['positive_feedback'] ?? '');

    // "Any issues or concerns?" — optional. Only generate a ticket if filled in.
    $issues        = clean_optional($_POST['issues_concerns'] ?? null);
    $ticketId      = $issues !== null ? generate_ticket_id() : null;

    // ── Validate required fields ──
    $errors = [];
    if ($contactName === '') $errors[] = 'Your name is required.';
    if ($company === '')     $errors[] = 'Company name is required.';
    if ($overall === '')     $errors[] = 'Overall satisfaction rating is required.';
    if ($serviceQ === '')    $errors[] = 'Service quality rating is required.';
    if ($commsQ === '')      $errors[] = 'Communication rating is required.';
    if ($confidence === '')  $errors[] = 'Confidence rating is required.';
    if ($positive === '')    $errors[] = 'Please tell us what went well.';

    if (!empty($errors)) {
        json_response(['success' => false, 'message' => implode(' ', $errors)], 422);
    }

    // ── Anything else posted (themed_q1, themed_q2, future/renamed fields, etc.) ──
    $knownFields = [
        'contact_name', 'company', 'overall_satisfaction', 'service_quality',
        'communication', 'confidence', 'positive_feedback', 'issues_concerns',
        'feedback_theme',
    ];
    $extra = [];
    foreach ($_POST as $key => $value) {
        if (in_array($key, $knownFields, true)) continue;
        $extra[$key] = is_string($value) ? trim($value) : $value;
    }
    $extraJson = json_encode($extra, JSON_UNESCAPED_UNICODE);

    $ip = $_SERVER['REMOTE_ADDR'] ?? null;

    $pdo = get_db_connection();

    $sql = "INSERT INTO `{$table}`
            (ticket_id, contact_name, company, overall_satisfaction, service_quality,
             communication, confidence, positive_feedback, issues_concerns,
             extra_data, ip_address, submitted_at)
            VALUES
            (:ticket_id, :contact_name, :company, :overall, :service_q,
             :comms, :confidence, :positive, :issues,
             :extra_data, :ip, NOW())";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':ticket_id'   => $ticketId,
        ':contact_name'=> $contactName,
        ':company'     => $company,
        ':overall'     => $overall,
        ':service_q'   => $serviceQ,
        ':comms'       => $commsQ,
        ':confidence'  => $confidence,
        ':positive'    => $positive,
        ':issues'      => $issues,
        ':extra_data'  => $extraJson,
        ':ip'          => $ip,
    ]);

    json_response([
        'success'   => true,
        'message'   => 'Thank you — your feedback has been recorded.',
        'ticket_id' => $ticketId,
        'theme'     => $themeLabel,
    ]);
}
