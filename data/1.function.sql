SET GLOBAL log_bin_trust_function_creators=1; 

DROP FUNCTION IF EXISTS `numericToRom`;
DELIMITER |
CREATE FUNCTION `numericToRom` (num INT(2)) RETURNS CHAR(4)
BEGIN
	DECLARE rom CHAR(4) DEFAULT 'I';

	SELECT
	CASE 
	 WHEN num=1 THEN 'I'
	 WHEN num=2 THEN 'II'
	 WHEN num=3 THEN 'III'
	 WHEN num=4 THEN 'IV'
	 WHEN num=5 THEN 'V'
	 WHEN num=6 THEN 'VI'
	 WHEN num=7 THEN 'VII'
	 WHEN num=8 THEN 'VIII'
	 WHEN num=9 THEN 'IX'
	 WHEN num=10 THEN 'X'
	 WHEN num=11 THEN 'XI'
	 ELSE 'XII'
	END
	INTO @rom;
	RETURN @rom;
END 
|
DELIMITER ;

DROP FUNCTION IF EXISTS `getDateDiff`;
DELIMITER |
CREATE FUNCTION `getDateDiff` (visit_date DATE) RETURNS CHAR(20)
BEGIN
DECLARE ret CHAR(20) DEFAULT '-';
SELECT 
	CASE 
	WHEN (TIMESTAMPDIFF(YEAR, visit_date, NOW()) >=1) THEN CONCAT(TIMESTAMPDIFF(YEAR, visit_date, NOW()), ' tahun yg lalu')
	WHEN ((TIMESTAMPDIFF(MONTH, visit_date, NOW())) >= 1) THEN (CONCAT(TIMESTAMPDIFF(MONTH, visit_date, NOW()), ' bulan yg lalu'))
	WHEN ((TIMESTAMPDIFF(WEEK, visit_date, NOW())) >= 1) THEN (CONCAT(TIMESTAMPDIFF(WEEK, visit_date, NOW()), ' minggu yg lalu'))
	WHEN ((TIMESTAMPDIFF(DAY, visit_date, NOW())) > 1) THEN (CONCAT(TIMESTAMPDIFF(DAY, visit_date, NOW()), ' hari yg lalu'))
	WHEN ((TIMESTAMPDIFF(DAY, visit_date, NOW())) = 1) THEN 'kemarin'
	WHEN ((TIMESTAMPDIFF(DAY, visit_date, NOW())) = 0) THEN 'hari ini'
	WHEN (TIMESTAMPDIFF(HOUR, visit_date, NOW()) > 1) THEN CONCAT((TIMESTAMPDIFF(HOUR, visit_date, NOW())), ' jam yg lalu')
	ELSE CONCAT((TIMESTAMPDIFF(MINUTE, visit_date, NOW())), ' menit yg lalu')
	END INTO @ret;
RETURN @ret;
END
|
DELIMITER ;


/*
DROP FUNCTION IF EXISTS `getDateDiff`;
DELIMITER |
CREATE FUNCTION `getDateDiff` (visit_date DATE) RETURNS CHAR(20)
BEGIN
DECLARE ret CHAR(20) DEFAULT '-';
SELECT 
	CASE 
	WHEN (TIMESTAMPDIFF(YEAR, visit_date, NOW()) >=1) THEN CONCAT(TIMESTAMPDIFF(YEAR, visit_date, NOW()), ' years ago')
	WHEN ((TIMESTAMPDIFF(MONTH, visit_date, NOW())) > 1) THEN (CONCAT(TIMESTAMPDIFF(MONTH, visit_date, NOW()), ' months ago'))
	WHEN ((TIMESTAMPDIFF(WEEK, visit_date, NOW())) > 1) THEN (CONCAT(TIMESTAMPDIFF(WEEK, visit_date, NOW()), ' weeks ago'))
	WHEN ((TIMESTAMPDIFF(DAY, visit_date, NOW())) > 1) THEN (CONCAT(TIMESTAMPDIFF(DAY, visit_date, NOW()), ' days ago'))
	WHEN ((TIMESTAMPDIFF(DAY, visit_date, NOW())) = 1) THEN 'yesterday'
	WHEN ((TIMESTAMPDIFF(DAY, visit_date, NOW())) = 0) THEN 'today'
	WHEN (TIMESTAMPDIFF(HOUR, visit_date, NOW()) > 1) THEN CONCAT((TIMESTAMPDIFF(HOUR, visit_date, NOW())), ' hours ago')
	ELSE CONCAT((TIMESTAMPDIFF(MINUTE, visit_date, NOW())), ' minutes ago')
	END INTO @ret;
RETURN @ret;
END
|
DELIMITER ;
*/


