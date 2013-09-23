<?php

Class Daftar_Pasien_List extends Controller {
    
    var $offset = 200;
    var $js = array(); 

    function __construct() {
        parent::Controller();
        //if(!$this->session->icddata('id')) redirect('login');
        $this->load->model('rekammedis/Daftar_Pasien_List_Model');
    }
    
   function index() {
        return $this->result($this->input->post('search_name') . '_' . $this->input->post('search_category'));
        
    }
      
   
    function result($str_search='', $start=0) {
		$str_search = empty($str_search)?'_':$str_search;
		$data['list'] = $this->Daftar_Pasien_List_Model->GetData($str_search, $start, $this->offset);
		$data['total'] = $this->Daftar_Pasien_List_Model->getCount();
		$data['start'] = $start;

		//print_r($data);
		$paging = array();
		$paging['base_url'] = base_url() . 'rekammedis/daftar_pasien_list/result/' . $str_search . '/';
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
        $this->_view($data);
    }    
    
   function excel() {
	    $str_search = empty($str_search)?'_':$str_search;
		$data['list'] = $this->Daftar_Pasien_List_Model->GetDataexcel($str_search, $start, $this->offset);
		$data['total'] = $this->Daftar_Pasien_List_Model->getCount();
		$data['start'] = $start;

		//print_r($data);
		$paging = array();
		$paging['base_url'] = base_url() . 'rekammedis/daftar_pasien_list/excel/' . $str_search . '/';
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
        
        header('Content-Type: application/vnd.pwg-xhtml-print+xml');
        header('Content-Disposition: inline; filename=Daftar_Pasien.xls');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
		$this->_view($data);
    }    

//VIEW//
    function _view($data = array()) {
        $this->load->view('rekammedis/daftar_pasien_list', $data);
        
    }
       
}
