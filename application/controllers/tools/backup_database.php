<?php

Class Backup_Database extends Controller {
    
    var $title;
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('tools/Backup_Database_Model');
		$this->title = "Backup &amp; Restore Database";
    }
    
    function index() {
        $data = array();
        $this->_view($data);
    }

    function get_data_by_id() {
        $ret = $this->Backup_Database_Model->GetDataById();
		echo json_encode($ret);
    }
    
    function delete_list() {
        $ret['command'] = "deleting data";
        if($this->Backup_Database_Model->DoDeleteData()) {
            $ret['msg'] = $this->lang->line('msg_delete');
            $ret['status'] = "success";
        } else {
            $ret['msg'] = $this->lang->line('msg_error_delete');
            $ret['status'] = "error";
        }
		echo json_encode($ret);
    }
	
	function restore_database($filename) {
		$a = exec($this->config->item('bin_path') . "mysql -u " . $this->db->username . " -p" . $this->db->password . " -D " . $this->db->database . " < " .  "webroot/backup_database/" .$filename);		
		$ret['msg'] = "Data Direstore";
		$ret['status'] = "success";
		echo json_encode($ret);
	}

    function process_form() {
		$ret = array();
        if($this->input->post('saved_id')) {
			$ret['command'] = "updating data";
			if($this->Backup_Database_Model->DoUpdateData()) {
				$ret['msg'] = $this->lang->line('msg_update');
				$ret['status'] = "success";
			} else {
				$ret['msg'] = $this->lang->line('msg_error_update');
				$ret['status'] = "error";
			}
        } else {
			/*
			// Load the DB utility class
			$this->load->dbutil();

			// Backup your entire database and assign it to a variable
			$prefs = array(
                'tables'      => array(),  // Array of tables to backup.
                'ignore'      => array(),           // List of tables to omit from the backup
                'format'      => 'txt',             // gzip, zip, txt
                'filename'    => '',    // File name - NEEDED ONLY WITH ZIP FILES
                'add_drop'    => TRUE,              // Whether to add DROP TABLE statements to backup file
                'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
                'newline'     => "\n"               // Newline character used in backup file
              );
			$backup =& $this->dbutil->backup($prefs);

			// Load the file helper and write the file to your server
			$this->load->helper('file');
			$filename = "webroot/backup_database/backup_" . date('Y-m-d_H-i-s') . ".sql";
			write_file($filename , $backup);
			$filesize = filesize($filename);
			
			// Load the download helper and send the file to your desktop
			//$this->load->helper('download');
			//force_download('mybackup.gz', $backup); 
			*/
			$filename = "webroot/backup_database/backup_" . date('Y-m-d_H-i-s') . ".sql";
			$ret['command'] = "adding data";
			@exec($this->config->item("bin_path") . "mysqldump -c --single-transaction -r " . $filename . " " . $this->db->database. " -u " . $this->db->username. " -p" . $this->db->password. "");
			$filesize = filesize($filename);

			if(true === $this->Backup_Database_Model->DoAddData($filename, $filesize)) {
				$ret['msg'] = "Data Dibackup";
				$ret['status'] = "success";
			} else {
				$ret['msg'] = "Data Gagal Dibackup";
				$ret['status'] = "error";
			}
        }
		echo json_encode($ret);
    }
    
    function download($filename) {
		//print_r(file_get_contents("webroot/backup_database/" . $filename));
		$this->load->helper('download');
		force_download($filename, file_get_contents("webroot/backup_database/" . $filename));
	}
    
    function upload() {
        $ret = array();
        $ret['x'] = $_FILES['Filedata'];
        if($_FILES['Filedata']['name']) {
			$a = exec($this->config->item('bin_path') . "mysql -u " . $this->db->username . " -p" . $this->db->password . " -D " . $this->db->database . " < " .  $_FILES['Filedata']['tmp_name']);
			$ret['msg'] = "Data Direstore";
			$ret['status'] = "success";
		}
        $this->load->view('tools/upload_status', $ret);
    }

//VIEW//
    function _view($data = array()) {
        $menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('_header', array('title' => $this->title, 'js' => $this->js, '_profile' => $profile['_profile']));
        $this->load->view('_menu', $menu);
        $this->load->view('tools/backup_database', $data);
        $this->load->view('_footer');
    }
}
