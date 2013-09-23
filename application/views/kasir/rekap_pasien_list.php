<h3 class="report_title"><?php echo $report_title;?></h3>
<h4 class="report_sub_title"><?php echo $report_sub_title_wilayah;?></h4>
<h4 class="report_sub_title"><?php echo $report_sub_title;?></h3>
<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="width:700px;margin:10px auto">
    <thead>
    <tr>
        <th style="width:30px;">No</th>
        <th>No. RM</th>
        <th>Pasien</th>
        <th>Tindakan</th>
        <th style="width:120px;">Tagihan (Rp)</th>
    </tr>
    </thead>
    <tbody>
    <?php for($i=0;$i<sizeof($list);$i++) :?>
    <tr>
        <td><?php echo ($i+1);?></td>
        <td><?php if($list[$i]['mr_number'] != $list[$i-1]['mr_number']) echo $list[$i]['mr_number'];?></td>
        <td><?php if($list[$i]['mr_number'] != $list[$i-1]['mr_number']) echo $list[$i]['name'];?></td>
        <td><?php echo $list[$i]['treatment'];?></td>
        <td style="text-align:right"><?php echo uangIndo($list[$i]['pay']);?></td>
    </tr>
    <?php $total+= $list[$i]['pay']; endfor;?>
    <tr>
        <td colspan="6" style="text-align:right"><b><?php echo uangIndo($total) . '<br/>Terbilang :<em>' . terbilang($total) . ' Rupiah</em>' ;?></b></td>
    </tr>
    </tbody>
</table>
<div style="text-align:center;" class="tblInput">
<input type="button" value="Cetak" onclick="openPrintPopup('rekap_pasien/printout/');"/>
</div>
