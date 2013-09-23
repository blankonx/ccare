<?php

Class Pasien extends Controller {
	var $offset = 10;
    var $js = array(); 

	var $title = '';
	var $report_title = 'Pasien Puskesmas';

	function __construct() {
		parent::Controller();
		if(!$this->session->userdata('id')) redirect('login');
		//$this->load->model('admission/Indoor_Model');   
		$this->load->model('rekammedis/Pasien_Model');     
		//$this->load->model('rekammedis/Pasien_Model');
		//$this->load->library('chartdirector');
		$this->title = $this->report_title;
	}
    
	function index($data="") {
        //return $this->result($this->input->post('search_name') . '_' . $this->input->post('search_category'));
        $data = array();
		$this->_view($data);	
    }

    function result($str_search='', $start=0) {
		$str_search = empty($str_search)?'_':$str_search;
		$data['list'] = $this->Pasien_Model->GetDataPasien($str_search, $start, $this->offset);
		$data['total'] = $this->Pasien_Model->getCount();
		$data['start'] = $start;

		//print_r($data);
		$paging = array();
		$paging['base_url'] = base_url() . 'rekammedis/pasien/result/' . $str_search . '/';
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
	
	function printout($title="") {
		$unit = $this->session->userdata('unit');
        $data['report_sub_title'] = 'Periode ' . tanggalIndo($this->session->userdata('year_start') . '-' . addExtraZero($this->session->userdata('month_start'),2) . '-01', 'F Y');
		
		$data['report_title'] = $this->report_title;
		$this->load->model('Xprofile_Model');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
		$data['report'] = $this->Pasien_Model->GetDataPasien_Print();
        $temp = $this->Pasien_Model->GetDrugDistribution_Print();
        $data['drug_out'] = $temp['drug_out'];
        $data['clinic'] = $temp['clinic'];
        
		//$data['report'] = $this->session->userdata('report');
		$this->load->view('_header_print_full_landscape', $data);
		$this->load->view('rekammedis/pasien_print', $data);
		$this->load->view('_footer_print_full_landscape');
	}
	
	function excel($title="") {
		$unit = $this->session->userdata('unit');
        $data['report_sub_title'] = 'Periode ' . tanggalIndo($this->session->userdata('year_start') . '-' . addExtraZero($this->session->userdata('month_start'),2) . '-01', 'F Y');
		
		$data['report_title'] = $this->report_title;
		$this->load->model('Xprofile_Model');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
		$data['report'] = $this->Pasien_Model->GetDataPasien_Print();
        $temp = $this->Pasien_Model->GetDrugDistribution_Print();
        $data['drug_out'] = $temp['drug_out'];
        $data['clinic'] = $temp['clinic'];
        
        header('Content-Type: application/vnd.pwg-xhtml-print+xml');
        header('Content-Disposition: inline; filename=' . underscore($this->report_title . '-' . $data["report_sub_title"]) . '.xls');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
		$this->load->view('rekammedis/pasien_excel', $data);
	}
	
	function pdf() {
		
	}
	
	function _view($data = array()) {
		$menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('_header', array('title' => $this->title, '_profile' => $profile['_profile']));
		$this->load->view('_menu', $menu);
		$this->load->view('rekammedis/pasien_list', $data);
		$this->load->view('_footer');
	}
}
