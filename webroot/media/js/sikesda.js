function fokus(elemId) {
	document.getElementById(elemId).focus();
	document.getElementById(elemId).select;
}
function delete_data_by_id(xid) {
	var konfirm = confirm('Yakin akan menghapus data?');
	if(konfirm) xajax__delete_data_by_id(xid);
	else return false;
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
	//debug("Anda Menekan Tombol : " + charCode);
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
function addOption(selectId,txt,val,defsel,sel)
{
	var objOption = new Option(txt,val,defsel,sel);
	document.getElementById(selectId).options.add(objOption);
}

function showLoading(elemId) {
	var obj = document.getElementById(elemId);
	obj.style.display='none';
	var loadingImg = document.createElement('img');
	loadingImg.setAttribute('src', '../webroot/images/loading.gif');
	obj.parentNode.appendChild(loadingImg);
}

function completeLoading(elemId) {
	var obj = document.getElementById(elemId);
	obj.style.display='';
	var loadingImg = obj.parentNode.childNodes[3];
	loadingImg.parentNode.removeChild(loadingImg);
}
function disableSelection(element) {
    element.onselectstart = function() {
        return false;
    };
    element.unselectable = "on";
    element.style.MozUserSelect = "none";
    element.style.cursor = "default";
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
var show_message_timeout_id;
function show_message(containerId, msg, xstatus) {
	clearTimeout(show_message_timeout_id);
	if(!xstatus || xstatus == '') {
		xstatus = 'success';
	}
	containerId = "#xmessage";
	$(containerId).text('').text(msg).removeClass().addClass(xstatus).slideDown('fast');
	show_message_timeout_id = setTimeout(function(){$(containerId).slideUp('fast');}, 2000);
}

function openPrintPopup(url) {
	var p = window.open(url, 'p');
	//var p = window.open(url, 'p', 'scrollbar=1,menubar=1,width=1000,height=500,addressbar=0,statusbar=0');
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
