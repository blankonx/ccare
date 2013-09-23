<?php

Class Pregnant extends Controller {
    
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('visit/Pregnant_Model');
    }
    
    function index() {
        return $this->home();
    }

    function home($visitId, $pregnantId=0) {
        $data = array();
        //$data['data'] = $this->Pregnant_Model->GetData($visitId);
        if(!$pregnantId) {
            $data['current'] = $this->Pregnant_Model->GetCurrentPregnant($visitId);
        } else {
            $data['current']['pregnant_id'] = $pregnantId;
        }
        $data['current']['visit_id'] = $visitId;
        $this->_view($data);
    }

    function form_pregnant($visitId, $pregnantId=0) {
        $data = array();
        $data['data'] = $this->Pregnant_Model->GetData($visitId);
        $data['data']['visit_id'] = $visitId;
        $data['data']['pregnant_id'] = $pregnantId;
        //print_r($data);

        $data['saved_family_history_disease_id'] = explode("|", $data['data']['family_history_disease_id']);
        $data['saved_history_disease_id'] = explode("|", $data['data']['history_disease_id']);

        $data['saved_family_history_disease_id'] = array_unique($data['saved_family_history_disease_id']);
        $data['saved_history_disease_id'] = array_unique($data['saved_history_disease_id']);

        //print_r($data);
		$data['family_history_disease'] = $this->Pregnant_Model->GetDataFamilyHistoryDisease();
		//$data['history_disease'] = $this->Pregnant_Model->GetDataHistoryDisease();
		$data['contraceptive'] = $this->Pregnant_Model->GetDataContraceptive();
		$data['health_facility'] = $this->Pregnant_Model->GetDataHealthFacilities();
		$data['paramedic_type'] = $this->Pregnant_Model->GetDataParamedicType();
		$data['continue'] = $this->Pregnant_Model->GetDataContinue();
		$data['paramedic'] = $this->Pregnant_Model->GetDataParamedic();
		$data['delivery_method'] = $this->Pregnant_Model->GetDataDeliveryMethod();
        //$data['poedji'] = $this->Pregnant_Model->GetDataPoedji();

        //$data['visit_data'] = $this->Pregnant_Model->GetVisitData($visitId);
        //$data['visit_pregnant_poedji_rochjati'] = array();
/*
        if(!empty($data['visit_data'])) {
            $visit_pregnant_poedji_rochjati = $this->Pregnant_Model->GetVisitPregnantPoedjiRochjati($data['visit_data']['id']);
            for($i=0;$i<sizeof($visit_pregnant_poedji_rochjati);$i++) {
                $data['visit_pregnant_poedji_rochjati'][$i] =$visit_pregnant_poedji_rochjati[$i]['poedji_rochjati_id'];
            }
        }

        if(empty($data['visit_data'])) {
            $data['current_pregnant'] = $this->Pregnant_Model->GetCurrentPregnant($visitId);
        }
*/
        //$data['saved_poedji_id'] = array_unique(explode("|", $data['visit_data']['saved_poedji_id']));
        //$data['total_score_poedji_rochjati'] = $this->Pregnant_Model->GetTotalScorePoedjiRochjati($data['visit_data']['id'], $visitId);

		//$age = getAge($data['data']['birth_date'], $data['data']['visit_date']);    
		//$data['data']['age'] = $age;

        //$data['doctor'] = $this->Pregnant_Model->GetDataDoctor();
        //echo "<pre>";
        //print_r($data['visit_data']);
        //print_r($data['current_pregnant']);
        //print_r($data['visit_pregnant_poedji_rochjati']);
        //echo "</pre>";
        $this->load->view('visit/pregnant_pregnant', $data);
        //$this->_view($data);
    }

    function form_visit($visitId, $pregnantId=0) {
        $data = array();
		$param = array('MSLine', 450, 250);

		$this->load->library('fusioncharts', $param);
		$this->fusioncharts->setSWFPath('../Charts/');
		$this->fusioncharts->setChartParams("caption=Grafik Perkembangan;xAxisName=Usia Kehamilan (minggu);yAxisName=Nilai;decimalPrecision=1");

		$data_chart = $this->Pregnant_Model->GetDataForChart($pregnantId);
		$this->fusioncharts->addDataset("Berat Badan");
		for($i=0;$i<sizeof($data_chart);$i++) {
			$this->fusioncharts->addCategory($data_chart[$i]['age_of_pregnant']);
			$this->fusioncharts->addChartData($data_chart[$i]['weight']);
		}

		$this->fusioncharts->addDataset("Tinggi Fundus");
		for($i=0;$i<sizeof($data_chart);$i++) {
			$this->fusioncharts->addChartData($data_chart[$i]['fundus_height']);
		}

        $data['data'] = $this->Pregnant_Model->GetData($visitId);
		//print_r($data);
        $data['data']['visit_id'] = $visitId;
        $data['data']['pregnant_id'] = $pregnantId;
        //print_r($data);

        //$data['saved_family_history_disease_id'] = explode("|", $data['data']['family_history_disease_id']);
        //$data['saved_history_disease_id'] = explode("|", $data['data']['history_disease_id']);

        //$data['saved_family_history_disease_id'] = array_unique($data['saved_family_history_disease_id']);
        //$data['saved_history_disease_id'] = array_unique($data['saved_history_disease_id']);

        //print_r($data);
		//$data['family_history_disease'] = $this->Pregnant_Model->GetDataFamilyHistoryDisease();
		//$data['history_disease'] = $this->Pregnant_Model->GetDataHistoryDisease();
		//$data['contraceptive'] = $this->Pregnant_Model->GetDataContraceptive();
		//$data['health_facility'] = $this->Pregnant_Model->GetDataHealthFacilities();
		//$data['paramedic_type'] = $this->Pregnant_Model->GetDataParamedicType();
		$data['continue'] = $this->Pregnant_Model->GetDataContinue();
		$data['paramedic'] = $this->Pregnant_Model->GetDataParamedic();
		//$data['birth'] = $this->Pregnant_Model->GetDataBirth();
        $data['poedji'] = $this->Pregnant_Model->GetDataPoedji();

        $data['visit_data'] = $this->Pregnant_Model->GetVisitData($visitId);
        $data['visit_pregnant_poedji_rochjati'] = array();

        if(!empty($data['visit_data'])) {
            $visit_pregnant_poedji_rochjati = $this->Pregnant_Model->GetVisitPregnantPoedjiRochjati($data['visit_data']['id']);
            for($i=0;$i<sizeof($visit_pregnant_poedji_rochjati);$i++) {
                $data['visit_pregnant_poedji_rochjati'][$i] =$visit_pregnant_poedji_rochjati[$i]['poedji_rochjati_id'];
            }
        }
        if(empty($data['visit_data'])) {
            $data['current_pregnant'] = $this->Pregnant_Model->GetCurrentPregnant($visitId);
        }

        //$data['saved_poedji_id'] = array_unique(explode("|", $data['visit_data']['saved_poedji_id']));
        $data['total_score_poedji_rochjati'] = $this->Pregnant_Model->GetTotalScorePoedjiRochjati($data['visit_data']['id'], $visitId);

		//$age = getAge($data['data']['birth_date'], $data['data']['visit_date']);    
		//$data['data']['age'] = $age;

        //$data['doctor'] = $this->Pregnant_Model->GetDataDoctor();
        //echo "<pre>";
        //print_r($data['visit_data']);
        //print_r($data['current_pregnant']);
        //print_r($data['visit_pregnant_poedji_rochjati']);
        //echo "</pre>";
        $this->load->view('visit/pregnant_visit', $data);
        //$this->_view($data);
    }

    function form_delivery($visitId, $pregnantId=0) {
        $data = array();
        $data['data'] = $this->Pregnant_Model->GetData($visitId);
        $data['current'] = $this->Pregnant_Model->GetCurrentDelivery($visitId, $pregnantId);
        //print_r($data);
        $data['data']['visit_id'] = $visitId;
        $data['data']['pregnant_id'] = $pregnantId;
		$data['delivery_method'] = $this->Pregnant_Model->GetDataDeliveryMethod();
		$data['continue'] = $this->Pregnant_Model->GetDataContinue();
		$data['paramedic'] = $this->Pregnant_Model->GetDataParamedic();
        $this->load->view('visit/pregnant_delivery', $data);
    }

    function form_newborn($cnt=1, $deliveryId='') {
        if($deliveryId) {
            //sudah ada data
            $data['current'] = $this->Pregnant_Model->GetCurrentNewborn($deliveryId);
        } else {
            //belum ada data
            $data['current'] = array();
            //$data['current'] = $this->Pregnant_Model->GetMRNumber($deliveryId);
        }
        $data['cnt'] = $cnt;
        //echo "<pre>";
        //print_r($data);
        //echo "</pre>";
        $this->load->view('visit/pregnant_newborn', $data);
    }

    function getHTP($hpht_date, $hpht_month, $hpht_year) {
        /* date+280 */
        echo date('d/m/Y', mktime(1, 1, 1, $hpht_month, $hpht_date+280, $hpht_year));
    }

    function lists($pregnantId, $visitId, $limit=0) {
        //$data['pregnant'] = $this->Pregnant_Model->GetDataPregnant($pregnantId);
        //$data['family_history_disease'] = $this->Pregnant_Model->GetDataPregnantFamilyHistory($pregnantId);
        //$data['history_disease'] = $this->Pregnant_Model->GetDataPregnantHistory($pregnantId);

        $this->load->library('pagination');

		$data['list'] = $this->Pregnant_Model->GetList($pregnantId, $limit, 5);
		$data['list_delivery'] = $this->Pregnant_Model->GetListDelivery($pregnantId);
		$data['list_pregnant'] = $this->Pregnant_Model->GetListPregnant($pregnantId);
        
        /*paging start*/
        $paging['base_url'] = site_url('visit/pregnant/lists/' . $pregnantId . '/' . $visitId . '/');
        $paging['base_url'] = base_url() . 'visit/pregnant/lists/' . $pregnantId . '/' . $visitId . '/';
        $paging['total_rows'] = $this->Pregnant_Model->GetCount();
        $paging['per_page'] = 100;
        $paging['uri_segment'] = 6;
        $paging['num_links'] = 5;
        $this->pagination->initialize($paging);
        
        if($this->pagination->create_links())
            $data['links'] = $this->pagination->create_links();
        else $data['links'] = '';

        $data['data']['visit_id'] = $visitId;
        $data['data']['pregnant_id'] = $pregnantId;
        //echo "<pre>";
        //print_r($data);
        //echo "</pre>";
        $this->load->view('visit/pregnant_lists', $data);
    }

    function process_form() {
		$ret = array();
		$ret['command'] = "adding data";
        $last_id = $this->Pregnant_Model->DoAddDataPregnant();
        //echo $last_id;
		if($last_id > 0) {
			$ret['msg'] = $this->lang->line('msg_save');
			$ret['status'] = "success";
			$ret['last_id'] = $last_id;
			//$ret['g'] = $this->input->post('g');
		} else {
			$ret['msg'] = $this->lang->line('msg_error_save');
			$ret['status'] = "error";
			$ret['last_id'] = '';
			//$ret['g'] = '';
		}
		echo json_encode($ret);
    }

    function process_form_visit() {
		$ret = array();
		$ret['command'] = "adding data";
        $last_id = $this->Pregnant_Model->DoAddPregnantVisit();
        //echo $last_id;
		if($last_id > 0) {
			$ret['msg'] = $this->lang->line('msg_save');
			$ret['status'] = "success";
			$ret['last_id'] = $last_id;
			$ret['g'] = $this->input->post('g');
		} else {
			$ret['msg'] = $this->lang->line('msg_error_save');
			$ret['status'] = "error";
			$ret['last_id'] = '';
			$ret['g'] = '';
		}
		echo json_encode($ret);
    }

    function process_form_delivery() {
		$ret = array();
		$ret['command'] = "adding data";
        //$a = $_POST;
        //print_r($a);
        $ins = $this->Pregnant_Model->DoAddPregnantDelivery();
        //echo $last_id;
		if($ins === TRUE) {
			$ret['msg'] = $this->lang->line('msg_save');
			$ret['status'] = "success";
			//$ret['last_id'] = $last_id;
			//$ret['g'] = $this->input->post('g');
		} else {
			$ret['msg'] = $this->lang->line('msg_error_save');
			$ret['status'] = "error";
			//$ret['last_id'] = '';
			//$ret['g'] = '';
		}
		echo json_encode($ret);
    }

    function detail($vpId) {
		$data['detail'] = $this->Pregnant_Model->GetDetail($vpId);
        $data['total'] = 0;
        //echo "<pre>";
        //print_r($data);
        //echo "</pre>";
        $this->load->view('visit/pregnant_detail', $data);
    }

    function detail_pregnant($pregnantId) {
		$data['detail'] = $this->Pregnant_Model->GetDetailPregnant($pregnantId);
        $data['total'] = 0;
        //echo "<pre>";
        //print_r($data);
        //echo "</pre>";
        $this->load->view('visit/pregnant_detail_pregnant', $data);
    }

    function detail_delivery($deliveryId) {
		$data['detail'] = $this->Pregnant_Model->GetDetailDelivery($deliveryId);
        $data['total'] = 0;
        //echo "<pre>";
        //print_r($data);
        //echo "</pre>";
        $this->load->view('visit/pregnant_detail_delivery', $data);
    }

    function visit_form($pregnantId) {
        $this->load->view('visit/pregnant_visit_form');
    }

    function visit_add($pregnantId = 0) {
        $this->load->view('visit/pregnant_visit_add');
    }

    function pregnant_tabs($visitId) {
        $data['data']['visit_id'] = $visitId;
        $data['module'] = $this->Pregnant_Model->GetPregnant($visitId);
        $this->load->view('visit/pregnant_tabs', $data);
    }

    function get_total_score_poedji_rochjati_from_pregnant() {
        $score_poedji = $this->Pregnant_Model->GetTotalScorePoedjiRochjatiFromPregnant();
        if($score_poedji > 0) {
            $data['class'] = 'green';
        } elseif($score_poedji > 2) {
            $data['class'] = 'yellow';
        } else {
            $data['class'] = 'red';
        }
        echo $score_poedji;
    }

    function get_total_score_poedji_rochjati() {
        $score_poedji = $this->Pregnant_Model->GetTotalScorePoedjiRochjati();
        if($score_poedji > 0) {
            $data['class'] = 'green';
        } elseif($score_poedji > 2) {
            $data['class'] = 'yellow';
        } else {
            $data['class'] = 'red';
        }
        echo $score_poedji;
    }

    function get_age_of_pregnant($pregnantId, $deliveryDate='') {
        if(!$deliveryDate) $deliveryDate = date('Y-m-d');
        else $deliveryDate = getYMD(str_replace("-", "/", $deliveryDate));
        //echo $deliveryDate;
        $datediff = $this->Pregnant_Model->GetDateDiffHPHT($pregnantId, $deliveryDate);
        echo $datediff;
    }

/*
    function prints($seId) {
		$data['detail'] = $this->Pregnant_Model->GetDetail($seId);
        $this->load->view('_header_print');
        $this->load->view('visit/pregnant_prints', $data);
        $this->load->view('_footer_print');
    }
    */
//VIEW//
    function _view($data = array()) {
        $this->load->view('visit/pregnant', $data);
    }
}
