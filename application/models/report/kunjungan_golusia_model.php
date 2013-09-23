<?php
Class Kunjungan_Golusia_Model extends Model {

	function __construct() {
		parent::Model();
	}
	function GetDataKunjungan_GolusiaForChart() {
		$jenispasien = $this->input->post('payment_type_id');
		$unit = $this->input->post('unit');
		$where = "";
		
		if($this->input->post('payment_type_id') != '') {
            $join .= " JOIN ref_payment_types rpt ON (rpt.id = v.payment_type_id) ";
            $where .= " AND v.payment_type_id = '".$this->input->post('payment_type_id')."' ";
        } else {
			$join .= " JOIN ref_payment_types rpt ON (rpt.id = v.payment_type_id) ";	
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
				v.payment_type_id as id,
				date_format(v.date,'%d/%m/%Y') as tanggal_kunjungan,
				rpt.name as jenis_pasien,
				CAST(getKelompokUmurX(p.birth_date, DATE(v.`date`)) AS SIGNED) as `age`,				
				COUNT(DISTINCT(v.family_folder)) as `count`,
				p.sex
			FROM 
				visits v
				JOIN patients p ON (p.family_folder = v.family_folder)
				
                $join
			WHERE 
				1=1
				$where 
				$between
			GROUP BY DATE(v.date),v.payment_type_id,getKelompokUmurX(p.birth_date, DATE(v.`date`)), p.sex
			ORDER BY tanggal_kunjungan, v.payment_type_id, `age`, p.sex
		", array(
			$start, $end
		));
		$return = $sql->result_array();
	    //echo "<pre>" . $this->db->last_query() . "</pre>";
	    //echo "<pre>";
	    //print_r($return);
	    //echo "</pre>";
		return $return;
	}

	function GetDataKunjungan_GolusiaForPrint() {
		$arr_post = $this->session->userdata('arr_post');
		$jenispasien = $arr_post['jenispasien'];
		$unit = $arr_post['unit'];
		$where = "";
		
		if($jenispasien != '') {
            $join .= " JOIN ref_payment_types rpt ON (rpt.id = v.payment_type_id) ";
            $where .= " AND v.payment_type_id = '".$jenispasien."' ";
        } else {
			$join .= " JOIN ref_payment_types rpt ON (rpt.id = v.payment_type_id) ";	
		}
		
		switch($arr_post['unit']) {
			case "year" :
				$between = " AND YEAR(v.`date`) BETWEEN ? AND ? ";
				$start = $arr_post['year_start'];
				$end = $arr_post['year_end'];
			break;
			case "month" :
				$between = " AND DATE(v.`date`) BETWEEN STR_TO_DATE(?, '%Y-%c-%e') AND STR_TO_DATE(?, '%Y-%c-%e') ";
				$start = $arr_post['year_start'] . '-' . $arr_post['month_start'] . '-1';
				$end = $arr_post['year_end'] . '-' . $arr_post['month_end'] . '-' . date('t', mktime(0,0,0,$arr_post['month_end'], 1, $arr_post['year_end']));
			break;
			default :
				$between = " AND DATE(v.`date`) BETWEEN STR_TO_DATE(?, '%Y-%c-%e') AND STR_TO_DATE(?, '%Y-%c-%e') ";
				$start = $arr_post['year_start'] . '-' . $arr_post['month_start'] . '-' . $arr_post['day_start'];
				$end = $arr_post['year_end'] . '-' . $arr_post['month_end'] . '-' . $arr_post['day_end'];
			break;
		}
		$sql = $this->db->query("
			SELECT 
				v.payment_type_id as id,
				date_format(v.date,'%d/%m/%Y') as tanggal_kunjungan,
				rpt.name as jenis_pasien,
				CAST(getKelompokUmurX(p.birth_date, DATE(v.`date`)) AS SIGNED) as `age`,
				COUNT(DISTINCT(v.family_folder)) as `count`,
				p.sex
			FROM 
				visits v
				JOIN patients p ON (p.family_folder = v.family_folder)
				
                $join
			WHERE 
				1=1
				$where 
				$between
			GROUP BY DATE(v.date),v.payment_type_id,getKelompokUmurX(p.birth_date, DATE(v.`date`)), p.sex
			ORDER BY tanggal_kunjungan, v.payment_type_id, `age`, p.sex
		", array(
			$start, $end
		));
		$return = $sql->result_array();
	  // echo "<pre>" . $this->db->last_query() . "</pre>";
	  //  echo "<pre>";
	  //  print_r($return);
	  //  echo "</pre>";
		return $return;
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

	
	function GetDataPaymentTypeName($id='') {
		$sql = $this->db->query("SELECT name FROM ref_payment_types WHERE id=?", array($id));
		$data = $sql->row_array();
		 return $data['jenis_pasien'];
	}
	
   
}
?>
