<div id="body">
    <div style="text-align:center;text-decoration:underline;text-transform:uppercase;font-weight:bold">
       <?php echo $report['report_title'];?>
    </div>
    <div style="text-align:center;"><?php echo $report['report_sub_title_wilayah'];?></div>
    <div style="text-align:center;"><?php echo $report['report_sub_title'];?></div><br/>
	<div style="text-align:center;"><img src="<?php echo base_url()?>webroot/media/charts/chart.jpg" alt="<?php echo $report_title;?>" /></div>
	
	<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="width:700px;margin:10px auto">
		<thead>
		<tr>
        <th rowspan="2" style="width:30px;">No</th>
        <th rowspan="2">Waktu</th>
        <th colspan="3" style="width:70px;text-align:center;">Jumlah</th>
        <th rowspan="2" style="width:50px;text-align:center;">Sub Total</th>
    </tr>
    <tr>
        <th style="width:40px;">Baru</th>
        <th style="width:40px;">Baru Kalender</th>
        <th style="width:40px;">Lama Kalender</th>
    </tr>
		</thead>
		<tbody>
		<?php for($i=0;$i<sizeof($report['chart']);$i++) :?>
		<tr>
			<td><?php echo ($i+1);?></td>
			<td><?php echo $report['chart'][$i]['name'];?></td>
			<td style="text-align:right"><?php echo $report['chart'][$i]['new_count'];?></td>
			<td style="text-align:right"><?php echo $report['chart'][$i]['newcal_count'];?></td>
			<td style="text-align:right"><?php echo $report['chart'][$i]['oldcal_count'];?></td>
			<td style="text-align:right"><?php echo ($report['chart'][$i]['new_count']+$report['chart'][$i]['newcal_count']+$report['chart'][$i]['oldcal_count']);?></td>
			<?php
			$new_total += $report['chart'][$i]['new_count'];
			$newcal_total += $report['chart'][$i]['newcal_count'];
			$old_total += $report['chart'][$i]['old_count'];
			?>
		</tr>
		<?php endfor;?>
		<tr>
			<td colspan="2"><b>Sub Total</b></td>
			<td style="text-align:right"><?php echo $new_total;?></td>
			<td style="text-align:right"><?php echo $newcal_total;?></td>
			<td style="text-align:right"><?php echo $old_total;?></td>
			<td style="text-align:right"><?php echo ($newcal_total+$oldcal_total+$new_total);?></td>
		</tr>
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
