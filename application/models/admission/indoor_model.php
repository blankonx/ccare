<?php
Class Indoor_Model extends Model {

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
    
	function GetComboReligionStatus() {
        $sql = $this->db->query(
        "
          SELECT id as id, name as name ".
        " FROM ref_religion_status"
        );
        return $sql->result_array();
    }
	
    function GetListTempatLahir() {
        $sql = $this->db->query(
        "
          SELECT birth_place FROM patients GROUP BY birth_place ORDER BY birth_place"
        );
        return $sql->result_array();
    }

	function GetListRs() {
        $sql = $this->db->query(
        "
          SELECT continue_to as rumahsakit FROM visits GROUP BY continue_to ORDER BY continue_to"
        );
        return $sql->result_array();
    }

	function GetListSpecialis() {
        $sql = $this->db->query(
        "
          SELECT specialis as specialis FROM visits GROUP BY specialis ORDER BY specialis"
        );
        return $sql->result_array();
    }
    
      
    function GetDataPatient($family_folder) {
		//get the latest data from visits_indoor & visits_outdoor
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
		//echo "<prev>". $this->db->last_query() ."</prev>";
		
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
            array($family_folder));
		$data_patient = $sql->row_array();

		//be sure this is the latest data only
		if(!empty($data_latest)) {
			$data_patient['nik'] = $data_latest['nik'];
			$data_patient['address'] = $data_latest['address'];
			$data_patient['no_kontak'] = $data_latest['no_kontak'];
			$data_patient['job_id'] = $data_latest['job_id'];
			$data_patient['payment_type_id'] = $data_latest['payment_type_id'];
			$data_patient['insurance_no'] = $data_latest['insurance_no'];
			$data_patient['nama_asuransi'] = $data_latest['nama_asuransi'];			
			$data_patient['family_folder'] = $data_latest['family_folder'];
			$data_patient['visit_date'] = tanggalIndo($data_latest['visit_date'], 'j F Y');
		}
        //print_r($data_latest);
        return $data_patient;
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
            SELECT IFNULL(MAX(family_folder)+1, 1) as `new_id` FROM patients"
        );
        return $sql->row_array();
        	
        $sql = $this->db->query("SELECT id as `new_id` FROM patient_latest_mr_number");
		$data = $sql->row_array();
		$this->db->query("UPDATE patient_latest_mr_number SET id=id+1");
        return $data;
        }

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
                address=?,
                no_kontak=?,
                job_id=?,
                user_id=?,
                marital_status_id=?
            WHERE 
                family_folder=?
                ", 
            array(
                $this->input->post('family_folder'), 
                $this->input->post('nik'), 
                $this->input->post('name'), 
                $this->input->post('sex'), 
                $this->input->post('birth_place'), 
                getYMD($this->input->post('birth_date')), 
                $this->input->post('address'), 
				$this->input->post('no_kontak'),
                $this->input->post('job_id'),
                $this->input->post('user_id'), 
                $this->input->post('marital_status_id'),
                $id
				)
            );
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
					`no_kontak`, 
					`job_id`, 
					`user_id`,
					`marital_status_id`,
					`registration_date`
			) VALUES(?,?,?,?,?,STR_TO_DATE(?, '%d/%m/%Y'),?,?,?,?,?,STR_TO_DATE(?, '%d/%m/%Y'))", 
            array(
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
		//$this->db->trans_begin();
        $sql = $this->db->query("
            INSERT INTO visits (
                `family_folder`,  
                `date`,
                `user_id`,
				`payment_type_id`,
				`insurance_no`,
				`nama_asuransi`,
				`address`,
				`no_kontak`,
				`job_id`,
				`continue_id`,
				`continue_to`,
				`specialis`,
				`paramedic`
            )
            VALUES (
                ?,STR_TO_DATE(CONCAT(?,' ',CURTIME()), '%d/%m/%Y %H:%i'),
                ?,?,?,?,?,?,?,?,NULLIF(?,''),NULLIF(?,''),?
            )
        ",
        array(
            $this->input->post('family_folder'),
            $this->input->post('visit_date'),
            $this->session->userdata('id'),
            $this->input->post('payment_type_id'),
            $this->input->post('insurance_no'), 
            $this->input->post('nama_asuransi'),
			$this->input->post('address'), 
			$this->input->post('no_kontak'),
			$this->input->post('job_id'),
			$this->input->post('continue_id'),
			$this->input->post('continue_to'),
			$this->input->post('specialis'),
			$this->session->userdata('name')
            )
        );
        //echo "<prev>". $this->db->last_query() ."</prev>"; 
		return $this->db->insert_id();
    }

	function DoAddPayment($visit_id, $receipt_id) {
        $payment_type_id = $this->input->post('payment_type_id');
        //UMUM
			$sql_payments = $this->db->query("
				INSERT INTO
					payments (visit_id, cost_type_id, receipt_id, payment_type_id, cost, pay, paid, user_id)
				VALUES
					(?, ?, ?, ?, ?, ?, ?, ?, ?)
			",
				array(
					$visit_id,
                    1,
                    $receipt_id,
                    $payment_type_id,
                    $this->input->post('pay'),
                    $this->input->post('pay'),
                    'yes',
					$this->session->userdata('id')
				));
        return $sql_payments;
	}
	
