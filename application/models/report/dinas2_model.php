<?php
Class Dinas2_Model extends Model {
	function __construct() {
		parent::Model();
	}
	
	function GetReport() {
		$unit = $this->input->post('unit');
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
			rp.name as puskesmas,
			v.patient_id as no_rm,
			rv.name as desa,
			rsd.name as kecamatan,
			getAgeAsYear(v.id) as usia,
			ad.icd_code as kode_icd,
			ad.icd_name as diagnosa,
			ad.`case` as `case`,
			DATE(v.`date`) as tgl,
			p.sex as sex,
			rpt.name as jenis_pasien
		FROM
			visits v
			JOIN patients p ON (p.id = v.patient_id)
			JOIN anamnese_diagnoses ad ON (ad.visit_id = v.id)
			JOIN ref_villages rv ON (rv.id = v.village_id)
			JOIN ref_sub_districts rsd ON (rsd.id = rv.sub_district_id)
			JOIN ref_payment_types rpt ON (rpt.id = v.payment_type_id),
			ref_profiles rp
		WHERE
			v.served='yes'
			$between
		", array($start, $end));
		return $sql->result_array();
	}
}
?>
