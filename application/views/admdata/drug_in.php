<script language="JavaScript" type="text/javascript">

$(document).ready(function() {
	$('.decimal').decimal();
    //DEFINE THE SHORTCUT
    $(document).bind('keydown', 'Ctrl+f', function(evt) {
		$("#div_search")
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
//get List Data

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

		$('#reloadData').click(function() {$('#frmSearch').submit()});
		
		$('#findData').click(function() {
			$("#div_search")
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
					if(data.status == 'success') {
						$('#frmSearch').submit();
					}
					else $("#name").focus();
				}
			});
			return false;
		});
	}

	$('#reset').click( function() {$('#frmSearch').submit();$('#frmInput').clearForm();$('#date').focus();});
	$('#frmSearch').submit();
    $('#code').focus();
});



</script>

<script language="javascript">
$(document).ready(function() {
    $(document).bind('keydown', 'Ctrl+n', function(evt) {
		createNextDrugInputForButton();
		return false;
    });
	var drugi=1;
	function createNextDrugInputForButton() {
		var obj = $('#unit_' + drugi);
		drugi++;
		
		var lix = $('<li/>');
		var inputTextDrug = $('<input type="text"/>')
			.attr('name', 'drug_name[]')
			.attr('id', 'drug_name_' + drugi)
			.attr('size', '50');

		var inputHidden = $('<input type="hidden"/>').attr('name', 'drug_id[]').attr('id', 'drug_id_' + drugi);

		var inputQty = $('<input type="text"/>')
			.attr('name', 'qty[]')
			.attr('id', 'qty_' + drugi)
			.attr('size', '5')
			.css('text-align', 'right')
			.decimal();

		var inputUnit = $('<span>')
			.attr('id', 'unit_' + drugi);

		var imgx = $('<img/>').attr('src', '../webroot/media/images/close.png').bind('click', function() {
			$(this).parent().slideUp('slow', function(){
				$(this).remove();
			});
		});
		
		inputTextDrug
		.autocomplete("../admdata/drug_in/get_list_drug", {
			formatItem: function(data, i, max, term) {
				return data[0] + "<div style='color:red;font-size: 90%;font-style:italic;text-align:right;'>Stock : " + data[3] + "</div>";
			},
			formatResult: function(data) {
				return data[0];
			}
		})
		.result(function(event, data, formatted) {
			inputHidden.val(data[1]);
			inputUnit.text(data[2]).focus();
			inputQty.val('1');
		});

		lix.append(inputTextDrug);
		lix.append("\n");
		lix.append(inputHidden);
		lix.append(inputQty);
		lix.append(inputUnit);

		obj.after(imgx);
		$('#list_prescribes').append(lix);
		inputTextDrug.focus();		
	}

    $("#drug_name_1")
	.autocomplete("../admdata/drug_in/get_list_drug", {
		formatItem: function(data, i, max, term) {
			return data[0] + "<div style='color:red;font-size: 90%;font-style:italic;text-align:right;'>Stock : " + data[3] + "</div>";
		},
		formatResult: function(data) {
			return data[0];
		}
	})
    .result(function(event, data, formatted) {
        $('#drug_id_1').val(data[1]);
        $('#qty_1').val('1').focus();
        $('#unit_1').text(data[2]);
    });
    $('#link_add_prescribe').click(function(e) {
        e.preventDefault();
        createNextDrugInputForButton();
    });
    
    $("#frmInput").validate({
        rules: {
        },
        submitHandler:
            function(form) {
                $(form).ajaxSubmit({
                    beforeSubmit:function() {disableForm(); enableForm();},
                    dataType: 'json',
                    success:function(data) {
						show_message('#message', data.msg, data.status);
						$('#frmSearch').submit();
                    }
                });
            }
    });
});

</script>
<div class="smallSearchContainer" id="div_search" style="z-index:1;position:absolute;top:0;left:700px">
	<div class="closeSmallSearch" id="closeSmallSearch"></div>
	<div class="smallSearch">
	<form method="POST" name="frmSearch" id="frmSearch" action="<?php echo site_url('admdata/drug_in_list');?>">
		<input type="text" name="search_name" id="search_name" value="" size="21" title="Kata Kunci" /><br/>
		<input type="text" name="search_date_start" id="search_date_start" size="8" value="<?php echo date('d/m/Y')?>" title="Tanggal Mulai"/> - 
		<input type="text" name="search_date_end" id="search_date_end" size="8" value="<?php echo date('d/m/Y')?>" title="Tanggal Selesai" />
	</form>
	</div>
</div>

<div id="divFormInputContainer" style="display:none"></div>

<div class="ui-dialog" style="width:100%;margin-right:5px;height:auto;float:left;">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar">Obat Masuk</div>
		<div class="ui-dialog-content">
        <div id="message" style="display:none"></div>
		<form method="POST" name="frmInput" id="frmInput" action="<?php echo site_url('admdata/drug_in/process_form')?>">
		<fieldset class="used" style="width:800px;">
		<legend>Obat Masuk</legend>
		<table cellpadding="0" cellspacing="0" border="0" class="tblInput" style="">
			<tr>
				<td style="width:150px;vertical-align:middle;">Tanggal Obat Masuk</td>
				<td style="width:300px;">
					<input type="text" name="date" id="date" size="8" style="font-size:18px;" value="<?php echo date('d/m/Y')?>" /><em>dd/mm/yyyy</em>
				</td>
			</tr>
			<tr>
				<td style="width:150px;vertical-align:middle;">
					Keterangan
				</td>
				<td>
					<input type="text" size="50" name="explanation" value="" style="font-size:12px;" />
				</td>
			</tr>
		</table>
		<hr/>
        <div class="tblInput" style="margin-top:10px;">
            <div class="prescribes_list" style="font-weight:bold;">
                <div style="width:375px;margin-left:30px">Obat</div>
                <div style="width:50px;">Jml</div>
            </div>
			<div style="clear:both"></div>
            <ol class="prescribes_list" id="list_prescribes">
                <li>
                    <input type="text" name="drug_name[]" id="drug_name_1" size="50" value=""/>
                    <input type="hidden" name="drug_id[]" id="drug_id_1" />
                    <input type="text" name="qty[]" id="qty_1" size="5" value="" style="text-align:right" class="decimal" /><span id="unit_1"></span>
                </li>
            </ol>
            <div style="text-align:right;width:450px;">
                <a href="javascript:void(0)" id="link_add_prescribe">Tambah Obat</a> <em>(atau tekan Ctrl+N)</em>
            </div>
        </div>
		</fieldset>
		<div class="tblInput">
            <input type="submit" name="Simpan" id="simpan" value="Simpan" />
			<input type="reset" name="Reset" id="reset" value="Batal" />
		</div>
		</form>
		<form method="POST" name="frmList" id="frmList" action="<?php echo site_url('admdata/drug_in/delete_list');?>">
		<div id="divSearchResult"></div>
		</form>
		</div>
	</div>
</div>
