<?php
Class Sickness_Explanation_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
	function GetList($visitId, $limit, $offset) {
        $sql = $this->db->query("
            SELECT 
                SQL_CALC_FOUND_ROWS 
                se.id as id,
                rd.name as doctor,
                se.explanation as explanation,
                DATE_FORMAT(se.`date`, '%e %b %y') as `date`,
                `getDateDiff`(v.`date`) as `datediff`
            FROM
                sickness_explanations se
                JOIN view_ref_doctors rd ON (rd.id = se.doctor_id)
                JOIN visits v ON (v.id = se.visit_id)
            WHERE
                v.patient_id = (SELECT patient_id FROM visits WHERE id=?)
            ORDER BY se.id DESC
            LIMIT $limit, $offset
        ",
        array(
            $visitId
        ));

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

    function GetDetail($seId) {
        $sql = $this->db->query("
            SELECT 
                p.name as `name`,
				CONCAT_WS(', ', v.`address`, rv.`name`, sd.`name`, d.`name`) as `address`,
				se.no as no,
                p.`sex` as `sex`,
                p.birth_place,
                p.birth_date,
				j.`name` as `job`,
				e.`name` as `education`,
                se.id as id,
                se.permit_day as permit_day,
                rd.name as doctor,
                rd.nip as nip,
                se.explanation as explanation,
                DATE_FORMAT(se.`date`, '%d-%m-%Y') as `date_before`,
                DATE_FORMAT(DATE_ADD(se.`date`, INTERVAL `permit_day` DAY), '%d-%m-%Y') as `date_after`,
                DATE_FORMAT(se.`date`, '%e %b %y') as `date`
            FROM
                sickness_explanations se
                JOIN view_ref_doctors rd ON (rd.id = se.doctor_id)
                JOIN visits v ON (v.id = se.visit_id)
                JOIN patients p ON (p.id = v.patient_id)
				JOIN `ref_villages` rv ON (rv.`id` = v.`village_id`)
				JOIN `ref_sub_districts` sd ON (sd.`id` = rv.`sub_district_id`)
				JOIN `ref_districts` d ON (d.`id` = sd.`district_id`)
				JOIN `ref_jobs` j ON (j.`id` = v.`job_id`)
				JOIN `ref_educations` e ON (e.`id` = v.`education_id`)
            WHERE
                se.id=?
        ",
        array(
            $seId
        ));

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

    function DoAddDataSicknessExplanation() {
        $sql = $this->db->query("
            INSERT INTO sickness_explanations(
                visit_id, 
                doctor_id, 
                no,
                permit_day,
                explanation, 
                `date`) 

            VALUES(
                ?,?,?,?,?,STR_TO_DATE(?, '%d/%m/%Y')
            )
        ",
            array(
                $this->input->post('se_visit_id'),
                $this->input->post('se_doctor_id'),
                $this->input->post('se_no') . $this->input->post('se_no_hidden'),
                $this->input->post('se_permit_day'),
                $this->input->post('se_explanation'),
                $this->input->post('se_date')
            )
        );
        $a = $this->db->insert_id();
        $this->db->query("UPDATE visits SET served='yes', paramedic_id=? WHERE id=?", array(
			$this->input->post('se_doctor_id'),
			$this->input->post('se_visit_id')
		));
		return $a;
    }

}
?>
