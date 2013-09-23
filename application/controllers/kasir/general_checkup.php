<?php

Class General_Checkup extends Controller {
    
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('kasir/General_Checkup_Model');
    }
    
    function index() {
		$data = array();
        //return $this->result();
        $this->_view($data);
    }

    function home($visitId, $mode='',$n=0) {
        return $this->result($visitId, $mode, $n);
    }

    function result($visit_id,$mode='',$n=0) {
		$data['data'] = $this->General_Checkup_Model->GetData($visit_id);
		$age = getAge($data['data']['birth_date'], $data['data']['visit_date']);    
		$data['data']['age'] = $age;
		$data['treatments'] = $this->General_Checkup_Model->GetDataTreatments($visit_id);
        $data['total'] = $this->General_Checkup_Model->GetTotal($visit_id);
        $this->_view($data);
    }
    
    function get_total($visitId) {
        $total = $this->General_Checkup_Model->GetTotal($visitId);
        echo 'Rp. ' . uangIndo($total) . '<br/>Terbilang : <em>' . terbilang($total) . ' rupiah</em>';
    }
	
	function printout($visitId, $title="") {
		$this->load->model('xProfile_Model');
		$data['profile'] = $this->xProfile_Model->GetProfile();
		
		$data['patient'] = $this->General_Checkup_Model->GetDataPatient($visitId);
		$data['treatments'] = $this->General_Checkup_Model->GetDataTreatmentsForPrint($visitId);
		
		$this->load->view('kasir/general_checkup_print', $data);
	}

    function delete_prescribe() {
		$ret['command'] = "deleting data";
		if($this->General_Checkup_Model->DoDeletePrescribe()) {
			$ret['msg'] = $this->lang->line('msg_delete');
			$ret['status'] = "success";
		} else {
			$ret['msg'] = $this->lang->line('msg_error_delete');
			$ret['status'] = "error";
		}
		echo json_encode($ret);
    }
    
    function delete_treatment() {
		$ret['command'] = "deleting data";
		if($this->General_Checkup_Model->DoDeleteTreatment()) {
			$ret['msg'] = $this->lang->line('msg_delete');
			$ret['status'] = "success";
		} else {
			$ret['msg'] = $this->lang->line('msg_error_delete');
			$ret['status'] = "error";
		}
		echo json_encode($ret);
    }

    function delete_prescribe_mix() {
		$ret['command'] = "deleting data";
		if($this->General_Checkup_Model->DoDeletePrescribeMix()) {
			$ret['msg'] = $this->lang->line('msg_delete');
			$ret['status'] = "success";
		} else {
			$ret['msg'] = $this->lang->line('msg_error_delete');
			$ret['status'] = "error";
		}
		echo json_encode($ret);
    }

    function process_form() {
		$ret = array();
		$ret['command'] = "adding data";
        //print_r($this->input->post('icd_id'));
		if($this->General_Checkup_Model->DoAddData()) {
			$ret['msg'] = $this->lang->line('msg_save');
			$ret['status'] = "success";
		} else {
			$ret['msg'] = $this->lang->line('msg_error_save');
			$ret['status'] = "error";
		}
		echo json_encode($ret);
    }

//VIEW//
    function _view($data = array()) {
        $this->load->view('kasir/general_checkup', $data);
    }
}
