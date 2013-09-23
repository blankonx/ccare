/*level 0*/
DROP VIEW IF EXISTS `expert_anamnese_diagnoses_level0`;
CREATE VIEW `expert_anamnese_diagnoses_level0` AS
SELECT 
	`ex`.`id` AS `id`,
	`ra`.`id` AS `anamnese_id`,
	`ra`.`name` AS `name`,
	`ex`.`score` AS `score`,
	`ri`.`id` AS `icd_id`,
	`ri`.`name` AS `icd_name`
FROM 
	`expert_anamnese_diagnoses` `ex` 
	JOIN `ref_anamneses` `ra` ON(`ra`.`id` = `ex`.`anamnese_id`) 
	LEFT JOIN `ref_icds` `ri` ON (`ri`.`id` = `ex`.`icd_id`)
WHERE 
	`ex`.`parent_id`=0
ORDER BY `ex`.`parent_id`;


/*level 1*/
DROP VIEW IF EXISTS `expert_anamnese_diagnoses_level1`;
CREATE VIEW `expert_anamnese_diagnoses_level1` AS
SELECT 
	`ex`.`id` AS `id`,
	`ra`.`id` AS `anamnese_id`,
	CONCAT_WS(', ',`parent`.`name`, `ra`.`name`) AS `name`,
	`ex`.`score` AS `score`,
	`ri`.`id` AS `icd_id`,
	`ri`.`name` AS `icd_name`
FROM 
	`expert_anamnese_diagnoses` `ex` 
	JOIN `ref_anamneses` `ra` ON(`ra`.`id` = `ex`.`anamnese_id`) 
	LEFT JOIN `ref_icds` `ri` ON (`ri`.`id` = `ex`.`icd_id`)
	JOIN `expert_anamnese_diagnoses_level0` `parent` ON (`parent`.`id` = `ex`.`parent_id`)
ORDER BY `ex`.`parent_id`;


/*level 2*/
DROP VIEW IF EXISTS `expert_anamnese_diagnoses_level2`;
CREATE VIEW `expert_anamnese_diagnoses_level2` AS
SELECT 
	`ex`.`id` AS `id`,
	`ra`.`id` AS `anamnese_id`,
	CONCAT_WS(', ',`parent`.`name`, `ra`.`name`) AS `name`,
	`ex`.`score` AS `score`,
	`ri`.`id` AS `icd_id`,
	`ri`.`name` AS `icd_name`
FROM 
	`expert_anamnese_diagnoses` `ex` 
	JOIN `ref_anamneses` `ra` ON(`ra`.`id` = `ex`.`anamnese_id`) 
	LEFT JOIN `ref_icds` `ri` ON (`ri`.`id` = `ex`.`icd_id`)
	JOIN `expert_anamnese_diagnoses_level1` `parent` ON (`parent`.`id` = `ex`.`parent_id`)
ORDER BY `ex`.`parent_id`;


/*level 3*/
DROP VIEW IF EXISTS `expert_anamnese_diagnoses_level3`;
CREATE VIEW `expert_anamnese_diagnoses_level3` AS
SELECT 
	`ex`.`id` AS `id`,
	`ra`.`id` AS `anamnese_id`,
	CONCAT_WS(', ',`parent`.`name`, `ra`.`name`) AS `name`,
	`ex`.`score` AS `score`,
	`ri`.`id` AS `icd_id`,
	`ri`.`name` AS `icd_name`
FROM 
	`expert_anamnese_diagnoses` `ex` 
	JOIN `ref_anamneses` `ra` ON(`ra`.`id` = `ex`.`anamnese_id`) 
	LEFT JOIN `ref_icds` `ri` ON (`ri`.`id` = `ex`.`icd_id`)
	JOIN `expert_anamnese_diagnoses_level2` `parent` ON (`parent`.`id` = `ex`.`parent_id`)
ORDER BY `ex`.`parent_id`;


/*level 4*/
DROP VIEW IF EXISTS `expert_anamnese_diagnoses_level4`;
CREATE VIEW `expert_anamnese_diagnoses_level4` AS
SELECT 
	`ex`.`id` AS `id`,
	`ra`.`id` AS `anamnese_id`,
	CONCAT_WS(', ',`parent`.`name`, `ra`.`name`) AS `name`,
	`ex`.`score` AS `score`,
	`ri`.`id` AS `icd_id`,
	`ri`.`name` AS `icd_name`
FROM 
	`expert_anamnese_diagnoses` `ex` 
	JOIN `ref_anamneses` `ra` ON(`ra`.`id` = `ex`.`anamnese_id`) 
	LEFT JOIN `ref_icds` `ri` ON (`ri`.`id` = `ex`.`icd_id`)
	JOIN `expert_anamnese_diagnoses_level3` `parent` ON (`parent`.`id` = `ex`.`parent_id`)
ORDER BY `ex`.`parent_id`;



/*level 5*/
DROP VIEW IF EXISTS `expert_anamnese_diagnoses_level5`;
CREATE VIEW `expert_anamnese_diagnoses_level5` AS
SELECT 
	`ex`.`id` AS `id`,
	`ra`.`id` AS `anamnese_id`,
	CONCAT_WS(', ',`parent`.`name`, `ra`.`name`) AS `name`,
	`ex`.`score` AS `score`,
	`ri`.`id` AS `icd_id`,
	`ri`.`name` AS `icd_name`
