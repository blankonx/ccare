<?php

Class Menu_List extends Controller {
    
    var $offset = 1000;
    var $js = array(); 

    function __construct() {
        parent::Controller();
        //if(!$this->session->menudata('id')) redirect('login');
        $this->load->model('admdata/Menu_List_Model');
    }
    
    function index() {
        return $this->result($this->input->post('search_name'));
    }

    function _get_menu($data, $parent = 0) {
        static $i = 1;
        $tab = str_repeat("\t\t", $i);
        $dash = str_repeat("&mdash;", $i);
        if ($data[$parent]) {
            $html = "";
            //$html = "\n$tab<optgroup>";
            $i++;
            foreach ($data[$parent] as $v) {
                $child = $this->_get_menu($data, $v['id']);
                $html .= "\n\t$tab";
                $html .= '<tr class="notSelected">';
                //$html .= '<td></td>';
                $html .= '<td>'.$v['id'].'<input type="checkbox" class="checkbox_delete" name="delete_id[]" id="delete_id_'.$v['id'].'" value="'.$v['id'].'" /></td>';
            
                $html .= '<td ondblclick="get_data_by_id('.$v["id"].')">'.$dash . ' ' . $v['name'].'</td>';
                $html .= '<td ondblclick="get_data_by_id('.$v["id"].')">'.$v['url'].'</td>';
                $html .= '<td><a href="'.site_url("admdata/menu/move_up/".$v["parent_id"]."/" . $v["id"] . "/" . $v["xordering"]).'" class="menu_change_order"><img src="'.base_url().'webroot/media/images/move_up.png" /></a></td>';
                $html .= '<td><a href="'.site_url("admdata/menu/move_dn/".$v["parent_id"]."/" . $v["id"] . "/" . $v["xordering"]).'" class="menu_change_order"><img src="'.base_url().'webroot/media/images/move_down.png" /></a></td>';
                $html .= '</tr>';
                
                //name="menu[]" value="'.$v['id'].'" id="'.$v['id'].'" />'.$dash . ' ' . $v['name'].'</option>';
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

    function result($str_search='', $start=0) {

		$temp = $this->Menu_List_Model->GetData($str_search, $start, $this->offset);
        $data['list'] = $this->_get_menu($temp);
		//$data['sub'] = $this->Menu_List_Model->GetMenuLevelTwo();
		$data['total'] = $this->Menu_List_Model->getCount();
		$data['start'] = $start;

		//print_r($data);
		$paging = array();
		$paging['base_url'] = base_url() . 'admdata/menu_list/result/' . $str_search . '/';
		$paging['total_rows'] = $data['total'];
		$paging['uri_segment'] = 5;
		$paging['per_page'] = $this->offset;
		$paging['num_links'] = 2;

		$this->load->library('pagination', $paging);
		$links = $this->pagination->create_links();
        $cur_page = $this->pagination->cur_page;
        $total_rows = $this->pagination->total_rows;
        $total_pages = $this->pagination->total_pages;
		$data['current_page'] = $start;
        
		if($links) $data['links'] = $this->lang->line('label_page') . ' ' . $cur_page . ' of ' . $total_pages . ', Total : ' . $total_rows . ' data&nbsp;&nbsp;&nbsp;&nbsp;' . $links;
		else $data['links'] = '';
        $this->_view($data);
    }

//VIEW//
    function _view($data = array()) {
        $this->load->view('admdata/menu_list', $data);
    }
}
