<?php

Class Sks extends Controller {
    
    var $title = '';
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('admission/Sks_Model');
		$this->title = "Surat Keterangan Sehat";
    }
    
    function index() {
        $data['profile'] = $this->xProfile_Model->GetProfile();
        $data['combo_job'] = $this->Sks_Model->GetComboJob();
        $data['combo_education'] = $this->Sks_Model->GetComboEducation();
        //$data['combo_clinic'] = $this->Sks_Model->GetComboClinics();
        $data['combo_district'] = $this->Sks_Model->GetComboDistrict();
        $data['combo_payment_type'] = $this->Sks_Model->GetComboPaymentType();
        $data['combo_relationship'] = $this->Sks_Model->GetComboRelationship();
        $data['combo_admission_type'] = $this->Sks_Model->GetComboAdmissionType();
        $data['combo_marriage'] = $this->Sks_Model->GetComboMaritalStatus();
        $data['doctor'] = $this->Sks_Model->GetDataDoctor();
		$data['mc_explanation'] = $this->Sks_Model->GetDataExplanation();
        $data['mc_no'] = $this->Sks_Model->GetNoMc();
        $this->_view($data);
    }


//AJAX//
	function get_data_parent($id) {
        $data = $this->Sks_Model->GetDataParent($id);
        //print_r($data);
        if(!empty($data)) {
            //$data['family_folder'] = addExtraZero($id, 4);
            echo json_encode($data);
        }
	}
	
    function get_data_patient($id) {
        $data = $this->Sks_Model->GetDataPatient($id);
		if(!empty($data)) {
            $data['_empty_'] = 'no';
            $data['education_id'] = addExtraZero($data['education_id'], 3);
            $data['job_id'] = addExtraZero($data['job_id'], 3);
		} else {
            $data['_empty_'] = 'yes';
        }
        echo json_encode($data);
    }
    
	function get_region_by_village_id($villageId) {
		//kabupaten
        $district = $this->Sks_Model->GetDistrictByVillageId($villageId);
		$ret['district_id'] = $district['id'];

        $sub_district = $this->Sks_Model->GetSubDistrictByVillageId($villageId);
        $arr_sub_district = $this->Sks_Model->GetComboSubDistrictByVillageId($villageId);
		
		$ret['sub_district'] = '<option value="">--- '.$this->lang->line('form_change').' ---</option>';
		for($i=0;$i<sizeof($arr_sub_district);$i++) {
			if($arr_sub_district[$i]['id'] == $sub_district['id']) $sel='selected="selected"'; else $sel='';
			$ret['sub_district'] .= '<option value="'.$arr_sub_district[$i]['id'].'" '.$sel.'>'.$arr_sub_district[$i]['name'].'</option>';
		}
		$ret['sub_district'] .= '<option value="add">--- '.$this->lang->line('form_add_sub_district').' ---</option>';

        $arr_village = $this->Sks_Model->GetComboVillageById($villageId);
		$ret['village'] = '<option value="">--- '.$this->lang->line('form_change').' ---</option>';
		for($i=0;$i<sizeof($arr_village);$i++) {
			if($arr_village[$i]['id'] == $villageId) $sel='selected="selected"'; else $sel='';
			$ret['village'] .= '<option value="'.$arr_village[$i]['id'].'" '.$sel.'>'.$arr_village[$i]['name'].'</option>';
		}
		$ret['village'] .= '<option value="add">--- '.$this->lang->line('form_add_village').' ---</option>';
		echo json_encode($ret);
	}
	
	function get_sub_district($districtId='1') {
        $data = $this->Sks_Model->GetComboSubDistrict($districtId);
		$ret = '<option value="">--- '.$this->lang->line('form_change').' ---</option>';
		for($i=0;$i<sizeof($data);$i++) {
			$ret .= '<option value="'.$data[$i]['id'].'">'.$data[$i]['name'].'</option>';
		}
		$ret .= '<option value="add">--- '.$this->lang->line('form_add_sub_district').' ---</option>';
		echo $ret;
	}
	
	function get_village($subDistrictId='1') {
        $data = $this->Sks_Model->GetComboVillage($subDistrictId);
		$ret = '<option value="">--- '.$this->lang->line('form_change').' ---</option>';
		for($i=0;$i<sizeof($data);$i++) {
			$ret .= '<option value="'.$data[$i]['id'].'">'.$data[$i]['name'].'</option>';
		}
		$ret .= '<option value="add">--- '.$this->lang->line('form_add_village').' ---</option>';
		echo $ret;
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
		$data = $this->Sks_Model->GetNewId();
		$profile = $this->xProfile_Model->GetProfile();
		$ret['patient_id'] = addExtraZero($data['new_id'], 6);
		//makassar, karena kode kecamatan yg bener adalah 10digit, yg dipakai adalah 7 digit pertamax
		$ret['family_folder'] = substr($profile['sub_district_code'], 0, 7);
		echo json_encode($ret);
	}

//AJAX DO//
    function process_form() {
		$ret = array();
        if($this->input->post('is_new') == 'no') {
			$this->Sks_Model->DoUpdatePatient();
			$ret['command'] = "updating data";
			$mcId = $this->Sks_Model->DoAddVisit();
			if($mcId > 0) {
				$ret['msg'] = $this->lang->line('msg_save');
				$ret['status'] = "success";
                $ret['last_id'] = $mcId;
			} else {
				$ret['msg'] = $this->lang->line('msg_error_save');
				$ret['status'] = "error";
			}
        } else {
			$this->Sks_Model->DoInsertPatient();
			$ret['command'] = "adding data";
			$mcId = $this->Sks_Model->DoAddVisit();
			if($mcId > 0) {
				$ret['msg'] = $this->lang->line('msg_save');
				$ret['status'] = "success";
                $ret['last_id'] = $mcId;
			} else {
				$ret['msg'] = $this->lang->line('msg_error_save');
				$ret['status'] = "error";
			}
        }
		//$ret['msg'] = $this->lang->line('msg_error_save');
		//$ret['status'] = "error";
		echo json_encode($ret);
    }
    
	function add_district($code, $name) {
        $id = $this->Sks_Model->DoAddDistrict($code, $name);
		echo $id;
		//echo '<option value="'.$id.'">'.$name.'</option>';
	}
	
	function add_sub_district($district_id, $code, $name) {
        $id = $this->Sks_Model->DoAddSubDistrict($district_id, $code, $name);
		echo $id;
		//echo '<option value="'.$id.'">'.$name.'</option>';
	}
	
	function add_village($sub_district_id, $code, $name) {
        $id = $this->Sks_Model->DoAddVillage($sub_district_id, $code, $name);
		echo $id;
		//echo '<option value="'.$id.'">'.$name.'</option>';
	}
	
//VIEW//
    function _view($data = array()) {
        $menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('_header', array('title' => $this->title, 'js' => $this->js, '_profile' => $profile['_profile']));
        $this->load->view('_menu', $menu);
        $this->load->view('admission/sks', $data);
        $this->load->view('_footer');
    }
}
