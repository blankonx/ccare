<script language="JavaScript" type="text/javascript">

$(document).ready(function() {
//DEFINE THE SHORTCUT
	//opening patient_search form
    $(document).bind('keydown', 'Ctrl+f', function(evt){
		//$("#panel_main").hide($('#visit_date').focus());
        $("#panel_patient_search").slideDown("fast", fokus_patient_search_form);return false;
    });
    $('#before').click(function(){
        var family_folder = parseInt(removeExtraZero($('#family_folder').val()))-1;
        if(family_folder == 0) return;
		$.ajax({
			url: '../admdata/patient/get_data_patient/' + family_folder,
			dataType: 'json',
			success:function(data) {
				fill_form_from_patient(data);
			}
		});
        $('#family_folder').val(addExtraZero(family_folder, 6));
    });
    $('#after').click(function(){
        //alert(parseInt($('#family_folder').val()));
        var family_folder = parseInt(removeExtraZero($('#family_folder').val()))+1;
        //alert(family_folder);
		$.ajax({
			url: '../admdata/patient/get_data_patient/' + family_folder,
			dataType: 'json',
			success:function(data) {
				fill_form_from_patient(data);
			}
		});
        $('#family_folder').val(addExtraZero(family_folder, 6));
    });
	
    $('#show_panel_patient_search').click(function(){
		//$("#panel_main").hide($('#visit_date').focus());
        $("#panel_patient_search").slideDown("fast", fokus_patient_search_form);return false;
    });

	$('#birth_date').change(function() {
		$.ajax({
			url: 'patient/hitung_usia/' + $(this).val(),
			dataType: 'json',
			success:function(data) {
				$('#age_year').val(data.year);
				$('#age_month').val(data.month);
				$('#age_day').val(data.day);
			}
		});
	});
	$('.age').change(function() {
		var age_year = $('#age_year').val();
		var age_month = $('#age_month').val();
		var age_day = $('#age_day').val();
		$.get('patient/get_tgl_lahir/' + age_year + '/' + age_month + '/' + age_day, function(data) {
			$('#birth_date').val(data);
		});
	});
	//closing patient_search form
    $(document).bind('keydown', 'esc', function(evt){
        $("#panel_patient_search").slideUp("slow", fokus_admdata_form);return false;
    });
    $('#close_panel_patient_search').click(function(){
        $("#panel_patient_search").slideUp("slow", fokus_admdata_form);return false;
    });
	$('#reset').click(function(){validator.resetForm();$('#family_folder').focus();reset_form()});
//alphanumericed input :

	$("#family_folder").numeric();

	$("#birth_date").numeric();
	$("#age_year").numeric();
	$("#age_month").numeric();
	$("#age_day").numeric();

//ajaxing patient_search form
    $('#frmPatient_Search').submit(function() {
		$('#divLoadingPatient_Search').ajaxStart(function(){$(this).show();});
		$('#divLoadingPatient_Search').ajaxStop(function(){$(this).hide();});

        $('#frmPatient_Search').ajaxSubmit({
		    type: 'POST',
            target: '#divPatient_SearchResult',
			success:function() {
				$("#q").focus();
				preparePagingLink();
			}
        });
        return false;
    });

	function preparePagingLink() {
		$('.pagingLinks a').click(function() {
				$('#divLoadingPatient_Search').ajaxStart(function(){$(this).show();});
				$('#divLoadingPatient_Search').ajaxStop(function(){$(this).hide();});
				$('#divPatient_SearchResult').load(this.href,preparePagingLink);return false;
			}
		);
	}
//validating the input
	//adding the dependencies of insurance number & payment type

    $('#family_folder').bind('change', function() {
        var no=$(this).val();
        //alert('xxx');
        $.ajax({
            dataType:'json',
            url:'patient/get_data_patient/' + no,
            success:function(data) {
                fill_form_from_patient(data);
            }
        });
    });

	var validator = $("#frmPendaftaran").validate({
		rules: {
            family_folder: {
                required:true,
                number:true,
                min:1
            },
            name: "required",
            birth_place: "required",
            birth_date: {
                required:true,
                date:true
            },
            address: "required",
            education_id: "required",
            job_id: "required"
		},
        submitHandler:
            function(form) {
                $(form).ajaxSubmit({
					beforeSubmit:disableForm,
					dataType: 'json',
                    success:function(data) {
                        show_message('#admdata_message', data.msg, data.status);
						enableForm();
						if(data.status == 'success') $("#reset").click();
                    }
                });
            }
	});

	$('#reset').click();
    //$('#visit_date').focus();

    $('#name').autocomplete("../admission/search/search_by_name", {
            selectFirst: false,
            matchContains: true,
            width:400,
            formatItem: function(data, i, max, term) {
                return '<b>' + data[1] + '</b> '
                + data[5] + ' '
                + data[2] + '<br/>'
                 + data[7]
                + '</div>' ;
		    },
            formatResult: function(data) {
                return data[1];
		    }
    })
    .result(function(event, data, formatted) {
        get_patient_from_search(data[4], data[3]);
    });
    
});

