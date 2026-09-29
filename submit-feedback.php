<?php
/**
 * submit-feedback.php
 * Public endpoint for the unified quarterly client feedback form.
 * Called via AJAX (fetch/FormData) from index.php.
 */

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/handler.php';

handle_feedback_submission();
