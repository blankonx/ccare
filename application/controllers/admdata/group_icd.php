<?php

Class Group_Icd extends Controller {
    
    var $title;
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('admdata/Group_Icd_Model');
        //$this->js[] = "jquery/js/jquery.jeditable.js";
		$this->title = "Data Kelompok Penyakit";
    }
    
    function index() {
        $data = array();
        $this->load->model('xProfile_Model');
        $data['profile'] = $this->xProfile_Model->GetProfile();
        //$data['combo_district'] = $this->Group_Icd_Model->GetComboDistrict();
        $this->_view($data);
    }

    function get_data_by_id() {
        $ret = $this->Group_Icd_Model->GetDataById();
		echo json_encode($ret);
    }
    
    function delete_icd($gid) {
        $ret['command'] = "deleting data";
        if($this->Group_Icd_Model->DoDeleteDetail($gid)) {
            $ret['msg'] = $this->lang->line('msg_delete');
            $ret['status'] = "success";
        } else {
            $ret['msg'] = $this->lang->line('msg_error_delete');
            $ret['status'] = "error";
        }
		echo json_encode($ret);
    }
    
    function delete_list() {
        $ret['command'] = "deleting data";
        if($this->Group_Icd_Model->DoDeleteData()) {
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
        if($this->input->post('id')) {
			$ret['command'] = "updating data";
			if($this->Group_Icd_Model->DoUpdateData()) {
				$ret['msg'] = $this->lang->line('msg_update');
				$ret['status'] = "success";
			} else {
				$ret['msg'] = $this->lang->line('msg_error_update');
				$ret['status'] = "error";
			}
        } else {
			$ret['command'] = "adding data";
			$last_id = $this->Group_Icd_Model->DoAddData();
			if($last_id > 0) {
				$ret['msg'] = $this->lang->line('msg_save');
				$ret['status'] = "success";
			} else {
				$ret['msg'] = $this->lang->line('msg_error_save');
				$ret['status'] = "error";
			}
        }
		echo json_encode($ret);
    }

//VIEW//
    function _view($data = array()) {
        $menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('_header', array('title' => $this->title, 'js' => $this->js, '_profile' => $profile['_profile']));
        $this->load->view('_menu', $menu);
        $this->load->view('admdata/group_icd', $data);
        $this->load->view('_footer');
    }
}
