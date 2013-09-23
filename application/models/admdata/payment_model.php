<?php
Class Payment_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//

    function GetDataById() {
        $sql = $this->db->query("
            SELECT *
			FROM 
				ref_payment_types
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
				ref_payment_types (
					id,
                    name
				)
			VALUES(
                ?,?
			)",
			array(
				$this->input->post('id'),
				$this->input->post('name')
			)
		);
	}
    
	function DoUpdateData() {
        return $this->db->query("
            UPDATE
                ref_payment_types 
            SET 
				id=?,
                name=?
            WHERE 
                id=?",
            array(
                $this->input->post('id'),
                $this->input->post('name'),
                $this->input->post('saved_id')
            )
        );
	}

	function DoDeleteData() {
        $delete_id = implode(",", $this->input->post('delete_id'));
		return $this->db->query("
			DELETE FROM
				ref_payment_types 
			WHERE 
				id IN ($delete_id)"
		);
	}
    
}
?>
