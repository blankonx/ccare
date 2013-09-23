<?php
Class Rujukan_Internal_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//

    function GetComboClinics() {
        $sql = $this->db->query("
            SELECT 
                child.`id` as `id`, 
                IFNULL(`parent`.`id`, `child`.id) as `order_id`, 
                child.`name` as `name`,
                parent.name as parent_name,
                `parent`.`id` as `parent_id`
            FROM
                `ref_clinics` `child`
				LEFT JOIN (
					SELECT 
						id, name
					FROM ref_clinics
					WHERE parent_id IS NULL AND active='yes' AND visible='yes'
				) `parent` ON (`parent`.id = `child`.parent_id)
            WHERE 
                `active` = 'yes' 
                AND `visible` = 'yes' 
                AND `child`.id NOT IN (5,160,161,162,163,164,165,166,167,168,169)
            ORDER BY
				order_id,parent_id,name
            "
        );
        return $sql->result_array();
    }
    
	function DoAddRujukanInternal() {
		return 
        $sql_visit = $this->db->query("
            INSERT INTO visits (
                parent_id, 
                patient_id, 
                family_folder, 
                family_relationship_id, 
                `date`, 
                `user_id`, 
                `payment_type_id`, 
                clinic_id, 
                insurance_no,
                address,
                village_id,
                education_id,
                job_id,
				admission_type_id
            )
            SELECT
                ?, 
                patient_id, 
                family_folder, 
                family_relationship_id, 
                STR_TO_DATE(?, '%d/%m/%Y %H:%i'), 
                ?, 
                `payment_type_id`, 
                ?, 
                insurance_no,
                address,
                village_id,
                education_id,
                job_id,
				'7'
            FROM
                visits
            WHERE
                id=?
        ", 
            array(
                $this->input->post('visit_id'),
                $this->input->post('date') . ' ' . $this->input->post('time'),
				$this->session->userdata('id'),
                $this->input->post('clinic_id'),
                $this->input->post('visit_id')
            )
        );
	}
}
?>
