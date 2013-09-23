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
	//openPrintPopup('patient_education/pdf/' + basename(filename));
	openPrintPopup('sepuluh_besar_anak_dewasa/printout/<?php echo underscore($report_title);?>');
	//alert(lebar);
}
</script>
<h3 class="report_title"><?php echo $report_title;?></h3>
<h4 class="report_sub_title"><?php echo $report_sub_title_wilayah;?></h4>
<h4 class="report_sub_title"><?php echo $report_sub_title;?></h3>
<div style="text-align:center"><?php $this->chart->renderChart(); ?></div>
<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="width:700px;margin:10px auto">
    <thead>
    <tr>
        <th style="width:30px;">No</th>
        <th>Diagnosa</th>
        <th style="width:70px;text-align:center;">Anak</th>
        <th style="width:70px;text-align:center;">Dewasa</th>
    </tr>
    </thead>
    <tbody>
    <?php for($i=0;$i<sizeof($chart);$i++) :?>
    <tr>
        <td><?php echo ($i+1);?></td>
        <td><?php echo $chart[$i]['code'] . ' - ' . $chart[$i]['name'];?></td>
        <td style="text-align:right"><?php echo $chart[$i]['anak'];?></td>
        <td style="text-align:right"><?php echo $chart[$i]['dewasa'];?></td>
		<?php
		$anak += $chart[$i]['anak'];
		$dewasa += $chart[$i]['dewasa'];
		?>
    </tr>
    <?php endfor;?>
    <tr>
        <td colspan="2"><b>Total</b></td>
        <td style="text-align:right"><?php echo $anak;?></td>
        <td style="text-align:right"><?php echo $dewasa;?></td>
    </tr>
    </tbody>
</table>
<div style="text-align:center;" class="tblInput">
<input type="button" value="Cetak" onclick="exportCharts('Sepuluh_Besar_Anak_DewasaChart', 'JPG')" id="buttonExport" />
</div>
