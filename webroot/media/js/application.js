function autosum(obj) {
	var plus = obj.value.split('+');
	var i;
	var total=0;
	for(i=0;i<plus.length;i++) {
		total += parseFloat(plus[i]);
	}
	obj.value=total.toString();
}
function fokus(elemId) {
	document.getElementById(elemId).focus();
	document.getElementById(elemId).select;
}
function autoSlashTanggal(obj, evt) {
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
	debug("Anda Menekan Tombol : " + charCode);

	var val = obj.value;
	var lebar = obj.value.length;
	if(charCode != 8) {
		if(lebar == 2) {
			obj.value = val + '/';
		}
		if(lebar == 5) {
			obj.value = val + '/';
		}
	}
}
function autoSlashTime(obj, evt) {
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
	debug("Anda Menekan Tombol : " + charCode);

	var val = obj.value;
	var lebar = obj.value.length;
	if(charCode != 8) {
		if(lebar == 2) {
			obj.value = val + ':';
		}
	}
}
function disableMe(obj) {
	obj.disabled=true;
}
function disableForm() {
	//alert(frm);
	$('input, select, button, textarea').attr('disabled','disabled');
}
function enableForm() {
	$('input, select, button, textarea').removeAttr('disabled');
}


function focusNext(elemNext, elemBefore, elemThis, evt) {
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode : ((evt.which) ? evt.which : evt.keyCode);
	debug("Anda Menekan Tombol : " + charCode);
    if (evt.ctrlKey && charCode == 13 || evt.shiftKey && charCode == 13 ) { //enter
		if (elemThis.type == "text" || elemThis.type == "button" || elemThis.type == "select-one" || elemThis.type == "password" || elemThis.type == "checkbox" || elemThis.type == "radio" || elemThis.type == "textarea")
		{
			$('#'+elemBefore+'').focus();
			$('#'+elemBefore+'').select();
			evt.preventDefault();
		} 
    } else if (charCode == 13) { //enter
		if (elemThis.type == "text" || elemThis.type == "button" || elemThis.type == "select-one" || elemThis.type == "password" || elemThis.type == "checkbox" || elemThis.type == "radio" || elemThis.type == "textarea")
		{
			$('#'+elemNext+'').focus();
			$('#'+elemNext+'').select();
			evt.preventDefault();
		} 
    }
    return false;
}


function numeralsOnly(obj, evt) {
    evt = (evt) ? evt : event;
    var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode : 
        ((evt.which) ? evt.which : 0));
    if (charCode > 31 && (charCode < 48 || charCode > 57) && (charCode > 105 || charCode < 96)) {
		var val = parseInt(obj.value);
		if(val == "NaN" || val == "undefined" || !val) val = "";
		obj.value = val;
    }
    return true;
}

function debug(txt) {
	if(document.getElementById('debug')) document.getElementById('debug').innerHTML = txt;
}
/*
function display_message(txt) {
	if(!txt) txt = 'Data Saved!';
    humanMsg.displayMsg(txt);
    return false;
}
*/
/*
var show_message_timeout_id;
function show_message(containerId, msg, xstatus) {
	clearTimeout(show_message_timeout_id);
	if(!xstatus || xstatus == '') {
		xstatus = 'success';
	}
	$(containerId).text('').text(msg).removeClass().addClass(xstatus).slideDown('slow');
	show_message_timeout_id = setTimeout(function(){$(containerId).slideUp('slow');}, 20000);
}
*/
function show_message(status, msg) {
	if(jQuery.isPlainObject(status)) {
		status = status.status;
		msg = status.msg;
	}
	/*
	$.pnotify({
		pnotify_history: false,
		pnotify_delay: 500,
		pnotify_text: data.msg,
		pnotify_type: data.status,
		pnotify_animation: {effect_in: 'bounce', effect_out: 'drop'},
		pnotify_shadow: true
	});
	* */
	/*
	 * 
	<div style="padding: 0 .7em;" class="ui-state-error ui-corner-all"> 
		<p><span style="float: left; margin-right: .7em;" class="ui-icon ui-icon-alert"></span> 
		<strong>Error:</strong> Needs more cowbell. </p>
	</div>

	 * */
	 var message;
	 if(status == 'error' && (!msg || msg == '')) { msg = 'Terdapat kesalahan dalam pengisian form. silakan cek kembali';}
	 if((status == 'info' || status == 'success') && (!msg || msg == '')) { msg = 'Data berhasil disimpan';}
	 if(status == 'error') {
		message = '<div style="padding: 1em;" class="ui-state-error ui-corner-all"><p><span style="float: left; margin-right: .7em;" class="ui-icon ui-icon-alert"></span><strong>Error : </strong>'+msg+'</p></div>';
		$('#smc-message-container').html(message).show('pulsate').delay(2000).hide('drop');
	} else {
		message = '<div style="padding: 1em;" class="ui-state-highlight ui-corner-all"><p><span style="float: left; margin-right: .7em;" class="ui-icon ui-icon-info"></span><strong>Info : </strong>'+msg+'</p></div>';
		$('#smc-message-container').html(message).show('drop').delay(2000).hide('drop');
	}
	
}
function openPopup(url) {
	//var p = window.open(url, 'p');
	var p = window.open(url, 'p', 'scrollbar=1,menubar=1,width=800,height=700,addressbar=0,statusbar=0');
	p.focus;
	//p.print();
}
function basename(path, suffix) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Ash Searle (http://hexmen.com/blog/)
    // +   improved by: Lincoln Ramsay
    // +   improved by: djmix
    // *     example 1: basename('/www/site/home.htm', '.htm');
    // *     returns 1: 'home'
 
    var b = path.replace(/^.*[\/\\]/g, '');
    
    if (typeof(suffix) == 'string' && b.substr(b.length-suffix.length) == suffix) {
        b = b.substr(0, b.length-suffix.length);
    }
    
    return b;
}
function getRandomNumber() {
	return Math.floor(Math.random()*1000000);
}

