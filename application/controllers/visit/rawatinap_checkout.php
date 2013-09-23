<?php

Class Rawatinap_Checkout extends Controller {
    
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('visit/Rawatinap_Checkout_Model');
        //$this->load->model('admission/Rawatinap_Model'); 
        //$this->load->model('rawatinap/Rawatinap_CheckoutInap_Model');                       
    }
    
    function index() {
		$data = array();
        //return $this->result();
        $this->_view($data);
    }

    function result($visitInpatientId, $visit_inpatient_clinic_id) {
		$data['data'] = $this->Rawatinap_Checkout_Model->GetData($visitInpatientId);
		//$data['module'] = $this->Rawatinap_Checkout_Model->GetModule($visitId);
		$this->_view($data);
    }
	
    function _view($data = array()) {
        $this->load->view('visit/rawatinap_checkout', $data);
    }
	
}
