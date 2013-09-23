<script language="JavaScript" type="text/javascript">
$(document).ready(function() {
//DEFINE THE SHORTCUT
	$(".numeric").numeric();
/*$('#spesialisasinya').autocomplete("profile/get_list_spesialisasinya", {
        selectFirst: false
    });*/
    
//VALIDATING INPUT
	$("#frmProfile").validate({
		rules: {
            name: "required",
            code: "required",
            code2: {
				required:true,
				minlength:2
			},
            address: "required",
            phone: "required"
		},
        submitHandler:
            function(form) {
                $(form).ajaxSubmit({
					dataType: 'json',
                    success:function(data) {
                        show_message('#message', data.msg, data.status);
						$("#name").focus();
                    }
                });
            }
	});
	$('#Filedata').change(function() {
	    $('#frmUpload').submit();    
    });
	$('#Filedata2').change(function() {
		//alert('asdf');
	    $('#frmUploadScreensaver').submit();    
    });
	$("#check_all").toggle(function() {
		$("#check_all").text("Hilangkan tanda");
		$('.work_area').attr("checked", "checked");
	}, function() {
		$("#check_all").text("Tandai semua");
		$('.work_area').removeAttr("checked");
	});
    $('#name').focus();
});


function upload_start() {
    $("#photo_img").fadeOut('slow');
}
function upload_error() {
    alert('Upload Error');
}
function upload_complete(file) {
    $("#photo_img").attr("src", "<?php echo base_url()?>webroot/media/upload/" + file.name).fadeIn('slow');
}
function nothing(){}
</script>
<div class="ui-dialog" style="width:100%;margin-right:5px;height:auto;float:left;">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar"><?php echo $title;?></div>
		<div class="ui-dialog-content" id="dialogContent">
            <div id="message" style="display:none"></div>
            <div style="clear:both"></div>
            <div style="float:left;width:450px;">
			<form method="POST" name="frmProfile" id="frmProfile" action="<?php echo site_url('admdata/profile/process_form');?>" enctype="multipart/form-data">
			<table cellpadding="0" cellspacing="0" border="0" class="tblInput" style="width:100%;">
				<tr>
					<td>Nama Dokter(Beserta Gelar)</td>
					<td><input type="text" name="name" id="name" value="<?php echo $profile['name'];?>" size="30" onkeypress="focusNext('spesialisasi_id', 'name', this, event)" /></td>
				</tr>
				<tr>
					<td style="width:200px;">Spesialisasi</td>
					<td>
						<input type="text" name="spesialisasinya" id="spesialisasinya" value="<?php echo $profile['spesialisasi'];?>" size="40" onkeypress="focusNext('no_str', 'spesialisasinya', this, event)" />
					</td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_no_str');?></td>
					<td><input type="text" name="no_str" id="no_str" value="<?php echo $profile['no_str'];?>" size="40" onkeypress="focusNext('awal_berlaku_str', 'no_str', this, event)" /></td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_masa_berlaku_str');?></td>
					<td><input type="text" name="awal_berlaku_str" id="awal_berlaku_str" value="<?php echo $profile['awal_str'];?>" size="10" maxlength="10" onkeyup="autoSlashTanggal(this, event)" onkeypress="focusNext('akhir_berlaku_str', 'awal_berlaku_str', this, event)" />
					<?php echo sampai; ?>
					<input type="text" name="akhir_berlaku_str" id="akhir_berlaku_str" value="<?php echo $profile['akhir_str'];?>" size="10" maxlength="10" onkeyup="autoSlashTanggal(this, event)" onkeypress="focusNext('no_sip', 'akhir_berlaku_str', this, event)" /><i>dd/mm/yyyy</i>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_no_sip');?></td>
					<td><input type="text" name="no_sip" id="no_sip" value="<?php echo $profile['no_sip'];?>" size="40" onkeypress="focusNext('phone', 'phone', this, event)" /></td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_masa_berlaku_sip');?></td>
					<td><input type="text" name="awal_berlaku_sip" id="awal_berlaku_sip" value="<?php echo $profile['awal_sip'];?>" size="10" maxlength="10" onkeyup="autoSlashTanggal(this, event)" onkeypress="focusNext('age_year', 'no_sip', this, event)" />
					<?php echo sampai; ?>
					<input type="text" name="awal_berlaku_sip" id="awal_berlaku_sip" value="<?php echo $profile['awal_sip'];?>" size="10" maxlength="10" onkeyup="autoSlashTanggal(this, event)" onkeypress="focusNext('age_year', 'birth_place', this, event)" /><i>dd/mm/yyyy</i>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_address');?></td>
					<td><input type="text" name="address" id="address" value="<?php echo $profile['address'];?>" size="40" onkeypress="focusNext('phone', 'phone', this, event)" /></td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_phone');?>/ HP</td>
					<td><input type="text" name="phone" id="phone" value="<?php echo $profile['phone'];?>" size="30" onkeypress="focusNext('no_str', 'no_str', this, event)" /></td>
				</tr>
				<tr>
					<td colspan="2"><hr /></td>
				</tr>
				<tr>
					<td>Header Laporan</td>
					<td><input type="text" name="report_header_1" id="report_header_1" value="<?php echo $profile['report_header_1'];?>" size="30" onkeypress="focusNext('report_header_2', 'head_office_number', this, event)" /></td>
				</tr>
				<tr>
					<td colspan="2"><hr /></td>
				</tr>
				<tr>
					<td>Screensaver delay</td>
					<td><input type="text" name="screensaver_delay" id="screensaver_delay" value="<?php echo $profile['screensaver_delay'];?>" size="10" maxlength="10" onkeypress="focusNext('save', 'url_service_server', this, event)" class="required" /> milisecond</td>
				</tr>
				<tr>
					<td></td>
                    <td>
                        <input type="submit" name="Save" id="save" value="Simpan" />
                        <input type="reset" name="Reset" id="reset" value="Batal" onclick="fokus('name');" />
                    </td>
				</tr>
			</table>
			</form>
			</div>
			<div>
			<fieldset>
				<legend>Logo</legend>
				<form id="frmUpload" method="post" action="<?php echo site_url('admdata/profile/upload_photo');?>" enctype="multipart/form-data" target="freme_status_upload">
					<img id="photo_img" src="<?php echo base_url();?>webroot/media/upload/<?php echo $profile['photo'];?>" width="150"/>
					<input type="file" name="Filedata" id="Filedata" size="10" />
				</form>
			</fieldset>
			<fieldset>
				<legend>Foto/ Gambar Depan</legend>
				<form id="frmUploadScreensaver" method="post" action="<?php echo site_url('admdata/profile/upload_screensaver');?>" enctype="multipart/form-data" target="freme_status_upload_screensaver">
					<img id="screensaver_img" src="<?php echo base_url();?>webroot/media/upload/<?php echo $profile['screensaver'];?>" width="400" />
					<input type="file" name="Filedata2" id="Filedata2" size="10" />
				</form>
			</fieldset>
                <iframe name="freme_status_upload" style="display:none;" id="freme_status_upload" src="<?php echo site_url('admdata/profile/upload_photo');?>"></iframe>
                <iframe name="freme_status_upload_screensaver" style="display:none;" id="freme_status_upload_screensaver" src="<?php echo site_url('admdata/profile/upload_screensaver');?>"></iframe>
			</div>
		</div>
        <!-- <div class="ui-dialog-buttonpane">
            Press Ctrl+f to finding patients
        </div> -->
	</div>
</div>