function addExtraZero(data, len) {
    var x = '';
    data = data + '';
	var y = parseInt(len) - data.length;
	while(x.length < y) {
		x += "0";
	}
	return x + data;
}

function removeExtraZero(data) {
    data = data + '';
    var dlength = data.length;
	//var y = parseInt(len) - data.length;
	while(data.substr(0,1) == '0') {
		data = data.substr(1, dlength)
	}
	return data;
}
function Terbilang(bilangan) {

 bilangan    = String(bilangan);
 var angka   = new Array('0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0');
 var kata    = new Array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan');
 var tingkat = new Array('','Ribu','Juta','Milyar','Triliun');

 var panjang_bilangan = bilangan.length;

 /* pengujian panjang bilangan */
 if (panjang_bilangan > 15) {
   kaLimat = "Diluar Batas";
   return kaLimat;
 }

 /* mengambil angka-angka yang ada dalam bilangan, dimasukkan ke dalam array */
 for (i = 1; i <= panjang_bilangan; i++) {
   angka[i] = bilangan.substr(-(i),1);
 }

 i = 1;
 j = 0;
 kaLimat = "";


 /* mulai proses iterasi terhadap array angka */
 while (i <= panjang_bilangan) {

   subkaLimat = "";
   kata1 = "";
   kata2 = "";
   kata3 = "";

   /* untuk Ratusan */
   if (angka[i+2] != "0") {
     if (angka[i+2] == "1") {
       kata1 = "Seratus";
     } else {
       kata1 = kata[angka[i+2]] + " Ratus";
     }
   }

   /* untuk Puluhan atau Belasan */
   if (angka[i+1] != "0") {
     if (angka[i+1] == "1") {
       if (angka[i] == "0") {
         kata2 = "Sepuluh";
       } else if (angka[i] == "1") {
         kata2 = "Sebelas";
       } else {
         kata2 = kata[angka[i]] + " Belas";
       }
     } else {
       kata2 = kata[angka[i+1]] + " Puluh";
     }
   }

   /* untuk Satuan */
   if (angka[i] != "0") {
     if (angka[i+1] != "1") {
       kata3 = kata[angka[i]];
     }
   }

   /* pengujian angka apakah tidak nol semua, lalu ditambahkan tingkat */
   if ((angka[i] != "0") || (angka[i+1] != "0") || (angka[i+2] != "0")) {
     subkaLimat = kata1+" "+kata2+" "+kata3+" "+tingkat[j]+" ";
   }

   /* gabungkan variabe sub kaLimat (untuk Satu blok 3 angka) ke variabel kaLimat */
   kaLimat = subkaLimat + kaLimat;
   i = i + 3;
   j = j + 1;

 }

 /* mengganti Satu Ribu jadi Seribu jika diperlukan */
 if ((angka[5] == "0") && (angka[6] == "0")) {
   kaLimat = kaLimat.replace("Satu Ribu","Seribu");
 }

 return kaLimat + "Rupiah";
}
function number_format(nStr)
{
  nStr += '';
  x = nStr.split('.');
  x1 = x[0];
  x2 = x.length > 1 ? '.' + x[1] : '';
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(x1)) {
    x1 = x1.replace(rgx, '$1' + ',' + '$2');
  }
  return x1 + x2;
}
