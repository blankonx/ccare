<?php

Class Patient_Search extends Controller {
    
    var $offset = 10;
    var $js = array(); 

    function __construct() {
        parent::Controller();
        $this->load->model('admdata/Patient_Search_Model');
    }
    
    function index() {
        return $this->result($this->input->post('q') . '_' . $this->input->post('patient_search_district_id') . '_' . $this->input->post('patient_search_sub_district_id') . '_' . $this->input->post('patient_search_village_id'));
        //return $this->result();
    }

    function result($str_patient_search='', $start=0) {

		//$data['q'] = $q;
		$data['list'] = $this->Patient_Search_Model->getData($str_patient_search, $start, $this->offset);
		$data['total'] = $this->Patient_Search_Model->getCount();
		$data['start'] = $start;

		//print_r($data);
		$paging = array();
		$paging['base_url'] = base_url() . 'admdata/patient_search/result/' . $str_patient_search . '/';
		$paging['total_rows'] = $data['total'];
		$paging['uri_segment'] = 5;
		$paging['per_page'] = $this->offset;
		$paging['num_links'] = 5;

		$this->load->library('pagination', $paging);
		$links = $this->pagination->create_links();
        $cur_page = $this->pagination->cur_page;
        $total_rows = $this->pagination->total_rows;
        $total_pages = $this->pagination->total_pages;
        
		if($links) $data['links'] = $this->lang->line('label_page') . ' ' . $cur_page . ' of ' . $total_pages . ', Total : ' . $total_rows . ' data&nbsp;&nbsp;&nbsp;&nbsp;' . $links;
		else $data['links'] = '';
        $this->_view($data);
    }
    

    function patient_search_by_name($str_patient_search='', $start=0) {

		//$data['q'] = $q;
		$data['list'] = $this->Patient_Search_Model->patient_searchByName($str_patient_search, $start, $this->offset);
		$data['total'] = $this->Patient_Search_Model->getCount();
		$data['start'] = $start;

		//print_r($data);
		$paging = array();
		$paging['base_url'] = base_url() . 'admdata/patient_search/patient_search_by_name/' . $str_patient_search . '/';
		$paging['total_rows'] = $data['total'];
		$paging['uri_segment'] = 5;
		$paging['per_page'] = $this->offset;
		$paging['num_links'] = 5;

		$this->load->library('pagination', $paging);
		$links = $this->pagination->create_links();
        $cur_page = $this->pagination->cur_page;
        $total_rows = $this->pagination->total_rows;
        $total_pages = $this->pagination->total_pages;
        
		if($links) $data['links'] = $this->lang->line('label_page') . ' ' . $cur_page . ' of ' . $total_pages . ', Total : ' . $total_rows . ' data&nbsp;&nbsp;&nbsp;&nbsp;' . $links;
		else $data['links'] = '';
        $this->load->view('admdata/patient_search_by_name', $data);
    }
    
//VIEW//
    function _view($data = array()) {
        $this->load->view('admdata/patient_search', $data);
    }
}
