<?php
Class Sks_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//

	function GetNoMc() {
		//get the current selected data
		$sql = $this->db->query("
			SELECT
                CONCAT_WS('/', rp.nama_singkat, `numericToRom`(DATE_FORMAT(NOW(), '%m')), DATE_FORMAT(NOW(), '%Y')) as `no`
			FROM 
				ref_profiles rp
		"
		);
		$data = $sql->row_array();
        return $data['no'];
	}

    function GetDataDoctor() {
        $sql = $this->db->query("
            SELECT * FROM view_ref_doctors WHERE active='yes' ORDER BY name
        "
        );
        return $sql->result_array();
    }

    function GetDataExplanation() {
        $sql = $this->db->query("
            SELECT * FROM ref_medical_certificate_explanations WHERE id<>4 ORDER BY id
        "
        );
        return $sql->result_array();
    }
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
		//get the latest data from visits_sks & visits_outdoor
		$sql_latest = $this->db->query("
				SELECT
					p.nik,
				    v.family_folder,
					MAX(v.date),
					v.address,
					v.no_kontak,
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
				no_kontak,
                job_id,
                marital_status_id,
                CONCAT(family_folder) as mrnumber
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
			//$data_patient['village_id'] = $data_latest['village_id'];
			$data_patient['no_kontak'] = $data_latest['no_kontak'];
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
					`no_kontak`, 
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
				$this->input->post('no_kontak'),
				$this->input->post('job_id'),
				$this->session->userdata('id'),
				$this->input->post('marital_status_id'),
				$this->input->post('visit_date')
				)
            );
    }

    function DoAddVisit() {
		$this->db->trans_start();
        $sql = $this->db->query("
            INSERT INTO visits (
                `patient_id`, 
                `family_folder`,  
                `date`,
                `user_id`,
				`payment_type_id`,
				`insurance_no`,
				`address`,
				`no_kontak`,
				`job_id`,
				`admission_type_id`,
                `served`
            )
            VALUES (
                ?,?,
                STR_TO_DATE(CONCAT(?,' ',CURTIME()), '%d/%m/%Y %H:%i'),
                ?,?,?,?,?,?,?,'yes',?
            )
        ",
        array(
            $this->input->post('patient_id'),
            $this->input->post('family_folder'),
            $this->input->post('visit_date'),
            $this->session->userdata('id'),
            $this->input->post('payment_type_id'),
            1, 
            $this->input->post('insurance_no'), 
			$this->input->post('address'),
			$this->input->post('no_kontak'),
			$this->input->post('job_id'),
			$this->input->post('admission_type_id'),
			$this->input->post('mc_doctor_id')
            )
        );
        $visitId = $this->db->insert_id();
        $last = $this->DoAddDataMedicalCertificate($visitId);
        
		if($this->input->post('fee') == 'pay') {
			$receipt_no = $this->DoAddReceipt();
			$this->DoAddPayment($visitId, $receipt_no);
		}
        
		//return $this->db->insert_id();
        $this->db->trans_complete();
        return $last;
    }
    
	function DoAddReceipt() {
        $this->db->query("
            INSERT INTO
				`receipts`(`date`)
			VALUES ( NOW() )"
		);
        return $this->db->insert_id();
	}


	function DoAddPayment($visit_id, $receipt_id) {
        $payment_type_id = $this->input->post('payment_type_id');
        if($payment_type_id != '001') {
            //ASURANSI, DIKLAIMKAN
			$sql_payments = $this->db->query("
				INSERT INTO
					payments (visit_id, cost_type_id, receipt_id, payment_type_id, name, cost, pay, paid, user_id)
				VALUES
					(?, ?, ?, ?, ?, ?, ?, ?, ?)
			",
				array(
					$visit_id,
                    1,
                    $receipt_id,
                    $payment_type_id,
                    'Retribusi',
                    $this->input->post('pay'),
                    $this->input->post('pay'),
                    'no',
					$this->session->userdata('id')
				));
        } else {
            //UMUM
			$sql_payments = $this->db->query("
				INSERT INTO
					payments (visit_id, cost_type_id, receipt_id, payment_type_id, name, cost, pay, paid, user_id)
				VALUES
					(?, ?, ?, ?, ?, ?, ?, ?, ?)
			",
				array(
					$visit_id,
                    1,
                    $receipt_id,
                    $payment_type_id,
                    'Retribusi',
                    $this->input->post('pay'),
                    $this->input->post('pay'),
                    'yes',
					$this->session->userdata('id')
				));
        }
        return $sql_payments;
	}

    
    function DoAddDataMedicalCertificate($visitId) {
        if($this->input->post('mc_explanation_id') != 'other') {
            $mc_explanation_id = $this->input->post('mc_explanation_id');
            $other = '';
        } else {
            $mc_explanation_id = '';
            $other = $this->input->post('mc_explanation_other');
        }
        $sql = $this->db->query("
            INSERT INTO medical_certificates(
                visit_id, 
                doctor_id, 
                no,
                result, 
                medical_certificate_explanation_id, 
                medical_certificate_explanation_other,
                `date`) 

            VALUES(
                ?,?,?,?,
                NULLIF('".$mc_explanation_id."',''),
                NULLIF('".$other."',''),
                NOW()
            )
        ",
            array(
                $visitId,
                $this->input->post('mc_doctor_id'),
                $this->input->post('mc_no') . $this->input->post('mc_no_hidden'),
                $this->input->post('mc_result')
            )
        );
        $a = $this->db->insert_id();
        /*BATAM : SURAT KETERANGAN SEHAT DILAKUKAN DI LAB*/
        return $a;
    }

    function DoAddDistrict($code, $name) {
        $this->db->query("INSERT INTO ref_districts(code, name) VALUES(?, ?)", array($code, $name));
        return $this->db->insert_id();
    }

    function DoAddSubDistrict($district_id, $code, $name) {
        $sql = "INSERT INTO ref_sub_districts(district_id, code, name) VALUES(?, ?, ?)";
        $this->db->query($sql, array($district_id, $code, $name));
        return $this->db->insert_id();
    }

    function DoAddVillage($sub_district_id, $code, $name) {
        $sql = "INSERT INTO ref_villages(sub_district_id, code, name) VALUES(?, ?, ?)";
        $this->db->query($sql, array($sub_district_id, $code, $name));
        return $this->db->insert_id();
    }


 //DO//
}
?>
