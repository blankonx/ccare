<?php
Class Checkout_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
	function GetComboKeadaanKeluar() {
        $sql = $this->db->query("
            SELECT * FROM ref_inpatient_exit_conditions
        "
        );
        return $sql->result_array();
	}
	
	function GetComboCaraKeluar() {
        $sql = $this->db->query("
            SELECT * FROM ref_inpatient_continue
        "
        );
        return $sql->result_array();
	}
	
	function DoAddPemulanganPasien() {
		if($this->input->post('inpatient_exit_condition_id') == '' && $this->input->post('inpatient_continue_id') =='') {
			$a = $this->db->query("
				UPDATE 
					visits_inpatient_clinic 
				SET 
					exit_date=NULL
				WHERE
					id=?
			", array(
				$this->input->post('visit_inpatient_clinic_id')
			));	
		} else {
			$a = $this->db->query("
				UPDATE 
					visits_inpatient_clinic 
				SET 
					exit_date=STR_TO_DATE(?,'%d/%m/%Y %H:%i')
				WHERE
					id=?
			", array(
				$this->input->post('date') . ' ' . $this->input->post('time'),
				$this->input->post('visit_inpatient_clinic_id')
			));
		}
		if(true === $a) {
			return $this->db->query("
				UPDATE 
					visits_inpatient 
				SET 
					inpatient_exit_condition_id=NULLIF(?,''),
					inpatient_continue_id=NULLIF(?,'')
				WHERE
					id=?
			", array(
				$this->input->post('inpatient_exit_condition_id'),
				$this->input->post('inpatient_continue_id'),
				$this->input->post('visit_inpatient_id')
			));
		}
		return $a;
	}
}
?>
