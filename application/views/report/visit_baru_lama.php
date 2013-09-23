<script type="text/javascript" src="<?php echo base_url()?>webroot/media/js/FusionCharts.js"></script>
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
						$("#clinic_id").focus();
                    }
                });
            }
	});
	$.ajax({
		url: 'visit_baru_lama/get_region_by_village_id/' + <?php echo $profile['village_id']?>,
		dataType: 'json',
		success:function(data) {
			$('#district_id').val(data.district_id);
			$('#sub_district_id').html(data.sub_district);
			$('#village_id').html(data.village);
		}
	});
	$('.general_spesifik').change(function() {
		var val = $(this).val();
		if(val == 'spesifik') { $('.spesifik').removeAttr('disabled'); $('.general').attr('disabled', 'disabled'); $('#district_id').focus();}
		if(val == 'general') { $('.general').removeAttr('disabled'); $('.spesifik').attr('disabled', 'disabled'); }
	});
	$('#frmReport').submit();
    $("#clinic_id").focus();
});
function setDisable(obj) {
	if(obj.value == "year") {
		$('#day_start').attr('disabled', 'disabled');
		$('#day_end').attr('disabled', 'disabled');
		$('#month_start').attr('disabled', 'disabled');
		$('#month_end').attr('disabled', 'disabled');
	} else if (obj.value == "month") {
		$('#day_start').attr('disabled', 'disabled');
		$('#day_end').attr('disabled', 'disabled');
		$('#month_start').removeAttr('disabled');
		$('#month_end').removeAttr('disabled');
	} else {
		$('#day_start').removeAttr('disabled');
		$('#day_end').removeAttr('disabled');
		$('#month_start').removeAttr('disabled');
		$('#month_end').removeAttr('disabled');
	}
}

function get_sub_district(val) {
	$.get('visit_baru_lama/get_sub_district/' + val, function(data) {$('#sub_district_id').html(data);});
	$.get('visit_baru_lama/get_village/0', function(data) {$('#village_id').html(data);});
}

