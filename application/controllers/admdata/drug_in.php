<?php

Class Drug_In extends Controller {
    
    var $title;
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('admdata/Drug_In_Model');
        //$this->js[] = "jquery/js/jquery.jeditable.js";
		$this->title = "Obat Masuk";
    }
    
    function index() {
        $data = array();
        $this->_view($data);
    }

    function get_list_drug() {
        $data = $this->Drug_In_Model->GetListDrug($this->input->post('q'));
        for($i=0;$i<sizeof($data);$i++) {
            echo $data[$i]['name'] . "|" . $data[$i]['id'] . "|" . $data[$i]['unit'] . "|" . $data[$i]['stock'] . "\n";
        }
    }
    
    function delete_list() {
        $ret['command'] = "deleting data";
        if($this->Drug_In_Model->DoDeleteData()) {
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
		$last_id = $this->Drug_In_Model->DoAddData();
		if($last_id > 0) {
			$ret['msg'] = $this->lang->line('msg_save');
			$ret['status'] = "success";
		} else {
			$ret['msg'] = $this->lang->line('msg_error_save');
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
        $this->load->view('admdata/drug_in', $data);
        $this->load->view('_footer');
    }
}
