<?php
Class Kunjungan_Sex_Patients_Model extends Model {

	function __construct() {
		parent::Model();
	}
	
	function GetDataKunjungan_Sex_PatientsForChart() {
		$unit = $this->input->post('unit');
		$region = $this->input->post('region');
		$where = "";
		
		switch($unit) {
			case "all" :
				$between = " ";
				$start = "";
				$end = "";
			break;
			case "year" :
				$between = " AND YEAR(v.`date`) BETWEEN ? AND ? ";
				$start = $this->input->post('year_start');
				$end = $this->input->post('year_end');
			break;
			case "month" :
				$between = " AND v.`date` BETWEEN STR_TO_DATE(?, '%Y-%c-%e') AND STR_TO_DATE(?, '%Y-%c-%e') ";
				$start = $this->input->post('year_start') . '-' . $this->input->post('month_start') . '-1';
				$end = $this->input->post('year_end') . '-' . $this->input->post('month_end') . '-' . date('t', mktime(0,0,0,$this->input->post('month_end'), 1, $this->input->post('year_end')));
			break;
			default :
				$between = " AND v.`date` BETWEEN STR_TO_DATE(?, '%Y-%c-%e') AND STR_TO_DATE(?, '%Y-%c-%e') ";
				$start = $this->input->post('year_start') . '-' . $this->input->post('month_start') . '-' . $this->input->post('day_start');
				$end = $this->input->post('year_end') . '-' . $this->input->post('month_end') . '-' . $this->input->post('day_end');
			break;
		}
		$sql = $this->db->query("
			SELECT 
				DATE_FORMAT(v.`date`, '%Y%m%d') as `test`,IFNULL(p.`sex`, 'Tidak Diketahui') as name,
				COUNT(v.`family_folder`) as `count`
			FROM 
				patients p
				JOIN `visits` v ON (v.`family_folder` = p.`family_folder`)
				
			WHERE 1=1 $where $between
			GROUP BY p.`sex`
		", array(
			$start, $end
		));
		//echo $this->db->last_query();
		return $sql->result_array();
	}

}
?>
