<?php

Class Checkup extends Controller {
    
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('kasir/Checkup_Model');
        //$this->load->model('admission/Rawatinap_Model'); 
        //$this->load->model('rawatinap/CheckupInap_Model');                       
    }
    
    function index() {
		$data = array();
        //return $this->result();
        $this->_view($data);
    }

    function result($visitId, $n) {
		$data['data'] = $this->Checkup_Model->GetData($visitId);
		//$data['module'] = $this->Checkup_Model->GetModule($visitId);
        $this->_view($data);
    }

//VIEW//
    function _view($data = array()) {
        $this->load->view('kasir/checkup', $data);
    }
}