FROM 
	`expert_anamnese_diagnoses` `ex` 
	JOIN `ref_anamneses` `ra` ON(`ra`.`id` = `ex`.`anamnese_id`) 
	LEFT JOIN `ref_icds` `ri` ON (`ri`.`id` = `ex`.`icd_id`)
	JOIN `expert_anamnese_diagnoses_level4` `parent` ON (`parent`.`id` = `ex`.`parent_id`)
ORDER BY `ex`.`parent_id`;


/*level 6*/
DROP VIEW IF EXISTS `expert_anamnese_diagnoses_level6`;
CREATE VIEW `expert_anamnese_diagnoses_level6` AS
SELECT 
	`ex`.`id` AS `id`,
	`ra`.`id` AS `anamnese_id`,
	CONCAT_WS(', ',`parent`.`name`, `ra`.`name`) AS `name`,
	`ex`.`score` AS `score`,
	`ri`.`id` AS `icd_id`,
	`ri`.`name` AS `icd_name`
FROM 
	`expert_anamnese_diagnoses` `ex` 
	JOIN `ref_anamneses` `ra` ON(`ra`.`id` = `ex`.`anamnese_id`) 
	LEFT JOIN `ref_icds` `ri` ON (`ri`.`id` = `ex`.`icd_id`)
	JOIN `expert_anamnese_diagnoses_level5` `parent` ON (`parent`.`id` = `ex`.`parent_id`)
ORDER BY `ex`.`parent_id`;



/*level 7*/
DROP VIEW IF EXISTS `expert_anamnese_diagnoses_level7`;
CREATE VIEW `expert_anamnese_diagnoses_level7` AS
SELECT 
	`ex`.`id` AS `id`,
	`ra`.`id` AS `anamnese_id`,
	CONCAT_WS(', ',`parent`.`name`, `ra`.`name`) AS `name`,
	`ex`.`score` AS `score`,
	`ri`.`id` AS `icd_id`,
	`ri`.`name` AS `icd_name`
FROM 
	`expert_anamnese_diagnoses` `ex` 
	JOIN `ref_anamneses` `ra` ON(`ra`.`id` = `ex`.`anamnese_id`) 
	LEFT JOIN `ref_icds` `ri` ON (`ri`.`id` = `ex`.`icd_id`)
	JOIN `expert_anamnese_diagnoses_level6` `parent` ON (`parent`.`id` = `ex`.`parent_id`)
ORDER BY `ex`.`parent_id`;



/*level 8*/
DROP VIEW IF EXISTS `expert_anamnese_diagnoses_level8`;
CREATE VIEW `expert_anamnese_diagnoses_level8` AS
SELECT 
	`ex`.`id` AS `id`,
	`ra`.`id` AS `anamnese_id`,
	CONCAT_WS(', ',`parent`.`name`, `ra`.`name`) AS `name`,
	`ex`.`score` AS `score`,
	`ri`.`id` AS `icd_id`,
	`ri`.`name` AS `icd_name`
FROM 
	`expert_anamnese_diagnoses` `ex` 
	JOIN `ref_anamneses` `ra` ON(`ra`.`id` = `ex`.`anamnese_id`) 
	LEFT JOIN `ref_icds` `ri` ON (`ri`.`id` = `ex`.`icd_id`)
	JOIN `expert_anamnese_diagnoses_level7` `parent` ON (`parent`.`id` = `ex`.`parent_id`)
ORDER BY `ex`.`parent_id`;



/*level 9*/
DROP VIEW IF EXISTS `expert_anamnese_diagnoses_level9`;
CREATE VIEW `expert_anamnese_diagnoses_level9` AS
SELECT 
	`ex`.`id` AS `id`,
	`ra`.`id` AS `anamnese_id`,
	CONCAT_WS(', ',`parent`.`name`, `ra`.`name`) AS `name`,
	`ex`.`score` AS `score`,
	`ri`.`id` AS `icd_id`,
	`ri`.`name` AS `icd_name`
FROM 
	`expert_anamnese_diagnoses` `ex` 
	JOIN `ref_anamneses` `ra` ON(`ra`.`id` = `ex`.`anamnese_id`) 
	LEFT JOIN `ref_icds` `ri` ON (`ri`.`id` = `ex`.`icd_id`)
	JOIN `expert_anamnese_diagnoses_level8` `parent` ON (`parent`.`id` = `ex`.`parent_id`)
ORDER BY `ex`.`parent_id`;


/*level 10*/
DROP VIEW IF EXISTS `expert_anamnese_diagnoses_level10`;
CREATE VIEW `expert_anamnese_diagnoses_level10` AS
SELECT 
	`ex`.`id` AS `id`,
	`ra`.`id` AS `anamnese_id`,
	CONCAT_WS(', ',`parent`.`name`, `ra`.`name`) AS `name`,
	`ex`.`score` AS `score`,
	`ri`.`id` AS `icd_id`,
	`ri`.`name` AS `icd_name`
FROM 
	`expert_anamnese_diagnoses` `ex` 
	JOIN `ref_anamneses` `ra` ON(`ra`.`id` = `ex`.`anamnese_id`) 
	LEFT JOIN `ref_icds` `ri` ON (`ri`.`id` = `ex`.`icd_id`)
	JOIN `expert_anamnese_diagnoses_level9` `parent` ON (`parent`.`id` = `ex`.`parent_id`)
ORDER BY `ex`.`parent_id`;

