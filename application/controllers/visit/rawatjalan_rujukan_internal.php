<?php

Class Rawatjalan_Rujukan_Internal extends Controller {
    
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('visit/Rawatjalan_Rujukan_Internal_Model');                     
    }
    
    function index() {
		$data = array();
        //return $this->result();
        $this->_view($data);
    }

    function result($visitId) {
		$data['data'] = $this->Rawatjalan_Rujukan_Internal_Model->GetData($visitId);
		$this->_view($data);
    }
	
    function _view($data = array()) {
        $this->load->view('visit/rawatjalan_rujukan_internal', $data);
    }
	
}
