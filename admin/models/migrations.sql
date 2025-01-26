-- 2nd March 2024

ALTER TABLE `widgets` CHANGE COLUMN `published` `published` int NOT NULL DEFAULT(1);
ALTER TABLE `blog_articles` ADD COLUMN `author_name` VARCHAR(255) AFTER id;

-- 5th March 2024
-- Created contacts table
-- Created enquiries table