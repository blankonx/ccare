<?php
Class Rawatjalan_Rujukan_Internal_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
	function GetData($visitId) {
		//get the current selected data
		$sql = $this->db->query("
			SELECT
                v.`id` as `visit_id`,
				CONCAT(p.`family_folder`, '-', p.`id`, '-', p.`family_relationship_id`) as `mr_number`,
				p.`name`,
				p.`parent_name`,
				p.`birth_place`,
				p.`sex` as `sex`,
				DATE_FORMAT(p.`birth_date`, '%d/%m/%y') as `birth_date`, 
				DATE_FORMAT(v.`date`, '%d/%m/%Y') as `visit_date_formatted`, 
				v.`date` as `visit_date`,
				p.birth_date as birth_date_for_age,
				DATE(v.date) as visit_date_for_age,
				CONCAT_WS(', ', v.`address`, rv.`name`, sd.`name`, d.`name`) as `address`,
				e.`name` as `education_name`,
				j.`name` as `job_name`,
                (
                    SELECT COUNT(*) 
                    FROM 
                        `visits` 
                    WHERE 
                        `patient_id`=(SELECT `patient_id` FROM `visits` WHERE `id`=?) 
                        AND `id` <=? 

                ) as `visit_count`
			FROM 
				`patients` p
				JOIN `visits` v ON (v.`patient_id` = p.`id`)
				JOIN `ref_villages` rv ON (rv.`id` = v.`village_id`)
				JOIN `ref_sub_districts` sd ON (sd.`id` = rv.`sub_district_id`)
				JOIN `ref_districts` d ON (d.`id` = sd.`district_id`)
				JOIN `ref_educations` e ON (e.`id` = v.`education_id`)
				JOIN `ref_jobs` j ON (j.`id` = v.`job_id`)
			WHERE
				v.`id`=?
		",
			array(
                $visitId,
                $visitId,
                $visitId,
                $visitId
            )
		);
		return $sql->row_array();
	}


}
?>
