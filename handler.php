<?php
/**
 * includes/handler.php
 *
 * Shared logic for handling a quarterly feedback submission into the
 * single feedback_submissions table. All areas (operations, communication,
 * commercial, relationship) are collected in one form and stored as
 * dedicated columns.
 */

require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/db.php';

function handle_feedback_submission(): void
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        json_response(['success' => false, 'message' => 'Invalid request method.'], 405);
    }

    $table = FEEDBACK_TABLE;

    // ── Core identity + ratings ──
    $contactName   = clean_text($_POST['contact_name'] ?? '');
    $company       = clean_text($_POST['company'] ?? '');
    $overall       = clean_text($_POST['overall_satisfaction'] ?? '');
    $serviceQ      = clean_text($_POST['service_quality'] ?? '');
    $commsQ        = clean_text($_POST['communication'] ?? '');
    $confidence    = clean_text($_POST['confidence'] ?? '');
    $surveyPeriod  = clean_optional($_POST['survey_period'] ?? null);

    // ── Step 3 comments (all required except other_comments) ──
    $positive      = clean_text($_POST['positive_feedback'] ?? '');
    $issues        = clean_text($_POST['issues_concerns'] ?? '');
    $operations    = clean_text($_POST['operations_feedback'] ?? '');
    $commsFb       = clean_text($_POST['communication_feedback'] ?? '');
    $commercial    = clean_text($_POST['commercial_feedback'] ?? '');
    $relationship  = clean_text($_POST['relationship_feedback'] ?? '');
    $otherComments = clean_optional($_POST['other_comments'] ?? null);

    // Ticket is created when issues/concerns are provided (always required now).
    $ticketId = $issues !== '' ? generate_ticket_id() : null;

    // ── Validate required fields ──
    $errors = [];
    if ($contactName === '')  $errors[] = 'Your name is required.';
    if ($company === '')      $errors[] = 'Company name is required.';
    if ($overall === '')      $errors[] = 'Overall satisfaction rating is required.';
    if ($serviceQ === '')     $errors[] = 'Service quality rating is required.';
    if ($commsQ === '')       $errors[] = 'Communication rating is required.';
    if ($confidence === '')   $errors[] = 'Confidence rating is required.';
    if ($positive === '')     $errors[] = 'Please tell us what went well.';
    if ($issues === '')       $errors[] = 'Please share any issues or concerns.';
    if ($operations === '')   $errors[] = 'Operations feedback is required.';
    if ($commsFb === '')      $errors[] = 'Communication feedback is required.';
    if ($commercial === '')   $errors[] = 'Commercial feedback is required.';
    if ($relationship === '') $errors[] = 'Partnership feedback is required.';

    if (!empty($errors)) {
        json_response(['success' => false, 'message' => implode(' ', $errors)], 422);
    }

    // ── Capture any unexpected extra fields into JSON ──
    $knownFields = [
        'contact_name', 'company', 'overall_satisfaction', 'service_quality',
        'communication', 'confidence', 'survey_period',
        'positive_feedback', 'issues_concerns',
        'operations_feedback', 'communication_feedback',
        'commercial_feedback', 'relationship_feedback', 'other_comments',
    ];
    $extra = [];
    foreach ($_POST as $key => $value) {
        if (in_array($key, $knownFields, true)) continue;
        $extra[$key] = is_string($value) ? trim($value) : $value;
    }
    $extraJson = !empty($extra) ? json_encode($extra, JSON_UNESCAPED_UNICODE) : null;

    $ip = $_SERVER['REMOTE_ADDR'] ?? null;
    $pdo = get_db_connection();

    $sql = "INSERT INTO `{$table}`
            (ticket_id, survey_period, contact_name, company,
             overall_satisfaction, service_quality, communication, confidence,
             positive_feedback, issues_concerns,
             operations_feedback, communication_feedback,
             commercial_feedback, relationship_feedback, other_comments,
             extra_data, ip_address, submitted_at)
            VALUES
            (:ticket_id, :survey_period, :contact_name, :company,
             :overall, :service_q, :comms, :confidence,
             :positive, :issues,
             :operations, :comms_fb,
             :commercial, :relationship, :other_comments,
             :extra_data, :ip, NOW())";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':ticket_id'     => $ticketId,
        ':survey_period' => $surveyPeriod,
        ':contact_name'  => $contactName,
        ':company'       => $company,
        ':overall'       => $overall,
        ':service_q'     => $serviceQ,
        ':comms'         => $commsQ,
        ':confidence'    => $confidence,
        ':positive'      => $positive,
        ':issues'        => $issues,
        ':operations'    => $operations,
        ':comms_fb'      => $commsFb,
        ':commercial'    => $commercial,
        ':relationship'  => $relationship,
        ':other_comments'=> $otherComments,
        ':extra_data'    => $extraJson,
        ':ip'            => $ip,
    ]);

    json_response([
        'success'   => true,
        'message'   => 'Thank you — your feedback has been recorded.',
        'ticket_id' => $ticketId,
    ]);
}
