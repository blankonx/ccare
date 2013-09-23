<?php
Class Checkup_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
	function GetData($visitClinicId) {
		//get the current selected data
		$sql = $this->db->query("
			SELECT
				p.family_folder as patient_id,
                v.`id` as `visit_id`,
				p.`name`,
				p.`birth_place`,
				p.`sex` as `sex`,
				DATE_FORMAT(p.`birth_date`, '%d/%m/%y') as `birth_date_formatted`, 
				DATE_FORMAT(v.`date`, '%d/%m/%Y') as `visit_date_formatted`, 
				p.birth_date as birth_date,
				DATE(v.date) as visit_date,
				p.`address`,
				j.`name` as `job_name`,
				ad.icd_name as diagnose,
                rpt.name as payment_type
			FROM 
				`patients` p
				JOIN `visits` v ON (v.`family_folder` = p.`family_folder`)
				LEFT JOIN anamnese_diagnoses ad ON (ad.visit_id = v.id)
				JOIN `ref_jobs` j ON (j.`id` = p.`job_id`)
                JOIN ref_payment_types rpt ON (rpt.id = v.payment_type_id)
			WHERE
				v.`id`=?
		",
			array(
                $visitClinicId
            )
		);
		return $sql->row_array();
	}

}
?>
