<script language="javascript">
$(document).ready(function() {
$('.decimal').decimal();
$('#continue_id').change(function() {
    var val = $(this).val();
    if(val == '003') $('#continue_to').val('Dirujuk ke').show();
    else $('#continue_to').val('').hide();
});
$('#continue_to').click(function() {
    var val = $(this).val();
    if(val == 'Dirujuk ke') {
        $('#continue_to').val('');
    }
});
$('#continue_to').blur(function() {
    var val = $(this).val();
    if(val == '') {
        $('#continue_to').val('Dirujuk ke');
    }
});
getBloodPressureStatus();
getBMI();
function getBloodPressureStatus() {
    var sistoleVal = parseInt($('#sistole').val());
    var diastoleVal = parseInt($('#diastole').val());
    var status;
    if(sistoleVal == "" || diastoleVal == "") return;
    if(sistoleVal <= 120 || diastoleVal <=79) {
        status = 'Normal';
    } else if(sistoleVal <= 139 || diastoleVal <=89) {
        status = 'Pre-Hipertensi';
    } else if(sistoleVal <= 159 || diastoleVal <=99) {
        status = 'HT Stage I';
    } else if(sistoleVal > 159 || diastoleVal >99) {
        status = 'HT Stage II';
    } else {
        status = 'Tidak diketahui';
    }
    $('#blood_pressure_formula_result').html('<span style="color:#000000">Status Tekanan Darah :</span> ' + status);
}
$('#diastole, #sistole').change(function() {
    getBloodPressureStatus();
});

function getBMI() {
    var weightVal = parseFloat($('#weight').val());
    var heightVal = parseFloat($('#height').val())/100;
    var status;
    var nilaiBMI;
    if(weightVal == "" || heightVal == "") return;
    nilaiBMI = weightVal/(heightVal*heightVal);
    if(nilaiBMI < 18.5) {
        status = 'Underweight';
        nilaiBMI = Math.round(nilaiBMI, 2);
    } else if(nilaiBMI >= 18.5 && nilaiBMI <25) {
        status = 'Normal weight';
        nilaiBMI = Math.round(nilaiBMI, 2);
    } else if(nilaiBMI >= 25 || nilaiBMI <30) {
        status = 'Overweight';
        nilaiBMI = Math.round(nilaiBMI, 2);
    } else if(nilaiBMI >= 30) {
        status = 'Obesity';
        nilaiBMI = Math.round(nilaiBMI, 2);
    } else {
        nilaiBMI = '-';
        status = 'Tidak diketahui';
    }
    $('#bmi').text(nilaiBMI + ' ('+ status + ')');
}
$('#weight, #height').change(function() {
    getBMI();
});
var yicdi=1;
function createNextAnamneseIcdInputForButton() {
    var obj = $('#anamnese_' + yicdi);
    yicdi++;
    currAnamneseKey++;
    //alert(currAnamneseKey);
    var lix = $('<td style="border-bottom:solid 1px #000000;"/>');
    //lix = lix.append($('<td>'));
    //alert(lix.html());
    var inputHiddenAnamnese = $('<input type="hidden"/>')
        .attr('name', 'ead_id[' + currAnamneseKey + ']')
        .attr('id', 'ead_id_' + yicdi);

    var inputHidden = $('<input type="hidden"/>')
        .attr('name', 'icd_id[' + currAnamneseKey + ']')
        .attr('id', 'icd_id_' + yicdi);

    var inputHiddenCode = $('<input type="hidden"/>')
        .attr('name', 'icd_code[' + currAnamneseKey + ']')
        .attr('id', 'icd_code_' + yicdi);

    var inputText = $('<input type="text"/>')
        .attr('name', 'icd_name[' + currAnamneseKey + ']')
        .attr('id', 'icd_name_' + yicdi)
        .attr('size', '35')
        .attr('onkeypress', "focusNext('explanation_" + yicdi + "', 'anamnese', this, event)");


    var inputExplanation = $('<input type="text"/>')
        .attr('name', 'explanation[' + currAnamneseKey + ']')
        .attr('id', 'explanation_' + yicdi)
        .attr('size', '35')
        .attr('onkeypress', "focusNext('anamnese_" + yicdi + "', 'icd_name_" + yicdi + "', this, event)");

    var inputSelect = $('<select/>')
        .attr('name', 'case[' + currAnamneseKey + ']')
        .attr('id', 'case_' + yicdi)
        .css('width', 80)
        .html('<option value="new">Kasus Baru</option><option value="old">Kasus Lama</option><option value="kkl">KKL</option>')
        .focus(function(obj) {
            //alert($(this).prev().val());
            if($(this).prev().val() != '') {
                $(this).attr('onkeypress', "focusNext('icd_name_" + yicdi + "', 'icd_name_" + yicdi + "', this, event)");
            }
            else {
                $(this).attr('onkeypress', "focusNext('drug_name_1', 'icd_name_" + yicdi + "', this, event)");
            }
        });

    var inputTextAnamnese = $('<input type="text"/>')
        .attr('name', 'anamnese[' + currAnamneseKey + ']')
        .attr('id', 'anamnese_' + yicdi)
        .attr('size', '47')
		.val('-')
        .attr('onkeypress', "focusNext('icd_name_" + yicdi + "', 'physic_anamnese', this, event)")
        .autocomplete("../visit/general_checkup/get_list_anamnese", {
            extraParams: {visit_id: $('#visit_id').val()},
            selectFirst: false,
            matchContains: true,
            highlightItem: false,
            formatItem: function(data, i, max, term) {
                return data[2] + "<div style='color:red;font-size: 90%;font-style:italic;text-align:right;'>" + data[4] + "</div>";
		    },
            formatResult: function(data) {
                return data[3];
		    }
        })
        .result(function(event, data, formatted) {
            inputHiddenAnamnese.val(data[0]);
			inputHidden.val(data[1]);
			inputText.val(data[4]);
			inputSelect.val(data[5]);
			inputHiddenCode.val(data[6]);
        });


    var imgx = $('<img/>').attr('src', '../webroot/media/images/close.png').bind('click', function() {
        $(this).parent().parent().remove();
    });

    inputText.autocomplete("../visit/general_checkup/get_list_icd", {
        formatItem: function(data, i, max, term) {
            return data[2] + " " + data[0];
		}
	})
	.result(function(event, data, formatted) {
        inputHidden.val(data[1]);
        inputHiddenCode.val(data[2]);
        inputHiddenAnamnese.val('');
        //CHECK IN DATABASE, IS HE PERNAH MENDERITA PENYAKIT INI (MENENTUKAN KASUS BARU LAMA OTOMATIS)
        $.ajax({
            url: '../visit/general_checkup/get_new_old_case',
            type: 'post',
            data: 'visit_id=' + $('#visit_id').val() + '&q=' + data[1],
            success : function(data) {
                inputSelect.val(data);
            }
        });
        //createNextIcdInput(inputText);
    });


    lix.append("\n");
    lix.append(inputTextAnamnese)
    .append(inputHiddenAnamnese)
    .append(inputText)
    .append(inputSelect)
    .append(inputHidden)
    .append(inputHiddenCode)
    .append(inputExplanation);

    //obj.attr('readonly', 'readonly');
    obj.after(imgx);
    var td_pertamax = $('<td style="width:100px">Anamnesa :<br/>Diagnosa :<br/>Catatan :<br/></td>');
    var xlix = $('<tr/>').append(td_pertamax).append(lix);
    $('#ol_list_anamnese_diagnose').append(xlix);
    inputTextAnamnese.focus();
}

var currAnamneseKey=0;
var icdi=1;

var drugi=1;
function createNextDrugInputForButton() {
    var obj = $('#unit_' + drugi);
    drugi++;
	//alert('drugi : ' + drugi);
    var inputTextDrug = $('<input type="text"/>')
        .attr('name', 'drug_name[]')
        .attr('id', 'drug_name_' + drugi)
        .attr('size', '30')
        .attr('onkeypress', "focusNext('dosis1_" + drugi + "', 'anamnese', this, event)");

    var inputHidden = $('<input type="hidden"/>').attr('name', 'drug_id[]').attr('id', 'drug_id_' + drugi);

    var inputDosis1 = $('<input type="text"/>')
        .attr('name', 'dosis1[]')
        .attr('id', 'dosis1_' + drugi)
        .attr('size', '3')
        .css('text-align', 'right')
        .attr('onkeypress', "focusNext('dosis2_" + drugi + "', 'drug_name_" + drugi + "', this, event)")
        .decimal();

    var inputDosis2 = $('<input type="text"/>')
        .attr('name', 'dosis2[]')
        .attr('id', 'dosis2_' + drugi)
        .attr('size', '3')
        .css('text-align', 'right')
        .attr('onkeypress', "focusNext('qty_" + drugi + "', 'dosis1_" + drugi + "', this, event)")
        .decimal();

    var inputQty = $('<input type="text"/>')
        .attr('name', 'qty[]')
        .attr('id', 'qty_' + drugi)
        .attr('size', '3')
        .css('text-align', 'right')
        .decimal()
        .attr('onkeypress', "focusNext('unit_" + drugi + "', 'dosis2_" + drugi + "', this, event)")

    var inputUnit = $('<input type="text"/>')
        .attr('name', 'unit[]')
        .attr('id', 'unit_' + drugi)
        .attr('size', '5')
        .focus(function(obj) {
			$(this).attr('onkeypress', "focusNext('drug_name_" + (drugi+1) + "', 'dosis2_" + drugi + "', this, event)");
        });

    var imgx = $('<img/>').attr('src', '../webroot/media/images/close.png').bind('click', function() {
        $(this).parent().parent().remove();
    });

    inputTextDrug
	.autocomplete("../visit/general_checkup/get_list_drug", {
        extraParams: {visit_id: $('#visit_id').val()},
		formatItem: function(data, i, max, term) {
			return data[0] + "<div style='color:red;font-size: 90%;font-style:italic;text-align:right;'>Stock : " + data[3] + "</div>";
		},
		formatResult: function(data) {
			return data[0];
		}
	})
    .result(function(event, data, formatted) {
        inputHidden.val(data[1]);
        //$(this).parent().append(data[2]);
        inputUnit.val(data[2]);
        inputDosis1.val('3');
        inputDosis2.val('1');
        inputQty.val('');
    });

    //inputQty.;

    var td_satu = $('<td/>')
    .append(inputTextDrug)
    .append(inputHidden);
    
    var td_dua = $('<td/>')
    .append(inputDosis1)
    .append('x')
    .append(inputDosis2);

    var td_tiga = $('<td/>')
    .append(inputQty)
    .append(inputUnit);

    obj.after(imgx);
	var trx = $('<tr/>')
	.append(td_satu)
	.append(td_dua)
	.append(td_tiga);
	
    $('#list_prescribes').append(trx);
    inputTextDrug.focus();
    
}

var tmti=1;
function createNextTreatmentInputForButton() {
    //var obj = $('#anamnese_' + yicdi);
    var obj = $('#treatment_price_' + tmti);
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
        });

    var inputPrice = $('<input type="text"/>')
        .attr('name', 'treatment_price[]')
        .attr('id', 'treatment_price_' + tmti)
        .attr('size', '10')
        .attr('readonly','readonly')
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
    obj.after(imgx);
    
    var trx = $('<tr/>').append(td_pertamax).append(td_keduax);
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
    $('#sistole').decimal();
    $('#diastole').decimal();
    $('#temperature').decimal();
    $('#respiration').decimal();
    $('#weight').decimal();
    $('#height').decimal();

    $('#link_add_anamnese_diagnose').click(function(e) {
        e.preventDefault();
        createNextAnamneseIcdInputForButton();
    });
    $("#anamnese_1").autocomplete("../visit/general_checkup/get_list_anamnese", {
            extraParams: {visit_id: $('#visit_id').val()},
            formatItem: function(data, i, max, term) {
                return data[2] + "<div style='color:red;font-size: 90%;font-style:italic;text-align:right;'>" + data[4] + "</div>";
		    },
            formatResult: function(data) {
                return data[3];
		    }
		})
		.result(function(event, data, formatted) {
			$('#ead_id_1').val(data[0]);
			$('#icd_id_1').val(data[1]);
			$('#icd_name_1').val(data[4]);
			$('#case_1').val(data[5]);
			$('#icd_code_1').val(data[6]);
            //if(data[0])
			    
    });
//AUTO COMPLETE THE ICD
    $("#icd_name_1").autocomplete("../visit/general_checkup/get_list_icd", {
        formatItem: function(data, i, max, term) {
            return data[2] + " " + data[0];
		}
	})
    .result(function(event, data, formatted) {
        $('#icd_id_1').val(data[1]);
        $('#icd_code_1').val(data[2]);
        $('#ead_id_1').val('');
        //CHECK IN DATABASE, IS HE PERNAH MENDERITA PENYAKIT INI (MENENTUKAN KASUS BARU LAMA OTOMATIS)
        $.ajax({
            url: '../visit/general_checkup/get_new_old_case',
            type: 'post',
            data: 'visit_id=' + $('#visit_id').val() + '&q=' + data[1],
            success : function(data) {
                $('#case_1').val(data);
            }
        });
    });

    $("#drug_name_1")
	.autocomplete("../visit/general_checkup/get_list_drug", {
        extraParams: {visit_id: $('#visit_id').val()},
		formatItem: function(data, i, max, term) {
			return data[0] + "<div style='color:red;font-size: 90%;font-style:italic;text-align:right;'>Stock : " + data[3] + "</div>";
		},
		formatResult: function(data) {
			return data[0];
		}
	})
    .result(function(event, data, formatted) {
        //drugi=1;
        $('#drug_id_1').val(data[1]);
        $('#dosis1_1').val('3');
        $('#dosis2_1').val('1');
        $('#qty_1').val('');
        $('#unit_1').val(data[2]);
    });
    $('#dosis1_1').numeric();
    $('#dosis2_1').decimal();
    $('#qty_1').numeric();
    $('#link_add_prescribe').click(function(e) {
        e.preventDefault();
        createNextDrugInputForButton();
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
    })
    
    $('#link_add_treatment').click(function(e) {
        e.preventDefault();
        createNextTreatmentInputForButton();
    });
    //preparing button delete saved
    $('.button_delete_anamnese_diagnose').click(function() {
        var xconfirm = confirm('Delete this data?');
        if(!xconfirm) {
            return false;
        } else {
            var xid = $(this).next().next().next().val();
            $.ajax({
                type: 'post',
                url:'../visit/general_checkup/delete_anamnese_diagnose',
                data:'id=' + xid,
                dataType: 'json',
                success: function(data) {
                    $("#physic_anamnese").focus();
                }
            });
            $(this).parent().parent().find('input').addClass('deleted');
            $(this).parent().parent().addClass('list_data_deleted');
            $(this).remove();
        }
    });
    
    $('.button_delete_prescribe').click(function() {
        var xconfirm = confirm('Delete this data?');
        if(!xconfirm) {
            return false;
        } else {
            var xid = $(this).prev().val();
            $.ajax({
                type: 'post',
                url:'../visit/general_checkup/delete_prescribe',
                data:'id=' + xid,
                dataType: 'json',
                success: function(data) {
                    //show_message('#message_checkup', data.msg, data.status);
                    $("#physic_anamnese").focus();
                }
            });
            $(this).parent().parent().find('input').addClass('deleted');
            $(this).parent().parent().addClass('list_data_deleted');
            $(this).remove();
        }
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
        }
    });
    //log
    $('#showHideLog').change(function() {
        if(document.getElementById('showHideLog').checked == true) {
            $('.list_data_deleted').hide();
        } else {
            $('.list_data_deleted').show();
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
						var xurl = '../visit/checkup/result/' + $('#visit_id').val();
						$('#panel_checkup_content').load(xurl);
                        $('#frmSearch').submit();
                            /*
                        $('#panel_checkup').slideUp('slow', function() {
                        });
                        */
                    }
                });
            }
    });
