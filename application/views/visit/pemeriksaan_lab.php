<script language="javascript" type="text/javascript">
$(document).ready(function() {
    //LIST 
    $('#pl_permit_day').numeric();
    $('#btnClosePemeriksaanLab').click(function(){
		$('#panel_checkup').hide();
		$('#alergi_container').hide();
		$('#alergi_msg_box').html('');
		$('#panel_checkup_content').children().remove();
		$('#panel_checkup_content').html('<div class="divLoading"></div>');
	});
    $('#list_pl').load('<?php echo base_url()."visit/pemeriksaan_lab/lists/".$data['visit_id'];?>');
    /*SICKNESS EXPLANATION FORM*/
    $("#frmPl").validate({
        rules: {
        
        },
        submitHandler:
            function(form) {
                //$('#reloadData').ajaxStart(function(){$(this).removeClass().addClass('buttonReloadIsLoad');});
                //$('#reloadData').ajaxStop(function(){$(this).removeClass().addClass('buttonReload');});
                $(form).ajaxSubmit({
                    beforeSubmit:disableForm,
                    dataType: 'json',
                    success:function(data) {
                        enableForm();
                        show_message('#message_pl', data.msg, data.status);
                        if(data.last_id) {
                            //openPrintPopup('pemeriksaan_lab/prints/' + data.last_id);
                            $('#list_pl').load('../visit/pemeriksaan_lab/lists/<?php echo $data['visit_id']?>');
                        }
                        $('#frmSearch').submit();
                    }
                });
            }
    });
});
</script>
<div id="message_pl"></div>
<form method="post" name="frmPl" id="frmPl" action="<?php echo site_url('visit/pemeriksaan_lab/process_form_pl')?>">
<input type="hidden" name="pl_visit_id" id="pl_visit_id" value="<?php echo $data['visit_id']?>" />
    <fieldset class="used">
	<legend>Jenis Pemeriksaan</legend>
    <div style="float:left;width:300px" class="tblInput">
    <ol>
    <?php for($i=0;$i<sizeof($pemeriksaan_lab);$i++) :?>
    <?php if($pemeriksaan_lab[$i]['parent_id'] > 2) break;?>

    <?php if($pemeriksaan_lab[$i]['parent_name'] != $pemeriksaan_lab[$i-1]['parent_name']) :?>
        <?php if($i == 0) :?>
            <li style="list-style-type:none;">
                <b><?php echo $pemeriksaan_lab[$i]['parent_name']?></b>
                <ol>
                    <li style="list-style-type: decimal"><label><input type="checkbox" id="<?php echo $pemeriksaan_lab[$i]['id'];?>" name="pemeriksaan_lab_item[]" class="menu_child menu_child_<?php echo $pemeriksaan_lab[$i]['parent_id']?>" value="<?php echo $pemeriksaan_lab[$i]['id'];?>"/><?php echo $pemeriksaan_lab[$i]['name']?></label>
                    <div style="font-style:italic;font-size:9px"><?php echo $pemeriksaan_lab[$i]['nilai_minimum'] . "&mdash;" . $pemeriksaan_lab[$i]['nilai_maximum'] . " " . $pemeriksaan_lab[$i]['satuan'];?></div></li>
        <?php else :?>
                </ol>
            </li>
            <li style="list-style-type:none;">
                <b><?php echo $pemeriksaan_lab[$i]['parent_name']?></b>
                <ol>
                    <li style="list-style-type: decimal"><label><input type="checkbox" id="<?php echo $pemeriksaan_lab[$i]['id'];?>" name="pemeriksaan_lab_item[]" class="menu_child menu_child_<?php echo $pemeriksaan_lab[$i]['parent_id']?>" value="<?php echo $pemeriksaan_lab[$i]['id'];?>"/><?php echo $pemeriksaan_lab[$i]['name']?></label>
                    <div style="font-style:italic;font-size:9px"><?php echo $pemeriksaan_lab[$i]['nilai_minimum'] . "&mdash;" . $pemeriksaan_lab[$i]['nilai_maximum'] . " " . $pemeriksaan_lab[$i]['satuan'];?></div></li>
        <?php endif;?>
    <?php else :?>
                <li style="list-style-type: decimal"><label><input type="checkbox" id="<?php echo $pemeriksaan_lab[$i]['id'];?>" name="pemeriksaan_lab_item[]" class="menu_child menu_child_<?php echo $pemeriksaan_lab[$i]['parent_id']?>" value="<?php echo $pemeriksaan_lab[$i]['id'];?>"/><?php echo $pemeriksaan_lab[$i]['name']?></label>
                    <div style="font-style:italic;font-size:9px"><?php echo $pemeriksaan_lab[$i]['nilai_minimum'] . "&mdash;" . $pemeriksaan_lab[$i]['nilai_maximum'] . " " . $pemeriksaan_lab[$i]['satuan'];?></div></li>
    <?php endif;?>
    <?php endfor;?>
    </ol> 
    </div>
    
    <div style="float:left;width:300px" class="tblInput">
    <ol>
    <?php $j=0; for($i=0;$i<sizeof($pemeriksaan_lab);$i++) :?>
    <?php if($pemeriksaan_lab[$i]['parent_id'] < 3) continue; if($pemeriksaan_lab[$i]['parent_id'] > 5) continue;?>

    <?php if($pemeriksaan_lab[$i]['parent_name'] != $pemeriksaan_lab[$i-1]['parent_name']) :?>
        <?php if($j == 0) :?>
            <li style="list-style-type:none">
                <b><?php echo $pemeriksaan_lab[$i]['parent_name']?></b>
                <ol>
                    <li style="list-style-type: decimal"><label><input type="checkbox" id="<?php echo $pemeriksaan_lab[$i]['id'];?>" name="pemeriksaan_lab_item[]" class="menu_child menu_child_<?php echo $pemeriksaan_lab[$i]['parent_id']?>" value="<?php echo $pemeriksaan_lab[$i]['id'];?>"/><?php echo $pemeriksaan_lab[$i]['name']?></label>
                    <div style="font-style:italic;font-size:9px"><?php echo $pemeriksaan_lab[$i]['nilai_minimum'] . "&mdash;" . $pemeriksaan_lab[$i]['nilai_maximum'] . " " . $pemeriksaan_lab[$i]['satuan'];?></div>
                    </li>
        <?php else :?>
                </ol>
            </li>
            <li style="list-style-type:none;">
                <b><?php echo $pemeriksaan_lab[$i]['parent_name']?></b>
                <ol>
                    <li style="list-style-type: decimal"><label><input type="checkbox" id="<?php echo $pemeriksaan_lab[$i]['id'];?>" name="pemeriksaan_lab_item[]" class="menu_child menu_child_<?php echo $pemeriksaan_lab[$i]['parent_id']?>" value="<?php echo $pemeriksaan_lab[$i]['id'];?>"/><?php echo $pemeriksaan_lab[$i]['name']?></label>
                    <div style="font-style:italic;font-size:9px"><?php echo $pemeriksaan_lab[$i]['nilai_minimum'] . "&mdash;" . $pemeriksaan_lab[$i]['nilai_maximum'] . " " . $pemeriksaan_lab[$i]['satuan'];?></div>
                    </li>
        <?php endif;?>
    <?php else :?>
                <li style="list-style-type: decimal"><label><input type="checkbox" id="<?php echo $pemeriksaan_lab[$i]['id'];?>" name="pemeriksaan_lab_item[]" class="menu_child menu_child_<?php echo $pemeriksaan_lab[$i]['parent_id']?>" value="<?php echo $pemeriksaan_lab[$i]['id'];?>"/><?php echo $pemeriksaan_lab[$i]['name']?></label>
                    <div style="font-style:italic;font-size:9px"><?php echo $pemeriksaan_lab[$i]['nilai_minimum'] . "&mdash;" . $pemeriksaan_lab[$i]['nilai_maximum'] . " " . $pemeriksaan_lab[$i]['satuan'];?></div>
                    </li>
    <?php endif;?>
    <?php $j++; endfor;?>
    </ol> 
    </div>

    <div style="float:left;width:300px" class="tblInput">
    <ol>
    <?php $k=0; for($i=0;$i<sizeof($pemeriksaan_lab);$i++) : ?>
    <?php if($pemeriksaan_lab[$i]['parent_id'] < 6) continue;?>

    <?php if($pemeriksaan_lab[$i]['parent_name'] != $pemeriksaan_lab[$i-1]['parent_name']) :?>
        <?php if($k == 0) :?>
            <li style="list-style-type:none;">
                <b><?php echo $pemeriksaan_lab[$i]['parent_name']?></b>
                <ol>
                    <li style="list-style-type: decimal"><label><input type="checkbox" id="<?php echo $pemeriksaan_lab[$i]['id'];?>" name="pemeriksaan_lab_item[]" class="menu_child menu_child_<?php echo $pemeriksaan_lab[$i]['parent_id']?>" value="<?php echo $pemeriksaan_lab[$i]['id'];?>"/><?php echo $pemeriksaan_lab[$i]['name']?></label>
                    <div style="font-style:italic;font-size:9px"><?php echo $pemeriksaan_lab[$i]['nilai_minimum'] . "&mdash;" . $pemeriksaan_lab[$i]['nilai_maximum'] . " " . $pemeriksaan_lab[$i]['satuan'];?></div>
                    </li>
        <?php else :?>
                </ol>
            </li>
            <li style="list-style-type:none;">
                <b><?php echo $pemeriksaan_lab[$i]['parent_name']?></b>
                <ol>
                    <li style="list-style-type: decimal"><label><input type="checkbox" id="<?php echo $pemeriksaan_lab[$i]['id'];?>" name="pemeriksaan_lab_item[]" class="menu_child menu_child_<?php echo $pemeriksaan_lab[$i]['parent_id']?>" value="<?php echo $pemeriksaan_lab[$i]['id'];?>"/><?php echo $pemeriksaan_lab[$i]['name']?></label>
                    <div style="font-style:italic;font-size:9px"><?php echo $pemeriksaan_lab[$i]['nilai_minimum'] . "&mdash;" . $pemeriksaan_lab[$i]['nilai_maximum'] . " " . $pemeriksaan_lab[$i]['satuan'];?></div>
                    </li>
        <?php endif;?>
    <?php else :?>
                <li style="list-style-type: decimal"><label><input type="checkbox" id="<?php echo $pemeriksaan_lab[$i]['id'];?>" name="pemeriksaan_lab_item[]" class="menu_child menu_child_<?php echo $pemeriksaan_lab[$i]['parent_id']?>" value="<?php echo $pemeriksaan_lab[$i]['id'];?>"/><?php echo $pemeriksaan_lab[$i]['name']?></label>
                    <div style="font-style:italic;font-size:9px"><?php echo $pemeriksaan_lab[$i]['nilai_minimum'] . "&mdash;" . $pemeriksaan_lab[$i]['nilai_maximum'] . " " . $pemeriksaan_lab[$i]['satuan'];?></div>
                    </li>
    <?php endif;?>
    <?php $k++; endfor;?>
    </ol> 
    </div>
	</fieldset>
    
    <div style="clear:both"></div>
    <div class="tblInput">
    <input type="submit" name="submit" id="pl_submit" value="Simpan" />
            <input type="button" name="Close" id="btnClosePemeriksaanLab" value="  Tutup  " />
    </div>
</form>
<div id="list_pl"></div>
