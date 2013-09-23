<input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page;?>" />
<div class="pagingContainer">
	<div class="buttonAdd buttonPaging" id="addData">Add</div>
	<div class="buttonDelete buttonPaging" id="deleteList" style="display:none">Delete</div>
	<div class="buttonSelectAll buttonPaging" id="selectAll">Select All</div>
	<div class="buttonReload" id="reloadData"></div>
	<div class="buttonFind" id="findData"></div>
	<div class="pagingLinks"><?php echo $links;?></div>
</div>
<table cellpadding="0" cellspacing="0" border="0" class="tblListData">
	<thead>
        <tr>
            <th style="width:30px">No.</th>
            <th style="width:50px">Kode</th>
            <th>Diagnosa</th>
            <th>Kata Kunci</th>
        </tr>
	</thead>
	<tbody id="tbodySearchResult">
	<?php if(empty($list)) :?>
		<tr>
			<td colspan="5" style="text-align:center;font-style:italic"><?php echo $this->lang->line('msg_data_not_found');?></td>
		</tr>
	<?php else :?>
		<?php for($i=0;$i<sizeof($list);$i++) :?>
		<?php if($list[$i]['category'] != $list[$i-1]['category']) :?>
			<tr class="notSelected">
				<td colspan="4" style="background:#F9F9F9;"><b><?php echo $list[$i]['category'];?></b></td>
			</tr>
		<?php endif;?>
		<tr class="notSelected">
			<td>
                <?php echo $list[$i]['id'];?>
                <input type="checkbox" class="checkbox_delete" name="delete_id[]" id="delete_id_<?php echo $list[$i]['id'];?>" value="<?php echo $list[$i]['id'];?>" />
            </td>
			<td ondblclick="get_data_by_id('<?php echo $list[$i]['id'];?>')"><?php echo $list[$i]['code'];?></td>
			<td ondblclick="get_data_by_id('<?php echo $list[$i]['id'];?>')"><?php echo $list[$i]['name'];?></td>
			<td ondblclick="get_data_by_id('<?php echo $list[$i]['id'];?>')"><?php echo $list[$i]['kata_kunci'];?></td>
		</tr>
		<?php endfor;?>
	<?php endif;?>
	</tbody>
</table>
