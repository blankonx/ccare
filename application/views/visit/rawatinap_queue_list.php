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
			<th style="width:20px">No.</th>
			<th style="width:50px">Masuk</th>			
			<th style="width:80px"><?php echo $this->lang->line('label_mr_number');?></th>
			<th><?php echo $this->lang->line('label_name');?></th>
            <th style="width:70px">Pemeriksaan Terakhir</th>
            <th style="width:70px"><?php echo $this->lang->line('label_sex');?></th>
            <th style="width:40px"><?php echo $this->lang->line('label_age');?></th>
			<th style="width:70px"><?php echo $this->lang->line('label_action');?></th>
        </tr>
	</thead>
	<tbody id="tbodySearchResult">
	<?php if(empty($list)) :?>
		<tr>
			<td colspan="8" style="text-align:center;font-style:italic"><?php echo $this->lang->line('msg_data_not_found');?></td>
		</tr>
	<?php else :?>
		<?php for($i=0;$i<sizeof($list);$i++) :?>
		<?php if($list[$i]['clinic_id'] != $list[$i-1]['clinic_id']) :?>
			<tr class="notSelected">
				<td colspan="8" style="background:#F9F9F9;"><b><?php echo $list[$i]['clinic_name'];?></b></td>
			</tr>
		<?php endif;?>
		<tr class="notSelected" id="<?php echo $list[$i]['id'] . '/' . $list[$i]['vicid'];?>">
			<td>
				<?php echo (++$start);?><input type="checkbox" class="checkbox_delete" name="delete_id[]" id="delete_id_<?php echo $list[$i]['id'];?>" value="<?php echo $list[$i]['id'];?>" />
			</td>
			<td id="time_<?php echo $list[$i]['id'];?>"><?php echo $list[$i]['time'];?></td>			
			<td id="mr_no_<?php echo $list[$i]['id'];?>"><?php echo $list[$i]['mr_number'];?></td>
			<td id="name_<?php echo $list[$i]['id'];?>"><b><?php echo $list[$i]['patient_name'];?></b></td>
			<td id="parent_<?php echo $list[$i]['id'];?>"><?php echo $list[$i]['latest_served_date'];?></td>
			<td id="parent_<?php echo $list[$i]['id'];?>"><?php echo $list[$i]['patient_sex'];?></td>
            <?php
                //counting the age
                //print_r($list);
                $age = getOneAge($list[$i]['birth_date_for_age'], $list[$i]['visit_date_for_age']);
            ?>
			<td id="parent_<?php echo $list[$i]['id'];?>" style="text-align:right">
                <?php echo $age; ?>
            </td>
			<td>
				<a class="detail_link" id="detail_<?php echo $list[$i]['id'];?>" title="Detail Pasien" href="<?php echo site_url('visit/patient_detail/result/' . $list[$i]['id']);?>">
					<img alt="Detail Pasien" src="<?php echo base_url();?>webroot/media/images/user.png">
				</a>&nbsp;
				<a class="checkup_link" id="checkup_<?php echo $list[$i]['id'];?>" title="Pemeriksaan Pasien" href="<?php echo site_url('visit/rawatinap_checkup/result/' . $list[$i]['id'] . '/' . $list[$i]['vicid']);?>">
					<img alt="Pemeriksaan Pasien" src="<?php echo base_url();?>webroot/media/images/add2.png">
				</a>&nbsp;
				<a class="checkout_link" id="checkout_<?php echo $list[$i]['id'];?>" title="Pemulangan Pasien" href="<?php echo site_url('visit/rawatinap_checkout/result/' . $list[$i]['id'] . '/' . $list[$i]['vicid']);?>">
					<img alt="Pemulangan Pasien" src="<?php echo base_url();?>webroot/media/images/keluar.png">
				</a>
			</td>
		</tr>
		<?php endfor;?>
	<?php endif;?>
	</tbody>
</table>
<div class="pagingContainerBottom">
	<div class="pagingLinks"><?php echo $links;?></div>
</div>
