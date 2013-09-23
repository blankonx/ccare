<?php

Class Rawatinap_Checkup extends Controller {
    
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('visit/Rawatinap_Checkup_Model');
        //$this->load->model('admission/Rawatinap_Model'); 
        //$this->load->model('rawatinap/Rawatinap_CheckupInap_Model');                       
    }
    
    function index() {
		$data = array();
        //return $this->result();
        $this->_view($data);
    }

    function result($visitId, $visit_inpatient_clinic_id) {
		$data['data'] = $this->Rawatinap_Checkup_Model->GetData($visitId);
		$data['module'] = $this->Rawatinap_Checkup_Model->GetModule($visitId);
		$this->_view($data);
    }
	
    function _view($data = array()) {
        $this->load->view('visit/rawatinap_checkup', $data);
    }
	
}
