<?php
Class Klinik_Model extends Model {
    function __construct() {
        parent::Model();
    }
//GET//
    function GetDataById() {
        $sql = $this->db->query("
            SELECT code, sub_district_id, name, address
	    FROM 
	    ref_puskesmas
            WHERE
                code=?    
            ",
            array($this->input->post('code'))
        );
        return $sql->row_array();
    }
//DO
function DoAddData() {
		return $this->db->query("
			INSERT INTO 
				ref_puskesmas (
					code,sub_district_id,
                    name, address
				)
			VALUES(
                ?,?,?,?)",
			array(
				$this->input->post('code'),
				$this->input->post('sub_district_id'),
				$this->input->post('name'),
				$this->input->post('address')
			)
		);
	}
    
	function DoUpdateData() {
        return $this->db->query("
            UPDATE
                ref_puskesmas 
            SET 
		code=?,
		sub_district_id=?,
                name=?,
		address=?
            WHERE 
                code=?",
            array(
                $this->input->post('code'),
		$this->input->post('sub_district_id'),
                $this->input->post('name'),
		$this->input->post('address'),
                $this->input->post('saved_id')
            )
        );
	}

	function DoDeleteData() {
        $delete_id = implode(",", $this->input->post('delete_id'));
		return $this->db->query("
			DELETE FROM
				ref_puskesmas 
			WHERE 
				code IN ($delete_id)"
		);
	}
	
	function GetListKec($q){
	$sql = $this->db->query("SELECT rsd.id, rsd.district_id, rsd.code, rsd.name as kecamatan, rd.name as kabupaten
	    FROM `ref_sub_districts` rsd
	    LEFT JOIN ref_districts rd ON (rd.id = rsd.district_id)
            WHERE rsd.id LIKE ?
            OR rsd.code LIKE ?
            OR rsd.name LIKE ?
	    ORDER BY rsd.id ASC
        ",
            array(
                "%" . $q . "%",
                "%" . $q . "%",
                "%" . $q . "%"
            )
        );
        return $sql->result_array();
	}
    
}
?>
