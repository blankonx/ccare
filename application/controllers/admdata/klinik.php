<?php
Class Klinik extends Controller {
    
    var $title;
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('admdata/Klinik_Model');
        //$this->js[] = "jquery/js/jquery.jeditable.js";
		$this->title = "Data Klinik";
    }
    
    function index() {
        $data = array();
        $this->_view($data);
    }

    function get_data_by_id() {
        $ret = $this->Klinik_Model->GetDataById();
		echo json_encode($ret);
    }
    
    function delete_list() {
        $ret['command'] = "deleting data";
        if($this->Klinik_Model->DoDeleteData()) {
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
			if($this->Klinik_Model->DoUpdateData()) {
				$ret['msg'] = $this->lang->line('msg_update');
				$ret['status'] = "success";
			} else {
				$ret['msg'] = $this->lang->line('msg_error_update');
				$ret['status'] = "error";
			}
        } else {
			$ret['command'] = "adding data";
			$last_id = $this->Klinik_Model->DoAddData();
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
        $this->load->view('admdata/klinik', $data);
        $this->load->view('_footer');
    }
    
    //tambahan autocomplete
    function get_list_kecamatan() {
        $data = $this->Klinik_Model->GetListKec($this->input->post('q'));
        for($i=0;$i<sizeof($data);$i++) {
            echo $data[$i]['id'] . "|" . $data[$i]['kecamatan'] . "|" . $data[$i]['kabupaten'] . "\n";
        }
    }
}
