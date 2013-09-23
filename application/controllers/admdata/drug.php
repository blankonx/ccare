<?php

Class Drug extends Controller {
    
    var $title;
    var $js = array(); 

    function __construct() {
        parent::Controller();
        if(!$this->session->userdata('id')) redirect('login');
        $this->load->model('admdata/Drug_Model');
		$this->title = "Data Obat";
    }
    
    function index() {
        $data = array();
        $data['combo_supplier'] = $this->Drug_Model->GetComboSupplier();
        $this->_view($data);
    }

    function get_data_by_id() {
        $ret = $this->Drug_Model->GetDataById();
		echo json_encode($ret);
    }
    
    function contoh_format() {
        require_once APPPATH . "libraries/excel/Format.php";
        require_once APPPATH . "libraries/excel/OLEwriter.php";
        require_once APPPATH . "libraries/excel/BIFFwriter.php";
        require_once APPPATH . "libraries/excel/Parser.php";
        require_once APPPATH . "libraries/excel/reader.php";
        require_once APPPATH . "libraries/excel/Worksheet.php";
        require_once APPPATH . "libraries/excel/Workbook.php";
		require_once APPPATH . "libraries/excel/bikinexcel.php";
        
        $data = $this->Drug_Model->GetAlldrug();
        $xls = new bikinExcel("contoh_format_obat.xls");
        $xls->setSheet("ContohFormatObat");
        $xls->addTh("No", "Kode", "Obat", "Jenis", "Satuan", "Supplier");
        $xls->setColumnWidth(5, 10, 40, 10, 10, 20);
        for($i=0;$i<sizeof($data);$i++) {
            $xls->addRow(
                ($i+1),
                $data[$i]['code'], 
                $data[$i]['name'], 
                $data[$i]['category'], 
                $data[$i]['unit'], 
                $data[$i]['supplier']
            );
        }
        $xls->build();
    }
    
    function delete_list() {
        $ret['command'] = "deleting data";
        if($this->Drug_Model->DoDeleteData()) {
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
			if($this->Drug_Model->DoUpdateData()) {
				$ret['msg'] = $this->lang->line('msg_update');
				$ret['status'] = "success";
			} else {
				$ret['msg'] = $this->lang->line('msg_error_update');
				$ret['status'] = "error";
			}
        } else {
			$ret['command'] = "adding data";
			$last_id = $this->Drug_Model->DoAddData();
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

    function process_form_upload() {
        $sukses = false;
		require_once APPPATH . "libraries/excel/Format.php";
		require_once APPPATH . "libraries/excel/OLEwriter.php";
		require_once APPPATH . "libraries/excel/BIFFwriter.php";
		require_once APPPATH . "libraries/excel/Parser.php";
		require_once APPPATH . "libraries/excel/reader.php";
		require_once APPPATH . "libraries/excel/Worksheet.php";
		require_once APPPATH . "libraries/excel/Workbook.php";
		
		$file = $_FILES['file_excel'];
		$arr_accept = array("xls", "csv");
		$ext = strtolower(end(explode(".", $file['name'])));
		if(in_array($ext, $arr_accept)) {
			$namafile_baru = "obat_" . md5(microtime()). "." . $ext;
			//echo $namafile_baru;
			$ret_ins = array();
			if(move_uploaded_file($file['tmp_name'], "webroot/obat_masuk/" . $namafile_baru)) {
				if($ext == "xls") {
					$data = new Spreadsheet_Excel_Reader;
					$data->setOutputEncoding('CP1251');
					$data->read("webroot/obat_masuk/" . $namafile_baru);
					$ret_ins = $this->Drug_Model->DoAddDataImport($data->sheets[0]['cells'], $data->sheets[0]['numRows']);
					echo "<script language=\"javascript\" type=\"text/javascript\">function setPreview(){alert('".$ret_ins['sukses']." data berhasil masuk. ".$ret_ins['gagal']." data gagal masuk pada baris ".$ret_ins['no_gagal'].". ');}document.onload=setPreview();</script>";
				} else {
					echo "<script language=\"javascript\" type=\"text/javascript\">function setPreview(){alert('Gagal memasukkan data. Silakan simpan file excel dalam format 2003');parent.parent.document.getElementById('file_excel').value='';}document.onload=setPreview();</script>";
					//$sukses = false;
				}
			} else {
				echo "<script language=\"javascript\" type=\"text/javascript\">function setPreview(){alert('Upload file gagal, silakan ulangi lagi');parent.parent.document.getElementById('file_excel').value='';}document.onload=setPreview();</script>";
				//$sukses = false;
			}
		} else {
			echo "<script language=\"javascript\" type=\"text/javascript\">function setPreview(){alert('Maaf, hanya boleh file dengan tipe xls saja');parent.parent.document.getElementById('file_excel').value='';}document.onload=setPreview();</script>";
		}
        $this->_view();
    }

//VIEW//
    function _view($data = array()) {
        $menu['_menu'] = $this->xMenu_Model->GetMenu();
        $profile['_profile'] = $this->xProfile_Model->GetProfile();
        $this->load->view('_header', array('title' => $this->title, 'js' => $this->js, '_profile' => $profile['_profile']));
        $this->load->view('_menu', $menu);
        $this->load->view('admdata/drug', $data);
        $this->load->view('_footer');
    }
}
