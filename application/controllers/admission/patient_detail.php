<?php

Class Patient_Detail extends Controller {
    
    var $offset = 10;
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('admission/Patient_Detail_Model');
    }
    
    function index() {
        //return $this->result();
    }

    function result($admission_id) {
		$data['data'] = $this->Patient_Detail_Model->GetData($admission_id);
		$age = getAge($data['data']['birth_date'], $data['data']['admission_date']);    
		$data['data']['age'] = $age;

        $this->_view($data);
    }

//VIEW//
    function _view($data = array()) {
        $this->load->view('admission/patient_detail', $data);
    }
}
