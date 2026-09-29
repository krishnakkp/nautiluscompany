-- schema.sql
-- Single table for the quarterly client feedback form.

CREATE DATABASE IF NOT EXISTS docscompanynautilus
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE docscompanynautilus;

-- Drop legacy theme-split tables (no longer used)
DROP TABLE IF EXISTS feedback_operations;
DROP TABLE IF EXISTS feedback_communication;
DROP TABLE IF EXISTS feedback_commercial;
DROP TABLE IF EXISTS feedback_relationship;

CREATE TABLE IF NOT EXISTS feedback_submissions (
  id                      INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  ticket_id               VARCHAR(30)  NULL,
  survey_period           VARCHAR(50)  NULL,
  contact_name            VARCHAR(150) NOT NULL,
  company                 VARCHAR(150) NOT NULL,
  overall_satisfaction    VARCHAR(50)  NOT NULL,
  service_quality         VARCHAR(50)  NOT NULL,
  communication           VARCHAR(50)  NOT NULL,
  confidence              VARCHAR(50)  NOT NULL,
  positive_feedback       TEXT         NOT NULL,
  issues_concerns         TEXT         NOT NULL,
  operations_feedback     TEXT         NOT NULL,
  communication_feedback  TEXT         NOT NULL,
  commercial_feedback     TEXT         NOT NULL,
  relationship_feedback   TEXT         NOT NULL,
  other_comments          TEXT         NULL,
  extra_data              JSON         NULL,
  ip_address              VARCHAR(45)  NULL,
  submitted_at            DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_ticket (ticket_id),
  INDEX idx_survey_period (survey_period),
  INDEX idx_submitted (submitted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
