<?php
Class Kunjungan_Pasien_Model extends Model {

	function __construct() {
		parent::Model();
	}
	
	function GetDataVisitSensus() {
		$unit = $this->input->post('unit');
		$where = "";
		if($this->input->post('region') == 'in') $where .= " AND rv.in_area ='yes' ";
		elseif($this->input->post('region') == 'out') $where .= " AND rv.in_area ='no' ";
		if($this->input->post('district_id') != '') $where .= " AND d.id = '".$this->input->post('district_id')."' ";
		if($this->input->post('sub_district_id') != '') $where .= " AND sd.id = '".$this->input->post('sub_district_id')."' ";
		if($this->input->post('village_id') != '') $where .= " AND rv.id = '".$this->input->post('village_id')."' ";
		$payment_type_id = $this->input->post('payment_type_id');
		$kelompok_umur = $this->input->post('kelompok_umur');
		$sex = $this->input->post('sex');
		if($payment_type_id != '') {
			$where .= " AND v.`payment_type_id` = '".$payment_type_id."' ";
		}
		if($kelompok_umur != '') {
			$join .= " JOIN patients ps ON (ps.id = v.patient_id) ";
            $where .= " AND getKelompokUmur(ps.`birth_date`, v.`date`)= '".$kelompok_umur."' ";
		}
		if($sex != '') {
			$join .= " JOIN patients px ON (px.id = v.patient_id) ";
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
			$tampilkan = "LIMIT 0, " . $this->input->post('tampilkan');
		}
		
		$sql = $this->db->query("
			SELECT 
				v.id as id,
				CONCAT(p.`family_folder`, '-', p.`family_relationship_id`) as `no_rm`,
				CASE 
				WHEN (p.nik='') THEN p.`family_folder`
				ELSE p.nik END as nik,
				p.name as name,
				p.parent_name as kk,
				DATE_FORMAT(p.birth_date, '%d/%m/%Y') as birth_date,
				CASE 
				WHEN (p.sex ='Laki-laki') THEN 'L'
				WHEN (p.sex ='Perempuan') THEN 'P' 
				ELSE 'Null'
				END as sex,
				v.`date` as visit_date,
				DATE_FORMAT(v.`date`, '%d/%m/%Y')  as `date`,
				p.address as alamat,
				rv.name as village,
				CASE 
				WHEN (v.visit_type ='baru') THEN 'B1'
				WHEN (v.visit_type ='baru-kalender') THEN 'B2'
				ELSE 'Lama' 
				END as jenis_kunjungan,
				concat(rpt.name,'<br/>',v.insurance_no) as jenis_pasien
			FROM 
				visits v
				JOIN patients p ON (p.id = v.patient_id)
                		LEFT JOIN ref_payment_types rpt ON (rpt.id = v.payment_type_id)
				JOIN `ref_villages` rv ON (rv.`id` = v.`village_id`)
				JOIN `ref_sub_districts` sd ON (sd.`id` = rv.`sub_district_id`)
				JOIN `ref_districts` d ON (d.`id` = sd.`district_id`)
				$join
			WHERE 
				1=1
				$where
				$between
            		GROUP BY p.id, DATE(v.`date`)
		", array(
			$start, $end
		));
		//echo "<pre>" . $this->db->last_query() . "</pre>"; 
		
		/*CASE WHEN (p.registration_date <> DATE(v.`date`)) THEN 'L' 
				WHEN (p.registration_date = DATE(v.`date`)) THEN 'B1' 
				ELSE 'B2' END as jenis_kunjungan,*/
		return $sql->result_array();
	}
	
	
	function GetDataVisitSensusPrint($report_param) {
		$unit = $report_param['unit'];
		$where = "";
		if($report_param['region'] == 'in') $where .= " AND rv.in_area ='yes' ";
		elseif($report_param['region'] == 'out') $where .= " AND rv.in_area ='no' ";
		if($report_param['district_id'] != '') $where .= " AND d.id = '".$report_param['district_id']."' ";
		if($report_param['sub_district_id'] != '') $where .= " AND sd.id = '".$report_param['sub_district_id']."' ";
		if($report_param['village_id'] != '') $where .= " AND rv.id = '".$report_param['village_id']."' ";
		$payment_type_id = $report_param['payment_type_id'];
		$kelompok_umur = $report_param['kelompok_umur'];
		$sex = $report_param['sex'];
		if($payment_type_id != '') {
			$where .= " AND v.`payment_type_id` = '".$payment_type_id."' ";
		}
		if($kelompok_umur != '') {
			$join .= " JOIN patients ps ON (ps.id = v.patient_id) ";
            $where .= " AND getKelompokUmur(ps.`birth_date`, v.`date`)= '".$kelompok_umur."' ";
		}
		if($sex != '') {
			$join .= " JOIN patients px ON (px.id = v.patient_id) ";
            $where .= " AND px.sex= '".$sex."' ";
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
		
		$tampilkan = "";
		if($report_param['tampilkan'] != 'ALL') {
			$tampilkan = "LIMIT 0, " . $report_param['tampilkan'];
		}
		
		$sql = $this->db->query("
			SELECT 
				v.id as id,
				CONCAT(p.`family_folder`, '-', p.`family_relationship_id`) as `no_rm`,
				CASE 
				WHEN (p.nik='') THEN p.`family_folder`
				ELSE p.nik END as nik,
				p.name as name,
				p.parent_name as kk,
				DATE_FORMAT(p.birth_date, '%d/%m/%Y') as birth_date,
				CASE 
				WHEN (p.sex ='Laki-laki') THEN 'L'
				WHEN (p.sex ='Perempuan') THEN 'P' 
				ELSE 'Null'
				END as sex,
				v.`date` as visit_date,
				DATE_FORMAT(v.`date`, '%d/%m/%Y')  as `date`,
				p.address as alamat,
				rv.name as village,
				CASE 
				WHEN (v.visit_type ='baru') THEN 'B1'
				WHEN (v.visit_type ='baru-kalender') THEN 'B2'
				ELSE 'Lama' 
				END as jenis_kunjungan,
				concat(rpt.name,'<br/>',v.insurance_no) as jenis_pasien
			FROM 
				visits v
				JOIN patients p ON (p.id = v.patient_id)
                		LEFT JOIN ref_payment_types rpt ON (rpt.id = v.payment_type_id)
				JOIN `ref_villages` rv ON (rv.`id` = v.`village_id`)
				JOIN `ref_sub_districts` sd ON (sd.`id` = rv.`sub_district_id`)
				JOIN `ref_districts` d ON (d.`id` = sd.`district_id`)
				$join
			WHERE 
				1=1
				$where
				$between
            		GROUP BY p.id, DATE(v.`date`)
		", array(
			$start, $end
		));
		//echo "<pre>" . $this->db->last_query() . "</pre>";
		return $sql->result_array();
	}

	function GetDataClinicName($id) {
		$sql = $this->db->query("SELECT name FROM ref_clinics WHERE id=?", array($id));
		$data = $sql->row_array();
		return $data['name'];
	}

    function GetComboClinics() {
        $sql = $this->db->query("
            SELECT 
                child.`id` as `id`, 
                IFNULL(`parent`.`id`, `child`.id) as `order_id`, 
                child.`name` as `name`,
                parent.name as parent_name,
                `parent`.`id` as `parent_id`
            FROM
                `ref_clinics` `child`
				LEFT JOIN (
					SELECT 
						id, name
					FROM ref_clinics
					WHERE parent_id IS NULL AND active='yes' AND visible='yes'
				) `parent` ON (`parent`.id = `child`.parent_id)
            WHERE 
                `active` = 'yes' 
                AND `visible` = 'yes' 
                AND `child`.id NOT IN (5,160,161,162,163,164,165,166,167,168,169)
            ORDER BY
				order_id,parent_id,name
            "
        );
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
    
    function GetDistrictByVillageId($villageId) {
        $sql = $this->db->query("
            SELECT id, name 
			FROM ref_districts 
			WHERE id=(
				SELECT rsd.district_id 
				FROM ref_sub_districts rsd 
					JOIN ref_villages rv ON (rv.sub_district_id = rsd.id)
				WHERE rv.id='$villageId') ORDER BY name
			"
        );
        return $sql->row_array();
    }
    function GetSubDistrictByVillageId($villageId) {
        $sql = $this->db->query("
            SELECT id, name 
			FROM ref_sub_districts 
			WHERE id=(
				SELECT rsd.id 
				FROM ref_sub_districts rsd 
					JOIN ref_villages rv ON (rv.sub_district_id = rsd.id)
				WHERE rv.id='$villageId') ORDER BY name
			"
        );
        return $sql->row_array();
    }
    function GetComboSubDistrictByVillageId($villageId) {
        $sql = $this->db->query("
            SELECT id, name 
			FROM ref_sub_districts 
			WHERE district_id=(
				SELECT rsd.district_id 
				FROM ref_sub_districts rsd JOIN ref_villages rv ON (rv.sub_district_id = rsd.id)
				WHERE rv.id='$villageId') ORDER BY name
			"
        );
        return $sql->result_array();
    }
    function GetComboVillageById($villageId) {
        $sql = $this->db->query("
            SELECT id, name FROM ref_villages WHERE sub_district_id=(SELECT sub_district_id FROM ref_villages WHERE id='$villageId') ORDER BY name
			"
        );
        return $sql->result_array();
    }
    function GetComboDistrict() {
        $sql = $this->db->query("
            SELECT id, name FROM ref_districts ORDER BY name"
        );
        return $sql->result_array();
    }
    
    function GetComboSubDistrict($district_id) {
        $sql = $this->db->query("
            SELECT id, name FROM ref_sub_districts WHERE district_id='$district_id' ORDER BY name"
        );
        return $sql->result_array();
    }

    function GetComboVillage($sub_district_id) {
        $sql = $this->db->query("
            SELECT id, name FROM ref_villages WHERE sub_district_id='$sub_district_id' ORDER BY name"
        );
        return $sql->result_array();
    }
    
    function GetRegionName($village_id='', $sub_district_id='', $district_id='') {
		if($village_id != '') {
			$q = "
				SELECT 
					CONCAT_WS(', ', v.`name`, sd.`name`, d.`name`) as `address`
				FROM `ref_villages` v
					JOIN `ref_sub_districts` sd ON (sd.`id` = v.`sub_district_id`)
					JOIN `ref_districts` d ON (d.`id` = sd.`district_id`)
				WHERE 
					v.id='".$village_id."'";
		} elseif($sub_district_id != '') {
			$q = "
				SELECT 
					CONCAT_WS(', ', sd.`name`, d.`name`) as `address`
				FROM `ref_sub_districts` sd
					JOIN `ref_districts` d ON (d.`id` = sd.`district_id`)
				WHERE 
					sd.id='".$sub_district_id."'";
		} else {
			$q = "
				SELECT 
					d.name as `address`
				FROM `ref_districts` d
				WHERE 
					d.id='".$district_id."'";
		}
		$sql = $this->db->query($q);
		$data = $sql->row_array();
		return $data['address'];
	}
}
?>
