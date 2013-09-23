<?php
Class Profile_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function GetProfile() {
        $sql = $this->db->query("SELECT * FROM view_ref_profiles");
        return $sql->row_array();
    }
    
    /*function GetListSpesialisasi() {
        $sql = $this->db->query(
        "
          SELECT id, name FROM ref_spesialisasi_tipe GROUP BY name ORDER BY name"
        );
        return $sql->result_array();
    }*/
	
 //DO//
    function DoUpdateProfile() {
        return $this->db->query("
            UPDATE ref_profiles 
            SET 
                name=?,
                spesialisasi=?,
                no_str=?,
                awal_berlaku_str=STR_TO_DATE(?, '%d/%m/%Y'),
                akhir_berlaku_str=STR_TO_DATE(?, '%d/%m/%Y'),
                no_sip=?,
                awal_berlaku_sip=STR_TO_DATE(?, '%d/%m/%Y'),
                akhir_berlaku_sip=STR_TO_DATE(?, '%d/%m/%Y'),
                address=?,
                phone=?,
                screensaver_delay=?,
                report_header_1=?
            ",
            array(
                $this->input->post('name'),
                $this->input->post('spesialisasinya'),
                $this->input->post('no_str'),
                $this->input->post('awal_berlaku_str'),
                $this->input->post('akhir_berlaku_str'),
                $this->input->post('no_sip'),
                $this->input->post('awal_berlaku_sip'),
                $this->input->post('akhir_berlaku_sip'),
                $this->input->post('address'),	
                $this->input->post('phone'),
                $this->input->post('screensaver_delay'),
                $this->input->post('report_header_1')
            )
        );
    }

   function DoUpdatePhoto($filename) {
        return $this->db->query("
            UPDATE ref_profiles 
            SET 
                photo=?
            ",
            array(
                $filename
            )
        );
    }

    function DoUpdateScreensaver($filename) {
        return $this->db->query("
            UPDATE ref_profiles 
            SET 
                screensaver=?
            ",
            array(
                $filename
            )
        );
    }
}
?>
