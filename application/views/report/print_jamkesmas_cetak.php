<div id="body">
    <div style="text-align:center;text-decoration:underline;text-transform:uppercase;font-weight:bold">
       <?php echo $report_title;?>
    </div>
     <div style="text-align:center;"><?php echo $report_sub_title;?></div><br/>
	
	<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="width:1000px;margin:10px auto">
		<thead>
		<tr>
        <th style="width:30px;">No</th>
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
		<th>Total Biaya</th>
		<th>Kode Primary Care</th>
        </tr>
		</thead>
		<tbody>
		<?php for($i=0;$i<sizeof($list);$i++) :?>
		<? $thn = getAge($list[$i]['birth_date'], $list[$i]['visit_date']);?>
		<tr>
        <td><?php echo ($i+1);?></td>
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
        <td><?php echo $list[$i]['total'];?></td>
        <td><?php echo $list[$i]['kode_klinik'];?></td>
        </tr>
		<?php endfor;?>
		</tbody>
	</table>
	
    <div style="margin-top:5mm;"></div>
    <div style="margin-left:12cm;float:left;width:9cm;text-align:center;">
        <?php echo tanggalIndo(date('Y-m-d'), 'j F Y');?><br/>
        Mengetahui/Mengesahkan, <br/><br/><br/><br/><br/>
        <?php echo $profile['name']?><br/>
		(<?php echo $profile['no_sip']?>)<br/><br/>
    </div>
	<div style="clear:both"></div>
</div>
