<script language="JavaScript" type="text/javascript">

$(document).ready(function() {
	$('.decimal').decimal();
    //DEFINE THE SHORTCUT
    $(document).bind('keydown', 'Ctrl+f', function(evt) {
		var ofs = $("#findData").offset();
		$("#div_search")
		.css('top', ofs.top)
		.css('left', ofs.left+20)
        .slideDown("fast", function() {
			$('#search_name').focus();
		});return false;
    });
    $(document).bind('keydown', 'esc', function(evt){
        $("#div_search").slideUp("fast", function(){$('#code').focus()});return false;
    });
    $('#closeSmallSearch').click(function(){
        $("#div_search").slideUp("fast", function(){$('#code').focus()});return false;
    });
//show form add
    $(document).bind('keydown', 'Ctrl+n', function(evt){
        $("#div_search").slideUp("fast");
			$('#reset').click();
			$('#frmInput').slideDown('fast');
		return false;
    });

//get List Data
	function getList() {
		$('#divSearchResult').load("<?php echo site_url('admdata/icd_list/result/_');?>" + "/" + $('#current_page').val(),prepareList);return false;
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
		},
        submitHandler:
            function(form) {
				$('#reloadData').ajaxStart(function(){$(this).removeClass().addClass('buttonReloadIsLoad');});
				$('#reloadData').ajaxStop(function(){$(this).removeClass().addClass('buttonReload');});
                $(form).ajaxSubmit({
					beforeSubmit:function() {
						disableForm();
						enableForm();
					},
					dataType: 'json',
                    success:function(data) {
                        show_message('#message', data.msg, data.status);
						if(data.status == 'success') {
							getList();
							$('#reset').click();
						}
						else $("#code").focus();
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
		$('#findData').click(function() {
			var ofs = $("#findData").offset();
			$("#div_search")
			.css('top', ofs.top)
			.css('left', ofs.left+20)
			.slideDown('fast');
			$('#search_name').focus();
		});

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

	$('#reset').click( function() {getList();$('#preview_table').slideUp('fast');$('#frmInput').clearForm();$('#id').val('');$('#code').focus();});
	$('#search_category').change(function() { $('#frmSearch').submit();});
	$('#frmSearch').resetForm();
	$('#frmSearch').submit();
    $('#code').focus();
});


function get_data_by_id(idx) {
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "icd/get_data_by_id",
		data: "id="+idx,
		success: function(jsonData) {
			$('#id').val(jsonData.id);
			$('#code').val(jsonData.code);
			$('#name').val(jsonData.name);
			$('#kata_kunci').val(jsonData.kata_kunci);
			$('#frmInput').slideDown('fast', function() {
				$('#kata_kunci').focus();
			});
		}
	});
} 

</script>
<div class="smallSearchContainer" id="div_search" style="display:none;">
	<div class="closeSmallSearch" id="closeSmallSearch"></div>
	<div class="smallSearch">
	<form method="POST" name="frmSearch" id="frmSearch" action="<?php echo site_url('admdata/icd_list');?>">
		<input type="text" name="search_name" id="search_name" value="" size="15"  />
	</form>
	</div>
</div>

<div id="divFormInputContainer" style="display:none"></div>

<div class="ui-dialog" style="width:100%;margin-right:5px;height:auto;float:left;">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar">Data ICD 10</div>
		<div class="ui-dialog-content">
            <div id="message" style="display:none"></div>
            <!-- <div id="errMessage" style="display:none" class="error">Terdapat kesalahan/ kekurangan pada pengisian form. Silakan lengkapi isian.</div> -->

		<form method="POST" name="frmInput" id="frmInput" style="display:none" action="<?php echo site_url('admdata/icd/process_form')?>">
		<input type="hidden" name="id" id="id" />
		<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
			<tr>
				<td style="width:120px">Kode</td>
				<td>
					<input type="text" name="code" id="code" readonly="readonly" size="8" class="readonly2" onkeypress="focusNext('name', 'name', this, event)" />
				</td>
			</tr>
			<tr>
				<td>Diagnosa</td>
				<td>
					<input type="text" name="name" id="name" readonly="readonly" size="50" class="readonly2" onkeypress="focusNext('kata_kunci', 'code', this, event)" />
				</td>
			</tr>
			<tr>
				<td>Kata Kunci</td>
				<td>
					<input type="text" name="kata_kunci" id="kata_kunci" size="50" />
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<input type="submit" name="Simpan" id="simpan" value="Simpan" />
					<input type="reset" name="Reset" id="reset" value="Batal" />
				</td>
			</tr>
		</table>
		</form>
			<form method="POST" name="frmList" id="frmList" action="<?php echo site_url('admdata/icd/delete_list');?>">
			<div id="divSearchResult"></div>
			</form>
		</div><!-- 
        <div class="ui-dialog-buttonpane">
		
        </div> -->
	</div>
</div>
