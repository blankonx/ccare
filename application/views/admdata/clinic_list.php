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
			<th style="width:20px">No.</th>
			<th><?php echo $this->lang->line('label_name');?></th>
			<th style="width:50px"><?php echo $this->lang->line('label_active');?></th>
			<th style="width:50px"><?php echo $this->lang->line('label_visible');?></th>
        </tr>
	</thead>
	<tbody id="tbodySearchResult">
	<?php if(empty($list)) :?>
		<tr>
			<td colspan="4" style="text-align:center;font-style:italic"><?php echo $this->lang->line('msg_data_not_found');?></td>
		</tr>
	<?php else :?>
		<?php for($i=0;$i<sizeof($list);$i++) :?>
		<?php if($list[$i]['category_id'] == $list[$i]['id']) :?>
			<?php if($list[$i]['allow_to_change'] == 'yes') :?>
			<tr class="notSelected">
				<td><?php echo (++$start);?><input type="checkbox" class="checkbox_delete" name="delete_id[]" id="delete_id_<?php echo $list[$i]['id'];?>" value="<?php echo $list[$i]['id'];?>" /></td>
				<td class="list_name" id="name_<?php echo $list[$i]['id'];?>"><?php echo $list[$i]['name'];?></td>
				<td>
					<input type="checkbox" name="active" value="<?php echo $list[$i]['id'];?>" <?php if($list[$i]['active'] == 'yes') echo 'checked="checked"'; ?> onchange="activateThis(this);" />
				</td>
				<td>
					<input type="checkbox" name="active" value="<?php echo $list[$i]['id'];?>" <?php if($list[$i]['visible'] == 'yes') echo 'checked="checked"'; ?> onchange="hideThis(this);" />
				</td>
			</tr>
			<?php else :?>
			<tr>
				<td><?php echo (++$start);?></td>
				<td><?php echo $list[$i]['name'];?></td>
				<td><input type="checkbox" name="active" value="<?php echo $list[$i]['id'];?>" <?php if($list[$i]['active'] == 'yes') echo 'checked="checked"'; ?> onchange="activateThis(this);" /></td>
				<td><?php echo $list[$i]['visible'];?></td>
			</tr>
			<?php endif;?>
		<?php else:?>
			<?php if($list[$i]['allow_to_change'] == 'yes') :?>
			<tr class="notSelected">
				<td><?php echo (++$start);?><input type="checkbox" class="checkbox_delete" name="delete_id[]" id="delete_id_<?php echo $list[$i]['id'];?>" value="<?php echo $list[$i]['id'];?>" /></td>
				<td colspan="3" class="list_name" id="name_<?php echo $list[$i]['id'];?>" style="padding-left:20px;"><?php echo $list[$i]['name'];?></td>
			</tr>
			<?php else :?>
			<tr>
				<td><?php echo (++$start);?></td>
				<td colspan="3" style="padding-left:20px;"><?php echo $list[$i]['name'];?></td>
			</tr>
			<?php endif;?>
		<?php endif;?>
		<?php endfor;?>
	<?php endif;?>
	</tbody>
</table>