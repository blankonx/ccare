<?php
Class Drug_In_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//

    function GetListDrug($q) {
        $sql = $this->db->query("
            SELECT `id`, `unit`, CONCAT(`code`, '-', `name`) as `name`, `stock` 
            FROM `ref_drugs`
            WHERE `code` LIKE ?
                   OR `name` LIKE ?
            LIMIT 10
        ",
            array(
                "%" . $q . "%",
                "%" . $q . "%"
            )
        );
        return $sql->result_array();
    }

//DO
	function DoAddData() {
		$this->db->query("
			INSERT INTO drugs_in (explanation, `date`, user_id)
			VALUES (?, STR_TO_DATE(?, '%d/%m/%Y'), ?)
		", array(
			$this->input->post('explanation'),
			$this->input->post('date'),
			$this->session->userdata('id')
		));
		
		$last_id = $this->db->insert_id();
		$drug_id = $this->input->post('drug_id');
		$qty = $this->input->post('qty');
		
		/*SELECT UNTUK NAMBAH STOK DULU*/
		$str_drug_id = implode(",", $drug_id);
		$qstock = $this->db->query("SELECT id, stock FROM ref_drugs WHERE id IN ($str_drug_id)");
		$qstock_data = $qstock->result_array();
		for($i=0;$i<sizeof($qstock_data);$i++) {
			$stock_data[$qstock_data[$i]['id']] = $qstock_data[$i]['stock'];
		}
		//print_r($stock_data);
		/*
		 * @JEMBER
		 * EXPIRED DATE BELUM TAK MASUKKAN
		 * */
		for($i=0;$i<sizeof($drug_id);$i++) {
			$arr_q[] = "('".$last_id."', '".$drug_id[$i]."', '".$qty[$i]."', '".($stock_data[$drug_id[$i]])."', '".($stock_data[$drug_id[$i]]+$qty[$i])."')";
			$last_stock[$i] = $stock_data[$drug_id[$i]]+$qty[$i];
		}
		//print_r($arr_q);
		$str_q = implode(",", $arr_q);
		$x = $this->db->query("
			INSERT INTO drugs_in_detail (drug_in_id, drug_id, qty, stock_before_insert, stock_after_insert)
			VALUES $str_q
		");
		//UPDATE STOCK
		for($i=0;$i<sizeof($drug_id);$i++) {
			$this->db->query("UPDATE ref_drugs SET stock=? WHERE id=?", array($last_stock[$i], $drug_id[$i]));
		}
		return $x;
	}
    
	function DoDeleteData() {
		if($this->input->post('delete_id')) {
			$delete_id = implode(",", $this->input->post('delete_id'));
			
			$qstock = $this->db->query("
				SELECT rd.id, rd.stock, did.qty FROM ref_drugs rd JOIN drugs_in_detail did ON (did.drug_id = rd.id) 
				WHERE did.drug_in_id IN ($delete_id) GROUP BY did.id");
			$qstock_data = $qstock->result_array();
			
			$b = $this->db->query("
				DELETE FROM
					drugs_in_detail 
				WHERE 
					drug_in_id IN ($delete_id)"
			);
			if(true === $b) {
				$a = $this->db->query("
					DELETE FROM
						drugs_in 
					WHERE 
						id IN ($delete_id)"
				);
				if(true === $a) {
					for($i=0;$i<sizeof($qstock_data);$i++) {
						$c = $this->db->query("UPDATE ref_drugs SET stock=stock-? WHERE id=?", array($qstock_data[$i]['qty'], $qstock_data[$i]['id']));
					}
					if(!$this->input->post('delete_detail_id')) return $c;
				}
				if(!$this->input->post('delete_detail_id')) return $a;
			}
			if(!$this->input->post('delete_detail_id')) return $b;
		}
		
		if($this->input->post('delete_detail_id')) {
			$delete_detail_id = implode(",", $this->input->post('delete_detail_id'));
			$qstock = $this->db->query("
				SELECT rd.id as id, rd.stock as stock, did.qty as qty 
				FROM ref_drugs rd 
					JOIN drugs_in_detail did ON (did.drug_id = rd.id) 
				WHERE did.id IN ($delete_detail_id) GROUP BY did.id");
			//echo $this->db->last_query();
			$qstock_data = $qstock->result_array();
			
			$b = $this->db->query("
				DELETE FROM
					drugs_in_detail 
				WHERE 
					id IN ($delete_detail_id)"
			);
			
			//echo $this->db->last_query();
			if(true === $b) {
				for($i=0;$i<sizeof($qstock_data);$i++) {
					$c = $this->db->query("UPDATE ref_drugs SET stock=stock-? WHERE id=?", array($qstock_data[$i]['qty'], $qstock_data[$i]['id']));
					
					//echo $this->db->last_query();
				}
				return $c;
			}
			return $b;
		}
	}
    
}
?>
