<div id="body">
    <div style="text-align:center;text-decoration:underline;text-transform:uppercase;font-weight:bold">
       <?php echo $report['report_title'];?>
    </div>
    <div style="text-align:center;"><?php echo $report['report_sub_title_wilayah'];?></div>
    <div style="text-align:center;"><?php echo $report['report_sub_title'];?></div><br/>
	<div style="text-align:center;"><img src="<?php echo base_url()?>webroot/media/charts/chart.jpg" alt="<?php echo $report_title;?>" /></div>
	
	<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="width:1000px;margin:10px auto">
    <thead>
    <tr>
        <th rowspan="2" style="width:30px;">No</th>
        <th rowspan="2" style="width:150px;">Rujuk Ke</th>
        <th colspan="<?php echo sizeof($jenis)?>" style="width:70px;text-align:center;">Jumlah</th>
        <th rowspan="2"> TOTAL</th>
    </tr>
    <tr>
        <?php for($j=0;$j<sizeof($jenis);$j++) :?>
			<th style="text-align:right"><?php echo $jenis[$j]['name'];?></th>
		<?php
		endfor;?>
    </tr>
    </thead>
    <tbody>
    <?php for($i=0;$i<sizeof($report);$i++) :?>
    <tr>
        <td><?php echo ($i+1);?></td>
        <td><?php echo $report[$i]['name'];?></td>
        <?php for($j=0;$j<sizeof($jenis);$j++) :?>
			<td style="text-align:right"><?php echo $report[$i]['count'][$jenis[$j]['id']];?></td>
		<?php
		$total[$jenis[$j]['id']] += $report[$i]['count'][$jenis[$j]['id']];
		$total[$report[$i]['name']] += $report[$i]['count'][$jenis[$j]['id']];
		$totaltok += $report[$i]['count'][$jenis[$j]['id']];
		endfor;
		//$total += $report[$i]['count'];
		
		
		?>
		<td style="text-align:right"><?php echo $total[$report[$i]['name']];?></td>
    </tr>
    <?php endfor;?>
		<tr>
        <td colspan="2"><b>Total</b></td>
			<?php for($j=0;$j<sizeof($jenis);$j++) :?>
				<td style="text-align:right"><?php echo $total[$jenis[$j]['id']];?></td>
			<?php
			endfor;?>
			<td style="text-align:right"><?php echo $totaltok?></td>
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