function fokus_search_form() {
	$("#panel_main").hide();
    fokus('q');
}

function fokus_admission_form() {
	$('#panel_main').show();
    fokus('family_folder');
}

function get_patient_from_search(family_folder, family_code) {
    $.ajax({
        dataType:'json',
        url:'patient/get_data_patient/' + family_folder,
        success:function(data) {
            fill_form_from_patient(data);
        }
    });
    $("#panel_search").fadeOut("fast", fokus_admission_form);
}

function reset_form() {
    $.ajax({
        dataType:'json',
        url:'patient/get_new_id',
        success:function(data) {
			//$('#family_folder').val(data.family_folder);
			$('#family_folder').val(data.family_folder);
			$('#is_new').val('yes');
        }
    });
}
function fokus_patient_search_form() {
	$("#panel_main").hide();
    fokus('q');
}
function fokus_admdata_form() {
	$('#panel_main').show();
    fokus('family_folder');
}

function get_patient_from_patient_search(family_folder) {
    $.ajax({
        dataType:'json',
        url:'patient/get_data_patient/' + family_folder,
        success:function(data) {
            fill_form_from_patient(data);
            $('#patient_search_by_name').hide();
        }
    });
    $("#panel_patient_search").fadeOut("fast", fokus_admdata_form);
}

function fill_form_from_patient(data) {
    if(data._empty_ == 'yes') {
        $('#is_new').val('yes');
        $('#family_folder').val(data.family_folder);
        $('#nik').val('');
        $('#name').val('');
        $('#birth_place').val('');
        $('#birth_date').val('');

        $('#age_year').val('');
        $('#age_month').val('');
        $('#age_day').val('');

        $('#address').val('');
        $('#no_kontak').val('');
        $('#job_id').val('');
        $('#visit_date').val(data.registration_date);
    
    } else {
        $('#is_new').val('no');
        $('#family_folder').val(data.family_folder);
        $('#nik').val(data.nik);
        $('#name').val(data.name);
        $('#sex').val(data.sex);
        $('#birth_place').val(data.birth_place);
        $('#birth_date').val(data.birth_date);
        $('#address').val(data.address);
        $('#no_kontak').val(data.no_kontak);
        $('#job_id').val(data.job_id);
        $('#marital_status_id').val(data.marital_status_id);
        $('#visit_date').val(data.registration_date);
		
		$.ajax({
			url: 'patient/hitung_usia/' + data.birth_date,
			dataType: 'json',
			success:function(data) {
				$('#age_year').val(data.year);
				$('#age_month').val(data.month);
				$('#age_day').val(data.day);
			}
		});
    }
}

