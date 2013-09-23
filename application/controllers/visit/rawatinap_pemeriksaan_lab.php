<?php

Class Rawatinap_Pemeriksaan_Lab extends Controller {
    
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('visit/Rawatinap_Pemeriksaan_Lab_Model');
    }
    
    function index() {
        return $this->home();
    }

    function home($visitInpatientId, $visitInpatientClinicId) {
		$data['rawatinap_pemeriksaan_lab'] = $this->Rawatinap_Pemeriksaan_Lab_Model->GetPemeriksaanLab();
		$data['data']['visit_inpatient_id'] = $visitInpatientId;
		$data['data']['visit_inpatient_clinic_id'] = $visitInpatientClinicId;

        $data['doctor'] = $this->Rawatinap_Pemeriksaan_Lab_Model->GetDataDoctor();
        $this->_view($data);
    }

    function lists($visitId, $limit=0) {
        $this->load->library('pagination');
		$data['list'] = $this->Rawatinap_Pemeriksaan_Lab_Model->GetList($visitId, $limit, 5);
        
        /*paging start*/
        $paging['base_url'] = site_url('visit/rawatinap_pemeriksaan_lab/lists/' . $visitId . '/');
        //$paging['base_url'] = base_url() . 'visit/rawatinap_pemeriksaan_lab/lists/' . $visitId . '/';
        $paging['total_rows'] = $this->Rawatinap_Pemeriksaan_Lab_Model->GetCount();
        $paging['per_page'] = 5;
        $paging['uri_segment'] = 5;
        $paging['num_links'] = 5;
        $this->pagination->initialize($paging);
        
        if($this->pagination->create_links())
            $data['links'] = $this->pagination->create_links();
        else $data['links'] = '';
        //print_r($data);
        $this->load->view('visit/rawatinap_pemeriksaan_lab_lists', $data);
    }

    function process_form_pl() {
		$ret = array();
		$ret['command'] = "adding data";
        $last_id = $this->Rawatinap_Pemeriksaan_Lab_Model->DoAddDataPemeriksaanLab();
        //echo $last_id;
		if($last_id > 0) {
			$ret['msg'] = $this->lang->line('msg_save');
			$ret['status'] = "success";
			$ret['last_id'] = $last_id;
		} else {
			$ret['msg'] = $this->lang->line('msg_error_save');
			$ret['status'] = "error";
			$ret['last_id'] = "0";
		}
		echo json_encode($ret);
    }

    function detail($plId) {
		$data['detail'] = $this->Rawatinap_Pemeriksaan_Lab_Model->GetDetail($plId);
        //print_r($data);
        $this->load->view('visit/rawatinap_pemeriksaan_lab_detail', $data);
    }

    function prints($plId) {
		$data['detail'] = $this->Rawatinap_Pemeriksaan_Lab_Model->GetDetail($plId);
		$this->load->model('Xprofile_Model');
		$data['profile'] = $this->Xprofile_Model->GetProfile();
        $this->load->view('_header_print', $data);
        $this->load->view('visit/rawatinap_pemeriksaan_lab_prints', $data);
        $this->load->view('_footer_print');
    }
/*
    function form($visitId) {
        $data['doctor'] = $this->Rawatinap_Pemeriksaan_Lab_Model->GetDataDoctor();
        $data['rawatinap_pemeriksaan_lab_explanation'] = $this->Rawatinap_Pemeriksaan_Lab_Model->GetDataMedicalCertificateExplanation();

        return $this->_view($data);
    }
*/
//VIEW//
    function _view($data = array()) {
        $this->load->view('visit/rawatinap_pemeriksaan_lab', $data);
    }
}