DROP FUNCTION IF EXISTS `getAgeAsYear`;
DELIMITER |
CREATE FUNCTION `getAgeAsYear` (visit_id INT) RETURNS INT(5)
BEGIN
DECLARE ret INT(5) DEFAULT '0';
SELECT 
	IFNULL(TIMESTAMPDIFF(YEAR, p.`birth_date`, v.`date`), 0) INTO @ret
FROM 
	visits v
	JOIN patients p ON (p.family_folder = v.family_folder)
WHERE
	v.id=visit_id;
RETURN @ret;
END
|
DELIMITER ;

DROP FUNCTION IF EXISTS `GetMRNumber`;
DELIMITER |
CREATE FUNCTION `GetMRNumber`() RETURNS INT(6)
BEGIN
DECLARE ret INT(6) DEFAULT '000000';
	SELECT MAX(family_folder)+1 INTO @ret FROM patients;
RETURN @ret;
END
|
DELIMITER ;

DROP FUNCTION IF EXISTS `GetBloodPressureRank`;
DELIMITER |
CREATE FUNCTION `GetBloodPressureRank`(sistole_val INT, diastole_val INT) RETURNS INT(3)
BEGIN
DECLARE ret INT(3);
	SELECT 
		IF(`sistole_rank`.`id` > `diastole_rank`.`id`, `sistole_rank`.`id`, `diastole_rank`.`id`) INTO @ret
	FROM 
		(SELECT
			`id`
		FROM
			`ref_blood_pressure_formula`
		WHERE
			sistole_val BETWEEN `sistole_min` AND `sistole_max`) as `sistole_rank`,
		(SELECT
			`id`
		FROM
			`ref_blood_pressure_formula`
		WHERE
			diastole_val BETWEEN `diastole_min` AND `diastole_max`) as `diastole_rank`;
RETURN @ret;
END
|
DELIMITER ;


/*TRIGGER INI BELUM JALAN
udah tak lembur pada tanggal 1/21/2009 tapi kok ya belum jalan*/
/*
DROP TRIGGER IF EXISTS `logger_child_of_pregnant` ;
DELIMITER |
CREATE TRIGGER `logger_child_of_pregnant` 
AFTER UPDATE ON `pregnants` 
FOR EACH ROW 
BEGIN 
	UPDATE `pregnant_family_history_diseases` SET `log`='yes' WHERE `pregnant_id`=OLD.`id`;
	UPDATE `pregnant_history_diseases` SET `log`='yes' WHERE `pregnant_id`=OLD.`id`;
END
|
DELIMITER ;
*/
/**/
/*
DROP TRIGGER IF EXISTS `logger_visit_pregnant_poedji_rochjati` ;
DELIMITER |
CREATE TRIGGER `logger_visit_pregnant_poedji_rochjati` 
AFTER UPDATE ON `visit_pregnants` 
FOR EACH ROW 
BEGIN 
	IF OLD.`log`='no' AND NEW.`log`='yes' THEN
		UPDATE `visit_pregnant_poedji_rochjati` SET `log`='yes' WHERE `visit_pregnant_id`=OLD.`id`;
	END IF;
END
|
DELIMITER ;
*/

/*membuat view*/

/*
		$data['age'] = array('0-7 hr', '8-28 hr', '1 bl-1 th', '1-4 th', '5-9 th', '10-14 th', '15-19 th', '20-44 th', '45-54 th', '55-59 th', '60-69 th', '&ge;70');
        */
        
