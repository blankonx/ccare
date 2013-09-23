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
		<td style="width:100px;">Pelayanan Asal</td>
		<td style="width:300px;color:#00A7D4"><?php echo $data['clinic'];?></td>
		<td style="" rowspan="5"></td>
        <td style="text-align:right;"></td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('label_name');?></td>
		<td style="color:#00A7D4"><b><div id="_patient_name_"><?php echo $data['name']?></div></b></td>
		<td>Dokter</td>
		<td style="color:#00A7D4"><?php echo $data['doctor']?></td>
	</tr>
	<tr>
		<td style="width:80px;"><?php echo $this->lang->line('label_age');?></td>
		<td style="width:300px;color:#00A7D4"><?php echo getOneAge($data['birth_date'], $data['visit_date'])?></td>
		<td>Tgl. Kunjungan</td>
		<td style="color:#00A7D4"><?php echo $data['visit_date_formatted']?></td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('label_sex');?></td>
		<td style="color:#00A7D4"><?php echo $data['sex']?></td>
		<td>Jenis Pasien</td>
		<td style="color:#00A7D4"><?php echo $data['payment_type']?></td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('label_address');?></td>
		<td style="color:#00A7D4" colspan="3"><?php echo $data['address']?></td>
	</tr>
</table>
<br />
<div id="tabs">
	<ul>
		<li class="ui-tabs-nav-item">
			<a title="tab_prescribes" id="button-1'" href="<?php echo site_url('kasir/general_checkup/result/'.$data['visit_id']);?>">Tagihan</a>
		</li>
	</ul>
	<div id="tab_prescribes">
		<div class="divLoading"></div>
	</div>
</div>
