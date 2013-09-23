<script language="JavaScript" type="text/javascript">

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
    $('#addData').click(function() {
			$('#frmInput').slideDown('fast');
			$('#reset').click();
	});
    $('#findData').click(function() {$('#div_search').slideDown('fast');$('#search_name').focus();});
//show form add
    $(document).bind('keydown', 'Ctrl+n', function(evt){
        $("#div_search").slideUp("fast");
			$('#reset').click();
			$('#frmInput').slideDown('fast');
		return false;
    });

//get List Data
	function getList() {
		$('#divSearchResult').load("<?php echo site_url('admdata/user_list/result/_');?>" + "/" + $('#current_page').val(),prepareList);return false;
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
    //var errContainer = $('#errMessage');
	var validator = $("#frmInput").validate({
        //errorContainer : errContainer,
		rules: {
            pwd2: {
                checkPassword:true
            }
		},
        submitHandler:
            function(form) {
				$('#reloadData').ajaxStart(function(){$(this).removeClass().addClass('buttonReloadIsLoad');});
				$('#reloadData').ajaxStop(function(){$(this).removeClass().addClass('buttonReload');});
                $(form).ajaxSubmit({
					dataType: 'json',
                    success:function(data) {
                        show_message('#message', data.msg, data.status);
						if(data.status == 'success') {
							getList();
							$('#reset').click();
						}
						else $("#name").focus();
                    }
                });
            }
	});

    $.validator.addMethod("checkPassword", function(value, element) {
        if($('#id').val()) {
            //edit data, password tidak wajib
            if(!$('#pwd').val() && !$('#pwd2').val()) return true;
            else if($('#pwd').val() && $('#pwd2').val() && $('#pwd').val() == $('#pwd2').val()) return true
            else return false;
        } else {
            //add data
            if(!$('#pwd').val() || !$('#pwd2').val() || $('#pwd').val() != $('#pwd2').val()) return false;
            else return true;
        }
    }, "Check your password");

	function confirmDelete(formData, jqForm, opt) {
		var v = $('.checkbox_delete').fieldValue();
		if(v == 0 || v == 'undefined') {alert('Choose min 1 data!');return false;}
		return confirm('Delete '+ v.length +' data?');
	}

	var allIsChecked = false;
	function prepareList() {
		$('.pagingLinks a').click(function() {
			$('#reloadData').ajaxStart(function(){$(this).removeClass().addClass('buttonReloadIsLoad');});
			$('#reloadData').ajaxStop(function(){$(this).removeClass().addClass('buttonReload');});
            $('#divSearchResult').load(this.href,prepareList);return false;
        });

		// select or unselect
		$('#tbodySearchResult tr').click(function(){
			//var checkbox = $(this).children().eq(1).children();
			var checkbox = $(this).children().eq(0).children();
			if(checkbox.attr('checked') == false) {
				checkbox.attr('checked', true);
				$(this).removeClass().addClass('selected');
			} else {
				checkbox.attr('checked', false);
				$(this).removeClass().addClass('notSelected');
			}
		});

		$("#selectAll").click(function() {
			if (allIsChecked == false) {
				$(this).removeClass('buttonSelectAll').addClass('buttonDeselectAll').html('Deselect All');
				$("#tbodySearchResult .checkbox_delete").attr("checked", true);
				$('#tbodySearchResult tr').removeClass().addClass('selected');
				allIsChecked = true;
			}
			else {
				$(this).removeClass('buttonDeselectAll').addClass('buttonSelectAll').html('Select All');
				$("#tbodySearchResult .checkbox_delete").attr("checked", false);
				$('#tbodySearchResult tr').removeClass().addClass('notSelected');
				allIsChecked = false;
			}
		});
		$(document).bind('keydown', 'Ctrl+a', function(evt){$("#selectAll").click();return false;});

		$('#reloadData').click(getList);
		
		$('#addData').click(function() {
			$('#frmInput').slideDown('fast');
			$('#reset').click();
			
		});
        //$('#addData').click(function() {$('#frmInput').slideDown('fast');$('#name').focus();});
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
	}
	
	$('#group_id').change(function() {
	    var val = $(this).val();
	    if(val == '3') {
	        $('#tr_pelayanan').css('display', '');
        } else {
            $('#tr_pelayanan').css('display', 'none');
        }
    });

	//checkall

	$('#reset').click( function() {getList();$('#preview_table').slideUp('fast');$('#frmInput').clearForm();$('#id').val('');$('#name').focus();});
	$('#frmSearch').resetForm();
	$('#frmSearch').submit();
    $('#name').focus();
});


