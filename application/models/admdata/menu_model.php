<?php
Class Menu_Model extends Model {

    function Menu_Model() {
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
				rm.`id`,
				rm.`parent_id`,
				rm.`level`,
				rm.`name`,
				rm.`url`,
				rm.`ordering`
			FROM 
				`ref_menu` rm 
            WHERE
                rm.`id`=?    
            ",
            array($this->input->post('id'))
        );
		//echo $this->db->last_query();
        return $sql->row_array();
    }

//DO
	function DoAddData() {
        $this->db->trans_start();
	    if(!$this->input->post('parent_id')) {
            $order = $this->db->query("
                SELECT IFNULL(MAX(`ordering`)+1, 1) as `ordering` 
                FROM ref_menu 
                WHERE parent_id=0"
            );
            
            $order_data = $order->row_array();
            $ins = $this->db->query("
                INSERT INTO 
                    ref_menu (
                        parent_id, 
						level,
                        name,
                        url,
                        ordering
                    )
                VALUES(
                    0,
					0,
                    ?,
                    ?,
                    ?
                )",
                array(
                    $this->input->post('name'), 
                    $this->input->post('url'),
                    $order_data['ordering']
                )
            );
            $last_id = $this->db->insert_id();
        } else {
			/*
			 * format : parentId|id|level
			 * */
			
            $order = $this->db->query("
                SELECT IFNULL(MAX(`ordering`)+1, 1) as `ordering`,level 
                FROM ref_menu 
                WHERE parent_id=?", array($this->input->post('parent_id'))
            );
			
            $order_data = $order->row_array();
            //$sql_parent = $this->db->query("SELECT * FROM ref_menu WHERE id=?", array($this->input->post('parent_id')));
            //$parent = $sql_parent->row_array();
            $ins = $this->db->query("
                INSERT INTO 
                    ref_menu (
                        parent_id, 
						level,
                        name,
                        url,
                        ordering
                    )
                VALUES(
                    ?,
                    ?,
                    ?,
					?,
                    ?
                )
                ",
                array(
                    $this->input->post('parent_id'), 
                    ($order_data['level']+1), 
                    $this->input->post('name'), 
                    $this->input->post('url'),
                    $order_data['ordering']
                )
            );
            $last_id = $this->db->insert_id();
        }
        $this->db->query("INSERT INTO group_menu(group_id, menu_id) VALUES (?,?)", array(1, $last_id));
        return $this->db->trans_complete();
	}
    
	function DoUpdateData() {
		//$arr = explode("|", $this->input->post('parent_id'));
        $sql_parent = $this->db->query("SELECT * FROM ref_menu WHERE id=?", array($this->input->post('parent_id')));
        $parent = $sql_parent->row_array();
        return $this->db->query("
            UPDATE
                ref_menu 
            SET 
                parent_id=?,
                level=?,
                name=?, 
                url=?
            WHERE 
                id=?",
            array(
				$this->input->post('parent_id'), 
                ($parent['level']+1), 
                $this->input->post('name'), 
                $this->input->post('url'), 
                $this->input->post('id')
            )
        );
	}

	function DoDeleteData() {
        $delete_id = implode(",", $this->input->post('delete_id'));
        $this->db->query("DELETE FROM group_menu WHERE menu_id IN($delete_id)");
		$this->db->query("
			DELETE FROM
				ref_menu 
			WHERE 
				parent_id IN($delete_id)"
		);
		return $this->db->query("
			DELETE FROM
				ref_menu 
			WHERE 
				id IN ($delete_id)"
		);
	}
	
	function DoMoveUp($parent_id, $id, $ordering) {
	    if($parent_id == '0') {
            $switch = $this->db->query("
            SELECT 
                id, ordering 
            FROM 
                ref_menu 
            WHERE 
                parent_id IS NULL 
                AND ordering < ?
            ORDER BY 
                ordering DESC LIMIT 1", 
            array($ordering));
        } else {
            $switch = $this->db->query("
            SELECT 
                id, ordering 
            FROM 
                ref_menu 
            WHERE 
                parent_id=? 
                AND ordering < ?
            ORDER BY 
                ordering DESC LIMIT 1", 
            array($parent_id, $ordering));
        }
        $switch_data = $switch->row_array();
        if(!empty($switch_data)) {
            $this->db->query("UPDATE ref_menu SET ordering=? WHERE id=?", array(
                $ordering,
                $switch_data['id']
            ));
            $this->db->query("UPDATE ref_menu SET ordering=? WHERE id=?", array(
                $switch_data['ordering'],
                $id,
            ));
        }
    }
    
	function DoMoveDn($parent_id, $id, $ordering) {
	    if($parent_id == '0') {
            $switch = $this->db->query("
            SELECT 
                id, ordering 
            FROM 
                ref_menu 
            WHERE 
                parent_id IS NULL 
                AND ordering > ?
            ORDER BY 
                ordering ASC LIMIT 1", 
            array($ordering));
        } else {
            $switch = $this->db->query("
            SELECT 
                id, ordering 
            FROM 
                ref_menu 
            WHERE 
                parent_id=? 
                AND ordering > ?
            ORDER BY 
                ordering ASC LIMIT 1", 
            array($parent_id, $ordering));
        }
        $switch_data = $switch->row_array();
        if(!empty($switch_data)) {
            $this->db->query("UPDATE ref_menu SET ordering=? WHERE id=?", array(
                $ordering,
                $switch_data['id']
            ));
            $this->db->query("UPDATE ref_menu SET ordering=? WHERE id=?", array(
                $switch_data['ordering'],
                $id,
            ));
        }
    }
    
}
?>