//General Checkup Form//
//GET//
    function GetDataPrescribes($visit_id) {
        $sql = $this->db->query("
            SELECT p.visit_id,
                p.`id`, 
                p.drug_name as `name`, 
                p.`unit` as unit, 
                p.`dosis1`, 
                p.`dosis2`, 
                p.`qty`, 
                p.`log`,
                p.drug_taken
            FROM `prescribes` p
            WHERE 
				(p.mix_name IS NULL OR p.mix_name='')
				AND p.log='no' 
				AND (p.`visit_id`=? 
				OR p.visit_id IN(SELECT parent_id FROM visits WHERE id=?))
            GROUP BY p.id
			ORDER BY p.`id`
        ",
            array($visit_id, $visit_id)
        );
        return $sql->result_array();
    }
    
    function GetDataPrescribesMix($visit_id) {
        $sql = $this->db->query("
            SELECT p.visit_id,
                p.`id`, 
                p.drug_name as `name`, 
                p.`mix_name` as `mix_name`,
                p.`unit` as unit, 
                p.`dosis1`, 
                p.`dosis2`, 
                p.`qty`, 
                p.`log`,
                p.`randomnumber`,
                p.drug_taken,
                p.mix_qty,
                p.mix_unit
            FROM `prescribes` p
            WHERE 
				(p.mix_name IS NOT NULL OR p.mix_name<>'')
				AND p.log='no' 
				AND (p.`visit_id`=? 
				OR p.visit_id IN(SELECT parent_id FROM visits WHERE id=?))
            GROUP BY p.id
			ORDER BY p.randomnumber, p.id
        ",
            array($visit_id, $visit_id)
        );
        return $sql->result_array();
    }
	
    function GetDataPrescribesForPrint($visit_id) {
        $sql = $this->db->query("
            SELECT p.visit_id,
				rd.code,
				rd.name,
                p.drug_name as `name`, 
                CONCAT(ROUND(p.qty), ' ', p.`unit`) as jumlah
            FROM `prescribes` p
			JOIN ref_drugs rd ON (rd.id = p.drug_id)
            WHERE 
				(p.mix_name IS NULL OR p.mix_name='')
				AND p.`visit_id`=? AND p.`log`='no'
            GROUP BY p.id
			ORDER BY p.`id`
        ",
            array($visit_id)
        );
        return $sql->result_array();
    }
	
    function GetDataPrescribesMixForPrint($visit_id) {
        $sql = $this->db->query("
            SELECT p.visit_id,
				rd.code,
				rd.name,
                p.drug_name as `name`, 
                p.`mix_name` as `mix_name`,
                CONCAT(ROUND(p.qty), ' ', p.`unit`) as jumlah,
                p.randomnumber,
                p.mix_qty,
                p.mix_unit
            FROM `prescribes` p
				JOIN ref_drugs rd ON (rd.id = p.drug_id)
            WHERE 
				p.randomnumber IS NOT NULL
				AND p.`visit_id`=? AND p.`log`='no'
            GROUP BY p.id
			ORDER BY p.randomnumber, p.id
        ",
            array($visit_id)
        );
        return $sql->result_array();
    }
	
	function GetDataPatientVisits($visitId) {
		//get the current selected data
		$sql = $this->db->query("
			SELECT
				CONCAT(p.`family_folder`) as `mr_number`,
				p.`name`,
				p.`birth_place`,
				p.`sex` as `sex`,
				p.`birth_date` as `birth_date`, 
				v.`date` as `visit_date`, 
				DATE_FORMAT(v.`date`, '%d-%m-%Y') as `visit_date_formatted`, 
				CONCAT_WS(', ', v.`address`) as `address`,
				rpt.name as payment_type,
                v.continue_id as continue_id,
                v.continue_to as continue_to,
				rcon.name as `continue`,
				v.specialis,
			FROM 
				`patients` p
				JOIN `visits` v ON (v.`family_folder` = p.`family_folder`)
				JOIN `ref_payment_types` rpt ON  (rpt.id = v.payment_type_id)
				LEFT JOIN `ref_continue` rcon ON (rcon.id = v.continue_id)
			WHERE
				v.`id`=?
		",
			array($visitId)
		);
		return $sql->row_array();
	}
	
	function GetData($visit_id) {
		//get the current selected data
		$sql = $this->db->query("
			SELECT
                v.`id` as `visit_id`,
				CONCAT(p.`family_folder`) as `mr_number`,
				p.`name`,
				p.`birth_place`,
				p.`sex` as `sex`,
				DATE_FORMAT(p.`birth_date`, '%d/%m/%y') as `birth_date`, 
				v.`date` as `visit_date`,
				CONCAT_WS(', ', v.`address`) as `address`,
				j.`name` as `job_name`,
                v.`continue_id` as `continue_id`,
                v.`continue_to` as `continue_to`
                (
                    SELECT COUNT(*) 
                    FROM 
                        `visits` 
                    WHERE 
                        `family_folder`=(SELECT `family_folder` FROM `visits` WHERE `id`=?) 
                        AND `id` <=? 

                ) as `visit_count`,
                v.`served`,
				v.specialis
			FROM 
				`patients` p
				JOIN `visits` v ON (v.`family_folder` = p.`family_folder`)
				JOIN `ref_jobs` j ON (j.`id` = v.`job_id`)
			WHERE
				v.`id`=?
		",
			array(
                $visit_id,
                $visit_id,
                $visit_id
            )
		);
		return $sql->row_array();
	}

    function GetDataGeneral_Checkup($visit_id) {
        $sql = $this->db->query("
            SELECT `id`, `visit_id`, `sistole`, `diastole`, `temperature`, `pulse`, `physic_anamnese`, `respiration`, `weight`, `height`, `log`, `date`  
            FROM `examinations`
            WHERE `visit_id`=? AND `log`='no'
        ",
            array($visit_id)
        );
       // echo "<pre>" . $this->db->last_query() . "</pre>";
        return $sql->row_array();
    }

    function GetDataDiagnoses($visit_id) {
        $sql = $this->db->query("
            SELECT d.`id`, d.`anamnese`, CONCAT(d.icd_code, ' ', d.icd_name) as `name`, d.`case` as `case`, d.`log`, d.explanation, d.element_teeth
            FROM `anamnese_diagnoses` d 
            WHERE d.`visit_id`=?
			ORDER BY d.`id`
        ",
            array($visit_id)
        );
        return $sql->result_array();
    }

    function GetDataDiagnosesForPrint($visit_id) {
        $sql = $this->db->query("
            SELECT 
				ri.code,
				ri.name,
				IF(ad.`case`='new', 'B', 'L') as `case`,
				ad.explanation
            FROM 
				`anamnese_diagnoses` ad 
				JOIN ref_icds ri ON (ri.id = ad.icd_id)
            WHERE 
				ad.`visit_id`=?
				AND ad.log='no'
			ORDER BY 
				ad.`id`
        ",
            array($visit_id)
        );
        return $sql->result_array();
    }

    function GetDataTreatments($visit_id) {
        $sql = $this->db->query("
            SELECT 
                t.`id` as id, 
                t.`name` as `name`, 
                t.`cost` as `price`,
                t.`log` as `log`
            FROM 
                `treatments` t
                JOIN `ref_treatments` rt ON (rt.`id` = t.`treatment_id`)
                JOIN `ref_treatment_categories` tc ON (tc.id = rt.treatment_category_id)
            WHERE t.`visit_id` = ?
            GROUP BY t.id
        ",
            array($visit_id)
        );
		//echo $this->db->last_query();
        return $sql->result_array();
    }

    function GetDataTreatmentsForPrint($visit_id) {
        $sql = $this->db->query("
            SELECT 
                t.`id` as id, 
                t.`name` as `name`, 
                t.`cost` as `price`
            FROM 
                `treatments` t
                JOIN `ref_treatments` rt ON (rt.`id` = t.`treatment_id`)
                JOIN `ref_treatment_categories` tc ON (tc.id = rt.treatment_category_id)
            WHERE t.`visit_id` = ? AND t.`log`='no'
            GROUP BY t.id
        ",
            array($visit_id)
        );
        return $sql->result_array();
    }
    
    function GetListExpertAnamneseDiagnose($arr_q) {
        for($i=0;$i<sizeof($arr_q);$i++) {
            $where .= " AND name LIKE '%".trim($arr_q[$i])."%' ";
        }
        $sql = "
            SELECT 
                expert.id as id,
                expert.name as name, 
                expert.icd_id as icd_id, 
                expert.icd_code as icd_code, 
                expert.icd_name as icd_name, 
                expert.score as score, 
                IF(newOld.`icd_id` = expert.icd_id, 'old', 'new') as `case`
            FROM
                (SELECT 
                    ead.id as id,
                    LOWER(GROUP_CONCAT(ra.name SEPARATOR ';')) as name,
                    ri.id as icd_id,
                    ri.name as icd_name,
                    ri.code as icd_code,
                    ead.score as score
                FROM
                    expert_anamnese_diagnoses ead
                    JOIN expert_anamnese_diagnose_details eadd ON (eadd.expert_anamnese_diagnose_id = ead.id)
                    JOIN ref_icds ri ON (ri.id = ead.icd_id)
                    JOIN ref_anamneses ra ON (ra.id = eadd.anamnese_id)
                GROUP BY ead.id
                ORDER BY name
                ) expert
                LEFT JOIN 
                    (
                        SELECT 
                            d.`id` as `did`, 
                            d.`icd_id` as `icd_id`
                        FROM `anamnese_diagnoses` d
                            JOIN `visits` v ON (v.`id` = d.`visit_id`)
                        WHERE 
                            v.`family_folder`=(SELECT `family_folder` FROM `visits` WHERE id=?)
                            
                    ) newOld ON(newOld.icd_id = expert.icd_id)
             WHERE
                1=1
                $where
             GROUP BY expert.id
             
        "
        ;

        $sql = $this->db->query($sql,
                    array(
                        $this->input->post('visit_id'),
                        $this->input->post('visit_id')
                        ));
        $anamneses = $sql->result_array();
        //$one_anamnese = $this->GetListAnamnese(end($arr_q));
        //print_r($one_anamnese);
        //print_r($more_anamnese);
        //$anamneses = array_combine($one_anamnese, $more_anamnese);
        return $anamneses;
    }
    
    function GetListIcd($q) {
        $sql = $this->db->query("
            SELECT `id`, `name` as `name`, `code` 
            FROM `ref_icds`
            WHERE `code` LIKE ?
                   OR `name` LIKE ?
                   OR `kata_kunci` LIKE ?",
            array(
                "%" . $q . "%",
                "%" . $q . "%",
                "%" . $q . "%"
            )
        );
        return $sql->result_array();
    }

    function GetNewOldCase() {
        $sql = $this->db->query("
            SELECT d.`id` 
            FROM `anamnese_diagnoses` d
                JOIN `visits` v ON (v.`id` = d.`visit_id`)
            WHERE 
                v.`family_folder`=(SELECT `family_folder` FROM `visits` WHERE id=?)
                AND d.`icd_id`=?
                
        ",
            array(
                $this->input->post('visit_id'),
                $this->input->post('visit_id'),
                $this->input->post('q')
            )
        );
        return $sql->row_array();
    }

    function GetListDrug() {
        $sql = $this->db->query("
            SELECT 
				`drug_id` as id, 
				`unit`, 
				CONCAT(`code`, '-', `drug`) as `name`
            FROM 
				`view_drugs`
            WHERE (
				`code` LIKE ?
                   OR `drug` LIKE ?)
        ",
            array(
                "%" . $this->input->post('q') . "%",
                "%" . $this->input->post('q') . "%"
            )
        ); 
        //echo $this->db->last_query();
        return $sql->result_array();
    }

    function GetListTreatment($q) {
        $sql = $this->db->query("
            SELECT 
				t.`id` as id, 
				tc.name as category,
				t.name as name,
				rtp.price as `price`
            FROM 
                `ref_treatments` t
                JOIN `ref_treatment_categories` tc ON (tc.id = t.treatment_category_id)
                JOIN ref_treatment_price rtp ON (rtp.treatment_id = t.id)
                JOIN visits v ON (v.payment_type_id = rtp.payment_type_id)
            WHERE 
                (t.`name` LIKE ?
                   OR tc.`name` LIKE ?)
		   Group By t.`id`
        ",
            array(
                "%" . $q . "%",
                "%" . $q . "%"
            )
        );
		//echo $this->db->last_query();
        return $sql->result_array();
    }

    function GetDataExplanation() {
        $sql = $this->db->query("
            SELECT * FROM ref_medical_certificate_explanations WHERE id<>4 ORDER BY id
        "
        );
        return $sql->result_array();
    }
    
    function DoDeleteAnamneseDiagnose() {
        return $this->db->query("
            UPDATE `anamnese_diagnoses` SET `log`='yes' WHERE id=?
        ",
            array($this->input->post('id'))
        );
    }

    function DoDeletePrescribe() {
        return $this->db->query("
            UPDATE `prescribes` SET `log`='yes' WHERE id=?
        ",
            array($this->input->post('id'))
        );
    }

    function DoDeleteTreatment() {
        $a = $this->db->query("
            UPDATE `treatments` SET `log`='yes' WHERE id=?
        ",
            array($this->input->post('id'))
        );
        $this->db->query("DELETE FROM payments WHERE treatment_id=?", array($this->input->post('id')));
        return $a;
    }

    function DoDeletePrescribeMix() {
        return $this->db->query("
            UPDATE `prescribes` SET `log`='yes'
            WHERE `randomnumber`=? AND `visit_id`=?
        ",
            array(
                $this->input->post('randomnumber'), 
                $this->input->post('visit_id')
            )
        );
    }

    function DoAddDiagnoses($visitId) {
        //insert the diagnose
        $anamnese = $_POST['anamnese'];
        $icd_code = $_POST['icd_code'];
        $icd_name = $_POST['icd_name'];
        $icd_id	  = $_POST['icd_id'];
        $explanation = $_POST['explanation'];
        //$element_teeth = $_POST['elemen'];
        //$icd_id2 = $this->input->post('icd_id');
        //$case = $_POST['case'];
	    
        //print_r($anamnese);
        //print_r($icd_id);

        if(!empty($icd_id)) {
            foreach($icd_id as $key => $val) {
                //echo $val;
                if($val && $icd_id[$key])
                    $arr_anamnese_diagnoses[] = "(NULLIF('" . $anamnese[$key] . "', ''), '" . $icd_code[$key] . "', '" . $icd_name[$key] . "', '" . $icd_id[$key] . "', '" . $visitId . "', '" . date('Y-m-d H:i:s') . "', '".$explanation[$key]."')";
                    /*
                for($i=0;$i<sizeof($icd_id[$key]);$i++) {
                    //echo $icd_id[$key][$i];
                    //echo "\n\n";
                }
                * */
            }
        }

        if(!empty($arr_anamnese_diagnoses)) {
            $str_anamnese_diagnoses = implode(", ", $arr_anamnese_diagnoses);
            //echo $str_diagnoses;
            $ins = $this->db->query("
                INSERT INTO `anamnese_diagnoses` (`anamnese`, `icd_code`, `icd_name`, `icd_id`, `visit_id`, `date`, `explanation`) 
                VALUES $str_anamnese_diagnoses
            "
            );
        }
        return $ins;
    }

    function DoAddPrescribes($visitId) {
        //insert the drugs/prescribes
        $drug_id = $this->input->post('drug_id');
        $drug_name = $this->input->post('drug_name');
        $unit = $this->input->post('unit');
        $dosis1 = $this->input->post('dosis1');
        $dosis2 = $this->input->post('dosis2');
        $qty = $this->input->post('qty');

        $arr_drugs = array();
        for($i=0;$i<sizeof($drug_id);$i++) {
            if($drug_id[$i] && $drug_id[$i] != 0) {	
                $arr_drugs[] = "('" . $visitId . "', '" . $drug_id[$i] . "', '" . $drug_name[$i] . "', '" . $dosis1[$i] . "', '" . $dosis2[$i] . "', '" . $qty[$i] . "', '" . $unit[$i] . "', '" . date('Y-m-d H:i:s') . "')";
            }
        }

        if(!empty($arr_drugs)) {
            $str_drugs = implode(", ", $arr_drugs);
            $ins = $this->db->query("
                INSERT INTO `prescribes` (`visit_id`, `drug_id`, `drug_name`, `dosis1`, `dosis2`, `qty`, `unit`, `date`) 
                VALUES $str_drugs
            "
            );
        }
        return $ins;
    } 

    function DoAddMix($visitId) {
        $mix_name = $this->input->post('mix_name');
        $mix_randomnumber = $this->input->post('mix_randomnumber');
        $mix_dosis1 = $this->input->post('mix_dosis1');
        $mix_dosis2 = $this->input->post('mix_dosis2');
        
        //print_r($mix_randomnumber);
        //$test = $_POST['mix_drug_id'];
        //print_r($test);
        if(!empty($mix_randomnumber))
        foreach($mix_randomnumber as $xname) {
            $drug_id = $_POST['mix_drug_id'][$xname];
            $drug_name = $_POST['mix_drug_name'][$xname];
            $qty = $_POST['mix_qty'][$xname];
            $unit = $_POST['mix_unit'][$xname];
            $mix_qty_qty = $_POST['mix_qty_qty'][$xname];
            $mix_unit_unit = $_POST['mix_unit_unit'][$xname];
            $strMixName = $mix_name[$xname];
            $strDosis1 = $mix_dosis1[$xname];
            $strDosis2 = $mix_dosis2[$xname];
			
	    //print_r($drug_id);
            //$drug_id = explode(",", $strDrugId);
            //$drug_name = explode(",", $strDrugName);
            //$qty = explode(",", $strQty);
            //$unit = explode(",", $strUnit);

            $arr_drugs = array();
            for($x=0;$x<sizeof($drug_id);$x++) {
                if($drug_id[$x] && $drug_id[$x] != 0) {
					/*SELECT THE STOCK*/
					$arr_drugs[] = "('" . $visitId . "', '" . $drug_id[$x] . "', '" . $drug_name[$x] . "', '" . $strMixName . "', '" . $strDosis1 . "', '" . $strDosis2 . "', '" . $qty[$x] . "', '" . $unit[$x] . "', '" . date('Y-m-d H:i:s') . "', '".$xname."', '" . $mix_qty_qty . "', '" . $mix_unit_unit . "')";
				}
            }
            if(!empty($arr_drugs)) {
                $str_drugs = implode(", ", $arr_drugs);
                $sql = "
                    INSERT INTO `prescribes` (`visit_id`, `drug_id`, `drug_name`, `mix_name`, `dosis1`, `dosis2`, `qty`, `unit`, `date`, `randomnumber`, `mix_qty`, `mix_unit`) 
                    VALUES $str_drugs
                ";
                //echo $sql;
                $ins = $this->db->query($sql);
            }
        }
        return $ins; 
    }
    
    function DoAddTreatments($visitId) {
        //insert the treatments
        $arr_treatment_id = $this->input->post('treatment_id');
        $arr_cost = $this->input->post('treatment_price');
        $arr_treatment = $this->input->post('treatment_name');
        //print_r($arr_treatment_id);
        for($i=0;$i<sizeof($arr_treatment_id);$i++) {
            if($arr_treatment_id[$i] && $arr_treatment_id!='') {
                //$xarr_treatment_id[] = $arr_treatment_id[$i];
                $ins = $this->db->query("INSERT INTO `treatments` (`visit_id`, `treatment_id`, `name`, `cost`, `date`) 
                    SELECT ?, `id`, ?, ?, NOW() FROM `ref_treatments` WHERE `id`=?
                ",
                array($visitId, $arr_treatment[$i], $arr_cost[$i], $arr_treatment_id[$i])
                );
                if(true === $ins) {
                    $treatment_id = $this->db->insert_id();
                    //insert into payments dab
                    $this->db->query("INSERT INTO payments(
                            visit_id,
                            cost_type_id,
                            treatment_id,
                            payment_type_id,
                            name,
                            cost
                        ) 
                        SELECT 
                            id,
                            '002',
                            ?,
                            payment_type_id,
                            ?,
                            ?
                        FROM
                            visits
                        WHERE
                            id=?
                        ", array(
                            $treatment_id,
                            $arr_treatment[$i],
                            $arr_cost[$i], 
                            $visitId
                        ));
                }
                //echo $this->db->last_query();
		//$this->input->post('visit_id')
            }
        }
        return $ins;
    }


    function DoUpdateExpertAnamneseDiagnoses() {
        $arr_ead = $_POST['ead_id'];
        $arr_anamnese = $_POST['anamnese'];
        $arr_icd = $_POST['icd_id'];

        if(!empty($arr_ead)) {
            for($i=0;$i<sizeof($arr_ead);$i++) {
                if($arr_ead[$i]) $arr_ead_exists[] = $arr_ead[$i];
            }
            if(!empty($arr_ead_exists)) {
                $str_ead_exists = implode(',', $arr_ead_exists);
                $this->db->query("UPDATE expert_anamnese_diagnoses SET score=score+1 WHERE id IN (".$str_ead_exists.")");
            }
        }
        //
        for($i=0;$i<sizeof($arr_anamnese);$i++) {
            if($arr_anamnese[$i] && !$arr_ead[$i] && $arr_icd[$i] != "") {
                //add new map
                $this->db->query("INSERT INTO expert_anamnese_diagnoses(icd_id) VALUES(?)", $arr_icd[$i]);
                $expert_id = $this->db->insert_id();

                $arr_single_anamnese[$i] = explode(";", $arr_anamnese[$i]);
                for($j=0;$j<sizeof($arr_single_anamnese[$i]);$j++) {

                    //check if the anamnese is exists
                    $sql = $this->db->query("SELECT id FROM ref_anamneses WHERE LOWER(TRIM(name))=LOWER(TRIM(?))", array($arr_single_anamnese[$i][$j]));
                    $existing_anamnese = $sql->row_array();

                    if(!empty($existing_anamnese) && $existing_anamnese['id']) {
                        $last_anamnese_id = $existing_anamnese['id'];
                    } else {
                        $this->db->query("INSERT INTO ref_anamneses(name) VALUES(TRIM(?))", array($arr_single_anamnese[$i][$j]));
                        $last_anamnese_id = $this->db->insert_id();
                    }

                    $this->db->query("INSERT INTO expert_anamnese_diagnose_details(expert_anamnese_diagnose_id, anamnese_id) VALUES(?, ?)", array($expert_id, $last_anamnese_id));
                }
            }
        }
    }

