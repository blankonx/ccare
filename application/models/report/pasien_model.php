<?php
Class Pasien_Model extends Model {

	function __construct() {
		parent::Model();
	}
	
	 function GetDataPasien($str_search='', $start, $offset) {
		$arr_search = explode("_", $str_search);
        $sql = $this->db->query(
                "
           SELECT
            p.family_folder,p.nik,p.name,p.sex,p.birth_place,
            DATE_FORMAT(p.birth_date,'%d-%m-%Y') as tgl_lahir, p.address, rpt.name as jns_pasien,v.insurance_no,
            p.marital_status_id, DATE_FORMAT(p.registration_date,'%d-%m-%Y') as registration_date
        FROM
            patients p
            JOIN visits v ON (v.family_folder=p.family_folder)  
            JOIN ref_payment_types rpt ON(rpt.id=v.payment_type_id)           
        ORDER BY p.family_folder,p.registration_date,p.name
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
    
    function GetDataPasien_Print($str_search='', $start, $offset) {
		$arr_search = explode("_", $str_search);
        $sql = $this->db->query(
                "
           SELECT
            p.family_folder,p.nik,p.name,p.sex,p.birth_place,
            DATE_FORMAT(p.birth_date,'%d-%m-%Y') as tgl_lahir, p.address, rpt.name as jns_pasien,v.insurance_no,
            p.marital_status_id, DATE_FORMAT(p.registration_date,'%d-%m-%Y') as registration_date
        FROM
            patients p
            JOIN visits v ON (v.family_folder=p.family_folder)  
            JOIN ref_payment_types rpt ON(rpt.id=v.payment_type_id)           
        ORDER BY p.family_folder,p.registration_date,p.name
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
