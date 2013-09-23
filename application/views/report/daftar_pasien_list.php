<input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page;?>" />
<div class="pagingContainer">
	
	<div class="pagingLinks"><?php echo $links;?></div>
</div>
<table cellpadding="0" cellspacing="0" border="0" class="tblListData">
	<thead>
       <tr>
        <th style="width:30px;" rowspan="2">No</th>
        <th style="width:100px;" rowspan="2">Nama/RM Pasien</th>
        <th style="width:150px;" rowspan="2">Alamat</th>
		<th style="width:10px;" rowspan="2">Jenis Kelamin</th>
		<th style="width:80px;" rowspan="2">Tempat/Tanggal Lahir</th>
		<th style="width:80px;" rowspan="2">Jenis/No. Asuransi Pasien</th>
		<th style="width:40px;" rowspan="2">Tanggal Input</th>
	</tr>
	</thead>
	<tbody id="tbodySearchResult">
	<?php if(empty($list)) :?>
		<tr>
			<td colspan="9" style="text-align:center;font-style:italic"><?php echo $this->lang->line('msg_data_not_found');?></td>
		</tr>
	<?php else :?>
		<?php for($i=0;$i<sizeof($list);$i++) :?>
		<tr class="notSelected">
			<td>
                <?php echo (++$start);?>
                <input type="checkbox" class="checkbox_delete" name="delete_id[]" id="delete_id_<?php echo $list[$i]['id'];?>" value="<?php echo $list[$i]['id'];?>" />
            </td>
        <td><?php echo $list[$i]['name'];?><? echo"/"; ?><?php echo $list[$i]['family_folder']."-".$list[$i]['family_relationship_id'];?></td>
        <td><?php echo $list[$i]['address'];?></td>
        <td style="text-align:center"><?php echo $list[$i]['sex'];?></td>
        <td style="text-align:left"><?php echo $list[$i]['birth_place']."/".$list[$i]['tgl_lahir'];?></td>
        <td style="text-align:left"><?php if($list[$i]['jns_pasien']<>'UMUM') echo $list[$i]['jns_pasien']."/".$list[$i]['insurance_no']; else echo $list[$i]['jns_pasien'];?></td>
        <td style="text-align:left"><?php echo $list[$i]['registration_date'];?></td>
    </tr>
		<?php endfor;?>
	<?php endif;?>
	</tbody>
</table>
<div style="text-align:center;" class="tblInput">
<!--<input type="button" value="Cetak" onclick="openPrintPopup('daftar_pasien_list/cetak/<?php echo underscore($report_title);?>');" id="buttonExport" /> -->
<input type="button" value="Export ke Excel" onclick="openPrintPopup('daftar_pasien_list/excel/<?php echo underscore($report_title);?>');" />
</div>
