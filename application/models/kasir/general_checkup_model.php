<?php
Class General_Checkup_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
	function GetDataPatient($visitId) {
		//get the current selected data
		$sql = $this->db->query("
			SELECT
				p.`family_folder` as `mr_number`,
				p.`name`,
				p.`birth_place`,
				p.`sex` as `sex`,
				p.birth_date as `birth_date`, 
				v.`date` as `visit_date`, 
				DATE_FORMAT(v.`date`, '%d-%m-%Y') as `visit_date_formatted`, 
				v.`address` as `address`,
				rpt.name as payment_type,
                v.continue_id as continue_id,
                v.continue_to as continue_to
			FROM 
				`patients` p
				JOIN `visits` v ON (v.`family_folder` = p.`family_folder`)
				JOIN `ref_payment_types` rpt ON  (rpt.id = v.payment_type_id)
			WHERE
				v.`id`=?
		",
			array($visitId)
		);
		return $sql->row_array();
	}
	
	function GetData($visit_id) {
		//get the current selected data
		$sql = $this->db->query("
			SELECT
                v.`id` as `visit_id`,
				p.`family_folder` as `mr_number`,
				p.`name`,
				p.`birth_place`,
				p.`sex` as `sex`,
				DATE_FORMAT(p.`birth_date`, '%d/%m/%y') as `birth_date`, 
				v.`date` as `visit_date`,
				v.`address` as `address`,
				v.`continue_id` as `continue_id`,
                v.`continue_to` as `continue_to`,
                (
                    SELECT COUNT(*) 
                    FROM 
                        `visits` 
                    WHERE 
                        `family_folder`=(SELECT `family_folder` FROM `visits` WHERE `id`=?) 
                        AND `id` <=? 

                ) as `visit_count`,
                v.`served`,
                pay.paid as paid
			FROM 
				`patients` p
				JOIN `visits` v ON (v.`family_folder` = p.`family_folder`)
				LEFT JOIN payments pay ON (pay.visit_id = v.id)
			WHERE
				v.`id`=?
            GROUP BY v.id
		",
			array(
                $visit_id,
                $visit_id,
                $visit_id,
                $visit_id
            )
		);
		return $sql->row_array();
	}

    function GetDataTreatments($visit_id) {
        $sql = $this->db->query("
            SELECT 
                `id` as id, 
                treatment_id,
                `name` as `name`, 
                `cost` as `price`,
                CASE
                    WHEN paid='no' THEN `cost`
                ELSE `pay` END as `pay`
            FROM 
                payments
            WHERE `visit_id` = ?
        ",
            array($visit_id)
        );
        return $sql->result_array();
    }

    function GetDataTreatmentsForPrint($visit_id) {
        $sql = $this->db->query("
            SELECT 
                `id` as id, 
                treatment_id,
                `name` as `name`, 
                pay as pay
            FROM 
                payments
            WHERE `visit_id` = ?
        ",
            array($visit_id)
        );
        return $sql->result_array();
    }
    
    function GetTotal($visitId) {
        $sql = $this->db->query("SELECT SUM(pay) as total FROM payments WHERE visit_id=?", array($visitId));
        $data = $sql->row_array();
        return $data['total'];
    }
    
    function DoAddTreatments() {
        //insert the treatments
        $arr_treatment_id = $this->input->post('treatment_id');
        $arr_cost = $this->input->post('treatment_price');
        $arr_treatment = $this->input->post('treatment_name');
        $arr_pay = $this->input->post('treatment_pay');
        //print_r($arr_treatment_id);
        for($i=0;$i<sizeof($arr_treatment_id);$i++) {
            if($arr_treatment_id[$i] && $arr_treatment_id!='') {
                //$xarr_treatment_id[] = $arr_treatment_id[$i];
                $ins = $this->db->query("
                    INSERT INTO `treatments` (`visit_id`, `treatment_id`, `name`, `cost`, `date`) 
                    SELECT ?, `id`, ?, ?, NOW() FROM `ref_treatments` WHERE `id`=?
                ",
                array($this->input->post('visit_id'), $arr_treatment[$i], $arr_cost[$i], $arr_treatment_id[$i])
                );
                if(true === $ins) {
                    $treatment_id = $this->db->insert_id();
                    //insert into payments dab
                    $this->db->query("
                        INSERT INTO payments(
                            visit_id,
                            cost_type_id,
                            treatment_id,
                            payment_type_id,
                            name,
                            cost,
                            pay,
                            paid,
                            user_id
                        ) 
                        SELECT 
                            id,
                            '002',
                            ?,
                            payment_type_id,
                            ?,
                            ?,
                            ?,
                            'yes',
                            ?
                        FROM
                            visits
                        WHERE
                            id=?
                        ", array(
                            $treatment_id,
                            $arr_treatment[$i],
                            $arr_cost[$i], 
                            $arr_pay[$i], 
                            $this->session->userdata('id'),
                            $this->input->post('visit_id')
                        ));
                }
                //echo $this->db->last_query();
            }
        }
        return $ins;
    }

    
    function DoUpdateTreatments() {
        //insert the treatments
        $arr_payment_saved_id = $this->input->post('payment_saved_id');
        $arr_pay = $this->input->post('pay_saved');
        //print_r($arr_treatment_id);
        for($i=0;$i<sizeof($arr_payment_saved_id);$i++) {
            if($arr_payment_saved_id[$i] && $arr_payment_saved_id[$i]!='') {
                $treatment_id = $this->db->insert_id();
                //insert into payments dab
                $this->db->query("
                    UPDATE payments SET
                    pay=?,
                    paid='yes',
                    user_id=?
                    WHERE
                        id=?
                    ", array(
                        $arr_pay[$i],
                        $this->session->userdata('id'),
                        $arr_payment_saved_id[$i]
                    ));
            }
        }
        return $ins;
    }


//DO
    function DoAddData() {
        $this->DoAddTreatments();
        $this->DoUpdateTreatments();
        return true;
    }
}
?>
