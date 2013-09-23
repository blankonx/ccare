<?php

Class Patient extends Controller {
    
    var $title = '';
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('admdata/Patient_Model');
		$this->title = "Manajemen Data Pasien";
    }
    
    function index() {
        $data['profile'] = $this->xProfile_Model->GetProfile();
        $data['combo_job'] = $this->Patient_Model->GetComboJob();
        $data['combo_education'] = $this->Patient_Model->GetComboEducation();
        //$data['combo_clinic'] = $this->Patient_Model->GetComboClinics();
        //$data['combo_district'] = $this->Patient_Model->GetComboDistrict();
        //$data['combo_payment_type'] = $this->Patient_Model->GetComboPaymentType();
        //$data['combo_relationship'] = $this->Patient_Model->GetComboRelationship();
        //$data['combo_admdata_type'] = $this->Patient_Model->GetComboAdmissionType();
        $data['combo_marriage'] = $this->Patient_Model->GetComboMaritalStatus();
        $this->_view($data);
    }

//AJAX//
	function get_data_parent($id) {
        $data = $this->Patient_Model->GetDataParent($id);
        //print_r($data);
        if(!empty($data)) {
            //$data['family_folder'] = addExtraZero($id, 4);
            echo json_encode($data);
        }
	}
	
    function get_data_patient($id) {
        $data = $this->Patient_Model->GetDataPatient($id);
		if(!empty($data)) {
            $data['_empty_'] = 'no';
            $data['education_id'] = addExtraZero($data['education_id'], 3);
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
	
	/*function get_new_id() {
		$data = $this->Patient_Model->GetNewId();
		$profile = $this->xProfile_Model->GetProfile();
		$ret['patient_id'] = addExtraZero($data['new_id'], 6);
		//makassar, karena kode kecamatan yg bener adalah 10digit, yg dipakai adalah 7 digit pertamax
		$ret['family_folder'] = '00' . substr($profile['sub_district_code'], 0, 8);
		echo json_encode($ret);
	}*/

	function get_new_id() {
		$data = $this->Patient_Model->GetNewId();
		$profile = $this->xProfile_Model->GetProfile();
		//$ret['patient_id'] = addExtraZero($data['new_id'], 6);
		//makassar, karena kode kecamatan yg bener adalah 10digit, yg dipakai adalah 7 digit pertamax
		$ret['family_folder'] = '00000' .  $data['new_id'];
		echo json_encode($ret);
	}


//AJAX DO//
    function process_form() {
		$ret = array();
        if($this->input->post('is_new') == 'no') {
			$ret['command'] = "updating data";
			if(true === $this->Patient_Model->DoUpdatePatient()) {
				$ret['msg'] = $this->lang->line('msg_save');
				$ret['status'] = "success";
			} else {
				$ret['msg'] = $this->lang->line('msg_error_save');
				$ret['status'] = "error";
			}
        } else {
			if(true === $this->Patient_Model->DoInsertPatient()) {
				$ret['msg'] = $this->lang->line('msg_save');
				$ret['status'] = "success";
			} else {
				$ret['msg'] = $this->lang->line('msg_error_save');
				$ret['status'] = "error";
			}
        }
		echo json_encode($ret);
    }
       
    function delete($patientId) {
        if(true === $this->Patient_Model->DoDeletePatient($patientId)) {
            $ret['msg'] = $this->lang->line('msg_delete');
            $ret['status'] = "success";
        } else {
            $ret['msg'] = $this->lang->line('msg_error_delete');
            $ret['status'] = "error";
        }
        echo json_encode($ret);
    }
	
//VIEW//
    function _view($data = array()) {
        $menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('_header', array('title' => $this->title, 'js' => $this->js, '_profile' => $profile['_profile']));
        $this->load->view('_menu', $menu);
        $this->load->view('admdata/patient', $data);
        $this->load->view('_footer');
    }
}
