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
			$('#divFrmInput').slideDown('fast');
		return false;
    });

//get List Data
	function getList() {
		$('#divSearchResult').load("<?php echo site_url('admdata/drug_list/result/_');?>" + "/" + $('#current_page').val(),prepareList);return false;
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
			$('#divFrmInput').slideDown('fast');
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
		url: "drug/get_data_by_id",
		data: "id="+idx,
		success: function(jsonData) {
			$('#id').val(jsonData.id);
			$('#code').val(jsonData.code);
			$('#name').val(jsonData.name);
			$('#category').val(jsonData.category);
			$('#unit').val(jsonData.unit);
			$('#supplier_id').val(jsonData.supplier_id);
			$('#divFrmInput').slideDown('fast', function() {
				$('#name').focus();
			});
		}
	});
} 

</script>
<div class="smallSearchContainer" id="div_search" style="display:none;">
	<div class="closeSmallSearch" id="closeSmallSearch"></div>
	<div class="smallSearch">
	<form method="POST" name="frmSearch" id="frmSearch" action="<?php echo site_url('admdata/drug_list');?>">
		<input type="text" name="search_name" id="search_name" value="" size="15"  />
		<select name="search_category" id="search_category" style="width:150px;">
			<option value="drug">Obat</option>
			<option value="bhp">Bahan Habis Pakai</option>
		</select>
	</form>
	</div>
</div>

<div id="divFormInputContainer" style="display:none"></div>

<div class="ui-dialog" style="width:100%;margin-right:5px;height:auto;float:left;">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar">Data Obat</div>
		<div class="ui-dialog-content">
            <div id="message" style="display:none"></div>
            <!-- <div id="errMessage" style="display:none" class="error">Terdapat kesalahan/ kekurangan pada pengisian form. Silakan lengkapi isian.</div> -->
<div id="divFrmInput" style="display:none">

		<form method="POST" name="frmInputUpload" id="frmInputUpload" enctype="multipart/form-data" action="<?php echo site_url('admdata/drug/process_form_upload')?>">
		<fieldset class="used" style="width:900px;">
        <legend>Upload Data Obat Masuk (Dari Excel)</legend>
		<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
			<tr>
				<td style="width:150px;vertical-align:middle;">File Excel</td>
				<td>
					 <input type="file" name="file_excel" id="file_excel" size="50" /> 
                     <a href="<?php echo site_url('admdata/drug/contoh_format')?>">Download Contoh Format</a>
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="Simpan" id="simpan" value="Simpan" /></td>
			</tr>
		</table>
		</fieldset>
		</form>
        
		<form method="POST" name="frmInput" id="frmInput" action="<?php echo site_url('admdata/drug/process_form')?>">
		<fieldset class="used" style="width:900px;">
        <legend>Input Obat Masuk</legend>
		<input type="hidden" name="id" id="id" />
		<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
			<tr>
				<td style="width:120px">Kode</td>
				<td>
					<input type="text" name="code" id="code" size="8" class="required" onkeypress="focusNext('name', 'name', this, event)" />
				</td>
			</tr>
			<tr>
				<td>Obat</td>
				<td>
					<input type="text" name="name" id="name" size="30" class="required" onkeypress="focusNext('category', 'code', this, event)" />
				</td>
			</tr>
			<tr>
				<td>Jenis</td>
				<td>
					<select name="category" id="category" class="required" style="width:200px;" onkeypress="focusNext('unit', 'name', this, event)">
						<option value="drug">Obat</option>
						<option value="bhp">Bahan Habis Pakai</option>
					</select>
				</td>
			</tr>
			<tr>
				<td>Satuan</td>
				<td>
					<input type="text" name="unit" id="unit" size="30" class="required" onkeypress="focusNext('supplier_id', 'category', this, event)" />
				</td>
			</tr>
			<tr>
				<td>Supplier (default)</td>
				<td>
					<select name="supplier_id" id="supplier_id" class="required" style="width:200px;" onkeypress="focusNext('simpan', 'unit', this, event)">
						<option value="">-- PILIH --</option>
						<?php for($i=0;$i<sizeof($combo_supplier);$i++) :?>
							<option value="<?php echo $combo_supplier[$i]['id']?>"><?php echo $combo_supplier[$i]['name']?></option>
						<?php endfor;?>
					</select>
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
		</fieldset>
		</form>
		
		</div>
			<form method="POST" name="frmList" id="frmList" action="<?php echo site_url('admdata/drug/delete_list');?>">
			<div id="divSearchResult"></div>
			</form>
		</div><!-- 
        <div class="ui-dialog-buttonpane">
		
        </div> -->
	</div>
</div>
