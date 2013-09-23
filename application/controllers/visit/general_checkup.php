<?php

Class General_Checkup extends Controller {
    
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('visit/General_Checkup_Model');
    }
    
    function index() {
		$data = array();
        //return $this->result();
        $this->_view($data);
    }

    function home($visitId, $mode='',$n=0) {
        return $this->result($visitId,$mode,$n);
    }

    function result($visit_id,$mode='',$n=0) {
		$data['data'] = $this->General_Checkup_Model->GetData($visit_id);
		$age = getAge($data['data']['birth_date'], $data['data']['visit_date']);    
		$data['data']['age'] = $age;

		$data['checkup'] = $this->General_Checkup_Model->GetDataGeneral_Checkup($visit_id);
		$data['diagnoses'] = $this->General_Checkup_Model->GetDataDiagnoses($visit_id);
		$data['prescribes'] = $this->General_Checkup_Model->GetDataPrescribes($visit_id);
		$data['prescribes_mix'] = $this->General_Checkup_Model->GetDataPrescribesMix($visit_id);
		$data['treatments'] = $this->General_Checkup_Model->GetDataTreatments($visit_id);
		$data['doctor'] = $this->General_Checkup_Model->GetDataDoctor();
		$data['continue'] = $this->General_Checkup_Model->GetDataContinue();
		$data['mc_explanation'] = $this->General_Checkup_Model->GetDataExplanation();
		$data['mode']=$mode;		
        //echo $diagnose[1]['name'];
        //print_r($data['diagnoses']);

        $this->_view($data);
    }
	
	function printout($visitId, $title="") {
		$this->load->model('xProfile_Model');
		$data['profile'] = $this->xProfile_Model->GetProfile();
		
		$data['patient'] = $this->General_Checkup_Model->GetDataPatient($visitId);
		$data['diagnoses'] = $this->General_Checkup_Model->GetDataDiagnosesForPrint($visitId);
		$data['prescribes'] = $this->General_Checkup_Model->GetDataPrescribesForPrint($visitId);
		$data['prescribes_mix'] = $this->General_Checkup_Model->GetDataPrescribesMixForPrint($visitId);
		$data['treatments'] = $this->General_Checkup_Model->GetDataTreatmentsForPrint($visitId);
		
		$this->load->view('visit/general_checkup_print', $data);
	}

    function get_list_anamnese() {
		$arr_q = explode(";", $this->input->post('q'));
        $data = $this->General_Checkup_Model->GetListExpertAnamneseDiagnose($arr_q);

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
        $data = $this->General_Checkup_Model->GetListIcd($this->input->post('q'));
        for($i=0;$i<sizeof($data);$i++) {
            echo $data[$i]['name'] . "|" . $data[$i]['id'] . "|" . $data[$i]['code'] . "\n";
        }
    }

    function get_new_old_case() {
        $data = $this->General_Checkup_Model->GetNewOldCase();
        //print_r($data);
        if(!empty($data)) {
            echo 'old';
        } else {
            echo 'new';
        }
    }

    function get_list_drug() {
        $data = $this->General_Checkup_Model->GetListDrug();
        for($i=0;$i<sizeof($data);$i++) {
            echo $data[$i]['name'] . "|" . $data[$i]['id'] . "|" . $data[$i]['unit'] . "|" . $data[$i]['stock'] . "\n";
        }
    }

    function get_list_treatment() {
        $data = $this->General_Checkup_Model->GetListTreatment($this->input->post('q'));
        for($i=0;$i<sizeof($data);$i++) {
            echo $data[$i]['name'] . "|" . $data[$i]['id'] . "|" . $data[$i]['price'] . "|" . $data[$i]['category'] . "\n";
        }
    }
/*
    function delete_diagnose() {
		$ret['command'] = "deleting data";
		if($this->General_Checkup_Model->DoDeleteDiagnose()) {
			$ret['msg'] = $this->lang->line('msg_delete');
			$ret['status'] = "success";
		} else {
			$ret['msg'] = $this->lang->line('msg_error_delete');
			$ret['status'] = "error";
		}
		echo json_encode($ret);
    }
*/
    function delete_anamnese_diagnose() {
		$ret['command'] = "deleting data";
		if($this->General_Checkup_Model->DoDeleteAnamneseDiagnose()) {
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
		if($this->General_Checkup_Model->DoDeletePrescribe()) {
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
		if($this->General_Checkup_Model->DoDeleteTreatment()) {
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
		if($this->General_Checkup_Model->DoDeletePrescribeMix()) {
			$ret['msg'] = $this->lang->line('msg_delete');
			$ret['status'] = "success";
		} else {
			$ret['msg'] = $this->lang->line('msg_error_delete');
			$ret['status'] = "error";
		}
		echo json_encode($ret);
    }

    function process_form() {
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

//VIEW//
    function _view($data = array()) {
        $this->load->view('visit/general_checkup', $data);
    }
}
