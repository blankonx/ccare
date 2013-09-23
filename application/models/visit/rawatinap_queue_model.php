<?php
Class Rawatinap_Queue_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function GetComboClinics() {
        $sql = $this->db->query("
            SELECT 
				`id`, `name`
			FROM 
				ref_inpatient_clinics 
			ORDER BY 
				`name` "
        );
        return $sql->result_array();
    }
	
	function DoDeleteData() {
        $delete_id = implode(",", $this->input->post('delete_id'));
		$x = $this->db->query("
			DELETE FROM
				`visits_inpatient_clinic` 
			WHERE 
				id IN ($delete_id)"
		);
		$this->db->query("DELETE FROM visits_inpatient_clinic WHERE visit_inpatient_id IN($delete_id)");
		$this->db->query("
		DELETE 
			FROM visits_inpatient_detail 
		WHERE 
			visit_inpatient_clinic_id IN(
				SELECT id 
				FROM visits_inpatient_clinic 
				WHERE visit_inpatient_id IN($delete_id))");
		return $x;
	}
}
?>
