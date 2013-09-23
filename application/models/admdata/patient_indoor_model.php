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
    
    
    function GetComboAdmissionType() {
        $sql = $this->db->query(
        "
          SELECT id as id, name as name ".
        " FROM ref_admission_types WHERE active='yes' AND id NOT IN (7) ORDER BY name"
        );
        return $sql->result_array();
    }

    function GetDataParent($id) {
        $sql = $this->db->query("
            SELECT 
                id,
                family_folder,
                name,
                last_name,
                address, 
                village_id
            FROM patients
            WHERE 
                family_folder=? AND 
                family_relationship_id='01' 
                ",
            array($id));
        $data = $sql->row_array();
        //If there is no parents in database, look for the brothers 
        if(empty($data)) {
            $sql = $this->db->query("
                SELECT 
                    id,
                    family_folder,
                    parent_name as name,
                    last_name,
                    address, 
                    village_id
                FROM patients
                WHERE 
                    family_folder=? 
                    ",
                array($id));
            $data = $sql->row_array();
        }
        return $data;
    }
    function GetDataPatient($id) {
		//get the latest data from visits_indoor & visits_outdoor
		$sql_latest = $this->db->query("
				SELECT
					p.nik,
				    v.family_folder,
					MAX(v.date),
					v.address,
					v.education_id,
					v.job_id,
					v.admission_type_id,
					v.insurance_no,
					v.payment_type_id
				FROM
					visits v
					JOIN patients p ON (p.id = v.patient_id)
				WHERE 
					p.id=?
					AND v.date>=ALL(
							SELECT 
								date 
							FROM 
								visits 
							WHERE 
								patient_id=?
							)
				GROUP BY p.id
		",
            array($id, $id)
		);
		$data_latest = $sql_latest->row_array();

        $sql = $this->db->query("
            SELECT 
                id,
                nik,
                name, 
                sex,
                birth_place, 
                DATE_FORMAT(birth_date, '%d/%m/%Y') as birth_date, 
                address, 
				education_id,
                job_id,
                marital_status_id,
                CONCAT(family_folder, '-',id) as mrnumber
            FROM 
				patients
            WHERE 
                id=? 
                ",
            array($id));
		$data_patient = $sql->row_array();

		//be sure this is the latest data only
		if(!empty($data_latest)) {
			$data_patient['nik'] = $data_latest['nik'];
			$data_patient['address'] = $data_latest['address'];
			$data_patient['education_id'] = $data_latest['education_id'];
			$data_patient['job_id'] = $data_latest['job_id'];
			$data_patient['admission_type_id'] = $data_latest['admission_type_id'];
			$data_patient['payment_type_id'] = $data_latest['payment_type_id'];
			$data_patient['insurance_no'] = $data_latest['insurance_no'];
			//$data_patient['id_kunj'] = $data_latest['idkunj'];			
			$data_patient['family_folder'] = $data_latest['family_folder'];
		}
        //print_r($data_latest);
        return $data_patient;
    }
    /*

    INI MENGGUNAKAN VISIT_OUTDOOR, tak disable dulu, karena zerofil ga jalan 12/19/2008
    function GetDataPatient($id) {
		//get the latest data from visits_indoor & visits_outdoor
		$sql_latest = $this->db->query("
			SELECT 
				MAX(tempResult.date), 
				tempResult.address, 
				tempResult.village_id, 
				tempResult.education_id, 
				tempResult.job_id, 
				tempResult.admission_type_id, 
				tempResult.insurance_no 
			FROM (
				SELECT
					v.patient_id,
					v.date,
					v.address,
					v.village_id,
					v.education_id,
					v.job_id,
					v.admission_type_id,
					v.insurance_no
				FROM
					visits v
					JOIN patients p ON (p.id = v.patient_id)
				WHERE 
					v.patient_id=?
					AND v.date>=ALL(
							SELECT 
								date 
							FROM 
								visits 
							WHERE 
								patient_id=?
							)
				UNION

				SELECT
					v.patient_id,
					v.date,
					v.address,
					v.village_id,
					v.education_id,
					v.job_id,
					v.admission_type_id,
					v.insurance_no
				FROM
					visits_outdoor v
					JOIN patients p ON (p.id = v.patient_id)
				WHERE 
					v.patient_id=?
					AND v.date>=ALL(
							SELECT 
								date 
							FROM 
								visits_outdoor 
							WHERE 
								patient_id=?
							)) 
				AS tempResult GROUP BY tempResult.patient_id
		",
            array($id, $id, $id, $id)
		);
		$data_latest = $sql_latest->row_array();

        $sql = $this->db->query("
            SELECT 
                id,
                family_relationship_id,
                name, 
                last_name,
				sex,
                parent_name, 
                birth_place, 
                DATE_FORMAT(birth_date, '%d/%m/%y') as birth_date, 
                address, 
                village_id, 
				education_id,
                job_id
            FROM 
				patients
            WHERE 
                id=? 
                ",
            array($id));
		$data_patient = $sql->row_array();

		//be sure this is the latest data only
		if(!empty($data_latest)) {
			$data_patient['address'] = $data_latest['address'];
			$data_patient['village_id'] = $data_latest['village_id'];
			$data_patient['education_id'] = $data_latest['education_id'];
			$data_patient['job_id'] = $data_latest['job_id'];
			$data_patient['admission_type_id'] = $data_latest['admission_type_id'];
			$data_patient['insurance_no'] = $data_latest['insurance_no'];
		}
        //print_r($data_latest);
        return $data_patient;
    }
*/
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

    function GetComboPaymentType() {
        $sql = $this->db->query("
            SELECT id, name FROM ref_payment_types order by id ASC"
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
            SELECT IFNULL(MAX(id)+1, 1) as `new_id` FROM patients"
        );
        return $sql->row_array();
        
		//select max dulu, jika max > latest_mr_number
		//$this->db->query("UPDATE patient_latest_mr_number SET id=(SELECT IFNULL(MAX(id)+1, 1) FROM patients)");
		/*BATAM : komputer pendaftaran lebih dari 1*/
		/*
        $sql = $this->db->query("
            SELECT 
				id as `new_id` 
			FROM 
				patient_latest_mr_number
			"
        );
		$data = $sql->row_array();
		$this->db->query("UPDATE patient_latest_mr_number SET id=id+1");
        return $data;
        */
		
		/* * JEMBER : nomor KK auto increment, bukan kode wilayah :))
		 * */
		/*
        $sql = $this->db->query("
            SELECT IFNULL(MAX(id)+1, 1) as `new_id`, IFNULL(MAX(family_folder)+1, 1) as `family_folder` FROM patients"
        );
        return $sql->row_array();
        * */
		
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
                marital_status_id=?
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
                $this->input->post('patient_id')
				)
            );
    }

    function DoInsertPatient() {
        return $this->db->query("
            INSERT INTO 
            	patients(
					`id`, 
					`family_folder`, 
            		`nik`, 
            		`name`, 
            		`sex`, 
					`birth_place`, 
					`birth_date`, 
					`address`, 
					`education_id`, 
					`job_id`, 
					`user_id`,
					`marital_status_id`,
					`registration_date`
			) VALUES(?,?,?,?,?,?,STR_TO_DATE(?, '%d/%m/%Y'),?,?,?,?,?, STR_TO_DATE(?, '%d/%m/%Y'))", 
            array(
                $this->input->post('patient_id'), 
                $this->input->post('family_folder'),
                $this->input->post('nik'), 
                ucwords(strtolower($this->input->post('name'))), 
                $this->input->post('sex'), 
                ucwords(strtolower($this->input->post('birth_place'))), 
                $this->input->post('birth_date'), 
                ucwords(strtolower($this->input->post('address'))),
				$this->input->post('education_id'),
				$this->input->post('job_id'),
				$this->session->userdata('id'),
				$this->input->post('marital_status_id'),
				$this->input->post('visit_date')
				)
            );
    }

    function DoAddVisit() {
		//$this->db->trans_begin();
        $sql = $this->db->query("
            INSERT INTO visits (
                `patient_id`, 
                `family_folder`,
                `date`,
                `user_id`,
				`payment_type_id`,
				`insurance_no`,
				`address`,
				`education_id`,
				`job_id`,
				`admission_type_id`
            )
            VALUES (
                ?,?,
                STR_TO_DATE(CONCAT(?,' ',CURTIME()), '%d/%m/%Y %H:%i'),
                ?,?,?,?,?,?,?
            )
        ",
        array(
            $this->input->post('patient_id'),
            $this->input->post('family_folder'),
            $this->input->post('visit_date'),
            $this->session->userdata('id'),
            $this->input->post('payment_type_id'),
            $this->input->post('insurance_no'), 
			$this->input->post('address'),  
			$this->input->post('education_id'),
			$this->input->post('job_id'),
			$this->input->post('admission_type_id')
            )
        );
		return $this->db->insert_id();
    }

	function DoAddPayment($visit_id, $receipt_id) {
		$sql_bills = $this->db->query("
			INSERT INTO
				bills (visit_id, cost_type_id, name, cost, paid, user_id)
			VALUES
				(?, ?, ?, ?, ?, ?)
		",
			array(
				$visit_id,
				1,
				'Retribusi',
				$this->input->post('pay'),
				'yes',
				$this->session->userdata('id')
			))
		;
		if($sql_bills === true) {
			$bill_id = $this->db->insert_id();
			$sql_payments = $this->db->query("
				INSERT INTO
					payments (bill_id, receipt_id, cost, pay, paid, user_id)
				VALUES
					(?, ?, ?, ?, ?, ?)
			",
				array(
					$bill_id,
					$receipt_id,
					$this->input->post('pay'),
					$this->input->post('pay'),
					'yes',
					$this->session->userdata('id')
				))
			;
			if($sql_payments === true) {
				$this->db->trans_commit();
			} else {
				$this->db->trans_rollback();
			}
		} else {
			$this->db->trans_rollback();
		}
	}
 //DO//
}
?>
