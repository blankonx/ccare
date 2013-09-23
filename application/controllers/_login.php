<?php

Class Login extends Controller {
    
    var $title = 'Login';

    function __construct() {
        parent::Controller();
        $this->load->model('Login_Model');
    }
    
    function index() {
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('login', array('title' => $this->title, '_profile' => $profile['_profile']));
    }

	function process_form() {
        $ret['command'] = "login process";
		$data = $this->Login_Model->GetData();
		if(!empty($data)) {
			if($data['pwd'] != md5($this->input->post('pwd'))) {
				$ret['msg'] = $this->lang->line('msg_pwd_not_match');
				$ret['status'] = "error";
			} else {
				//redirect
                $this->session->set_userdata($data);
				$ret['msg'] = $this->lang->line('msg_success') . ', ' . $this->lang->line('msg_please_wait');
				$ret['status'] = "success";
			}
		} else {
			$ret['msg'] = $this->lang->line('msg_data_not_found');
			$ret['status'] = "error";
		}
		echo json_encode($ret);
	}

	function logout() {
        $ret['command'] = "logout process";
        //$this->session->set_userdata('menu', array());
        $this->session->sess_destroy();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('login', array('title' => $this->title, 'msg' => 'Logged Out', 'msg_class' => 'success', '_profile' => $profile['_profile']));
	}
}
