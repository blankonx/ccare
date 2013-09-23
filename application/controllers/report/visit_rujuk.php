<?php

Class Visit_Rujuk extends Controller {
	var $title = '';
	var $report_title = 'Statistik Rujukan';

	function __construct() {
		parent::Controller();
		if(!$this->session->userdata('id')) redirect('login');
		//$this->load->model('admission/Indoor_Model');
		$this->load->model('report/Visit_Rujuk_Model');
		//$this->load->model('report/Visit_Rujuk_Model');
		//$this->load->library('chartdirector');
		$this->title =$this->lang->line('label_report')." &raquo;" . $this->report_title;
	}
    
	function index($data="") {
		$data = array();
		$this->load->model('Xprofile_Model');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
        $data['combo_district'] = $this->Visit_Rujuk_Model->GetComboDistrict();
		$this->_view($data);	      	
	}
	
	function process_form() {
		$this->session->set_userdata('report', array());
		$unit = $this->input->post('unit');
		$region = $this->input->post('region');
		$data['jenis'] = $this->Visit_Rujuk_Model->GetDataJenis();
		
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
		
		$data['report_sub_title_wilayah'] = "";
		if($this->input->post('general_spesifik') == 'spesifik') {
			$data['report_sub_title_wilayah'] = $this->Visit_Rujuk_Model->GetRegionName($this->input->post('village_id'), $this->input->post('sub_district_id'), $this->input->post('district_id'));
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
		
		/*CHART BEGIN*/
		$param = array("Pie3D", 700, 300, 'Visit_RujukChart');
		$this->load->library('chart', $param);
		$data['chart'] = $this->Visit_Rujuk_Model->GetDataVisit_RujukForChart();
		
		//SET SESSION FOR PRINT OUT
		$this->session->set_userdata('report', $data);

		for($i=0;$i<sizeof($data['chart']);$i++) {
            $data['report'][$i]['name'] = $data['chart'][$i]['name'];
            //$data['report'][$data['chart'][$i]['id']]['icd_code'] = $data['chart'][$i]['icd_code'];
            $data['report'][$i]['count'][$data['chart'][$i]['payment_type_id']] = $data['chart'][$i]['count'];
			$this->chart->addChartData($data['chart'][$i]['count'], "label=" . $data['chart'][$i]['name']);
		}
	//	print_r($data['report']);
		/*CHART END*/
        $this->load->view('report/visit_rujuk_list', $data);
	}
	
	function printout($title="") {
		$this->load->model('Xprofile_Model');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
		$data['report'] = $this->session->userdata('report');
		$report_param = $this->session->userdata('report_param');

		$this->session->set_userdata('report', array());
		$unit = $report_param['unit'];
		$region = $report_param['region'];
		$data['jenis'] = $this->Visit_Rujuk_Model->GetDataJenis();
		
		switch($report_param['unit']) {
			case "all" :
				$data['report_sub_title'] = ' ';
			break;
			case "year" :
				$data['report_sub_title'] = 'Periode ' . $report_param['year_start']. ' - ' . $report_param['year_end'];
			break;
			case "month" :
				$data['report_sub_title'] = 'Periode ' . tanggalIndo($report_param['year_start'] . '-' . addExtraZero($report_param['month_start'],2) . '-01', 'F Y') . ' - ' . tanggalIndo($report_param['year_end'] . '-' . addExtraZero($report_param['month_end'],2) . '-01', 'F Y');
			break;
			default:
				$data['report_sub_title'] = 'Periode ' . tanggalIndo($report_param['year_start'] . '-' . addExtraZero($report_param['month_start'],2) . '-' . addExtraZero($report_param['day_start'], 2), 'j F Y') . ' - ' . tanggalIndo($report_param['year_end'] . '-' . addExtraZero($report_param['month_end'],2) . '-' . addExtraZero($report_param['day_end'],2), 'j F Y');
			break;
		}
		
		$data['report_title'] = $this->report_title;
		
		$data['report_sub_title_wilayah'] = "";
		if($report_param['general_spesifik'] == 'spesifik') {
			$data['report_sub_title_wilayah'] = $this->Visit_Rujuk_Model->GetRegionName($report_param['village_id'], $report_param['sub_district_id'], $report_param['district_id']);
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

		/*CHART BEGIN*/
		$param = array("Pie3D", 700, 300, 'Visit_RujukChart');
		$this->load->library('chart', $param);
		$data['chart'] = $this->Visit_Rujuk_Model->GetDataVisit_RujukForChartPrint($report_param);
		
		//SET SESSION FOR PRINT OUT
		$this->session->set_userdata('report', $data);

		for($i=0;$i<sizeof($data['chart']);$i++) {
            	$data['report'][$i]['name'] = $data['chart'][$i]['name'];
            	//$data['report'][$data['chart'][$i]['id']]['icd_code'] = $data['chart'][$i]['icd_code'];
            	$data['report'][$i]['count'][$data['chart'][$i]['payment_type_id']] = $data['chart'][$i]['count'];
			$this->chart->addChartData($data['chart'][$i]['count'], "label=" . $data['chart'][$i]['name']);
		}
		//print_r($data['report']);
		/*CHART END*/

		$this->load->view('_header_print_full', $data);
		$this->load->view('report/visit_rujuk_print', $data);
		$this->load->view('_footer_print_full');
	}
	
	function pdf() {
		
	}
	
	function _view($data = array()) {
		$menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('_header', array('title' => $this->title, '_profile' => $profile['_profile']));
		$this->load->view('_menu', $menu);
		$this->load->view('report/visit_rujuk', $data);
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
	
	
	function get_region_by_village_id($villageId) {
		//kabupaten
        $district = $this->Visit_Rujuk_Model->GetDistrictByVillageId($villageId);
		$ret['district_id'] = $district['id'];

        $sub_district = $this->Visit_Rujuk_Model->GetSubDistrictByVillageId($villageId);
        $arr_sub_district = $this->Visit_Rujuk_Model->GetComboSubDistrictByVillageId($villageId);
		
		$ret['sub_district'] = '<option value="">--- '.$this->lang->line('form_all').' ---</option>';
		for($i=0;$i<sizeof($arr_sub_district);$i++) {
			if($arr_sub_district[$i]['id'] == $sub_district['id']) $sel='selected="selected"'; else $sel='';
			$ret['sub_district'] .= '<option value="'.$arr_sub_district[$i]['id'].'" '.$sel.'>'.$arr_sub_district[$i]['name'].'</option>';
		}

        $arr_village = $this->Visit_Rujuk_Model->GetComboVillageById($villageId);
		$ret['village'] = '<option value="">--- '.$this->lang->line('form_all').' ---</option>';
		for($i=0;$i<sizeof($arr_village);$i++) {
			if($arr_village[$i]['id'] == $villageId) $sel='selected="selected"'; else $sel='';
			$ret['village'] .= '<option value="'.$arr_village[$i]['id'].'" '.$sel.'>'.$arr_village[$i]['name'].'</option>';
		}
		echo json_encode($ret);
	}
	function get_sub_district($districtId='1') {
        $data = $this->Visit_Rujuk_Model->GetComboSubDistrict($districtId);
		$ret = '<option value="">--- '.$this->lang->line('form_all').' ---</option>';
		for($i=0;$i<sizeof($data);$i++) {
			$ret .= '<option value="'.$data[$i]['id'].'">'.$data[$i]['name'].'</option>';
		}
		echo $ret;
	}
	function get_village($subDistrictId='1') {
        $data = $this->Visit_Rujuk_Model->GetComboVillage($subDistrictId);
		$ret = '<option value="">--- '.$this->lang->line('form_all').' ---</option>';
		for($i=0;$i<sizeof($data);$i++) {
			$ret .= '<option value="'.$data[$i]['id'].'">'.$data[$i]['name'].'</option>';
		}
		echo $ret;
	}
}
