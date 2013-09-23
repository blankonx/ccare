<?php
Class Kunjungan_Pasien_Unik_Model extends Model {

	function __construct() {
		parent::Model();
	}
	
	function GetDataVisitSensus() {
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
		
		$sql = $this->db->query("
			SELECT 
				v.id as id,
				p.`family_folder` as `no_rm`,
				CASE 
				WHEN (p.nik='') THEN p.`family_folder`
				ELSE p.nik END as nik,
				p.name as name,
				DATE_FORMAT(p.birth_date, '%d/%m/%Y') as birth_date,
                CASE 
                WHEN (p.sex ='Laki-laki') THEN 'L'
                WHEN (p.sex ='Perempuan') THEN 'P' 
                ELSE 'Null'
                END as sex,
                v.`date` as visit_date,
				DATE_FORMAT(v.`date`, '%d/%m/%Y')  as `date`,
				p.address as alamat,
                concat(v.nama_asuransi,'<br/>',v.insurance_no) as jenis_pasien
			FROM 
				visits v
				JOIN patients p ON (p.family_folder = v.family_folder)
			WHERE 
				1=1
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
		
		$payment_type_id = $this->input->post('payment_type_id');
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
				CASE 
				WHEN (p.nik='') THEN p.`family_folder`
				ELSE p.nik END as nik,
				p.name as name,
				DATE_FORMAT(p.birth_date, '%d/%m/%Y') as birth_date,
                CASE 
                WHEN (p.sex ='Laki-laki') THEN 'L'
                WHEN (p.sex ='Perempuan') THEN 'P' 
                ELSE 'Null'
                END as sex,
                v.`date` as visit_date,
				DATE_FORMAT(v.`date`, '%d/%m/%Y')  as `date`,
				p.address as alamat,
                concat(v.nama_asuransi,'<br/>',v.insurance_no) as jenis_pasien
			FROM 
				visits v
				JOIN patients p ON (p.family_folder = v.family_folder)
			WHERE 
				1=1
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
