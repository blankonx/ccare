<?php
Class Rekap_Pasien_Model extends Model {

	function __construct() {
		parent::Model();
	}
	
	function GetDataRekapRekap_Pasien() {
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
                (px.`family_folder`) as `mr_number`,
                px.name as name,
                p.name as treatment,
                p.pay as pay
			FROM 
				payments p
                JOIN visits v ON (v.id = p.visit_id)
                JOIN patients px ON (px.family_folder = v.family_folder)
			WHERE 
                p.paid='yes'
				$where
				$between
            GROUP BY p.id
            ORDER BY px.family_folder, p.name
		", array(
			$start, $end
		));
		//echo "<pre>" . $this->db->last_query() . "</pre>";
		return $sql->result_array();
	}
	
	
	function GetDataRekapRekap_PasienPrint($report_param) {
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
                (px.`family_folder`) as `mr_number`,
                px.name as name,
                p.name as treatment,
                p.pay as pay
			FROM 
				payments p
                JOIN visits v ON (v.id = p.visit_id)
                JOIN patients px ON (px.family_folder = v.family_folder)
			WHERE 
                p.paid='yes'
				$where
				$between
            GROUP BY p.id
            ORDER BY px.family_folder, p.name
		", array(
			$start, $end
		));
		//echo "<pre>" . $this->db->last_query() . "</pre>";
		return $sql->result_array();
	}
}
?>
