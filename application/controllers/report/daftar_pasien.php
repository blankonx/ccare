<?php

Class Daftar_Pasien extends Controller {
    
    var $title;
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('rekammedis/Daftar_Pasien_Model');
		$this->title = "Daftar Pasien Puskesmas";
    }
    
    function index() {
        $data = array();
        $this->_view($data);
    }

    function get_data_by_id() {
        $ret = $this->Daftar_Pasien_Model->GetDataById();
		echo json_encode($ret);
    }
    
    function delete_list() {
        $ret['command'] = "deleting data";
        if($this->Daftar_Pasien_Model->DoDeleteData()) {
            $ret['msg'] = $this->lang->line('msg_delete');
            $ret['status'] = "success";
        } else {
            $ret['msg'] = $this->lang->line('msg_error_delete');
            $ret['status'] = "error";
        }
		echo json_encode($ret);
    }

    function printout($title="",$str_search='', $start, $offset) {
		//$unit = $this->session->userdata('unit');
       // $data['report_sub_title'] = 'Periode ' . tanggalIndo($this->session->userdata('year_start') . '-' . addExtraZero($this->session->userdata('month_start'),2) . '-01', 'F Y');
		
		$data['report_title'] = $this->report_title;
		$this->load->model('Xprofile_Model');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
		$data['list'] = $this->Daftar_Pasien_Model->GetDataByIdPrint($str_search='', $start, $offset);
        //$temp = $this->Pasien_Model->GetDrugDistribution_Print();
       // $data['drug_out'] = $temp['drug_out'];
       // $data['clinic'] = $temp['clinic'];
        
		//$data['report'] = $this->session->userdata('report');
		$this->load->view('_header_print_full_landscape', $data);
		$this->load->view('rekammedis/daftar_pasien_print', $data);
		$this->load->view('_footer_print_full_landscape');
	}
	
	function excel($title="",$str_search='', $start, $offset) {
		
        $data['report_sub_title'] = 'Periode ' . tanggalIndo($this->session->userdata('year_start') . '-' . addExtraZero($this->session->userdata('month_start'),2) . '-01', 'F Y');
		
		$data['report_title'] = $this->report_title;
	
		$data['report'] = $this->Daftar_Pasien_Model->GetDataByIdPrint();
        
        
        header('Content-Type: application/vnd.pwg-xhtml-print+xml');
        header('Content-Disposition: inline; filename=' . underscore($this->report_title . '-' . $data["report_sub_title"]) . '.xls');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
		$this->load->view('rekammedis/daftar_pasien_excel', $data);
	}
	

//VIEW//
    function _view($data = array()) {
        $menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('_header', array('title' => $this->title, 'js' => $this->js, '_profile' => $profile['_profile']));
        $this->load->view('_menu', $menu);
        $this->load->view('rekammedis/daftar_pasien', $data);
        $this->load->view('_footer');
    }
}
