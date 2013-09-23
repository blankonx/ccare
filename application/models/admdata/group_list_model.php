<?php
Class Group_List_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function GetData($str_search='', $start, $offset) {
        //echo $query;
        $sql = $this->db->query(
                "
            SELECT 
				SQL_CALC_FOUND_ROWS
				rg.id as id,
				rg.name as name,
				GROUP_CONCAT(CONCAT(xm.parent_name, ' ', xm.name) SEPARATOR '<br/>') as menu
			FROM 
				`ref_groups` rg
				LEFT JOIN group_menu gm ON (gm.group_id = rg.id)
				LEFT JOIN view_menu xm ON (xm.id = gm.menu_id)
            GROUP BY rg.id
			ORDER BY rg.name, menu
			LIMIT $start, $offset
		",
                array(
                    "%" . $str_search . "%"
                )
		);
        return $sql->result_array();
    }

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
