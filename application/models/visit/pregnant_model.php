<?php
Class Pregnant_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//

    function GetDataPregnant($pregnantId) {
        $sql = $this->db->query("
            SELECT 
                p.*,
                b.name as birth,
                c.name as contraceptive,
                rp.name as paramedic,
                rhf.name as health_facility
            FROM
                pregnants p
                LEFT JOIN ref_delivery_methods b ON (b.id = p.delivery_method_id)
                LEFT JOIN ref_contraceptives c ON (c.id = p.contraceptive_id)
                LEFT JOIN ref_paramedic_types rp ON (rp.id = p.medical_facilities_other_paramedic_type_id)
                LEFT JOIN ref_health_facilities rhf ON (rhf.id = p.medical_facilities_other_health_facility_id)
            WHERE
                p.id=?
        ",
        array(
            $pregnantId
        ));
        //echo $this->db->last_query();

        if($sql->num_rows() > 0) {
            return $sql->row_array();
        } else {
            return false;
        }
    }

	function GetDataForChart($pregnantId) {
        $sql = $this->db->query("
            SELECT 
                *
            FROM
                view_list_visit_pregnants 
            WHERE
                `pregnant_id`=?
            AND `log`='no'
        ",
        array(
            $pregnantId
        ));
        //echo $this->db->last_query();

        if($sql->num_rows() > 0) {
            return $sql->result_array();
        } else {
            return false;
        }
	}

    function GetVisitData($visitId) {
        $sql = $this->db->query("
            SELECT 
                    vp.*,
                    v.paramedic_id as paramedic_id,
                    v.continue_id as continue_id
            FROM
                visit_pregnants vp
                JOIN visits v ON (v.id = vp.visit_id)                
            WHERE
                v.id=?
                AND vp.`log`='no'
            GROUP BY vp.id
        ",
        array(
            $visitId
        ));
        //echo $this->db->last_query();

        if($sql->num_rows() > 0) {
            return $sql->row_array();
        } else {
            return false;
        }
    }

    function GetVisitPregnantPoedjiRochjati($visitPregnantId) {
        $sql = $this->db->query("SELECT poedji_rochjati_id FROM visit_pregnant_poedji_rochjati WHERE visit_pregnant_id=?", array($visitPregnantId));
        //echo $this->db->last_query();
        return $sql->result_array();
    }

    function GetDataPregnantFamilyHistory($pregnantId) {
        $sql = $this->db->query("
            SELECT 
                rfhd.name as name
            FROM
                pregnants p
                JOIN pregnant_family_history_diseases pfhd ON (pfhd.pregnant_id = p.id)
                JOIN ref_family_history_diseases rfhd ON (rfhd.id = pfhd.family_history_disease_id)
            WHERE
                p.id=?
        ",
        array(
            $pregnantId
        ));
        //echo $this->db->last_query();

        if($sql->num_rows() > 0) {
            return $sql->result_array();
        } else {
            return false;
        }
    }

    function GetDataPregnantHistory($pregnantId) {
        $sql = $this->db->query("
            SELECT 
                rhd.name as name
            FROM
                pregnants p
                JOIN pregnant_history_diseases phd ON (phd.pregnant_id = p.id)
                JOIN ref_history_diseases rhd ON (rhd.id = phd.history_disease_id)
            WHERE
                p.id=?
        ",
        array(
            $pregnantId
        ));
        //echo $this->db->last_query();

        if($sql->num_rows() > 0) {
            return $sql->result_array();
        } else {
            return false;
        }
    }

	function GetList($pregnantId, $limit, $offset) {
        $sql = $this->db->query("
            SELECT 
                SQL_CALC_FOUND_ROWS 
                *
            FROM
                view_list_visit_pregnants 
            WHERE
                `pregnant_id`=?
                AND `log`='no'
            LIMIT $limit, $offset
        ",
        array(
            $pregnantId
        ));
        //echo $this->db->last_query();

        if($sql->num_rows() > 0) {
            return $sql->result_array();
        } else {
            return false;
        }
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


    function GetListPregnant($pregnantId) {
        $sql = $this->db->query("
            SELECT
                vp.id as id,
                vp.g, vp.p, vp.a,
                getDateDiff(v.`date`) as `datediff`,
                DATE_FORMAT(v.`date`, '%e %b %Y') as `date`,
                p.`name` as `paramedic`,
                vp.`log` as `log`
            FROM
                pregnants vp
                JOIN visits v ON (v.id = vp.visit_id)
                JOIN ref_paramedics p ON (p.id = v.paramedic_id)
            WHERE
                vp.`log`='no'
                AND vp.id=?
            ",
        array(
            $pregnantId
        ));

        if($sql->num_rows() > 0) {
            return $sql->row_array();
        } else {
            return false;
        }
    }

    function GetListDelivery($pregnantId) {
        $sql = $this->db->query("
            SELECT
                d.id as id, 
                d.age_of_pregnant as age_of_pregnant,
                getDateDiff(v.`date`) as `datediff`,
                DATE_FORMAT(v.`date`, '%e %b %Y') as `date`,
                p.`name` as `paramedic`,
                dm.`name` as `delivery_method`
            FROM
                deliveries d
                JOIN visits v ON (v.id = d.visit_id)
                JOIN newborn n ON (n.delivery_id = d.id)
                JOIN ref_paramedics p ON (p.id = v.paramedic_id)
                JOIN ref_delivery_methods dm ON (dm.id = d.delivery_method_id)
            WHERE
                d.`log`='no'
                AND n.`log`='no'
                AND d.pregnant_id=?
            ",
        array(
            $pregnantId
        ));

        if($sql->num_rows() > 0) {
            return $sql->row_array();
        } else {
            return false;
        }
    }

	function GetData($visitId) {
        $sql = $this->db->query("
            SELECT
                v.paramedic_id as paramedic_id, 
                v.continue_id as continue_id,
                p.*,
                getAgeAsYear(?) as `age`,
                GROUP_CONCAT(pf.family_history_disease_id SEPARATOR '|') as family_history_disease_id,
                GROUP_CONCAT(ph.history_disease_id SEPARATOR '|') as history_disease_id
            FROM
                visits v 
                JOIN pregnants p ON (p.visit_id = v.id)
                LEFT JOIN pregnant_family_history_diseases pf ON (pf.pregnant_id = p.id)
                LEFT JOIN pregnant_history_diseases ph ON (ph.pregnant_id = p.id)
            WHERE
                v.id=?
                AND p.`log`='no'
            GROUP BY p.id
        ",
        array(
            $visitId,
            $visitId
        ));

        if($sql->num_rows() > 0) {
            return $sql->row_array();
        } else {
            return false;
        }
	}

    function GetPregnant($visitId) {
        $sql = $this->db->query("
            SELECT 
                v.id as visit_id,
                p.id as id,
                p.g as g,
                CONCAT('Hamil ke-', p.g) as name,
                CONCAT('filename', p.id) as filename
            FROM
                visits v
                JOIN pregnants p ON (p.visit_id = v.id)
            WHERE
                v.patient_id = (SELECT patient_id FROM visits WHERE id=?)
                AND p.`log`='no'
            GROUP BY p.id
            ORDER BY p.id DESC
        ",
        array(
            $visitId
        ));
        //echo $this->db->last_query();

        if($sql->num_rows() > 0) {
            return $sql->result_array();
        } else {
            return false;
        }
    
    }

    function GetCurrentPregnant($visitId) {
        $sql = $this->db->query("
            SELECT 
                /*
                kunjungan_ke,
                usia kehamilan
                trimester
                */
                v.id as `visit_id`,
                p.id as `pregnant_id`,
                TIMESTAMPDIFF(WEEK, p.hpht, v.`date`) as `age_of_pregnant`,
                CASE 
                    WHEN TIMESTAMPDIFF(WEEK, p.hpht, v.`date`) < 12 THEN '1'
                    WHEN TIMESTAMPDIFF(WEEK, p.hpht, v.`date`) < 24 THEN '2'
                    ELSE '3'
                END as `trimester`,
				IFNULL(MAX(vp.kunjungan_ke), 0)+1 as kunjungan_ke 
            FROM
                visits v
                JOIN pregnants p ON(p.visit_id = v.id)
                LEFT JOIN visit_pregnants vp ON (vp.pregnant_id = p.id)
            WHERE
                v.patient_id = (SELECT patient_id FROM visits WHERE id=?)
                AND p.`log`='no'
                AND p.id >= ALL(SELECT id FROM `pregnants`)
            GROUP BY p.id
        ",
        array(
            $visitId
        ));
        //echo $this->db->last_query();
        
        $data = $sql->row_array();
        return $data;    
    }

    function GetDetail($vpId) {
        $sql = $this->db->query("
            SELECT 
                vp.*,
                p.name as p_name,
                c.name as c_name,
                pr.name as pr_name,
                pr.score as pr_score
            FROM
                visit_pregnants vp
                JOIN visits v ON (v.id = vp.visit_id)
                JOIN ref_paramedics p ON (p.id = v.paramedic_id)
                JOIN ref_continue c ON (c.id = v.continue_id)
                JOIN visit_pregnant_poedji_rochjati vppr ON (vppr.visit_pregnant_id = vp.id)
                JOIN ref_poedji_rochjati pr ON (pr.id = vppr.poedji_rochjati_id)
            WHERE
                vppr.`log`='no'
                AND vp.id=?
        ",
        array(
            $vpId
        ));

        if($sql->num_rows() > 0) {
            return $sql->result_array();
        } else {
            return false;
        }
    }

    function GetDetailPregnant($pregnantId) {
        $sql = $this->db->query("
            SELECT 
                vp.*,
                p.name as p_name,
                c.name as c_name,
                pr.name as pr_name,
                pr.score as pr_score,
                pt.name as pt_name,
                b.name as b_name,
                hf.name as hf_name
            FROM
                pregnants vp
                JOIN visits v ON (v.id = vp.visit_id)
                JOIN ref_paramedics p ON (p.id = v.paramedic_id)
                JOIN ref_continue c ON (c.id = v.continue_id)
                LEFT JOIN ref_delivery_methods b ON (b.id= vp.delivery_method_id)
                LEFT JOIN pregnant_poedji_rochjati vppr ON (vppr.pregnant_id = vp.id)
                LEFT JOIN ref_poedji_rochjati pr ON (pr.id = vppr.poedji_rochjati_id)
                LEFT JOIN ref_paramedic_types pt ON (pt.id = vp.medical_facilities_other_paramedic_type_id)
                LEFT JOIN ref_health_facilities hf ON (hf.id = vp.medical_facilities_other_health_facility_id)
            WHERE
                vp.id=?
        ",
        array(
            $pregnantId
        ));
        //echo $this->db->last_query();

        if($sql->num_rows() > 0) {
            return $sql->row_array();
        } else {
            return false;
        }
    }

    function GetDetailDelivery($deliveryId) {
        $sql = $this->db->query("
            SELECT 
                vp.*,
                p.name as p_name,
                c.name as c_name,
                b.name as delivery_method,
                n.*

            FROM
                deliveries vp
                JOIN visits v ON (v.id = vp.visit_id)
                JOIN ref_paramedics p ON (p.id = v.paramedic_id)
                JOIN ref_continue c ON (c.id = v.continue_id)
                JOIN ref_delivery_methods b ON (b.id= vp.delivery_method_id)
                JOIN newborn n ON (n.delivery_id = vp.id)
            WHERE
                vp.`log`='no'
                AND vp.id=?
        ",
        array(
            $deliveryId
        ));
        //echo $this->db->last_query();

        if($sql->num_rows() > 0) {
            return $sql->result_array();
        } else {
            return false;
        }
    }

    function GetDataFamilyHistoryDisease() {
        $sql = $this->db->query("
            SELECT * FROM ref_family_history_diseases WHERE active='yes'
        "
        );
        return $sql->result_array();
    }

    function GetTotalScorePoedjiRochjatiFromPregnant($pregnantId= 0, $visitId = 0) {
        //$total = 2; //starting score
        $total = 0;

        if($visitPregnantId) {
            //$total=50;
            //if the data already saved
            //get poedji rochjati from database
            $sql = $this->db->query("
                SELECT 
                    SUM(pr.score) as score
                FROM
                    visit_pregnant_poedji_rochjati vppr 
                    JOIN visit_pregnants vp ON (vp.id = vppr.visit_pregnant_id)
                    JOIN ref_poedji_rochjati pr ON (pr.id = vppr.poedji_rochjati_id)
                WHERE
                    vppr.`log`='no'
                    AND vp.id=?
            ",
            array(
                $visitPregnantId
            ));
            $data = $sql->row_array();
            $total += $data['score'];
        } elseif($visitId) {
            $sql_default = $this->db->query("SELECT score FROM ref_poedji_rochjati WHERE id='001'");
            $ret = $sql_default->row_array();
            $total += $ret['score'];
            //$total=30;
            //first view, check the data bellow
            /*
            age < 16th = 4
            age > 35 = 4
            */
            $sql = $this->db->query("
                SELECT
                    CASE 
                        WHEN (getAgeAsYear(v.id) < 16) THEN (SELECT score FROM ref_poedji_rochjati WHERE id='002')
                        WHEN (getAgeAsYear(v.id) > 35) THEN (SELECT score FROM ref_poedji_rochjati WHERE id='003')
                        ELSE '0' 
                    END as `score`
                FROM
                    visits v
                WHERE 
                    v.id=?
            ", 
                array(
                    $visitId    
                ));
            $data = $sql->row_array();
            $total += $data['score'];

        } elseif($this->input->post('visit_id')) {
            $sql_default = $this->db->query("SELECT score FROM ref_poedji_rochjati WHERE id='001'");
            $ret = $sql_default->row_array();
            $total += $ret['score'];
            //$total=20;
            //user change or unchange the data
            if($this->input->post('janin_position') == 'Sungsang') {
                $sql_janin = $this->db->query("SELECT score FROM ref_poedji_rochjati WHERE id='026'");
                $ret = $sql_janin->row_array();
                $total += $ret['score'];

            } elseif($this->input->post('janin_position') == 'Melintang') {
                $sql_janin = $this->db->query("SELECT score FROM ref_poedji_rochjati WHERE id='027'");
                $ret = $sql_janin->row_array();
                $total += $ret['score'];
            }
            if($this->input->post('age') < 16) {
                $sql_age = $this->db->query("SELECT score FROM ref_poedji_rochjati WHERE id='002'");
                $data = $sql_age->row_array();
                $total += $data['score'];
            } elseif($this->input->post('age') > 35) {
                $sql_age = $this->db->query("SELECT score FROM ref_poedji_rochjati WHERE id='003'");
                $data = $sql_age->row_array();
                $total += $data['score'];
            }

            $id = $_POST['poedji'];
            if(!empty($id)) {
                $strId = implode(", ", $id);

                $sql = $this->db->query(
                "
                    SELECT SUM(score) as score FROM ref_poedji_rochjati WHERE id IN($strId)
                "    
                );
                $data = $sql->row_array();
                $total += $data['score'];
            }
        }
        return $total;
    }


    function GetTotalScorePoedjiRochjati($visitPregnantId = 0, $visitId = 0) {
        //$total = 2; //starting score
        $total = 0;

        if($visitPregnantId) {
            //$total=50;
            //if the data already saved
            //get poedji rochjati from database
            $sql = $this->db->query("
                SELECT 
                    SUM(pr.score) as score
                FROM
                    visit_pregnant_poedji_rochjati vppr 
                    JOIN visit_pregnants vp ON (vp.id = vppr.visit_pregnant_id)
                    JOIN ref_poedji_rochjati pr ON (pr.id = vppr.poedji_rochjati_id)
                WHERE
                    vppr.`log`='no'
                    AND vp.id=?
            ",
            array(
                $visitPregnantId
            ));
            $data = $sql->row_array();
            $total += $data['score'];
        } elseif($visitId) {
            $sql_default = $this->db->query("SELECT score FROM ref_poedji_rochjati WHERE id='001'");
            $ret = $sql_default->row_array();
            $total += $ret['score'];
            //$total=30;
            //first view, check the data bellow
            /*
            age < 16th = 4
            age > 35 = 4
            */
            $sql = $this->db->query("
                SELECT
                    CASE 
                        WHEN (getAgeAsYear(v.id) < 16) THEN (SELECT score FROM ref_poedji_rochjati WHERE id='002')
                        WHEN (getAgeAsYear(v.id) > 35) THEN (SELECT score FROM ref_poedji_rochjati WHERE id='003')
                        ELSE '0' 
                    END as `score`
                FROM
                    visits v
                WHERE 
                    v.id=?
            ", 
                array(
                    $visitId    
                ));
            $data = $sql->row_array();
            $total += $data['score'];

        } elseif($this->input->post('visit_id')) {
            $sql_default = $this->db->query("SELECT score FROM ref_poedji_rochjati WHERE id='001'");
            $ret = $sql_default->row_array();
            $total += $ret['score'];
            //$total=20;
            //user change or unchange the data
            if($this->input->post('janin_position') == 'Sungsang') {
                $sql_janin = $this->db->query("SELECT score FROM ref_poedji_rochjati WHERE id='026'");
                $ret = $sql_janin->row_array();
                $total += $ret['score'];

            } elseif($this->input->post('janin_position') == 'Melintang') {
                $sql_janin = $this->db->query("SELECT score FROM ref_poedji_rochjati WHERE id='027'");
                $ret = $sql_janin->row_array();
                $total += $ret['score'];
            }
            if($this->input->post('age') < 16) {
                $sql_age = $this->db->query("SELECT score FROM ref_poedji_rochjati WHERE id='002'");
                $data = $sql_age->row_array();
                $total += $data['score'];
            } elseif($this->input->post('age') > 35) {
                $sql_age = $this->db->query("SELECT score FROM ref_poedji_rochjati WHERE id='003'");
                $data = $sql_age->row_array();
                $total += $data['score'];
            }

            $id = $_POST['poedji'];
            if(!empty($id)) {
                $strId = implode(", ", $id);

                $sql = $this->db->query(
                "
                    SELECT SUM(score) as score FROM ref_poedji_rochjati WHERE id IN($strId)
                "    
                );
                $data = $sql->row_array();
                $total += $data['score'];
            }
        }
        return $total;
    }

    function GetDateDiffHPHT($pregnantId, $deliveryDate) {
        $sql = $this->db->query("
        SELECT 
	        TIMESTAMPDIFF(WEEK, hpht, ?) as datediff
        FROM 
            pregnants
        WHERE id=?
        ",
        array(
            $deliveryDate,
            $pregnantId    
        ));
        $data = $sql->row_array();
        return $data['datediff'];
    }

    function GetDataHistoryDisease() {
        $sql = $this->db->query("
            SELECT * FROM ref_history_diseases WHERE active='yes'
        "
        );
        return $sql->result_array();
    }

    function GetDataContraceptive() {
        $sql = $this->db->query("
            SELECT id, name FROM ref_contraceptives WHERE active='yes'
        "
        );
        return $sql->result_array();
    }

    function GetDataHealthFacilities() {
        $sql = $this->db->query("
            SELECT id, name FROM ref_health_facilities WHERE active='yes'
        "
        );
        return $sql->result_array();
    }

    function GetDataParamedicType() {
        $sql = $this->db->query("
            SELECT id, name FROM ref_paramedic_types WHERE active='yes'
        "
        );
        return $sql->result_array();
    }

    function GetDataParamedic() {
        $sql = $this->db->query("
            SELECT id, name FROM ref_paramedics WHERE active='yes'
        "
        );
        return $sql->result_array();
    }

    function GetDataContinue() {
        $sql = $this->db->query("
            SELECT * FROM ref_continue
        "
        );
        return $sql->result_array();
    }

    function GetDataDeliveryMethod() {
        $sql = $this->db->query("
            SELECT id, name FROM ref_delivery_methods WHERE active='yes'
        "
        );
        return $sql->result_array();
    }

    function GetDataPoedji() {
        $sql = $this->db->query("
            SELECT id, name FROM ref_poedji_rochjati WHERE (category='2' OR category='3') AND active='yes' AND id NOT IN(26,27)
        "
        );
        return $sql->result_array();
    }

    function DoAddDataPregnant() {
        $sql = true;
        $sql_family = true;
        $sql_disease = true;

        $cara_persalinan_sebelumnya = $this->input->post('cara_persalinan_sebelumnya');
        $cara_persalinan_buatan = $this->input->post('cara_persalinan_buatan');

        $medical_facilities_other = $this->input->post('medical_facilities_other');
        $medical_facilities_other_age = $this->input->post('medical_facilities_other_age');
        $medical_facilities_other_paramedic_type_id = $this->input->post('medical_facilities_other_paramedic_type_id');
        $medical_facilities_other_health_facility_id = $this->input->post('medical_facilities_other_health_facility_id');

        //UPDATE EXISTING DATA
        $sql = $this->db->query("
            INSERT INTO pregnants(
                visit_id, 
                g,
                p,
                a,
                hpht,
                htp,
                alive_child,
                dead_child,
                premature_child,
                married_year,
                childbirth_interval,
                delivery_method_id,
                lila,
                height,
                family_history_disease_other,
                history_disease_other,
                contraceptive_id,
                medical_facilities_other,
                medical_facilities_other_age,
                medical_facilities_other_paramedic_type_id,
                medical_facilities_other_health_facility_id
            ) 

            VALUES(
                ?,?,?,
                ?,?,?,
                ?,?,?,
                ?,?,?,
                ?,?,?,
                ?,?,?,
                IF('$medical_facilities_other' = 'no', NULL, '$medical_facilities_other_age'),
                IF('$medical_facilities_other' = 'no', NULL, '$medical_facilities_other_paramedic_type_id'),
                IF('$medical_facilities_other' = 'no', NULL, '$medical_facilities_other_health_facility_id')
            )
        ",
            array(
                $this->input->post('visit_id'),
                $this->input->post('g'),
                $this->input->post('p'),
                $this->input->post('a'),
                getYMD($this->input->post('hpht')),
                getYMD($this->input->post('htp')),
                $this->input->post('alive_child'),
                $this->input->post('dead_child'),
                $this->input->post('premature_child'),
                $this->input->post('married_year'),
                $this->input->post('childbirth_interval'),
                $this->input->post('delivery_method_id'),
                $this->input->post('lila'),
                $this->input->post('height'),
                $this->input->post('family_history_disease_other'),
                $this->input->post('history_disease_other'),
                $this->input->post('contraceptive_id'),
                $this->input->post('medical_facilities_other')
            )
        );
        $last_id = $this->db->insert_id();
        $family_history_disease = $_POST['family_history_disease'];
        $history_disease = $_POST['history_disease'];
        
        if($last_id) {
            $this->db->query("UPDATE pregnants SET log='yes' WHERE visit_id=? AND id<>?", 
                array($this->input->post('visit_id'), $last_id));

            $this->db->query("
            UPDATE 
                `visit_pregnants`
            SET 
                `pregnant_id`=? 
            WHERE 
                `pregnant_id` IN (SELECT id FROM pregnants WHERE visit_id=?)", 
                array(
                    $last_id,
                    $this->input->post('visit_id')
                    )
                );

        }
        
        if(!empty($family_history_disease)) {
            /*set log dilakukan oleh trigger pada tabel pregnants on update*/
            for($i=0;$i<sizeof($family_history_disease);$i++) {
                $arr_family[] = "('".$last_id."','".$family_history_disease[$i]."')";
            }
            $str_family = implode(",", $arr_family);
            $sql_family = $this->db->query("
                INSERT INTO `pregnant_family_history_diseases`(pregnant_id, family_history_disease_id)
                VALUES $str_family
            ");
        }
        if(!empty($history_disease)) {
            /*set log dilakukan oleh trigger pada tabel pregnants on update*/
            for($i=0;$i<sizeof($history_disease);$i++) {
                $arr_disease[] = "('".$last_id."','".$history_disease[$i]."')";
            }
            $str_disease = implode(",", $arr_disease);
            $sql_disease = $this->db->query("
                INSERT INTO `pregnant_history_diseases`(pregnant_id, history_disease_id)
                VALUES $str_disease
            ");
        }
        if($sql === TRUE) {
            return $this->db->query("UPDATE visits SET served='yes', paramedic_id=?, continue_id=? WHERE id=?", 
                array(
                    $this->input->post('paramedic_id'),
                    $this->input->post('continue_id'),
                    $this->input->post('visit_id')
                ));
        } else {
            return false;
        }
    }

    function DoAddPregnantPoedjiRochjati() {
        $pri = array();
        if($this->input->post('married_year') > 4) {
            $pri[] = 4;
        }
        if($this->input->post('childbirth_interval') < 2) {
            $pri[] = 6;
        } elseif($this->input->post('childbirth_interval') > 10) {
            $pri[] = 5;
        }
        if($this->input->post('alive_child') > 3) {
            $pri[] = 7;
        }
        if($this->input->post('height') < 145) {
            $pri[] = 8;
        }
        if($this->input->post('delivery_method_id') == 2) { //vacuum
            $pri[] = 10;
        } elseif($this->input->post('delivery_method_id') == 3) { //vacuum
            $pri[] = 11;
        } elseif($this->input->post('delivery_method_id') == 4) { //vacuum
            $pri[] = 12;
        } elseif($this->input->post('delivery_method_id') == 5) { //vacuum
            $pri[] = 13;
        }
        if(!empty($pri)) {
            for($i=0;$i<sizeof($pri);$i++) {
                $arrPri[] = "('".$this->input->post('pregnant_id')."', '" . $pri[$i] . "')";
            }
            $strPri = implode(", ", $arrPri);
            return $this->db->query("INSERT INTO pregnant_poedji_rochjati (pregnant_id, poedji_rochjati_id) VALUES $strPri");
        }
        return false;
    }

    function DoAddPregnantVisit() {
        //update, ke log : dilakukan oleh trigger
        $this->db->query("UPDATE `visit_pregnants` SET `log` ='yes' WHERE `visit_id`=? AND `pregnant_id`=?",
        array($this->input->post('visit_id'), $this->input->post('pregnant_id')));

        $sql = $this->db->query(
        "
        INSERT INTO visit_pregnants (
            visit_id, 
            pregnant_id,
            kunjungan_ke,
            age_of_pregnant,
            trimester,
            keluhan,
            weight,
            sistole,
            diastole,
            fundus_height,
            janin_position,
            janin_heartbeat,
            edema,
            hb,
            examination_special,
            examination_supplementary,
            fe,
            kapsul_minyak_beryodium,
            tt_immunization
        ) VALUES (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            NULLIF(?,''),
            NULLIF(?,''),
            NULLIF(?,''),
            NULLIF(?,''),
            NULLIF(?,'')
        )
        ",
        array(
            $this->input->post('visit_id'),
            $this->input->post('pregnant_id'),
            $this->input->post('kunjungan_ke'),
            $this->input->post('age_of_pregnant'),
            $this->input->post('trimester'),
            $this->input->post('keluhan'),
            $this->input->post('weight'),
            $this->input->post('sistole'),
            $this->input->post('diastole'),
            $this->input->post('fundus_height'),
            $this->input->post('janin_position'),
            $this->input->post('janin_heartbeat'),
            $this->input->post('edema'),
            $this->input->post('hb'),
            $this->input->post('examination_special'),
            $this->input->post('examination_supplementary'),
            $this->input->post('fe'),
            $this->input->post('kapsul_minyak_beryodium'),
            $this->input->post('tt_immunization')
            )
        );

        if($sql === TRUE) {
            $last_id = $this->db->insert_id();
            //update visit
            $sql_update_visit = $this->db->query("UPDATE visits SET served='yes', paramedic_id=?, continue_id=? WHERE id=?", 
                array(
                    $this->input->post('paramedic_id'),
                    $this->input->post('continue_id'),
                    $this->input->post('visit_id')
                ));

            //insert ke table visit_puji
            //insert default data
            $this->db->query("INSERT INTO visit_pregnant_poedji_rochjati (visit_pregnant_id, poedji_rochjati_id) VALUES(?, '001') ",
                array($last_id)
            );

            //if janin_position = sungsang || melintang, insert to poedji table
            if($this->input->post('janin_position') == 'Sungsang') {
                $this->db->query("
                INSERT INTO 
                    visit_pregnant_poedji_rochjati (visit_pregnant_id, poedji_rochjati_id)
                VALUES(?, '026') 
                ",
                array($last_id)
                );

            } elseif($this->input->post('janin_position') == 'Melintang') {
                $this->db->query("
                INSERT INTO 
                    visit_pregnant_poedji_rochjati (visit_pregnant_id, poedji_rochjati_id)
                VALUES(?, '027') 
                ",
                array($last_id)
                );
            }
            //if age
            if($this->input->post('age') < 16) {
                $this->db->query("
                INSERT INTO 
                    visit_pregnant_poedji_rochjati (visit_pregnant_id, poedji_rochjati_id)
                VALUES(?, '002') 
                ",
                array($last_id)
                );
            } elseif($this->input->post('age') > 35) {
                $this->db->query("
                INSERT INTO 
                    visit_pregnant_poedji_rochjati (visit_pregnant_id, poedji_rochjati_id)
                VALUES(?, '003') 
                ",
                array($last_id)
                );
            }

            $data = $_POST['poedji'];
            if(!empty($data)) {
                
                for($i=0;$i<sizeof($data);$i++) {
                    $arr_ins[] = " ('" . $last_id . "', '" .$data[$i]. "')";
                }
                $str_ins = implode(", ", $arr_ins);
                $sql_poedji = $this->db->query(
                "
                    INSERT INTO visit_pregnant_poedji_rochjati(
                        visit_pregnant_id,
                        poedji_rochjati_id
                    )
                    VALUES $str_ins
                "    
                );
                return $sql_poedji;
            } else {
                return $sql;
            }
        } else {
            return $sql;
        }
    }

    function GetCurrentDelivery($visitId, $pregnantId) {
        $sql = $this->db->query("
            SELECT 
                d.*,
                v.paramedic_id,
                v.continue_id
            FROM 
                deliveries d
                JOIN visits v ON(v.id = d.visit_id)
                JOIN newborn n ON(n.delivery_id = d.id)
            WHERE 
                v.id=? 
                AND d.pregnant_id=? 
                AND d.`log`='no' 
            ORDER BY d.id DESC 
            ", 
            array($visitId, $pregnantId));
            //echo $this->db->last_query();
        return $sql->result_array();
    }

    function GetCurrentNewborn($deliveryId) {
        $sql = $this->db->query("
            SELECT 
                *
            FROM 
                newborn
            WHERE 
                delivery_id=? 
                AND `log`='no' ", 
            array($deliveryId));
            //echo $this->db->last_query();
        return $sql->result_array();
    }

    
    function DoAddPregnantDelivery() {
        $arr_complication = $_POST['delivery_complication'];
        $str_complication = implode(",", $arr_complication);
        /*cek apakah ada data sebelumnya, klo ada set ke log*/
        $cek = $this->db->query("SELECT id FROM deliveries WHERE `pregnant_id`=? AND `log`='no' ORDER BY id DESC LIMIT 1", array($this->input->post('pregnant_id')));
        $cek_data = $cek->row_array();
        if(!empty($cek_data)) {
            $this->db->query("UPDATE `deliveries` SET `log`='yes' WHERE `id`=?", array($cek_data['id']));
            $this->db->query("UPDATE `newborn` SET `log`='yes' WHERE `delivery_id`=?", array($cek_data['id']));
        }
        $arr_date = explode("/", $this->input->post('date'));
        $arr_time = explode(":", $this->input->post('time'));
        $date = date('Y-m-d H:i:s', mktime($arr_time[0], $arr_time[1], 0, $arr_date[1], $arr_date[0], $arr_date[2]));

        $sql_delivery = $this->db->query("
            INSERT INTO deliveries(
                pregnant_id, 
                visit_id, 
                `date`, 
                age_of_pregnant,
                delivery_method_id, 
                delivery_complication, 
                post_partum_condition, 
                post_partum_abnormality) 
            VALUES(
                ?,
                ?,
                ?,
                ?,
                ?,
                (?),
                ?,
                ?
            )
        ", 
            array(
                $this->input->post('pregnant_id'),
                $this->input->post('visit_id'),
                $date,
                $this->input->post('age_of_pregnant'),
                $this->input->post('delivery_method_id'),
                $str_complication,
                $this->input->post('post_partum_condition'),
                $this->input->post('post_partum_abnormality')
        ));
        //echo $this->db->last_query();
        if($sql_delivery) {
            $delivery_id = $this->db->insert_id();
            $post = $_POST;
            if(!empty($post['newborn_name'])) {
                for($i=0;$i<sizeof($post['newborn_name']);$i++) {
                    //cek ke table pasien, apakah px sudah ada apa belum
                    $px = $this->db->query("SELECT id FROM patients WHERE id=?", array($post['newborn_patient_id'][$i]));
                    $data_px = $px->row_array();
                    if(!empty($data_px)) {
                        //update px
                        $this->db->query("
                        UPDATE 
                            patients 
                        SET 
                            name=?,
                            sex=?,
                            birth_date=?,
                            user_id=?
                        WHERE
                            id=?
                            AND family_folder=?
                            AND family_relationship_id=?
                        ",
                        array(
                            $post['newborn_name'][$i],
                            $post['newborn_sex'][$i][0],
                            getYMD($post['newborn_birth_date'][$i]),
                            $this->session->userdata('id'),
                            $post['newborn_patient_id'][$i],
                            $post['newborn_family_folder'][$i],
                            $post['newborn_family_relationship_id'][$i]
                        ));
                        $patient_id = $post['newborn_patient_id'][$i];
                    } else {
                        //insert px
                        $this->db->query("
                        INSERT INTO patients(
                            family_folder, 
                            family_relationship_id, 
                            name, 
                            sex, 
                            parent_name, 
                            birth_place, 
                            birth_date, 
                            address, 
                            village_id, 
                            education_id, 
                            job_id, 
                            user_id
                            ) 
                        SELECT
                            ?,
                            ?,
                            ?,
                            ?,
                            (SELECT name FROM patients WHERE family_folder=? AND family_relationship_id='01' LIMIT 1),
                            'Sleman',
                            ?,
                            (SELECT address FROM patients WHERE family_folder=? AND family_relationship_id='01' LIMIT 1),
                            (SELECT village_id FROM patients WHERE family_folder=? AND family_relationship_id='01' LIMIT 1),
                            '1',
                            '11',
                            ?
                        ",
                        array(
                            $post['newborn_family_folder'][$i],
                            $post['newborn_family_relationship_id'][$i],
                            $post['newborn_name'][$i],
                            $post['newborn_sex'][$i][0],
                            $post['newborn_family_folder'][$i],
                            $post['newborn_birth_date'][$i],
                            $post['newborn_family_folder'][$i],
                            $post['newborn_family_folder'][$i],
                            $this->session->userdata('id')
                        ));
                        $patient_id = $this->db->insert_id();
                    }

                    $sql_newborn = $this->db->query("
                    INSERT INTO newborn(
                        patient_id,
                        family_folder,
                        delivery_id, 
                        name,
                        birth_date, 
                        weight, 
                        height, 
                        head_circumstance,
                        sex, 
                        `condition`,
                        apgar_score, 
                        cause_of_death,
                        date_of_death,
                        early_breastfeeding
                        ) 
                    VALUES(
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        NULLIF(?, ''),
                        NULLIF(?, ''),
                        NULLIF(?, ''),
                        ?
                    )
                        ",
                    array(
                        $patient_id,
                        $post['newborn_family_folder'][$i],
                        $delivery_id,
                        $post['newborn_name'][$i],
                        getYMD($post['newborn_birth_date'][$i]),
                        $post['newborn_weight'][$i],
                        $post['newborn_height'][$i],
                        $post['newborn_head_circumstance'][$i],
                        $post['newborn_sex'][$i][0],
                        $post['newborn_condition'][$i][0],
                        $post['newborn_apgar_score'][$i],
                        $post['newborn_cause_of_death'][$i],
                        getYMD($post['newborn_date_of_death'][$i]),
                        $post['newborn_early_breastfeeding'][$i][0]
                    ));
                } //endfor
            } //endif
            
            $this->db->query("UPDATE visits SET served='yes', paramedic_id=?, continue_id=? WHERE id=?", 
                array(
                    $this->input->post('paramedic_id'),
                    $this->input->post('continue_id'),
                    $this->input->post('visit_id')
                ));
        } //endif
        return $sql_delivery;
    }
}
?>