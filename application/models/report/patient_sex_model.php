<?php
Class Patient_Sex_Model extends Model {

	function __construct() {
		parent::Model();
	}
	
	function GetDataPatient_SexForChart() {
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
				$between = " AND YEAR(p.`registration_date`) BETWEEN ? AND ? ";
				$start = $this->input->post('year_start');
				$end = $this->input->post('year_end');
			break;
			case "month" :
				$between = " AND p.`registration_date` BETWEEN STR_TO_DATE(?, '%Y-%c-%e') AND STR_TO_DATE(?, '%Y-%c-%e') ";
				$start = $this->input->post('year_start') . '-' . $this->input->post('month_start') . '-1';
				$end = $this->input->post('year_end') . '-' . $this->input->post('month_end') . '-' . date('t', mktime(0,0,0,$this->input->post('month_end'), 1, $this->input->post('year_end')));
			break;
			default :
				$between = " AND p.`registration_date` BETWEEN STR_TO_DATE(?, '%Y-%c-%e') AND STR_TO_DATE(?, '%Y-%c-%e') ";
				$start = $this->input->post('year_start') . '-' . $this->input->post('month_start') . '-' . $this->input->post('day_start');
				$end = $this->input->post('year_end') . '-' . $this->input->post('month_end') . '-' . $this->input->post('day_end');
			break;
		}
		$sql = $this->db->query("
			SELECT 
				IFNULL(p.`sex`, 'Tidak Diketahui') as name,
				COUNT(p.`family_folder`) as `count`
			FROM 
				patients p
				
				$join
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
