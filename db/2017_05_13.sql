ALTER TABLE `persons` ADD `doing` TEXT NULL DEFAULT NULL AFTER `phone`, ADD `interest` TEXT NULL DEFAULT NULL AFTER `doing`, ADD `music` TEXT NULL DEFAULT NULL AFTER `interest`, ADD `books` TEXT NULL DEFAULT NULL AFTER `music`, ADD `tv` TEXT NULL DEFAULT NULL AFTER `books`, ADD `quote` TEXT NULL DEFAULT NULL AFTER `tv`, ADD `about` TEXT NULL DEFAULT NULL AFTER `quote`;
ALTER TABLE shop ADD  partners varchar(255) NULL;

