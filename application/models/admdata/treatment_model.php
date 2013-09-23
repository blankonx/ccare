<?php
Class Treatment_Model extends Model {

    function __construct() {
        parent::Model();
    }

//GET//
    function GetComboCategory() {
        $sql = $this->db->query("
            SELECT 
				id, name 
			FROM 
				ref_treatment_categories 
			ORDER BY 
				name"
        );
        return $sql->result_array();
    }
	
    function GetComboPaymentType() {
        $sql = $this->db->query("
            SELECT 
				id, name 
			FROM 
				ref_payment_types 
			ORDER BY 
				id"
        );
        return $sql->result_array();
    }
    
    function GetDataById() {
        $sql = $this->db->query("
        SELECT 
            rt.id as id,
            rt.treatment_category_id as treatment_category_id,
            rtp.id as ref_treatment_price_id,
            rt.name as name,
            rtp.payment_type_id as payment_type_id,
            rtp.price as price
        FROM 
            ref_treatments rt
            JOIN ref_treatment_price rtp ON (rtp.treatment_id = rt.id)
            JOIN ref_payment_types rpt ON (rpt.id = rtp.payment_type_id)
        WHERE
            treatment_id=?
        ORDER BY rpt.id
        ", array($this->input->post('id')));
        
       // echo $this->db->last_query();
        return $sql->result_array();
    }
	
	function DoDeleteData() {
        $delete_id = implode(",", $this->input->post('delete_id'));
		return $this->db->query("
			DELETE FROM
				ref_treatments 
			WHERE 
				id IN ($delete_id)"
		);
	}
	
	function DoAddData() {
        $this->db->trans_start();
		$sql = $this->db->query("
			INSERT INTO 
				ref_treatments (
					treatment_category_id, 
					name)
			VALUES(
				?,
				?)",
			array(
				$this->input->post('treatment_category_id'), 
				$this->input->post('name')
			)
		);
        $last_id = $this->db->insert_id();
        $price = $this->input->post('price');
        $payment_type_id = $this->input->post('payment_type_id');
        $ref_treatment_price_id = $this->input->post('ref_treatment_price_id');
        $payment_type_id = $this->input->post('payment_type_id');
        for($i=0;$i<sizeof($payment_type_id);$i++) {
            $x = $this->db->query("
            INSERT INTO 
                ref_treatment_price(treatment_id, payment_type_id, price) 
            VALUES(?, ?, ?)
            ", array(
            $last_id,
            $payment_type_id[$i],
            $price[$i]
            ));
        }
        return $this->db->trans_complete();
        //return $sql;
        $payment_type_id = $this->input->post('payment_type_id');
	}
	
	function DoUpdateData() {
        $this->db->trans_start();
		$sql = $this->db->query("
			UPDATE
				ref_treatments 
			SET 
				treatment_category_id=?, 
				name=?
			WHERE 
				id=?",
			array(
				$this->input->post('treatment_category_id'), 
				$this->input->post('name'),  
				$this->input->post('id')
			)
		);
		 //echo $this->db->last_query();
        //$last_id = $this->db->insert_id();
        $price = $this->input->post('price');
        $payment_type_id = $this->input->post('payment_type_id');
        $ref_treatment_price_id = $this->input->post('ref_treatment_price_id');
        $payment_type_id = $this->input->post('payment_type_id');
        
        for($i=0;$i<sizeof($payment_type_id);$i++) {
			if($ref_treatment_price_id[$i] == '') {
					
				$x = $this->db->query("
				INSERT INTO 
					ref_treatment_price (treatment_id, payment_type_id, price)
				VALUES (?,?,?)
				", array(
				$this->input->post('id'),
				$payment_type_id[$i],
				$price[$i]
				));
			} else {
				$x = $this->db->query("
				UPDATE 
					ref_treatment_price
				SET 
					price=?
				WHERE
					id=?
				", array(
				$price[$i],
				$ref_treatment_price_id[$i]
				));
			}
        }
       // print_r($ref_treatment_price_id[$i]);
       // echo $this->db->last_query();
        return $this->db->trans_complete();
        //return $sql;
	}
}
?>
