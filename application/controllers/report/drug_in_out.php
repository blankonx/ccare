<?php

Class Drug_In_Out extends Controller {
	var $title = '';
	var $report_title = 'Daftar Obat Masuk - Keluar';

	function __construct() {
		parent::Controller();
		if(!$this->session->userdata('id')) redirect('login');
		//$this->load->model('admission/Indoor_Model');   
		$this->load->model('report/Drug_In_Out_Model');     
		//$this->load->model('report/Drug_In_Out_Model');
		//$this->load->library('chartdirector');
		$this->title =$this->lang->line('label_report')." &raquo;" . $this->report_title;
	}
    
	function index($data="") {
		$data = array();
		//$data['combo_clinic'] = $this->Drug_In_Out_Model->GetComboClinics(); 	
		$this->_view($data);	      	
	}
	
	function process_form() {
		$unit = $this->input->post('unit');
		//$region = $this->input->post('region');
		
		switch($unit) {
			case "all" :
				$data['report_sub_title'] = ' ';
			break;
			case "year" :
				$data['report_sub_title'] = 'Periode ' . $this->input->post('year_start') . ' - ' . $this->input->post('year_end');
			break;
			case "month" :
				$data['report_sub_title'] = 'Periode ' . tanggalIndo($this->input->post('year_start') . '-' . addExtraZero($this->input->post('month_start'),2) . '-01', 'F Y') . ' - ' . tanggalIndo($this->input->post('year_end') . '-' . addExtraZero($this->input->post('month_end'),2) . '-01', 'F Y');
			break;
			default:
				$data['report_sub_title'] = 'Periode ' . tanggalIndo($this->input->post('year_start') . '-' . addExtraZero($this->input->post('month_start'),2) . '-' . addExtraZero($this->input->post('day_start'), 2), 'j F Y') . ' - ' . tanggalIndo($this->input->post('year_end') . '-' . addExtraZero($this->input->post('month_end'),2) . '-' . addExtraZero($this->input->post('day_end'),2), 'j F Y');
			break;
		}
		
		$data['report_title'] = $this->report_title;
		
		/*CHART BEGIN*/
		//$param = array("Pie3D", 700, 300, 'Drug_In_OutChart');
		//$this->load->library('chart', $param);
		$data['chart'] = $this->Drug_In_Out_Model->GetDataDrug_In_OutForChart();
		
		//SET SESSION FOR PRINT OUT
		$this->session->set_userdata('report', $data);

		//for($i=0;$i<sizeof($data['chart']);$i++) {
		//	$this->chart->addChartData($data['chart'][$i]['count'], "label=" . $data['chart'][$i]['name']);
		//}
		/*CHART END*/
        $this->load->view('report/drug_in_out_list', $data);
	}
	
	function printout($title="") {
		$this->load->model('Xprofile_Model');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
		$data['report'] = $this->session->userdata('report');
		$this->load->view('_header_print_full', $data);
		$this->load->view('report/drug_in_out_print', $data);
		$this->load->view('_footer_print_full');
	}
	
	function pdf() {
		
	}
	
	function _view($data = array()) {
		$menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('_header', array('title' => $this->title, '_profile' => $profile['_profile']));
		$this->load->view('_menu', $menu);
		$this->load->view('report/drug_in_out', $data);
		$this->load->view('_footer');
	}
	
	function _setLabel($date, $unit) {
		switch($unit) {
			case "year" :
				return $date;
			break;
			case "month" :
				$arrdate['year'] = substr($date, 0, 4);
				$arrdate['month'] = substr($date, 4, 2);
				$concat_date = $arrdate['year'] . '-' . $arrdate['month'] . '-01';
				return tanggalIndo($concat_date, 'M y');
			break;
			default :
				$arrdate['year'] = substr($date, 0, 4);
				$arrdate['month'] = substr($date, 4, 2);
				$arrdate['day'] = substr($date, 6, 2);
				$concat_date = $arrdate['year'] . '-' . $arrdate['month'] . '-' . $arrdate['day'];
				return tanggalIndo($concat_date, 'j M');
			break;
		}
	}
}
