<?php
Class Klaim_RawatJalan_Model extends Model {

	function __construct() {
		parent::Model();
	}
	
	function GetDataVisitSensus() {
		$unit = $this->input->post('unit');
		$where = "";
		
        $arr_icd_id = $this->input->post('icd_id');
        if(!empty($arr_icd_id) || !$arr_icd_id[0]) {
            foreach($arr_icd_id as $key => $val) {
                if(is_null($val == '') || $val == '' || !$val) {
                    unset($arr_icd_id[$key]);
                }
            }
            if(!empty($arr_icd_id)) {
                //print_r($arr_icd_id);
                $str_icd_id = implode(", ", $arr_icd_id);
                $where .= " AND ad.`icd_id` IN ($str_icd_id ) ";
            }
        }
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
		
		$sql = $this->db->query("
			SELECT 
				v.id as id,
				p.`family_folder` as `no_rm`,
				p.name as name,
				p.birth_date as birth_date,
                CASE 
                WHEN (p.sex ='Laki-laki') THEN 'L'
                WHEN (p.sex ='Perempuan') THEN 'P' 
                ELSE 'Null'
                END as sex,
                v.`date` as visit_date,
				DATE_FORMAT(v.`date`, '%d/%m/%Y')  as `date`,
                
				CONCAT(ad.icd_code, ' ', ad.icd_name) as diagnose,
                t.name as treatment,
                t.cost,
                v.payment_type_id,
                CONCAT(v.nama_asuransi,'<br/>',v.insurance_no) as insurance_no
			FROM 
				visits v
				JOIN patients p ON (p.family_folder = v.family_folder)
				LEFT JOIN anamnese_diagnoses ad ON (ad.visit_id = v.id)
				LEFT JOIN ref_payment_types rpt ON (rpt.id = v.payment_type_id)
				LEFT JOIN treatments t ON (t.visit_id= v.id)
			WHERE 
				(t.`log` = 'no' OR t.`log` is null) 
				AND (ad.`log` = 'no' OR t.`log` is null)
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
		
        $arr_icd_id = $report_param['icd_id'];
        if(!empty($arr_icd_id) || !$arr_icd_id[0]) {
            foreach($arr_icd_id as $key => $val) {
                if(is_null($val == '') || $val == '' || !$val) {
                    unset($arr_icd_id[$key]);
                }
            }
            if(!empty($arr_icd_id)) {
                //print_r($arr_icd_id);
                $str_icd_id = implode(", ", $arr_icd_id);
                $where .= " AND ad.`icd_id` IN ($str_icd_id ) ";
            }
        }
		
		$payment_type_id = $report_param['payment_type_id'];
		if($payment_type_id != '') {
			$where .= " AND v.`payment_type_id` = '".$payment_type_id."' ";
		}
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
				p.birth_date as birth_date,
                CASE 
                WHEN (p.sex ='Laki-laki') THEN 'L'
                WHEN (p.sex ='Perempuan') THEN 'P' 
                ELSE 'Null'
                END as sex,
                v.`date` as visit_date,
				DATE_FORMAT(v.`date`, '%d/%m/%Y')  as `date`,
               	CONCAT(ad.icd_code, ' ', ad.icd_name) as diagnose,
                t.name as treatment,
                t.cost,
                v.payment_type_id,
                CONCAT(v.nama_asuransi,'<br/>',v.insurance_no) as insurance_no
			FROM 
				visits v
				JOIN patients p ON (p.family_folder = v.family_folder)
				LEFT JOIN anamnese_diagnoses ad ON (ad.visit_id = v.id)
				LEFT JOIN ref_payment_types rpt ON (rpt.id = v.payment_type_id)
				LEFT JOIN treatments t ON (t.visit_id= v.id)
			WHERE 
				(t.`log` = 'no' OR t.`log` is null) 
				AND (ad.`log` = 'no' OR t.`log` is null)
				$where
				$between
		", array(
			$start, $end
		));
		//echo "<pre>" . $this->db->last_query() . "</pre>";
		return $sql->result_array();
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
