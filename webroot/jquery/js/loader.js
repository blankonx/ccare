(function ($) {
	$.fn.spin = function (action, options) {
		if (typeof action == typeof {}) { options = action; action = null; }
		options = $.extend({ action: action || 'start', speed: 1000 }, options);

		var img = $(this);
		if (!img.is('img')) throw 'Hey!  You can only use $.fn.spin for images!';

		var data = img.data('spin.data');
		if (data == null) {
			if (typeof Raphael == 'undefined') throw 'Hey!  You need RaphaelJS (http://www.raphaeljs.com)!';
			var size = { width: img.width(), height: img.height() }
			data = { div: img.wrap('<div/>').parent()
				.attr({ id: 'jQueryspin' + Math.random().toString().substr(2) })
				.css(size).css('overflow', 'hidden')
			};
			data.r = Raphael(data.div.attr('id'), size.width, size.height);
			data.rimg = data.r.image(img.attr('src'), 0, 0, size.width, size.height); 

			setTimeout(function () { data.r.safari(); });
			img.data('spin.data', data);

			img.hide().bind('spin.start', function (e) {
				img.trigger('spin.stop');
				var spin = function () {
					data.rimg.attr({ rotation: 0 });
					data.rimg.animate({ rotation: 360 }, e.speed, 'linear');
				};
				spin();
				data.tmr = setInterval(spin, e.speed);

			}).bind('spin.stop', function () {
				clearInterval(data.tmr);
				data.rimg.stop();
				data.rimg.attr({ rotation: 0 });
			});
		}

		img.trigger({ type: 'spin.' + options.action, speed: options.speed });
	}
})(jQuery);
