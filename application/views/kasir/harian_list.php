<h3 class="report_title"><?php echo $report_title;?></h3>
<h4 class="report_sub_title"><?php echo $report_sub_title_wilayah;?></h4>
<h4 class="report_sub_title"><?php echo $report_sub_title;?></h3>
<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="width:700px;margin:10px auto">
    <thead>
    <tr>
        <th style="width:5px;">No</th>
        <th style="width:120px;">Sub Total (Rp)</th>
    </tr>
    </thead>
    <tbody>
    <?php for($i=0;$i<sizeof($list);$i++) :?>
    <tr>
        <td style="width:5px;"><?php echo ($i+1);?></td>
        <td style="text-align:right"><?php echo uangIndo($list[$i]['pay']);?></td>
    </tr>
    <?php $total+= $list[$i]['pay']; endfor;?>
    <tr>
        <td colspan="3" style="text-align:right"><?php echo uangIndo($total) . '<br/>Terbilang :<em>' . terbilang($total) . ' Rupiah</em>' ;?></td>
    </tr>
    </tbody>
</table>
<div style="text-align:center;" class="tblInput">
<input type="button" value="Cetak" onclick="openPrintPopup('harian/printout/');"/>
</div>
