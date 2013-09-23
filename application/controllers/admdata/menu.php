<?php

Class Menu extends Controller {
    
    var $title;
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('admdata/Menu_Model');
        //$this->js[] = "jquery/js/jquery.jeditable.js";
		$this->title = "Data Menu";
    }
    
    function index() {
        //$data['parent_menu'] = $this->Menu_Model->GetParentMenu();
        $temp = $this->Menu_Model->GetMenu();
        $data['combo_menu'] = $this->_get_combo_menu($temp);
        $this->_view($data);
    }

    function _get_combo_menu($data, $parent = 0) {
        static $i = 1;
        $tab = str_repeat("\t\t", $i);
        $dash = str_repeat("&mdash;", $i);
        if ($data[$parent]) {
            $html = "";
            //$html = "\n$tab<optgroup>";
            $i++;
            foreach ($data[$parent] as $v) {
                $child = $this->_get_combo_menu($data, $v['id']);
                $html .= "\n\t$tab";
                $html .= '<option name="menu[]" value="'.$v['id'].'" id="'.$v['id'].'" />'.$dash . ' ' . $v['name'].'</option>';
                //$html .= '<a href="'.site_url($v['url']).'">'.$v['name'].'</a>';
                if ($child) {
                    $i--;
                    $html .= $child;
                    $html .= "\n\t$tab";
                }
                //$html .= '</li>';
            }
            //$html .= "\n$tab</optgroup>";
            return $html;
        } else {
            return false;
        }
    }
    
    function get_parent_menu() {
        $data = $this->Menu_Model->GetParentMenu();
		echo "<option value=\"\">Top Menu</option>";
        for($i=0;$i<sizeof($data);$i++) {
			if(!$data[$i]['parent_id']) {
				$current_parent_id = $data[$i]['id'];
				echo "<option style=\"font-weight:bold;\" value=\"|".$data[$i]['id'].$data[$i]['level']."\">".$data[$i]['name']."</option>";
			} elseif($data[$i]['parent_id'] == $current_parent_id) {
				echo "<option style=\"padding-left:20px;\" value=\"".$data[$i]['parent_id'] . "|" . $data[$i]['id'] . "|" . $data[$i]['level']."\">".$data[$i]['name']."</option>";
			}
        }
    }

    function get_data_by_id() {
        $ret = $this->Menu_Model->GetDataById();
		echo json_encode($ret);
    }
    
    function move_up($parent_id, $id, $ordering) {
        $this->Menu_Model->DoMoveUp($parent_id, $id, $ordering);
    }
    
    function move_dn($parent_id, $id, $ordering) {
        $this->Menu_Model->DoMoveDn($parent_id, $id, $ordering);
    }
    
    function delete_list() {
        $ret['command'] = "deleting data";
        if($this->Menu_Model->DoDeleteData()) {
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
			if($this->Menu_Model->DoUpdateData()) {
				$ret['msg'] = $this->lang->line('msg_update');
				$ret['status'] = "success";
			} else {
				$ret['msg'] = $this->lang->line('msg_error_update');
				$ret['status'] = "error";
			}
        } else {
			$ret['command'] = "adding data";
			$last_id = $this->Menu_Model->DoAddData();
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
        $this->load->view('admdata/menu', $data);
        $this->load->view('_footer');
    }
}
