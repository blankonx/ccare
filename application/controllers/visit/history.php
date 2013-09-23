<?php

Class History extends Controller {
    
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('visit/History_Model');
    }
    
    function index($visitId) {
        return $this->lists($visitId);
    }

    function home($visitId) {
        $data['latest'] = $this->History_Model->GetLatestVisit($visitId);
        $data['data']['visit_id'] = $visitId;
        $data['anamnese_diagnose'] = array_unique(explode('|', $data['latest']['anamnese_diagnose']));
        $data['treatment'] = array_unique(explode('|', $data['latest']['treatment']));
        $data['prescribe'] = array_unique(explode('|', $data['latest']['prescribe']));
        $this->_view($data);
    }

    function lists($visitId, $limit=1) {
        $this->load->library('pagination');

		$data['history'] = $this->History_Model->GetListVisit($visitId, $limit, 5);
        
        /*paging start*/
        $paging['base_url'] = site_url('visit/history/lists/' . $visitId . '/');
        $paging['base_url'] = base_url() . 'visit/history/lists/' . $visitId . '/';
        $paging['total_rows'] = $this->History_Model->GetCount();
        $paging['per_page'] = 5;
        $paging['uri_segment'] = 5;
        $paging['num_links'] = 5;
        $this->pagination->initialize($paging);
        
        if($this->pagination->create_links())
            $data['links'] = $this->pagination->create_links();
        else $data['links'] = '';
        

        //echo $this->pagination->create_links();

        $this->load->view('visit/history_lists', $data);
    }

    function detail($visitId) {
        /*PAGING DAB*/
		$data['detail'] = $this->History_Model->GetDetailVisit($visitId);
        $data['anamnese_diagnose'] = array_unique(explode('|', $data['detail']['anamnese_diagnose']));
        $data['treatment'] = array_unique(explode('|', $data['detail']['treatment']));
        $data['prescribe'] = array_unique(explode('|', $data['detail']['prescribe']));

        //print_r($data);
        $this->load->view('visit/history_detail', $data);
    }

//VIEW//
    function _view($data = array()) {
        $this->load->view('visit/history', $data);
    }
}
