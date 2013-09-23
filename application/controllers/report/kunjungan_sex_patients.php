<?php

Class Kunjungan_Sex_Patients extends Controller {
	var $title = '';
	var $report_title = 'Statistik Kunjungan Pasien Berdasarkan Jenis Kelamin';

	function __construct() {
		parent::Controller();
		if(!$this->session->userdata('id')) redirect('login');
		//$this->load->model('admission/Indoor_Model');
		$this->load->model('report/Kunjungan_Sex_Patients_Model');
		//$this->load->model('report/Kunjungan_Sex_Patients_Model');
		//$this->load->library('chartdirector');
		$this->title =$this->lang->line('label_report')." &raquo;" . $this->report_title;
	}
    
	function index($data="") {
		$data = array();
		$this->load->model('Xprofile_Model');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
        
		$this->_view($data);	      	
	}
	
	function process_form() {
		$this->session->set_userdata('report', array());
		$unit = $this->input->post('unit');
		$region = $this->input->post('region');
		
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
		$param = array("Pie3D", 700, 300, 'Kunjungan_Sex_PatientsChart');
		$this->load->library('chart', $param);
		$data['chart'] = $this->Kunjungan_Sex_Patients_Model->GetDataKunjungan_Sex_PatientsForChart();
		
		//SET SESSION FOR PRINT OUT
		$this->session->set_userdata('report', $data);

		for($i=0;$i<sizeof($data['chart']);$i++) {
			$this->chart->addChartData($data['chart'][$i]['count'], "label=" . $data['chart'][$i]['name']);
		}
		/*CHART END*/
        $this->load->view('report/kunjungan_sex_patients_list', $data);
	}
	
	function printout($title="") {
		$this->load->model('Xprofile_Model');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
		$data['report'] = $this->session->userdata('report');
		$this->load->view('_header_print_full', $data);
		$this->load->view('report/kunjungan_sex_patients_print', $data);
		$this->load->view('_footer_print_full');
	}
	
	function pdf() {
		
	}
	
	function _view($data = array()) {
		$menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('_header', array('title' => $this->title, '_profile' => $profile['_profile']));
		$this->load->view('_menu', $menu);
		$this->load->view('report/kunjungan_sex_patients', $data);
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
