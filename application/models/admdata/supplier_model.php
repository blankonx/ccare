<?php
Class Supplier_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//

    function GetDataById() {
        $sql = $this->db->query("
            SELECT *
			FROM 
				ref_suppliers
            WHERE
                id=?    
            ",
            array($this->input->post('id'))
        );
        return $sql->row_array();
    }

//DO
	function DoAddData() {
		return $this->db->query("
			INSERT INTO 
				ref_suppliers (
                    name
				)
			VALUES(
                ?
			)",
			array(
				$this->input->post('name')
			)
		);
	}
    
	function DoUpdateData() {
        return $this->db->query("
            UPDATE
                ref_suppliers 
            SET 
                name=?
            WHERE 
                id=?",
            array(
                $this->input->post('name'),
                $this->input->post('id')
            )
        );
	}

	function DoDeleteData() {
        $delete_id = implode(",", $this->input->post('delete_id'));
		return $this->db->query("
			DELETE FROM
				ref_suppliers 
			WHERE 
				id IN ($delete_id)"
		);
	}
    
}
?>
