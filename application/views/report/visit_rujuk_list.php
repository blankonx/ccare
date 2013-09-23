<script language="javascript">
function exportCharts(chartId, exportType)
{
	var chart = getChartFromId(chartId);
	if (chart.hasRendered() != true) {
		alert("Please wait for the chart to finish rendering, before you can invoke exporting");
		return;
	}
	chart.exportChart( {exportFormat: exportType} );
}
function exportCallback(obj) {
	var filename = obj.fileName;
	//openPrintPopup('visit_rujuk/pdf/' + basename(filename));
	openPrintPopup('visit_rujuk/printout/<?php echo underscore($report_title);?>');
	//alert(lebar);
}
</script>
<h3 class="report_title"><?php echo $report_title;?></h3>
<h4 class="report_sub_title"><?php echo $report_sub_title_wilayah;?></h4>
<h4 class="report_sub_title"><?php echo $report_sub_title;?></h4>
<div style="text-align:center"><?php $this->chart->renderChart(); ?></div>
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
		 //echo "<pre>";
         //print_r($report);
         //echo "</pre>";	
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
<div style="text-align:center;" class="tblInput">
<input type="button" value="Cetak" onclick="exportCharts('Visit_RujukChart', 'JPG')" id="buttonExport" />
</div>
