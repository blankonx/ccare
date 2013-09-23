<h3 class="report_title"><?php echo $report_title;?></h3>
<h4 class="report_sub_title"><?php echo $report_sub_title_wilayah;?></h4>
<h4 class="report_sub_title"><?php echo $report_sub_title;?></h3>
<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="width:700px;margin:10px auto">
    <thead>
    <tr>
        <th style="width:30px;">No</th>
        <th>No. RM</th>
        <th>Nama</th>
        <th>Diagnosa</th>
        <th>Tindakan</th>
        <th>Obat</th>
    </tr>
    </thead>
    <tbody>
    <?php for($i=0;$i<sizeof($list);$i++) :?>
    <tr>
        <td><?php echo ($i+1);?></td>
        <td><?php echo $list[$i]['no_rm'];?></td>
        <td><?php echo $list[$i]['name'];?></td>
        <td><?php echo $list[$i]['diagnose'];?></td>
        <td><?php echo $list[$i]['treatment'];?></td>
        <td><?php echo $list[$i]['drug'];?></td>
    </tr>
    <?php endfor;?>
    </tbody>
</table>
<div style="text-align:center;" class="tblInput">
<input type="button" value="Cetak" onclick="openPrintPopup('visit_sensus/printout/');"/>
</div>
