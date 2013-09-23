<?php
Class xMenu_Model extends Model {

    function __construct() {
        parent::Model();
    }
    
    function GetMenu() {
        $group_id = $this->session->userdata('group_id');
        if(!$group_id) $group_id = '0';
        $sql = $this->db->query("
        SELECT 
            m.id, m.parent_id, m.name, m.url, m.ordering 
        FROM 
            ref_menu m 
            JOIN group_menu gm ON (gm.menu_id = m.id)
        WHERE gm.group_id=?
        ORDER BY ordering
        ", array(
            $group_id
        ));
        $data = array();
        $temp = $sql->result_array();
        for($i=0;$i<sizeof($temp);$i++) {
            $data[$temp[$i]['parent_id']][] = $temp[$i];
        }
        return $data;
    }
}
?>
