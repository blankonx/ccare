<script language="javascript">
$(document).ready(function() {
    //make the tabs
    var $tabs = $('#tabs > ul').tabs({
        spinner:'', 
        remote:true, 
        hide:function() {
            //alert('hide');
        },
        show:function() {
            //alert('showed ; ');
        }
    });
    //menampilkan alergi
    //cek alerginya berdasar patient_id
    $('#alergi_patient_id').val(<?php echo $data['patient_id'];?>);
    $('#alergi_family_folder').val(<?php echo $data['family_folder'];?>);
    $('#alergi_family_relationship_id').val(<?php echo $data['family_relationship_id'];?>);
    $.ajax({
		url:'<?php echo site_url('home/alergi_get/' . $data['patient_id']);?>',
		success:function(data) {
			if(data != '<ol></ol>') {
				//punya alergi, tampilin semua
				$('#alergi_msg_box').html(data);
				$('#alergi_msg_box').show();
				$('#alergiForm').show();
				$('#alergi_msg').focus();
				$('#alergi_container').slideDown();
				$('.alergi_delete_button').click(function(e) {
					var xurl = this.href;
					var obj = $(this).parent();
					e.preventDefault();
					$.ajax({
						url:xurl,
						success:function() {
							obj.remove();
						}
					});
				});
			} else {
				//tidak punya alergi
				$('#alergi_container').slideDown();
				$('#alergi_msg_box').hide();
				$('#alergiForm').hide();
			}
		}
	});
});
</script>
<table cellpadding="0" cellspacing="0" border="0" class="tblNote" style="width:100%;">
	<tr>
		<td style="width:100px;"><?php echo $this->lang->line('label_mr_number');?></td>
		<td style="width:150px;color:#00A7D4"><div id="_mr_number_"><?php echo $data['mr_number']?></div></td>
		<td style="width:150px;">NIK/No. RM Lama</td>
		<td style="width:400px;color:#00A7D4"><?php echo $data['nik']?></td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('label_name');?></td>
		<td style="color:#00A7D4"><b><div id="_patient_name_"><?php echo $data['name']?></div></b></td>
		<td><?php echo $this->lang->line('label_sex');?></td>
		<td style="color:#00A7D4"><?php echo $data['sex']?> (<?php echo getOneAge($data['birth_date_for_age'], $data['visit_date_for_age'])?>)</td>
	</tr>
	<tr>
		<td><?php echo $this->lang->line('label_parent');?></td>
		<td style="color:#00A7D4"><?php echo $data['parent_name']?></td>
		<td>Jenis Pasien</td>
		<td style="color:#00A7D4"><?php echo $data['payment_type']?></td>
	</tr>
	<tr>
		<td></td>
		<td style="color:#00A7D4"></td>
		<td><?php echo $this->lang->line('label_address');?></td>
		<td style="color:#00A7D4"><?php echo $data['address']?></td>
        <td style="text-align:right;font-weight:bold;">
            <?php echo $this->lang->line('label_hello');?> <span style="color:#00A7D4"><?php echo $this->session->userdata('name');?>
        </td>
	</tr>
	<tr>
		<td>Tgl. Kunjungan</td>
		<td style="color:#00A7D4"><?php echo $data['visit_date_formatted']?></td>
		<td><?php echo $this->lang->line('label_number_of_visit');?></td>
		<td style="color:#00A7D4"><b><?php echo $data['visit_count']?></b></td>
        <td style="text-align:right;"><input type="checkbox" name="showHideLog" id="showHideLog" value="1" /><label for="showHideLog" id="showHideLogLabel">Show Hide Logs</label></td>
	</tr>
</table>
<br />
<div id="tabs">
<ul>
<?php for($i=0;$i<sizeof($module);$i++) : ?>
    <li class="ui-tabs-nav-item">
        <a title="<?php echo $module[$i]['filename']?>" id="<?php echo 'button-' . $i?>" href="<?php echo $module[$i]['path']?>"><?php echo $module[$i]['name']?></a>
    </li>
<?php endfor;?>
</ul>

<?php for($i=0;$i<sizeof($module);$i++) : ?>
    <div id="<?php echo $module[$i]['filename']?>">
        <div class="divLoading"></div>
    </div>
<?php endfor;?>
    
</div>
