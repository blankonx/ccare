<script language="javascript" type="text/javascript">
$(document).ready(function() {
    //LIST 
    $('#pl_permit_day').numeric();
    $('#btnClosePemeriksaanLab').click(function(){$('#panel_checkup').slideUp('fast')});
    $('#list_pl').load('<?php echo base_url()."visit/rawatinap_pemeriksaan_lab/lists/".$data['visit_inpatient_id'];?>');
    /*SICKNESS EXPLANATION FORM*/
    $("#frmSe").validate({
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
                            //openPrintPopup('rawatinap_pemeriksaan_lab/prints/' + data.last_id);
                            $('#list_pl').load('../visit/rawatinap_pemeriksaan_lab/lists/<?php echo $data['visit_inpatient_id']?>');
                        }
                    }
                });
            }
    });
});
</script>
<div id="message_pl"></div>
<form method="post" name="frmSe" id="frmSe" action="<?php echo site_url('visit/rawatinap_pemeriksaan_lab/process_form_pl')?>">
<input type="hidden" name="pl_visit_id" id="pl_visit_id" value="<?php echo $data['visit_id']?>" />
<input type="hidden" name="pl_visit_inpatient_id" id="pl_visit_inpatient_id" value="<?php echo $data['visit_inpatient_id']?>" />
<input type="hidden" name="pl_visit_inpatient_clinic_id" id="pl_visit_inpatient_clinic_id" value="<?php echo $data['visit_inpatient_clinic_id']?>" />
    <fieldset class="used">
	<legend>Jenis Pemeriksaan</legend>
    <div style="float:left;width:300px" class="tblInput">
    <ol>
    <?php for($i=0;$i<sizeof($rawatinap_pemeriksaan_lab);$i++) :?>
    <?php if($rawatinap_pemeriksaan_lab[$i]['parent_id'] > 2) break;?>

    <?php if($rawatinap_pemeriksaan_lab[$i]['parent_name'] != $rawatinap_pemeriksaan_lab[$i-1]['parent_name']) :?>
        <?php if($i == 0) :?>
            <li style="list-style-type:none;">
                <b><?php echo $rawatinap_pemeriksaan_lab[$i]['parent_name']?></b>
                <ol>
                    <li style="list-style-type: decimal"><label><input type="checkbox" id="<?php echo $rawatinap_pemeriksaan_lab[$i]['id'];?>" name="rawatinap_pemeriksaan_lab_item[]" class="menu_child menu_child_<?php echo $rawatinap_pemeriksaan_lab[$i]['parent_id']?>" value="<?php echo $rawatinap_pemeriksaan_lab[$i]['id'];?>"/><?php echo $rawatinap_pemeriksaan_lab[$i]['name']?></label></li>
        <?php else :?>
                </ol>
            </li>
            <li style="list-style-type:none;">
                <b><?php echo $rawatinap_pemeriksaan_lab[$i]['parent_name']?></b>
                <ol>
                    <li style="list-style-type: decimal"><label><input type="checkbox" id="<?php echo $rawatinap_pemeriksaan_lab[$i]['id'];?>" name="rawatinap_pemeriksaan_lab_item[]" class="menu_child menu_child_<?php echo $rawatinap_pemeriksaan_lab[$i]['parent_id']?>" value="<?php echo $rawatinap_pemeriksaan_lab[$i]['id'];?>"/><?php echo $rawatinap_pemeriksaan_lab[$i]['name']?></label></li>
        <?php endif;?>
    <?php else :?>
                <li style="list-style-type: decimal"><label><input type="checkbox" id="<?php echo $rawatinap_pemeriksaan_lab[$i]['id'];?>" name="rawatinap_pemeriksaan_lab_item[]" class="menu_child menu_child_<?php echo $rawatinap_pemeriksaan_lab[$i]['parent_id']?>" value="<?php echo $rawatinap_pemeriksaan_lab[$i]['id'];?>"/><?php echo $rawatinap_pemeriksaan_lab[$i]['name']?></label></li>
    <?php endif;?>
    <?php endfor;?>
    </ol> 
    </div>
    
    <div style="float:left;width:300px" class="tblInput">
    <ol>
    <?php $j=0; for($i=0;$i<sizeof($rawatinap_pemeriksaan_lab);$i++) :?>
    <?php if($rawatinap_pemeriksaan_lab[$i]['parent_id'] < 3) continue; if($rawatinap_pemeriksaan_lab[$i]['parent_id'] > 5) continue;?>

    <?php if($rawatinap_pemeriksaan_lab[$i]['parent_name'] != $rawatinap_pemeriksaan_lab[$i-1]['parent_name']) :?>
        <?php if($j == 0) :?>
            <li style="list-style-type:none">
                <b><?php echo $rawatinap_pemeriksaan_lab[$i]['parent_name']?></b>
                <ol>
                    <li style="list-style-type: decimal"><label><input type="checkbox" id="<?php echo $rawatinap_pemeriksaan_lab[$i]['id'];?>" name="rawatinap_pemeriksaan_lab_item[]" class="menu_child menu_child_<?php echo $rawatinap_pemeriksaan_lab[$i]['parent_id']?>" value="<?php echo $rawatinap_pemeriksaan_lab[$i]['id'];?>"/><?php echo $rawatinap_pemeriksaan_lab[$i]['name']?></label></li>
        <?php else :?>
                </ol>
            </li>
            <li style="list-style-type:none;">
                <b><?php echo $rawatinap_pemeriksaan_lab[$i]['parent_name']?></b>
                <ol>
                    <li style="list-style-type: decimal"><label><input type="checkbox" id="<?php echo $rawatinap_pemeriksaan_lab[$i]['id'];?>" name="rawatinap_pemeriksaan_lab_item[]" class="menu_child menu_child_<?php echo $rawatinap_pemeriksaan_lab[$i]['parent_id']?>" value="<?php echo $rawatinap_pemeriksaan_lab[$i]['id'];?>"/><?php echo $rawatinap_pemeriksaan_lab[$i]['name']?></label></li>
        <?php endif;?>
    <?php else :?>
                <li style="list-style-type: decimal"><label><input type="checkbox" id="<?php echo $rawatinap_pemeriksaan_lab[$i]['id'];?>" name="rawatinap_pemeriksaan_lab_item[]" class="menu_child menu_child_<?php echo $rawatinap_pemeriksaan_lab[$i]['parent_id']?>" value="<?php echo $rawatinap_pemeriksaan_lab[$i]['id'];?>"/><?php echo $rawatinap_pemeriksaan_lab[$i]['name']?></label></li>
    <?php endif;?>
    <?php $j++; endfor;?>
    </ol> 
    </div>


    <div style="float:left;width:300px" class="tblInput">
    <ol>
    <?php $k=0; for($i=0;$i<sizeof($rawatinap_pemeriksaan_lab);$i++) : ?>
    <?php if($rawatinap_pemeriksaan_lab[$i]['parent_id'] < 6) continue;?>

    <?php if($rawatinap_pemeriksaan_lab[$i]['parent_name'] != $rawatinap_pemeriksaan_lab[$i-1]['parent_name']) :?>
        <?php if($k == 0) :?>
            <li style="list-style-type:none;">
                <b><?php echo $rawatinap_pemeriksaan_lab[$i]['parent_name']?></b>
                <ol>
                    <li style="list-style-type: decimal"><label><input type="checkbox" id="<?php echo $rawatinap_pemeriksaan_lab[$i]['id'];?>" name="rawatinap_pemeriksaan_lab_item[]" class="menu_child menu_child_<?php echo $rawatinap_pemeriksaan_lab[$i]['parent_id']?>" value="<?php echo $rawatinap_pemeriksaan_lab[$i]['id'];?>"/><?php echo $rawatinap_pemeriksaan_lab[$i]['name']?></label></li>
        <?php else :?>
                </ol>
            </li>
            <li style="list-style-type:none;">
                <b><?php echo $rawatinap_pemeriksaan_lab[$i]['parent_name']?></b>
                <ol>
                    <li style="list-style-type: decimal"><label><input type="checkbox" id="<?php echo $rawatinap_pemeriksaan_lab[$i]['id'];?>" name="rawatinap_pemeriksaan_lab_item[]" class="menu_child menu_child_<?php echo $rawatinap_pemeriksaan_lab[$i]['parent_id']?>" value="<?php echo $rawatinap_pemeriksaan_lab[$i]['id'];?>"/><?php echo $rawatinap_pemeriksaan_lab[$i]['name']?></label></li>
        <?php endif;?>
    <?php else :?>
                <li style="list-style-type: decimal"><label><input type="checkbox" id="<?php echo $rawatinap_pemeriksaan_lab[$i]['id'];?>" name="rawatinap_pemeriksaan_lab_item[]" class="menu_child menu_child_<?php echo $rawatinap_pemeriksaan_lab[$i]['parent_id']?>" value="<?php echo $rawatinap_pemeriksaan_lab[$i]['id'];?>"/><?php echo $rawatinap_pemeriksaan_lab[$i]['name']?></label></li>
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
