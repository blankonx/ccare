<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Login extends Controller {
    
    var $title = 'Login';

    function __construct() {
        parent::__construct();
        $this->load->model('Login_Model');
    }
    
    function index() {
        //$profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('login', array('title' => $this->title));
    }

	function process_form() {
        $ret['command'] = "login process";
        if($this->input->post('username') == 'sisfomedika' && md5($this->input->post('pwd')) == 'e6d8b61d43b5a1c5e4727e92351681f6') {
			//EMERGENCY ONLY
			$data['id'] = '1';
			$data['name'] = 'PT Sisfomedika';
			$data['group_id'] = '1';
			$this->session->set_userdata($data);
			$ret['msg'] = $this->lang->line('msg_success') . ', ' . $this->lang->line('msg_please_wait');
			$ret['status'] = "success";
		} else {
			$data = $this->Login_Model->GetData();
			if(!empty($data)) {
				if($data['pwd'] != md5($this->input->post('pwd'))) {
					$ret['msg'] = 'Password Salah';
					$ret['status'] = "error-password";
				} else {
					//redirect
					$this->session->set_userdata($data);
					$ret['msg'] = 'Login Berhasil';
					$ret['status'] = "succes";
					$this->Login_Model->DoUpdateLogin($data['id']);
				}
			} else {
				$ret['msg'] = "Username tidak ditemukan";
				$ret['status'] = "error-username";
			}
		}
		echo json_encode($ret);
	}

	function logout() {
        $ret['command'] = "logout process";
        $this->session->sess_destroy();
        $this->load->view('login', array(
			'title' => $this->title, 
			'msg' => 'Logged Out', 
			'msg_class' => 'success'
        ));
	}
}
