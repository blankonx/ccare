<?php
Class Drug_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    
    function GetAlldrug() {
        $sql = $this->db->query("
        SELECT 
			rd.id,
			rd.code,
			rd.name,
			rd.category,
			rd.unit,
			rs.name as supplier
        FROM ref_drugs rd
        JOIN ref_suppliers rs ON (rs.id = rd.supplier_id)");
        return $sql->result_array();
    }

    function GetDataById() {
        $sql = $this->db->query("
            SELECT *
			FROM 
				ref_drugs
            WHERE
                id=?    
            ",
            array($this->input->post('id'))
        );
        return $sql->row_array();
    }
    
    function GetComboSupplier() {
        $sql = $this->db->query("
            SELECT *
			FROM 
				ref_suppliers
			ORDER BY name
            "
        );
        return $sql->result_array();
	}

//DO
	function DoAddData() {
		return $this->db->query("
			INSERT INTO 
				ref_drugs (
					category,
					code,
                    name,
					unit,
					supplier_id
				)
			VALUES(
                ?,?,?,?,?
			)",
			array(
				$this->input->post('category'),
				$this->input->post('code'),
				$this->input->post('name'),
				$this->input->post('unit'),
				$this->input->post('supplier_id')
			)
		);
	}
    
	function DoUpdateData() {
        return $this->db->query("
            UPDATE
                ref_drugs 
            SET 
					category=?,
					code=?,
                    name=?,
					unit=?,
					supplier_id=?
            WHERE 
                id=?",
            array(
				$this->input->post('category'),
				$this->input->post('code'),
				$this->input->post('name'),
				$this->input->post('unit'),
				$this->input->post('supplier_id'),
                $this->input->post('id')
            )
        );
	}

	function DoDeleteData() {
        $delete_id = implode(",", $this->input->post('delete_id'));
		return $this->db->query("
			DELETE FROM
				ref_drugs 
			WHERE 
				id IN ($delete_id)"
		);
	}
    
    function DoAddDataImport($list, $numrows) {
        //$drug_in_id = $this->db->insert_id();
        $ret['ok'] = 0;
        $ret['gagal'] = 0;
        for ($i=2; $i<=$numrows; $i++) {
			$q = $this->db->query("SELECT id FROM ref_suppliers WHERE name=?", array($list[$i][6]));
			$arr_supplier_id = $q->row_array();
			$supplier_id = $arr_supplier_id['id'];
			if($supplier_id['id']=='') {
				$q = $this->db->query("INSERT INTO ref_suppliers(name) VALUES(?)", array($list[$i][6]));
				$supplier_id = $this->db->insert_id();
			}
			if(true === $this->DoAddDataImportDetail(
						$supplier_id, 
						$list[$i][4], 
						$list[$i][2], 
						$list[$i][3], 
						$list[$i][5])) {
				$ret['ok'] += 1;
			} else {
				$ret['gagal'] += 1;
				$no_gagal[] = $i;
			}
        }
        $ret['no_gagal'] = implode(", ", $no_gagal);
        return $ret;
    }
    
    function DoAddDataImportDetail($supplier_id, $category, $code, $name, $unit) {
        $x = $this->db->query("
            INSERT INTO ref_drugs(supplier_id, category, code, name, unit) 
            VALUES (?,?,?,?,?)
            ", array(
                $supplier_id, $category, $code, $name, $unit
            ));
        return $x;
        //echo $this->db->last_query();
    }
}
?>
