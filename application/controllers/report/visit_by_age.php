<?php

Class Visit_By_Age extends Controller {
	var $title = '';
	var $report_title = 'Statistik Kunjungan Berdasar Usia';

	function __construct() {
		parent::Controller();
		if(!$this->session->userdata('id')) redirect('login');
		//$this->load->model('age/Indoor_Model');   
		$this->load->model('report/Visit_By_Age_Model');     
		//$this->load->model('report/Visit_By_Age_Model');
		//$this->load->library('chartdirector');
		$this->title =$this->lang->line('label_report')." &raquo; " . $this->report_title;
	}
    
	function index($data="") {
		//$data['combo_bulan_indo'] = $this->Visit_By_Age_Model->GetComboBulanIndo(); 	 	
		//$data['combo_clinic'] = $this->Visit_By_Age_Model->GetComboClinics(); 	
		$data = array();
		$this->_view($data);	      	
	}
	
	function process_form() {
		require_once APPPATH . "libraries/chart.php";
		$unit = $this->input->post('unit');
		$region = $this->input->post('region');
		$age = array('&le;15', '16-19', '20-24', '25-29', '&ge;30');
		
		switch($unit) {
			case "year" :
				$data['report_sub_title'] = 'Periode ' . $this->input->post('year_start') . ' - ' . $this->input->post('year_end');
				$start = $this->input->post('year_start');
				$end = $this->input->post('year_end');
				$diff = datediff('Y', $this->input->post('year_start') . '-01-01', $this->input->post('year_end') . '-01-01');
			break;
			case "month" :
				$data['report_sub_title'] = 'Periode ' . tanggalIndo($this->input->post('year_start') . '-' . addExtraZero($this->input->post('month_start'),2) . '-01', 'F Y') . ' - ' . tanggalIndo($this->input->post('year_end') . '-' . addExtraZero($this->input->post('month_end'),2) . '-01', 'F Y');
				$start = $this->input->post('year_start') . addExtraZero($this->input->post('month_start'), 2);
				$end = $this->input->post('year_end') . addExtraZero($this->input->post('month_end'), 2);
				$diff = datediff('m', $this->input->post('year_start') . '-' . addExtraZero($this->input->post('month_start'), 2) . '-01', $this->input->post('year_end') . '-' . addExtraZero($this->input->post('month_end'), 2) . '-01');
			break;
			default:
				$data['report_sub_title'] = 'Periode ' . tanggalIndo($this->input->post('year_start') . '-' . addExtraZero($this->input->post('month_start'),2) . '-' . addExtraZero($this->input->post('day_start'), 2), 'j F Y') . ' - ' . tanggalIndo($this->input->post('year_end') . '-' . addExtraZero($this->input->post('month_end'),2) . '-' . addExtraZero($this->input->post('day_end'),2), 'j F Y');
				$start = $this->input->post('year_start') . addExtraZero($this->input->post('month_start'), 2) . addExtraZero($this->input->post('day_start'), 2);
				$end = $this->input->post('year_end') . addExtraZero($this->input->post('month_end'), 2) . addExtraZero($this->input->post('day_end'), 2);
				//$mktime_start = mktime(0,0,0, addExtraZero($this->input->post('month_start'), 2), addExtraZero($this->input->post('day_start'), 2), $this->input->post('year_start'));
				//$mktime_end = mktime(0,0,0, addExtraZero($this->input->post('month_end'), 2), addExtraZero($this->input->post('day_end'), 2), $this->input->post('year_end'));
				$diff = datediff('d', $this->input->post('year_start') . '-' . addExtraZero($this->input->post('month_start'), 2) . '-' . addExtraZero($this->input->post('day_start'), 2), $this->input->post('year_end') . '-' . addExtraZero($this->input->post('month_end'), 2) . '-' . addExtraZero($this->input->post('day_end'), 2));
			break;
		}
		
		$data['report_title'] = $this->report_title;
		 		
		/*CHART BEGIN*/
		$param = array("MSColumn3D", 700, 300, 'Visit_By_AgeChart');
		$FC1 = new Chart($param);
		$data['chart_temp'] = array();
		$data['chart_temp'] = $this->Visit_By_Age_Model->GetDataVisit_By_AgeForChart();
		
		$i=0;
		while($diff >= $i) {
			//$tgl = mktime();
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
			
			for($k=0;$k<sizeof($age);$k++) {
				//$data['chart']['age'][$k] = $age[$k];
				$data['chart']['dataset'][$k] = $age[$k];
				for($j=0;$j<sizeof($data['chart_temp']);$j++) {
					$data['chart']['count'][$i][$k] = 0;
					
					if($data['chart_temp'][$j]['test'] == $now && $age[$k] == $data['chart_temp'][$j]['age']) {
						$data['chart']['count'][$i][$k] = $data['chart_temp'][$j]['count'];
						break;
					}
				}
			}
			$i++;
		}
		
		//SET SESSION FOR PDF
		//$this->session->set_userdata('test', 'asdf');
		//$this->session->set_userdata('report_count', serialize($data['chart']['count']));
		$this->session->set_userdata('report', $data);
		//$this->session->set_userdata('test', array('asdfccasdfadsfasdfasdfccasdfadsfasdfasdf', 'aaccasdfadsfasdfasdfccasdfadsfasdfasdf', 'bbccasdfadsfasdfasdfccasdfadsfasdfasdf', 'ccasdfadsfasdfasdfccasdfadsfasdfasdf'));
		//print_r($data);

		//add The Category
		for($i=0;$i<sizeof($data['chart']['name']);$i++) {
			$FC1->addCategory($data['chart']['name'][$i]);
		}
		
		for($i=0;$i<sizeof($data['chart']['dataset']);$i++) {
			$x = str_replace("&le;", "<=", $data['chart']['dataset'][$i]);
			$x = str_replace("&ge;", ">=", $x);
			$FC1->addDataset($x);
			for($j=0;$j<sizeof($data['chart']['count']);$j++) {
				$FC1->addChartData($data['chart']['count'][$j][$i]);
			}
		}
		$data['FC1'] = $FC1;
		/*CHART END*/
		
		/*CREATING 2nd CHART*/
		/*CHART BEGIN*/
		$param2 = array("Pie3D", 700, 200, 'Visit_By_AgeChart_Total');
		$FC2 = new Chart($param2);
		$FC2->setChartParams('caption=Resume Total;exportFilename=chart2;exportCallback=exportCallback2');
		
		for($i=0;$i<sizeof($data['chart_temp']);$i++) {
			$x = str_replace("&le;", "<=", $data['chart_temp'][$i]['age']);
			$x = str_replace("&ge;", ">=", $x);
			$chart2[$x]['count'] += $data['chart_temp'][$i]['count'];
			$chart2[$x]['name'] = $x;
		}
		if(is_array($chart2)) {
			foreach($chart2 as $key => $val) {
				$FC2->addChartData($chart2[$key]['count'], "label=" . $chart2[$key]['name']);
			}
		}
		$data['FC2'] = $FC2;
		/*CHART END*/
		
        $this->load->view('report/visit_by_age_list', $data);
	}
	
	function printout($title="") {
		$this->load->model('Xprofile_Model');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
		$data['report'] = $this->session->userdata('report');
		$this->load->view('_header_print_full', $data);
		$this->load->view('report/visit_by_age_print', $data);
		$this->load->view('_footer_print_full');
	}
	
	function pdf() {
	}

	
	function _view($data = array()) {
		$menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('_header', array('title' => $this->title, '_profile' => $profile['_profile']));
		$this->load->view('_menu', $menu);
		$this->load->view('report/visit_by_age', $data);
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
