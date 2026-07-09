<?php
/**
 * includes/helpers.php
 * Small shared utility functions used by the submit endpoints and admin panel.
 */

/**
 * Generates a unique, human-readable ticket ID, e.g. TCK-20260709-4F82
 */
function generate_ticket_id(): string
{
    $date  = date('Ymd');
    $rand  = strtoupper(substr(bin2hex(random_bytes(4)), 0, 4));
    return TICKET_PREFIX . '-' . $date . '-' . $rand;
}

/**
 * Trims a value and returns null if the result is an empty string.
 * Used so optional fields (like "Any issues or concerns?") store NULL
 * rather than an empty string when left blank.
 */
function clean_optional(?string $value): ?string
{
    if ($value === null) return null;
    $value = trim($value);
    return $value === '' ? null : $value;
}

/**
 * Trims a required text value.
 */
function clean_text(?string $value): string
{
    return trim((string) $value);
}

/**
 * Sends a JSON response and stops execution.
 */
function json_response(array $payload, int $statusCode = 200): void
{
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($payload);
    exit;
}

/**
 * Basic HTML escaping shortcut for the admin panel views.
 */
function h(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}
