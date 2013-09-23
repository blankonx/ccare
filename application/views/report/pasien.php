<script language="javascript">

//get List Data

$(document).ready(function() {
    var errContainer = $('#errMessage');
	var validator = $("#frmReport").validate({
        errorContainer : errContainer,
		rules: {
		},
        submitHandler:
            function(form) {
                $(form).ajaxSubmit({
					beforeSubmit:function() {
						$('#list_data').html('<div style="text-align:center"><img src="<?php echo base_url()?>webroot/media/images/loader-black.gif"/></div>');
					},
                    target: '#list_data',
                    success:function(data) {
                        //$('#unit_kerja_label').text($('#unit_kerja_id option:selected').text());
						$("#unit").focus();
                    }
                });
            }
	});
	$('#frmReport').submit();
    $("#unit").focus();
});

</script>
<div class="ui-dialog" style="width:100%;margin-right:5px;height:auto;float:left;">
	<div class="ui-dialog-titlebar"><?php echo $title;?></div>
	<div class="ui-dialog-content" id="dialogContent">
		
	
   </div>
</div>
