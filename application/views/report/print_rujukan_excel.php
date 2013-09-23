<html>
    <head>
        <title></title>
    </head>
<body>
	<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="width:1000px;margin:10px auto">
		<thead>
		<tr>
            <th colspan="15"><?php echo $report_title;?></th>
		</tr>
	
		<tr>
            <th colspan="15"><?php echo $report_sub_title;?></th>
		</tr>
		<tr>
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

</body>
</html>
