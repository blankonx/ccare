<?php

Class Group extends Controller {
    
    var $title;
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('admdata/Group_Model');
        //$this->js[] = "jquery/js/jquery.jeditable.js";
		$this->title = "Data Group";
    }
    
    function index() {
        $_menu = $this->Group_Model->GetMenu();
        $data['menu'] = $this->_get_menu($_menu);
        //$data['sub'] = $this->Group_Model->GetMenuLevelTwo();
        $this->_view($data);
    }

    function _get_menu($data, $parent = 0) {
        static $i = 1;
        $tab = str_repeat("\t\t", $i);
        if ($data[$parent]) {
            $html = "\n$tab<ul>";
            $i++;
            foreach ($data[$parent] as $v) {
                $child = $this->_get_menu($data, $v['id']);
                $html .= "\n\t$tab<li>";
                $html .= '<label><input class="menu_admdata" type="checkbox" name="menu[]" value="'.$v['id'].'" id="'.$v['id'].'" />'.$v['name'].'</label>';
                //$html .= '<a href="'.site_url($v['url']).'">'.$v['name'].'</a>';
                if ($child) {
                    $i--;
                    $html .= $child;
                    $html .= "\n\t$tab";
                }
                $html .= '</li>';
            }
            $html .= "\n$tab</ul>";
            return $html;
        } else {
            return false;
        }
    }

    function get_data_by_id() {
        $ret['data'] = $this->Group_Model->GetDataById();
        //print_r($ret);
		echo json_encode($ret);
    }
    function delete_list() {
        $ret['command'] = "deleting data";
        if($this->Group_Model->DoDeleteData()) {
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
			if($this->Group_Model->DoUpdateData()) {
				$ret['msg'] = $this->lang->line('msg_update');
				$ret['status'] = "success";
			} else {
				$ret['msg'] = $this->lang->line('msg_error_update');
				$ret['status'] = "error";
			}
        } else {
			$ret['command'] = "adding data";
			$last_id = $this->Group_Model->DoAddData();
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
        $this->load->view('admdata/group', $data);
        $this->load->view('_footer');
    }
}
