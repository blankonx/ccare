<?php
Class Pemeriksaan_Lab_List_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function getData($str_search='', $start, $offset) {

		$arr_search = array();
		$arr_search = explode('_', $str_search);

		$query = "
            SELECT 
				SQL_CALC_FOUND_ROWS
				tc.id as category_id, tc.name as category, t.id, t.name, t.price, t.satuan, t.nilai_minimum, t.nilai_maximum 
			FROM 
				ref_pemeriksaan_lab t
				JOIN ref_pemeriksaan_lab_categories tc ON (tc.id = t.pemeriksaan_lab_category_id)
			WHERE
				tc.id LIKE ?
				AND t.name LIKE ?
			ORDER BY tc.name, t.name ASC
			LIMIT $start, $offset
		";
        //echo $query;
        $sql = $this->db->query(
                $query,
                array(
                    "%" . $arr_search[0] . "%",
                    "%" . $arr_search[1] . "%"
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
