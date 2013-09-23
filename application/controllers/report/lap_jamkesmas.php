<?php
Class Lap_Jamkesmas extends Controller {
	var $title = 'Laporan Jamkesmas';
	var $report_title = 'Laporan Jamkesmas';

	function __construct() {
		parent::Controller();
		if(!$this->session->userdata('id')) redirect('login');
		$this->load->model('report/Lap_Jamkesmas_Model');
		//$this->load->library('zip');
	}
    
	function index($ret="") {
        $data['service_status'] = $this->session->flashdata('service_status');
		$data['profile'] = $this->xProfile_Model->GetProfile();
		$data['combo_payment_type'] = $this->Lap_Jamkesmas_Model->GetComboPaymentType();
		$this->_view($data);	      	
	}
    
    function ping_server() {
        require_once APPPATH . "libraries/ping.php";
		$profile = $this->xProfile_Model->GetProfile();
        $parse = parse_url(prep_url($profile['url_service_server']));
        ping::site($parse['host']);
    }
	
	function process_form() {
		/*
		 * query untuk ngedump menjadi file sql
		 * */
        $profile = $this->xProfile_Model->GetProfile();
        $visit = $this->Lap_Jamkesmas_Model->BackupVisits($periode,$profile);
		$periode = $this->input->post('day_start') . "-" . $this->input->post('month_start') . "-" . $this->input->post('year_start') . "_";
		$periode .= $this->input->post('day_end') . "-" . $this->input->post('month_end') . "-" . $this->input->post('year_end');
		$vis = "";

		if($this->input->post('payment_type_id') != '') {
			$data['report_title'] .= ' Jenis Pasien ' . $this->Lap_Jamkesmas_Model->GetDataPaymentTypeName($this->input->post('payment_type_id'));
		}
		
        for($i=0;$i<sizeof($visit);$i++) {
			//nik,nama_pasien, tgl_lahir, umur,jenis kelamin,tgl_kunjungan, nama_status_jaminan, kode icdx, deskripsi tindakanmedis,ttotal biaya, kode_klinik

            $usia = getAge($visit[$i]['birth_date'], $visit[$i]['visit_date']);
            $vis .= $visit[$i]['nik'] . ";";
			$vis .= $visit[$i]['name'].';'; 
			$vis .= $visit[$i]['birth_date'].';'; 
			$vis .= $usia['year'] . ';';
            $vis .= $usia['month'] . ';';
            $vis .= $usia['day'] . ';';
			$vis .= $visit[$i]['sex'] . ';';
			$vis .= $visit[$i]['visit_date'] . ';';
			$vis .= $visit[$i]['kode_jaminan'] . ';';
			$vis .= $visit[$i]['icd_code'] . ';';
			$vis .= $visit[$i]['treatment'] . ';';
			$vis .= $visit[$i]['total'] . ';';
			$vis .= $visit[$i]['kode_klinik'] . "\n";
        }

        if($this->input->post('metode') == "service") {
            require_once APPPATH . "libraries/nusoap.php";
            $this->load->helper('url');
            $client = new nusoap_client(prep_url($profile['url_service_server']) . "/services/receive_report/wsdl");
            $result = $client->call('receive_report', array($profile['code'], $periode, $gel));
            //echo $profile['url_service_server'] . "/services/receive_report/wsdl";
            
            if ($client->fault) {
                $this->session->set_flashdata('service_status', 'Gagal Mengirim Data ke Server. Kode 1');
                //echo '<h2>Fault</h2><pre>';
                //print_r($result);
                //echo '</pre>';
            } else {
                // Check for errors
                $err = $client->getError();
                if ($err) {
                    $this->session->set_flashdata('service_status', 'Gagal Mengirim Data ke Server. Kode 2');
                    // Display the error
                    //echo '<h2>Error</h2><pre>' . $err;
                    //print_r($result);
                    //echo '</pre>';
                } else {
                    $this->session->set_flashdata('service_status', $result);
                    // Display the result
                    //echo '<h2>Result</h2><pre>';
                    //print_r($result);
                    //echo '</pre>';
                }
            }
            redirect('report/lap_jamkesmas');
        } else {
				
				$data = array(
                'jamkesmas_'. $periode . "-" . underscore($profile['name']).'.csv' => $vis
            );
			$this->load->library('zip');
			$this->zip->add_data($data);
			$this->zip->archive('.'. dirname($_SERVER['SCRIPT_FILENAME']) .'/webroot/lap_jamkesmas/jamkes_'. $periode . "_" . underscore($profile['name']).'.zip');			
			$datazip = $this->zip->download('jamkes_'. $periode . "_" . underscore($profile['name']).'.zip'); 
        }
	}
	
	function _view($data = array()) {
		$menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('_header', array('title' => $this->title, '_profile' => $profile['_profile']));
		$this->load->view('_menu', $menu);
		$this->load->view('report/lap_jamkesmas', $data);
		$this->load->view('_footer');
	}
	
}
