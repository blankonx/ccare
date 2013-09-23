<?php
Class Dinas2 extends Controller {
	var $title = 'Download Data';
	var $report_title = 'Download Data';

	function __construct() {
		parent::Controller();
		if(!$this->session->userdata('id')) redirect('login');
		$this->load->model('report/Dinas2_Model');
		//$this->load->library('zip');
	}
    
	function index($data="") {
		$data = array();
		$this->_view($data);	      	
	}
	
	function process_form() {
		$this->load->helper('download');
		$data = $this->Dinas2_Model->GetReport();
		$xdata = "";
		for($i=0;$i<sizeof($data);$i++) {
			$xdata .= implode(";", $data[$i]) . "\n";
		}
		//echo "as";
		force_download('Report-Dinas.csv', $xdata);
		//echo "as";
	}
	
	function _view($data = array()) {
		$menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('_header', array('title' => $this->title, '_profile' => $profile['_profile']));
		$this->load->view('_menu', $menu);
		$this->load->view('report/dinas2', $data);
		$this->load->view('_footer');
	}
}
