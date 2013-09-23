<?php
Class Job_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//

    function GetDataById() {
        $sql = $this->db->query("
            SELECT *
			FROM 
				ref_jobs
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
				ref_jobs (
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
                ref_jobs 
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
				ref_jobs 
			WHERE 
				id IN ($delete_id)"
		);
	}
    
}
?>
