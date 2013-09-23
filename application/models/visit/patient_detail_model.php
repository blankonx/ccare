<?php
Class Patient_Detail_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
	function GetData($visit_id) {
		//get the current selected data
		$sql = $this->db->query("
			SELECT
				p.`family_folder` as `mr_number`,
				p.`name`,
				p.`birth_place`,
				p.`sex` as `sex`,
				DATE_FORMAT(p.`birth_date`, '%d/%m/%y') as `birth_date`, 
				v.`date` as `visit_date`,
				v.`address` as `address`
			FROM 
				`patients` p
				JOIN `visits` v ON (v.`family_folder` = p.`family_folder`)
			WHERE
				v.`id`=?
		",
			array($visit_id)
		);
		return $sql->row_array();
	}
}
?>
