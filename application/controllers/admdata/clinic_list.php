<?php

Class Clinic_List extends Controller {
    
    var $offset = 10;
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('admdata/Clinic_List_Model');
    }
    
    function index() {
        return $this->result(0, $this->input->post('search_name'));
    }

    function result($start=0, $str_search='') {

		//$data['q'] = $q;
		$data['list'] = $this->Clinic_List_Model->getData($str_search, $start, $this->offset);
		$data['total'] = $this->Clinic_List_Model->getCount();
		$data['start'] = $start;

		//print_r($data);
		$paging = array();
		if(trim($str_search) == '') {
			$paging['base_url'] = base_url() . 'admdata/clinic_list/result/';
			$paging['uri_segment'] = 4;
		} else {
			$paging['base_url'] = base_url() . 'admdata/clinic_list/result/' . $str_search . '/';
			$paging['uri_segment'] = 5;
		}
		$paging['total_rows'] = $data['total'];
		$paging['per_page'] = $this->offset;
		$paging['num_links'] = 2;

		$this->load->library('pagination', $paging);
		$links = $this->pagination->create_links();
        $cur_page = $this->pagination->cur_page;
        $total_rows = $this->pagination->total_rows;
        $total_pages = $this->pagination->total_pages;
		$data['current_page'] = $start;
        
		if($links) $data['links'] = $this->lang->line('label_page') . ' ' . $cur_page . ' of ' . $total_pages . ', Total : ' . $total_rows . ' data&nbsp;&nbsp;&nbsp;&nbsp;' . $links;
		else $data['links'] = '';
        $this->_view($data);
    }

//VIEW//
    function _view($data = array()) {
        $this->load->view('admdata/clinic_list', $data);
    }
}
