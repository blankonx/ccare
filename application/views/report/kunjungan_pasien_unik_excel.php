<html>
    <head>
        <title></title>
    </head>
<body>
	<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="width:1000px;margin:10px auto">
		<thead>
		<tr>
            <th colspan="15"><?php echo $report_title;?></th>
		</tr>
		<tr>
            <th colspan="15"><?php echo $report_sub_title_wilayah;?></th>
		</tr>
		<tr>
            <th colspan="15"><?php echo $report_sub_title;?></th>
		</tr>
		<tr>
        <tr>
        <th style="width:30px;">No</th>
        <th>No. RM</th>
        <th>NIK/KTP</th>
        <th>Nama Pasien</th>
        <th style="width:35px;">Usia</th>
        <th style="width:35px;">Tgl Lahir</th>
        <th>Sex</th>
        <th>Alamat</th>
        <th>Jenis Pasien</th>
     </tr>
    </thead>
    <tbody>
    <?php for($i=0;$i<sizeof($list);$i++) :?>
    <tr>
        <td><?php echo ($i+1);?></td>
        <td><?php echo $list[$i]['no_rm'];?></td>
        <td><?php echo $list[$i]['nik'];?></td>
        <td><?php echo $list[$i]['name'];?></td>
        <td style="text-align:right;"><?php echo getOneAge($list[$i]['birth_date'], $list[$i]['visit_date']);?></td>
        <td><?php echo $list[$i]['birth_date'];?></td>
        <td><?php echo $list[$i]['sex'];?></td>
        <td><?php echo $list[$i]['alamat'];?></td>
        <td><?php echo $list[$i]['jenis_pasien'];?></td>
         </tr>
    <?php endfor;?>
    </tbody>
</table>
</body>
</html>