//DO
    function DoAddData($visitId) {
        //set the input before and be the log
        /*
        11/28/2008
        query sebelumnya*/
        $this->db->trans_start();
        $this->db->query("UPDATE `examinations` SET `log`='yes' WHERE `visit_id`=?", 
            array($this->input->post('visit_id'))
        );
        /*
        $this->db->query("
            DELETE FROM `examinations` WHERE `visit_id`=?", 
            array($this->input->post('visit_id'))
        );
        */
		//set the served status to `yes`
		$this->db->query("UPDATE `visits` 
            SET 
                `served`='yes',
                `continue_to`=NULLIF(?,''),
				`specialis`=NULLIF(?,''),
                `continue_id`=?
            WHERE id=?
			",
			array(
                $this->input->post('continue_to'),
				$this->input->post('specialis'),
                $this->input->post('continue_id'),
                $this->input->post('visit_id')
            )
		);
        
        //INSERT THE DIAGNOSES
        $this->DoAddDiagnoses($visitId);

        //INSERT THE PRESCRIBES
        $this->DoAddPrescribes($visitId);

        //INSERT THE PRESCRIBES MIX
        $this->DoAddMix($visitId);

        //INSERT THE TREATMENTS
        $this->DoAddTreatments($visitId);

        //ADD OR UPDATE THE EXPERT SYSTEM
        $this->DoUpdateExpertAnamneseDiagnoses();

		//$arr_odontogram = $this->input->post('odontogram');
		//$odontogram = implode("|",$arr_odontogram);
		//echo $odontogram;
        $x = $this->db->query("
            INSERT INTO examinations(visit_id, sistole, diastole, temperature, pulse, physic_anamnese, respiration, weight, height, blood_type, `date`)
            VALUES (
                ?,
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NOW()
                )
            ",
            array(
                $visitId,
                $this->input->post('sistole'),
                $this->input->post('diastole'),
                $this->input->post('temperature'),
                $this->input->post('pulse'),
                trim($this->input->post('pemeriksaan_fisik')),
                $this->input->post('respiration'),
                $this->input->post('weight'),
                $this->input->post('height'),
                $this->input->post('blood_type')
            )
        );
        //echo "<prev>" .$this->db->last_query(). "</prev>";
        return $this->db->trans_complete();
    }

    function DoAddDataMedicalCertificate() {
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
                result, 
                medical_certificate_explanation_id, 
                medical_certificate_explanation_other,
                `date`) 

            VALUES(
                ?,?,?,
                NULLIF('".$mc_explanation_id."',''),
                NULLIF('".$other."',''),
                NOW()
            )
        ",
            array(
                $this->input->post('mc_visit_id'),
                $this->input->post('mc_doctor_id'),
                $this->input->post('mc_result')
            )
        );
        return $this->db->insert_id();
    }

    function DoAddDataSicknessExplanation() {
        $sql = $this->db->query("
            INSERT INTO sickness_explanations(
                visit_id, 
                doctor_id, 
                explanation, 
                `date`) 

            VALUES(
                ?,?,?,
                NOW()
            )
        ",
            array(
                $this->input->post('se_visit_id'),
                $this->input->post('se_doctor_id'),
                $this->input->post('se_explanation')
            )
        );
        return $this->db->insert_id();
    }
	
		function GetDataContinue() {
        $sql = $this->db->query("
            SELECT * FROM ref_continue
        "
        );
        return $sql->result_array();
    }
}
?>
