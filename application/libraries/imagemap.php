<?php
class Imagemap
{
	var $_MAPSTR;
	var $_NAME;
	var $_ALT;
	var $_ORDINAT;
	var $_LINK;
	var $_IMG;
	var $_SCLA;
	function STRNG($_ALT,$_ORDINAT,$_SCLA,$_LINK,$_SHAPE="POLY")
	{
	$this->_SCLA	=$_SCLA;
	$this->_ALT		= $_ALT;
	$this->_ORDINAT	= $_ORDINAT;
	$this->_LINK	= $_LINK;
	$_XPL= explode(",",$_ORDINAT);
	$zf=array_pad(array(),0,0);
	for($i=0;$i<count($_XPL);$i++){
	$xd=$_XPL[$i]/$_SCLA;
	$zf[$i]=$xd;
	}
	$_IMz = implode(",",$zf);


	$this->_MAPSTR .= "<AREA ALT=\"$_ALT\" SHAPE=\"$_SHAPE\" COORDS=\"$_IMz\" HREF=\"$_LINK\">\n";
	}

	function MAPING($_NAME,$_IMG){
	$this->_NAME	= $_NAME;
	$this->_IMG		= $_IMG;
	echo "<MAP NAME=\"$_NAME\">";
	print ($this->_MAPSTR);
	echo "</MAP>";
	echo "<IMG SRC=$_IMG USEMAP=\"#$_NAME\" border=0>";
	}

	
}
?>