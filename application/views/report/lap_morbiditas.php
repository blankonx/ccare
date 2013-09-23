<script language="javascript">
//get List Data
$(document).ready(function() {
    <?php if($service_status != "") :?>
    alert('<?php echo $service_status;?>');
    <?php endif;?>
    var errContainer = $('#errMessage');
    $('#ping_button').click(function() {
        $('#ping_result').html('<img src="<?php echo base_url()?>/webroot/media/images/loading.gif" />');
        $.get('<?php echo site_url("report/lap_morbiditas/ping_server")?>', function(data) {
            $('#ping_result').html(data);
        });
    });
    $('#ping_button2').click(function() {
        $('#ping_result2').html('<img src="<?php echo base_url()?>/webroot/media/images/loading.gif" />');
        $.get('<?php echo site_url("report/lap_morbiditas/ping_server")?>', function(data) {
            $('#ping_result2').html(data);
        });
    });
    $("#day_start").focus();
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
		<form method="POST" name="frmReport" id="frmReport" action="<?php echo site_url('report/lap_morbiditas/process_form')?>">
		<table cellpadding="0" cellspacing="0" border="0" class="tblInput" style="width:100%">
			<tr>	
				<td style="width: 100px;"><?php echo $this->lang->line('label_unit')?></td>
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
                <td>Metode</td>
                <td>
                <label><input type="radio" name="metode" value="service" checked="checked"/>Web Service (Otomatis Laporan Terkirim ke Dinas)</label><br/>
                <div style="font-size:10px;margin-left:30px">
                Server yang digunakan : <b><?php echo $_profile['url_service_server']?></b><br/>
                    Silakan Test Koneksi dengan Server dengan klik tombol panah 
                    <img style="cursor:pointer" id="ping_button" src="<?php echo base_url()?>/webroot/media/images/keluar.png" alt="Test Koneksi Server"/>
                    Hasil : <span id="ping_result"></span>
                    <br/>
                </div>
                <label><input type="radio" name="metode" value="manual" id="manual"/>Manual (Laporan dikirim manual/email/flashdisk)</label>
                </td>
            </tr>
			<tr>
				<td colspan="4" style="text-align:center">
				<input type="submit" name="Show" id="submit" value="Proses" />
				</td>
			</tr>
		</table>
		</form>
		<div id="list_data" style="margin-top:20px;background-color:#dcdcdc;"></div>
   </div>
</div>

</div>
