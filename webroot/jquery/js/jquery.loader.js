(function ($) {

    $.widget("ui.loader", {
        interval: 0,
        intervalValue: 0,

        options: {
            speed: 25,
            autoStart: false,
            cssClass: 'ui-loader',
            overlayCssClass: 'ui-loader-overlay',
            progressCssClass: 'ui-loader-progress'
        },

        _create: function () {
            this.on = false;

            if (this.options.autoStart) {
                this.loader();
            }
        },

        destroy: function () {
            this.element.find('.' + this.options.cssClass).remove();

            clearInterval(this.interval);

            $.Widget.prototype.destroy.call(this);
        },

        _setOption: function (key, value) {
            this.options[key] = value;
        },

        _draw: function () {
            if (this.on) {
                var element = this.element;
                var top = element.offset().top - $(window).scrollTop();
                var left = element.offset().left - $(window).scrollLeft();

                this.wrapper.css({
                    position: 'fixed',
                    top: top,
                    left: left,
                    width: element.outerWidth(),
                    height: element.outerHeight()
                });

                this.progress.css({
                    'margin-top': (-1 * this.progress.outerHeight()) / 2,
                    'margin-left': (-1 * this.progress.outerWidth()) / 2
                });
            }
        },

        _drawEvent: function (event) {
            event.data.parent._draw();
        },

        loader: function (show) {
            var loader = this;
            var element = this.element;

            if (show) {
                if (!this.on) {
                    loader.on = true;

                    loader.intervalValue = 0;

                    loader.wrapper = $("<div>");
                    loader.wrapper.appendTo(element).addClass(loader.options.cssClass);
                    loader.wrapper.width(loader.element.outerWidth()).height(loader.element.outerHeight());

                    $(window).bind('resize', { parent: loader }, loader._drawEvent);
                    $(window).bind('scroll', { parent: loader }, loader._drawEvent);

                    var overlay = $("<div>");
                    overlay.appendTo(loader.wrapper).addClass(loader.options.overlayCssClass).addClass('ui-widget-overlay');

                    loader.progress = $("<div>");
                    loader.progress.appendTo(loader.wrapper).addClass(loader.options.progressCssClass);
                    loader.progress.progressbar({ value: loader.intervalValue });

                    loader.interval = setInterval(function () {
                        loader.progress.progressbar({ value: loader.intervalValue });
                        loader.intervalValue = loader.intervalValue == 100 ? 0 : loader.intervalValue = loader.intervalValue + 1;
                    }, loader.options.speed);

                    this._draw();
                }
            }
            else {
                if (this.on) {
                    loader.wrapper.remove();
                    clearInterval(loader.interval);
                    $(window).unbind('resize', loader._drawEvent);
                    $(window).unbind('scroll', loader._drawEvent);

                    loader.on = false;
                }
            }
        }
    });

})(jQuery);