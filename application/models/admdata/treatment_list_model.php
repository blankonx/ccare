<?php
Class Treatment_List_Model extends Model {

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
                t.id as id,
				tc.id as category_id, 
                tc.name as category, 
                t.id, t.name, 
                rtp.price as price
			FROM 
				ref_treatments t
				JOIN ref_treatment_categories tc ON (tc.id = t.treatment_category_id)
                JOIN 
                    (
                    SELECT 
                        treatment_id,
                        GROUP_CONCAT(price SEPARATOR '|') as price 
                    FROM 
                        ref_treatment_price
                    GROUP BY treatment_id
                    ORDER BY payment_type_id
                    ) rtp ON (rtp.treatment_id = t.id)
			WHERE
				tc.id LIKE ?
				AND t.name LIKE ?
            GROUP BY t.id
			ORDER BY tc.name, t.name
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
	
    function GetComboPaymentType() {
        $sql = $this->db->query("
            SELECT 
				id, name 
			FROM 
				ref_payment_types 
			ORDER BY 
				id"
        );
        return $sql->result_array();
    }
}
?>
