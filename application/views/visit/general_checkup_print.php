<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Lembar Registrasi</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url()?>webroot/media/css/print_full.css" media="print,screen">
	<style>
	table td, table th{
		font-size:11px;
	}
	</style>
</head>
<body>
<div id="all-container" style="width:10cm;">
<div id="header" style="height:1.8cm">
    <div style="text-align:center;width:10cm;font-weight:bold;font-size:10pt">
        <?php echo $profile['name'];?>
    </div>
    <div style="text-align:center;width:10cm;font-size:8pt;letter-spacing:1px;margin-top:5pt;">
        <?php echo $profile['address'] . ' Telp.' . $profile['phone'];?>
    </div>
</div>
<div style="font-size:9pt;border:solid 1px #000000;width:10cm;">
<table cellpadding="0" cellspacing="1" border="0" style="padding:1em;">
	<tr>
		<td style="width:2.5cm">Tanggal</td>
		<td style="width:6cm">: <?php echo tanggalIndo($patient['visit_date'], 'd-m-Y H:i:s');?></td>
	</tr>
	<tr>
		<td>Pemeriksa</td>
		<td>: <?php echo $patient['doctor'];?></td>
	</tr>
	<tr>
		<td>Pelayanan</td>
		<td>: <?php echo $patient['clinic'];?></td>
	</tr>
	<tr>
		<td>No. MR</td>
		<td>: <?php echo $patient['mr_number'];?></td>
	</tr>
	<tr>
		<td>Nama KK</td>
		<td>: <?php echo $patient['parent_name'];?></td>
	</tr>
	<tr>
		<td>Nama Pasien</td>
		<td>: <?php echo $patient['name'];?></td>
	</tr>
	<tr>
		<td>Usia</td>
		<td>: <?php echo getOneAge($patient['birth_date'], $patient['visit_date']);?></td>
	</tr>
	<tr>
		<td>Jenis Kelamin</td>
		<td>: <?php echo $patient['sex'];?></td>
	</tr>
	<!--
	<tr>
		<td>Kunjungan ke</td>
		<td>: <?php echo $patient['visit_count'];?></td>
	</tr>
	-->
	<tr>
		<td>Alamat</td>
		<td>: <?php echo $patient['address'];?></td>
	</tr>
	<tr>
		<td>Jenis Pasien</td>
		<td>: <?php echo $patient['payment_type'];?></td>
	</tr>
	<tr>
		<td>Tindak Lanjut</td>
		<td>: <?php echo $patient['continue'];?>
        </td>
	</tr>
    <?php if($patient['continue_id'] == '003') : ?>
	<tr>
		<td>Dirujuk ke </td>
		<td>: <?php echo $patient['continue_to'];?></td>
	</tr>
    <?php endif; ?>
</table>
<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="margin:5px auto;width:98%">
	<thead>
	<tr>
		<th>Kode</th>
		<th>Diagnosa</th>
		<th>B/L</th>
	</tr>
	</thead>
	<tbody>
	<?php $j=0; for($i=0;$i<sizeof($diagnoses);$i++) : ?>
	<tr>
		<td><?php echo $diagnoses[$i]['code'];?></td>
		<td><?php echo $diagnoses[$i]['name'];?></td>
		<td><?php echo $diagnoses[$i]['case'];?></td>
	</tr>
	<?php endfor;?>
	</tbody>
</table>
<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="margin:5px auto;width:98%">
	<thead>
	<tr>
		<th>Kode</th>
		<th>Obat</th>
		<th>Jumlah</th>
	</tr>
	</thead>
	<tbody>
	<?php $j=0; for($i=0;$i<sizeof($prescribes);$i++) : ?>
	<tr>
		<td><?php echo $prescribes[$i]['code'];?></td>
		<td><?php echo $prescribes[$i]['name'];?></td>
		<td><?php echo $prescribes[$i]['jumlah'];?></td>
	</tr>
	<?php endfor;?>
	<tr>
		<td colspan="3"><strong>Racikan : </strong></td>
	</tr>
	<?php $j=0; for($i=0;$i<sizeof($prescribes_mix);$i++) : 
	if($prescribes_mix[$i]['randomnumber'] != $prescribes_mix[$i-1]['randomnumber']) :
	?>
	<tr>
		<td colspan="3"><em><strong><?php echo $prescribes_mix[$i]['mix_name'];?></strong>&nbsp;&nbsp;(<?php echo $prescribes_mix[$i]['mix_qty'] . " " . $prescribes_mix[$i]['mix_unit'];?>)</em></td>
	</tr>
	<tr>
		<td><?php echo $prescribes_mix[$i]['code'];?></td>
		<td><?php echo $prescribes_mix[$i]['name'];?></td>
		<td><?php echo $prescribes_mix[$i]['jumlah'];?></td>
	</tr>
	<?php else:?>
	<tr>
		<td><?php echo $prescribes_mix[$i]['code'];?></td>
		<td><?php echo $prescribes_mix[$i]['name'];?></td>
		<td><?php echo $prescribes_mix[$i]['jumlah'];?></td>
	</tr>
	<?php endif;?>
	<?php endfor;?>
	</tbody>
</table>
<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="margin:5px auto;width:98%">
	<thead>
	<tr>
		<th>Kode</th>
		<th>Tindakan</th>
		<th>Biaya</th>
	</tr>
	</thead>
	<tbody>
	<?php $j=0; for($i=0;$i<sizeof($treatments);$i++) : ?>
	<tr>
		<td><?php echo $treatments[$i]['code'];?></td>
		<td><?php echo $treatments[$i]['name'];?></td>
		<td style="text-align:right"><?php echo uangIndo($treatments[$i]['price']);?></td>
	</tr>
	<?php $total +=$treatments[$i]['price']; endfor;?>
	<tr>
		<td colspan="2">Total</td>
		<td style="text-align:right"><?php echo uangIndo($total);?></td>
	</tr>
	</tbody>
</table>
<div style="float:right;width:4cm;text-align:center;">
Pemeriksa,<br/><br/><br/><br/>(<?php echo $patient['doctor']; ?>)<br/><br/>
</div>
<div style="clear:both"></div>
</div>
</div>
</body>
<script language="javascript">
window.print();
</script>
</html>
