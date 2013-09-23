<?php
Class Clinic_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function GetComboCategory() {
        $sql = $this->db->query("
            SELECT 
				`id`, `name` 
			FROM 
				`ref_clinics`
			WHERE id IN(5,160,161,162,163,164,165,166,167,168,169) 
			ORDER BY 
				`name`"
        );
        return $sql->result_array();
    }
	
	function DoDeleteData() {
        $delete_id = implode(",", $this->input->post('delete_id'));
		return $this->db->query("
			DELETE FROM
				`ref_clinics`
			WHERE 
				`id` IN ($delete_id) 
				OR `parent_id` IN ($delete_id)
			AND allow_to_change='yes'	
			"
		);
	}
	
	function DoAddData() {
		$sql = $this->db->query("
			INSERT INTO 
				`ref_clinics` (
					`parent_id`, 
					`name`, 
					`active`,
					`visible`)
			VALUES(
				NULLIF(?,''),
				?,
				?,
				?)",
			array(
				$this->input->post('parent_id'), 
				$this->input->post('name'), 
				$this->input->post('active'), 
				$this->input->post('visible')
			)
		);
		$last_id = $this->db->insert_id();
		//insert ke module
        $this->db->query("INSERT INTO clinic_modules(clinic_id, module_id) VALUES (?,1), (?,4)", array($last_id, $last_id));
		return $sql;
	}

	function DoUpdateName() {
        $id = end(explode('_', $this->input->post('id')));
		return $this->db->query("
			UPDATE
				`ref_clinics` 
			SET 
				`name`=?
			WHERE 
				`id`=?",
			array(
				$this->input->post('value'),
				$id
			)
		);
	}
	
	function DoUpdateActive() {
		return $this->db->query("
			UPDATE
				`ref_clinics` 
			SET 
				`active`=?
			WHERE 
				`id`=?",
			array(
				$this->input->post('active'),
				$this->input->post('id')
			)
		);
	}
	
	function DoUpdateVisible() {
		return $this->db->query("
			UPDATE
				`ref_clinics` 
			SET 
				`visible`=?
			WHERE 
				`id`=?",
			array(
				$this->input->post('visible'),
				$this->input->post('id')
			)
		);
	}

}
?>
