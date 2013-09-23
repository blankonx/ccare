<?php
Class Group_Icd_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//

    function GetDataById() {
        $sql = $this->db->query("
            SELECT 
                ig.id,
                ig.name,
                igd.id as igd_id,
                i.id as icd_id,
                i.code as icd_code,
                i.name as icd_name
			FROM 
				ref_icd_group ig
                LEFT JOIN ref_icd_group_detail igd ON (igd.icd_group_id = ig.id)
                LEFT JOIN ref_icds i ON (i.id = igd.icd_id)
            WHERE
                ig.id=?    
            ",
            array($this->input->post('id'))
        );
        return $sql->result_array();
    }
    
    function GetIcdDetailById($icdGroupId) {
        $sql = $this->db->query("
            SELECT 
                igd.id as igd_id,
                i.id as icd_id,
                i.code as icd_code,
                i.name as icd_name
			FROM 
                ref_icd_group_detail igd
                LEFT JOIN ref_icds i ON (i.id = igd.icd_id)
            WHERE
                igd.icd_group_id=?    
            ",
            array($icdGroupId)
        );
        return $sql->result_array();
	}
	    
//DO
	function DoAddData() {
        $this->db->trans_start();
		$q = $this->db->query("
			INSERT INTO 
				ref_icd_group (
                    name
				)
			VALUES(
                ?
			)",
			array(
				$this->input->post('name')
			)
		);
        $this->AddBoundary($this->db->insert_id());
        return $this->db->trans_complete();
	}
    
	function DoUpdateData() {
        $this->db->trans_start();
        $q = $this->db->query("
            UPDATE
                ref_icd_group 
            SET 
                name=?,
                `date`=NOW()
            WHERE 
                id=?",
            array(
                $this->input->post('name'),
                $this->input->post('id')
            )
        );
        $this->AddBoundary($this->input->post('id'));
        return $this->db->trans_complete();
	}
	
	function AddBoundary($icdGroupId) {
		$this->db->query("DELETE FROM ref_icd_group_detail WHERE icd_group_id=?", array($icdGroupId));
		$icd_id = $this->input->post('icd_id');
		foreach($icd_id as $key => $val) {
			$this->db->query("INSERT INTO ref_icd_group_detail(icd_group_id, icd_id) VALUES(?,?)", array($icdGroupId, $val));
		}
	}

	function DoDeleteDetail($gid) {
		return $this->db->query("
			DELETE FROM
				ref_icd_group_detail 
			WHERE 
				id=?", array($gid)
		);
	}

	function DoDeleteData() {
        $delete_id = implode(",", $this->input->post('delete_id'));
		return $this->db->query("
			DELETE FROM
				ref_icd_group 
			WHERE 
				id IN ($delete_id)"
		);
	}
    
}
?>
