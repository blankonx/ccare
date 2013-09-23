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
			<th style="width:50px"><?php echo $this->lang->line('label_time');?></th>			
			<th style="width:80px"><?php echo $this->lang->line('label_mr_number');?></th>
			<th><?php echo $this->lang->line('label_name');?></th>
            <th style="width:100px">Biaya</th>
            <th style="width:100px">Jenis Pasien</th>
            <th style="width:70px"><?php echo $this->lang->line('label_sex');?></th>
            <th style="width:40px"><?php echo $this->lang->line('label_age');?></th>
			<th style="width:80px"><?php echo $this->lang->line('label_action');?></th>
        </tr>
	</thead>
	<tbody id="tbodySearchResult">
	<?php if(empty($list)) :?>
		<tr>
			<td colspan="9" style="text-align:center;font-style:italic"><?php echo $this->lang->line('msg_data_not_found');?></td>
		</tr>
	<?php else :?>
		<?php for($i=0;$i<sizeof($list);$i++) :?>
		<?php if($list[$i]['clinic_id'] != $list[$i-1]['clinic_id']) :?>
			<tr class="notSelected">
				<td colspan="9" style="background:#F9F9F9;"><b><?php echo $list[$i]['clinic_name'];?></b></td>
			</tr>
		<?php endif;?>
		<tr class="notSelected" id="<?php echo $list[$i]['id']?>">
			<td>
				<?php echo (++$start);?><input type="checkbox" class="checkbox_delete" name="delete_id[]" id="delete_id_<?php echo $list[$i]['id'];?>" value="<?php echo $list[$i]['id'];?>" />
			</td>
			<td><?php echo $list[$i]['time'];?></td>			
			<td><?php echo $list[$i]['mr_number'];?></td>
			<td><b><?php echo $list[$i]['patient_name'];?></b></td>
			<td style="text-align:right"><b><?php echo uangIndo($list[$i]['biaya']);?></b></td>
			<td><?php echo $list[$i]['payment_type'];?></td>
			<td><?php echo $list[$i]['patient_sex'];?></td>
            <?php
                //counting the age
                //print_r($list);
                $age = getOneAge($list[$i]['birth_date_for_age'], $list[$i]['visit_date_for_age']);
            ?>
			<td style="text-align:right"><?php echo $age; ?></td>
			<td>
				<a class="detail_link" id="detail_<?php echo $list[$i]['id'];?>" title="" href="<?php echo site_url('visit/patient_detail/result/' . $list[$i]['id']);?>">
					<img alt="" src="<?php echo base_url();?>webroot/media/images/user.png">
				</a>&nbsp;
                <a class="checkup_link" id="checkup_<?php echo $list[$i]['id'];?>" title="Edit Checkup" href="<?php echo site_url('kasir/checkup/result/' . $list[$i]['id']);?>">
                    <img alt="Edit Checkup" src="<?php echo base_url();?>webroot/media/images/check.png">
                </a>
				<?php if($list[$i]['payid']) :?>
				<a class="print_link" title="Cetak Kwitansi" href="javascript:void(0)" onclick="openPrintPopup('<?php echo site_url("kasir/general_checkup/printout/" . $list[$i]["id"]);?>')">
					<img alt="" src="<?php echo base_url();?>webroot/media/images/print16.png">
				</a>&nbsp;
				<?php endif;?>
			</td>
		</tr>
		<?php endfor;?>
	<?php endif;?>
	</tbody>
</table>
<div class="pagingContainerBottom">
	<div class="pagingLinks"><?php echo $links;?></div>
</div>
