<?php
Class Clinic_List_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function getData($str_search='', $start, $offset) {
		/*		$query = "
            SELECT 
				SQL_CALC_FOUND_ROWS
				`parent`.`id` as `category_id`, 
				`parent`.`name` as `category_name`,
				`child`.`parent_id` as `parent_id`,
				`child`.`id` as `id`,
				`child`.`name` as `name`,
				`child`.`active` as `active`,
				`child`.`visible` as `visible`,
				`child`.`allow_to_change` as `allow_to_change`
			FROM 
				`clinics` `child` 
				LEFT JOIN (
					SELECT 
						`id`, `name` 
					FROM `clinics`
					WHERE `parent_id`=0
				) parent ON (`parent`.`id` = `child`.`parent_id`)
			WHERE
				`child`.`name` LIKE ?
			ORDER BY `category_name`, `parent_id`
			LIMIT $start, $offset
		";
		*/
		$query = "
            SELECT 
				SQL_CALC_FOUND_ROWS
				IFNULL(`parent`.`id`, `child`.`id`) as `category_id`, 
				IFNULL(`parent`.`name`, `child`.`name`) as `category_name`,
				`child`.`parent_id` as `parent_id`,
				`child`.`id` as `id`,
				`child`.`name` as `name`,
				`child`.`active` as `active`,
				`child`.`visible` as `visible`,
				`child`.`allow_to_change` as `allow_to_change`
			FROM 
				`ref_clinics` `child` 
				LEFT JOIN (
					SELECT 
						`id`, `name` 
					FROM `ref_clinics`
					WHERE `parent_id`=0
				) parent ON (`parent`.`id` = `child`.`parent_id`)
			WHERE
				`child`.`name` LIKE ?
			ORDER BY `category_name`, `parent_id`
			LIMIT $start, $offset
		";

        //echo $query;
        $sql = $this->db->query(
                $query,
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