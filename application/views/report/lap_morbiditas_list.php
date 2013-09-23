<h3 class="report_title"><?php echo $report_title; ?></h3>
<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="width:500px;margin:10px auto">
    <thead>
    <tr>
        <th style="width:30px;">No</th>
        <th>Periode</th>
        <th>Dibuat Tanggal</th>
        <th style="width:50px;">Ukuran (KB)</th>
        <th style="width:50px;">Download</th>
    </tr>
    </thead>
    <tbody>
    <?php for($i=0;$i<sizeof($report);$i++) : 
		$arr_periode = explode("-", $report[$i]['periode']);
		$periode = bulanIndo($arr_periode[0], "F") . " " . $arr_periode[1];
		$tgl = tanggalIndo($report[$i]['date'], "j F Y H:i");
	?>
    <tr>
        <td><?php echo ($i+1);?></td>
        <td><?php echo $periode;?></td>
        <td><?php echo $tgl;?></td>
        <td style="text-align:right;"><?php echo round($report[$i]['filesize']/1024, 1);?></td>
        <td style="text-align:center;">
			
			<a href="<?php echo base_url() . $report[$i]['filename'] . ".dep";?>" title="Download Laporan Morbiditas Periode <?php echo $periode; ?>">
				<img src="<?php echo base_url()?>webroot/media/images/download.png" alt="Download"/>
			</a>
		</td>
    </tr>
    <?php endfor;?>
    </tbody>
</table>
<div style="text-align:center;" class="tblInput">
</div>
