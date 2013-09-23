<script language="JavaScript" type="text/javascript">
function activateThis(obj) {
	var active;
	if(obj.checked == true) {
		active='yes';
	} else {
		active='no';
	}
	$.ajax({
		url:'../admdata/clinic/update_active',
		type: 'POST',
		data: 'id=' + obj.value + '&active=' + active,
		dataType: 'json',
		success:function(data) {
			show_message('#message', data.msg, data.status);
		}
	});
}

function hideThis(obj) {
	var visible;
	if(obj.checked == true) {
		visible='yes';
	} else {
		visible='no';
	}
	$.ajax({
		url:'../admdata/clinic/update_visible',
		type: 'POST',
		data: 'id=' + obj.value + '&visible=' + visible,
		dataType: 'json',
		success:function(data) {
			show_message('#message', data.msg, data.status);
		}
	});
}
$(document).ready(function() {
//DEFINE THE SHORTCUT
    $(document).bind('keydown', 'Ctrl+f', function(evt){
        $("#div_search").slideDown("fast", function(){$('#search_name').focus()});return false;
    });
    
    $(document).bind('keydown', 'esc', function(evt){
        $("#div_search").slideUp("fast", function(){$('#name').focus()});return false;
    });
    
    $('#closeSmallSearch').click(function(){
        $("#div_search").slideUp("fast", function(){$('#name').focus()});return false;
    });
    
    $('#addData').click(function() {$('#frmData').slideDown('fast');$('#name').focus();});
    $('#findData').click(function() {$('#div_search').slideDown('fast');$('#search_name').focus();});

	//show form add
    $(document).bind('keydown', 'Ctrl+n', function(evt){
        $("#div_search").slideUp("fast");
		$('#frmData').slideDown('fast');
		$('#name').focus();
		return false;
    });

//get List Data
	function getList() {
		$('#divSearchResult').load("<?php echo site_url('admdata/clinic_list/result');?>" + "/" + $('#current_page').val(),prepareList);return false;
	}
//ajaxing search form
    $('#frmSearch').submit(function() {
		$('#reloadData').ajaxStart(function(){$(this).removeClass().addClass('buttonReloadIsLoad');});
		$('#reloadData').ajaxStop(function(){$(this).removeClass().addClass('buttonReload');});

        $('#frmSearch').ajaxSubmit({
		    type: 'POST',
            target: '#divSearchResult',
			success:function() {
				prepareList();
			}
        });
        return false;
    });

//ajaxing add data
	var validator = $("#frmData").validate({
		rules: {
            name: "required",
            active: "required",
            visible: "required"
		},
        submitHandler:
            function(form) {
				$('#reloadData').ajaxStart(function(){$(this).removeClass().addClass('buttonReloadIsLoad');});
				$('#reloadData').ajaxStop(function(){$(this).removeClass().addClass('buttonReload');});
                $(form).ajaxSubmit({
					dataType: 'json',
					clearForm:true,
                    success:function(data) {
                        show_message('#message', data.msg, data.status);
						if(data.status == 'success') getList();
						$("#name").focus();
                    }
                });
            }
	});

	function confirmDelete(formData, jqForm, opt) {
		var v = $('.checkbox_delete').fieldValue();
		if(v == 0 || v == 'undefined') {alert('Choose min 1 data!');return false;}
		return confirm('Delete '+ v.length +' data?');
	}

	var allIsChecked = false;
	function prepareList() {
		$('#debug').html('start');
		$('.pagingLinks a').click(function(e) {
			$('#reloadData').ajaxStart(function(){$(this).removeClass().addClass('buttonReloadIsLoad');});
			$('#reloadData').ajaxStop(function(){$(this).removeClass().addClass('buttonReload');});
            $('#divSearchResult').load(this.href,prepareList);return false;
        });

		// select or unselect
		$('#tbodySearchResult tr').click(function(){
			var checkbox = $(this).children().eq(0).children();
			if(checkbox.attr('type') == 'checkbox') {
				if(checkbox.attr('checked') == false) {
					checkbox.attr('checked', true);
					$(this).removeClass().addClass('selected');
				} else {
					checkbox.attr('checked', false);
					$(this).removeClass().addClass('notSelected');
				}
			}
		});

		$("#selectAll").click(function() {
			if (allIsChecked == false) {
				$(this).removeClass('buttonSelectAll').addClass('buttonDeselectAll').html('Deselect All');
				$("#tbodySearchResult .checkbox_delete").attr("checked", true);
				$('#tbodySearchResult tr.notSelected').removeClass().addClass('selected');
				allIsChecked = true;
			}
			else {
				$(this).removeClass('buttonDeselectAll').addClass('buttonSelectAll').html('Select All');
				$("#tbodySearchResult .checkbox_delete").attr("checked", false);
				$('#tbodySearchResult tr.selected').removeClass().addClass('notSelected');
				allIsChecked = false;
			}
		});
		$(document).bind('keydown', 'Ctrl+a', function(evt){
			$("#selectAll").click();return false;
		});

		$('#reloadData').click(getList);
        $('#addData').click(function() {$('#frmData').slideDown('fast');$('#name').focus();});
        $('#findData').click(function() {$('#div_search').slideDown('fast');$('#search_name').focus();});

		$('#deleteList').click(function() {
			$('#reloadData').ajaxStart(function(){$(this).removeClass().addClass('buttonReloadIsLoad');});
			$('#reloadData').ajaxStop(function(){$(this).removeClass().addClass('buttonReload');});
			$('#frmList').ajaxSubmit({
				beforeSubmit:confirmDelete,
				type: 'POST',
				dataType: 'json',
				success:function(data) {
					show_message('#message', data.msg, data.status);
					if(data.status == 'success') {getList();}
					else $("#name").focus();
				}
			});
			return false;
		});
		$('#debug').html('end');
	}

	//checkall

	$('#reset').click(getList);
	getList();
    $('#name').focus();
});


