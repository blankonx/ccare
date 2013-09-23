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
		
		verticalOffset: -75,                // vertical offset of the dialog from center screen, in pixels
		horizontalOffset: 0,                // horizontal offset of the dialog from center screen, in pixels/
		repositionOnResize: true,           // re-centers the dialog on window resize
		overlayOpacity: .01,                // transparency level of overlay
		overlayColor: '#FFF',               // base color of overlay
		draggable: true,                    // make the dialogs draggable (requires UI Draggables plugin)
		okButton: '&nbsp;OK&nbsp;',         // text for the OK button
		cancelButton: '&nbsp;Cancel&nbsp;', // text for the Cancel button
		dialogClass: null,                  // if specified, this class will be applied to all dialogs
		
		// Public methods
		
		alert: function(message, title, callback) {
			if( title == null ) title = 'Alert';
			$.alerts._show(title, message, null, 'alert', function(result) {
				if( callback ) callback(result);
			});
		},
		
		confirm: function(message, title, callback) {
			if( title == null ) title = 'Confirm';
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
			
			//$.alerts._hide();
			//$.alerts._overlay('show');
			$('#confirmation').dialog({
				title:title,
				autoOpen:false,
				width: 300,
				height: 200,
				modal: true,
				resizable:false
			});
			// IE6 Fix
			var pos = ($.browser.msie && parseInt($.browser.version) <= 6 ) ? 'absolute' : 'fixed'; 
			$("#confirmation").html(msg);
			
			//$.alerts._reposition();
			//$.alerts._maintainPosition(true);
			
			switch( type ) {
				case 'alert':
					$('#confirmation').dialog({
						buttons: {
							'Ok' : function() {
								$('#confirmation').dialog("close");
								callback(true);
							}
						}
					});
				break;
				case 'confirm':
					$('#confirmation').dialog({
						buttons: {
							'Ok' : function() {
								$('#confirmation').dialog("close");
								if( callback ) callback(true);
							},
							'Batal' : function() {
								$(this).dialog("close");
								if( callback ) callback(false);
							}
						}
					});
				break;
				case 'prompt':
					$("#confirmation").append('<div class="ui-form"><input type="text" size="30" id="confirmation-prompt" /></div>');
					$('#confirmation').dialog({
						buttons: {
							'Ok' : function() {
								var val = $("#confirmation-prompt").val();
								if( callback ) callback( val );
								$('#confirmation').dialog("close");
							},
							'Batal' : function() {
								$(this).dialog("close");
								if( callback ) callback(null);
							}
						}
					});
					$("#confirmation-prompt").focus().select();
				break;
			}
		},
		
		_reposition: function() {
			var top = (($(window).height() / 2) - ($("#popup_container").outerHeight() / 2)) + $.alerts.verticalOffset;
			var left = (($(window).width() / 2) - ($("#popup_container").outerWidth() / 2)) + $.alerts.horizontalOffset;
			if( top < 0 ) top = 0;
			if( left < 0 ) left = 0;
			
			// IE6 fix
			if( $.browser.msie && parseInt($.browser.version) <= 6 ) top = top + $(window).scrollTop();
			
			$("#popup_container").css({
				top: top + 'px',
				left: left + 'px'
			});
			$("#popup_overlay").height( $(document).height() );
		},
		
		_maintainPosition: function(status) {
			if( $.alerts.repositionOnResize ) {
				switch(status) {
					case true:
						$(window).bind('resize', $.alerts._reposition);
					break;
					case false:
						$(window).unbind('resize', $.alerts._reposition);
					break;
				}
			}
		}
		
	}
	
	// Shortuct functions
	xAlert = function(message, title, callback) {
		$.alerts.alert(message, title, callback);
	}
	
	xConfirm = function(message, title, callback) {
		$.alerts.confirm(message, title, callback);
	};
		
	xPrompt = function(message, value, title, callback) {
		$.alerts.prompt(message, value, title, callback);
	};
	
})(jQuery);
