<script language="javascript" type="text/javascript">
$(document).ready(function() {
    //LIST
	$('.numeric').numeric(); 
    $('#se_permit_day').numeric();
    $('#btnCloseSicknessExplanation').click(function(){
		$('#panel_checkup').hide();
		$('#alergi_container').hide();
		$('#alergi_msg_box').html('');
		$('#panel_checkup_content').children().remove();
		$('#panel_checkup_content').html('<div class="divLoading"></div>');
	});
    $('#list_se').load('<?php echo base_url()."/visit/sickness_explanation/lists/".$data['visit_id'];?>');
    /*SICKNESS EXPLANATION FORM*/
    $("#frmSe").validate({
        rules: {
        
        },
        submitHandler:
            function(form) {
                //$('#reloadData').ajaxStart(function(){$(this).removeClass().addClass('buttonReloadIsLoad');});
                //$('#reloadData').ajaxStop(function(){$(this).removeClass().addClass('buttonReload');});
                $(form).ajaxSubmit({
                    beforeSubmit:disableForm,
                    dataType: 'json',
                    success:function(data) {
                        enableForm();
                        show_message('#message_se', data.msg, data.status);
                        if(data.last_id) {
                            openPrintPopup('sickness_explanation/prints/' + data.last_id);
                            $('#list_se').load('../visit/sickness_explanation/lists/<?php echo $data['visit_id']?>');
                        }
                        $('#frmSearch').submit();
                    }
                });
            }
    });
    $('#se_no').focus();
});
</script>
<div id="message_se"></div>
<form method="post" name="frmSe" id="frmSe" action="<?php echo site_url('visit/sickness_explanation/process_form_se')?>">
<input type="hidden" name="se_visit_id" id="se_visit_id" value="<?php echo $data['visit_id']?>" />
    <table cellpadding="0" cellspacing="0" border="0" class="tblInput">
        <tr>
            <td style="width:150px;">Nomor</td>
            <td>
				<input type="text" name="se_no" id="se_no" class="required numeric" size="4" onkeypress="focusNext('se_name', 'se_name', this, event)"/>
				<input type="text" readonly="readonly" class="readonly2" name="se_no_hidden" id="se_no_hidden" value="/<?php echo $data['no']?>" />
            </td>
        </tr>
        <tr>
            <td>Nama</td>
            <td><input type="text" name="se_name" id="se_name" value="<?php echo $data['name']?>" readonly="readonly" class="readonly2" size="40" onkeypress="focusNext('se_address', 'se_no', this, event)"/></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><input type="text" name="se_address" id="se_address" value="<?php echo $data['address']?>" readonly="readonly" class="readonly2" size="50" onkeypress="focusNext('se_job', 'se_name', this, event)"/></td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td><input type="text" name="se_job" id="se_job" value="<?php echo $data['job_name']?>" readonly="readonly" class="readonly2" size="40" onkeypress="focusNext('se_sex', 'se_address', this, event)"/></td>
        </tr>
        <tr>
            <td>Pendidikan</td>
            <td><input type="text" name="se_education" id="se_education" value="<?php echo $data['education_name']?>" readonly="readonly" class="readonly2" size="40" onkeypress="focusNext('se_sex', 'se_address', this, event)"/></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td><input type="text" name="se_sex" id="se_sex" value="<?php echo $data['sex']?>" readonly="readonly" class="readonly2" size="20" onkeypress="focusNext('se_permit_day', 'se_job', this, event)"/></td>
        </tr>
        <tr>
            <td>Istirahat selama</td>
            <td><input type="text" name="se_permit_day" id="se_permit_day" value="3" size="5" onkeypress="focusNext('se_date', 'se_sex', this, event)"/> hari, dari tanggal <input type="text" name="se_date" id="se_date" value="<?php echo date('d/m/Y');?>" size="10" onkeypress="focusNext('se_explanation', 'se_permit_day', this, event)" onkeyup="autoSlashTanggal(this, event)" class="date-pick"/><i>dd/mm/yyyy</i></td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td><textarea name="se_explanation" id="se_explanation" cols="40" rows="5" onkeypress="focusNext('se_result_1', 'se_permit_day', this, event)"><?php echo $data['explanation']?></textarea></td>
        </tr>
        <tr>
            <td>Dokter</td>
            <td>
                <select name="se_doctor_id" id="se_doctor_id" style="width:200px" onkeypress="focusNext('se_explanation_id_0', 'se_result_1', this, event)" class="required">
                <?php for($i=0;$i<sizeof($doctor);$i++) :?>
                    <option value="<?php echo $doctor[$i]['id'];?>"><?php echo $doctor[$i]['name'];?></option>
                <?php endfor;?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" name="submit" id="se_submit" value="Simpan &amp; Cetak" />
            <input type="button" name="Close" id="btnCloseSicknessExplanation" value="  Tutup  " />
            </td>
        </tr>
    </table>
</form>
<div id="list_se"></div>
