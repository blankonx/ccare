<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * 
 * Class Chart 
 * 
 * This class used to access FusionCharts class with default configuration
 * by : tantos
 * 06.06.2009 19:47:06 
 * 
 * */
require_once APPPATH . "libraries/fusioncharts.php";


Class Chart extends FusionCharts {
	
	var $test = array(
			"useRoundEdges" => 1,
			"exportEnabled" => 1,
			"exportAtClient" => 0,
			"exportAction" => 'save',
			"exportDialogMessage" => 'Tunggu sebentar...',
			"exportCallback" => 'exportCallback',
			"exportFileName" => 'chart',
			"exportShowMenuItem" => 0,
			"showPrintMenuItem" => 0,
			"showFCMenuItem" => 0,
			"bgColor" => "f7f8f4,f7f8f4",
			"showBorder" => 1,
			"decimalPrecision" => 0,
			"formatNumber" => 0,
			"formatNumberScale" => 0,
			"useRoundEdges" => 1
			/*,
			"paletteColors" => 'FF0000,0372AB,FF5904'*/
		);
	//var $JSC = array();
	
	function __construct($var = array()) {
		
		$this->test['exportHandler'] = base_url() . 'ChartExporter/FCExporter.php';
		
		switch(strtolower($var[0])) {
			case "line" :
			case "msline" :
				$this->test['xAxisName'] = "Waktu";
				$this->test['yAxisName'] = "Jumlah";
			break;
			
			case "column2d" :
			case "column3d" :
			case "mscolumn2d" :
			case "mscolumn3d" :
				$this->test['xAxisName'] = "Waktu";
				$this->test['yAxisName'] = "Jumlah";
			break;
			
			case "pie2d" :
			case "pie3d" :
			break;
			
			default :
			break;
			
		}
		//echo $this->test['exportHandler'];
		//print_r($this->test);
		parent::__construct($var);
		$this->isTransparent = 'wmode';
		$this->JSC['registerwithjs'] = 1;
		$this->setSWFPath('../webroot/Charts/');
		//$test = implode(";",$this->test);
		//echo $test;
		foreach($this->test as $key => $val) {
			$this->setChartParam($key, $val);
		}
	}
}
?>
