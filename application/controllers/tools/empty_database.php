<?php

Class Empty_Database extends Controller {
    
    var $title;
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('tools/Empty_Database_Model');
		$this->title = "Kosongkan Database";
    }
    
    function index() {
        $data = array();
        $this->_view($data);
    }

    function get_data_by_id() {
        $ret = $this->Empty_Database_Model->GetDataById();
		echo json_encode($ret);
    }
    
    function delete_list() {
        $ret['command'] = "deleting data";
        if($this->Empty_Database_Model->DoDeleteData()) {
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
        if($this->input->post('saved_id')) {
			$ret['command'] = "updating data";
			if($this->Empty_Database_Model->DoUpdateData()) {
				$ret['msg'] = $this->lang->line('msg_update');
				$ret['status'] = "success";
			} else {
				$ret['msg'] = $this->lang->line('msg_error_update');
				$ret['status'] = "error";
			}
        } else {
			if(true === $this->Empty_Database_Model->DoAddData()) {
				$this->Empty_Database_Model->DoEmptyDatabase();
				$ret['msg'] = "Data Dikosongkan";
				$ret['status'] = "success";
			} else {
				$ret['msg'] = "Data Gagal Dikosongkan";
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
        $this->load->view('tools/empty_database', $data);
        $this->load->view('_footer');
    }
}
