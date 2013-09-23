// jQuery Alert Dialogs Plugin
//
// Version 1.1
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 14 May 2009
//
// Visit http://abeautifulsite.net/notebook/87 for more information
//
// Usage:
//		jAlert( message, [title, callback] )
//		jConfirm( message, [title, callback] )
//		jPrompt( message, [value, title, callback] )
// 
// History:
//
//		1.00 - Released (29 December 2008)
//
//		1.01 - Fixed bug where unbinding would destroy all resize events
//
// License:
// 
// This plugin is dual-licensed under the GNU General Public License and the MIT License and
// is copyright 2008 A Beautiful Site, LLC. 
//
(function($) {
	
	$.alerts = {
		
		// These properties can be read/written by accessing $.alerts.propertyName from your scripts at any time
		okButton: '&nbsp;OK&nbsp;',         // text for the OK button
		cancelButton: '&nbsp;Cancel&nbsp;', // text for the Cancel button
		
		// Public methods
		
		alert: function(message, title, callback) {
			if( title == null ) title = 'Peringatan!';
			$.alerts._show(title, message, null, 'alert', function(result) {
				if( callback ) callback(result);
			});
		},
		
		confirm: function(message, title, callback) {
			if( title == null ) title = 'Konfirmasi';
			$.alerts._show(title, message, null, 'confirm', function(result) {
				if( callback ) callback(result);
			});
		},
			
		prompt: function(message, value, title, callback) {
			if( title == null ) title = 'Prompt';
			$.alerts._show(title, message, value, 'prompt', function(result) {
				if( callback ) callback(result);
			});
		},
		
		// Private methods
		
		_show: function(title, msg, value, type, callback) {
			switch( type ) {
				case 'alert':
					$("#smc-alert").html('<div class="smc-alert-icon" style="float:left; margin-right:20px;"></div>' + msg);
					$('#smc-alert').dialog({
						title:title,
						width: 400,
						height: 200,
						modal: true,
						resizable:false,
						buttons: {
							'Ok' : function() {
								$('#smc-alert').dialog("close");
								callback(true);
							}
						}
					});
				break;
				case 'confirm':
					$("#smc-confirm").html('<div class="smc-confirm-icon" style="float:left; margin-right:20px;"></div>' + msg);
					$('#smc-confirm').dialog({
						title:title,
						width: 400,
						height: 200,
						modal: true,
						resizable:false,
						buttons: {
							'Ok' : function() {
								$('#smc-confirm').dialog("close");
								if( callback ) callback(true);
							},
							'Batal' : function() {
								$('#smc-confirm').dialog("close");
								//if( callback ) callback(false);
							}
						}
					});
					//$('#smc-confirm').dialog('open');
				break;
				case 'prompt':
					$("#smc-prompt").html('<div class="smc-prompt-icon" style="float:left; margin-right:20px;"></div>' + msg);
					$("#smc-prompt").append('<div class="ui-form"><input type="text" size="30" id="smc-prompt-text" /></div>');
					$('#smc-prompt').dialog({
						title:title,
						width: 400,
						height: 200,
						modal: true,
						resizable:false,						
						buttons: {
							'Ok' : function() {
								var val = $("#smc-prompt-text").val();
								if( callback ) callback( val );
								$('#smc-prompt').dialog("close");
							},
							'Batal' : function() {
								$('#smc-prompt').dialog("close");
								//if( callback ) callback(null);
							}
						}
					});
					$("#smc-prompt-text").focus().select();
				break;
			}
		}
	}
	
	// Shortuct functions
	smcAlert = function(message, callback, title) {
		$.alerts.alert(message, title, callback);
	}
	
	smcConfirm = function(message, callback, title) {
		$.alerts.confirm(message, title, callback);
	};
		
	smcPrompt = function(message, value, callback, title) {
		$.alerts.prompt(message, value, title, callback);
	};
	
})(jQuery);
