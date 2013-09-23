<?php
Class Icd_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//

    function GetDataById() {
        $sql = $this->db->query("
            SELECT *
			FROM 
				ref_icds
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
				ref_icds (
					code,
                    name,
					kata_kunci
				)
			VALUES(
                ?,?,?
			)",
			array(
				$this->input->post('code'),
				$this->input->post('name'),
				$this->input->post('kata_kunci')
			)
		);
	}
    
	function DoUpdateData() {
        return $this->db->query("
            UPDATE
                ref_icds 
            SET 
					kata_kunci=?
            WHERE 
                id=?",
            array(
				$this->input->post('kata_kunci'),
                $this->input->post('id')
            )
        );
	}

	function DoDeleteData() {
        $delete_id = implode(",", $this->input->post('delete_id'));
		return $this->db->query("
			DELETE FROM
				ref_icds 
			WHERE 
				id IN ($delete_id)"
		);
	}
    
}
?>
