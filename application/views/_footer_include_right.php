</div><!-- endOfMainContainer -->
<script>
$(document).ready(function() {
    $('#tblHideRightFrame').hover(
        function() {
            $('#tblHideRightFrame').fadeTo('slow', 1);
        },
        function() {
			$('#tblHideRightFrame').fadeTo('slow', 0.3);
		}
    );

    $('#tblHideRightFrame').click(function() {
		if($(this).attr('class') == 'tblHide') { //hiding
			$('#rightFrame').hide(
			function() {
				//$('#rightFrame').hide();
				$('#main-container').animate({
					'width' : '100%'
				}, 
				'fast',
				function() {
					//$('#rightFrame').hide();
					$('#tblHideRightFrame').removeClass().addClass('tblShow');
				});
			});
		} else { //showing
			//$('#rightFrame').hide();
			$('#main-container').animate({
				'width' : '75%'
			}, 
			'fast',
			function() {
				$('#rightFrame').show();
				$('#tblHideRightFrame').removeClass().addClass('tblHide');
			});
		}
    });
    //$('#tblHideRightFrame').click();
	
    $('#rightFrame').hide();
	//$('#main-container').css({'width' : 1000});
	//alert('asdf');
	$('#chat_title').toggle(function() {
		$('#chat_msg_box').show();
		$('#chatForm').show();
		$('#chat_msg').focus();
	}, function() {
		$('#chat_msg_box').hide();
		$('#chatForm').hide();
	});
    $("#chatForm").validate({
        submitHandler:
            function(form) {
                $(form).ajaxSubmit({
                    beforeSubmit:function() {
                        if($('#chat_msg').val() == '') return false;
                    },
                    clearForm:true,
                    success:function(data) {
                        $('#chat_msg_box').load('<?php echo base_url().'home/chat_get';?>');
                        $('#chat_msg').focus();
                    }
                });
            }
	});
    chatReload();
});
var chatTimeoutId;
function chatReload() {
	$('#chat_msg_box').load('<?php echo site_url('home/chat_get');?>');
	chatTimeoutId = setTimeout("chatReload()", 60000);
}
</script>

<div id="tblHideRightFrame" class="tblShow" style="position:absolute;z-index:1;left:97%;opacity:0.3"></div>
<div id="rightFrame" style="width:295px;float:left;">
	<!-- accordion start -->
	<div id="accordion" style="overflow:hidden">
		<div class="ui-accordion-group">
			<h3 class="ui-accordion-header"><a href="#">Informasi</a></h3>
			<div class="ui-accordion-content">
				<div id="debug" style="display:none"></div>
                <i>Login Sebagai <?php echo $this->session->userdata('name')?></i><br/><br/>
			</div>
		</div>
	</div>
	<!-- accordion end -->
</div><!-- endOfRightFrame -->
</div><!-- endOfContentContainer -->
</div><!-- endOfAllContainer -->
<div id="chat_container">
	<div id="chat_title" style="cursor:pointer">Chatting</div>
	<div id="chat_msg_box" style="margin:1px auto;display:none;"></div>
	<form id="chatForm" name="chatForm" method="post" action="<?php echo site_url('home/chat_send')?>" style="display:none;">
		<input type="text" name="chat_msg" id="chat_msg" value="" size="27" class="input_default" />
		<input type="submit" name="chat_submit" id="chat_submit" value="Kirim" style="display:none" />
	</form>
</div>
</body>
</html>
