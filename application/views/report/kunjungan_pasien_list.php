<h3 class="report_title"><?php echo $report_title;?></h3>
<h4 class="report_sub_title"><?php echo $report_sub_title_wilayah;?></h4>
<h4 class="report_sub_title"><?php echo $report_sub_title;?></h3>
<table cellpadding="1" cellspacing="0" border="0" class="tblListData" style="width:1000px;margin:10px auto">
    <thead>
    <tr>
            <th style="width:30px;">No</th>
            <th>No. RM</th>
            <th>No. RM Lama</th>
            <th>Tanggal Kunjungan</th>
            <th>Nama Pasien</th>
            <th>Nama KK</th>
            <th>Sex</th>
            <th style="width:35px;">Tgl Lahir</th>
            <th style="width:35px;">Usia</th>
            <th style="width:35px;">Alamat</th>
            <th>Desa</th>
            <th style="width:150px;">Kriteria Kunjungan<br>(B1=Baru, B2=Baru Kalender, L=Lama)</th>
            <th>Jenis Pasien</th>
		</tr>
    </thead>
    <tbody>
    <?php for($i=0;$i<sizeof($list);$i++) :?>
    <tr>
        <td><?php echo ($i+1);?></td>
        <td><?php echo $list[$i]['no_rm'];?></td>
        <td><?php echo $list[$i]['nik'];?></td>
        <td><?php echo $list[$i]['date'];?></td>
        <td><?php echo $list[$i]['name'];?></td>
        <td><?php echo $list[$i]['kk'];?></td>
        <td><?php echo $list[$i]['sex'];?></td>
        <td><?php echo $list[$i]['birth_date'];?></td>
        <td style="text-align:right;"><?php echo getOneAge($list[$i]['birth_date'], $list[$i]['visit_date']);?></td>
        <td><?php echo $list[$i]['alamat'];?></td>
        <td><?php echo $list[$i]['village'];?></td>
        <td style="width:150px;"><?php echo $list[$i]['jenis_kunjungan'];?></td>
        <td><?php echo $list[$i]['jenis_pasien'];?></td>
    </tr>
    <?php endfor;?>
    </tbody>
</table>
<div style="text-align:center;" class="tblInput">
<input type="button" value="Cetak" onclick="openPrintPopup('kunjungan_pasien/printout/');"/>
<input type="button" value="Export ke Excel" onclick="openPrintPopup('kunjungan_pasien/excel/');"/>
</div>
