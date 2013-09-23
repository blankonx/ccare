<script language="JavaScript" type="text/javascript">

$(document).ready(function() {
//DEFINE THE SHORTCUT
    $('.decimal').decimal();
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
        $('#treatment_category_id').val('');
        <?php for($i=0;$i<sizeof($payment_type);$i++) :?>
            $('#price_<?php echo $payment_type[$i]['id']?>').val('');
            $('#ref_treatment_price_id_<?php echo $payment_type[$i]['id']?>').val('');
            $('#payment_type_id_<?php echo $payment_type[$i]['id']?>').val('');
        <?php endfor;?>
		$('#divSearchResult').load("<?php echo site_url('admdata/treatment_list/result/_');?>" + "/" + $('#current_page').val(),prepareList);
        $('#name').val('').focus();
        return false;
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
	$('#search_treatment_category_id').bind('keypress', function(e){if(e.keyCode == 13) $('#frmSearch').submit()});
	$('#search_treatment_category_id').bind('change', function() {$('#frmSearch').submit()});

//ajaxing add data
	var validator = $("#frmData").validate({
		rules: {
            name: "required",
            treatment_category_id: "required",
            price: "required"
		},
        submitHandler:
            function(form) {
				$('#reloadData').ajaxStart(function(){$(this).removeClass().addClass('buttonReloadIsLoad');});
				$('#reloadData').ajaxStop(function(){$(this).removeClass().addClass('buttonReload');});
                $(form).ajaxSubmit({
					dataType: 'json',
                    success:function(data) {
                        show_message('#message', data.msg, data.status);
						if(data.status == 'success') getList();
						else $("#name").focus();
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
	}

	//checkall

	$('#reset').click(function() {
        $('#id').val('');
        getList();
    });
	$('#frmSearch').resetForm();
	$('#frmSearch').submit();
    $('#name').focus();
});

function get_data_by_id(idx) {
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "treatment/get_data_by_id",
		data: "id="+idx,
		success: function(jsonData) {
			$('#id').val(jsonData[0].id);
			$('#treatment_category_id').val(jsonData[0].treatment_category_id);
			$('#name').val(jsonData[0].name);
            $.each(jsonData, function(key, val) {
                $('#price_' + jsonData[key].payment_type_id).val(jsonData[key].price);
                $('#ref_treatment_price_id_' + jsonData[key].payment_type_id).val(jsonData[key].ref_treatment_price_id);
            });
			$('#frmData').slideDown('fast', function() {
				$('#name').focus();
			});
		}
	});
} 

</script>

<div class="smallSearchContainer" id="div_search" style="display:none;left:287px;top:0">
	<div class="closeSmallSearch" id="closeSmallSearch"></div>
	<div class="smallSearch">
	<form method="POST" name="frmSearch" id="frmSearch" action="<?php echo site_url('admdata/treatment_list');?>">
		<input type="text" name="search_name" id="search_name" value="" size="25" onkeypress="focusNext('search_treatment_category_id', 'search_treatment_category_id', this, event)" />
		<select name="search_treatment_category_id" id="search_treatment_category_id" style="width:200px" onkeypress="focusNext('search_name', 'search_name', this, event)">
			<option value="">--- <?php echo $this->lang->line('form_all');?> ---</option>
			<?php for($i=0;$i<sizeof($combo_categories);$i++) :?>
			<option value="<?php echo $combo_categories[$i]['id']?>"><?php echo $combo_categories[$i]['name']?></option>
			<?php endfor;?>
		</select>
	</form>
	</div>
</div>

<div class="ui-dialog" style="width:100%;margin-right:5px;height:auto;float:left;">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar"><?php echo $title;?></div>
		<div class="ui-dialog-content">
            <div id="message" style="display:none"></div>
			<form method="POST" name="frmData" id="frmData" style="display:none" action="<?php echo site_url('admdata/treatment/process_form');?>">
            <input type="hidden" name="id" id="id" value="">
			<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
				<tr>
					<td style="width:150px">Nama Tindakan</td>
					<td><input type="text" name="name" id="name" value="" size="30" onkeypress="focusNext('treatment_category_id', 'treatment_category_id', this, event)" /></td>
				</tr>
				<tr>
					<td>Jenis Tindakan</td>
					<td>
						<select name="treatment_category_id" id="treatment_category_id" style="width:250px" onkeypress="focusNext('price', 'name', this, event)">
                            <option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
							<?php for($i=0;$i<sizeof($combo_categories);$i++) :?>
							<option value="<?php echo $combo_categories[$i]['id']?>"><?php echo $combo_categories[$i]['name']?></option>
							<?php endfor;?>
						</select>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_price');?></td>
                    <td>
                        <table>
                            <tr>
                    <?php for($i=0;$i<sizeof($payment_type);$i++) :?>
                        <td><b><?php echo $payment_type[$i]['name'];?> :</b><br/>
                            <input class="decimal" type="text" name="price[<?php $payment_type[$i]['id']?>]" size="12" id="price_<?php echo $payment_type[$i]['id']?>" style="text-align:right" onkeypress="focusNext('treatment_category_id', 'treatment_category_id', this, event)"/>
                            <input type="hidden" name="ref_treatment_price_id[]" id="ref_treatment_price_id_<?php echo $payment_type[$i]['id']?>" />
                            <input type="hidden" name="payment_type_id[]" value="<?php echo $payment_type[$i]['id'];?>" id="payment_type_id_<?php $payment_type[$i]['id']?>" />
                        </td>
                    <?php endfor;?>
                            </tr>
                        </table>
                    </td>
				</tr>
				<tr>
					<td></td><td>
					<input type="submit" name="Search" id="submit" value="Simpan" /><input type="reset" name="Reset" id="reset" value="Batal" />
					</td>
				</tr>
			</table>
			</form>

			<form method="POST" name="frmList" id="frmList" action="<?php echo site_url('admdata/treatment/delete_list');?>">
			<div id="divSearchResult"></div>
			</form>
		</div>
        <div class="ui-dialog-buttonpane">
		:)
        </div>
	</div>
</div>
