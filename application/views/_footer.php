</div><!-- endOfMainContainer -->
<script language="javascript" type="text/javascript">
$(document).ready(function() {
	$('#chat_title').toggle(function() {
		$('#chat_msg_box').show();
		$('#chatForm').show();
		$('#chat_msg').focus();
		$('#chat_title').css('text-decoration', 'none');
	}, function() {
		$('#chat_msg_box').hide();
		$('#chatForm').hide();
		$('#chat_title').css('text-decoration', 'none');
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
                        //$('#chat_msg_box').load('<?php echo base_url().'home/chat_get';?>');
						$('#chat_msg_box').html(data);
                        $('#chat_msg').focus();
                    }
                });
            }
	});
    chatReload();
});
var chatI=0;
var chatTimeoutId;
function chatReload() {
	var before = $('#chat_msg_box div:last').text();
	$.ajax({
		url:'<?php echo site_url('home/chat_get');?>',
		success: function(data) {
			$('#chat_msg_box').html(data);
			var after = $('#chat_msg_box div:last').text();
			if(before != after && chatI > 0) {
				$('#chat_title').css('text-decoration', 'blink');
			}
			chatI++;
		}
	});
	chatTimeoutId = setTimeout("chatReload()", 10000);
}
</script>
</div><!-- endOfRightFrame -->
</div><!-- endOfContentContainer -->
</div><!-- endOfAllContainer -->
<div id="chat_container">
	<div id="chat_title" style="cursor:pointer">Chat : <em><?php echo $this->session->userdata('name');?></em></div>
	<div id="chat_msg_box" style="margin:1px auto;display:none;"></div>
	<form id="chatForm" name="chatForm" method="post" action="<?php echo site_url('home/chat_send')?>" style="display:none;">
		<input type="text" name="chat_msg" id="chat_msg" value="" size="27" class="input_default" />
		<input type="submit" name="chat_submit" id="chat_submit" value="Kirim" style="display:none" />
	</form>
</div>
<div style="width:100%;margin:0;auto;font-size:12px;text-align:center;">copyright &copy; yayangroup</div>
</body>
</html>
