<?php
Class Kunjungan_Pasien_Unik extends Controller {
	var $title = '';
	var $report_title = 'Buku Register Kunjungan Pasien';

	function __construct() {
		parent::Controller();
		if(!$this->session->userdata('id')) redirect('login');
		$this->load->model('report/Kunjungan_Pasien_Unik_Model');
		$this->title =$this->lang->line('label_report')." &raquo;" . $this->report_title;
	}
    
	function index($data="") {
		$this->load->model('Xprofile_Model');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
       
		$data['combo_payment_type'] = $this->Kunjungan_Pasien_Unik_Model->GetComboPaymentType();
		$this->_view($data);	      	
	}
	
	function process_form() {
		$unit = $this->input->post('unit');
		$region = $this->input->post('region');
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
			$data['report_title'] .= $this->lang->line('label_clinic') . ' ' . $this->Kunjungan_Pasien_Unik_Model->GetDataClinicName($this->input->post('clinic_id'));
		}
        
		if($this->input->post('payment_type_id') != '') {
			$data['report_title'] .= ' Jenis Pasien ' . $this->Kunjungan_Pasien_Unik_Model->GetDataPaymentTypeName($this->input->post('payment_type_id'));
		}
		
		$data['report_sub_title_wilayah'] = "";
		if($this->input->post('general_spesifik') == 'spesifik') {
			$data['report_sub_title_wilayah'] = $this->Kunjungan_Pasien_Unik_Model->GetRegionName($this->input->post('village_id'), $this->input->post('sub_district_id'), $this->input->post('district_id'));
		} else {
			switch($region) {
				case "in" :
					$data['report_sub_title_wilayah'] = " Dalam Wilayah ";
				break;
				case "out" :
					$data['report_sub_title_wilayah'] = " Luar Wilayah ";
				break;
				default :
					$data['report_sub_title_wilayah'] = " Semua Wilayah ";
				break;
			}
		}
		$pos = $_POST;
		foreach($pos as $key => $val) {
			$report_param[$key] = $val;
		}
		$this->session->set_userdata('report_param', $report_param);
		
		$data['list'] = $this->Kunjungan_Pasien_Unik_Model->GetDataVisitSensus();
        $this->load->view('report/kunjungan_pasien_unik_list', $data);
	}
    
    function excel($title="") {
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
			$data['report_title'] .= $this->lang->line('label_clinic') . ' ' . $this->Kunjungan_Pasien_Unik_Model->GetDataClinicName($report_param['clinic_id']);
		}
        
		if($report_param['payment_type_id'] != '') {
			$data['report_title'] .= ' Jenis Pasien ' . $this->Kunjungan_Pasien_Unik_Model->GetDataPaymentTypeName($report_param['payment_type_id']);
		}
		
		$data['report_sub_title_wilayah'] = "";
		if($report_param['general_spesifik'] == 'spesifik') {
			$data['report_sub_title_wilayah'] = $this->Kunjungan_Pasien_Unik_Model->GetRegionName($report_param['village_id'], $report_param['sub_district_id'], $report_param['district_id']);
		} else {
			switch($report_param['region']) {
				case "in" :
					$data['report_sub_title_wilayah'] = " Dalam Wilayah ";
				break;
				case "out" :
					$data['report_sub_title_wilayah'] = " Luar Wilayah ";
				break;
				default :
					$data['report_sub_title_wilayah'] = " Semua Wilayah ";
				break;
			}
		}
        header('Content-Type: application/vnd.pwg-xhtml-print+xml');
        header('Content-Disposition: inline; filename=Kunjungan_Pasien_' . underscore($data["report_sub_title"]) . '.xls');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
		//print_r($report_param);
		$data['list'] = $this->Kunjungan_Pasien_Unik_Model->GetDataVisitSensusPrint($report_param);
		//$this->load->view('_header_print_full_landscape', $data);
		$this->load->view('report/kunjungan_pasien_unik_excel', $data);
		//$this->load->view('_footer_print_full');
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
			$data['report_title'] .= $this->lang->line('label_clinic') . ' ' . $this->Kunjungan_Pasien_Unik_Model->GetDataClinicName($report_param['clinic_id']);
		}
		
		$data['report_sub_title_wilayah'] = "";
		if($report_param['general_spesifik'] == 'spesifik') {
			$data['report_sub_title_wilayah'] = $this->Kunjungan_Pasien_Unik_Model->GetRegionName($report_param['village_id'], $report_param['sub_district_id'], $report_param['district_id']);
		} else {
			switch($report_param['region']) {
				case "in" :
					$data['report_sub_title_wilayah'] = " Dalam Wilayah ";
				break;
				case "out" :
					$data['report_sub_title_wilayah'] = " Luar Wilayah ";
				break;
				default :
					$data['report_sub_title_wilayah'] = " Semua Wilayah ";
				break;
			}
		}
		//print_r($report_param);
		$data['list'] = $this->Kunjungan_Pasien_Unik_Model->GetDataVisitSensusPrint($report_param);
		$this->load->view('_header_print_full_landscape', $data);
		$this->load->view('report/kunjungan_pasien_unik_print', $data);
		$this->load->view('_footer_print_full');
	}
	
	function _view($data = array()) {
		$menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('_header', array('title' => $this->title, '_profile' => $profile['_profile']));
		$this->load->view('_menu', $menu);
		$this->load->view('report/kunjungan_pasien_unik', $data);
		$this->load->view('_footer');
	}
	
	function get_region_by_village_id($villageId) {
		//kabupaten
        $district = $this->Kunjungan_Pasien_Unik_Model->GetDistrictByVillageId($villageId);
		$ret['district_id'] = $district['id'];

        $sub_district = $this->Kunjungan_Pasien_Unik_Model->GetSubDistrictByVillageId($villageId);
        $arr_sub_district = $this->Kunjungan_Pasien_Unik_Model->GetComboSubDistrictByVillageId($villageId);
		
		$ret['sub_district'] = '<option value="">--- '.$this->lang->line('form_all').' ---</option>';
		for($i=0;$i<sizeof($arr_sub_district);$i++) {
			if($arr_sub_district[$i]['id'] == $sub_district['id']) $sel='selected="selected"'; else $sel='';
			$ret['sub_district'] .= '<option value="'.$arr_sub_district[$i]['id'].'" '.$sel.'>'.$arr_sub_district[$i]['name'].'</option>';
		}

        $arr_village = $this->Kunjungan_Pasien_Unik_Model->GetComboVillageById($villageId);
		$ret['village'] = '<option value="">--- '.$this->lang->line('form_all').' ---</option>';
		for($i=0;$i<sizeof($arr_village);$i++) {
			if($arr_village[$i]['id'] == $villageId) $sel='selected="selected"'; else $sel='';
			$ret['village'] .= '<option value="'.$arr_village[$i]['id'].'" '.$sel.'>'.$arr_village[$i]['name'].'</option>';
		}
		echo json_encode($ret);
	}
	function get_sub_district($districtId='1') {
        $data = $this->Kunjungan_Pasien_Unik_Model->GetComboSubDistrict($districtId);
		$ret = '<option value="">--- '.$this->lang->line('form_all').' ---</option>';
		for($i=0;$i<sizeof($data);$i++) {
			$ret .= '<option value="'.$data[$i]['id'].'">'.$data[$i]['name'].'</option>';
		}
		echo $ret;
	}
	function get_village($subDistrictId='1') {
        $data = $this->Kunjungan_Pasien_Unik_Model->GetComboVillage($subDistrictId);
		$ret = '<option value="">--- '.$this->lang->line('form_all').' ---</option>';
		for($i=0;$i<sizeof($data);$i++) {
			$ret .= '<option value="'.$data[$i]['id'].'">'.$data[$i]['name'].'</option>';
		}
		echo $ret;
	}
}
