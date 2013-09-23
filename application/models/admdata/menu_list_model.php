<?php
Class Menu_List_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function GetData($str_search='', $start, $offset) {
        $sql = $this->db->query("
        SELECT 
            m.id, m.parent_id, m.name, m.url, m.ordering, m.ordering as xordering
        FROM 
            ref_menu m 
        WHERE m.name LIKE ?
        ORDER BY 
            ordering
        LIMIT $start, $offset
        ", array(
            "%" . $str_search . "%"
        ));
        $data = array();
        $temp = $sql->result_array();
        for($i=0;$i<sizeof($temp);$i++) {
            $data[$temp[$i]['parent_id']][] = $temp[$i];
        }
        return $data;
    }
    /*
    function GetData($str_search='', $start, $offset) {
        //echo $query;
        $sql = $this->db->query(
                "
        SELECT
			menu_child.parent_id as parent_id,
			menu_child.id as id,
			menu_child.name as name,
			menu_child.url as url,
			menu_child.level as level,
			menu_child.ordering as child_ordering,
			IFNULL(menu_parent.ordering, menu_child.ordering) as xordering
		FROM
			ref_menu menu_child
			LEFT JOIN (
				SELECT 
					id,
					ordering
				FROM
					ref_menu
				WHERE
					parent_id IS NULL
			) menu_parent ON(menu_parent.id = menu_child.parent_id)
        WHERE level <> '2'
		GROUP BY menu_child.id
		ORDER BY xordering, menu_child.parent_id, menu_child.ordering
			LIMIT $start, $offset
		",
                array(
                    "%" . $str_search . "%"
                )
		);
        return $sql->result_array();
    }

    function GetMenuLevelTwo() {
        $sql = $this->db->query("
		SELECT
			rm.parent_id,
			rm.id,
			rm.name,
			rm.url,
			rm.ordering
		FROM
			ref_menu rm 
            WHERE  level = '2'
		ORDER BY parent_id, ordering
        ");
        return $sql->result_array();
    }
*/
    function getCount() {
        $query = $this->db->query("SELECT FOUND_ROWS() as total");
        if($query->num_rows() > 0) {
            $data = $query->row_array();
            return $data['total'];
        } else {
            return false;
        }
    }
}
?>