function get_data_by_id(idx) {
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "user/get_data_by_id",
		data: "id="+idx,
		success: function(jsonData) {
			$('#id').val(jsonData.id);
			$('#name').val(jsonData.name);
			$('#username').val(jsonData.username);
			$('#group_id').val(jsonData.group_id);
			if(jsonData.group_id == '3') {
	            $('#tr_pelayanan').css('display', '');
			   
            } else {
                $('#tr_pelayanan').css('display', 'none');
            }
			$('#frmInput').slideDown('fast', function() {
				$('#name').focus();
			});
		}
	});
} 

</script>
<div class="smallSearchContainer" id="div_search" style="display:none;left:287px;top:0">
	<div class="closeSmallSearch" id="closeSmallSearch"></div>
	<div class="smallSearch">
	<form method="POST" name="frmSearch" id="frmSearch" action="<?php echo site_url('admdata/user_list');?>">
		<input type="text" name="search_name" id="search_name" value="" size="25"  />
	</form>
	</div>
</div>

<div id="divFormInputContainer" style="display:none"></div>

<div class="ui-dialog" style="width:100%;margin-right:5px;height:auto;float:left;">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar">Data Pengguna</div>
		<div class="ui-dialog-content">
            <div id="message" style="display:none"></div>
            <!-- <div id="errMessage" style="display:none" class="error">Terdapat kesalahan/ kekurangan pada pengisian form. Silakan lengkapi isian.</div> -->

		<form method="POST" name="frmInput" id="frmInput" style="display:none" action="<?php echo site_url('admdata/user/process_form')?>">
		<input type="hidden" name="id" id="id" value="" />
		<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
			<tr>
				<td style="width:120px"><?php echo $this->lang->line('label_name');?></td>
				<td>
					<input type="text" name="name" id="name" size="30" class="required" />
				</td>
			</tr>
			<tr>
				<td style="width:120px">Email</td>
				<td>
					<input type="text" name="email" id="email" size="50" />
				</td>
			</tr>
			<tr>
				<td><?php echo $this->lang->line('label_username');?></td>
				<td>
					<input type="text" name="username" id="username" size="30" class="required" />
				</td>
			</tr>
			<tr>
				<td><?php echo $this->lang->line('label_pwd');?></td>
				<td>
					<input type="password" name="pwd" id="pwd" size="20" />
				</td>
			</tr>
			<tr>
				<td>Ulangi Password</td>
				<td>
					<input type="password" name="pwd2" id="pwd2" size="20" />
				</td>
			</tr>
			<tr>
				<td>Group</td>
				<td>
                    <select name="group_id" id="group_id" class="required" style="width:220px">
                    <option value="">-- PILIH --</option>
                    <?php for($i=0;$i<sizeof($group);$i++) :?>
                        <option value="<?php echo $group[$i]['id']?>"><?php echo $group[$i]['name']?></option>
                    <?php endfor;?>
                    </select>
				</td>
			</tr>
			
			<tr>
				<td></td>
				<td>
					<input type="submit" name="Simpan" id="simpan" value="Simpan" />
					<input type="reset" name="Reset" id="reset" value="Reset" />
				</td>
			</tr>
		</table>
		</form>
			<form method="POST" name="frmList" id="frmList" action="<?php echo site_url('admdata/user/delete_list');?>">
			<div id="divSearchResult">
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
                            <th style="width:200px">Nama</th>
                            <th style="width:200px">Username</th>
                            <th>Group</th>
                            <th>Pelayanan</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="5" style="text-align:center;font-style:italic"><?php echo $this->lang->line('msg_no_data');?></td>
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
