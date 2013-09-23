<div id="body">
    <div style="text-align:center;text-decoration:underline;text-transform:uppercase;font-weight:bold">
       <?php echo $report_title;?>
    </div>
    <div style="text-align:center;"><?php echo $report_sub_title_wilayah;?></div>
    <div style="text-align:center;"><?php echo $report_sub_title;?></div><br/>
	

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
    <div style="margin-top:5mm;"></div>
    <div style="margin-left:12cm;float:left;width:9cm;text-align:center;">
        <?php //echo removeKotaKab($profile['district']);?>, <?php echo tanggalIndo(date('Y-m-d'), 'j F Y');?><br/>
        Mengetahui/Mengesahkan, <br/><br/><br/><br/>
        <?php echo $profile['name']?><br/>
		(<?php echo $profile['no_sip']?>)<br/><br/>
    </div>
	<div style="clear:both"></div>
</div>
