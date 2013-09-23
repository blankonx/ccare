<?php

Class Home extends Controller {
    
    var $title = 'Home';

    function Home() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('Home_Model');
    }
    
    function index() {
        return $this->dashboard();
    }
    
    function dashboard() {
        $menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $data['dashboard'] = $this->Home_Model->GetDashboardVisits();
		
		require_once APPPATH . "libraries/chart.php";
        $param = array('MsLine', 500, 200, 'DashboardChart');
        //$param['caption'] = 'Statistik Kunjungan';
		$data['fc'] = new Chart($param);
        $data['fc']->setChartParam('caption', 'STATISTIK KUNJUNGAN PASIEN');
        $data['fc']->setChartParam('exportShowMenuItem', 1);
        $data['fc']->setChartParam('showPrintMenuItem', 1);
        $data['fc']->setChartParam('exportAction', 'download');
        
		$data['chart'] = $this->Home_Model->GetDashboardVisitChart();
        
		for($i=0;$i<sizeof($data['chart']);$i++) {
			$data['fc']->addCategory($data['chart'][$i]['name']);
			$data['fc']->addChartData($data['chart'][$i]['count']);
		}
        
        $this->load->view('_header', array('title' => $this->title, '_profile' => $profile['_profile']));
        $this->load->view('_menu', $menu);
        $this->load->view('home', $data);
        $this->load->view('_footer');
    }
    
    function chat_get() {
        $data['chat'] = $this->Home_Model->GetChat();
        $this->load->view('chat_list_msg', $data);
    }
    
    function chat_send() {
        $this->Home_Model->DoAddChat();
        return $this->chat_get();
    }
    
    function alergi_get($patientId) {
        $data = $this->Home_Model->GetAlergi($patientId);
        echo "<ol>";
        for($i=0;$i<sizeof($data);$i++) {
			echo '<li>'.$data[$i]['alergi'].' <a class="alergi_delete_button" href="'.site_url('home/alergi_delete/' . $data[$i]['id']).'"><img src="'.base_url().'/webroot/media/images/delete.png" style="border:0"/></a></li>';
		}
        echo "</ol>";
    }
    
    function alergi_delete($alergiId) {
		if($this->Home_Model->DoDeleteAlergi($alergiId)) {
			echo "sukses";
		} else {
			echo "gagal";
		}
	}
    
    function alergi_send() {
        $this->Home_Model->DoAddAlergi();
        return $this->alergi_get($this->input->post('alergi_patient_id'));
    }
    
}
