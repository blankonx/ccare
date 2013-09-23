<?php
Class Patient_Detail_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
	function GetData($visit_id) {
		//get the current selected data
		$sql = $this->db->query("
			SELECT
				CONCAT(p.`family_folder`) as `mr_number`,
				p.`name`,
				p.`birth_place`,
				p.`sex` as `sex`,
				DATE_FORMAT(p.`birth_date`, '%d/%m/%y') as `birth_date`, 
				v.`date` as `visit_date`,
				CONCAT_WS(', ', v.`address`) as `address`,
				j.`name` as `job_name`
			FROM 
				`patients` p
				JOIN `visits` v ON (v.`family_folder` = p.`family_folder`)
				JOIN `ref_jobs` j ON (j.`id` = v.`job_id`)
			WHERE
				v.`id`=?
		",
			array($visit_id)
		);
		return $sql->row_array();
	}
/*
    function getData($id, $code) {
		$sql_latest = $this->db->query("
			SELECT 
				MAX(tempResult.date), 
				tempResult.name, 
				tempResult.parent_name, 
				tempResult.birth_place, 
				tempResult.birth_date,  
				tempResult.address, 
				tempResult.village_id, 
				tempResult.education_id, 
				tempResult.job_id, 
				tempResult.payment_type_id, 
				tempResult.insurance_no 
			FROM (
				SELECT
					p.id as patient_id,
					p.family_code as patient_family_code,
					p.name as name,
					p.parent_name as parent_name,
					p.birth_place as birth_place,
					p.birth_date as birth_date,
					v.date,
					v.address,
					v.village_id,
					v.education_id,
					v.job_id,
					v.payment_type_id,
					v.insurance_no
				FROM
					visits v JOIN
					patients p ON (p.id = v.patient_id AND p.family_code=v.patient_family_code)
				WHERE 
					p.id=?
					AND p.family_code=? 
					AND date>=ALL(
							SELECT 
								date 
							FROM 
								visits 
							WHERE 
								patient_id=?
								AND patient_family_code=?
							)
				UNION

				SELECT
					p.id as patient_id,
					p.family_code as patient_family_code,
					p.name as name,
					p.parent_name as parent_name,
					p.birth_place as birth_place,
					p.birth_date as birth_date,
					v.date,
					v.address,
					v.village_id,
					v.education_id,
					v.job_id,
					v.payment_type_id,
					v.insurance_no
				FROM
					visits_outdoor v JOIN
					patients p ON (p.id = v.patient_id AND p.family_code=v.patient_family_code)
				WHERE 
					p.id=?
					AND p.family_code=? 
					AND date>=ALL(
							SELECT 
								date 
							FROM 
								visits_outdoor 
							WHERE 
								patient_id=?
								AND patient_family_code=?
							)) 
				AS tempResult GROUP BY tempResult.patient_id,tempResult.patient_family_code
		",
            array($id, $code, $id, $code, $id, $code, $id, $code)
		);
		
		return $sql_latest->row_array();
    }
	*/
}
?>
