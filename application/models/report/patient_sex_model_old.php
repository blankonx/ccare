<?php
Class Patient_Sex_Model extends Model {

	function __construct() {
		parent::Model();
	}
	
	function GetDataPatient_SexForChart() {
		$unit = $this->input->post('unit');
		$region = $this->input->post('region');
		$where = "";
		if($this->input->post('region') == 'in') $where .= " AND rv.in_area ='yes' ";
		elseif($this->input->post('region') == 'out') $where .= " AND rv.in_area ='no' ";
		if($this->input->post('district_id') != '') $where .= " AND d.id = '".$this->input->post('district_id')."' ";
		if($this->input->post('sub_district_id') != '') $where .= " AND sd.id = '".$this->input->post('sub_district_id')."' ";
		if($this->input->post('village_id') != '') $where .= " AND rv.id = '".$this->input->post('village_id')."' ";
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
				COUNT(p.`id`) as `count`
			FROM 
				patients p
				JOIN `ref_villages` rv ON (rv.`id` = p.`village_id`)
				JOIN `ref_sub_districts` sd ON (sd.`id` = rv.`sub_district_id`)
				JOIN `ref_districts` d ON (d.`id` = sd.`district_id`)
				$join
			WHERE 1=1 $where $between
			GROUP BY p.`sex`
		", array(
			$start, $end
		));
		//echo $this->db->last_query();
		return $sql->result_array();
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