function get_village(val) {
	$.get('visit_baru_lama/get_village/' + val, function(data) {$('#village_id').html(data);});
}
</script>
<div class="ui-dialog" style="width:100%;margin-right:5px;height:auto;float:left;">
	<div class="ui-dialog-titlebar"><?php echo $title;?></div>
	<div class="ui-dialog-content" id="dialogContent">
		<form method="POST" name="frmReport" id="frmReport" action="<?php echo site_url('report/visit_baru_lama/process_form')?>">
		<table cellpadding="0" cellspacing="0" border="0" class="tblInput" style="width:100%">
			<tr>
				<td style="width: 70px;"><?php echo $this->lang->line('label_clinic')?></td>
				<td>
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
				<td rowspan="5">
				<fieldset class="used">
					<legend>Wilayah</legend>
					<table cellpadding="0" cellspacing="0" border="0" class="tblInput" style="width:100%">
						<tr>
							<td>	
								<label><input type="radio" name="general_spesifik" class="general_spesifik" value="general" checked="checked"/><span style="font-weight:bold">Umum</span></label>
							</td>
							<td colspan="2">
								<label><input type="radio" name="general_spesifik" class="general_spesifik" value="spesifik"/><span style="font-weight:bold">Spesifik</span></label>
							</td>
						</tr>
						<tr>
							<td style="padding-left:20px;">
							<div id="general_td">
								<label><input type="radio" name="region" value="all" class="general" checked="checked" />Semua Wilayah</label><br/>
								<label><input type="radio" name="region" value="in" class="general" />Dalam Wilayah</label><br/>
								<label><input type="radio" name="region" value="out" class="general" />Luar Wilayah</label><br/>
							</div>
							</td>
							<td style="padding-left:20px;">
								<select name="district_id" id="district_id" style="width:200px" disabled="disabled" class="spesifik" onchange="get_sub_district(this.value);" onkeypress="focusNext('sub_district_id', 'address', this, event)" >
								<option value="">--- <?php echo $this->lang->line('form_all');?> ---</option>
									<?php for($i=0;$i<sizeof($combo_district);$i++) :?>
									<?php if($combo_district[$i]['id'] == $profile['district_id']) $sel='selected'; else $sel='';?>
									<option value="<?php echo $combo_district[$i]['id']?>" <?php echo $sel;?>><?php echo $combo_district[$i]['name']?></option>
									<?php endfor;?>
								</select><br/>
								<select name="sub_district_id" id="sub_district_id" style="width:200px" disabled="disabled" class="spesifik" onchange="get_village(this.value);" onkeypress="focusNext('village_id', 'district_id', this, event)" >
									<option value="">--- <?php echo $this->lang->line('form_all');?> ---</option>
								</select><br/>
								<select name="village_id" id="village_id" style="width:200px" disabled="disabled" class="spesifik" onkeypress="focusNext('education_id', 'sub_district_id', this, event)" >
									<option value="">--- <?php echo $this->lang->line('form_all');?> ---</option>
								</select>
							</td>
						</tr>
					</table>
				</fieldset>
				</td>
				
				
			</tr>
			<tr>
				
				<td><?php echo $this->lang->line('label_type')?></td>
				<td>
					<label><input type="radio" name="type" value="MsLine" checked="checked" />Line</label>
					<label><input type="radio" name="type" value="MSColumn3D" />Bar</label>
				</td>
				
			</tr>
			<tr>
				<td><?php echo $this->lang->line('label_unit')?></td>
				<td>
					<select name="unit" id="unit" style="width: 90px;" onkeypress="focusNext('day_start', 'clinic_id', this, event)" onchange="setDisable(this, event)">
					<option value="day"><?php echo $this->lang->line('label_day')?></option>
					<option value="month"><?php echo $this->lang->line('label_month')?></option>
					<option value="year"><?php echo $this->lang->line('label_year')?></option>
					</select> 
				</td>
			</tr>
			<tr>
				
				<td><?php echo $this->lang->line('label_since')?></td>
				<td>
					<?php
					$start['mktime'] = strtotime("-7 day");
					$start['day'] = date("j", $start['mktime']);
					$start['month'] = date("n", $start['mktime']);
					$start['year'] = date("Y", $start['mktime']);
					
					$now['day'] = date("j");
					$now['month'] = date("n");
					$now['year'] = date("Y");
					$now['year_start'] = 1971;
					?>
					<select name="day_start" id="day_start" style="width: 50px;" onkeypress="focusNext( 'month_start', 'unit', this, event)">
					<?php for($i=1;$i<32;$i++) :
							if($i==$start['day']) $sel = "selected"; else $sel = "";	?>
						<option value="<?=$i?>" <?=$sel?> ><?=$i?></option>
					<?php endfor; ?>
					</select>
					
					<select name="month_start" id="month_start" style="width: 100px;" onkeypress="focusNext( 'year_start', 'day_start', this, event)">
						<?php for($i=1;$i<13;$i++) :
								//$bln = tambahNol($i, 2);
								if($i==$start['month']) $sel = "selected"; else $sel = ""; ?>
							<option value="<?=$i?>" <?=$sel?> ><?=bulanIndo($i, "F")?></option>
						<? endfor; ?>
					</select>
					<select name="year_start" id="year_start" style="width: 70px;" onkeypress="focusNext( 'day_end', 'month_start', this, event)" class="inputan">
						<? for($i=$now['year_start'];$i<=$now['year'];$i++) :
								if($i==$start['year']) $sel = "selected"; else $sel = "";	?>
							<option value="<?=$i?>" <?=$sel?> ><?=$i?></option>
						<? endfor; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td><?php echo $this->lang->line('label_until')?></td>
				<td>
					<select name="day_end" id="day_end" style="width: 50px;" onkeypress="focusNext( 'month_end', 'year_start', this, event)">
					<?php for($i=1;$i<32;$i++) :
							if($i==$now['day']) $sel = "selected"; else $sel = "";	?>
						<option value="<?=$i?>" <?=$sel?> ><?=$i?></option>
					<?php endfor; ?>
					</select>
					
					<select name="month_end" id="month_end" style="width: 100px;" onkeypress="focusNext( 'year_end', 'day_end', this, event)">
						<?php for($i=1;$i<13;$i++) :
								//$bln = tambahNol($i, 2);
								if($i==$now['month']) $sel = "selected"; else $sel = ""; ?>
							<option value="<?=$i?>" <?=$sel?> ><?=bulanIndo($i, "F")?></option>
						<? endfor; ?>
					</select>
					<select name="year_end" id="year_end" style="width: 70px;" onkeypress="focusNext( 'submit', 'month_end', this, event)" class="inputan">
						<? for($i=$now['year_start'];$i<=$now['year'];$i++) :
								if($i==$now['year']) $sel = "selected"; else $sel = "";	?>
							<option value="<?=$i?>" <?=$sel?> ><?=$i?></option>
						<? endfor; ?>
					</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><label><input type="checkbox" name="belum_dilayani" value="yes" checked="checked" />Termasuk Pasien yg belum dilayani</label></td>
			</tr>
			<tr>
				<td colspan="4" style="text-align:center">
				<input type="submit" name="Show" id="submit" value="<?php echo $this->lang->line('form_show');?>" />
				</td>
			</tr>
		</table>
		</form>
		<div id="list_data" style="margin-top:20px;background-color:#dcdcdc;"></div>
   </div>
</div>
