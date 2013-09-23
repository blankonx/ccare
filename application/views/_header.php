<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php echo $_profile['name'];?> &raquo; <?php echo strip_tags($title);?></title>
	
	<link rel="icon" href="<?php echo base_url()?>favicon.ico" type="image/x-icon"> 
	<link rel="shortcut icon" href="<?php echo base_url()?>favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>webroot/jquery/css/superfish.css" media="screen">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>webroot/jquery/css/jquery-ui-themeroller.css" media="screen">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>webroot/jquery/css/autocomplete.css" media="screen">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>webroot/jquery/css/jquery.simplemodal.basic.css" media="screen">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>webroot/media/css/sikesda.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>webroot/media/css/table.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>webroot/media/css/form.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>webroot/media/css/paging.css">

<!-- jquery -->
    <script type="text/javascript" src="<?php echo base_url()?>webroot/jquery/js/jquery-1.2.6.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>webroot/jquery/js/jquery.ui.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>webroot/jquery/js/jquery.hotkeys.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>webroot/jquery/js/jquery.form.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>webroot/jquery/js/jquery.validate.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>webroot/jquery/js/jquery.alphanumeric.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>webroot/jquery/js/jquery.autocomplete.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>webroot/jquery/js/hoverIntent.js"></script> 
	<script type="text/javascript" src="<?php echo base_url()?>webroot/jquery/js/superfish.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>webroot/jquery/js/jquery.ui.datepicker-id.js"></script>

 	<script type="text/javascript">
		$(function(){
			$('ul.sf-menu').superfish();
			$('.date-pick').datepicker({
				dateFormat:'dd/mm/yy',
				changeYear:true,
				changeMonth:true,
				regional:'id',
				firstDay:1
			});
		});
		$(document).ready(function(){
			//accordion
			$('#accordion').accordion({header: ".ui-accordion-header"});
            $("input[@type=text]").attr('autocomplete', 'off').focus(function(){this.select();});
		});
	</script>
<!-- sikesda -->
    <script type="text/javascript" src="<?php echo base_url()?>webroot/media/js/sikesda.js"></script>

</head>
<body>
<div id="xmessage"></div>
<!--<div id="xloading" style="position:absolute;z-index:100;background-color:#000000;width:100%;height:100%;"></div>-->
<div id="all-container">
