<?php
Class Lap_Jamkesmas_Model extends Model {

	function __construct() {
		parent::Model();
	}
	
	function GetReportDinas() {
		$sql = $this->db->query("
			SELECT * FROM report_dinas ORDER BY id DESC
		");
		$return = $sql->result_array();
		return $return;
	}
	
	//DO
	function DoAddReportDinas($periode, $filename) {
		return $this->db->query("
			INSERT INTO report_dinas (periode, filename, filesize) VALUES
			('".$periode."', '".$filename."', '".filesize($filename)."')
		");
	}
		
	function BackupVisits($periode, $profile) {
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
		$kelompok_umur = $this->input->post('kelompok_umur');
		$sex = $this->input->post('sex');
		
		if($payment_type_id != '') {
			$where .= " AND v.`payment_type_id` = '".$payment_type_id."' ";
		}
		if($kelompok_umur != '') {
			$join .= " JOIN patients ps ON (ps.family_folder = v.family_folder) ";
            $where .= " AND getKelompokUmur(ps.`birth_date`, v.`date`)= '".$kelompok_umur."' ";
		}
		if($sex != '') {
			$join .= " JOIN patients px ON (px.family_folder = v.family_folder) ";
            $where .= " AND px.sex= '".$sex."' ";
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
		$tampilkan = "";
		if($this->input->post('tampilkan') != 'ALL') {
			$tampilkan = "ORDER BY v.`date`, p.name ASC LIMIT 0, " . $this->input->post('tampilkan');
		}
		$sql = $this->db->query("SELECT  p.nik, p.name,  p.birth_date,(CASE WHEN (`p`.`sex` = 'Laki-laki') THEN '1' ELSE '2' END) AS `sex`, v.date as visit_date, v.payment_type_id as kode_jaminan,ad.icd_code, ad.diagnose as diagnose,tr.treatment as treatment, tr.total, v.address, v.insurance_no,(SELECT `no_str` AS `code` FROM `ref_profiles`) AS `kode_klinik`
			FROM patients p
			LEFT JOIN visits v ON (v.family_folder = p.family_folder)
			LEFT JOIN (SELECT visit_id,icd_id,icd_code, GROUP_CONCAT(CONCAT(icd_code, ' ', icd_name) SEPARATOR '|') as diagnose
								FROM
								anamnese_diagnoses
								WHERE `log`='no' OR `log` is null
								GROUP BY visit_id
								) ad ON (ad.visit_id = v.id)
			LEFT JOIN (SELECT visit_id, sum(cost) as total, GROUP_CONCAT(name SEPARATOR '|') as treatment
								FROM
								treatments
								WHERE `log`='no' OR `log` is null
								GROUP BY visit_id
								) tr ON (tr.visit_id = v.id)
			$join
			WHERE 1=1
				$where
				$between
		", array(
			$start, $end
		));
		return $sql->result_array();
		//echo $this->db->last_query();
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
