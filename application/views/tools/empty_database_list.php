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
        </tr>
	</thead>
	<tbody id="tbodySearchResult">
	<?php if(empty($list)) :?>
		<tr>
			<td colspan="3" style="text-align:center;font-style:italic"><?php echo $this->lang->line('msg_data_not_found');?></td>
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
			<td ondblclick="get_data_by_id('<?php echo $list[$i]['id'];?>')"><?php echo $tgl;?></td>
		</tr>
		<?php endfor;?>
	<?php endif;?>
	</tbody>
</table>
