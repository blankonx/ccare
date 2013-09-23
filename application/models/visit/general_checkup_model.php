<?php
Class General_Checkup_Model extends Model {

    function __construct() {
        parent::Model();
    }

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
	
	function GetDataPatient($visitId) {
		//get the current selected data
		$sql = $this->db->query("
			SELECT
				CONCAT(p.`family_folder`, '-', p.`family_relationship_id`) as `mr_number`,
				p.`name`,
				p.`parent_name`,
				p.`birth_place`,
				p.`sex` as `sex`,
				p.`birth_date` as `birth_date`, 
				v.`date` as `visit_date`, 
				DATE_FORMAT(v.`date`, '%d-%m-%Y') as `visit_date_formatted`, 
				CONCAT_WS(', ', v.`address`, rv.`name`, sd.`name`, d.`name`) as `address`,
				rd.name as doctor,
				rc.name as clinic,
				rpt.name as payment_type,
                v.continue_id as continue_id,
                v.continue_to as continue_to,
				rcon.name as `continue`
			FROM 
				`patients` p
				JOIN `visits` v ON (v.`patient_id` = p.`id` AND v.`family_relationship_id` = p.`family_relationship_id`)
				JOIN `ref_villages` rv ON (rv.`id` = v.`village_id`)
				JOIN `ref_sub_districts` sd ON (sd.`id` = rv.`sub_district_id`)
				JOIN `ref_districts` d ON (d.`id` = sd.`district_id`)
				LEFT JOIN `ref_paramedics` rd ON (rd.`id` = v.`paramedic_id`)
				JOIN `ref_clinics` rc ON (rc.`id` = v.`clinic_id`)
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
				CONCAT(p.`family_folder`, '-', p.`family_relationship_id`) as `mr_number`,
				p.`name`,
				p.`parent_name`,
				p.`birth_place`,
				p.`sex` as `sex`,
				DATE_FORMAT(p.`birth_date`, '%d/%m/%y') as `birth_date`, 
				v.`date` as `visit_date`,
				CONCAT_WS(', ', v.`address`, rv.`name`, sd.`name`, d.`name`) as `address`,
				e.`name` as `education_name`,
				j.`name` as `job_name`,
                v.`paramedic_id` as `doctor_id`,
                v.`continue_id` as `continue_id`,
                v.`continue_to` as `continue_to`,
                v.clinic_id as clinic_id,
                (
                    SELECT COUNT(*) 
                    FROM 
                        `visits` 
                    WHERE 
                        `patient_id`=(SELECT `patient_id` FROM `visits` WHERE `id`=?) 
                        AND `id` <=? 

                ) as `visit_count`,
                v.`served`
			FROM 
				`patients` p
				JOIN `visits` v ON (v.`patient_id` = p.`id`)
				JOIN `ref_villages` rv ON (rv.`id` = v.`village_id`)
				JOIN `ref_sub_districts` sd ON (sd.`id` = rv.`sub_district_id`)
				JOIN `ref_districts` d ON (d.`id` = sd.`district_id`)
				JOIN `ref_educations` e ON (e.`id` = v.`education_id`)
				JOIN `ref_jobs` j ON (j.`id` = v.`job_id`)
			WHERE
				v.`id`=?
		",
			array(
                $visit_id,
                $visit_id,
                $visit_id,
                $visit_id
            )
		);
		return $sql->row_array();
	}

    function GetDataGeneral_Checkup($visit_id) {
        $sql = $this->db->query("
            SELECT `id`, `visit_id`, `visit_inpatient_detail_id`, `sistole`, `diastole`, `temperature`, `pulse`, `physic_anamnese`, `respiration`, `weight`, `height`, `blood_type`, `odontogram_kode`, `oclusi`, `torus_palat`, `palatum`, `supernumery_teeth`, `ada_supernumery_teeth`, `diastema`, `ada_diastema`, `anomali_teeth`, `ada_anomali_teeth`, `other_sign`, `hypertensi`, `jantung`, `asthma`, `dm`, `drug_alergy`, `other_sick_history`, `eo_face`, `eo_kel_limfe`, `eo_others`, `io_mukosa_gingiva`, `io_palatum`, `io_gigi`, `teeth_ce`, `teeth_ce_plus`, `teeth_sondasi`, `teeth_sondasi_plus`, `teeth_perkusi`, `teeth_perkusi_plus`, `teeth_palpasi`, `teeth_palpasi_plus`, `log`, `date`  
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
                            v.`patient_id`=(SELECT `patient_id` FROM `visits` WHERE id=?)
                            
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
                   OR `kata_kunci` LIKE ?
        ",
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
                v.`patient_id`=(SELECT `patient_id` FROM `visits` WHERE id=?)
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
				CONCAT(`code`, '-', `drug`) as `name`, 
				`stock` 
            FROM 
				`view_drugs_stock_clinic`
            WHERE 
                stock>0
				AND clinic_id=(
                    SELECT
                        CASE 
                            WHEN rc.parent_id IN(160,161,162,163,164,165,166,167,168,169) THEN v.clinic_id
                            ELSE '016'
                        END
                    FROM
                        visits v
                        JOIN ref_clinics rc ON (rc.id = v.clinic_id)
                    WHERE 
                        v.id=?
                )
				AND (
				`code` LIKE ?
                   OR `drug` LIKE ?)
        ",
            array(
                $this->input->post('visit_id'),
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
                v.id=?
                AND (t.`name` LIKE ?
                   OR tc.`name` LIKE ?)
        ",
            array(
                $this->input->post('visit_id'),
                "%" . $q . "%",
                "%" . $q . "%"
            )
        );
        return $sql->result_array();
    }

    function GetDataDoctor() {
        $sql = $this->db->query("
            SELECT * FROM ref_paramedics WHERE active='yes' ORDER BY name
        "
        );
        return $sql->result_array();
    }

    function GetDataContinue() {
        $sql = $this->db->query("
            SELECT * FROM ref_continue
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

    function DoAddDiagnoses() {
        //insert the diagnose
        $anamnese = $_POST['anamnese'];
        $icd_code = $_POST['icd_code'];
        $icd_name = $_POST['icd_name'];
        $icd_id = $_POST['icd_id'];
        $explanation = $_POST['explanation'];
        $element_teeth = $_POST['elemen'];
        //$icd_id2 = $this->input->post('icd_id');
        $case = $_POST['case'];
	    
        //print_r($anamnese);
        //print_r($icd_id);

        if(!empty($anamnese)) {
            foreach($anamnese as $key => $val) {
                //echo $val;
                if($val && $icd_id[$key])
                    $arr_anamnese_diagnoses[] = "(NULLIF('" . $val . "', ''), '" . $icd_code[$key] . "', '" . $icd_name[$key] . "', '" . $icd_id[$key] . "', '" . $this->input->post('visit_id') . "', '" . date('Y-m-d H:i:s') . "', '".$case[$key]."', '".$explanation[$key]."', '".$element_teeth[$key]."')";
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
                INSERT INTO `anamnese_diagnoses` (`anamnese`, `icd_code`, `icd_name`, `icd_id`, `visit_id`, `date`, `case`, `explanation`,`element_teeth`) 
                VALUES $str_anamnese_diagnoses
            "
            );
        }
        return $ins;
    }

    function DoAddPrescribes() {
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
				/*SELECT THE STOCK*/
				$sql_cur_stock = $this->db->query("
					SELECT 
						`stock` as `stock_before_insert`, 
						`stock`-$qty[$i] as `stock_after_insert` 
					FROM 
						view_drugs_stock_clinic
					WHERE drug_id=? AND clinic_id='016'
				",
					array($drug_id[$i])
				);
				$cur_stock = $sql_cur_stock->row_array();
				
                $arr_drugs[] = "('" . $this->input->post('visit_id') . "', '" . $drug_id[$i] . "', '" . $drug_name[$i] . "', '" . $dosis1[$i] . "', '" . $dosis2[$i] . "', '" . $qty[$i] . "', '" . $unit[$i] . "', '" . date('Y-m-d H:i:s') . "', '".$cur_stock['stock_before_insert']."', '".$cur_stock['stock_after_insert']."')";
                /*
                if($qty[$i]) {
                    $this->db->query("
                        UPDATE `ref_drugs` SET `stock`=`stock`-$qty[$i] WHERE id=?
                    ",
                    array($drug_id[$i])
                    );
                }
                */
            }
        }

        if(!empty($arr_drugs)) {
            $str_drugs = implode(", ", $arr_drugs);
            $ins = $this->db->query("
                INSERT INTO `prescribes` (`visit_id`, `drug_id`, `drug_name`, `dosis1`, `dosis2`, `qty`, `unit`, `date`, `stock_before_insert`, `stock_after_insert`) 
                VALUES $str_drugs
            "
            );
        }
        return $ins;
    }

    function DoAddMix() {
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
			//echo "asu";
			//print_r($drug_id);
            //$drug_id = explode(",", $strDrugId);
            //$drug_name = explode(",", $strDrugName);
            //$qty = explode(",", $strQty);
            //$unit = explode(",", $strUnit);

            $arr_drugs = array();
            for($x=0;$x<sizeof($drug_id);$x++) {
                if($drug_id[$x] && $drug_id[$x] != 0) {
					/*SELECT THE STOCK*/
					$sql_cur_stock = $this->db->query("
						SELECT 
							`stock` as `stock_before_insert`, 
							`stock`-$qty[$x] as `stock_after_insert` 
						FROM 
							view_drugs_stock_clinic
						WHERE drug_id=? AND clinic_id='016'
					",
						array($drug_id[$x])
					);
					$cur_stock = $sql_cur_stock->row_array();
					$arr_drugs[] = "('" . $this->input->post('visit_id') . "', '" . $drug_id[$x] . "', '" . $drug_name[$x] . "', '" . $strMixName . "', '" . $strDosis1 . "', '" . $strDosis2 . "', '" . $qty[$x] . "', '" . $unit[$x] . "', '" . date('Y-m-d H:i:s') . "', '".$cur_stock['stock_before_insert']."', '".$cur_stock['stock_after_insert']."', '".$xname."', '" . $mix_qty_qty . "', '" . $mix_unit_unit . "')";
                    //$arr_drugs[] = "('" . $this->input->post('visit_id') . "', '" . $drug_id[$x] . "', '" . $drug_name[$x] . "', '" . $xname . "', '" . $strDosis1 . "', '" . $strDosis2 . "', '" . $qty[$x] . "', '" . $unit[$x] . "', '" . date('Y-m-d H:i:s') . "')";
                    /*
					if($qty[$x]) {
						$this->db->query("
							UPDATE `ref_drugs` SET `stock`=`stock`-$qty[$x] WHERE id=?
						",
						array($drug_id[$x])
						);
					}
					**/
				}
            }
            if(!empty($arr_drugs)) {
                $str_drugs = implode(", ", $arr_drugs);
                $sql = "
                    INSERT INTO `prescribes` (`visit_id`, `drug_id`, `drug_name`, `mix_name`, `dosis1`, `dosis2`, `qty`, `unit`, `date`, `stock_before_insert`, `stock_after_insert`, `randomnumber`, `mix_qty`, `mix_unit`) 
                    VALUES $str_drugs
                ";
                //echo $sql;
                $ins = $this->db->query($sql);
            }
        }
        return $ins; 
    }
    
    function DoAddTreatments() {
        //insert the treatments
        $arr_treatment_id = $this->input->post('treatment_id');
        $arr_cost = $this->input->post('treatment_price');
        $arr_treatment = $this->input->post('treatment_name');
        //print_r($arr_treatment_id);
        for($i=0;$i<sizeof($arr_treatment_id);$i++) {
            if($arr_treatment_id[$i] && $arr_treatment_id!='') {
                //$xarr_treatment_id[] = $arr_treatment_id[$i];
                $ins = $this->db->query("
                    INSERT INTO `treatments` (`visit_id`, `treatment_id`, `name`, `cost`, `date`) 
                    SELECT ?, `id`, ?, ?, NOW() FROM `ref_treatments` WHERE `id`=?
                ",
                array($this->input->post('visit_id'), $arr_treatment[$i], $arr_cost[$i], $arr_treatment_id[$i])
                );
                if(true === $ins) {
                    $treatment_id = $this->db->insert_id();
                    //insert into payments dab
                    $this->db->query("
                        INSERT INTO payments(
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
                            $this->input->post('visit_id')
                        ));
                }
                //echo $this->db->last_query();
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
    function DoAddData() {
        //set the input before and be the log
        /*
        11/28/2008
        query sebelumnya*/
        $this->db->trans_start();
        $this->db->query("
            UPDATE `examinations` SET `log`='yes' WHERE `visit_id`=?", 
            array($this->input->post('visit_id'))
        );
        /*
        $this->db->query("
            DELETE FROM `examinations` WHERE `visit_id`=?", 
            array($this->input->post('visit_id'))
        );
        */
		//set the served status to `yes`
		$this->db->query("
			UPDATE 
                `visits` 
            SET 
                `served`='yes',
                `paramedic_id`=?,
                `user_id_poli`=?,
                `continue_to`=NULLIF(?,''),
                `continue_id`=?
            WHERE id=?
			",
			array(
                $this->input->post('doctor_id'),
                $this->session->userdata('id'),
                $this->input->post('continue_to'),
                $this->input->post('continue_id'),
                $this->input->post('visit_id')
            )
		);
        
        //INSERT THE DIAGNOSES
        $this->DoAddDiagnoses();

        //INSERT THE PRESCRIBES
        $this->DoAddPrescribes();

        //INSERT THE PRESCRIBES MIX
        $this->DoAddMix();

        //INSERT THE TREATMENTS
        $this->DoAddTreatments();

        //ADD OR UPDATE THE EXPERT SYSTEM
        $this->DoUpdateExpertAnamneseDiagnoses();

		$arr_odontogram = $this->input->post('odontogram');
		$odontogram = implode("|",$arr_odontogram);
		//echo $odontogram;
        $x = $this->db->query("
            INSERT INTO examinations(visit_id, sistole, diastole, temperature, pulse, physic_anamnese, respiration, weight, height, blood_type, `date`, `odontogram_kode`,`oclusi`,`torus_palat`,`palatum`,`supernumery_teeth`,ada_supernumery_teeth,`diastema`,ada_diastema,`anomali_teeth`,ada_anomali_teeth,`other_sign`,`hypertensi`,`jantung`,`asthma`,`dm`,`drug_alergy`,`other_sick_history`,`eo_face`,`eo_kel_limfe`,`eo_others`,`io_mukosa_gingiva`,`io_palatum`,io_gigi,`teeth_ce`,teeth_ce_plus,`teeth_sondasi`,teeth_sondasi_plus,`teeth_perkusi`,teeth_perkusi_plus,`teeth_palpasi`,teeth_palpasi_plus)
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
                NOW(),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,''),
                NULLIF(?,'')
                
                )
            ",
            array(
                $this->input->post('visit_id'),
                $this->input->post('sistole'),
                $this->input->post('diastole'),
                $this->input->post('temperature'),
                $this->input->post('pulse'),
                trim($this->input->post('physic_anamnese')),
                $this->input->post('respiration'),
                $this->input->post('weight'),
                $this->input->post('height'),
                $this->input->post('blood_type'),
                $odontogram,
                $this->input->post('oclusi'),
                $this->input->post('torus_palat'),
                $this->input->post('palatum'),
                $this->input->post('supernumery'),
                $this->input->post('ada_supernumery'),
                $this->input->post('diastema'),
                $this->input->post('ada_diastema'),
                $this->input->post('gigi_anomali'),
                $this->input->post('ada_gigi_anomali'),
                $this->input->post('lain2'),
                $this->input->post('hypertensi'),
                $this->input->post('jantung'),
                $this->input->post('asthma'),
                $this->input->post('dm'),
                $this->input->post('alergi_obat'),
                $this->input->post('lain3'),
                $this->input->post('eo_face'),
                $this->input->post('eo_kel_limfe'),
                $this->input->post('lain4'),
                $this->input->post('io_mukosa_gingiva'),
                $this->input->post('io_lidah_palatum'),
                $this->input->post('io_gigi'),
                $this->input->post('io_ce'),
                $this->input->post('io_ce_plus'),
                $this->input->post('io_sondasi'),
                $this->input->post('io_sondasi_plus'),
                $this->input->post('io_perkusi'),
                $this->input->post('io_perkusi_plus'),
                $this->input->post('io_palpasi'),
                $this->input->post('io_palpasi_plus')
                
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
}
?>
