<?php
Class Sepuluh_Besar_Model extends Model {

	function __construct() {
		parent::Model();
	}
	
	function GetDataSepuluh_BesarForChart() {
		$unit = $this->input->post('unit');
		$where = "";
		
		if($this->input->post('icd_group_id') != '') {
	   	    $join .= " JOIN ref_icd_group_detail igd ON (igd.icd_id = ad.icd_id) ";
            $where .= " AND igd.icd_group_id = '".$this->input->post('icd_group_id')."' ";
        }
		
		$payment_type_id = $this->input->post('payment_type_id');
		$kelompok_umur = $this->input->post('kelompok_umur');
		$sex = $this->input->post('sex');
		
		//$where .= " AND v.`served`='yes' ";
		
		if($payment_type_id != '') {
			$where .= " AND v.`payment_type_id` = '".$payment_type_id."' ";
		}
		if($kelompok_umur != '') {
			$join .= " JOIN patients p ON (p.family_folder = v.family_folder) ";
            $where .= " AND getKelompokUmur(p.`birth_date`, v.`date`)= '".$kelompok_umur."' ";
		}
		if($sex != '') {
			$join .= " JOIN patients px ON (px.family_folder = v.family_folder) ";
            $where .= " AND px.sex= '".$sex."' ";
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
			   	ad.icd_code as code,
			   	ad.icd_name as name,
			   	COUNT(ad.icd_id) as `count`
			FROM 
				anamnese_diagnoses ad
				JOIN visits v ON (v.id = ad.visit_id)
				
				$join
			WHERE ad.log='no' $where $between
			GROUP BY ad.icd_id
			ORDER BY `count` DESC, name
			$tampilkan
		", array(
			$start, $end
		));
		//echo $this->db->last_query();
		return $sql->result_array();
	}
	
	
	function GetDataPaymentTypeName($id) {
		$sql = $this->db->query("SELECT name FROM ref_payment_types WHERE id=?", array($id));
		$data = $sql->row_array();
		return $data['name'];
	}
    
    function GetComboKelompokPenyakit() {
        $sql = $this->db->query("SELECT id, name FROM ref_icd_group ORDER BY name");
        return $sql->result_array();
    }
    
    function GetNamaKelompokPenyakit($id='') {
        $sql = $this->db->query("SELECT name FROM ref_icd_group WHERE id=?", array($id));
        $data = $sql->row_array();
        return empty($data)?'':$data['name'];
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
