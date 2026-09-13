-- Idempotent schema migration for the reviews table.
-- Ensures the table exists and has a `role` column so the frontend
-- carousel can render "Swahili Student" / "French Student" style
-- designations under each reviewer name.
--
-- Truehost MySQL < 8.0.29 does not support ADD COLUMN IF NOT EXISTS.
-- If the ALTER TABLE below errors with a syntax error, run the plain
-- ALTER TABLE `reviews` ADD COLUMN `role` VARCHAR(100) NULL AFTER `rating`;
-- statement instead.

CREATE TABLE IF NOT EXISTS `reviews` (
    `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name`         VARCHAR(120) NOT NULL,
    `email`        VARCHAR(190) NULL,
    `review`       TEXT NOT NULL,
    `rating`       TINYINT UNSIGNED NOT NULL DEFAULT 5,
    `role`         VARCHAR(100) NULL,
    `image_path`   VARCHAR(255) NULL,
    `is_published` TINYINT(1) NOT NULL DEFAULT 0,
    `created_at`   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at`   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_reviews_published_created` (`is_published`, `created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `reviews`
    ADD COLUMN IF NOT EXISTS `role` VARCHAR(100) NULL AFTER `rating`;
