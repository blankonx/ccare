<?php
Class Search_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function getData($str_search='', $start, $offset) {

		$arr_search = array();
		$arr_search = explode('_', $str_search);
		$q = '';

		if($q) $q = "AND (" . $q . ")";

		$query = "
		SELECT 
				SQL_CALC_FOUND_ROWS
				p.nik,
                p.`family_folder`,
                p.`name` as `name`, 
                p.`birth_place`, 
                p.`sex`,
                DATE_FORMAT(p.`birth_date`, '%d/%m/%Y') as `birth_date`, 
                CURDATE() as `curdate`,
				CONCAT_WS(', ', p.`address`) as `address`
            FROM `patients` p
            WHERE 
				(p.`family_folder` LIKE ? 
				OR p.`nik` LIKE ?
				OR p.`name` LIKE ?
				OR p.`address` LIKE ?
				)
				$q
            ORDER BY  p.`family_folder`
			LIMIT $start, $offset
		";

        $sql = $this->db->query(
            $query,
            array(
				'%' . $arr_search[0]. '%',
				'%' . $arr_search[0]. '%',            
				'%' . $arr_search[0]. '%',
				'%' . $arr_search[0]. '%'				
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
    
    function searchByName() {
        $str_q = $this->input->post('q');
        $arr_q = explode(",", $str_q);
        for($i=0;$i<sizeof($arr_q);$i++) {
            $arr_q[$i] = trim($arr_q[$i]);
            //$xarr_q[$i] = explode(" ", $arr_q[$i]);
        }

		$query = "
		SELECT 
            p.`family_folder`,
            p.`name` as `name`, 
            p.`birth_place`, 
            p.`sex`,
            DATE_FORMAT(p.`birth_date`, '%d/%m/%y') as `birth_date`, 
            CONCAT_WS(', ', p.`address`) as `address`
        FROM `patients` p
            JOIN `visits` vis ON (vis.family_folder = p.family_folder)
        WHERE 
            (p.name LIKE ? OR p.`family_folder` LIKE ?)
        GROUP BY p.family_folder
        ORDER BY  p.`family_folder`, p.name ASC
		";
        $sql = $this->db->query(
            $query,
            array(
				$arr_q[0]. '%',
				$arr_q[0]. '%'
			)
		);
		//echo $this->db->last_query();
        return $sql->result_array();
    }
}
?>
