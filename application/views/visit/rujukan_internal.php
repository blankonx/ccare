<script language="javascript" type="text/javascript">
$(document).ready(function() {
    //LIST 
    //$('#pr_permit_day').numeric();
    $('#btnCloseRujukanInternal').click(function(){$('#panel_rujukan_internal').slideUp('fast')});
    //$('#list_pr').load('<?php echo base_url()."visit/rujukan_internal/lists/".$data['visit_id'];?>');
    /*SICKNESS EXPLANATION FORM*/
    $("#frmPr").validate({
        rules: {
        
        },
        submitHandler:
            function(form) {
                $(form).ajaxSubmit({
                    beforeSubmit:disableForm,
                    dataType: 'json',
                    success:function(data) {
                        enableForm();
						$('#frmSearch').submit();
						$('#close_panel_rujukan_internal').click();
                        show_message('#message', data.msg, data.status);
                    }
                });
            }
    });
});
</script>
<div id="message_pr"></div>
<form method="post" name="frmPr" id="frmPr" action="<?php echo site_url('visit/rujukan_internal/process_form_pr')?>">
<input type="hidden" name="visit_id" id="visit_id" value="<?php echo $data['visit_id']?>" />
<input type="hidden" name="visit_clinic_id" id="visit_clinic_id" value="<?php echo $data['visit_clinic_id']?>" />
	<table cellpadding="0" cellspacing="0" border="0" class="tblInput" style="background:#c1db6b;padding:20px;">
		<tr>
            <td style="width:170px;vertical-align:middle;">
                Poliklinik Tujuan
            </td>
            <td style="width:300px;">
						<select name="clinic_id" id="clinic_id" style="width:200px" onkeypress="focusNext('payment_type_id', 'admission_type_id', this, event)">
							<option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
							<?php $k=0; for($i=0;$i<sizeof($combo_clinic);$i++) :?>
							<?php 
                                if($i!=0 && $combo_clinic[$i]['parent_id'] != $combo_clinic[$i-1]['parent_id'] && $combo_clinic[$i-1]['parent_id'] != NULL) {
                                    echo '</optgroup>';
                                }
                                if($combo_clinic[$i]['parent_id'] != NULL && $combo_clinic[$i]['parent_id'] != $combo_clinic[$i-1]['parent_id']) :
                                    echo '<optgroup label="'.$combo_clinic[$i]['parent_name'].'">';
							?>
							<?php endif;?>
								<option value="<?php echo $combo_clinic[$i]['id']?>"><?php echo $combo_clinic[$i]['name']?></option>
							<?php endfor;?>
						</select>
            </td>
			<td style="width:150px;vertical-align:middle;">Tanggal Rujukan</td>
			<td style="width:300px;">
				<input type="text" name="date" id="date" size="8" style="font-size:18px;" value="<?php echo date('d/m/Y')?>" />
				<input type="text" name="time" id="time" size="3" style="font-size:18px;" value="<?php echo date('H:i')?>" />
			</td>
		</tr>
	</table>
	<hr style="margin-bottom:20px;"/>
    <div class="tblInput">
    <input type="submit" name="submit" id="pr_submit" value="Simpan" />
            <input type="button" name="Close" id="btnCloseRujukanInternal" value="  Tutup  " />
    </div>
</form>
