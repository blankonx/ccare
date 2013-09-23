<?php

Class Checkout extends Controller {
    
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('visit/Checkout_Model');
    }
    
    function index() {
        return $this->home();
    }
	
	function home() {}

    function result($visitInpatientId, $visitInpatientClinicId) {
		/*data pemulangan*/
		$data = array();
		$data['keadaan_keluar'] = $this->Checkout_Model->GetComboKeadaanKeluar();
		$data['cara_keluar'] = $this->Checkout_Model->GetComboCaraKeluar();
		$data['data']['visit_inpatient_id'] = $visitInpatientId;
		$data['data']['visit_inpatient_clinic_id'] = $visitInpatientClinicId;
        $this->_view($data);
    }

    function process_form_ck() {
		$ret = array();
		$ret['command'] = "adding data";
		if(true === $this->Checkout_Model->DoAddPemulanganPasien()) {
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
        $this->load->view('visit/checkout', $data);
    }
}
