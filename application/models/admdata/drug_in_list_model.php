<?php
Class Drug_In_List_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function GetData($str_search='', $start, $offset) {
		$arr_search = explode("_", $str_search);
		/*
		 * 0 = search_name
		 * 1 = search_date_start
		 * 2 = search_date_end
		 * */
        $sql = $this->db->query(
                "
            SELECT 
				SQL_CALC_FOUND_ROWS
				di.id,
				did.id as detail_id,
                DATE_FORMAT(di.`date`, '%d/%m/%Y') as `date`,
				di.explanation,
				rd.code, 
				rd.name,
				rd.unit,
				rd.stock,
				did.stock_before_insert,
				did.stock_after_insert,
				did.qty
			FROM 
				drugs_in di
				JOIN drugs_in_detail did ON (did.drug_in_id = di.id)
				JOIN ref_drugs rd ON (rd.id = did.drug_id)
			WHERE
				di.`date` BETWEEN STR_TO_DATE(?, '%d/%m/%Y') AND STR_TO_DATE(?,'%d/%m/%Y')
				AND 
				(di.explanation LIKE ?
				OR rd.name LIKE ? 
				OR rd.code LIKE ?)
			ORDER BY di.id DESC, rd.code
			LIMIT $start, $offset
		",
                array(
                    $arr_search[1],
                    $arr_search[2],
                    "%" . $arr_search[0] . "%",
                    "%" . $arr_search[0] . "%",
                    "%" . $arr_search[1] . "%"
                )
		);
		//echo "<pre>" . $this->db->last_query() . "</pre>";
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
