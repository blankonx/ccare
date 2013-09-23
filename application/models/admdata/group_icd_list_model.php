<?php
Class Group_Icd_List_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function GetData($str_search='', $start, $offset) {
        $sql = $this->db->query(
                "
            SELECT 
				SQL_CALC_FOUND_ROWS
                ig.id,
                ig.name,
                ig.`date`,
                COUNT(igd.id) as jml
			FROM 
				`ref_icd_group` ig
                LEFT JOIN ref_icd_group_detail igd ON (igd.icd_group_id = ig.id)
			WHERE
				ig.name LIKE ?
			GROUP BY ig.id
			ORDER BY ig.name
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
