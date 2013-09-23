<?php
Class Klinik_List_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function GetData($str_search='', $start, $offset) {
        $sql = $this->db->query(
                "
            SELECT 
		SQL_CALC_FOUND_ROWS
                code,sub_district_id, name, address
			FROM 
				`ref_puskesmas`
			WHERE
				name LIKE ?
			ORDER BY code
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
