<?php

Class Medical_Certificate extends Controller {
    
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('visit/Medical_Certificate_Model');
    }
    
    function index() {
        return $this->home();
    }

    function home($visitId) {
		$data['data'] = $this->Medical_Certificate_Model->GetData($visitId);
		$age = getAge($data['data']['birth_date'], $data['data']['visit_date']);    
		$data['data']['age'] = $age;

        $data['doctor'] = $this->Medical_Certificate_Model->GetDataDoctor();
		$data['mc_explanation'] = $this->Medical_Certificate_Model->GetDataExplanation();
        $this->_view($data);
    }

    function lists($visitId, $limit=0) {
        $this->load->library('pagination');
		$data['list'] = $this->Medical_Certificate_Model->GetList($visitId, $limit, 5);
        
        /*paging start*/
        $paging['base_url'] = site_url('visit/medical_certificate/lists/' . $visitId . '/');
        $paging['base_url'] = base_url() . 'visit/medical_certificate/lists/' . $visitId . '/';
        $paging['total_rows'] = $this->Medical_Certificate_Model->GetCount();
        $paging['per_page'] = 5;
        $paging['uri_segment'] = 5;
        $paging['num_links'] = 5;
        $this->pagination->initialize($paging);
        
        if($this->pagination->create_links())
            $data['links'] = $this->pagination->create_links();
        else $data['links'] = '';
        //print_r($data);
        $this->load->view('visit/medical_certificate_lists', $data);
        //$this->_view($data);
    }

    function process_form_mc() {
		$ret = array();
		$ret['command'] = "adding data";
        $last_id = $this->Medical_Certificate_Model->DoAddDataMedicalCertificate();
        //echo $last_id;
		if($last_id > 0) {
			$ret['msg'] = $this->lang->line('msg_save');
			$ret['status'] = "success";
			$ret['last_id'] = $last_id;
		} else {
			$ret['msg'] = $this->lang->line('msg_error_save');
			$ret['status'] = "error";
			$ret['last_id'] = "0";
		}
		echo json_encode($ret);
    }

    function detail($mcId) {
		$data['detail'] = $this->Medical_Certificate_Model->GetDetail($mcId);
        //print_r($data);
        $this->load->view('visit/medical_certificate_detail', $data);
    }

    function prints($mcId) {
		$data['detail'] = $this->Medical_Certificate_Model->GetDetail($mcId);
		$this->load->model('Xprofile_Model');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
        //$this->load->view('_header_print_full', $data);
        $this->load->view('visit/medical_certificate_prints', $data);
        //$this->load->view('_footer_print_full');
    }
/*
    function form($visitId) {
        $data['doctor'] = $this->Medical_Certificate_Model->GetDataDoctor();
        $data['medical_certificate_explanation'] = $this->Medical_Certificate_Model->GetDataMedicalCertificateExplanation();

        return $this->_view($data);
    }
*/
//VIEW//
    function _view($data = array()) {
        $this->load->view('visit/medical_certificate', $data);
    }
}
