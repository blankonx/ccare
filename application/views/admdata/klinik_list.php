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
            <th style="width:50px">Kode</th>
	    <th style="width:50px">Kode Wilayah</th>
            <th style="width:250px">Nama Klinik</th>
	    <th>Alamat</th>
        </tr>
	</thead>
	<tbody id="tbodySearchResult">
	<?php if(empty($list)) :?>
		<tr>
		<td colspan="2" style="text-align:center;font-style:italic"><?php echo $this->lang->line('msg_data_not_found');?></td>
		</tr>
	<?php else :?>
		<?php for($i=0;$i<sizeof($list);$i++) :?>
		<tr class="notSelected">
			<td>
                <?php echo $list[$i]['code'];?>
                <input type="checkbox" class="checkbox_delete" name="delete_id[]" id="delete_id_<?php echo $list[$i]['code'];?>" value="<?php echo $list[$i]['code'];?>" />
            </td>
			<td ondblclick="get_data_by_id('<?php echo $list[$i]['code'];?>')" id="sub_district_id_<?php echo $list[$i]['code'];?>"><?php echo $list[$i]['sub_district_id'];?></td>
			<td ondblclick="get_data_by_id('<?php echo $list[$i]['code'];?>')" id="name_<?php echo $list[$i]['code'];?>"><?php echo $list[$i]['name'];?></td>
			<td ondblclick="get_data_by_id('<?php echo $list[$i]['code'];?>')" id="address_<?php echo $list[$i]['code'];?>"><?php echo $list[$i]['address'];?></td>
		</tr>
		<?php endfor;?>
	<?php endif;?>
	</tbody>
</table>
