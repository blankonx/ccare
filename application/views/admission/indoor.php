<script language="JavaScript" type="text/javascript">
$(document).ready(function() { 
$('.decimal').decimal();	
if ($('#payment_type_id').val()=='01'){
	$('#insurance_no').attr('readonly', true).addClass('readonly');
	$('#insurance_no').val('');
	$('#nama_asuransi').attr('readonly', true).addClass('readonly');
	$('#nama_asuransi').val('');
	}

$('#continue_id').change(function() {
    var val = $(this).val();
    if(val == '03') $('#continue_to').val('Dirujuk ke').show() && $('#specialis').val('Spesialis').show();
    else $('#continue_to').val('').hide() && $('#specialis').val('').hide();
});
$('#continue_to').click(function() {
    var val = $(this).val();
    if(val == 'Dirujuk ke') {
        $('#continue_to').val('');
    }
});
$('#specialis').click(function() {
    var val = $(this).val();
    if(val == 'Spesialis') {
        $('#specialis').val('');
    }
});
$('#continue_to').blur(function() {
    var val = $(this).val();
    if(val == '') {
        $('#continue_to').val('Dirujuk ke');
    }
});
$('#specialis').blur(function() {
    var val = $(this).val();
    if(val == '') {
        $('#specialis').val('Spesialis');
    }
});

 $('#continue_to').autocomplete("indoor/get_list_Rs", {
        selectFirst: false
    });
 $('#specialis').autocomplete("indoor/get_list_Specialis", {
        selectFirst: false
    });

//begin form epidemologi pasien
    $('#birth_place').autocomplete("indoor/get_list_tempat_lahir", {
        selectFirst: false
    });
       
	//opening search form
    $(document).bind('keydown', 'Ctrl+f', function(evt) {
		//$("#panel_main").hide($('#visit_date').focus());
        $("#panel_search").slideDown("fast", fokus_search_form);return false;
    });
    $('#before').click(function(){
        var family_folder = parseInt(removeExtraZero($('#family_folder').val()))-1;
        if(family_folder == 0) return;
		$.ajax({
			url: '../admission/indoor/get_data_patient/' + family_folder,
			dataType: 'json',
			success:function(data) {
				fill_form_from_patient(data);
			}
		});
        $('#family_folder').val(addExtraZero(family_folder, 6));
    });
    $('#after').click(function(){
        //alert(parseInt($('#family_folder').val()));
        var family_folder = parseInt(removeExtraZero($('#family_folder').val()))+1;
        //alert(family_folder);
		$.ajax({
			url: '../admission/indoor/get_data_patient/' + family_folder,
			dataType: 'json',
			success:function(data) {
				fill_form_from_patient(data);
			}
		});
        $('#family_folder').val(addExtraZero(family_folder, 6));
    });
	
    $('#show_panel_search').click(function(){
		//$("#panel_main").hide($('#visit_date').focus());
        $("#panel_search").slideDown("fast", fokus_search_form);return false;
    });

	$('#birth_date').change(function() {
		$.ajax({
			url: 'indoor/hitung_usia/' + $(this).val(),
			dataType: 'json',
			success:function(data) {
				$('#age_year').val(data.year);
				$('#age_month').val(data.month);
				$('#age_day').val(data.day);
			}
		});
	});
	$('.age').change(function() {
		var age_year = $('#age_year').val();
		var age_month = $('#age_month').val();
		var age_day = $('#age_day').val();
		if(age_year == '') age_year = '0';
		$.get('indoor/get_tgl_lahir/' + age_year + '/' + age_month + '/' + age_day, function(data) {
			$('#birth_date').val(data);
		});
	});
	//closing search form
    $(document).bind('keydown', 'esc', function(evt){
        $("#panel_search").slideUp("slow", fokus_admission_form);return false;
    });
    $('#close_panel_search').click(function(){
        $("#panel_search").slideUp("slow", fokus_admission_form);return false;
    });
	$('#reset').click(function(){validator.resetForm();$('#family_folder').focus();reset_form()});
//alphanumericed input :
	$("#visit_date").numeric();
	$("#family_folder").numeric();
	$("#birth_date").numeric();
	$("#age_year").numeric();
	$("#age_month").numeric();
	$("#age_day").numeric();
	
//ajaxing search form
    $('#frmSearch').submit(function() {
		$('#divLoadingSearch').ajaxStart(function(){$(this).show();});
		$('#divLoadingSearch').ajaxStop(function(){$(this).hide();});

        $('#frmSearch').ajaxSubmit({
		    type: 'POST',
            target: '#divSearchResult',
			success:function() {
				$("#q").focus();
				preparePagingLink();
			}
        });
        return false;
    });

	function preparePagingLink() {
		$('.pagingLinks a').click(function() {
				$('#divLoadingSearch').ajaxStart(function(){$(this).show();});
				$('#divLoadingSearch').ajaxStop(function(){$(this).hide();});
				$('#divSearchResult').load(this.href,preparePagingLink);return false;
			}
		);
	}
//validating the input
	//adding the dependencies of insurance number & payment type
	$.validator.addMethod("insuranceIsRequired", function(value, element) {
		var val = $('#payment_type_id').val();
		if(val == '2' || val == '3') {
			if(value && value!='undefined' && $.trim(value) != '') return true;
			return false;
		} else {
			return true;
		}
	}, "Isikan nomor asuransi");
	
    $('#family_folder').bind('change', function() {
        var no=$(this).val();
        $.ajax({
            dataType:'json',
            url:'indoor/get_data_parent/' + no,
            success:function(data) {
                $('#family_folder').val(data.family_folder);
                $('#name').val('');
                $('#last_name').val('');
                
                $('#age_year').val('');
                $('#age_month').val('');
                $('#age_day').val('');

                $('#address').val('');
                //$('#education_id').val('');
                $('#job_id').val('');		
				
            }
        });
    });
    $('#family_folder').bind('change', function() {
        var no=$(this).val();
        //alert('xxx');
        $.ajax({
            dataType:'json',
            url:'indoor/get_data_patient/' + no,
            success:function(data) {
                fill_form_from_patient(data);
				getDataJamkesda(data);
            }
        });
    });

	var validator = $("#frmPendaftaran").validate({
		rules: {
			visit_date: {
                required:true,
                date:true
            },
            family_folder: {
                required:true,
                number:true,
                min:1
            },
            name: "required",
           // birth_place: "required",
            birth_date: {
                required:true,
                date:true
            },
            address: "required",
            //Edit 13 Juli utk dr Hartoyo
            
            //no_kontak: "required",
            marital_status_id: "required",
            job_id: "required",
            /*payment_type_id: "required",
			insurance_no:{
				insuranceIsRequired:true
			},*/
			
		},
        submitHandler:
            function(form) {
				
                $(form).ajaxSubmit({
					beforeSubmit:disableForm,
					dataType: 'json',
                    success:function(data) {
                        show_message('#admission_message', data.msg, data.status);
						enableForm();
						if(data.status == 'success') $("#reset").click();
                    }
                });
            }
	});

	$('#reset').click();
    //$('#visit_date').focus();
    $('#name').autocomplete("../admission/search/search_by_name", {
            selectFirst: false,
            matchContains: true,
            width:400,
            formatItem: function(data, i, max, term) {
                return '<b>' + data[0] + '</b> '
                + data[1] + ' ' + data[2] + '<br/>'
                 + data[3] + ' ' + data[4]
                + '</div>' ;
		    },
            formatResult: function(data) {
                return data[0];
		    }
    })
    .result(function(event, data, formatted) {
        get_patient_from_search(data[0], data[1]);
    });
   ;
// end form epidemologi pasien 

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

//Ajax Form Pemeriksaan
var yicdi=1;
function createNextAnamneseIcdInputForButton() {
    var obj = $('#icd_name_' + yicdi);
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
        .attr('size', '20')
        .attr('onkeypress', "focusNext('explanation_" + yicdi + "', 'anamnese', this, event)");


    var inputExplanation = $('<textarea>')
        .attr('name', 'explanation[' + currAnamneseKey + ']')
        .attr('id', 'explanation_' + yicdi)
        .attr('rows', '1')
        .attr('col', '60')
        .attr('onkeypress', "focusNext('anamnese_" + yicdi + "', 'icd_name_" + yicdi + "', this, event)");

    var inputSelect = ''; 

    var inputTextAnamnese = $('<input type="text"/>')
        //.attr('name', 'anamnese[' + currAnamneseKey + ']')
        //.attr('id', 'anamnese_' + yicdi)
        //.attr('size', '47')
		//.val('-')
        .attr('onkeypress', "focusNext('icd_name_" + yicdi + "', 'pemeriksaan_fisik', this, event)")
        .autocomplete("../admission/indoor/get_list_anamnese", {
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
           // inputHiddenAnamnese.val(data[0]);
			inputHidden.val(data[1]);
			inputText.val(data[4]);
			inputSelect.val(data[5]);
			inputHiddenCode.val(data[6]);
        });


    var imgx = $('<img/>').attr('src', '../webroot/media/images/close.png').bind('click', function() {
        $(this).parent().parent().remove();
    });

    inputText.autocomplete("../admission/indoor/get_list_icd", {
        formatItem: function(data, i, max, term) {
            return data[2] + " " + data[0];
		}
	})
	.result(function(event, data, formatted) {
        inputHidden.val(data[1]);
        inputHiddenCode.val(data[2]);
        //inputHiddenAnamnese.val('');
        //CHECK IN DATABASE, IS HE PERNAH MENDERITA PENYAKIT INI (MENENTUKAN KASUS BARU LAMA OTOMATIS)
        $.ajax({
            url: '../admission/indoor/get_new_old_case',
            type: 'post',
            data: 'visit_id=' + $('#visit_id').val() + '&q=' + data[1],
            success : function(data) {
                inputSelect.val(data);
            }
        });
        //createNextIcdInput(inputText);
    });

    lix.append("\n");
    lix.append(inputText)
    .append(inputSelect)
    .append(inputHidden)
    .append(inputHiddenCode)
    .append('<br />')
    .append(inputExplanation);

    //obj.attr('readonly', 'readonly');
    obj.after(imgx);
    var td_pertamax = $('<td style="width:100px">Diagnosis :<br/>Catatan :<br/></td>');
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
        .attr('size', '20')
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
	.autocomplete("../admission/indoor/get_list_drug", {
        extraParams: {visit_id: $('#visit_id').val()},
		formatItem: function(data, i, max, term) {
			return data[0];
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
        .attr('size', '20')
        .attr('onkeypress', "focusNext('treatment_price_" + tmti + "', 'anamnese', this, event)")
        .autocomplete("../admission/indoor/get_list_treatment", {
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
    $("#anamnese_1").autocomplete("../admission/indoor/get_list_anamnese", {
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
    $("#icd_name_1").autocomplete("../admission/indoor/get_list_icd", {
        formatItem: function(data, i, max, term) {
            return data[2] + " " + data[0];
		}
	})
    .result(function(event, data, formatted) {
        $('#icd_id_1').val(data[1]);
        $('#icd_code_1').val(data[2]);
        $('#ead_id_1').val('');
        //CHECK IN DATABASE, IS HE PERNAH MENDERITA PENYAKIT INI (MENENTUKAN KASUS BARU LAMA OTOMATIS)
        /*$.ajax({
            url: '../admission/indoor/get_new_old_case',
            type: 'post',
            data: 'visit_id=' + $('#visit_id').val() + '&q=' + data[1],
            success : function(data) {
                $('#case_1').val(data);
            }
        });*/
    });

    $("#drug_name_1")
	.autocomplete("../admission/indoor/get_list_drug", {
        extraParams: {visit_id: $('#visit_id').val()},
		formatItem: function(data, i, max, term) {
			return data[0];
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
    
    $("#treatment_name_1").autocomplete("../admission/indoor/get_list_treatment", {
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
                url:'../admission/indoor/delete_anamnese_diagnose',
                data:'id=' + xid,
                dataType: 'json',
                success: function(data) {
                    $("#pemeriksaan_fisik").focus();
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
                url:'../admission/indoor/delete_prescribe',
                data:'id=' + xid,
                dataType: 'json',
                success: function(data) {
                    //show_message('#message_checkup', data.msg, data.status);
                    $("#pemeriksaan_fisik").focus();
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
                url:'../admission/indoor/delete_treatment',
                data:'id=' + xid,
                dataType: 'json',
                success: function(data) {
                    $("#pemeriksaan_fisik").focus();
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

    $("#frmPendaftaran").validate({
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
						var xurl = '../admission/indoor/result/' + $('#visit_id').val();
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
                url:'../admission/indoor/delete_prescribe_mix',
                data:'randomnumber=' + randomnumber + '&visit_id=' + $('#visit_id').val(),
                dataType: 'json',
                success: function(data) {
                    $("#pemeriksaan_fisik").focus();
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
	.autocomplete("../admission/indoor/get_list_drug", {
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
            .attr('size', '20');
            
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
		.autocomplete("../admission/indoor/get_list_drug", {
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
//end Ajax Form Pemeriksaan
//});

function reset_form() {
    $.ajax({
        dataType:'json',
        url:'indoor/get_new_id',
        success:function(data) {
			//$('#family_folder').val(data.family_folder);
			$('#family_folder').val(data.family_folder);
            $('#is_new').val('yes');
            $('#lastvisit').text('Belum Pernah Berkunjung');
            $('#icd').text('--');
       }
    });
}
function fokus_search_form() {
	$("#panel_main").hide();
    fokus('q');
}
function fokus_admission_form() {
	$('#panel_main').show();
    fokus('family_folder');
}
function getDataJamkesda(data) {
	$.ajax({
		method:'get',
		dataType:'json',
		url:'indoor/getDataJamkesda/' + data.nik + '/' + data.name + '/' + data.birth_date2,
		success:function(data2) {
			//alert(data2.id_jamkesda);
			//data.payment_type_id = '004';
			//data.insurance_no = data2.id_jamkesda;
			$('#payment_type_id').val('004');
			$('#insurance_no').val(data2.id_jamkesda);
			//ret = data.id_jamkesda;
		}
	});
}
function get_patient_from_search(family_folder) {
	//alert('asdfasdf');
    $.ajax({
        dataType:'json',
        url:'indoor/get_data_patient/' + family_folder,
        success:function(data) {
            fill_form_from_patient(data);
            getDataJamkesda(data);
			/*
			var m = getDataJamkesda(data);
			alert(m);
			if(m != '') {
				data.payment_type_id = '004';
				data.insurance_no = m;
				//alert(m.id_jamkesda);
			}*/
        }
    });
    $("#panel_search").fadeOut("fast", fokus_admission_form);
}


function fill_form_from_patient(data) {
    if(data._empty_ == 'yes') {
        $('#is_new').val('yes');
        //$('#patient_id').val(data.id);
        $('#family_folder').val(data.family_folder);
        $('#nik').val('');
        $('#name').val('');
        $('#birth_place').val('');
        $('#birth_date').val('');
        $('#age_year').val('');
        $('#age_month').val('');
        $('#age_day').val('');
        $('#address').val('');
        $('#no_kontak').val('');
        $('#job_id').val('');
        $('#payment_type_id').val('');
        $('#insurance_no').val('');
        $('#nama_asuransi').val('');
        $('#lastvisit').text('Belum Pernah Berkunjung');
                
    } else {
        $('#is_new').val('no');
        //$('#patient_id').val(data.id);
        $('#family_folder').val(data.family_folder);
        $('#nik').val(data.nik);
        $('#name').val(data.name);   
        $('#sex').val(data.sex);
        $('#birth_place').val(data.birth_place);
        $('#birth_date').val(data.birth_date);
        $('#address').val(data.address);
        $('#no_kontak').val(data.no_kontak);
        $('#job_id').val(data.job_id);
        $('#payment_type_id').val(data.payment_type_id);
        $('#marital_status_id').val(data.marital_status_id);
        enableDisableInsuranceFromVal(data.payment_type_id);
        $('#insurance_no').val(data.insurance_no);
        $('#nama_asuransi').val(data.nama_asuransi);
        $('#lastvisit').text(data.visit_date);
        		
		$.ajax({
			url: 'indoor/hitung_usia/' + data.birth_date,
			dataType: 'json',
			success:function(data) {
				$('#age_year').val(data.year);
				$('#age_month').val(data.month);
				$('#age_day').val(data.day);
			}
		});		
    }
}

function enableDisableInsurance(obj) {
	var val = obj.value;
	if(val == '001') {
		$('#insurance_no').attr('readonly', true);
		$('#insurance_no').removeClass().addClass('readonly');
		$('#insurance_no').val('');
		$('#nama_asuransi').attr('readonly', true);
		$('#nama_asuransi').removeClass().addClass('readonly');
		$('#nama_asuransi').val('');
	} else {
		$('#insurance_no').attr('readonly', false);
		$('#insurance_no').removeClass();
		$('#nama_asuransi').attr('readonly', false);
		$('#nama_asuransi').removeClass();
	}
}

function enableDisableInsuranceFromVal(val) {
	if(val == '001') {
		$('#insurance_no').attr('readonly', true);
		$('#insurance_no').removeClass().addClass('readonly');
		$('#insurance_no').val('');
		$('#nama_asuransi').attr('readonly', true);
		$('#nama_asuransi').removeClass().addClass('readonly');
		$('#nama_asuransi').val('');
	} else {
		$('#insurance_no').attr('readonly', false);
		$('#insurance_no').removeClass();
		$('#nama_asuransi').attr('readonly', false);
		$('#nama_asuransi').removeClass();
	}
}
</script>
<div class="ui-dialog" style="width:100%;margin-right:5px;height:auto;float:left;" id="panel_main">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar"><?php echo $title;?></div>
		<div class="ui-dialog-content" id="dialogContent">
            <div id="admission_message" style="display:none"></div>
			<form method="POST" name="frmPendaftaran" id="frmPendaftaran" action="<?php echo site_url('admission/indoor/process_form');?>">
            <input type="hidden" name="is_new" id="is_new" value="yes" />
           	<input type="hidden" name="visit_id" id="visit_id" value="<?php echo $data['visit_id']?>" />
			<table cellpadding="0" cellspacing="0" border="0" class="tblInput" style="width:100%;">
				<tr>
					<td style="width:150px;font-size:18px;"><?php echo $this->lang->line('label_date');?></td>
					<td style="width:400px;font-size:18px;"><input type="text" class="date-pick" name="visit_date" id="visit_date" style="font-size:18px;" maxlength="10" value="<?=date('d/m/Y')?>" size="10" onkeyup="autoSlashTanggal(this, event)" onkeypress="focusNext('family_folder', 'visit_date', this, event)" /><i>dd/mm/yyyy</i></td>
					<td style="width:400px;font-size:14px;" rowspan="3">
		            <?php echo $this->lang->line('label_last_visit');?>
		            <span id="lastvisit" style="font-size:14px;color:#0000FF;">Belum Pernah Berkunjung</span><br/>
		            Diagnosis Terakhir :<span id="namaclinic" style="font-size:14px;color:#0000FF;">--</span><br>
		            <!--- Link Histori --->
		            <div id="show_panel_history" style="cursor:pointer;"><img src="<?php echo base_url()?>webroot/media/images/user.png" border="0" title="History Kesakitan Pasien (Ctrl+H)" alt="History (Ctrl+H)" /></div>
		            </td>
					<td>
						<!-- <a href="javascript:void(0)"> -->
                            <div id="before" style="cursor:pointer;float:left"><img src="<?php echo base_url()?>webroot/media/images/arrow_left_blue.png" border="0" title="Nomor RM sebelumnya" alt="Nomor RM sebelumnya" /></div>
                            <div id="after" style="cursor:pointer;float:left;"><img src="<?php echo base_url()?>webroot/media/images/arrow_right_blue.png" border="0" title="Nomor RM sesudahnya" alt="Nomor RM sesudahnya" /></div>
							<div id="show_panel_search" style="cursor:pointer;"><img src="<?php echo base_url()?>webroot/media/images/search_folder.png" border="0" title="Find (Ctrl+F)" alt="Find (Ctrl+F)" /></div>
						<!-- </a> -->
					</td>
					
				</tr>
				<tr>
					<td style="font-size:18px;"><?php echo $this->lang->line('label_mr_number');?></td>
					<td>
                    <table cellpadding="0" cellspacing="0" border="0">
                        <tr>
                            <td>
                    <input type="text" name="family_folder" id="family_folder" value="" size="10" maxlength="10" onkeypress="focusNext('nik', 'family_folder', this, event)" style="text-align:right;font-size:18px;font-weight:bold" title="No Rekammedis" />
                            </td>
                            <td>&nbsp;</td>
                         </tr>
                    </table>
                    </td>
                    <td>&nbsp;</td>
				</tr>         
				<tr>
					<td colspan="4"><hr /></td>
				</tr>
            </table>
            <div style="float:left;width:50%">
            <table cellpadding="0" cellspacing="0" border="0" class="tblInput">
				<tr>
					<td style="width:200px">NIK/KTP</td>
					<td><input type="text" name="nik" id="nik" value="" size="20" maxlength="16" onkeypress="focusNext('name', 'family_relationship_code', this, event)" /></td>
				</tr>
               	<tr>
					<td><?php echo $this->lang->line('label_name');?></td>
					<td>
                        <input type="text" name="name" id="name" value="" size="30" onkeypress="focusNext('birth_place', 'name', this, event)" />
                    </td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_place_date_of_birth');?></td>
					<td>
						<input type="text" name="birth_place" id="birth_place" value="" size="10" onkeypress="focusNext('birth_date', 'birth_place', this, event)" />,
						<input type="text" name="birth_date" id="birth_date" value="" size="10" maxlength="10" onkeyup="autoSlashTanggal(this, event)" onkeypress="focusNext('age_year', 'birth_date', this, event)" /><i>dd/mm/yyyy</i>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_age');?></td>
					<td><input type="text" class="age" name="age_year" id="age_year" value="" size="1" onkeypress="focusNext('age_month', 'age_year', this, event)" />th 
					<input type="text" class="age" name="age_month" id="age_month" value="" size="1" onkeypress="focusNext('age_day', 'age_month', this, event)" />bl 
					<input type="text" class="age" name="age_day" id="age_day" value="" size="1" onkeypress="focusNext('sex', 'age_day', this, event)" />hr </td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_sex');?></td>
					<td>
						<select name="sex" id="sex" style="width:100px;" onkeypress="focusNext('address', 'sex', this, event)">
							<option value="Laki-laki">Laki-laki</option>
							<option value="Perempuan">Perempuan</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_address');?></td>
					<td><input type="text" name="address" id="address" value="" size="40" onkeypress="focusNext('no_kontak', 'address', this, event)" /></td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_religion');?></td>
					<td>
						<select name="religion_id" id="religion_id" style="width:200px" onkeypress="focusNext('marital_status_id', 'job_id', this, event)">
							<option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
							<?php for($i=0;$i<sizeof($combo_religion);$i++) :?>
							<option value="<?php echo $combo_religion[$i]['id']?>"><?php echo $combo_religion[$i]['name']?></option>
							<?php endfor;?>
						</select>
					</td>
				</tr>	
				<tr>
					<td style="width:200px;"><?php echo $this->lang->line('label_no_kontak');?></td>
					<td><input type="text" name="no_kontak" id="no_kontak" value="" size="40" onkeypress="focusNext('job_id', 'address', this, event)" /></td>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_job');?></td>
					<td>
						<select name="job_id" id="job_id" style="width:200px" onkeypress="focusNext('marital_status_id', 'job_id', this, event)">
							<option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
							<?php for($i=0;$i<sizeof($combo_job);$i++) :?>
							<option value="<?php echo $combo_job[$i]['id']?>"><?php echo $combo_job[$i]['name']?></option>
							<?php endfor;?>
						</select>
					</td>
				</tr>				
				<tr>
					<td><?php echo $this->lang->line('label_marriedstatus');?></td>
					<td>
						<select name="marital_status_id" id="marital_status_id" style="width:200px" onkeypress="focusNext('payment_type_id', 'marital_status_id', this, event)">
							<option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
							<?php for($i=0;$i<sizeof($combo_marriage);$i++) :?>
							<option value="<?php echo $combo_marriage[$i]['id']?>"><?php echo $combo_marriage[$i]['name']?></option>
							<?php endfor;?>
						</select>
					</td>
				</tr>
               	<tr>
					<td><?php echo $this->lang->line('label_payment_type');?></td>
					<td>
						<select name="payment_type_id" id="payment_type_id" style="width:200px" onchange="enableDisableInsurance(this)" onkeypress="focusNext('insurance_no', 'payment_type_id', this, event)">
							<option value="">--- <?php echo $this->lang->line('form_change');?> ---</option>
							<?php for($i=0;$i<sizeof($combo_payment_type);$i++) :?>
							<?php if($combo_payment_type[$i]['id'] == '001') $sel='selected'; else $sel='';?>
							<option value="<?php echo $combo_payment_type[$i]['id']?>" <?php echo $sel;?>><?php echo $combo_payment_type[$i]['name']?></option>
							<?php endfor;?>
						</select>
					</td>
				</tr>
				<tr>
					<td><?php echo $this->lang->line('label_insurance_no');?></td>
					<td>
						<input type="text" name="insurance_no" id="insurance_no" value="" size="15" onkeypress="focusNext('nama_asuransi', 'insurance_no', this, event)" /> <?php echo $this->lang->line('label_insurance');?> 
						<input type="text" name="nama_asuransi" id="nama_asuransi" value="" size="20" onkeypress="focusNext('weight', 'nama_asuransi', this, event)" />
					</td>
				</tr>
			</table>
			<table cellpadding="0" cellspacing="0" border="0" class="tblInput" style="width:97%;">
				<tr>
				<td>
					<fieldset class="used" style="width:98%;font-color:blue;"><legend style="color:blue;">Kalkulator BMI</legend>
					<table cellpadding="0" cellspacing="0" width="100%" border="0" class="tblInput">
						<tr>
							<td style="width:30%;"><?php echo $this->lang->line('label_weight');?>
							<input type="text" name="weight" id="weight" size="7" maxlength="6" onkeypress="focusNext('height', 'weight', this, event)" value="<?php echo $checkup['weight']?>" style="text-align:right" /> Kg
							</td>
							<td style="width:30%;"><?php echo $this->lang->line('label_height');?>
								<input type="text" name="height" id="height" size="7" maxlength="6" onkeypress="focusNext('anamnese_saved_1', 'height', this, event)" value="<?php echo $checkup['height']?>" style="text-align:right" /> Cm
							</td>
							<td style="width:4%;" align="right">BMI</td>
							<td  align="center" id="bmi" style="color:#FF0000;"></td>
						</tr>
					</table>
					</fieldset>	
				</td>	
				</tr>
				<tr>
				<td>
					<fieldset class="used" style="width:98%;"><legend style="color:blue;">Anamnese</legend>
					<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
						<tr>
							<td style="width:80px;">Keluhan Utama</td>
							<td  class="list_data_<?php echo $className;?>">								

								<input type="text" name="anamnese[]" id="anamnese_1" size="80" onkeypress="focusNext('icd_name_1', 'sistole', this, event)" value="-" /><br/>
								<input type="hidden" name="ead_id[0]" id="ead_id_1" />

							</td>
						</tr>
					</table>
					</fieldset>	
				</td>	
				</tr>
				<tr>
					<td>
						<fieldset class="used" style="width:98%;"><legend style="color:blue;">Vital Sign</legend>
							<table border="0" cellpadding="0" cellspacing="0" style="width:100%;">
								<tr>
									<td>
									<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
								<tr>
									<td style="width:50px;"><?php echo $this->lang->line('label_blood_pressure');?></td>
									<td>
										<input type="text" name="sistole" id="sistole" size="5" maxlength="6" onkeypress="focusNext('diastole', 'height', this, event)" value="<?php echo $checkup['sistole']?>" style="text-align:right" /> / 
										<input type="text" name="diastole" id="diastole" size="5" maxlength="6" onkeypress="focusNext('temperature', 'sistole', this, event)" value="<?php echo $checkup['diastole']?>" style="text-align:right" /> mmhg<br/>
										<div id="blood_pressure_formula_result" style="color:#FF0000"></div>
									</td>
								</tr>
								<tr>
									<td><?php echo $this->lang->line('label_temperature');?></td>
									<td>
										<input type="text" name="temperature" id="temperature" size="7" maxlength="6" onkeypress="focusNext('pulse', 'temperature', this, event)" value="<?php echo $checkup['temperature']?>" style="text-align:right" /> &ordm; C
									</td>
								</tr>
								<tr>
									<td><?php echo $this->lang->line('label_pulse');?></td>
									<td>
										<input type="text" name="pulse" id="pulse" size="7" maxlength="6" onkeypress="focusNext('respiration', 'pulse', this, event)" value="<?php echo $checkup['pulse']?>" style="text-align:right" /> x/mnt
									</td>
								</tr>
								</table>
							</td>
							<td>
								<table style="width:90%;valign:top;">
									<tr>
									<td><?php echo $this->lang->line('label_respiration');?></td>
									<td>
										<input type="text" name="respiration" id="respiration" size="7" maxlength="6" onkeypress="focusNext('blood_type', 'respiration', this, event)" value="<?php echo $checkup['respiration']?>" style="text-align:right" /> x/mnt
									</td>
								</tr>
								<tr>
									<td>Golongan Darah</td>
									<td>
										<input type="text" name="blood_type" id="blood_type" size="3" maxlength="2" onkeypress="focusNext('pemeriksaan_fisik', 'blood_type', this, event)" value="<?php echo $checkup['blood_type']?>" style="text-align:right" />
									</td>
								</tr>
								</table>
							</td>
							</tr>
							</table>
						</fieldset>						
					</td>
				</tr>
				</td>
				</tr>
				<tr>
				<td>
					<fieldset class="used" style="width:98%;"><legend style="color:blue;">Pemeriksaan Fisik</legend>
					<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
						<tr>
							<td style="width:100px;">Hasil Pemeriksaan</td>
							<td>
								<textarea cols="60" rows="2" name="pemeriksaan_fisik" id="pemeriksaan_fisik" onkeypress="focusNext('icd_name_1', 'pemeriksaan_fisik', this, event)"/></textarea>
							</td>
						</tr>
					</table>
					</fieldset>	
				</td>	
				</tr>
				</table>
                </div>
				<div style="float:left;width:50%">
				<!---------Pemeriksaan ---------------------------------------------------------------------------------------------->
				<fieldset class="used"><legend style="color:blue;">Diagnosis</legend>
							<table border="0" style="width:95%" id="ol_list_anamnese_diagnose">
								<?php for($i=0;$i<sizeof($diagnoses);$i++) :?>
									<?php if($diagnoses[$i]['log'] == 'yes') $className="deleted"; else $className="";?>
									<tr class="list_data_<?php echo $className;?>">
										<td style="width:80px">Diagnosis :<br/><br/>Catatan :<br/></td>
										<td class="list_data_<?php echo $className;?>" style="border-bottom:solid 1px #000000;">
										<input type="hidden" name="ead_saved_id[]" id="ead_saved_id_<?php echo $diagnoses[$i]['id']?>" value="<?php echo $diagnoses[$i]['id']?>" />
										<?php if($diagnoses[$i]['log'] == 'no') :?>
										<img src="../webroot/media/images/close.png" alt="Delete" class="button_delete_anamnese_diagnose" />
										<?php endif;?>
										<input readonly="readonly" type="text" name="icd_saved_name[]" id="icd_saved_name_<?php echo $diagnoses[$i]['id']?>" size="25" value="<?php echo $diagnoses[$i]['name']?>" onkeypress="focusNext('case_saved_<?php echo $diagnoses[$i]['id']?>', 'anamnese', this, event)" class="<?php echo $className?>" />
										<input type="hidden" name="icd_saved_id[]" id="icd_saved_id_<?php echo $diagnoses[$i]['id']?>" value="<?php echo $diagnoses[$i]['id']?>" />
										<input type="hidden" name="icd_saved_code[]" id="icd_saved_code_<?php echo $diagnoses[$i]['id']?>" value="<?php echo $diagnoses[$i]['code']?>" />
										<textarea col="60" rows="1" readonly="readonly" name="explanation_saved[]" id="explanation_saved_<?php echo $diagnoses[$i]['id']?>" class="<?php echo $className?>"><?php echo $diagnoses[$i]['explanation']?> </textarea>
										</td>
									</tr>
								<?php endfor;?>
								<tr>
									<td style="width:80px">Diagnosis :<br/><br/>Catatan :</br></td>
									<td style="border-bottom:solid 1px #000000;">
										<input type="hidden" name="ead_id[0]" id="ead_id_1" />
										<input type="text" name="icd_name[0]" id="icd_name_1" size="20" onkeypress="focusNext('case_1', 'icd_name_1', this, event)" value="" />
										<input type="hidden" name="icd_id[0]" id="icd_id_1" />
										<input type="hidden" name="icd_code[0]" id="icd_code_1" />
										<textarea cols="60" rows="1" name="explanation[0]" id="explanation_1" onkeypress="focusNext('icd_name_2', 'case_1', this, event)"/></textarea>
									</td>
								</tr>
							</table>
							<div style="text-align:right"><a href="javascript:void(0)" id="link_add_anamnese_diagnose">Tambah Diagnosa</a></div>
						</fieldset>				
				<tr>
				<td colspan="2">
					<fieldset class="used" style="width:97%;"><legend style="color:blue;"><?php echo $this->lang->line('label_prescribes');?></legend>
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
								<input type="text" name="drug_saved_name[]" id="drug_saved_name_<?php echo $prescribes[$i]['id']?>" size="20" onkeypress="focusNext('saved_dosis1_<?php echo $prescribes[$i]['id']?>', 'anamnese', this, event)" value="<?php echo $prescribes[$i]['name']?>" readonly="readonly" class="<?php echo $className?>" />
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
								<input type="text" name="drug_name[]" id="drug_name_1" size="20" onkeypress="focusNext('dosis1_1', 'anamnese', this, event)" value="" />
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
			</td>
			</tr>
			<tr>
			<td colspan="2">
			<fieldset class="used" style="width:97%;"><legend style="color:blue;">Resep Racikan</legend>
									<table id="list_prescribes_mix">
										<thead>
										<tr>
											<th style="">Nama Racikan/Obat</th>
											<th style="">Dosis</th>
											<th style="text-align:left">Jml</th>
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
													<input type="text" name="mix_name[<?php echo $prescribes_mix[$i]['randomnumber']?>]" size="20" value="<?php echo $prescribes_mix[$i]['mix_name']?>" readonly="readonly" class="<?php echo $className?>" />
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
													&bull;<input type="text" name="mix_drug_saved_name[<?php echo $prescribes_mix[$i]['randomnumber']?>][]" id="mix_drug_saved_name_<?php echo $prescribes_mix[$i]['id']?>" size="20" value="<?php echo $prescribes_mix[$i]['name']?>" readonly="readonly" class="<?php echo $className?>" />
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
													&bull;<input type="text" name="mix_drug_saved_name[<?php echo $prescribes_mix[$i]['randomnumber']?>][]" id="mix_drug_saved_name_<?php echo $prescribes_mix[$i]['id']?>" size="20" value="<?php echo $prescribes_mix[$i]['name']?>" readonly="readonly" class="<?php echo $className?>" />
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
													<input type="text" name="mix_name[]" id="mix_name_1" size="15" />
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
													&bull;<input type="text" name="mix_drug_name[][]" id="mix_drug_name_1" size="20" />
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
				<tr>
					<td>
					<fieldset class="used"><legend style="color:blue;"><?php echo $this->lang->line('label_treatment');?></legend>
							<table id="list_treatments">
								<tr>
									<th style="width:370px"><?php echo $this->lang->line('label_treatment');?></th>
									<th style="width:120px"><?php echo $this->lang->line('label_price');?></th>
								</tr>
								<?php for($i=0;$i<sizeof($treatments);$i++) :?>
									<?php if($treatments[$i]['log'] == 'yes') $className="deleted"; else $className="";?>
									<tr id="li_treatment_saved_<?php echo $treatments[$i]['id']?>" class="list_data_<?php echo $className;?>">
										<td class="list_data_<?php echo $className;?>">

											<input type="text" name="treatment_saved_name[]" id="treatment_saved_name_<?php echo $treatments[$i]['id']?>" size="20" onkeypress="focusNext('price_saved_<?php echo $treatments[$i]['id']?>', 'price_saved_<?php echo $treatments[$i]['id']?>', this, event)" value="<?php echo $treatments[$i]['name']?>" readonly="readonly" class="<?php echo $className?>" />
										</td>
										<td class="list_data_<?php echo $className;?>">
											<input type="text" name="price_saved[]" id="price_saved_<?php echo $treatments[$i]['id']?>" size="10" onkeypress="focusNext('treatment_saved_name_<?php echo $treatments[$i]['id']?>', 'treatment_saved_name_<?php echo $treatments[$i]['id']?>', this, event)" value="<?php echo $treatments[$i]['price']?>" style="text-align:right" class="<?php echo $className?>" />

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
										<input type="text" name="treatment_name[]" id="treatment_name_1" size="20" onkeypress="focusNext('treatment_price_1', 'treatment_price_1', this, event)" value="" />
									</td>
									<td>
										<input type="text" name="treatment_price[]" id="treatment_price_1" size="10" onkeypress="focusNext('treatment_name_2', 'treatment_name_1', this, event)" value="" style="text-align:right" />
									</td>
								</tr>
							</table>
							<div style="text-align:right"><a href="javascript:void(0)" id="link_add_treatment">Tambah Tindakan</a></div>
						</fieldset>
					</td>
				</tr>
				<tr>
					<td>
					<fieldset class="used"><legend style="color:blue;">Penanganan Lanjut</legend>
							<table>
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
										if($data['continue_id'] == '03') $display="";
										else $display = "display:none";
										?>
										&nbsp;<input style="<?php echo $display;?>" type="text" name="continue_to" id="continue_to" value="<?php echo $data['continue_to'];?>" onkeypress="focusNext('specialis', 'continue_id', this, event)" size="20">&nbsp;<input style="<?php echo $display;?>" type="text" name="specialis" id="specialis" value="<?php echo $data['specialis'];?>" onkeypress="focusNext('save', 'specialis', this, event)" size="20">
									</td>
								</tr>
							</table>
						</fieldset>
					</td>
				</tr>
				</table>
            </div>
            <div style="clear:both"></div>
            <div style="text-align:center" class="tblInput">
            <input type="submit" name="Save" id="save" value="Simpan" />
              <input type="reset" name="Reset" id="reset" value="Reset" />
            </div>
			</form>
		</div>
        <div class="ui-dialog-buttonpane">
		<?php echo $this->lang->line('info_ctrl_f_find');?>
        </div>
	</div>
</div>
<div id="search_by_name" style="display:none;z-index:2;position:absolute;background-color:#FFFFFF;border:solid 3px #28530b"></div>
<div id="panel_search" class="ui-dialog" style="display:none;width:99%;height:auto;position:absolute;z-index:3;top:0;">
	<div style="position: relative;" class="ui-dialog-container">
		<div class="ui-dialog-titlebar">Pencarian Pasien
			<a class="ui-dialog-titlebar-close" href="javascript:void(0)" id="close_panel_search"></a>
		</div>
		<div class="ui-dialog-content" style="min-height:490px;">
			<form method="POST" name="frmSearch" id="frmSearch" action="<?php echo site_url('admission/search');?>">
			<table cellpadding="0" cellspacing="0" border="0" class="tblInput">
				<tr>
					<td style="width:150px"><?php echo $this->lang->line('label_keyword');?></td>
					<td><input type="text" name="q" id="q" value="" size="30" onkeypress="focusNext('Search', 'q', this, event)" /></td>
				</tr>
				<tr>
					<td></td><td><div style="float:left;"><input type="submit" name="Search" id="submit_search" value="Cari" /></div>
					<div id="divLoadingSearch" class="divLoading" style="display:none">Loading...</div></td>
				</tr>
			</table>
			</form>
			<div id="divSearchResult"></div>
		</div>
        <div class="ui-dialog-buttonpane">
            <?php echo $this->lang->line('label_press_esc_to_close');?>
        </div>
	</div>
</div>
