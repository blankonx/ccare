<script language="JavaScript" type="text/javascript">

$(document).ready(function() {
    $(document).bind('keydown', 'Ctrl+f', function(evt){
        $("#div_search").slideDown("fast", function(){$('#search_name').focus()});return false;
    });
    $("#div_search").bind('keydown', 'esc', function(evt){
        $("#div_search").slideUp("fast");return false;
    });
    $('#closeSmallSearch').click(function(){
        $("#div_search").slideUp("fast");return false;
    });
    $('#findData').click(function() {$('#div_search').slideDown('fast');$('#search_name').focus();});

	function getList() {
		$('#divSearchResult').load("<?php echo site_url('visit/queue_list/result/_');?>" + "/" + $('#current_page').val(),prepareList);return false;
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
	$('#search_clinic_id').bind('keypress', function(e){if(e.keyCode == 13) $('#frmSearch').submit()});
	$('#search_clinic_id').bind('change', function() {
	    var txt = $('#search_clinic_id option:selected').text();
	    if(txt != '--- Semua ---') $('#_clinic_label').text(txt);
	    $('#frmSearch').submit();
    });
	$('#visit_date_start').bind('change', function() {$('#frmSearch').submit()});
	$('#visit_date_end').bind('change', function() {$('#frmSearch').submit()});
	$('#search_show_served').bind('change', function() {$('#frmSearch').submit()});
    

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
            $('#divSearchResult').load(this.href,
				function() {
					/*$('#xcurrent_page').val($('#current_page').val());*/
					prepareList();
				});return false;
        });

		//viewing popup detil
		$('.detail_link').click(
			function() {
				//if($('#panel_detail').css('display') == 'none') {
				var ofs = $(this).offset();
				$('#panel_detail').css('top', ofs.top+20).css('left', ofs.left-320).slideDown('fast');
				$('#panel_detail_content').html('<div class="divLoading"></div>').load(this.href);
                return false;
				//}
			})
        .blur(
			function() {
				$('#panel_detail').slideUp('fast');
			}
		);
        
		//viewing popup rujukan_internal
		$('.rujukan_internal_link')
		.click(function(e) {
			e.preventDefault();
			$('#panel_rujukan_internal').show();
			$('#panel_rujukan_internal_content').html('<div class="divLoading"></div>').load(this.href);
		});
        $('#close_panel_rujukan_internal').click(function(){
            $('#panel_rujukan_internal').slideUp('fast', function() {
                $('#panel_rujukan_internal_content').children().remove()
                $('#panel_rujukan_internal_content').html('<div class="divLoading"></div>');
            });
        });
        //Im adding the checkup_cnt, in order to make the link unique, 
        //cz, if it's not unique, the function that melekat di <input/> will duplicated

        var checkup_cnt=1;
		$('.checkup_link').click(function() {
            $('#panel_checkup').slideDown('fast');
            var xurl = this.href + '/' + checkup_cnt + '/';
            $('#panel_checkup_content').load(xurl);
            checkup_cnt++;
            return false;
		});
		$('.checkup_link').parent().parent().dblclick(function() {
            //$('#panel_checkup').slideDown('fast');
            var xurl = '../visit/checkup/result/' + $(this).attr('id') + '/' + checkup_cnt + '/';
            $('#panel_checkup_content').load(xurl);
            $('#panel_checkup').show();
            checkup_cnt++;
            return false;
		});

        //CHECKUP PANEL CLOSE
        $('#close_panel_checkup').click(function(){
            $('#panel_checkup').hide();
			$('#alergi_container').hide();
			$('#alergi_msg_box').html('');
			$('#panel_checkup_content').children().remove();
			$('#panel_checkup_content').html('<div class="divLoading"></div>');
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
	//ALERGI

	$('#alergi_title').toggle(function() {
		$('#alergi_msg_box').show();
		$('#alergiForm').show();
		$('#alergi_msg').focus();
	}, function() {
		$('#alergi_msg_box').hide();
		$('#alergiForm').hide();
	});
    $("#alergiForm").validate({
        submitHandler:
            function(form) {
                $(form).ajaxSubmit({
                    beforeSubmit:function() {
                        if($('#alergi_msg').val() == '') return false;
                    },
                    clearForm:true,
                    success:function(data) {
						$('#alergi_msg_box').html(data);
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
                        $('#alergi_msg').focus();
                    }
                });
            }
	});
	//getList();
	queueReload();
    $('#div_search').slideDown('slow');
	$('#search_name').focus();
});


var queueTimeoutId;
function queueReload() {
	$('#frmSearch').submit();
	/*BATAM : REFRESH DIMATIKAN :*/
	/*
	queueTimeoutId = setTimeout("queueReload()", 7000);
	*/
}

</script>


<div class="smallSearchContainer" id="div_search" style="display:none;right:16px;top:25px">
	<div class="closeSmallSearch" id="closeSmallSearch"></div>
	<div class="smallSearch">
	<form method="POST" name="frmSearch" id="frmSearch" action="<?php echo site_url('visit/queue_list');?>">
		<input type="hidden" name="xcurrent_page" id="xcurrent_page" value="" />
		<input type="text" name="search_name" id="search_name" value="" size="25" onkeypress="focusNext('search_clinic_id', 'search_clinic_id', this, event)" />
		
						<select name="search_clinic_id" id="search_clinic_id" style="width:200px" onkeypress="focusNext('visit_date_start', 'search_name', this, event)">
							<option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
							<?php $k=0; for($i=0;$i<sizeof($combo_clinic);$i++) :?>
							<?php 
                                if($i!=0 && $combo_clinic[$i]['parent_id'] != $combo_clinic[$i-1]['parent_id'] && $combo_clinic[$i-1]['parent_id'] != NULL) {
                                    echo '</optgroup>';
                                }
                                if($combo_clinic[$i]['parent_id'] != NULL && $combo_clinic[$i]['parent_id'] != $combo_clinic[$i-1]['parent_id']) :
                                    echo '<optgroup label="'.$combo_clinic[$i]['parent_name'].'">';
							?>
							<?php endif;?>
								<option value="<?php echo $combo_clinic[$i]['id']?>"><?php echo $combo_clinic[$i]['name']?></option>
							<?php endfor;?>
						</select>
        <div style="text-align:right;">
        <input type="text" name="visit_date_start" class="date-pick" id="visit_date_start" maxlength="10" value="<?=date('d/m/Y')?>" size="12" onkeyup="autoSlashTanggal(this, event)" onkeypress="focusNext('visit_date_end', 'search_clinic_id', this, event)" />&minus;<input type="text" name="visit_date_end" id="visit_date_end" maxlength="10" value="<?=date('d/m/Y')?>" size="12" onkeyup="autoSlashTanggal(this, event)" onkeypress="focusNext('search_name', 'visit_date_start', this, event)" class="date-pick" />
        <input type="checkbox" name="search_show_served" id="search_show_served" value="yes" />
        <label for="search_show_served"><?php echo $this->lang->line('label_show_served_patient');?></label>
        </div>
	</form>
	</div>
</div>

<div class="ui-dialog" style="width:100%;margin-right:5px;height:auto;float:left;">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar"><?php echo $title;?> <span id="_clinic_label"></span></div>
		<div class="ui-dialog-content">
            <div id="message" style="display:none"></div>
			<form method="POST" name="frmList" id="frmList" action="<?php echo site_url('visit/queue/delete_list');?>">
			<div id="divSearchResult" style="margin-top:20px;">
			<input type="hidden" name="current_page" id="current_page" value="0" />
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
							<th><?php echo $this->lang->line('label_mr_number');?></th>
							<th><?php echo $this->lang->line('label_name');?></th>
							<th style="width:70px"><?php echo $this->lang->line('label_sex');?></th>
							<th style="width:50px"><?php echo $this->lang->line('label_age');?></th>
                            <th style="width:70px"><?php echo $this->lang->line('label_action');?></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan="7" style="text-align:center;font-style:italic"><?php echo $this->lang->line('msg_no_data');?></td>
						</tr>
					</tbody>
				</table>
			</div>
			</form>
			<ul class="legend">
				<li><img alt="Detail Pasien" src="<?php echo base_url();?>webroot/media/images/user.png"/>&nbsp;Detail Pasien</li>
				<li><img alt="Periksa Pasien" src="<?php echo base_url();?>webroot/media/images/add2.png"/>&nbsp;Periksa Pasien</li>
				<li><img alt="Ubah Data Pemeriksaan Pasien" src="<?php echo base_url();?>webroot/media/images/check.png"/>&nbsp;Ubah Data Pemeriksaan Pasien</li>
				<li><img alt="Cetak Pemeriksaan" src="<?php echo base_url();?>webroot/media/images/print16.png"/>&nbsp;Cetak Pemeriksaan</li>
				<li><img alt="Rujukan Internal" src="<?php echo base_url();?>webroot/media/images/keluar.png"/>&nbsp;Rujukan Internal</li>
			</ul>
		</div><!-- 
        <div class="ui-dialog-buttonpane">
		
        </div> -->
	</div>
</div>

<div id="panel_detail" class="ui-dialog" style="display:none;width:400px;height:auto;position:absolute;z-index:3;top:0;">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar">Detail</div>
		<div class="ui-dialog-content" id="panel_detail_content">
            <div class="divLoading"></div>
		</div>
	</div>
</div>

<div id="panel_checkup" class="ui-dialog" style="display:none;width:99%;height:auto;position:absolute;z-index:4;top:0;">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar"><div id="panel_checkup_title">Checkup</div>
			<a class="ui-dialog-titlebar-close" href="javascript:void(0)" id="close_panel_checkup"></a>
		</div>
		<div class="ui-dialog-content" id="panel_checkup_content">
            <div class="divLoading"></div>
		</div>
	</div>
</div>


<div id="panel_mix" class="ui-dialog" style="display:none;width:500px;height:auto;position:absolute;z-index:5;top:0;">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar"><div id="panel_mix_title">Mix Prescribes</div>
			<a class="ui-dialog-titlebar-close" href="javascript:void(0)" id="close_panel_mix"></a>
		</div>
		<div class="ui-dialog-content" id="panel_mix_content">
            <div class="divLoading"></div>
		</div>
	</div>
</div>

<div id="panel_rujukan_internal" class="ui-dialog" style="display:none;width:99%;height:auto;position:absolute;z-index:6;top:0;">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar"><div id="panel_rujukan_internal_title">Rujukan Internal</div>
			<a class="ui-dialog-titlebar-close" href="javascript:void(0)" id="close_panel_rujukan_internal"></a>
		</div>
		<div class="ui-dialog-content" id="panel_rujukan_internal_content">
            <div class="divLoading"></div>
		</div>
	</div>
</div>

<div id="alergi_container" style="display:none">
	<div id="alergi_title" style="cursor:pointer">Alergi</div>
	<div id="alergi_msg_box" style="margin:1px auto;display:none;"></div>
	<form id="alergiForm" name="alergiForm" method="post" action="<?php echo site_url('home/alergi_send')?>" style="display:none;">
		<input type="hidden" name="alergi_patient_id" id="alergi_patient_id" value="" />
		<input type="hidden" name="alergi_family_folder" id="alergi_family_folder" value="" />
		<input type="hidden" name="alergi_family_relationship_id" id="alergi_family_relationship_id" value="" />
		<input type="text" name="alergi_msg" id="alergi_msg" value="" size="27" class="input_default" />
		<input type="submit" name="alergi_submit" id="alergi_submit" value="Kirim" style="display:none" />
	</form>
</div>

<!-- <div id="panel_pregnant_visit" class="ui-dialog" style="margin:120px 10px;display:none;width:980px;height:auto;position:absolute;z-index:6;top:0;">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar">
            <div id="panel_pregnant_visit_title">Kunjungan Kehamilan</div>
			<a class="ui-dialog-titlebar-close" href="javascript:void(0)" id="close_pregnant_visit"></a>
		</div>
		<div class="ui-dialog-content" id="panel_pregnant_visit_content">
            <div class="divLoading"></div>
        </div>
	</div>
</div> -->
