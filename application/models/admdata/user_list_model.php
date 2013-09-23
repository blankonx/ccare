<?php
Class User_List_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function GetData($str_search='', $start, $offset) {
        //echo $query;
        $str_search = substr($str_search, 0, -1);
        $sql = $this->db->query(
                "
            SELECT 
				SQL_CALC_FOUND_ROWS
                u.id as `id`,
                u.name as `name`,
                u.email as `email`,
                u.username as `username`,
                rg.name as `group`
			FROM 
				`users` u
                JOIN `ref_groups` `rg` ON (rg.id = u.group_id)
           	WHERE
				u.name LIKE ?
			ORDER BY rg.name, u.name
			LIMIT $start, $offset
		",
                array(
                    "%" . $str_search . "%"
                )
		);
		//echo $this->db->last_query();
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
