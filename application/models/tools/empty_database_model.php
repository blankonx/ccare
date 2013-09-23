<?php
Class Empty_Database_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//

    function GetDataById() {
        $sql = $this->db->query("
            SELECT *
			FROM 
				tools_empty_database
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
				tools_empty_database (
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
	
	function DoEmptyDatabase() {
		$this->db->query("TRUNCATE TABLE patients");
		$this->db->query("TRUNCATE TABLE visits");
		$this->db->query("TRUNCATE TABLE drugs_clinic_request");
		$this->db->query("TRUNCATE TABLE report_dinas");
		$this->db->query("TRUNCATE TABLE tools_backup_database");
		$this->db->query("TRUNCATE TABLE drugs_in");
		$this->db->query("UPDATE patient_latest_mr_number SET id=1");
		$this->db->query("TRUNCATE TABLE expert_anamnese_diagnoses");
		$this->db->query("TRUNCATE TABLE expert_anamnese_diagnose_details");
		$this->db->query("TRUNCATE TABLE receipts");
		$this->db->query("TRUNCATE TABLE prescribes");
		$this->db->query("TRUNCATE TABLE chats");
		$this->db->query("TRUNCATE TABLE lplpo");
		$this->db->query("TRUNCATE TABLE alergi");
		$this->db->query("TRUNCATE TABLE users");
		$this->db->query("TRUNCATE TABLE ref_paramedics");
		$this->db->query("INSERT INTO `users` (`id`,`group_id`,`clinic_id`,`username`,`pwd`,`name`) VALUES (NULL , 1 , NULL , 'admin', MD5( 'rahasia' ) , 'Administrator')");
		$this->db->query("INSERT INTO `ref_paramedics` (`id`,`paramedic_type_id`,`nip`,`name`,`active`) VALUES (NULL , 1 , '19' , 'dokter Umum', 'yes'),(NULL , 7 , '19' , 'dokter Gigi', 'yes'),(NULL , 2 , '19' , 'Bidan', 'yes'),(NULL , 6 , '19' , 'Laborat', 'yes')");
		$this->db->query("TRUNCATE TABLE tools_empty_database");
		return true;
	}
    
	function DoUpdateData() {
        return $this->db->query("
            UPDATE
                tools_empty_database 
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
				tools_empty_database 
			WHERE 
				id IN ($delete_id)"
		);
	}
    
}
?>
