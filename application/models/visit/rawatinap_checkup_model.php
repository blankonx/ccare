<?php
Class Rawatinap_Checkup_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
	function GetData($visitInpatientId) {
		//get the current selected data
		$sql = $this->db->query("
			SELECT
                vi.`id` as `visit_id`,
				CONCAT(p.`family_folder`, '-', p.`id`, '-', p.`family_relationship_id`) as `mr_number`,
				p.`name`,
				p.`parent_name`,
				p.`birth_place`,
				p.`sex` as `sex`,
				DATE_FORMAT(p.`birth_date`, '%d/%m/%y') as `birth_date`, 
				p.birth_date as birth_date_for_age,
				DATE(vic.entry_date) as visit_date_for_age,
				DATE_FORMAT(vi.`entry_date`, '%d/%m/%Y %H:%i') as `visit_date_formatted`, 
				DATE_FORMAT(vic.`entry_date`, '%d/%m/%Y %H:%i') as `inpatient_first_time`, 
				CONCAT_WS(', ', v.`address`, rv.`name`, sd.`name`, d.`name`) as `address`,
				e.`name` as `education_name`,
				j.`name` as `job_name`
			FROM 
				`patients` p
				JOIN `visits_inpatient` vi ON (vi.`patient_id` = p.`id`)
				JOIN `visits_inpatient_clinic` vic ON (vic.visit_inpatient_id = vi.id)
				JOIN `visits` v ON (v.`id` = vi.`visit_id`)
				JOIN `ref_villages` rv ON (rv.`id` = v.`village_id`)
				JOIN `ref_sub_districts` sd ON (sd.`id` = rv.`sub_district_id`)
				JOIN `ref_districts` d ON (d.`id` = sd.`district_id`)
				JOIN `ref_educations` e ON (e.`id` = v.`education_id`)
				JOIN `ref_jobs` j ON (j.`id` = v.`job_id`)
			WHERE
				vi.`id`=?
		",
			array(
                $visitInpatientId
            )
		);
		return $sql->row_array();
	}

    function GetModule($visitInpatientId) {
        $sql = $this->db->query("
            SELECT 
                rm.`id` as `id`, 
                rm.`name` as `name`, 
                rm.`filename` as `filename`,
                CONCAT_WS('/', '..', rm.`group`, rm.`filename`, 'home', v.id, vic.id) as `path`
            FROM 
                ref_modules rm 
                JOIN inpatient_clinic_modules cm ON (cm.module_id = rm.id)
				JOIN visits_inpatient_clinic vic ON (vic.inpatient_clinic_id = cm.inpatient_clinic_id)
                JOIN visits_inpatient v ON (v.id = vic.visit_inpatient_id)
            WHERE vic.exit_date IS NULL AND v.id=?
            ORDER BY rm.ordering
        ",
            array(
                $visitInpatientId    
            )
        );
		//echo $this->db->last_query();
        return $sql->result_array();
    }

}
?>