</script>

<div class="smallSearchContainer" id="div_search" style="display:none;left:498px;top:0">
	<div class="closeSmallSearch" id="closeSmallSearch"></div>
	<div class="smallSearch">
	<form method="POST" name="frmSearch" id="frmSearch" action="<?php echo site_url('admdata/clinic_list');?>">
		<input type="text" name="search_name" id="search_name" value="" size="25" />
	</form>
	</div>
</div>

<div class="ui-dialog" style="width:100%;margin-right:5px;height:auto;float:left;">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar"><?php echo $title;?></div>
		<div class="ui-dialog-content">
            <div id="message" style="display:none"></div>
			<form method="POST" name="frmData" id="frmData" style="display:none" action="<?php echo site_url('admdata/clinic/process_form');?>">
			<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
				<tr>
					<td style="width:150px"><?php echo $this->lang->line('label_name');?></td>
					<td><input type="text" name="name" id="name" value="" size="30" onkeypress="focusNext('parent_id', 'parent_id', this, event)" /></td>
				</tr>
				<tr>
					<td>Kelompok</td>
					<td>
					<select id="parent_id" name="parent_id" onkeypress="focusNext( 'active', 'active', this, event)" style="width:200px;background:#FFFFFF;">
						<option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
							<?php $k=0; for($i=0;$i<sizeof($combo_clinic);$i++) :?>
							<?php if($combo_clinic[$i]['id'] == $combo_clinic[$i+1]['parent_id']) :
								$k = $combo_clinic[$i]['id'];
								echo '<optgroup label="'.$combo_clinic[$i]['name'].'">';
							elseif($k != $combo_clinic[$i]['parent_id']) : ?>
								</optgroup>
								<option value="<?php echo $combo_clinic[$i]['id']?>"><?php echo $combo_clinic[$i]['name']?></option>
							<?php else:?>
								<option value="<?php echo $combo_clinic[$i]['id']?>"><?php echo $combo_clinic[$i]['name']?></option>
							<?php endif;?>
							<?php endfor;?>
					</select>
					<em>Pilih jika memiliki kelompok. Misalnya Kelompok Pustu. Jika tidak memiliki kelompok, jangan dipilih.</em>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<label for="active"><input type="checkbox" name="active" id="active" value="yes" onkeypress="focusNext('visible', 'parent_id', this, event)" checked="checked" /><?php echo $this->lang->line('label_active');?></label>
					</td>
				</tr>
				<tr>
					<td></td>
					<td>
						<label for="visible"><input type="checkbox" name="visible" id="visible" value="yes" onkeypress="focusNext('submit', 'active', this, event)" checked="checked" /><?php echo $this->lang->line('label_visible');?></label>
					</td>
				</tr>
				<tr>
					<td></td><td>
					<input type="submit" name="Search" id="submit" value="Simpan" /><input type="reset" name="Reset" id="reset" value="Batal" />
					</td>
				</tr>
			</table>
			</form>

			<form method="POST" name="frmList" id="frmList" action="<?php echo site_url('admdata/clinic/delete_list');?>">
			<div id="divSearchResult">
			<input type="hidden" name="current_page" id="current_page" value="0" />
                <div class="pagingContainer">
                    <div class="buttonAdd buttonPaging" id="addData">Add</div>
                    <div class="buttonDelete buttonPaging" id="deleteList">Delete</div>
                    <div class="buttonReload" id="reloadData"></div>
	                <div class="buttonFind" id="findData"></div>
                    <div class="pagingLinks"><?php echo $links;?></div>
                </div>
				<table cellpadding="0" cellspacing="0" border="0" class="tblListData">
					<thead>
						<tr>
							<th style="width:20px">No.</th>
							<th><?php echo $this->lang->line('label_clinic');?></th>
							<th style="width:70px"><?php echo $this->lang->line('label_active');?></th>
							<th style="width:70px"><?php echo $this->lang->line('label_visible');?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="4" style="text-align:center;font-style:italic"><?php echo $this->lang->line('msg_no_data');?></td>
						</tr>
					</tbody>
				</table>
			</div>
			</form>
		</div><!-- 
        <div class="ui-dialog-buttonpane">
		
        </div> -->
	</div>
</div>
