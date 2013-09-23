<script language="javascript" type="text/javascript">
$(document).ready(function() {
	$('.numeric').numeric();
    $('#mc_explanation_other').focus(function() {
        if($(this).val() == 'Other...') $(this).val('');
        $(this).prev().attr('checked','checked');
    })
    .blur(function() {
        if($(this).val() == '') $(this).val('Other...');
    });

    //LIST 
    $('#btnCloseMedicalCertificate').click(function(){
		$('#panel_checkup').hide();
		$('#alergi_container').hide();
		$('#alergi_msg_box').html('');
		$('#panel_checkup_content').children().remove();
		$('#panel_checkup_content').html('<div class="divLoading"></div>');
	});
    $('#list_mc').load('<?php echo base_url()."visit/medical_certificate/lists/".$data['visit_id'];?>');
	$.validator.addMethod("mcUsage", function(value, element) {
		var val = $('input:radio[@name=mc_explanation_id]:checked').val();
		//var other_val = $('#mc_explanation_other').val();
        //alert(val);
        //alert(other_val);
		if(val == 'other' && (value == '' || value == 'undefined' || value == 'Other...')) {
			return false;
		}
		return true;
	}, "Please fill this field");
    $("#frmMc").validate({
        rules: {
            mc_explanation_other:{
                mcUsage:true
            }
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
                        show_message('#message_mc', data.msg, data.status);
                        if(data.last_id) {
                            openPrintPopup('medical_certificate/prints/' + data.last_id);
                            $('#list_mc').load('../visit/medical_certificate/lists/<?php echo $data['visit_id']?>');
                        }
                        $('#frmSearch').submit();
                    }
                });
            }
    });
    $('#mc_no').focus();
});
</script>
<div id="message_mc"></div>
<form method="post" name="frmMc" id="frmMc" action="<?php echo site_url('visit/medical_certificate/process_form_mc')?>">
<input type="hidden" name="mc_visit_id" id="mc_visit_id" value="<?php echo $data['visit_id']?>" />
    <table cellpadding="0" cellspacing="0" border="0" class="tblInput">
        <tr>
            <td style="width:150px;">Nomor</td>
            <td>
				<input type="text" name="mc_no" id="mc_no" class="required numeric" size="4" onkeypress="focusNext('mc_name', 'mc_name', this, event)" />
				<input type="text" readonly="readonly" class="readonly2" name="mc_no_hidden" id="mc_no_hidden" value="/<?php echo $data['no']?>" />
            </td>
        </tr>
        <tr>
            <td>Nama</td>
            <td><input type="text" name="mc_name" id="mc_name" value="<?php echo $data['name']?>" readonly="readonly" class="readonly2" size="40" onkeypress="focusNext('mc_address', 'mc_no', this, event)"/></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><input type="text" name="mc_address" id="mc_address" value="<?php echo $data['address']?>" readonly="readonly" class="readonly2" size="50" onkeypress="focusNext('mc_job', 'mc_name', this, event)"/></td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td><input type="text" name="mc_job" id="mc_job" value="<?php echo $data['job_name']?>" readonly="readonly" class="readonly2" size="40" onkeypress="focusNext('mc_sex', 'mc_address', this, event)"/></td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td><input type="text" name="mc_sex" id="mc_sex" value="<?php echo $data['sex']?>" readonly="readonly" class="readonly2" size="20" onkeypress="focusNext('mc_result_1', 'mc_job', this, event)"/></td>
        </tr>
        <tr>
            <td>Hasil</td>
            <td>
                <label for="mc_result_1">
                <input type="radio" name="mc_result" id="mc_result_1" value="Sehat" onkeypress="focusNext('mc_doctor_id', 'mc_sex', this, event)" checked="checked" />
                Sehat
                </label>

                <label for="mc_result_2">
                <input type="radio" name="mc_result" id="mc_result_2" value="Tidak Sehat" onkeypress="focusNext('mc_doctor_id', 'mc_sex', this, event)"/>
                Tidak Sehat
                </label>
            </td>
        </tr>
        <tr>
            <td>Dokter</td>
            <td>
                <select name="mc_doctor_id" id="mc_doctor_id" style="width:200px" onkeypress="focusNext('mc_explanation_id_0', 'mc_result_1', this, event)" class="required">
                <?php for($i=0;$i<sizeof($doctor);$i++) :?>
                    <option value="<?php echo $doctor[$i]['id'];?>"><?php echo $doctor[$i]['name'];?></option>
                <?php endfor;?>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">Surat Keterangan sehat ini digunakan untuk :
                <ol>
                    <?php for($i=0;$i<sizeof($mc_explanation);$i++) :?>
                    <li>
                        <label for="mc_explanation_id_<?php echo $i?>">
                            <?php if($i==0) $checked="checked='checked'"; else $checked=""; ?>
                            <input type="radio" name="mc_explanation_id" id="mc_explanation_id_<?php echo $i;?>" value="<?php echo $mc_explanation[$i]['id']?>" onkeypress="focusNext('mc_submit', 'mc_doctor_id', this, event)" <?php echo $checked;?>/>
                            <?php echo $mc_explanation[$i]['name'];?>
                        </label>
                    </li>
                    <?php endfor;?>
                    <li>
                        <label for="mc_explanation_other">
                            <input type="radio" name="mc_explanation_id" id="mc_explanation_id_" value="other" onkeypress="focusNext('mc_explanation_<?php echo ($i+1);?>', 'mc_explanation_<?php echo ($i-1);?>', this, event)"/>
                            <input type="text" name="mc_explanation_other" id="mc_explanation_other" size="50" value="Other..." onkeypress="focusNext('mc_submit', 'mc_explanation_id_0', this, event)"/>
                        </label>
                    </li>
                </ol>
            </td>
        </tr>
        <tr>
            <td colspan="2"><input type="submit" name="submit" id="mc_submit" value="Simpan &amp; Cetak" />
            <input type="button" name="Close" id="btnCloseMedicalCertificate" value="  Tutup  " />
            </td>
        </tr>
    </table>
</form>
<div id="list_mc"></div>
