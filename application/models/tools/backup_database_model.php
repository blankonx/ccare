<?php
Class Backup_Database_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//

    function GetDataById() {
        $sql = $this->db->query("
            SELECT *
			FROM 
				tools_backup_database
            WHERE
                id=?    
            ",
            array($this->input->post('id'))
        );
        return $sql->row_array();
    }

//DO
	function DoAddData($filename, $filesize) {
		return $this->db->query("
			INSERT INTO 
				tools_backup_database (
                    name,
					filename,
					filesize
				)
			VALUES(
                ?,?,
                ?
			)",
			array(
				$this->input->post('name'),
				basename($filename),
				$filesize
			)
		);
	}
    
	function DoUpdateData() {
        return $this->db->query("
            UPDATE
                tools_backup_database 
            SET 
                name=?
            WHERE 
                id=?",
            array(
                $this->input->post('name'),
                $this->input->post('saved_id')
            )
        );
	}

	function DoDeleteData() {
        $delete_id = implode(",", $this->input->post('delete_id'));
		return $this->db->query("
			DELETE FROM
				tools_backup_database 
			WHERE 
				id IN ($delete_id)"
		);
	}
	
	function RestoreDatabase($filename) {
		$content = file_get_contents("webroot/backup_database/" .$filename);
		$this->db->query($content);
	}
    
}
?>