//}
//prepareGeneral_Checkup();

/*
18.11.2009
MIX MIX MIX NEW
*/
	
    var randomnum = Math.floor(Math.random()*666666666);
    //$('#mix_name_1');
    
    $('#addMix').click(function(e) {
        e.preventDefault();
        createNextMixInputForButton();
    });
    $('#link_add_prescribe_mix_drug').click(function(e) {
        e.preventDefault();
        createNextMixDrugInputForButton($(this));
	})
	.attr('title', randomnum);
	$('.link_add_prescribe_saved_mix_drug').click(function(e) {
        e.preventDefault();
        createNextMixDrugInputForButton($(this));
	});
	$('.button_delete_prescribe_saved_mix').click(function(e) {
        var xconfirm = confirm('Delete this data?');
        if(!xconfirm) {
            return false;
        } else {
            var randomnumber = $(this).prev().val();
            $.ajax({
                type: 'post',
                url:'../visit/general_checkup/delete_prescribe_mix',
                data:'randomnumber=' + randomnumber + '&visit_id=' + $('#visit_id').val(),
                dataType: 'json',
                success: function(data) {
                    $("#physic_anamnese").focus();
                }
            });
            $(this).parent().parent().parent().find('input').addClass('deleted');
            $(this).parent().parent().parent().addClass('list_data_deleted');
            $(this).parent().parent().parent().find('img').remove();
            $(this).remove();
        }
	});
	$('#mix_name_1').parent().parent().parent().removeAttr('alt').attr('alt', randomnum);
	$('#mix_name_1').removeAttr('name').attr('name', 'mix_name['+ randomnum +']');
	$('#mix_dosis1_1').removeAttr('name').attr('name', 'mix_dosis1['+ randomnum +']');
	$('#mix_dosis2_1').removeAttr('name').attr('name', 'mix_dosis2['+ randomnum +']');
	
	$('#mix_qty_qty_1').removeAttr('name').attr('name', 'mix_qty_qty['+ randomnum +']');
	$('#mix_unit_unit_1').removeAttr('name').attr('name', 'mix_unit_unit['+ randomnum +']');
	$('#mix_randomnumber_1').removeAttr('name').attr('name', 'mix_randomnumber['+ randomnum +']').val(randomnum);
	
	
	$('#mix_drug_name_1').removeAttr('name').attr('name', 'mix_drug_name['+ randomnum +'][]')
	.autocomplete("../visit/general_checkup/get_list_drug", {
        extraParams: {visit_id: $('#visit_id').val()},
		formatItem: function(data, i, max, term) {
			return data[0] + "<div style='color:red;font-size: 90%;font-style:italic;text-align:right;'>Stock : " + data[3] + "</div>";
		},
		formatResult: function(data) {
			return data[0];
		}
	})
	.result(function(event, data, formatted) {
		$('#mix_drug_id_1').val(data[1]);
		$('#mix_unit_1').val(data[2]);
		$('#mix_qty_1').val('');
	});
	$('#mix_drug_id_1').removeAttr('name').attr('name', 'mix_drug_id['+ randomnum +'][]');
	$('#mix_qty_1').removeAttr('name').attr('name', 'mix_qty['+ randomnum +'][]');
	$('#mix_unit_1').removeAttr('name').attr('name', 'mix_unit['+ randomnum +'][]');
    var mixi=1;
    
    function createNextMixInputForButton() {
		randomnum = Math.floor(Math.random()*666666666);
        var obj = $('#mix_unit_unit_' + mixi);
        mixi++;
        var inputMixName = $('<input type="text"/>')
            .attr('name', 'mix_name['+randomnum+']')
            .attr('id', 'mix_name_' + mixi)
            .attr('size', '30');
            
        var inputRandomNumber = $('<input type="hidden"/>')
            .attr('name', 'mix_randomnumber['+randomnum+']')
            .val(randomnum)
            .attr('id', 'mix_randomnumber_' + mixi);

		var inputDosis1 = $('<input type="text"/>')
			.attr('name', 'mix_dosis1['+randomnum+']')
			.attr('id', 'mix_dosis1_' + mixi)
			.attr('size', '3')
			.css('text-align', 'right')
			.decimal();

		var inputDosis2 = $('<input type="text"/>')
			.attr('name', 'mix_dosis2['+randomnum+']')
			.attr('id', 'mix_dosis2_' + mixi)
			.attr('size', '3')
			.css('text-align', 'right')
			.decimal();

		var inputMixQty = $('<input type="text"/>')
			.attr('name', 'mix_qty_qty['+randomnum+']')
			.attr('id', 'mix_qty_qty_' + mixi)
			.attr('size', '3')
			.css('text-align', 'right')
			.decimal();
			
		var inputMixUnit = $('<input type="text"/>')
			.attr('name', 'mix_unit_unit['+randomnum+']')
			.attr('id', 'mix_unit_unit_' + mixi)
			.attr('size', '5');
			
        var imgx = $('<img/>').attr('src', '../webroot/media/images/close.png').bind('click', function() {
            $(this).parent().parent().parent().remove();
        });
        
        var linkx = $('<a/>').attr('href', 'javascript:void(0)').attr('title', randomnum).text('Tambah Obat').bind('click', function() {
            createNextMixDrugInputForButton($(this));
        });

        var td_satu = $('<td/>')
        .append(inputMixName)
        .append(inputRandomNumber);
        var td_dua =  $('<td/>')
        .append(inputDosis1)
        .append('x')
        .append(inputDosis2);
        var td_tiga =  $('<td/>')
        .append(inputMixQty)
        .append(inputMixUnit);
        var td_empat =  $('<td/>')
        .append(linkx);
        
        obj.next(imgx);
        
        var trx = $('<tr/>')
        .append(td_satu)
        .append(td_dua)
        .append(td_tiga)
        .append(td_empat);
        var tbodyx = $('<tbody attr="'+randomnum+'"/>')
        .append(trx);
        obj.parent().after().append(imgx);
        $('#list_prescribes_mix').append(tbodyx);
    }
	var mixdrugi=1;
	
	function createNextMixDrugInputForButton(xlinkObj) {
		//alert(xlink.parent().parent().parent().attr('alt'));
		var temprandomnum = xlinkObj.attr('title');
		var obj = $('#mix_drug_id_' + mixdrugi);
		mixdrugi++;
		//alert('mixdrugi : ' + mixdrugi);
		var inputTextDrug = $('<input type="text"/>')
			.attr('name', 'mix_drug_name['+temprandomnum+'][]')
			.attr('id', 'mix_drug_name_' + mixdrugi)
			.attr('size', '45');

		var inputHidden = $('<input type="hidden"/>').attr('name', 'mix_drug_id['+temprandomnum+'][]').attr('id', 'mix_drug_id_' + mixdrugi);

		var inputQty = $('<input type="text"/>')
			.attr('name', 'mix_qty['+temprandomnum+'][]')
			.attr('id', 'mix_qty_' + mixdrugi)
			.attr('size', '3')
			.css('text-align', 'right')
			.decimal();

		var inputUnit = $('<input type="text"/>')
			.attr('name', 'mix_unit['+temprandomnum+'][]')
			.attr('id', 'mix_unit_' + mixdrugi)
			.attr('size', '5')
			.attr('readonly', 'readonly')
			.attr('class', 'readonly2');

		var imgx = $('<img/>').attr('src', '../webroot/media/images/close.png').bind('click', function() {
			$(this).parent().parent().remove();
		});

		inputTextDrug
		.autocomplete("../visit/general_checkup/get_list_drug", {
            extraParams: {visit_id: $('#visit_id').val()},
			formatItem: function(data, i, max, term) {
				return data[0] + "<div style='color:red;font-size: 90%;font-style:italic;text-align:right;'>Stock : " + data[3] + "</div>";
			},
			formatResult: function(data) {
				return data[0];
			}
		})
		.result(function(event, data, formatted) {
			inputHidden.val(data[1]);
			inputUnit.val(data[2]);
			inputQty.val('');
		});

		//inputQty.;

		var td_satu = $('<td colspan="2"/>')
		.append('&bull;')
		.append(inputTextDrug);
		

		var td_tiga = $('<td/>')
		.append(inputQty)
		.append(inputUnit)
		.append(inputHidden);

		obj.after(imgx);
		var trx = $('<tr/>')
		.append(td_satu)
		.append(td_tiga);
		
		xlinkObj.parent().parent().parent().append(trx);
		inputTextDrug.focus();
	}
});

