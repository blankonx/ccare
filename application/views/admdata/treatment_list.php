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
            <th><?php echo $this->lang->line('label_treatment');?></th>
            <?php for($i=0;$i<sizeof($payment_type);$i++) :?>
            <th style="width:120px;"><?php echo $payment_type[$i]['name'];?></th>
            <?php endfor;?>
        </tr>
	</thead>
	<tbody id="tbodySearchResult">
	<?php if(empty($list)) :?>
		<tr>
			<td colspan="14" style="text-align:center;font-style:italic"><?php echo $this->lang->line('msg_data_not_found');?></td>
		</tr>
	<?php else :?>
		<?php for($i=0;$i<sizeof($list);$i++) :?>
		<?php if($list[$i]['category_id'] != $list[$i-1]['category_id']) :?>
			<tr class="notSelected">
				<td colspan="14" style="background:#F9F9F9;"><b><?php echo $list[$i]['category'];?></b></td>
			</tr>
		<?php endif;?>
		<tr class="notSelected">
			<td><?php echo (++$start);?><input type="checkbox" class="checkbox_delete" name="delete_id[]" id="delete_id_<?php echo $list[$i]['id'];?>" value="<?php echo $list[$i]['id'];?>" /></td>
			<td ondblclick="get_data_by_id('<?php echo $list[$i]['id'];?>')"><?php echo $list[$i]['name'];?></td>
            <?php 
            $arr_name = explode("|", $list[$i]['price']);
            for($j=0;$j<sizeof($arr_name);$j++) : ?>
			<td ondblclick="get_data_by_id('<?php echo $list[$i]['id'];?>')"><?php echo uangIndo($arr_name[$j]);?></td>
            <?php endfor;?>
		</tr>
		<?php endfor;?>
	<?php endif;?>
	</tbody>
</table>
