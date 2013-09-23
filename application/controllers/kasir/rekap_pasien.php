<?php

Class Rekap_Pasien extends Controller {
	var $title = '';
	var $report_title = 'Rekap Pendapatan Per Pasien';

	function __construct() {
		parent::Controller();
		//if(!$this->session->userdata('id')) redirect('login');
		//$this->load->model('admission/Indoor_Model');   
		$this->load->model('kasir/Rekap_Pasien_Model');     
		//$this->load->model('kasir/Rekap_Pasien_Model');
		//$this->load->library('chartdirector');
		$this->title =$this->lang->line('label_report')." &raquo;" . $this->report_title;
	}
    
	function index($data="") {
		$this->load->model('Xprofile_Model');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
		//$data['combo_clinic'] = $this->Rekap_Pasien_Model->GetComboClinics(); 	
		$this->_view($data);	      	
	}
	
	function process_form() {
		$unit = $this->input->post('unit');
		$this->session->set_userdata('report_param', array());
		switch($unit) {
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
		
		if($this->input->post('clinic_id') != '') {
			$data['report_title'] .= $this->lang->line('label_clinic') . ' ' . $this->Rekap_Pasien_Model->GetDataClinicName($this->input->post('clinic_id'));
		}
        
		$pos = $_POST;
		foreach($pos as $key => $val) {
			$report_param[$key] = $val;
		}
		$this->session->set_userdata('report_param', $report_param);
		
		$data['list'] = $this->Rekap_Pasien_Model->GetDataRekapRekap_Pasien();
        $this->load->view('kasir/rekap_pasien_list', $data);
	}
	
	function printout($title="") {
		$this->load->model('Xprofile_Model');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
		$report_param = $this->session->userdata('report_param');
		$data['report_title'] = $this->report_title;
		
		switch($report_param['unit']) {
			case "year" :
				$data['report_sub_title'] = 'Periode ' . $report_param['year_start'] . ' - ' . $report_param['year_end'];
			break;
			case "month" :
				$data['report_sub_title'] = 'Periode ' . tanggalIndo($report_param['year_start'] . '-' . addExtraZero($report_param['month_start'],2) . '-01', 'F Y') . ' - ' . tanggalIndo($report_param['year_end'] . '-' . addExtraZero($report_param['month_end'],2) . '-01', 'F Y');
			break;
			default:
				$data['report_sub_title'] = 'Periode ' . tanggalIndo($report_param['year_start'] . '-' . addExtraZero($report_param['month_start'],2) . '-' . addExtraZero($report_param['day_start'], 2), 'j F Y') . ' - ' . tanggalIndo($report_param['year_end'] . '-' . addExtraZero($report_param['month_end'],2) . '-' . addExtraZero($report_param['day_end'],2), 'j F Y');
			break;
		}
		
		if($report_param['clinic_id'] != '') {
			$data['report_title'] .= $this->lang->line('label_clinic') . ' ' . $this->Rekap_Pasien_Model->GetDataClinicName($report_param['clinic_id']);
		}
        
		//print_r($report_param);
		$data['list'] = $this->Rekap_Pasien_Model->GetDataRekapRekap_PasienPrint($report_param);
		$this->load->view('_header_print_full', $data);
		$this->load->view('kasir/rekap_pasien_print', $data);
		$this->load->view('_footer_print_full');
	}
	
	function _view($data = array()) {
		$menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('_header', array('title' => $this->title, '_profile' => $profile['_profile']));
		$this->load->view('_menu', $menu);
		$this->load->view('kasir/rekap_pasien', $data);
		$this->load->view('_footer');
	}
}
