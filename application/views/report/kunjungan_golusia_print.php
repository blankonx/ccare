<style>
.tblListData td, .tblListData th  {
	font-size:10px;
}
</style>
<div id="body">
    <div style="text-align:center;text-decoration:underline;text-transform:uppercase;font-weight:bold">
       <?php echo $report_title;?>
    </div>
    
    <div style="text-align:center;"><?php echo $report_sub_title;?></div><br/>
<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="width:98%;margin:10px auto">
    <thead>
   <tr>
        <th rowspan="3" style="width:30px;">No</th>
        <th rowspan="3">Hari/Tanggal</th>
        <th rowspan="3">Jenis Pasien</th>
        <th colspan="<?php echo (sizeof($age)*2);?>" style="text-align:center;">Jumlah Kunjungan Pasien</th>
        <th rowspan="2" colspan="2" style="width:50px;text-align:center;">Total</th>
    </tr>
    <tr>
		<?php for($i=0;$i<sizeof($age);$i++) :?>
        <th colspan="2" style="text-align:center;"><?php echo $str_age[$i]?></th>
		<?php endfor;?>
    </tr>
    <tr>
		<?php for($i=0;$i<(sizeof($age)*1);$i++) :?>
        <th style="width:20px;">L</th>
        <th style="width:20px;">P</th>
		<?php endfor;?>
        <th style="width:20px;">L</th>
        <th style="width:20px;">P</th>
        
       
    </tr>
    </thead>
    <tbody>
    <?php $i=0; 
  //  echo "<pre>";
    //print_r($report);
   // echo "</pre>";
    foreach($report as $key => $val) : 
    foreach($val as $key2 => $val2) : 
    $total['Laki-laki']=0;
    $total['Perempuan']=0;   
    ?>
    <tr>
        <td><?php echo ($i+1);?></td>
        <td style="width:80px;"><?php echo $key;?></td>
        <td style="width:120px;"><?php echo $key2;?></td>
		<?php for($j=0;$j<(sizeof($age));$j++) :?>
        <td style="text-align:center"><?php echo empty($val2[$age[$j]]['Laki-laki'])?'0':$val2[$age[$j]]['Laki-laki'];?></td>
        <td style="text-align:center"><?php echo empty($val2[$age[$j]]['Perempuan'])?'0':$val2[$age[$j]]['Perempuan'];?></td>
       
       	<?php 
       	$subtotal[$j]['Laki-laki'] += $val2[$age[$j]]['Laki-laki'];
       	$subtotal[$j]['Perempuan'] += $val2[$age[$j]]['Perempuan'];
		$total['Laki-laki'] += $val2[$age[$j]]['Laki-laki'];
		$total['Perempuan'] += $val2[$age[$j]]['Perempuan'];
		endfor;?>
		
        <td style="text-align:center"><?php echo $total['Laki-laki'];?></td>
        <td style="text-align:center"><?php echo $total['Perempuan'];?></td>
        
       </tr>
    <?php $i++; 
		$totalsemua['Laki-laki'] += $total['Laki-laki'];
		$totalsemua['Perempuan'] += $total['Perempuan'];
		$totalsemuanya = $totalsemua['Laki-laki'] + $totalsemua['Perempuan'];
    endforeach;
    endforeach;
    ?>
    <tr>
		<td colspan="3" align="right"><b>SUB TOTAL</b></td>
		<?php for($j=0;$j<sizeof($age);$j++) :?>
				<td style="text-align:center"><?php echo $subtotal[$j]['Laki-laki'];?></td>
				<td style="text-align:center"><?php echo $subtotal[$j]['Perempuan'];?></td>
			<?php
			endfor;?>
		<td align="center"><b><?php echo $totalsemua['Laki-laki'];?></b></td>
		<td align="center"><b><?php echo $totalsemua['Perempuan'];?></b></td>
    </tr>
    <tr>
		<td colspan="27" align="right"><b>TOTAL</b></td>
		<td colspan="2" align="center"><b><?php echo $totalsemuanya;?></b></td>
    </tr>
    </tbody>
</table>
<div style="margin-top:5mm;"></div>
    <div style="margin-left:12cm;float:left;width:9cm;text-align:center;">
        <?php echo tanggalIndo(date('Y-m-d'), 'j F Y');?><br/>
        Dokter <br/><br/><br/><br/><br/>
        <?php echo $profile['name']?><br/>
		(<?php echo $profile['no_sip']?>)<br/><br/>
    </div>
	<div style="clear:both"></div>
</div>
