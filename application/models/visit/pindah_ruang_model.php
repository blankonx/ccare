<?php
Class Pindah_Ruang_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
	function GetComboClinic() {
        $sql = $this->db->query("
            SELECT * FROM ref_inpatient_clinics
        "
        );
        return $sql->result_array();
	}
		
	function DoAddPindahRuang() {
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
		if(true === $a) {
			return $this->db->query("
				INSERT INTO 
					visits_inpatient_clinic(
						visit_inpatient_id,
						inpatient_clinic_id,
						user_id,
						entry_date
					)
				VALUES(?,?,?,STR_TO_DATE(?,'%d/%m/%Y %H:%i'))
			", array(
				$this->input->post('visit_inpatient_id'),
				$this->input->post('inpatient_clinic_id'),
				$this->session->userdata('id'),
				$this->input->post('date') . ' ' . $this->input->post('time')
			));

		}
		return $a;
	}
}
?>
