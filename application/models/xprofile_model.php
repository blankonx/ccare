<?php
Class xProfile_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function GetProfile() {
        $sql = $this->db->query("
            SELECT * FROM view_ref_profiles"
        );
        return $sql->row_array();
    }

}
?>
