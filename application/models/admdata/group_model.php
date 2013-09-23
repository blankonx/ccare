<?php
Class Group_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    
    function GetMenu() {
        $sql = $this->db->query("
        SELECT 
            m.id, m.parent_id, m.name, m.url, m.ordering 
        FROM 
            ref_menu m 
        ORDER BY ordering
        ");
        $data = array();
        $temp = $sql->result_array();
        for($i=0;$i<sizeof($temp);$i++) {
            $data[$temp[$i]['parent_id']][] = $temp[$i];
        }
        return $data;
    }
	
    function GetDataById() {
        $sql = $this->db->query("
            SELECT 
                rg.id as id,
                rg.name as name,
                gm.menu_id as menu_id
			FROM 
				ref_groups rg
				LEFT JOIN group_menu gm ON (gm.group_id = rg.id)
            WHERE
                rg.id=?    
            ",
            array($this->input->post('id'))
        );
        return $sql->result_array();
    }

//DO
	function DoAddData() {
		$ins_group = $this->db->query("
			INSERT INTO 
				ref_groups (
                    name
				)
			VALUES(
                ?
			)",
			array(
				$this->input->post('name')
			)
		);
		if($ins_group) {
            $last_id = $this->db->insert_id();
            $arrmenu = $_POST['menu'];
            for($i=0;$i<sizeof($arrmenu);$i++) {
                $arr_ins[] = "('".$last_id."','".$arrmenu[$i]."')";
            }
            $str_ins = implode(",", $arr_ins);
            $this->db->query("INSERT INTO group_menu(group_id, menu_id) VALUES " . $str_ins);
        }
        return $ins_group;
	}
    
	function DoUpdateData() {
        $upd_grouop = $this->db->query("
            UPDATE
                ref_groups 
            SET 
                name=?
            WHERE 
                id=?",
            array(
                $this->input->post('name'), 
                $this->input->post('id')
            )
        );
        //delete all menu dulu
		if($upd_grouop) {
            $last_id = $this->input->post('id');
		    $this->db->query("DELETE FROM group_menu WHERE group_id=?", array($last_id));
            $arrmenu = $_POST['menu'];
            for($i=0;$i<sizeof($arrmenu);$i++) {
                $arr_ins[] = "('".$last_id."','".$arrmenu[$i]."')";
            }
            $str_ins = implode(",", $arr_ins);
            $this->db->query("INSERT INTO group_menu(group_id, menu_id) VALUES " . $str_ins);
        }
        return $upd_grouop;
	}

	function DoDeleteData() {
        $delete_id = implode(",", $this->input->post('delete_id'));
        $this->db->query("DELETE FROM ref_groups WHERE id IN ($delete_id)");
		return $this->db->query("
			DELETE FROM
				group_menu 
			WHERE 
				group_id IN ($delete_id)"
		);
	}
    
}
?>
