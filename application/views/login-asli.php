<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php echo $_profile['name'];?>  &raquo; <?php echo strip_tags($title);?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>webroot/media/css/loginx.css">
    <script type="text/javascript" src="<?php echo base_url()?>webroot/jquery/js/jquery-1.2.6.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>webroot/jquery/js/jquery.form.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>webroot/jquery/js/jquery.validate.js"></script>
	<script type="text/javascript" src="<?php echo base_url()?>webroot/media/js/sikesda.js"></script>
	<script type="text/javascript">
	var show_message_timeout_id;
	function show_message_login(containerId, msg, xstatus) {
		clearTimeout(show_message_timeout_id);
		$(containerId).html('<em>Loading...</em>');
		$(containerId).html('').html('<em>'+msg+'</em>');
		show_message_timeout_id = setTimeout(function(){$(containerId).html('SISFOMAS LOGIN');}, 1500);
	}

	$(document).ready(function() {
		$("input[@type=text]").attr('autocomplete', 'off').focus(function(){this.select();});
		$(document).mouseup(function() {
			$("#loginform").mouseup(function() {
				return false;
			});
			$("a.close").click(function(e){
				e.preventDefault();
				$("#loginform").hide();
				$(".lock").fadeIn();
			});
			if ($("#loginform").is(":hidden")) {
				$(".lock").fadeOut();
			} else {
				$(".lock").fadeIn();
			}				
			$("#loginform").toggle();
			$("#username").focus();
		});
		// I dont want this form be submitted
		$("#signin").validate({
			submitHandler:
				function(form) {
					$(form).ajaxSubmit({
						dataType: 'json',
						success:function(data) {
							show_message_login('#login-title', data.msg, data.status);
							if(data.status == 'success') {
								document.location='<?php echo site_url("home/dashboard");?>'
							}
							$("#username").focus();
						}
					});
				}
		});
		
		// This is example of other button
		$("input#cancel_submit").click(function(e) {
			$("#loginform").hide();
			$(".lock").fadeIn();
		});
	});
	</script>

</head>
<body>
<div id="cont">
  <div class="box lock"></div>
  <div id="loginform" class="box form">
    <h2><span id="login-title">SISFOMAS LOGIN</span> <a href="" class="close">Tutup</a></h2>
    <div class="formcont">
    <fieldset id="signin_menu">
    <span class="message">Masukkan username dan password Anda dengan benar.</span>
    <form method="post" id="signin" action="<?php echo site_url('login/process_form')?>">
      <label for="username">Username</label>
      <input id="username" name="username" value="" class="required" tabindex="4" type="text" onkeypress="focusNext('pwd', 'login', this, event)" />
      </p>
      <p>
        <label for="password">Password</label>
        <input id="pwd" name="pwd" value="" class="required" tabindex="5" type="password">
      </p>
      <p class="clear"></p>
      <a href="#" class="forgot" style="display:none;" id="resend_password_link">Lupa password?</a>
      <p class="remember">
        <input id="signin_submit" value="Login" tabindex="6" type="submit"/>
        <input id="cancel_submit" value="Batal" tabindex="7" type="button"/>
      </p>
    </form>
    </fieldset>
    </div>
    <div class="formfooter"></div>
  </div>
</div>

<!-- Begin Full page background technique -->
<!--<div id="bg">
  <div>
    <table cellspacing="0" cellpadding="0">
      <tr>
        <td><img src="<?php echo base_url();?>webroot/media/images/mac.jpg" alt=""/> </td>
      </tr>
    </table>
  </div>
</div>-->
<!-- End Full page background technique -->
</body>
</html>
