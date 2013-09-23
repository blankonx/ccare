<input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page;?>" />
<div class="pagingContainer">
	<div class="buttonAdd buttonPaging" id="addData">Add</div>
	<div class="buttonDelete buttonPaging" id="deleteList">Delete</div>
	<div class="buttonSelectAll buttonPaging" id="selectAll">Select All</div>
	<div class="buttonReload" id="reloadData"></div>
	<div class="buttonFind" id="findData"></div>
	<div class="pagingLinks"><?php echo $links;?></div>
</div>
<table cellpadding="0" cellspacing="0" border="0" class="tblListData">
	<thead>
        <tr>
            <th style="width:50px">No.</th>
            <th>Keterangan</th>
            <th>Dibuat Tanggal</th>
            <th style="width:50px;">Ukuran (MB)</th>
            <th style="width:50px;">Download</th>
			<th style="width:50px;">Restore</th>
        </tr>
	</thead>
	<tbody id="tbodySearchResult">
	<?php if(empty($list)) :?>
		<tr>
			<td colspan="6" style="text-align:center;font-style:italic"><?php echo $this->lang->line('msg_data_not_found');?></td>
		</tr>
	<?php else :?>
		<?php for($i=0;$i<sizeof($list);$i++) :
		$tgl = tanggalIndo($list[$i]['date'], "j F Y H:i");
		?>
		<tr class="notSelected">
			<td>
                <?php echo ($i+1);?>
                <input type="checkbox" class="checkbox_delete" name="delete_id[]" id="delete_id_<?php echo $list[$i]['id'];?>" value="<?php echo $list[$i]['id'];?>" />
            </td>
			<td ondblclick="get_data_by_id('<?php echo $list[$i]['id'];?>')"><?php echo $list[$i]['name'];?></td>
			<td><?php echo $tgl;?></td>
			<td style="text-align:right" ondblclick="get_data_by_id('<?php echo $list[$i]['id'];?>')"><?php echo round($list[$i]['filesize']/1024/1024, 1);?></td>
			<td ondblclick="get_data_by_id('<?php echo $list[$i]['id'];?>')" style="text-align:center;">
			<a href="<?php echo site_url('tools/backup_database/download/' . $list[$i]['filename']) ;?>" title="Download Backup Database <?php echo $tgl; ?>" target="_blank">
				<img src="<?php echo base_url()?>webroot/media/images/download.png" alt="Download"/>
			</a>
			</td>
			<td style="text-align:center;">
				<a class="restore_database" href="<?php echo site_url("tools/backup_database/restore_database") . "/" . basename($list[$i]['filename']);?>" title="Restore Backup <?php echo $periode; ?>">
					<img src="<?php echo base_url()?>webroot/media/images/reset.png" alt="Restore"/>
				</a>
			</td>
		</tr>
		<?php endfor;?>
	<?php endif;?>
	</tbody>
</table>