function confirmDelete(xurl) {
    var m = confirm('Delete this data?');
    if(m) {
        $.ajax({
            url:xurl,
            success:function(e) {
                $('#frmPatient_Search').submit();
            }
        });
    }
    return;
}
</script>
<div class="ui-dialog" style="width:100%;margin-right:5px;height:auto;float:left;" id="panel_main">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar"><?php echo $title;?></div>
		<div class="ui-dialog-content" id="dialogContent">
            <div id="admdata_message" style="display:none"></div>
			<form method="POST" name="frmPendaftaran" id="frmPendaftaran" action="<?php echo site_url('admdata/patient/process_form');?>">
            <input type="hidden" name="is_new" id="is_new" value="yes" />
			<table cellpadding="0" cellspacing="0" border="0" class="tblInput" style="width:100%;">
				<tr>
					<td style="width:150px;font-size:18px;">Tanggal Daftar</td>
					<td><input type="text" class="date-pick" name="visit_date" id="visit_date" style="font-size:18px;" maxlength="10" value="<?=date('d/m/Y')?>" size="10" onkeyup="autoSlashTanggal(this, event)" onkeypress="focusNext('family_folder', 'visit_date', this, event)" /><i>dd/mm/yyyy</i></td>
					<td>
						<!-- <a href="javascript:void(0)"> -->
                            <div id="before" style="cursor:pointer;float:left"><img src="<?php echo base_url()?>webroot/media/images/arrow_left_blue.png" border="0" title="Nomor RM sebelumnya" alt="Nomor RM sebelumnya" /></div>
                            <div id="after" style="cursor:pointer;float:left;"><img src="<?php echo base_url()?>webroot/media/images/arrow_right_blue.png" border="0" title="Nomor RM sesudahnya" alt="Nomor RM sesudahnya" /></div>
							<div id="show_panel_patient_search" style="cursor:pointer;"><img src="<?php echo base_url()?>webroot/media/images/search_folder.png" border="0" title="Find (Ctrl+F)" alt="Find (Ctrl+F)" /></div>
						<!-- </a> -->
					</td>
				</tr>
				<tr>
					<td style="width:150px;font-size:18px;"><?php echo $this->lang->line('label_mr_number');?></td>
					<td>
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td>
                    <input type="text" name="family_folder" id="family_folder" value="" size="6" maxlength="6" onkeypress="focusNext('nik', 'family_folder', this, event)" style="text-align:right;font-size:18px;font-weight:bold" title="Family Folder" />
                            </td>
                            <td>&nbsp;</td>
							<td></td>
                        </tr>
                    </table>
                    </td>
				</tr>              
				<tr>
					<td colspan="2"><hr /></td>
				</tr>
				<tr>
					<td>NIK/No. RM Lama</td>
					<td><input type="text" name="nik" id="nik" value="" size="20" maxlength="16" onkeypress="focusNext('name', 'nik', this, event)" /></td>
				</tr>
                <tr>
					<td><?php echo $this->lang->line('label_name');?></td>
					<td>
                        <input type="text" name="name" id="name" value="" size="30" onkeypress="focusNext('birth_place', 'name', this, event)" />
                    </td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_place_date_of_birth');?></td>
					<td>
						<input type="text" name="birth_place" id="birth_place" value="" size="10" onkeypress="focusNext('birth_date', 'parent_name', this, event)" />,
						<input type="text" name="birth_date" id="birth_date" value="" size="10" maxlength="10" onkeyup="autoSlashTanggal(this, event)" onkeypress="focusNext('age_year', 'birth_place', this, event)" /><i>dd/mm/yyyy</i>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_age');?></td>
					<td><input type="text" class="age" name="age_year" id="age_year" value="" size="1" onkeypress="focusNext('age_month', 'birth_date', this, event)" />th 
					<input type="text" class="age" name="age_month" id="age_month" value="" size="1" onkeypress="focusNext('age_day', 'age_year', this, event)" />bl 
					<input type="text" class="age" name="age_day" id="age_day" value="" size="1" onkeypress="focusNext('sex', 'age_month', this, event)" />hr </td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_sex');?></td>
					<td>
						<select name="sex" id="sex" style="width:100px;" onkeypress="focusNext('address', 'sex', this, event)">
							<option value="Laki-laki">Laki-laki</option>
							<option value="Perempuan">Perempuan</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_address');?></td>
					<td><input type="text" name="address" id="address" value="" size="40" onkeypress="focusNext('no_kontak', 'address', this, event)" /></td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_no_kontak');?></td>
					<td>
						<input type="text" name="no_kontak" id="no_kontak" value="" size="30" onkeypress="focusNext('district_id', 'sex', this, event)" />
					</td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_job');?></td>
					<td>
						<select name="job_id" id="job_id" style="width:200px" onkeypress="focusNext('marital_status_id', 'education_id', this, event)">
							<option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
							<?php for($i=0;$i<sizeof($combo_job);$i++) :?>
							<option value="<?php echo $combo_job[$i]['id']?>"><?php echo $combo_job[$i]['name']?></option>
							<?php endfor;?>
						</select>
					</td>
				</tr>				
				<tr>
					<td><?php echo $this->lang->line('label_marriedstatus');?></td>
					<td>
						<select name="marital_status_id" id="marital_status_id" style="width:200px" onkeypress="focusNext('save', 'job_id', this, event)">
							<option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
							<?php for($i=0;$i<sizeof($combo_marriage);$i++) :?>
							<option value="<?php echo $combo_marriage[$i]['id']?>"><?php echo $combo_marriage[$i]['name']?></option>
							<?php endfor;?>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
                    <td>
                        <input type="submit" name="Save" id="save" value="Simpan" />

                        <input type="reset" name="Reset" id="reset" value="Reset" />
                    </td>
				</tr>
			</table>
			</form>
		</div>
        <div class="ui-dialog-buttonpane">
		<?php echo $this->lang->line('info_ctrl_f_find');?>
        </div>
	</div>
</div>
<div id="patient_search_by_name" style="display:none;z-index:2;position:absolute;background-color:#FFFFFF;border:solid 3px #28530b"></div>
<div id="panel_patient_search" class="ui-dialog" style="display:none;width:99%;height:auto;position:absolute;z-index:3;top:0;">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar">Pencarian Pasien
			<a class="ui-dialog-titlebar-close" href="javascript:void(0)" id="close_panel_patient_search"></a>
		</div>
		<div class="ui-dialog-content" style="min-height:490px;">
			<form method="POST" name="frmPatient_Search" id="frmPatient_Search" action="<?php echo site_url('admdata/patient_search');?>">
			<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
				<tr>
					<td style="width:150px"><?php echo $this->lang->line('label_keyword');?></td>
					<td><input type="text" name="q" id="q" value="" size="30" onkeypress="focusNext('patient_search_district_id', 'patient_search_village_id', this, event)" /></td>
				</tr>
				
				<tr>
					<td></td><td><div style="float:left;"><input type="submit" name="Patient_Search" id="submit_patient_search" value="Cari" /></div>
					<div id="divLoadingPatient_Search" class="divLoading" style="display:none">Loading...</div></td>
				</tr>
			</table>
			</form>
			<div id="divPatient_SearchResult"></div>
		</div>
        <div class="ui-dialog-buttonpane">
            <?php echo $this->lang->line('label_press_esc_to_close');?>
        </div>
	</div>
</div>
