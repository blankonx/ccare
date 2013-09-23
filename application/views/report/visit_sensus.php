<script language="javascript">

//get List Data

$(document).ready(function() {
    $('#link_add_anamnese_diagnose').click(function(e) {
        e.preventDefault();
        createNextAnamneseIcdInputForButton();
    });

    var yicdi=1;
    function createNextAnamneseIcdInputForButton() {
        var obj = $('#icd_name_' + yicdi);
        yicdi++;
        currAnamneseKey++;
        var lix = $('<li/>');
        var inputHidden = $('<input type="hidden"/>')
            .attr('name', 'icd_id[]')
            .attr('id', 'icd_id_' + yicdi);

        var inputCode = $('<input type="text"/>')
            .attr('name', 'icd_code[]')
            .attr('size', '5')
            .attr('readonly', 'readonly')
            .attr('class', 'readonly2')
            .attr('id', 'icd_code_' + yicdi);

        var inputText = $('<input type="text"/>')
            .attr('name', 'icd_name[]')
            .attr('id', 'icd_name_' + yicdi)
            .attr('size', '50');

        var imgx = $('<img/>').attr('src', '../webroot/media/images/close.png').bind('click', function() {
            $(this).parent().remove();
        });

        inputText.autocomplete("../visit/general_checkup/get_list_icd", {
            formatItem: function(data, i, max, term) {
                return data[2] + " " + data[0];
            }
        })
        .result(function(event, data, formatted) {
            inputHidden.val(data[1]);
            inputCode.val(data[2]);
        });
        
        lix.append(inputHidden)
        .append(inputCode)
        .append(inputText); 

        obj.after(imgx);
        $('#ol_list_diagnose').append(lix);
        inputText.focus();
    }

    var currAnamneseKey=0;
    var icdi=1;

    $("#icd_name_1").autocomplete("../visit/general_checkup/get_list_icd", {
        formatItem: function(data, i, max, term) {
            return data[2] + " " + data[0];
		}
	})
    .result(function(event, data, formatted) {
        $('#icd_id_1').val(data[1]);
        $('#icd_code_1').val(data[2]);
    });
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
</script>
<div class="ui-dialog" style="width:100%;margin-right:5px;height:auto;float:left;">
	<div class="ui-dialog-titlebar"><?php echo $title;?></div>
	<div class="ui-dialog-content" id="dialogContent">
		<form method="POST" name="frmReport" id="frmReport" action="<?php echo site_url('report/visit_sensus/process_form')?>">
		<table cellpadding="0" cellspacing="0" border="0" class="tblInput" style="width:100%">
			
			<tr>
				<td><?php echo $this->lang->line('label_payment_type');?></td>
				<td>
					<select name="payment_type_id" id="payment_type_id" style="width:200px">
						<option value="">--- <?php echo $this->lang->line('form_all');?> ---</option>
						<?php for($i=0;$i<sizeof($combo_payment_type);$i++) :?>
						<option value="<?php echo $combo_payment_type[$i]['id']?>"><?php echo $combo_payment_type[$i]['name']?></option>
						<?php endfor;?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Kelompok Umur</td>
				<td>
					<select name="kelompok_umur" id="kelompok_umur" style="width:200px">
						<option value="">--- <?php echo $this->lang->line('form_all');?> ---</option>
						<option value="0-7 hr">0-7 hr</option>
						<option value="8-28 hr">8-28 hr</option>
						<option value="1 bl-1 th">1 bl-1 th</option>
						<option value="1-4 th">1-4 th</option>
						<option value="5-9 th">5-9 th</option>
						<option value="10-14 th">10-14 th</option>
						<option value="15-19 th">15-19 th</option>
						<option value="20-44 th">20-44 th</option>
						<option value="45-54 th">45-54 th</option>
						<option value="55-59 th">55-59 th</option>
						<option value="60-69 th">60-69 th</option>
						<option value="<?php echo htmlentities('&ge;70'); ?>">&ge;70</option>
					</select>
				</td>
			</tr>
				<tr>
					<td><?php echo $this->lang->line('label_sex');?></td>
					<td>
						<select name="sex" id="sex" style="width:200px;">
                            <option value="">--- <?php echo $this->lang->line('form_all');?> ---</option>
							<option value="Laki-laki">Laki-laki</option>
							<option value="Perempuan">Perempuan</option>
						</select>
					</td>
				</tr>
			<tr>	
				<td style="width: 70px;"><?php echo $this->lang->line('label_unit')?></td>
				<td style="width: 300px;">
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
					$start['mktime'] = strtotime("-1 day");
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
				<td>ICD</td>
				<td colspan="3">
					<ol id="ol_list_diagnose">
						<li>
							<input type="text" name="icd_code[0]" id="icd_code_1" size="5" class="readonly2" readonly="readonly" />
							<input type="text" name="icd_name[0]" id="icd_name_1" size="50" onkeypress="focusNext('icd_name_1', 'icd_name_1', this, event)" value="" />
							<input type="hidden" name="icd_id[0]" id="icd_id_1" />
                        </li>
					</ol>
					<a href="javascript:void(0)" id="link_add_anamnese_diagnose">[Tambah Diagnosa]</a>
				</td>
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
