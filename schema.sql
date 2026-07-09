-- ─────────────────────────────────────────────────────────────────
-- schema.sql
-- One table per form tab (Operations / Communication / Commercial /
-- Relationship). All 4 share the same structure:
--   - a fixed set of columns for the questions common to every tab
--     today (name, company, 3 star ratings, confidence, positive
--     feedback, optional issues/concerns + auto ticket id)
--   - an `extra_data` JSON column that stores whatever themed
--     questions/fields were on the form at the time of submission.
--     This means if the themed questions for a tab change in future,
--     you do NOT need to alter the table — new fields just land in
--     `extra_data` automatically.
-- ─────────────────────────────────────────────────────────────────

CREATE DATABASE IF NOT EXISTS nautilus_feedback
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE nautilus_feedback;

-- Tab A — Operations & Vessel Performance
CREATE TABLE IF NOT EXISTS feedback_operations (
  id                    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  ticket_id             VARCHAR(30)  NULL,
  contact_name          VARCHAR(150) NOT NULL,
  company               VARCHAR(150) NOT NULL,
  overall_satisfaction  VARCHAR(50)  NOT NULL,
  service_quality       VARCHAR(50)  NOT NULL,
  communication         VARCHAR(50)  NOT NULL,
  confidence            VARCHAR(50)  NOT NULL,
  positive_feedback     TEXT         NOT NULL,
  issues_concerns       TEXT         NULL,
  extra_data            JSON         NULL,
  ip_address            VARCHAR(45)  NULL,
  submitted_at          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_ticket (ticket_id),
  INDEX idx_submitted (submitted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tab B — Communication & Responsiveness
CREATE TABLE IF NOT EXISTS feedback_communication (
  id                    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  ticket_id             VARCHAR(30)  NULL,
  contact_name          VARCHAR(150) NOT NULL,
  company               VARCHAR(150) NOT NULL,
  overall_satisfaction  VARCHAR(50)  NOT NULL,
  service_quality       VARCHAR(50)  NOT NULL,
  communication         VARCHAR(50)  NOT NULL,
  confidence            VARCHAR(50)  NOT NULL,
  positive_feedback     TEXT         NOT NULL,
  issues_concerns       TEXT         NULL,
  extra_data            JSON         NULL,
  ip_address            VARCHAR(45)  NULL,
  submitted_at          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_ticket (ticket_id),
  INDEX idx_submitted (submitted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tab C — Commercial & Value for Money
CREATE TABLE IF NOT EXISTS feedback_commercial (
  id                    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  ticket_id             VARCHAR(30)  NULL,
  contact_name          VARCHAR(150) NOT NULL,
  company               VARCHAR(150) NOT NULL,
  overall_satisfaction  VARCHAR(50)  NOT NULL,
  service_quality       VARCHAR(50)  NOT NULL,
  communication         VARCHAR(50)  NOT NULL,
  confidence            VARCHAR(50)  NOT NULL,
  positive_feedback     TEXT         NOT NULL,
  issues_concerns       TEXT         NULL,
  extra_data            JSON         NULL,
  ip_address            VARCHAR(45)  NULL,
  submitted_at          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_ticket (ticket_id),
  INDEX idx_submitted (submitted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tab D — Relationship & Strategic Review
CREATE TABLE IF NOT EXISTS feedback_relationship (
  id                    INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  ticket_id             VARCHAR(30)  NULL,
  contact_name          VARCHAR(150) NOT NULL,
  company               VARCHAR(150) NOT NULL,
  overall_satisfaction  VARCHAR(50)  NOT NULL,
  service_quality       VARCHAR(50)  NOT NULL,
  communication         VARCHAR(50)  NOT NULL,
  confidence            VARCHAR(50)  NOT NULL,
  positive_feedback     TEXT         NOT NULL,
  issues_concerns       TEXT         NULL,
  extra_data            JSON         NULL,
  ip_address            VARCHAR(45)  NULL,
  submitted_at          DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_ticket (ticket_id),
  INDEX idx_submitted (submitted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