function enableDisableSupernumery(obj) {
	if(obj.checked == true) {
		var val = obj.value;
		if(val == 'Ada' || val == 'undefined') {
			$('#ada_supernumery').attr('readonly', false);
			$('#ada_supernumery').removeClass();
		} else {
			$('#ada_supernumery').attr('readonly', true);
			$('#ada_supernumery').removeClass().addClass('readonly');
			$('#ada_supernumery').val('');
		}
	}
}
</script>
<form method="POST" name="frmGeneral_Checkup" id="frmGeneral_Checkup" action="<?php echo site_url('visit/general_checkup/process_form')?>">
<input type="hidden" name="visit_id" id="visit_id" value="<?php echo $data['visit_id']?>" />
<div id="message_checkup" style="display:none"></div>
<table class="tblInput" style="width:100%;">
	<tr>
		<td style="width:45%;">
		
			<fieldset class="used"><legend><?php echo $this->lang->line('label_physic_anamnese');?></legend>
				<div class="tblInput">
					<textarea name="physic_anamnese" id="physic_anamnese" cols="45" rows="3" onkeypress="focusNext('sistole', 'sistole', this, event)"><?php echo $checkup['physic_anamnese']?></textarea>
				</div>
			</fieldset>
		</td>
		
		<?php
		/*
		 * ini buat batam, klo gigi disembunyikan
		 * */
		if($data['clinic_id'] == 2) $hide_for_gigi = "visibility:hidden;display:none;";
		//if($data['clinic_id'] <> 2) $hide_for_umum = "visibility:hidden;display:none;"; 
		?>
		<td >
		
			<fieldset class="used"><legend>Vital Sign</legend>
				<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
					<tr>
						<td style="width:50px;"><?php echo $this->lang->line('label_blood_pressure');?></td>
						<td>
							<input type="text" name="sistole" id="sistole" size="5" maxlength="6" onkeypress="focusNext('diastole', 'height', this, event)" value="<?php echo $checkup['sistole']?>" style="text-align:right" /> / 
							<input type="text" name="diastole" id="diastole" size="5" maxlength="6" onkeypress="focusNext('temperature', 'sistole', this, event)" value="<?php echo $checkup['diastole']?>" style="text-align:right" /> mmhg<br/>
                            <div id="blood_pressure_formula_result" style="color:#FF0000"></div>
						</td>
					</tr>
					
					<tr style="<?php echo $hide_for_gigi?>">
						<td><?php echo $this->lang->line('label_temperature');?></td>
						<td>
							<input type="text" name="temperature" id="temperature" size="7" maxlength="6" onkeypress="focusNext('pulse', 'diastole', this, event)" value="<?php echo $checkup['temperature']?>" style="text-align:right" /> &ordm; C
						</td>
					</tr>
					<tr style="<?php echo $hide_for_gigi?>">
						<td><?php echo $this->lang->line('label_pulse');?></td>
						<td>
							<input type="text" name="pulse" id="pulse" size="7" maxlength="6" onkeypress="focusNext('respiration', 'temperature', this, event)" value="<?php echo $checkup['pulse']?>" style="text-align:right" /> x/mnt
						</td>
					</tr>
					<tr style="<?php echo $hide_for_gigi?>">
						<td><?php echo $this->lang->line('label_respiration');?></td>
						<td>
							<input type="text" name="respiration" id="respiration" size="7" maxlength="6" onkeypress="focusNext('blood_type', 'pulse', this, event)" value="<?php echo $checkup['respiration']?>" style="text-align:right" /> x/mnt
						</td>
					</tr>
					<tr>
						<td>Golongan Darah</td>
						<td>
							<input type="text" name="blood_type" id="blood_type" size="3" maxlength="2" onkeypress="focusNext('weight', 'respiration', this, event)" value="<?php echo $checkup['blood_type']?>" style="text-align:right" />
						</td>
					</tr>
				</table>
			</fieldset>
		</td>
	
		<td>

			<fieldset class="used" style="<?php echo $hide_for_gigi?>"><legend>Physics</legend>
				<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
					<tr>
						<td style="width:90px;"><?php echo $this->lang->line('label_weight');?></td>
						<td>
							<input type="text" name="weight" id="weight" size="7" maxlength="6" onkeypress="focusNext('height', 'respiration', this, event)" value="<?php echo $checkup['weight']?>" style="text-align:right" /> Kg
						</td>
					</tr>
					<tr>
						<td><?php echo $this->lang->line('label_height');?></td>
						<td>
							<input type="text" name="height" id="height" size="7" maxlength="6" onkeypress="focusNext('anamnese_1', 'weight', this, event)" value="<?php echo $checkup['height']?>" style="text-align:right" /> Cm
						</td>
					</tr>
					<tr>
						<td>BMI</td>
						<td id="bmi" style="color:#FF0000;"></td>
					</tr>
				</table>
			</fieldset>			
		</td>
	</tr>
	<tr>
	<?php
		if($data['clinic_id'] <> 2) $hide_for_umum = "visibility:hidden;display:none;";
		?>
		<td style="width:45%;<?php echo $hide_for_umum?>">
		<?php $odontogram = explode("|",$checkup['odontogram_kode']);?>
		<fieldset class="used"><legend>ODONTOGRAM</legend>
				<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
					<tr>
						<td>
							<input type="checkbox" name="odontogram[]" id="odontogram" value="18" <?php echo in_array('18',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_18');?></label>
						</td>
						<td>
							<input type="checkbox" name="odontogram[]" id="odontogram" value="17" <?php echo in_array('17',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_17');?></label>
						</td>
						<td>
							<input type="checkbox" name="odontogram[]" id="odontogram" value="16" <?php echo in_array('16',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_16');?></label>
						</td>
						<td>
							<input type="checkbox" name="odontogram[]" id="odontogram" value="15" <?php echo in_array('15',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_15');?></label>
						</td>
						<td>
							<input type="checkbox" name="odontogram[]" id="odontogram" value="14" <?php echo in_array('14',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_14');?></label>
						</td>
						<td>
							<input type="checkbox" name="odontogram[]" id="odontogram" value="13"  <?php echo in_array('13',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_13');?></label>
						</td>
						<td>
							<input type="checkbox" name="odontogram[]" id="odontogram" value="12"  <?php echo in_array('12',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_12');?></label>
						</td>
						<td>
							<input type="checkbox" name="odontogram[]" id="odontogram" value="11"  <?php echo in_array('11',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_11');?></label>
						</td>
						<td>
							<input type="checkbox" name="odontogram[]" id="odontogram" value="21"  <?php echo in_array('21',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_21');?></label>
						</td>
						<td>
							<input type="checkbox" name="odontogram[]" id="odontogram" value="22"  <?php echo in_array('22',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_22');?></label>
						</td>
						<td>
							<input type="checkbox" name="odontogram[]" id="odontogram" value="23"  <?php echo in_array('23',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_23');?></label>
						</td>
						<td>
							<input type="checkbox" name="odontogram[]" id="odontogram" value="24"  <?php echo in_array('24',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_24');?></label>
						</td>
						<td>
							<input type="checkbox" name="odontogram[]" id="odontogram" value="25"  <?php echo in_array('25',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_25');?></label>
						</td>
						<td>
							<input type="checkbox" name="odontogram[]" id="odontogram" value="26"  <?php echo in_array('26',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_26');?></label>
						</td>
						<td>
							<input type="checkbox" name="odontogram[]" id="odontogram" value="27"  <?php echo in_array('27',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_27');?></label>
						</td>
						<td>
							<input type="checkbox" name="odontogram[]" id="odontogram" value="28"  <?php echo in_array('28',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_28');?></label>
						</td>
					
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="55"  <?php echo in_array('55',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_55');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="54"  <?php echo in_array('54',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_54');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="53"  <?php echo in_array('53',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_53');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="52"  <?php echo in_array('52',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_52');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="51"  <?php echo in_array('51',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_51');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="61"  <?php echo in_array('61',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_61');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="62"  <?php echo in_array('62',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_62');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="63"  <?php echo in_array('63',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_63');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="64"  <?php echo in_array('64',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_64');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="65"  <?php echo in_array('65',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_65');?></label>
						</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td><input type="checkbox" name="odontogram[]" id="odontogram" value="85"  <?php echo in_array('85',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_85');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="84"  <?php echo in_array('84',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_84');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="83"  <?php echo in_array('83',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_83');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="82"  <?php echo in_array('82',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_82');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="81"  <?php echo in_array('81',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_81');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="71"  <?php echo in_array('71',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_71');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="72"  <?php echo in_array('72',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_72');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="73"  <?php echo in_array('73',$odontogram)?'checked="checked"':''?>/>
							<label for="odontogram"><?php echo $this->lang->line('label_73');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="74"  <?php echo in_array('74',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_74');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="75"  <?php echo in_array('75',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_75');?></label>
						</td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td>
							<input type="checkbox" name="odontogram[]" id="odontogram" value="48"  <?php echo in_array('48',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_48');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="47"  <?php echo in_array('47',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_47');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="46"  <?php echo in_array('46',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_46');?></label>
						</td>
						<td>
							<input type="checkbox" name="odontogram[]" id="odontogram" value="45"  <?php echo in_array('45',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_45');?></label>
						</td>
						<td>
							<input type="checkbox" name="odontogram[]" id="odontogram" value="44"  <?php echo in_array('44',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_44');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="43"  <?php echo in_array('43',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_43');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="42"  <?php echo in_array('42',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_42');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="41"  <?php echo in_array('41',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_41');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="31"  <?php echo in_array('31',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_31');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="32"  <?php echo in_array('32',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_32');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="33"  <?php echo in_array('33',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_33');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="34"  <?php echo in_array('34',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_34');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="35"  <?php echo in_array('35',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_35');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="36"  <?php echo in_array('36',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_36');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="37"  <?php echo in_array('37',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_37');?></label>
						</td>
						<td>
						<input type="checkbox" name="odontogram[]" id="odontogram" value="38"  <?php echo in_array('38',$odontogram)?'checked="checked"':''?> />
							<label for="odontogram"><?php echo $this->lang->line('label_38');?></label>			
						</td>
					</tr>
				</table>
			</fieldset>
		</td>
		<td>
		<fieldset class="used" style="<?php echo $hide_for_umum?>"><legend>Pemeriksaan Subyektif</legend>
				<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
					<tr>
						<td style="width:140px;"><?php echo $this->lang->line('label_oclusi');?></td>
						<td>
							<input type="radio" name="oclusi" id="oclusi" checked="checked" value="Normal-Bite" 
							<?php echo ($checkup['oclusi']=='Normal-Bite')?'checked="checked"':''?>/>
							<label for="oclusi"><?php echo $this->lang->line('label_normal_bite');?></label>
							<input type="radio" name="oclusi" id="oclusi" value="Cros-Bite" <?php echo ($checkup['oclusi']=='Cros-Bite')?'checked="checked"':''?> />
							<label for="oclusi"><?php echo $this->lang->line('label_cros_bite');?></label>
							<input type="radio" name="oclusi" id="oclusi" value="Steep-Bite" <?php echo ($checkup['oclusi']=='Steep-Bite')?'checked="checked"':''?> />
							<label for="oclusi"><?php echo $this->lang->line('label_steep_bite');?></label>	
						</td>
					</tr>
					<tr>
						<td><?php echo $this->lang->line('label_torus_palat');?></td>
						<td>
							<input type="radio" name="torus_palat" id="torus_palat" checked="checked" value="Tidak-Ada" <?php echo ($checkup['torus_palat']=='Tidak-Ada')?'checked="checked"':''?>/>
							<label for="torus_palat"><?php echo $this->lang->line('label_tidak_ada');?></label>
							<input type="radio" name="torus_palat" id="torus_palat" value="Besar" <?php echo ($checkup['torus_palat']=='Besar')?'checked="checked"':''?>/>
							<label for="torus_palat"><?php echo $this->lang->line('label_besar');?></label>
							<input type="radio" name="torus_palat" id="torus_palat" value="Sedang" <?php echo ($checkup['torus_palat']=='Sedang')?'checked="checked"':''?>/>
							<label for="torus_palat"><?php echo $this->lang->line('label_sedang');?></label>
							<input type="radio" name="torus_palat" id="torus_palat" value="Kecil" <?php echo ($checkup['torus_palat']=='Kecil')?'checked="checked"':''?>/>
							<label for="torus_palat"><?php echo $this->lang->line('label_kecil');?></label>
							<input type="radio" name="torus_palat" id="torus_palat" value="Multipel" <?php echo ($checkup['torus_palat']=='Multipel')?'checked="checked"':''?>/>
							<label for="torus_palat"><?php echo $this->lang->line('label_multipel');?></label>						
						</td>
					</tr>
					<tr>
						<td><?php echo $this->lang->line('label_palatum');?></td>
						<td><input type="radio" name="palatum" id="palatum" value="Dalam" <?php echo ($checkup['palatum']=='Dalam')?'checked="checked"':''?> />
							<label for="palatum"><?php echo $this->lang->line('label_dalam');?></label>
							<input type="radio" name="palatum" id="palatum" value="Sedang" <?php echo ($checkup['palatum']=='Sedang')?'checked="checked"':''?> />
							<label for="palatum"><?php echo $this->lang->line('label_sedang');?></label>
							<input type="radio" name="palatum" id="palatum" value="Rendah" <?php echo ($checkup['palatum']=='Rendah')?'checked="checked"':''?> />
							<label for="palatum"><?php echo $this->lang->line('label_rendah');?></label>
						</td>
					</tr>
					<tr>
						<td><?php echo $this->lang->line('label_supernumery_teeth');?></td>
						<td><input type="radio" name="supernumery" id="supernumery" checked="checked" value="Tidak-Ada" <?php echo ($checkup['supernumery_teeth']=='Tidak-Ada')?'checked="checked"':''?>/>
							<label for="supernumery"><?php echo $this->lang->line('label_tidak_ada');?></label>
							<input type="radio" name="supernumery" id="supernumery" value="Ada"  <?php echo ($checkup['supernumery_teeth']=='Ada')?'checked="checked"':''?>/>
							<label for="supernumery"><?php echo $this->lang->line('label_ada');?></label><input type="text" size="35" name="ada_supernumery" value="<?php echo $checkup['ada_supernumery_teeth']?>">
						</td>
					</tr>
					<tr>
						<td><?php echo $this->lang->line('label_diastema');?></td>
						<td><input type="radio" name="diastema" id="diastema" checked="checked" value="Tidak-Ada" <?php echo ($checkup['diastema']=='Tidak-Ada')?'checked="checked"':''?>/>
							<label for="diastema"><?php echo $this->lang->line('label_tidak_ada');?></label>
							<input type="radio" name="diastema" id="diastema" value="Ada"  <?php echo ($checkup['diastema']=='Ada')?'checked="checked"':''?>/>
							<label for="diastema"><?php echo $this->lang->line('label_ada');?></label><input type="text" size="35" name="ada_diastema" value="<?php echo $checkup['ada_diastema']?>">
						</td>
					</tr>
					<tr>
						<td><?php echo $this->lang->line('label_gigi_anomali');?></td>
						<td><input type="radio" name="gigi_anomali" id="gigi_anomali" checked="checked" value="Tidak-Ada"  <?php echo ($checkup['anomali_teeth']=='Tidak-Ada')?'checked="checked"':''?> />
							<label for="gigi_anomali"><?php echo $this->lang->line('label_tidak_ada');?></label>
							<input type="radio" name="gigi_anomali" id="gigi_anomali" value="Ada"  <?php echo ($checkup['anomali_teeth']=='Ada')?'checked="checked"':''?>/>
							<label for="gigi_anomali"><?php echo $this->lang->line('label_ada');?></label><input type="text" size="35" name="ada_gigi_anomali" value="<?php echo $checkup['ada_anomali_teeth']?>">
						</td>
					</tr>
					<!--<tr>
						<td>Golongan Darah</td>
						<td>
							<input type="text" name="blood_type" id="blood_type" size="3" maxlength="2" onkeypress="focusNext('gigi_anomali', 'blood_type', this, event)" value="<?php //echo $checkup['blood_type']?>" style="text-align:right" />
						</td>
					</tr>-->
					<tr>
						<td><?php echo $this->lang->line('label_lain2');?></td>
						<td><textarea name="lain2" id="lain2" col="450" rows="1" onkeypress="focusNext('hypertensi', 'lain2', this, event)" style="text-align:right"><?php echo $checkup['other_sign']?></textarea>
						</td>
					</tr>
				</table>
			</fieldset>	
		</td>
	</tr>
	<tr>
	<td><fieldset class="used" style="<?php echo $hide_for_umum?>"><legend>Riwayat Penyakit</legend>
				<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
					<tr>
						<td><?php echo $this->lang->line('label_hypertensi');?></td>
						<td><input type="radio" name="hypertensi" id="hypertensi" checked="checked" value="Tidak" <?php echo ($checkup['hypertensi']=='Tidak')?'checked="checked"':''?>/>
							<label for="hypertensi"><?php echo $this->lang->line('label_tidak');?></label>	
							<input type="radio" name="hypertensi" id="hypertensi" value="Ya"  <?php echo ($checkup['hypertensi']=='Ya')?'checked="checked"':''?>/>
							<label for="hypertensi"><?php echo $this->lang->line('label_ya');?></label><br>
											
							<!--
							<label style="width:100px;"><?php //echo $this->lang->line('label_blood_pressure');?>
							<input type="text" name="sistole2" id="sistole2" size="5" maxlength="6" onkeypress="focusNext('diastole2', 'palatum', this, event)" value="<?php //echo $checkup['sistole']?>" style="text-align:right" /> / 
							<input type="text" name="diastole2" id="diastole2" size="5" maxlength="6" onkeypress="focusNext('jantung', 'sistole2', this, event)" value="<?php //echo $checkup['diastole']?>" style="text-align:right" /> mmhg<br/>
                            <div id="blood_pressure_formula_result" style="color:#FF0000"></div>--->
							</label>						
						</td>
					</tr>
					<tr>
						<td><?php echo $this->lang->line('label_jantung');?></td>
						<td><input type="radio" name="jantung" id="jantung" checked="checked" value="Tidak"  <?php echo ($checkup['jantung']=='Tidak')?'checked="checked"':''?>/>
							<label for="jantung"><?php echo $this->lang->line('label_tidak');?></label>
							<input type="radio" name="jantung" id="jantung" value="Ya"  <?php echo ($checkup['jantung']=='Ya')?'checked="checked"':''?>/>
							<label for="jantung"><?php echo $this->lang->line('label_ya');?></label>
						</td>
					</tr>
					<tr>
						<td><?php echo $this->lang->line('label_asthma');?></td>
						<td><input type="radio" name="asthma" id="asthma" checked="checked" value="Tidak"  <?php echo ($checkup['asthma']=='Tidak')?'checked="checked"':''?> />
							<label for="asthma"><?php echo $this->lang->line('label_tidak');?></label>
							<input type="radio" name="asthma" id="asthma" value="Ya"  <?php echo ($checkup['asthma']=='Ya')?'checked="checked"':''?>/>
							<label for="asthma"><?php echo $this->lang->line('label_ya');?></label>
						</td>
					</tr>
									
					<tr>
						<td><?php echo $this->lang->line('label_dm');?></td>
						<td><input type="radio" name="dm" id="dm" checked="checked" value="Tidak" <?php echo ($checkup['dm']=='Tidak')?'checked="checked"':''?> />
							<label for="dm"><?php echo $this->lang->line('label_tidak');?></label>
							<input type="radio" name="dm" id="dm" value="Ya" <?php echo ($checkup['dm']=='Ya')?'checked="checked"':''?> />
							<label for="dm"><?php echo $this->lang->line('label_ya');?></label>
						</td>
					</tr>				
					<tr>
						<td><?php echo $this->lang->line('label_alergi_obat');?></td>
						<td><input type="radio" name="alergi_obat" id="alergi_obat" checked="checked" value="Tidak"  <?php echo ($checkup['drug_alergy']=='Tidak')?'checked="checked"':''?>/>
							<label for="alergi_obat"><?php echo $this->lang->line('label_tidak');?></label>
							<input type="radio" name="alergi_obat" id="alergi_obat" value="Ya"  <?php echo ($checkup['drug_alergy']=='Ya')?'checked="checked"':''?> />
							<label for="alergi_obat"><?php echo $this->lang->line('label_ya');?></label>				
						</td>
					</tr>
					<tr>
						<td><?php echo $this->lang->line('label_lain2');?></td>
						<td><textarea name="lain3" id="lain3" col="150" rows="2"><?php echo $checkup['other_sick_history']?></textarea>
						</td>
					</tr>
				</table>
			</fieldset>	</td>
			<td>
			<fieldset class="used" style="<?php echo $hide_for_umum?>"><legend>Pemeriksaan Obyektif</legend>
				<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
					<tr>
						<td colspan="2" align="left" style="width:140px;">EO(Eksternal Oral) :<br><?php //echo $this->lang->line('label_oclusi');?>
</td></tr><tr><td>&nbsp;&nbsp;&nbsp;Wajah </td><td> <input type="radio" name="eo_face" id="eo_face" checked="checked" value="Tidak-Ada-Kelainan"  <?php echo ($checkup['eo_face']=='Tidak-Ada-Kelainan')?'checked="checked"':''?> />
							<label for="eo_face">Tidak Ada Kelainan<?php //echo $this->lang->line('label_tidak');?></label>
							<input type="radio" name="eo_face" id="eo_face" value="Wajah-Asimetris"  <?php echo ($checkup['eo_face']=='Wajah-Asimetris')?'checked="checked"':''?> />
							<label for="eo_face">Asimetris<?php //echo $this->lang->line('label_cros_bite');?></label>
</td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;Kel. Limfe<?php //echo $this->lang->line('label_torus_palat');?></td>
						<td>
							<input type="radio" name="kel_limfe" id="kel_limfe" checked="checked" value="Tidak-Teraba"  <?php echo ($checkup['kel_limfe']=='Tidak-Teraba')?'checked="checked"':''?> />
							<label for="kel_limfe">Tidak<?php //echo $this->lang->line('label_besar');?></label>
							<input type="radio" name="kel_limfe" id="kel_limfe" value="Teraba"  <?php echo ($checkup['kel_limfe']=='Teraba')?'checked="checked"':''?> />
							<label for="kel_limfe">Teraba<?php //echo $this->lang->line('label_tidak_ada');?></label>
						</td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;Lain-Lain<?php //echo $this->lang->line('label_palatum');?></td>
						<td><textarea col="450" rows="1" name="lain4"><?php echo $checkup['eo_others']?></textarea>
						</td>
					</tr>
					<tr>
						<td>IO (Intra Oral) :</td></tr>
						<tr>
							<td>&nbsp;&nbsp;&nbsp;Gigi<?php //echo $this->lang->line('label_supernumery_teeth');?></td>
							<td><textarea col="450" rows="1" name="io_gigi"><?php echo $checkup['io_gigi']?></textarea>
						</td>
					 </tr>
					 <tr>
						<td>&nbsp;&nbsp;&nbsp;Mukosa/Gingiva<?php //echo $this->lang->line('label_supernumery_teeth');?></td>
						<td><textarea col="450" rows="1" name="io_mukosa_gingiva"><?php echo $checkup['io_mukosa_gingiva']?></textarea>
						</td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;Lidah/Palatum<?php //echo $this->lang->line('label_supernumery_teeth');?></td>
						<td><textarea col="350" rows="1" name="io_lidah_palatum"><?php echo $checkup['io_palatum']?></textarea>
						</td>
					</tr>
					
					<tr>
						<td colspan="2">Pemeriksaan IO dengan Alat :<br><?php //echo $this->lang->line('label_gigi_anomali');?></td></tr>
						<tr><td>&nbsp;&nbsp;&nbsp;CE</td>
						<td><input type="radio" name="io_ce" id="io_ce" value="0"  <?php echo ($checkup['teeth_ce']==0)?'checked="checked"':''?> />
							<label for="io_ce">-<?php //echo $this->lang->line('label_tidak_ada');?></label>
							<input type="radio" name="io_ce" id="io_ce" value="1"  <?php echo ($checkup['teeth_ce']==1)?'checked="checked"':''?>/>
							<label for="io_ce">+<?php //echo $this->lang->line('label_ada');?></label>&nbsp;<input type="text" size="10" name="io_ce_plus" value="<?php echo $checkup['teeth_ce_plus']?>">
						</td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;Sondasi :<?php //echo $this->lang->line('label_gigi_anomali');?></td>
						<td><input type="radio" name="io_sondasi" id="io_sondasi" checked="checked" value="0"  <?php echo ($checkup['teeth_sondasi']==0)?'checked="checked"':''?>/>
							<label for="io_sondasi">-<?php //echo $this->lang->line('label_tidak_ada');?></label>
							<input type="radio" name="io_sondasi" id="io_sondasi" value="1"  <?php echo ($checkup['teeth_sondasi']==1)?'checked="checked"':''?>/>
							<label for="io_sondasi">+<?php //echo $this->lang->line('label_ada');?></label>&nbsp;<input type="text" size="10" name="io_sondasi_plus" value="<?php echo $checkup['teeth_sondasi_plus']?>">
						</td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;Perkusi :<?php //echo $this->lang->line('label_gigi_anomali');?></td>
						<td><input type="radio" name="io_perkusi" id="io_perkusi" checked="checked" value="0"  <?php echo ($checkup['teeth_perkusi']==0)?'checked="checked"':''?> />
							<label for="io_perkusi">-<?php //echo $this->lang->line('label_tidak_ada');?></label>
							<input type="radio" name="io_perkusi" id="io_perkusi" value="1"  <?php echo ($checkup['teeth_perkusi']==1)?'checked="checked"':''?> />
							<label for="io_perkusi">+<?php //echo $this->lang->line('label_ada');?></label>&nbsp;<input type="text" size="10" name="io_perkusi_plus" value="<?php echo $checkup['teeth_perkusi_plus']?>">
						</td>
					</tr>
					<tr>
						<td>&nbsp;&nbsp;&nbsp;Palpasi :<?php //echo $this->lang->line('label_gigi_anomali');?></td>
						<td><input type="radio" name="io_palpasi" id="io_palpasi" value="0"  <?php echo ($checkup['teeth_palpasi']==0)?'checked="checked"':''?>/>
							<label for="io_palpasi">-<?php //echo $this->lang->line('label_tidak_ada');?></label>
							<input type="radio" name="io_palpasi" id="io_palpasi" value="1"  <?php echo ($checkup['teeth_palpasi']==1)?'checked="checked"':''?> />
							<label for="io_palpasi">+<?php //echo $this->lang->line('label_ada');?></label>&nbsp;<input type="text" size="10" name="io_palpasi_plus" value="<?php echo $checkup['teeth_palpasi_plus']?>">
						</td>
					</tr>
				</table>
			</fieldset>
			</td>
	</tr>
	<tr>
		<td>
			<fieldset class="used"><legend><?php echo $this->lang->line('label_anamnese');?> &amp; <?php echo $this->lang->line('label_diagnose');?>
				</legend>
				<table border="0" style="width:95%" id="ol_list_anamnese_diagnose">
					<?php for($i=0;$i<sizeof($diagnoses);$i++) :?>
						<?php if($diagnoses[$i]['log'] == 'yes') $className="deleted"; else $className="";?>
						<tr class="list_data_<?php echo $className;?>">
							<td style="width:80px">Anamnesa :<br/><br/><div style="<?php echo $hide_for_umum?>">Elemen</div><br/>Diagnosa :<br/><br/>Catatan :<br/></td>
							<td class="list_data_<?php echo $className;?>" style="border-bottom:solid 1px #000000;">

							<input type="text" name="anamnese_saved[]" id="anamnese_saved_<?php echo $diagnoses[$i]['id']?>" size="25" onkeypress="focusNext('icd_name_1', 'height', this, event)" value="<?php echo $diagnoses[$i]['anamnese']?>" readonly="readonly" class="<?php echo $className?>" /><br/>
							
							<input type="hidden" name="ead_saved_id[]" id="ead_saved_id_<?php echo $diagnoses[$i]['id']?>" value="<?php echo $diagnoses[$i]['id']?>" />
							<input type="text" name="elemen[0]" id="elemen_1" size="5" style="<?php echo $hide_for_umum?>" onkeypress="focusNext('icd_name_1', 'case_1', this, event)" value="<?php echo $diagnoses[$i]['element_teeth']?>" /><br/>
							
							<?php if($diagnoses[$i]['log'] == 'no') :?>
							<img src="../webroot/media/images/close.png" alt="Delete" class="button_delete_anamnese_diagnose" />
							<?php endif;?>
							<input readonly="readonly" type="text" name="icd_saved_name[]" id="icd_saved_name_<?php echo $diagnoses[$i]['id']?>" size="25" value="<?php echo $diagnoses[$i]['name']?>" onkeypress="focusNext('case_saved_<?php echo $diagnoses[$i]['id']?>', 'anamnese', this, event)" class="<?php echo $className?>" />
							<?php if($diagnoses[$i]['case'] == 'new') :?>
								<input type="text" readonly="readonly" name="case_saved[]" id="case_saved_<?php echo $diagnoses[$i]['id']?>" onkeypress="focusNext('drug_name_1', 'icd_saved_name_<?php echo $diagnoses[$i]['id']?>', this, event)" size="10" value="Kasus Baru" class="<?php echo $className?>" />
							<?php elseif($diagnoses[$i]['case'] == 'old') :?>
								<input type="text" readonly="readonly" name="case_saved[]" id="case_saved_<?php echo $diagnoses[$i]['id']?>" onkeypress="focusNext('icd_name_1', 'icd_saved_name_<?php echo $diagnoses[$i]['id']?>', this, event)" size="10" value="Kasus Lama" class="<?php echo $className?>" />                        
							<?php else :?>
								<input type="text" readonly="readonly" name="case_saved[]" id="case_saved_<?php echo $diagnoses[$i]['id']?>" onkeypress="focusNext('icd_name_1', 'icd_saved_name_<?php echo $diagnoses[$i]['id']?>', this, event)" size="10" value="KKL" class="<?php echo $className?>" />
							<?php endif;?>

							<input type="hidden" name="icd_saved_id[]" id="icd_saved_id_<?php echo $diagnoses[$i]['id']?>" value="<?php echo $diagnoses[$i]['id']?>" />
							<input type="hidden" name="icd_saved_code[]" id="icd_saved_code_<?php echo $diagnoses[$i]['id']?>" value="<?php echo $diagnoses[$i]['code']?>" />
							<textarea col="150" rows="1" readonly="readonly" name="explanation_saved[]" id="explanation_saved_<?php echo $diagnoses[$i]['id']?>" class="<?php echo $className?>"><?php echo $diagnoses[$i]['explanation']?> </textarea>
							</td>
						</tr>
					<?php endfor;?>
					<tr>
						<td style="width:80px">Anamnesa :<br/><br/><div style="<?php echo $hide_for_umum?>">Elemen :</div><br/>Diagnosa :<br/><br/>Catatan :</br></td>
						<td style="border-bottom:solid 1px #000000;">
							<input type="text" name="anamnese[0]" id="anamnese_1" size="30" onkeypress="focusNext('icd_name_1', 'physic_anamnese', this, event)" value="-" /><br/>
							<input type="hidden" name="ead_id[0]" id="ead_id_1" />
							<input type="text" name="elemen[0]" id="elemen_1" size="5" style="<?php echo $hide_for_umum?>" onkeypress="focusNext('icd_name_1', 'case_1', this, event)" value="" /><br/>
							<input type="text" name="icd_name[0]" id="icd_name_1" size="20" onkeypress="focusNext('case_1', 'icd_name_1', this, event)" value="" />
							<select name="case[0]" id="case_1" onkeypress="focusNext('explanation_1', 'icd_name_1', this, event)" style="width:80px;">
								<option value="new">Kasus Baru</option>
								<option value="old">Kasus Lama</option>
								<option value="kkl">KKL</option>                        
							</select><br/>
							<input type="hidden" name="icd_id[0]" id="icd_id_1" />
							<input type="hidden" name="icd_code[0]" id="icd_code_1" />
							<textarea col="150" rows="1" name="explanation[0]" id="explanation_1" size="30" onkeypress="focusNext('icd_name_2', 'case_1', this, event)"/> </textarea>
						</td>
					</tr>
				</table>
				<div style="text-align:right"><a href="javascript:void(0)" id="link_add_anamnese_diagnose">Tambah Diagnosa</a></div>
			</fieldset>
			
			<fieldset class="used"><legend><?php echo $this->lang->line('label_doctor');?> &amp; <?php echo $this->lang->line('label_continue');?></legend>
				<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
				<tr>
					<td style="width:100px;">
						<?php echo $this->lang->line('label_doctor');?>
					</td>
					<td>
						<select name="doctor_id" id="doctor_id" style="width:150px;">
						<?php for($i=0;$i<sizeof($doctor);$i++) :?>
						<?php if($doctor[$i]['id'] == $data['doctor_id']) $sel='selected="selected"'; else $sel=''; ?>
							<option value="<?php echo $doctor[$i]['id']?>" <?php echo $sel?>><?php echo $doctor[$i]['name']?></option>
						<?php endfor;?>
						</select>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_continue');?></td>
					<td>
						<select name="continue_id" id="continue_id" style="width:150px;">
						<?php for($i=0;$i<sizeof($continue);$i++) :?>
						<?php if($continue[$i]['id'] == $data['continue_id']) $sel='selected="selected"'; else $sel=''; ?>
						<option value="<?php echo $continue[$i]['id']?>" <?php echo $sel?>><?php echo $continue[$i]['name']?></option>
						<?php endfor;?>
						</select>
                        <?php 
                        if($data['continue_id'] == '003') $display="";
                        else $display = "display:none";
                        ?>
                        &nbsp;<input style="<?php echo $display;?>" type="text" name="continue_to" id="continue_to" value="<?php echo $data['continue_to'];?>" size="40">
					</td>
				</tr>
				</table>
			</fieldset>
		</td>
		<td colspan="2">
			<fieldset class="used"><legend><?php echo $this->lang->line('label_treatment');?></legend>
				<table id="list_treatments">
					<tr>
						<th style="width:370px"><?php echo $this->lang->line('label_treatment');?></th>
						<th style="width:120px"><?php echo $this->lang->line('label_price');?></th>
					</tr>
					<?php for($i=0;$i<sizeof($treatments);$i++) :?>
						<?php if($treatments[$i]['log'] == 'yes') $className="deleted"; else $className="";?>
						<tr id="li_treatment_saved_<?php echo $treatments[$i]['id']?>" class="list_data_<?php echo $className;?>">
							<td class="list_data_<?php echo $className;?>">

								<input type="text" name="treatment_saved_name[]" id="treatment_saved_name_<?php echo $treatments[$i]['id']?>" size="50" onkeypress="focusNext('price_saved_<?php echo $treatments[$i]['id']?>', 'price_saved_<?php echo $treatments[$i]['id']?>', this, event)" value="<?php echo $treatments[$i]['name']?>" readonly="readonly" class="<?php echo $className?>" />
							</td>
							<td class="list_data_<?php echo $className;?>">
								<input type="text" readonly="readonly" name="price_saved[]" id="price_saved_<?php echo $treatments[$i]['id']?>" size="10" onkeypress="focusNext('treatment_saved_name_<?php echo $treatments[$i]['id']?>', 'treatment_saved_name_<?php echo $treatments[$i]['id']?>', this, event)" value="<?php echo $treatments[$i]['price']?>" style="text-align:right" class="<?php echo $className?>" />

								<input type="hidden" name="treatment_saved_id[]" id="treatment_saved_id_<?php echo $treatments[$i]['id']?>" value="<?php echo $treatments[$i]['id']?>" />
								<?php if($treatments[$i]['log'] == 'no') :?>
								<img src="../webroot/media/images/close.png" alt="Delete" class="button_delete_treatment" />
								<?php endif;?>
							</td>
						</tr>
					<?php endfor;?>
					<tr>
						<td>
							<input type="hidden" name="treatment_id[]" id="treatment_id_1" />
							<input type="text" name="treatment_name[]" id="treatment_name_1" size="35" onkeypress="focusNext('treatment_price_1', 'treatment_price_1', this, event)" value="" />
						</td>
						<td>
							<input type="text" name="treatment_price[]" id="treatment_price_1" size="10" readonly="readonly" onkeypress="focusNext('treatment_name_2', 'treatment_name_1', this, event)" value="" style="text-align:right" />
						</td>
					</tr>
				</table>
				<div style="text-align:right"><a href="javascript:void(0)" id="link_add_treatment">Tambah Tindakan</a></div>
			</fieldset>
			<fieldset class="used"><legend><?php echo $this->lang->line('label_prescribes');?></legend>
				<table id="list_prescribes">
					<tr>
						<th style="">Obat</th>
						<th style="">Dosis</th>
						<th style="text-align:left">Jml</th>
					</tr>
					<?php for($i=0;$i<sizeof($prescribes);$i++) :?>
						<?php if($prescribes[$i]['log'] == 'yes') $className="deleted"; else $className="";?>

						<tr class="list_data_<?php echo $className;?>">
							<td>
								<input type="text" name="drug_saved_name[]" id="drug_saved_name_<?php echo $prescribes[$i]['id']?>" size="30" onkeypress="focusNext('saved_dosis1_<?php echo $prescribes[$i]['id']?>', 'anamnese', this, event)" value="<?php echo $prescribes[$i]['name']?>" readonly="readonly" class="<?php echo $className?>" />
							</td>
							<td>
								<input type="text" name="saved_dosis1[]" id="saved_dosis1_<?php echo $prescribes[$i]['id']?>" size="3" onkeypress="focusNext('saved_dosis2_1', 'drug_saved_name_1', this, event)" value="<?php echo $prescribes[$i]['dosis1']?>" style="text-align:right" readonly="readonly" class="<?php echo $className?>" />x<input type="text" name="saved_dosis2[]" id="saved_dosis2_<?php echo $prescribes[$i]['id']?>" size="3" onkeypress="focusNext('qty_1', 'saved_dosis1_1', this, event)" value="<?php echo $prescribes[$i]['dosis2']?>" style="text-align:right" readonly="readonly" class="<?php echo $className?>" />
							</td>
							<td>
								<input type="text" name="qty_saved[]" id="qty_saved_<?php echo $prescribes[$i]['id']?>" size="3" onkeypress="focusNext('drug_name_1', 'saved_dosis2_1', this, event)" value="<?php echo $prescribes[$i]['qty']?>" style="text-align:right" readonly="readonly" class="<?php echo $className?>" />
								<input type="text" name="unit_saved[]" id="unit_saved_<?php echo $prescribes[$i]['id']?>" size="5" value="<?php echo $prescribes[$i]['unit']?>" readonly="readonly" class="<?php echo $className?>" />
								
								<input type="hidden" name="drug_saved_id[]" id="drug_saved_id_<?php echo $prescribes[$i]['id']?>" value="<?php echo $prescribes[$i]['id']?>" />
								<?php if($prescribes[$i]['log'] == 'no' && $prescribes[$i]['drug_taken'] == 'no') :?>
								<img src="../webroot/media/images/close.png" alt="Delete" class="button_delete_prescribe" />
								<?php endif;?>
							</td>
						</tr>
					<?php endfor;?>

						<tr>
							<td>
								<input type="text" name="drug_name[]" id="drug_name_1" size="30" onkeypress="focusNext('dosis1_1', 'anamnese', this, event)" value="" />
								<input type="hidden" name="drug_id[]" id="drug_id_1" />
							</td>
							<td>
								<input type="text" name="dosis1[]" id="dosis1_1" size="3" onkeypress="focusNext('dosis2_1', 'drug_name_1', this, event)" value="" style="text-align:right" />x<input type="text" name="dosis2[]" id="dosis2_1" size="3" onkeypress="focusNext('qty_1', 'dosis1_1', this, event)" value="" style="text-align:right" />
							</td>
							<td>
								<input type="text" name="qty[]" id="qty_1" size="3" onkeypress="focusNext('unit_1', 'dosis2_1', this, event)" value="" style="text-align:right" />
								<input type="text" name="unit[]" id="unit_1" size="5" onkeypress="focusNext('drug_name_2', 'qty_1', this, event)" value="" />
							</td>
						</tr>
				</table>
				<div style="text-align:right">
					<a href="javascript:void(0)" id="link_add_prescribe">Tambah Obat</a>
				</div>
			</fieldset>

			<fieldset class="used">
			<legend>Resep Racikan</legend>
				<table id="list_prescribes_mix">
					<thead>
					<tr>
						<th style="">Nama Racikan/Obat</th>
						<th style="">Dosis</th>
						<th style="">Jml</th>
					</tr>
					</thead>
					<?php for($i=0;$i<sizeof($prescribes_mix);$i++) :?>
						<?php if($prescribes_mix[$i]['log'] == 'yes') $className="deleted"; else $className="";?>
						<?php if($prescribes_mix[$i]['randomnumber'] != $prescribes_mix[$i-1]['randomnumber']) :
							if($i != 0) echo "</tbody>";
						?>
						<tbody class="list_data_<?php echo $className;?>">
						<tr>
							<td>
								<input type="text" name="mix_name[<?php echo $prescribes_mix[$i]['randomnumber']?>]" size="30" value="<?php echo $prescribes_mix[$i]['mix_name']?>" readonly="readonly" class="<?php echo $className?>" />
							</td>
							<td>
								<input type="text" name="mix_dosis1[<?php echo $prescribes_mix[$i]['randomnumber']?>]" size="3" value="<?php echo $prescribes_mix[$i]['dosis1']?>" style="text-align:right" readonly="readonly" class="<?php echo $className?>" />x<input type="text" name="mix_dosis2[<?php echo $prescribes_mix[$i]['randomnumber']?>]" size="3" value="<?php echo $prescribes_mix[$i]['dosis2']?>" style="text-align:right" readonly="readonly" class="<?php echo $className?>" />
								
							</td>
							<td>
								<input type="text" name="mix_qty_qty_saved[<?php echo $prescribes_mix[$i]['randomnumber']?>]" size="3" value="<?php echo $prescribes_mix[$i]['mix_qty']?>" style="text-align:right" class="<?php echo $className?>" readonly="readonly" />
								<input type="text" name="mix_unit_unit_saved[<?php echo $prescribes_mix[$i]['randomnumber']?>]" size="5" value="<?php echo $prescribes_mix[$i]['mix_unit']?>" readonly="readonly" class="<?php echo $className?>" />
								<input type="hidden" name="mix_saved_id[<?php echo $prescribes_mix[$i]['randomnumber']?>]" value="<?php echo $prescribes_mix[$i]['id']?>" />
								<input type="hidden" name="mix_randomnumber[<?php echo $prescribes_mix[$i]['randomnumber']?>]" value="<?php echo $prescribes_mix[$i]['randomnumber']?>" />
								<?php if($prescribes_mix[$i]['log'] == 'no' && $prescribes_mix[$i]['drug_taken'] == 'no') :?>
								<img src="../webroot/media/images/close.png" alt="Delete" class="button_delete_prescribe_saved_mix" />
								<?php endif;?>
							</td>
							<td>
								<a href="javascript:void(0)" class="link_add_prescribe_saved_mix_drug" title="<?php echo $prescribes_mix[$i]['randomnumber']?>">Tambah Obat</a>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								&bull;<input type="text" name="mix_drug_saved_name[<?php echo $prescribes_mix[$i]['randomnumber']?>][]" id="mix_drug_saved_name_<?php echo $prescribes_mix[$i]['id']?>" size="45" value="<?php echo $prescribes_mix[$i]['name']?>" readonly="readonly" class="<?php echo $className?>" />
							</td>
							<td>
								<input type="text" name="mix_qty_saved[<?php echo $prescribes_mix[$i]['randomnumber']?>][]" id="mix_qty_saved_<?php echo $prescribes_mix[$i]['id']?>" size="3" value="<?php echo $prescribes_mix[$i]['qty']?>" style="text-align:right" readonly="readonly" class="<?php echo $className?>" />
								<input type="text" name="mix_unit_saved[<?php echo $prescribes_mix[$i]['randomnumber']?>][]" id="mix_unit_saved_<?php echo $prescribes_mix[$i]['id']?>" size="5" value="<?php echo $prescribes_mix[$i]['unit']?>" readonly="readonly" class="<?php echo $className?>" />
								
								<input type="hidden" name="mix_drug_saved_id[<?php echo $prescribes_mix[$i]['randomnumber']?>][]" id="mix_drug_saved_id_<?php echo $prescribes_mix[$i]['id']?>" value="<?php echo $prescribes_mix[$i]['id']?>" />
								<?php if($prescribes_mix[$i]['log'] == 'no' && $prescribes_mix[$i]['drug_taken'] == 'no') :?>
								<img src="../webroot/media/images/close.png" alt="Delete" class="button_delete_prescribe" />
								<?php endif;?>
							</td>
						</tr>
						<?php else:?>
						<tr>
							<td colspan="2">
								&bull;<input type="text" name="mix_drug_saved_name[<?php echo $prescribes_mix[$i]['randomnumber']?>][]" id="mix_drug_saved_name_<?php echo $prescribes_mix[$i]['id']?>" size="45" value="<?php echo $prescribes_mix[$i]['name']?>" readonly="readonly" class="<?php echo $className?>" />
							</td>
							<td>
								<input type="text" name="mix_qty_saved[<?php echo $prescribes_mix[$i]['randomnumber']?>][]" id="mix_qty_saved_<?php echo $prescribes_mix[$i]['id']?>" size="3" value="<?php echo $prescribes_mix[$i]['qty']?>" style="text-align:right" readonly="readonly" class="<?php echo $className?>" />
								<input type="text" name="mix_unit_saved[<?php echo $prescribes_mix[$i]['randomnumber']?>][]" id="mix_unit_saved_<?php echo $prescribes_mix[$i]['id']?>" size="5" value="<?php echo $prescribes_mix[$i]['unit']?>" readonly="readonly" class="<?php echo $className?>" />
								
								<input type="hidden" name="mix_drug_saved_id[<?php echo $prescribes_mix[$i]['randomnumber']?>][]" id="mix_drug_saved_id_<?php echo $prescribes_mix[$i]['id']?>" value="<?php echo $prescribes_mix[$i]['id']?>" />
								<?php if($prescribes_mix[$i]['log'] == 'no' && $prescribes_mix[$i]['drug_taken'] == 'no') :?>
								<img src="../webroot/media/images/close.png" alt="Delete" class="button_delete_prescribe" />
								<?php endif;?>
							</td>
						</tr>
						<?php if(!$prescribes_mix[$i+1]['mix_name']) echo "</tbody>";?>
					<?php endif;?>
					<?php endfor;?>
						<tbody>
						<tr>
							<td>
								<input type="text" name="mix_name[]" id="mix_name_1" size="30" />
								<input type="hidden" name="mix_randonumber[]" id="mix_randomnumber_1" />
							</td>
							<td>
								<input type="text" name="mix_dosis1[]" id="mix_dosis1_1" size="3" style="text-align:right" class="decimal" />x<input type="text" name="mix_dosis2[]" id="mix_dosis2_1" size="3" class="decimal" />
							</td>
							<td>
								<input type="text" name="mix_qty_qty[]" id="mix_qty_qty_1" size="3" style="text-align:right" class="decimal" />
								<input type="text" name="mix_unit_unit[]" id="mix_unit_unit_1" size="5" />
							</td>
							<td>
								<a href="javascript:void(0)" id="link_add_prescribe_mix_drug">Tambah Obat</a>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								&bull;<input type="text" name="mix_drug_name[][]" id="mix_drug_name_1" size="45" />
							</td>
							<td>
								<input type="text" name="mix_qty[][]" id="mix_qty_1" size="3" style="text-align:right" />
								<input type="text" name="mix_unit[][]" id="mix_unit_1" size="5" style="text-align:right" readonly="readonly" class="readonly2" />
								<input type="hidden" name="mix_drug_id[][]" id="mix_drug_id_1" />
							</td>
						</tr>
						</tbody>
						<!---->
				</table>
				<div style="text-align:right">
					<a href="javascript:void(0)" id="addMix">Tambah Racikan</a>
				</div>
			</fieldset>
		</td>
	</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
    <tr>
        <td></td>
        <td>
            <input type="submit" name="Save" id="SaveGeneral_Checkup" value="  Simpan  " />
            <input type="button" name="Close" id="btnCloseGeneral_Checkup" value="  Tutup  " />
            <?php if($data['served'] == 'yes') :?>
            <input type="button" name="Cetak" value="  Cetak  " onclick="openPrintPopup('<?php echo site_url("visit/general_checkup/printout/" . $data["visit_id"]);?>')"/>
            <?php endif;?>
        </td>
    </tr>
</table>
</form>
