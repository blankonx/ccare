<script language="javascript" type="text/javascript">
$(document).ready(function() {
    //LIST 
    //$('#pr_permit_day').numeric();
    $('#btnClosePindahRuang').click(function(){$('#panel_checkup').slideUp('fast')});
    //$('#list_pr').load('<?php echo base_url()."visit/pindah_ruang/lists/".$data['visit_id'];?>');
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
						$('#close_panel_checkout').click();
                        show_message('#message', data.msg, data.status);
                    }
                });
            }
    });
});
</script>
<div id="message_pr"></div>
<form method="post" name="frmPr" id="frmPr" action="<?php echo site_url('visit/pindah_ruang/process_form_pr')?>">
<input type="hidden" name="visit_inpatient_id" id="visit_inpatient_id" value="<?php echo $data['visit_inpatient_id']?>" />
<input type="hidden" name="visit_inpatient_clinic_id" id="visit_inpatient_clinic_id" value="<?php echo $data['visit_inpatient_clinic_id']?>" />
	<table cellpadding="0" cellspacing="0" border="0" class="tblInput" style="background:#c1db6b;padding:20px;">
		<tr>
            <td style="width:170px;vertical-align:middle;">
                Bangsal Tujuan
            </td>
            <td style="width:300px;">
                <select name="inpatient_clinic_id" id="inpatient_clinic_id" style="width:200px;font-size:18px;">
				<option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
                <?php for($i=0;$i<sizeof($inpatient_clinic);$i++) :?>
                <?php if($inpatient_clinic[$i]['id'] == $data['inpatient_clinic_id']) $sel='selected="selected"'; else $sel=''; ?>
                    <option value="<?php echo $inpatient_clinic[$i]['id']?>" <?php echo $sel?>><?php echo $inpatient_clinic[$i]['name']?></option>
                <?php endfor;?>
                </select>
            </td>
			<td style="width:150px;vertical-align:middle;">Tanggal Pindah</td>
			<td style="width:300px;">
				<input type="text" name="date" id="date" size="8" style="font-size:18px;" value="<?php echo date('d/m/Y')?>" />
				<input type="text" name="time" id="time" size="3" style="font-size:18px;" value="<?php echo date('H:i')?>" />
			</td>
		</tr>
	</table>
	<hr style="margin-bottom:20px;"/>
    <div class="tblInput">
    <input type="submit" name="submit" id="pr_submit" value="Simpan" />
            <input type="button" name="Close" id="btnClosePindahRuang" value="  Tutup  " />
    </div>
</form>
