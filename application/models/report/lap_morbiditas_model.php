<?php
Class Lap_Morbiditas_Model extends Model {

	function __construct() {
		parent::Model();
	}
	
	function GetReportDinas() {
		$sql = $this->db->query("
			SELECT * FROM report_dinas ORDER BY id DESC
		");
		$return = $sql->result_array();
		return $return;
	}
	
	//DO
	function DoAddReportDinas($periode, $filename) {
		return $this->db->query("
			INSERT INTO report_dinas (periode, filename, filesize) VALUES
			('".$periode."', '".$filename."', '".filesize($filename)."')
		");
	}
		
	function BackupVisits($periode, $profile) {
		$unit = $this->input->post('unit');
		$where = "";
		
		$payment_type_id = $this->input->post('payment_type_id');
		if($payment_type_id != '') {
			$where .= " AND v.`payment_type_id` = '".$payment_type_id."' ";
		}
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

		$sql = $this->db->query("SELECT  p.nik, p.name,  p.birth_date,(CASE WHEN (`p`.`sex` = 'Laki-laki') THEN '1' ELSE '2' END) AS `sex`, v.date as visit_date, v.payment_type_id, ad.diagnose as diagnose,tr.treatment as treatment, tr.total, v.address, v.insurance_no,(SELECT `no_str` AS `code` FROM `ref_profiles`) AS `kode_klinik`
			FROM patients p
			LEFT JOIN visits v ON (v.family_folder = p.family_folder)
			LEFT JOIN (SELECT visit_id,icd_id, GROUP_CONCAT(CONCAT(icd_code, ' ', icd_name) SEPARATOR '|') as diagnose
								FROM
								anamnese_diagnoses
								WHERE `log`='no' OR `log` is null
								GROUP BY visit_id
								) ad ON (ad.visit_id = v.id)
			LEFT JOIN (SELECT visit_id, sum(cost) as total, GROUP_CONCAT(name SEPARATOR '|') as treatment
								FROM
								treatments
								WHERE `log`='no' OR `log` is null
								GROUP BY visit_id
								) tr ON (tr.visit_id = v.id)
			WHERE 1=1
				$where
				$between
		", array(
			$start, $end
		));
		return $sql->result_array();
		//echo $this->db->last_query();
	}

	function GetComboPaymentType() {
        $sql = $this->db->query("
            SELECT 
                id,name
            FROM
                `ref_payment_types`
            ORDER BY
				name
            "
        );
        return $sql->result_array();
    }

	
	function GetDataPaymentTypeName($id) {
		$sql = $this->db->query("SELECT name FROM ref_payment_types WHERE id=?", array($id));
		$data = $sql->row_array();
		return $data['name'];
	}
		
}
?>
