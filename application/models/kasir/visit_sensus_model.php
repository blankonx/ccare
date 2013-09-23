<?php
Class Visit_Sensus_Model extends Model {

	function __construct() {
		parent::Model();
	}
	
	function GetDataVisitSensus() {
		$unit = $this->input->post('unit');
		$where = "";
		
		//$where .= " AND v.`served`='yes' ";
		
		switch($unit) {
			case "year" :
				$between = " AND YEAR(v.`date`) BETWEEN ? AND ? ";
				$start = $this->input->post('year_start');
				$end = $this->input->post('year_end');
			break;
			case "month" :
				$between = " AND DATE(v.`date`) BETWEEN STR_TO_DATE(?, '%Y-%c-%e') AND STR_TO_DATE(?, '%Y-%c-%e') ";
				$start = $this->input->post('year_start') . '-' . $this->input->post('month_start') . '-1';
				$end = $this->input->post('year_end') . '-' . $this->input->post('month_end') . '-' . date('t', mktime(0,0,0,$this->input->post('month_end'), 1, $this->input->post('year_end')));
			break;
			default :
				$between = " AND DATE(v.`date`) BETWEEN STR_TO_DATE(?, '%Y-%c-%e') AND STR_TO_DATE(?, '%Y-%c-%e') ";
				$start = $this->input->post('year_start') . '-' . $this->input->post('month_start') . '-' . $this->input->post('day_start');
				$end = $this->input->post('year_end') . '-' . $this->input->post('month_end') . '-' . $this->input->post('day_end');
			break;
		}
		
		$sql = $this->db->query("
			SELECT 
				v.id as id,
				p.`family_folder` as `no_rm`,
				p.name as name,
				DATE_FORMAT(v.`date`, '%d/%m/%Y')  as `date`,
				pres.drug as drug,
				ad.diagnose as diagnose,
				tr.treatment as treatment
			FROM 
				visits v
				JOIN patients p ON (p.id = v.patient_id)
				LEFT JOIN (
					SELECT 
						visit_id,
						GROUP_CONCAT(CONCAT(drug_name, ' (', qty, ' ', unit, ')') SEPARATOR '<br/>') as drug
					FROM
						prescribes
					WHERE `log`='no'
					GROUP BY visit_id
				) pres ON (pres.visit_id = v.id)
				LEFT JOIN (
					SELECT 
						visit_id,
						GROUP_CONCAT(icd_name SEPARATOR '<br/>') as diagnose
					FROM
						anamnese_diagnoses
					WHERE `log`='no'
					GROUP BY visit_id
					) ad ON (ad.visit_id = v.id)
				LEFT JOIN (
					SELECT 
						visit_id,
						GROUP_CONCAT(name SEPARATOR '<br/>') as treatment
					FROM
						treatments
					WHERE `log`='no'
					GROUP BY visit_id
					) tr ON (tr.visit_id = v.id)
			WHERE 
				v.`served`='yes'
				$where
				$between
		", array(
			$start, $end
		));
		//echo "<pre>" . $this->db->last_query() . "</pre>";
		return $sql->result_array();
	}
	
	
	function GetDataVisitSensusPrint($report_param) {
		$unit = $report_param['unit'];
		$where = "";
			
		//$where .= " AND v.`served`='yes' ";
		
		switch($unit) {
			case "year" :
				$between = " AND YEAR(v.`date`) BETWEEN ? AND ? ";
				$start = $report_param['year_start'];
				$end = $report_param['year_end'];
			break;
			case "month" :
				$between = " AND DATE(v.`date`) BETWEEN STR_TO_DATE(?, '%Y-%c-%e') AND STR_TO_DATE(?, '%Y-%c-%e') ";
				$start = $report_param['year_start'] . '-' . $report_param['month_start'] . '-1';
				$end = $report_param['year_end'] . '-' . $report_param['month_end'] . '-' . date('t', mktime(0,0,0,$report_param['month_end'], 1, $report_param['year_end']));
			break;
			default :
				$between = " AND DATE(v.`date`) BETWEEN STR_TO_DATE(?, '%Y-%c-%e') AND STR_TO_DATE(?, '%Y-%c-%e') ";
				$start = $report_param['year_start'] . '-' . $report_param['month_start'] . '-' . $report_param['day_start'];
				$end = $report_param['year_end'] . '-' . $report_param['month_end'] . '-' . $report_param['day_end'];
			break;
		}
		
		$sql = $this->db->query("
			SELECT 
				v.id as id,
				p.`family_folder` as `no_rm`,
				p.name as name,
				DATE_FORMAT(v.`date`, '%d/%m/%Y')  as `date`,
				pres.drug as drug,
				ad.diagnose as diagnose,
				tr.treatment as treatment
			FROM 
				visits v
				JOIN patients p ON (p.id = v.patient_id)
				LEFT JOIN (
					SELECT 
						visit_id,
						GROUP_CONCAT(CONCAT(drug_name, ' (', qty, ' ', unit, ')') SEPARATOR '<br/>') as drug
					FROM
						prescribes
					WHERE `log`='no'
					GROUP BY visit_id
				) pres ON (pres.visit_id = v.id)
				LEFT JOIN (
					SELECT 
						visit_id,
						GROUP_CONCAT(icd_name SEPARATOR '<br/>') as diagnose
					FROM
						anamnese_diagnoses
					WHERE `log`='no'
					GROUP BY visit_id
					) ad ON (ad.visit_id = v.id)
				LEFT JOIN (
					SELECT 
						visit_id,
						GROUP_CONCAT(name SEPARATOR '<br/>') as treatment
					FROM
						treatments
					WHERE `log`='no'
					GROUP BY visit_id
					) tr ON (tr.visit_id = v.id)
			WHERE 
				v.`served`='yes'
				$where
				$between
		", array(
			$start, $end
		));
		//echo "<pre>" . $this->db->last_query() . "</pre>";
		return $sql->result_array();
	}

	function GetDataClinicName($id) {
		$sql = $this->db->query("SELECT name FROM ref_clinics WHERE id=?", array($id));
		$data = $sql->row_array();
		return $data['name'];
	}

}
?>
