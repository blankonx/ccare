<div id="body">
    <div style="text-align:center;text-decoration:underline;text-transform:uppercase;font-weight:bold">
       <?php echo $report_title;?>
    </div>
    <div style="text-align:center;"><?php echo $report_sub_title_wilayah;?></div>
    <div style="text-align:center;"><?php echo $report_sub_title;?></div><br/>
	
	<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="width:1000px;margin:10px auto">
		<thead>
		<tr>
            <th style="width:30px;">No</th>
            <th>No. RM</th>
            <th>No. RM Lama</th>
            <th>Tanggal Kunjungan</th>
            <th>Nama Pasien</th>
            <th>Nama KK</th>
            <th>Sex</th>
            <th style="width:35px;">Tgl Lahir</th>
            <th style="width:35px;">Usia</th>
            <th style="width:35px;">Alamat</th>
            <th>Desa</th>
            <th style="width:150px;">Kriteria Kunjungan<br>(B1=Baru, B2=Baru Kalender, L=Lama)</th>
            <th>Jenis Pasien</th>
		</tr>
		</thead>
		<tbody>
		<?php for($i=0;$i<sizeof($list);$i++) :?>
		<tr>
        <td><?php echo ($i+1);?></td>
        <td><?php echo $list[$i]['no_rm'];?></td>
        <td><?php echo $list[$i]['nik'];?></td>
        <td><?php echo $list[$i]['date'];?></td>
        <td><?php echo $list[$i]['name'];?></td>
        <td><?php echo $list[$i]['kk'];?></td>
        <td><?php echo $list[$i]['sex'];?></td>
        <td><?php echo $list[$i]['birth_date'];?></td>
        <td style="text-align:right;"><?php echo getOneAge($list[$i]['birth_date'], $list[$i]['visit_date']);?></td>
        <td><?php echo $list[$i]['alamat'];?></td>
        <td><?php echo $list[$i]['village'];?></td>
        <td style="width:150px;"><?php echo $list[$i]['jenis_kunjungan'];?></td>
        <td><?php echo $list[$i]['jenis_pasien'];?></td>
		</tr>
		<?php endfor;?>
		</tbody>
	</table>
	
    <div style="margin-top:5mm;"></div>
    <div style="margin-left:12cm;float:left;width:9cm;text-align:center;">
        <?php echo removeKotaKab($profile['district']);?>, <?php echo tanggalIndo(date('Y-m-d'), 'j F Y');?><br/>
        Mengetahui/Mengesahkan, <br/><br/><br/><br/><br/>
        <?php echo $profile['name']?><br/>
		(<?php echo $profile['no_sip']?>)<br/><br/>
    </div>
	<div style="clear:both"></div>
</div>
