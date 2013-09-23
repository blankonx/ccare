<?php
Class User_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function GetGroup() {
        $sql = $this->db->query("
            SELECT 
				id, name
			FROM 
				ref_groups"
        );
        return $sql->result_array();
    }

    function GetDataById() {
        $sql = $this->db->query("
            SELECT *
			FROM 
				users
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
				users (
                    group_id,
                    name,
                    email,
                    username,
                    pwd
				)
			VALUES(
                ?,
                NULLIF(?, ''),
                ?,
                ?,
                MD5(?)
			)",
			array(
				$this->input->post('group_id'), 
				$this->input->post('name'),
				$this->input->post('email'), 
				$this->input->post('username'), 
				$this->input->post('pwd')
			)
		);
	}
    
	function DoUpdateData() {
        $pwd = $this->input->post('pwd');
        $pwd2 = $this->input->post('pwd2');

        if($pwd && MD5($pwd) == md5($pwd2)) {
            return $this->db->query("
                UPDATE
                    users 
                SET 
                    group_id=?,
                    name=?,
                    email=?, 
                    username=?,
                    pwd=MD5(?)
                WHERE 
                    id=?",
                array(
                    $this->input->post('group_id'), 
                    $this->input->post('name'),
                    $this->input->post('email'), 
                    $this->input->post('username'), 
                    $this->input->post('pwd'),
                    $this->input->post('id')
                )
            );
        } else {
            return $this->db->query("
                UPDATE
                    users 
                SET 
                    group_id=?,
                    name=?, 
                    email=?,
                    username=?
                WHERE 
                    id=?",
                array(
                    $this->input->post('group_id'), 
                    $this->input->post('name'), 
                    $this->input->post('email'), 
                    $this->input->post('username'), 
                    $this->input->post('id')
                )
            );
        }
	}

	function DoDeleteData() {
        $delete_id = implode(",", $this->input->post('delete_id'));
		return $this->db->query("
			DELETE FROM
				users 
			WHERE 
				id IN ($delete_id)"
		);
	}
    
}
?>
