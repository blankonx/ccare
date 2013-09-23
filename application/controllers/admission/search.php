<?php

Class Search extends Controller {
    
    var $offset = 10;
    var $js = array(); 

    function __construct() {
        parent::Controller();
        $this->load->model('admission/Search_Model');
    }
    
    function index() {
        return $this->result($this->input->post('q'));
        //return $this->result();
    }

    function result($str_search='', $start=0) {

		//$data['q'] = $q;
		$data['list'] = $this->Search_Model->getData($str_search, $start, $this->offset);
		$data['total'] = $this->Search_Model->getCount();
		$data['start'] = $start;

		//print_r($data);
		$paging = array();
		$paging['base_url'] = base_url() . 'admission/search/result/' . $str_search . '/';
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
    

     function search_by_name() {
		//$data['q'] = $q;
		$data = $this->Search_Model->searchByName();
        for($i=0;$i<sizeof($data);$i++) {
            echo $data[$i]['family_folder'] . "|" . $data[$i]['name'] . "|" . $data[$i]['sex'] . "|" . getOneAge($data[$i]['birth_date']) . "|" . $data[$i]['address'] . "\n";
        }
    }
    
//VIEW//
    function _view($data = array()) {
        $this->load->view('admission/search', $data);
    }
}
