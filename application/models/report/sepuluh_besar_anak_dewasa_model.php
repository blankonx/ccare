<?php
Class Sepuluh_Besar_Anak_Dewasa_Model extends Model {

	function __construct() {
		parent::Model();
	}
	
	function GetDataSepuluh_Besar_Anak_DewasaForChart() {
		$unit = $this->input->post('unit');
		$where = "";
		
		$payment_type_id = $this->input->post('payment_type_id');
		
		//$where .= " AND v.`served`='yes' ";
		
		if($payment_type_id != '') {
			$where .= " AND v.`payment_type_id` = '".$payment_type_id."' ";
		}
		
		switch($unit) {
			case "all" :
				$between = " AND 1=1 ";
				$start = "";
				$end = "";
			break;
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
		$tampilkan = "";
		if($this->input->post('tampilkan') != 'ALL') {
			$tampilkan = "LIMIT 0, " . $this->input->post('tampilkan');
		}
		
		$sql = $this->db->query("
                SELECT 
                    IFNULL(anak.id, dewasa.id) as id,
                    IFNULL(anak.code, dewasa.code) as code,
                    IFNULL(anak.name, dewasa.name) as name,
                    IFNULL(dewasa.`count`,0) as dewasa,
                    IFNULL(anak.`count`,0) as anak,
                    IFNULL(anak.`count`,0)+IFNULL(dewasa.`count`,0) as jml
                 FROM 
                    (
                    SELECT 
                        ad.icd_id as id,
                        ad.icd_code as code,
                        ad.icd_name as name,
                        COUNT(ad.icd_id) as `count`
                    FROM 
                        anamnese_diagnoses ad
                        JOIN visits v ON (v.id = ad.visit_id)
                        
                    WHERE ad.log='no' AND getAgeAsYear(v.id)<=12 $where $between
                    GROUP BY ad.icd_id
                    ORDER BY `count` DESC, icd_name
                    ) anak
                    LEFT JOIN (
                    SELECT 
                        ad.icd_id as id,
                        ad.icd_code as code,
                        ad.icd_name as name,
                        COUNT(ad.icd_id) as `count`
                    FROM 
                        anamnese_diagnoses ad
                        JOIN ref_icds ri ON (ri.id = ad.icd_id)
                        JOIN visits v ON (v.id = ad.visit_id)
                        
                    WHERE ad.log='no' AND getAgeAsYear(v.id)>12 $where $between
                    GROUP BY icd_id
                    ORDER BY `count` DESC, icd_name
                    ) dewasa ON (dewasa.id = anak.id)
                ORDER BY jml DESC, code
			$tampilkan
		", array(
			$start, $end,
			$start, $end
		));
		//echo "<pre>" . $this->db->last_query() . "</pre>";
		return $sql->result_array();
	}
	
	
	function GetDataPaymentTypeName($id) {
		$sql = $this->db->query("SELECT name FROM ref_payment_types WHERE id=?", array($id));
		$data = $sql->row_array();
		return $data['name'];
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
    
}
?>
