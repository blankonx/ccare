<?php

Class Kunjungan_Golusia extends Controller {
	var $title = '';
	var $report_title = 'Laporan Kunjungan Pasien Berdasarkan Golongan Usia';

	function __construct() {
		parent::Controller();
		if(!$this->session->userdata('id')) redirect('login');
		//$this->load->model('age/Indoor_Model');   
		$this->load->model('report/Kunjungan_Golusia_Model');     
		//$this->load->model('report/Kunjungan_Golusia_Model');
		//$this->load->library('chartdirector');
		$this->title =$this->lang->line('label_report')." &raquo; " . $this->report_title;
	}
    
	function index($data="") {
		$data = array();
		$this->load->model('Xprofile_Model');
        
        $data['combo_payment_type'] = $this->Kunjungan_Golusia_Model->GetComboPaymentType();
		$data['profile'] = $this->Xprofile_Model->GetProfile();
		$this->_view($data);	      	
	}
	
	function process_form() {
		$jenispasien = $this->input->post('payment_type_id');
		$unit = $this->input->post('unit');
		//$data['age'] = array('0-7 hr', '8-28 hr', '1 bl-1 th', '1-4 th', '5-9 th', '10-14 th', '15-19 th', '20-44 th', '45-54 th', '55-59 th', '60-69 th', '&ge;70');
        $data['age'] = array(1,2,3,4,5,6,7,8,9,10,11,12);
		$data['str_age'] = array('0-7 hr', '8-28 hr', '1 bl-1 th', '1-4 th', '5-9 th', '10-14 th', '15-19 th', '20-44 th', '45-54 th', '55-59 th', '60-69 th', '&ge;70');
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
		
		$data['report_title'] = $this->Kunjungan_Golusia_Model->GetDataPaymentTypeName($this->input->post('payment_type_id'));
		
		$data['temp'] = $this->Kunjungan_Golusia_Model->GetDataKunjungan_GolusiaForChart();
		$data['jenispasien'] = $this->Kunjungan_Golusia_Model->GetDataPaymentTypeName($id='');
        for($i=0;$i<sizeof($data['temp']);$i++) {
            //$data['report'][$data['temp'][$i]['id']]['patient_id'] = $data['temp'][$i]['patient_id'];
            //$data['report'][$data['temp'][$i]['tanggal_kunjungan']][$data['temp'][$i]['id']]['tanggal_kunjungan'] = $data['temp'][$i]['tanggal_kunjungan'];
            //$data['report'][$data['temp'][$i]['tanggal_kunjungan']][$data['temp'][$i]['jenis_pasien']]['jenis_pasien'] = $data['temp'][$i]['jenis_pasien'];
            $data['report'][$data['temp'][$i]['tanggal_kunjungan']][$data['temp'][$i]['jenis_pasien']][$data['temp'][$i]['age']][$data['temp'][$i]['sex']] = $data['temp'][$i]['count'];
        }
		//echo "<pre>";
        //print_r($data['report']);
		//echo "</pre>";
		//$arr_post['icd_group_id'] = $this->input->post('icd_group_id');
		$arr_post['region'] = $region;
		$arr_post['jenispasien'] = $jenispasien;
		$arr_post['unit'] = $unit;
		$arr_post['day_start'] = $this->input->post('day_start');
		$arr_post['month_start'] = $this->input->post('month_start');
		$arr_post['year_start'] = $this->input->post('year_start');
		$arr_post['day_end'] = $this->input->post('day_end');
		$arr_post['month_end'] = $this->input->post('month_end');
		$arr_post['year_end'] = $this->input->post('year_end');
		
		$arr_post['report_title'] = $data['report_title'];
		$arr_post['report_sub_title_wilayah'] = $data['report_sub_title_wilayah'];
		$this->session->set_userdata('arr_post', $arr_post);
        $this->load->view('report/kunjungan_golusia_list', $data);
	}
	
	function printout($title="") {
		$this->load->model('Xprofile_Model');
		$arr_post = $this->session->userdata('arr_post');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
		
        $data['age'] = array(1,2,3,4,5,6,7,8,9,10,11,12);
		$data['str_age'] = array('0-7 hr', '8-28 hr', '1 bl-1 th', '1-4 th', '5-9 th', '10-14 th', '15-19 th', '20-44 th', '45-54 th', '55-59 th', '60-69 th', '&ge;70');
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
		
		$data['report_title'] = $this->Kunjungan_Golusia_Model->GetDataPaymentTypeName($jenispasien);
		$data['report_title'] = $this->report_title;
		$data['report_sub_title_wilayah'] = "";
		if($arr_post['general_spesifik'] == 'spesifik') {
			$data['report_sub_title_wilayah'] = $this->Kunjungan_Golusia_Model->GetRegionName($arr_post['village_id'], $arr_post['sub_district_id'], $arr_post['district_id']);
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
		
		$data['temp'] = $this->Kunjungan_Golusia_Model->GetDataKunjungan_GolusiaForPrint();
		$data['jenispasien'] = $this->Kunjungan_Golusia_Model->GetDataPaymentTypeName($id='');
		//$data['jenispasien'] = $this->jenispasien;
        for($i=0;$i<sizeof($data['temp']);$i++) {
            $data['report'][$data['temp'][$i]['tanggal_kunjungan']][$data['temp'][$i]['jenis_pasien']][$data['temp'][$i]['age']][$data['temp'][$i]['sex']] = $data['temp'][$i]['count'];
        }
		$this->load->view('_header_print_full_landscape', $data);
		$this->load->view('report/kunjungan_golusia_print', $data);
		$this->load->view('_footer_print_full');
	}
	
	function excel() {
		$this->load->model('Xprofile_Model');
		$arr_post = $this->session->userdata('arr_post');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
		
        $data['age'] = array(1,2,3,4,5,6,7,8,9,10,11,12);
		$data['str_age'] = array('0-7 hr', '8-28 hr', '1 bl-1 th', '1-4 th', '5-9 th', '10-14 th', '15-19 th', '20-44 th', '45-54 th', '55-59 th', '60-69 th', '&ge;70');
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
		
		//$data['report_title'] = $this->Kunjungan_Golusia_Model->GetNamaKelompokPenyakit($arr_post['icd_group_id']);
		//$data['report_title'] = $this->report_title;
		$data['report_sub_title_wilayah'] = "";
		if($arr_post['general_spesifik'] == 'spesifik') {
			$data['report_sub_title_wilayah'] = $this->Kunjungan_Golusia_Model->GetRegionName($arr_post['village_id'], $arr_post['sub_district_id'], $arr_post['district_id']);
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
		$data['temp'] = $this->Kunjungan_Golusia_Model->GetDataKunjungan_GolusiaForPrint();
		$data['jenispasien'] = $this->Kunjungan_Golusia_Model->GetDataPaymentTypeName($id='');
        for($i=0;$i<sizeof($data['temp']);$i++) {
            $data['report'][$data['temp'][$i]['tanggal_kunjungan']][$data['temp'][$i]['jenis_pasien']][$data['temp'][$i]['age']][$data['temp'][$i]['sex']] = $data['temp'][$i]['count'];
        }
        header('Content-Type: application/vnd.pwg-xhtml-print+xml');
        header('Content-Disposition: inline; filename=' . underscore($data["report_title"] . '-' . $data["report_sub_title"]) . '.xls');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        
		//$this->load->view('_header_print_full_landscape', $data);
		$this->load->view('report/kunjungan_golusia_excel', $data);
		//$this->load->view('_footer_print_full');
	}
	
	function _view($data = array()) {
		$menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('_header', array('title' => $this->title, '_profile' => $profile['_profile']));
		$this->load->view('_menu', $menu);
		$this->load->view('report/kunjungan_golusia', $data);
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
