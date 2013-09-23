<?php
Class Patient_Search_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function getData($str_patient_search='', $start, $offset) {

		$arr_patient_search = array();
		$arr_patient_search = explode('_', $str_patient_search);
		$q = '';

		
		if($q) $q = "AND (" . $q . ")";

		$query = "
		SELECT 
				SQL_CALC_FOUND_ROWS
				p.`family_folder` as `mr_number`,
                p.`family_folder` as `family_code`,
                p.`name` as `name`,  
                p.`birth_place`, 
                p.`sex`,
                DATE_FORMAT(p.`birth_date`, '%d/%m/%y') as `birth_date`, 
				CONCAT_WS(', ', p.`address`) as `address`
            FROM `patients` p
            WHERE 
				(p.`family_folder` LIKE ? 
				OR p.`nik` LIKE ?
				OR p.`name` LIKE ?
				OR p.`address` LIKE ?
				)
				$q
            ORDER BY p.`family_folder`
			LIMIT $start, $offset
		";

        $sql = $this->db->query(
            $query,
            array(
				'%' . $arr_patient_search[0]. '%',
				'%' . $arr_patient_search[0]. '%',            
				'%' . $arr_patient_search[0]. '%',
				'%' . $arr_patient_search[0]. '%'
			)
		);
		//echo $query;
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
    
    function patient_searchByName($str_patient_search='', $start, $offset) {
		$query = "
		SELECT 
				SQL_CALC_FOUND_ROWS
				p.`family_folder` as `mr_number`,
                p.`name` as `name`,  
                p.`birth_place`, 
                p.`sex`,
                DATE_FORMAT(p.`birth_date`, '%d/%m/%y') as `birth_date`, 
				CONCAT_WS(', ', p.`address`) as `address`
            FROM `patients` p
            WHERE 
				p.name LIKE ?
            ORDER BY p.`family_folder`
			LIMIT $start, $offset
		";

        $sql = $this->db->query(
            $query,
            array(
				'%' . $str_patient_search. '%'
				
			)
		);
		//echo $query;
        return $sql->result_array();
    }
}
?>
