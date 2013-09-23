<?php
Class Login_Model extends Model {

    function Login_Model() {
        parent::Model();
    }

	function GetData() {
        $sql = $this->db->query("
            SELECT 
				`id`, `pwd`, `name`, `group_id` 
			FROM 
				`users`
			WHERE 
				`username`=?",
			array(
				$this->input->post('username')	
			)
        );
        return $sql->row_array();
	}
	
	function DoUpdateLogin($userId) {
		$this->db->query("
			UPDATE users
			SET 
				login_count=login_count+1,
				last_login=NOW()
			WHERE
				id=?
		", array($userId));
	}
}
?>
