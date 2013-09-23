<?php
Class Pemeriksaan_Lab_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function GetComboCategory() {
        $sql = $this->db->query("
            SELECT 
				id, name 
			FROM 
				ref_pemeriksaan_lab_categories 
			ORDER BY 
				name"
        );
        return $sql->result_array();
    }
    
    function GetDataById() {
        $sql = $this->db->query("
            SELECT 
				*
			FROM 
				ref_pemeriksaan_lab
            WHERE id=?", array(
                $this->input->post('id')
            )
        );
        return $sql->row_array();
    }
	
	function DoDeleteData() {
        $delete_id = implode(",", $this->input->post('delete_id'));
		return $this->db->query("
			DELETE FROM
				ref_pemeriksaan_lab 
			WHERE 
				id IN ($delete_id)"
		);
	}
	
	function DoAddData() {
		return $this->db->query("
			INSERT INTO 
				ref_pemeriksaan_lab (
					pemeriksaan_lab_category_id, 
					name, 
                    satuan,
                    nilai_minimum,
                    nilai_maximum,
					price)
			VALUES(
				?,
				?,?,?,?,
				?)",
			array(
				$this->input->post('pemeriksaan_lab_category_id'), 
				$this->input->post('name'), 
				$this->input->post('satuan'), 
				$this->input->post('nilai_minimum'), 
				$this->input->post('nilai_maximum'), 
				$this->input->post('price')
			)
		);
	}
	
	function DoUpdateData() {
		return $this->db->query("
			UPDATE
				ref_pemeriksaan_lab 
			SET 
				pemeriksaan_lab_category_id=?, 
				name=?, 
				satuan=?, 
				nilai_minimum=?, 
				nilai_maximum=?, 
				price=?
			WHERE 
				id=?",
			array(
				$this->input->post('pemeriksaan_lab_category_id'), 
				$this->input->post('name'), 
				$this->input->post('satuan'), 
				$this->input->post('nilai_minimum'), 
				$this->input->post('nilai_maximum'), 
				$this->input->post('price'), 
				$this->input->post('id')
			)
		);
	}
}
?>
