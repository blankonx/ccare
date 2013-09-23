<?
class bikinExcel {
	var $wb; // new Workbook()
	var $namafile;
	var $worksheet = array("sheet1");
	var $title = array();
	var $first_row = 0;
	var $first_col = 0;
	var $last_row = 0;
	var $last_col = 0;
	//baris yang telah ditulis
	var $curr_row = 0;
	//kolom yang telah ditulis
	var $curr_col = 0;

	var $column_width = array();

	function __construct($namafile) {
		$this->namafile = $namafile;
		$this->wb = new Workbook("-");
		return $this->wb;
	}

	function bikinExcel($namafile) {
		return $this->__construct($namafile);
	}

	function excelHeader() {
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=" . $this->namafile);
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
		header("Pragma: public");	
	}

	function setSheet() {
		$val = func_get_args();
		$num = func_num_args();
		for($i=0;$i<$num;$i++) {
			$this->worksheet[$i] =& $this->wb->add_worksheet($val[$i]);
			$this->worksheet[$i]->set_portrait();
			$this->worksheet[$i]->set_paper(9);
			$this->worksheet[$i]->center_horizontally();
			$this->worksheet[$i]->set_margin_left(0.5);
			$this->worksheet[$i]->set_margin_right(0.5);
			$this->worksheet[$i]->set_margin_top(1);
			$this->worksheet[$i]->set_margin_bottom(1);
			$this->worksheet[$i]->set_print_scale(90);
			$this->worksheet[$i]->hide_gridlines(1);
		}
	}

	function setTitle() {
		$val = func_get_args();
		$num = func_num_args();
		for($i=0;$i<$num;$i++) {
			$this->title[$i] = $val[$i];
		}
	}

	function getTitleFormat() {
		$format =& $this->wb->add_format();
		$format->set_size(12);
		//function merge_cells($first_row, $first_col, $last_row, $last_col)
		//$this->wb->merge_cells($this->first_row, $this->first_col, $this->first_row, $this->last_col);
		$format->set_bold(1);
		$format->set_align('center');
		//$format->set_pattern();
		return $format;
	}

	function getSubTitleFormat() {
		$format =& $this->wb->add_format();
		$format->set_size(11);
		$format->set_bold(1);
		$format->set_align('center');
		return $format;
	}

	function getThFormat() {
		$format =& $this->wb->add_format();
		$format->set_bold(1);
		$format->set_align('center');
		$format->set_align('vcenter');
		$format->set_text_wrap(0);
		$format->set_size(12);
		//$format->set_pattern();
		return $format;
	}

	function getRowFormat() {
		$format =& $this->wb->add_format();
		$format->set_bold(0);
		$format->set_align('left');
		$format->set_align('vcenter');
		$format->set_text_wrap(0);
		$format->set_size(12);
		//$format->set_pattern();
		return $format;
	}

	function addTh() {
		$val = func_get_args();
		$num = func_num_args();
		$this->last_col = $num;
		for($i=0;$i<$num;$i++) {
			$ret[] = $val[$i];
		}
		$this->Th[] = $ret;
	}

	function setColumnWidth() {
		$val = func_get_args();
		$num = func_num_args();
		for($i=0;$i<$num;$i++) {
			$ret[] = $val[$i];
		}
		$this->column_width[] = $ret;
	}

	function addRow() {
		$val = func_get_args();
		$num = func_num_args();
		for($i=0;$i<$num;$i++) {
			$ret[] = $val[$i];
		}
		$this->Row[] = $ret;
		//Row[0] = array("no1", "nama1", "alamat1");
		//Row[1] = array("no2", "nama2", "alamat2");
		//Row[0][0] = "no1";
		//Row[1][0] = "no2";
	}

	function setHeader() {
		
	}

	function setTandaTangan() {
	
	}

	function setPrintArea() {
		//$this->worksheet[0]->print_area($this->first_row, $this->first_col, $this->last_row, $this->last_col);
	}

	function buildTitle() {
		$kolom_tengah = ceil(($this->last_col+$this->first_col)/2);
		for($i=0;$i<sizeof($this->title);$i++) {
			$title = explode("\n", $this->title[$i]);
			//echo title
			$this->worksheet[0]->write($this->first_row, $kolom_tengah, $title[0], $this->getTitleFormat());
			//echo subtitle
			$this->worksheet[0]->write($this->first_row+1, $kolom_tengah, $title[1], $this->getSubTitleFormat());
		}
		$this->curr_row += $i;
	}

	function buildTh() {
		$th_format = $this->getThFormat();
		for($i=0;$i<sizeof($this->Th);$i++) {
			for($j=0;$j<sizeof($this->Th[$i]);$j++) {
				$kolom = $j+$this->first_col;
				if($this->column_width[$i][$j]) {
					$this->worksheet[0]->set_column($kolom, $kolom, $this->column_width[$i][$j]);
				}
				$this->worksheet[0]->write_string($i, $kolom, $this->Th[$i][$j], $th_format);
			}
			$this->curr_row += 1;
		}
	}

	function buildRow() {
		$format = $this->getRowFormat();
		for($i=0;$i<sizeof($this->Row);$i++) {
			for($j=0;$j<sizeof($this->Row[$i]);$j++) {
				$this->worksheet[0]->write_string(($i + $this->curr_row), ($j + $this->first_col), $this->Row[$i][$j], $format);
				$this->last_row = $i + $this->curr_row;
			}
		}
	}

	function build() {
		$this->excelHeader();
		//$this->buildTitle();
		$this->buildTh();
		$this->buildRow();
		$this->setPrintArea();
		$this->wb->close();
	}
}
?>