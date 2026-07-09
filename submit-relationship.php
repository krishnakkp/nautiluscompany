<?php
/**
 * submit-relationship.php
 * Public endpoint for Tab D — writes into the feedback_relationship table.
 * Called via AJAX (fetch/FormData) from feedback-form.html when the form
 * is loaded with ?t=d
 */

require_once __DIR__ . "/config.php";
require_once __DIR__ . "/includes/handler.php";

handle_feedback_submission("d");
