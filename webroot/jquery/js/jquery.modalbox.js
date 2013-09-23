(function($){
	$.fn.extend({
		modalPanel: function() {
			
			//Create our overlay object
			var overlay = $("<div id='modal-overlay'></div>");
			//Create our modal window
			var modalWindow = $("<div id='modal-window'></div>");
			
			return this.each(function() {
				//Listen for clicks on objects passed to the plugin
				$(this).click(function(e) {
					
					if (typeof document.body.style.maxHeight === "undefined") { //if IE 6
						$("body","html").css({height: "100%", width: "100%"});
						$("html").css("overflow","hidden");
					}
					
					//Append the overlay to the document body
					$("body").append(overlay.click(function() { modalHide(); }))
					//Add a loader to our page
					$("body").append("<div id='modal-load'></div>");
					
					//Set the css and fade in our overlay
					overlay.css("opacity", 0.8);
					overlay.fadeIn(150);
					
					//Prevent the anchor link from loading
					e.preventDefault();
					
					//Activate a listener 
					$(document).keydown(handleEscape);	
					
					//Load the image
					var img = new Image();
					$(img).load(function () {
						var imageWidth = img.width / 2 ;
						var imageHeight = img.height / 2;
						modalWindow.css({
							"margin-left": -imageWidth,
							"margin-top": -imageHeight
						});	
						$("#modal-load").remove();
						modalWindow.append(img);
						$(this).addClass("modal-image");
						$("body").append(modalWindow);
						modalWindow.fadeIn(150);
					})
					.attr({ src: this.href }).click(function() {
						modalHide();
					});
				});
			});
			
			//Our function for hiding the modalbox
			function modalHide() {
				$(document).unbind("keydown", handleEscape)
				var remove = function() { $(this).remove(); };
				overlay.fadeOut(remove);
				modalWindow
					.fadeOut(remove)
					.empty();
			}
			
			//Our function that listens for escape key.
			function handleEscape(e) {
				if (e.keyCode == 27) {
					modalHide();
				}
			}
		}
	});
})(jQuery);