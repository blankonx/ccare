<?php

Class Profile extends Controller {
    
    var $title;
    var $js = array();

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('admdata/Profile_Model');
		$this->title = $this->lang->line('label_profile');
    }
    
    function index() {
        $data['profile'] = $this->xProfile_Model->GetProfile();
		$this->_view($data);
    }
    
    function ping_server($server) {
        require_once APPPATH . "libraries/ping.php";
        ping::site($server);
    }

//AJAX DO//
    function process_form() {
		$ret = array();
        $ret['command'] = "updating data";
        if($this->Profile_Model->DoUpdateProfile()) {
            $ret['msg'] = $this->lang->line('msg_save');
            $ret['status'] = "success";
        } else {
            $ret['msg'] = $this->lang->line('msg_error_save');
            $ret['status'] = "error";
        }
		echo json_encode($ret);
    }

	/*function get_list_spesialisasinya($id) {
        $data = $this->Profile_Model->GetListSpesialisasi();
        for($i=0;$i<sizeof($data);$i++) {
            echo $data[$i]['name'] . "\n";
        }
	}*/

    function upload_photo() {
        $ret = array();
        if(move_uploaded_file($_FILES['Filedata']['tmp_name'], 'webroot/media/upload/' . $_FILES['Filedata']['name'])) {
            $this->Profile_Model->DoUpdatePhoto($_FILES['Filedata']['name']);
            $ret['name'] = $_FILES['Filedata']['name'];
            $ret['status'] = "success";
        }
        $this->load->view('admdata/profile_upload', $ret);
    }

    function upload_screensaver() {
        $ret = array();
        if(move_uploaded_file($_FILES['Filedata2']['tmp_name'], 'webroot/media/upload/' . $_FILES['Filedata2']['name'])) {
            $this->Profile_Model->DoUpdateScreensaver($_FILES['Filedata2']['name']);
            $ret['name'] = $_FILES['Filedata2']['name'];
            $ret['status'] = "success";
        }
        $this->load->view('admdata/profile_upload_screensaver', $ret);
    }
    
	
//VIEW//
    function _view($data = array()) {
        $menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('_header', array('title' => $this->title, 'js' => $this->js, '_profile' => $profile['_profile']));
        $this->load->view('_menu', $menu);
        $this->load->view('admdata/profile', $data);
        $this->load->view('_footer');
    }
}
