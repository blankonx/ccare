<table cellpadding="0" cellspacing="0" border="0" class="tblNote" style="width:100%;">
	<tr>
		<td style="width:120px;"><?php echo $this->lang->line('label_mr_number');?></td>
		<td><?php echo $data['mr_number']?></td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('label_name');?></td>
		<td><?php echo $data['name']?></td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('label_parent');?></td>
		<td><?php echo $data['parent_name']?></td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('label_place_date_of_birth');?></td>
		<td><?php echo $data['birth_place']?>, <?php echo $data['birth_date']?></td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('label_age');?></td>
		<td><?php echo $data['age']['year']?>yr&nbsp;&nbsp;<?php echo $data['age']['month']?>mo&nbsp;&nbsp;<?php echo $data['age']['day']?>dy&nbsp;&nbsp;</td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('label_sex');?></td>
		<td><?php echo $data['sex']?></td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('label_address');?></td>
		<td><?php echo $data['address']?></td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('label_education');?></td>
		<td><?php echo $data['education_name']?></td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('label_job');?></td>
		<td><?php echo $data['job_name']?></td>
	</tr>
</table>
