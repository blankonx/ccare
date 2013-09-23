<?php
Class Indoor extends Controller {
    
    var $title = '';
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('admission/Indoor_Model');
		$this->title = $this->lang->line('label_indoor_admission');
    }
    
    function index() {
		$data = array();
        $data['profile'] = $this->xProfile_Model->GetProfile();
        $data['combo_job'] = $this->Indoor_Model->GetComboJob();
        //$data['combo_education'] = $this->Indoor_Model->GetComboEducation();
        $data['combo_payment_type'] = $this->Indoor_Model->GetComboPaymentType();
        $data['combo_marriage'] = $this->Indoor_Model->GetComboMaritalStatus();
		$data['combo_religion'] = $this->Indoor_Model->GetComboReligionStatus();
		$data['continue'] = $this->Indoor_Model->GetDataContinue();
        $this->_view($data);
    }
    
    function getDataJamkesda($nik, $name, $birth_date) {
		$return = array();
		
		//nik
		//$content = file_get_contents($this->config->item('xml_addr_jamkesda') . '/nik/' . $nik);
		$content = file_get_contents($this->config->item('xml_addr_jamkesda') . '/namapeserta/' . rawurlencode($name) . '/dob/' . $birth_date);
		$xml = new SimpleXMLElement($content);
		$arr = get_object_vars($xml);
		$item = get_object_vars($xml->item);
		//print_r($arr);
		//echo $xml['item']['id_jamkesda'];
		if($arr['status'] == 'Success' && $arr['jml'] == 1) {
			$return['jml'] = 1;
			$return['id_jamkesda'] = $item['id_jamkesda'];
			$return['nama_peserta'] = $item['nama_peserta'];
		} elseif($arr['status'] == 'Success' && $arr['jml'] > 1) {
			$return['jml'] = $arr->jml;
			$i=0;
			foreach($item as $key => $val) {
				$return[$i]['id_jamkesda'] = $val['id_jamkesda'];
				$return[$i]['nama_peserta'] = $val['nama_peserta'];
				$i++;
			}
		} else {
			//nama & dob
			$content = file_get_contents($this->config->item('xml_addr_jamkesda') . '/namapeserta/' . $name . '/dob/' . $birth_date);
			$arr = new SimpleXMLElement($content);
			if($arr->status == 'Success' && $arr->jml == 1) {
				$return['jml'] = 1;
			$return['id_jamkesda'] = $item['id_jamkesda'];
			$return['nama_peserta'] = $item['nama_peserta'];
			} elseif($arr->status == 'Success' && $arr->jml > 1) {
				$return['jml'] = $arr->jml;
				$i=0;
				foreach($item as $key => $val) {
				$return[$i]['id_jamkesda'] = $val['id_jamkesda'];
				$return[$i]['nama_peserta'] = $val['nama_peserta'];
					$i++;
				}
			} else {
				$return[$i]['id_jamkesda'] = 'asdf';
				$return[$i]['nama_peserta'] = 'asdfasdf';
			}
		}
		
		echo json_encode($return);
		//get value by elementname
		//echo $xml->item->nama_peserta;
	}


//AJAX//
	function get_list_tempat_lahir($id) {
        $data = $this->Indoor_Model->GetListTempatLahir();
        for($i=0;$i<sizeof($data);$i++) {
            echo $data[$i]['birth_place'] . "\n";
        }
	}
    
    function get_list_Rs() {
        $data = $this->Indoor_Model->GetListRs();
        for($i=0;$i<sizeof($data);$i++) {
            echo $data[$i]['rumahsakit'] . "\n";
        }
    }

	function get_list_Specialis() {
        $data = $this->Indoor_Model->GetListSpecialis();
        for($i=0;$i<sizeof($data);$i++) {
            echo $data[$i]['specialis'] . "\n";
        }
    }
   
	function get_data_patient($id) {
        $data = $this->Indoor_Model->GetDataPatient($id);
		if(!empty($data)) {
            $data['_empty_'] = 'no';
           // $data['education_id'] = addExtraZero($data['education_id'], 3);
            $data['job_id'] = addExtraZero($data['job_id'], 3);
		} else {
            $data['_empty_'] = 'yes';
        }
        echo json_encode($data);
    }
    
    	
	function hitung_usia($d, $m, $y) {
		$usia = array();
        if($d && $m && $y) {
            $usia = getAge($d . '/' . $m . '/' . $y);
        }
		echo json_encode($usia);
	}
	
	function get_tgl_lahir($thn=0, $bln=0, $hari=0) {
		$ret = @date("d/m/Y", @mktime(1, 1, 1, date('m')-$bln, date('d')-$hari, date('Y')-$thn));
		echo $ret;
	}
	
	function get_new_id() {
		$data = $this->Indoor_Model->GetNewId();
		$profile = $this->xProfile_Model->GetProfile();
		//$ret['patient_id'] = addExtraZero($data['new_id'], 6);
		//makassar, karena kode kecamatan yg bener adalah 10digit, yg dipakai adalah 7 digit pertamax
		$ret['family_folder'] = '00000' .  $data['new_id'];
		echo json_encode($ret);
	}

