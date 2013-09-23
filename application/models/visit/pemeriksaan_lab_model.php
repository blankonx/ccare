<?php
Class Pemeriksaan_Lab_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
	function GetList($visitId, $limit, $offset) {
        $sql = $this->db->query("
            SELECT 
                SQL_CALC_FOUND_ROWS 
                pl.id as id,
                DATE_FORMAT(v.`date`, '%d %b %y') as `date`,
                `getDateDiff`(v.`date`) as `datediff`,
                CONCAT(SUBSTRING(GROUP_CONCAT(rpl.name SEPARATOR ', '), 1, 70), '...') as jenis
            FROM
                visit_pemeriksaan_lab pl
                JOIN visits v ON (v.id = pl.visit_id)
                JOIN visit_pemeriksaan_lab_detail pld ON (pld.visit_pemeriksaan_lab_id = pl.id)
                JOIN ref_pemeriksaan_lab rpl ON (rpl.id = pld.pemeriksaan_lab_id)
            WHERE
                v.patient_id = (SELECT patient_id FROM visits WHERE id=?)
            GROUP BY pl.id
            ORDER BY pl.id DESC
            LIMIT $limit, $offset
        ",
        array(
            $visitId
        ));
        return $sql->result_array();
	}

    function GetCount() {
        $sql = $this->db->query("SELECT FOUND_ROWS() as total");
        if($sql->num_rows() > 0) {
            $data = $sql->row_array();
            return $data['total'];
        } else {
            return false;
        }
    }

    function GetDetail($plId) {
        $sql = $this->db->query("
            SELECT 
                pl.id as id,
                rplc.name as parent_name,
                rpl.name as name,
                rpl.satuan,
                rpl.nilai_minimum,
                rpl.nilai_maximum,
                pld.result as result
            FROM
                visit_pemeriksaan_lab pl
                JOIN visits v ON (v.id = pl.visit_id)
                JOIN visit_pemeriksaan_lab_detail pld ON (pld.visit_pemeriksaan_lab_id = pl.id)
                JOIN ref_pemeriksaan_lab rpl ON (rpl.id = pld.pemeriksaan_lab_id)
                JOIN ref_pemeriksaan_lab_categories rplc ON (rplc.id = rpl.pemeriksaan_lab_category_id)
            WHERE 
                pl.id =?
        ",
        array(
            $plId
        ));
		return $sql->result_array();
    }
    

    function GetDataDoctor() {
        $sql = $this->db->query("
            SELECT * FROM view_ref_doctors WHERE active='yes' ORDER BY name
        "
        );
        return $sql->result_array();
    }
    
    function GetPemeriksaanLab() {
        $sql = $this->db->query("
            SELECT
                plc.id as parent_id,
                plc.name as parent_name,
                pl.id as id,
                pl.satuan,
                pl.nilai_minimum,
                pl.nilai_maximum,
                pl.name as name
            FROM
                ref_pemeriksaan_lab pl
                JOIN ref_pemeriksaan_lab_categories plc ON (plc.id = pl.pemeriksaan_lab_category_id)
            ORDER BY
                plc.ordering, pl.ordering
        ");
        return $sql->result_array();
    }

    function DoAddDataPemeriksaanLab() {
        /*
         * untuk lab, dimasukkan ke tabel visit dengan parent_id = id visit pengirim
         * lalu untuk visit_id di visit_pemeriksaan_lab diisi dengan visit_id yg di lab
         * ok?oye........
         * */
        $sql_visit = $this->db->query("
            INSERT INTO visits (
                parent_id, 
                patient_id, 
                family_folder, 
                family_relationship_id, 
                `date`, 
                `user_id`, 
                `payment_type_id`, 
                clinic_id, 
                insurance_no,
                address,
                village_id,
                education_id,
                job_id
            )
            SELECT
                ?, 
                patient_id, 
                family_folder, 
                family_relationship_id, 
                `date`, 
                `user_id`, 
                `payment_type_id`, 
                '6', 
                insurance_no,
                address,
                village_id,
                education_id,
                job_id
            FROM
                visits
            WHERE
                id=?
        ", 
            array(
                $this->input->post('pl_visit_id'),
                $this->input->post('pl_visit_id')
            )
        );
        
        $last_visit_id = $this->db->insert_id();
        
        $sql = $this->db->query("
            INSERT INTO visit_pemeriksaan_lab(visit_id) 
            VALUES(?)
        ",
            array(
                $last_visit_id
            )
        );
        
        $last_id =  $this->db->insert_id();
        $item = $_POST['pemeriksaan_lab_item'];
        $arr_item = array();
        for($i=0;$i<sizeof($item);$i++) {
            $arr_item[] = "('".$last_id."', '".$item[$i]."')";
            
            $x = $this->db->query("
                INSERT INTO 
                    visit_pemeriksaan_lab_detail(
                        visit_pemeriksaan_lab_id, 
                        pemeriksaan_lab_id,
                        price
                    ) 
                    SELECT 
                        ?,
                        ?,
                        price
                    FROM
                        ref_pemeriksaan_lab
                    WHERE id=?
            ", array(
                $last_id,
                $item[$i],
                $item[$i]
            ));
            //echo $this->db->last_query();
            //echo "\n";
        }
        //$str_item = implode(",", $arr_item);
        return $x;
    }

}
?>
