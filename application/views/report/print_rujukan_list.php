<h3 class="report_title"><?php echo $report_title;?></h3>

<h4 class="report_sub_title"><?php echo $report_sub_title;?></h3>
<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="width:1000px;margin:10px auto">
    <thead>
      <tr>
        <th style="width:30px;">No</th>
		<th>Kode Primary Care</th>
		<th>Nama Dokter</th>
		<th>Tujuan Rujukan</th>
		<th>NIK</th>
		<th>Nama</th>
		<th>Tgl. Lahir</th>
		<th>Tahun</th>
		<th>Bulan</th>
		<th>Hari</th>
		<th>Sex</th>
		<th>Tgl Kunjungan</th>
        <th>Kode Status</th>
		<th>ICD</th>
		<th>Treatment</th>
		</tr>
		</thead>
		<tbody>
		<?php for($i=0;$i<sizeof($list);$i++) :?>
		<? $thn = getAge($list[$i]['birth_date'], $list[$i]['visit_date']);?>
		<tr>
        <td><?php echo ($i+1);?></td>
		<td><?php echo $list[$i]['kode_klinik'];?></td>
		<td><?php echo $list[$i]['paramedic'];?></td>
		<td><?php echo $list[$i]['continue_to'] . "|" . $list[$i]['specialis'];?></td>
        <td><?php echo $list[$i]['nik'];?></td>
        <td><?php echo $list[$i]['name'];?></td>
        <td><?php echo $list[$i]['birth_date'];?></td>
		<td style="text-align:right;"><?php echo $thn['year'];?></td>
		<td style="text-align:right;"><?php echo $thn['month'];?></td>
		<td style="text-align:right;"><?php echo $thn['day'];?></td>
        <td><?php echo $list[$i]['sex'];?></td>
        <td><?php echo $list[$i]['visit_date'];?></td>
        <td><?php echo $list[$i]['kode_jaminan'];?></td>
        <td><?php echo $list[$i]['icd_code'];?></td>
		<td><?php echo $list[$i]['treatment'];?></td>
        </tr>
		<?php endfor;?>
    </tbody>
</table>
<div style="text-align:center;" class="tblInput">
<input type="button" value="Cetak" onclick="openPrintPopup('print_rujukan/printout/');"/>
<input type="button" value="Export ke Excel" onclick="openPrintPopup('print_rujukan/excel/');"/>
</div>
