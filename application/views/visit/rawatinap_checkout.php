<script language="javascript">
$(document).ready(function() {
    //make the tabs
    var $tabs = $('#tabs > ul').tabs({
        spinner:'', 
        remote:true, 
        hide:function() {
            //alert('hide');
        },
        show:function() {
            //alert('showed ; ');
        }
    });
});
</script>
<table cellpadding="0" cellspacing="0" border="0" class="tblNote" style="width:100%;">
	<tr>
		<td style="width:100px;"><?php echo $this->lang->line('label_mr_number');?></td>
		<td style="width:150px;color:#00A7D4"><div id="_mr_number_"><?php echo $data['mr_number']?></div></td>
		<td style="width:100px;"><?php echo $this->lang->line('label_age');?></td>
		<td style="width:400px;color:#00A7D4"><?php echo getOneAge($data['birth_date'])?></td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('label_name');?></td>
		<td style="color:#00A7D4"><b><div id="_patient_name_"><?php echo $data['name']?></div></b></td>
		<td><?php echo $this->lang->line('label_sex');?></td>
		<td style="color:#00A7D4"><?php echo $data['sex']?></td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('label_parent');?></td>
		<td style="color:#00A7D4"><?php echo $data['parent_name']?></td>
		<td><?php echo $this->lang->line('label_address');?></td>
		<td style="color:#00A7D4"><?php echo $data['address']?></td>
        <td style="text-align:right;font-weight:bold;">
            <?php echo $this->lang->line('label_hello');?> <span style="color:#00A7D4"><?php echo $this->session->userdata('name');?>
        </td>
	</tr>
	<tr>
		<td style="height:20px"></td>
	</tr>
	<tr>
		<td colspan="2">Tgl. Masuk Pelayanan</td>
		<td colspan="2" style="color:#00A7D4"><?php echo $data['inpatient_first_time']?></td>
	</tr>
	<tr>
		<td colspan="2">Tgl. Mulai Dirawat di Bangsal ini</td>
		<td colspan="2" style="color:#00A7D4"><b><?php echo $data['visit_date_formatted']?></b></td>
        <td style="text-align:right;">
			<!--<input type="checkbox" name="showHideLog" id="showHideLog" value="1" /><label for="showHideLog" id="showHideLogLabel">Show Hide Logs</label>-->
		</td>
	</tr>
</table>
<br />
<div id="tabs">
	<ul>
		<li class="ui-tabs-nav-item">
			<a title="checkout" id="button-1'" href="checkout/result/<?php echo $data['visit_inpatient_id'] . '/' . $data['visit_inpatient_clinic_id'];?>">Pemulangan Pasien</a>
		</li>
		<li class="ui-tabs-nav-item">
			<a title="pindah_ruang" id="button-2" href="pindah_ruang/result/<?php echo $data['visit_inpatient_id'] . '/' . $data['visit_inpatient_clinic_id'];?>">Pindah Ruang Perawatan</a>
		</li>
	</ul>
	<div id="checkout">
		<div class="divLoading"></div>
	</div>
	<div id="pindah_ruang">
		<div class="divLoading"></div>
	</div>
</div>
