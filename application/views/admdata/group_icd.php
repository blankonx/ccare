<script language="JavaScript" type="text/javascript">

$(document).ready(function() {

    var yicdi=1;
    function createNextAnamneseIcdInputForButton() {
        var obj = $('#icd_name_' + yicdi);
        yicdi++;
        currAnamneseKey++;
        var lix = $('<li/>');
        var inputHidden = $('<input type="hidden"/>')
            .attr('name', 'icd_id[]')
            .attr('id', 'icd_id_' + yicdi);

        var inputCode = $('<input type="text"/>')
            .attr('name', 'icd_code[]')
            .attr('size', '5')
            .attr('readonly', 'readonly')
            .attr('class', 'readonly2')
            .attr('id', 'icd_code_' + yicdi);

        var inputText = $('<input type="text"/>')
            .attr('name', 'icd_name[]')
            .attr('id', 'icd_name_' + yicdi)
            .attr('size', '50');

        var imgx = $('<img/>').attr('src', '../webroot/media/images/close.png').bind('click', function() {
            $(this).parent().remove();
        });

        inputText.autocomplete("../visit/general_checkup/get_list_icd", {
            formatItem: function(data, i, max, term) {
                return data[2] + " " + data[0];
            }
        })
        .result(function(event, data, formatted) {
            inputHidden.val(data[1]);
            inputCode.val(data[2]);
        });
        
        lix.append(inputHidden)
        .append(inputCode)
        .append(inputText); 

        obj.after(imgx);
        $('#ol_list_diagnose').append(lix);
        inputText.focus();
    }

    var currAnamneseKey=0;
    var icdi=1;

    $("#icd_name_1").autocomplete("../visit/general_checkup/get_list_icd", {
        formatItem: function(data, i, max, term) {
            return data[2] + " " + data[0];
		}
	})
    .result(function(event, data, formatted) {
        $('#icd_id_1').val(data[1]);
        $('#icd_code_1').val(data[2]);
    });
    
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
        $("#div_search").slideUp("fast", function(){$('#id').focus()});return false;
    });
    $('#closeSmallSearch').click(function(){
        $("#div_search").slideUp("fast", function(){$('#id').focus()});return false;
    });
//show form add
    $(document).bind('keydown', 'Ctrl+n', function(evt){
        $("#div_search").slideUp("fast");
			$('#reset').click();
			$('#frmInput').slideDown('fast');
			$('#name').focus();
		return false;
    });
    $('#link_add_anamnese_diagnose').click(function(e) {
        e.preventDefault();
        createNextAnamneseIcdInputForButton();
    });

//get List Data
	function getList() {
		$('#divSearchResult').load("<?php echo site_url('admdata/group_icd_list/result/_');?>" + "/" + $('#current_page').val(),prepareList);return false;
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
							$('#frmSearch').submit();
							$('#reset').click();
                            $('#ol_list_diagnose').html('');
                            //createNextAnamneseIcdInputForButton();
						}
						else $("#id").focus();
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
					else $("#id").focus();
				}
			});
			return false;
		});
	}

	//checkall
	$('#reset').click( function() {
		//getList();
		$('#frmInput').clearForm();
		$('#code').focus();
	});
	$('#frmSearch').resetForm();
	$('#frmSearch').submit();
    $('#code').focus();
});

function get_data_by_id(idx) {
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "group_icd/get_data_by_id",
		data: "id="+idx,
		success: function(jsonData) {
			$('#id').val(jsonData[0].id);
			$('#name').val(jsonData[0].name);
            
            $('#ol_list_diagnose').html('');
                
			$.each(jsonData, function(i, item) {
			    //var xid = '#' + item.menu_id;
                var lix = $('<li/>');

                var inputHidden = $('<input type="hidden"/>')
                    .attr('name', 'icd_id[]')
                    .val(item.icd_id);
                    
                var inputCode = $('<input type="text"/>')
                    .attr('name', 'icd_code[]')
                    .attr('size', '5')
                    .attr('readonly', 'readonly')
                    .attr('class', 'readonly2')
                    .val(item.icd_code);

                var inputText = $('<input type="text"/>')
                    .attr('name', 'icd_name[]')
                    .attr('readonly', 'readonly')
                    .attr('class', 'readonly2')
                    .attr('size', '50')
                    .val(item.icd_name);

                var imgx = $('<img/>').attr('src', '../webroot/media/images/close.png').bind('click', function() {
                    var m = confirm('Delete This Data?');
                    var x = $(this);
                    if(m) {
                        $.ajax({
                            url:'../admdata/group_icd/delete_icd/' + item.igd_id,
                            success: function(data) {
                                x.parent().remove();
                            }
                        });
                    }
                });

                lix
                .append(inputHidden)
                .append(inputCode)
                .append(inputText);
                inputText.after(imgx);
                $('#ol_list_diagnose').append(lix);
            });
			$('#frmInput').slideDown('fast', function() {
				$('#name').focus();
			});
		}
	});
} 

</script>
<div class="smallSearchContainer" id="div_search" style="display:none;">
	<div class="closeSmallSearch" id="closeSmallSearch"></div>
	<div class="smallSearch">
	<form method="POST" name="frmSearch" id="frmSearch" action="<?php echo site_url('admdata/group_icd_list');?>">
		<input type="text" name="search_name" id="search_name" value="" size="25"  />
	</form>
	</div>
</div>

<div id="divFormInputContainer" style="display:none"></div>

<div class="ui-dialog" style="width:100%;margin-right:5px;height:auto;float:left;">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar"><?php echo $title;?></div>
		<div class="ui-dialog-content">
            <div id="message" style="display:none"></div>
            <!-- <div id="errMessage" style="display:none" class="error">Terdapat kesalahan/ kekurangan pada pengisian form. Silakan lengkapi isian.</div> -->

		<form method="POST" name="frmInput" id="frmInput" style="display:none" action="<?php echo site_url('admdata/group_icd/process_form')?>">
		<input type="hidden" name="id" id="id" />
		<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
			<tr>
				<td style="width:150px">Kelompok</td>
				<td>
					<input type="text" name="name" id="name" size="30" class="required" />
				</td>
			</tr>
			<tr>
				<td>ICD</td>
				<td>
					<ol id="ol_list_diagnose">
						<li>
							<input type="text" name="icd_code[0]" id="icd_code_1" size="5" class="readonly2" readonly="readonly" />
							<input type="text" name="icd_name[0]" id="icd_name_1" size="50" onkeypress="focusNext('icd_name_1', 'icd_name_1', this, event)" value="" />
							<input type="hidden" name="icd_id[0]" id="icd_id_1" />
                        </li>
					</ol>
					<a href="javascript:void(0)" id="link_add_anamnese_diagnose">[Tambah Diagnosa]</a>
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
			<form method="POST" name="frmList" id="frmList" action="<?php echo site_url('admdata/group_icd/delete_list');?>">
			<div id="divSearchResult"></div>
			</form>
		</div><!-- 
        <div class="ui-dialog-buttonpane">
		
        </div> -->
	</div>
</div>
