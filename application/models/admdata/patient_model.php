<?php
Class Patient_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function GetComboMaritalStatus() {
        $sql = $this->db->query(
        "
          SELECT id as id, name as name ".
        " FROM ref_marital_status"
        );
        return $sql->result_array();
    }
   
    function GetDataPatient($id) {
		//get the latest data from visits_patient & visits_outdoor
		$sql_latest = $this->db->query("
				SELECT
					p.nik,
				    v.family_folder,
					MAX(v.date),
					p.address,
					v.no_kontak,
					v.job_id,
					v.insurance_no,
					v.nama_asuransi,
					v.payment_type_id,
					v.date as visit_date
				FROM
					visits v
					JOIN patients p ON (p.family_folder = v.family_folder)
				WHERE 
					p.family_folder=?
					AND v.date>=ALL(
							SELECT 
								date 
							FROM 
								visits 
							WHERE 
								family_folder=?
							)
				GROUP BY p.family_folder
		",
            array($family_folder, $family_folder)
		);
		$data_latest = $sql_latest->row_array();

        $sql = $this->db->query("
            SELECT 
                family_folder,
                nik,
                name, 
                sex,
                birth_place, 
                DATE_FORMAT(birth_date, '%d/%m/%Y') as birth_date, 
                birth_date as birth_date2,
                address, 
               	no_kontak,
                job_id,
                marital_status_id
            FROM 
				patients
            WHERE 
                family_folder=? 
                ",
            array($id));
		$data_patient = $sql->row_array();

		//be sure this is the latest data only
		if(!empty($data_latest)) {
			$data_patient['nik'] = $data_latest['nik'];
			$data_patient['address'] = $data_latest['address'];
			$data_patient['job_id'] = $data_latest['job_id'];
			$data_patient['admdata_type_id'] = $data_latest['admdata_type_id'];
			$data_patient['payment_type_id'] = $data_latest['payment_type_id'];
			$data_patient['insurance_no'] = $data_latest['insurance_no'];
			//$data_patient['id_kunj'] = $data_latest['idkunj'];			
			$data_patient['family_folder'] = $data_latest['family_folder'];
		}
        //print_r($data_latest);
        return $data_patient;
    }
    
    function GetComboEducation() {
        $sql = $this->db->query("
            SELECT id as id, name as name FROM ref_educations"
        );
        return $sql->result_array();
    }

    function GetComboJob() {
        $sql = $this->db->query("
            SELECT id as id, name as name FROM ref_jobs order by name ASC"
        );
        return $sql->result_array();
    }

//AJAX GET//     
    function GetNewId() {
		/*
		 * GUNUNG KIDUL : komputer pendaftaran cuma 1
		 * 
		 * 
		*/
        $sql = $this->db->query("
            SELECT IFNULL(MAX(family_folder)+1, 1) as `new_id` FROM patients"
        );
        return $sql->row_array();
        	
        $sql = $this->db->query("SELECT id as `new_id` FROM patient_latest_mr_number");
		$data = $sql->row_array();
		$this->db->query("UPDATE patient_latest_mr_number SET id=id+1");
        return $data;
    }

//3 INI DIPANGGIL KETIKA GET_PATIENT
 //AJAX DO//
 //tangglnya belum
    function DoUpdatePatient() {
        return $this->db->query("
            UPDATE patients 
            SET 
                family_folder=?,
                nik=?,
                name=?,
                sex=?, 
                birth_place=?, 
                birth_date=?,
                marital_status_id=?,
                registration_date=STR_TO_DATE(?, '%d/%m/%Y'),
                address = ?
            WHERE 
                id=?
                ", 
            array(
                $this->input->post('family_folder'),  
                $this->input->post('nik'), 
                $this->input->post('name'), 
                $this->input->post('sex'), 
                $this->input->post('birth_place'), 
                getYMD($this->input->post('birth_date')), 
                $this->input->post('marital_status_id'), 
                $this->input->post('visit_date'), 
                $this->input->post('address'),
                $this->input->post('patient_id')
				)
            );
        //echo $this->db->last_query();
    }

    function DoInsertPatient() {
        return $this->db->query("
            INSERT INTO 
            	patients(
					`family_folder`, 
            		`nik`, 
            		`name`, 
					`sex`, 
					`birth_place`, 
					`birth_date`, 
					`address`, 
					`job_id`, 
					`user_id`,
					`marital_status_id`,
					`registration_date`
			) VALUES(?,?,?,?,?,STR_TO_DATE(?, '%d/%m/%Y'),?,?,?,?,STR_TO_DATE(?, '%d/%m/%Y'))", 
            array(
                $this->input->post('family_folder'), 
                $this->input->post('nik'), 
                ucwords(strtolower($this->input->post('name'))), 
                $this->input->post('sex'), 
                ucwords(strtolower($this->input->post('birth_place'))), 
                $this->input->post('birth_date'), 
                ucwords(strtolower($this->input->post('address'))), 
				$this->input->post('job_id'),
				$this->session->userdata('id'),
				$this->input->post('marital_status_id'),
				$this->input->post('visit_date')
				)
            );
    }
       
    function DoDeletePatient($patientId) {
        return $this->db->query("DELETE FROM patients WHERE family_folder=?", $patientId);
    }

 //DO//
}
?>
