<?php

Class Clinic extends Controller {
    
    var $title;
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('admdata/Clinic_Model');
        $this->js[] = "jquery/js/jquery.jeditable.js";
		$this->title = $this->lang->line('label_indoor_clinics');
    }
    
    function index() {
        $data['combo_clinic'] = $this->Clinic_Model->GetComboCategory();
        $this->_view($data);
    }

	//AJAX DO//

    function delete_list() {
        $ret['command'] = "deleting data";
        if($this->Clinic_Model->DoDeleteData()) {
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
		if($this->Clinic_Model->DoAddData()) {
			$ret['msg'] = $this->lang->line('msg_save');
			$ret['status'] = "success";
		} else {
			$ret['msg'] = $this->lang->line('msg_error_save');
			$ret['status'] = "error";
		}
		echo json_encode($ret);
    }

    function update_name() {
        $ret['command'] = "updating data";
        $ret['value'] = $this->input->post('value');
        if($this->Clinic_Model->DoUpdateName()) {
            $ret['msg'] = $this->lang->line('msg_update');
            $ret['status'] = "success";
        } else {
            $ret['msg'] = $this->lang->line('msg_error_update');
            $ret['status'] = "error";
        }
		echo json_encode($ret);
    }

	function update_active() {
        $ret['command'] = "activating data";
        $ret['value'] = $this->input->post('active');
        if($this->Clinic_Model->DoUpdateActive()) {
            $ret['msg'] = $this->lang->line('msg_update');
            $ret['status'] = "success";
        } else {
            $ret['msg'] = $this->lang->line('msg_error_update');
            $ret['status'] = "error";
        }
		echo json_encode($ret);
	}

	function update_visible() {
        $ret['command'] = "hiding data";
        $ret['value'] = $this->input->post('visible');
        if($this->Clinic_Model->DoUpdateVisible()) {
            $ret['msg'] = $this->lang->line('msg_update');
            $ret['status'] = "success";
        } else {
            $ret['msg'] = $this->lang->line('msg_error_update');
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
        $this->load->view('admdata/clinic', $data);
        $this->load->view('_footer');
    }
}
