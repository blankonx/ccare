<?php
Class Rawatinap_Queue_List_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function getData($str_search='', $start, $offset) {

		$arr_search = array();
		$arr_search = explode('_', $str_search);
        $q = " AND vic.`exit_date` IS NULL ";
        if(!$arr_search[2]) {
            $q .= " AND v.`inpatient_continue_id` IS NULL ";
        }
        if(!$arr_search[3]) $arr_search[3] = date('d-m-Y');
        if(!$arr_search[4]) $arr_search[4] = date('d-m-Y');
		$query = "
            SELECT 
				SQL_CALC_FOUND_ROWS
				v.`id` as `id`,
				`vic`.`id` as `vicid`,
				v.`entry_date` as `date`,
				DATE_FORMAT(v.`entry_date`, '%d/%m/%Y %H:%i') as `time`,
				CONCAT(p.`family_folder`, '-', p.`id`, '-', p.`family_relationship_id`) as `mr_number`,
				p.`id` as `patient_id`,
				p.`name` as `patient_name`,
				p.`sex` as `patient_sex`,
				p.`birth_date` as `birth_date`,
				p.birth_date as birth_date_for_age,
				DATE(vic.entry_date) as visit_date_for_age,
				v.`entry_date` as `visit_date`,
				c.`id` as `clinic_id`,
				c.`name` as `clinic_name`,
				/*IFNULL(DATE_FORMAT(vid.`date`, '%d/%m/%Y %H:%i'), 'Belum Pernah Diperiksa') as `latest_served_date`,*/
				v.`served` as `served`
			FROM 
				`visits_inpatient` v
				JOIN `patients` p ON (p.`id` = v.`patient_id` )
				JOIN `visits_inpatient_clinic` vic ON (vic.visit_inpatient_id = v.id)
				JOIN `ref_inpatient_clinics` c ON (c.`id` = vic.`inpatient_clinic_id`)
				/*
				LEFT JOIN (
					SELECT
						`id`, `visit_inpatient_clinic_id`, `date`
					FROM 
						visits_inpatient_detail 
					WHERE `date`=(SELECT MAX(`date`) FROM visits_inpatient_detail GROUP BY visit_inpatient_clinic_id)
					
					) vid ON (vid.visit_inpatient_clinic_id = vic.id)
					*/
			WHERE
				c.`id` LIKE ?
				AND p.`name` LIKE ?
                $q
			GROUP BY vic.id
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
