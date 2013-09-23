<?php

Class Sickness_Explanation extends Controller {
    
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('visit/Sickness_Explanation_Model');
    }
    
    function index() {
        return $this->home();
    }

    function home($visitId) {
		$data['data'] = $this->Sickness_Explanation_Model->GetData($visitId);
		$age = getAge($data['data']['birth_date'], $data['data']['visit_date']);    
		$data['data']['age'] = $age;

        $data['doctor'] = $this->Sickness_Explanation_Model->GetDataDoctor();
        $this->_view($data);
    }

    function lists($visitId, $limit=0) {
        $this->load->library('pagination');
		$data['list'] = $this->Sickness_Explanation_Model->GetList($visitId, $limit, 5);
        
        /*paging start*/
        $paging['base_url'] = site_url('visit/sickness_explanation/lists/' . $visitId . '/');
        $paging['base_url'] = base_url() . 'visit/sickness_explanation/lists/' . $visitId . '/';
        $paging['total_rows'] = $this->Sickness_Explanation_Model->GetCount();
        $paging['per_page'] = 5;
        $paging['uri_segment'] = 5;
        $paging['num_links'] = 5;
        $this->pagination->initialize($paging);
        
        if($this->pagination->create_links())
            $data['links'] = $this->pagination->create_links();
        else $data['links'] = '';
        //print_r($data);
        $this->load->view('visit/sickness_explanation_lists', $data);
    }

    function process_form_se() {
		$ret = array();
		$ret['command'] = "adding data";
        $last_id = $this->Sickness_Explanation_Model->DoAddDataSicknessExplanation();
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

    function detail($seId) {
		$data['detail'] = $this->Sickness_Explanation_Model->GetDetail($seId);
        //print_r($data);
        $this->load->view('visit/sickness_explanation_detail', $data);
    }

    function prints($seId) {
		$data['detail'] = $this->Sickness_Explanation_Model->GetDetail($seId);
		$this->load->model('Xprofile_Model');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
        $this->load->view('visit/sickness_explanation_prints', $data);
    }
/*
    function form($visitId) {
        $data['doctor'] = $this->Sickness_Explanation_Model->GetDataDoctor();
        $data['sickness_explanation_explanation'] = $this->Sickness_Explanation_Model->GetDataMedicalCertificateExplanation();

        return $this->_view($data);
    }
*/
//VIEW//
    function _view($data = array()) {
        $this->load->view('visit/sickness_explanation', $data);
    }
}
