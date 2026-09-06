-- Idempotent schema migration for the faqs table.
-- Safe to run on prod via phpMyAdmin or `mysql < faqs-schema.sql`.
-- Run once after deploying the FAQ CMS wiring.

CREATE TABLE IF NOT EXISTS `faqs` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `question`   TEXT NOT NULL,
    `answer`     TEXT NOT NULL,
    `category`   VARCHAR(64) NOT NULL DEFAULT 'Getting Started',
    `published`  TINYINT(1) NOT NULL DEFAULT 0,
    `author`     INT UNSIGNED NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_faqs_category_published` (`category`, `published`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add `category` column if the table existed already without it.
-- MySQL 8.0.29+ supports IF NOT EXISTS on ADD COLUMN; on older MySQL
-- run this block manually if the column is missing:
--   ALTER TABLE `faqs` ADD COLUMN `category` VARCHAR(64) NOT NULL
--     DEFAULT 'Getting Started' AFTER `answer`;
--   ALTER TABLE `faqs` ADD INDEX `idx_faqs_category_published` (`category`, `published`);
ALTER TABLE `faqs`
    ADD COLUMN IF NOT EXISTS `category` VARCHAR(64) NOT NULL
        DEFAULT 'Getting Started' AFTER `answer`;

ALTER TABLE `faqs`
    ADD INDEX IF NOT EXISTS `idx_faqs_category_published` (`category`, `published`);
