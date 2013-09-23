<?php
Class History_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
	function GetData($visit_id) {
	}

    function GetLatestVisit($visitId) {
        $sql = $this->db->query("
            SELECT 
                v.id as id,
                DATE_FORMAT(v.`date`, '%d %b %y') as `date`,
                `getDateDiff`(v.`date`) as `datediff`,
                c.`name` as `clinic`,
                GROUP_CONCAT(CONCAT(an.anamnese, ', <b>', an.icd_name, '</b>') SEPARATOR '|') as anamnese_diagnose,
                GROUP_CONCAT(tr.name SEPARATOR '|') as treatment,
                GROUP_CONCAT(CONCAT(pr.drug_name, '&nbsp;&nbsp;(', format(pr.dosis1,0), ' x ', format(pr.dosis2,0), ')',' Jml: ',substring_index(pr.qty,'.',1),' ',pr.unit) SEPARATOR '|') as prescribe,
                CONCAT_WS('/', ex.sistole, ex.diastole) as blood_pressure,
                ex.temperature as temperature,
                ex.pulse as pulse,
                ex.physic_anamnese as physic_anamnese,
                ex.respiration as respiration,
                ex.weight as weight,
                ex.height as height,
                ex.blood_type as blood_type 
            FROM `examinations` ex
                JOIN `visits` v ON (v.id = ex.visit_id)
                JOIN `ref_clinics` c ON (c.id = v.clinic_id)
                JOIN `patients` p ON (p.id = v.patient_id)
                LEFT JOIN anamnese_diagnoses an ON (an.visit_id = v.id)
                LEFT JOIN treatments tr ON (tr.visit_id = v.id)
                LEFT JOIN prescribes pr ON (pr.visit_id = v.id)
            WHERE 
                v.id <= ?
                AND v.patient_id=(SELECT patient_id FROM visits WHERE id=?)
            GROUP BY v.id
            ORDER BY v.id DESC 
            LIMIT 1
        ",
            array(
                $visitId,
                $visitId,
                $visitId,
                $visitId
                )
        );
        return $sql->row_array();
        
    }
