<div class="pagingContainer"><div class="pagingLinks"><?php echo $links;?></div></div>
<table cellpadding="0" cellspacing="0" border="0" class="tblListData">
	<thead>
		<tr>
			<th style="width:30px;">No.</th>
			<th style="width:90px;"><?php echo $this->lang->line('label_mr_number');?></th>
			<th style="width:170px;"><?php echo $this->lang->line('label_name');?></th>
			<th style="width:70px;"><?php echo $this->lang->line('label_sex');?></th>
			<th style="width:100px;"><?php echo $this->lang->line('label_date_of_birth');?></th>
			<th><?php echo $this->lang->line('label_address');?></th>
			<th style="width:50px;">Hapus</th>
		</tr>
	</thead>
	<tbody id="tbodySearchResult">
	<?php if(empty($list)) :?>
		<tr>
			<td colspan="6" style="text-align:center;font-style:italic"><?php echo $this->lang->line('msg_data_not_found');?></td>
		</tr>
	<?php else :?>
		<?php for($i=0;$i<sizeof($list);$i++) :?>
		<tr>
			<td onclick="get_patient_from_patient_search('<?php echo $list[$i]['family_folder']?>')"><?php echo (++$start);?></td>
			<td onclick="get_patient_from_patient_search('<?php echo $list[$i]['family_folder']?>')"><?php echo $list[$i]['mr_number'];?></td>
			
			<td onclick="get_patient_from_patient_search('<?php echo $list[$i]['family_folder']?>')"><?php echo $list[$i]['name'];?></td>
			<td onclick="get_patient_from_patient_search('<?php echo $list[$i]['family_folder']?>')"><?php echo $list[$i]['sex'];?></td>
			
					
			<td onclick="get_patient_from_patient_search('<?php echo $list[$i]['family_folder']?>')"><?php echo $list[$i]['birth_place'] . ', ' . $list[$i]['birth_date'];?></td>
			
			<td onclick="get_patient_from_patient_search('<?php echo $list[$i]['family_folder']?>')"><?php echo $list[$i]['address'];?></td>
			
			<td>
				<a href="javascript:void(0)" onclick="confirmDelete('<?php echo site_url("admdata/patient/delete/" . $list[$i]['family_folder']);?>');" title="Delete" style="display:block"><img src="<?php echo base_url();?>webroot/media/images/delete.png"></a>
			</td>
		</tr>
		<?php endfor;?>
	<?php endif;?>
	</tbody>
</table>
