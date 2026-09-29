-- Migration helper (optional)
-- Run on an existing docscompanynautilus database that still has the
-- old theme-split tables. Creates the new unified table.
-- Old tables (feedback_operations, feedback_communication,
-- feedback_commercial, feedback_relationship) are left in place so
-- you can archive/export them before dropping.

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
