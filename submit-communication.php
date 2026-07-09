<?php
/**
 * submit-communication.php
 * Public endpoint for Tab B — writes into the feedback_communication table.
 * Called via AJAX (fetch/FormData) from feedback-form.html when the form
 * is loaded with ?t=b
 */

require_once __DIR__ . "/config.php";
require_once __DIR__ . "/includes/handler.php";

handle_feedback_submission("b");
