<?php

Class LB_Satu_Custom extends Controller {
	var $title = '';
	var $report_title = 'Laporan LB1';

	function __construct() {
		parent::Controller();
		if(!$this->session->userdata('id')) redirect('login');
		//$this->load->model('age/Indoor_Model');   
		$this->load->model('report/LB_Satu_Custom_Model');     
		//$this->load->model('report/LB_Satu_Custom_Model');
		//$this->load->library('chartdirector');
		$this->title =$this->lang->line('label_report')." &raquo; " . $this->report_title;
	}
    
	function index($data="") {
		$data = array();
		$this->load->model('Xprofile_Model');
        $data['combo_district'] = $this->LB_Satu_Custom_Model->GetComboDistrict();
		$data['profile'] = $this->Xprofile_Model->GetProfile();
		$this->_view($data);	      	
	}
	
	function process_form() {
		$region = $this->input->post('region');
		$unit = $this->input->post('unit');
		$data['age'] = array('0-7 hr', '8-28hr', '1 bl-1 th', '1-4 th', '5-9 th', '10-14 th', '15-19 th', '20-44 th', '45-54 th', '55-59 th', '60-69 th', '&ge;70');
		switch($unit) {
			case "year" :
				$data['report_sub_title'] = 'Periode ' . $this->input->post('year_start') . ' - ' . $this->input->post('year_end');
				$data['periode'] = $this->input->post('year_start') . "-" . $this->input->post('year_end');
				$data['periode_label'] = "Hari";
			break;
			case "month" :
				$data['report_sub_title'] = 'Periode ' . tanggalIndo($this->input->post('year_start') . '-' . addExtraZero($this->input->post('month_start'),2) . '-01', 'F Y') . ' - ' . tanggalIndo($this->input->post('year_end') . '-' . addExtraZero($this->input->post('month_end'),2) . '-01', 'F Y');
				$data['periode'] = addExtraZero($this->input->post('month_start'), 2) ."|". $this->input->post('year_start') . "-" . addExtraZero($this->input->post('month_end'), 2) . "|" . $this->input->post('year_end');
				$data['periode_label'] = "Bulan";
			break;
			default:
				$data['report_sub_title'] = 'Periode ' . tanggalIndo($this->input->post('year_start') . '-' . addExtraZero($this->input->post('month_start'),2) . '-' . addExtraZero($this->input->post('day_start'), 2), 'j F Y') . ' - ' . tanggalIndo($this->input->post('year_end') . '-' . addExtraZero($this->input->post('month_end'),2) . '-' . addExtraZero($this->input->post('day_end'),2), 'j F Y');
				$data['periode'] = addExtraZero($this->input->post('day_start'), 2) ."|". addExtraZero($this->input->post('month_start'), 2) ."|". $this->input->post('year_start') . "-" . addExtraZero($this->input->post('day_end'), 2) ."|". addExtraZero($this->input->post('month_end'), 2) . "|" . $this->input->post('year_end');
				$data['periode_label'] = "Tahun";
			break;
		}
		
		$data['report_title'] = $this->report_title;
		$data['report_sub_title_wilayah'] = "";
		if($this->input->post('general_spesifik') == 'spesifik') {
			$data['report_sub_title_wilayah'] = $this->LB_Satu_Custom_Model->GetRegionName($this->input->post('village_id'), $this->input->post('sub_district_id'), $this->input->post('district_id'));
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
		$data['temp'] = $this->LB_Satu_Custom_Model->GetDataLB_Satu_CustomForChart();
		$data['jenis_penyakit'] = $this->LB_Satu_Custom_Model->GetJenisPenyakit();
		//echo "<pre>";
		for($i=0;$i<sizeof($data['jenis_penyakit']);$i++) {
			
			for($k=0;$k<sizeof($data['age']);$k++) {
				
				for($j=0;$j<sizeof($data['temp']);$j++) {
					
					//$data['report']['count'][$i][$k] = 0;
					$data['report']['count'][$i][$k]['new'] = 0;
					$data['report']['count'][$i][$k]['old'] = 0;
					$data['report']['count'][$i][$k]['kkl'] = 0;
					
					if($data['temp'][$j]['id'] == $data['jenis_penyakit'][$i]['id'] && $data['age'][$k] == $data['temp'][$j]['age']) {
						//print_r($data['temp'][$j]);
						if($data['temp'][$j]['case'] == 'new') {
							$data['report']['count'][$i][$k]['new'] = $data['temp'][$j]['count'];
						} elseif($data['temp'][$j]['case'] == 'old') {
							$data['report']['count'][$i][$k]['old'] = $data['temp'][$j]['count'];
						} else {
							$data['report']['count'][$i][$k]['kkl'] = $data['temp'][$j]['count'];
						}
						break;
					}
				}
			}
		}
		$arr_post['region'] = $region;
		$arr_post['unit'] = $unit;
		$arr_post['day_start'] = $this->input->post('day_start');
		$arr_post['month_start'] = $this->input->post('month_start');
		$arr_post['year_start'] = $this->input->post('year_start');
		$arr_post['day_end'] = $this->input->post('day_end');
		$arr_post['month_end'] = $this->input->post('month_end');
		$arr_post['year_end'] = $this->input->post('year_end');
		$arr_post['village_id'] = $this->input->post('village_id');
		$arr_post['sub_district_id'] = $this->input->post('sub_district_id');
		$arr_post['district_id'] = $this->input->post('district_id');
		$arr_post['general_spesifik'] = $this->input->post('general_spesifik');
		//$arr_post['report_title'] = $data['report_title'];
		//$arr_post['report_sub_title_wilayah'] = $data['report_sub_title_wilayah'];
		$this->session->set_userdata('arr_post', $arr_post);
        $this->load->view('report/lb_satu_custom_list', $data);
	}
	
	function printout($title="") {
		$this->load->model('Xprofile_Model');
		$arr_post = $this->session->userdata('arr_post');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
		
		$data['age'] = array('0-7 hr', '8-28hr', '1 bl-1 th', '1-4 th', '5-9 th', '10-14 th', '15-19 th', '20-44 th', '45-54 th', '55-59 th', '60-69 th', '&ge;70');
		switch($arr_post['unit']) {
			case "year" :
				$data['report_sub_title'] = 'Periode ' . $arr_post['year_start'] . ' - ' . $arr_post['year_end'];
				$data['periode'] = $arr_post['year_start'] . "-" . $arr_post['year_end'];
				$data['periode_label'] = "Hari";
			break;
			case "month" :
				$data['report_sub_title'] = 'Periode ' . tanggalIndo($arr_post['year_start'] . '-' . addExtraZero($arr_post['month_start'],2) . '-01', 'F Y') . ' - ' . tanggalIndo($arr_post['year_end'] . '-' . addExtraZero($arr_post['month_end'],2) . '-01', 'F Y');
				$data['periode'] = addExtraZero($arr_post['month_start'], 2) ."|". $arr_post['year_start'] . "-" . addExtraZero($arr_post['month_end'], 2) . "|" . $arr_post['year_end'];
				$data['periode_label'] = "Bulan";
			break;
			default:
				$data['report_sub_title'] = 'Periode ' . tanggalIndo($arr_post['year_start'] . '-' . addExtraZero($arr_post['month_start'],2) . '-' . addExtraZero($arr_post['day_start'], 2), 'j F Y') . ' - ' . tanggalIndo($arr_post['year_end'] . '-' . addExtraZero($arr_post['month_end'],2) . '-' . addExtraZero($arr_post['day_end'],2), 'j F Y');
				$data['periode'] = addExtraZero($arr_post['day_start'], 2) ."|". addExtraZero($arr_post['month_start'], 2) ."|". $arr_post['year_start'] . "-" . addExtraZero($arr_post['day_end'], 2) ."|". addExtraZero($arr_post['month_end'], 2) . "|" . $arr_post['year_end'];
				$data['periode_label'] = "Tahun";
			break;
		}
		
		$data['report_title'] = $this->report_title;
		$data['report_sub_title_wilayah'] = "";
		if($arr_post['general_spesifik'] == 'spesifik') {
			$data['report_sub_title_wilayah'] = $this->LB_Satu_Custom_Model->GetRegionName($arr_post['village_id'], $arr_post['sub_district_id'], $arr_post['district_id']);
		} else {
			switch($arr_post['region']) {
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
		$data['temp'] = $this->LB_Satu_Custom_Model->GetDataLB_Satu_CustomForPrint();
		$data['jenis_penyakit'] = $this->LB_Satu_Custom_Model->GetJenisPenyakitForPrint();
		//echo "<pre>";
		for($i=0;$i<sizeof($data['jenis_penyakit']);$i++) {
			
			for($k=0;$k<sizeof($data['age']);$k++) {
				
				for($j=0;$j<sizeof($data['temp']);$j++) {
					
					//$data['report']['count'][$i][$k] = 0;
					$data['report']['count'][$i][$k]['new'] = 0;
					$data['report']['count'][$i][$k]['old'] = 0;
					$data['report']['count'][$i][$k]['kkl'] = 0;
					
					if($data['temp'][$j]['id'] == $data['jenis_penyakit'][$i]['id'] && $data['age'][$k] == $data['temp'][$j]['age']) {
						//print_r($data['temp'][$j]);
						if($data['temp'][$j]['case'] == 'new') {
							$data['report']['count'][$i][$k]['new'] = $data['temp'][$j]['count'];
						} elseif($data['temp'][$j]['case'] == 'old') {
							$data['report']['count'][$i][$k]['old'] = $data['temp'][$j]['count'];
						} else {
							$data['report']['count'][$i][$k]['kkl'] = $data['temp'][$j]['count'];
						}
						break;
					}
				}
			}
		}
		
		$this->load->view('_header_print_full_landscape', $data);
		$this->load->view('report/lb_satu_custom_print', $data);
		$this->load->view('_footer_print_full');
	}
	
	function csv() {
		$this->load->model('Xprofile_Model');
		$this->load->helper('download');
		$data = $this->session->userdata('report');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
		//echo "<pre>";
		//print_r($data);
		//$xdata = $data['profile']['code'] . ";" . $data['profile']['name'] . ";" . $data['periode_label'] . ";" . $data['periode'] . "\n";
		//$xdata = $data['profile']['code'];
		for($i=0;$i<sizeof($data['jenis_penyakit']);$i++) : 
			$total['new']=0;
			$total['old']=0;
			$xdata .= ($i+1) . ";" . $data['jenis_penyakit'][$i]['code'] . ";" . $data['jenis_penyakit'][$i]['name'] . ";";
				for($j=0;$j<sizeof($data['report']['count'][$i]);$j++) :
					$xdata .= $data['report']['count'][$i][$j]['new'] . ";" . $data['report']['count'][$i][$j]['old'] . ";" . $data['report']['count'][$i][$j]['kkl'] . ";";
				endfor;
				$xdata .= "\n";
		endfor;
		force_download('LB_1_' . $data['profile']['code'] . '_.xls', $xdata);
		//echo "asu";
		//$this->load->view('_header_print_full_landscape', $data);
		//$this->load->view('report/lb_satu_custom_print', $data);
		//$this->load->view('_footer_print_full');
	}
	
	function _view($data = array()) {
		$menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('_header', array('title' => $this->title, '_profile' => $profile['_profile']));
		$this->load->view('_menu', $menu);
		$this->load->view('report/lb_satu_custom', $data);
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
        $district = $this->LB_Satu_Custom_Model->GetDistrictByVillageId($villageId);
		$ret['district_id'] = $district['id'];

        $sub_district = $this->LB_Satu_Custom_Model->GetSubDistrictByVillageId($villageId);
        $arr_sub_district = $this->LB_Satu_Custom_Model->GetComboSubDistrictByVillageId($villageId);
		
		$ret['sub_district'] = '<option value="">--- '.$this->lang->line('form_all').' ---</option>';
		for($i=0;$i<sizeof($arr_sub_district);$i++) {
			if($arr_sub_district[$i]['id'] == $sub_district['id']) $sel='selected="selected"'; else $sel='';
			$ret['sub_district'] .= '<option value="'.$arr_sub_district[$i]['id'].'" '.$sel.'>'.$arr_sub_district[$i]['name'].'</option>';
		}

        $arr_village = $this->LB_Satu_Custom_Model->GetComboVillageById($villageId);
		$ret['village'] = '<option value="">--- '.$this->lang->line('form_all').' ---</option>';
		for($i=0;$i<sizeof($arr_village);$i++) {
			if($arr_village[$i]['id'] == $villageId) $sel='selected="selected"'; else $sel='';
			$ret['village'] .= '<option value="'.$arr_village[$i]['id'].'" '.$sel.'>'.$arr_village[$i]['name'].'</option>';
		}
		echo json_encode($ret);
	}
	function get_sub_district($districtId='1') {
        $data = $this->LB_Satu_Custom_Model->GetComboSubDistrict($districtId);
		$ret = '<option value="">--- '.$this->lang->line('form_all').' ---</option>';
		for($i=0;$i<sizeof($data);$i++) {
			$ret .= '<option value="'.$data[$i]['id'].'">'.$data[$i]['name'].'</option>';
		}
		echo $ret;
	}
	function get_village($subDistrictId='1') {
        $data = $this->LB_Satu_Custom_Model->GetComboVillage($subDistrictId);
		$ret = '<option value="">--- '.$this->lang->line('form_all').' ---</option>';
		for($i=0;$i<sizeof($data);$i++) {
			$ret .= '<option value="'.$data[$i]['id'].'">'.$data[$i]['name'].'</option>';
		}
		echo $ret;
	}
}
