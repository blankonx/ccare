<?php

Class Treatment extends Controller {
    
    var $title;
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('admdata/Treatment_Model');
        $this->js[] = "jquery/js/jquery.jeditable.js";
		$this->title = $this->lang->line('label_treatment');
    }
    
    function index() {
        //xajax
        $data['combo_categories'] = $this->Treatment_Model->GetComboCategory();
        $data['payment_type'] = $this->Treatment_Model->GetComboPaymentType();
        $this->_view($data);
    }

    function get_data_by_id() {
        $ret = $this->Treatment_Model->GetDataById();
		echo json_encode($ret);
    }

	//AJAX DO//

    function delete_list() {
        $ret['command'] = "deleting data";
        if($this->Treatment_Model->DoDeleteData()) {
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
			if($this->Treatment_Model->DoUpdateData()) {
				$ret['msg'] = $this->lang->line('msg_update');
				$ret['status'] = "success";
			} else {
				$ret['msg'] = $this->lang->line('msg_error_update');
				$ret['status'] = "error";
			}
        } else {
			$ret['command'] = "adding data";
			if($this->Treatment_Model->DoAddData()) {
				$ret['msg'] = $this->lang->line('msg_save');
				$ret['status'] = "success";
			} else {
				$ret['msg'] = $this->lang->line('msg_error_save');
				$ret['status'] = "error";
			}
        }
		echo json_encode($ret);
    }

    function update_name() {
        $ret['command'] = "updating data";
        $ret['value'] = $this->input->post('value');
        if($this->Treatment_Model->DoUpdateName()) {
            $ret['msg'] = $this->lang->line('msg_update');
            $ret['status'] = "success";
        } else {
            $ret['msg'] = $this->lang->line('msg_error_update');
            $ret['status'] = "error";
        }
		echo json_encode($ret);
    }

    function update_price() {
        $ret['command'] = "updating data";
        $ret['value'] = $this->input->post('value');
        if($this->Treatment_Model->DoUpdatePrice()) {
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
        $this->load->view('admdata/treatment', $data);
        $this->load->view('_footer');
    }
}