//AJAX DO//
	/*function process_form() {
		$ret = array();
		$ret['command'] = "adding data";
        //print_r($this->input->post('icd_id'));
		if($this->General_Checkup_Model->DoAddData()) {
			$ret['msg'] = $this->lang->line('msg_save');
			$ret['status'] = "success";
		} else {
			$ret['msg'] = $this->lang->line('msg_error_save');
			$ret['status'] = "error";
		}
		echo json_encode($ret);
    } 
	*/

    function process_form() {
		$ret = array();
        if($this->input->post('is_new') == 'no') {
			$this->Indoor_Model->DoUpdatePatient();
			$visitId = $this->Indoor_Model->DoAddVisit();
			$this->Indoor_Model->DoAddData($visitId);
			$ret['command'] = "updating data";			
			
			if($visitId > 0) {
				$ret['msg'] = $this->lang->line('msg_save');
				$ret['status'] = "success";
			} else {
				$ret['msg'] = $this->lang->line('msg_error_save');
				$ret['status'] = "error";
			}
        } else {
			$this->Indoor_Model->DoInsertPatient();
			$ret['command'] = "adding data";
			$visitId = $this->Indoor_Model->DoAddVisit();
			$this->Indoor_Model->DoAddData($visitId);
			
			if($visitId > 0) {
				$ret['msg'] = $this->lang->line('msg_save');
				$ret['status'] = "success";
			} else {
				$ret['msg'] = $this->lang->line('msg_error_save');
				$ret['status'] = "error";
			}
        }
		
		echo json_encode($ret);
    }
    
 //Controller untuk form input pemeriksaan//
	function home($visitId, $mode='',$n=0) {
        return $this->result($visitId,$mode,$n);
    }

    function result($visit_id,$mode='',$n=0) {
		$data['data'] = $this->Indoor_Model->GetData($visit_id);
		$age = getAge($data['data']['birth_date'], $data['data']['visit_date']);    
		$data['data']['age'] = $age;

		$data['checkup'] = $this->Indoor_Model->GetDataGeneral_Checkup($visit_id);
		$data['diagnoses'] = $this->Indoor_Model->GetDataDiagnoses($visit_id);
		$data['prescribes'] = $this->Indoor_Model->GetDataPrescribes($visit_id);
		$data['prescribes_mix'] = $this->Indoor_Model->GetDataPrescribesMix($visit_id);
		$data['treatments'] = $this->Indoor_Model->GetDataTreatments($visit_id);
		//$data['doctor'] = $this->Indoor_Model->GetDataDoctor();
		$data['continue'] = $this->Indoor_Model->GetDataContinue();
		$data['mc_explanation'] = $this->Indoor_Model->GetDataExplanation();
		$data['mode']=$mode;		
        //echo $diagnose[1]['name'];
        //print_r($data['diagnoses']);

        $this->_view($data);
    }
	
	function printout($visitId, $title="") {
		$this->load->model('xProfile_Model');
		$data['profile'] = $this->xProfile_Model->GetProfile();
		
		$data['patient'] = $this->Indoor_Model->GetDataPatient($visitId);
		$data['diagnoses'] = $this->Indoor_Model->GetDataDiagnosesForPrint($visitId);
		$data['prescribes'] = $this->Indoor_Model->GetDataPrescribesForPrint($visitId);
		$data['prescribes_mix'] = $this->Indoor_Model->GetDataPrescribesMixForPrint($visitId);
		$data['treatments'] = $this->Indoor_Model->GetDataTreatmentsForPrint($visit_id);
		
		//$this->load->view('visit/general_checkup_print', $data);
		$this->load->view('admission/general_checkup_print', $data);
	}

    function get_list_anamnese() {
		$arr_q = explode(";", $this->input->post('q'));
        $data = $this->Indoor_Model->GetListExpertAnamneseDiagnose($arr_q);

        for($i=0;$i<sizeof($data);$i++) {
            $arr_name[$i] = explode(";", $data[$i]['name']);

			for($j=0;$j<sizeof($arr_q);$j++) {
                $arr_q[$j] = trim($arr_q[$j]);
                $key_delete = array_search($arr_q[$j], $arr_name[$i]);
                if($key_delete !== false) {
                    unset($arr_name[$i][$key_delete]);
                }
			}
            $name = implode('; ', $arr_name[$i]);
			echo $data[$i]['id'] . "|" . $data[$i]['icd_id'] . "|" . $name . "|" . $data[$i]['name'] . "|" . $data[$i]['icd_name'] . "|" . $data[$i]['case'] . "|" . $data[$i]['icd_code'];
			echo "\n";
        }
    }

    function get_list_icd() {
        $data = $this->Indoor_Model->GetListIcd($this->input->post('q'));
        for($i=0;$i<sizeof($data);$i++) {
            echo $data[$i]['name'] . "|" . $data[$i]['id'] . "|" . $data[$i]['code'] . "\n";
        }
    }

    function get_new_old_case() {
        $data = $this->Indoor_Model->GetNewOldCase();
        //print_r($data);
        if(!empty($data)) {
            echo 'old';
        } else {
            echo 'new';
        }
    }

    function get_list_drug() {
        $data = $this->Indoor_Model->GetListDrug();
        for($i=0;$i<sizeof($data);$i++) {
            echo $data[$i]['name'] . "|" . $data[$i]['id'] . "|" . $data[$i]['unit'] . "|" . $data[$i]['stock'] . "\n";
        }
    }

    function get_list_treatment() {
        $data = $this->Indoor_Model->GetListTreatment($this->input->post('q'));
        for($i=0;$i<sizeof($data);$i++) {
            echo $data[$i]['name'] . "|" . $data[$i]['id'] . "|" . $data[$i]['price'] . "|" . $data[$i]['category'] . "\n";
        }
    }

    function delete_anamnese_diagnose() {
		$ret['command'] = "deleting data";
		if($this->Indoor_Model->DoDeleteAnamneseDiagnose()) {
			$ret['msg'] = $this->lang->line('msg_delete');
			$ret['status'] = "success";
		} else {
			$ret['msg'] = $this->lang->line('msg_error_delete');
			$ret['status'] = "error";
		}
		echo json_encode($ret);
    }

    function delete_prescribe() {
		$ret['command'] = "deleting data";
		if($this->Indoor_Model->DoDeletePrescribe()) {
			$ret['msg'] = $this->lang->line('msg_delete');
			$ret['status'] = "success";
		} else {
			$ret['msg'] = $this->lang->line('msg_error_delete');
			$ret['status'] = "error";
		}
		echo json_encode($ret);
    }
    function delete_treatment() {
		$ret['command'] = "deleting data";
		if($this->Indoor_Model->DoDeleteTreatment()) {
			$ret['msg'] = $this->lang->line('msg_delete');
			$ret['status'] = "success";
		} else {
			$ret['msg'] = $this->lang->line('msg_error_delete');
			$ret['status'] = "error";
		}
		echo json_encode($ret);
    }

    function delete_prescribe_mix() {
		$ret['command'] = "deleting data";
		if($this->Indoor_Model->DoDeletePrescribeMix()) {
			$ret['msg'] = $this->lang->line('msg_delete');
			$ret['status'] = "success";
		} else {
			$ret['msg'] = $this->lang->line('msg_error_delete');
			$ret['status'] = "error";
		}
		echo json_encode($ret);
    }
 
 //End Controller untuk form input pemeriksaan//    
    	
//VIEW//
    function _view($data = array()) {
        $menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('_header', array('title' => $this->title, 'js' => $this->js, '_profile' => $profile['_profile']));
        $this->load->view('_menu', $menu);
        $this->load->view('admission/indoor', $data);
        $this->load->view('_footer');
    }
}
