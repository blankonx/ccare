<script language="javascript" type="text/javascript">
$(document).ready(function() {
    //LIST 
    //$('#ck_permit_day').numeric();
    $('#btnClosePemulanganPasien').click(function(){$('#panel_checkup').slideUp('fast')});
    //$('#list_ck').load('<?php echo base_url()."visit/checkout/lists/".$data['visit_id'];?>');
    /*SICKNESS EXPLANATION FORM*/
    $("#frmCk").validate({
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
<div id="message_ck"></div>
<form method="post" name="frmCk" id="frmCk" action="<?php echo site_url('visit/checkout/process_form_ck')?>">
<input type="hidden" name="visit_inpatient_id" id="visit_inpatient_id" value="<?php echo $data['visit_inpatient_id']?>" />
<input type="hidden" name="visit_inpatient_clinic_id" id="visit_inpatient_clinic_id" value="<?php echo $data['visit_inpatient_clinic_id']?>" />
	<table cellpadding="0" cellspacing="0" border="0" class="tblInput" style="background:#c1db6b;padding:20px;">
		<tr>
            <td style="width:170px;vertical-align:middle;">
                Keadaan Keluar
            </td>
            <td style="width:300px;">
                <select name="inpatient_exit_condition_id" id="inpatient_exit_condition_id" style="width:200px;font-size:18px;">
				<option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
                <?php for($i=0;$i<sizeof($keadaan_keluar);$i++) :?>
                <?php if($keadaan_keluar[$i]['id'] == $data['keadaan_keluar_id']) $sel='selected="selected"'; else $sel=''; ?>
                    <option value="<?php echo $keadaan_keluar[$i]['id']?>" <?php echo $sel?>><?php echo $keadaan_keluar[$i]['name']?></option>
                <?php endfor;?>
                </select>
            </td>
			<td style="width:150px;vertical-align:middle;">Tanggal Pemulangan</td>
			<td style="width:300px;">
				<input type="text" name="date" id="date" size="8" style="font-size:18px;" value="<?php echo date('d/m/Y')?>" />
				<input type="text" name="time" id="time" size="3" style="font-size:18px;" value="<?php echo date('H:i')?>" />
			</td>
		</tr>
		<tr>
            <td style="width:170px;vertical-align:middle;">
                Cara Keluar
            </td>
            <td style="width:300px;">
                <select name="inpatient_continue_id" id="inpatient_continue_id" style="width:200px;font-size:18px;">
				<option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
                <?php for($i=0;$i<sizeof($cara_keluar);$i++) :?>
                <?php if($cara_keluar[$i]['id'] == $data['cara_keluar_id']) $sel='selected="selected"'; else $sel=''; ?>
                    <option value="<?php echo $cara_keluar[$i]['id']?>" <?php echo $sel?>><?php echo $cara_keluar[$i]['name']?></option>
                <?php endfor;?>
                </select>
            </td>
		</tr>
	</table>
	<hr style="margin-bottom:20px;"/>
    <div class="tblInput">
    <input type="submit" name="submit" id="ck_submit" value="Simpan" />
            <input type="button" name="Close" id="btnClosePemulanganPasien" value="  Tutup  " />
    </div>
</form>
