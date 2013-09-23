<script language="javascript">
function exportCharts(chartId, exportType)
{
	var chart = getChartFromId(chartId);
	if (chart.hasRendered() != true) {
		alert("Tunggu sampai grafik selesai di load.");
		return;
	}
	chart.exportChart( {exportFormat: 'JPG'} );
}
function exportCallback(obj) {
	var filename = obj.fileName;
	//openPrintPopup('visit_baru_lama/pdf/' + basename(filename));
	var exportType = $('#exportType').val();
	openPrintPopup('visit_baru_lama/'+exportType+'/<?php echo underscore($report_title);?>');
	//alert(lebar);
}
$.(document).ready(function() {
	$('#buttonExport').click(function() { $('#exportType').val('printout') });
	//$('#buttonExportPDF').click(function() { $('#exportType').val('pdf') });
});
</script>
<h3 class="report_title"><?php echo $report_title;?></h3>
<h4 class="report_sub_title"><?php echo $report_sub_title_wilayah;?></h4>
<h4 class="report_sub_title"><?php echo $report_sub_title;?></h4>
<div style="text-align:center"><?php $this->chart->renderChart(); ?></div>
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
    <?php for($i=0;$i<sizeof($chart);$i++) :?>
    <tr>
        <td><?php echo ($i+1);?></td>
        <td><?php echo $chart[$i]['name'];?></td>
        <td style="text-align:right"><?php echo $chart[$i]['new_count'];?></td>
        <td style="text-align:right"><?php echo $chart[$i]['newcal_count'];?></td>
        <td style="text-align:right"><?php echo $chart[$i]['oldcal_count'];?></td>
        <td style="text-align:right"><?php echo ($chart[$i]['new_count']+$chart[$i]['newcal_count']+$chart[$i]['oldcal_count']);?></td>
		<?php
		$new_total += $chart[$i]['new_count'];
		$newcal_total += $chart[$i]['newcal_count'];
		$oldcal_total += $chart[$i]['oldcal_count'];
		?>
    </tr>
    <?php endfor;?>
    <tr>
        <td colspan="2"><b>Sub Total</b></td>
        <td style="text-align:right"><?php echo $new_total;?></td>
        <td style="text-align:right"><?php echo $newcal_total;?></td>
        <td style="text-align:right"><?php echo $oldcal_total;?></td>
        <td style="text-align:right"><?php echo ($newcal_total+$oldcal_total+$new_total);?></td>
    </tr>
    </tbody>
</table>
<div style="text-align:center;" class="tblInput">
<input type="hidden" value="printout" id="exportType" />
<input type="button" value="Cetak" onclick="exportCharts('Visit_Baru_LamaChart')" id="buttonExport"/>
<!--<input type="button" value="Export PDF" onclick="exportCharts('Visit_Baru_LamaChart')" id="buttonExportPDF" class="btn_report btn_pdf"/>-->
</div>
