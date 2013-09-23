<script language="JavaScript" type="text/javascript">

$(document).ready(function() {
//DEFINE THE SHORTCUT
	//opening search form
    $(document).bind('keydown', 'Ctrl+f', function(evt){
		//$("#panel_main").hide($('#visit_date').focus());
        $("#panel_search").slideDown("fast", fokus_search_form);return false;
    });
    $('#before').click(function(){
        var patient_id = parseInt(removeExtraZero($('#patient_id').val()))-1;
        if(patient_id == 0) return;
		$.ajax({
			url: '../admission/sks/get_data_patient/' + patient_id,
			dataType: 'json',
			success:function(data) {
				fill_form_from_patient(data);
			}
		});
        $('#patient_id').val(addExtraZero(patient_id, 6));
    });
    $('#after').click(function(){
        //alert(parseInt($('#patient_id').val()));
        var patient_id = parseInt(removeExtraZero($('#patient_id').val()))+1;
        //alert(patient_id);
		$.ajax({
			url: '../admission/sks/get_data_patient/' + patient_id,
			dataType: 'json',
			success:function(data) {
				fill_form_from_patient(data);
			}
		});
        $('#patient_id').val(addExtraZero(patient_id, 6));
    });
	
    $('#show_panel_search').click(function(){
		//$("#panel_main").hide($('#visit_date').focus());
        $("#panel_search").slideDown("fast", fokus_search_form);return false;
    });

	$('#birth_date').change(function() {
		$.ajax({
			url: 'sks/hitung_usia/' + $(this).val(),
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
		$.get('sks/get_tgl_lahir/' + age_year + '/' + age_month + '/' + age_day, function(data) {
			$('#birth_date').val(data);
		});
	});
	//closing search form
    $(document).bind('keydown', 'esc', function(evt){
        $("#panel_search").slideUp("slow", fokus_admission_form);return false;
    });
    $('#close_panel_search').click(function(){
        $("#panel_search").slideUp("slow", fokus_admission_form);return false;
    });
	$('#reset').click(function(){validator.resetForm();$('#family_folder').focus();reset_form()});
//alphanumericed input :
	$("#visit_date").numeric();

	$("#patient_id").numeric();
	$("#family_relationship_id").numeric();

	$("#birth_date").numeric();
	$("#age_year").numeric();
	$("#age_month").numeric();
	$("#age_day").numeric();
	$("#pay").decimal();

//ajaxing search form
    $('#frmSearch').submit(function() {
		$('#divLoadingSearch').ajaxStart(function(){$(this).show();});
		$('#divLoadingSearch').ajaxStop(function(){$(this).hide();});

        $('#frmSearch').ajaxSubmit({
		    type: 'POST',
            target: '#divSearchResult',
			success:function() {
				$("#q").focus();
				preparePagingLink();
			}
        });
        return false;
    });

	function preparePagingLink() {
		$('.pagingLinks a').click(function() {
				$('#divLoadingSearch').ajaxStart(function(){$(this).show();});
				$('#divLoadingSearch').ajaxStop(function(){$(this).hide();});
				$('#divSearchResult').load(this.href,preparePagingLink);return false;
			}
		);
	}
//validating the input
	//adding the dependencies of insurance number & payment type
	$.validator.addMethod("insuranceIsRequired", function(value, element) {
		var val = $('#payment_type_id').val();
		if(val == '2' || val == '5' || val == '6' || val == '7' || val == '8' || val == '10') {
			if(value && value!='undefined' && $.trim(value) != '') return true;
			return false;
		} else {
			return true;
		}
	}, "Isikan nomor asuransi");
	//adding the dependencies of free or pay
	$.validator.addMethod("freeOrPay", function(value, element) {
		var val = $('input:radio[@name=fee]:checked').val();
		if(val == 'pay' && (value == 'undefined' || $.trim(value) == '')) {
			return false;
		}
		return true;
	}, "Isikan jumlah yg dibayarkan");
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

    $('#family_folder').bind('change', function() {
        var no=$(this).val();
        $.ajax({
            dataType:'json',
            url:'sks/get_data_parent/' + no,
            success:function(data) {
                $('#family_folder').val(data.family_folder);
                $('#family_relationship_id').val('');
                $('#family_relationship_code').val('');
                $('#name').val('');
                $('#last_name').val('');
                $('#parent_name').val(data.name);

                $('#age_year').val('');
                $('#age_month').val('');
                $('#age_day').val('');

                $('#address').val('');
                $('#education_id').val('');
                $('#job_id').val('');		
				$.ajax({
					url: 'sks/get_region_by_village_id/' + data.village_id,
					dataType: 'json',
					success:function(data) {
						$('#district_id').val(data.district_id);
						$('#sub_district_id').html(data.sub_district);
						$('#village_id').html(data.village);
					}
				});
            }
        });
    });
    $('#patient_id').bind('change', function() {
        var no=$(this).val();
        //alert('xxx');
        $.ajax({
            dataType:'json',
            url:'sks/get_data_patient/' + no,
            success:function(data) {
                fill_form_from_patient(data);
            }
        });
    });

	var validator = $("#frmPendaftaran").validate({
		rules: {
			visit_date: {
                required:true,
                date:true
            },
            patient_id: {
                required:true,
                number:true,
                min:1
            },
            family_relationship_id: {
                required:true,
                number:true,
                min:1
            },
            name: "required",
            parent_name: "required",
            birth_place: "required",
            birth_date: {
                required:true,
                date:true
            },
            address: "required",
            district_id: "required",
            sub_district_id: "required",
            village_id: "required",
            education_id: "required",
            marital_status_id: "required",
            job_id: "required",
            clinic_id: "required",
            payment_type_id: "required",
			insurance_no:{
				insuranceIsRequired:true
			},
            mc_explanation_other:{
                mcUsage:true
            },
			pay:{
				freeOrPay:true
			}
		},
        submitHandler:
            function(form) {
                $(form).ajaxSubmit({
					beforeSubmit:disableForm,
					dataType: 'json',
                    success:function(data) {
                        show_message('#admission_message', data.msg, data.status);
                        openPrintPopup('../visit/medical_certificate/prints/' + data.last_id);
						enableForm();
						if(data.status == 'success') $("#reset").click();
                    }
                });
            }
	});

	$('#reset').click();
    //$('#visit_date').focus();

    $('#name').keypress(function(e) {
        val = $(this).val();
        if(val.length > 2) {
            setTimeout(
                function() {
                    val = $('#name').val();
                    var offx = $('#name').offset();
                    $('#search_by_name').show();
                    var xtop = offx.top-20;
                    var xleft = offx.left+100;
                    $('#search_by_name').css('margin-top', xtop).css('margin-left', xleft);
                    $.ajax({
                        url: '<?php echo site_url("admission/search/search_by_name")?>/' + val,
                        success: function(data) {
                            $('#search_by_name').html(data);
                        }
                    });
                }, 
            700);
        }
    }).blur(function(e) {
        setTimeout(function() {$('#search_by_name').html('').hide()}, 700);
    });
    $('#parent_name').keypress(function(e) { 
        $('#search_by_name').hide();
    });
    $('#mc_explanation_other').focus(function() {
        if($(this).val() == 'Other...') $(this).val('');
        $(this).prev().attr('checked','checked');
    })
    .blur(function() {
        if($(this).val() == '') $(this).val('Other...');
    });
});

function reset_form() {
    $.ajax({
        dataType:'json',
        url:'sks/get_new_id',
        success:function(data) {
			$('#patient_id').val(data.patient_id);
			$('#family_folder').val(data.family_folder);
        }
    });
	$.ajax({
		url: 'sks/get_region_by_village_id/' + <?php echo $profile['village_id']?>,
		dataType: 'json',
		success:function(data) {
			$('#district_id').val(data.district_id);
			$('#sub_district_id').html(data.sub_district);
			$('#village_id').html(data.village);
		}
	});
}
function fokus_search_form() {
	$("#panel_main").hide();
    fokus('q');
}
function fokus_admission_form() {
	$('#panel_main').show();
    fokus('family_folder');
}

function get_patient_from_search(id, family_code) {
    $.ajax({
        dataType:'json',
        url:'sks/get_data_patient/' + id,
        success:function(data) {
            fill_form_from_patient(data);
        }
    });
    $("#panel_search").fadeOut("fast", fokus_admission_form);
}

function use_as_parent(id) {
    $.ajax({
        dataType:'json',
        url:'sks/get_data_parent/' + id,
        success:function(data) {
            $('#family_folder').val(data.family_folder);
            $('#family_relationship_id').val('');
            $('#family_relationship_code').val('');
            $('#name').val('');
            $('#last_name').val('');
            $('#parent_name').val(data.name);

            $('#age_year').val('');
            $('#age_month').val('');
            $('#age_day').val('');

            $('#address').val('');
            $('#education_id').val('');
            $('#job_id').val('');
			$.ajax({
				url: 'sks/get_region_by_village_id/' + data.village_id,
				dataType: 'json',
				success:function(data) {
					$('#district_id').val(data.district_id);
					$('#sub_district_id').html(data.sub_district);
					$('#village_id').html(data.village);
				}
			});
        }
    });
    $("#panel_search").fadeOut("fast",  function() {$('#family_folder').focus()});
}

function fill_form_from_patient(data) {
    if(data._empty_ == 'yes') {
        $('#is_new').val('yes');
        //$('#patient_id').val(data.id);
        $('#family_folder').val(data.family_folder);
        $('#family_relationship_id').val(data.family_relationship_id);
        $('#family_relationship_code').val(data.family_relationship_id);
        $('#nik').val('');
        $('#name').val('');
        $('#last_name').val('');
        $('#parent_name').val('');
        $('#birth_place').val('');
        $('#birth_date').val('');

        $('#age_year').val('');
        $('#age_month').val('');
        $('#age_day').val('');

        $('#address').val('');
        $('#education_id').val('');
        $('#job_id').val('');
        $('#payment_type_id').val('');
        $('#insurance_no').val('');
    
    } else {
        $('#is_new').val('no');
        $('#patient_id').val(data.id);
        $('#family_folder').val(data.family_folder);
        $('#family_relationship_id').val(data.family_relationship_id);
        $('#family_relationship_code').val(data.family_relationship_id);
        $('#nik').val(data.nik);
        $('#name').val(data.name);
        $('#last_name').val(data.last_name);
        $('#parent_name').val(data.parent_name);
        $('#sex').val(data.sex);
        $('#birth_place').val(data.birth_place);
        $('#birth_date').val(data.birth_date);
        $('#address').val(data.address);
        $('#education_id').val(data.education_id);
        $('#job_id').val(data.job_id);
        $('#payment_type_id').val(data.payment_type_id);
        //alert(data.education_id);
        //alert(data.job_id);
        $('#marital_status_id').val(data.marital_status_id);
        enableDisableInsuranceFromVal(data.payment_type_id);
        $('#insurance_no').val(data.insurance_no);
		
		$.ajax({
			url: 'sks/hitung_usia/' + data.birth_date,
			dataType: 'json',
			success:function(data) {
				$('#age_year').val(data.year);
				$('#age_month').val(data.month);
				$('#age_day').val(data.day);
			}
		});
		$.ajax({
			url: 'sks/get_region_by_village_id/' + data.village_id,
			dataType: 'json',
			success:function(data) {
				$('#district_id').val(data.district_id);
				$('#sub_district_id').html(data.sub_district);
				$('#village_id').html(data.village);
			}
		});
    }
}
function get_sub_district(val) {
	if(val == 'add') {
		var dCode = prompt('Kode Kabupaten', '-');
		var dName = prompt('Nama Kabupaten');
		//var dId = $("#district_id").val();
		if(dName && dName != "undefined") {
			$.get('sks/add_district/' + dCode + '/' + dName, function (data) {
				$('#district_id').append('<option value="'+data+'" selected="selected">' + dName + '</option>');
				$.get('sks/get_sub_district/' + val, function(data) {$('#sub_district_id').html(data);});
				$.get('sks/get_village/0', function(data) {$('#village_id').html(data);});
			});
		} else {
			$('#district_id').val('');
		}
	} else {
		$.get('sks/get_sub_district/' + val, function(data) {$('#sub_district_id').html(data);});
		$.get('sks/get_village/0', function(data) {$('#village_id').html(data);});
	}
}

function get_village(val) {
		if(val == 'add') {
			var dCode = prompt('Kode Kecamatan', '-');
			var dName = prompt('Nama Kecamatan');
			var dId = $('#district_id').val();
			if(dName && dName != "undefined") {
				$.get('sks/add_sub_district/' + dId + '/' + dCode + '/' + dName, function (data) {
					$('#sub_district_id').append('<option value="'+data+'" selected="selected">'+dName+'</option>');
					$.get('sks/get_village/0', function(data) {$('#village_id').html(data);});
				});
			} else {
				$('#sub_district_id').val('');
			}
		} else {
			$.get('sks/get_village/' + val, function(data) {$('#village_id').html(data);});
		}
}
function add_village(val) {
	if(val == 'add') {
		var dCode = prompt('Kode Kelurahan', '-');
		var dName = prompt('Nama Kelurahan');
		var dId = $('#sub_district_id').val();
		if(dName && dName != "undefined") {
			$.get('sks/add_village/' + dId + '/' + dCode + '/' + dName, function (data) {
				$('#village_id').append('<option value="'+data+'" selected="selected">'+dName+'</option>');
			});
		} else {
			$('#village_id').val('');
		}
	}
}

function get_sub_district_for_search(val) {
	$.get('sks/get_sub_district/' + val, function(data) {$('#search_sub_district_id').html(data);});
	$.get('sks/get_village/0', function(data) {$('#search_village_id').html(data);});
}
function get_village_for_search(val) {
	$.get('sks/get_village/' + val, function(data) {$('#search_village_id').html(data);});
}
function enableDisableInsurance(obj) {
	var val = obj.value;
	if(val == '001') {
		$('#insurance_no').attr('readonly', true);
		$('#insurance_no').removeClass().addClass('readonly');
		$('#insurance_no').val('');
	} else {
		$('#insurance_no').attr('readonly', false);
		$('#insurance_no').removeClass();
	}
}
function enableDisableInsuranceFromVal(val) {
	if(val == '001') {
		$('#insurance_no').attr('readonly', true);
		$('#insurance_no').removeClass().addClass('readonly');
		$('#insurance_no').val('');
	} else {
		$('#insurance_no').attr('readonly', false);
		$('#insurance_no').removeClass();
	}
}

function enableDisableFee(obj) {
	if(obj.checked == true) {
		var val = obj.value;
		if(val == 'pay' || val == 'undefined') {
			$('#pay').attr('readonly', false);
			$('#pay').removeClass();
		} else {
			$('#pay').attr('readonly', true);
			$('#pay').removeClass().addClass('readonly');
			$('#pay').val('');
		}
	}
}

function fillFamilyRelationshipId() {
	$('#family_relationship_id').val($('#family_relationship_code').val());
	$.ajax({
		dataType:'json',
		url:'sks/get_data_patient/' + $('#patient_id').val(),
		success:function(data) {
			fill_form_from_patient(data);
		}
	});
}

</script>
<div class="ui-dialog" style="width:100%;margin-right:5px;height:auto;float:left;" id="panel_main">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar"><?php echo $title;?></div>
		<div class="ui-dialog-content" id="dialogContent">
            <div id="admission_message" style="display:none"></div>
			<form method="POST" name="frmPendaftaran" id="frmPendaftaran" action="<?php echo site_url('admission/sks/process_form');?>">
            <input type="hidden" name="is_new" id="is_new" value="yes" />
			<table cellpadding="0" cellspacing="0" border="0" class="tblInput" style="width:100%;">
				<tr>
					<td style="width:150px;font-size:18px;"><?php echo $this->lang->line('label_date');?></td>
					<td><input type="text" class="date-pick" name="visit_date" id="visit_date" style="font-size:18px;" maxlength="10" value="<?=date('d/m/Y')?>" size="10" onkeyup="autoSlashTanggal(this, event)" onkeypress="focusNext('family_folder', 'visit_date', this, event)" /><i>dd/mm/yyyy</i></td>
					<td>
						<!-- <a href="javascript:void(0)"> -->
                            <div id="before" style="cursor:pointer;float:left"><img src="<?php echo base_url()?>webroot/media/images/arrow_left_blue.png" border="0" title="Nomor RM sebelumnya" alt="Nomor RM sebelumnya" /></div>
                            <div id="after" style="cursor:pointer;float:left;"><img src="<?php echo base_url()?>webroot/media/images/arrow_right_blue.png" border="0" title="Nomor RM sesudahnya" alt="Nomor RM sesudahnya" /></div>
							<div id="show_panel_search" style="cursor:pointer;"><img src="<?php echo base_url()?>webroot/media/images/search_folder.png" border="0" title="Find (Ctrl+F)" alt="Find (Ctrl+F)" /></div>
						<!-- </a> -->
					</td>
				</tr>
				<tr>
					<td style="font-size:18px;"><?php echo $this->lang->line('label_mr_number');?></td>
					<td>
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td>
                    <input type="text" name="family_folder" id="family_folder" value="" size="7" maxlength="7" onkeypress="focusNext('patient_id', 'visit_date', this, event)" style="text-align:right;font-size:18px;font-weight:bold" title="Family Folder" />/
                            </td>
                            <td>
                    <input type="text" name="patient_id" id="patient_id" value="" size="8" maxlength="8" onkeypress="focusNext('family_relationship_code', 'family_folder', this, event)" style="text-align:right;font-size:18px;font-weight:bold" title="Patient ID" onchange="fillFamilyRelationshipId();" />/
                            </td>
                            <td>
                    <input type="text" name="family_relationship_id" id="family_relationship_id" value="" size="2" maxlength="2" onkeypress="focusNext('family_relationship_code', 'patient_id', this, event);" title="Family Relationships Code" style="text-align:right;font-size:18px;font-weight:bold" readonly="readonly" class="readonly2" />
                    <!--<input type="text" name="family_relationship_id" id="family_relationship_id" value="" size="2" maxlength="2" onkeypress="focusNext('name', 'patient_id', this, event);" title="Family Relationships Code" style="text-align:right;font-size:18px;font-weight:bold" />-->
                            </td>
                        </tr>
                        <tr>
							<td><span style="font-size:10px;font-style:italic">Family Folder</span></td>
							<td><span style="font-size:10px;font-style:italic">ID Pasien</span></td>
							<td><span style="font-size:10px;font-style:italic">Kode Hubungan Keluarga</span></td>
                        </tr>
                    </table>
                    </td>
					<td></td>
				</tr>
                
				<tr>
					<td><?php echo $this->lang->line('label_family_relationship');?></td>
					<td>
						<select name="family_relationship_code" id="family_relationship_code" style="width:200px" onkeypress="focusNext('nik', 'patient_id', this, event)" onchange="fillFamilyRelationshipId();">
							<option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
							<?php for($i=0;$i<sizeof($combo_relationship);$i++) :?>
							<option value="<?php echo $combo_relationship[$i]['id']?>"><?php echo $combo_relationship[$i]['name']?></option>
							<?php endfor;?>
						</select>
					</td>
				</tr>
                
				<tr>
					<td colspan="2"><hr /></td>
				</tr>
				<tr>
					<td>NIK/No. KTP</td>
					<td><input type="text" name="nik" id="nik" value="" size="20" maxlength="16" onkeypress="focusNext('name', 'family_relationship_code', this, event)" /></td>
				</tr>
                <?php if($this->config->item('use_last_name') == true) :?>
				<tr>
					<td><?php echo $this->lang->line('label_first_name');?></td>
					<td>
                        <input type="text" name="name" id="name" value="" size="30" onkeypress="focusNext('last_name', 'family_relationship_id', this, event)" />
                        &nbsp;<?php echo $this->lang->line('label_last_name');?>
                        <input type="text" name="last_name" id="last_name" value="" size="30" onkeypress="focusNext('parent_name', 'name', this, event)" />
                    </td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_parent');?></td>
					<td><input type="text" name="parent_name" id="parent_name" value="" size="30" onkeypress="focusNext('birth_place', 'last_name', this, event)" /></td>
				</tr>
                <?php else:?>
				<tr>
					<td><?php echo $this->lang->line('label_name');?></td>
					<td>
                        <input type="text" name="name" id="name" value="" size="30" onkeypress="focusNext('parent_name', 'nik', this, event)" />
                    </td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_parent');?></td>
					<td><input type="text" name="parent_name" id="parent_name" value="" size="30" onkeypress="focusNext('birth_place', 'name', this, event)" /></td>
				</tr>
                <?php endif;?>
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
						<select name="sex" id="sex" style="width:100px;" onkeypress="focusNext('address', 'age_day', this, event)">
							<option value="Laki-laki">Laki-laki</option>
							<option value="Perempuan">Perempuan</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_address');?></td>
					<td><input type="text" name="address" id="address" value="" size="40" onkeypress="focusNext('district_id', 'sex', this, event)" /></td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_district');?></td>
					<td>
						<select name="district_id" id="district_id" style="width:200px" onchange="get_sub_district(this.value);" onkeypress="focusNext('sub_district_id', 'address', this, event)" >
						<option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
							<?php for($i=0;$i<sizeof($combo_district);$i++) :?>
							<?php if($combo_district[$i]['id'] == $profile['district_id']) $sel='selected'; else $sel='';?>
							<option value="<?php echo $combo_district[$i]['id']?>" <?php echo $sel;?>><?php echo $combo_district[$i]['name']?></option>
							<?php endfor;?>
							<option value="add">--- <?php echo $this->lang->line('form_add_district');?> ---</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_sub_district');?></td>
					<td>
						<select name="sub_district_id" id="sub_district_id" style="width:200px" onchange="get_village(this.value);" onkeypress="focusNext('village_id', 'district_id', this, event)" >
							<option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
							<option value="add">--- <?php echo $this->lang->line('form_add_sub_district');?> ---</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_village');?></td>
					<td>
						<select name="village_id" id="village_id" style="width:200px" onchange="add_village(this.value)" onkeypress="focusNext('education_id', 'sub_district_id', this, event)" >
                            <option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
							<option value="add">--- <?php echo $this->lang->line('form_add_village');?> ---</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_education');?></td>
					<td>
						<select name="education_id" id="education_id" style="width:200px" onkeypress="focusNext('job_id', 'village_id', this, event)">
							<option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
							<?php for($i=0;$i<sizeof($combo_education);$i++) :?>
							<option value="<?php echo $combo_education[$i]['id']?>"><?php echo $combo_education[$i]['name']?></option>
							<?php endfor;?>
						</select>
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
						<select name="marital_status_id" id="marital_status_id" style="width:200px" onkeypress="focusNext('admission_type_id', 'job_id', this, event)">
							<option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
							<?php for($i=0;$i<sizeof($combo_marriage);$i++) :?>
							<option value="<?php echo $combo_marriage[$i]['id']?>"><?php echo $combo_marriage[$i]['name']?></option>
							<?php endfor;?>
						</select>
					</td>
				</tr>												

				<tr>
					<td colspan="2"><hr /></td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_admission_type');?></td>
					<td>
						<select name="admission_type_id" id="admission_type_id" style="width:200px" onkeypress="focusNext('clinic_id', 'marital_status_id', this, event)">
							<option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
							<?php for($i=0;$i<sizeof($combo_admission_type);$i++) :
							if($combo_admission_type[$i]['id'] == 5) $sel = 'selected="selected"'; else $sel='';
							?>
							<option value="<?php echo $combo_admission_type[$i]['id']?>" <?php echo $sel;?>><?php echo $combo_admission_type[$i]['name']?></option>
							<?php endfor;?>
						</select>
						
					</td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_payment_type');?></td>
					<td>
						<select name="payment_type_id" id="payment_type_id" style="width:200px" onchange="enableDisableInsurance(this)" onkeypress="focusNext('insurance_no', 'clinic_id', this, event)">
							<option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
							<?php for($i=0;$i<sizeof($combo_payment_type);$i++) :?>
							<option value="<?php echo $combo_payment_type[$i]['id']?>"><?php echo $combo_payment_type[$i]['name']?></option>
							<?php endfor;?>
						</select>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_insurance_no');?></td>
					<td><input type="text" name="insurance_no" id="insurance_no" value="" size="30" onkeypress="focusNext('fee_is_free', 'payment_type_id', this, event)" /></td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_cost');?></td>
					<td>
					<input type="radio" name="fee" id="fee_is_free" value="free" onkeypress="focusNext('pay', 'insurance_no', this, event);enableDisableFee(this)" onclick="enableDisableFee(this)" /><label for="fee_is_free"><?php echo $this->lang->line('label_free');?></label>
					<input type="radio" name="fee" id="fee_is_pay" value="pay" onkeypress="focusNext('pay', 'insurance_no', this, event);enableDisableFee(this)" onclick="enableDisableFee(this)" /><label for="fee_is_pay"><?php echo $this->lang->line('label_pay');?></label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					Rp.<input type="text" name="pay" id="pay" value="" maxlength="8" size="20" style="text-align:right" /></td>
				</tr>											

				<tr>
					<td colspan="2"><hr /></td>
				</tr>
        <tr>
            <td>Nomor</td>
            <td>
				<input type="text" name="mc_no" id="mc_no" class="required numeric" size="4" onkeypress="focusNext('mc_name', 'mc_name', this, event)" />
				<input type="text" readonly="readonly" class="readonly2" name="mc_no_hidden" id="mc_no_hidden" value="/<?php echo $mc_no;?>" />
            </td>
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
<div id="search_by_name" style="display:none;z-index:2;position:absolute;background-color:#FFFFFF;border:solid 3px #28530b"></div>
<div id="panel_search" class="ui-dialog" style="display:none;width:99%;height:auto;position:absolute;z-index:3;top:0;">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar">Pencarian Pasien
			<a class="ui-dialog-titlebar-close" href="javascript:void(0)" id="close_panel_search"></a>
		</div>
		<div class="ui-dialog-content" style="min-height:490px;">
			<form method="POST" name="frmSearch" id="frmSearch" action="<?php echo site_url('admission/search');?>">
			<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
				<tr>
					<td style="width:150px"><?php echo $this->lang->line('label_keyword');?></td>
					<td><input type="text" name="q" id="q" value="" size="30" onkeypress="focusNext('search_district_id', 'search_village_id', this, event)" /></td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_district');?></td>
					<td>
						<select name="search_district_id" id="search_district_id" style="width:200px" onchange="get_sub_district_for_search(this.value)" onkeypress="focusNext('search_sub_district_id', 'q', this, event)" >
                            <option value="">--- <?php echo $this->lang->line('form_all');?> ---</option>
							<?php for($i=0;$i<sizeof($combo_district);$i++) :?>
							<?php if($combo_district[$i]['id'] == $this->config->item('district_id')) $sel='selected'; else $sel='';?>
							<option value="<?php echo $combo_district[$i]['id']?>" <?php echo $sel;?>><?php echo $combo_district[$i]['name']?></option>
							<?php endfor;?>
						</select>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_sub_district');?></td>
					<td>
						<select name="search_sub_district_id" id="search_sub_district_id" style="width:200px" onchange="get_village_for_search(this.value);" onkeypress="focusNext('search_village_id', 'search_district_id', this, event)" >
                            <option value="">--- <?php echo $this->lang->line('form_all');?> ---</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_village');?></td>
					<td>
						<select name="search_village_id" id="search_village_id" style="width:200px" onkeypress="focusNext('submit_search', 'search_sub_district_id', this, event)" >
                            <option value="">--- <?php echo $this->lang->line('form_all');?> ---</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td><td><div style="float:left;"><input type="submit" name="Search" id="submit_search" value="Cari" /></div>
					<div id="divLoadingSearch" class="divLoading" style="display:none">Loading...</div></td>
				</tr>
			</table>
			</form>
			<div id="divSearchResult"></div>
		</div>
        <div class="ui-dialog-buttonpane">
            <?php echo $this->lang->line('label_press_esc_to_close');?>
        </div>
	</div>
</div>
