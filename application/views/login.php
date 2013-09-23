<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>c-Care</title>
	<link rel="icon" href="<?php echo base_url()?>/favicon.ico" type="image/x-icon"/>
	<link rel="shortcut icon" href="<?php echo base_url()?>favicon.ico" type="image/x-icon"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>webroot/media/css/reset.css">
	<link rel="stylesheet" type="text/css" media="screen,projection" href="<?php echo base_url()?>webroot/jquery/css/Aristo/jquery-ui-1.8.7.custom.css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>webroot/media/css/login.css">
	<link rel="stylesheet" href="<?php echo base_url()?>webroot/jquery/css/nivo-slider/default/default.css" type="text/css" media="screen" />
	<link rel="stylesheet" href="<?php echo base_url()?>webroot/jquery/css/nivo-slider.css" type="text/css" media="screen" />
	<script src="<?php echo base_url()?>webroot/jquery/js/jquery.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>webroot/jquery/js/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>webroot/jquery/js/jquery.form.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>webroot/jquery/js/jquery.validate.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo base_url()?>webroot/jquery/js/jquery.nivo.slider.pack.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>webroot/media/js/application.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url()?>webroot/media/css/loginx.css">
   	<script type="text/javascript" src="<?php echo base_url()?>webroot/media/js/sikesda.js"></script>
	
	<script type="text/javascript">
	var show_message_timeout_id;
	$(function() {
		$("#submitButton").button();
	});
	
	$(document).ready(function() {
        $('#slider').nivoSlider({
			pauseTime:7000
		});
		
		$("#login-form").validate({
			submitHandler:
				function(form) {
					$(form).ajaxSubmit({
						dataType: 'json',
						success:function(data) {
							if(data.status == 'succes') {
								/*$('#login-header').hide();
								$('#login-body').hide();
								$('#loading2').show();
								document.location='<?php echo site_url();?>'*/
								document.location='<?php echo site_url("home/dashboard");?>'
							} else if(data.status == 'error-username') {
								$('#username').addClass('error');
								$('#' + data.status).show().text(data.msg);
								$("#username").focus();
							} else {
								$('#pwd').addClass('error');
								$('#' + data.status).show().text(data.msg);
								$("#pwd").focus();
							}
						}
					});
				}
		});
		$('#username').focus();
	});
	</script>
</head>
<body>
<div id="loading2" style="display:none;position:absolute;z-index:9999999;top:50%;margin-top:-65px;height:110px;width:100%;">
</div>
<div id="login-header" style="background-color:#f5f5f5;border-bottom: 1px solid #e5e5e5;height:70px;margin-bottom:35px;">
	<div style="width:1000px;margin:0 auto;font-size:50px;line-height:50px;height:40px;padding-top:12px;"><img src="<?php echo base_url()?>webroot/media/images/c-care-logo-1.gif"></div>
	<div class="logo" style="width:1000px;margin:0 auto;font-size:12px;">Computerized Health Care System</div>
	<div style="clear:both"></div>
</div>
<div id="login-body" style="width:1000px;margin:0 auto;">
	<div style="float:left;width:656px;">
        <div class="slider-wrapper theme-default">
            <div class="ribbon"></div>
            <div id="slider" class="nivoSlider">
                <img src="<?php echo base_url()?>/webroot/media/images/about/1.png" title="Trade Mark Clinic Care (c-Care)"/>
               <!-- <img src="<?php //echo base_url()?>/webroot/media/images/about/2.png" title="Mampu berintegrasi dengan sistem lain seperti website maupun aplikasi lain menggunakan web service" /> -->
                <img src="<?php echo base_url()?>/webroot/media/images/about/3.png" title="Dikembangkan menggunakan software Open Source yang powerfull dan telah digunakan oleh berbagai perusahaan besar di dunia" />
                <!-- <img src="<?php //echo base_url()?>/webroot/media/images/about/4.png" title="Web Development menggunakan teknologi terkini HTML 5 dan CSS 3" /> -->
                <img src="<?php echo base_url()?>/webroot/media/images/about/7.png" title="Terdapat Lebih dari 14.000 data obat di dalam databasenya " /> 
                <img src="<?php echo base_url()?>/webroot/media/images/about/5.png" title="Di Kembangkan Oleh PT. SISFOMEDIKA yang Fokus pada Teknologi Informasi Keseatan yang Open Source" />
                <img src="<?php echo base_url()?>/webroot/media/images/about/6.png" title="Bekerja Sama dengan Institusi Pendidikan (SIMKES UGM)" />
            </div>
        </div>	
	</div>
	<div style="float:right;width:300px;padding:10px 20px 10px 20px;min-height:280px;border:1px solid #e5e5e5;background-color:#f5f5f5">
		<div class="logo" style="font-size:24px;line-height:40px;">c-Care<sup>1.1</sup><span style="font-family:arial;font-size:14px;color:#000">&nbsp;Login</span></div>
		<form class="ui-form" method="post" id="login-form" action="<?php echo site_url('login/process_form')?>">
		<label>
			Username : admin
			<input id="username" name="username" autocomplete="off" class="required" tabindex="1" size="30" type="text" onkeypress="focusNext('pwd', 'pwd', this, event)" />
			<div style="text-align:right"><label for="username" generated="true" id="error-username" class="error" style="display: none;"></label>&nbsp;</div>
		</label>
		<label>
			Password : rahasia
			<input id="pwd" name="pwd" autocomplete="off" class="required" tabindex="2" size="30" type="password" onkeypress="focusNext('submitButton', 'username', this, event)" />
			<div style="text-align:right"><label for="pwd" generated="true" id="error-password" class="error" style="display: none;"></label>&nbsp;</div>
		</label>
		<input type="submit" id="submitButton" value="Login" />
		</form>
	</div>
	<div style="clear:both"></div>
</div>	
	<div style="width:1000px;margin:40px auto;min-height:220px;border:1px solid #e5e5e5;background-color:#f5f5f5;display:none">
	</div>
<div id="loading2" style="display:none;position:absolute;z-index:9999999;top:50%;margin-bottom:-65px;height:110px;width:100%;">
<div style="width:100%;overflow:visible;height:38px;text-align:center;"><img src="<?php echo base_url()?>webroot/media/images/c-care-logo.gif"></div>
</div>
</body>
</html>
