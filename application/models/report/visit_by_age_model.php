<?php
Class Visit_By_Age_Model extends Model {

	function __construct() {
		parent::Model();
	}
	
	function GetDataVisit_By_AgeForChart() {
		$unit = $this->input->post('unit');
		$region = $this->input->post('region');
		$clinic_id = $this->input->post('clinic_id');
		/*
		if($arr_clinic_id)
			$clinic_id = implode(",", $arr_clinic_id);
		else $clinic_id = "";
		*/ 
		
		$where = " ";
		$group_by = "  ";
		switch($unit) {
			case "year" :
				$select = " YEAR(v.`date`) as `test` ";
				$group_by .= " YEAR(v.`date`) ";
				$between = " YEAR(v.`date`) BETWEEN ? AND ? ";
				$start = $this->input->post('year_start');
				$end = $this->input->post('year_end');
			break;
			case "month" :
				$select = " EXTRACT(YEAR_MONTH FROM v.`date`) as `test` ";
				$group_by .= " EXTRACT(YEAR_MONTH FROM v.`date`) ";
				$between = " DATE(v.`date`) BETWEEN STR_TO_DATE(?, '%Y-%c-%e') AND STR_TO_DATE(?, '%Y-%c-%e') ";
				$start = $this->input->post('year_start') . '-' . $this->input->post('month_start') . '-1';
				$end = $this->input->post('year_end') . '-' . $this->input->post('month_end') . '-' . date('t', mktime(0,0,0,$this->input->post('month_end'), 1, $this->input->post('year_end')));
			break;
			default :
				$select = " DATE_FORMAT(v.`date`, '%Y%m%d') as `test` ";
				$group_by .= " DATE(v.`date`) ";
				$between = " DATE(v.`date`) BETWEEN STR_TO_DATE(?, '%Y-%c-%e') AND STR_TO_DATE(?, '%Y-%c-%e') ";
				$start = $this->input->post('year_start') . '-' . $this->input->post('month_start') . '-' . $this->input->post('day_start');
				$end = $this->input->post('year_end') . '-' . $this->input->post('month_end') . '-' . $this->input->post('day_end');
			break;
		}
		
		$sql = $this->db->query("
			SELECT 
				getKelompokUmur(p.birth_date, DATE(v.`date`)) as 'age',
				COUNT(v.id) as `count`,
				$select
			FROM 
				visits v
				JOIN patients p ON (p.id = v.patient_id)
			WHERE $where $between
			GROUP BY getKelompokUmur(p.birth_date, DATE(v.`date`)), $group_by
			ORDER BY test, `name`
		", array(
			$start, $end
		));
		$return = $sql->result_array();
		//echo $this->db->last_query();
		return $return;
	}
 
    function GetDataPaymentType() {
        $sql = $this->db->query("
            SELECT 
                `id` as `id`, 
                `name` as `name`
            FROM
                `ref_ages`
            WHERE 
				`active` = 'yes'"
        );
        return $sql->result_array();
    }
}
?>