/*
    function GetLatestVisit2($visitId) {
        $sql = $this->db->query("
            SELECT 
                v.id as id,
                DATE_FORMAT(v.`date`, '%e %b %y') as `date`,
                CASE 
                    WHEN (TIMESTAMPDIFF(HOUR, v.`date`, NOW()) < 1) THEN CONCAT((TIMESTAMPDIFF(MINUTE, v.`date`, NOW())), ' minutes ago')
                    WHEN (TIMESTAMPDIFF(HOUR, v.`date`, NOW()) <= 24) THEN CONCAT((TIMESTAMPDIFF(HOUR, v.`date`, NOW())), ' hours ago')
                    WHEN (DATEDIFF(NOW(), v.`date`) < 2) THEN 'Yesterday'
                ELSE CONCAT(DATEDIFF(NOW(), v.`date`), ' days ago') END as `datediff`,
                c.`name` as `clinic`,
                an.anamnese as anamnese,
                an.icd_name as diagnose,
                tr.name as treatment,
                CONCAT(pr.drug_name, '&nbsp;&nbsp;(', pr.dosis1, ' x ', pr.dosis2, ')') as prescribe
            FROM `examinations` ex
                JOIN `visits` v ON (v.id = ex.visit_id)
                JOIN `ref_clinics` c ON (c.id = v.clinic_id)
                LEFT JOIN anamnese_diagnoses an ON (an.visit_id = v.id)
                LEFT JOIN treatments tr ON (tr.visit_id = v.id)
                LEFT JOIN prescribes pr ON (pr.visit_id = v.id)
            WHERE 
                v.patient_id = (SELECT `patient_id` FROM `visits` WHERE id=?)
                AND v.id < ?
            GROUP BY v.id
            ORDER BY v.id DESC 
        ",
            array(
                $visitId,
                $visitId,
                $visitId
                )
        );
        return $sql->result_array();
        
    }
*/
    function GetListVisit($visitId, $limit, $offset) {
        $sql = $this->db->query("
            SELECT 
                SQL_CALC_FOUND_ROWS 
                v.id as id,
                DATE_FORMAT(v.`date`, '%e %b %y') as `date`,
                `getDateDiff`(v.`date`) as `datediff`,
                c.`name` as `clinic`,
                CASE
                    WHEN(LENGTH(GROUP_CONCAT(an.`icd_name` SEPARATOR ', ')) > 80) THEN CONCAT(SUBSTRING(GROUP_CONCAT(an.`icd_name` SEPARATOR ', '), 1, 80), ' ...')
                ELSE GROUP_CONCAT(an.`icd_name` SEPARATOR ', ')
                END as `diagnose`
                
            FROM `examinations` ex
                JOIN `visits` v ON (v.id = ex.visit_id)
                JOIN `ref_clinics` c ON (c.id = v.clinic_id)
                JOIN `patients` p ON (p.id = v.patient_id)
                LEFT JOIN anamnese_diagnoses an ON (an.visit_id = v.id)
            WHERE 
                v.id<=?
                AND v.patient_id=(SELECT patient_id FROM visits WHERE id=?)
            GROUP BY v.id, c.id
            ORDER BY v.id DESC
            LIMIT $limit, $offset
        ",
            array(
                $visitId,
                $visitId
                )
        );
        //echo $this->db->last_query();
        if($sql->num_rows() > 0) {
            return $sql->result_array();
        } else {
            return false;
        }
        //return $sql->result_array();
    }

    function getCount() {
        $sql = $this->db->query("SELECT FOUND_ROWS() as total");
        if($sql->num_rows() > 0) {
            $data = $sql->row_array();
            return $data['total'];
        } else {
            return false;
        }
    }

    function GetDetailVisit($visitId) {
        $sql = $this->db->query("
            SELECT 
                v.id as id,
                DATE_FORMAT(v.`date`, '%d %b %y') as `date`,
                `getDateDiff`(v.`date`) as `datediff`,
                c.`name` as `clinic`,
                GROUP_CONCAT(CONCAT(an.anamnese, ', <b>', an.icd_name, '</b>') SEPARATOR '|') as anamnese_diagnose,
                GROUP_CONCAT(tr.name SEPARATOR '|') as treatment,
                GROUP_CONCAT(CONCAT(pr.drug_name, '&nbsp;&nbsp;(', pr.dosis1, ' x ', pr.dosis2, ')') SEPARATOR '|') as prescribe,
                CONCAT_WS('/', ex.sistole, ex.diastole) as blood_pressure,
                ex.temperature as temperature,
                ex.pulse as pulse,
                ex.physic_anamnese as physic_anamnese,
                ex.respiration as respiration,
                ex.weight as weight,
                ex.height as height,
                ex.blood_type as blood_type
            FROM `examinations` ex
                JOIN `visits` v ON (v.id = ex.visit_id)
                JOIN `ref_clinics` c ON (c.id = v.clinic_id)
                LEFT JOIN anamnese_diagnoses an ON (an.visit_id = v.id)
                LEFT JOIN treatments tr ON (tr.visit_id = v.id)
                LEFT JOIN prescribes pr ON (pr.visit_id = v.id)
            WHERE 
                v.id = ?
            GROUP BY v.id
            ORDER BY v.id DESC 
            LIMIT 1
        ",
            array(
                $visitId
                )
        );
        return $sql->row_array();
        
    }

/*
    function GetDataHistory($visitId) {
        $sql = $this->db->query("
            SELECT 
                DATE_FORMAT(v.`date`, '%d %b %y') as `date`,
                CASE 
                    WHEN (DATEDIFF(NOW(), v.`date`) = 0) THEN 'Today'
                    WHEN (DATEDIFF(NOW(), v.`date`) = 1) THEN 'Yesterday'
                ELSE CONCAT(DATEDIFF(NOW(), v.`date`), ' days ago') END as `datediff`,
                c.`name` as `clinic`,
                GROUP_CONCAT(an.anamnese SEPARATOR '<br/><br/>') as anamnese,
                GROUP_CONCAT(ri.name SEPARATOR '<br/><br/>') as diagnose,
                GROUP_CONCAT(tr.name SEPARATOR '<br/><br/>') as treatment,
                GROUP_CONCAT(CONCAT(rd.name, '\t', pr.dosis1, ' x ', pr.dosis2) SEPARATOR '-') as prescribe
            FROM `examinations` ex
                JOIN `visits` v ON (v.id = ex.visit_id)
                JOIN `ref_clinics` c ON (c.id = v.clinic_id)
                LEFT JOIN anamnese_diagnoses an ON (an.visit_id = v.id)
                LEFT JOIN ref_icds ri ON (ri.id = an.icd_id)
                LEFT JOIN treatments tr ON (tr.visit_id = v.id)
                LEFT JOIN prescribes pr ON (pr.id = v.id)
                JOIN ref_drugs rd ON (rd.id = pr.drug_id)
            WHERE 
                v.patient_id = (SELECT `patient_id` FROM `visits` WHERE id=?)
                AND v.patient_family_code = (SELECT `patient_family_code` FROM `visits` WHERE id=?)
                AND an.`log`='no'
                AND tr.`log`='no'
            GROUP BY v.id
            ORDER BY v.`date` DESC
        ",
            array(
                $visitId,
                $visitId
                )
        );
        return $sql->result_array();
    }
    */
}
?>
