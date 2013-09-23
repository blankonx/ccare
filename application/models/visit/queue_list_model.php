<?php
Class Queue_List_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function getData($str_search='', $start, $offset) {

		$arr_search = array();
		$arr_search = explode('_', $str_search);
        if(!$arr_search[2]) {
            $q = " AND v.`served` = 'no' ";
        }
        if(!$arr_search[3]) $arr_search[3] = date('d-m-Y');
        if(!$arr_search[4]) $arr_search[4] = date('d-m-Y');
		$query = "
            SELECT 
				SQL_CALC_FOUND_ROWS
				v.`id` as `id`,
				v.`date` as `date`,
				DATE_FORMAT(v.`date`, '%d-%m-%y') as `time21`,
				DATE_FORMAT(v.`date`, '%H:%i') as `time22`,				
				CASE
					WHEN DATE(v.`date`) = CURDATE() THEN DATE_FORMAT(v.`date`, '%H:%i')
					ELSE DATE_FORMAT(v.`date`, '%d/%m/%Y %H:%i') END as `time`,
				CONCAT(p.`family_folder`, '-', p.`family_relationship_id`) as `mr_number`,
				p.`id` as `patient_id`,
				p.`name` as `patient_name`,
				p.`sex` as `patient_sex`,
				p.`birth_date` as `birth_date`,
				p.birth_date as birth_date_for_age,
				DATE(v.date) as visit_date_for_age,
				v.`date` as `visit_date`,
				c.`id` as `clinic_id`,
				c.`name` as `clinic_name`,
				v.`served` as `served`
			FROM 
				`visits` v
				JOIN `patients` p ON (p.`id` = v.`patient_id` )
				JOIN `ref_clinics` c ON (c.`id` = v.`clinic_id`)
			WHERE
				c.`id` LIKE ?
				AND p.`name` LIKE ?
				AND DATE(v.`date`) BETWEEN STR_TO_DATE(?, '%d-%m-%Y') AND STR_TO_DATE(?, '%d-%m-%Y')
                $q
			ORDER BY c.name, v.id, p.`name`
			LIMIT $start, $offset
		";
        //echo $query;
        $sql = $this->db->query(
                $query,
                array(
                    "%" . $arr_search[0] . "%",
                    "%" . $arr_search[1] . "%",
                    $arr_search[3],
                    $arr_search[4]
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
