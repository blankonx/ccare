<?php
Class Visit_By_Payment_Type_Model extends Model {

	function __construct() {
		parent::Model();
	}
	
	function GetDataVisit_By_Payment_TypeForChart() {
		$unit = $this->input->post('unit');
		$where = "";
		
		$group_by = " rpt.id, ";
		switch($unit) {
			case "year" :
				$select = " YEAR(v.`date`) as `test`, ";
				$group_by .= " YEAR(v.`date`) ";
				$between = " AND YEAR(v.`date`) BETWEEN ? AND ? ";
				$start = $this->input->post('year_start');
				$end = $this->input->post('year_end');
			break;
			case "month" :
				$select = " EXTRACT(YEAR_MONTH FROM v.`date`) as `test`, ";
				$group_by .= " EXTRACT(YEAR_MONTH FROM v.`date`) ";
				$between = " AND DATE(v.`date`) BETWEEN STR_TO_DATE(?, '%Y-%c-%e') AND STR_TO_DATE(?, '%Y-%c-%e') ";
				$start = $this->input->post('year_start') . '-' . $this->input->post('month_start') . '-1';
				$end = $this->input->post('year_end') . '-' . $this->input->post('month_end') . '-' . date('t', mktime(0,0,0,$this->input->post('month_end'), 1, $this->input->post('year_end')));
			break;
			default :
				$select = " DATE_FORMAT(v.`date`, '%Y%m%d') as `test`, ";
				$group_by .= " DATE(v.`date`) ";
				$between = " AND DATE(v.`date`) BETWEEN STR_TO_DATE(?, '%Y-%c-%e') AND STR_TO_DATE(?, '%Y-%c-%e') ";
				$start = $this->input->post('year_start') . '-' . $this->input->post('month_start') . '-' . $this->input->post('day_start');
				$end = $this->input->post('year_end') . '-' . $this->input->post('month_end') . '-' . $this->input->post('day_end');
			break;
		}
		
		$sql = $this->db->query("
			SELECT 
				rpt.id as payment_type_id,
				rpt.name as payment_type,
				$select
				COUNT(v.`id`) as `count`
			FROM 
				visits v
				JOIN ref_payment_types rpt ON(rpt.id = v.payment_type_id)
				
			WHERE 1=1 $where $between
			GROUP BY $group_by
		", array(
			$start, $end
		));
		$return = $sql->result_array();
		//echo $this->db->last_query();
		return $return;
	}
	
	
    function GetDataJenis() {
        $sql = $this->db->query("
            SELECT 
                `id` as `id`, 
                `name` as `name`
            FROM
                `ref_payment_types`
            WHERE 
				`active` = 'yes' "
        );
        return $sql->result_array();
    }
	
}
?>
