<script language="javascript">
$(document).ready(function() {
$('.decimal').decimal();

var tmti=1;
function createNextTreatmentInputForButton() {
    //var obj = $('#anamnese_' + yicdi);
    var obj = $('#treatment_pay_' + tmti);
    tmti++;
    //var lix = $('<li/>');
    var td_pertamax = $('<td/>');
    var inputHidden = $('<input type="hidden"/>').attr('name', 'treatment_id[]').attr('id', 'treatment_id_' + tmti);

    var inputTextTreatment = $('<input type="text"/>')
        .attr('name', 'treatment_name[]')
        .attr('id', 'treatment_name_' + tmti)
        .attr('size', '50')
        .attr('onkeypress', "focusNext('treatment_price_" + tmti + "', 'anamnese', this, event)")
        .autocomplete("../visit/general_checkup/get_list_treatment", {
            extraParams: {visit_id: $('#visit_id').val()},
            formatItem: function(data, i, max, term) {
                return data[0] + "<div style='color:red;font-size: 90%;font-style:italic;text-align:right;'>" + data[3] + "</div><div style='color:red;font-size: 90%;font-style:italic;text-align:right;'>" + data[2] + "</div>";
                //return data[0] + "<div style='color:red;font-size: 90%;font-style:italic;text-align:right;'>" + data[2] + "</div>";
		    }
		})
        .result(function(event, data, formatted) {
            inputHidden.val(data[1]);
            inputPrice.val(data[2]);
            inputPay.val(data[2]);
        });

    var inputPrice = $('<input type="text"/>')
        .attr('name', 'treatment_price[]')
        .attr('id', 'treatment_price_' + tmti)
        .attr('size', '10')
        .attr('readonly', 'readonly')
        .css('text-align', 'right')
        .decimal()
        .focus(function(obj) {
			$(this).attr('onkeypress', "focusNext('treatment_name_" + (tmti+1) + "', 'treatment_name_" + tmti + "', this, event)");
        });

    var inputPay = $('<input type="text"/>')
        .attr('name', 'treatment_pay[]')
        .attr('id', 'treatment_pay_' + tmti)
        .attr('size', '10')
        .css('text-align', 'right')
        .decimal()
        .focus(function(obj) {
			$(this).attr('onkeypress', "focusNext('treatment_name_" + (tmti+1) + "', 'treatment_name_" + tmti + "', this, event)");
        });

    var imgx = $('<img/>').attr('src', '../webroot/media/images/close.png').bind('click', function() {
		$(this).parent().parent().remove();
    });

    td_pertamax.append(inputHidden);
    td_pertamax.append(inputTextTreatment);
    var td_keduax = $('<td/>');
    td_keduax.append(inputPrice);
    var td_ketigax = $('<td/>');
    td_ketigax.append(inputPay);
    obj.after(imgx);
    
    var trx = $('<tr/>').append(td_pertamax).append(td_keduax).append(td_ketigax);
    $('#list_treatments').append(trx);
    inputTextTreatment.focus();
}

    $("input[@type=text]").attr('autocomplete', 'off').focus(function(){this.select();});
    $('#btnCloseGeneral_Checkup').click(function(){
		$('#panel_checkup').hide();
		$('#alergi_container').hide();
		$('#alergi_msg_box').html('');
		$('#panel_checkup_content').children().remove();
		$('#panel_checkup_content').html('<div class="divLoading"></div>');
	});
    
    $("#treatment_name_1").autocomplete("../visit/general_checkup/get_list_treatment", {
            extraParams: {visit_id: $('#visit_id').val()},
            formatItem: function(data, i, max, term) {
                return data[0] + "<div style='color:red;font-size: 90%;font-style:italic;text-align:right;'>" + data[3] + "</div><div style='color:red;font-size: 90%;font-style:italic;text-align:right;'>" + data[2] + "</div>";
		    }
		})
    .result(function(event, data, formatted) {
        $('#treatment_id_1').val(data[1]);
        $('#treatment_price_1').val(data[2]);
        $('#treatment_pay_1').val(data[2]);
    })
    
    $('#link_add_treatment').click(function(e) {
        e.preventDefault();
        createNextTreatmentInputForButton();
    });
    
    $('.button_delete_treatment').click(function() {
        var xconfirm = confirm('Delete this data?');
        if(!xconfirm) {
            return false;
        } else {
            var xid = $(this).prev().val();
            $.ajax({
                type: 'post',
                url:'../visit/general_checkup/delete_treatment',
                data:'id=' + xid,
                dataType: 'json',
                success: function(data) {
                    $("#physic_anamnese").focus();
                }
            });
            $(this).parent().parent().find('input').addClass('deleted');
            $(this).parent().parent().addClass('list_data_deleted');
            $(this).remove();
            setTimeout(function() {$.ajax({
                url:'../kasir/general_checkup/get_total/' + $('#visit_id').val(),
                success: function(data) {
                    $("#total").html(data);
                    $('#frmSearch').submit();
                }
            });}, 30);
        }
    });

    $("#frmGeneral_Checkup").validate({
        rules: {
        },
        submitHandler:
            function(form) {
                $(form).ajaxSubmit({
                    beforeSubmit:function() {disableForm(); enableForm();},
                    dataType: 'json',
                    success:function(data) {
                        show_message('#message', data.msg, data.status);
						//$('#panel_checkup').slideDown('fast');
						//$('#panel_checkup').jqmShow();
						var xurl = '../kasir/checkup/result/' + $('#visit_id').val();
						$('#panel_checkup_content').load(xurl);
                        $('#frmSearch').submit();
                    }
                });
            }
    });
});

