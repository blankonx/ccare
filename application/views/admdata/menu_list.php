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
            <th style="width:200px">Nama</th>
            <th>URL</th>
            <th style="width:20px;text-align:center;">&uarr;</th>
            <th style="width:20px;text-align:center;">&darr;</th>
        </tr>
	</thead>
	<tbody id="tbodySearchResult">
	<?php if(empty($list)) :?>
		<tr>
			<td colspan="5" style="text-align:center;font-style:italic"><?php echo $this->lang->line('msg_data_not_found');?></td>
		</tr>
	<?php else : //print_r($list);?>
        <?php echo $list;?>
    <?php endif;?>
	</tbody>
</table>
