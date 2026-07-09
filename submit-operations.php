<?php
/**
 * submit-operations.php
 * Public endpoint for Tab A — writes into the feedback_operations table.
 * Called via AJAX (fetch/FormData) from feedback-form.html when the form
 * is loaded with ?t=a
 */

require_once __DIR__ . "/config.php";
require_once __DIR__ . "/includes/handler.php";

handle_feedback_submission("a");