</script>
<form method="POST" name="frmGeneral_Checkup" id="frmGeneral_Checkup" action="<?php echo site_url('kasir/general_checkup/process_form')?>">
<input type="hidden" name="visit_id" id="visit_id" value="<?php echo $data['visit_id']?>" />
<div id="message_checkup" style="display:none"></div>
<table class="tblInput">
	<tr>
		<td>
			<fieldset class="used"><legend><?php echo $this->lang->line('label_treatment');?></legend>
				<table id="list_treatments">
					<tr>
						<th style="width:370px"><?php echo $this->lang->line('label_treatment');?></th>
						<th style="width:120px"><?php echo $this->lang->line('label_price');?></th>
						<th style="width:120px">Bayar</th>
					</tr>
					<?php for($i=0;$i<sizeof($treatments);$i++) :?>
						<?php if($treatments[$i]['log'] == 'yes') $className="deleted"; else $className="";?>
						<tr id="li_treatment_saved_<?php echo $treatments[$i]['id']?>" class="list_data_<?php echo $className;?>">
							<td class="list_data_<?php echo $className;?>">

								<input type="text" name="treatment_saved_name[]" id="treatment_saved_name_<?php echo $treatments[$i]['id']?>" size="50" onkeypress="focusNext('price_saved_<?php echo $treatments[$i]['id']?>', 'price_saved_<?php echo $treatments[$i]['id']?>', this, event)" value="<?php echo $treatments[$i]['name']?>" readonly="readonly" class="<?php echo $className?>" />
							</td>
							<td class="list_data_<?php echo $className;?>">
								<input type="text" readonly="readonly" name="price_saved[]" id="price_saved_<?php echo $treatments[$i]['id']?>" size="10" onkeypress="focusNext('treatment_saved_name_<?php echo $treatments[$i]['id']?>', 'treatment_saved_name_<?php echo $treatments[$i]['id']?>', this, event)" value="<?php echo $treatments[$i]['price']?>" style="text-align:right" class="<?php echo $className?>" />
							</td>
							<td class="list_data_<?php echo $className;?>">
								<input type="text" name="pay_saved[]" id="pay_saved_<?php echo $treatments[$i]['id']?>" size="10" onkeypress="focusNext('treatment_saved_name_<?php echo $treatments[$i]['id']?>', 'treatment_saved_name_<?php echo $treatments[$i]['id']?>', this, event)" value="<?php echo empty($treatments[$i]['pay'])?$treatments[$i]['price']:$treatments[$i]['pay'];?>" style="text-align:right" class="<?php echo $className?>" />

								<input type="hidden" name="payment_saved_id[]" value="<?php echo $treatments[$i]['id']?>" />
								<input type="hidden" name="treatment_saved_id[]" value="<?php echo $treatments[$i]['treatment_id']?>" />
								<img src="../webroot/media/images/close.png" alt="Delete" class="button_delete_treatment" />
							</td>
						</tr>
					<?php endfor;?>
					<tr>
						<td>
							<input type="hidden" name="treatment_id[]" id="treatment_id_1" />
							<input type="text" name="treatment_name[]" id="treatment_name_1" size="50" onkeypress="focusNext('treatment_price_1', 'treatment_price_1', this, event)" value="" />
						</td>
						<td>
							<input type="text" readonly="readonly" class="decimal" name="treatment_price[]" id="treatment_price_1" size="10" onkeypress="focusNext('treatment_name_2', 'treatment_name_1', this, event)" value="" style="text-align:right" />
						</td>
						<td>
							<input type="text" class="decimal" name="treatment_pay[]" id="treatment_pay_1" size="10" onkeypress="focusNext('treatment_name_2', 'treatment_name_1', this, event)" value="" style="text-align:right" />
						</td>
					</tr>
				</table>
				<div style="text-align:right"><a href="javascript:void(0)" id="link_add_treatment">Tambah Tindakan</a></div>
			</fieldset>
        </td>
	</tr>
    <tr>
        <td>
            <fieldset class="used">
                <legend>Total</legend>
                <div id="total" style="text-align:right;font-size:14pt;font-weight:bold;">
                <?php echo 'Rp. ' . uangIndo($total) . '<br/>Terbilang : <em>' . terbilang($total) . ' Rupiah</em>';?>
                </div>
            </fieldset>
        </td>
    </tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
    <tr>
        <td></td>
        <td>
            <input type="submit" name="Save" id="SaveGeneral_Checkup" value="  Bayar  " />
            <input type="button" name="Close" id="btnCloseGeneral_Checkup" value="  Tutup  " />
            <?php if($data['paid'] == 'yes') :?>
            <input type="button" name="Cetak" value="  Cetak  " onclick="openPrintPopup('<?php echo site_url("kasir/general_checkup/printout/" . $data["visit_id"]);?>')"/>
            <?php endif;?>
        </td>
    </tr>
</table>
</form>
