<?php
Class Medical_Certificate_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//

	function GetList($visitId, $limit, $offset) {
        $sql = $this->db->query("
            SELECT 
                SQL_CALC_FOUND_ROWS 
                mc.id as id,
                mc.no as no,
                rd.name as doctor,
                mc.result as result,
                CASE 
                    WHEN mc.medical_certificate_explanation_id IS NULL THEN medical_certificate_explanation_other
                    ELSE rmce.name
                END as explanation,
                DATE_FORMAT(mc.`date`, '%e %b %y') as `date`,
                `getDateDiff`(v.`date`) as `datediff`
            FROM
                medical_certificates mc
                JOIN view_ref_doctors rd ON (rd.id = mc.doctor_id)
                LEFT JOIN ref_medical_certificate_explanations rmce ON (rmce.id = mc.medical_certificate_explanation_id)
                JOIN visits v ON (v.id = mc.visit_id)
            WHERE
                v.patient_id = (SELECT patient_id FROM visits WHERE id=?)
            ORDER BY mc.id DESC
            LIMIT $limit, $offset
        ",
        array(
            $visitId
        ));
        //echo $this->db->last_query();

        if($sql->num_rows() > 0) {
            return $sql->result_array();
        } else {
            return false;
        }
	}

    function GetCount() {
        $sql = $this->db->query("SELECT FOUND_ROWS() as total");
        if($sql->num_rows() > 0) {
            $data = $sql->row_array();
            return $data['total'];
        } else {
            return false;
        }
    }

    function GetDetail($mcId) {
        $sql = $this->db->query("
            SELECT 
                p.name as `name`,
				CONCAT_WS(', ', v.`address`, rv.`name`, sd.`name`, d.`name`) as `address`,
                p.`sex` as `sex`,
				j.`name` as `job`,
				mc.no as no,
                mc.id as id,
                rd.name as doctor,
                mc.result as result,
                p.birth_place,
                p.birth_date,
                CASE 
                    WHEN mc.medical_certificate_explanation_id IS NULL THEN medical_certificate_explanation_other
                    ELSE rmce.name
                END as explanation,
                DATE_FORMAT(mc.`date`, '%e %b %y') as `date`,
                ex.weight,
                ex.height,
                ex.sistole,
                ex.diastole,
                ex.blood_type,
                rd.nip as nip
            FROM
                medical_certificates mc
                JOIN view_ref_doctors rd ON (rd.id = mc.doctor_id)
                LEFT JOIN ref_medical_certificate_explanations rmce ON (rmce.id = mc.medical_certificate_explanation_id)
                JOIN visits v ON (v.id = mc.visit_id)
                JOIN patients p ON (p.id = v.patient_id)
				JOIN `ref_villages` rv ON (rv.`id` = v.`village_id`)
				JOIN `ref_sub_districts` sd ON (sd.`id` = rv.`sub_district_id`)
				JOIN `ref_districts` d ON (d.`id` = sd.`district_id`)
				JOIN `ref_jobs` j ON (j.`id` = v.`job_id`)
                LEFT JOIN (
                    SELECT * FROM
                    examinations 
                    WHERE `log`='no'
                    ) ex ON (ex.visit_id = v.id)
            WHERE
                mc.id=?
        ",
        array(
            $mcId
        ));
        //echo $this->db->last_query();
        if($sql->num_rows() > 0) {
            return $sql->row_array();
        } else {
            return false;
        }
    }

	function GetData($visit_id) {
		//get the current selected data
		$sql = $this->db->query("
			SELECT
                v.`id` as `visit_id`,
				CONCAT(p.`family_folder`, '-', p.`id`, '-', p.`family_relationship_id`) as `mr_number`,
                CONCAT_WS('/', rp.nama_singkat, `numericToRom`(DATE_FORMAT(NOW(), '%m')), DATE_FORMAT(NOW(), '%Y')) as `no`,
				p.`name`,
				p.`parent_name`,
				p.`birth_place`,
				p.`sex` as `sex`,
				DATE_FORMAT(p.`birth_date`, '%d/%m/%y') as `birth_date`, 
				v.`date` as `visit_date`,
				CONCAT_WS(', ', v.`address`, rv.`name`, sd.`name`, d.`name`) as `address`,
				e.`name` as `education_name`,
				j.`name` as `job_name`,
                (
                    SELECT COUNT(*) 
                    FROM 
                        `visits` 
                    WHERE 
                        `patient_id`=(SELECT `patient_id` FROM `visits` WHERE `id`=?) 
                        AND `id` <=? 

                ) as `visit_count`
			FROM 
				`patients` p
				JOIN `visits` v ON (v.`patient_id` = p.`id`)
				JOIN `ref_villages` rv ON (rv.`id` = v.`village_id`)
				JOIN `ref_sub_districts` sd ON (sd.`id` = rv.`sub_district_id`)
				JOIN `ref_districts` d ON (d.`id` = sd.`district_id`)
				JOIN `ref_educations` e ON (e.`id` = v.`education_id`)
				JOIN `ref_jobs` j ON (j.`id` = v.`job_id`),
				ref_profiles rp
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
                $this->input->post('mc_visit_id'),
                $this->input->post('mc_doctor_id'),
                $this->input->post('mc_no') . $this->input->post('mc_no_hidden'),
                $this->input->post('mc_result')
            )
        );
        $a = $this->db->insert_id();
        /*BATAM : SURAT KETERANGAN SEHAT DILAKUKAN DI LAB*/
        $this->db->query("UPDATE visits SET served='yes', paramedic_id=? WHERE id=?", array(
			$this->input->post('mc_doctor_id'),
			$this->input->post('mc_visit_id')
		));
        return $a;
    }
}
?>
