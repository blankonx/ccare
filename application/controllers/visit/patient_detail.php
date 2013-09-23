<?php

Class Patient_Detail extends Controller {
    
    var $offset = 10;
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('visit/Patient_Detail_Model');
    }
    
    function index() {
        //return $this->result();
    }

    function result($visit_id) {
		$data['data'] = $this->Patient_Detail_Model->GetData($visit_id);
		$age = getAge($data['data']['birth_date'], $data['data']['visit_date']);    
		$data['data']['age'] = $age;

        $this->_view($data);
    }

//VIEW//
    function _view($data = array()) {
        $this->load->view('visit/patient_detail', $data);
    }
}
