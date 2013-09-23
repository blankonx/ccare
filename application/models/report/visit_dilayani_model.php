<?php
Class Visit_Dilayani_Model extends Model {

	function __construct() {
		parent::Model();
	}
	
	function GetDataVisit_DilayaniForChart() {
		$unit = $this->input->post('unit');
		$where = "";
		if($this->input->post('region') == 'in') $where .= " AND rv.in_area ='yes' ";
		elseif($this->input->post('region') == 'out') $where .= " AND rv.in_area ='no' ";
		if($this->input->post('district_id') != '') $where .= " AND d.id = '".$this->input->post('district_id')."' ";
		if($this->input->post('sub_district_id') != '') $where .= " AND sd.id = '".$this->input->post('sub_district_id')."' ";
		if($this->input->post('village_id') != '') $where .= " AND rv.id = '".$this->input->post('village_id')."' ";
		
		//$where .= " AND v.`served`='yes' ";
		if($this->input->post('clinic_id') != '') {
			$where .= " AND v.`clinic_id`='".$this->input->post('clinic_id')."' ";
		}
		switch($unit) {
			case "year" :
				$select = " YEAR(v.`date`) as `test`, ";
				$group_by = " YEAR(v.`date`) ";
				$between = " AND YEAR(v.`date`) BETWEEN ? AND ? ";
				$start = $this->input->post('year_start');
				$end = $this->input->post('year_end');
			break;
			case "month" :
				$select = " EXTRACT(YEAR_MONTH FROM v.`date`) as `test`, ";
				$group_by = " EXTRACT(YEAR_MONTH FROM v.`date`) ";
				$between = " AND DATE(v.`date`) BETWEEN STR_TO_DATE(?, '%Y-%c-%e') AND STR_TO_DATE(?, '%Y-%c-%e') ";
				$start = $this->input->post('year_start') . '-' . $this->input->post('month_start') . '-1';
				$end = $this->input->post('year_end') . '-' . $this->input->post('month_end') . '-' . date('t', mktime(0,0,0,$this->input->post('month_end'), 1, $this->input->post('year_end')));
			break;
			default :
				$select = " DATE_FORMAT(v.`date`, '%Y%m%d') as `test`, ";
				$group_by = " DATE(v.`date`) ";
				$between = " AND DATE(v.`date`) BETWEEN STR_TO_DATE(?, '%Y-%c-%e') AND STR_TO_DATE(?, '%Y-%c-%e') ";
				$start = $this->input->post('year_start') . '-' . $this->input->post('month_start') . '-' . $this->input->post('day_start');
				$end = $this->input->post('year_end') . '-' . $this->input->post('month_end') . '-' . $this->input->post('day_end');
			break;
		}
		
		$sql_new = $this->db->query("
			SELECT 
				$select
				COUNT(v.`id`) as `count`
			FROM 
				visits v
				JOIN `ref_villages` rv ON (rv.`id` = v.`village_id`)
				JOIN `ref_sub_districts` sd ON (sd.`id` = rv.`sub_district_id`)
				JOIN `ref_districts` d ON (d.`id` = sd.`district_id`)
			WHERE v.served='yes' $where $between
			GROUP BY $group_by
		", array(
			$start, $end
		));
		$return['new'] = $sql_new->result_array();
		//echo "<pre>". $this->db->last_query() . "</pre>";
		
		$sql_old = $this->db->query("
			SELECT 
				$select
				COUNT(v.`id`) as `count`
			FROM 
				visits v
				JOIN `ref_villages` rv ON (rv.`id` = v.`village_id`)
				JOIN `ref_sub_districts` sd ON (sd.`id` = rv.`sub_district_id`)
				JOIN `ref_districts` d ON (d.`id` = sd.`district_id`)
			WHERE v.served='no' $where $between
			GROUP BY $group_by
		", array(
			$start, $end
		));
		$return['old'] = $sql_old->result_array();
		//echo "<pre>". $this->db->last_query() . "</pre>";
		return $return;
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
