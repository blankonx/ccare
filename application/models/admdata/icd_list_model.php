<?php
Class Icd_List_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function GetData($str_search='', $start, $offset) {
		$arr_search = explode("_", $str_search);
        $sql = $this->db->query(
                "
            SELECT 
				SQL_CALC_FOUND_ROWS
                rd.id,
                rd.name,
                rd.code,
                rd.kata_kunci
			FROM 
				`ref_icds` rd
			WHERE
				rd.name LIKE ? OR rd.code LIKE ? OR rd.kata_kunci LIKE ?
			ORDER BY rd.code, rd.name
			LIMIT $start, $offset
		",
                array(
                    "%" . $arr_search[0] . "%",
                    "%" . $arr_search[0] . "%",
                    "%" . $arr_search[0] . "%"
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
