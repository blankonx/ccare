<h3 class="report_title"><?php echo $report_title;?></h3>

<h4 class="report_sub_title"><?php echo $report_sub_title;?></h3>
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
<div style="text-align:center;" class="tblInput">
<input type="button" value="Cetak" onclick="openPrintPopup('visit_sensus/printout/');"/>
<input type="button" value="Export ke Excel" onclick="openPrintPopup('visit_sensus/excel/');"/>
</div>
