<script language="javascript">
function exportCharts(chartId, chartId2, exportType)
{
	var chart = getChartFromId(chartId);
	var chart2 = getChartFromId(chartId2);
	if (chart.hasRendered() != true && chart2.hasRendered() != true) {
		alert("Please wait for the chart to finish rendering, before you can invoke exporting");
		return;
	}
	chart.exportChart( {exportFormat: exportType} );
	chart2.exportChart( {exportFormat: exportType} );
}
var img2;
var n=0;
var timeoutId;
function exportCallback(obj) {
	if(img2) {
		openPrintPopup('visit_by_age/printout/<?php echo underscore($report_title);?>');
	} else {
		if(n < 5) {
			timeoutId = setTimeout("exportCallback()", 1000);
			n++;
		} else {
			clearTimeout(timeoutId);
			alert('Gambar 2 belum selesai');
			return;
		}
	}
}
function exportCallback2(obj) {
	img2 = basename(obj.fileName);
}
</script>
<h3 class="report_title"><?php echo $report_title;?></h3>
<h4 class="report_sub_title"><?php echo $report_sub_title;?></h3>
<div style="text-align:center;"><?php $FC1->renderChart(); ?></div>
<div style="text-align:center;"><?php $FC2->renderChart(); ?></div>
<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="width:700px;margin:10px auto">
    <thead>
    <tr>
        <th rowspan="2" style="width:30px;">No</th>
        <th rowspan="2">Waktu</th>
        <th colspan="<?php echo sizeof($chart['dataset'])?>" style="text-align:center;">Jumlah</th>
        <th rowspan="2" style="width:50px;text-align:center;">Sub Total</th>
    </tr>
    <tr>
		<?php for($i=0;$i<sizeof($chart['dataset']);$i++) :?>
        <th style="width:70px;"><?php echo $chart['dataset'][$i]?></th>
		<?php endfor;?>
    </tr>
    </thead>
    <tbody>
    <?php for($i=0;$i<sizeof($chart['name']);$i++) :?>
    <tr>
        <td><?php echo ($i+1);?></td>
        <td><?php echo $chart['name'][$i];?></td>
		<?php for($j=0;$j<sizeof($chart['count'][$i]);$j++) :?>
        <td style="text-align:right"><?php echo $chart['count'][$i][$j];?></td>
		<?php 
		$chart['sub_total'][$j] += $chart['count'][$i][$j];
		endfor;?>
        <td style="text-align:right"><?php echo @array_sum($chart['count'][$i]);?></td>
    </tr>
    <?php endfor;?>
    <tr>
        <td colspan="2"><b>Sub Total</b></td>
		<?php for($i=0;$i<sizeof($chart['sub_total']);$i++) :?>
        <td style="text-align:right"><?php echo $chart['sub_total'][$i]?></td>
		<?php endfor;?>
        <td style="text-align:right"><?php echo @array_sum($chart['sub_total']);?></td>
    </tr>
    </tbody>
</table>

<div style="text-align:center;" class="tblInput">
<input type="button" value="Cetak" onclick="exportCharts('Visit_By_AgeChart', 'Visit_By_AgeChart_Total', 'JPG')" id="buttonExport" />
</div>
