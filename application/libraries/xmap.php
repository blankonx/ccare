<?
class Xmap
{
	var $image;
	var $w,$h;
	var $clr;
	var $r,$g,$b;
	var $rgb;
	function SetCanvas($w,$h){
		$this->image=imagecreate($w,$h);
	}
	
	function SetColor($clr){
		$this->clr = $clr;
		$this->r = $red;
		$this->g = $green;
		$this->b = $blue;
		$this->rgb = array(
		"merah"=>array(255,0,0),
		"hijau"=>array(0,255,0),
		"hijautua"=>array(0,128,0),
		"biru"=>array(0,0,255),
		"putih"=>array(255,255,255),
		"hitam"=>array(0,0,0),
		"kuning"=>array(255,255,0),
		"birumuda"=>array(0,255,255),
		"n1"=>array(255,0,255)
		);
		
		$red = $this->rgb[$clr][0];
		$green = $this->rgb[$clr][1];
		$blue = $this->rgb[$clr][2];
		
		$this->clr= imagecolorallocate($this->image,$red,$green,$blue);
		
	}
	function SetColor2($red,$green,$blue){
		$this->clr= imagecolorallocate($this->image,$red,$green,$blue);
		
	}
	
	function DrawPolygon($data){
		imagefilledpolygon($this->image,$data,count($data)/2,$this->clr);
	}
	
	function DrawLinePolygon($data){
		imagepolygon($this->image,$data,count($data)/2,$this->clr);
	}
	
	function WriteString($x,$y,$str){
		imagestring($this->image,3,$x,$y,$str,$this->clr);
	}
	
	function jpeg()
	{
		header("Content-Type: image/JPEG");
		imageJPEG($this->image);
		imagedestroy($this->image);
	}

	function png()
	{
		header("Content-Type: image/PNG");
		imagePNG($this->image);
		imagedestroy($this->image);
	}
	
}
