<?php
Class Pemeriksaan_Lab_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//

	function GetDataPatient($visitId) {
		//get the current selected data
		$sql = $this->db->query("
			SELECT
				CONCAT(p.`family_folder`, '-', p.`id`, '-', p.`family_relationship_id`) as `mr_number`,
				p.`name`,
				p.`parent_name`,
				p.`birth_place`,
				p.`sex` as `sex`,
				DATE_FORMAT(p.`birth_date`, '%d/%m/%y') as `birth_date`, 
				DATE_FORMAT(v.`date`, '%d/%m/%y') as `visit_date`, 
				CONCAT_WS(', ', v.`address`, rv.`name`, sd.`name`, d.`name`) as `address`,
				rd.name as doctor,
				rc.name as clinic,
				rpt.name as payment_type,
				rcon.name as `continue`
			FROM 
				`patients` p
				JOIN `visits` v ON (v.`patient_id` = p.`id` AND v.`family_relationship_id` = p.`family_relationship_id`)
				LEFT JOIN `visit_pemeriksaan_lab` vpl ON (vpl.visit_id = v.id)
				JOIN `ref_villages` rv ON (rv.`id` = v.`village_id`)
				JOIN `ref_sub_districts` sd ON (sd.`id` = rv.`sub_district_id`)
				JOIN `ref_districts` d ON (d.`id` = sd.`district_id`)
				LEFT JOIN `ref_paramedics` rd ON (rd.`id` = v.`paramedic_id`)
				JOIN `ref_clinics` rc ON (rc.`id` = v.`clinic_id`)
				JOIN `ref_payment_types` rpt ON  (rpt.id = v.payment_type_id)
				LEFT JOIN `ref_continue` rcon ON (rcon.id = v.continue_id)
			WHERE
				v.`id`=?
		",
			array($visitId)
		);
		return $sql->row_array();
	}
	
    function GetData($visitId) {
        $sql = $this->db->query("
            SELECT 
				vpl.id as visit_pemeriksaan_lab_id,
				v.served
            FROM visit_pemeriksaan_lab vpl 
				JOIN visits v ON (v.id = vpl.visit_id)
            WHERE 
				vpl.visit_id=?
        ",
        array($visitId));
        return $sql->row_array();
    }
    
	function GetList($visitId, $limit, $offset) {
        $sql = $this->db->query("
            SELECT 
                SQL_CALC_FOUND_ROWS 
                pl.id as id,
                DATE_FORMAT(v.`date`, '%d %b %y') as `date`,
                `getDateDiff`(v.`date`) as `datediff`,
                CONCAT(SUBSTRING(GROUP_CONCAT(rpl.name SEPARATOR ', '), 1, 70), '...') as jenis
            FROM
                visit_pemeriksaan_lab pl
                JOIN visits v ON (v.id = pl.visit_id)
                JOIN visit_pemeriksaan_lab_detail pld ON (pld.visit_pemeriksaan_lab_id = pl.id)
                JOIN ref_pemeriksaan_lab rpl ON (rpl.id = pld.pemeriksaan_lab_id)
            WHERE
                v.patient_id = (SELECT patient_id FROM visits WHERE id=?)
            GROUP BY pl.id
            ORDER BY pl.id DESC
            LIMIT $limit, $offset
        ",
        array(
            $visitId
        ));

        if($sql->num_rows() > 0) {
            return $sql->result_array();
        } else {
            return false;
        }
	}

    function GetCount() {
        $sql = $this->db->query("SELECT FOUND_ROWS() as total");
        if($sql->num_rows() > 0) {
            $data = $sql->row_array();
            return $data['total'];
        } else {
            return false;
        }
    }

    function GetDetail($plId) {
        $sql = $this->db->query("
            SELECT 
                pl.id as id,
                rplc.name as parent_name,
                rpl.name as name,
                rpl.satuan,
                rpl.nilai_minimum,
                rpl.nilai_maximum,
                pld.result as result
            FROM
                visit_pemeriksaan_lab pl
                JOIN visits v ON (v.id = pl.visit_id)
                JOIN visit_pemeriksaan_lab_detail pld ON (pld.visit_pemeriksaan_lab_id = pl.id)
                JOIN ref_pemeriksaan_lab rpl ON (rpl.id = pld.pemeriksaan_lab_id)
                JOIN ref_pemeriksaan_lab_categories rplc ON (rplc.id = rpl.pemeriksaan_lab_category_id)
            WHERE 
                pl.id =?
            ORDER BY rplc.ordering, rpl.ordering
        ",
        array(
            $plId
        ));
		return $sql->result_array();
    }

    function GetDetailForPrint($visitId) {
        $sql = $this->db->query("
            SELECT 
                pl.id as id,
                rplc.name as parent_name,
                rpl.name as name,
                rpl.satuan,
                rpl.nilai_minimum,
                rpl.nilai_maximum,
                pld.result as result
            FROM
                visit_pemeriksaan_lab pl
                JOIN visits v ON (v.id = pl.visit_id)
                JOIN visit_pemeriksaan_lab_detail pld ON (pld.visit_pemeriksaan_lab_id = pl.id)
                JOIN ref_pemeriksaan_lab rpl ON (rpl.id = pld.pemeriksaan_lab_id)
                JOIN ref_pemeriksaan_lab_categories rplc ON (rplc.id = rpl.pemeriksaan_lab_category_id)
            WHERE 
                pl.visit_id =?
            ORDER BY rplc.ordering, rpl.ordering
        ",
        array(
            $visitId
        ));
		return $sql->result_array();
    }
    

    function GetDataParamedic() {
        $sql = $this->db->query("
            SELECT * FROM view_ref_laborat WHERE active='yes' ORDER BY name
        "
        );
        return $sql->result_array();
    }
    
    function GetPemeriksaanLab($visitId) {
        $sql = $this->db->query("
            SELECT
                plc.id as parent_id,
                plc.name as parent_name,
                vpld.id as id,
                pl.name as name,
                pl.satuan,
                pl.nilai_minimum,
                pl.nilai_maximum,
                vpld.`result` as `result`
            FROM
                ref_pemeriksaan_lab pl
                JOIN ref_pemeriksaan_lab_categories plc ON (plc.id = pl.pemeriksaan_lab_category_id)
                JOIN visit_pemeriksaan_lab_detail vpld ON (vpld.pemeriksaan_lab_id = pl.id)
                JOIN visit_pemeriksaan_lab vpl ON(vpl.id = vpld.visit_pemeriksaan_lab_id)
            WHERE 
                vpl.visit_id=?
            ORDER BY
                plc.ordering, pl.ordering
        ", array($visitId));
        return $sql->result_array();
    }
    
    function GetPemeriksaanLabBlankForm() {
        $sql = $this->db->query("
            SELECT
				pl.id as pl_id,
                plc.id as parent_id,
                plc.name as parent_name,
                pl.satuan,
                pl.nilai_minimum,
                pl.nilai_maximum,
                pl.name as name
            FROM
                ref_pemeriksaan_lab pl
                JOIN ref_pemeriksaan_lab_categories plc ON (plc.id = pl.pemeriksaan_lab_category_id)
            ORDER BY
                plc.ordering, pl.ordering
        ");
		//echo $this->db->last_query();
        return $sql->result_array();
    }
    
    function GetListPemeriksaanLab() {
        $sql = $this->db->query("
            SELECT
				pl.id as pl_id,
                plc.id as parent_id,
                plc.name as parent_name,
                pl.satuan,
                pl.nilai_minimum,
                pl.nilai_maximum,
                pl.name as name
            FROM
                ref_pemeriksaan_lab pl
                JOIN ref_pemeriksaan_lab_categories plc ON (plc.id = pl.pemeriksaan_lab_category_id)
            WHERE 
				pl.name LIKE ?
				OR plc.name LIKE ?
            ORDER BY
                plc.ordering, pl.ordering
        ", array(
			'%' . $this->input->post('q') . '%',
			'%'. $this->input->post('q') . '%'
        ));
		//echo $this->db->last_query();
        return $sql->result_array();
	}
    
    function DoAddDataPemeriksaanLab() {
        $id = $_POST['pemeriksaan_lab_id'];
        $item_id = $_POST['pemeriksaan_lab_item_id'];
        $item = $_POST['pemeriksaan_lab_item'];
        $a = false;
        $this->db->query("INSERT INTO visit_pemeriksaan_lab(visit_id) VALUES(?)", array($this->input->post('pl_visit_id')));
        $last_id = $this->db->insert_id();
        for($i=0;$i<sizeof($item);$i++) {
			if($item[$i] != '') {
				$a = $this->db->query("
					INSERT INTO 
						visit_pemeriksaan_lab_detail (
							visit_pemeriksaan_lab_id,
							pemeriksaan_lab_id,
							result
						)
					VALUES (
						?,?,?
					)
				", 
					array(
						$last_id,
						$id[$i],
						$item[$i]
					)
				);
				//echo $this->db->last_query() . "\n";
			}
        }
		if(true === $a) {
			$this->db->query("
				UPDATE 
					visits
				SET 
					user_id=?,
					paramedic_id=?, 
					served='yes',
					continue_id=1 
				WHERE 
					id=?", 
				array(
					$this->session->userdata('id'),
					$this->input->post('paramedic_id'), 
					$this->input->post('pl_visit_id')
				)
			);
		}
        return $a;
    }

    
    function DoAddDataPemeriksaanLabNewItem() {
        $id = $_POST['pemeriksaan_lab_item_new_id'];
        //$item_id = $_POST['pemeriksaan_lab_item_id'];
        $item = $_POST['pemeriksaan_lab_item_new_value'];
        $a = false;
        //$this->db->query("INSERT INTO visit_pemeriksaan_lab(visit_id) VALUES(?)", array($this->input->post('pl_visit_id')));
        //$last_id = $this->db->insert_id();
        for($i=0;$i<sizeof($item);$i++) {
			if($item[$i] != '') {
				$a = $this->db->query("
					INSERT INTO 
						visit_pemeriksaan_lab_detail (
							visit_pemeriksaan_lab_id,
							pemeriksaan_lab_id,
							result
						)
					VALUES (
						?,?,?
					)
				", 
					array(
						$this->input->post('pl_visit_pemeriksaan_lab_id'),
						$id[$i],
						$item[$i]
					)
				);
				//echo $this->db->last_query() . "\n";
			}
        }
        return $a;
    }
    
    function DoUpdateDataPemeriksaanLab() {
        $item_id = $_POST['pemeriksaan_lab_item_id'];
        $item = $_POST['pemeriksaan_lab_item'];
        
        for($i=0;$i<sizeof($item_id);$i++) {
            $a = $this->db->query("
                UPDATE 
                    visit_pemeriksaan_lab_detail 
                SET
                    result=?
                WHERE
                    id=?
            ", 
                array(
                    $item[$i],
                    $item_id[$i]
                )
            );
        }
			$this->db->query("
				UPDATE 
					visits
				SET 
					user_id=?,
					paramedic_id=?, 
					served='yes',
					continue_id=1 
				WHERE 
					id=?", 
				array(
					$this->session->userdata('id'),
					$this->input->post('paramedic_id'), 
					$this->input->post('pl_visit_id')
				)
			);
		$this->DoAddDataPemeriksaanLabNewItem();
        //$this->db->query("UPDATE visits SET served='yes' WHERE id=?", array($this->input->post('pl_visit_id')));
        return $a;
    }

}
?>
