<?php
class xImage
{
	var	$_IMG;
	var	$_WIDTH,$_HEIGHT;
	var	$_COLOR;
	var	$_RED,$_GREEN,$_BLUE;
	var	$_CLR;
	var	$_DATA;
	var $_FONT;
	var $_STRING;
	var $xc,$yc;
	var $_SOURCE;
	var $_SRC;
	var $_SCL;
	var $_ANG;

	function SET_CANVAS($_WIDTH,$_HEIGHT)
	{
	  $this->_WIDTH	=	$_WIDTH;
	  $this->_HEIGHT	=	$_HEIGHT;
	  $this->_IMG	= imagecreate($_WIDTH,$_HEIGHT);
	}
	
	function SET_COLOR($_COLOR)
	{
	 $this->_COLOR	=	$_COLOR;
	 $this->_RED		=	$_RED;
	 $this->_GREEN	=	$_GREEN;
	 $this->_BLUE	=	$_BLUE;
	 $this->RGB_LIST	=array(
	  "kuning"=>array(255,255,0),
	  "merah"=>array(255,0,0),
	  "hijau"=>array(0,255,0),
	  "biru"=>array(0,0,255),
	  "birumuda"=>array(0,255,255),
	  "hitam"=>array(0,0,0),
	  "putih"=>array(255,255,255),
	  "x1" =>array(255,255,255),
	  "x2" => array(255,250,250),
	  "x3" => array(255,230,230),
	  "x4" => array(255,200,200),
	  "x5" => array(255,170,170),
	  "x6" => array(255,140,140),
	  "x7" => array(255,110,110),
	  "x8" => array(255,80,80),
	  "x9" => array(255,50,50),
	  "x10" => array(255,0,0),
	  );
	  $_RED	=	$this->RGB_LIST[$_COLOR][0];
	  $_GREEN	=	$this->RGB_LIST[$_COLOR][1];
	  $_BLUE	=	$this->RGB_LIST[$_COLOR][2];
	  $this->_CLR = imagecolorallocate($this->_IMG,$_RED,$_GREEN,$_BLUE);
	}

	function SET_COLOR2($r, $g, $b) {
	  $this->_CLR = imagecolorallocate($this->_IMG,$r,$g,$b);
	}
	
	function RECT($x1,$y1,$x2,$y2)
	{
	 imagefilledrectangle($this->_IMG,$x1,$y1,$x2,$y2,$this->_CLR);
	}

	function RECTLINE($x1,$y1,$x2,$y2)
	{
	 imagerectangle($this->_IMG,$x1,$y1,$x2,$y2,$this->_CLR);
	}

	function TRANS()
	{
	 imagecolortransparent($this->_IMG,$this->_CLR);
	}
	
	function INTERLACE()
	{
	 imageinterlace($this->_IMG,1);
	}
	
	function POLYGON($_DATA){
	 $this->_DATA	=	$_DATA;
	 imagefilledpolygon($this->_IMG,$_DATA,count($_DATA)/2,$this->_CLR);
	}
	
	function LINE_POLYGON($_DATA){
	 imagepolygon($this->_IMG,$_DATA,count($_DATA)/2,$this->_CLR);
	}

	function STRING_IMG($xc,$yc,$_STRING,$_FONT)
	{
	 $this->xc = $xc;
	 $this->yc = $yc;
	 $this->_FONT = $_FONT;
	 $this->_STRING = $_STRING;
	 imagestring($this->_IMG,$_FONT,$xc,$yc,$_STRING,$this->_CLR);
	}
	
	function TTF_STR($_FONT,$xc,$yc,$_STRING,$_ANG="35"){
	 $this->_ANG = $_ANG;
	 imagettftext($this->_IMG,$_FONT,$_ANG,$xc,$yc,$this->_CLR,"webroot/fonts/arial.ttf",$_STRING);
	}
	
	function FROM_GIF($_SOURCE)
	{
	 $this->_SOURCE = $_SOURCE;
	 $this->_SRC = imagecreateFROMgif($_SOURCE);
	}
	
	function FROM_PNG($_SOURCE)
	{
	 $this->_SRC = imagecreateFROMpng($_SOURCE);
	}
	
	function FROM_JPEG($_SOURCE)
	{
	 $this->_SRC = imagecreateFROMjpeg($_SOURCE);
	}
	
	function IMG_COPY($xc,$yc,$_SCL="2")
	{
	 $this->_SCL =$_SCL;
	 imagecopyresized($this->_IMG,$this->_SRC,$xc,$yc,0,0,imageSX($this->_SRC)/$_SCL,imageSY($this->_SRC)/$_SCL,
	 imageSX($this->_SRC)-1,imageSY($this->_SRC)-1);
	}


	function JPEG_IMAGE()
	{
		header("Content-Type: image/JPEG");
		imageJPEG($this->_IMG);
		imagedestroy($this->_IMG);
	}

	function PNG_IMAGE()
	{
		header("Content-Type: image/PNG");
		imagePNG($this->_IMG);
		imagedestroy($this->_IMG);
	}
}
?>
