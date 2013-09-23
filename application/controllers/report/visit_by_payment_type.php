<?php

Class Visit_By_Payment_Type extends Controller {
	var $title = '';
	var $report_title = 'Statistik Kunjungan Berdasar Jenis Pasien';

	function __construct() {
		parent::Controller();
		if(!$this->session->userdata('id')) redirect('login'); 
		$this->load->model('report/Visit_By_Payment_Type_Model');     
		$this->title =$this->lang->line('label_report')." &raquo; " . $this->report_title;
	}
    
	function index($data="") {
		$this->load->model('Xprofile_Model');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
       
		//$data['combo_clinic'] = $this->Visit_By_Payment_Type_Model->GetComboClinics(); 	
		$this->_view($data);
	}
	
	function process_form() {
		require_once APPPATH . "libraries/chart.php";
		$unit = $this->input->post('unit');
		$region = $this->input->post('region');
		$jenis = $this->Visit_By_Payment_Type_Model->GetDataJenis();
		
		switch($unit) {
			case "year" :
				$data['report_sub_title'] = 'Periode ' . $this->input->post('year_start') . ' - ' . $this->input->post('year_end');
				$diff = datediff('Y', $this->input->post('year_start') . '-01-01', $this->input->post('year_end') . '-01-01');
			break;
			case "month" :
				$data['report_sub_title'] = 'Periode ' . tanggalIndo($this->input->post('year_start') . '-' . addExtraZero($this->input->post('month_start'),2) . '-01', 'F Y') . ' - ' . tanggalIndo($this->input->post('year_end') . '-' . addExtraZero($this->input->post('month_end'),2) . '-01', 'F Y');
				$diff = datediff('m', $this->input->post('year_start') . '-' . addExtraZero($this->input->post('month_start'), 2) . '-01', $this->input->post('year_end') . '-' . addExtraZero($this->input->post('month_end'), 2) . '-01');
			break;
			default:
				$data['report_sub_title'] = 'Periode ' . tanggalIndo($this->input->post('year_start') . '-' . addExtraZero($this->input->post('month_start'),2) . '-' . addExtraZero($this->input->post('day_start'), 2), 'j F Y') . ' - ' . tanggalIndo($this->input->post('year_end') . '-' . addExtraZero($this->input->post('month_end'),2) . '-' . addExtraZero($this->input->post('day_end'),2), 'j F Y');
				$diff = datediff('d', $this->input->post('year_start') . '-' . addExtraZero($this->input->post('month_start'), 2) . '-' . addExtraZero($this->input->post('day_start'), 2), $this->input->post('year_end') . '-' . addExtraZero($this->input->post('month_end'), 2) . '-' . addExtraZero($this->input->post('day_end'), 2));
			break;
		}
		
		$data['report_title'] = $this->report_title;
		
		if($this->input->post('clinic_id') != '') {
			$data['report_title'] .= ' Berdasar Jenis Pasien ' . $this->lang->line('label_clinic') . ' ' . $this->Visit_By_Payment_Type_Model->GetDataClinicName($this->input->post('clinic_id'));
		}
		
		$data['report_sub_title_wilayah'] = "";
		if($this->input->post('general_spesifik') == 'spesifik') {
			$data['report_sub_title_wilayah'] = $this->Visit_By_Payment_Type_Model->GetRegionName($this->input->post('village_id'), $this->input->post('sub_district_id'), $this->input->post('district_id'));
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
		$param = array($this->input->post('type'), 700, 300, 'Visit_By_Payment_TypeChart');
		$FC1 = new Chart($param);
		$data['chart_temp'] = $this->Visit_By_Payment_Type_Model->GetDataVisit_By_Payment_TypeForChart();
		
		$i=0;
		while($diff >= $i) {
			switch($unit) {
				case "year" :
					$now = date('Y', mktime(0,0,0, 1, 01, $this->input->post('year_start')+$i));
				break;
				case "month":
					$now = date('Ym', mktime(0,0,0, $this->input->post('month_start')+$i, 1, $this->input->post('year_start')));
				break;
				default:
					$now = date('Ymd', mktime(0,0,0, $this->input->post('month_start'), $this->input->post('day_start')+$i, $this->input->post('year_start')));
				break;
			}
			$data['chart']['name'][$i] = $this->_setLabel($now, $unit);
			
			for($k=0;$k<sizeof($jenis);$k++) {
				$data['chart']['payment_type_id'][$k] = $jenis[$k]['id'];
				$data['chart']['dataset'][$k] = $jenis[$k]['name'];
				for($j=0;$j<sizeof($data['chart_temp']);$j++) {
					$data['chart']['count'][$i][$k] = 0;
					
					if($data['chart_temp'][$j]['test'] == $now && $jenis[$k]['id'] == $data['chart_temp'][$j]['payment_type_id']) {
						$data['chart']['count'][$i][$k] = $data['chart_temp'][$j]['count'];
						break;
					}
				}
			}
			$i++;
		}
		$this->session->set_userdata('report', $data);

		//add The Category
		for($i=0;$i<sizeof($data['chart']['name']);$i++) {
			$FC1->addCategory($data['chart']['name'][$i]);
		}
		
		for($i=0;$i<sizeof($data['chart']['dataset']);$i++) {
			$FC1->addDataset($data['chart']['dataset'][$i]);
			for($j=0;$j<sizeof($data['chart']['count']);$j++) {
				$FC1->addChartData($data['chart']['count'][$j][$i]);
			}
		}
		$data['FC1'] = $FC1;
		/*CHART END*/
		
		/*CREATING 2nd CHART*/
		/*CHART BEGIN*/
		$param2 = array("Pie3D", 700, 200, 'Visit_By_Payment_TypeChart_Total');
		$FC2 = new Chart($param2);
		$FC2->setChartParams('caption=Resume Total;exportFilename=chart2;exportCallback=exportCallback2');
		
		for($i=0;$i<sizeof($data['chart_temp']);$i++) {
			$chart2[$data['chart_temp'][$i]['payment_type_id']]['count'] += $data['chart_temp'][$i]['count'];
			$chart2[$data['chart_temp'][$i]['payment_type_id']]['name'] = $data['chart_temp'][$i]['payment_type'];
		}
		if(is_array($chart2)) {
			foreach($chart2 as $key => $val) {
				$FC2->addChartData($chart2[$key]['count'], "label=" . $chart2[$key]['name']);
			}
		}
		$data['FC2'] = $FC2;
		/*CHART END*/
		
        $this->load->view('report/visit_by_payment_type_list', $data);
	}
	
	function printout($title="") {
		$this->load->model('Xprofile_Model');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
		$data['report'] = $this->session->userdata('report');
		$this->load->view('_header_print_full', $data);
		$this->load->view('report/visit_by_payment_type_print', $data);
		$this->load->view('_footer_print_full');
	}
	
	function _view($data = array()) {
		$menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('_header', array('title' => $this->title, '_profile' => $profile['_profile']));
		$this->load->view('_menu', $menu);
		$this->load->view('report/visit_by_payment_type', $data);
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
        $district = $this->Visit_By_Payment_Type_Model->GetDistrictByVillageId($villageId);
		$ret['district_id'] = $district['id'];

        $sub_district = $this->Visit_By_Payment_Type_Model->GetSubDistrictByVillageId($villageId);
        $arr_sub_district = $this->Visit_By_Payment_Type_Model->GetComboSubDistrictByVillageId($villageId);
		
		$ret['sub_district'] = '<option value="">--- '.$this->lang->line('form_all').' ---</option>';
		for($i=0;$i<sizeof($arr_sub_district);$i++) {
			if($arr_sub_district[$i]['id'] == $sub_district['id']) $sel='selected="selected"'; else $sel='';
			$ret['sub_district'] .= '<option value="'.$arr_sub_district[$i]['id'].'" '.$sel.'>'.$arr_sub_district[$i]['name'].'</option>';
		}

        $arr_village = $this->Visit_By_Payment_Type_Model->GetComboVillageById($villageId);
		$ret['village'] = '<option value="">--- '.$this->lang->line('form_all').' ---</option>';
		for($i=0;$i<sizeof($arr_village);$i++) {
			if($arr_village[$i]['id'] == $villageId) $sel='selected="selected"'; else $sel='';
			$ret['village'] .= '<option value="'.$arr_village[$i]['id'].'" '.$sel.'>'.$arr_village[$i]['name'].'</option>';
		}
		echo json_encode($ret);
	}
	function get_sub_district($districtId='1') {
        $data = $this->Visit_By_Payment_Type_Model->GetComboSubDistrict($districtId);
		$ret = '<option value="">--- '.$this->lang->line('form_all').' ---</option>';
		for($i=0;$i<sizeof($data);$i++) {
			$ret .= '<option value="'.$data[$i]['id'].'">'.$data[$i]['name'].'</option>';
		}
		echo $ret;
	}
	function get_village($subDistrictId='1') {
        $data = $this->Visit_By_Payment_Type_Model->GetComboVillage($subDistrictId);
		$ret = '<option value="">--- '.$this->lang->line('form_all').' ---</option>';
		for($i=0;$i<sizeof($data);$i++) {
			$ret .= '<option value="'.$data[$i]['id'].'">'.$data[$i]['name'].'</option>';
		}
		echo $ret;
	}
}
