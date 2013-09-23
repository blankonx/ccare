<?php

Class Rujukan_Internal extends Controller {
    
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('visit/Rujukan_Internal_Model');
    }
    
    function index() {
        return $this->home();
    }
	
	function home() {}

    function result($visitId) {
		$data = array();
		$data['combo_clinic'] = $this->Rujukan_Internal_Model->GetComboClinics();
		$data['data']['visit_id'] = $visitId;
        $this->_view($data);
    }

    function process_form_pr() {
		$ret = array();
		$ret['command'] = "adding data";
		if(true === $this->Rujukan_Internal_Model->DoAddRujukanInternal()) {
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
        $this->load->view('visit/rujukan_internal', $data);
    }
}
