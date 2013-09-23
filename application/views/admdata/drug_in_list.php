<input type="hidden" name="current_page" id="current_page" value="<?php echo $current_page;?>" />
<div class="pagingContainer">
	<div class="buttonDelete buttonPaging" id="deleteList">Delete</div>
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
            <th>Obat</th>
            <th style="width:70px">Jumlah</th>
            <th style="width:70px">Stock Awal</th>
            <th style="width:70px">Stock Akhir</th>
            <th style="width:70px">Stock Skr</th>
            <th style="width:70px">Satuan</th>
        </tr>
	</thead>
	<tbody id="tbodySearchResult">
	<?php if(empty($list)) :?>
		<tr>
			<td colspan="8" style="text-align:center;font-style:italic"><?php echo $this->lang->line('msg_data_not_found');?></td>
		</tr>
	<?php else : $j=0;?>
		<?php for($i=0;$i<sizeof($list);$i++) :?>
		<?php if($list[$i]['id'] != $list[$i-1]['id']) : $j=0;?>
			<tr class="notSelected">
				<td colspan="8" style="background:#F9F9F9;">
					<input type="checkbox" class="checkbox_delete" name="delete_id[]" id="delete_id_<?php echo $list[$i]['id'];?>" value="<?php echo $list[$i]['id'];?>" />
					<b><?php echo $list[$i]['date'] . ' &mdash; <em>' . $list[$i]['explanation'] . '</em>';?></b>
				</td>
			</tr>
		<?php endif;?>
		<tr class="notSelected">
			<td>
                <?php echo ++$j;?>
                <input type="checkbox" class="checkbox_delete" name="delete_detail_id[]" id="delete_detail_id_<?php echo $list[$i]['detail_id'];?>" value="<?php echo $list[$i]['detail_id'];?>" />
            </td>
			<td><?php echo $list[$i]['code'];?></td>
			<td><?php echo $list[$i]['name'];?></td>
			<td style="text-align:right"><?php echo $list[$i]['qty'];?></td>
			<td style="text-align:right"><?php echo $list[$i]['stock_before_insert'];?></td>
			<td style="text-align:right"><?php echo $list[$i]['stock_after_insert'];?></td>
			<td style="text-align:right"><?php echo $list[$i]['stock'];?></td>
			<td><?php echo $list[$i]['unit'];?></td>
		</tr>
		<?php endfor;?>
	<?php endif;?>
	</tbody>
</table>
