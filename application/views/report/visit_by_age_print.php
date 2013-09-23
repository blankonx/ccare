<div id="body">
    <div style="text-align:center;text-decoration:underline;text-transform:uppercase;font-weight:bold">
       <?php echo $report['report_title'];?>
    </div>
    <div style="text-align:center;"><?php echo $report['report_sub_title'];?></div><br/>
	<div style="text-align:center;"><img src="<?php echo base_url()?>webroot/media/charts/chart.jpg" alt="<?php echo $report_title;?>" /></div>
	<div style="text-align:center;"><img src="<?php echo base_url()?>webroot/media/charts/chart2.jpg" alt="<?php echo $report_title;?>" /></div>
	
	<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="width:700px;margin:10px auto">
		<thead>
		<tr>
			<th rowspan="2" style="width:30px;">No</th>
			<th rowspan="2">Waktu</th>
			<th colspan="<?php echo sizeof($report['chart']['dataset'])?>" style="text-align:center;">Jumlah</th>
			<th rowspan="2" style="width:50px;text-align:center;">Sub Total</th>
		</tr>
		<tr>
			<?php for($i=0;$i<sizeof($report['chart']['dataset']);$i++) :?>
			<th style="width:70px;"><?php echo $report['chart']['dataset'][$i]?></th>
			<?php endfor;?>
		</tr>
		</thead>
		<tbody>
		<?php for($i=0;$i<sizeof($report['chart']['name']);$i++) :?>
		<tr>
			<td><?php echo ($i+1);?></td>
			<td><?php echo $report['chart']['name'][$i];?></td>
			<?php for($j=0;$j<sizeof($report['chart']['count'][$i]);$j++) :?>
			<td style="text-align:right"><?php echo $report['chart']['count'][$i][$j];?></td>
			<?php 
			$report['chart']['sub_total'][$j] += $report['chart']['count'][$i][$j];
			endfor;?>
			<td style="text-align:right"><?php echo array_sum($report['chart']['count'][$i]);?></td>
		</tr>
		<?php endfor;?>
		<tr>
			<td colspan="2"><b>Sub Total</b></td>
			<?php for($i=0;$i<sizeof($report['chart']['sub_total']);$i++) :?>
			<td style="text-align:right"><?php echo $report['chart']['sub_total'][$i]?></td>
			<?php endfor;?>
			<td style="text-align:right"><?php echo @array_sum($report['chart']['sub_total']);?></td>
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
