<div id="body">
    <div style="text-align:center;text-decoration:underline;text-transform:uppercase;font-weight:bold">
       <?php echo $report_title;?>
    </div>
    <div style="text-align:center;"><?php echo $report_sub_title;?></div><br/>
<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="margin:10px auto">
    <thead>
    <tr>
        <th style="width:30px;" rowspan="2">No</th>
        <th style="width:100px;" rowspan="2">Nama/RM Pasien</th>
        <th style="width:100px;" rowspan="2">Nama Ortu</th>
        <th style="width:80px;" rowspan="2">Desa</th>
		<th style="width:150px;" rowspan="2">Alamat</th>
		<th style="width:10px;" rowspan="2">Jenis Kelamin</th>
		<th style="width:80px;" rowspan="2">Tempat/Tanggal Lahir</th>
		<th style="width:80px;" rowspan="2">Jenis/No. Asuransi Pasien</th>
		<th style="width:40px;" rowspan="2">Tanggal Input</th>
	</tr>
    <tr>
        <?php foreach($clinic as $key => $val) :?>
            <th><?php echo $val;?></th>
        <?php endforeach;?>
    </tr>
    </thead>
    <tbody>
    <?php for($i=0;$i<sizeof($report);$i++) :?>
    <tr>
        <td><?php echo ($i+1);?></td>
        <td><?php echo $report[$i]['name'];?><? echo"/"; ?><?php echo $report[$i]['family_folder']."-".$report[$i]['family_relationship_id'];?></td>
        <td><?php echo $report[$i]['parent_name'];?></td>
         <td><?php echo $report[$i]['desa'];?></td>
        <td><?php echo $report[$i]['address'];?></td>
        <td style="text-align:center"><?php echo $report[$i]['sex'];?></td>
        <td style="text-align:left"><?php echo $report[$i]['birth_place']."/".$report[$i]['tgl_lahir'];?></td>
        <td style="text-align:left"><?php echo $report[$i]['jns_pasien']."/".$report[$i]['insurance_no'];?></td>
        <td style="text-align:left"><?php echo $report[$i]['registration_date'];?></td>
    </tr>
    <?php endfor;?>
    </tbody>
</table>
	
    <div style="margin-top:5mm;"></div>
    <div style="margin-left:17cm;float:left;width:9cm;text-align:center;">
        <?php echo removeKotaKab($profile['district']);?>, <?php echo tanggalIndo(date('Y-m-d'), 'j F Y');?><br/>
        Petugas<br/><br/><br/><br/><br/>
		______________________________<br/><br/>
    </div>
	<div style="clear:both"></div>
</div>
