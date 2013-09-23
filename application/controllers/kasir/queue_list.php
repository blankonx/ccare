<?php

Class Queue_List extends Controller {
    
    var $offset = 20;
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('kasir/Queue_List_Model');
    }
    
    function index() {
        return $this->result($this->input->post('search_name') . '_' . $this->input->post('search_show_served') . '_' . str_replace("/", "-", $this->input->post('visit_date_start')) . '_' . str_replace("/", "-", $this->input->post('visit_date_end')) . "/" . $this->input->post('xcurrent_page'));
    }

    function result($str_search='', $start=0) {

		$data['list'] = $this->Queue_List_Model->getData($str_search, $start, $this->offset);
		$data['total'] = $this->Queue_List_Model->getCount();
		$data['start'] = $start;

		//print_r($data);
		$paging = array();
		$paging['base_url'] = base_url() . 'kasir/queue_list/result/' . $str_search . '/';
		$paging['total_rows'] = $data['total'];
		$paging['uri_segment'] = 5;
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
        //print_r($data);
        $this->_view($data);
    }

//VIEW//
    function _view($data = array()) {
        $this->load->view('kasir/queue_list', $data);
    }
}
