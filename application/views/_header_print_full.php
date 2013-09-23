<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php echo strip_tags($report['report_title']);?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>webroot/media/css/print_full.css" media="print,screen">
    <script type="text/javascript" src="<?php echo base_url()?>webroot/jquery/js/jquery-1.2.6.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
		window.print();
	});
    </script>
</head>
<body>
<div id="all-container">
<div id="header">
    <div>
		<img src="<?php echo base_url()?>webroot/media/upload/<?php echo $profile['photo']?>" alt="Logo" height="70" border="0"/>
    </div>
    <div style="text-align:center;width:18cm;font-weight:bold;font-size:14px"><?php echo $profile['report_header_1'];?></div>
    <div style="text-align:center;width:18cm;font-weight:bold;font-size:16px;"><?php echo $profile['report_header_2'];?></div>
    <div style="text-align:center;width:18cm;font-weight:bold"><?php echo strtoupper($profile['name'])?></div>
	<div style="font-size:10px;text-align:center;width:18cm;"><?php echo $profile['address'] . " Telp. " . $profile['phone'];?></div>
</div>
