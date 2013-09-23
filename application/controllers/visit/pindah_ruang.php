<?php

Class Pindah_Ruang extends Controller {
    
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('visit/Pindah_Ruang_Model');
    }
    
    function index() {
        return $this->home();
    }
	
	function home() {}

    function result($visitInpatientId, $visitInpatientClinicId) {
		/*data pemulangan*/
		$data = array();
		$data['inpatient_clinic'] = $this->Pindah_Ruang_Model->GetComboClinic();
		$data['data']['visit_inpatient_id'] = $visitInpatientId;
		$data['data']['visit_inpatient_clinic_id'] = $visitInpatientClinicId;
        $this->_view($data);
    }

    function process_form_pr() {
		$ret = array();
		$ret['command'] = "adding data";
		if(true === $this->Pindah_Ruang_Model->DoAddPindahRuang()) {
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
        $this->load->view('visit/pindah_ruang', $data);
    }
}