DROP FUNCTION IF EXISTS `getKelompokUmur`;
DELIMITER |
CREATE FUNCTION `getKelompokUmur` (birth_date DATE, visit_date DATE) RETURNS CHAR(10)
BEGIN
DECLARE ret CHAR(10) DEFAULT '-';
SELECT 
	CASE
		WHEN (TIMESTAMPDIFF(DAY, birth_date, visit_date) < 7) THEN '0-7 hr'
		WHEN (TIMESTAMPDIFF(DAY, birth_date, visit_date) BETWEEN 8 AND 28) THEN '8-28 hr'
		WHEN (TIMESTAMPDIFF(DAY, birth_date, visit_date) > 28 AND TIMESTAMPDIFF(YEAR, birth_date, visit_date) < 1) THEN '1 bl-1 th'
		WHEN (TIMESTAMPDIFF(YEAR, birth_date, visit_date) BETWEEN 1 AND 4) THEN '1-4 th'
		WHEN (TIMESTAMPDIFF(YEAR, birth_date, visit_date) BETWEEN 5 AND 9) THEN '5-9 th'
		WHEN (TIMESTAMPDIFF(YEAR, birth_date, visit_date) BETWEEN 10 AND 14) THEN '10-14 th'
		WHEN (TIMESTAMPDIFF(YEAR, birth_date, visit_date) BETWEEN 15 AND 19) THEN '15-19 th'
		WHEN (TIMESTAMPDIFF(YEAR, birth_date, visit_date) BETWEEN 20 AND 44) THEN '20-44 th'
		WHEN (TIMESTAMPDIFF(YEAR, birth_date, visit_date) BETWEEN 45 AND 54) THEN '45-54 th'
		WHEN (TIMESTAMPDIFF(YEAR, birth_date, visit_date) BETWEEN 55 AND 59) THEN '55-59 th'
		WHEN (TIMESTAMPDIFF(YEAR, birth_date, visit_date) BETWEEN 60 AND 69) THEN '60-69 th'
		ELSE '&ge;70'
	END into @ret;
RETURN @ret;
END
|
DELIMITER ;


DROP FUNCTION IF EXISTS `getKelompokUmurX`;
DELIMITER |
CREATE FUNCTION `getKelompokUmurX` (birth_date DATE, visit_date DATE) RETURNS CHAR(2)
BEGIN
DECLARE ret CHAR(2) DEFAULT '-';
SELECT 
	CASE
		WHEN (TIMESTAMPDIFF(DAY, birth_date, visit_date) < 7) THEN '1'
		WHEN (TIMESTAMPDIFF(DAY, birth_date, visit_date) BETWEEN 8 AND 28) THEN '2'
		WHEN (TIMESTAMPDIFF(DAY, birth_date, visit_date) > 28 AND TIMESTAMPDIFF(YEAR, birth_date, visit_date) < 1) THEN '3'
		WHEN (TIMESTAMPDIFF(YEAR, birth_date, visit_date) BETWEEN 1 AND 4) THEN '4'
		WHEN (TIMESTAMPDIFF(YEAR, birth_date, visit_date) BETWEEN 5 AND 9) THEN '5'
		WHEN (TIMESTAMPDIFF(YEAR, birth_date, visit_date) BETWEEN 10 AND 14) THEN '6'
		WHEN (TIMESTAMPDIFF(YEAR, birth_date, visit_date) BETWEEN 15 AND 19) THEN '7'
		WHEN (TIMESTAMPDIFF(YEAR, birth_date, visit_date) BETWEEN 20 AND 44) THEN '8'
		WHEN (TIMESTAMPDIFF(YEAR, birth_date, visit_date) BETWEEN 45 AND 54) THEN '9'
		WHEN (TIMESTAMPDIFF(YEAR, birth_date, visit_date) BETWEEN 55 AND 59) THEN '10'
		WHEN (TIMESTAMPDIFF(YEAR, birth_date, visit_date) BETWEEN 60 AND 69) THEN '11'
		ELSE '12'
	END into @ret;
RETURN @ret;
END
|
DELIMITER ;


DROP FUNCTION IF EXISTS `getKelompokUmurK3`;
DELIMITER |
CREATE FUNCTION `getKelompokUmurK3` (birth_date DATE, visit_date DATE) RETURNS CHAR(2)
BEGIN
DECLARE ret CHAR(2) DEFAULT '-';
SELECT 
	CASE
		WHEN (TIMESTAMPDIFF(YEAR, birth_date, visit_date) BETWEEN 15 AND 44) THEN '1'
		WHEN (TIMESTAMPDIFF(YEAR, birth_date, visit_date) BETWEEN 45 AND 54) THEN '2'
		WHEN (TIMESTAMPDIFF(YEAR, birth_date, visit_date) BETWEEN 55 AND 64) THEN '3'
		ELSE '4'
	END into @ret;
RETURN @ret;
END
|
DELIMITER ;

/*
DROP FUNCTION IF EXISTS `getAnakDewasa`;
DELIMITER |
CREATE FUNCTION `getAnakDewasa` (visit_id INT) RETURNS CHAR(7)
BEGIN
DECLARE ret CHAR(7) DEFAULT '';
SELECT 
	CASE
		WHEN (TIMESTAMPDIFF(YEAR, p.`birth_date`, v.`date`) < 12) THEN 'Anak'
		ELSE 'Dewasa'
	END into @ret
FROM 
	visits v
	JOIN patients p ON (p.id = v.patient_id)
WHERE
	v.id=visit_id;
RETURN @ret;
END
|
DELIMITER ;
*/
