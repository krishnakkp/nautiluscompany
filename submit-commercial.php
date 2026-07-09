<?php
/**
 * submit-commercial.php
 * Public endpoint for Tab C — writes into the feedback_commercial table.
 * Called via AJAX (fetch/FormData) from feedback-form.html when the form
 * is loaded with ?t=c
 */

require_once __DIR__ . "/config.php";
require_once __DIR__ . "/includes/handler.php";

handle_feedback_submission("c");
