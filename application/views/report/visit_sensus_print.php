<div id="body">
    <div style="text-align:center;text-decoration:underline;text-transform:uppercase;font-weight:bold">
       <?php echo $report_title;?>
    </div>
     <div style="text-align:center;"><?php echo $report_sub_title;?></div><br/>
	
	<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="width:1000px;margin:10px auto">
		<thead>
		<tr>
        <th style="width:30px;">No</th>
        <th>Tgl Kunjungan</th>
        <th>No. RM</th>
        <th>Nama</th>
        <th>Sex</th>
        <th style="width:35px;">Usia</th>
        <th>Alamat Dusun</th>
        <th>Jenis Pasien</th>
        <th>ICD</th>
        <th>Diagnosa</th>
        <th>Kasus<br>Penyakit</th>
        <th>Tindakan</th>
        <th>Obat</th>
        </tr>
		</thead>
		<tbody>
		<?php for($i=0;$i<sizeof($list);$i++) :?>
		<tr>
        <td><?php echo ($i+1);?></td>
        <td><?php echo $list[$i]['date'];?></td>
        <td><?php echo $list[$i]['no_rm'];?></td>
        <td><?php echo $list[$i]['name'];?></td>
        <td><?php echo $list[$i]['sex'];?></td>
        <td style="text-align:right;"><?php echo getOneAge($list[$i]['birth_date'], $list[$i]['visit_date']);?></td>
        <td><?php echo $list[$i]['address'];?></td>
        <td><?php echo $list[$i]['jenis_pasien'];?></td>
        <td><?php echo $list[$i]['icd_code'];?></td>
        <td><?php echo $list[$i]['diagnose'];?></td>
        <td><?php echo $list[$i]['case'];?></td>
        <td><?php echo $list[$i]['treatment'];?></td>
        <td><?php echo $list[$i]['drug'];?></td>
        </tr>
		<?php endfor;?>
		</tbody>
	</table>
	
    <div style="margin-top:5mm;"></div>
    <div style="margin-left:12cm;float:left;width:9cm;text-align:center;">
        <?php echo tanggalIndo(date('Y-m-d'), 'j F Y');?><br/>
        Mengetahui/Mengesahkan, <br/><br/><br/><br/><br/>
        <?php echo $profile['name']?><br/>
		(<?php echo $profile['no_sip']?>)<br/><br/>
    </div>
	<div style="clear:both"></div>
</div>
