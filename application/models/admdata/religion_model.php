<?php
Class Religion_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//

    function GetDataById() {
        $sql = $this->db->query("
            SELECT *
			FROM 
				ref_religions
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
				ref_religions (
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
                ref_religions 
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
				ref_religions 
			WHERE 
				id IN ($delete_id)"
		);
	}
    
}
?>
