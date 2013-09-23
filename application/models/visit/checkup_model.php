<?php
Class Checkup_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
	function GetData($visit_id) {
		//get the current selected data
		$sql = $this->db->query("
			SELECT
                v.`id` as `visit_id`,
				CONCAT(p.`family_folder`, '-', p.`family_relationship_id`) as `mr_number`,
                p.nik,
				p.id as patient_id,
				p.family_folder as family_folder,
				p.family_relationship_id as family_relationship_id,
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
                rpt.name as payment_type,
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
                JOIN ref_payment_types rpt ON (rpt.id = v.payment_type_id)
			WHERE
				v.`id`=?
		",
			array(
                $visit_id,
                $visit_id,
                $visit_id,
                $visit_id
            )
		);
        //echo "<pre>" .$this->db->last_query() . "</pre>";
		return $sql->row_array();
	}

    function GetModule($visitId) {
        $sql = $this->db->query("
            SELECT 
                rm.`id` as `id`, 
                rm.`name` as `name`, 
                rm.`filename` as `filename`,
                CONCAT_WS('/', '..', rm.`group`, rm.`filename`, 'home', v.id) as `path`
            FROM 
                ref_modules rm 
                JOIN clinic_modules cm ON (cm.module_id = rm.id)
                JOIN visits v ON (v.clinic_id = cm.clinic_id)
            WHERE v.id=?
            ORDER BY rm.ordering
        ",
            array(
                $visitId    
            )
        );
        return $sql->result_array();
    }

    function GetPregnant($visitId) {
        $sql = $this->db->query("
            SELECT 
                p.id as id,
                p.g as g
            FROM
                visits v
                JOIN pregnants p ON (p.visit_id = v.id)
            WHERE
                v.patient_id = (SELECT patient_id FROM visits WHERE id=?)
                AND p.`log`='no'
            GROUP BY p.id
            ORDER BY p.id DESC
        ",
        array(
            $visitId
        ));
        //echo $this->db->last_query();

        if($sql->num_rows() > 0) {
            return $sql->result_array();
        } else {
            return false;
        }
    
    }
}
?>
