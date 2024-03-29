/*globals jQuery,$*/
/*jslint white: false */
/*
 *
 * Wijmo Library 1.4.0
 * http://wijmo.com/
 *
 * Copyright(c) ComponentOne, LLC.  All rights reserved.
 * 
 * Dual licensed under the Wijmo Commercial or GNU GPL Version 3 licenses.
 * licensing@wijmo.com
 * http://wijmo.com/license
 *
 *
 * * Wijmo Pager widget.
 *
 * Depends:
 *  jquery-1.4.2.js
 *  jquery.ui.core.js
 *  jquery.ui.widget.js
 *
 */
(function ($) {
	"use strict";
	$.widget("wijmo.wijpager", {
		options: {
			/// <summary>
			/// The class of the first-page button.
			/// Default: ui-icon-seek-first.
			/// Type: String
			/// Code example: $("#element").wijpager( { firstButtonClass: "ui-icon-seek-first" } );
			/// </summary>
			firstPageClass: "ui-icon-seek-first",

			/// <summary>
			/// The text to display for the first-page button.
			/// Default: "First".
			/// Type: String
			/// Code example: $("#element").wijpager( { firstPageText: "First" } );
			/// </summary>
			firstPageText: "First",

			/// <summary>
			/// The class of the last-page button.
			/// Default: ui-icon-seek-end.
			/// Type: String
			/// Code example: $("#element").wijpager( { lastPageClass: "ui-icon-seek-end" } );
			/// </summary>
			lastPageClass: "ui-icon-seek-end",

			/// <summary>
			/// The text to display for the last-page button.
			/// Default: "Last".
			/// Type: String
			/// Code example: $("#element").wijpager( { lastPageText: "Last" } );
			/// </summary>
			lastPageText: "Last",

			/// <summary>
			/// Determines the pager mode. Possible values are: "nextPrevious", "nextPreviousFirstLast", "numeric", "numericFirstLast".
			/// 
			/// "nextPrevious" - a set of pagination controls consisting of Previous and Next buttons.
			/// "nextPreviousFirstLast" - a set of pagination controls consisting of Previous, Next, First, and Last buttons.
			/// "numeric" - a set of pagination controls consisting of numbered link buttons to access pages directly.
			/// "numericFirstLast" - a set of pagination controls consisting of numbered and First and Last link buttons.
			///
			/// Default: "numeric".
			/// Type: String
			/// Code example: $("#element").wijpager( { mode: "numeric" } );
			/// </summary>
			mode: "numeric",

			/// <summary>
			/// The class of the next-page button.
			/// Default: ui-icon-seek-next.
			/// Type: String
			/// Code example: $("#element").wijpager( { nextPageClass: "ui-icon-seek-next" } );
			/// </summary>
			nextPageClass: "ui-icon-seek-next",

			/// <summary>
			/// The text to display for the next-page button.
			/// Default: "Next".
			/// Type: String
			/// Code example: $("#element").wijpager( { nextPageText: "Next" } );
			/// </summary>
			nextPageText: "Next",

			/// <summary>
			/// The number of page buttons to display in the pager.
			/// Default: 10.
			/// Type: Number.
			/// Code example: $("#element").wijpager( { pageButtonCount: 10 } );
			/// </summary>
			pageButtonCount: 10,

			/// <summary>
			/// The class of the previous-page button.
			/// Default: ui-icon-seek-prev.
			/// Type: String
			/// Code example: $("#element").wijpager( { previousPageClass: "ui-icon-seek-prev" } );
			/// </summary>
			previousPageClass: "ui-icon-seek-prev",

			/// <summary>
			/// The text to display for the previous-page button.
			/// Default: "Previous".
			/// Type: String
			/// Code example: $("#element").wijpager( { previousPageText: "Previous" } );
			/// </summary>
			previousPageText: "Previous",

			/// <summary>
			/// Total number of pages.
			/// Default: 1.
			/// Type: Number.
			/// Code example: $("#element").wijpager( { pageCount: 1 } );
			/// </summary>
			pageCount: 1,

			/// <summary>
			/// The zero-based index of the current page.
			/// Default: 0.
			/// Type: Number.
			/// Code example: $("#element").wijpager( { pageIndex: 0 } );
			/// </summary>
			pageIndex: 0,

			/// <summary>
			/// pageIndexChanging event handler. A function called when page index is changing. Cancellable.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the pageIndexChanging event:
			/// $("#element").wijpager({ pageIndexChanging: function (e, args) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijpagerpageindexchanging", function (e, args) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data whith this event.
			/// args.newPageIndex - new page index.
			/// </param>
			pageIndexChanging: null,

			/// <summary>
			/// pageIndexChanged event handler. A function called when the page index is changed.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the pageIndexChanged event:
			/// $("#element").wijpager({ pageIndexChanged: function (e) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijpagerpageindexchanged", function (e) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			pageIndexChanged: null
		},

		_create: function () {
			this.element.addClass("ui-widget wijmo-wijpager ui-helper-clearfix");
			if (this.options.disabled) {
				this.disable();
			}
			this._refresh();
		},

		_init: function () {
		},

		destroy: function () {
			///	<summary>
			///	Destroy wijpager widget and reset the DOM element.
			///	</summary>
			this.element.removeClass("ui-widget wijmo-wijpager ui-helper-clearfix");
			this.$ul.remove();
			$.Widget.prototype.destroy.apply(this, arguments);
		},

		_setOption: function (key, value) {
			$.Widget.prototype._setOption.apply(this, arguments);
			this._refresh();
		},

		_refresh: function () {
			this._validate();

			if (this.$ul) {
				this.$ul.remove();
			}

			this.element.append(this.$ul = $("<ul class=\"ui-list ui-corner-all ui-widget-content ui-helper-clearfix\" role=\"tablist\"></ul>"));

			switch ((this.options.mode || "").toLowerCase()) {
				case "nextprevious":
					this._createNextPrev(false);
					break;

				case "nextpreviousfirstlast":
					this._createNextPrev(true);
					break;

				case "numeric":
					this._createNumeric(false);
					break;

				case "numericfirstlast":
					this._createNumeric(true);
					break;
			}
		},

		_validate: function () {
			if (isNaN(this.options.pageCount) || this.options.pageCount < 1) {
				this.options.pageCount = 1;
			}

			if (isNaN(this.options.pageIndex) || this.options.pageIndex < 0) {
				this.options.pageIndex = 0;
			} else if (this.options.pageIndex >= this.options.pageCount) {
				this.options.pageIndex = this.options.pageCount - 1;
			}

			if (isNaN(this.options.pageButtonCount) || this.options.pageButtonCount < 1) {
				this.options.pageButtonCount = 1;
			}
		},

		_createNextPrev: function (addFirstLast) {
			// first button
			if (addFirstLast && this.options.pageIndex) {
				this.$ul.append(this._createPagerItem(false, this.options.firstPageText)
									.append(this._createPagerControl(1, this.options.firstPageText,
										 this.options.firstPageClass))
								);
			}

			// previous button
			if (this.options.pageIndex) {
				this.$ul.append(this._createPagerItem(false, this.options.previousPageText)
									.append(this._createPagerControl(this.options.pageIndex,
										this.options.previousPageText, this.options.previousPageClass))
								);
			}

			// next button
			if (this.options.pageIndex + 1 < this.options.pageCount) {
				this.$ul.append(this._createPagerItem(false, this.options.nextPageText)
									.append(this._createPagerControl(this.options.pageIndex + 2,
										this.options.nextPageText, this.options.nextPageClass))
								);
			}

			// last button
			if (addFirstLast && (this.options.pageIndex + 1 < this.options.pageCount)) {
				this.$ul.append(this._createPagerItem(false, this.options.lastPageText)
									.append(this._createPagerControl(this.options.pageCount,
										this.options.lastPageText, this.options.lastPageClass))
								);
			}
		},

		_createNumeric: function (addFirstLast) {
			var currentPage = this.options.pageIndex + 1,
			startPageNumber = 1,
			endPageNumber = Math.min(this.options.pageCount, this.options.pageButtonCount),
			i;

			if (currentPage > endPageNumber) {
				startPageNumber = (Math.floor(this.options.pageIndex / this.options.pageButtonCount)) * this.options.pageButtonCount + 1;

				endPageNumber = startPageNumber + this.options.pageButtonCount - 1;
				endPageNumber = Math.min(endPageNumber, this.options.pageCount);

				if (endPageNumber - startPageNumber + 1 < this.options.pageButtonCount) {
					startPageNumber = Math.max(1, endPageNumber - this.options.pageButtonCount + 1);
				}
			}

			// first + "..." buttons
			if (startPageNumber !== 1) {
				// first button
				if (addFirstLast) {
					this.$ul.append(this._createPagerItem(false, this.options.firstPageText)
						.append(this._createPagerControl(1, this.options.firstPageText, this.options.firstPageClass))
					);
				}

				// "..." button
				this.$ul.append(this._createPagerItem(false, "...").append(this._createPagerControl(startPageNumber - 1, "...", "")));
			}

			// page numbers buttons
			for (i = startPageNumber; i <= endPageNumber; i++) {
				this.$ul.append(this._createPagerItem(i === currentPage, i.toString())
					.append(this._createPagerControl(i, i.toString(), "", i === currentPage)));
			}

			// "..." + last buttons
			if (this.options.pageCount > endPageNumber) {
				this.$ul.append(this._createPagerItem(false, "...").append(this._createPagerControl(endPageNumber + 1, "...", "")));

				// last button
				if (addFirstLast) {
					this.$ul.append(this._createPagerItem(false, this.options.lastPageText)
						.append(this._createPagerControl(this.options.pageCount, this.options.lastPageText, this.options.lastPageClass)));
				}
			}
		},

		_createPagerItem: function (active, title) {
			var $li = $("<li />")
				.addClass("ui-page ui-corner-all")
				.attr({ "role": "tab", "aria-label": title, "title": title });
			//                .css("textAlign", "left")

			if (active) {
				$li
					.addClass("ui-state-active")
					.attr("aria-selected", "true");
			} else {
				$li
				.addClass("ui-state-default")
				.hover(
					function () {
						$(this).removeClass("ui-state-default").addClass("ui-state-hover");
					},
					function () {
						$(this).removeClass("ui-state-hover").addClass("ui-state-default");
					}); //.unbind('mouseenter mouseleave');
			}

			return $li;
		},

		_createPagerControl: function (pageIndex, btnText, btnClass, disabled) {
			var ctrl = null;

			if (disabled) {
				ctrl = $("<span />");
			} else {
				if (btnClass) {
					ctrl = $("<span />").addClass("ui-icon " + btnClass);
				} else {
					ctrl = $("<a/>").attr("href", "#");
				}
			}

			ctrl.attr("title", btnText).text(btnText);

			if (!disabled) {
				ctrl.bind("click." + this.widgetName, { newPageIndex: pageIndex - 1 }, $.proxy(this._onClick, this)); // pageIndex is 1-based.
			}

			return ctrl;
		},

		_onClick: function (arg) {
			if (this.options.disabled) {
				return false;
			}

			var eventArg = { newPageIndex: arg.data.newPageIndex, handled: false };

			if (this._trigger("pageIndexChanging", null, eventArg) !== false) {
				if (this.options.pageIndex !== eventArg.newPageIndex) {
					this.options.pageIndex = eventArg.newPageIndex;
					if (!eventArg.handled) {
						this._refresh();
					}
					this._trigger("pageIndexChanged", null, { newPageIndex: eventArg.newPageIndex });
				}
			}

			return false;
		}
	});
})(jQuery);

/*
 *
 * Wijmo Library 1.4.0
 * http://wijmo.com/
 *
 * Copyright(c) ComponentOne, LLC.  All rights reserved.
 * 
 * Dual licensed under the Wijmo Commercial or GNU GPL Version 3 licenses.
 * licensing@wijmo.com
 * http://wijmo.com/license
 *
 *
 ** Wijmo Text Selection plugin.
*
*/


(function ($) {
"use strict";

$.fn.extend({
wijtextselection: function () {
	/// <summary>jQuery plugins to get/set text selection for input element</summary>
	var start,end,t=this[0];
	var val = this.val();
	if (arguments.length === 0){
		var range, stored_range, s, e;
		if($.browser.msie){
			var selection=document.selection;
			if (t.tagName.toLowerCase() != "textarea") {
				range = selection.createRange().duplicate();
				range.moveEnd("character", val.length);
				s = (range.text == "" ? val.length:val.lastIndexOf(range.text));
				range = selection.createRange().duplicate();
				range.moveStart("character", -val.length);
				e = range.text.length;
			} else {
				range = selection.createRange();
				stored_range = range.duplicate();
				stored_range.moveToElementText(t);
				stored_range.setEndPoint('EndToEnd', range);
				s = stored_range.text.length - range.text.length,
				e = s + range.text.length
			}
		} else {
			s=t.selectionStart;
			e=t.selectionEnd;
		}
		
		var te=val.substring(s,e);
		return {start:s,end:e,text:te,replace:function(st){
			return val.substring(0,s)+st+val.substring(e,val.length)
		}};
	}else if (arguments.length === 1){
		if (typeof arguments[0]==="object" && typeof arguments[0].start==="number" && typeof arguments[0].end==="number"){
			start=arguments[0].start;
			end=arguments[0].end;
		}else if (typeof arguments[0]==="string"){
			if((start=val.indexOf(arguments[0]))>-1){
				end=start+arguments[0].length;
			}
		}else if(Object.prototype.toString.call(arguments[0])==="[object RegExp]"){
			var re=arguments[0].exec(val);
			if(re != null) {
				start=re.index;
				end=start+re[0].length;
			}
		}
	}else if (arguments.length === 2){
		if (typeof arguments[0]==="number" && typeof arguments[1] === "number"){
			start = arguments[0];
			end = arguments[1];
		}
	}
	
	if(typeof start === "undefined"){
		start = 0;
		end = val.length;
	}
	
	if($.browser.msie){
		var selRange = t.createTextRange();
		selRange.collapse(true);
		selRange.moveStart('character', start);
		selRange.moveEnd('character', end-start);
		selRange.select();
	} else {
		t.selectionStart=start;
		t.selectionEnd=end;
	}
}
});
		
})(jQuery);

/*globals window jQuery */
/*
 *
 * Wijmo Library 1.4.0
 * http://wijmo.com/
 *
 * Copyright(c) ComponentOne, LLC.  All rights reserved.
 * 
 * Dual licensed under the Wijmo Commercial or GNU GPL Version 3 licenses.
 * licensing@wijmo.com
 * http://wijmo.com/license
 *
 *
 ** Wijmo Datasource widget.
*
* Depends:
*	jquery-1.4.2.js
*
*/
(function ($) {
	"use strict";
	/// <summary>
	/// wijdatasource reads local raw data or remote raw data through proxy by using
	/// a DataReader and provide tabular object data for widgets. 
	/// </summary>
	var wijdatasource, wijarrayreader, wijhttpproxy;
	wijdatasource = function (options) {
		var self = this;
		/// <summary>
		/// The data to process using the wijdatasource class.
		/// Default: {}.
		/// Type: Object. 
		/// </summary>
		self.data = {};
		/// <summary>
		/// The reader to use with wijdatasource. The wijdatasource class will call the
		/// read method of reader to read from rawdata with an array of fields provided.
		/// The field contains a name, mapping and defaultValue properties which define
		/// the rule of the mapping.
		/// If no reader is configured with wijdatasource it will directly return the
		/// raw data.
		/// Default: null.
		/// Type: Object. 
		/// </summary>
		self.reader = null;
		/// <summary>
		/// The proxy to use with wijdatasource. The wijdatasource class will call
		/// the proxy object's request method.  
		/// In the proxy object, you can send a request to a remote server to
		/// obtain data with the ajaxs options object provided.
		/// Then you can use the wijdatasource reader to process the raw data in the call.
		/// Default: null.
		/// Type: Object. 
		/// </summary>
		self.proxy = null;
		/// <summary>
		/// The processed items from the raw data.  This can be obtained after
		/// datasource is loaded.
		/// Default: [].
		/// Type: Array. 
		/// </summary>
		self.items = [];
		/// <summary>
		/// Function called before loading process starts
		/// Default: null.
		/// Type: Function. 
		/// Code example:
		/// var datasource = new wijdatasource({loading: function(e, data) { }})
		/// </summary>
		/// <param name="datasource" type="wijdatasource">
		/// wijdatasource object that raises this event.
		/// </param>
		/// <param name="data" type="Object">
		/// data passed in by load method.
		/// </param>
		self.loading = null;
		/// <summary>
		/// Function called after loading.
		/// Default: null.
		/// Type: Function. 
		/// Code example:
		/// var datasource = new wijdatasource({loaded: function(e, data) { }})
		/// </summary>
		/// <param name="datasource" type="wijdatasource">
		/// wijdatasource object that raises this event.
		/// </param>
		/// <param name="data" type="Object">
		/// data passed in by load method.
		/// </param>
		self.loaded = null;

		self._constructor(options);
	};
	window.wijdatasource = wijdatasource;

	$.extend(wijdatasource.prototype, {
		_constructor: function (options) {
			$.extend(this, options);
		},

		load: function (data, forceLocalReload) {
			/// <summary>
			/// Triggers data loading process of wijdatasource.
			/// </summary>
			/// <param name="data" type="Object">
			/// The data to pass to the loading and loaded event handler.
			/// </param>
			/// <param name="forceLocalReload" type="Boolean">
			/// Normally local data is only load for one time,
			/// if needs to reload the data, try to set forceLocalReload to true.
			/// </param>

			var self = this,
			p = self.proxy;
			//var d = self.data;
			// fire loading event.
			if ($.isFunction(self.loading)) {
				self.loading(self, data);
			}
			// if datasource has an proxy object, it will use the request method of
			// proxy to retrive the raw data.
			if (p) {
				// pass callback function to request method so that proxy could
				// call the function when request is finished.
				p.request(self, self.loaded, data);
			}
			else {
				// local data is loaded only once, if force loading is needed
				// forceLocalReload should be true.
				if (self.items.length === 0 || forceLocalReload) {
					// no proxy, read raw data
					this.read();
				}
				// callback function is called
				if ($.isFunction(self.loaded)) {
					self.loaded(self, data);
				}
			}
		},

		read: function () {
			/// <summary>
			/// Triggers data reading process of wijdatasource
			/// by using a DataReader if presented.
			/// </summary>

			var self = this,
			d = self.data;
			// reads using a reader object
			if (d  && self.reader) {
				self.reader.read(self);
			}
			else {
				// returns raw data if no reader is configured with datasource.
				self.items = self.data;
				//removed by Jeffrey for removing unnecessary return
				//return self.data;
				//end by Jeffrey
			}
		}
	});

	/// <summary>
	/// wijdatasource ArrayReader reads from a array and processes items.
	/// </summary>
	wijarrayreader = function (fields) {
		// this.fields to store the fields info
		if ($.isArray(fields)) {
			this.fields = fields;
		}
	};
	window.wijarrayreader = wijarrayreader;

	$.extend(wijarrayreader.prototype, {
		read: function (datasource) {
			/// <summary>
			/// Starts reading data.
			/// </summary>
			/// <param name="datasource" type="wijdatasource">
			/// The wijdatasource using this DataReader.
			/// </param>

			// convert the raw data of wijdatasource
			if ($.isArray(datasource.data)) {
				datasource.items = this._map(datasource.data);
			}
			else {
				datasource.items = [];
			}
		},

		_map: function (data) {
			var self = this, arr = [];
			if (self.fields === undefined || self.fields.length === 0) {
				$.extend(true, arr, data);
				return arr;
			}
			else {
				$.each(data, function (index, value) {
					var i = {};
					$.each(self.fields, function (index, field) {
						// mapping property is a function,
						// the return value will be used as value.
						if ($.isFunction(field.mapping)) {
							i[field.name] = field.mapping(value);
							return true;
						}
						// use string field mapping or number index mapping.
						var mapping = field.mapping !== undefined ? 
											field.mapping : field.name,
						v = value[mapping];
						if (v === undefined) {
							if (field.defaultValue !== undefined) {
								v = field.defaultValue;
							}
							else {
								v = value;
							}
						}
						i[field.name] = v;
					});
					arr.push(i);
				});
			}
			return arr;
		}
	});

	/// <summary>
	/// wijdatasource HttpProxy fetches data by using Ajax request.
	/// </summary>
	wijhttpproxy = function (options) {
		this.options = options;
	};
	window.wijhttpproxy = wijhttpproxy;

	$.extend(wijhttpproxy.prototype, {
		request: function (datasource, callBack, userData) {
			/// <summary>
			/// Starts requesting data.
			/// </summary>
			/// <param name="datasource" type="wijdatasource">
			/// The wijdatasource using this DataReader.
			/// </param>
			/// <param name="callback" type="Function">
			/// The function to call after requesting data successfully.
			/// </param>

			var self = this,
			o = $.extend({}, this.options),
			oldSuccess = o.success;

			o.success = function (data) {
				if ($.isFunction(oldSuccess)) {
					oldSuccess(data);
				}
				self._complete(data, datasource, callBack, o, userData);
			};
			$.ajax(o);
		},

		_complete: function (data, datasource, callback, options, userData) {
			// set raw data
			datasource.data = options.key !== undefined ? data[options.key] : data;
			// read raw data using a data reader in datasource
			datasource.read();
			// fire loaded callback
			if ($.isFunction(callback)) {
				callback(datasource, userData);
			}
		}
	});
} (jQuery));

/*globals jQuery,window,document*/
/*
 *
 * Wijmo Library 1.4.0
 * http://wijmo.com/
 *
 * Copyright(c) ComponentOne, LLC.  All rights reserved.
 * 
 * Dual licensed under the Wijmo Commercial or GNU GPL Version 3 licenses.
 * licensing@wijmo.com
 * http://wijmo.com/license
 *
 *
 * * Wijmo Combobox widget.
 *
 * Depends:
 *	jquery.ui.core.js
 *	jquery.ui.widget.js
 *	jquery.ui.position.js
 *	jquery.ui.wijlist.js
 *
 */
(function ($) {
	"use strict";
	var inputCSS = "wijmo-wijcombobox-input",
		stateHover = "ui-state-hover",
		stateActive = "ui-state-active",
		stateFocus = "ui-state-focus",
		conerLeft = "ui-corner-left",
		conerRight = "ui-corner-right",
		triggerHTML = "<div class='wijmo-wijcombobox-trigger ui-state-default " +
							"ui-corner-right'>" +
							"<span class='ui-icon ui-icon-triangle-1-s'></span>" +
						"</div>",
		labelHTML = "<label class='wijmo-wijcombobox-label ui-widget-content'></label>";

	$.widget("wijmo.wijcombobox", {
		options: {
			/// <summary>
			/// A value that specifies the underlying data source provider of wijcombobox.
			/// Default: null.
			/// Type: wijdatasource/Array
			/// </summary>
			/// <remarks>
			/// This option could either be a wijdatasource object 
			/// or an Object Array containing an item such as 
			/// {label: "label text", value: "value"}.
			/// </remarks>
			data: null,
			/// <summary>
			/// A value that specifies the text in the wijcombobox label.
			/// Default: null.
			/// Type: String.
			/// </summary>
			labelText: null,
			/// <summary>
			/// A value that determines the minimum length of text 
			/// that can be entered in the wijcombobox text box to issue an AJAX request.
			/// Default: 4.
			/// Type: Number.
			/// </summary>
			minLength: 4,
			/// <summary>
			/// A value that determines the duration (in milliseconds) of the time 
			/// to delay before autocomplete begins after typing stops.
			/// Default: 300.
			/// Type: Number.
			/// </summary>
			delay: 300,
			/// <summary>
			/// A value that specifies the animation options for a drop-down list
			/// when it is visible.
			/// Default: null.
			/// Type: Object.
			/// </summary>
			showingAnimation: null,
			/// <summary>
			/// A value specifies the animation options for the drop-down list
			/// when it is hidden.
			/// Default: null.
			/// Type: Object.
			/// </summary>
			hidingAnimation: null,
			/// <summary>
			/// A value that determines whether to show the trigger of wijcombobox.
			/// Default: true.
			/// Type: Boolean.
			/// </summary>
			showTrigger: true,
			/// <summary>
			/// A value that specifies the position of the drop-down list trigger.
			/// Default: "right".
			/// Type: String.
			/// </summary>
			triggerPosition: "right",
			/// <summary>
			/// A value that specifies the height of the drop-down list.
			/// Default: 300.
			/// Type: Number.
			/// </summary>
			/// <remarks>
			/// If the total height of all items is less than the value of this option,
			/// it will use the total height of items as the height of the drop-down list.
			/// </remarks>
			dropdownHeight: 300,
			/// <summary>
			/// A value that specifies the width of the drop-down list.
			/// Default: "auto".
			/// Type: Number/String("auto").
			/// </summary>
			/// <remarks>
			/// When this option is set to "auto", the width of the drop-down
			/// list is equal to the width of wijcombobox.
			/// </remarks>
			dropdownWidth: "auto",
			/// <summary>
			/// A value that determines whether to select the item 
			/// when the item gains focus or is activated.
			/// Default: false.
			/// Type: Boolean.
			/// </summary>
			selectOnItemFocus: false,
			/// <summary>
			/// A value determines whether to shorten the drop-down list items 
			/// by matching the text in the textbox after typing.
			/// Default: true.
			/// Type: Boolean.
			/// </summary>
			autoFilter: true,
			/// <summary>
			/// A value that determines whether to start the auto-complete 
			/// function after typing in the text if a match exists.
			/// Default: true.
			/// Type: Boolean.
			/// </summary>
			autoComplete: true,
			/// <summary>
			/// A value that determines whether to highlight the keywords in an item. 
			/// If "abc" is typed in the textbox, 
			/// all "abc" matches are highlighted in the drop-down list.
			/// Default: true.
			/// Type: Boolean.
			/// </summary>
			highlightMatching: true,
			/// <summary>
			/// A value that specifies the position options of the drop-down list.
			/// The default value of the "of" options is the input of wijcombobox.
			/// Default: {}.
			/// Type: Object.
			/// </summary>
			dropDownListPosition: {},
			/// <summary>
			/// An array that specifies the column collections of wijcombobox.
			/// Example: columns: [{name: "header1", width: 150},
			///                    {name: "header2", width: 150},
			///                    {name: "header3", width: 150}]
			/// Default: [].
			/// Type: Array.
			/// </summary>
			columns: [],
			/// <summary>
			/// A value that specifies the selection mode of wijcombobox.
			/// Default: "Single".
			/// Type: String.
			/// <remarks>
			/// Possible options are: "single" and "multiple".
			/// </remars>
			/// </summary>
			selectionMode: "single",
			/// <summary>
			/// A value that specifies the separator for 
			/// the multiple selected items text in the textbox.
			/// Default: ",".
			/// Type: String.
			/// </summary>
			multipleSelectionSeparator: ",",
			/// <summary>
			/// A value that determines whether to check the input text against 
			/// the text of the selected item when the focus blurs. 
			/// Default: false.
			/// Type: Boolean.
			/// </summary>
			/// <remarks>
			/// If the text does not match any item, input text will restore 
			/// to text the selected item or empty if no item is selected.  
			/// </remarks>
			forceSelectionText: false,
			/// <summary>
			/// A function called when any item in list is selected.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#combobox").wijbarchart({select: function(e, data) { } });
			/// Bind to the event by type: wijcomboxselect
			/// $("#combobox").bind("wijcomboxselect", function(e, data) {} );
			/// </summary>
			/// <param name="e" type="EventObj">
			/// EventObj that relates to this event.
			/// </param>
			/// <param name="item" type="Object">
			/// item to be rendered.
			/// item.element: LI element with this item.
			/// item.list: wijlist instance.
			/// item.label: label of item.
			/// item.value: value of item.
			/// item.text: could be set in handler to override rendered label of item.
			/// </param>
			select: null,
			/// <summary>
			/// A value that determines whether input is editable.
			/// Default: true.
			/// Type: Boolean.
			/// </summary>
			isEditable: true,
			/// <summary>
			/// A value that specifies the index of the item to select 
			/// when using single mode.
			/// If the selectionMode is "multiple", then this option could be set 
			/// to an array of Number which contains the indices of the items to select.
			/// Default: -1.
			/// Type: Number/Array.
			/// </summary>
			/// <remarks>
			/// If no item is selected, it will return -1.
			/// </remarks>
			selectedIndex: -1,
			/// <summary>
			/// A function called when drop-donw list is opened.
			/// Default: null.
			/// Type: Function.
			/// </summary>
			/// <param name="e" type="EventObj">
			/// The jquery event object.
			/// </param>
			open: null,
			/// <summary>
			/// A function called when drop-donw list is closed.
			/// Default: null.
			/// Type: Function.
			/// </summary>
			/// <param name="e" type="EventObj">
			/// The jquery event object.
			/// </param>
			close: null,
			/// <summary>
			/// A value added to the width of the target select element 
			/// to account for the scroll bar width of superpanel.
			/// Default: 6.
			/// Type: Number.
			/// <remarks>
			/// Unit for this value is pixel.
			/// Because the width of the scroll bar may be different between browsers 
			/// if wijcombobox is initialized with the width of the HTML select element, 
			/// the text may be hidden by the scroll bar of wijcombobox. 
			/// </remarks>
			/// </summary>
			selectElementWidthFix: 6,
			/// <summary>
			/// A function called before searching the list.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#combobox").wijbarchart({search: function(e, data) { } });
			/// Bind to the event by type: wijcomboxsearch
			/// $("#combobox").bind("wijcomboxsearch", function(e, data) {} );
			/// </summary>
			/// <param name="e" type="EventObj">
			/// The jquery event object.
			/// </param>
			/// <param name="data" type="Object">
			/// data.datasrc: The datasource of wijcombobox.
			/// data.term: The text to search.
			/// </param>
			search: null,
			/// <summary>
			/// A function called when select item is changed.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#combobox").wijbarchart({changed: function(e, data) { } });
			/// Bind to the event by type: wijcomboxchanged
			/// $("#combobox").bind("wijcomboxchanged", function(e, data) {} );
			/// </summary>
			/// <param name="e" type="EventObj">
			/// The jquery event object.
			/// </param>
			/// <param name="data" type="Object">
			/// data.oldItem: The old item.
			/// data.newItem: The new item.
			/// data.oldIndex: The old index of selected item.
			/// data.newIndex: The new index of selected item.
			/// </param>
			changed: null,
			/// <summary>
			/// The object contains the options of wijlist.
			/// Default: null.
			/// Type: Object.
			/// </summary>
			listOptions: null
		},

		_create: function () {
			var t = this;
			// inits selected items
			t.selectedItem = null;
			t.selectedItems = [];

			// inits wijcombobox
			t._createDOMElements();
			t._bindInputEvents();
			t._initDropDownList();
			t.repaint();
			t._checkSelectIndex();
		},

		_checkSelectIndex: function () {
			var self = this, index;

			index = self.options.selectedIndex;
			if (!self._usingRemoteData() && (index >= 0 || $.isArray(index))) {
				self.search(null, "checkindex");
			}
		},

		repaint: function () {
			/// <summary>
			/// Repaints wijcombobox. Returns true if it succeeds; 
			/// otherwise, returns false.
			/// </summary>
			/// <returns type="Boolean">
			/// Returns true if it succeeds; otherwise, returns false.
			/// </returns>

			var self = this;
			if (self.element.is(":visible") ||
			(self._select !== undefined && self._input.is(":visible"))) {
				self._showTrigger();
				if (self.options.disabled) {
					self.disable();
				}
				return true;
			}
			return false;
		},

		_bindInputEvents: function () {
			var self = this, input, o, code, keyCode;

			input = self._input;
			o = self.options;
			// self.element is an html input element.
			input.bind("keydown.wijcombobox", function (event) {
				if (o.disabled === true) {
					return;
				}
				code = event.keyCode;
				keyCode = $.ui.keyCode;
				switch (code) {
					case keyCode.UP:
						self._move("previous", event);
						// prevent moving cursor to beginning of text field in some browsers
						event.preventDefault();
						break;
					case keyCode.DOWN:
						self._move("next", event);
						// prevent moving cursor to end of text field in some browsers
						event.preventDefault();
						break;
					case keyCode.ENTER:
						// when menu is open or has focus
						if (self.menu.active) {
							event.preventDefault();
							self.menu.select(event);
						}
						break;
					//passthrough - ENTER and TAB both select the current element                    
					case keyCode.TAB:
						input.trigger("wijcomboblur");
						if (!self.menu.active ||
					(o.selectionMode === "multiple" && keyCode.TAB === code)) {
							return;
						}
						self.menu.select(event);
						// remove selection from input.
						var end = input.val().length;
						self._selectText(end, end, input);

						break;
					case keyCode.ESCAPE:
						self.close(event);
						break;
					case keyCode.LEFT:
					case keyCode.RIGHT:
					case keyCode.SHIFT:
					case keyCode.CONTROL:
					case keyCode.HOME:
					case keyCode.END:
					case keyCode.DELETE:
					case keyCode.PAGE_UP:
					case keyCode.PAGE_DOWN:
						// ignore metakeys (shift, ctrl, alt)
						break;
					case 18: //alt key
						input.trigger("wijcomboblur");
						break;
					default:
						// keypress is triggered before the input value is changed
						window.clearTimeout(self.searching);
						if (o.isEditable === false) {
							if (self._cacheKey === undefined) {
								self._cacheKey = "";
							}
							self._cacheKey += String.fromCharCode(code);
						}
						self.searching = window.setTimeout(function () {
							var term;
							if (o.isEditable === false) {
								term = self._cacheKey;
								self._cacheKey = undefined;
							}
							else {
								term = input.val();
							}
							self.search(term, event);
						}, o.delay);
						break;
				}
			}).bind("wijcomboblur.wijcombobox", function (event) {
				window.clearTimeout(self.searching);
				self._addInputFocus(false, stateFocus);
				// TODO try to implement this without a timeout, 
				// see clearTimeout in search()
				self.closing = window.setTimeout(function () {
					self.close(event, true);
				}, 150);

			}).bind("focus.wijcombobox", function () {
				self._addInputFocus(true, stateFocus);
			}).bind("blur.wijcombobox", function () {
				if (!self.menu.element.is(":visible")) {
					input.trigger("wijcomboblur");
				}
				self._change();
			});
		},

		_addInputFocus: function (add, css) {
			var self = this, wrap, key, arrow;

			wrap = self._input.parent();
			key = add ? "addClass" : "removeClass";
			arrow = self._triggerArrow;
			wrap[key](css);
			if (arrow !== undefined) {
				arrow[key](css);
			}
		},

		_renderColumnsHeader: function (header) {
			var ul = $("<ul class='wijmo-wijcombobox-rowheader'></ul>");
			$.each(this.options.columns, function (index, column) {
				var li = $("<li class='wijmo-wijcombobox-cell ui-widget-header'></li>");
				li.html(column.name);
				if (column.width !== undefined) {
					li.width(column.width);
				}
				li.appendTo(ul);
			});
			header.append(ul);
		},

		_hasSameValueText: function (item1, item2) {
			return item1.label === item2.label && item1.value === item2.value;
		},

		_initDropDownList: function () {
			var self = this, doc, menuElement, o, header, listOptions;

			doc = self.element[0].ownerDocument;
			menuElement = $("<div class='wijmo-wijcombobox-list'></div>");
			o = self.options;
			if (o.columns.length > 0) {
				menuElement.addClass("wijmo-wijcombobox-multicolumn");
				header = $("<div class='wijmo-wijsuperpanel-header " +
				"ui-state-default'></div>");
				self._renderColumnsHeader(header);
				menuElement.append(header);
			}

			listOptions = {
				keepHightlightOnMouseLeave: true,
				selectionMode: o.selectionMode,
				addHoverItemClass: o.columns.length === 0,
				focus: function (e, item) {
					var i = item;
					if (o.selectOnItemFocus) {
						self.menu.select(null, {
							notCloseAfterSelected: true
						});
					}
					if (o.columns.length > 0) {
						i.element.prev().addClass("wijmo-wijcombobox-active-prev");
						i.element.find(".wijmo-wijcombobox-row>.wijmo-wijcombobox-cell")
						.addClass("ui-state-hover");
					}
				},
				selected: function (event, ui) {
					window.clearTimeout(self.closing);
					var mode = o.selectionMode, item, newIndex, oldIndex, oldItem;

					item = ui.item;
					if (self._trigger("select", event, item)) {
						if (mode === "single") { // single mode selection
							// local data select
							if (!self._usingRemoteData()) {
								newIndex = $.inArray(item, self.items);
								if (newIndex !== o.selectedIndex) {
									self._input.val(item.label);
									oldItem = self.selectedItem;
									if (oldItem !== null) {
										oldItem.selected = false;
									}
									self.selectedItem = item;
									oldIndex = o.selectedIndex;
									o.selectedIndex = newIndex;
									// fire select change event 
									if (self._select !== undefined) {
										self._select[0].selectedIndex = o.selectedIndex;
										self._select.trigger("change");
									}
									self._trigger("changed", null, {
										oldItem: oldItem,
										selectedItem: self.selectedItem,
										newIndex: o.selectedIndex,
										oldIndex: oldIndex
									});
								}
							}
							else {
								// If items have the same text and value, 
								// they are considered to be same in remote mode.
								if (self.selectedItem === null ||
								!self._hasSameValueText(item, self.selectedItem)) {
									self._input.val(item.label);
									self.selectedItem = item;
									self._trigger("changed", null, {
										selectedItem: item
									});
								}
							}
						}
						else { // multiple selection mode
							if (!self._usingRemoteData()) {

								self.selectedItems = ui.selectedItems;
								self._selectedItemsToInputVal(self.selectedItems);
								self._trigger("changed", null, {
									selectedItem: item,
									selectedItems: self.selectedItems
								});
								///TODO: show helper list
							}
						}
					}
					if ((ui.data === undefined || !ui.data.notCloseAfterSelected) &&
					mode === "single") {
						self.close(event);
						self._input.focus();
					}
				},
				blur: function (e, item) {
					var d = item.element;
					if (o.columns.length > 0) {
						d.find(".wijmo-wijcombobox-row>.wijmo-wijcombobox-cell")
						.removeClass("ui-state-hover");
						d.prev().removeClass("wijmo-wijcombobox-active-prev");
					}
				},
				itemRendering: function (event, data) {
					var item = data, css;
					css = "";
					if (item.isSeparator) {
						css += " wijmo-wijcombobox-separator";
					}
					if (item.selected) {
						css += " wijmo-wijcombobox-selecteditem";
					}
					if (css.length > 0) {
						item.element.addClass(css);
					}
					if (self._keypress && o.isEditable &&
					o.columns.length === 0 && o.highlightMatching &&
					$.trim(self._input.val()).length > 0) {
						item.text = item.label.replace(
						new RegExp("(?![^&;]+;)(?!<[^<>]*)(" +
						self._escapeRegex(self._input.val()) +
						")(?![^<>]*>)(?![^&;]+;)", "gi"),
						"<span class='ui-priority-primary'>$1</span>");
					}
					else {
						item.text = undefined;
					}
				},
				itemRendered: function (event, data) {
					var item = data, li, u;
					if (item.cells === undefined) {
						return;
					}
					li = item.element;
					li.empty();
					u = $("<ul class='wijmo-wijcombobox-row'></ul>");
					$.each(item.cells, function (index, cell) {
						var l = $("<li class='wijmo-wijcombobox-cell " +
						"ui-state-default'></li>");
						l.append(cell);
						l.attr("title", cell);
						u.append(l);
					});
					li.append(u);
				},
				superPanelOptions: {
					resized: function (e) {
						var m = self.menu, ele = m.element;
						o.dropdownWidth = ele.outerWidth();
						o.dropdownHeight = ele.outerHeight();
						self._positionList();
						self.menu.refreshSuperPanel();
					}
				}
			};
			listOptions = $.extend(true, listOptions, o.listOptions);
			self.menu = menuElement.appendTo("body", doc)
						.wijlist(listOptions)
						.zIndex(self._input.zIndex() + 1).css({
							top: 0,
							left: 0
						}).hide().data("wijlist");
			self._menuUL = self.menu.ul;
		},

		_selectedItemsToInputVal: function (items) {
			var s = "", self, sep;

			self = this;
			sep = self.options.multipleSelectionSeparator;
			self.selectedItems = items;

			$.each(items, function (index, item) {
				s += item.label + sep;
			});
			if (s.length > 0) {
				s = s.substr(0, s.lastIndexOf(sep));
			}
			self._input.val(s);
		},

		_createDOMElements: function () {
			var self = this, comboElement, ele, input;
			comboElement =
				$("<div role='combobox' class='wijmo-wijcombobox " +
					"ui-widget ui-helper-clearfix'>" +
					"<div class='wijmo-wijcombobox-wrapper " +
					"ui-state-default ui-corner-all'>" +
					"</div>" +
				"</div>");
			// check if element is  a select element
			ele = self.element;
			self._comboElement = comboElement;
			// create from a select element
			if (ele[0].tagName.toLowerCase() === "select") {
				self._select = ele;
				// add class to set font size to get the correct width of select.
				ele.addClass("ui-widget");
				input = self._input = $("<input role='textbox' " +
				"aria-autocomplete='list' aria-haspopup='true' />")
				.insertAfter(ele);
				self.options.data = self._convertSelectOptions();
			}
			else {
				input = self._input = ele;
			}
			comboElement.insertBefore(input);
			comboElement.children(".wijmo-wijcombobox-wrapper").append(input);
			input.attr({
				autocomplete: "off",
				role: "textbox",
				"aria-wijcombobox": "list",
				"aria-haspopup": "true"
			}).addClass(inputCSS);
			self._oldWidth = ele.css("width");
			if (self.options.isEditable === false) {
				input.attr("readonly", "readonly");
			}
			comboElement.bind("mouseenter", function () {
				self._addInputFocus(true, stateHover);
			}).bind("mouseleave", function () {
				self._addInputFocus(false, stateHover);
			});
		},

		_convertSelectOptions: function () {
			var items = [], self, selectOptions;

			self = this;
			selectOptions = self._select.get(0).options;
			$.each(selectOptions, function (idx, opt) {
				items.push({ label: opt.text, value: opt.value });
			});
			self.options.selectedIndex = self._select[0].selectedIndex;
			return items;
		},

		getComboElement: function () {
			return this._comboElement;
		},

		_showTrigger: function () {
			var self = this, o, input, inputWrapper, comboElement,
			selectClone, selectWidth = 0,
			trigger, label, sp, padding, labelPadding, triggerPadding;

			o = self.options;
			input = self._input;
			inputWrapper = input.parent();
			comboElement = self._comboElement;
			trigger = self._triggerArrow;
			label = self._label;

			// set size
			if (self._select !== undefined) {
				//update for fixing bug 15920 by wuhao
				if (!$.browser.msie) {
					selectWidth = self._select.width();
				} else {
					selectClone = self._select.clone();
					self._select.after(selectClone);
					selectWidth = selectClone.width();
					selectClone.remove();
				}
				input.width(selectWidth +
				(o.data.length > 20 ? o.selectElementWidthFix : 0));
				//				input.width(self._select.width() +
				//				(o.data.length > 20 ? o.selectElementWidthFix : 0));
				//end for bug 15920.
				self._select.hide();
			}

			//update for fixing bug 15920 by wuhao
			input.css("margin-left", "");
			input.css("margin-right", "");
			//end for bug 15920.

			comboElement.width(inputWrapper[0].offsetWidth);
			//comboElement.height(inputWrapper[0].offsetHeight);

			// show label
			if (o.labelText !== null) {
				label = self._label = $(labelHTML);
				inputWrapper.append(label.html(o.labelText));
			}
			else {
				if (label !== undefined) {
					label.remove();
					self._label = undefined;
				}
			}

			if (o.showTrigger) {
				input.removeClass("ui-corner-all");
				if (trigger === undefined) {
					trigger = self._triggerArrow = $(triggerHTML);
					comboElement.append(trigger);
					trigger.bind("mouseover.triggerevent", self, function (e) {
						if (o.disabled === true) {
							return;
						}
						var ct = $(e.currentTarget);
						ct.addClass(stateHover);
					}).bind("mousedown.triggerevent", self, function (e) {
						if (o.disabled === true) {
							return;
						}
						var ct = $(e.currentTarget);
						ct.addClass(stateActive);
					}).bind("mouseup.triggerevent", self, function (e) {
						var ct = $(e.currentTarget);
						ct.removeClass(stateActive);
					}).bind("click.triggerevent", self, function () {
						if (o.disabled === true) {
							return;
						}
						self._triggerClick();
					});
				}
				if (o.triggerPosition === "right") {
					trigger.css({ left: "", right: "0px" });
					trigger.removeClass(conerLeft);
					trigger.addClass(conerRight);
				}
				else {
					trigger.css({ "right": "", "left": "0px" });
					trigger.removeClass(conerRight);
					trigger.addClass(conerLeft);
				}
				trigger.setOutHeight(comboElement.innerHeight());
				sp = trigger.find("span");
				sp.css("margin-left", (trigger.innerWidth() - sp[0].offsetWidth) / 2);
				sp.css("margin-top", (trigger.innerHeight() - sp[0].offsetHeight) / 2);
			}
			else {
				if (trigger !== undefined) {
					trigger.unbind(".triggerevent");
					trigger.remove();
					self._triggerArrow = undefined;
				}
				input.removeClass("ui-corner-left");
				input.removeClass("ui-corner-right");
				input.addClass("ui-corner-all");
			}

			// padding
			padding = labelPadding = triggerPadding = 0;
			if (label !== undefined) {
				labelPadding += label[0].offsetWidth;
			}
			if (trigger !== undefined) {
				triggerPadding = trigger[0].offsetWidth;
			}
			padding = labelPadding + triggerPadding;
			input.setOutWidth(inputWrapper.innerWidth() - padding);
			padding = padding === 0 ? "" : padding;
			if (o.triggerPosition === "right") {
				input.css("margin-left", "");
				input.css("margin-right", padding);
				if (label !== undefined) {
					label.css("left", "");
					label.css("right", triggerPadding);
				}
			}
			else {
				input.css("margin-right", "");
				input.css("margin-left", padding);

				if (label !== undefined) {
					label.css("right", "");
					label.css("left", triggerPadding);
				}
			}
		},

		_triggerClick: function (e) {
			var self = this, term = "";
			window.clearTimeout(self.closing);
			if (self.menu.element.is(":visible")) {
				self.close();
			}
			else {
				// TODO: click open should not render again.
				if (self._usingRemoteData()) {
					term = self._input.val();
				}
				self.search(term, e);
			}
		},

		destroy: function () {
			/// <summary>
			/// Destroys the wijcombobox.
			/// </summary>

			var self = this,
			ele = self.element;
			if (self.options.isEditable === false) {
				ele.removeAttr("readonly");
			}
			if (self._select !== undefined) {
				self._select.removeClass("ui-widget");
				self._select.show();
				self._input.remove();
			}
			else {
				ele.css("width", self._oldWidth);
				ele.removeClass(inputCSS);
				ele.removeAttr("autocomplete").removeAttr("role")
				.removeAttr("aria-wijcombobox").removeAttr("aria-haspopup");
				ele.insertBefore(self._comboElement);
				ele.css("padding", "");
			}
			self._comboElement.remove();
			self.menu.destroy();
			self.menu.element.remove();
			$.Widget.prototype.destroy.call(self);
		},

		_setOption: function (key, value) {
			var self = this, ele, input;
			ele = self._comboElement;
			input = self.element;
			$.Widget.prototype._setOption.apply(self, arguments);
			if (key === "disabled") {
				if (value) {
					ele.addClass("wijmo-wijcombobox-disabled ui-state-disabled");
					input.attr("disabled", "disabled");
					self.close();
				}
				else {
					ele.removeClass("wijmo-wijcombobox-disabled ui-state-disabled");
					input.removeAttr("disabled");
				}
			}
			else if (key === "isEditable") {
				if (value) {
					input.attr("readonly", "readonly");
				}
				else {
					input.removeAttr("readonly");
				}
			}
			//Add comments by RyanWu@20110119.
			//For fixing the issue that first open the dropdown list and choose one item,
			//then set the new data to the combo and click the dropdown list, 
			//an exception will be thrown.
			else if (key === "data") {
				self.selectedItem = null;
				self.options.selectedIndex = -1;
				self._input.val("");
			}
			//end by RyanWu@20110119.
			else if (key === "selectedIndex") {
				if (value > -1) {
					if (self.selectedItem !== null) {
						self.selectedItem.selected = false;
					}
					if (self.items[value] !== null) {
						self.selectedItem = self.items[value];
						self.selectedItem.selected = true;
						self._input.val(self.selectedItem.label);
					}
				}
			}
		},

		search: function (value, eventObj) {
			/// <summary>
			/// Searches the wijcombobox drop-down list for the given value. 
			/// </summary>
			/// <param name="value" type="String">
			/// Text to search in the drop-down list
			/// </param>

			var self = this, o, datasource, d;

			o = self.options;
			datasource = o.data;
			window.clearTimeout(self.closing);
			d = {
				value: value,
				e: eventObj,
				self: self
			};

			// load data when data is not loaded yet 
			// or datasource is using a proxy to obtain data.
			if (datasource !== null) {
				// check index will skip search event
				if (eventObj !== "checkindex") {
					if (self._trigger("search", eventObj,
					{ datasrc: datasource, term: d }) === false) {
						return;
					}
				}

				if ($.isArray(datasource)) {
					self._hideShowArrow(false);
					self._onListLoaded(datasource, d);
				}
				else {
					if (self._usingRemoteData() &&
					eventObj !== undefined && value.length < o.minLength) {
						return;
					}
					self._hideShowArrow(false);
					datasource.loaded = self._onListLoaded;
					datasource.load(d);
				}
			}
		},

		_usingRemoteData: function () {
			var o = this.options.data, r = false;
			if (!$.isArray(o) && o !== null && o.proxy !== null) {
				r = true;
			}
			return r;
		},

		_hideShowArrow: function (show) {
			// hide arrow to show
			var self = this, input, arrow;

			input = self.element;
			arrow = self._triggerArrow;
			if (arrow !== undefined) {
				arrow[show ? "show" : "hide"]();
			}
			input[show ? "removeClass" : "addClass"]("wijmo-wijcombobox-loading");
		},

		_onListLoaded: function (datasource, data) {
			var self = data.self, ele, o, searchTerm, items, idx, itemsToRender;

			ele = self._input;
			o = self.options;
			searchTerm = data.value;
			items = $.isArray(datasource) ? datasource : datasource.items;
			self.items = items;
			if (data.e === "checkindex") {
				idx = o.selectedIndex;
				if (o.selectionMode === "multiple" && $.isArray(idx)) {
					$.each(idx, function (i, n) {
						var itm = items[n];
						itm.selected = true;
						self.selectedItems.push(itm);
					});
					self._selectedItemsToInputVal(self.selectedItems);
				}
				else {
					items[idx].selected = true;
					self.selectedItem = items[idx];
					ele.val(self.selectedItem.label);
				}
				self._hideShowArrow(true);
				return;
			}
			// only fileter result when using local data.
			if (!self._usingRemoteData()) {
				self._filter(items, searchTerm);
				itemsToRender = $.grep(items, function (item1) {
					return !o.autoFilter || item1.match;
				});
			}
			else {
				self._topHit = null;
				itemsToRender = items;
			}
			if (itemsToRender.length > 0) {
				// open dropdown list
				self._openlist(itemsToRender, data);
				// trigger dropdown open event.
				self._trigger("open");
				self._addInputFocus(true, stateFocus);
			}
			else {
				self.close(null, true);
			}
			self._hideShowArrow(true);
		},

		close: function (event, skipAnimation) {
			/// <summary>
			/// Closes drop-down list.
			/// </summary>
			/// <param name="event" type="EventObj">
			/// EventObj width this method, normally null.
			/// </param>
			/// <param name="skipAnimation" type="Boolean">
			/// A value indicating whehter to skip animation.
			/// </param>
			var self = this, menu, hidingAnimation, hidingStyle;
			menu = self.menu;

			self._dropDownHeight = menu.element.outerHeight();
			self._dropDownWidth = menu.element.outerWidth();

			window.clearTimeout(self.closing);
			// test parent element is need, hidingAnimation
			// because some effect will wrap the target element.
			if (menu.element.is(":visible") && !menu.element.is(":animated") &&
				!menu.element.parent().is(":animated")) {
				self._trigger("close", event);
				menu.deactivate();
				hidingAnimation = self.options.hidingAnimation;
				//add for size animation by wuhao 2011/7/16
				if (hidingAnimation && hidingAnimation.effect === "size") {
					hidingAnimation.options = $.extend({
						to: {
							width: 0,
							height: 0
						}}, hidingAnimation.options);
				}
				hidingStyle = menu.element.attr("style");
				//end for size animation
				if (skipAnimation !== true && hidingAnimation) {
					menu.element.hide(
					hidingAnimation.effect,
					hidingAnimation.options,
					hidingAnimation.speed,
					function () {
						//add for size animation by wuhao 2011/7/16
						menu.element.removeAttr("style")
										.attr("style", hidingStyle)
										.hide();
						//end for size animation 
						if (hidingAnimation.callback) {
							hidingAnimation.callback.apply(this, arguments);
						}
					});
				}
				else {
					menu.element.hide();
				}
				self._addInputFocus(false, stateFocus);
				$(document).unbind("click", self.closeOnClick);
			}
		},

		_change: function () {
			// TODO: finish _change event.
			var self = this, o, f, m, ele, t, itm;

			o = self.options;
			f = o.forceSelectionText;
			m = o.selectionMode;
			ele = self._input;
			t = ele.val();
			itm = self.selectedItem;

			if (f) {
				if (m === "single") {
					if (itm !== null) {
						if (itm.label !== t) {
							ele.val(itm.label);
						}
					}
					else {
						ele.val("");
					}
				}
			}
			if (m === "multiple") {
				self._selectedItemsToInputVal(self.selectedItems);
			}
		},

		_openlist: function (items, data) {
			var self = data.self, eventObj = data.e, keypress, textWidth, menuElement,
			o, oldPadding, verticalBorder = 2, headerHeight = 0, dropDownHeight, h, showingAnimation,
			showingStyle, showingSize;
			keypress = self._keypress = !!eventObj;
			o = self.options;
			menuElement = self.menu.element;

			menuElement.zIndex(self.element.zIndex() + 1);
			self.menu.setItems(items);
			self.menu.renderList();
			// show dropdown
			self.menu.element.show();
			if (o.dropdownWidth === "auto") {
				textWidth = self._comboElement.outerWidth();
			}
			else {
				textWidth = o.dropdownWidth;
			}
			oldPadding = menuElement.css("padding");
			menuElement.css("padding", "0px");
			menuElement.setOutWidth(textWidth);
			menuElement.css("padding", oldPadding);

			dropDownHeight = o.dropdownHeight;
			if (self._select !== undefined) {
				dropDownHeight = 20 * self._menuUL
				.children(".wijmo-wijlist-item:first").outerHeight();
			}
			//For fixing bug 15778
			//h = Math.min(self._menuUL.outerHeight() + verticalBorder, dropDownHeight); 
			if (menuElement.children(".wijmo-wijsuperpanel-header")) {
				headerHeight = menuElement.children(".wijmo-wijsuperpanel-header").outerHeight();
			}
			//end for fixing bug 15778
			h = Math.min(self._menuUL.outerHeight() + verticalBorder + headerHeight, dropDownHeight);
			menuElement.setOutHeight(h);
			self.menu.refreshSuperPanel();
			self._positionList();
			if (!keypress && self.selectedItem !== undefined) {
				self.menu.activate(null, self.selectedItem, true);
			}
			if (keypress && eventObj.keyCode !== $.ui.keyCode.BACKSPACE) {
				if (o.isEditable) {
					self._runAutoComplete();
				}
				else {
					self.menu.activate(null, self._topHit, true);
				}
			}
			else {
				showingAnimation = self.options.showingAnimation;
				if (o.showingAnimation !== null &&
				!(eventObj !== undefined &&
				eventObj.keyCode === $.ui.keyCode.BACKSPACE)) {
					self.menu.element.hide();
					//Add comments by RyanWu@20101105.
					//For fixing the issue that list items are transparent 
					//when choosing bounce effect. 

					//self.menu.element.show(
					//showingAnimation.effect, 
					//showingAnimation.options, 
					//showingAnimation.speed, 
					//showingAnimation.callback);
					//add for size animation by wuhao 2011/7/16
					showingSize = {
						from: { width: 0, height: 0 },
						to: { width: self._dropDownWidth || menuElement.outerWidth(),
							height: self._dropDownHeight || menuElement.outerHeight()
						}
					};
					if (showingAnimation && showingAnimation.effect === "size") {
						showingAnimation.options = 
							$.extend(showingSize, showingAnimation.options);
					}
					showingStyle = menuElement.attr("style");
					//end for size animation
					menuElement.show(
					showingAnimation.effect,
					showingAnimation.options,
					showingAnimation.speed,
					function () {
						//add for size animation by wuhao 2011/7/16
						menuElement.removeAttr("style")
										.attr("style", showingStyle)
										.show();
						//end for size animation
						if (showingAnimation.callback) {
							showingAnimation.callback.apply(this, arguments);
						}

						if ($.browser.msie) {
							menuElement.css("filter", "");
						}
					});
					//end by RyanWu@20101105.
				}
			}
			if (!self.hasOwnProperty("closeOnClick")) {
				var origCloseOnClick = self.closeOnClick;
				self.closeOnClick = function (e) { return origCloseOnClick(e); };
			}
			$(document).bind("click", self, self.closeOnClick);
		},

		closeOnClick: function (e) {
			var self = e.data, t = e.target;

			if (!$.contains(self._comboElement[0], t) &&
			!$.contains(self.menu.element[0], t)) {
				self.close();
				$(".wijmo-wijcombobox-wrapper", self._comboElement[0])
				.removeClass("ui-state-hover")
				.removeClass("ui-state-focus");
				$(".wijmo-wijcombobox-trigger", self._comboElement[0])
				.removeClass("ui-state-hover")
				.removeClass("ui-state-focus");
			}
		},

		_positionList: function () {
			var self = this, positionOptions, defaultPosition;
			positionOptions = self.options.dropDownListPosition;
			defaultPosition = {
				my: "left top",
				at: "left bottom",
				of: self._comboElement,
				collision: "none"
			};
			defaultPosition = $.extend(defaultPosition, positionOptions);
			self.menu.element.position(defaultPosition);
		},

		_runAutoComplete: function () {
			var self = this, ele, topHit, oldText, fullText, start, end;
			ele = self._input;
			topHit = self._topHit;
			if (!self.options.autoComplete || topHit === null) {
				return;
			}
			self.menu.activate(null, topHit, true);
			oldText = ele.val();
			fullText = topHit.label;
			ele.val(fullText);
			start = oldText.length;
			end = fullText.length;
			self._selectText(start, end, ele);
		},

		_selectText: function (start, end, input) {
			var v = input.val(), inputElement = input.get(0), range;
			if (v.length > 0) {
				if (inputElement.setSelectionRange !== undefined) {
					inputElement.setSelectionRange(start, end);
				}
				else if (inputElement.createTextRange !== undefined) {
					range = inputElement.createTextRange();
					range.moveStart("character", start);
					range.moveEnd("character", end - v.length);
					range.select();
				}
			}
		},

		_move: function (direction, event) {
			if (!this.menu.element.is(":visible")) {
				this.search("", event);
				return;
			}
			if (this.menu.first() && /^previous/.test(direction) ||
			this.menu.last() && /^next/.test(direction)) {
				//update for fixing bug 15964 by wuhao
				//this.menu.deactivate();
				//end for bug 15964.
				return;
			}
			this.menu[direction](event);
		},

		_escapeRegex: function (value) {
			if (value === undefined) {
				return value;
			}
			return value.replace(/([\^\$\(\)\[\]\{\}\*\.\+\?\|\\])/gi, "\\$1");
		},

		_filter: function (array, searchTerm) {
			var term1 = this._escapeRegex(searchTerm), matcher, topHit = null;
			/// TODO : start with or contains and case sensitive.
			matcher = new RegExp(term1, "i");
			$.each(array, function (index, item) {
				if (term1 === undefined || term1.length === 0) {
					item.match = true;
					return;
				}
				var matchResult = matcher.exec(item.label);
				if (matchResult === null) {
					item.match = false;
				}
				else {
					if (topHit === null && matchResult.index === 0) {
						topHit = item;
					}
					item.match = matchResult.index >= 0;
				}
			});
			this._topHit = topHit;
			return array;
		}
	});
} (jQuery));

/*
 *
 * Wijmo Library 1.4.0
 * http://wijmo.com/
 *
 * Copyright(c) ComponentOne, LLC.  All rights reserved.
 * 
 * Dual licensed under the Wijmo Commercial or GNU GPL Version 3 licenses.
 * licensing@wijmo.com
 * http://wijmo.com/license
 *
 *
 * * Wijmo Inputcore widget.
 *
 */
(function ($) {
	"use strict";
	window.wijinputcore = {
		options: {
			///	<summary>
			///		Determines the culture ID name.
			///	</summary>
			culture: '',
			///	<summary>
			///		The CSS class applied to the widget when an invalid value is entered.
			///	</summary>
			invalidClass: 'ui-state-error',
			///	<summary>
			///		Determines the text that will be displayed for blank status.
			///	</summary>
			nullText: '',
			///	<summary>
			///		Show Null Text if the value is empty and the control loses its focus.
			///	</summary>
			showNullText: false,
			///	<summary>
			///		If true, then the browser response is disabled when the ENTER key is pressed.
			///	</summary>
			hideEnter: false,
			///	<summary>
			///		Determines whether the user can type a value.
			///	</summary>
			disableUserInput: false,
			///	<summary>
			///		Determines the alignment of buttons.
			///		Possible values are: 'left', 'right'
			///	</summary>
			buttonAlign: 'right',
			///	<summary>
			///		Determines whether trigger button is displayed.
			///	</summary>
			showTrigger: false,
			///	<summary>
			///		Determines whether spinner button is displayed.
			///	</summary>
			showSpinner: false,
			///	<summary>
			///		Array of data items for the drop-down list.
			///	</summary>
			comboItems: undefined,
			///	<summary>
			///		Determines the width of the drop-down list.
			///	</summary>
			comboWidth: undefined,
			///	<summary>
			///		Determines the height of the drop-down list.
			///	</summary>
			comboHeight: undefined,
			/// <summary>
			/// The initializing event handler. A function called before the widget is initialized.
			/// Default: null.
			/// Type: Function.
			/// Code example: $("#element").wijinputmask({ initializing: function () { } });
			/// </summary>
			initializing: null,
			/// <summary>
			/// The initialized event handler. A function called after the widget is initialized.
			/// Default: null.
			/// Type: Function.
			/// Code example: $("#element").wijinputmask({ initialized: function (e) { } });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			initialized: null,
			/// <summary>
			/// The triggerMouseDown event handler. A function called when the mouse is pressed down on the trigger button.
			/// Default: null.
			/// Type: Function.
			/// Code example: $("#element").wijinputmask({ triggerMouseDown: function (e) { } });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			triggerMouseDown: null,
			/// <summary>
			/// The triggerMouseUp event handler. A function called when the mouse is released on the trigger button.
			/// Default: null.
			/// Type: Function.
			/// Code example: $("#element").wijinputmask({ triggerMouseUp: function (e) { } });
			/// </summary>
			////// <param name="e" type="Object">jQuery.Event object.</param>
			triggerMouseUp: null,
			/// <summary>
			/// The textChanged event handler. A function called when the text of the input is changed.
			/// Default: null.
			/// Type: Function.
			/// Code example: $("#element").wijinputmask({ textChanged: function (e, arg) { } });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.text: The new text.
			///</param>
			textChanged: null,
			/// <summary>
			/// The invalidInput event handler. A function called when invalid charactor is typed.
			/// Default: null.
			/// Type: Function.
			/// Code example: $("#element").wijinputmask({ invalidInput: function (e) { } });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			invalidInput: null
		},

		_create: function () {
			if (this.element[0].tagName.toLowerCase() !== 'input') {
				throw "Target element is not a INPUT";
			}
			
			$.effects.save(this.element, ['width', 'height']);
			var width = this.element.width();
			this.element.wrap("<div class='wijmo-wijinput ui-widget ui-helper-clearfix ui-state-default ui-corner-all'><span class='wijmo-wijinput-wrapper'></span></div>");
			this.element.addClass('wijmo-wijinput-input ui-corner-all').attr({ 'role': 'textbox', 'aria-multiline': false });
			this.wrapper = this.element.parent();
			this.outerDiv = this.wrapper.parent();
			this.outerDiv.width(width);

			if (this.options.showTrigger) {
				this.triggerBtn = $("<div class='wijmo-wijinput-trigger ui-state-default'><span class='ui-icon ui-icon-triangle-1-s'></span></div>")
					.addClass(this.options.buttonAlign === 'left' ? 'ui-corner-left' : 'ui-corner-right')
					.attr('role', 'button')
					.appendTo(this.outerDiv);
				this.element.attr({ 'role': 'combobox', 'aria-expanded': false });
			}

			if (this.options.showSpinner) {
				this.spinner = $("<div class='wijmo-wijinput-spinner wijmo-wijinput-button'></div>");
				this.spinUp = $("<div class='ui-state-default wijmo-wijinput-spinup'><span class='ui-icon ui-icon-triangle-1-n'></span></div>").attr('role', 'button');
				this.spinDown = $("<div class='ui-state-default wijmo-wijinput-spindown'><span class='ui-icon ui-icon-triangle-1-s'></span></div>").attr('role', 'button');
				if (!this.options.showTrigger) {
					this.spinUp.addClass(this.options.buttonAlign === 'left' ? 'ui-corner-tl' : 'ui-corner-tr');
					this.spinDown.addClass(this.options.buttonAlign === 'left' ? 'ui-corner-bl' : 'ui-corner-br');
				}
				this.spinner.append(this.spinUp)
					.append(this.spinDown)
					.appendTo(this.outerDiv);
				this.element.attr('role', 'spinner');
			}

			if (this.options.showTrigger && this.options.showSpinner) {
				this.outerDiv.addClass(this.options.buttonAlign === 'left' ? 'ui-input-spinner-trigger-left' : 'ui-input-spinner-trigger-right');
			} else {
				if (this.options.showTrigger) {
					this.outerDiv.addClass(this.options.buttonAlign === 'left' ? 'ui-input-trigger-left' : 'ui-input-trigger-right');
				}

				if (this.options.showSpinner) {
					this.outerDiv.addClass(this.options.buttonAlign === 'left' ? 'ui-input-spinner-left' : 'ui-input-spinner-right');
				}
			}

			this.element.setOutWidth(this.outerDiv.width());
			this._initialize();
		},

		_createTextProvider: function () {
			return undefined;
		},

		_beginUpdate: function () {
		},

		_endUpdate: function () {
		},

		_onTriggerClicked: function () {
		},

		_initialize: function () {
			this.element.data('initializing', true);
			this._trigger('initializing');

			this.element.data('preText', this.element.val());
			this.element.data('elementValue', this.element.val());
			this.element.data('errorstate', false);
			this.element.data('breakSpinner', true);
			this.element.data('prevCursorPos', -1);
			this.element.data('doubleBytes', false);

			this._createTextProvider();
			this._beginUpdate();

			var isLeftButton = function (e) { return (!e.which ? e.button : e.which) === 1; };
			var o = this.options, self = this;
			if (this.triggerBtn && !o.disabled) {
				this.triggerBtn.bind({
					'mouseover': function () { self._addState('hover', $(this)); },
					'mouseout': function () { self._removeState('hover', $(this)); },
					'mousedown': function (e) {
						if (!isLeftButton(e)) { return; }
						self._addState('active', $(this));
						self._trigger('triggerMouseDown');
					},
					'mouseup': function (e) {
						if (!isLeftButton(e)) { return; }
						self._stopEvent(e);
						self._stopSpin();
						self._removeState('active', $(this));
						self._trigger('triggerMouseUp');
						self._onTriggerClicked();
						self._trySetFocus();
					}
				});
			}

			var spinButtonDown = function (e) {
				if (!isLeftButton(e)) { return; }
				self._trySetFocus();
				self.element.data('breakSpinner', false);
				self._addState('active', $(this));
				self._doSpin($(e.currentTarget).hasClass('wijmo-wijinput-spinup'), true);
			};

			var spinButtonUp = function (e) {
				if (!isLeftButton(e)) { return; }
				self._stopSpin();
				self._removeState('active', $(this));
			};

			if (this.spinUp && !o.disabled) {
				this.spinUp.bind({
					'mouseover': function () { self._addState('hover', $(this)); },
					'mouseout': function () { self._removeState('hover', $(this)); },
					'mousedown': spinButtonDown,
					'mouseup': spinButtonUp
				});
			}

			if (this.spinDown && !o.disabled) {
				this.spinDown.bind({
					'mouseover': function () { self._addState('hover', $(this)); },
					'mouseout': function () { self._removeState('hover', $(this)); },
					'mousedown': spinButtonDown,
					'mouseup': spinButtonUp
				});
			}

			this.element.bind({
				'focus.wijinput': $.proxy(this._onFocus, this),
				'blur.wijinput': $.proxy(this._onBlur, this),
				'mouseup.wijinput': $.proxy(this._onMouseUp, this),
				'keypress.wijinput': $.proxy(this._onKeyPress, this),
				'keydown.wijinput': $.proxy(this._onKeyDown, this),
				'keyup.wijinput': $.proxy(this._onKeyUp, this),
				'change.wijinput': $.proxy(this._onChange, this),
				'paste.wijinput': $.proxy(this._onPast, this),
				'drop.wijinput': $.proxy(this._onDrop, this)
			});

			this.element.bind('propertychange.wijinput input.wijinput', $.proxy(this._onInput, this));
			this.element.data('initializing', false);

			this._resetData();
			this._endUpdate();
			this._updateText();
			
			if (this.options.disabled){
				this.disable();
			}
			
			this._trigger('initialized');
		},

		_init: function () {
		},

		_setOption: function (key, value) {
			$.Widget.prototype._setOption.apply(this, arguments);

			switch (key) {
				case 'buttonAlign':
				case 'showTrigger':
				case 'showSpinner':
					this._destroy();
					this._create();
					break;

				case 'showNullText':
					this._updateText();
					break;

				case 'disabled':
					this.element.attr('disabled', value);
					this.element[value ? 'addClass' : 'removeClass'](this.namespace + "-state-disabled");
					if (this.triggerBtn !== undefined) {
						this.triggerBtn[value ? 'addClass' : 'removeClass'](this.namespace + "-state-disabled");
					}

					if (this.spinup !== undefined) {
						this.spinup[value ? 'addClass' : 'removeClass'](this.namespace + "-state-disabled");
					}

					if (this.spindown !== undefined) {
						this.spindown[value ? 'addClass' : 'removeClass'](this.namespace + "-state-disabled");
					}
					break;
			}
		},

		destroy: function () {
			$.Widget.prototype.destroy.apply(this, arguments);
			this._destroy();
		},

		_destroy: function () {
			this.wrapper = undefined;
			this.outerDiv = undefined;
			this.element.unbind('.wijinput');

			this.element.removeData('errorstate')
				.removeData('breakSpinner')
				.removeData('prevCursorPos')
				.removeData('doubleBytes')
				.removeData('isPassword')
				.removeClass('wijmo-wijinput-input')
				.removeAttr('role')
				.removeAttr('aria-valuemin')
				.removeAttr('aria-valuemax')
				.removeAttr('aria-valuenow')
				.removeAttr('aria-expanded');

			this.element.parent().replaceWith(this.element);
			this.element.parent().replaceWith(this.element);
			$.effects.restore(this.element, ['width', 'height']);
		},

		widget: function () {
			return this.outerDiv;
		},

		_getCulture: function (name) {
			return $.findClosestCulture(name || this.options.culture);
		},

		_addState: function (state, el) {
			if (el.is(':not(.ui-state-disabled)')) {
				el.addClass('ui-state-' + state);
			}
		},

		_removeState: function (state, el) {
			el.removeClass('ui-state-' + state);
		},

		_isInitialized: function () {
			return !this.element.data('initializing');
		},

		_setData: function (val) {
			this.setText(val);
		},
		
		_resetData: function () {
		},

		_validateData: function () {
		},

		getText: function () {
			/// <summary>Gets the text displayed in the input box.</summary>
			if (!this._isInitialized()) { return this.element.val(); }
			return this._textProvider.toString(true, false, false);
		},

		setText: function (value) {
			/// <summary>Sets the text displayed in the input box.</summary>
			if (!this._isInitialized()) {
				this.element.val(value);
			} else {
				this._textProvider.set(value);
				this._updateText();
			}
		},

		selectText: function (start, end) {
			/// <summary>Selects a range of text.</summary>
			/// <param name="start" type="Number">Start of the range.</param>
			/// <param name="end" type="Number">End of the range.</param>
			if (this.element.is(':disabled')) { return; }
			this.element.wijtextselection(start, end);
		},

		focus: function () {
			/// <summary>Set the focus to this input.</summary>
			if (this.element.is(':disabled')) { return; }
			this.element.get(0).focus();
		},
		
		isFocused: function () {
			/// <summary>Determines whether the input has input focus.</summary>
			return this.outerDiv.hasClass("ui-state-focus");
		},

		_raiseTextChanged: function () {
			var txt = this.element.val();
			if (this.element.data('preText') !== txt) {
				this._trigger('textChanged', null, {text: txt});
				this.element.data('preText', txt);
			}
		},

		_raiseDataChanged: function () {
		},

		_allowEdit: function () {
			return !(this.element.attr('readOnly') && this.element.is(':disabled'));
		},

		_updateText: function (keepSelection) {
			if (!this._isInitialized()) { return; }

			// default is false
			keepSelection = !!keepSelection;
			var range = this.element.wijtextselection();
			this.element.val(this._textProvider.toString());
			this.options.text = this._textProvider.toString(true, false, false);
			if (this.element.is(':disabled')) { return; }

			if (keepSelection){
				this.selectText(range.start, range.end);
			}
			this.element.data('prevCursorPos', range.start);

			this._raiseTextChanged();
			this._raiseDataChanged();
		},

		_trySetFocus: function () {
			if (!this.isFocused()) {
				try {
					if (!this.options.disableUserInput) {
						this.element.focus();
					}
				}
				catch (e) {
				}
			}
		},

		_deleteSelText: function (backSpace) {
			if (!this._allowEdit()) { return; }
			var selRange = this.element.wijtextselection();

			backSpace = !!backSpace;
			if (backSpace) {
				if (selRange.end === selRange.start) {
					if (selRange.end >= 1) {
						selRange.end = (selRange.end - 1);
						selRange.start = (selRange.start - 1);
					} else {
						return;
					}
				} else {
					selRange.end = (selRange.end - 1);
				}
			} else {
				selRange.end = (selRange.end - 1);
			}
			if (selRange.end < selRange.start) {
				selRange.end = (selRange.start);
			}
			var rh = new wijInputResult();
			this._textProvider.removeAt(selRange.start, selRange.end, rh);
			this._updateText();
			this.selectText(rh.testPosition, rh.testPosition);
		},

		_fireIvalidInputEvent: function () {
			this._trigger('invalidInput');
			if (!this.element.data('errorstate')) {
				var cls = this.options.invalidClass || 'ui-state-error';
				this.element.data('errorstate', true);
				var self = this;
				window.setTimeout(function () {
					self.outerDiv.removeClass(cls);
					self.element.data('errorstate', false);
				}, 100);
				this.outerDiv.addClass(cls);
			}
		},

		_onInput: function (e) {
			if (!this.element.data('doubleBytes') || !this.element.data('lastSelection')) {
				return;
			}
			var range = this.element.wijtextselection();
			var start = this.element.data('lastSelection').start;
			var end = range.end;

			this.element.data('doubleBytes', false);
			if (end >= start) {
				var txt = this.element.val();
				var str = txt.substring(start, end);
				var self = this;
				window.setTimeout(function () {
					if (!self.element.data('lastValue')) { return; }

					self.element.val(self.element.data('lastValue'));
					var lastSel = self.element.data('lastSelection');
					self.element.wijtextselection(lastSel);
					self.element.removeData('lastSelection');
					self.element.data('batchKeyPress', true);
					for (var i = 0; i < str.length; i++) {
						e.which = e.charCode = e.keyCode = str.charCodeAt(i);
						this._onKeyPress(e);
					}
					self.element.data('batchKeyPress', false);
				}, 1);
			}
		},

		_keyDownPreview: function (e) {
			return false; // true means handled.
		},

		_onKeyDown: function (e) {
			this.element.data('prevCursorPos', -1);

			if (!this._isInitialized()) { return; }

			var k = this._getKeyCode(e);
			if (k === 229) { // Double Bytes
				if (!this.element.data('lastSelection')) {
					this.element.data('lastSelection', this.element.wijtextselection());
					this.element.data('lastValue', this.element.val());
				}

				this.element.data('doubleBytes', true);
				return;
			}
			this.element.data('doubleBytes', false);

			if (this.options.disableUserInput) {
				this._stopEvent(e);
				return;
			}

			if (this._keyDownPreview(e)) {
				this._stopEvent(e);
				return;
			}

			switch (k) {
				case $.ui.keyCode.UP:
					this._doSpin(true, false);
					this._stopEvent(e);
					return;
				case $.ui.keyCode.DOWN:
					this._doSpin(false, false);
					this._stopEvent(e);
					return;
			}

			if (e.ctrlKey) {
				switch (k) {
					case $.ui.keyCode.INSERT:
					case 67: // 'c'
						return;
					default:
						break;
				}
			}
			if ((e.ctrlKey || e.altKey)) { return; }

			switch (k) {
				case 112: // F1-F6
				case 113:
				case 114:
				case 115:
				case 116:
				case 117:
				case $.ui.keyCode.TAB:
				case $.ui.keyCode.CAPSLOCK:
				case $.ui.keyCode.END:
				case $.ui.keyCode.HOME:
				case $.ui.keyCode.CTRL:
				case $.ui.keyCode.SHIFT:
					return;
				case $.ui.keyCode.BACKSPACE:
					this._deleteSelText(true);
					this._stopEvent(e);
					return;
				case $.ui.keyCode.DELETE:
					this._deleteSelText(false);
					this._stopEvent(e);
					return;
				case $.ui.keyCode.ENTER:
					if (!this.options.hideEnter) { return; }
					break;
				case $.ui.keyCode.ESCAPE:
					this._stopEvent(e);
					window.setTimeout($.proxy(this._resetData, this), 1);
					return;
				case $.ui.keyCode.PAGE_UP:
				case $.ui.keyCode.PAGE_DOWN:
				case $.ui.keyCode.ALT:
					this._stopEvent(e);
					return;
			}
		},

		_onKeyUp: function (e) {
			if (this.element.data('doubleBytes')) { return; }
			var k = this._getKeyCode(e);

			if (!this._isInitialized()) { return; }
			if (k === $.ui.keyCode.ENTER) { return; }
			if (k === $.ui.keyCode.ESCAPE) { return; }

			if (this.options.disableUserInput) {
				this._raiseTextChanged();
				this._raiseDataChanged();
				return;
			}

			this._stopEvent(e);
		},

		_getKeyCode: function (e) {
			var userAgent = window.navigator.userAgent;
			if ((userAgent.indexOf('iPod') !== -1 || userAgent.indexOf('iPhone') !== -1) && e.which === 127) {
				return 8;
			}
			return e.keyCode || e.which;
		},

		_keyPressPreview: function (e) {
			return false;
		},

		_onKeyPress: function (e) {
			if (this.element.data('doubleBytes')) { return; }
			this.element.data('prevCursorPos', -1);

			if (this.options.disableUserInput) { return; }
			if (!this._allowEdit()) { return; }

			if (e.ctrlKey && e.keyCode == 119) {  //Ctrl + F8
				this._onPast(e);
				return;
			}
			
			if (e.which === 0) { return; }
			
			var key = e.keyCode || e.which;
			if (key === $.ui.keyCode.BACKSPACE){
				this._stopEvent(e);
				return;
			}
			
			if (e.ctrlKey || e.altKey) {
				if (key !== $.ui.keyCode.SPACE) {
					return;
				}
			}
			
			if (key === $.ui.keyCode.ENTER && !this.options.hideEnter){
				return true;
			}
			
			if (this._keyPressPreview(e)) {
				return;
			}

			var selRange = this.element.wijtextselection();
			var ch = String.fromCharCode(key);
			if (selRange.start < selRange.end) {
				this._textProvider.removeAt(selRange.start, selRange.end - 1, new wijInputResult());
			}
			var rh = new wijInputResult();
			var opResult = this._textProvider.insertAt(ch, selRange.start, rh);
			if (opResult) {
				this._updateText();
				this.selectText(rh.testPosition + 1, rh.testPosition + 1);
			}
			else {
				this._fireIvalidInputEvent();
			}
			if (!this.element.data('batchKeyPress')) {
				this._stopEvent(e);
			}
		},
		
		_isNullText: function(){
			return this.options.showNullText && this.element.val() === this.options.nullText;
		},
		
		_doFocus: function(){
			var selRange = this.element.wijtextselection();
			var sta = selRange.start;
			this._updateText();
			var s = this.element.val();
			if (s.length === sta) { sta = 0; }
			if (!$.browser.safari) {
				this.selectText(sta, sta);
			}
		},

		_afterFocused: function () {
			if (this._isNullText()){
				this._doFocus();
			}
		},

		_onFocus: function (e) {
			if (this.options.disableUserInput) { return; }
			this._addState('focus', this.outerDiv);

			if (!this.element.data('breakSpinner')) {
				return;
			}

			if (!this._isInitialized()) { return; }
			if (!this._allowEdit()) { return; }

			if (!this.element.data('focusNotCalledFirstTime')) { this.element.data('focusNotCalledFirstTime', new Date().getTime()); }
			this._afterFocused();
		},

		_onBlur: function (e) {
			if (this.options.disableUserInput) { return; }
			if (this._isComboListVisible()) { return; }

			var focused = this.isFocused();
			this._removeState('focus', this.outerDiv);
			
			if (!this.element.data('breakSpinner')) {
				this.element.get(0).focus();
				var curPos = this.element.data('prevCursorPos');
				if (curPos !== undefined && curPos !== -1) {
					this.selectText(curPos, curPos);
				}
				return;
			}
			if (!this._isInitialized()) { return; }
			if (!focused) { return; }

			this.element.data('value', this.element.val());
			var self = this;
			window.setTimeout(function () {
				self._onChange();
				self._updateText();
				self._validateData();
			}, 100);
		},

		_onMouseUp: function (e) {
			if (!this._isInitialized()) { return; }
			if (this.element.is(':disabled')) { return; }

			var selRange = this.element.wijtextselection();
			this.element.data('prevCursorPos', selRange.start);
		},

		_onChange: function (e) {
			if (!this.element) { return; }

			var val = this.element.val();
			var txt = this.getText();
			if (txt !== val) {
				this.setText(val);
			}
		},

		_onPast: function (e) {
			window.setTimeout($.proxy(this._onChange, this), 1);
		},

		_onDrop: function (e) {
			window.setTimeout($.proxy(this._onChange, this), 1);
		},

		_stopEvent: function (e) {
			e.stopPropagation();
			e.preventDefault();
		},

		_calcSpinInterval: function () {
			this._repeatingCount++;
			if (this._repeatingCount > 10) {
				return 50;
			}
			else if (this._repeatingCount > 4) {
				return 100;
			}
			else if (this._repeatingCount > 2) {
				return 200;
			}
			return 400;
		},

		_doSpin: function () {
		},

		_stopSpin: function _stopSpin() {
			this.element.data('breakSpinner', true);
			this._repeatingCount = 0;
		},

		_hasComboItems: function () {
			return (!!this.options.comboItems && this.options.comboItems.length);
		},

		_isComboListVisible: function () {
			if (!this._comboDiv) { return false; }
			return this._comboDiv.wijpopup('isVisible');
		},

		_popupComboList: function () {
			if (!this._hasComboItems()) { return; }
			if (!this._allowEdit()) { return; }

			if (this._isComboListVisible()) {
				this._comboDiv.wijpopup('hide');
				return;
			}

			var self = this;
			if (this._comboDiv === undefined) {
				this._comboDiv = $("<div></div>")
				.appendTo(document.body)
				.width(this.element.width())
				.height(this.options.comboHeight || 180)
				.css('position', 'absolute');

				var content = this._normalize(this.options.comboItems);
				this._comboDiv.wijlist({
					autoSize: true,
					maxItemsCount: 5,
					selected: function (event, ui) {
						self._setData(ui.item.value);
						self._comboDiv.wijpopup('hide');
						self._trySetFocus();
					}
				});

				this._comboDiv.wijlist('setItems', content);
				this._comboDiv.wijlist('renderList');
				this._comboDiv.wijlist("refreshSuperPanel");
			}

			this._comboDiv.wijpopup({
				autoHide: true
			});

			this.outerDiv.attr('aria-expanded', true);
			this._comboDiv.wijpopup('show', {
				of: this.outerDiv,
				offset: '0 4',
				hidden: function () { self.outerDiv.attr('aria-expanded', false); }
			});
		},

		_normalize: function (items) {
			// assume all items have the right format when the first item is complete
			if (items.length && items[0].label && items[0].value) {
				return items;
			}
			return $.map(items, function (item) {
				if (typeof item === "string") {
					return {
						label: item,
						value: item
					};
				}
				return $.extend({
					label: item.label || item.value,
					value: item.value || item.label
				}, item);
			});
		}
	};

	window.wijInputResult = function () {
		this.alphanumericCharacterExpected = -2;
		this.asciiCharacterExpected = -1;
		this.digitExpected = -3;
		this.invalidInput = -51;
		this.letterExpected = -4;
		this.nonEditPosition = -54;
		this.positionOutOfRange = -55;
		this.promptCharNotAllowed = -52;
		this.signedDigitExpected = -5;
		this.unavailableEditPosition = -53;
		this.testPosition = -1;
	};

	window.wijInputResult.prototype = {
		characterEscaped: 1,
		noEffect: 2,
		sideEffect: 3,
		success: 4,
		unknown: 0,
		hint: 0,

		clone: function () {
			var rh = new wijInputResult();
			rh.hint = this.hint;
			rh.testPosition = this.testPosition;
			return rh;
		}
	};

})(jQuery);

/*
 *
 * Wijmo Library 1.4.0
 * http://wijmo.com/
 *
 * Copyright(c) ComponentOne, LLC.  All rights reserved.
 * 
 * Dual licensed under the Wijmo Commercial or GNU GPL Version 3 licenses.
 * licensing@wijmo.com
 * http://wijmo.com/license
 *
 *
 * * Wijmo Inputdate widget.
 *
 * Depends:
 *	jquery-1.4.2.js
 *	jquery.ui.core.js
 *	jquery.ui.widget.js
 *	jquery.ui.position.js
 *	jquery.effects.core.js	
 *	jquery.effects.blind.js
 *	jquery.glob.js
 *	jquery.plugin.wijtextselection.js
 *	jquery.mousewheel.js
 *	jquery.wijmo.wijpopup.js
 *	jquery.wijmo.wijcalendar.js
 *	jquery.wijmo.wijinputcore.js
 *
 */

(function ($) {
	"use strict";
	var wijdigits = {
		useDefault: -2,
		asIs: -1,
		zero: 0,
		one: 1,
		two: 2,
		three: 3,
		four: 4,
		five: 5,
		six: 6,
		seven: 7,
		eight: 8
	};

	$.widget("wijmo.wijinputdate", $.extend(true, {}, wijinputcore, {
		options: {
			///	<summary>
			///		Determines the default date value for a date input.
			///	</summary>
			date: null,
			///	<summary>
			///		The format pattern to display the date value
			///		wijinputdate supports two types of formats: Standard Format and Custom Format.
			///
			///		A standard date and time format string uses a single format specifier to 
			///		define the text representation of a date and time value. 
			///
			///		Possible values for Standard Format are:
			///		"d": ShortDatePattern
			///		"D": LongDatePattern
			///     "f": Full date and time (long date and short time)
			///     "F": FullDateTimePattern
			///	    "g": General (short date and short time)
			///     "G": General (short date and long time)
			///     "m": MonthDayPattern
			///     "M": monthDayPattern
			///     "r": RFC1123Pattern
			///     "R": RFC1123Pattern
			///     "s": SortableDateTimePattern
			///     "t": shortTimePattern
			///     "T": LongTimePattern
			///     "u": UniversalSortableDateTimePattern
			///     "U": Full date and time (long date and long time) using universal time
			///     "y": YearMonthPattern
			///     "Y": yearMonthPattern
			///
			///		Any date and time format string that contains more than one character, including white space, 
			///		is interpreted as a custom date and time format string. For example: 
			///		"mmm-dd-yyyy", "mmmm d, yyyy", "mm/dd/yyyy", "d-mmm-yyyy", "ddd, mmmm dd, yyyy" etc.
			///
			///		Below are the custom date and time format specifiers:
			///
			///		"d": The day of the month, from 1 through 31. 
			///		"dd": The day of the month, from 01 through 31.
			///		"ddd": The abbreviated name of the day of the week.
			///		"dddd": The full name of the day of the week.
			///		"m": The minute, from 0 through 59.
			///		"mm": The minute, from 00 through 59.
			///		"M": The month, from 1 through 12.
			///		"MM": The month, from 01 through 12.
			///		"MMM": The abbreviated name of the month.
			///		"MMMM": The full name of the month.
			///		"y": The year, from 0 to 99.
			///		"yy": The year, from 00 to 99
			///		"yyy": The year, with a minimum of three digits.
			///		"yyyy": The year as a four-digit number
			///		"h": The hour, using a 12-hour clock from 1 to 12.
			///		"hh": The hour, using a 12-hour clock from 01 to 12.
			///		"H": The hour, using a 24-hour clock from 0 to 23.
			///		"HH": The hour, using a 24-hour clock from 00 to 23.
			///		"s": The second, from 0 through 59.
			///		"ss": The second, from 00 through 59.
			///		"t": The first character of the AM/PM designator.
			///		"tt": The AM/PM designator.
			///	</summary>
			dateFormat: 'd',
			///	<summary>
			///		Determines the value of the starting year to be used for the smart input year calculation.
			///	</summary>
			startYear: 1950,
			///	<summary>
			///		Allows smart input behavior.
			///	</summary>
			smartInputMode: true,
			///	<summary>
			///		Determines the active field index.
			///	</summary>
			activeField: 0,
			///	<summary>
			///		Determines the time span, in milliseconds, between two input intentions.
			///	</summary>
			keyDelay: 800,
			///	<summary>
			///		Determines whether to automatically moves to the next field.
			///	</summary>
			autoNextField: true,
			///	<summary>
			///		Determines the calendar element for a date input.
			///		Set to 'default' to use default calendar.
			///	</summary>
			calendar: 'default',
			///	<summary>
			///		Detemines the popup position of a calendar. See jQuery.ui.position for position options.
			///	</summary>
			popupPosition: {
				offset: '0 4'
			},
			/// <summary>
			/// The dateChanged event handler. A function called when the date of the input is changed.
			/// Default: null.
			/// Type: Function.
			/// Code example: $("#element").wijinputdate({ dateChanged: function (e, arg) { } });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.date: The new date.
			///</param>
			dateChanged: null
		},

		_createTextProvider: function () {
			this._textProvider = new wijDateTextProvider(this, this.options.dateFormat);
		},

		_beginUpdate: function () {
			var o = this.options;

			var strDate;
			if (!o.date) {
				o.date = new Date();
				if (!this.element.data('elementValue')){
					this.element.data('nullDate', true);
				}else{
					strDate = this.element.data('elementValue');
				}
			}else{
				if (typeof o.date === 'string'){
					strDate = o.date;
				}
			}
			
			if (strDate){
				strDate = strDate.replace(/-/g, '/');
			
				try{
					o.date = new Date(strDate);
					if (isNaN(o.date)){
						o.date = new Date();
					}
				}
				catch (e){
					o.date = new Date();
				}
			}

			this.element.data({
				defaultDate: new Date(o.date.getTime()),
				preDate: new Date(o.date.getTime())
			});
			this._resetTimeStamp();
			if (o.showTrigger && !this._hasComboItems()) {
				this._initCalendar();
			}
			this.element.addClass('wijmo-wijinput-date')
				.attr({
					'aria-valuemin': new Date(1900, 1, 1),
					'aria-valuemax': new Date(2099, 1, 1),
					'aria-valuenow': o.date
				});
		},

		_endUpdate: function () {
			var self = this;
			this.element.click(function () {
				self.highLightCursor();
			});

			this.element.mousewheel(function (e, delta) {
				self._doSpin(delta > 0, false);
			});
		},

		_onTriggerClicked: function () {
			if (this._hasComboItems()) {
				this._popupComboList();
			} else {
				this._popupOrHideCalendar();
			}
		},

		_setOption: function (key, value) {
			$.Widget.prototype._setOption.apply(this, arguments);
			wijinputcore._setOption.apply(this, arguments);

			switch (key) {
				case 'date':
					if (!value){
						this.options.date = new Date();
						
						if (!this.isFocused()){
							this.element.data('nullDate', true);
						}						
					}else{
						if (typeof value === "string") {
							value = value.replace(/-/g, '/');
						}
						
						this.options.date = new Date(value);
						if (isNaN(this.options.date)){
							this.options.date = new Date();
						}
					}
					this._updateText();
					this.highLightField();
					break;

				case 'dateFormat':
				case 'culture':
					this._textProvider._setFormat(this.options.dateFormat);
					this._updateText();
					break;

				case 'activeField':
					value = Math.min(value, this._textProvider.getFieldCount() - 1);
					value = Math.max(value, 0);
					this.options.activeField = value;
					this.highLightField();
					this._resetTimeStamp();
					break;
			}
		},

		_setData: function (val) {
			this.option('date', val);
		},
		
		_resetData: function () {
			var o = this.options;
			
			var d = this.element.data('defaultDate');
			if (d === undefined || d === null){
				d = this.element.data('elementValue');
				if (d !== undefined && d !== null && d !== ""){
					this.element.val(d);
					this._onChange();
				}else
				{
					this._setData(new Date());
				}
			}else{
				this._setData(d);
			}
		 },

		_resetTimeStamp: function () {
			this.element.data('cursorPos', 0);
			this.element.data('timeStamp', new Date('1900/1/1'));
		},

		highLightField: function (index) {
			if (index === undefined) { index = this.options.activeField; }
			if (this.isFocused()){
				var range = this._textProvider.getFieldRange(index);
				if (range) {
					this.element.wijtextselection(range);
				}
			}
		},

		highLightCursor: function (pos) {
			if (this._isNullText()){
				return;
			}
		
			if (pos === undefined) {
				pos = Math.max(0, this.element.wijtextselection().start);
			}

			var index = this._textProvider.getCursorField(pos);
			if (index < 0) { return; }
			this._setOption('activeField', index);
		},

		toNextField: function () {
			this._setOption('activeField', this.options.activeField + 1);
		},

		toPrevField: function () {
			this._setOption('activeField', this.options.activeField - 1);
		},

		toFirstField: function () {
			this._setOption('activeField', 0);
		},

		toLastField: function () {
			this._setOption('activeField', this._textProvider.getFieldCount());
		},
		
		clearField: function (index) {
			if (index === undefined) { index = this.options.activeField; }
			var range = this._textProvider.getFieldRange(index);
			if (range) {
				var rh = new wijInputResult();
				this._textProvider.removeAt(range.start, range.end, rh);
				this._updateText();
				var self = this;
				window.setTimeout(function () {
					self.highLightField();
				}, 1);
			}
		},

		_doSpin: function (up, repeating) {
			up = !!up;
			repeating = !!repeating;

			if (!this._allowEdit()) { return; }
			if (repeating && this.element.data('breakSpinner')) { return; }

			if (this._textProvider[up ? 'incEnumPart' : 'decEnumPart']()) {
				this._updateText();
				this.highLightField();
			}

			if (repeating && !this.element.data('breakSpinner')) {
				window.setTimeout($.proxy(function () { this._doSpin(up, true); }, this), this._calcSpinInterval());
			}
		},

		_afterFocused: function () {
			if (this._isNullText()){
				this._doFocus();
				this.element.data('nullDate', false);
			}
		
			var self = this,
				hc = function(){
					self.highLightCursor();
					self._resetTimeStamp();
				};
				
			if ($.browser.msie) {
				hc();
			} else {
				window.setTimeout(hc);
			}
		},

		_keyDownPreview: function (e) {
			var key = e.keyCode || e.which;
			switch (key) {
				case $.ui.keyCode.LEFT:
					this.toPrevField();
					return true;
					break;

				case $.ui.keyCode.RIGHT:
					this.toNextField();
					return true;
					break;

				case $.ui.keyCode.TAB:
				case $.ui.keyCode.SPACE:
				case 188: // ,
				case 190: // .
				case 110: // . on pad
				case 191: // /
					if (e.shiftKey) {
						if (this.options.activeField > 0) {
							this.toPrevField();
							return true;
						}
					} else {
						if (this.options.activeField < this._textProvider.getFieldCount() - 1) {
							this.toNextField();
							return true;
						}
					}
					break;

				case $.ui.keyCode.HOME:
					if (e.ctrlKey) {
						this._setOption('date', new Date());
					} else {
						this.toFirstField();
					}
					return true;
					break;

				case $.ui.keyCode.END:
					if (e.ctrlKey) {
						this._setOption('date', new Date('1970/1/1'));
					} else {
						this.toLastField();
					}
					return true;
					break;

				case $.ui.keyCode.DELETE:
					this.clearField();
					return;
					break;
			}

			return false;
		},

		_autoMoveToNextField: function (pos) {
			if (!this.options.autoNextField) { return; }

			if (this._textProvider.needToMove(this.options.activeField, pos)) {
				this.toNextField();
			}
		},

		_keyPressPreview: function (e) {
			var range = this._textProvider.getFieldRange(this.options.activeField);
			if (range) {
				var key = e.keyCode || e.which;
				if (key === $.ui.keyCode.TAB){
					return true;
				}
				
				if (key === $.ui.keyCode.SPACE){
					this._stopEvent(e);
					return true;
				}
				
				var ch = String.fromCharCode(key);
				var fieldSep = this._textProvider.isFieldSep(ch, this.options.activeField);
				if (fieldSep) {
					this.toNextField();
					this._stopEvent(e);
					return true;
				}

				var cursor = this.element.data('cursorPos');
				var now = new Date(), lastTime = this.element.data('timeStamp');
				this.element.data('timeStamp', now);
				var newAction = (now.getTime() - lastTime.getTime()) > this.options.keyDelay;
				if (newAction) {
					cursor = 0;
				}

				var pos = range.start + cursor;
				this.element.data('cursorPos', ++cursor);

				var ret = this._textProvider.addToField(ch, this.options.activeField, pos, !newAction);
				if (ret) {
					this._updateText();
					this._autoMoveToNextField(cursor);
					this.highLightField();
				} else {
					this._fireIvalidInputEvent();
				}

				this._stopEvent(e);
				return true;
			}

			return false;
		},

		_raiseDataChanged: function () {
			var d = this.options.date;
			var prevDt = this.element.data('preDate');
			this.element.data('preDate', new Date(d.getTime()));
			if ((!prevDt && d) || (prevDt && !d) || ( prevDt && d && (prevDt.getTime() !== d.getTime()))) {
				this._syncCalendar();
				this.element.attr('aria-valuenow', d);
				this._trigger('dateChanged', null, { date: d });
			}
		},

		isDateNull: function () {
			/// <summary>Determines whether the date is a null value.</summary>
			return this.element.data('nullDate');
		},
		
		_isMinDate: function (date) {
			return date.getFullYear() === 1 && date.getMonth() === 0 && date.getDate() === 1;
		},

		_initCalendar: function () {
			var c = this.options.calendar;
			if (c === undefined || c === null) { return; }
			if (typeof (c) === 'boolean' || c === 'default') {
				c = $("<div/>");
				c.appendTo(document.body);
			}

			var calendar = $(c);
			if (calendar.length != 1) { return; }

			this.element.data('calendar', calendar);
			calendar.wijcalendar({ popupMode: true });
			this._syncCalendar();

			var self = this;
			calendar.bind('wijcalendarselecteddateschanged', function () {
				var selDate = $(this).wijcalendar("getSelectedDate");
				$(this).wijcalendar("close");
				if (!!selDate) { self.option('date', selDate); }
				self._trySetFocus();
			});
		},

		_syncCalendar: function () {
			var calendar = this.element.data('calendar');
			if (!calendar) { return; }

			var d = this.options.date;
			if (this._isMinDate(d)) { d = new Date(); }

			calendar.wijcalendar('option', 'displayDate', d);
			calendar.wijcalendar('unSelectAll');
			calendar.wijcalendar('selectDate', d);
			calendar.wijcalendar('refresh');
		},

		_popupOrHideCalendar: function () {
			if (!this._allowEdit()) { return; }

			var calendar = this.element.data('calendar');
			if (!calendar) { return; }

			if (calendar.wijcalendar('isPopupShowing')) {
				calendar.wijcalendar('hide');
				return;
			}

			this._syncCalendar();
			calendar.wijcalendar('popup', $.extend({}, this.options.popupPosition, { of: this.outerDiv }));
		}
	}));


	//============================

	var wijDateTextProvider = function (w, f) {
		this.inputWidget = w;
		this.descriptors = new Array(0);
		this.desPostions = new Array(0);
		this.fields = new Array(0);
		this._setFormat(f);
	};

	wijDateTextProvider.prototype = {
		descriptors: undefined,
		desPostions: undefined,
		maskPartsCount: 0,
		pattern: 'M/d/yyyy',

		initialize: function () { },

		getFieldCount: function () {
			return this.fields.length;
		},

		getFieldRange: function (index) {
			var desc = this.fields[index];
			return { start: desc.startIndex, end: desc.startIndex + desc.getText().length };
		},

		getCursorField: function (pos) {
			pos = Math.min(pos, this.desPostions.length - 1);
			pos = Math.max(pos, 0);
			var desc = this.desPostions[pos].desc;
			if (desc.type === -1) {
				var i = $.inArray(desc, this.descriptors);
				if (i > 0 && this.descriptors[i - 1].type != -1) {
					desc = this.descriptors[i - 1];
				} else {
					return -1; // liternal
				}
			}
			return $.inArray(desc, this.fields);
		},

		needToMove: function (index, pos) {
			var desc = this.fields[index];
			return pos === desc.maxLen;
		},

		_getCulture: function () {
			return this.inputWidget._getCulture();
		},
		
		_isDigitString: function (s) {
			s = s.trim();
			if (s.length ===  0) { return true; }
			
			var c = s.charAt(0);
			if (c === '+' || c === '-') {
				s = s.substr(1);
				s = s.trim();
			}
			if (s.length ===  0) { return true; }
			try {
				var f = parseFloat(s);
				var t = f.toString();
				return t === s;
			}
			catch (e) {
				return false;
			}
		},

		_setFormat: function (f) {
			this.descriptors = [];
			var curPattern = '';
			var prevCh = '';
			var isBegin = false;
			var liternalNext = false;
			this.pattern = this._parseFormatToPattern(f);
			for (var i = 0; i < this.pattern.length; i++) {
				var ch = this.pattern.charAt(i);
				if (liternalNext) {
					this.descriptors.push(this.createDescriptor(-1, ch));
					curPattern = '';
					liternalNext = false;
					continue;
				}
				if (ch === '\\') {
					liternalNext = true;
					if (curPattern.length > 0) {
						if (!this.handlePattern(curPattern)) {
							this.descriptors.push(this.createDescriptor(-1, prevCh));
						}
						curPattern = '';
					}
					continue;
				}
				if (ch === '\'') {
					if (isBegin) {
						isBegin = false;
						curPattern = '';
					} else {
						isBegin = true;
						if (curPattern.length > 0) {
							if (!this.handlePattern(curPattern)) {
								this.descriptors.push(this.createDescriptor(-1, prevCh));
							}
							curPattern = '';
						}

					}
					continue;
				}
				if (isBegin) {
					this.descriptors.push(this.createDescriptor(-1, ch));
					curPattern = '';
					continue;
				}
				if (!i) {
					prevCh = ch;
				}
				if (prevCh !== ch && curPattern.length > 0) {
					if (!this.handlePattern(curPattern)) {
						this.descriptors.push(this.createDescriptor(-1, prevCh));
					}
					curPattern = '';
				}
				curPattern += ch;
				prevCh = ch;
			}
			if (curPattern.length > 0) {
				if (!this.handlePattern(curPattern)) {
					this.descriptors.push(this.createDescriptor(-1, prevCh));
				}
			}

			this.fields = $.grep(this.descriptors, function (d) {
				return d.type !== -1;
			});
		},
		
		_parseFormatToPattern: function (f) {
			var cf = this.inputWidget._getCulture().calendars.standard;
			var pattern = cf.patterns.d;
			if (f.length <= 1) {
				switch (f) {
					case "":
					case "d": // ShortDatePattern
						pattern = cf.patterns.d;
						break;
					case "D": // LongDatePattern
						pattern = cf.patterns.D;
						break;
					case "f": // Full date and time (long date and short time)
						pattern = cf.patterns.D + " " + cf.patterns.t;
						break;
					case "F": // Full date and time (long date and long time)
						pattern = cf.patterns.D + " " + cf.patterns.T;
						break;
					case "g": // General (short date and short time)
						pattern = cf.patterns.d + " " + cf.patterns.t;
						break;
					case "G": // General (short date and long time)
						pattern = cf.patterns.d + " " + cf.patterns.T;
						break;
					case "m": // MonthDayPattern
						pattern = cf.patterns.M;
						break;
					case "M": // monthDayPattern
						pattern = cf.patterns.M;
						break;
					case "s": // SortableDateTimePattern
						pattern = cf.patterns.S;
						break;
					case "t": // shortTimePattern
						pattern = cf.patterns.t;
						break;
					case "T": // LongTimePattern
						pattern = cf.patterns.T;
						break;
					case "u": // UniversalSortableDateTimePattern
						pattern = cf.patterns.S;
						break;
					case "U": // Full date and time (long date and long time) using universal time
						pattern = cf.patterns.D + " " + cf.patterns.T;
						break;
					case "y": // YearMonthPattern
						pattern = cf.patterns.Y;
						break;
					case "Y": // yearMonthPattern
						pattern = cf.patterns.Y;
						break;
				}
			}else{
				pattern = f;
			}
			
			return pattern;
		},

		getDate: function () {
			return (!!this.inputWidget) ? this.inputWidget.options.date : undefined;
		},

		setDate: function (value) {
			if (this.inputWidget) {
				this.inputWidget._setData(value);
			}
		},

		_internalSetDate: function (date) {
			if (this.inputWidget) {
				this.inputWidget.options.date = date;
			}
		},

		daysInMonth: function (m, y) {
			m = m - 1;
			var d = new Date(y, ++m, 1, -1).getDate();
			return d;
		},

		setYear: function (val, allowChangeOtherParts, resultObj) {
			try {
				if (resultObj && resultObj.isfullreset) {
					resultObj.offset = 1;
					val = '1970';
				}
				if (val instanceof String) {
					if (!this._isDigitString(val)) {
						return false;
					}
				}
				val = val * 1;
				if (val < 0) {
					if (resultObj && resultObj.isreset) {
						val = 1;
					} else {
						return false;
					}
				}
				var currentDate = this.getDate();
				var testDate = new Date(currentDate.getTime());
				testDate.setFullYear(val);
				if (this._isValidDate(testDate)) {
					var mmm = this.daysInMonth(this.getMonth(), this.getYear());
					if (mmm === currentDate.getDate()) {
						testDate = new Date(currentDate.getTime());
						testDate.setDate(1);
						testDate.setFullYear(val);
						mmm = this.daysInMonth((testDate.getMonth() + 1), testDate.getFullYear());
						testDate.setDate(mmm);
						if (this._isValidDate(testDate)) {
							this._internalSetDate(testDate);
							return true;
						} else {
							return false;
						}
					}
					currentDate.setFullYear(val);
					this._internalSetDate(currentDate);
					return true;
				}
				else {
					if (resultObj && resultObj.isreset) {
						currentDate.setFullYear(1);
						this._internalSetDate(currentDate);
						return true;
					}
					return false;
				}
			}
			catch (e) {
				return false;
			}
		},

		getYear: function () {
			try {
				var year = this.getDate().getFullYear();
				year = '' + year + '';
				while (year.length < 4) {
					year = '0' + year;
				}
				return '' + year + '';
			}
			catch (e) {
				alert('getYear() failed');
			}
			return '';
		},

		setMonth: function (val, allowChangeOtherParts, resultObj) {
			try {
				if (resultObj && resultObj.isfullreset) {
					val = '1';
				}
				val = val * 1;
				var currentDate = this.getDate();
				if (typeof (allowChangeOtherParts) !== 'undefined' && !allowChangeOtherParts) {
					if (val > 12 || val < 1) {
						if (resultObj && resultObj.isreset) {
							val = 1;
						} else {
							return false;
						}
					}
				}
				var mmm = this.daysInMonth(this.getMonth(), this.getYear()), testDate;
				if (mmm === this.getDate().getDate()) {
					testDate = new Date(currentDate.getTime());
					testDate.setDate(1);
					testDate.setMonth(val - 1);
					mmm = this.daysInMonth((testDate.getMonth() + 1), testDate.getFullYear());
					testDate.setDate(mmm);
					if (this._isValidDate(testDate)) {
						this._internalSetDate(testDate);
						return true;
					} else {
						return false;
					}
				}
				else {
					testDate = new Date(currentDate.getTime());
					testDate.setMonth(val - 1);
					if (this._isValidDate(testDate)) {
						this._internalSetDate(testDate);
						return true;
					} else {
						return false;
					}
				}
			}
			catch (e) {
				return false;
			}
		},

		getMonth: function () {
			return (this.getDate().getMonth() + 1);
		},

		setDayOfMonth: function (val, allowChangeOtherParts, resultObj) {
			try {
				if (resultObj && resultObj.isfullreset) {
					return this.setDayOfMonth(1, allowChangeOtherParts);
				}
				var currentDate = this.getDate();
				val = val * 1;
				if (typeof (allowChangeOtherParts) !== 'undefined' && !allowChangeOtherParts) {
					var mmm = this.daysInMonth(this.getMonth(), this.getYear());
					if (val > mmm || val < 1) {
						if (resultObj && resultObj.isreset) {
							return this.setDayOfMonth(1, allowChangeOtherParts, resultObj);
						}
						return false;
					}
				}
				var testDate = new Date(currentDate.getTime());
				testDate.setDate(val);
				if (this._isValidDate(testDate)) {
					this._internalSetDate(testDate);
					return true;
				} else {
					return false;
				}
			}
			catch (e) {
				return false;
			}
		},

		getDayOfMonth: function () {
			return this.getDate().getDate();
		},

		setHours: function (val, allowChangeOtherParts) {
			try {
				val = val * 1;
				if (typeof (allowChangeOtherParts) !== 'undefined' && !allowChangeOtherParts) {
					if (val > 24) {
						return false;
					}
				}
				var testDate = new Date(this.getDate().getTime());
				testDate.setHours(val);
				if (this._isValidDate(testDate)) {
					this._internalSetDate(testDate);
					return true;
				} else {
					return false;
				}
			}
			catch (e) {
				return false;
			}
		},

		getHours: function () {
			return this.getDate().getHours();
		},

		setMinutes: function (val, allowChangeOtherParts) {
			try {
				val = val * 1;
				if (typeof (allowChangeOtherParts) !== 'undefined' && !allowChangeOtherParts) {
					if (val > 60) {
						return false;
					}
				}
				var testDate = new Date(this.getDate().getTime());
				testDate.setMinutes(val);
				if (this._isValidDate(testDate)) {
					this._internalSetDate(testDate);
					return true;
				} else {
					return false;
				}
			}
			catch (e) {
				return false;
			}
		},

		getMinutes: function () {
			return this.getDate().getMinutes();
		},

		setSeconds: function (val, allowChangeOtherParts) {
			try {
				val = val * 1;
				if (typeof (allowChangeOtherParts) !== 'undefined' && !allowChangeOtherParts) {
					if (val > 60) {
						return false;
					}
				}
				var testDate = new Date(this.getDate().getTime());
				testDate.setSeconds(val);
				if (this._isValidDate(testDate)) {
					this._internalSetDate(testDate);
					return true;
				} else {
					return false;
				}
			}
			catch (e) {
				return false;
			}
		},

		getSeconds: function () {
			return this.getDate().getSeconds();
		},

		setDayOfWeek: function (val) {
			try {
				val = val * 1;
				var aDif = val - this.getDayOfWeek() * 1;
				return this.setDayOfMonth(this.getDayOfMonth() * 1 + aDif * 1, true);
			}
			catch (e) {
				return false;
			}
		},

		getDayOfWeek: function () {
			return (this.getDate().getDay() + 1);
		},

		handlePattern: function (p) {
			var reg = new RegExp('y{3,4}');
			var suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(10));
				return true;
			}
			reg = new RegExp('y{2,2}');
			suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(2));
				return true;
			}
			reg = new RegExp('y{1,1}');
			suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(1));
				return true;
			}
			reg = new RegExp('d{4,4}');
			suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(101));
				return true;
			}
			reg = new RegExp('d{3,3}');
			suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(100));
				return true;
			}
			reg = new RegExp('d{2,2}');
			suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(30));
				return true;
			}
			reg = new RegExp('d{1,1}');
			suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(31));
				return true;
			}
			reg = new RegExp('M{4,4}');
			suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(27));
				return true;
			}
			reg = new RegExp('M{3,3}');
			suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(26));
				return true;
			}
			reg = new RegExp('M{2,2}');
			suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(20));
				return true;
			}
			reg = new RegExp('M{1,1}');
			suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(25));
				return true;
			}
			reg = new RegExp('h{2,2}');
			suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(46));
				return true;
			}
			reg = new RegExp('h{1,1}');
			suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(45));
				return true;
			}
			reg = new RegExp('H{2,2}');
			suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(48));
				return true;
			}
			reg = new RegExp('H{1,1}');
			suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(47));
				return true;
			}
			reg = new RegExp('m{2,2}');
			suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(50));
				return true;
			}
			reg = new RegExp('m{1,1}');
			suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(51));
				return true;
			}
			reg = new RegExp('s{2,2}');
			suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(60));
				return true;
			}
			reg = new RegExp('s{1,1}');
			suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(61));
				return true;
			}
			reg = new RegExp('t{2,2}');
			suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(251));
				return true;
			}
			reg = new RegExp('t{1,1}');
			suc = reg.test(p);
			if (suc) {
				this.descriptors.push(this.createDescriptor(250));
				return true;
			}
			return false;
		},

		createDescriptor: function (t, liternal) {
			var desc = null;
			var id = this.maskPartsCount++;
			switch (t) {
				case -1:
					desc = new _dateDescriptor(this, id);
					desc.liternal = liternal;
					break;
				case 20:
					desc = new _dateDescriptor20(this, id);
					break;
				case 25:
					desc = new _dateDescriptor25(this, id);
					break;
				case 26:
					desc = new _dateDescriptor26(this, id);
					break;
				case 27:
					desc = new _dateDescriptor27(this, id);
					break;
				case 30:
					desc = new _dateDescriptor30(this, id);
					break;
				case 31:
					desc = new _dateDescriptor31(this, id);
					break;
				case 100:
					desc = new _dateDescriptor100(this, id);
					break;
				case 101:
					desc = new _dateDescriptor101(this, id);
					break;
				case 10:
					desc = new _dateDescriptor10(this, id);
					break;
				case 1:
					desc = new _dateDescriptor1(this, id);
					break;
				case 2:
					desc = new _dateDescriptor2(this, id);
					break;
				case 45:
					desc = new _dateDescriptor45(this, id);
					break;
				case 46:
					desc = new _dateDescriptor46(this, id);
					break;
				case 47:
					desc = new _dateDescriptor47(this, id);
					break;
				case 48:
					desc = new _dateDescriptor48(this, id);
					break;
				case 250:
					desc = new _dateDescriptor250(this, id);
					break;
				case 251:
					desc = new _dateDescriptor251(this, id);
					break;
				case 50:
					desc = new _dateDescriptor50(this, id);
					break;
				case 51:
					desc = new _dateDescriptor51(this, id);
					break;
				case 60:
					desc = new _dateDescriptor60(this, id);
					break;
				case 61:
					desc = new _dateDescriptor61(this, id);
					break;
				default:
					break;
			}
			return desc;
		},

		toString: function () {
			if (this.inputWidget.options.showNullText && !this.inputWidget.isFocused() && this.inputWidget.isDateNull()) {
				return this.inputWidget.options.nullText;
			}
			var s = '', l = 0;
			this.desPostions = new Array(0);
			for (var i = 0; i < this.descriptors.length; i++) {
				this.descriptors[i].startIndex = s.length;
				var txt = '' || this.descriptors[i].getText();
				s += txt;
				for (var j = 0; j < txt.length; j++) {
					var dp = {};
					dp.desc = this.descriptors[i];
					dp.pos = j;
					dp.text = txt;
					dp.length = txt.length;
					this.desPostions.push(dp);
					l++;
					if (this.desPostions.length !== l) {
						throw 'Fatal Error !!!!!!!!!!!!!!!';
					}
				}
			}
			return s;
		},

		set: function (input, rh) {
			if (this.pattern === 'dddd' || this.pattern === 'ddd') {
				return false;
			}
			if (typeof input == 'object') {
				this._internalSetDate(new Date(input));
				return true;
			}

			var dt = this.getDateFromFormat(input, this.pattern);
			if (!dt) {
				dt = this._parseDate(input, this.pattern);
			}
			if (!!dt) {
				this._internalSetDate(new Date(dt));
				return true;
			}
			return false;
		},

		haveEnumParts: function () {
			return false;
		},

		removeLiterals: function (s) {
			s = '' + s + '';
			s = s.replace(new RegExp('\\s', 'g'), '');
			s = s.replace(new RegExp('[+]', 'g'), '');
			s = s.replace(new RegExp('[.]', 'g'), '');
			s = s.replace(new RegExp('[:]', 'g'), '');
			s = s.replace(new RegExp('[-]', 'g'), '');
			s = s.replace(new RegExp('[()=]', 'g'), '');
			return s;
		},

		getFirstDelimiterPos: function (aText, bText) {
			var i = 0;
			var j = 0;
			while (i < bText.length && j < aText.length) {
				var ch1 = bText.charAt(i);
				var ch2 = aText.charAt(j);
				if (ch1 === ch2) {
					j++;
				}
				else {
					return j - 1;
				}
				i++;
			}
			return aText.length - 1;
		},

		findAlikeArrayItemIndex: function (arr, txt) {
			var index = -1;
			var pos = 99999;
			for (var i = 0; i < arr.length; i++) {
				var k = arr[i].toLowerCase().indexOf(txt.toLowerCase());
				if (k !== -1 && k < pos) {
					pos = k;
					index = i;
				}
			}
			return index;
		},

		_isValidDate: function (dt) {
			if (dt === undefined) { return false; }
			if (isNaN(dt)) { return false; }
			if (dt.getFullYear() < 1 || dt.getFullYear() > 9999) { return false; }
			return true;
		},

		isFieldSep: function (input, activeField) {
			var nextField = activeField++;
			if (nextField < this.descriptors.length) {
				var desc = this.descriptors[nextField];
				if (desc.type != -1) { return false; }
				return (input === desc.text);
			}

			return false;
		},

		getPositionType: function (pos) {
			var desPos = this.desPostions[pos];
			return desPos.desc.type;
		},

		addToField: function (input, activeField, pos, append) {
			var desc = this.fields[activeField];
			if (desc.type == 10) {
				return this.insertAt(input, pos);
			}

			var txt = append ? desc.getText() + input : input;
			var resultObj = { val: input, pos: 0, offset: 0, isreset: false };
			return desc.setText(txt, ((input.length === 1) ? false : true), resultObj);
		},

		insertAt: function (input, position, rh) {
			if (!rh) { rh = new wijInputResult(); }

			rh.testPosition = -1;
			var desPos;
			if (input.length === 1) {
				desPos = this.desPostions[position];
				if (desPos && desPos.desc.type === -1) {
					if (desPos.text === input) {
						rh.testPosition = position;
						rh.hint = rh.characterEscaped;
						return true;
					}
				}
			}

			var oldTxt = input, pos = position;
			input = this.removeLiterals(input);
			var txt = input;
			var tryToExpandAtRight = false, tryToExpandAtLeft = false;
			if (pos > 0 && txt.length === 1) {
				pos--;
				position = pos;
				desPos = this.desPostions[pos];
				tryToExpandAtRight = true;
				if (desPos && (desPos.desc.type === -1 || desPos.desc.getText().length !== 1)) {
					position++;
					pos++;
					tryToExpandAtRight = false;
				}
			}
			var result = false, curInsertTxt, resultObj;
			while (txt.length > 0 && pos < this.desPostions.length) {
				desPos = this.desPostions[pos];
				if (desPos.desc.type === -1) {
					pos = pos + desPos.length;
					continue;
				}
				if (desPos.desc.needAdjustInsertPos()) {
					curInsertTxt = txt.substr(0, (desPos.length - desPos.pos));
					curInsertTxt = desPos.text.slice(0, desPos.pos) + curInsertTxt + desPos.text.slice(desPos.pos + curInsertTxt.length, desPos.length);
					if (tryToExpandAtRight) {
						curInsertTxt = desPos.text + curInsertTxt;
					}
					if (tryToExpandAtLeft) {
						curInsertTxt = curInsertTxt + desPos.text;
					}
					var prevTextLength = desPos.desc.getText().length;
					var alternativeInsertText = '';
					try {
						if (input.length === 1) {
							if (!desPos.pos) {
								alternativeInsertText = input;
							} else if (desPos.pos > 0) {
								alternativeInsertText = curInsertTxt.substring(0, desPos.pos + 1);
							}
						}
					}
					catch (e) {
					}
					if (prevTextLength === 1 && curInsertTxt.length > 1 && input.length === 1) {
						if (desPos.desc.type === 31 || desPos.desc.type === 25) {
							this._disableSmartInputMode = true;
						}
					}
					resultObj = { val: input, pos: desPos.pos, offset: 0, isreset: false };
					result = desPos.desc.setText(curInsertTxt, ((input.length === 1) ? false : true), resultObj);
					this._disableSmartInputMode = false;
					if (!result && typeof (alternativeInsertText) !== 'undefined' && alternativeInsertText.length > 0 && (desPos.desc.type === 26 || desPos.desc.type === 27 || desPos.desc.type === 100 || desPos.desc.type === 101 || desPos.desc.type === 250 || desPos.desc.type === 251)) {
						result = desPos.desc.setText(alternativeInsertText, ((input.length === 1) ? false : true), resultObj);
					}
					if (result) {
						rh.hint = rh.success;
						rh.testPosition = pos + resultObj.offset;
						if (input.length === 1) {
							var newTextLength = desPos.desc.getText().length;
							var posAdjustValue = desPos.pos;
							if (desPos.pos > (newTextLength - 1)) {
								posAdjustValue = newTextLength;
							}
							var diff = newTextLength - prevTextLength;
							if (diff > 0 && desPos.pos === prevTextLength - 1) {
								posAdjustValue = newTextLength - 1;
							}
							var s = this.toString();
							rh.testPosition = desPos.desc.startIndex + posAdjustValue + resultObj.offset;
						}
						txt = txt.slice(desPos.length - desPos.pos, txt.length);
					}
					else {
						rh.hint = rh.invalidInput;
						if (rh.testPosition !== -1) {
							rh.testPosition = position;
						}
						if (desPos.desc.type !== -1 && input.length === 1) {
							return false;
						}
					}
					pos = pos + desPos.length;
				} else {
					var delimOrEndPos = this.getFirstDelimiterPos(txt, oldTxt);
					if (delimOrEndPos < 0) {
						delimOrEndPos = 0;
					}
					curInsertTxt = txt.substring(0, delimOrEndPos + 1);
					resultObj = { val: input, pos: desPos.pos, offset: 0, isreset: false };
					result = desPos.desc.setText(curInsertTxt, ((input.length === 1) ? false : true), resultObj);
					if (result) {
						rh.hint = rh.success;
						rh.testPosition = pos + resultObj.offset;
						txt = txt.slice(delimOrEndPos + 1, txt.length);
					} else {
						rh.hint = rh.invalidInput;
						if (rh.testPosition !== -1) {
							rh.testPosition = position;
						}
					}
					if (delimOrEndPos < 0) {
						delimOrEndPos = 0;
					}
					var aDelta = delimOrEndPos + 1;
					pos = pos + aDelta;
				}
			}
			return result;
		},

		removeAt: function (start, end, rh) {
			try {
				var desPos = this.desPostions[start];
				if (desPos.desc.needAdjustInsertPos()) {
					var curInsertTxt = '0';
					var pos = start;
					desPos.text = desPos.desc.getText();
					curInsertTxt = desPos.text.slice(0, desPos.pos) + curInsertTxt + desPos.text.slice(desPos.pos + curInsertTxt.length, desPos.length);
					var resultObj = { val: curInsertTxt, pos: desPos.pos, offset: 0, isreset: true, isfullreset: false };
					if ((end - start + 1) >= desPos.length) {
						resultObj.isfullreset = true;
						start = start + desPos.length;
						pos = start;
					}
					var result = desPos.desc.setText(curInsertTxt, false, resultObj);
					if (result) {
						rh.hint = rh.success;
						rh.testPosition = pos;
					} else {
						rh.hint = rh.invalidInput;
						if (rh.testPosition === -1) {
							rh.testPosition = start;
						}
					}
				}
				if (start < end) {
					this.removeAt(start + 1, end, rh);
				}
				return true;
			}
			catch (e) {
				return false;
			}
		},

		incEnumPart: function () {
			var desc = this.fields[this.inputWidget.options.activeField];
			if (desc) {
				desc.inc();
			}
			return true;
		},

		decEnumPart: function (pos) {
			var desc = this.fields[this.inputWidget.options.activeField];
			if (desc) {
				desc.dec();
			}
			return true;
		},

		setValue: function (val) {
			this.setDate(new Date(val instanceof Date ? val.getTime() : val));
			return true;
		},

		getValue: function () {
			return this.getDate();
		},

		_disableSmartInputMode: false,

		_isSmartInputMode: function () {
			if (this._disableSmartInputMode) { return false; }
			if (this.inputWidget) { return this.inputWidget.options.smartInputMode; }
			return true;
		},

		_getInt: function (str, i, minlength, maxlength) {
			for (var x = maxlength; x >= minlength; x--) {
				var token = str.substring(i, i + x);
				if (token.length < minlength) {
					return null;
				}
				if ($.wij.charValidator.isDigit(token)) {
					return token;
				}
			}
			return null;
		},

		getDateFromFormat: function (val, format) {
			var cf = this._getCulture().calendars.standard;

			var monthNames = $.merge($.merge([], cf.months.names), cf.months.namesAbbr);
			var dayNames = $.merge($.merge([], cf.days.names), cf.days.namesShort);
			val = val + '';
			format = format + '';
			var i_val = 0, i_format = 0, c = '', token = '', x = 0, y = 0, i;
			var now = new Date(), year = now.getFullYear(), month = now.getMonth() + 1;
			var date = 1, hh = 0, mm = 0, ss = 0, ampm = '';
			var comment = false, escape = false;
			while (i_format < format.length) {
				c = format.charAt(i_format);
				token = '';
				while ((format.charAt(i_format) === c) && (i_format < format.length)) {
					token += format.charAt(i_format++);
					if (escape) {
						break;
					}
				}
				if (escape) {
					i_val += token.length;
					escape = false;
				} else if (token === '\\') {
					escape = true;
				} else if (token === '\'') {
					comment = !comment;
				} else if (comment) {
					i_val += token.length;
				} else if (token === 'yyyy' || token === 'yy' || token === 'y') {
					if (token === 'yyyy') {
						x = 4;
						y = 4;
					}
					if (token === 'yy') {
						x = 2;
						y = 2;
					}
					if (token === 'y') {
						x = 2;
						y = 4;
					}
					year = this._getInt(val, i_val, x, y);
					if (!year) {
						return 0;
					}
					i_val += (year).length;
					if ((year).length === 2) {
						if (year > 70) {
							year = 1900 + (year - 0);
						} else {
							year = 2000 + (year - 0);
						}
					}
				}
				else if (token === 'MMMM' || token === 'MMM' || token === 'NNN') {
					month = 0;
					for (i = 0; i < monthNames.length; i++) {
						var month_name = monthNames[i];
						if (val.substring(i_val, i_val + month_name.length).toLowerCase() === month_name.toLowerCase()) {
							if ((token === 'MMM' || token === 'MMMM') || (token === 'NNN' && i > 11)) {
								month = i + 1;
								if (month > 12) {
									month = month - 12;
								}
								i_val += month_name.length;
								break;
							}
						}
					}
					if ((month < 1) || (month > 12)) {
						return 0;
					}
				}
				else if (token === 'dddd' || token === 'ddd' || token === 'EE' || token === 'E') {
					for (i = 0; i < dayNames.length; i++) {
						var day_name = dayNames[i];
						if (val.substring(i_val, i_val + day_name.length).toLowerCase() === day_name.toLowerCase()) {
							i_val += day_name.length;
							break;
						}
					}
				}
				else if (token === 'MM' || token === 'M') {
					month = this._getInt(val, i_val, token.length, 2);
					if (!month || (month < 1) || (month > 12)) {
						return 0;
					}
					i_val += (month).length;
				}
				else if (token === 'dd' || token === 'd') {
					date = this._getInt(val, i_val, token.length, 2);
					if (!date || (date < 1) || (date > 31)) {
						return 0;
					}
					i_val += (date).length;
				}
				else if (token === 'hh' || token === 'h') {
					hh = this._getInt(val, i_val, token.length, 2);
					if (!hh || (hh < 1) || (hh > 12)) {
						return 0;
					}
					i_val += (hh).length;
				}
				else if (token === 'HH' || token === 'H') {
					hh = this._getInt(val, i_val, token.length, 2);
					if (!hh || (hh < 0) || (hh > 23)) {
						return 0;
					}
					i_val += (hh).length;
				}
				else if (token === 'KK' || token === 'K') {
					hh = this._getInt(val, i_val, token.length, 2);
					if (!hh || (hh < 0) || (hh > 11)) {
						return 0;
					}
					i_val += (hh).length;
				}
				else if (token === 'kk' || token === 'k') {
					hh = this._getInt(val, i_val, token.length, 2);
					if (!hh || (hh < 1) || (hh > 24)) {
						return 0;
					}
					i_val += (hh).length;
					hh = hh - 1;
				}
				else if (token === 'mm' || token === 'm') {
					mm = this._getInt(val, i_val, token.length, 2);
					if (!mm || (mm < 0) || (mm > 59)) {
						return 0;
					}
					i_val += (mm).length;
				}
				else if (token === 'ss' || token === 's') {
					ss = this._getInt(val, i_val, token.length, 2);
					if (!ss || (ss < 0) || (ss > 59)) {
						return 0;
					}
					i_val += (ss).length;
				}
				else if (token === 'tt' || token === 't' || token === 'a') {
					if (val.substring(i_val, i_val + 2).toLowerCase() === 'am') {
						ampm = 'AM';
						i_val += 2;
					}
					else if (val.substring(i_val, i_val + 2).toLowerCase() === 'pm') {
						ampm = 'PM';
						i_val += 2;
					}
					else if (val.substring(i_val, i_val + 1).toLowerCase() === 'a') {
						ampm = 'AM';
						i_val += 1;
					}
					else if (val.substring(i_val, i_val + 1).toLowerCase() === 'p') {
						ampm = 'PM';
						i_val += 1;
					}
					else if (val.substring(i_val, i_val + cf.AM[0].length).toLowerCase() === cf.AM[0].toLowerCase()) {
						ampm = 'AM';
						i_val += cf.AM[0].length;
					}
					else if (val.substring(i_val, i_val + cf.PM[0].length).toLowerCase() === cf.PM[0].toLowerCase()) {
						ampm = 'PM';
						i_val += cf.AM[0].length;
					}
					else if (val.substring(i_val, i_val + 1).toLowerCase() === ' ') {
						i_val += 1;
					}
				}
				else {
					var chch = val.substring(i_val, i_val + token.length);
					if (chch !== token) {
						return 0;
					} else {
						i_val += token.length;
					}
				}
			}
			if (i_val !== val.length) {
				return 0;
			}
			if (month === 2) {
				if (((!year % 4) && (year % 100)) || (!year % 400)) {
					if (date > 29) {
						return 0;
					}
				}
				else {
					if (date > 28) {
						return 0;
					}
				}
			}
			if ((month === 4) || (month === 6) || (month === 9) || (month === 11)) {
				if (date > 30) {
					return 0;
				}
			}
			if (hh < 12 && ampm === 'PM') {
				hh = hh - 0 + 12;
			}
			else if (hh > 11 && ampm === 'AM') {
				hh = hh - 12;
			}
			var newdate = new Date(year, month - 1, date, hh, mm, ss);
			newdate.setFullYear(year);
			return newdate.getTime();
		},

		_parseDate: function (val, pattern) {
			if (pattern) {
				if (pattern.indexOf('MMM') === -1 && pattern.indexOf('MMMM') === -1) {
					pattern = pattern.replace('MM', 'M');
				}
				pattern = pattern.replace('dd', 'd');
				pattern = pattern.replace('tt', 'a');
			}
			var preferEuro = false;
			window.generalFormats = [(!pattern) ? 'y/M/d' : pattern, 'y-M-d', 'MMM d, y', 'MMM d,y', 'y-MMM-d', 'd-MMM-y', 'MMM d'];
			window.monthFirst = ['M/d/y', 'M-d-y', 'M.d.y', 'MMM-d', 'M/d', 'M-d'];
			window.dateFirst = ['d/M/y', 'd-M-y', 'd.M.y', 'd-MMM', 'd/M', 'd-M'];
			var checkList = ['generalFormats', (preferEuro) ? 'dateFirst' : 'monthFirst', (preferEuro) ? 'monthFirst' : 'dateFirst'];
			var d;
			for (var i = 0; i < checkList.length; i++) {
				var l = (window)[checkList[i]];
				for (var j = 0; j < l.length; j++) {
					d = this.getDateFromFormat(val, l[j]);
					if (d) {
						return d;
					}
				}
			}
			return 0;
		},

		paddingZero: function (val, aCount) {
			var s = '' + val + '';
			while (s.length < aCount) {
				s = '0' + s;
			}
			return s;
		},

		_formatDate: function (d, f, ci) {
			if (!(d.valueOf())) {
				return '&nbsp;';
			}

			var self = this;
			var sRes = f.replace(new RegExp('yyyy|MMMM|MMM|MM|M|mm|m|dddd|ddd|dd|d|hh|h|HH|H|ss|s|tt|t|a/p', 'gi'), function (match) {
				var h;
				switch (match) {
					case 'yyyy':
						return d.getFullYear();
					case 'MMMM':
						return ci.dateTimeFormat.monthNames[d.getMonth()];
					case 'MMM':
						return ci.dateTimeFormat.abbreviatedMonthNames[d.getMonth()];
					case 'MM':
						return self.paddingZero((d.getMonth() + 1), 2);
					case 'M':
						return self.paddingZero((d.getMonth() + 1), 1);
					case 'mm':
						return self.paddingZero(d.getMinutes(), 2);
					case 'm':
						return self.paddingZero(d.getMinutes(), 1);
					case 'dddd':
						return ci.dateTimeFormat.dayNames[d.getDay()];
					case 'ddd':
						return ci.dateTimeFormat.abbreviatedDayNames[d.getDay()];
					case 'dd':
						return self.paddingZero(d.getDate(), 2);
					case 'd':
						return self.paddingZero(d.getDate(), 1);
					case 'hh':
						h = d.getHours() % 12;
						return self.paddingZero(((h) ? h : 12), 2);
					case 'h':
						h = d.getHours() % 12;
						return self.paddingZero(((h) ? h : 12), 1);
					case 'HH':
						return self.paddingZero(d.getHours(), 2);
					case 'H':
						return self.paddingZero(d.getHours(), 1);
					case 'ss':
						return self.paddingZero(d.getSeconds(), 2);
					case 's':
						return self.paddingZero(d.getSeconds(), 1);
					case 'tt':
						return (d.getHours() < 12) ? cf.AM[0] : cf.PM[0];
					case 't':
						return (d.getHours() < 12) ? ((cf.AM[0].length > 0) ? cf.AM[0].charAt(0) : '') : ((cf.PM[0].length > 0) ? cf.PM[0].charAt(0) : '');
					case 'a/p':
						return (d.getHours() < 12) ? 'a' : 'p';
				}
				return 'N';
			});
			return sRes;
		}
	};


	////////////////////////////////////////////////////////////////////////////////
	// _iDateDescriptor

	var _iDateDescriptor = function (tp, id, type, len) {
		this._txtProvider = tp;
		this.id = id;
		this.type = type;
		this.startIndex = 0;
		this.maxLen = len || 2;
	};

	_iDateDescriptor.prototype = {
		_txtProvider: null,
		id: 0,
		type: 0,
		name: null,
		startIndex: 0,
		maxLen: 2,

		getText: function () { return null; },
		setText: function (value, allowchangeotherpart, result) { return false; },
		inc: function () { },
		dec: function () { },
		needAdjustInsertPos: function () { return true; },
		reachMaxLen: function () {
			var t = this.getText();
			do {
				if (t.charAt(0) === '0') {
					t = t.slice(1);
				} else {
					break;
				}
			} while (t.length > 0);
			return t.length >= this.maxLen;
		}
	};

	var wijImplementInterface = function (target, interfaceType) {
		for (var name in interfaceType.prototype) {
			if (!target.prototype[name]) {
				target.prototype[name] = interfaceType.prototype[name];
			}
		}
	};


	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor

	var _dateDescriptor = function (owner, id) {
		wijImplementInterface(_dateDescriptor, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, -1, 100]);
	};

	_dateDescriptor.prototype = {
		liternal: '',

		getText: function () {
			return this.liternal;
		}
	};

	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor20

	var _dateDescriptor20 = function (owner, id) {
		wijImplementInterface(_dateDescriptor20, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 20]);
		this.name = 'Two-digit month';
	};

	_dateDescriptor20.prototype = {
		getText: function () {
			var m = '' + this._txtProvider.getMonth() + '';
			return m.length === 1 ? ('0' + m) : m;
		},

		setText: function (value, allowchangeotherpart, result) {
			return this._txtProvider.setMonth(value, allowchangeotherpart, result);
		},

		inc: function () {
			this._txtProvider.setMonth(this._txtProvider.getMonth() * 1 + 1, true);
		},

		dec: function () {
			this._txtProvider.setMonth(this._txtProvider.getMonth() * 1 - 1, true);
		}
	};

	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor25

	var _dateDescriptor25 = function (owner, id) {
		wijImplementInterface(_dateDescriptor25, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 25]);
		this.name = 'month';
	};

	_dateDescriptor25.prototype = {

		getText: function () {
			var m = '' + this._txtProvider.getMonth() + '';
			return m;
		},

		setText: function (value, allowchangeotherpart, result) {
			return this._txtProvider.setMonth(value, allowchangeotherpart, result);
		},

		inc: function () {
			this._txtProvider.setMonth(this._txtProvider.getMonth() * 1 + 1, true);
		},

		dec: function () {
			this._txtProvider.setMonth(this._txtProvider.getMonth() * 1 - 1, true);
		}
	};

	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor26

	var _dateDescriptor26 = function (owner, id) {
		wijImplementInterface(_dateDescriptor26, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 26, 100]);
		this.name = 'AbbreviatedMonthNames';
	};

	_dateDescriptor26.prototype = {

		getText: function () {
			var m = this._txtProvider.getMonth(), culture = this._txtProvider._getCulture();
			return culture.calendars.standard.months.namesAbbr[m - 1];
		},

		setText: function (value, allowchangeotherpart, result) {
			var m = -1;
			m = this._txtProvider.findAlikeArrayItemIndex(cf.months.namesAbbr, value);
			if (m === -1) {
				return false;
			}
			return this._txtProvider.setMonth(m + 1, allowchangeotherpart, result);
		},

		inc: function () {
			this._txtProvider.setMonth(this._txtProvider.getMonth() * 1 + 1, true);
		},

		dec: function () {
			this._txtProvider.setMonth(this._txtProvider.getMonth() * 1 - 1, true);
		}
	};

	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor27

	var _dateDescriptor27 = function (owner, id) {
		wijImplementInterface(_dateDescriptor27, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 27, 100]);
		this.name = 'MonthNames';
	};

	_dateDescriptor27.prototype = {

		getText: function () {
			var m = this._txtProvider.getMonth(), culture = this._txtProvider._getCulture();
			return culture.calendars.standard.months.names[m - 1];
		},

		setText: function (value, allowchangeotherpart, result) {
			var m = -1;
			if (result && result.isfullreset) {
				m = 1;
			}
			else {
				var culture = this._txtProvider._getCulture();
				m = this._txtProvider.findAlikeArrayItemIndex(culture.calendars.standard.months.names, value);
				if (m === -1) {
					return false;
				}
			}
			return this._txtProvider.setMonth(m + 1, allowchangeotherpart, result);
		},

		inc: function () {
			this._txtProvider.setMonth(this._txtProvider.getMonth() * 1 + 1, true);
		},

		dec: function () {
			this._txtProvider.setMonth(this._txtProvider.getMonth() * 1 - 1, true);
		}
	};

	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor30

	var _dateDescriptor30 = function (owner, id) {
		wijImplementInterface(_dateDescriptor30, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 30]);
		this.name = 'Two-digit day of month';
	};

	_dateDescriptor30.prototype = {

		getText: function () {
			var aDayOfMonth = this._txtProvider.getDayOfMonth();
			if (aDayOfMonth < 10) {
				aDayOfMonth = '0' + aDayOfMonth;
			}
			return '' + aDayOfMonth + '';
		},

		setText: function (value, allowchangeotherpart, result) {
			return this._txtProvider.setDayOfMonth(value, allowchangeotherpart, result);
		},

		inc: function () {
			this._txtProvider.setDayOfMonth(this._txtProvider.getDayOfMonth() * 1 + 1, true);
		},

		dec: function () {
			this._txtProvider.setDayOfMonth(this._txtProvider.getDayOfMonth() * 1 - 1, true);
		}
	};

	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor31

	var _dateDescriptor31 = function (owner, id) {
		wijImplementInterface(_dateDescriptor31, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 31]);
		this.name = 'Day of month';
	};

	_dateDescriptor31.prototype = {

		getText: function () {
			var aDayOfMonth = this._txtProvider.getDayOfMonth();
			return '' + aDayOfMonth + '';
		},

		setText: function (value, allowchangeotherpart, result) {
			return this._txtProvider.setDayOfMonth(value, allowchangeotherpart, result);
		},

		inc: function () {
			this._txtProvider.setDayOfMonth(this._txtProvider.getDayOfMonth() * 1 + 1, true);
		},

		dec: function () {
			this._txtProvider.setDayOfMonth(this._txtProvider.getDayOfMonth() * 1 - 1, true);
		}
	};

	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor100

	var _dateDescriptor100 = function (owner, id) {
		wijImplementInterface(_dateDescriptor100, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 100, 100]);
		this.name = 'AbbreviatedDayNames';
	};

	_dateDescriptor100.prototype = {

		getText: function () {
			var dw = this._txtProvider.getDayOfWeek(), culture = this._txtProvider._getCulture();
			return culture.calendars.standard.days.namesShort[dw - 1];
		},

		setText: function (value, allowchangeotherpart, result) {
			var dw = -1, culture = this._txtProvider._getCulture();
			dw = this._txtProvider.findAlikeArrayItemIndex(culture.calendars.standard.days.namesShort, value);
			if (dw === -1) {
				return false;
			}
			return this._txtProvider.setDayOfWeek(dw + 1);
		},

		inc: function () {
			this._txtProvider.setDayOfMonth(this._txtProvider.getDayOfMonth() * 1 + 1, true);
		},

		dec: function () {
			this._txtProvider.setDayOfMonth(this._txtProvider.getDayOfMonth() * 1 - 1, true);
		},

		needAdjustInsertPos: function () {
			return false;
		}
	};

	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor101

	var _dateDescriptor101 = function (owner, id) {
		wijImplementInterface(_dateDescriptor101, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 101, 100]);
		this.name = 'DayNames';
	};

	_dateDescriptor101.prototype = {

		getText: function () {
			var dw = this._txtProvider.getDayOfWeek(), culture = this._txtProvider._getCulture();
			return culture.calendars.standard.days.names[dw - 1];
		},

		setText: function (value, allowchangeotherpart, result) {
			var dw = -1, culture = this._txtProvider._getCulture();
			dw = this._txtProvider.findAlikeArrayItemIndex(culture.calendars.standard.days.names, value);
			if (dw === -1) {
				return false;
			}
			return this._txtProvider.setDayOfWeek(dw + 1);
		},

		inc: function () {
			this._txtProvider.setDayOfMonth(this._txtProvider.getDayOfMonth() * 1 + 1, true);
		},

		dec: function () {
			this._txtProvider.setDayOfMonth(this._txtProvider.getDayOfMonth() * 1 - 1, true);
		},

		needAdjustInsertPos: function () {
			return false;
		}
	};

	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor10

	var _dateDescriptor10 = function (owner, id) {
		wijImplementInterface(_dateDescriptor10, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 10, 4]);
		this.name = 'Four-digit year';
	};

	_dateDescriptor10.prototype = {
		getText: function () {
			return this._txtProvider.getYear();
		},

		setText: function (value, allowchangeotherpart, result) {
			if (this._txtProvider._isSmartInputMode() && result) {
				var startYear = 1900 + 100;
				if (this._txtProvider.inputWidget.options.startYear) {
					startYear = this._txtProvider.inputWidget.options.startYear;
				}
				var endYear = startYear + 100 - 1;
				startYear = this._txtProvider.paddingZero(startYear, 4);
				endYear = this._txtProvider.paddingZero(endYear, 4);
				if (result.pos === 0 || result.pos === 1) {
					var curDate = new Date();
					//var curYear = this._txtProvider.paddingZero(curDate.getFullYear(), 4);
					var thisYear = this._txtProvider.paddingZero(this._txtProvider.getYear(), 4);
					if (thisYear.charAt(0) === '0' && thisYear.charAt(1) === '0' && result.pos <= 1) {
						var inputNum = result.val * 1;
						var century = '00';
						if (inputNum >= 5) {
							century = startYear.slice(0, 2);
						}
						else {
							century = endYear.slice(0, 2);
						}
						var addYear = result.val + thisYear.slice(3, 4);
						var s = century + addYear;
						result.offset = 2 - result.pos;
						this._txtProvider.setYear(s, allowchangeotherpart, result);
						return true;
					}
				}
			}
			return this._txtProvider.setYear(value, allowchangeotherpart, result);
		},

		inc: function () {
			this._txtProvider.setYear(this._txtProvider.getYear() * 1 + 1, true);
		},

		dec: function () {
			this._txtProvider.setYear(this._txtProvider.getYear() * 1 - 1, true);
		}
	};


	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor1

	var _dateDescriptor1 = function (owner, id) {
		wijImplementInterface(_dateDescriptor1, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 1]);
		this.name = 'One-digit year';
	};

	_dateDescriptor1.prototype = {

		getText: function () {
			var y = this._txtProvider.getYear();
			y = '' + y + '';
			if (y.length === 4) {
				y = y.charAt(2) + y.charAt(3);
			}
			if (y.charAt(0) === '0') {
				y = y.charAt(1);
			}
			return y;
		},

		setText: function (value, allowchangeotherpart, result) {
			value = value + '';
			while (value.length < 2) {
				value = '0' + value;
			}
			var y = this._txtProvider.getYear();
			y = '' + y + '';
			if (value === '00') {
				var m = this._txtProvider.getMonth();
				var aDayOfMonth = this._txtProvider.getDayOfMonth();
				var h = this._txtProvider.getHours();
				var min = this._txtProvider.getMinutes();
				var s = this._txtProvider.getSeconds();
				if (m === 1 && aDayOfMonth === 1 && !h && !min && !s) {
					y = '0001';
					value = '01';
				}
			}
			if (y.length >= 2) {
				y = y.charAt(0) + y.charAt(1) + value.charAt(0) + value.charAt(1);
			}
			return this._txtProvider.setYear(y, allowchangeotherpart, result);
		},

		inc: function () {
			this._txtProvider.setYear(this._txtProvider.getYear() * 1 + 1, true);
		},

		dec: function () {
			this._txtProvider.setYear(this._txtProvider.getYear() * 1 - 1, true);
		}
	};

	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor2

	var _dateDescriptor2 = function (owner, id) {
		wijImplementInterface(_dateDescriptor2, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 2]);
		this.name = 'Two-digit year';
	};

	_dateDescriptor2.prototype = {

		getText: function () {
			var y = this._txtProvider.getYear();
			y = '' + y + '';
			if (y.length === 4) {
				y = y.charAt(2) + y.charAt(3);
			}
			return y;
		},

		setText: function (value, allowchangeotherpart, result) {
			value = value + '';
			while (value.length < 2) {
				value = '0' + value;
			}
			var y = this._txtProvider.getYear();
			y = '' + y + '';
			if (value === '00') {
				var m = this._txtProvider.getMonth();
				var aDayOfMonth = this._txtProvider.getDayOfMonth();
				var h = this._txtProvider.getHours();
				var min = this._txtProvider.getMinutes();
				var s = this._txtProvider.getSeconds();
				if (m === 1 && aDayOfMonth === 1 && !h && !min && !s) {
					y = '0001';
					value = '01';
				}
			}
			if (y.length >= 2) {
				y = y.charAt(0) + y.charAt(1) + value.charAt(0) + value.charAt(1);
			}
			var aRes = this._txtProvider.setYear(y, allowchangeotherpart, result);
			return aRes;
		},

		inc: function () {
			this._txtProvider.setYear(this._txtProvider.getYear() * 1 + 1, true);
		},

		dec: function () {
			this._txtProvider.setYear(this._txtProvider.getYear() * 1 - 1, true);
		}
	};

	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor45

	var _dateDescriptor45 = function (owner, id) {
		wijImplementInterface(_dateDescriptor45, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 45]);
		this.name = 'h';
	};

	_dateDescriptor45.prototype = {

		getText: function () {
			var h = this._txtProvider.getHours();
			if (h > 12) {
				h = h - 12;
			}
			if (!h) {
				h = 12;
			}
			return '' + h + '';
		},

		setText: function (value, allowchangeotherpart, result) {
			var h = this._txtProvider.getHours();
			if (h > 12) {
				value = ((value * 1) + 12);
			}
			return this._txtProvider.setHours(value, allowchangeotherpart);
		},

		inc: function () {
			this._txtProvider.setHours(this._txtProvider.getHours() * 1 + 1, true);
		},

		dec: function () {
			this._txtProvider.setHours(this._txtProvider.getHours() * 1 - 1, true);
		}
	};

	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor46

	var _dateDescriptor46 = function (owner, id) {
		wijImplementInterface(_dateDescriptor46, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 46]);
		this.name = 'hh';
	};

	_dateDescriptor46.prototype = {

		getText: function () {
			var h = this._txtProvider.getHours();
			if (h > 12) {
				h = h - 12;
			}
			if (!h) {
				h = 12;
			}
			if (h < 10) {
				h = '0' + h;
			}
			return '' + h + '';
		},

		setText: function (value, allowchangeotherpart, result) {
			var h = this._txtProvider.getHours();
			if (h > 12) {
				value = ((value * 1) + 12);
			}
			return this._txtProvider.setHours(value, allowchangeotherpart);
		},

		inc: function () {
			this._txtProvider.setHours(this._txtProvider.getHours() * 1 + 1, true);
		},

		dec: function () {
			this._txtProvider.setHours(this._txtProvider.getHours() * 1 - 1, true);
		}
	};

	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor47

	var _dateDescriptor47 = function (owner, id) {
		wijImplementInterface(_dateDescriptor47, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 47]);
		this.name = 'H';
	};

	_dateDescriptor47.prototype = {

		getText: function () {
			var h = this._txtProvider.getHours();
			return '' + h + '';
		},

		setText: function (value, allowchangeotherpart, result) {
			return this._txtProvider.setHours(value, allowchangeotherpart);
		},

		inc: function () {
			this._txtProvider.setHours(this._txtProvider.getHours() * 1 + 1, true);
		},

		dec: function () {
			this._txtProvider.setHours(this._txtProvider.getHours() * 1 - 1, true);
		}
	};

	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor48

	var _dateDescriptor48 = function (owner, id) {
		wijImplementInterface(_dateDescriptor48, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 48]);
		this.name = 'HH';
	};

	_dateDescriptor48.prototype = {

		getText: function () {
			var h = this._txtProvider.getHours();
			if (h < 10) {
				h = '0' + h;
			}
			return '' + h + '';
		},

		setText: function (value, allowchangeotherpart, result) {
			return this._txtProvider.setHours(value, allowchangeotherpart);
		},

		inc: function () {
			this._txtProvider.setHours(this._txtProvider.getHours() * 1 + 1, true);
		},

		dec: function () {
			this._txtProvider.setHours(this._txtProvider.getHours() * 1 - 1, true);
		}
	};

	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor250

	var _dateDescriptor250 = function (owner, id) {
		wijImplementInterface(_dateDescriptor250, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 250]);
		this.name = 't';
	};

	_dateDescriptor250.prototype = {

		getText: function () {
			var h = this._txtProvider.getHours(), ds = '', culture = this._txtProvider._getCulture();
			if (h < 12) {
				ds = culture.calendars.standard.AM[0];
			}
			else {
				ds = culture.calendars.standard.PM[0];
			}
			if (ds.length <= 0) {
				ds = ' ';
			}
			return ds.charAt(0);
		},

		setText: function (value, allowchangeotherpart, result) {
			return true;
		},

		inc: function () {
			this._txtProvider.setHours(this._txtProvider.getHours() * 1 + 12, true);
		},

		dec: function () {
			this._txtProvider.setHours(this._txtProvider.getHours() * 1 - 12, true);
		}
	};

	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor251

	var _dateDescriptor251 = function (owner, id) {
		wijImplementInterface(_dateDescriptor251, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 251]);
		this.name = 'tt';
	};

	_dateDescriptor251.prototype = {

		getText: function () {
			var h = this._txtProvider.getHours(), ds = '', culture = this._txtProvider._getCulture();
			if (h < 12) {
				ds = culture.calendars.standard.AM[0];
			}
			else {
				ds = culture.calendars.standard.PM[0];
			}
			if (ds.length <= 0) {
				ds = ' ';
			}
			return ds;
		},

		setText: function (value, allowchangeotherpart, result) {
			return true;
		},

		inc: function () {
			this._txtProvider.setHours(this._txtProvider.getHours() * 1 + 12, true);
		},

		dec: function () {
			this._txtProvider.setHours(this._txtProvider.getHours() * 1 - 12, true);
		}
	};


	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor50

	var _dateDescriptor50 = function (owner, id) {
		wijImplementInterface(_dateDescriptor50, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 50]);
		this.name = 'mm';
	};

	_dateDescriptor50.prototype = {

		getText: function () {
			var min = this._txtProvider.getMinutes();
			if (min < 10) {
				min = '0' + min;
			}
			return '' + min + '';
		},

		setText: function (value, allowchangeotherpart, result) {
			return this._txtProvider.setMinutes(value, allowchangeotherpart);
		},

		inc: function () {
			this._txtProvider.setMinutes(this._txtProvider.getMinutes() * 1 + 1, true);
		},

		dec: function () {
			this._txtProvider.setMinutes(this._txtProvider.getMinutes() * 1 - 1, true);
		}
	};

	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor51

	var _dateDescriptor51 = function (owner, id) {
		wijImplementInterface(_dateDescriptor51, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 51]);
		this.name = 'm';
	};

	_dateDescriptor51.prototype = {

		getText: function () {
			var min = this._txtProvider.getMinutes();
			return '' + min + '';
		},

		setText: function (value, allowchangeotherpart, result) {
			return this._txtProvider.setMinutes(value, allowchangeotherpart);
		},

		inc: function () {
			this._txtProvider.setMinutes(this._txtProvider.getMinutes() * 1 + 12, true);
		},

		dec: function () {
			this._txtProvider.setMinutes(this._txtProvider.getMinutes() * 1 - 12, true);
		}
	};

	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor60

	var _dateDescriptor60 = function (owner, id) {
		wijImplementInterface(_dateDescriptor60, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 60]);
		this.name = 'ss';
	};

	_dateDescriptor60.prototype = {

		getText: function () {
			var s = this._txtProvider.getSeconds();
			if (s < 10) {
				s = '0' + s;
			}
			return '' + s + '';
		},

		setText: function (value, allowchangeotherpart, result) {
			return this._txtProvider.setSeconds(value, allowchangeotherpart);
		},

		inc: function () {
			this._txtProvider.setSeconds(this._txtProvider.getSeconds() * 1 + 12, true);
		},

		dec: function () {
			this._txtProvider.setSeconds(this._txtProvider.getSeconds() * 1 - 12, true);
		}
	};

	////////////////////////////////////////////////////////////////////////////////
	// _dateDescriptor61

	var _dateDescriptor61 = function (owner, id) {
		wijImplementInterface(_dateDescriptor61, _iDateDescriptor);
		_iDateDescriptor.apply(this, [owner, id, 61]);
		this.name = 's';
	};

	_dateDescriptor61.prototype = {

		getText: function () {
			var s = this._txtProvider.getSeconds();
			return '' + s + '';
		},

		setText: function (value, allowchangeotherpart, result) {
			return this._txtProvider.setSeconds(value, allowchangeotherpart);
		},

		inc: function () {
			this._txtProvider.setSeconds(this._txtProvider.getSeconds() * 1 + 12, true);
		},

		dec: function () {
			this._txtProvider.setSeconds(this._txtProvider.getSeconds() * 1 - 12, true);
		}
	};

})(jQuery);

/*
 *
 * Wijmo Library 1.4.0
 * http://wijmo.com/
 *
 * Copyright(c) ComponentOne, LLC.  All rights reserved.
 * 
 * Dual licensed under the Wijmo Commercial or GNU GPL Version 3 licenses.
 * licensing@wijmo.com
 * http://wijmo.com/license
 *
 *
 * * Wijmo Inputmask widget.
 *
 * Depends:
 *	jquery-1.4.2.js
 *	jquery.ui.core.js
 *	jquery.ui.widget.js
 *	jquery.ui.position.js
 *	jquery.effects.core.js	
 *	jquery.effects.blind.js
 *	jquery.glob.js
 *	jquery.plugin.wijtextselection.js
 *	jquery.wijmo.wijpopup.js
 *	jquery.wijmo.wijinputcore.js
 *
 */
 (function ($) {
"use strict";
var wijchartype = {
	editOptional: 1,
	editRequired: 2,
	separator: 4,
	literal: 8
};

$.widget("wijmo.wijinputmask", $.extend(true, {}, wijinputcore, {
	options: {
		///	<summary>
		///		Determines the default text.
		///	</summary>
		text: null,
		///	<summary>
		///		Determines the input mask to use at run time. 
		///		Mask must be a string composed of one or more of the masking elements.
		///	</summary>
		mask: "",
		///	<summary>
		///		Determines the character used to represent the absence of user input.
		///	</summary>
		promptChar: '_',
		///	<summary>
		///		Indicates whether the prompt characters in the input mask are hidden when the input loses focus.
		///	</summary>
		hidePromptOnLeave: false,
		///	<summary>
		///		Determines how an input character that matches the prompt character should be handled.
		///	</summary>
		resetOnPrompt: true,
		///	<summary>
		///		Indicates whether promptChar can be entered as valid data by the user.
		///	</summary>
		allowPromptAsInput: false,
		///	<summary>
		///		Determines the character to be substituted for the actual input characters.
		///	</summary>
		passwordChar: '',
		///	<summary>
		///		Determines how a space input character should be handled.
		///	</summary>
		resetOnSpace: true,
		///	<summary>
		///		Indicates whether the user is allowed to re-enter literal values.
		///	</summary>
		skipLiterals: true
	},
	
	_createTextProvider: function(){
		this._textProvider = new wijMaskedTextProvider(this, this.options.mask, false);
	},
	
	_beginUpdate: function(){
		this.element.addClass('wijmo-wijinput-mask');
		this.element.data('isPassword', (this.options.passwordChar.length > 0) && (this.element.attr('type') !== 'password'));
		this.element.data('defaultText', this.options.text);
	},
	
	_onTriggerClicked: function(){
		this._popupComboList();
	},

	_setOption: function (key, value) {
		$.Widget.prototype._setOption.apply(this, arguments);
		wijinputcore._setOption.apply(this, arguments);

		switch (key) {
			case 'text':
				this.setText(value);
				break;

			case 'mask':
			case 'culture':
				if (typeof (value) === 'undefined' || value.length <= 0) { return; }
				var text = this.getText();
				this._textProvider.mask = value;
				this._textProvider.initialMask = value;
				this._textProvider.initialize();
				this._textProvider.set(text);
				this._updateText();
				break;
			case 'promptChar':
				if (!!this._textProvider) {
					this._textProvider.updatePromptChar();
					this._updateText();
				}
				break;
			case 'hidePromptOnLeave':
			case 'resetOnPrompt':
				this._updateText();
				break;
			case 'passwordChar':
				this.element.data('isPassword', ((value + '').length > 0));
				this._updateText();
				break;
		}
	},
	
	_resetData: function () {
		var o = this.options;
		var txt = this.element.data('defaultText');
		if (txt === undefined || txt === null){
			txt = this.element.data('elementValue');
		}
		
		if (txt === undefined || txt === null){
			txt = "";
		}
		
		this.setText(txt);
	},
	
	_isPassword: function () {
		return !!this.element.data('isPassword');
	},
	
	_getTextWithPrompts: function () {
		return !this._isInitialized() ? this.element.val() : this._textProvider.toString(true, true, false);
	},

	_getTextWithLiterals: function () {
		return !this._isInitialized() ? this.element.val() : this._textProvider.toString(true, false, true);
	},

	_getTextWithPromptAndLiterals: function () {
		return !this._isInitialized() ? this.element.val() : this._textProvider.toString(true, true, true);
	},
	
	_onChange: function (e) {
		if (!this.element) { return; }

		var val = this.element.val();
		var txt = this.getText();
		if (txt !== val) {
			txt = this._getTextWithPrompts();
			if (txt !== val) {
				txt = this._getTextWithPromptAndLiterals();
				if (txt !== val) {
					this.setText(val);
				}
			}
		}
	},
	
	_afterFocused: function () {
		if (this._isNullText() || !!this.options.hidePromptOnLeave) {
			this._doFocus();
		}
	}
}));



var wijMaskedTextProvider = function (w, m, asciiOnly) {
	this.inputWidget = w;
	this.mask = m;
	this.asciiOnly = asciiOnly;
	this.descriptors = [];
	this.noMask = false;
	this.initialize();
};

wijMaskedTextProvider.prototype = {
	inputWidget: undefined,
	noMask: false,
	mask: '',
	testString: '',
	assignedCharCount: 0,
	requiredCharCount: 0,
	asciiOnly: false,
	
	initialize: function () {
		this.noMask = (!this.mask || this.mask.length <= 0);
		if (this.noMask) { return; }

		this.testString = '';
		this.assignedCharCount = 0;
		this.requiredCharCount = 0;
		this.descriptors = new Array(0);
		var caseType = 'none', escape = false, index = 0, charType = wijchartype.literal, text = '';
		var culture = this.inputWidget._getCulture();
		for (var i = 0; i < this.mask.length; i++) {
			var needDesc = false;
			var ch = this.mask.charAt(i);
			if (escape) {
				escape = false;
				needDesc = true;
			}
			if (!needDesc) {
				var ch3 = ch;
				if (ch3 <= 'C') {
					switch (ch3) {
						case '#':
						case '9':
						case '?':
						case 'C':
							ch = this.getPromtChar();
							charType = wijchartype.editOptional;
							needDesc = true;
							break;
						case '$':
							text = culture.numberFormat.currency.symbol;
							charType = wijchartype.separator;
							needDesc = true;
							break;
						case '%':
						case '-':
						case ';':
						case '=':
						case '@':
						case 'B':
							charType = wijchartype.literal;
							needDesc = true;
							break;
						case '&':
						case '0':
						case 'A':
							ch = this.getPromtChar();
							charType = wijchartype.editRequired;
							needDesc = true;
							break;
						case ',':
							text = culture.numberFormat[','];
							charType = wijchartype.separator;
							needDesc = true;
							break;
						case '.':
							text = culture.numberFormat['.'];
							charType = wijchartype.separator;
							needDesc = true;
							break;
						case '/':
							text = culture.calendars.standard['/'];
							charType = wijchartype.separator;
							needDesc = true;
							break;
						case ':':
							text = culture.calendars.standard[':'];
							charType = wijchartype.separator;
							needDesc = true;
							break;
						case '<':
							caseType = 'lower';
							continue;
						case '>':
							caseType = 'upper';
							continue;
					}
					if (!needDesc) {
						charType = wijchartype.literal;
						needDesc = true;
					}
				}
				if (!needDesc) {
					if (ch3 <= '\\') {
						switch (ch3) {
							case 'L':
								ch = this.getPromtChar();
								charType = wijchartype.editRequired;
								needDesc = true;
								break;
							case '\\':
								escape = true;
								charType = wijchartype.literal;
								continue;
						}
						if (!needDesc) {
							charType = wijchartype.literal;
							needDesc = true;
						}
					}
					if (!needDesc) {
						if (ch3 === 'a') {
							ch = this.getPromtChar();
							charType = wijchartype.editOptional;
							needDesc = true;
						}
						if (!needDesc) {
							if (ch3 !== '|') {
								charType = wijchartype.literal;
								needDesc = true;
							}
							if (!needDesc) {
								caseType = 'none';
								continue;
							}
						}
					}
				}
			}
			if (needDesc) {
				var cd = new wijCharDescriptor(i, charType);
				if (this.isEditDesc(cd)) {
					cd.caseConversion = caseType;
				}
				if (charType !== wijchartype.separator) {
					text = ch;
				}
				for (var j = 0; j < text.length; j++) {
					var ch2 = text.charAt(j);
					this.testString = this.testString + ch2;
					this.descriptors[this.descriptors.length] = cd;
					index++;
				}
			}
		}
		this.testString.Capacity = this.testString.length;
	},

	getAllowPromptAsInput: function () {
		return !!this.inputWidget ? this.inputWidget.options.allowPromptAsInput : false;
	},

	getPasswordChar: function () {
		return !!this.inputWidget ? this.inputWidget.options.passwordChar : '*';
	},

	isPassword: function () {
		return !!this.inputWidget ? this.inputWidget._isPassword() : false;
	},

	getResetOnPrompt: function () {
		return !!this.inputWidget ? this.inputWidget.options.resetOnPrompt : true;
	},

	getResetOnSpace: function () {
		return !!this.inputWidget ? this.inputWidget.options.resetOnSpace : true;
	},

	getSkipLiterals: function () {
		return !!this.inputWidget ? this.inputWidget.options.skipLiterals : true;
	},
	
	getHidePromptOnLeave: function () {
		return !!this.inputWidget ? this.inputWidget.options.hidePromptOnLeave : false;
	},
	
	_trueOR: function (n1, n2) {
		return ((n1 >>> 1 | n2 >>> 1) * 2 + (n1 & 1 | n2 & 1));
	},

	setValue: function (val) {
		return false;
	},

	getValue: function () {
		return null;
	},
	
	getPromtChar: function () {
		return !!this.inputWidget ? this.inputWidget.options.promptChar : '_';
	},

	updatePromptChar: function () {
		if (this.noMask) { return; }

		for (var i = 0; i < this.descriptors.length; i++) {
			var cd = this.descriptors[i];
			if (cd.charType === wijchartype.editOptional || cd.charType === wijchartype.editRequired) {
				if (!cd.isAssigned) {
					this.testString = $.wij.charValidator.setChar(this.testString, this.getPromtChar(), i);
				}
			}
		}
	},

	resetChar: function (pos) {
		var cd = this.descriptors[pos];
		if (this.isEditPos(pos) && cd.isAssigned) {
			cd.isAssigned = false;
			this.testString = $.wij.charValidator.setChar(this.testString, this.getPromtChar(), pos);
			this.assignedCharCount--;
			if (cd.charType === wijchartype.editRequired) {
				this.requiredCharCount--;
			}
		}
	},

	getAdjustedPos: function (pos) {
		if (this.noMask) {
			if (pos >= this.testString.length) {
				pos = this.testString.length - 1;
			}
		}
		else {
			if (pos >= this.descriptors.length) {
				pos = pos - 1;
			}
		}
		
		return Math.max(0, pos);
	},

	incEnumPart: function (pos, rh, step) {
		return !this.noMask;
	},

	decEnumPart: function (pos, rh, step) {
		return !this.noMask;
	},

	findNonEditPositionInRange: function (start, end, direction) {
		return this.findPositionInRange(start, end, direction, this._trueOR(wijchartype.literal, wijchartype.separator));
	},

	findPositionInRange: function (start, end, direction, charType) {
		start = Math.max(0, start);
		end = Math.min(end, this.testString.length - 1);
		
		if (start <= end) {
			while (start <= end) {
				var pos = (direction) ? start++ : end--;
				var cd = this.descriptors[pos];
				if (((cd.charType & 4294967295) & (charType & 4294967295)) === cd.charType) {
					return pos;
				}
			}
		}
		return -1;
	},

	findAssignedEditPositionInRange: function (start, end, direction) {
		if (this.assignedCharCount === 0) { return -1; }
		return this.findEditPositionInRange(start, end, direction, wijchartype.editRequired);
	},

	findEditPositionInRange: function (start, end, direction, assignedStatus) {
		do {
			var pos = this.findPositionInRange(start, end, direction, this._trueOR(wijchartype.editRequired, wijchartype.editOptional));
			if (pos === -1) {
				break;
			}
			
			var cd = this.descriptors[pos];
			switch (assignedStatus) {
				case wijchartype.editOptional:
					if (!cd.isAssigned) {
						return pos;
					}
					break;
				case wijchartype.editRequired:
					if (cd.isAssigned) {
						return pos;
					}
					break;
				default:
					return pos;
			}
			if (direction){
				start++;
			}else{
				end--;
			}
		} while (start <= end);
		
		return -1;
	},

	findAssignedEditPositionFrom: function (pos, direction) {
		if (!this.assignedCharCount) { return -1; }
		
		var start, end;
		if (direction) {
			start = pos;
			end = this.testString.length - 1;
		}else{
			start = 0;
			end = pos;
		}
		return this.findAssignedEditPositionInRange(start, end, direction);
	},

	findEditPositionFrom: function (pos, direction) {
		var start, end;
		if (direction) {
			start = pos;
			end = this.testString.length - 1;
		}
		else {
			start = 0;
			end = pos;
		}
		return this.findEditPositionInRange(start, end, direction, 0);
	},
	
	setChar: function (input, pos, desc) {
		pos = pos < 0 ? 0 : pos;
		if (!desc) {
			desc = this.descriptors[pos];
		}
		if (this.testEscapeChar(input, pos, desc)) {
			this.resetChar(pos);
		}else{
			if ($.wij.charValidator.isLetter(input)) {
				if ($.wij.charValidator.isUpper(input)) {
					if (desc.caseConversion === 'lower') {
						input = input.toLowerCase();
					}
				}
				else if (desc.caseConversion === 'upper') {
					input = input.toUpperCase();
				}
			}
			this.testString = $.wij.charValidator.setChar(this.testString, input, pos);
			if (!desc.isAssigned) {
				desc.isAssigned = true;
				this.assignedCharCount++;
				if (desc.charType === wijchartype.editRequired) {
					this.requiredCharCount++;
				}
			}
		}
	},

	internalInsertAt: function (input, pos, rh, testOnly) {
		if (input.length === 0) {
			rh.testPosition = pos;
			rh.hint = rh.noEffect;
			return true;
		}
		if (!this._testString(input, pos, rh)) {
			return false;
		}
		var num1 = this.findEditPositionFrom(pos, true);
		var flag1 = this.findAssignedEditPositionInRange(num1, rh.testPosition, true) !== -1;
		var num2 = this.findAssignedEditPositionFrom(this.testString.length - 1, false);
		if (flag1 && (rh.testPosition === (this.testString.length - 1))) {
			rh.hint = rh.unavailableEditPosition;
			rh.testPosition = this.testString.length;
			return false;
		}
		var num3 = this.findEditPositionFrom(rh.testPosition + 1, true);
		if (flag1) {
			var hint1 = new wijInputResult();
			hint1.hint = hint1.unknown;
			var repeat = true;
			while (repeat) {
				repeat = false;
				if (num3 === -1) {
					rh.hint = rh.unavailableEditPosition;
					rh.testPosition = this.testString.length;
					return false;
				}
				var cd = this.descriptors[num1];
				if (cd.isAssigned && !this.testChar(this.testString.charAt(num1), num3, hint1)) {
					rh.hint = hint1.hint;
					rh.testPosition = num3;
					return false;
				}
				if (num1 !== num2) {
					num1 = this.findEditPositionFrom(num1 + 1, true);
					num3 = this.findEditPositionFrom(num3 + 1, true);
					repeat = true;
					continue;
				}
			}
			if (hint1.hint > rh.hint) {
				rh.hint = hint1.hint;
			}
		}
		if (!testOnly) {
			if (flag1) {
				while (num1 >= pos) {
					var descriptor2 = this.descriptors[num1];
					if (descriptor2.isAssigned) {
						this.setChar(this.testString.charAt(num1), num3);
					}
					else {
						this.resetChar(num3);
					}
					num3 = this.findEditPositionFrom(num3 - 1, false);
					num1 = this.findEditPositionFrom(num1 - 1, false);
				}
			}
			this.setString(input, pos);
		}
		return true;
	},

	insertAt: function (input, pos, rh) {
		if (rh === undefined) { rh = new wijInputResult(); }
		if (input === undefined) { throw 'InsertAt: input'; }

		if (this.noMask) {
			this.testString = this.testString.substring(0, pos) + input + this.testString.substring(pos, this.testString.length);
			rh.testPosition = pos + input.length - 1;
			return true;
		}
		if ((pos >= 0) && (pos < this.testString.length)) {
			return this.internalInsertAt(input, pos, rh, false);
		}
		rh.testPosition = pos;
		rh.hint = rh.positionOutOfRange;
		return false;
	},

	clear: function (rh) {
		if (this.noMask) {
			this.testString = '';
			rh.hint = rh.success;
			return;
		}
		if (!this.assignedCharCount) {
			rh.hint = rh.noEffect;
		}else{
			rh.hint = rh.success;
			for (var num1 = 0; num1 < this.testString.length; num1++) {
				this.resetChar(num1);
			}
		}
	},

	isLiteral: function (desc) {
		if (!desc) { return false;}
		if (desc.charType !== wijchartype.literal) {
			return (desc.charType === wijchartype.separator);
		}
		return true;
	},

	testEscapeChar: function (input, pos, desc) {
		pos = pos < 0 ? 0 : pos;
		if (!desc) {
			desc = this.descriptors[pos];
		}
		if (this.isLiteral(desc)) {
			if (this.getSkipLiterals()) {
				return (input === this.testString.charAt(pos));
			}
			return false;
		}
		if ((!this.getResetOnPrompt() || (input !== this.getPromtChar())) && (!this.getResetOnSpace() || (input !== ' '))) {
			return false;
		}
		return true;
	},

	testChar: function (input, pos, rh) {
		if (!$.wij.charValidator.isPrintableChar(input)) {
			rh.hint = rh.invalidInput;
			return false;
		}
		var cd = this.descriptors[pos];
		if (!cd) { return false; }

		if (this.isLiteral(cd)) {
			if (this.getSkipLiterals() && (input === this.testString.charAt(pos))) {
				rh.hint = rh.characterEscaped;
				return true;
			}
			rh.hint = rh.nonEditPosition;
			return false;
		}
		if (input === this.getPromtChar()) {
			if (this.getResetOnPrompt()) {
				if (this.isEditDesc(cd) && cd.isAssigned) {
					rh.hint = rh.sideEffect;
				}else{
					rh.hint = rh.characterEscaped;
				}
				return true;
			}
			if (!this.getAllowPromptAsInput()) {
				rh.hint = rh.promptCharNotAllowed;
				return false;
			}
		}
		if ((input === ' ') && this.getResetOnSpace()) {
			if (this.isEditDesc(cd) && cd.isAssigned) {
				rh.hint = rh.sideEffect;
			}else{
				rh.hint = rh.characterEscaped;
			}
			return true;
		}
		switch (this.mask.charAt(cd.maskPosition)) {
			case 'L':
				if (!$.wij.charValidator.isLetter(input)) {
					rh.hint = rh.letterExpected;
					return false;
				}
				if (!$.wij.charValidator.isAsciiLetter(input) && this.asciiOnly) {
					rh.hint = rh.asciiCharacterExpected;
					return false;
				}
				break;
			case 'a':
				if (!$.wij.charValidator.isAlphanumeric(input) && (input !== ' ')) {
					rh.hint = rh.alphanumericCharacterExpected;
					return false;
				}
				if (!$.wij.charValidator.isAciiAlphanumeric(input) && this.asciiOnly) {
					rh.hint = rh.asciiCharacterExpected;
					return false;
				}
				break;
			case '?':
				if (!$.wij.charValidator.isLetter(input) && (input !== ' ')) {
					rh.hint = rh.letterExpected;
					return false;
				}
				if ($.wij.charValidator.isAsciiLetter(input) || !this.asciiOnly) {
					break;
				}
				rh.hint = rh.asciiCharacterExpected;
				return false;
			case 'A':
				if (!$.wij.charValidator.isAlphanumeric(input)) {
					rh.hint = rh.alphanumericCharacterExpected;
					return false;
				}
				if ($.wij.charValidator.isAciiAlphanumeric(input) || !this.asciiOnly) {
					break;
				}
				rh.hint = rh.asciiCharacterExpected;
				return false;
			case 'C':
				if ((!$.wij.charValidator.isAscii(input) && this.asciiOnly) && (input !== ' ')) {
					rh.hint = rh.asciiCharacterExpected;
					return false;
				}
				break;
			case '9':
				if (!$.wij.charValidator.isDigit(input) && (input !== ' ')) {
					rh.hint = rh.digitExpected;
					return false;
				}
				break;
			case '#':
				if ((!$.wij.charValidator.isDigit(input) && (input !== '-')) && ((input !== '+') && (input !== ' '))) {
					rh.hint = rh.digitExpected;
					return false;
				}
				break;
			case '&':
				if (!$.wij.charValidator.isAscii(input) && this.asciiOnly) {
					rh.hint = rh.asciiCharacterExpected;
					return false;
				}
				break;
			case '0':
				if (!$.wij.charValidator.isDigit(input)) {
					rh.hint = rh.digitExpected;
					return false;
				}
				break;
		}
		if ((input === this.testString.charAt(pos)) && cd.isAssigned) {
			rh.hint = rh.noEffect;
		}else{
			rh.hint = rh.success;
		}
		return true;
	},

	_testString: function (input, pos, rh) {
		rh.hint = rh.unknown;
		rh.testPosition = pos;
		if (input.length) {
			var hint1 = new wijInputResult();
			hint1.testPosition = rh.testPosition;
			hint1.hint = rh.hint;
			for (var i = 0; i < input.length; i++) {
				var ch = input.charAt(i);
				if (rh.testPosition > this.testString.length) {
					rh.hint = rh.unavailableEditPosition;
					return false;
				}
				if (!this.testEscapeChar(ch, rh.testPosition)) {
					rh.testPosition = this.findEditPositionFrom(rh.testPosition, true);
					if (rh.testPosition === -1) {
						rh.testPosition = this.testString.length;
						rh.hint = rh.unavailableEditPosition;
						return false;
					}
				}
				if (!this.testChar(ch, rh.testPosition, hint1)) {
					rh.hint = hint1.hint;
					return false;
				}
				if (hint1.hint > rh.hint) {
					rh.hint = hint1.hint;
				}
				rh.testPosition += 1;
				
				if (rh.testPosition == this.testString.length){
					break;
				}
			}
			rh.testPosition -= 1;
		}
		return true;
	},

	set: function (input, rh) {
		if (rh === undefined) { rh = new wijInputResult(); }
		if (input === undefined) { throw 'SetFromPos: input parameter is null or undefined.'; }

		rh.hint = rh.unknown;
		rh.testPosition = 0;
		if (!input.length) {
			this.clear(rh);
			return true;
		}
		if (this.noMask) {
			this.testString = input;
			return true;
		}
		if (!this.testSetString(input, rh.testPosition, rh)) {
			return false;
		}
		var num1 = this.findAssignedEditPositionFrom(rh.testPosition + 1, true);
		if (num1 !== -1) {
			this.resetString(num1, this.testString.length - 1);
		}
		return true;
	},

	resetString: function (start, end) {
		if (this.noMask) {
			this.testString = '';
			return;
		}
		start = this.findAssignedEditPositionFrom(start, true);
		if (start !== -1) {
			end = this.findAssignedEditPositionFrom(end, false);
			while (start <= end) {
				start = this.findAssignedEditPositionFrom(start, true);
				this.resetChar(start);
				start++;
			}
		}
	},

	setString: function (input, pos) {
		for (var i = 0; i < input.length; i++) {
			var ch = input.charAt(i);
			if (!this.testEscapeChar(ch, pos)) {
				pos = this.findEditPositionFrom(pos, true);
			}
			
			if (pos < 0 || pos >= this.testString.length) { return; }
			this.setChar(ch, pos);
			pos++;
		}
	},

	testSetString: function (input, pos, rh) {
		if (input.length > this.testString.length) {
			input = input.substring(0, this.testString.length);
		}
		
		if (this._testString(input, pos, rh)) {
			this.setString(input, pos);
			return true;
		}
		return false;
	},
	
	toString: function (ignorePasswordChar, includePrompt, includeLiterals, start, len) {
		ignorePasswordChar = (ignorePasswordChar === undefined) ? !this.isPassword() : ignorePasswordChar;
		includePrompt = (includePrompt === undefined) ? (this.getHidePromptOnLeave() ? this.inputWidget.isFocused() : true) : includePrompt;
		includeLiterals = (includeLiterals === undefined) ? true : includeLiterals;

		if (this.noMask) {
			if (!ignorePasswordChar) {
				var s = '';
				for (var i = 0; i < this.testString.length; i++) {
					s += this.getPasswordChar();
				}
				return s;
			}
			return this.testString;
		}
		

		start = (start === undefined) ? 0 : start;
		len = (len === undefined) ? this.testString.length : len;

		if (len <= 0) { return ''; }
		if (start < 0) { start = 0; }
		if (start >= this.testString.length) { return ''; }
		var num1 = this.testString.length - start;
		if (len > num1) { len = num1; }
		if ((!this.isPassword() || ignorePasswordChar) && (includePrompt && includeLiterals)) {
			var result = this.testString.substring(start, len - start);
			return result;
		}
		var builder1 = '';
		var num2 = (start + len) - 1;
		for (var num5 = start; num5 <= num2; num5++) {
			var ch = this.testString.charAt(num5);
			var cd = this.descriptors[num5];
			switch (cd.charType) {
				case wijchartype.editOptional:
				case wijchartype.editRequired:
					if (!cd.isAssigned) {
						break;
					}
					if (!this.isPassword() || ignorePasswordChar) {
						builder1 = builder1 + ch;
						continue;
					}
					builder1 = builder1 + this.getPasswordChar();
					continue;
				case (wijchartype.editRequired | wijchartype.editOptional):
					builder1 = builder1 + ch;
					continue;
				case wijchartype.separator:
				case wijchartype.literal:
					if (!includeLiterals) {
						continue;
					}
					builder1 = builder1 + ch;
					continue;
				default:
					builder1 = builder1 + ch;
					continue;
			}
			if (includePrompt) {
				builder1 = builder1 + ch;
				continue;
			}
			builder1 = builder1 + ' ';
			continue;
		}
		return builder1;
	},

	isEditDesc: function (desc) {
		if (this.noMask) { return true; }
		
		if (desc.charType !== wijchartype.editRequired) {
			return (desc.charType === wijchartype.editOptional);
		}
		return true;
	},

	isEditPos: function (pos) {
		if (this.noMask) { return true; }
		if ((pos < 0) || (pos >= this.testString.length)) { return false; }

		var cd = this.descriptors[pos];
		return this.isEditDesc(cd);
	},

	internalRemoveAt: function (start, end, rh, testOnly) {
		if (this.noMask) {
			try {
				this.testString = this.testString.substring(0, start) + this.testString.substring(end + 1, this.testString.length);
				rh.testPosition = start;
			}
			catch (e) {
			}
			return true;
		}
		var hint1 = new wijInputResult();
		var ch;
		var ch2;
		var num1 = this.findAssignedEditPositionFrom(this.testString.length - 1, false);
		var i = this.findEditPositionInRange(start, end, true, 0);
		rh.hint = rh.noEffect;
		if ((i === -1) || (i > num1)) {
			rh.testPosition = start;
			return true;
		}
		rh.testPosition = start;
		var flag1 = end < num1;
		if (this.findAssignedEditPositionInRange(start, end, true) !== -1) {
			rh.hint = rh.success;
		}
		if (flag1) {
			var num3 = this.findEditPositionFrom(end + 1, true);
			var num4 = num3;
			start = i;
			var repeat = true;
			while (repeat) {
				repeat = false;
				ch = this.testString.charAt(num3);
				var cd = this.descriptors[num3];
				if (((ch !== this.getPromtChar()) || cd.isAssigned) && !this.testChar(ch, i, hint1)) {
					rh.hint = hint1.hint;
					rh.testPosition = i;
					return false;
				}
				if (num3 !== num1) {
					num3 = this.findEditPositionFrom(num3 + 1, true);
					i = this.findEditPositionFrom(i + 1, true);
					repeat = true;
					continue;
				}
			}
			if (rh.sideEffect > rh.hint) {
				rh.hint = rh.sideEffect;
			}
			if (testOnly) {
				return true;
			}
			num3 = num4;
			i = start;
			var repeat2 = true;
			while (repeat2) {
				repeat2 = false;
				ch2 = this.testString.charAt(num3);
				var descriptor2 = this.descriptors[num3];
				if ((ch2 === this.getPromtChar()) && !descriptor2.isAssigned) {
					this.resetChar(i);
				}
				else {
					this.setChar(ch2, i);
					this.resetChar(num3);
				}
				if (num3 !== num1) {
					num3 = this.findEditPositionFrom(num3 + 1, true);
					i = this.findEditPositionFrom(i + 1, true);
					repeat2 = true;
					continue;
				}
			}
			start = i + 1;
		}
		if (start <= end) {
			this.resetString(start, end);
		}
		return true;
	},

	removeAt: function (start, end, rh) {
		if (typeof (end) === 'undefined') {
			end = start;
		}

		if (!rh) { rh = new wijInputResult(); }
		if (end >= this.testString.length) {
			rh.testPosition = end;
			rh.hint = rh.positionOutOfRange;
			return false;
		}
		if ((start >= 0) && (start <= end)) {
			var result = this.internalRemoveAt(start, end, rh, false);
			return result;
		}
		rh.testPosition = start;
		rh.hint = rh.positionOutOfRange;
		return false;
	}
};


////////////////////////////////////////////////////////////////////////////////
// wijCharDescriptor

var wijCharDescriptor = function (maskPos, charType) {
	this.caseConversion = 'none';
	this.maskPosition = maskPos;
	this.charType = charType;
};

wijCharDescriptor.prototype = {
	isAssigned: false,
	maskPosition: 0
};
	

})(jQuery);

/*
 *
 * Wijmo Library 1.4.0
 * http://wijmo.com/
 *
 * Copyright(c) ComponentOne, LLC.  All rights reserved.
 * 
 * Dual licensed under the Wijmo Commercial or GNU GPL Version 3 licenses.
 * licensing@wijmo.com
 * http://wijmo.com/license
 *
 *
 * * Wijmo Inputnumber widget.
 *
 * Depends:
 *	jquery-1.4.2.js
 *	jquery.ui.core.js
 *	jquery.ui.widget.js
 *	jquery.ui.position.js
 *	jquery.effects.core.js	
 *	jquery.effects.blind.js
 *	jquery.glob.js
 *	jquery.plugin.wijtextselection.js
 *	jquery.wijmo.wijpopup.js
 *	jquery.wijmo.wijinputcore.js
 *
 */
 (function ($) {
	 "use strict";

	 $.widget("wijmo.wijinputnumber", $.extend(true, {}, wijinputcore, {
		 options: {
			///	<summary>
			///		Determines the type of the number input.
			///		Possible values are: 'numeric', 'percent', 'currency'.
			///	</summary>
			type: 'numeric',
			///	<summary>
			///		Determines the default numeric value.
			///	</summary>
			value: null,
			///	<summary>
			///		Determines the minimal value that can be entered for numeric/percent/currency inputs.
			///	</summary>
			minValue: -1000000000,
			///	<summary>
			///		Determines the maximum value that can be entered for numeric/percent/currency inputs.
			///	</summary>
			maxValue: 1000000000,
			///	<summary>
			///		Indicates whether the thousands group separator will be 
			///		inserted between between each digital group 
			///		(number of digits in thousands group depends on the 
			///		selected Culture).
			///	</summary>
			showGroup: false,
			///	<summary>
			///		Indicates the number of decimal places to display.
			///		Possible values are integer from -2 to 8. They are:
			///		useDefault: -2,
			///		asIs: -1,
			///		zero: 0,
			///		one: 1,
			///		two: 2,
			///		three: 3,
			///		four: 4,
			///		five: 5,
			///		six: 6,
			///		seven: 7,
			///		eight: 8
			///	</summary>
			decimalPlaces: 2,
			///	<summary>
			///		Determines how much to increase/decrease the input field.
			///	</summary>
			increment: 1,
			/// <summary>
			/// The valueChanged event handler. A function called when the value of the input is changed.
			/// Default: null.
			/// Type: Function.
			/// Code example: $("#element").wijinputnumber({ valueChanged: function (e, arg) { } });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.value: The new value.
			///</param>
			valueChanged: null,
			/// <summary>
			/// The valueBoundsExceeded event handler. A function called when the value of the input exceeds the valid range.
			/// Default: null.
			/// Type: Function.
			/// Code example: $("#element").wijinputnumber({ valueBoundsExceeded: function (e) { } });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			valueBoundsExceeded: null
		 },

		 _createTextProvider: function () {
			 this._textProvider = new wijNumberTextProvider(this, this.options.type);
		 },

		 _beginUpdate: function () {
			 var o = this.options;
			 this.element.addClass('wijmo-wijinput-numeric');
			 
			 this.element.data({
				 defaultValue: o.value,
				 preValue: o.value
			 }).attr({
				 'aria-valuemin': o.minValue,
				 'aria-valuemax': o.maxValue,
				 'aria-valuenow': o.value || 0
			 });
		 },
		 
		 _onTriggerClicked: function () {
			 this._popupComboList();
		 },

		 _setOption: function (key, value) {
			 $.Widget.prototype._setOption.apply(this, arguments);
			 wijinputcore._setOption.apply(this, arguments);

			 switch (key) {
				 case 'minValue':
					 this.element.attr('aria-valuemin', value);
					 this._updateText();
					 break;

				 case 'maxValue':
					 this.element.attr('aria-valuemax', value);
					 this._updateText();
					 break;

				 case 'value':
					 this.setValue(value);
					 this._updateText();
					 break;

				 case 'showGroup':
				 case 'decimalPlaces':
				 case 'culture':
					 this._textProvider.updateStringFormat();
					 this._updateText();
					 break;
			 }
		 },

		 _setData: function (val) {
			 this.setValue(val);
		 },

		 _resetData: function () {
			var val = this.element.data('defaultValue');
			if (val === undefined || val === null){
				val = this.element.data('elementValue');
				if (val === undefined || val === null && val === ""){
					val = 0;
				}
			}
			
			this.setValue(val);
		 },

		 _validateData: function () {
			 if (this._textProvider.checkAndRepairBounds(true, false)) {
				 this._updateText();
			 }
		 },

		 _raiseDataChanged: function () {
			 var v = this.options.value;
			 var prevValue = this.element.data('preValue');
			 this.element.data('preValue', v);
			 if (prevValue !== v) {
				 this.element.attr('aria-valuenow', v);
				 this._trigger('valueChanged', null, {value: v});
			 }
		 },

		 getValue: function () {
			 var val = this._textProvider.getValue();
			 if (val === undefined || val === null) { val = this.getText(); }
			 return val;
		 },

		 setValue: function (val, exact) {
			 try {
				 exact = !!exact;
				 if (typeof val === 'boolean') {
					 val = val ? '1' : '0';
				 }else if (typeof val === 'string') {
					 val = this._textProvider.tryParseValue(val);
				 }
				 
				 if (this._textProvider.setValue(val)) {
					 this._updateText();
				 } else {
					 if (exact) {
						 var prevVal = '';
						 prevVal = this.getText();
						 this.setText(val);
						 val = val.trim();
						 var txt = this.getText().trim();
						 if (txt !== val) {
							this.setText(prevVal);
						 }
					 } else {
						 this.setText(val);
					 }
				 }

				 return true;
			 }
			 catch (e) {
				 return false;
			 }
		 },

		 isValueNull: function () {
			 try {
				 return (this._textProvider).isValueNull();
			 }
			 catch (e) {
				 return true;
			 }
		 },

		 _updateText: function () {
			 if (!this._isInitialized()) { return; }
			 this.options.value = this._textProvider.getValue();
			 wijinputcore._updateText.apply(this, arguments);
			 if (!this._textProvider.checkAndRepairBounds(false, false)) {
				 this._trigger('valueBoundsExceeded');
			 }
		 },
		 
		 _doSpin: function (up, repeating) {
			up = !!up;
			repeating = !!repeating;

			if (!this._allowEdit()) { return; }
			if (repeating && this.element.data('breakSpinner')) { return; }
			var selRange = this.element.wijtextselection();
			var rh = new wijInputResult();
			if (this.element.data('focusNotCalledFirstTime') !== -9 && (new Date().getTime() - this.element.data('focusNotCalledFirstTime')) < 600) {
				this.element.data('focusNotCalledFirstTime', -9);
				this.element.data('prevCursorPos', 0);
			}
			if (this.element.data('prevCursorPos') === -1) {
				this.element.data('prevCursorPos', selRange.start);
			} else {
				selRange.start = (this.element.data('prevCursorPos'));
			}
			rh.testPosition = selRange.start;
			this._textProvider[up ? 'incEnumPart' : 'decEnumPart'](selRange.start, rh, this.options.increment);
			this._updateText();
			this.element.data('prevCursorPos', rh.testPosition);
			this.selectText(rh.testPosition, rh.testPosition);
			if (repeating && !this.element.data('breakSpinner')) {
				window.setTimeout($.proxy(function () { this._doSpin(up, true); }, this), this._calcSpinInterval());
			}
		}
	 }));


	 //==============================
	 var wijNumberTextProvider = function (owner, t) {
		 this.inputWidget = owner;
		 this._type = t;
		 this._stringFormat = new wijNumberFormat(this._type, this.inputWidget.options.decimalPlaces, this.inputWidget.options.showGroup, this._getCulture());
		 this._stringFormat._setValueFromJSFloat(this.getValue());
	 };

	 wijNumberTextProvider.prototype = {
		 _type: 'numeric',
		 _stringFormat: null,

		 _getCulture: function () {
			 return this.inputWidget._getCulture();
		 },

		 getDecimalSeparator: function () {
			 return this._getCulture().numberFormat['.'];
		 },
		 
		 tryParseValue: function(value){
			return this._stringFormat.tryParseValue(value);
		 },

		 toString: function () {
			 if (this.inputWidget.options.showNullText && !this.inputWidget.isFocused() && this.isValueNull()) {
				 return this.inputWidget.options.nullText;
			 }
			 return this._stringFormat.getFormattedValue();
		 },

		 isValueNull: function () {
			var o = this.inputWidget.options,
				nullValue = Math.max(0, o.minValue);

			return null === o.value || undefined === o.value || nullValue === o.value;
		 },

		 set: function (input, rh) {
			 this.clear();
			 this.insertAt(input, 0, rh);
			 return true;
		 },

		 clear: function () {
			 this._stringFormat.clear();
		 },

		 checkAndRepairBounds: function (chkAndRepair, chkIsLessOrEqMin) {
			 var result = true;
			 if (typeof (chkAndRepair) === 'undefined') { chkAndRepair = false; }

			 var minValue = this.inputWidget.options.minValue,
				maxValue = this.inputWidget.options.maxValue;

			 if (typeof (chkIsLessOrEqMin) !== 'undefined' && chkIsLessOrEqMin) {
				 return this._stringFormat.checkMinValue(minValue, false, true);
			 }

			 if (!this._stringFormat.checkMinValue(minValue, chkAndRepair, false)) { result = false; }
			 if (!this._stringFormat.checkMaxValue(maxValue, chkAndRepair)) { result = false; }
			 if (this.inputWidget.options.decimalPlaces >= 0) {
				 this._stringFormat.checkDigitsLimits(this.inputWidget.options.decimalPlaces);
			 }

			 return result;
		 },

		 countSubstring: function (txt, subStr) {
			 var c = 0;
			 var pos = txt.indexOf(subStr);
			 while (pos !== -1) {
				 c++;
				 pos = txt.indexOf(subStr, pos + 1);
			 }
			 return c;
		 },

		 getAdjustedPositionFromLeft: function (position) {
			 var currentText = this._stringFormat._currentText;
			 for (var i = 0; i < currentText.length; i++) {
				 var ch = currentText.charAt(i);
				 if (!$.wij.charValidator.isDigit(ch) && (ch !== ',' && ch !== '.') || ch === '0') {
					 if (this._stringFormat.isZero()) {
						 if (position < i) {
							 position++;
						 }
					 } else {
						 if (position <= i) {
							 position++;
						 }
					 }
				 } else {
					 break;
				 }
			 }
			 
			 return position;
		 },

		 getDecimalSeparatorPos: function () {
			 var currentText = this._stringFormat._currentText;
			 return currentText.indexOf(this.getDecimalSeparator());
		 },

		 insertAt: function (input, position, rh) {
			 var nf = this._getCulture().numberFormat;

			 if (input === nf['.']) { input = nf['.']; }
			 if (!rh) { rh = new wijInputResult(); }
			 if (input.length === 1) {
				 if (input === '+') {
					 this._stringFormat.setPositiveSign();
					 this.checkAndRepairBounds(true, false);
					 return true;
				 }
				 if (input === '-' || input === ')' || input === '(') {
					 this._stringFormat.invertSign();
					 this.checkAndRepairBounds(true, false);
					 rh.testPosition = position;
					if (this._stringFormat.isNegative())
						rh.testPosition = position;
					else
						rh.testPosition = position - 2;
					 return true;
				 }
				 if (!$.wij.charValidator.isDigit(input)) {
					 if (input === '.') {
						 var pos = this.getDecimalSeparatorPos();
						 if (pos >= 0) {
							 rh.testPosition = pos;
							 return true;
						 }
					 }
					 if (input !== ',' && input !== '.' && input !== ')' && input !== '+' && input !== '-' && input !== '(' && input !== this.getDecimalSeparator()) {
						 if (this._type === 'percent' && input === nf.percent.symbol) {
							 rh.testPosition = position;
							 return true;
						 } else if (this._type === 'currency' && input === nf.currency.symbol) {
							 rh.testPosition = position;
							 return true;
						 } else {
							 return false;
						 }
					 }
				 }
			 }

			 position = this.getAdjustedPositionFromLeft(position);
			 var slicePos = position;
			 var currentText = this._stringFormat._currentText;
			 if (slicePos > currentText.length) {
				 slicePos = currentText.length - 1;
			 }
			 if (input.length === 1) {
				 if (currentText.charAt(slicePos) === input) {
					 rh.testPosition = slicePos;
					 return true;
				 }
			 }
			 var beginText = currentText.substring(0, slicePos);
			 var endText = currentText.substring(slicePos, currentText.length);
			 if (this._stringFormat.isZero()) {
				 endText = endText.replace(new RegExp('[0]'), '');
			 }

			 rh.testPosition = beginText.length + input.length - 1;
			 this._stringFormat.deFormatValue(beginText + input + endText);
			 this.checkAndRepairBounds(true, false);
			 try {
				 if (input.length === 1) {
					 if (this.inputWidget.options.showGroup) {
						 var newBegText = this._stringFormat._currentText.substring(0, beginText.length);
						 if (this.countSubstring(newBegText, this._stringFormat._groupSeparator) !== this.countSubstring(beginText, this._stringFormat._groupSeparator)) {
							 rh.testPosition = rh.testPosition + 1;
						 }
					 }
					 else {
						 var leftPrevCh = beginText.charAt(beginText.length - 1);
						 var leftCh = this._stringFormat._currentText.charAt(rh.testPosition - 1);
						 if (leftCh !== leftPrevCh) {
							 rh.testPosition = rh.testPosition - 1;
						 }
					 }
				 }
			 }
			 catch (e) {
			 }
			 
			 return true;
		 },

		 removeAt: function (start, end, rh) {
			 var nf = this._getCulture().numberFormat;

			 if (!rh) { rh = new wijInputResult(); }
			 rh.testPosition = start;
			 try {
				 var curText = this._stringFormat._currentText;
				 if ((start === end) && curText.substring(start, end + 1) === this.getDecimalSeparator()) {
					 return false;
				 }
				 var curInsertText = curText.slice(0, start) + curText.slice(end + 1);
				 if (curInsertText === '') { curInsertText = '0'; }
				 this._stringFormat.deFormatValue(curInsertText);
				 if (start === end && this.inputWidget.options.showGroup) {
					 try {
						 var newBegText = this._stringFormat._currentText.substring(0, start);
						 if (this.countSubstring(newBegText, this._stringFormat._groupSeparator) !== this.countSubstring(curInsertText, this._stringFormat._groupSeparator)) {
							 rh.testPosition = rh.testPosition - 1;
							 if (curText.indexOf(nf.currency.symbol) === rh.testPosition || curText.indexOf(nf.percent.symbol) === rh.testPosition) {
								 rh.testPosition = rh.testPosition + 1;
							 }
						 }
					 }
					 catch (e1) {
					 }
				 }
				 this.checkAndRepairBounds(true, false);
				 return true;
			 }
			 catch (e2) {
			 }
			 this.checkAndRepairBounds(true, false);
			 return true;
		 },

		 incEnumPart: function (position, rh, val) {
			 if (!rh) { rh = new wijInputResult(); }
			 this._stringFormat.increment(val);
			 return this.checkAndRepairBounds(true, false);
		 },

		 decEnumPart: function (position, rh, val) {
			 if (!rh) { rh = new wijInputResult(); }
			 this._stringFormat.decrement(val);
			 return this.checkAndRepairBounds(true, false);
		 },

		 getValue: function () {
			 return this._stringFormat.getJSFloatValue();
		 },

		 setValue: function (val) {
			 try {
				 this._stringFormat._setValueFromJSFloat(val);
				 this.checkAndRepairBounds(true, false);
				 return true;
			 }
			 catch (e) {
				 return false;
			 }
		 },

		 updateStringFormat: function () {
			 var t = '0';
			 if (typeof (this._stringFormat) !== 'undefined') {
				 t = this._stringFormat._currentValueInString;
			 }
			 this._stringFormat = new wijNumberFormat(this._type, this.inputWidget.options.decimalPlaces, this.inputWidget.options.showGroup, this._getCulture());
			 this._stringFormat._currentValueInString = t;
		 }
	 };


	 //============================

	 var wijNumberFormat = function (t, dp, g, c) {
		 this.type = t;
		 this.digitsPlaces = dp;
		 this.showGroup = g;
		 this.culture = c;
	 };

	 wijNumberFormat.prototype = {
		 _currentValueInString: '0',
		 _currentText: '0',
		 _groupSeparator: ' ',
		 type: 'numeric',
		 digitsPlaces: 0,
		 showGroup: false,
		 culture: null,

 		 isNegtive: function (value) {
			 return value.indexOf('-') !== -1 || value.indexOf('(') !== -1;
		 },
		 
		 stripValue: function(value){
			 var nf = this.culture.numberFormat;
			 var isNegative = this.isNegtive(value);

			 value = value.replace('(', '');
			 value = value.replace(')', '');
			 value = value.replace('-', '');
			 value = value.replace(nf.percent.symbol, '');
			 value = value.replace(nf.currency.symbol, '');
			 var groupSep = nf[','];
			 var decimalSep = nf['.'];
			 switch (this.type) {
				 case 'percent':
					 groupSep = nf.percent[','];
					 decimalSep = nf.percent['.'];
					 break;
				 case 'currency':
					 groupSep = nf.currency[','];
					 decimalSep = nf.currency['.'];
					 break;
			 }
			 this._groupSeparator = groupSep;
			 var r = new RegExp('[' + groupSep + ']', 'g');
			 value = value.replace(r, '');
			 r = new RegExp('[' + decimalSep + ']', 'g');
			 value = value.replace(r, '.');
			 r = new RegExp('[ ]', 'g');
			 value = value.replace(r, '');
			 try {
				 var reg = new RegExp('([\\d\\.])+');
				 var arr = reg.exec(value);
				 if (arr) {
					 value = arr[0];
				 }
				 if (isNegative) {
					 value = '-' + value;
				 }
				 
				 return value;
			 }
			 catch (e) {
			 }
			 
			 return null;
		 },
		 
		 tryParseValue: function(value){
			 value = this.stripValue(value);
			 if (value === null) {return 0;}
			 
			 try{
				value = parseFloat(value);
				if (isNaN(value)) { value = 0 ;}
			 }catch(e){
				value = 0;
			 }
			 
			 return value;
		 },

		 deFormatValue: function (value) {
 			 value = this.stripValue(value);
			 if (value === null) {return;}
		 
			 this._currentValueInString = value;
			 this._currentText = this.formatValue(value);
		 },

		 formatValue: function (value) {
			 var nf = this.culture.numberFormat;
			 value = '' + value + '';
			 var dp = this.digitsPlaces, groupSep = ' ', decimalSep = '.', decimals = 2, isNegative = this.isNegtive(value);

			 var groupSizes = new Array(3);
			 groupSizes.push(3);
			 var pattern = 'n';
			 switch (this.type) {
				 case 'numeric':
					 pattern = isNegative ? nf.pattern[0] : 'n';
					 groupSep = nf[','];
					 decimalSep = nf['.'];
					 decimals = nf.decimals;
					 groupSizes = nf.groupSizes;
					 break;
				 case 'percent':
					 pattern = nf.percent.pattern[isNegative ? 0 : 1];
					 groupSep = nf.percent[','];
					 decimalSep = nf.percent['.'];
					 decimals = nf.percent.decimals;
					 groupSizes = nf.percent.groupSizes;
					 break;
				 case 'currency':
					 pattern = nf.currency.pattern[isNegative ? 0 : 1];
					 groupSep = nf.currency[','];
					 decimalSep = nf.currency['.'];
					 decimals = nf.currency.decimals;
					 groupSizes = nf.currency.groupSizes;
					 break;
			 }

			 if (dp !== -2) { decimals = dp; }
			 if (!this.showGroup) { groupSizes = [0]; }

			 value = value.replace(new RegExp('^[0]+'), '');
			 var digitsString = this.formatDigit(value, groupSep, decimalSep, decimals, groupSizes);
			 digitsString = digitsString.replace(new RegExp('^[0]+'), '');
			 if (digitsString.indexOf(decimalSep) === 0) { digitsString = '0' + digitsString; }
			 if (digitsString === '') { digitsString = '0'; }

			 this._currentValueInString = value;
			 this._currentText = this.applyFormatPattern(pattern, digitsString, nf.percent.symbol, nf.currency.symbol);
			 return this._currentText;
		 },

		 getFormattedValue: function () {
			 return this.formatValue(this._currentValueInString);
		 },

		 getJSFloatValue: function () {
			 try {
				 if (this._currentValueInString === '') {
					 return 0;
				 }
				 return parseFloat(this._currentValueInString);
			 }
			 catch (e) {
				 return Number.NaN;
			 }
		 },

		 clear: function () {
			 this._currentValueInString = '0';
			 this._currentText = '0';
		 },

		 _setValueFromJSFloat: function (v) {
			 try {
				 this._currentValueInString = '' + v + '';
				 this.formatValue(v);
				 return true;
			 }
			 catch (e) {
				 return false;
			 }
		 },

		 isZero: function (val) {
			 try {
				if (val === undefined){
					val = this._currentValueInString;
				}
			 
				 var test = val.replace('-', '');
				 test = test.replace('(', '');
				 test = test.replace(')', '');
				 if (!test.length) {
					 test = '0';
				 }
				 var dbl = parseFloat(test);
				 if (!isNaN(dbl) && !dbl) {
					 return true;
				 }
			 }
			 catch (e) {
			 }
			 return false;
		 },

		 setPositiveSign: function () {
			 this._currentValueInString = this._currentValueInString.replace('-', '');
			 this._currentValueInString = this._currentValueInString.replace('(', '');
			 this._currentValueInString = this._currentValueInString.replace(')', '');
		 },
		 
		 isNegative: function(){
			return this._currentValueInString.indexOf('-') !== -1 || this._currentValueInString.indexOf('(') !== -1;
		 },

		 invertSign: function () {
			 var isNegative = this.isNegative();
			 if (isNegative) {
				 this.setPositiveSign();
			 } else {
				 this._currentValueInString = (!this._currentValueInString.length) ? '0' : '-' + this._currentValueInString;
			 }
			 if (this.isZero()) {
				 this._currentValueInString = isNegative ? '0' : '-0';
			 }
			 this.formatValue(this._currentValueInString);
		 },

		 increment: function (val) {
			 if (val === undefined) { val = 1; }
			 try {
				 var arr = this._currentValueInString.split('.');
				 this._currentValueInString = (arr[0] * 1 + val) + '' + ((arr.length > 1) ? ('.' + arr[1]) : '');
			 }
			 catch (e) {
			 }
		 },

		 decrement: function (val) {
			 if (val === undefined) { val = 1; }
			 try {
				 var arr = this._currentValueInString.split('.');
				 this._currentValueInString = (arr[0] * 1 - val) + '' + ((arr.length > 1) ? ('.' + arr[1]) : '');
			 }
			 catch (e) {
			 }
		 },

		 checkDigitsLimits: function (aDigitsCount) {
			 try {
				 var arr = this._currentValueInString.split('.');
				 if (!arr.length || (arr.length === 1 && arr[0] === '')) {
					 return;
				 }
				 var s = '';
				 if (arr.length > 1) {
					 s = arr[1];
				 }
				 var d = '';
				 for (var i = 0; i < aDigitsCount; i++) {
					 var ch = '0';
					 if (s.length > i) {
						 ch = s.charAt(i);
					 }
					 d = d + ch;
				 }
				 if (d.length > 0) {
					 this._currentValueInString = arr[0] + '.' + d;
				 } else {
					 this._currentValueInString = arr[0];
				 }
			 }
			 catch (e) {
			 }
		 },

		 checkMinValue: function (val, chkAndRepair, chkIsLessOrEqMin) {
			 if (typeof (chkIsLessOrEqMin) === 'undefined') {
				 chkIsLessOrEqMin = false;
			 }
			 var result = true;
			 try {
				 var arr = this._currentValueInString.split('.');
				 var s1 = parseFloat((arr[0] === '' || arr[0] === '-') ? '0' : arr[0]);
				 var s2 = 0;
				 if (arr.length > 1 && parseFloat(arr[1]) > 0) {
					 s2 = parseFloat('1.' + arr[1]);
				 }
				 if (s1 < 0 || arr[0] === '-') {
					 s2 = s2 * -1;
				 }
				 val = '' + val + '';
				 arr = val.split('.');
				 var sv1 = parseFloat(arr[0]);
				 var sv2 = 0;
				 if (arr.length > 1 && parseFloat(arr[1]) > 0) {
					 sv2 = parseFloat('1.' + arr[1]);
				 }
				 if (s1 > sv1) {
					 return true;
				 }
				 if (s1 < sv1 || (chkIsLessOrEqMin && s1 === sv1 && s2 <= sv2)) {
					 result = false;
				 } else if (s1 === sv1 && s1 < 0 && s2 > sv2) {
					 result = false;
				 } else if (s1 === sv1 && s1 >= 0 && s2 < sv2) {
					 result = false;
				 }
				 if (!result && chkAndRepair) {
					 this._currentValueInString = '' + val + '';
				 }
			 }
			 catch (e) {
			 }
			 return result;
		 },

		 checkMaxValue: function (val, chkAndRepair) {
			 var result = true;
			 try {
				 var arr = this._currentValueInString.split('.');
				 var s1 = parseFloat((arr[0] === '' || arr[0] === '-') ? '0' : arr[0]);
				 var s2 = 0;
				 if (arr.length > 1 && parseFloat(arr[1]) > 0) {
					 s2 = parseFloat('1.' + arr[1]);
				 }
				 if (s1 < 0 || arr[0] === '-') {
					 s2 = s2 * -1;
				 }
				 val = '' + val + '';
				 arr = val.split('.');
				 var sv1 = parseFloat(arr[0]);
				 var sv2 = 0;
				 if (arr.length > 1 && parseFloat(arr[1]) > 0) {
					 sv2 = parseFloat('1.' + arr[1]);
				 }
				 if (s1 < sv1) {
					 return true;
				 }
				 if (s1 > sv1) {
					 result = false;
				 }
				 if (s1 === sv1 && s1 >= 0 && s2 > sv2) {
					 result = false;
				 }
				 if (s1 === sv1 && s1 < 0 && s2 < sv2) {
					 result = false;
				 }
				 if (!result && chkAndRepair) {
					 this._currentValueInString = '' + val + '';
				 }
			 }
			 catch (e) {
			 }
			 return result;
		 },

		 applyFormatPattern: function (pattern, digitString, percentSymbol, currencySymbol) {
			 var result = pattern;
			 var r = new RegExp('[n]', 'g');
			 result = result.replace(r, digitString);
			 r = new RegExp('[%]', 'g');
			 result = result.replace(r, percentSymbol);
			 r = new RegExp('[$]', 'g');
			 result = result.replace(r, currencySymbol);
			 return result;
		 },

		 formatDigit: function (value, groupSep, decimalSep, decimals, groupSizes) {
			 var absValue = '' + value + '';
			 absValue = absValue.replace('-', '');
			 absValue = absValue.replace('(', '');
			 absValue = absValue.replace(')', '');
			 var decimalPos = absValue.indexOf(decimalSep);
			 if (decimalPos === -1) { decimalPos = absValue.indexOf('.'); }
			 if (decimalPos === -1) { decimalPos = absValue.indexOf(','); }
			 if (decimalPos === -1) { decimalPos = absValue.length; }

			 var result = '', groupSizeIndex = 0, groupCount = 0, ch, i;
			 for (i = absValue.length - 1; i >= 0; i--) {
				 ch = absValue.charAt(i);
				 if (i < decimalPos) {
					 result = ch + result;
					 groupCount++;
					 if (groupCount === groupSizes[groupSizeIndex] * 1 && groupSizes[groupSizeIndex] * 1 && i) {
						 result = groupSep + result;
						 groupCount = 0;
						 if (groupSizes.length - 1 > groupSizeIndex) {
							 groupSizeIndex++;
						 }
					 }
				 }
			 }
			 if (decimals > 0) {
				 result = result + decimalSep;
				 for (i = 0; i < decimals; i++) {
					 ch = '0';
					 if (i + decimalPos + 1 < absValue.length) {
						 ch = absValue.charAt(i + decimalPos + 1);
					 }
					 result = result + ch;
				 }
			 }
			 if (decimals === -1) {
				 if (decimalPos < absValue.length - 1) {
					 result = result + decimalSep;
					 result = result + absValue.substr(decimalPos + 1);
				 }
			 }
			 return result;
		 }
	 };

 })(jQuery);

/*globals jQuery,$,document*/
/*jslint white: false*/

/*
 *
 * Wijmo Library 1.4.0
 * http://wijmo.com/
 *
 * Copyright(c) ComponentOne, LLC.  All rights reserved.
 * 
 * Dual licensed under the Wijmo Commercial or GNU GPL Version 3 licenses.
 * licensing@wijmo.com
 * http://wijmo.com/license
 *
 *
 * * Wijmo Grid Widget.
 *
 * Depends:
 * jquery-1.4.2.js
 * jquery.ui.core.js
 * jquery.ui.widget.js
 * jquery.glob.js
 * jquery.wijmo.wijutil.js
 * jquery.wijmo.wijdatasource.js
 *
 * Optional dependencies for paging feature:
 * jquery.wijmo.wijpager.js
 *
 * Optional dependencies for scrolling feature:
 * jquery.wijmo.wijsuperpanel.js
 *
 * Optional dependencies for filtering feature:
 * jquery.ui.position.js
 * jquery.wijmo.wijinputdate.js
 * jquery.wijmo.wijinputmask.js
 * jquery.wijmo.wijinputnumber.js
 * jquery.wijmo.wijlist.js
 *
 * Optional dependencies for column moving feature:
 * jquery.ui.draggable.js
 * jquery.ui.droppable.js
 * jquery.ui.position.js
 *
 */

(function ($) {
	"use strict";
	$.widget("wijmo.wijgrid", {
		options: {
			/// <summary>
			/// A value indicating whether columns can be sized.
			/// Default: false.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ allowColSizing: false });
			/// </summary>
			allowColSizing: false,

			/// <summary>
			/// A value indicating whether columns can be moved.
			/// Default: false.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ allowColMoving: false });
			/// </summary>
			allowColMoving: false,

			/// <summary>
			/// A value indicating whether keyboard navigation is allowed.
			/// Default: false.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ allowKeyboardNavigation: false });
			/// </summary>
			allowKeyboardNavigation: false,

			/// <summary>
			/// A value indicating whether the widget can be paged.
			/// Default: false.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ allowPaging: false });
			/// </summary>
			allowPaging: false,

			/// <summary>
			/// A value indicating whether the widget can be sorted.
			/// Default: false.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ allowSorting: false });
			/// </summary>
			allowSorting: false,

			/// <summary>
			/// A value indicating whether editing is enabled.
			/// Default: false.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ allowEditing: false });
			/// </summary>
			allowEditing: false,

			/// <summary>
			/// Determines whether wijgrid should parse underlying data at each operation requiring data re-fetching, like calling the ensureControl(true) method, paging, sorting, etc.
			/// If the option is disabled, wijgrid parses data only at the first fetch.
			/// The option is ignored if dynamic data load feature is used, in this case data are always parsed.
			///
			/// Default: true
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ alwaysParseData: true });
			/// </summary>
			///
			/// <remarks>
			/// Turning off the option enhance wijgrid performance but if underlying data are changed by a developer it is necessary
			/// that changes match column datatype.
			/// </remarks>
			alwaysParseData: true,

			/// <summary>
			/// Determines behavior for column autogeneration.
			///
			/// Possible values are: "none", "append", "merge".
			///
			/// "none": column auto-generation is turned off.
			/// "append": a column will be generated for each data field and added to the end of the columns collection.
			/// "merge": each column having dataKey option not specified will be automatically bound to the first unreserved data field.
			/// For each data field not bound to any column a new column will be generated and added to the end of the columns collection.
			/// To prevent automatic binding of a column to a data field set its dataKey option to null.
			///
			/// Default: "merge".
			/// Type: String.
			/// Code example: $("#element").wijgrid({ columnsAutogenerationMode: "merge" });
			/// </summary>
			///
			/// <remarks>
			/// Note: columns autogeneration process affects the options of columns and the columns option itself.
			/// </remarks>
			columnsAutogenerationMode: "merge",

			/// <summary>
			/// Function used for styling the cells in wijgrid.
			/// Default: undefined,
			/// Type: Function.
			/// Code example: $("#element").wijgrid({ cellStyleFormatter: function(args) { } });
			/// </summary>
			/// <param name="args" type="Object">
			/// args.$cell: jQuery object that represents cell to format.
			/// args.column: Options of the column to which the cell belongs.
			/// args.state: state of a cell to format, the following $.wijmo.wijgrid.renderState values or their combination can be applied to the cell: rendering, current, selected.
			/// args.row: information about associated row.
			/// args.row.$rows: jQuery object that represents rows to format.
			/// args.row.data: associated data.
			/// args.row.dataRowIndex: data row index.
			/// args.row.dataItemIndex: data item index.
			/// args.row.virtualDataItemIndex: virtual data item index.
			/// args.row.type: type of the row, one of the $.wijmo.wijgrid.rowType values.
			/// </param>
			cellStyleFormatter: undefined,

			/// <summary>
			/// An array of column options.
			/// Default: [].
			/// Type: Array.
			/// Code example: $("#element").wijgrid({ columns: [ { headerText: "column0", allowSort: false }, { headerText: "column1", dataType: "number" } ] });
			/// </summary>
			columns: [],

			/// <summary>
			/// Determines the culture ID.
			/// Default: "".
			/// Type: String.
			/// Code example: $("#element").wijgrid({ culture: "en" });
			/// </summary>
			culture: "",

			/// <summary>
			/// An array of custom user filters.
			///
			/// Custom user filter is an object which contains the following properties:
			///   name - operator name.
			///   arity - the number of filter operands. Can be either 1 or 2.
			///   css - the name of the CSS-class determining filter icon. If no value is set, then "filter-<name.toLowerCase()>" class is used.
			///   applicableTo - an array of datatypes to which the filter can be applied. Possible values for elements of the array are "string", "number", "datetime", "currency" and "boolean".
			///   operator - comparison operator, the number of accepted parameters depends upon the arity. The first parameter is a data value, the second parameter is a filter value.
			///
			/// Default: [].
			/// Type: Array.
			/// Code example:
			///
			///   var oddFilterOp = {
			///     name: "customOperator-Odd",
			///     arity: 1,
			///     applicableTo: ["number"],
			///     operator: function(dataVal) { return (dataVal % 2 !== 0); }
			///  }
			///
			///  $("#element").wijgrid({ customFilterOperators: [oddFilterOp] });
			/// </summary>
			customFilterOperators: [],

			/// <summary>
			/// Determines the datasource.
			/// Possible datasources include:
			///
			///   1. A DOM table. This is the default datasource, used if the data option is null.
			///     Table must be contained in a DOM element to which wijgrid is attached, must have no cells with rowSpan and colSpan attributes.
			///   2. A two-dimensional array, such as [[0, "a"], [1, "b"]]
			///   3. An array of hashes, such as [{field0: 0, field1: "a"}, {field0: 1, field1: "b'}]
			///   4. A wijdatasource
			///
			/// Type: Object.
			/// Default: null
			/// Code example:
			/// /* DOM table */
			/// $("#element").wijgrid();
			///
			/// /* two-dimensional array */
			/// $("#element").wijgrid({ data: [[0, "a"], [1, "b"]] });
			/// </summary>
			data: null,

			/// <summary>
			/// Determines whether to use number type column width as the real width of the column.
			/// Default: false.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ ensurePxWidth: true });
			/// </summary>
			/// <remarks>
			/// If this option is set to true, wijgrid will not expand itself to expand the available space.
			/// Instead, it will use the width option of each column widget.
			/// </remarks>
			ensureColumnsPxWidth: false,

			/// <summary>
			/// Determines the order of items in the filter dropdown list.
			/// Possible values are: "none", "alphabetical", "alphabeticalCustomFirst" and "alphabeticalEmbeddedFirst"
			///
			/// "none" - operators follow the order of addition, built-in operators goes before custom ones.
			/// "alphabetical" - operators are sorted alphabetically.
			/// "alphabeticalCustomFirst" - operators are sorted alphabetically with custom operators going before built-in ones.
			/// "alphabeticalEmbeddedFirst" - operators are sorted alphabetically with built-in operators going before custom operators.
			///
			/// Note: "NoFilter" operator is always first.
			///
			/// Type: String.
			/// Default: "alphabeticalCustomFirst"
			/// Code example: $("#element").wijgrid({ filterOperatorsSortMode: "alphabeticalCustomFirst" });
			/// </summary>
			filterOperatorsSortMode: "alphabeticalCustomFirst",

			/// <summary>
			/// Determines the caption of the group area.
			/// Default: "Drag a column here to group by that column.".
			/// Type: String.
			/// Code example: $("#element").wijgrid({ groupAreaCaption: "Drag a column here to group by that column." });
			/// </summary>
			groupAreaCaption: "Drag a column here to group by that column.",

			/// <summary>
			/// Determines the indentation of the groups.
			/// Default: 10.
			/// Type: Number.
			/// Code example: $("#element").wijgrid({ groupIndent: 10 });
			/// </summary>
			groupIndent: 10,

			/// <summary>
			/// Cell values equal to this property value are considered as null value.
			/// Case-sensitive for built-in parsers.
			/// Default: undefined.
			/// Type: String.
			/// Code example: $("#element").wijgrid({ nullString: "" });
			/// </summary>
			nullString: undefined,

			/// <summary>
			/// Determines the zero-based index of the current page.
			/// The default value is 0.
			/// Type: Number.
			/// Code example: $("#element").wijgrid({ pageIndex: 0 });
			/// </summary>
			pageIndex: 0,

			/// <summary>
			/// Number of rows to place on a single page.
			/// The default value is 10.
			/// Type: Number.
			/// Code example: $("#element").wijgrid({ pageSize: 10 });
			/// </summary>
			pageSize: 10,

			/// <summary>
			/// Pager settings.
			/// Note: See jquery.wijmo.wijpager.js for more information.
			/// Type: Object.
			/// Default: { mode: "numeric", pageButtonCount: 10, position: "bottom" }.
			/// Code example: $("#element").wijgrid({ pagerSettings: { position: "bottom" } });
			/// </summary>
			pagerSettings: {
				mode: "numeric",
				pageButtonCount: 10,
				position: "bottom"
			},

			/// A value indicating whether DOM cell attributes can be passed within a data values.
			/// Default: false.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ readAttributesFromData: false });
			/// </summary>
			/// <remarks>
			/// This option allows binding collection of values to data and automatically converting them as attributes of corresponded DOM table cells during rendering.
			///
			/// Values should be passed as an array of two items, where first item is a value of the data field, the second item is a list of values:
			///
			/// $("#element").wijgrid({
			///   data: [
			///     [ [1, { "style": "color: red", "class": "myclass" } ], a ]
			///   ]
			/// });
			///
			/// or
			///
			/// $("#element").wijgrid({
			///   data: [
			///     { col0: [1, { "style": "color: red", "class": "myclass" }], col1: "a" }
			///   ]
			/// });
			///
			/// Note: during conversion wijgrid extracts the first item value and makes it data field value, the second item (list of values) is removed:
			///  [ { col0: 1, col1: "a" } ]
			/// 
			/// If DOM table is used as a datasource then attributes belonging to the cells in tBody section of the original table will be read and applied to the new cells.
			///
			/// rowSpan and colSpan attributes are not allowed.
			/// </remarks>
			readAttributesFromData: false,

			/// <summary>
			/// Function used for styling the rows in wijgrid.
			/// Default: undefined,
			/// Type: Function.
			/// Code example: $("#element").wijgrid({ rowStyleFormatter: function(args) { } });
			/// </summary>
			/// <param name="args" type="Object">
			/// args.state: state of a row to format, the following $.wijmo.wijgrid.renderState values or their combination can be applied to the row: rendering, current, hovered.
			/// args.$rows: jQuery object that represents rows to format.
			/// args.data: associated data.
			/// args.dataRowIndex: data row index.
			/// args.dataItemIndex: data item index.
			/// args.virtualDataItemIndex: virtual data item index.
			/// args.type: type of the row, one of the $.wijmo.wijgrid.rowType values.
			/// </param>
			rowStyleFormatter: undefined,

			/// <summary>
			/// Determines the scrolling mode.
			///
			/// Possible values are:
			/// "none": scrolling is not used, staticRowIndex value is ignored.
			/// "auto": scrollbars appear automatically depending upon content size.
			/// "horizontal": horizontal scrollbar is active.
			/// "vertical": vertical scrollbar is active.
			/// "both": both horizontal and vertical scrollbars are active.
			///
			/// Default: "none".
			/// Type: String.
			/// Code example: $("#element").wijgrid({ scrollMode: "none" });
			/// </summary>
			scrollMode: "none",

			/// <summary>
			/// Represents selection behavior.
			/// Possible values are: "none", "singleCell", "singleColumn", "singleRow", "singleRange", "multiColumn", "multiRow" and "multiRange".
			///
			/// "none": selection is turned off.
			/// "singleCell": only a single cell can be selected at the same time.
			/// "singleColumn": only a single column can be selected at the same time.
			/// "singleRow": only a single row can be selected at the same time.
			/// "singleRange": only a single range of cells can be selected at the same time.
			/// "multiColumn": it is possible to select more than one row at the same time using the mouse and the CTRL or SHIFT keys.
			/// "multiRow": it is possible to select more than one row at the same time using the mouse and the CTRL or SHIFT keys.
			/// "multiRange": it is possible to select more than one cells range at the same time using the mouse and the CTRL or SHIFT keys.
			///
			/// Default: "singleRow".
			/// Type: String.
			/// Code example: $("#element").wijgrid({ selectionMode: "singleRow" });
			/// </summary>
			selectionMode: "singleRow",

			/// <summary>
			/// A value indicating whether filter row is visible.
			/// Default: false.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ showFilter: false });
			/// </summary>
			showFilter: false,

			/// <summary>
			/// A value indicating whether footer row is visible.
			/// Default: false.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ showFooter: false });
			/// </summary>
			showFooter: false,

			/// <summary>
			/// A value indicating whether group area is visible.
			/// Default: false.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ showGroupArea: false });
			/// </summary>
			showGroupArea: false,

			/// <summary>
			/// A value indicating whether the row header is visible.
			/// Default: false.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ showRowHeader: false });
			/// </summary>
			showRowHeader: false,

			/*dma> Commented by YK for removing unsupported options.
			/// <summary>
			/// A value indicating whether the grid view should split content into several views with the ability to resize and scroll each view independently.
			/// Default: false.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ splits: false });
			/// </summary>
			splits: false,

			/// <summary>
			/// Determines the distance in pixels for the vertical splitter. Applicable when the splits option is true.
			/// Default: 50.
			/// Type: Number.
			/// Code example: $("#element").wijgrid({ splitDistanceX: 50 });
			/// </summary>
			splitDistanceX: 50,

			/// <summary>
			/// Determines the distance in pixels for the horizontal splitter. Applicable when the splits option is true.
			/// Default: 50.
			/// Type: Number.
			/// Code example: $("#element").wijgrid({ splitDistanceY: 50 });
			/// </summary>
			splitDistanceY: 50,

			/// <summary>
			/// Indicates the zero-based  index  of  the column that will be shown on the
			/// left when the grid view scrolled horizontally. Note, that all columns
			/// before the static column will be automatically marked as static, too. Set
			/// this option to false or to any negative value if you want to turn
			/// off the static columns feature.
			///
			/// Default: -1.
			/// Type: Number.
			/// Code example: $("#element").wijgrid({ staticColumnIndex: -1 });
			/// </summary>
			staticColumnIndex: -1,*/

			/// <summary>
			/// Indicates whether header is static or not. Static header is always
			/// shown on the top when the wijgrid is scrolled vertically.
			/// Set this option to 0 to turn on the static header feature or to -1 to turn it off.
			///
			/// Default: -1.
			/// Type: Number.
			/// Code example: $("#element").wijgrid({ staticRowIndex: -1 });
			/// </summary>
			staticRowIndex: -1,
			/*<dma*/

			/* --- events */

			/// <summary>
			/// The afterCellEdit event handler. A function called after editing is completed.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the afterCellEdit event:
			/// $("#element").wijgrid({ afterCellEdit: function (e, args) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridaftercelledit", function (e, args) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.cell: gets the edited cell's information.
			/// args.event: event that initiated the cell updating.
			/// args.handled: gets or sets value determining whether the developer finalizes editing of the cell manually.
			///   The default value is false which means that the widget will try to finalize editing of the cell automatically.
			///   If the developer provides a custom editing front end then this property must be set to true.
			/// </param>
			afterCellEdit: null,

			/// <summary>
			/// The afterCellUpdate event handler. A function called after a cell has been updated.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the afterCellUpdate event:
			/// $("#element").wijgrid({ afterCellUpdate: function (e, args) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridaftercellupdate", function (e, args) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.cell: gets the edited cell's information.
			/// </param>
			afterCellUpdate: null,

			/// <summary>
			/// The beforeCellEdit event handler. A function called before a cell enters edit mode. Cancellable.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the beforeCellEdit event:
			/// $("#element").wijgrid({ beforeCellEdit: function (e, args) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridbeforecelledit", function (e, args) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.cell: information about the cell to be edited.
			/// args.event: event initiated cell editing.
			/// args.handled: gets or sets a value determining whether developer initiates cell editor(s) manually.
			///   The default value is false which means that widget will trying to provide editing control automatically.
			///   If cells contain custom controls or if developer wants to provide a custom editing front end then he
			///   must set this property to true.
			///</param>
			beforeCellEdit: null,

			/// <summary>
			/// The beforeCellUpdate event handler. A function called before a cell is updated.
			/// Default: null.
			/// Type: Function.
			///
			/// Code example:
			/// Supply a callback function to handle the beforeCellUpdate event:
			/// $("#element").wijgrid({ beforeCellUpdate: function (e, args) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridbeforecellupdate", function (e, args) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.cell: gets information of the edited cell.
			/// args.value: returns the new cell value. If the property value is not changed the widget will try to
			///   extract the new cell value automatically. If the developer provides custom editing front end then
			///   the new cell value must be returned within this property.
			/// </param>
			beforeCellUpdate: null,

			/// <summary>
			/// The columnDragging event handler. A function called when column dragging is started, but before wijgrid handles the operation. Cancellable.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the columnDragging event:
			/// $("#element").wijgrid({ columnDragging: function (e, args) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridcolumndragging", function (e, args) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.drag: drag source, column being dragged.
			/// args.dragSource: the place where the dragged column widget is located, possible value: "groupArea", "columns".
			/// </param>
			columnDragging: null,

			/// <summary>
			/// The columnDragged event handler. A function called when column dragging has been started.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the columnDragged event:
			/// $("#element").wijgrid({ columnDragged: function (e, args) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridcolumndragged", function (e, args) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.drag: drag source, column being dragged.
			/// args.dragSource: the place where the dragged column widget is located, possible value: "groupArea", "columns".
			/// </param>
			columnDragged: null,

			/// <summary>
			/// The columnDropping event handler. A function called when column is dropped, but before wijgrid handles the operation. Cancellable.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the columnDropping event:
			/// $("#element").wijgrid({ columnDropping: function (e, args) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridcolumndropping", function (e, args) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.drag: drag source, column being dragged.
			/// args.drop: drop target, column on which drag source is dropped(be null if dropping a column into empty group area).
			/// args.dragSource: the place where the dragged column widget is located, possible value: "groupArea", "columns".
			/// args.dropSource: the place where the dropped column widget is located, possible value: "groupArea", "columns".
			/// args.at: position to drop (one of the "left", "right" and "center" values) relative to drop target(be "left" if dropping a column into empty group area).
			/// </param>
			columnDropping: null,

			/// <summary>
			/// The columnDropped event handler. A function called when column has been dropped.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the columnDropped event:
			/// $("#element").wijgrid({ columnDropped: function (e, args) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridcolumndropped", function (e, args) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.drag: drag source, column being dragged.
			/// args.drop: drop target, column on which drag source is dropped(be null if dropping a column into empty group area).
			/// args.dragSource: the place where the dragged column widget is located, possible value: "groupArea", "columns".
			/// args.dropSource: the place where the dropped column widget is located, possible value: "groupArea", "columns".
			/// args.at: position to drop (one of the "left", "right" and "center" values) relative to drop target(be "left" if dropping a column into empty group area).
			/// </param>
			columnDropped: null,

			/// <summary>
			/// The columnResizing event handler. A function called when column is resized, but before wijgrid handles the operation. Cancellable.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the columnResizing event:
			/// $("#element").wijgrid({ columnResizing: function (e, args) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridcolumnresizing", function (e, args) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.column: column that is being resized.
			/// args.oldWidth: the old width of the column before resized.
			/// args.newWidth: the new width being set to the column.
			/// </param>
			columnResizing: null,

			/// <summary>
			/// The columnResized event handler. A function called when column has been resized.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the columnResized event:
			/// $("#element").wijgrid({ columnResized: function (e) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridcolumnresized", function (e) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.column: column that is being resized.
			/// </param>
			columnResized: null,
			//end by Jeffrey

			/// <summary>
			/// The currentCellChanging event handler. A function called before the current cell is changed. Cancellable.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the currentCellChanging event:
			/// $("#element").wijgrid({ currentCellChanging: function (e, args) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridcurrentcellchanging", function (e, args) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.cellIndex: new cell index.
			/// args.rowIndex: new row index.
			/// args.oldCellIndex: old cell index.
			/// args.oldRowIndex: old row index.
			/// </param>
			currentCellChanging: null,

			/// <summary>
			/// The currentCellChanged event handler. A function called after the current cell is changed.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the currentCellChanged event:
			/// $("#element").wijgrid({ currentCellChanged: function (e) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridcurrentcellchanged", function (e) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			currentCellChanged: null,

			/// <summary>
			/// The filterOperatorsListShowing event handler. A function called before the filter drop-down list is shown.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the filterOperatorsListShowing event:
			/// $("#element").wijgrid({ filterOperatorsListShowing: function (e, args) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridfilteroperatorslistshowing", function (e, args) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.column: associated column.
			/// args.operators: An array of filter operators.
			/// </param>
			filterOperatorsListShowing: null,

			/// <summary>
			/// The groupAggregate event handler. A function called when groups are being created and the "aggregate" option of the column object has been set to "custom".
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the groupAggregate event:
			/// $("#element").wijgrid({ groupAggregate: function (e, args) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridgroupaggregate", function (e, args) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.data: data object.
			/// args.column: column that is being grouped.
			/// args.groupByColumn: column initiated grouping.
			/// args.groupText: text that is being grouped.
			/// args.text: text that will be displayed in the group header or group footer.
			/// args.groupingStart: first index for the data being grouped.
			/// args.groupingEnd: last index for the data being grouped.
			/// args.isGroupHeader: indicates whether row that is being grouped is a group header or not.
			/// </param>
			groupAggregate: null,

			/// <summary>
			/// The groupText event handler. A function called when groups are being created and the groupInfo.headerText or groupInfo.footerText of the groupInfo option has been set to "custom".
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the groupText event:
			/// $("#element").wijgrid({ groupText: function (e, args) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridgrouptext", function (e, args) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.data: data object.
			/// args.column: column that is being grouped.
			/// args.groupByColumn: column initiated grouping.
			/// args.groupText: text that is being grouped.
			/// args.text: text that will be displayed in the group header or group footer.
			/// args.groupingStart: first index for the data being grouped.
			/// args.groupingEnd: last index for the data being grouped.
			/// args.isGroupHeader: indicates whether the row that is being grouped is a group header or not.
			/// args.aggregate: aggregate value.
			/// </param>
			groupText: null,

			/// <summary>
			/// The invalidCellValue event handler. A function called when a cell needs to start updating but the cell value is invalid.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the invalidCellValue event:
			/// $("#element").wijgrid({ invalidCellValue: function (e, args) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridinvalidcellvalue", function (e, args) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.cell: gets the information of edited cell.
			/// args.value: current value.
			/// </param>
			invalidCellValue: null,

			/// <summary>
			/// The pageIndexChanging event handler. A function called before page index is changed. Cancellable.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the pageIndexChanging event:
			/// $("#element").wijgrid({ pageIndexChanging: function (e, args) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridpageindexchanging", function (e, args) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.newPageIndex: new page index.
			/// </param>
			pageIndexChanging: null,

			/// <summary>
			/// The pageIndexChanged event handler. A function called after page index is changed.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the pageIndexChanged event:
			/// $("#element").wijgrid({ pageIndexChanged: function (e) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridpageindexchanged", function (e) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			pageIndexChanged: null,

			/// <summary>
			/// The selectionChanged event handler. A function called after the selection is changed.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the selectionChanged event:
			/// $("#element").wijgrid({ selectionChanged: function (e, args) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridselectionchanged", function (e, args) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.addedCells: cells added to the selection.
			/// args.removedCells: cells removed from the selection.
			/// </param>
			selectionChanged: null,

			/// <summary>
			/// The sorting event handler. A function called before the sorting operation is started. Cancellable.
			/// Type: Function.
			/// Default: null.
			/// Code example:
			/// Supply a callback function to handle the sorting event:
			/// $("#element").wijgrid({ sorting: function (e, args) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridsorting", function (e, args) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.column: column that is being sorted.
			/// args.sortDirection: new sort direction.
			/// </param>
			sorting: null,

			/// <summary>
			/// The sorted event handler. A function called after the widget is sorted.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the sorted event:
			/// $("#element").wijgrid({ sorted: function (e, args) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridsorted", function (e, args) { });
			/// </summary>
			///
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data with this event.
			/// args.column: column that is being sorted.
			/// </param>
			sorted: null,

			/* events --- */

			/* --- life-cycle events */
			/// <summary>
			/// The ajaxError event handler. A function called when wijgrid is bound to remote data and
			/// the ajax request fails.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the ajaxError event:
			/// $("#element").wijgrid({ ajaxError: function (e, args) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridajaxerror", function (e, args) { });
			/// </summary>
			/// <param name="e" type="Object">jQuery.Event object.</param>
			/// <param name="args" type="Object">
			/// The data corresponded with this event.
			/// args.XMLHttpRequest: the XMLHttpRequest object.
			/// args.textStatus: a string describing the error type.
			/// args.errorThrown: an exception object.
			///
			/// Refer to the jQuery.ajax.error event documentation for more details on this arguments.
			/// </param>
			ajaxError: null,

			/// <summary>
			/// The dataLoading event handler. A function called when wijgrid loads a portion of data from the underlying datasource.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the dataLoading event:
			/// $("#element").wijgrid({ dataLoading: function (e) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgriddataloading", function (e) { });
			/// </summary>
			/// <param name="e" type="Object">jQuery.Event object.</param>
			dataLoading: null,

			/// <summary>
			/// The dataLoaded event handler. A function called when data are loaded.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the dataLoaded event:
			/// $("#element").wijgrid({ dataLoaded: function (e) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgriddataloaded", function (e) { });
			/// </summary>
			/// <param name="e" type="Object">jQuery.Event object.</param>
			dataLoaded: null,

			/// <summary>
			/// The loading event handler. A function called at the beginning of the wijgrid's lifecycle.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the loading event:
			/// $("#element").wijgrid({ loading: function (e) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridloading", function (e) { });
			/// </summary>
			/// <param name="e" type="Object">jQuery.Event object.</param>
			loading: null,

			/// <summary>
			/// The loaded event handler. A function called at the end the wijgrid's lifecycle when wijgrid is
			/// filled with data and rendered.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the loaded event:
			/// $("#element").wijgrid({ loaded: function (e) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridloaded", function (e) { });
			/// </summary>
			/// <param name="e" type="Object">jQuery.Event object.</param>
			loaded: null,

			/// <summary>
			/// The rendering event handler. A function called when wijgrid is about to render.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the rendering event:
			/// $("#element").wijgrid({ rendering: function (e) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridrendering", function (e) { });
			/// </summary>
			/// <param name="e" type="Object">jQuery.Event object.</param>
			rendering: null,

			/// <summary>
			/// The rendered event handler. A function called when wijgrid is rendered.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a callback function to handle the rendered event:
			/// $("#element").wijgrid({ rendered: function (e) { } });
			/// Bind to the event by type:
			/// $("#element").bind("wijgridrendered", function (e) { });
			/// </summary>
			/// <param name="e" type="Object">jQuery.Event object.</param>
			rendered: null

			/* life-cycle events --- */
		},

		// private fields **
		_staticColumnIndex: -1,
		_data$prefix: "wijgrid",
		_customSortOrder: 1000,
		_reverseKey: false,
		_pageSizeKey: 10,
		// ** private fields

		_ajaxError: function (xhttpr, textStatus, error) {
			this._trigger("ajaxError", null, {
				XMLHttpRequest: xhttpr,
				textStatus: textStatus,
				errorThrown: error
			});

			this.outerDiv.removeClass("wijmo-wijgrid-loading");
		},

		_dataLoading: function (userData) {
			this._trigger("dataLoading");
			this.outerDiv.addClass("wijmo-wijgrid-loading");
		},

		_dataLoaded: function (userData) {
			this._trigger("dataLoaded");
			this.outerDiv.removeClass("wijmo-wijgrid-loading");
			this.doRefresh(userData);
			this._trigger("loaded");
		},

		ensureControl: function (loadData, userData) {
			/// <summary>
			/// Moves column widgets options to wijgrid options and renders wijgrid
			/// Code example: $("#element").wijgrid("ensureControl", true);
			/// </summary>
			/// <param name="loadData" type="Boolean">Determines if wijgrid must load data from linked data source before rendering.</param>
			this._trigger("loading");

			if (!$.isPlainObject(userData)) {
				userData = {
					data: null,
					afterRefresh: null,
					beforeRefresh: null
				};
			}

			if (this._initialized) {
				this._ownerise(false);
				this._widgetsToOptions();
			} else {
				this._prepareColumnOptions(false); // prepare static columns only
			}

			this._ownerise(true);

			if (loadData === true) {
				this._dataStore.load(userData);
			} else {
				this.doRefresh(userData);
				this._trigger("loaded");
			}
		},

		doRefresh: function (userData) {
			/// <summary>
			/// Re-renders wijgrid.
			/// Code example: $("#element").wijgrid("doRefresh");
			/// </summary>
			if (!this._initialized) {
				try {
					this._prepareColumnOptions(true); // prepare static and dynamic columns
				}
				catch (e) {
					throw e;
				}
				finally {
					this._initialized = true;
				}
			} else {
				if (userData && $.isFunction(userData.beforeRefresh)) {
					userData.beforeRefresh.apply(this);
				}
			}

			this._rebuildLeaves(); // build leaves, visible leaves, set dataIndex etc

			var dataSlice = this._dataStore.getDataSlice(),
				table = dataSlice.data,
				leaves, ri, rowsLen, dataItem, newItem, i, len, leaf, tmp;

			$.each(this._field("leaves"), function () { // copy totals
				this._totalsValue = (dataSlice.totals)
						? dataSlice.totals[this.dataKey]
						: undefined;
			});

			this._setPageCount(dataSlice);

			leaves = this._field("leaves");
			this.dataTable = [];

			if (rowsLen = table.length) { // process data items
				for (ri = 0; ri < rowsLen; ri++) {
					dataItem = table[ri];
					newItem = [];

					for (i = 0, len = leaves.length; i < len; i++) {
						leaf = leaves[i];

						if ($.wijmo.wijgrid.validDataKey(leaf.dataKey)) {
							newItem.push({
								value: dataItem.values[leaf.dataKey],
								__attr: (dataItem.attributes) ? dataItem.attributes.cellsAttributes[leaf.dataKey] : {},
								__style: {}
							});

							newItem.originalRowIndex = dataItem.originalRowIndex;
						}
					}

					newItem.rowType = $.wijmo.wijgrid.rowType.data;
					if (ri % 2 !== 0) {
						newItem.rowType |= $.wijmo.wijgrid.rowType.dataAlt;
					}

					newItem.__style = {};
					newItem.__attr = (dataItem.attributes) ? dataItem.attributes.rowAttributes : {};

					this.dataTable.push(newItem);
				}
			} else {
				// process empty data row
				if (dataSlice.emptyData && (rowsLen = dataSlice.emptyData.length)) {
					for (ri = 0; ri < rowsLen; ri++) {
						dataItem = dataSlice.emptyData[ri];
						newItem = [];
						tmp = this._field("visibleLeaves").length;

						for (i = 0, len = dataItem.length; i < len; i++) {
							newItem.push({
								html: dataItem[i],
								__attr: {
									colSpan: ((tmp > 0 && ri === rowsLen - 1)
										? tmp - ri
										: 1)
								},
								__style: {}
							});
						}

						newItem.rowType = $.wijmo.wijgrid.rowType.emptyDataRow;
						newItem.__style = {};
						newItem.__attr = {};

						this.dataTable.push(newItem);
					}
				}
			}

			this._trigger("rendering");
			this._refresh();
			this._trigger("rendered");

			if (userData && $.isFunction(userData.afterRefresh)) {
				userData.afterRefresh.apply(this);
			}
		},

		_prepareColumnOptions: function (dataLoaded) {
			$.wijmo.wijgrid.traverse(this.options.columns, function (column) {
				column.isBand = ($.isArray(column.columns) || (column.clientType === "c1band"));
			});

			// set .isLeaf
			new $.wijmo.wijgrid.bandProcessor()._getVisibleHeight(this.options.columns, true);

			// prepare leaves
			var leaves = [],
				boundedToDOM,
				headerRow = this._originalHeaderRowData(),
				footerRow = this._originalFooterRowData(),
				autogenerationMode = (this.options.columnsAutogenerationMode || "").toLowerCase();

			if (dataLoaded) {
				boundedToDOM = this._dataStore.dataMode() === $.wijmo.wijgrid.dataMode.dom;

				if (autogenerationMode !== "none") {
					(new $.wijmo.wijgrid.columnsGenerator(this)).generate(autogenerationMode, this._dataStore, this.options.columns);
				}
			}

			$.wijmo.wijgrid.setTraverseIndex(this.options.columns); // build indices (linearIdx, travIdx, parentIdx)

			// * merge options with defaults and build "pure" leaves list.
			$.wijmo.wijgrid.traverse(this.options.columns, function (column) {
				// merge options **
				column.isBand = ($.isArray(column.columns) || (column.clientType === "c1band"));

				$.wijmo.wijgrid.shallowMerge(column, $.wijmo.c1basefield.prototype.options); // merge with the c1basefield default options

				if (!column.isBand) {
					$.wijmo.wijgrid.shallowMerge(column, $.wijmo.c1field.prototype.options); // merge with the c1field default options

					if (!column.clientType) {
						column.clientType = "c1field";
					}
				} else {
					column.clientType = "c1band";
				}
				// ** merge options

				if (column.isLeaf && !column.isBand) {
					leaves.push(column);
				}
			});

			this._field("leaves", leaves); // contains static columns only when dataLoaded == false, used by the "dynamic data load" feature during request initialization.

			if (dataLoaded) {
				// assume headerText and footerText
				$.each(leaves, function (i, leaf) {
					var thIndex = (typeof (leaf.dataKey) === "number")
						? leaf.dataKey
						: i;

					if (autogenerationMode === "merge" || leaf.dynamic === true) { // assume headerText options of the static columns only when using "merge" mode.
						if (leaf.headerText === undefined) {
							if (boundedToDOM && headerRow && (thIndex < headerRow.length)) {
								leaf.headerText = $.trim(headerRow[thIndex]); // copy th
							} else {
								if ($.wijmo.wijgrid.validDataKey(leaf.dataKey)) {
									leaf.headerText = "" + leaf.dataKey; // copy dataKey
								}
							}
						}
					}

					if (boundedToDOM && footerRow && (thIndex < footerRow.length)) {
						leaf._footerTextDOM = $.trim(footerRow[thIndex]);
					}
				});

			}
		},

		_rebuildLeaves: function () {
			var tmpColumns = [],
				leaves = [],
				tmp;

			if (this.options.showRowHeader) { // append rowHeader
				tmp = $.wijmo.wijgrid.createDynamicField({ clientType: "c1basefield", dataIndex: -1, travIdx: -1, parentVis: true,
					allowMoving: false, allowSizing: false, allowSort: false
				});
				tmp.owner = this;
				tmpColumns.push(tmp);
			}

			$.each(this.options.columns, function (index, item) {
				tmpColumns.push(item); // append columns
			});

			// generate span table and build leaves
			this._field("spanTable", new $.wijmo.wijgrid.bandProcessor().generateSpanTable(tmpColumns, leaves));
			this._field("leaves", leaves);

			this._onLeavesCreated();
		},

		_onLeavesCreated: function () {
			var leaves = this._field("leaves"),
				dataIndex = 0,
				visLeavesIdx = 0,
				self = this;

			// build visible leaves list, set dataParsers, dataIndices
			this._field("visibleLeaves", $.grep(leaves, function (leaf, index) {
				leaf.leavesIdx = index;

				if ($.wijmo.wijgrid.validDataKey(leaf.dataKey)) {
					leaf.dataIndex = dataIndex++;
				} else {
					leaf.dataIndex = -1;
				}

				// attach data parser **
				if (!leaf.isBand) {
					self._ensureDataParser(leaf);

					if ($.isFunction(leaf.dataParser)) {
						leaf.dataParser = new leaf.dataParser();
					}
				}
				// ** attach data parser

				if (leaf.parentVis) {
					leaf.visLeavesIdx = visLeavesIdx++;
					return true;
				}

				return false;
			}));
		},

		_create: function () {
			if (!this.element.is("table")) {
				throw "invalid markup";
			}

			var styleHeight = this.element[0].style.height,
				styleWidth = this.element[0].style.width;

			this.rendered = false;

			// initialize data
			this._dataStore = new $.wijmo.wijgrid.dataStore(this);

			//this.element.addClass("ui-widget wijmo-wijgrid ui-widget-content ui-corner-all");
			this.element.addClass("wijmo-wijgrid-root");
			this.element.wrap("<div class=\"ui-widget wijmo-wijgrid ui-widget-content ui-corner-all\"></div>");
			this.outerDiv = this.element.parent();

			// -
			//this.outerDiv.css({ "height": this.element.css("height"), "width": this.element.css("width") });
			if (styleHeight) {
				this.outerDiv.css("height", this.element[0].style.height);
			}

			if (styleHeight !== "" && styleHeight !== "auto") {
				this._autoHeight = false;
			}
			else {
				this._autoHeight = true;
			}

			if (styleWidth) {
				this.outerDiv.css("width", this.element[0].style.width);
			}

			if (styleWidth !== "" && styleWidth !== "auto") {
				this._autoWidth = false;
			}
			else {
				this._autoWidth = true;
			}

			this.element.css({ "height": "", "width": "" });
			// -

			this.filterOperatorsCache = new $.wijmo.wijgrid.filterOperatorsCache();

			// process build-in filtering operators
			this._registerFilterOperator($.wijmo.wijgrid.embeddedFilters);

			if (this.options.disabled) {
				this.disable();
			}

			// formatters
			this.cellFormatter = new $.wijmo.wijgrid.cellFormatterHelper();
			this.rowStyleFormatter = new $.wijmo.wijgrid.rowStyleFormatterHelper(this);
			this.cellStyleFormatter = new $.wijmo.wijgrid.cellStyleFormatterHelper(this);
		},

		_init: function () {
			this.$superPanelHeader = null;
			this.$topPagerDiv = null;
			this.$bottomPagerDiv = null;

			// processing custom filtering operators
			this.filterOperatorsCache.removeCustom();
			$.each(this.options.customFilterOperators, function (index, value) {
				value.custom = true;
			});
			this._registerFilterOperator(this.options.customFilterOperators);

			// culture
			this._field("closestCulture", $.findClosestCulture(this.options.culture) || $.findClosestCulture("default"));

			if (!this.options.data) { // dataSource is a domTable
				if (!this._field("thead")) { // read tHead section
					this._field("thead", $.wijmo.wijgrid.readTableSection(this.element, 1));
				}

				if (!this._field("tfoot")) { // read tFoot section
					this._field("tfoot", $.wijmo.wijgrid.readTableSection(this.element, 3));
				}
			}

			this._initialized = this._initialized || false; // to avoid reinitialization.

			this.ensureControl(true);
		},

		_setOption: function (key, value) {
			var presetFunc = this["_preset_" + key],
				oldValue = this.options[key],
				optionChanged, postsetFunc;

			if (presetFunc !== undefined) {
				value = presetFunc.apply(this, [value, oldValue]);
			}

			optionChanged = (value !== oldValue);

			//$.Widget.prototype._setOption.apply(this, arguments); note: there is no dynamic linkage between the arguments and the formal parameter values when strict mode is used
			$.Widget.prototype._setOption.apply(this, [key, value]); // update this.options

			if (optionChanged) {
				postsetFunc = this["_postset_" + key];
				if (postsetFunc !== undefined) {
					postsetFunc.apply(this, [value, oldValue]);
				}
			}
		},

		destroy: function () {
			///	<summary>
			///	Destroy wijgrid widget and reset the DOM element.
			/// Code example: $("#element").wijgrid("destroy");
			///	</summary>

			var tmp,
				self = this;

			this._detachEvents(true);

			if (tmp = this._field("resizer")) {
				tmp.dispose();
			}

			$.wijmo.wijgrid.iterateChildrenWidgets(this.outerDiv, function (index, widget) {
				if (widget !== self) {
					widget.destroy();
				}
			});

			// YK: destroy outer div after restoring element.
			this.element.insertBefore(this.outerDiv);
			this.outerDiv.remove();

			if (tmp = this._field("selectionui")) {
				tmp.dispose();
			}

			if (tmp = this._field("dragndrop")) {
				tmp.dispose();
			}

			// cleanup $data
			$.wijmo.wijgrid.remove$dataByPrefix(this.element, this._data$prefix);

			$.Widget.prototype.destroy.apply(this, arguments);
		},

		// * public
		columns: function () {
			/// <summary>
			/// Returns a one-dimensional array of widgets bound to visible column headers.
			/// Code example: var colWidgets = $("#element").wijgrid("columns");
			/// </summary>
			/// <returns type="Array" elementType="$.wijmo.c1basefield">A one-dimensional array of widgets bound to visible column headers.</returns>
			return this._field("columns") || [];
		},

		currentCell: function (cellInfo /* cellIndex */, rowIndex /* opt */) {
			/// <summary>
			/// Gets or sets the current cell for the grid.
			/// Note: Use (-1, -1) value to hide the current cell.
			/// Code example:
			/// -) Getter:
			///   var current = $("#element).wijgrid("currentCell");
			/// -) Setter:
			///   $("#element).wijgrid("currentCell", new $.wijmo.wijgrid.cellInfo(0, 0));
			///   or
			///   $("#element).wijgrid("currentCell", 0, 0);
			/// </summary>
			/// <param name="cellInfo" type="$.wijmo.wijgrid.cellInfo">Object that represents a single cell.</param>
			/// <param name="cellIndex" type="Number" integer="true" optional="true">Zero-based index of the required cell inside the corresponding row.</param>
			/// <param name="rowIndex" type="Number" integer="true" optional="true">Zero-based index of the row that contains required cell.</param>
			/// <returns type="$.wijmo.wijgrid.cellInfo">Object that represents current cell of the grid</returns>

			var currentCell;

			if (arguments.length === 0) { // getter
				currentCell = this._field("currentCell");
				if (!currentCell) {
					this._field("currentCell", currentCell = $.wijmo.wijgrid.cellInfo.prototype.outsideValue);
				}
				return currentCell;
			} else { // setter

				currentCell = (arguments.length === 1)
					? cellInfo._clone()
					: new $.wijmo.wijgrid.cellInfo(cellInfo, rowIndex);

				if (!currentCell.isEqual($.wijmo.wijgrid.cellInfo.prototype.outsideValue)) {
					if (!currentCell._isValid()) {
						throw "invalid arguments";
					}

					currentCell._clip(this._getDataCellsRange());

					if (currentCell.rowIndex() >= 0 && !(this.dataTable[currentCell.rowIndex()].rowType & $.wijmo.wijgrid.rowType.data)) {
						return;
					}
				}

				currentCell._setGridView(this);

				this._changeCurrentCell(currentCell);

				return this._field("currentCell");
			}
		},

		data: function () {
			/// <summary>
			/// Gets a array of the underlying data.
			/// Code example: var data = $("#element").wijgrid("data");
			/// </summary>
			/// <returns type="Array"></returns>
			return this._dataStore.dataSource().items;
		},

		selection: function () {
			/// <summary>
			/// Gets an object that manages selection in the grid.
			/// Code example:
			///   var selection = $("#element").wijgrid("selection");
			/// </summary>
			/// <returns type="$.wijmo.wijgrid.selection">Object that manages selection in the grid.</returns>
			var selection = this._field("selection");
			if (!selection) {
				this._field("selection", selection = new $.wijmo.wijgrid.selection(this));
			}
			return selection;
		},

		beginEdit: function () {
			/// <summary>
			/// Puts the current cell in editing mode.
			/// Note: works only if the allowEditing option is set to true.
			/// Code example: $("#element").wijgrid("beginEdit");
			/// </summary>
			/// <returns type="Boolean">True if the cell is successfully put in edit mode, otherwise false.</returns>
			return this._beginEditInternal(null);
		},

		endEdit: function () {
			/// <summary>
			/// Finishes editing the current cell.
			/// Code example: $("#element").wijgrid("endEdit");
			/// </summary>
			return this._endEditInternal(null);
		},

		pageCount: function () {
			/// <summary>
			/// Gets the number of pages.
			/// Code example:
			/// var pageCount = $("#element").wijgrid("pageCount");
			/// </summary>
			/// <returns type="Number" integer="true">True if the cell is successfully put in edit mode, otherwise false.</returns>
			return this.options.allowPaging
				? this._field("pageCount") || 1
				: 1;
		},

		// * public
		_dragndrop: function () {
			var dnd = this._field("dragndrop");

			if (!dnd) {
				this._field("dragndrop", dnd = new $.wijmo.wijgrid.dragAndDropHelper(this));
			}

			return dnd;
		},

		_headerRows: function () {
			var accessor = this._field("headerRowsAccessor"),
				bottomOffset;

			if (!accessor) {
				bottomOffset = this.options.showFilter ? 1 : 0;
				this._field("headerRowsAccessor", accessor = new $.wijmo.wijgrid.rowAccessor(this._view(), 1 /* thead */, 0, bottomOffset));
			}

			return accessor;
		},

		_filterRow: function () {
			if (this.options.showFilter) {
				var tHeadAccessor = new $.wijmo.wijgrid.rowAccessor(this._view(), 1 /* thead */, 0, 0);

				return tHeadAccessor.item(tHeadAccessor.length() - 1); // filter is the last row in the tHead section
			}

			return null;
		},

		_rows: function () {
			var accessor = this._field("rowsAccessor");

			if (!accessor) {
				this._field("rowsAccessor", accessor = new $.wijmo.wijgrid.rowAccessor(this._view(), 2 /* tbody */, 0, 0));
			}

			return accessor;
		},

		_selectionui: function () {
			var selectionui = this._field("selectionui");

			if (!selectionui) {
				this._field("selectionui", selectionui = new $.wijmo.wijgrid.selectionui(this));
			}

			return selectionui;
		},

		_setPageCount: function (dataSlice) {
			this._field("pageCount", Math.ceil(dataSlice.totalRows / this.options.pageSize) || 1);
		},

		_registerFilterOperator: function (value) {
			var i, len;

			if (value && $.isArray(value)) {
				for (i = 0, len = value.length; i < len; i++) {
					this.filterOperatorsCache.add(value[i]);
				}
			}
			else {
				for (i = 0, len = arguments.length; i < len; i++) {
					this.filterOperatorsCache.add(arguments[i]);
				}
			}
		},

		//

		// * propeties (pre-\ post-)
		_postset_allowColMoving: function (value, oldValue) {
			var self = this;

			$.each(this.columns(), function (idx, wijField) {
				if (value) {
					self._dragndrop().attach(wijField);
				} else {
					self._dragndrop().detach(wijField);
				}
			});

			$.each(this._field("groupWidgets"), function (idx, wijField) {
				if (value) {
					self._dragndrop().attach(wijField);
				} else {
					self._dragndrop().detach(wijField);
				}
			});
		},

		_postset_allowSorting: function (value, oldValue) {
			this.ensureControl(false);
		},

		_postset_columns: function (value, oldValue) {
			throw "read-only";
		},

		_postset_allowPaging: function (value, oldValue) {
			this.ensureControl(true);
		},

		_postset_culture: function (value, oldValue) {
			//this._field("closestCulture", $.findClosestCulture(this.options.culture));
			throw "read-only";
		},

		_postset_customFilterOperators: function (value, oldValue) {
			this.filterOperatorsCache.removeCustom();
			$.each(this.options.customFilterOperators, function (index, value) {
				value.custom = true;
			});
			this._registerFilterOperator(value);
		},

		_postset_data: function (value, oldValue) {
			throw "read-only";
		},

		_postset_disabled: function (value, oldValue) {
			// update children widgets
			var self = this;

			$.wijmo.wijgrid.iterateChildrenWidgets(this.outerDiv, function (index, widget) {
				if (widget !== self) {
					widget.option("disabled", value);
				}
			});
		},

		_postset_groupIndent: function (value, oldValue) {
			this.ensureControl(false);
		},

		_preset_pageIndex: function (value, oldValue) {
			if (isNaN(value)) {
				throw "out of range";
			}

			var pageCount = this.pageCount();

			if (value > pageCount - 1) {
				value = pageCount - 1;
			}

			if (value < 0) {
				value = 0;
			}

			if (this.options.allowPaging && value !== oldValue) {
				if (!this._onPageIndexChanging({ newPageIndex: value })) {
					value = oldValue;
				}
			}

			return value;
		},

		_postset_pageIndex: function (value, oldValue) {
			if (this.options.allowPaging) {
				this.ensureControl(true, {
					afterRefresh: function () { this._onPageIndexChanged(); }
				});
			}
		},

		_preset_pageSize: function (value, oldValue) {
			if (isNaN(value)) {
				throw "out of range";
			}

			if (value <= 0) {
				value = 1;
			}

			return value;
		},

		_postset_pageSize: function (value, oldValue) {
			this.options.pageIndex = 0;

			if (this.options.allowPaging) {
				this.ensureControl(true);
			}
		},

		_postset_pagerSettings: function (value, oldValue) {
			this.ensureControl(false);
		},

		_postset_scrollMode: function (value, oldValue) {
			if (value === "none" || oldValue === "none") { // wijsuperpanel is enabled or disabled.
				this.ensureControl(false);
			} else { // wijsuperpanel is used, updating it.
				// refresh panel.
				this._view().refreshPanel();
			}
		},

		_postset_selectionMode: function (value, oldValue) {
			var selection = this.selection(),
				currentCell = this.currentCell();

			selection.beginUpdate();

			selection.clear();

			if (currentCell && currentCell._isValid()) {
				selection._selectRange(new $.wijmo.wijgrid.cellInfoRange(currentCell, currentCell), false, false, 0 /* none */, null);
			}

			selection.endUpdate();
		},

		_postset_showFilter: function (value, oldValue) {
			this.ensureControl(false);
		},

		_postset_showRowHeader: function (value, oldValue) {
			this.ensureControl(false);
		},

		_postset_staticRowIndex: function () {
			if (this.options.scrollMode !== "none") { // staticRowIndex is ignored when scrolling is turned off.
				this.ensureControl(false);
			}
		},
		/*_postset_staticColumnIndex: function() {
		//this._refresh(0);
		this._ensureControl(0);
		},*/

		// * propeties (pre-\ post-)

		// * private
		_columnWidgetsFactory: function ($node, columnOpt) {
			var columnWidget,
				clientType = columnOpt.clientType;

			if (!clientType && columnOpt.isBand) {
				clientType = "c1band";
			}

			//columnOpt.owner = this;
			columnOpt = $.extend({ owner: this }, columnOpt, { disabled: this.options.disabled });

			switch (clientType) {
				case "c1basefield":
					columnWidget = $node.c1basefield(columnOpt);
					break;

				case "c1band":
					columnWidget = $node.c1band(columnOpt);
					break;

				default:
					columnWidget = $node.c1field(columnOpt);
			}

			return columnWidget;
		},

		_field: function (name, value) {
			//return $.wijmo.wijgrid.dataPrefix(this.element, this._data$prefix, name, value);
			return $.wijmo.wijgrid.dataPrefix(this.element[0], this._data$prefix, name, value);
		},

		_removeField: function (name) {
			var internalDataName = this._data$prefix + name;

			this.element.removeData(internalDataName);
		},

		_changeRenderState: function ($obj, state, combine) {
			var $dp = $.wijmo.wijgrid.dataPrefix,
				prevState = $dp($obj, this._data$prefix, "renderState");

			if (combine) { // combine
				state = prevState | state;
				$dp($obj, this._data$prefix, "renderState", state);
			} else { // clear
				state = prevState & ~state;
				$dp($obj, this._data$prefix, "renderState", state);
			}

			return state;
		},

		_prepareFilterRequest: function (isLocal) {
			var leaves = this._field("leaves"),
				result;

			if (!leaves) {
				return [];
			}

			result = $.map(leaves, $.proxy(function (element, index) {
				if (!element.isBand && ($.wijmo.wijgrid.validDataKey(element.dataKey)/*element.dataIndex >= 0*/) && element.filterOperator) {
					var opName = element.filterOperator.toLowerCase(),
						operator;

					// check operator name
					if (opName !== "nofilter" && (operator = this.filterOperatorsCache.getByName(opName))) {

						// check dataType
						if ($.inArray(element.dataType || "string", operator.applicableTo) >= 0) {

							// check arity + filterValue
							if (operator.arity === 1 || (operator.arity > 1 && element.filterValue !== undefined)) {
								return (isLocal)
									? [{ column: element, operator: operator}]
									: [{ dataKey: element.dataKey, filterOperator: element.filterOperator, filterValue: element.filterValue}];
							}
						}
					}
				}

				return null;
			}, this));

			return result;
		},

		_preparePageRequest: function (isLocal) {
			if (this.options.allowPaging) {
				return {
					pageIndex: this.options.pageIndex,
					pageSize: this.options.pageSize
				};
			}
			return null;
		},

		_prepareSortRequest: function (isLocal) {
			var leaves = this._field("leaves"),
				result;

			if (!leaves || !this.options.allowSorting) {
				return [];
			}

			result = $.map(leaves, function (element, index) {
				var value = null;

				if (!element.isBand && element.allowSort && ($.wijmo.wijgrid.validDataKey(element.dataKey))) {
					if (element.groupInfo && (element.groupInfo.position !== "none") && (element.sortDirection === "none")) {
						element.sortDirection = "ascending"; // use "ascending" for grouped columns by default
					}

					value = (element.sortDirection === "ascending" || element.sortDirection === "descending")
						? [{ dataKey: element.dataKey,
							sortDirection: element.sortDirection,
							sortOrder: element.sortOrder || 0
						}]
						: null;
				}

				return value;
			});

			// sort by .sortOrder
			result.sort(function (a, b) {
				return a.sortOrder - b.sortOrder;
			});

			// remove .sortOrder
			$.each(result, function (idx, item) {
				//item.sortOrder = idx;
				delete item.sortOrder;
			});

			return result;
		},

		_prepareTotalsRequest: function (isLocal) {
			var leaves = this._field("leaves"),
				result;

			if (!leaves || !this.options.showFooter) {
				return [];
			}

			result = $.map(leaves, function (element, index) {
				if (!element.isBand && $.wijmo.wijgrid.validDataKey(element.dataKey) && element.aggregate && element.aggregate !== "none") {
					return (isLocal)
						? [{ column: element, aggregate: element.aggregate}]
						: [{ dataKey: element.dataKey, aggregate: element.aggregate}];
				}

				return null;
			});

			return result;
		},

		_widgetsToOptions: function () {
			var colOptionsList = $.wijmo.wijgrid.flatten(this.options.columns);

			$.each(this.columns(), function (index, colWidget) {
				delete colWidget.options.columns; // only options of the column itself will be merged at the next step.
				var congruentColOption = colOptionsList[colWidget.options.travIdx];
				$.extend(true, congruentColOption, colWidget.options);
			});
		},

		_recreateColumnWidgets: function () {
			$.each(this.columns(), function (index, item) {
				item.destroy();
			});

			var columns = [],
				headerRows = this._headerRows(),
				visibleColumns, i, len, column, headerRowObj, th, columnWidget;

			if (/* tHead.length*/headerRows && headerRows.length()) {
				visibleColumns = []; // visible bands and leaves

				$.wijmo.wijgrid.traverse(this.options.columns, function (column) {
					if (column.parentVis) {
						visibleColumns.push(column);
					}
				});

				for (i = 0, len = visibleColumns.length; i < len; i++) {
					column = visibleColumns[i];
					headerRowObj = headerRows.item(column.thY);
					th = new $.wijmo.wijgrid.rowAccessor().getCell(headerRowObj, column.thX);

					columnWidget = this._columnWidgetsFactory($(th), column);
					columns.push(columnWidget.data(columnWidget.data($.wijmo.c1basefield.prototype._data$prefix + "widgetName"))); // store actual widget instance
				}
			}

			this._field("columns", columns);
		},

		_ownerise: function (flag) {
			if (flag) {
				var self = this;

				$.wijmo.wijgrid.traverse(this.options.columns, function (column) {
					column.owner = self;

					var tmp, i, len;

					if ((tmp = column.groupInfo)) {
						tmp.owner = column;

						if (tmp.expandInfo) {
							for (i = 0, len = tmp.expandInfo.length; i < len; i++) {
								tmp.expandInfo[i].owner = tmp;
							}
						}
					}
				});
			} else {

				$.wijmo.wijgrid.traverse(this.options.columns, function (column) {
					delete column.owner;

					var tmp, i, len;

					if ((tmp = column.groupInfo)) {
						delete tmp.owner;

						if (tmp.expandInfo) {
							for (i = 0, len = tmp.expandInfo.length; i < len; i++) {
								delete tmp.expandInfo[i].owner;
							}
						}
					}
				});
			}
		},

		_updateSplits: function (scrollValue) {
			if (this._view().updateSplits !== null) {
				this._view().updateSplits(scrollValue);
			}
		},

		_refresh: function () {
			var i = 0, j = -1,
				view, currentCell, resizer,
				scrollValue = { type: "", hScrollValue: null, vScrollValue: null },
				filterEditorsInfo = [];

			//$.wijmo.wijgrid.timerOn("refresh");

			if (this._view()) {
				scrollValue = this._view().getScrollValue();
			}

			this._detachEvents(false);

			this.element.detach();
			this.element.empty();
			this.outerDiv.empty();
			this.outerDiv.append(this.element);

			if (this._field("selectionui")) {
				this._field("selectionui").dispose();
				this._field("selectionui", null);
			}

			if (this._field("headerRowsAccessor")) {
				this._field("headerRowsAccessor", null);
			}

			if (this._field("rowsAccessor")) {
				this._field("rowsAccessor", null);
			}

			if (this._field("resizer")) {
				this._field("resizer").dispose();
			}

			// apply grouping
			new $.wijmo.wijgrid.grouper().group(this, this.dataTable, this._field("leaves"));

			// apply merging
			new $.wijmo.wijgrid.merger().merge(this.dataTable, this._field("visibleLeaves"));

			// view
			//if (!this.options.splits && (this.options.staticRowIndex >= 0 || this.options.staticColumnIndex >= 0)) {
			// only support fixing row feature in this version.
			if (this.options.scrollMode !== "none" && (this._staticColumnIndex >= 0 || this.options.staticRowIndex >= 0)) {
				this._field("view", view = new $.wijmo.wijgrid.fixedView(this));
			} else {
				this._field("view", view = new $.wijmo.wijgrid.flatView(this));
			}
			view.initialize();

			this._render();

			// (re)create iternal widgets
			this._ownerise(false);
			this._recreateColumnWidgets();
			this._ownerise(true);

			// pager
			if (this.options.allowPaging) {
				// top pager
				if (this.$topPagerDiv) {
					this.$topPagerDiv.wijpager(this._pagerSettings2PagerWidgetSettings());
				}

				// bottom pager
				if (this.$bottomPagerDiv) {
					this.$bottomPagerDiv.wijpager(this._pagerSettings2PagerWidgetSettings());
				}
			}

			// (re)create iternal widgets

			// update css
			//this._updateCss();

			// attach events
			this._attachEvents();

			// currentCell
			$(view.focusableElement()).attr("tabIndex", 0); // to handle keyboard\ focus events

			//because after setting some options affecting the current cell,
			//the current cell info is not correct.
			//if (this.currentCell()._isValid()) {
			//	this.currentCell(this.currentCell())._isEdit(false);
			if (this.currentCell()._isValid() && this.currentCell(this.currentCell())) {
				this.currentCell()._isEdit(false);
			} else {
				i = 0;
				j = -1;

				while (this.dataTable[i] && j < 0) {
					if (this.dataTable[i].rowType & $.wijmo.wijgrid.rowType.data) {
						j = i;
					}
					i++;
				}

				if (j >= 0) { // first datarow
					this.currentCell(new $.wijmo.wijgrid.cellInfo(0, j));
				}
			}

			// selection
			this._field("selection", null); // always recreate selection object
			currentCell = this.currentCell();
			if (currentCell._isValid()) {
				this.selection()._startNewTransaction(currentCell);
				this.selection()._selectRange(new $.wijmo.wijgrid.cellInfoRange(currentCell, currentCell), false, false, 0 /* none */, null);
			}

			// selection ui
			this._selectionui();

			// initialize resizer
			resizer = new $.wijmo.wijgrid.resizer(this);
			$.each(this.columns(), function (index, colWidget) {
				var o = colWidget.options;

				if (o.visible && o.parentVis && o.isLeaf) {
					resizer.addElement(colWidget);
				}
			});
			this._field("resizer", resizer);

			this.rendered = true;

			this._updateSplits(scrollValue); /*dma*/

			// update filter editors widths
			$.each(this.columns(), function (index, colWidget) {
				if (!colWidget.options.isBand && colWidget.options.showFilter === true) {
					var width = colWidget._getFilterEditorWidth();

					if (width !== undefined) {
						filterEditorsInfo.push({
							widget: colWidget,
							width: width
						});
					}
				}
			});

			$.each(filterEditorsInfo, function (index, item) {
				item.widget._setFilterEditorWidth(item.width);
			});

			//window.defaultStatus = $.wijmo.wijgrid.timerOff("refresh");
		},

		_render: function () {
			var view = this._view(),
				content;

			view.render(0xFF);

			// YK: for fixing pager is not align to top and bottom when header is fixed.
			content = this.outerDiv;
			if (this.options.scrollMode !== "none") {
				// fixed header content
				if (this.options.staticRowIndex >= 0) {
					content = this.outerDiv.find("div.wijmo-wijgrid-scroller:first");
				}
				else {
					content = this.outerDiv.find(".wijmo-wijgrid-content-area");
				}
			}

			this.$superPanelHeader = null;

			// top pager (top div)
			if (this.$topPagerDiv) {
				if (this.$topPagerDiv.data("wijpager")) {
					this.$topPagerDiv.wijpager("destroy");
				}

				this.$topPagerDiv.remove();
			}

			this.$topPagerDiv = null;

			if (this.options.allowPaging && ((this.options.pagerSettings.position === "top") || (this.options.pagerSettings.position === "topAndBottom"))) {
				if (!this.$topPagerDiv) {
					content.prepend(this.$superPanelHeader = $("<div class=\"wijmo-wijsuperpanel-header\"></div>"));
					this.$superPanelHeader.prepend(this.$topPagerDiv = $("<div class=\"wijmo-wijgrid-header ui-widget-header ui-corner-top\"></div>"));
				}
			}

			if (this.options.showGroupArea) {
				this._processGroupArea(content);
			}

			// bottom pager (bottom div)
			if (this.$bottomPagerDiv) {
				if (this.$bottomPagerDiv.data("wijpager")) {
					this.$bottomPagerDiv.wijpager("destroy");
				}

				this.$bottomPagerDiv.remove();
			}

			this.$bottomPagerDiv = null;

			if (this.options.allowPaging && ((this.options.pagerSettings.position === "bottom") || (this.options.pagerSettings.position === "topAndBottom"))) {
				if (!this.$bottomPagerDiv) {
					content.append(this.$bottomPagerDiv = $("<div class=\"wijmo-wijgrid-footer wijmo-wijsuperpanel-footer ui-state-default ui-corner-bottom\"></div>"));
				}
			}
		},

		_processGroupArea: function (content) {
			var self = this,
				leafCollection,
				groupCollection = this._field("groups"),
				groupingDiv,
				groupElement,
				groupWidgetCollection = [];

			groupingDiv = $("<div class=\"ui-widget-content ui-helper-clearfix\"></div>");

			if (groupCollection.length > 0) {
				$.each(groupCollection, function (index, item) {
					groupElement = $("<a href=\"#\"></a>").appendTo(groupingDiv);
					groupElement.c1groupedfield($.extend({ owner: self }, {
						allowMoving: item.allowMoving,
						allowSort: item.allowSort,
						dataIndex: item.dataIndex,
						headerText: item.headerText,
						isBand: item.isBand,
						isLeaf: item.isLeaf,
						linearIdx: item.linearIdx,
						parentIdx: item.parentIdx,
						sortDirection: item.sortDirection,
						travIdx: item.travIdx,
						groupedIndex: item.groupedIndex
					}, { disabled: self.options.disabled }));
					groupWidgetCollection.push(groupElement.data("c1groupedfield"));
				});
			}
			else {
				groupingDiv
					.addClass("wijmo-wijgrid-group-area")
					.html(self.options.groupAreaCaption !== "" ? self.options.groupAreaCaption : "&nbsp;");
			}

			this._field("groupWidgets", groupWidgetCollection);
			if (!this.$superPanelHeader) {
				content.prepend(this.$superPanelHeader = $("<div class=\"wijmo-wijsuperpanel-header\"></div>"));
			}

			this.$superPanelHeader.prepend(groupingDiv);
			this._dragndrop().attachGroupArea(groupingDiv);
		},

		/*
		_updateCss: function() {
		var view = this._view();

		$.each(view.subTables(), function(index, item) {
		var domTable = item.element();
		$(domTable).addClass("wijmo-wijgrid-table");

		if (domTable.tBodies) {
		var tBody = domTable.tBodies[0];
		if (tBody) {
		$(tBody).addClass("ui-widget-content wijmo-wijgrid-data");
		}
		}
		});

		view.updateCss();
		},*/

		_attachEvents: function () {
			var view = this._view(),
				$fe = $(view.focusableElement());

			$fe.bind("keydown." + this.widgetName, $.proxy(this._onKeyDown, this));
			$fe.bind("keypress." + this.widgetName, $.proxy(this._onKeyPress, this));

			$.each(view.subTables(), $.proxy(function (index, element) {
				var domTable = element.element();
				if (domTable) {
					if (domTable.tHead) {
						$(domTable.tHead).bind("click." + this.widgetName, $.proxy(this._onClick, this));
					}

					if (domTable.tBodies.length) {
						$(domTable.tBodies[0])
							.bind("click." + this.widgetName, $.proxy(this._onClick, this))
							.bind("dblclick." + this.widgetName, $.proxy(this._onDblClick, this))
							.bind("mousemove." + this.widgetName, $.proxy(this._onMouseMove, this))
							.bind("mouseout." + this.widgetName, $.proxy(this._onMouseOut, this));
					}
				}
			}, this));

			// attach "onGroupExpandCollapseIconClick" event
			$.each(view.getJoinedTables(true, 0), $.proxy(function (index, item) {
				if (item && typeof (item) !== "number") {
					var domTable = item.element(); // item is a htmlTableAccessor instance

					$(domTable)
						.find("> tbody")
						.find("> tr.wijmo-wijgrid-groupheaderrow > td .wijmo-wijgrid-grouptogglebtn")
						.bind("click." + this.widgetName, $.proxy(this._onGroupBtnClick, this));
				}
			}, this));

			view.attachEvents();
		},

		_detachEvents: function (destroy) {
			var view = this._view(),
				self = this,
				$fe;

			if (view) {
				$fe = $(view.focusableElement());

				$fe.unbind("keydown." + this.widgetName);
				$fe.unbind("keypress." + this.widgetName);

				$.each(view.subTables(), function () {
					var domTable = this.element(); // item (this) is a htmlTableAccessor instance 

					if (domTable) {
						if (domTable.tHead) {
							$(domTable.tHead).unbind("." + self.widgetName);
						}

						if (domTable.tBodies.length) {
							$(domTable.tBodies[0]).unbind("." + self.widgetName);
						}
					}
				});

				if (destroy) {
					// detach "onGroupExpandCollapseIconClick" event
					$.each(view.getJoinedTables(true, 0), function (index, item) {
						if (item && typeof (item) !== "number") {
							$(item.element()) // item (this) is a htmlTableAccessor instance 
								.find("> tbody")
								.find("> tr.wijmo-wijgrid-groupheaderrow > td .wijmo-wijgrid-grouptogglebtn")
								.unbind("." + self.widgetName);
						}
					});
				}

				//view.detachEvents();
			}
		},

		_handleSort: function (column, multiSort) {
			var columns = this.options.columns,
				travIdx = column.travIdx,
				newSortDirection, args;

			//if (this.options.allowSorting && ($.inArray(columnWidget, columns) >= 0)) {
			if (column && this.options.allowSorting) {
				newSortDirection = ((column.sortDirection === "none")
					? "ascending"
					: ((column.sortDirection === "ascending") ? "descending" : "ascending"));

				args = { column: column, sortDirection: newSortDirection };

				if (this._onColumnSorting(args)) {
					args.column.sortDirection = args.sortDirection;

					if (multiSort) {
						args.column.sortOrder = this._customSortOrder++;
					} else {
						this._customSortOrder = 1000; // reset to default

						// reset sortDirection for all column widgets except sorting one and grouped columns
						$.each(this.columns(), function (index, item) {
							item.options.sortOrder = 0;

							if (item.options.travIdx !== travIdx && !(item.options.groupInfo && item.options.groupInfo.position !== "none")) {
								item.options.sortDirection = "none";
							}
						});

						// ensure invisible columns.
						$.wijmo.wijgrid.traverse(columns, function (item) {
							item.sortOrder = 0;

							if (item.travIdx !== travIdx && !(item.groupInfo && item.groupInfo.position !== "none")) {
								item.sortDirection = "none";
							}
						});
					}

					this.ensureControl(true, {
						afterRefresh: function () { this._onColumnSorted({ column: args.column }); }
					});
				}
			}
		},

		_pagerSettings2PagerWidgetSettings: function () {
			return $.extend({}, this.options.pagerSettings,
				{
					disabled: this.options.disabled,
					pageCount: this.pageCount(),
					pageIndex: this.options.pageIndex,
					pageIndexChanging: $.proxy(this._onPagerWidgetPageIndexChanging, this),
					pageIndexChanged: $.proxy(this._onPagerWidgetPageIndexChanged, this)
				});
		},

		_handleDragnDrop: function (dragTravIdx, dropTravIdx, at, dragInGroup, dropInGroup) {
			var drag = $.wijmo.wijgrid.getColumnByTravIdx(this.options.columns, dragTravIdx),
				drop,
				dragSource = dragInGroup ? "groupArea" : "columns",
				dropSource = dropInGroup ? "groupArea" : "columns";

			if (dropTravIdx == -1 && dropInGroup === true && dragInGroup !== true) {
				if (this._onColumnDropping({ drag: drag.found, drop: null, dragSource: dragSource, dropSource: dropSource, at: at })) {
					this.ensureControl(true, {
						beforeRefresh: function () {
							drag.found.groupedIndex = 0;

							$.extend(true, drag.found, {
								groupInfo: {
									position: "header"
								}
							});
						},

						afterRefresh: function () { this._onColumnDropped({ drag: drag.found, drop: null, dragSource: dragSource, dropSource: dropSource, at: at }); }
					});
				}

				return;
			}

			drop = $.wijmo.wijgrid.getColumnByTravIdx(this.options.columns, dropTravIdx);

			//window.defaultStatus = drag.headerText + " to " + drop.headerText + " at " + at;

			if (this._onColumnDropping({ drag: drag.found, drop: drop.found, dragSource: dragSource, dropSource: dropSource, at: at })) {
				this.ensureControl(dropInGroup === true, {
					beforeRefresh: function () {
						if (dropInGroup === true) {
							switch (at) {
								case "left":
									drag.found.groupedIndex = drop.found.groupedIndex - 0.5;
									break;

								case "right":
									drag.found.groupedIndex = drop.found.groupedIndex + 0.5;
									break;
							}

							if (dragInGroup !== true) {
								$.extend(true, drag.found, {
									groupInfo: {
										position: "header"
									}
								});
							}

							return;
						}

						/* modifying the wijgrid.options.columns option */
						drag.at.splice(drag.found.linearIdx, 1);

						//because when drag is before drop, the index of drop is affected.
						switch (at) {
							case "left":
								if (drag.at === drop.at && drag.found.linearIdx < drop.found.linearIdx) {
									drop.at.splice(drop.found.linearIdx - 1, 0, drag.found);
								} else {
									drop.at.splice(drop.found.linearIdx, 0, drag.found);
								}
								break;

							case "right":
								if (drag.at === drop.at && drag.found.linearIdx < drop.found.linearIdx) {
									drop.at.splice(drop.found.linearIdx, 0, drag.found);
								} else {
									drop.at.splice(drop.found.linearIdx + 1, 0, drag.found);
								}
								break;

							case "center": // drop is a band
								drop.found.columns.push(drag.found);
								break;
						}

						// rebuild indices (linearIdx, travIdx, parentIdx)
						$.wijmo.wijgrid.setTraverseIndex(this.options.columns);
					},

					afterRefresh: function () { this._onColumnDropped({ drag: drag.found, drop: drop.found, dragSource: dragSource, dropSource: dropSource, at: at }); }
				});
			}
		},

		_handleFilter: function (column, rawOperator, rawValue) {
			var operator = this.filterOperatorsCache.getByName(rawOperator),
				value, ok;

			if (operator) {
				if (operator.arity > 1) {
					// check value
					value = this._parse(column.options, rawValue);
					ok = (value !== null && (column.options.dataType === "string" || !isNaN(value)));
				} else {
					ok = true;
				}

				if (ok) {
					if (this._onColumnFiltering({ column: column.options, operator: operator.name, value: value })) {
						column.options.filterValue = value;
						column.options.filterOperator = operator.name;

						this.options.pageIndex = 0;

						this.ensureControl(true, {
							afterRefresh: function () { this._onColumnFiltered({ column: column.options }); }
						});
					}
				}
			}
		},

		// * event handlers

		_onColumnDropping: function (args) {
			return this._trigger("columnDropping", null, args);
		},

		_onColumnDropped: function (args) {
			this._trigger("columnDropped", null, args);
		},

		_onColumnFiltering: function (args) {
			return true;
		},

		_onColumnFiltered: function (args) {
		},

		_onColumnSorting: function (args) {
			return this._trigger("sorting", null, args);
		},

		_onColumnSorted: function (args) {
			this._trigger("sorted", null, args);
		},

		_onCurrentCellChanged: function () {
			if (this.options.allowKeyboardNavigation) {
				var currentCell = this._field("currentCell");

				if (currentCell && !currentCell.isEqual(currentCell.outsideValue)) {
					this._view().scrollTo(currentCell);
				}
			}

			this._trigger("currentCellChanged");
		},

		_onPageIndexChanging: function (args) {
			return this._trigger("pageIndexChanging", null, args);
		},

		_onPageIndexChanged: function (args) {
			this._trigger("pageIndexChanged");
		},

		_onPagerWidgetPageIndexChanging: function (sender, args) {
			args.handled = true;
		},

		_onPagerWidgetPageIndexChanged: function (sender, args) {
			this._setOption("pageIndex", args.newPageIndex);
		},

		_onClick: function (args) {
			if (!this._canInteract() || !args.target) {
				return;
			}

			// info[0] - clicked cell
			// info[1] - wijmo-wijgrid-table
			var view = this._view(),
				info = this._getParentSubTable(args.target, ["td", "th"], view.subTables()),
				clickedCell, $row, clickedCellInfo,
				extendMode = 0, // none
				currentCell, selection;

			if (info) {
				clickedCell = info[0];

				$row = $(clickedCell).closest("tr");

				if (!($row.is(".wijmo-wijgrid-datarow") || $row.is(".wijmo-wijgrid-headerrow"))) {
					return;
				}

				if (!$row.length) {
					return;
				}

				clickedCellInfo = view.getAbsCellInfo(clickedCell)._dataToAbs(this._getDataToAbsOffset());

				if (clickedCellInfo.cellIndex() < 0 || clickedCellInfo.rowIndex() < 0) { // header cell, rowheader cell or filter cell

					if (clickedCellInfo.rowIndex() >= 0) { // rowheader cell
						// move current cell to the first cell of the clicked row
						clickedCellInfo = new $.wijmo.wijgrid.cellInfo(0, clickedCellInfo.rowIndex());
						extendMode = 2; // extend to row
					} else { // header cell
						// move current cell to the first cell of the clicked column
						clickedCellInfo = new $.wijmo.wijgrid.cellInfo(clickedCellInfo.cellIndex(), 0);
						extendMode = 1; // extend to column
					}
				}

				this._changeCurrentCell(clickedCellInfo);

				currentCell = this.currentCell();
				selection = this.selection();

				if (!args.shiftKey || (!selection._multipleRangesAllowed() && this.options.selectionMode.toLowerCase() !== "singlerange")) {
					selection._startNewTransaction(currentCell);
				}

				selection.beginUpdate();

				if (args.shiftKey && args.ctrlKey) {
					selection._clearRange(new $.wijmo.wijgrid.cellInfoRange(currentCell, currentCell), extendMode);
				} else {
					selection._selectRange(new $.wijmo.wijgrid.cellInfoRange(selection._anchorCell(), currentCell), args.ctrlKey, args.shiftKey, extendMode, null);
				}

				selection.endUpdate();
			}
		},

		_onDblClick: function (args) {
			this._beginEditInternal(args);
		},

		_onGroupBtnClick: function (args) {
			var $row = $(args.target).closest("tr"),
				gh = new $.wijmo.wijgrid.groupHelper(),
				groupInfo = gh.getGroupInfo($row[0]),
				column, group;

			if (groupInfo) {
				column = gh.getColumnByGroupLevel(this._field("leaves"), groupInfo.level);
				if (column) {
					group = column.groupInfo.expandInfo[groupInfo.index];

					if (group.isExpanded) {
						group.collapse(args.shiftKey);
					} else {
						group.expand(args.shiftKey);
					}
					this._view().ensureWidth(); /*dma*/
				}
			}
		},

		_onKeyDown: function (args) {
			if (!this._canInteract) {
				return true;
			}

			var tag = args.target.tagName.toLowerCase(),
				canChangePos = false,
				curPos, cell, currentCell, selection;

			if ((tag === "input" || tag === "option" || tag === "select" || tag === "textarea") &&
				 ($(args.target).closest("tr.wijmo-wijgrid-datarow").length === 0)) { // not a datarow ?
				return true;
			}

			if (this.options.allowEditing) {
				if (args.which === 113) { // F2: start editing
					this._beginEditInternal(args);
					return false;
				} else
				// ESC: cancel editing
					if ((args.which === $.ui.keyCode.ESCAPE) && (this.currentCell()._isValid() && this.currentCell()._isEdit())) {
						this._endEditInternal(args);
						return false;
					}
			}

			if (!this.options.allowKeyboardNavigation) {
				return true;
			}

			//switch (args.keyCode) {
			switch (args.which) {
				case $.ui.keyCode.LEFT:
				case $.ui.keyCode.RIGHT:
				case $.ui.keyCode.DOWN:
				case $.ui.keyCode.UP:
				case $.ui.keyCode.PAGE_DOWN:
				case $.ui.keyCode.PAGE_UP:
				case $.ui.keyCode.HOME:
				case $.ui.keyCode.END:
				case $.ui.keyCode.TAB:

					curPos = this._getNextCurrencyPos(this._getDataCellsRange(), this.currentCell(), args.keyCode, args.shiftKey);
					canChangePos = this._canMoveToAnotherCell(args.target, args.which); // TODO: add tab navigation

					break;
			}

			if (canChangePos) {
				cell = this._changeCurrentCell(new $.wijmo.wijgrid.cellInfo(curPos.cellIndex, curPos.rowIndex));

				currentCell = this.currentCell();
				selection = this.selection();

				if (!args.shiftKey || (!selection._multipleRangesAllowed() && this.options.selectionMode.toLowerCase() !== "singlerange")) {
					selection._startNewTransaction(currentCell);
				}

				selection.beginUpdate();
				selection._selectRange(new $.wijmo.wijgrid.cellInfoRange(selection._anchorCell(), currentCell), false, args.shiftKey, 0 /* none */, null);
				selection.endUpdate();

				// TODO: tab navigation

				return false; // stop bubbling
			}

			return true;
		},

		_onKeyPress: function (args) {
			if (this._canInteract() && this.options.allowEditing) {
				var charCode = args.which,
					currentCell = this.currentCell(),
					tag, table, domSubTables;

				if (charCode && currentCell._isValid() && !currentCell._isEdit()) {
					tag = args.target.tagName.toLowerCase();

					if (tag !== "input" && tag !== "option" && tag !== "select" && tag !== "textarea") {
						table = $(args.target).closest(".wijmo-wijgrid-table");
						// if (table.length && (table[0] === this.$table[0])) {
						if (table.length) {

							domSubTables = $.map(this._view().subTables(), function (item, index) {
								return item.element();
							});

							if ($.inArray(table[0], domSubTables) >= 0) {
								if ($.wij.charValidator.isPrintableChar(String.fromCharCode(charCode))) {
									//new $.wijmo.wijgrid.cellEditorHelper().currentCellEditStart(this, args);
									this._beginEditInternal(args);
									return false;
								}
							}
						}
					}
				}
			}
		},

		_onMouseMove: function (args) {
			if (!this._canInteract()) {
				return;
			}

			var view = this._view(),
				info = this._getParentSubTable(args.target, ["td", "th"], view.subTables()),
				hoveredCell, $hoveredRow, hoveredCellInfo, rowIndex, rowObj, rowInfo,
				$rs = $.wijmo.wijgrid.renderState;

			if (info) {
				hoveredCell = info[0];
				$hoveredRow = $(hoveredCell).closest("tr");

				if (!$hoveredRow.length || $hoveredRow.is(".wijmo-wijgrid-foorow") || !($hoveredRow.is(".wijmo-wijgrid-datarow") || $hoveredRow.is(".wijmo-wijgrid-headerrow"))) {
					return;
				}

				hoveredCellInfo = view.getAbsCellInfo(hoveredCell)._dataToAbs(this._getDataToAbsOffset());

				rowIndex = this._field("hoveredRow"); // previous row index
				if (rowIndex !== undefined && hoveredCellInfo.rowIndex() !== rowIndex) {
					rowObj = this._rows().item(rowIndex);
					if (rowObj) {
						rowInfo = this._createRowInfo(rowObj);
						rowInfo.state = this._changeRenderState(rowInfo.$rows, $rs.hovered, false);
						this.rowStyleFormatter.format(rowInfo);
					}
				}

				rowIndex = hoveredCellInfo.rowIndex();
				this._field("hoveredRow", rowIndex);
				//if (rowIndex >= 1) { // yk to inclue the first row.
				if (rowIndex >= 0) {
					rowObj = this._rows().item(rowIndex);
					if (rowObj) {
						rowInfo = this._createRowInfo(rowObj);
						rowInfo.state = this._changeRenderState(rowInfo.$rows, $rs.hovered, true);
						this.rowStyleFormatter.format(rowInfo);
					}
				}
			}
		},

		_onMouseOut: function (args) {
			if ($(args.relatedTarget).closest(".wijmo-wijgrid-data").length === 0) { // remove hovering
				var hovRowIndex = this._field("hoveredRow"),
					rowObj, rowInfo;

				if (hovRowIndex >= 0) {
					rowObj = this._rows().item(hovRowIndex);
					if (rowObj) {
						rowInfo = this._createRowInfo(rowObj);
						rowInfo.state = this._changeRenderState(rowInfo.$rows, $.wijmo.wijgrid.renderState.hovered, false);
						this.rowStyleFormatter.format(rowInfo);
					}
				}
			}
		},
		// * event handlers


		// * resizing
		_fieldResized: function (fieldWidget, oldWidth, newWidth) {
			if (oldWidth < 0) {
				oldWidth = 0;
			}

			if (newWidth <= 0) {
				newWidth = 1;
			}

			if (this._trigger("columnResizing", null, { column: fieldWidget.options, oldWidth: oldWidth, newWidth: newWidth }) !== false) {

				//add by Jeffrey on 14th Feb 2011
				//we should set the width option with the column resized
				//this.options.columns[fieldWidget.options.$uid].width = newWidth;
				//end by Jeffrey

				fieldWidget.option("width", newWidth);

				this._trigger("columnResized", null, { column: fieldWidget.options });
			}
		},
		// * resizing

		// * currentCell
		_changeCurrentCell: function (cellInfo) {
			var result = null,
				currentCell = this.currentCell(),
				dataRange = this._getDataCellsRange(),
				args, cellEditCompleted;

			// if cellInfo has a valid value
			if ((dataRange._isValid() && dataRange._containsCellInfo(cellInfo)) || (cellInfo.isEqual(cellInfo.outsideValue))) {

				// other cell than current cell
				if (currentCell.cellIndex() !== cellInfo.cellIndex() || currentCell.rowIndex() !== cellInfo.rowIndex()) {
					args = {
						cellIndex: cellInfo.cellIndex(),
						rowIndex: cellInfo.rowIndex(),
						oldCellIndex: currentCell.cellIndex(),
						oldRowIndex: currentCell.rowIndex()
					};

					if (this._trigger("currentCellChanging", null, args)) {

						cellEditCompleted = false;
						if (!this.options.allowEditing || !currentCell._isEdit() || (cellEditCompleted = this._endEditInternal(null))) {
							if (dataRange._containsCellInfo(currentCell)) {
								this._changeCurrentCellUI(currentCell, false); // remove the current one
							}

							currentCell = cellInfo._clone();
							currentCell._setGridView(this);

							result = this._changeCurrentCellUI(currentCell, true);

							this._field("currentCell", currentCell); // set currentCell

							//this._trigger("currentCellChanged");
							this._onCurrentCellChanged();
						}
					}
				} else { // the same cell
					result = this._changeCurrentCellUI(currentCell, true); // ensure
				}
			} else { // cellInfo is invalid
				// do nothing

				// this._changeCurrentCellUI(currentCell, false);
				// this._field("currentCell", currentCell.outsideValue); // set currentCell
			}

			return result;
		},

		_changeCurrentCellUI: function (cellInfo, add) {
			if (cellInfo && !cellInfo.isEqual(cellInfo.outsideValue)) {
				var view = this._view(),
					leaves = this._field("visibleLeaves"),
					dataOffset = this._getDataToAbsOffset(),
					x = cellInfo.cellIndex() + dataOffset.x,
					y = cellInfo.rowIndex() + dataOffset.y,
					cell, $cell, dataRowObj, dataRowInfo, headerRowInfo,
					$rs = $.wijmo.wijgrid.renderState,
					state;

				if (y >= 0) {
					dataRowObj = view.getJoinedRows(y, 0);

					if (dataRowObj) {
						dataRowInfo = this._createRowInfo(dataRowObj);
						dataRowInfo.state = this._changeRenderState(dataRowInfo.$rows, $rs.current, add);
						this.rowStyleFormatter.format(dataRowInfo);
					}

					if (x >= 0 && x < leaves.length) {
						cell = view.getHeaderCell(x);
						if (cell) { // activate header cell
							headerRowInfo = this._createRowInfo(this._headerRows().item(cellInfo.column().thY));

							$cell = $(cell);
							state = this._changeRenderState($cell, $rs.current, add);
							this.cellStyleFormatter.format($cell, x, cellInfo.column(), headerRowInfo, state);
						}

						cell = view.getCell(x, y);
						if (cell) { // activate data cell
							$cell = $(cell);
							state = this._changeRenderState($cell, $rs.current, add);
							this.cellStyleFormatter.format($cell, x, cellInfo.column(), dataRowInfo, state);
						}
					}

					return view.getCell(x, y);
				} // if y >= 0
			}

			return null;
		},
		// * currentCell


		// * editing
		_beginEditInternal: function (e) {
			if (this._canInteract() && this.options.allowEditing) {
				var column = this.currentCell().column(),
					res;

				if (column && !column.readOnly) {
					res = new $.wijmo.wijgrid.cellEditorHelper().currentCellEditStart(this, e);
					if (res) {
						// this._view().ensureWidth(undefined, column.visLeavesIdx);
					}
					return res;
				}
			}

			return false;
		},

		_endEditInternal: function (e) {
			if (this._canInteract() && this.options.allowEditing) {
				//var column = this.currentCell().column(),
				var res = new $.wijmo.wijgrid.cellEditorHelper().currentCellEditEnd(this, e);

				if (res) {
					// this._view().ensureWidth(undefined, column.visLeavesIdx);
				}
				return res;
			}

			return false;
		},
		// * editing

		// misc

		_createRow: function (tableSection, rowType, rowIndex) {
			return tableSection.insertRow(-1);
		},

		_createCell: function (rowType, rowIndex, rowCell) {
			var rt = $.wijmo.wijgrid.rowType;

			switch (rowType) {
				case rt.header:
					return "<th><div class=\"wijmo-wijgrid-innercell\"></div></th>";

				case rt.filter:
					return "<td />";

				default: // body section - data, data | dataAlt, groupFooter, groupHeader, emptyDataRow
					// footer section - footer
					return "<td><div class=\"wijmo-wijgrid-innercell\"></div></td>";
			}
		},

		_cellCreated: function ($cell, cellIndex, column, rowInfo, state, attr, style) {
			$.wijmo.wijgrid.dataPrefix($cell, this._data$prefix, "renderState", state);

			this.cellStyleFormatter.format($cell, cellIndex, column, rowInfo, state, attr, style);

			this._changeRenderState($cell, $.wijmo.wijgrid.renderState.rendering, false);
		},

		_rowCreated: function (rowInfo, rowAttr, rowStyle) {
			$.wijmo.wijgrid.dataPrefix(true, rowInfo.$rows, this._data$prefix, {
				dataTableRowIndex: rowInfo._dataTableRowIndex,
				dataRowIndex: rowInfo.dataRowIndex,
				rowType: rowInfo.type,
				dataItemIndex: rowInfo.dataItemIndex,
				virtualDataItemIndex: rowInfo.virtualDataItemIndex,
				renderState: rowInfo.state
			});

			this.rowStyleFormatter.format(rowInfo, rowAttr, rowStyle);

			this._changeRenderState(rowInfo.$rows, $.wijmo.wijgrid.renderState.rendering, false);
		},

		_createRowInfo: function (rowObj, rowType /*opt*/, renderState /*opt*/, dataTableRowIndex /*opt*/, dataRowIndex /*opt*/, dataItemIndex/*opt*/, virtualDataItemIndex/*opt*/) {
			var dataTable = this.dataTable,
				sourceDataRow = null,
				$rows = (rowObj[1] ? $(rowObj) : $(rowObj[0])),
				tmp,
				$getData = $.wijmo.wijgrid.dataPrefix;

			if (isNaN(rowType)) {
				rowType = $getData($rows, this._data$prefix, "rowType");
			}

			if (isNaN(renderState)) {
				renderState = $getData($rows, this._data$prefix, "renderState");
			}

			if (isNaN(dataTableRowIndex)) {
				dataTableRowIndex = $getData($rows, this._data$prefix, "dataTableRowIndex");
			}

			if (isNaN(dataRowIndex)) {
				dataRowIndex = $getData($rows, this._data$prefix, "dataRowIndex");
			}

			if (isNaN(dataItemIndex)) {
				dataItemIndex = $getData($rows, this._data$prefix, "dataItemIndex");
			}

			if (isNaN(virtualDataItemIndex)) {
				virtualDataItemIndex = $getData($rows, this._data$prefix, "virtualDataItemIndex");
			}

			if (dataTableRowIndex >= 0) {
				tmp = dataTable[dataTableRowIndex].originalRowIndex;
				if (tmp >= 0) {
					sourceDataRow = this.data()[tmp];
				}
			}

			return {
				$rows: $rows,
				state: renderState,
				type: rowType,
				data: sourceDataRow,
				dataRowIndex: dataRowIndex,
				dataItemIndex: dataItemIndex,
				virtualDataItemIndex: virtualDataItemIndex,
				_dataTableRowIndex: dataTableRowIndex
			};
		},

		_ensureDataParser: function (column) {
			switch (column.dataType) {
				case undefined: // default parser
				case "string":
					if (!column.dataParser) {
						column.dataParser = $.wijmo.wijgrid.embeddedParsers.stringParser;
					}
					break;

				case "boolean":
					if (!column.dataParser) {
						column.dataParser = $.wijmo.wijgrid.embeddedParsers.boolParser;
					}
					break;

				case "number":
					if (!column.dataParser) {
						column.dataParser = $.wijmo.wijgrid.embeddedParsers.numberParser;
					}
					break;

				case "currency":
					if (!column.dataParser) {
						column.dataParser = $.wijmo.wijgrid.embeddedParsers.currencyParser;
					}
					break;

				case "datetime":
					if (!column.dataParser) {
						column.dataParser = $.wijmo.wijgrid.embeddedParsers.dateTimeParser;
					}
					break;

				default:
					throw $.wijmo.wijgrid.stringFormat("Unsupported dataType value: \"{0}\"", column.dataType);
			}
		},

		_parseDOM: function (column, value) {
			return column.dataParser.parseDOM(value, this._field("closestCulture"), column.dataFormatString, this.options.nullString, true);
		},

		_parse: function (column, value) {
			var parsedValue = column.dataParser.parse(value, this._field("closestCulture"), column.dataFormatString, this.options.nullString, true);

			switch (column.dataType) {
				case "datetime":
					if (parsedValue !== null && !(parsedValue instanceof Date)) {
						throw "invalid value.";
					}
					break;

				case "number":
				case "currency":
					if (parsedValue !== null && (typeof (parsedValue) !== "number" || isNaN(parsedValue))) {
						throw "invalid value.";
					}
					break;

				case "boolean":
					if (parsedValue !== null && (typeof (parsedValue) !== "boolean" || isNaN(parsedValue))) {
						throw "invalid value.";
					}

					break;
			}

			return parsedValue;
		},

		_toStr: function (column, value) {
			return column.dataParser.toStr(value, this._field("closestCulture"), column.dataFormatString, this.options.nullString, true);
		},

		_canInteract: function () {
			return !this.options.disabled;
		},

		_canMoveToAnotherCell: function (domElement, keyCode) {
			var tag = domElement.tagName.toLowerCase(),
				len, selectionRange, kc, res;

			switch (tag) {
				case "input":
					if ($(domElement).hasClass("wijgridinput")) {

						if (domElement.type === "text") {
							len = domElement.value.length;
							selectionRange = new $.wijmo.wijgrid.domSelection(domElement).getSelection();

							kc = $.ui.keyCode;

							res = ((keyCode === kc.UP || keyCode === kc.DOWN || keyCode === kc.PAGE_DOWN || keyCode === kc.PAGE_UP) ||
								(selectionRange.length === 0 &&
									(
										(selectionRange.start === 0 && (keyCode === kc.LEFT || keyCode === kc.HOME)) ||
										(selectionRange.end >= len && (keyCode === kc.RIGHT || keyCode === kc.END))
									)
								));

							return res;
						}

						return true;
					}

					return false;

				case "textarea":
				case "select":
					return false;
			}

			return true;
		},

		_getDataToAbsOffset: function () {
			var x = 0,
				y = 0,
				headerRows = this._headerRows();

			if (this.options.showRowHeader) {
				x++;
			}

			if (headerRows) {
				y += headerRows.length();
			}

			if (this._filterRow()) {
				y++;
			}

			return {
				x: x,
				y: y
			};
		},

		_getDataCellsRange: function () {
			var minCol = 0,
				minRow = 0,
				maxCol = this._field("visibleLeaves").length - 1, // = this._field("dataCache").<maxWidth>
				maxRow = this.dataTable.length - 1;

			if (this.options.showRowHeader) {
				maxCol--;
			}

			if (maxCol < 0 || maxRow < 0) {
				minCol = minRow = maxCol = maxRow = -1;
			}

			return new $.wijmo.wijgrid.cellInfoRange(new $.wijmo.wijgrid.cellInfo(minCol, minRow),
				new $.wijmo.wijgrid.cellInfo(maxCol, maxRow));
		},

		_getNextCurrencyPos: function (dataRange, cellInfo, keyCode, shiftKeyPressed) {
			var cellIndex = cellInfo.cellIndex(),
				rowIndex = cellInfo.rowIndex(),
				tmp;

			switch (keyCode) {
				case $.ui.keyCode.PAGE_UP:
					if (this._reverseKey && rowIndex === dataRange.topLeft().rowIndex()) {
						rowIndex = dataRange.bottomRight().rowIndex();
					} else {
						rowIndex -= this._pageSizeKey;

						if (rowIndex < (tmp = dataRange.topLeft().rowIndex())) {
							rowIndex = tmp;
						}
					}
					break;

				case $.ui.keyCode.PAGE_DOWN:
					if (this._reverseKey && rowIndex === dataRange.bottomRight().rowIndex()) {
						rowIndex = dataRange.TopLeft().RowIndex();
					}
					else {
						rowIndex += this._pageSizeKey;

						if (rowIndex > (tmp = dataRange.bottomRight().rowIndex())) {
							rowIndex = tmp;
						}
					}

					break;

				case $.ui.keyCode.END:
					cellIndex = (this._reverseKey && cellIndex === dataRange.bottomRight().cellIndex())
						? dataRange.topLeft().cellIndex()
						: dataRange.bottomRight().cellIndex();

					break;

				case $.ui.keyCode.HOME:
					cellIndex = (this._reverseKey && cellIndex === dataRange.topLeft().cellIndex())
						? dataRange.bottomRight().cellIndex()
						: dataRange.topLeft().cellIndex();

					break;

				case $.ui.keyCode.LEFT:
					if (cellIndex > dataRange.topLeft().cellIndex()) {
						cellIndex--;
					} else
						if (this._reverseKey) {
							cellIndex = dataRange.bottomRight().cellIndex();
						}

					break;

				case $.ui.keyCode.UP:
					if (rowIndex > dataRange.topLeft().rowIndex()) {
						rowIndex--;
					}
					else
						if (this._reverseKey) {
							rowIndex = dataRange.bottomRight().rowIndex();
						}

					break;

				case $.ui.keyCode.RIGHT:
					if (cellIndex < dataRange.bottomRight().cellIndex()) {
						cellIndex++;
					}
					else
						if (this._reverseKey) {
							cellIndex = dataRange.topLeft().cellIndex();
						}

					break;

				case $.ui.keyCode.ENTER:
				case $.ui.keyCode.DOWN:
					if (rowIndex < dataRange.bottomRight().rowIndex()) {
						rowIndex++;
					}
					else
						if (this._reverseKey) {
							rowIndex = dataRange.topLeft().rowIndex();
						}

					break;

				case $.ui.keyCode.TAB:
					if (false /* TODO - tab navigation */) {
						if (shiftKeyPressed) {
							cellIndex--;

							if (cellIndex < dataRange.topLeft().cellIndex()) {

								cellIndex = dataRange.bottomRight().cellIndex();
								rowIndex--;

								if (rowIndex < dataRange.topLeft().rowIndex()) {
									rowIndex = dataRange.bottomRight().rowIndex();
								}
							}
						}
						else {
							cellIndex++;

							if (cellIndex > dataRange.bottomRight().cellIndex()) {
								cellIndex = dataRange.topLeft().cellIndex();
								rowIndex++;

								if (rowIndex > dataRange.bottomRight().rowIndex()) {
									rowIndex = dataRange.topLeft().rowIndex();
								}
							}
						}

					}

					break;
			}

			return { cellIndex: cellIndex, rowIndex: rowIndex };
		},

		_getParentSubTable: function (root, tagsToFind, subTables) {
			var domSubTables = $.map(subTables, function (item, index) { return item.element(); }),
				subTable = null,
				lastCoincidentEl = null,
				tag;

			for (; root !== null && subTable === null; root = root.parentNode) {
				tag = (root.tagName)
					? root.tagName.toLowerCase()
					: undefined;

				if ($.inArray(tag, tagsToFind) >= 0) {
					lastCoincidentEl = root;
				} else {
					//if ($(root).hasClass("wijmo-wijgrid-table")) {
					if ($.inArray(root, domSubTables) >= 0) {
						subTable = root;
					}
				}
			}

			return (lastCoincidentEl && subTable)
				? [lastCoincidentEl, subTable]
				: null;
		},

		_getRealStaticRowIndex: function () {
			//return this.options.staticRowIndex;
			if (this.options.staticRowIndex >= 0) {
				var index = this._field("spanTable").length - 1; //the whole header is fixed in case of staticRowIndex >= 0.

				if (this.options.showFilter) {
					index++; // filter row is placed inside the header, so it is fixed too.
				}

				return index;
			} else {
				return this.options.staticRowIndex;
			}
		},

		_view: function () {
			return this._field("view");
		},

		_originalFooterRowData: function () {
			var footer = this._field("tfoot");

			return (footer && footer.length)
				? footer[0] // first row only
				: null;
		},

		_originalHeaderRowData: function () {
			var header = this._field("thead");

			return (header && header.length)
				? header[0] // first row only
				: null;
		}

		// * misc
	});
})(jQuery);
/*
 Provides the base widget for columns in the wijgrid.
*/

(function ($) {
	"use strict";
	$.widget("wijmo.c1basefield", {
		_data$prefix: "c1basefield",
		options: {
			/// <summary>
			/// A value indicating whether the column can be moved.
			/// Default: true.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ columns: [ { allowMoving: true } ] });
			/// </summary>
			allowMoving: true,

			/// <summary>
			/// A value indicating whether the column can be sized.
			/// Default: true.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ columns: [ { allowSizing: true } ] });
			/// </summary>
			allowSizing: true,

			/// <summary>
			/// A value indicating the key of the data field associated with a column.
			/// If an array of hashes is used as a datasource for wijgrid, this should be string value,
			/// otherwise this should be an integer determining an index of the field in the datasource.
			/// Default: undefined
			/// Type: String or Number.
			/// Code example: $("#element").wijgrid({ columns: [ { dataKey: "ProductID" } ] });
			/// </summary>
			dataKey: undefined,

			/// <summary>
			/// Function used for changing content, style and attributes of the column cells.
			/// Default: undefined.
			/// Type: Function.
			/// Code example: $("#element").wijgrid({ columns: [ { cellFormatter: function(args) { } } ] });
			/// </summary>
			/// <remarks>
			/// Important: cellFormatter should not alter content of header and filter row cells container.
			/// </remarks>
			/// <param name="args" type="Object">
			/// args.$container: jQuery object that represents cell container to format.
			/// args.afterDefaultCallback: callback function which is invoked after applying default formatting.
			/// args.column: Options of the formatted column.
			/// args.formattedValue: Formatted value of the cell.
			/// args.row: information about associated row.
			/// args.row.$rows: jQuery object that represents rows to format.
			/// args.row.data: associated data.
			/// args.row.dataRowIndex: data row index.
			/// args.row.dataItemIndex: data item index.
			/// args.row.virtualDataItemIndex: virtual data item index.
			/// args.row.type: type of the row, one of the $.wijmo.wijgrid.rowType values.
			/// </param>
			/// <returns type="Boolean">True if container content has been changed and wijgrid should not apply the default formatting to the cell.</returns>
			cellFormatter: undefined,

			/// <summary>
			/// Gets or sets the footer text.
			/// The text may include a placeholder: "{0}" is replaced with the aggregate.
			/// Default: undefined.
			/// Type: String.
			/// Code example: $("#element").wijgrid({ columns: [ { footerText: "footer" } ] });
			/// </summary>
			/// <remarks>
			/// If the value is undefined the footer text will be determined automatically depending on the type of the datasource:
			///  DOM table - text in the footer cell.
			/// </remarks>
			footerText: undefined,

			/// <summary>
			/// Gets or sets the header text.
			/// Default: undefined.
			/// Type: String.
			/// Code example: $("#element").wijgrid({ columns: [ { headerText: "column0" } ] });
			/// </summary>
			/// <remarks>
			/// If the value is undefined the header text will be determined automatically depending on the type of the datasource:
			///  DOM table - text in the header cell.
			///  Array of hashes - dataKey (name of the field associated with column).
			///  Two-dimensional array - dataKey (index of the field associated with column).
			/// </remarks>
			headerText: undefined,

			/// <summary>
			/// A value indicating whether column is visible.
			/// Default: true.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ columns: [ { visible: true } ] });
			/// </summary>
			visible: true,

			/// <summary>
			/// Determines the width of the column.
			/// Default: undefined.
			/// Type: Number or String.
			/// Code example:
			/// $("#element").wijgrid({ columns: [ { width: 150 } ] });
			/// $("#element").wijgrid({ columns: [ { width: "10%" } ]});
			/// </summary>
			/// <remarks>
			/// The option could either be a number of string.
			/// Use number to specify width in pixel.
			/// Use string to specify width in percentage.
			/// By default, wijgrid emulates the table element behavior when using number as width.
			/// This means wijgrid may not have the exact width specified.
			/// If exact width is needed, please set ensureColumnsPxWidth option of wijgrid to true.
			/// </remarks>
			width: undefined
		},

		_create: function () {
			var wijgrid = this.options.owner;

			this.element.addClass("ui-widget wijmo-c1basefield ui-state-default");
			this._field("owner", wijgrid);
			delete this.options.owner;
			this._field("widgetName", this.widgetName);

			if (this.options.disabled) {
				this.disable();
			}

			if (wijgrid.options.allowColMoving) {
				wijgrid._dragndrop().attach(this);
			}
		},

		_init: function () {
			this.element.wrapInner("<div class='wijmo-wijgrid-innercell'></div>");
			this._refreshHeaderCell();
		},

		destroy: function () {
			var wijgrid = this._owner();

			if (wijgrid) {
				wijgrid._dragndrop().detach(this);
			}

			$.wijmo.wijgrid.remove$dataByPrefix(this.element, this._data$prefix);
		},

		_field: function (name, value) {
			//return $.wijmo.wijgrid.dataPrefix(this.element, this._data$prefix, name, value);
			return $.wijmo.wijgrid.dataPrefix(this.element[0], this._data$prefix, name, value);
		},

		_removeField: function (name) {
			var internalDataName = this._data$prefix + name;

			this.element.removeData(internalDataName);
		},

		//isInvokedOutside stands for whether setOption is invoked by related widget
		_setOption: function (key, value, isInvokedOutside) {
			var presetFunc = this["_preset_" + key],
				oldValue = this.options[key],
				optionChanged, postsetFunc;

			if (presetFunc !== undefined) {
				value = presetFunc.apply(this, [value, oldValue, isInvokedOutside]);
			}

			optionChanged = (value !== oldValue);

			//$.Widget.prototype._setOption.apply(this, arguments);  note: there is no dynamic linkage between the arguments and the formal parameter values when strict mode is used
			$.Widget.prototype._setOption.apply(this, [key, value]);

			if (optionChanged) {
				postsetFunc = this["_postset_" + key];
				if (postsetFunc !== undefined) {
					postsetFunc.apply(this, [value, oldValue, isInvokedOutside]);
				}
			}
		},

		_postset_allowMoving: function (value, oldValue, isInvokedOutside) {
			//no need to detach because there is allowMoving judgment in draganddrop
			/*
			if (value) {
				if (this._owner().options.allowColMoving) {
					this._owner()._dragndrop().attach(this);
				}
			} else {
				this._owner()._dragndrop().detach(this);
			}
			*/
			this._invokeGroupedColumn("allowMoving", value, isInvokedOutside);
		},

		_preset_clientType: function (value, oldValue) {
			throw "read-only";
		},

		_postset_headerText: function (value, oldValue, isInvokedOutside) {
			this._refreshHeaderCell();
			this._invokeGroupedColumn("headerText", value, isInvokedOutside);
		},

		_postset_visible: function (value, oldValue) {
			this._owner().ensureControl(false);
		},

		_postset_width: function (value, oldValue) {
			// change width of column.
			this._owner()._view().ensureWidth(value, this.options.visLeavesIdx);
		},

		_invokeGroupedColumn: function (key, value, isInvokedOutside) {
			//invoke setOption method to set the property of related widget
			if (!isInvokedOutside && this.options.groupedIndex !== undefined) {
				var groupWidget = this._owner()._field("groupWidgets")[this.options.groupedIndex];
				groupWidget._setOption(key, value, true);
			}
		},

		_owner: function () {
			return this._field("owner");
		},

		_canSize: function () {
			return this.options.allowSizing && this._owner().options.allowColSizing;
		},

		// drag-n-drop
		_canDrag: function () {
			return this.options.allowMoving === true;
		},

		_canDropTo: function (wijField) {
			// parent can't be dropped into a child
			if ($.wijmo.wijgrid.isChildOf(this._owner().options.columns, wijField, this)) {
				return false;
			}

			return true;
		},

		_refreshHeaderCell: function () {
			var $container = this.element.children(".wijmo-wijgrid-innercell")
				.empty()
				.html(this.options.headerText || "") // html(value) returns "" if value is undefined
				.wrapInner("<span class=\"wijmo-wijgrid-headertext\" />");
		}
	});
})(jQuery);

/*
 Provides the widget for columns in the wijgrid.
*/

(function ($) {
	"use strict";
	$.widget("wijmo.c1field", $.wijmo.c1basefield, {
		options: {
			/// <summary>
			/// Causes the grid to calculate aggregate values on the column and place them in the column footer cell or group header and footer rows.
			/// If the <see cref="showFooter"/> option is disabled or grid does not contain any groups, setting the "aggregate" option has no effect.
			/// 
			/// Possible values are: "none", "count", "sum", "average", "min", "max", "std", "stdPop", "var", "varPop" and "custom".
			///
			/// "none": no aggregate is calculated or displayed.
			/// "count": count of non-empty values.
			/// "sum": sum of numerical values.
			/// "average": average of the numerical values.
			/// "min": minimum value (numerical, string, or date).
			/// "max": maximum value (numerical, string, or date).
			/// "std": standard deviation (using formula for Sample, n-1).
			/// "stdPop": standard deviation (using formula for Population, n).
			/// "var": variance (using formula for Sample, n-1).
			/// "varPop": variance (using formula for Population, n).
			/// "custom": custom value (causing grid to throw groupAggregate event).
			///
			/// Default: "none".
			/// Type: String.
			/// Code example: $("#element").wijgrid({ columns: [{ aggregate: "none" }] });
			/// </summary>
			aggregate: "none",

			/// <summary>
			/// A value indicating whether column can be sorted.
			/// Default: true.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ columns: [{ allowSort: true }] });
			/// </summary>
			allowSort: true,

			/// <summary>
			/// Column data type. Used to determine the rules for sorting, grouping, aggregate calculation, and so on.
			/// Possible values are: "string", "number", "datetime", "currency" and "boolean".
			///
			/// "string": if using built-in parser any values are acceptable; "&nbsp;" considered as an empty string, nullString as null.
			/// "number": if using built-in parser only numeric values are acceptable, also "&nbsp;", "" and nullString which are considered as null. Any other value throws an exception.
			/// "datetime": if using built-in parser only date-time values are acceptable, also "&nbsp;", "" and nullString which are considered as null. Any other value throws an exception.
			/// "currency": if using built-in parser only numeric and currency values are acceptable, also "&nbsp;", "" and nullString which are considered as null. Any other value throws an exception.
			/// "boolean": if using built-in parser only "true" and "false" (case-insensitive) values are acceptable, also "&nbsp;", "" and nullString which are considered as null. Any other value throws an exception.
			/// 
			/// Default: "string".
			/// Type: String.
			/// Code example: $("#element").wijgrid({ columns: [{ dataType: "string" }] });
			/// </summary>
			dataType: "string",

			/// <summary>
			/// Data converter that is able to translate values from a string representation to column data type and back.
			/// 
			/// The dataParser is an object which must contains the following methods:
			///   parseDOM(value, culture, format): converts given DOM element into the typed value.
			///   parse(value, culture, format): converts the value into typed value.
			///   toStr(value, culture, format): converts the value into its string representation.
			///
			/// Default: undefined (widget built-in parser for supported datatypes will be used).
			/// Type: Object.
			///
			/// Code example:
			///   var myBoolParser = {
			///     parseDOM: function (value, culture, format, nullString) {
			///       return this.parse(value.innerHTML, culture, format, nullString);
			///     },
			///
			///     parse: function (value, culture, format, nullString) {
			///       if (typeof (value) === "boolean")  return value;
			///
			///       if (!value || (value === "&nbsp;") || (value === nullString)) {
			///         return null;
			///       }
			///
			///       switch (value.toLowerCase()) {
			///         case "on": return true;
			///         case "off": return false;
			///       }
			///
			///       return NaN;
			///     },
			///
			///     toStr: function (value, culture, format, nullString) {
			///       if (value === null)  return nullString;
			///       return (value) ? "on" : "off";
			///     }
			///   }
			///
			///   $("#element").wijgrid({ columns: [ { dataType: "boolean", dataParser: myBoolParser } ] });
			/// </summary>
			dataParser: undefined,

			/// <summary>
			/// A pattern used for formatting and parsing column values. See jquery.glob.js for possible values.
			/// The default value is undefined ("n" pattern will be used for "number" dataType, "d" for "datetime", "c" for "currency").
			/// Default: undefined.
			/// Type: String.
			/// Code example: $("#element").wijgrid({ columns: [ { dataType: "number", dataFormatString: "n" } ] });
			/// </summary>
			dataFormatString: undefined,

			/// <summary>
			/// An operation set for filtering. Must be either one of the embedded operators or custom filter operator.
			/// Case insensitive.
			///
			// Embedded filter operators include:
			///   "NoFilter": no filter.
			///   "Contains": applicable to "string" data type.
			///   "NotContain": applicable to "string" data type.
			///   "BeginsWith": applicable to "string" data type.
			///   "EndsWith": applicable to "string" data type.
			///   "Equals": applicable to "string", "number", "datetime", "currency" and "boolean" data types.
			///   "NotEqual": applicable to "string", "number", "datetime", "currency" and "boolean" data types.
			///   "Greater": applicable to "string", "number", "datetime", "currency" and "boolean" data types.
			///   "Less": applicable to "string", "number", "datetime", "currency" and "boolean" data types.
			///   "GreaterOrEqual": applicable to "string", "number", "datetime", "currency" and "boolean" data types.
			///   "LessOrEqual": applicable to "string", "number", "datetime", "currency" and "boolean" data types.
			///   "IsEmpty": applicable to "string".
			///   "NotIsEmpty": applicable to "string".
			///   "IsNull": applicable to "string", "number", "datetime", "currency" and "boolean" data types.
			///   "NotIsNull": applicable to "string", "number", "datetime", "currency" and "boolean" data types.
			///
			/// Default: "nofilter".
			/// Type: String.
			/// Code example: $("#element").wijgrid({ columns: [ { filterOperator: "nofilter" } ] });
			/// </summary>
			filterOperator: "nofilter",

			/// <summary>
			/// A value set for filtering.
			/// Default: undefined.
			/// Type: Depends on column data type.
			/// Code example: $("#element").wijgrid({ columns: [ { filterValue: "abc" } ] });
			/// </summary>
			filterValue: undefined,

			/// <summary>
			/// Using to customize the appearance and position of groups.
			/// Default: {
			///   groupSingleRow: true,
			///   collapsedImageClass: "ui-icon-triangle-1-e",
			///   expandedImageClass: "ui-icon-triangle-1-se",
			///   position: "none",
			///   outlineMode: "startExpanded",
			///   headerText: undefined,
			///   footerText: undefined
			/// }
			/// Type: Object.
			/// Code example: $("#element").wijgrid({ columns: [{ groupInfo: { position: "header" }}] });
			/// </summary>
			groupInfo: {
				expandInfo: [], // infrastructure

				/// <summary>
				/// A value indicating whether groupings containing a single row are grouped.
				/// The default value is true.
				/// Type: Boolean.
				/// </summary>
				groupSingleRow: true,

				/// <summary>
				/// Determines the css used to show collapsed nodes on the grid.
				/// The default value is "ui-icon-triangle-1-e".
				/// Type: String.
				/// </summary>
				collapsedImageClass: "ui-icon-triangle-1-e",

				/// <summary>
				/// Determines the css used to show expanded nodes on the grid.
				/// The default value is "ui-icon-triangle-1-se".
				/// Type: String.
				/// </summary>
				expandedImageClass: "ui-icon-triangle-1-se",

				/// <summary>
				/// Determines whether the grid should insert group header and/or group footer rows for this column.
				///
				/// Possible values are: "none", "header", "footer", "headerAndFooter".
				///  "none" -  disables grouping for the column.
				///  "header" - inserts header rows.
				///  "footer" - inserts footer rows.
				///  "headerAndFooter" - inserts header and footer rows.
				///
				/// The default value is "none".
				/// Type: String.
				/// </summary>
				position: "none",

				/// <summary>
				/// Determines whether the user will be able to collapse and expand the groups by clicking on the group headers,
				/// and also determines whether groups will be initially collapsed or expanded.
				///
				/// Possible values are: "none", "startCollapsed", "startExpanded".
				///  "none" -  disables collapsing and expanding.
				///  "startCollapsed" - groups are initially collapsed.
				///  "startExpanded" - groups are initially expanded.
				///
				/// The default value is "startExpanded".
				/// Type: String.
				/// </summary>
				outlineMode: "startExpanded",

				/// <summary>
				/// Determines the text that is displayed in the group header rows.
				///
				/// The text may include up to three placeholders:
				/// "{0}" is replaced with the value being grouped on.
				/// "{1}" is replaced with the group's column header.
				/// "{2}" is replaced with the aggregate
				///
				/// The text may be set to "custom". Doing so causes the grid groupText event to be raised when
				/// processing a grouped header.
				///
				/// The default value is undefined.
				/// Type: String.
				/// </summary>
				headerText: undefined,

				/// <summary>
				/// Determines the text that is displayed in the group footer rows.
				///
				/// The text may include up to three placeholders:
				/// "{0}" is replaced with the value being grouped on.
				/// "{1}" is replaced with the group's column header.
				/// "{2}" is replaced with the aggregate
				///
				/// The text may be set to "custom". Doing so causes the grid groupText event to be raised when
				/// processing a grouped footer.
				///
				/// The default value is undefined.
				/// Type: String.
				/// </summary>
				footerText: undefined
			},

			/// <summary>
			/// A value indicating whether the cells in the column can be edited.
			/// Default: false.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ columns: [ { readOnly: false } ] });
			/// </summary>
			readOnly: false,

			/// <summary>
			/// Determines whether rows are merged.
			/// Possible values are: "none", "free" and "restricted".
			///
			/// "none": no row merging.
			/// "free": allows row with identical text to merge.
			/// "restricted": keeps rows with identical text from merging if rows in the previous column are merged.
			/// 
			/// Default: "none".
			/// Type: String.
			/// Code example: $("#element").wijgrid({ columns: [{ rowMerge: "none" }] });
			/// </summary>
			rowMerge: "none",

			/// <summary>
			/// A value indicating whether filter editor will be shown in the filter row.
			/// Default: true.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ columns: [ { showFilter: true } ] });
			/// </summary>
			showFilter: true,

			/// <summary>
			/// Determines the sort direction.
			/// Possible values are: "none", "ascending" and "descending".
			///
			/// "none": no sorting.
			/// "ascending": sort from smallest to largest.
			/// "descending": sort from largest to smallest.
			/// 
			/// Default: "none".
			/// Type: String.
			/// Code example: $("#element").wijgrid({ columns: [{ sortDirection: "none" }] });
			/// </summary>
			sortDirection: "none",

			/// <summary>
			/// A value indicating whether null value is allowed during editing.
			/// Default: false.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ columns: [ { valueRequired: false } ] });
			/// </summary>
			valueRequired: false
		},

		_create: function () {
			$.wijmo.c1basefield.prototype._create.apply(this, arguments);
			this.element.addClass("ui-widget wijmo-c1field");
		},

		destroy: function () {
			this.element.find("*").unbind("." + this.widgetName);

			if (this.$filterEditor) {
				this.$filterEditor
					.closest("td") // column filter cell
					.find("*")
					.unbind("." + this.widgetName);

				switch (this.options.dataType) {
					case "number":
					case "currency":
						this.$filterEditor.wijinputnumber("destroy");
						break;

					case "datetime":
						this.$filterEditor.wijinputdate("destroy");
						break;

					default:
						this.$filterEditor.wijinputmask("destroy");
						break;
				}

				this.$filterEditor = null;
			}

			this._removeDropDownFilterList();

			$.wijmo.c1basefield.prototype.destroy.apply(this, arguments);
		},

		_init: function () {
			$.wijmo.c1basefield.prototype._init.apply(this, arguments);

			this.$filterEditor = null;

			var wijgrid = this._owner();

			this.filterRow = wijgrid._filterRow();
			if (wijgrid.options.showFilter && this.options.showFilter && (this.options.dataIndex >= 0)) {
				this._prepareFilterCell();
			}
		},

		_postset_aggregate: function (value, oldValue) {
			this._owner().ensureControl(false);
		},

		_postset_allowSort: function (value, oldValue, isInvokedOutside) {
			//this.element.find("#contentCell").empty();
			//this._headerTextDOM(this.options.headerText);
			this._refreshHeaderCell();
			this._invokeGroupedColumn("allowSort", value, isInvokedOutside);
		},

		_postset_dataType: function (value, oldValue) {
			throw "read-only";
		},

		_postset_dataParser: function (value, oldValue) {
			this._owner().ensureControl(false);
		},

		_postset_dataFormatString: function (value, oldValue) {
			this._owner().ensureControl(false);
		},

		_postset_filterOperator: function (value, oldValue) {
			this._owner().ensureControl(true);
		},

		_postset_filterValue: function (value, oldValue) {
			this._owner().ensureControl(true);
		},

		_postset_groupInfo: function (value, oldValue) {
			this._owner().ensureControl(true);
		},

		_postset_rowMerge: function (value, oldValue) {
			this._owner().ensureControl(false);
		},

		_postset_showFilter: function (value, oldValue) {
			this._owner().ensureControl(false);
		},

		_postset_sortDirection: function (value, oldValue) {
			this.options.sortOrder = 0;
			this._owner().ensureControl(true);
		},

		_postset_width: function (value, oldValue) {
			this._setFilterEditorWidth(1);
			$.wijmo.c1basefield.prototype._postset_width.apply(this, arguments);
			this._setFilterEditorWidth(this._getFilterEditorWidth());
		},

		_canDropTo: function(wijField) {
			if ($.wijmo.c1basefield.prototype._canDropTo.apply(this, arguments)) {
				//the grouped column can't be dropped into group area
				if (this.options.groupedIndex !== undefined && (wijField instanceof $.wijmo.c1groupedfield)) {
					return false;
				}

				return true;
			}
 
			return false;
		},

		_canSort: function () {
			var grid = this._owner();

			return (grid && grid.options.allowSorting && this.options.allowSort && (this.options.dataIndex >= 0));
		},

		_refreshHeaderCell: function () {
			if (this._canSort()) {
				var $anchor,
					$container = this.element.children(".wijmo-wijgrid-innercell")
						.empty()
						.html(this.options.headerText || "") // html(value) returns "" if value is undefined
						.wrapInner("<a class=\"wijmo-wijgrid-headertext\" href=\"#\" role=\"button\" />");

				$anchor = $container.children("a").bind("click." + this.widgetName, this, this._onHrefClick);

				switch (this.options.sortDirection) { // sorting icon
					case "ascending":
						$anchor.append($("<span class=\"ui-icon ui-icon-triangle-1-n\">ascending</span>"));
						break;

					case "descending":
						$anchor.append($("<span class=\"ui-icon ui-icon-triangle-1-s\">descending</span>"));
						break;
				}
			} else {
				$.wijmo.c1basefield.prototype._refreshHeaderCell.apply(this, arguments);
			}
		},

		_prepareFilterCell: function () {
			var filterCellIndex = this.options.visLeavesIdx,
				gridView = null, filterCell = null, dataValue,
				editorOptions;

			if (filterCellIndex >= 0) {
				gridView = this._owner();

				if (this.filterRow) {
					filterCell = $(new $.wijmo.wijgrid.rowAccessor().getCell(this.filterRow, filterCellIndex));
				} else {
					throw "exception";
				}

				filterCell.find(".wijmo-wijgrid-filtericon").attr("class", this._getFilterOpIconCss(gridView, this.options.filterOperator));
				this.$filterEditor = filterCell.find("input");

				//var editorWidth = this._getFilterEditorWidth();
				//this.$filterEditor.setOutWidth(editorWidth);

				dataValue = gridView._parse(this.options, this.options.filterValue);

				// set default value
				if (dataValue === null) {
					switch (this.options.dataType) {
						case "boolean":
							dataValue = false;
							break;

						case "number":
						case "currency":
						case "datetime":
							dataValue = 0;
							break;

						default:
							dataValue = "";
					}
				}

				editorOptions = {
					culture: gridView.options.culture,
					disabled: gridView.options.disabled,
					decimalPlaces: (function (pattern) { // map decimal places specified within the dataFormatString option into the decimalPlaces option of the wijinputnumber.
						var test = /^(n|p|c){1}(\d*)$/.exec(pattern);

						if (test) {
							if (test[2]) {
								return parseInt(test[2], 10);
							}
						}

						return 2;
					})(this.options.dataFormatString)
				};

				// create editor
				switch (this.options.dataType) {
					case "number":
						this.$filterEditor.wijinputnumber($.extend(editorOptions, { value: dataValue }));
						break;

					case "datetime":
						this.$filterEditor.wijinputdate($.extend(editorOptions, { date: dataValue }));
						break;

					case "currency":
						this.$filterEditor.wijinputnumber($.extend(editorOptions, { type: "currency", value: dataValue }));
						break;

					default:
						this.$filterEditor.wijinputmask({ text: dataValue });
				}

				// create button
				//var filterButton = filterCell.find(".filterBtn");
				filterCell.find(".wijmo-wijgrid-filter-trigger") // filter button
					.attr({ "role": "button", "aria-haspopup": "true" })
					.bind("mouseenter." + this.widgetName, function (e) {
						$(this).addClass("ui-state-hover");
					}).bind("mouseleave." + this.widgetName, function (e) {
						$(this).removeClass("ui-state-hover ui-state-active");
					}).bind("mouseup." + this.widgetName, this, function (e) {
						$(this).removeClass("ui-state-active");
					}).bind("mousedown." + this.widgetName, { column: this }, this._onFilterBtnClick)
					.bind("click." + this.widgetName, function (e) { e.preventDefault(); }); // prevent # being added to url.
			}
		},

		_onFilterBtnClick: function (e) {
			var column = e.data.column,
				wijgrid, filterOpLC, applicableFilters, args, items, key, operator, eventGuid;

			if (column.options.disabled) {
				return false;
			}

			if (column.$dropDownFilterList) { // close the dropdown list
				column._removeDropDownFilterList();
				return false;
			}

			wijgrid = column._owner();
			filterOpLC = column.options.filterOperator.toLowerCase();
			applicableFilters = wijgrid.filterOperatorsCache.getByDataType(column.options.dataType);

			wijgrid.filterOperatorsCache.sort(applicableFilters, wijgrid.options.filterOperatorsSortMode);

			args = $.extend(true, {}, { operators: applicableFilters, column: column.options });
			wijgrid._trigger("filterOperatorsListShowing", null, args);

			items = [];
			if (args.operators) {
				for (key in args.operators) {
					if (args.operators.hasOwnProperty(key)) {
						operator = args.operators[key];
						items.push({ label: operator.name, value: operator.name, selected: operator.name.toLowerCase() === filterOpLC });
					}
				}
			}

			column.$dropDownFilterList = $("<div class=\"wijmo-wijgrid-filterlist\"></div").appendTo(document.body).wijlist(
			{
				autoSize: true,
				maxItemsCount: 8,
				selected: function (data, arg) {
					column._removeDropDownFilterList();
					wijgrid._handleFilter(column, arg.item.value, column.$filterEditor.val());
				}
			});

			column.$dropDownFilterList
				.wijlist("setItems", items)
				.wijlist("renderList");

			if (items.length > 8) {
				column.$dropDownFilterList.width(column.$dropDownFilterList.width() + 20);
			}

			column.$dropDownFilterList.$button = $(this);

			column.$dropDownFilterList
				.wijlist("refreshSuperPanel")
				.position({
					of: $(this),
					my: "left top",
					at: "left bottom"
				});

			eventGuid = column.$dropDownFilterList.eventGuid = new Date().getTime();
			$(document).bind("mousedown." + column.widgetName + "." + eventGuid, { column: column }, column._onDocMouseDown);
		},

		_getFilterOpIconCss: function (gridView, filterOpName) {
			var css = "filter-nofilter",
				filterOp = gridView.filterOperatorsCache.getByName(filterOpName.toLowerCase());

			if (filterOp) {
				if (filterOp.css) {
					css = filterOp.css;
				} else {
					css = "filter-" + filterOp.name.toLowerCase();
				}
			}

			return "wijmo-wijgrid-filtericon " + css;
		},

		_onDocMouseDown: function (e) {
			var $target = $(e.target),
				$filterList = $target.parents(".wijmo-wijgrid-filterlist:first"),
				$filterButton = $target.is(".wijmo-wijgrid-filter-trigger")
					? $target
					: $target.parents(".wijmo-wijgrid-filter-trigger:first");

			if (($filterButton.length && ($filterButton[0] === e.data.column.$dropDownFilterList.$button[0])) ||
			 ($filterList.length && ($filterList[0] === e.data.column.$dropDownFilterList[0]))) {
				// do nothing
			} else {
				e.data.column._removeDropDownFilterList();
			}
		},

		_onHrefClick: function (args) {
			if (args.data.options.disabled) {
				return false;
			}

			if (args.data.options.allowSort) {
				args.data._owner()._handleSort(args.data.options, args.ctrlKey);
			}

			return false;
		},

		_removeDropDownFilterList: function () {
			if (this.$dropDownFilterList) {
				var eventGuid = this.$dropDownFilterList.eventGuid;

				this.$dropDownFilterList.remove();

				this.$dropDownFilterList = null;

				$(document).unbind("mousedown." + this.widgetName + "." + eventGuid, this._onDocMouseDown);
			}
		},

		_getFilterEditorWidth: function () {
			if (this.$filterEditor) {
				var $fd = this.$filterEditor.closest(".wijmo-wijgrid-filter"),
					value = $fd.width() - $fd.find(".wijmo-wijgrid-filtericon").outerWidth();

				if (!value || value < 0) {
					value = 0;
				}

				return value;
			}

			return undefined;
		},

		_setFilterEditorWidth: function (width) {
			if (this.$filterEditor) {
				width -= this.$filterEditor.leftBorderWidth() + this.$filterEditor.rightBorderWidth();

				if (width < 0) {
					width = 0;
				}

				switch (this.options.dataType) {
					case "number":
					case "currency":
						this.$filterEditor.wijinputnumber("widget").width(width);
						break;
					case "datetime":
						this.$filterEditor.wijinputdate("widget").width(width);
						break;
					default:
						this.$filterEditor.wijinputmask("widget").width(width);
						break;
				}

				this.$filterEditor.setOutWidth(width);
			}
		}
	});
})(jQuery);


/*
 Provides the grouped widget for columns in the wijgrid.
*/

(function ($) {
	"use strict";
	$.widget("wijmo.c1groupedfield", {
		_data$prefix: "c1groupedfield",
		options: {
			/// <summary>
			/// A value indicating whether the column can be moved.
			/// Default: true.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ columns: [ { allowMoving: true } ] });
			/// </summary>
			allowMoving: true,

			/// <summary>
			/// A value indicating whether column can be sorted.
			/// Default: true.
			/// Type: Boolean.
			/// Code example: $("#element").wijgrid({ columns: [{ allowSort: true }] });
			/// </summary>
			allowSort: true,

			/// <summary>
			/// Gets or sets the header text.
			/// Default: undefined.
			/// Type: String.
			/// Code example: $("#element").wijgrid({ columns: [ { headerText: "column0" } ] });
			/// </summary>
			/// <remarks>
			/// If the value is undefined the header text will be determined automatically depending on the type of the datasource:
			///  DOM table - text in the header cell.
			///  Array of hashes - dataKey (name of the field associated with column).
			///  Two-dimensional array - dataKey (index of the field associated with column).
			/// </remarks>
			headerText: undefined,

			/// <summary>
			/// Determines the sort direction.
			/// Possible values are: "none", "ascending" and "descending".
			///
			/// "none": no sorting.
			/// "ascending": sort from smallest to largest.
			/// "descending": sort from largest to smallest.
			/// 
			/// Default: "none".
			/// Type: String.
			/// Code example: $("#element").wijgrid({ columns: [{ sortDirection: "none" }] });
			/// </summary>
			sortDirection: "none"
		},

		_create: function () {
			var wijgrid = this.options.owner;

			this.element.addClass("wijmo-wijgrid-group-button ui-state-default ui-corner-all");
			this._field("owner", wijgrid);
			delete this.options.owner;

			if (this.options.disabled) {
				this.disable();
			}

			if (wijgrid.options.allowColMoving) {
				wijgrid._dragndrop().attach(this);
			}
		},

		_init: function () {
			this._refreshHeaderCell();
		},

		destroy: function () {
			this.element.find("*").unbind("." + this.widgetName);

			var wijgrid = this._owner();

			if (wijgrid) {
				wijgrid._dragndrop().detach(this);
			}

			$.wijmo.wijgrid.remove$dataByPrefix(this.element, this._data$prefix);
		},

		_field: function (name, value) {
			return $.wijmo.wijgrid.dataPrefix(this.element[0], this._data$prefix, name, value);
		},

		_removeField: function (name) {
			var internalDataName = this._data$prefix + name;

			this.element.removeData(internalDataName);
		},

		_setOption: function (key, value, isInvokedOutside) {
			var presetFunc = this["_preset_" + key],
				oldValue = this.options[key],
				optionChanged, postsetFunc;

			if (presetFunc !== undefined) {
				value = presetFunc.apply(this, [value, oldValue, isInvokedOutside]);
			}

			optionChanged = (value !== oldValue);

			//$.Widget.prototype._setOption.apply(this, arguments);  note: there is no dynamic linkage between the arguments and the formal parameter values when strict mode is used
			$.Widget.prototype._setOption.apply(this, [key, value]);

			if (optionChanged) {
				postsetFunc = this["_postset_" + key];
				if (postsetFunc !== undefined) {
					postsetFunc.apply(this, [value, oldValue, isInvokedOutside]);
				}
			}
		},

		_postset_headerText: function (value, oldValue, isInvokedOutside) {
			this._refreshHeaderCell();
		},

		_postset_allowSort: function (value, oldValue, isInvokedOutside) {
			this._refreshHeaderCell();
		},

		_owner: function () {
			return this._field("owner");
		},

		_canSize: function () {
			return this.options.allowSizing && this._owner().options.allowColSizing;
		},

		// drag-n-drop
		_canDrag: function () {
			return this.options.allowMoving === true;
		},

		_canDropTo: function (wijField) {
			//band can't be dropped into group area
			if (!(wijField instanceof $.wijmo.c1groupedfield)) {
				return false;
			}

			// parent can't be dropped into a child
			if ($.wijmo.wijgrid.isChildOf(this._owner().options.columns, wijField, this)) {
				return false;
			}

			return true;
		},

		_canSort: function () {
			var grid = this._owner();

			return (grid && grid.options.allowSorting && this.options.allowSort && (this.options.dataIndex >= 0));
		},

		_refreshHeaderCell: function () {
			var $closeButton = $("<span class=\"wijmo-wijgrid-group-button-close ui-state-default ui-corner-all\"><span class=\"ui-icon ui-icon-close\"></span></span>")
				.bind("click." + this.widgetName, this, this._onCloseClick);
			this.element
				.html(this.options.headerText || "") // html(value) returns "" if value is undefined
				.prepend($closeButton)
				.bind("click." + this.widgetName, this, this._onHrefClick);
			if (this._canSort()) {
				switch (this.options.sortDirection) { // sorting icon
					case "ascending":
						this.element.append($("<span class=\"wijmo-wijgrid-group-button-sort ui-icon ui-icon-triangle-1-n\"></span>"));
						break;

					case "descending":
						this.element.append($("<span class=\"wijmo-wijgrid-group-button-sort ui-icon ui-icon-triangle-1-s\"></span>"));
						break;
				}
			}
		},

		_onCloseClick: function (args) {
			args.data._owner().ensureControl(false, {
				beforeRefresh: function () {
					var column = $.wijmo.wijgrid.getColumnByTravIdx(this.options.columns, args.data.options.travIdx);

					delete column.found.groupedIndex;

					$.extend(true, column.found, {
						groupInfo: {
							position: "none"
						}
					});
				}
			});

			return false;
		},

		_onHrefClick: function (args) {
			var wijgrid = args.data._owner(),
				options = args.data.options,
				column;

			if (!options.disabled && options.allowSort) {
				//find the column according to the c1groupedfield widget
				column = $.wijmo.wijgrid.search(wijgrid.columns(), function (test) {
					return test.options.travIdx === options.travIdx;
				});

				column = (!column.found) // grouped column is invisible?
					? $.wijmo.wijgrid.getColumnByTravIdx(wijgrid.options.columns, options.travIdx).found
					: column.found.options;

				if (column) {
					wijgrid._handleSort(column, args.ctrlKey);
				}
			}

			return false;
		}
	});
})(jQuery);

(function ($) {
	"use strict";
	$.widget("wijmo.c1band", $.wijmo.c1basefield, {
		options: {
			/// <summary>
			/// Gets a array of objects representing the columns of the band.
			/// The default value is an empty array.
			/// Type: Array.
			/// </summary>
			columns: []
		},

		_create: function () {
			$.wijmo.c1basefield.prototype._create.apply(this, arguments);
			this.element.addClass("ui-widget wijmo-c1band");
		},

		_canDropTo: function(wijField) {
			if ($.wijmo.c1basefield.prototype._canDropTo.apply(this, arguments)) {
				//band can't be dropped into group area
				return (wijField instanceof $.wijmo.c1groupedfield);
			}
 
			return false;
		}
	});
})(jQuery);

(function ($) {
	"use strict";
	// traversing, band processing
	$.extend($.wijmo.wijgrid, {
		bandProcessor: function () {
			var height, width, table, traverseList, shift, inc, savedXPos;

			this.generateSpanTable = function (root, leaves) {
				height = width = inc = shift = 0;
				table = [];
				traverseList = [];
				savedXPos = [];

				var spanTable = this._generateSpanTable(root, leaves, true);

				return spanTable;
			};

			this._generateSpanTable = function (root, leaves, parentVisibility) {
				var i, j;
					height = this._getVisibleHeight(root, parentVisibility);

				leaves = leaves || [];

				//var foo = function(self) {
				$.wijmo.wijgrid.traverse(root, function (column) {
					if (column.isLeaf) {
						leaves.push(column);
					}
					traverseList.push(column);
					//self.traverseList.push(column);
				});
				//} (this); // make closure

				width = leaves.length;

				for (i = 0; i < height; i++) {
					table[i] = [];
					for (j = 0; j < width; j++) {
						table[i][j] = { column: null, colSpan: 0, rowSpan: 0 };
					}
				}

				this._setTableValues(root, 0, 0);

				return table;
			};

			this._getVisibleHeight = function (root, parentVisibility) {
				var i, len, colVis, tmp, result = 0;

				if ($.isArray(root)) { // columns
					for (i = 0, len = root.length; i < len; i++) {
						tmp = this._getVisibleHeight(root[i], parentVisibility);
						result = Math.max(result, tmp);
					}
				} else { // column
					colVis = (root.visible === undefined) ? true : root.visible;
					root.parentVis = colVis && parentVisibility;

					if (root.isBand) { // band
						for (i = 0, len = root.columns.length; i < len; i++) {
							tmp = this._getVisibleHeight(root.columns[i], root.parentVis);
							result = Math.max(result, tmp);
						}

						if (!root.parentVis) {
							return result;
						}

						root.isLeaf = (result === 0);
						result++;
					} else { // general column
						root.isLeaf = true;
						if (root.parentVis) {
							result = 1;
						}
					}
				}

				return result;
			};

			this._getVisibleParent = function (column) {

				while (column) {
					column = traverseList[column.parentIdx];
					if (column && (column.parentVis || column.parentVis === undefined)) {
						return column;
					}
				}

				return null;
			};

			this._setTableValues = function (root, y, x) {
				var i, len, tx, posX, parentIsLeaf, visibleParent;

				if ($.isArray(root)) { //
					for (i = 0, len = root.length; i < len; i++) {
						this._setTableValues(root[i], y, x);
					}
				} else { // column
					if (root.travIdx === undefined) {
						throw "undefined travIdx";
					}

					tx = x + shift;

					if (root.parentVis) {
						posX = tx + inc;
						table[y][posX].column = root;
						savedXPos[root.travIdx] = posX;
					}

					if (root.isBand) { // band
						for (i = 0, len = root.columns.length; i < len; i++) {
							this._setTableValues(root.columns[i], y + 1, x);
						}
					}

					if (root.parentVis) {
						if (shift - tx === 0) { //root is column or band without visible nodes
							table[y][savedXPos[root.travIdx]].rowSpan = height - y;
							shift++;
						} else { // band with visible nodes
							table[y][savedXPos[root.travIdx]].colSpan = shift - tx;
						}
					} else {
						if (!root.isBand && height > 0) {
							visibleParent = this._getVisibleParent(root);

							parentIsLeaf = (visibleParent)
							? visibleParent.isLeaf
							: false;

							if (parentIsLeaf) {
								inc++;
							}

							if (y >= height) {
								y = height - 1;
							}

							posX = x + shift + inc;

							table[y][posX].column = root;

							if (!parentIsLeaf) {
								if (visibleParent && (savedXPos[visibleParent.travIdx] === posX)) {
									this._shiftTableElements(posX, y);
								}

								inc++;
							}
						}
					}
				}
			};

			this._shiftTableElements = function (x, untilY) {
				var i;

				for (i = 0; i < untilY; i++) {
					table[i][x + 1] = table[i][x];
					table[i][x] = { column: null, colSpan: 0, rowSpan: 0 };

					if (table[i][x + 1].column) {
						savedXPos[table[i][x + 1].column.travIdx]++;
					}
				}
			};
		},

		// returns both visible and invisible leaves.
		getAllLeaves: function (columns) {
			var leaves = [];

			this._getAllLeaves(columns, leaves);

			return leaves;
		},

		_getAllLeaves: function (columns, leaves) {
			var i, len, column, subColumns;

			if (columns) {
				for (i = 0, len = columns.length; i < len; i++) {
					column = columns[i];

					if (column.options) { // widget
						column = column.options;
					}

					subColumns = column.columns;
					if (subColumns && subColumns.length) {
						this._getAllLeaves(subColumns, leaves);
					}
					else {
						leaves.push(column);
					}
				}
			}
		},

		// returns null or { found (object), at (array) } object.
		getColumnByTravIdx: function (columns, travIdx) {
			var i, len, column, result = null;

			if (columns) {
				for (i = 0, len = columns.length; i < len && !result; i++) {
					column = columns[i];

					if (column.options) { // widget
						column = column.options;
					}

					if (column.travIdx === travIdx) {
						return { found: column, at: columns };
					}

					if (column.columns) {
						result = this.getColumnByTravIdx(column.columns, travIdx);
					}
				}
			}

			return result;
		},

		isChildOf: function (columns, child, parent) {
			if (child.options) {
				child = child.options;
			}

			if (parent.options) {
				parent = parent.options;
			}

			if (parent.isBand && child.parentIdx >= 0) {
				if (child.parentIdx === parent.travIdx) {
					return true;
				}

				if (child.parentIdx > parent.travIdx) {
					var traverse = this.flatten(columns);

					while (true) {
						child = traverse[child.parentIdx];

						if (child.travIdx === parent.travIdx) {
							return true;
						}

						if (child.parentIdx === -1) {
							break;
						}
					}
				}
			}

			return false;
		},

		getLeaves: function (columns) {
			var leaves = [];

			this._getLeaves(columns, leaves);

			return leaves;
		},

		_getLeaves: function (columns, leaves) {
			var i, len, column;

			if (columns) {
				for (i = 0, len = columns.length; i < len; i++) {
					column = columns[i];

					if (column.isLeaf) {
						leaves.push(column);
					}

					if (column.columns) {
						this._getLeaves(column.columns, leaves);
					}
				}
			}
		},

		setTraverseIndex: function (columns) {
			return this._setTraverseIndex(columns, 0, -1); // -> columns length
		},

		_setTraverseIndex: function (columns, idx, parentIdx) {
			var i, len, column;

			if (columns) {
				for (i = 0, len = columns.length; i < len; i++) {
					column = columns[i];

					if (column.options) { // widget
						column = column.options;
					}

					column.linearIdx = i;
					column.travIdx = idx++;
					column.parentIdx = parentIdx;

					if (column.columns) {
						idx = this._setTraverseIndex(column.columns, idx, idx - 1);
					}
				}
			}

			return idx;
		},

		flatten: function (columns) {
			var result = [];

			this.traverse(columns, function (column) {
				result.push(column);
			});

			return result;
		},

		traverse: function (columns, callback) {
			var i, len, column;

			if (columns && ($.isFunction(callback))) {
				for (i = 0, len = columns.length; i < len; i++) {
					column = columns[i];

					if (column.options) { // widget
						column = column.options;
					}

					callback(column);

					if (column.columns) { // go deeper
						this.traverse(column.columns, callback);
					}
				}
			}
		},

		getAriaHeaders: function (visibleLeaves, traverseList) {
			var i, len, leaf, value, result = [];

			for (i = 0, len = visibleLeaves.length; i < len; i++) {
				leaf = visibleLeaves[i];
				value = "";

				do {
					value += escape(leaf.headerText) + " ";
				} while ((leaf = traverseList[leaf.parentIdx])/*&& leaf.parentVis*/);

				result[i] = $.trim(value);
			}

			return result;
		}
	});
})(jQuery);(function ($) {
	"use strict";
	$.extend($.wijmo.wijgrid, {
		// section:
		// 1 - tHead
		// 2 - tBody
		// 3 - tFoot
		// otherwise - table
		getTableSection: function (table, section) {
			if (table && !table.nodeType) {
				table = table[0]; // jQuery
			}

			if (table) {
				switch (section) {
					case 1:
						return table.tHead;

					case 2:
						if (table.tBodies) {
							return table.tBodies[0] || null;
						}
						break;

					case 3:
						return table.tFoot;

					default:
						return table;
				}
			}

			return null;
		},

		// section:
		// 1 - tHead
		// 2 - tBody
		// 3 - tFoot
		// otherwise - table
		getTableSectionLength: function (table, section) {
			if (table && !table.nodeType) {
				table = table[0]; // jQuery
			}

			return (table && (section = this.getTableSection(table, section)))
				? section.rows.length
				: 0;
		},

		getTableSectionRow: function (table, section, rowIndex) {
			if (table && !table.nodeType) {
				table = table[0]; // jQuery
			}

			return (table && (section = this.getTableSection(table, section)))
				? section.rows[rowIndex] || null
				: null;
		},

		// section:
		// 1 - tHead
		// 2 - tBody
		// 3 - tFoot
		// otherwise - table
		readTableSection: function (table, section, readAttributes) {
			var ri, rowLen, ci, celLen, row, tmp,
				result = [],
				prevent = function (attrName) {
					attrName = attrName.toLowerCase();
					return attrName === "rowspan" || attrName === "colspan";
				}

			if (table && !table.nodeType) {
				table = table[0]; // jQuery
			}

			if (table && (section = this.getTableSection(table, section))) {
				for (ri = 0, rowLen = section.rows.length; ri < rowLen; ri++) {
					row = section.rows[ri];
					tmp = [];

					if (readAttributes) {
						tmp.rowAttributes = null; // $.wijmo.wijgrid.getAttributes(row);
						tmp.cellsAttributes = [];
					}

					for (ci = 0, celLen = row.cells.length; ci < celLen; ci++) {
						tmp[ci] = row.cells[ci].innerHTML;

						if (readAttributes) {
							tmp.cellsAttributes[ci] = $.wijmo.wijgrid.getAttributes(row.cells[ci], prevent);
						}
					}

					result[ri] = tmp;
				}
			}

			return result;
		}
	});
})(jQuery);(function ($) {
	"use strict";
	$.extend($.wijmo.wijgrid, {
		dataMode: {
			dom: 1,
			statical: 2,
			remoteStatical: 4,
			dynamical: 8
		},

		dataStore: function (wijgrid) {
			var _dataSource = null,
				_self = this,
				_isLoaded = false,
				_clonedItems = null,
				_attributes = null, // store attributes here (an array of a { rowAttributes, cellsAttributes }
				_transformedData, // { data: array, totalRows: int }
				_parsed = false,
				_transformed = false;

			this.dataMode = function () {
				return _dataMode();
			};

			this.dataSource = function () {
				return _dataSource;
			};

			this.getFieldNames = function () {

				if (!_isLoaded) {
					throw "data is not loaded yet";
				}

				var result = [],
					key, fooKey, firstItem;

				if (_dataSource.items && _dataSource.items.length) {
					firstItem = _dataSource.items[0];
				} else {
					if ((_dataMode() === $.wijmo.wijgrid.dataMode.dom) && _dataSource.header && _dataSource.header.length) { // DOMTable contains no data rows but header.
						firstItem = _dataSource.header[0];
					}
				}

				if (firstItem) {
					for (key in firstItem) {
						if (firstItem.hasOwnProperty(key)) {
							result.push((!isNaN(key)) ? parseInt(key, 10) : key);
						}
					}
				}

				return result;
			};

			// { data: array, totalRows: int }
			this.getDataSlice = function () {

				if (!_isLoaded) {
					throw "data is not loaded yet";
				}

				if (!_parsed) {
					_parsed = true; // todo try/ finally
					_parseData(_clonedItems);
				}

				if (!_transformed) {
					_transformed = true; // todo try/ finally

					if (_dataMode() !== $.wijmo.wijgrid.dataMode.dynamical) {
						_transformedData = _transform(_clonedItems, _dataSource.emptyData);
					} else {
						_transformedData = {
							data: _clonedItems, //  $.extend(true, [], _clonedItems),
							totalRows: _dataSource.data.totalRows,
							totals: _dataSource.data.totals || {},
							emptyData: _dataSource.emptyData
						};
					}
				}

				return _transformedData;
			};

			this.load = function (userData) {
				if (!_dataSource) {
					_dataSource = $.proxy(_createDataSource, this)(wijgrid);
				}

				if (_dataMode() === $.wijmo.wijgrid.dataMode.dynamical) { // always load data
					userData.data = _prepareRequest();
					if (_dataSource.proxy) { // remote 
						_dataSource.proxy.options.data = $.extend(_dataSource.proxy.options.data, userData.data);
					}

					_attributes = null; // indicates that we should read attributes
					_dataSource.load(userData, true);
				} else { // local
					if (!_isLoaded) { // first time ?
						_attributes = null; // indicates that we should read attributes
						_dataSource.load(userData);
					} else {
						_dataLoading(_dataSource, userData);
						_dataLoaded(_dataSource, userData);
					}
				}
			};

			this.isLoaded = function () {
				return _isLoaded;
			};

			this.updateValue = function (originalRowIndex, dataKey, newValue) {
				if (!_isLoaded) {
					throw "data is not loaded yet";
				}

				this.dataSource().items[originalRowIndex][dataKey] = newValue;
			};

			// private

			function _createDataSource(grid) {
				var dataSource = null,
					gridData = grid.options.data,
					oldError;

				if (gridData === null) { // DOMTable
					dataSource = new wijdatasource({
						data: grid.element,
						reader: new _dataReaderWrapper(new _domTableDataReader()),
						loading: $.proxy(_dataLoading, this),
						loaded: $.proxy(_dataLoaded, this)
					});
				} else
					if ($.isArray(gridData)) { // Array
						dataSource = new wijdatasource({
							data: gridData,
							reader: new _dataReaderWrapper(new wijarrayreader()),
							loading: $.proxy(_dataLoading, this),
							loaded: $.proxy(_dataLoaded, this)
						});
					} else { // wijdatasource
						dataSource = new wijdatasource(gridData);

						dataSource.reader = new _dataReaderWrapper(gridData.reader);

						dataSource.loading = $.proxy(function (ds, data) {
							if ($.isFunction(gridData.loading)) {
								gridData.loading(ds, data);
							}

							$.proxy(_dataLoading, this)(ds, data);
						}, this);

						dataSource.loaded = $.proxy(function (ds, data) {
							if ($.isFunction(gridData.loaded)) {
								gridData.loaded(ds, data);
							}

							$.proxy(_dataLoaded, this)(ds, data);
						}, this);

						if (dataSource.proxy && dataSource.proxy.options) {
							oldError = dataSource.proxy.options.error;
							dataSource.proxy.options.error = function () {
								_error.apply(this, arguments);

								if ($.isFunction(oldError)) {
									oldError.apply(this, arguments);
								}
							};
						}
					}

				return dataSource;
			}

			function _dataLoading(wijDataSource, userData) {
				if (_self.dataMode() === $.wijmo.wijgrid.dataMode.dynamical || wijgrid.options.alwaysParseData) {
					_parsed = false;  // always parse data
				}

				_transformed = false;
				_transformedData = null;
				_clonedItems = null;
				wijgrid._dataLoading(userData);
			}

			function _dataLoaded(wijDataSource, userData) {
				_isLoaded = true;

				// clone original items and get attributes (optional), extend them to a { value, originalRowIndex, attributes } triplet
				var i, len, item, dataKey, dataValue, tmp,
					mode = _dataMode(),
					readAttributes = (!_attributes && wijgrid.options.readAttributesFromData);

				if (!_attributes) { // first time?
					_attributes = []; 
				}

				_clonedItems = [];

				for (i = 0, len = wijDataSource.items.length; i < len; i++) {
					item = wijDataSource.items[i];

					if (readAttributes) {
						if (mode === $.wijmo.wijgrid.dataMode.dom) { // Row and cells attributes are provided by the tableReader within rowAttributes and cellsAttributes properties of the data item itself.
							_attributes.push({
								rowAttributes: item.rowAttributes,
								cellsAttributes: item.cellsAttributes
							});

							delete item.rowAttributes;
							delete item.cellsAttributes;
						} else { // Otherwise cell attributes can be passed within data values as an array of size 2. First element points to a data value, second element points to an attributes hash.
							tmp = {};

							for (dataKey in item) {
								if (item.hasOwnProperty(dataKey) && $.isArray(dataValue = item[dataKey])) {
									tmp[dataKey] = dataValue[1]; // copy attributes to tmp
									item[dataKey] = dataValue[0]; // overwrite item[dataKey] with actual data value
								}
							}

							_attributes.push({
								rowAttributes: {},
								cellsAttributes: tmp
							});
						}
					}

					_clonedItems.push({
						values: item, // important!!: the same object is shared between _clonedItems and wijDataSource(aka _dataSource).items
						originalRowIndex: i,
						attributes: _attributes[i]
					});
				}

				wijgrid._dataLoaded(userData);
			}

			function _error() {
				wijgrid._ajaxError.apply(wijgrid, arguments);
			}

			function _dataMode() {
				if (!_dataSource.data) { // dataSource.data == domTable
					return $.wijmo.wijgrid.dataMode.dom;
				}

				if (_dataSource.dynamic === true) {
					return $.wijmo.wijgrid.dataMode.dynamical;
				}

				return $.wijmo.wijgrid.dataMode.statical;
			}

			function _parseData(data) {
				if (data && data.length) {

					var dataLeaves = [],
						dataLen, ri, len, dataRow, di, value, dataLeaf;

					$.wijmo.wijgrid.traverse(wijgrid.options.columns, function (column) {
						if ($.wijmo.wijgrid.validDataKey(column.dataKey)) {
							dataLeaves.push(column);
						}
					});

					dataLen = Math.min(dataLeaves.length, /*_self.getFieldsCount()*/_self.getFieldNames().length);
					for (ri = 0, len = data.length; ri < len; ri++) {
						dataRow = data[ri];

						for (di = 0; di < dataLen; di++) {
							value = null;
							dataLeaf = dataLeaves[di];

							if (dataLeaf && dataLeaf.dataParser) {
								value = wijgrid._parse(dataLeaf, dataRow.values[dataLeaf.dataKey]);
								dataRow.values[dataLeaf.dataKey] = value;
							}

						} // for di
					} // for ri
				}
			}

			// { data: array, totalRows: int }
			function _transform(data, emptyData) {
				if (data && data.length) {
					var filterRequest = wijgrid._prepareFilterRequest(true),
						pageRequest = wijgrid._preparePageRequest(true),
						sortRequest = wijgrid._prepareSortRequest(true),
						totalsRequest = wijgrid._prepareTotalsRequest(true),
						result = new $.wijmo.wijgrid.dataHelper().getDataSlice(wijgrid, data /*$.extend(true, [], data)*/, filterRequest, pageRequest, sortRequest, totalsRequest);

					return result;
				}

				return {
					data: [],
					totalRows: 0,
					totals: {},
					emptyData: emptyData
				};
			}

			function _prepareRequest() {
				var result = {
					filtering: wijgrid._prepareFilterRequest(false),
					paging: wijgrid._preparePageRequest(false),
					sorting: wijgrid._prepareSortRequest(false),
					totals: wijgrid._prepareTotalsRequest(false)
				};

				return result;
			}

			// * data readers *
			function _dataReaderWrapper(dataReader) {

				this.read = function (dataSource) {
					dataSource.items = null;

					if (dataReader && $.isFunction(dataReader.read)) {
						dataReader.read(dataSource);
					}

					if (!$.isArray(dataSource.items)) {
						dataSource.items = [];

						if ($.isArray(dataSource.data)) {
							dataSource.items = dataSource.data;
						} else {
							if (dataSource.data && $.isArray(dataSource.data.rows)) {
								dataSource.items = dataSource.data.rows; // remoteDynamical
							}
						}
					}

					if (_dataMode() === $.wijmo.wijgrid.dataMode.dynamical) {
						if (!dataSource.data || isNaN(dataSource.data.totalRows)) {
							throw "totalRows value is missing";
						}
					}

					if (!dataSource.items || !$.isArray(dataSource.items)) {
						dataSource.items = [];
					}
				};
			}

			function _domTableDataReader() {
				this.read = function (wijDataSource) {
					wijDataSource.items = [];

					if (wijDataSource && wijDataSource.data && wijDataSource.data.length) {
						if ($.wijmo.wijgrid.getTableSectionLength(wijDataSource.data, 2) === 1 &&
							$($.wijmo.wijgrid.getTableSectionRow(wijDataSource.data, 2, 0)).hasClass("wijmo-wijgrid-emptydatarow")) { // special case - empty data row
							wijDataSource.emptyData = $.wijmo.wijgrid.readTableSection(wijDataSource.data, 2);
						} else { // read data rows
							wijDataSource.items = $.wijmo.wijgrid.readTableSection(wijDataSource.data, 2, wijgrid.options.readAttributesFromData);
						}

						wijDataSource.header = $.wijmo.wijgrid.readTableSection(wijDataSource.data, 1);
						wijDataSource.data = null;
					} else {
						throw "invalid data source";
					}
				};
			}
		},

		dataHelper: function () {

			this.getDataSlice = function (gridView, dataCache, filterRequest, pageRequest, sortRequest, totalsRequest) {
				// apply filtering
				dataCache = _applyFiltering(dataCache, filterRequest, gridView);

				// apply sorting
				$.proxy(_applySort, this)(dataCache, sortRequest);

				var totalRows = dataCache.length, // number of rows in the data source (before paging will be applied)
					start, end, pagedData, i, j, len,
					totals = {};

				// calculate totals
				totals = _getTotals(dataCache, totalsRequest, gridView);

				// apply paging
				if (pageRequest) {
					start = Math.min(dataCache.length - 1, pageRequest.pageIndex * pageRequest.pageSize);

					if (start < 0) {
						start = 0;
					}

					end = Math.min(dataCache.length, start + pageRequest.pageSize);

					pagedData = [];
					for (i = start, len = 0, j = 0; i < end; i++, j++) {
						pagedData[j] = dataCache[i];
					}

					dataCache = pagedData;
				}

				return {
					data: dataCache,
					totalRows: totalRows,
					totals: totals
				};
			};

			// totalsRequest: [ {column, aggregate} ]
			function _getTotals(data, totalsRequest, gridView) {
				var i, len, j, len2, dataItemValues,
					tallies = [],
					result = {};

				for (i = 0, len = totalsRequest.length; i < len; i++) {
					tallies.push(new $.wijmo.wijgrid.tally());
				}

				for (i = 0, len = data.length; i < len; i++) {
					dataItemValues = data[i].values;

					for (j = 0, len2 = tallies.length; j < len2; j++) {
						tallies[j].add(dataItemValues[totalsRequest[j].column.dataKey]);
					}
				}

				for (i = 0, len = tallies.length; i < len; i++) {
					result[totalsRequest[i].column.dataKey] = tallies[i].getValueString(totalsRequest[i].column);
				}

				return result;
			}

			// filterRequest: [ {column, filterOperator} ]
			function _applyFiltering(data, filterRequest, gridView) {
				var dataLength, filterLength,
					filterValues = {},
					i, fi, operator, column,
					dataRes = [],
					dataRow, flag, j, dataVal;

				if (!data || (dataLength = data.length) === 0 ||
					!filterRequest || (filterLength = filterRequest.length) === 0) {

					return data;
				}

				// preformat filterValues
				for (i = 0; i < filterLength; i++) {
					fi = filterRequest[i];
					operator = fi.operator;
					column = fi.column;

					if (operator.arity > 1) {
						filterValues[i] = gridView._parse(column, column.filterValue);
					}
				}

				for (i = 0; i < dataLength; i++) {
					dataRow = data[i];
					flag = true;

					for (j = 0; j < filterLength && flag; j++) {
						fi = filterRequest[j];
						dataVal = dataRow.values[fi.column.dataKey];

						flag &= fi.operator.operator(dataVal, filterValues[j]);
					}

					if (flag) {
						dataRes.push(dataRow);
					}
				}

				return dataRes;
			}

			// sortRequest: array of { dataKey, sortDirection } 
			function _applySort(data, sortRequest) {
				if (sortRequest.length) {

					var builder = [],
						i, len, arg, si, dataKey, idx;

					builder.push("var context = this;"); // declare "context" variable explicitly to avoid js minimization issue.
					builder.push("this.sort = function(a, b)\n{\n");

					for (i = 0, len = sortRequest.length; i < len; i++) {
						arg = "arg" + i;
						si = sortRequest[i];

						dataKey = (typeof (si.dataKey) === "string")
							? "\"" + si.dataKey + "\""
							: si.dataKey;

						if (si.sortDirection === "ascending" || si.sortDirection === "descending") {
							if (si.sortDirection === "ascending") {
								builder.push("var ", arg, " = context._sortAsc", "(a.values[", dataKey, "], b.values[", dataKey, "]);\n");
							}
							else {
								builder.push("var ", arg, " = context._sortDesc", "(a.values[", dataKey, "], b.values[", dataKey, "]);\n");
							}
						} else { // sortDirection === none: restore original order
							builder.push("var ", arg, " = context._sortDigitAsc", "(a.originalRowIndex, b.originalRowIndex);\n");
						}

						builder.push("if (", arg, " === 0)\n");
						builder.push("{\n");
					}

					idx = sortRequest.length - 1;
					if (idx >= 0) { // sort identical values using originalRowIndex
						arg = "arg" + idx;
						si = sortRequest[idx];

						dataKey = (typeof (si.dataKey) === "string")
							? "\"" + si.dataKey + "\""
							: si.dataKey;

						if ((si.sortDirection === "ascending") || (si.sortDirection === "descending")) {
							if (si.sortDirection === "ascending") {
								builder.push("var ", arg, " = context._sortDigitAsc", "(a.originalRowIndex, b.originalRowIndex);\n");
							}
							else {
								builder.push("var ", arg, " = context._sortDigitDesc", "(a.originalRowIndex, b.originalRowIndex);\n");
							}
						}
					}

					for (i = sortRequest.length - 1; i >= 0; i--) {
						builder.push("}\n");
						arg = "arg" + i;
						builder.push("return ", arg, ";\n");
					}

					builder.push("}");

					eval(builder.join(""));

					data.sort(this.sort);
				}
			}

			this._sortAsc = function (a, b) {
				if (a instanceof Date) {
					a = a.getTime();
				}

				if (b instanceof Date) {
					b = b.getTime();
				}

				if (a === b) {
					return 0;
				}

				if (a === null) {
					return -1;
				}

				if (b === null) {
					return 1;
				}

				return (a < b) ? -1 : 1;
			};

			this._sortDesc = function (a, b) {
				if (a instanceof Date) {
					a = a.getTime();
				}

				if (b instanceof Date) {
					b = b.getTime();
				}

				if (a === b) {
					return 0;
				}

				if (a === null) {
					return 1;
				}

				if (b === null) {
					return -1;
				}

				return (a < b) ? 1 : -1;
			};

			this._sortDigitAsc = function (a, b) {
				return a - b;
			};

			this._sortDigitDesc = function (a, b) {
				return b - a;
			};
		}
	});
})(jQuery);(function ($) {
	"use strict";
	$.extend($.wijmo.wijgrid, {
		groupRange: function (expanded, range, sum, position) {
			this.value = -1;

			switch (arguments.length) {
				case 4:
					this.isExpanded = expanded;
					this.cr = range;
					this.sum = sum;
					this.position = position;
					break;

				case 1:
					this.isExpanded = expanded;
					this.cr = new $.wijmo.wijgrid.cellRange(-1, -1);
					this.sum = -1;
					this.position = "none";
					break;

				default:
					this.isExpanded = false;
					this.cr = new $.wijmo.wijgrid.cellRange(-1, -1);
					this.sum = -1;
					this.position = "none";
			}

			this.isSubRange = function (groupRange) {
				return ((this.cr.r1 >= groupRange.cr.r1) && (this.cr.r2 <= groupRange.cr.r2));
			};

			this.toString = function () {
				return this.cr.r1 + "-" + this.cr.r2;
			};

			this._getHeaderImageClass = function (expanded) {
				var groupInfo = this.owner;

				if (groupInfo) {
					return expanded
						? groupInfo.expandedImageClass || $.wijmo.c1field.prototype.options.groupInfo.expandedImageClass /*"ui-icon-triangle-1-se"*/
						: groupInfo.collapsedImageClass || $.wijmo.c1field.prototype.options.groupInfo.collapsedImageClass /*"ui-icon-triangle-1-e"*/;
				}

				return null;
			};

			this.collapse = function () {
				var groupInfo, column, grid, groupHelper, leaves, groupedColumnsCnt;

				if ((groupInfo = this.owner) && (column = groupInfo.owner) && (grid = column.owner)) {
					groupHelper = new $.wijmo.wijgrid.groupHelper();
					leaves = grid._field("leaves");

					if (groupHelper.isParentExpanded(leaves, this.cr, groupInfo.level)) {
						if ((groupInfo.position !== "footer") && (groupInfo.outlineMode !== "none")) { // do not collapse groups with .position == "footer"
							groupedColumnsCnt = groupHelper.getGroupedColumnsCount(leaves);
							/*var tbody = grid.$table.find("> tbody")[0];*/

							_collapse(groupHelper, grid._rows() /*tbody*/, leaves, this, groupedColumnsCnt);
						}
					}
				}
			};

			this.expand = function (expandChildren) {
				var groupInfo, column, grid, groupHelper, leaves, groupedColumnsCnt;

				if ((groupInfo = this.owner) && (column = groupInfo.owner) && (grid = column.owner)) {
					groupHelper = new $.wijmo.wijgrid.groupHelper();
					leaves = grid._field("leaves");

					if (groupHelper.isParentExpanded(leaves, this.cr, groupInfo.level)) {
						groupedColumnsCnt = groupHelper.getGroupedColumnsCount(leaves);
						/*var tbody = grid.$table.find("> tbody")[0];*/

						_expand(groupHelper, grid._rows(), leaves, this, groupedColumnsCnt, expandChildren, true);
					}
				}
			};

			// private members

			function _collapse(groupHelper, /*tbody*/rowAccessor, leaves, groupRange, groupedColumnsCnt) {
				var groupInfo = groupRange.owner,
					dataStart = groupRange.cr.r1,
					dataEnd = groupRange.cr.r2,
					rowObj, i, len,
					childRanges, childRange, j;

				switch (groupInfo.position) {
					case "header":
					case "headerAndFooter":
						rowObj = rowAccessor.item(groupRange.cr.r1);

						if (rowObj) {
							if (rowObj[0]) {
								rowObj[0]["aria-expanded"] = "false";
							}

							if (rowObj[1]) {
								rowObj[1]["aria-expanded"] = "false";
							}
						}

						dataStart++;
						break;
				}

				// hide child rows
				for (i = dataStart; i <= dataEnd; i++) {
					rowObj = rowAccessor.item(i);
					if (rowObj) {
						if (rowObj[0]) {
							rowObj[0].style.display = "none";
							rowObj[0]["aria-hidden"] = "true";
						}

						if (rowObj[1]) {
							rowObj[1].style.display = "none";
							rowObj[1]["aria-hidden"] = "true";
						}
					}

					//tbody.rows[i].style.display = "none";
				}

				// update isExpanded property
				groupRange.isExpanded = false;
				_updateHeaderIcon(/*tbody*/rowAccessor, groupRange);

				for (i = groupInfo.level + 1; i <= groupedColumnsCnt; i++) {
					childRanges = groupHelper.getChildGroupRanges(leaves, groupRange.cr, /*groupRange.owner.level*/ i - 1);
					for (j = 0, len = childRanges.length; j < len; j++) {
						childRange = childRanges[j];
						childRange.isExpanded = false;

						switch (childRange.owner.position) {
							case "header":
							case "headerAndFooter":
								rowObj = rowAccessor.item(childRange.cr.r1);

								if (rowObj) {
									if (rowObj[0]) {
										rowObj[0]["aria-expanded"] = "false";
									}

									if (rowObj[1]) {
										rowObj[1]["aria-expanded"] = "false";
									}
								}

								break;
						}

						_updateHeaderIcon(/*tbody*/rowAccessor, childRange);
					}
				}
			}

			function _expand(groupHelper, /*tbody*/rowAccessor, leaves, groupRange, groupedColumnsCnt, expandChildren, isRoot) {
				var groupInfo = groupRange.owner,
					dataStart = groupRange.cr.r1,
					dataEnd = groupRange.cr.r2,
					rowObj, i, len,
					childRanges, childRange, childIsRoot;

				switch (groupInfo.position) {
					case "header":
						/*tbody.rows[dataStart].style.display = "";*/
						rowObj = rowAccessor.item(dataStart);
						if (rowObj) {
							if (rowObj[0]) {
								rowObj[0].style.display = "";
								rowObj[0]["aria-hidden"] = "false";

								if (isRoot || expandChildren) {
									rowObj[0]["aria-expanded"] = "true";
								}
							}

							if (rowObj[1]) {
								rowObj[1].style.display = "";
								rowObj[1]["aria-hidden"] = "false";

								if (isRoot || expandChildren) {
									rowObj[1]["aria-expanded"] = "true";
								}
							}
						}
						dataStart++;
						break;
					case "footer":
						/*tbody.rows[dataEnd].style.display = "";*/
						rowObj = rowAccessor.item(dataEnd);
						if (rowObj) {
							if (rowObj[0]) {
								rowObj[0].style.display = "";
								rowObj[0]["aria-hidden"] = "false";
							}

							if (rowObj[1]) {
								rowObj[1].style.display = "";
								rowObj[1]["aria-hidden"] = "false";
							}
						}
						dataEnd--;
						break;
					case "headerAndFooter":
						/*tbody.rows[dataStart].style.display = "";*/
						rowObj = rowAccessor.item(dataStart);
						if (rowObj) {
							if (rowObj[0]) {
								rowObj[0].style.display = "";
								rowObj[0]["aria-hidden"] = "false";

								if (isRoot || expandChildren) {
									rowObj[0]["aria-expanded"] = "true";
								}
							}

							if (rowObj[1]) {
								rowObj[1].style.display = "";
								rowObj[1]["aria-hidden"] = "false";

								if (isRoot || expandChildren) {
									rowObj[1]["aria-expanded"] = "true";
								}
							}
						}
						if (isRoot) {
							/*tbody.rows[dataEnd].style.display = "";*/
							rowObj = rowAccessor.item(dataEnd);
							if (rowObj) {
								if (rowObj[0]) {
									rowObj[0].style.display = "";
									rowObj[0]["aria-hidden"] = "false";
								}

								if (rowObj[1]) {
									rowObj[1].style.display = "";
									rowObj[1]["aria-hidden"] = "false";
								}
							}
						}
						dataStart++;
						dataEnd--;
						break;
				}

				if (isRoot) {
					groupRange.isExpanded = true;
					_updateHeaderIcon(/*tbody*/rowAccessor, groupRange);
				} else {
					return;
				}

				if (groupRange.owner.level === groupedColumnsCnt) { // show data rows
					for (i = dataStart; i <= dataEnd; i++) {
						/*tbody.rows[i].style.display = "";*/
						rowObj = rowAccessor.item(i);
						if (rowObj) {
							if (rowObj[0]) {
								rowObj[0].style.display = "";
								rowObj[0]["aria-hidden"] = "false";
							}

							if (rowObj[1]) {
								rowObj[1].style.display = "";
								rowObj[1]["aria-hidden"] = "false";
							}
						}

					}
				} else {
					childRanges = groupHelper.getChildGroupRanges(leaves, groupRange.cr, groupRange.owner.level);

					if (expandChildren) { // throw action deeper
						for (i = 0, len = childRanges.length; i < len; i++) {
							childRange = childRanges[i];
							_expand(groupHelper, /*tbody*/rowAccessor, leaves, childRange, groupedColumnsCnt, expandChildren, true);
						}
					} else { // show only headers of the child groups or fully expand child groups with .position == "footer"\ .outlineMode == "none"
						for (i = 0, len = childRanges.length; i < len; i++) {
							childRange = childRanges[i];

							childIsRoot = (childRange.owner.position === "footer" || childRange.owner.outlineMode === "none")
								? true
								: false;

							_expand(groupHelper, /*tbody*/rowAccessor, leaves, childRange, groupedColumnsCnt, false, childIsRoot);
						}
					}
				}
			}

			function _updateHeaderIcon(/*tbody*/rowAccessor, groupRange) {
				if (groupRange.owner.position !== "footer") {
					/*var imageDiv = $(tbody.rows[groupRange.cr.r1]).find("div.wijmo-wijgrid-grouptogglebtn:first-child");*/
					var imageDiv = null,
					rowObj = rowAccessor.item(groupRange.cr.r1);

					if (rowObj) {
						if (rowObj[0]) {
							imageDiv = $(rowObj[0]).find("div.wijmo-wijgrid-grouptogglebtn:first-child");
						}
					}

					if (imageDiv && imageDiv.length) {
						imageDiv.toggleClass(groupRange._getHeaderImageClass(!groupRange.isExpanded), false);
						imageDiv.toggleClass(groupRange._getHeaderImageClass(groupRange.isExpanded), true);
					}
				}
			}
		},

		grouper: function () {

			this.group = function (grid, data, leaves) {
				this._grid = grid;
				this._data = data;
				this._leaves = leaves;
				this._groupRowIdx = 0;
				this._groupHelper = new $.wijmo.wijgrid.groupHelper();

				var level = 1,
					i, len, leaf,
					groupCollection = [],
					needReset = false,
					groupLength = 0;

				//get the grouped columns
				for (i = 0, len = leaves.length; i < len; i++) {
					leaf = leaves[i];

					if (leaf.groupInfo) {
						delete leaf.groupInfo.level;
						delete leaf.groupInfo.expandInfo;
					}

					if (/*(leaf.dynamic !== true) && */leaf.groupInfo && (leaf.groupInfo.position && (leaf.groupInfo.position !== "none")) &&
						(leaf.dataIndex >= 0)) {
						if (leaf.groupedIndex === undefined) {
							needReset = true;
						}
					} else {
						if (leaf.groupedIndex !== undefined) {
							delete leaf.groupedIndex;
						}
					}
				}
				if (needReset) {
					for (i = 0, len = leaves.length; i < len; i++) {
						leaf = leaves[i];

						if (/*(leaf.dynamic !== true) && */leaf.groupInfo && (leaf.groupInfo.position && (leaf.groupInfo.position !== "none")) &&
							(leaf.dataIndex >= 0)) {
							leaf.groupedIndex = groupLength++;
							groupCollection.push(leaf);
						}
					}
				} else {
					groupCollection = $.map(leaves, function (element, index) {
						return element.groupedIndex !== undefined ? element : null;
					});
					groupCollection.sort(function (a, b) {
						return a.groupedIndex - b.groupedIndex;
					});
					$.each(groupCollection, function (index, item) {
						item.groupedIndex = index;
					});
				}
				grid._field("groups", groupCollection);

				for (i = 0, len = groupCollection.length; i < len; i++) {
					leaf = groupCollection[i];
					this._groupRowIdx = 0;

					if (/*(leaf.dynamic !== true) && */leaf.groupInfo && (leaf.groupInfo.position && (leaf.groupInfo.position !== "none")) &&
						(leaf.dataIndex >= 0)) {
						leaf.groupInfo.level = level;
						leaf.groupInfo.expandInfo = [];
						this._processRowGroup(leaf, level++);
					}
				}
				/*
				for (i = 0, len = leaves.length; i < len; i++) {
					leaf = leaves[i];
					this._groupRowIdx = 0;

					if ((leaf.dynamic !== true) && leaf.groupInfo && (leaf.groupInfo.position && (leaf.groupInfo.position !== "none")) &&
						(leaf.dataIndex >= 0) && !leaf.groupInfo.expandInfo) {
						leaf.groupInfo.level = level;
						leaf.groupInfo.expandInfo = [];
						this._processRowGroup(leaf, level++);
					}
				}
				*/
				delete this._grid;
				delete this._data;
				delete this._leaves;
			};

			this._processRowGroup = function (leaf, level) {
				var row, cellRange, isExpanded, startCollapsed, indentRow,
					groupRange, isParentCollapsed, header, footer, i;

				for (row = 0; row < this._data.length; row++) {
					// if (this._data[row].rowType !== "data") {
					if (!(this._data[row].rowType & $.wijmo.wijgrid.rowType.data)) {
						continue;
					}

					cellRange = this._getGroupCellRange(row, leaf, level);
					isExpanded = true;
					startCollapsed = (leaf.groupInfo.outlineMode === "startCollapsed");

					if (startCollapsed || this._groupHelper.isParentCollapsed(this._leaves, cellRange, level)) {
						if ((leaf.groupInfo.groupSingleRow === false) && (cellRange.r1 === cellRange.r2)) {
							continue;
						}
						isExpanded = false;
					}

					// indent
					if (level && this._grid.options.groupIndent) {
						for (indentRow = cellRange.r1; indentRow <= cellRange.r2; indentRow++) {
							this._addIndent(this._data[indentRow][0], level);
						}
					}

					// insert group header/ group footer
					switch (leaf.groupInfo.position) {
						case "header":
							groupRange = this._addGroupRange(leaf.groupInfo, cellRange, isExpanded);
							this._updateByGroupRange(groupRange, level);

							isParentCollapsed = this._groupHelper.isParentCollapsed(this._leaves, groupRange.cr, level);
							header = this._buildGroupRow(groupRange, cellRange, true, isParentCollapsed);

							for (i = cellRange.r1; i <= cellRange.r2; i++) {
								this._data[i].__attr["aria-level"] = level + 1;
								if (!isExpanded) {
									this._data[i].__style.display = "none";
									this._data[i].__attr["aria-hidden"] = true;

								}
							}

							this._data.splice(cellRange.r1, 0, header); // insert group header

							header.__attr["arial-level"] = level;
							header.__attr["aria-expanded"] = isExpanded;
							if (isParentCollapsed) {
								header.__style.display = "none";
								header.__attr["aria-hidden"] = true;
							}

							row = cellRange.r2 + 1;
							break;

						case "footer":
							groupRange = this._addGroupRange(leaf.groupInfo, cellRange, true);
							this._updateByGroupRange(groupRange, level);

							footer = this._buildGroupRow(groupRange, cellRange, false, false);
							footer.__attr["aria-level"] = level;

							this._data.splice(cellRange.r2 + 1, 0, footer);
							row = cellRange.r2 + 1;

							isParentCollapsed = this._groupHelper.isParentCollapsed(this._leaves, groupRange.cr, level);
							if (isParentCollapsed) {
								footer.__style.display = "none";
								footer.__attr["aria-hidden"] = true;
							}

							break;

						case "headerAndFooter":
							groupRange = this._addGroupRange(leaf.groupInfo, cellRange, isExpanded);
							this._updateByGroupRange(groupRange, level);

							isParentCollapsed = this._groupHelper.isParentCollapsed(this._leaves, groupRange.cr, level);
							header = this._buildGroupRow(groupRange, cellRange, true, isParentCollapsed);
							footer = this._buildGroupRow(groupRange, cellRange, false, false);

							for (i = cellRange.r1; i <= cellRange.r2; i++) {
								this._data[i].__attr["aria-level"] = level + 1;
								if (!isExpanded) {
									this._data[i].__style.display = "none";
									this._data[i].__attr["aria-hidden"] = true;
								}
							}

							this._data.splice(cellRange.r2 + 1, 0, footer);
							footer.__attr["aria-level"] = level;
							if (isParentCollapsed || !isExpanded) {
								footer.__style.display = "none";
								footer.__attr["aria-hidden"] = true;
							}

							this._data.splice(cellRange.r1, 0, header);
							header.__attr["aria-level"] = level;
							header.__attr["aria-expanded"] = isExpanded;
							if (isParentCollapsed) {
								header.__style.display = "none";
								header.__attr["aria-hidden"] = true;
							}

							row = cellRange.r2 + 2;
							break;

						default:
							throw $.wijmo.wijgrid.stringFormat("Unknown Position value: \"{0}\"", leaf.groupInfo.position);
					}

					this._groupRowIdx++;
				}
			};

			this._buildGroupRow = function (groupRange, cellRange, isHeader, isParentCollapsed) {
				//when some column is hidden, the group row is not correct.
				var groupInfo = groupRange.owner,
					leaf = groupInfo.owner,
					gridView = leaf.owner,
					row = [],
					groupByText = "",
					//headerOffset = 0,
					aggregate = "",
					tmp, cell, caption, args, span, col, bFirst, agg;

				row.__style = {};
				row.__attr = {};

				row.__attr.id = ((isHeader) ? "GH" : "GF") + this._groupRowIdx + "-" + groupInfo.level;

				row.rowType = (isHeader)
					? $.wijmo.wijgrid.rowType.groupHeader //"groupHeader"
					: $.wijmo.wijgrid.rowType.groupFooter; // "groupFooter";

				//if (cellRange.c1 > -1 && ((tmp = this._data[cellRange.r1][cellRange.c1].value) !== null)) {
				if ((leaf.dataIndex >= 0) && ((tmp = this._data[cellRange.r1][leaf.dataIndex].value) !== null)) {
					groupByText = gridView._toStr(leaf, tmp);
				}

				if (this._grid.options.showRowHeader) {
					row.push({ html: "&nbsp;" });
				}

				// create the summary cell
				cell = { html: "", __attr: {}, __style: {} };
				if (isHeader && groupInfo.outlineMode !== "none") {
					if (groupRange.isExpanded) {
						cell.html = "<div class=\"ui-icon " + groupRange._getHeaderImageClass(true) +
						" wijmo-wijgrid-grouptogglebtn\">&nbsp;</div>";
					}
					else {
						cell.html = "<div class=\"ui-icon " + groupRange._getHeaderImageClass(false) +
						" wijmo-wijgrid-grouptogglebtn\">&nbsp;</div>";
					}
				}

				row.push(cell);

				// add group header text
				/*var leaf = (cellRange.c1 >= 0)
				? this._leaves[cellRange.c1]
				: null;*/
				if (leaf.aggregate && (leaf.aggregate !== "none")) {
					//aggregate = this._getAggregate(cellRange, leaf, groupInfo.owner, isHeader, groupByText);
					aggregate = this._getAggregate(cellRange, leaf, leaf, isHeader, groupByText);

					//if (leaf.parentVis) {
					//	headerOffset = 1;
					//}
				}

				caption = (isHeader)
					? groupInfo.headerText
					: groupInfo.footerText;

				// format caption

				// The text may include up to three placeholders:
				// "{0}" is replaced with the value being grouped on and
				// "{1}" is replaced with the group's column header
				// "{2}" is replaced with the aggregate
				if (caption === "custom") {
					args = {
						data: this._data, // data object.
						column: leaf, // column that is being grouped.
						groupByColumn: groupInfo.owner, // column initiated grouping.
						groupText: groupByText, // text that is being grouped.
						text: "", // text that will be displayed in the groupHeader or Footer.
						groupingStart: cellRange.r1, // first index for the data being grouped.
						groupingEnd: cellRange.r2, // last index for the data being grouped.
						isGroupHeader: isHeader,
						aggregate: aggregate
					};

					if (this._grid._trigger("groupText", null, args)) {
						caption = args.text;
					}
				} else {
					if ((caption === undefined) || (caption === null)) { // use default formatting
						if (isHeader) {
							caption = "{1}: {0}";
						}

						if (aggregate || (aggregate === 0)) {
							caption = caption
								? caption + " {2}"
								: "{2}";
						}
					}

					caption = $.wijmo.wijgrid.stringFormat(caption, groupByText,
						leaf && leaf.headerText ? leaf.headerText : "",
						aggregate.toString());
				}

				if (!caption) {
					caption = "&nbsp;";
				}

				cell.html += "<span>" + caption + "</span>";
				this._addIndent(cell, groupInfo.level - 1);

				// summary cells span until the end of the row or the first aggregate
				//span = headerOffset;
				span = 1;
				col = (this._grid.options.showRowHeader)
					? 1
					: 0;

				//for (; col < cellRange.c1; col++) { // c1 is an index of the leaf inside the this._leaves
				//	if (this._leaves[col].parentVis) {
				//		span++;
				//	}
				//}

				//col = cellRange.c1 + headerOffset;
				bFirst = true;
				for (; col < this._leaves.length; col++) {
					leaf = this._leaves[col];
					if (leaf.parentVis) {
						if (bFirst) {
							bFirst = false;
							continue;
						}
						if ((leaf.dynamic !== true) && leaf.aggregate && (leaf.aggregate !== "none")) {
							break;
						}

						span++;
					}
				}

				// add aggregates (or blanks) until the end of the row
				for (; col < this._leaves.length; col++) {
					leaf = this._leaves[col];
					if (leaf.parentVis) {
						agg = this._getAggregate(cellRange, leaf, groupInfo.owner, isHeader, groupByText);
						if (!agg && (agg !== 0)) {
							agg = "&nbsp;";
						}
						row.push({ html: agg.toString() });
					}
				}

				//cell.colSpan = span;
				cell.__attr.colSpan = span;

				return row;
			};

			this._getAggregate = function (cellRange, column, groupByColumn, isGroupHeader, groupByText) {
				var aggregate = "",
					args, tally, row;

				if (!column.aggregate || (column.aggregate === "none")) {
					return aggregate;
				}

				if (column.aggregate === "custom") {
					args = {
						data: this._data, // data object
						column: column, // column that is being grouped.
						groupByColumn: groupByColumn, // column initiated grouping.
						groupText: groupByText, // text that is being grouped.
						text: "", // text that will be displayed in the groupHeader or groupFooter.
						groupingStart: cellRange.r1, // first index for the data being grouped.
						groupingEnd: cellRange.r2, // last index for the data being grouped.
						isGroupHeader: isGroupHeader
					};

					if (this._grid._trigger("groupAggregate", null, args)) {
						aggregate = args.text;
					}
				} else {
					tally = new $.wijmo.wijgrid.tally();

					for (row = cellRange.r1; row <= cellRange.r2; row++) {
						tally.add(this._data[row][column.dataIndex].value);
					}

					aggregate = tally.getValueString(column);
				}

				return aggregate;
			};

			this._getGroupCellRange = function (row, leaf, level) {
				//var range = new $.wijmo.wijgrid.cellRange(row, leaf.dataIndex);
				var idx = leaf.leavesIdx, // $.inArray(leaf, this._leaves);
					range = new $.wijmo.wijgrid.cellRange(row, idx),
					parentRange = this._groupHelper.getParentGroupRange(this._leaves, range, level),
					str, count;

				//if (this._data[row].rowType === "data") {
				if (this._data[row].rowType & $.wijmo.wijgrid.rowType.data) {
					str = this._data[row][leaf.dataIndex].value;

					for (range.r2 = row, count = this._data.length - 1; range.r2 < count; range.r2++) {
						//if ((this._data[range.r2 + 1].rowType !== "data") || (parentRange && (range.r2 + 1 > parentRange.r2))) {
						if (!(this._data[range.r2 + 1].rowType & $.wijmo.wijgrid.rowType.data) || (parentRange && (range.r2 + 1 > parentRange.r2))) {
							break;
						}

						if (this._data[range.r2 + 1][leaf.dataIndex].value !== str) {
							break;
						}
					}
				}

				return range;
			};

			this._addGroupRange = function (groupInfo, cellRange, isExpanded) {
				var result = null,
					idx = this._groupHelper.getChildGroupIndex(cellRange, groupInfo.expandInfo),
					range, expandState, r1, r2;

				if (idx >= 0 && idx < groupInfo.expandInfo.length) {
					result = groupInfo.expandInfo[idx];
				} else {
					range = new $.wijmo.wijgrid.cellRange(cellRange.r1, cellRange.r1, cellRange.r2, cellRange.r2); // clone
					expandState = (groupInfo.position === "footer")
						? true
						: isExpanded && (groupInfo.outlineMode !== "startCollapsed");

					result = new $.wijmo.wijgrid.groupRange(expandState, range, -1, groupInfo.position);

					result.owner = groupInfo;

					groupInfo.expandInfo.push(result);
				}

				if (result) {
					r1 = cellRange.r1;
					r2 = cellRange.r2;

					if (groupInfo.position === "headerAndFooter") {
						r2 += 2;
					}

					if (groupInfo.position !== "headerAndFooter") {
						r2++;
					}

					result.cr.r2 = r2;
				}

				return result;
			};

			this._updateByGroupRange = function (groupRange, level) {
				var i, len, groupInfo, len2, j, cur, delta;

				for (i = 0, len = this._leaves.length; i < len; i++) {
					groupInfo = this._leaves[i].groupInfo;

					//
					// if (groupInfo) {
					//

					if (groupInfo && (groupInfo.level < level)) {

						len2 = (groupInfo.expandInfo)
							? groupInfo.expandInfo.length
							: 0;

						for (j = 0; j < len2; j++) {
							cur = groupInfo.expandInfo[j];
							//
							//if (cur.cr.r1 !== groupRange.cr.r1) {
							//
							delta = (groupRange.position === "headerAndFooter") ? 2 : 1;

							if (cur.cr.r1 >= groupRange.cr.r1 && !((cur.cr.r1 === groupRange.cr.r1) && (cur.position === "footer"))) {
								cur.cr.r1 += delta;
							}

							if (cur.cr.r2 >= groupRange.cr.r1) {
								cur.cr.r2 += delta;
							}
							//
							//}
							//
						}
					}
				}
			};

			this._addIndent = function (cellObj, level) {
				var indent;

				if (level > 0 && (indent = this._grid.options.groupIndent)) {
					cellObj.__style.paddingLeft = (indent * level) + "px";
				}
			};
		}
	});
})(jQuery);
(function ($) {
	"use strict";
	$.extend($.wijmo.wijgrid, {
		groupHelper: function () {

			this.getGroupInfo = function (domRow) {

				if (domRow) {
					if (!$.wijmo.wijgrid._getGroupInfoRegExp) {
						$.wijmo.wijgrid._getGroupInfoRegExp = new RegExp(".*G([HF]){1}(\\d+)-(\\d+)$");
					}

					var info = $.wijmo.wijgrid._getGroupInfoRegExp.exec(domRow.id),
						level, index, isHeader;

					if (info) {
						level = parseInt(info[3], 10);
						index = parseInt(info[2], 10);
						isHeader = (info[1] === "H");

						return {
							level: level,
							index: index,
							isHeader: isHeader,
							toString: function () {
								return (this.isHeader ? "GH" : "GF") + this.index + "-" + this.level;
							}
						};
					}
				}

				return null;
			};

			this.getColumnByGroupLevel = function (leaves, level) {
				var i, len, leaf;

				for (i = 0, len = leaves.length; i < len; i++) {
					leaf = leaves[i];
					if (leaf.groupInfo && (leaf.groupInfo.level === level)) {
						return leaf;
					}
				}

				return null;
			};

			this.getGroupedColumnsCount = function (leaves) {
				var result = 0,
					i, len, groupInfo;

				for (i = 0, len = leaves.length; i < len; i++) {
					groupInfo = leaves[i].groupInfo;
					if (groupInfo && (groupInfo.position !== "none")) {
						result++;
					}
				}

				return result;
			};

			// cellRange cellRange
			// groupRange[] childExpandInfo
			this.getChildGroupIndex = function (cellRange, childExpandInfo) {
				var left = 0,
					right = childExpandInfo.length - 1,
					median, cmp;

				while (left <= right) {
					median = ((right - left) >> 1) + left;
					cmp = childExpandInfo[median].cr.r1 - cellRange.r1;

					if (cmp === 0) {
						return median;
					}

					if (cmp < 0) {
						left = median + 1;
					} else {
						right = median - 1;
					}
				}

				return left;
				//return ~left;
			};

			// cellRange childRange
			// groupRange[] parentExpandInfo
			this.getParentGroupIndex = function (cellRange, parentExpandInfo) {
				var idx = this.getChildGroupIndex(cellRange, parentExpandInfo);

				if (idx > 0) {
					idx--;
				}

				return (idx < parentExpandInfo.length)
					? idx
					: -1;
			};

			// level: 1-based level of the cellRange;
			this.getChildGroupRanges = function (leaves, cellRange, level) {
				var result = [],
					childRanges, childRange, i, len, firstChildIdx,
					childGroupedColumn = this.getColumnByGroupLevel(leaves, level + 1);

				if (childGroupedColumn) {
					childRanges = childGroupedColumn.groupInfo.expandInfo;

					firstChildIdx = this.getChildGroupIndex(cellRange, childRanges);
					for (i = firstChildIdx, len = childRanges.length; i < len; i++) {
						childRange = childRanges[i];
						if (childRange.cr.r2 <= cellRange.r2) {
							result.push(childRange);
						} else {
							break;
						}
					}

					/*for (var i = 0, len = childRanges.length; i < len; i++) {
					if (childRange.cr.r1 >= cellRange.r1 && childRange.r2 <= cellRange.r2) {
					result.push(childRange);
					}
					}*/
				}

				return result;
			};

			// level: 1-based level of the cellRange; optional.
			this.getParentGroupRange = function (leaves, cellRange, level) {
				var i, groupInfo, idx;

				if (level === undefined) {
					level = 0xFFFF;
				}

				if (level - 2 >= 0) {
					for (i = leaves.length - 1; i >= 0; i--) {
						groupInfo = leaves[i].groupInfo;
						if (!groupInfo || !groupInfo.expandInfo || (groupInfo.level < 0) || (groupInfo.level !== level - 1)) {
							continue;
						}

						idx = this.getParentGroupIndex(cellRange, groupInfo.expandInfo);
						if (idx >= 0) {
							return groupInfo.expandInfo[idx];
						}
					}
				}

				return null;
			};

			// level: 1-based level of the cellRange.
			this.isParentCollapsed = function (leaves, cellRange, level) {
				var i, parentGroupRange;

				if (level === 1) {
					return false;
				}

				for (i = level; i > 1; i--) {
					parentGroupRange = this.getParentGroupRange(leaves, cellRange, i);

					if (parentGroupRange && !parentGroupRange.isExpanded) {
						return true;
					}

					cellRange = parentGroupRange.cr;
				}

				return false;
			};

			// level: 1-based level of the cellRange.
			this.isParentExpanded = function (leaves, cellRange, level) {
				var i, parentGroupRange;

				if (level === 1) {
					return true;
				}

				for (i = level; i > 1; i--) {
					parentGroupRange = this.getParentGroupRange(leaves, cellRange, i);

					if (parentGroupRange && parentGroupRange.isExpanded) {
						return true;
					}

					cellRange = parentGroupRange.cr;
				}

				return false;
			};
		}
	});
})(jQuery);(function ($) {
	"use strict";
	$.extend($.wijmo.wijgrid, {
		cellRange: function (row1, col1, row2, col2) {
			switch (arguments.length) {
				case 2:
					this.r1 = this.r2 = row1;
					this.c1 = this.c2 = col1;
					break;
				case 4:
					this.r1 = row1;
					this.r2 = row2;
					this.c1 = col1;
					this.c2 = col2;
					break;
				default:
					this.r1 = 0;
					this.r2 = 0;
					this.c1 = 0;
					this.c2 = 0;
			}

			this.isSingleCell = function () {
				return ((this.r1 === this.r2) && (this.c1 === this.c2));
			};
		},

		merger: function () {
			this.merge = function (data, visibleLeaves) {
				this.leaves = visibleLeaves;
				this.data = data;

				var i, len, leaf;

				for (i = 0, len = visibleLeaves.length; i < len; i++) {
					leaf = visibleLeaves[i];

					if ((leaf.dataIndex >= 0) && !leaf.isBand && (leaf.rowMerge === "free" || leaf.rowMerge === "restricted")) {
						this.mergeColumn(leaf);
					}
				}
				delete this.data;
				delete this.leaves;
			};

			this.mergeColumn = function (column) {
				var dataIdx = column.dataIndex,
					i, len, range, span, spannedRow;

				for (i = 0, len = this.data.length; i < len; i++) {
					//if (this.data[i].rowType !== "data") {
					if (!(this.data[i].rowType & $.wijmo.wijgrid.rowType.data)) {
						continue;
					}

					range = this.getCellRange(i, column);

					if (range.r1 !== range.r2) {
						span = range.r2 - range.r1 + 1;
						//this.data[range.r1][dataIdx].rowSpan = span;
						this.data[range.r1][dataIdx].__attr.rowSpan = span;

						for (spannedRow = range.r1 + 1; spannedRow <= range.r2; spannedRow++) {
							//this.data[spannedRow][dataIdx] = null;
							this.data[spannedRow][dataIdx].visible = false;
						}
					}

					i = range.r2;
				}
			};

			this.getCellRange = function (rowIdx, column) {
				var columnIdx = column.dataIndex,
					range = new $.wijmo.wijgrid.cellRange(rowIdx, columnIdx),
					str = this.data[rowIdx][columnIdx].value,
					dataLen = this.data.length,
					dataItem, leafIdx, prevLeaf, range2;

				for (range.r2 = rowIdx; range.r2 < dataLen - 1; range.r2++) {
					dataItem = this.data[range.r2 + 1];

					//if ((dataItem.rowType !== "data") || (dataItem[columnIdx].value !== str)) {
					if (!(dataItem.rowType & $.wijmo.wijgrid.rowType.data) || (dataItem[columnIdx].value !== str)) {
						break;
					}
				}

				leafIdx = column.leavesIdx; // $.inArray(column, this.leaves);
				if (leafIdx > 0 && column.rowMerge === "restricted") {
					prevLeaf = this.leaves[leafIdx - 1];
					if (prevLeaf.dataIndex >= 0) {
						range2 = this.getCellRange(rowIdx, prevLeaf);
						range.r1 = Math.max(range.r1, range2.r1);
						range.r2 = Math.min(range.r2, range2.r2);
					}
				}

				return range;
			};
		}
	});
})(jQuery);(function ($) {
	"use strict";
	$.extend($.wijmo.wijgrid, {
		/// <summary>
		/// Row type.
		/// </summary>
		rowType: {
			/// <summary>
			/// Header row.
			/// </summary>
			header: 1,

			/// <summary>
			/// Data row.
			/// </summary>
			data: 2,

			/// <summary>
			/// Data alternating row (used only as modifier of the rowType.data, not as independent value).
			/// </summary>
			dataAlt: 4,

			/// <summary>
			/// Filter row.
			/// </summary>
			filter: 8,

			/// <summary>
			/// Group header row.
			/// </summary>
			groupHeader: 16,

			/// <summary>
			/// Group footer row.
			/// </summary>
			groupFooter: 32,

			/// <summary>
			/// Footer row.
			/// </summary>
			footer: 64,

			/// <summary>
			/// Empty data row
			/// </summary>
			emptyDataRow: 128
		},

		/// <summary>
		/// Determines an object render state.
		/// </summary>
		renderState: {
			/// <summary>
			/// Normal state.
			/// </summary>
			none: 0,

			/// <summary>
			/// Object is being rendered.
			/// </summary>
			rendering: 1,

			/// <summary>
			/// Object is one of the elements determining the current position of the wijgrid.
			/// </summary>
			current: 2,

			/// <summary>
			/// Object is hovered.
			/// </summary>
			hovered: 4,

			/// <summary>
			/// Object is selected.
			/// </summary>
			selected: 8
		},

		stringFormat: function (value, params) {
			var i, len;

			if (!value) {
				return "";
			}

			for (i = 1, len = arguments.length; i < len; i++) {
				value = value.replace(new RegExp("\\{" + (i - 1) + "\\}", "gm"), arguments[i]);
			}

			return value;
		},

		validDataKey: function (dataKey) {
			return (dataKey && !(dataKey < 0)) || (dataKey === 0);
		},

		iterateChildrenWidgets: function (item, callback) {
			if (item && callback) {
				if (item.nodeType) {
					item = $(item);
				}

				item.find(".ui-widget").each(function (domIndex, domValue) {
					$.each($(domValue).data(), function (dataKey, dataValue) {
						if (dataValue.widgetName) {
							callback(domIndex, dataValue);
						}
					});
				});
			}
		},

		remove$dataByPrefix: function ($element, prefix) {
			var data$keys = [];

			$.each($element.data(), function (key) {
				if (key.indexOf(prefix) === 0) {
					data$keys.push(key);
				}
			});

			$.each(data$keys, function (idx, key) {
				$element.removeData(key);
			});
		},

		domSelection: function (input) {
			this.getSelection = function () {
				var start = 0,
					end = 0,
					textRange;

				if (input.selectionStart !== undefined) { // DOM3
					start = input.selectionStart;
					end = input.selectionEnd;
				} else {
					if (document.selection) { // IE
						textRange = document.selection.createRange().duplicate();
						end = textRange.text.length; // selection length
						start = Math.abs(textRange.moveStart("character", -input.value.length)); // move selection to the beginning
						end += start;
					}
				}

				return { start: start, end: end, length: end - start };
			};

			this.setSelection = function (range) {
				if (input.selectionStart !== undefined) { // DOM3
					input.setSelectionRange(range.start, range.end);
				} else { // IE
					var textRange = input.createTextRange();

					textRange.collapse(true);
					textRange.moveStart("character", range.start);
					textRange.moveEnd("character", range.end);
					textRange.select();
				}
			};
		},

		createDynamicField: function (options) {
			return $.extend(true,
								{},
								$.wijmo.c1basefield.prototype.options,
								$.wijmo.c1field.prototype.options,
								{ dynamic: true, isLeaf: true, isBand: false },
								options
							);
		},

		bounds: function (element, client) {
			if (element) {
				var $dom = element.nodeType ? $(element) : element,
					offset = $dom.offset();

				if (offset) {
					if (client) {
						return { top: offset.top, left: offset.left, width: $dom[0].clientWidth || 0, height: $dom[0].clientHeight || 0 };
					}

					return { top: offset.top, left: offset.left, width: $dom.outerWidth(), height: $dom.outerHeight() };
				}
			}

			return null;
		},

		_getDOMText: function (domElement, controlDepth, depth) {
			if (depth === undefined) {
				depth = 0;
			}

			if (domElement && (!controlDepth || (controlDepth && depth < 2))) {
				if (domElement.nodeType === 3) { // text node
					return domElement.nodeValue;
				}
				else
					if (domElement.nodeType === 1) { // element node

						switch (domElement.type) {
							case "button":
							case "text":
							case "textarea":
							case "select-one":
								return domElement.value;
							case "checkbox":
								return domElement.checked.toString();
						}

						var result = "",
							i;

						for (i = 0; domElement.childNodes[i]; i++) {
							result += this._getDOMText(domElement.childNodes[i], controlDepth, depth + 1);
						}
						return result;
					}
			}

			return "";
		},

		ensureTBody: function (domTable) {
			if (domTable) {
				return (domTable.tBodies && domTable.tBodies.length > 0)
					? domTable.tBodies[0]
					: domTable.appendChild(document.createElement("tbody"));
			}

			return null;
		},

		rowTypeFromCss: function ($rows) {
			var test = /wijmo-wijgrid-(\S+)row/.exec($rows.attr("class"));

			if (test) {
				switch (test[1]) {
					case "header":
						return $.wijmo.wijgrid.rowType.header;

					case "filter":
						return $.wijmo.wijgrid.rowType.filter;

					case "data":
						if ($rows.hasClass("wijmo-wijgrid-alternatingrow")) {
							return $.wijmo.wijgrid.rowType.data | $.wijmo.wijgrid.rowType.dataAlt;
						}
						return $.wijmo.wijgrid.rowType.data;

					case "alternating":
						return $.wijmo.wijgrid.rowType.data | $.wijmo.wijgrid.rowType.dataAlt;

					case "groupheader":
						return $.wijmo.wijgrid.rowType.groupHeader;

					case "groupheader":
						return $.wijmo.wijgrid.rowType.groupFooter;
				}
			}
		},

		// deep (boolean, opt), obj, prefix, name (opt), value(s) (opt)
		dataPrefix: function () {
			var len = arguments.length,
				key, value, internalName,
				deep = (typeof (arguments[0]) === "boolean"),
				obj = deep ? arguments[1] : arguments[0],
				is$ = (obj.nodeType === undefined),
				foo, i, currentVal;

			if (len === 3) { // getter
				internalName = arguments[1] + arguments[2];
				return (is$)
					? $.data(obj[0], internalName)
					: $.data(obj, internalName);
			} else { // setter
				if (deep) {
					value = arguments[3];

					for (key in value) {
						currentVal = value[key];
						if (value.hasOwnProperty(key)) {
							internalName = arguments[2] + key;
							if (is$) {
								for (i = 0, len = obj.length; i < len; i++) {
									foo = $.data(obj[i], internalName, currentVal);
								}
							} else {
								$.data(obj, internalName, currentVal);
							}
						}
					}
				} else {
					internalName = arguments[1] + arguments[2];
					currentVal = arguments[3];

					if (is$) {
						for (i = 0, len = obj.length; i < len; i++) {
							foo = $.data(obj[i], internalName, currentVal);
						}
						return foo;
					} else {
						return $.data(obj, internalName, currentVal);
					}
				}
			}
		},

		shallowMerge: function (target, src) {
			if (src && target) {
				var name, value, typeOf;

				for (name in src) {
					if (src.hasOwnProperty(name)) {
						value = src[name];
						typeOf = typeof (value);

						if ((typeOf === "string" || typeOf === "boolean" || typeOf === "number") && (target[name] === undefined)) {
							target[name] = value;
						}
					}
				}
			}
		},

		isCustomObject: function (value) {
			return (value && (typeof (value) === "object") && !(value instanceof Date));
		},

		search: function (value, test) {
			var key, foo,
				isFunc = $.isFunction(test);

			for (key in value) {
				if (value.hasOwnProperty(key)) {

					foo = isFunc
						? test(value[key])
						: (value[key] === test);

					if (foo === true) {
						return {
							at: key,
							found: value[key]
						};
					}
				}
			}

			return {
				at: null,
				found: null
			};
		},

		getAttributes: function (dom, prevent) {
			if (dom) {
				var $dom = $(dom),
					i, len,
					cnt = 0,
					result = {},
					attrValue, attrName;

				for (i = 0, len = dom.attributes.length; i < len; i++) {
					attrName = dom.attributes[i].name;
					if (attrName && (!prevent || !prevent(attrName))) {
						attrValue = dom.getAttribute(attrName);

						if (attrName === "style") {
							attrValue = (typeof (attrValue) === "object")
								? attrValue.cssText
								: attrValue;
						}

						if (!attrValue && attrName === "class") {
							attrValue = dom.getAttribute("className");
						}

						if (attrValue && (typeof (attrValue) !== "function")) {
							result[attrName] = attrValue;
							cnt++;
						}
					}
				}

				if (cnt) {
					return result;
				}
			}

			return null;
		}
	});


	/*$.extend($.wijmo.wijgrid, {
	measurments: [],

	timerOn: function (cat) {
	this.measurments[cat] = new Date().getTime();
	},

	timerOff: function (cat) {
	var result = (new Date().getTime() - this.measurments[cat]) / 1000;
	delete this.measurments[cat];
	return result;
	},
	});*/
})(jQuery);(function ($) {
	"use strict";

	$.extend($.wijmo.wijgrid, {
		embeddedParsers: {
			stringParser: {
				// DOM -> string
				parseDOM: function (value, culture, format, nullString, convertEmptyStringToNull) {
					return this.parse($.wijmo.wijgrid._getDOMText(value, true), culture, format, nullString, convertEmptyStringToNull);
				},

				// string -> string
				parse: function (value, culture, format, nullString, convertEmptyStringToNull) {
					switch (value) {
						case null:
							return null;

						case nullString:
							if (convertEmptyStringToNull) {
								return null;
							}

						case undefined:
						case "&nbsp":
							return "";

						default:
							return "" + value;
					}
				},

				// string -> string
				toStr: function (value, culture, format, nullString, convertEmptyStringToNull) {
					if (value === null && convertEmptyStringToNull) {
						return nullString;
					}
					return "" + value;
				}
			},

			numberParser: {
				// DOM -> number
				parseDOM: function (value, culture, format, nullString, convertEmptyStringToNull) {
					return this.parse($.wijmo.wijgrid._getDOMText(value, true), culture, format, nullString, convertEmptyStringToNull);
				},

				// string\ number -> number
				parse: function (value, culture, format, nullString, convertEmptyStringToNull) {
					var type = typeof (value);

					if (type === "number") {
						return isNaN(value)
							? NaN
							: value;
					}

					if ((!value && value !== 0) || (value === "&nbsp;") || (value === nullString && convertEmptyStringToNull)) {
						return null;
					}

					return $.parseFloat(value, 10, culture.name);
				},

				// number -> string
				toStr: function (value, culture, format, nullString, convertEmptyStringToNull) {
					if (value === null && convertEmptyStringToNull) {
						return nullString;
					}

					return $.format(value, format ? format : "n", culture.name);
				}
			},

			currencyParser: {
				// DOM -> number
				parseDOM: function (value, culture, format, nullString, convertEmptyStringToNull) {
					return this.parse($.wijmo.wijgrid._getDOMText(value, true), culture, format, nullString, convertEmptyStringToNull);
				},

				// string\ number -> number
				parse: function (value, culture, format, nullString, convertEmptyStringToNull) {
					var type = typeof (value);

					if (type === "number") {
						return isNaN(value)
							? NaN
							: value;
					}

					if ((!value && value !== 0) || (value === "&nbsp;") || (value === nullString && convertEmptyStringToNull)) {
						return null;
					}

					if (type === "string") {
						value = value.replace(culture.numberFormat.currency.symbol, "");
					}

					return $.parseFloat(value, 10, culture.name);
				},

				// number -> string (currency)
				toStr: function (value, culture, format, nullString, convertEmptyStringToNull) {
					if (value === null && convertEmptyStringToNull) {
						return nullString;
					}

					return $.format(value, format ? format : "c", culture.name);
				}
			},

			dateTimeParser: {
				// DOM -> datetime
				parseDOM: function (value, culture, format, nullString, convertEmptyStringToNull) {
					return this.parse($.wijmo.wijgrid._getDOMText(value, true), culture, format, nullString, convertEmptyStringToNull);
				},

				// string/ datetime -> datetime
				parse: function (value, culture, format, nullString, convertEmptyStringToNull) {
					var match;

					if (value instanceof Date) {
						return value;
					}

					if (!value || (value === "&nbsp;") || (value === nullString && convertEmptyStringToNull)) {
						return null;
					}

					match = /^\/Date\((\d+)\)\/$/.exec(value);
					if (match) {
						return new Date(parseInt(match[1], 10));
					}

					return $.parseDate(value, format, culture.name);
				},

				// datetime -> string
				toStr: function (value, culture, format, nullString, convertEmptyStringToNull) {
					if (value === null && convertEmptyStringToNull) {
						return nullString;
					}

					return $.format(value, format ? format : "d", culture.name);
				}
			},

			boolParser: {
				// DOM -> bool
				parseDOM: function (value, culture, format, nullString, convertEmptyStringToNull) {
					return this.parse($.wijmo.wijgrid._getDOMText(value, true), culture, format, nullString, convertEmptyStringToNull);
				},

				// string\ bool -> bool
				parse: function (value, culture, format, nullString, convertEmptyStringToNull) {
					var valType = typeof (value);

					if (valType === "boolean") {
						return value;
					}

					if (valType === "string") {
						value = $.trim(value);
					}

					if (!value || (value === "&nbsp;") || (value === nullString && convertEmptyStringToNull)) {
						return null;
					}

					switch (value.toLowerCase()) {
						case "true":
							return true;

						case "false":
							return false;
					}

					return NaN;
				},

				// bool -> string
				toStr: function (value, culture, format, nullString, convertEmptyStringToNull) {
					if (value === null && convertEmptyStringToNull) {
						return nullString;
					}

					return (value) ? "true" : "false";
				}
			}
		}
	});
})(jQuery);(function ($) {
	"use strict";
	$.extend($.wijmo.wijgrid, {
		filterOperatorsCache: function () {
			var _cache = {};

			this.add = function (operator) {
				if (operator && operator.name && operator.operator) {
					var name = operator.name.toLowerCase();
					if (!_cache[name]) {
						_cache[name] = operator;
					}
				}
			};

			this.clear = function () {
				_cache.length = 0;
			};

			this.getByName = function (name) {
				return _cache[name.toLowerCase()];
			};

			this.getByDataType = function (dataType) {
				var result = [],
					name, operator;

				for (name in _cache) {
					if (_cache.hasOwnProperty(name)) {
						operator = _cache[name];

						if ($.inArray(dataType, operator.applicableTo) >= 0) {
							result.push(operator);
						}
					}
				}

				return result;
			};

			this.removeCustom = function () {
				var name;

				for (name in _cache) {
					if (_cache[name].custom) {
						delete _cache[name];
					}
				}
			};

			this.sort = function (filtersArray, mode) {
				switch (mode.toLowerCase()) {
					case "alphabetical":
						filtersArray.sort(sortAlpha);
						break;
					case "alphabeticalcustomfirst":
						filtersArray.sort(sortAlphaCustomFirst);
						break;

					case "alphabeticalembeddedFirst":
						filtersArray.sort(sortAlphaEmbeddedFirst);
						break;

					case "none": // do nothing
						break;

					default:
						break;
				}

				return filtersArray;
			};

			function sortAlpha(a, b) {
				var n1 = a.name.toLowerCase(),
					n2 = b.name.toLowerCase();

				if (n1 !== n2) {
					if (n1 === "nofilter") {
						return -1;
					}

					if (n2 === "nofilter") {
						return 1;
					}
				}

				if (n1 === n2) {
					return 0;
				}

				return (n1 < n2)
					? -1
					: 1;
			}

			function sortAlphaEmbeddedFirst(a, b) {
				var n1 = a.name.toLowerCase(),
					n2 = b.name.toLowerCase();

				if (n1 !== n2) {
					if (n1 === "nofilter") {
						return -1;
					}

					if (n2 === "nofilter") {
						return 1;
					}
				}

				if (a.custom !== b.custom) {
					if (a.custom) {
						return 1;
					}

					if (b.custom) {
						return -1;
					}
				}

				if (n1 === n2) {
					return 0;
				}

				return (n1 < n2)
					? -1
					: 1;
			}

			function sortAlphaCustomFirst(a, b) {
				var n1 = a.name.toLowerCase(),
					n2 = b.name.toLowerCase();

				if (n1 !== n2) {
					if (n1 === "nofilter") {
						return -1;
					}

					if (n2 === "nofilter") {
						return 1;
					}
				}

				if (a.custom !== b.custom) {
					if (a.custom) {
						return -1;
					}

					if (b.custom) {
						return 1;
					}
				}

				if (n1 === n2) {
					return 0;
				}

				return (n1 < n2)
					? -1
					: 1;
			}
		}
	});

	$.wijmo.wijgrid.embeddedFilters = [
	{
		name: "NoFilter",
		arity: 1,
		applicableTo: ["string", "number", "datetime", "currency", "boolean"],
		operator: function (dataVal) {
			return true;
		}
	},
	{
		name: "Contains",
		arity: 2,
		applicableTo: ["string"],
		operator: function (dataVal, filterVal) {
			if (dataVal === filterVal) { // handle null and undefined
				return true;
			}

			return (dataVal)
				? dataVal.indexOf(filterVal) >= 0
				: false;
		}
	},
	{
		name: "NotContain",
		arity: 2,
		applicableTo: ["string"],
		operator: function (dataVal, filterVal) {
			if (dataVal === filterVal) { // handle null and undefined
				return false;
			}

			return (dataVal)
				? dataVal.indexOf(filterVal) < 0
				: true;
		}
	},
	{
		name: "BeginsWith",
		arity: 2,
		applicableTo: ["string"],
		operator: function (dataVal, filterVal) {
			if (dataVal === filterVal) { // handle null and undefined
				return true;
			}

			return (dataVal)
				? dataVal.indexOf(filterVal) === 0
				: false;
		}
	},
	{
		name: "EndsWith",
		arity: 2,
		applicableTo: ["string"],
		operator: function (dataVal, filterVal) {
			if (dataVal === filterVal) { // handle null and undefined
				return true;
			}

			if (dataVal) {
				var idx = dataVal.lastIndexOf(filterVal);

				return (idx >= 0)
					? (dataVal.length - idx) === filterVal.length
					: false;
			}

			return false;
		}
	},
	{
		name: "Equals",
		arity: 2,
		applicableTo: ["string", "number", "datetime", "currency", "boolean"],
		operator: function (dataVal, filterVal) {
			if (dataVal instanceof Date) {
				dataVal = dataVal.getTime();
			}

			if (filterVal instanceof Date) {
				filterVal = filterVal.getTime();
			}

			return dataVal === filterVal;
		}
	},
	{
		name: "NotEqual",
		arity: 2,
		applicableTo: ["string", "number", "datetime", "currency", "boolean"],
		operator: function (dataVal, filterVal) {
			if (dataVal instanceof Date) {
				dataVal = dataVal.getTime();
			}

			if (filterVal instanceof Date) {
				filterVal = filterVal.getTime();
			}

			return dataVal !== filterVal;
		}
	},
	{
		name: "Greater",
		arity: 2,
		applicableTo: ["string", "number", "datetime", "currency", "boolean"],
		operator: function (dataVal, filterVal) {
			if (dataVal instanceof Date) {
				dataVal = dataVal.getTime();
			}

			if (filterVal instanceof Date) {
				filterVal = filterVal.getTime();
			}

			return dataVal > filterVal;
		}
	},
	{
		name: "Less",
		arity: 2,
		applicableTo: ["string", "number", "datetime", "currency", "boolean"],
		operator: function (dataVal, filterVal) {
			if (dataVal instanceof Date) {
				dataVal = dataVal.getTime();
			}

			if (filterVal instanceof Date) {
				filterVal = filterVal.getTime();
			}

			return dataVal < filterVal;
		}
	},
	{
		name: "GreaterOrEqual",
		arity: 2,
		applicableTo: ["string", "number", "datetime", "currency", "boolean"],
		operator: function (dataVal, filterVal) {
			if (dataVal instanceof Date) {
				dataVal = dataVal.getTime();
			}

			if (filterVal instanceof Date) {
				filterVal = filterVal.getTime();
			}

			return dataVal >= filterVal;
		}
	},
	{
		name: "LessOrEqual",
		arity: 2,
		applicableTo: ["string", "number", "datetime", "currency", "boolean"],
		operator: function (dataVal, filterVal) {
			if (dataVal instanceof Date) {
				dataVal = dataVal.getTime();
			}

			if (filterVal instanceof Date) {
				filterVal = filterVal.getTime();
			}

			return dataVal <= filterVal;
		}
	},
	{
		name: "IsEmpty",
		arity: 1,
		applicableTo: ["string"],
		operator: function (dataVal) {
			return !dataVal && dataVal !== 0 && dataVal !== false;
		}
	},
	{
		name: "NotIsEmpty",
		arity: 1,
		applicableTo: ["string"],
		operator: function (dataVal) {
			return !!dataVal || dataVal === 0 || dataVal === false;
		}
	},
	{
		name: "IsNull",
		arity: 1,
		applicableTo: ["string", "number", "datetime", "currency", "boolean"],
		operator: function (dataVal) {
			return dataVal === null;
		}
	},
	{
		name: "NotIsNull",
		arity: 1,
		applicableTo: ["string", "number", "datetime", "currency", "boolean"],
		operator: function (dataVal) {
			return dataVal !== null;
		}
	}
];
})(jQuery);(function ($) {
	"use strict";
	$.extend($.wijmo.wijgrid, {
		htmlTableAccessor: function (domTable) {
			var offsets = [],
				width = 0,
				table = domTable;

			_buildOffsets();

			function _buildOffsets() {
				var rowSpan = [],
					rowOffsets, i, rowLen, row, j, jOffset, celLen, cell, cs, rowSpanLen;

				for (i = 0, rowLen = table.rows.length; i < rowLen; i++) {
					rowOffsets = [];
					offsets[i] = rowOffsets;

					row = table.rows[i];
					for (j = 0, jOffset = 0, celLen = row.cells.length; j < celLen; j++, jOffset++) {
						cell = row.cells[j];

						// process rowspan
						for (; rowSpan[jOffset] > 1; jOffset++) {
							rowSpan[jOffset]--;
							rowOffsets[jOffset] = { cellIdx: -1, colIdx: -1 };
						}

						if (!(rowSpan[jOffset] > 1)) {
							rowSpan[jOffset] = cell.rowSpan;
						}

						rowOffsets[jOffset] = { cellIdx: j, colIdx: -1 };
						rowOffsets[j].colIdx = jOffset;

						// process colspan
						cs = cell.colSpan;
						for (; cs > 1; cs--) {
							rowOffsets[++jOffset] = { cellIdx: -1, colIdx: -1 };
						}
					}

					rowSpanLen = rowSpan.length;
					for (; jOffset < rowSpanLen; jOffset++) {
						rowSpan[jOffset]--;
						rowOffsets[jOffset] = { cellIdx: -1, colIdx: -1 };
					}

					width = Math.max(width, rowSpanLen);
				}
			}

			this.element = function () {
				return domTable;
			};

			this.getCellIdx = function (colIdx, rowIdx) {
				return (colIdx < width)
					? offsets[rowIdx][colIdx].cellIdx
					: -1;
			};

			// arguments:
			// (cellIdex, rowIdx)
			// or
			// (domCell)
			this.getColumnIdx = function (cellIdx, rowIdx) {
				if (typeof (cellIdx) !== "number") { // domCell
					var domCell = cellIdx;

					cellIdx = domCell.cellIndex;
					rowIdx = domCell.parentNode.rowIndex;
				}

				return (cellIdx < width)
					? offsets[rowIdx][cellIdx].colIdx
					: -1;
			};

			// section:
			// 1 - tHead
			// 2 - tBody
			// 3 - tFoot
			// otherwise - table
			this.getSectionLength = function (section) {
				return $.wijmo.wijgrid.getTableSectionLength(table, section);
			};

			// section:
			// 1 - tHead
			// 2 - tBody
			// 3 - tFoot
			// otherwise - table
			this.getSectionRow = function (rowIndex, section) {
				return $.wijmo.wijgrid.getTableSectionRow(table, section, rowIndex);
			};

			// iterates through the table rows using natural cells order
			this.forEachColumnCellNatural = function (columnIdx, callback, param) {
				var i, rowLen, row, result;

				for (i = 0, rowLen = table.rows.length; i < rowLen; i++) {
					row = table.rows[i];

					if (columnIdx < row.cells.length) {
						result = callback(row.cells[columnIdx], columnIdx, param);
						if (result !== true) {
							return result;
						}
					}
				}

				return true;
			};

			// iterates through the table rows using colSpan\rowSpan offsets
			this.forEachColumnCell = function (columnIdx, callback, param) {
				var i, rowLen, row, offsetCellIdx, result;

				for (i = 0, rowLen = offsets.length; i < rowLen; i++) {
					row = table.rows[i];

					offsetCellIdx = this.getCellIdx(columnIdx, i);
					if (offsetCellIdx >= 0) {
						result = callback(row.cells[offsetCellIdx], i, param);
						if (result !== true) {
							return result;
						}
					}
				}

				return true;
			};

			// iterates throw the cells of a table row
			this.forEachRowCell = function (rowIndex, callback, param) {
				var row = table.rows[rowIndex],
					i, celLen, result;

				for (i = 0, celLen = row.cells.length; i < celLen; i++) {
					result = callback(row.cells[i], i, param);
					if (result !== true) {
						return result;
					}
				}

				return true;
			};

			/*dma>*/
			this.colGroupTag = function () {
				var cgs = table.getElementsByTagName("colgroup");

				return (cgs !== null && cgs.length > 0) ? cgs[0] : null;
			};

			this.colTags = function () {
				var colGroup = this.colGroupTag();

				return (colGroup !== null) ? colGroup.getElementsByTagName("col") : [];
			};
			/*<dma*/
		}
	});
})(jQuery);(function ($) {
	"use strict";
	$.wijmo.wijgrid.cellInfo = function (cellIndex, rowIndex) {
		/// <summary>
		/// Object that represents a single cell.
		/// Code example: var cell = new $.wijmo.wijgrid.cellInfo(0, 0);
		/// </summary>
		/// <param name="cellIndex">Zero-based index of the required cell inside the corresponding row.</param>
		/// <param name="rowIndex">Zero-based index of the row that contains required cell.</param>
		/// <returns type="$.wijmo.wijgrid.cellInfo">Object that represents a single cell.</returns>

		var _isEdit = false,
			_gridView = null;

		// public
		this.cellIndex = function (value) {
			/// <summary>
			/// Gets the zero-based index of the cell in the row which it corresponds to.
			/// Code example: var index = cellInfoObj.cellIndex();
			/// </summary>
			/// <returns type="Number" integer="true"></returns>

			if (arguments.length === 0) {
				return cellIndex;
			}

			cellIndex = value;
		};

		this.column = function () {
			/// <summary>
			/// Gets the associated column object.
			/// Code example: var index = cellInfoObj.column();
			/// </summary>
			/// <returns type="Object"></returns>

			if (_gridView && this._isValid()) {
				var offset = _gridView._getDataToAbsOffset();

				return _gridView._field("visibleLeaves")[cellIndex + offset.x];
			}

			return null;
		};


		this.rowIndex = function (value) {
			/// <summary>
			/// Gets the zero-based index of the row containing the cell.
			/// Code example: var index = cellInfoObj.rowIndex();
			/// </summary>
			/// <returns type="Number" integer="true"></returns>

			if (arguments.length === 0) {
				return rowIndex;
			}

			rowIndex = value;
		};

		this.isEqual = function (value) {
			/// <summary>
			/// Compares the current object with a specified one and indicates whether they are identical.
			/// Code example: var isEqual = cellInfoObj1.isEqual(cellInfoObj2);
			/// </summary>
			/// <param name="value" type="$.wijmo.wijgrid.cellInfo">Object to compare</param>
			/// <returns type="Boolean">True if the objects are identical, otherwise false.</returns>
			return (value && (value.rowIndex() === rowIndex) && (value.cellIndex() === cellIndex));
		};

		this.tableCell = function () {
			/// <summary>
			/// Returns the table cell element corresponding to this object.
			/// Code example: var domCell = cellInfoObj.tableCell();
			/// </summary>
			/// <returns type="Object" domElement="true" />
			if (_gridView && this._isValid()) {
				var offset = _gridView._getDataToAbsOffset();

				return _gridView._view().getCell(cellIndex + offset.x, rowIndex + offset.y);
			}

			return null;
		};

		this.container = function () {
			/// <summary>
			/// Returns the jQuery object containing a cell content.
			/// Code example: var $container = cellInfoObj.container();
			/// </summary>
			/// <returns type="jQuery" />
			var tableCell = this.tableCell(),
				$innerDiv;

			if (tableCell) {
				$innerDiv = $(tableCell).children("div.wijmo-wijgrid-innercell");
				if ($innerDiv) {
					return $innerDiv;
				}
			}

			return null;
		};

		this.value = function (value/*opt*/) {
			/// <summary>
			/// Gets or sets underlying cell data.
			/// Code example:
			/// -) Getter:
			///   var value = cellInfoObj.value();
			/// -) Setter:
			///   cellInfoObj.value("value");
			/// </summary>
			/// <param name="value" type="Object">Value to set.</param>
			/// <returns type="Object" />
			/// <remarks>
			/// "invalid value" exception will be thrown by the setter if the value does not correspond to associated column.
			/// </remarks>
			var column, dataTableRow;

			if (_gridView && this._isValid()) {
				dataTableRow = _gridView.dataTable[rowIndex];
				if (dataTableRow.rowType & $.wijmo.wijgrid.rowType.data) {
					column = this.column();

					if (arguments.length === 0) { // getter
						return dataTableRow[/*cellIndex*/column.dataIndex].value;
					} else { // setter
						// validation
						value = _gridView._parse(column, value);

						if ((value === null && column.valueRequired) ||
						(column.dataType && column.dataType !== "string" && isNaN(value))) {
							throw "invalid value";
						}

						dataTableRow[column.dataIndex].value = value;
						_gridView._dataStore.updateValue(dataTableRow.originalRowIndex, column.dataKey, value);
					}
				}
			}
		};

		this.row = function () {
			/// <summary>
			/// Gets the accociated row's information.
			/// </summary>
			/// <returns type="object">
			/// Information about associated row.
			/// 
			/// The return value has the following properties:
			/// $rows: jQuery object that represents associated rows.
			/// data: associated data.
			/// dataRowIndex: data row index.
			/// dataItemIndex: data item index.
			/// virtualDataItemIndex: virtual data item index.
			/// type: type of the row, one of the $.wijmo.wijgrid.rowType values.
			/// </returns>

			var rowObj = this._row();

			if (rowObj !== null) {
				rowObj = _gridView._createRowInfo(rowObj);
				return rowObj;
			}

			return null;
		};

		this.toString = function () {
			return cellIndex + ":" + rowIndex;
		};

		// * public

		// internal

		this._dataToAbs = function (offset) {
			cellIndex -= offset.x;
			rowIndex -= offset.y;

			return this;
		};

		this._clip = function (range) {
			var flag = false,
				val;

			if (cellIndex < (val = range.topLeft().cellIndex())) {
				flag = true;
				cellIndex = val;
			}

			if (cellIndex > (val = range.bottomRight().cellIndex())) {
				flag = true;
				cellIndex = val;
			}

			if (rowIndex < (val = range.topLeft().rowIndex())) {
				flag = true;
				rowIndex = val;
			}

			if (rowIndex > (val = range.bottomRight().rowIndex())) {
				flag = true;
				rowIndex = val;
			}

			return flag;
		};

		this._clone = function () {
			return new $.wijmo.wijgrid.cellInfo(cellIndex, rowIndex);
		};

		this._row = function () {
			if (_gridView && this._isValid()) {
				return _gridView._rows().item(rowIndex);
			}

			return null;
		};

		this._isValid = function () {
			return cellIndex >= 0 && rowIndex >= 0;
		};

		this._isEdit = function (value) {
			if (!arguments.length) {
				return _isEdit;
			}

			_isEdit = value;
		};

		this._setGridView = function (value) {
			_gridView = value;
		};

		// internal *
	};

	$.wijmo.wijgrid.cellInfo.prototype.outsideValue = new $.wijmo.wijgrid.cellInfo(-1, -1);

	$.wijmo.wijgrid.cellInfoRange = function (topLeft, bottomRight) {
		/// <summary>
		/// Specifies a range of cells determined by two cells.
		/// Code example: var range = $.wijmo.wijgrid.cellInfoRange(new $.wijmo.wijgrid.cellInfo(0, 0), new $.wijmo.wijgrid.cellInfo(0, 0));
		/// </summary>
		/// <param name="topLeft" type="$.wijmo.wijgrid.cellInfo">Object that represents the top left cell of the range.</param>
		/// <param name="bottomRight" type="$.wijmo.wijgrid.cellInfo">Object that represents the bottom right cell of the range.</param>
		/// <returns type="$.wijmo.wijgrid.cellInfoRange"></returns>

		if (!topLeft || !bottomRight) {
			throw "invalid arguments";
		}

		var _topLeft = topLeft._clone(),
			_bottomRight = bottomRight._clone();

		// public 

		this.bottomRight = function () {
			/// <summary>
			/// Gets the object that represents the bottom right cell of the range.
			/// Code example: var cellInfoObj = range.bottomRight();
			/// </summary>
			/// <returns type="$.wijmo.wijgrid.cellInfo" />
			return _bottomRight;
		};

		this.isEqual = function (range) {
			/// <summary>
			/// Compares the current range with a specified range and indicates whether they are identical.
			/// Code example: var isEqual = range1.isEqual(range2);
			/// </summary>
			/// <param name="range" type="$.wijmo.wijgrid.cellInfoRange">Range to compare.</param>
			/// <returns type="Boolean">True if the ranges are identical, otherwise false.</returns>
			return (range && _topLeft.isEqual(range.topLeft()) && _bottomRight.isEqual(range.bottomRight()));
		};

		this.topLeft = function () {
			/// <summary>
			/// Gets the object that represents the top left cell of the range.
			/// Code example: var cellInfoObj = range.topLeft();
			/// </summary>
			/// <returns type="$.wijmo.wijgrid.cellInfo" />
			return _topLeft;
		};

		this.toString = function () {
			return _topLeft.toString() + " - " + _bottomRight.toString();
		};

		// public *

		// internal
		this._isIntersect = function (range) {
			var rangeH, thisH, rangeW, thisW;

			if (range) {
				rangeH = range.bottomRight().rowIndex() - range.topLeft().rowIndex() + 1;
				thisH = _bottomRight.rowIndex() - _topLeft.rowIndex() + 1;

				if ((range.topLeft().rowIndex() + rangeH) - _topLeft.rowIndex() < rangeH + thisH) {
					rangeW = range.bottomRight().cellIndex() - range.topLeft().cellIndex() + 1;
					thisW = _bottomRight.cellIndex() - _topLeft.cellIndex() + 1;

					return ((range.topLeft().cellIndex() + rangeW) - _topLeft.cellIndex() < rangeW + thisW);
				}
			}

			return false;
		};

		this._isValid = function () {
			return _topLeft._isValid() && _bottomRight._isValid();
		};

		this._clip = function (clipBy) {
			return _topLeft._clip(clipBy) | _bottomRight._clip(clipBy);
		};

		this._clone = function () {
			return new $.wijmo.wijgrid.cellInfoRange(_topLeft._clone(), _bottomRight._clone());
		};

		this._containsCellInfo = function (info) {
			return (info && info.cellIndex() >= _topLeft.cellIndex() && info.cellIndex() <= _bottomRight.cellIndex() &&
				info.rowIndex() >= _topLeft.rowIndex() && info.rowIndex() <= _bottomRight.rowIndex());
		};

		this._containsCellRange = function (range) {
			return (range && this._containsCellInfo(range.topLeft()) && this._containsCellInfo(range.bottomRight()));
		};

		// mode:
		//  0: none
		//  1: extendToColumn
		//  2: extendToRow
		//
		// borders - cellInfoRange
		this._extend = function (mode, borders) {
			if (mode === 1) {
				_topLeft.rowIndex(borders.topLeft().rowIndex());
				_bottomRight.rowIndex(borders.bottomRight().rowIndex());
			} else {
				if (mode === 2) {
					_topLeft.cellIndex(borders.topLeft().cellIndex());
					_bottomRight.cellIndex(borders.bottomRight().cellIndex());
				}
			}

			return this;
		};

		this._normalize = function () {
			var x0 = _topLeft.cellIndex(),
				y0 = _topLeft.rowIndex(),
				x1 = _bottomRight.cellIndex(),
				y1 = _bottomRight.rowIndex();

			_topLeft.cellIndex(Math.min(x0, x1));
			_topLeft.rowIndex(Math.min(y0, y1));

			_bottomRight.cellIndex(Math.max(x0, x1));
			_bottomRight.rowIndex(Math.max(y0, y1));
		};

		// internal *
	};
})(jQuery);(function ($) {
	"use strict";
	$.extend($.wijmo.wijgrid, {
		flatView: function (gridView) {
			var _dataTable = null,
				_contentArea = null,
				verScrollBarSize = 18;

			this.initialize = function () {
				_dataTable = null;
				_contentArea = null;
				this._createLayout();
			};

			this._createLayout = function () {
				if (gridView.options.scrollMode !== "none") {
					gridView.outerDiv.wrapInner("<div class=\"wijmo-wijgrid-fixedview\"><div class=\"wijmo-wijgrid-split-area wijmo-wijgrid-split-area-se wijmo-wijgrid-content-area\"></div></div>");
				}
			};

			this._testNeedVBar = function (outerDiv, gridEle, mode, autoHeight) {
				var excludeVbarWidth,
					gridWidth = gridEle.width(),
					gridHeight = gridEle.height(),
					outerWidth = outerDiv.width(),
					outerHeight = outerDiv.height();

				// remove auto width to make width 100%  take effect. 
				if (gridEle[0].style.width === "auto") {
					gridEle.css("width", "");
				}
				if (mode === "both" || mode === "vertical") {
					excludeVbarWidth = true;
				}
				else if (mode === "auto") {
					if (gridHeight > outerHeight) {
						excludeVbarWidth = true;
					}
					//modified by Jeffrey on 21st Feb 2011
					//When the height needs to be auto adjusted,
					//the vertical scrollbar should not be shown
					//else if (gridWidth > outerWidth && gridHeight > outerHeight - verScrollBarSize) {
					else if (!autoHeight && gridWidth > outerWidth && gridHeight > outerHeight - verScrollBarSize) {
						//end by Jeffrey
						excludeVbarWidth = true;
					}
				}
				return excludeVbarWidth;
			};

			this.updateSplits = function (scrollValue) {
				var self = this,
					hasWidth = false,
					o = gridView.options,
					gridEle = gridView.element,
					widthArray = [],
					visibleLeaves = gridView._field("visibleLeaves"),
					mode = gridView.options.scrollMode,
					outerDiv = gridView.outerDiv,
					splitSE, beforeWidth, after, colIndex, diff, len,
					needVbar, needExpand, expandToColumn,
					thsWithWidth = [];

				$.each(visibleLeaves, function (index, leaf) {
					var th, isPercentage,
						w = leaf.width;

					if (w) {
						hasWidth = true;
						th = self.getHeaderCell(index);
						isPercentage = typeof w === "string";
						if (!isPercentage && o.ensureColumnsPxWidth) {
							self.setColumnWidth(index, w);
							leaf._realWidth = true;
							thsWithWidth.push({ th: $(th), clientWidth: th.clientWidth, index: index, isPercentage: isPercentage, ensurePxWidth: true });
						}
						else {
							th.width = w;
							thsWithWidth.push({ th: $(th), clientWidth: th.clientWidth, index: index, isPercentage: isPercentage });
						}
					}
				});

				// only set width on inner cell div when needed.
				if (o.scrollMode !== "none" || hasWidth || o.allowColSizing ||
				//prevent the width of th from being changed when changing the width of filterEditor
				//o.allowEditing || o.autoExpandColumnIndex) {
					o.showFilter || o.allowEditing || o.autoExpandColumnIndex) {
					if (!o.ensureColumnsPxWidth) {
						splitSE = (o.scrollMode === "none") ?
						outerDiv : outerDiv.find(".wijmo-wijgrid-content-area");
						needVbar = self._testNeedVBar(gridView.outerDiv, gridEle, mode, gridView._autoHeight);
						if (needVbar) {
							splitSE.width(splitSE.width() - verScrollBarSize);
						}
						needExpand = !o.ensureColumnsPxWidth && splitSE.innerWidth() > gridEle[0].offsetWidth;
						// if table width is not enough to occupy the available space in outerDiv,
						// grid will expand to take up the space
						// if autoExpandColumnIndex is set, the addtional space 
						// will be added to the specified column and keep width of other columns.
						expandToColumn = o.autoExpandColumnIndex;
						if (needExpand && !expandToColumn) {
							// expand to full width by setting width 100%
							gridEle.css("width", "100%");
							beforeWidth = gridEle.width();
						}
					}
					// read column widths.
					$.each(visibleLeaves, function (index, leaf) {
						self.setColumnWidth(index, null, widthArray);
					});
					// remove th width
					$.each(thsWithWidth, function (index, widthObject) {
						if (widthObject.ensurePxWidth) {
							return;
						}
						widthObject.th.removeAttr("width");
						if (!widthObject.isPercentage) {
							widthArray[widthObject.index] = widthObject.clientWidth;
						}
					});
					// set column width on inner cell divs to expand table
					$.each(widthArray, function (index, width) {
						var leaf = visibleLeaves[index];
						if (leaf._realWidth) {
							delete leaf._realWidth;
							return;
						}
						self.setColumnWidth(index, width);
					});
					if (needExpand) {
						if (expandToColumn) {
							beforeWidth = gridEle.width();
						}
						else {
							gridEle.css("width", "auto");
						}
						after = o.autoExpandColumnIndex ? splitSE.width() : gridEle.width();
						diff = after - beforeWidth;
						if (!expandToColumn) {
							// if we are expanding table with 100% width,
							// there may be a 1px difference before 
							// and after adding width on each inner cell div.
							// we need to substract it from one of columns.
							diff = -diff;
						}
					}
					// fix width to account for difference.
					if (diff && visibleLeaves.length > 0) {
						len = widthArray.length - 1;
						colIndex = o.autoExpandColumnIndex || len;
						if (colIndex > len) {
							colIndex = len;
						}
						self.setColumnWidth(colIndex, widthArray[colIndex] + diff);
					}
				}
				else if (outerDiv.innerWidth() > gridEle[0].offsetWidth) {
					gridEle.css("width", "100%");
				}
				// refresh super panel after width is set.
				self.refreshPanel(scrollValue);
			};

			this.getScrollValue = function () {
				var superPanelObj = this.getSuperPanel();

				return (superPanelObj)
					? {
						type: "flat",
						hScrollValue: superPanelObj.options.hScroller.scrollValue,
						vScrollValue: superPanelObj.options.vScroller.scrollValue
					}
					: {
						type: "flat",
						hScrollValue: null,
						vScrollValue: null
					};
			};

			this.getSuperPanel = function () {
				var panelElement = gridView.outerDiv.find(".wijmo-wijgrid-content-area");

				return panelElement
					? panelElement.data("wijsuperpanel")
					: null;
			};

			this.scrollTo = function (currentCell) {
				var superPanelObj = this.getSuperPanel(),
					element = currentCell.tableCell(),
					$dom = element.nodeType ? $(element) : element,
					contentElement, wrapperElement,
					visibleLeft, visibleTop, visibleWidth, visibleHeight,
					elementPosition, elementLeft, elementTop, elementWidth, elementHeight,
					resultLeft = null, resultTop = null;

				if (superPanelObj && $dom.is(":visible")) {
					contentElement = superPanelObj.getContentElement();
					wrapperElement = contentElement.parent();
					visibleLeft = parseInt((contentElement.css("left") + "").replace("px", ""), 10) * -1;
					visibleTop = parseInt((contentElement.css("top") + "").replace("px", ""), 10) * -1;
					visibleWidth = wrapperElement.outerWidth();
					visibleHeight = wrapperElement.outerHeight();
					elementPosition = $dom.position();
					elementLeft = Math.abs(elementPosition.left);
					elementTop = Math.abs(elementPosition.top);
					elementWidth = $dom.outerWidth();
					elementHeight = $dom.outerHeight();

					if (elementTop + elementHeight > visibleTop + visibleHeight) {
						visibleTop = resultTop = elementTop + elementHeight - visibleHeight;
					}
					if (elementLeft + elementWidth > visibleLeft + visibleWidth) {
						visibleLeft = resultLeft = elementLeft + elementWidth - visibleWidth;
					}
					if (elementTop < visibleTop) {
						resultTop = elementTop;
					}
					if (elementLeft < visibleLeft) {
						resultLeft = elementLeft;
					}
					if (currentCell.row()._dataTableRowIndex === 0 && visibleTop > 0) {
						resultTop = 0;
					}
					if (resultLeft !== null) {
						superPanelObj.hScrollTo(resultLeft);
					}
					if (resultTop !== null) {
						superPanelObj.vScrollTo(resultTop);
					}
				}
			};

			this.setColumnWidth = function (index, px, widthArray) {
				/// <summary>
				/// Set column width.
				/// </summary>
				/// <param name="index" type="Number">
				/// The index of the column. Start with 0.
				/// </param>
				/// <param name="px" type="Number">
				/// The width of each column.
				/// </param>

				// var tableEle = $(_dataTable.element());
				var th = this.getHeaderCell(index);
				if (th) {
					px = px ? px : th.clientWidth;
					if (widthArray) {
						widthArray.push(px);
						return;
					}
					if (px) {
						// set width on inner div of th and table td in each column.
						$(th).children("div.wijmo-wijgrid-innercell").setOutWidth(px);

						this.forEachColumnCell(index, function (cell, index) {
							var $row = $(cell.parentNode);

							if ($row.parent().is("tbody") && !$row.is(".wijmo-wijgrid-emptydatarow", ".wijmo-wijgrid-groupheaderrow", ".wijmo-wijgrid-groupfooterrow")) {
								$(cell).children("div.wijmo-wijgrid-innercell").setOutWidth(px);
							}

							return true;
						});

						// tableEle.find("tbody > tr:not(.wijmo-wijgrid-groupheaderrow, .wijmo-wijgrid-groupfooterrow) > td:nth-child(" + (index + 1) + ") > div.wijmo-wijgrid-innercell").setOutWidth(px);
					}
				}
			};

			this._getMappedScrollMode = function () {
				var scrollMode = gridView.options.scrollMode,
					vScrollBarVisibility = "auto",
					hScrollBarVisibility = "auto";

				switch (scrollMode) {
					case "horizontal":
						vScrollBarVisibility = "hidden";
						hScrollBarVisibility = "visible";
						break;

					case "vertical":
						vScrollBarVisibility = "visible";
						hScrollBarVisibility = "hidden";
						break;

					case "both":
						vScrollBarVisibility = "visible";
						hScrollBarVisibility = "visible";
						break;
				}

				return { vScrollBarVisibility: vScrollBarVisibility, hScrollBarVisibility: hScrollBarVisibility };
			};

			this.refreshPanel = function (scrollValue) {
				var mode = gridView.options.scrollMode,
					outerDiv = gridView.outerDiv,
					splitSE, panelModes;

				if (mode !== "none") {
					splitSE = outerDiv.find(".wijmo-wijgrid-content-area");
					panelModes = this._getMappedScrollMode();

					splitSE.width(this._getGridWidth(mode));
					splitSE.height(outerDiv.innerHeight());

					if (!splitSE.data("wijsuperpanel")) {
						splitSE.wijsuperpanel({
							bubbleScrollingEvent: false,
							vScroller: { scrollBarVisibility: panelModes.vScrollBarVisibility, scrollValue: scrollValue.type === "flat" ? scrollValue.vScrollValue : null },
							hScroller: { scrollBarVisibility: panelModes.hScrollBarVisibility, scrollValue: scrollValue.type === "flat" ? scrollValue.hScrollValue : null },
							//added by Jeffrey on 21st Feb 2011
							//auto adjusting height with hscrollbar shown
							hScrollerActivating: function (e, data) {
								var diff;
								if (gridView._autoHeight) {
									diff = gridView.element.height() - data.contentLength;
									if (diff > 0) {
										splitSE.height(splitSE.height() + diff);
										splitSE.wijsuperpanel("paintPanel");
										return false;
									}
								}
							}
							//end by Jeffrey
						});
					}
					else {
						splitSE.wijsuperpanel("paintPanel");
					}
				}
				//remove by Jeffrey on 12th Apr 2011 for refreshing bug
				/*
				else {
				outerDiv.width(gridView.element.width());
				}
				*/
				//end by Jeffrey
			};

			this._getGridWidth = function (mode) {
				var tableWidth = gridView.element.width(),
					outWidth = gridView.outerDiv.innerWidth();

				if (this._testNeedVBar(gridView.outerDiv, gridView.element, mode, gridView._autoHeight)) {
					tableWidth += verScrollBarSize;
				}

				if (tableWidth > outWidth) {
					tableWidth = outWidth;
				}

				return tableWidth;
			};

			this.render = function () {
				var visibleLeaves = gridView._field("visibleLeaves"),
					table = gridView.element[0],
					tHead = null,
					spanTable, span, width, ri, height, domRow, thX, ci,
					$domCell, $container,
					i, len, leaf,
					colGroup, col,
					data, tBody, rowLen,
					dataRow, dataRowLen,
					cellLen, dataIndex, cellIndex, doBreak,
					cellValue, dataValue, rowInfo,
					cellAttr, cellStyle,
					dataRowIndex = -1,
					virtualDataItemIndexBase = 0,
					$rt = $.wijmo.wijgrid.rowType,
					$rs = $.wijmo.wijgrid.renderState,
					isDataRow;

				// create header
				spanTable = gridView._field("spanTable");
				if (spanTable && spanTable.length) {
					tHead = table.createTHead();
					width = spanTable[0].length;

					for (ri = 0, height = spanTable.length; ri < height; ri++) {
						//domRow = tHead.insertRow(-1);
						domRow = gridView._createRow(tHead, $rt.header, ri);

						rowInfo = gridView._createRowInfo([domRow], $rt.header, $rs.rendering, -1, -1, -1, -1);
						thX = 0;

						for (ci = 0; ci < width; ci++) {
							span = spanTable[ri][ci];

							if (span.column && span.column.parentVis) {
								span.column.thX = thX++;
								span.column.thY = ri;

								//$domCell = $("<th><div class=\"wijmo-wijgrid-innercell\"></div></th>");
								$domCell = $(gridView._createCell($rt.header, ri, ci));

								$container = $domCell.children("div");
								domRow.appendChild($domCell[0]);
								gridView.cellFormatter.format($container, span.column, span.column.headerText, rowInfo);
								gridView._cellCreated($domCell, ci, span.column, rowInfo, $rs.rendering, { colSpan: span.colSpan, rowSpan: span.rowSpan });
							} // end if
						} // for ci

						gridView._rowCreated(rowInfo);

					} // for ri
				} // end if
				// create header end

				// create filter
				if (gridView.options.showFilter) {
					if (!tHead) {
						tHead = table.createTHead();
					}

					//domRow = tHead.insertRow(-1); // filterRow
					domRow = gridView._createRow(tHead, $rt.filter, -1);
					rowInfo = gridView._createRowInfo([domRow], $rt.filter, $rs.rendering, -1, -1, -1, -1);

					for (i = 0, len = visibleLeaves.length; i < len; i++) {
						leaf = visibleLeaves[i];
						//$domCell = $(domRow.insertCell(-1));
						$domCell = $(gridView._createCell($rt.filter, undefined, i));
						domRow.appendChild($domCell[0]);
						gridView.cellFormatter.format($domCell, leaf, leaf.filterValue, rowInfo);
						gridView._cellCreated($domCell, i, leaf, rowInfo, $rs.rendering);
					}

					gridView._rowCreated(rowInfo);
				}
				// create filter end

				// colgroup
				colGroup = document.createElement("colgroup");
				for (i = 0, len = visibleLeaves.length; i < len; i++) {
					col = document.createElement("col");
					colGroup.appendChild(col);
				}
				table.appendChild(colGroup);
				// end colgroup

				// create body **
				data = gridView.dataTable;

				tBody = $.wijmo.wijgrid.ensureTBody(table);

				if (gridView._dataStore.dataMode() === $.wijmo.wijgrid.dataMode.dynamical) {
					virtualDataItemIndexBase = gridView.options.pageIndex * gridView.options.pageSize;
				}

				// render rows 
				for (ri = 0, rowLen = data.length; ri < rowLen; ri++) {
					dataRow = data[ri];
					dataRowLen = dataRow.length;
					isDataRow = (dataRow.rowType & $rt.data) !== 0;

					//domRow = tBody.insertRow(-1);
					domRow = gridView._createRow(tBody, dataRow.rowType, dataRow.originalRowIndex);

					rowInfo = gridView._createRowInfo([domRow], dataRow.rowType, $rs.rendering,
						ri,
						isDataRow ? ++dataRowIndex : -1,
						isDataRow ? dataRow.originalRowIndex : -1,
						isDataRow ? virtualDataItemIndexBase + dataRow.originalRowIndex : -1);

					// render cells
					for (ci = 0, cellLen = visibleLeaves.length; ci < cellLen; ci++) {
						leaf = visibleLeaves[ci];
						dataIndex = leaf.dataIndex;

						cellIndex = 0;
						doBreak = false;

						switch (dataRow.rowType) {
							case $rt.data:
							case $rt.data | $rt.dataAlt:
								cellIndex = dataIndex; // use [leaf -> data] mapping

								if (cellIndex >= 0 && (!dataRow[cellIndex] || (dataRow[cellIndex].visible === false))) {
									continue; // spanned cell ?
								}
								break;

							case $rt.emptyDataRow:
							case $rt.groupHeader:
							case $rt.groupFooter:
								cellIndex = ci; // just iterate through all dataRow cells.

								if (cellIndex >= dataRowLen) {
									doBreak = true; // don't extend group headers\ footers with additional cells
								}
								break;
						}

						if (doBreak) {
							break;
						}

						//$domCell = $("<td><div class=\"wijmo-wijgrid-innercell\"></div></td>");
						$domCell = $(gridView._createCell(dataRow.rowType, dataRow.originalRowIndex, cellIndex));
						$container = $domCell.children("div");

						domRow.appendChild($domCell[0]);

						if ((dataRow.rowType & $rt.data) && leaf.dataParser) {
							cellValue = null;

							if (cellIndex >= 0) { // cellIndex is equal to leaf.dataIndex here
								dataValue = dataRow[cellIndex].value;
								cellValue = gridView._toStr(leaf, dataValue);
							} else { // unbound column
							}

							gridView.cellFormatter.format($container, leaf, cellValue, rowInfo);
						} else {
							if (cellIndex >= 0) {
								$container.html(dataRow[cellIndex].html); // use original html
							}
						}

						cellAttr = (cellIndex >= 0) ? dataRow[cellIndex].__attr : null;
						cellStyle = (cellIndex >= 0) ? dataRow[cellIndex].__style : null;

						gridView._cellCreated($domCell, ci, leaf, rowInfo, $rs.rendering, cellAttr, cellStyle);
					} // for ci

					if (!domRow.cells.length) {
						tBody.removeChild(domRow);
					} else {
						gridView._rowCreated(rowInfo, dataRow.__attr, dataRow.__style);
					}
				} // for ri
				// ** create body

				// footer **
				if (gridView.options.showFooter) {
					//domRow = table.createTFoot().insertRow(-1);
					domRow = gridView._createRow(table.createTFoot(), $rt.footer, -1);
					rowInfo = gridView._createRowInfo([domRow], $rt.footer, $rs.rendering, -1, -1, -1, -1);

					for (ci = 0, cellLen = visibleLeaves.length; ci < cellLen; ci++) {
						leaf = visibleLeaves[ci];

						//$domCell = $("<td><div class=\"wijmo-wijgrid-innercell\"></div></td>");
						$domCell = $(gridView._createCell($rt.footer, undefined, ci));

						$container = $domCell.children("div");

						domRow.appendChild($domCell[0]);

						gridView.cellFormatter.format($container, leaf, "", rowInfo);
						gridView._cellCreated($domCell, i, leaf, rowInfo, $rs.rendering);
					}

					gridView._rowCreated(rowInfo);
				}
				// ** footer

				postRender();
			};

			this.attachEvents = function () {
			};

			//this.updateCss = function () {
			//};

			// array of a htmlTableAccessor instances
			this.subTables = function () {
				return [_dataTable];
			};

			this.focusableElement = function () {
				return _dataTable.element();
			};

			this.forEachRowCell = function (rowIndex, callback, param) {
				return _dataTable.forEachRowCell(rowIndex, callback, param);
			};

			this.forEachColumnCell = function (colIndex, callback, param) {
				return _dataTable.forEachColumnCell(colIndex, callback, param);
			};

			this.ensureWidth = function (delta, index) {
				if (arguments.length > 0) {
					this.setColumnWidth(index, delta);
				}
				this.refreshPanel();
			};

			this.getCell = function (absColIdx, absRowIdx) {
				var cellIdx = _dataTable.getCellIdx(absColIdx, absRowIdx),
					rowObj;

				if (cellIdx >= 0) {
					rowObj = this.getJoinedRows(absRowIdx, 0);
					if (rowObj[0]) {
						return rowObj[0].cells[cellIdx];
					}
				}

				return null;
			};

			this.getAbsoluteRowIndex = function (domRow) {
				return domRow.rowIndex;
			};

			this.getJoinedCols = function (columnIndex) {
				var $colGroup = $(_dataTable.element()).find("> colgroup");

				if ($colGroup.length) {
					if (columnIndex < $colGroup[0].childNodes.length) {
						return [$colGroup[0].childNodes[columnIndex], null];
					}
				}

				return [null, null];
			};

			this.getJoinedRows = function (rowIndex, rowScope) {
				return [_dataTable.getSectionRow(rowIndex, rowScope), null];
			};

			this.getJoinedTables = function (byColumn, index) {
				return [_dataTable, null, index];
			};

			this.getHeaderCell = function (absColIdx) {
				var leaf = gridView._field("visibleLeaves")[absColIdx],
					headerRow;

				if (leaf && (headerRow = gridView._headerRows())) {
					return new $.wijmo.wijgrid.rowAccessor().getCell(headerRow.item(leaf.thY), leaf.thX);
				}

				return null;
			};

			this.getAbsCellInfo = function (cell) {
				return new $.wijmo.wijgrid.cellInfo(_dataTable.getColumnIdx(cell), cell.parentNode.rowIndex);
			};

			this.getVisibleAreaBounds = function () {
				var dataTableBounds = $.wijmo.wijgrid.bounds(_dataTable.element()),
					splitSEBounds;

				if (gridView.options.scrollMode === "none") {
					return dataTableBounds;
				} else {
					splitSEBounds = $.wijmo.wijgrid.bounds(gridView.outerDiv.find(".wijmo-wijgrid-split-area-se:first")[0]);

					return {
						top: dataTableBounds.top,
						left: dataTableBounds.left,
						width: Math.min(splitSEBounds.width, dataTableBounds.width),
						height: Math.min(splitSEBounds.height, dataTableBounds.height)
					};
				}
			};

			// private
			function postRender() {
				gridView.element
					.addClass("wijmo-wijgrid-table")
					.find("> tbody").addClass("ui-widget-content wijmo-wijgrid-data");

				_dataTable = new $.wijmo.wijgrid.htmlTableAccessor(gridView.element[0]);

				// set width on td inner div of each column after all styles are applied to grid.
				gridView.element
					.attr({ "role": "grid", "cellpadding": "0", "border": "0", "cellspacing": "0" })
					.css("border-collapse", "separate");
			}
			// private
		}
	});
})(jQuery);(function ($) {
	"use strict";
	$.wijmo.wijgrid.selection = function (gridView) {
		/// <summary>
		/// Object that represents selection in the grid.
		/// Code example: var selection = new $.wijmo.wijgrid.selection(gridView);
		/// </summary>
		/// <param name="gridview" type="$.wijmo.wijgrid" mayBeNull="false">gridView</param>
		/// <returns type="$.wijmo.wijgrid.selection">Object that represents selection in the grid</returns>
		var _updates = 0,
			_anchorCell,
			_addedCells = new $.wijmo.wijgrid.cellInfoOrderedCollection(gridView),
			_removedCells = new $.wijmo.wijgrid.cellInfoOrderedCollection(gridView),
			_selectedCells = new $.wijmo.wijgrid.cellInfoOrderedCollection(gridView),
			_addedDuringCurTransactionCells = new $.wijmo.wijgrid.cellInfoOrderedCollection(gridView),
			_selectedColumns = null, // ?
			_selectedRows = null; // ?

		this.selectedCells = function () {
			/// <summary>
			/// Gets a read-only collection of the selected cells.
			/// Code example: var selectedCells = selectionObj.selectedCells();
			/// </summary>
			/// <returns type="$.wijmo.wijgrid.cellInfoOrderedCollection"/>
			return _selectedCells;
		};

		/*this.selectedColumns = function () {
		return _selectedColumns; // TODO ?
		};

		this.selectedRows = function () {
		return _selectedRows; // TODO ?
		};*/

		this.addRange = function (cellRange /* x0 */, y0 /* opt */, x1 /* opt */, y1 /* opt */) {
			/// <summary>
			/// Adds a cell range to the current selection.
			///
			/// Usage:
			/// 1. addRange(cellRange)
			/// 2. addRange(x0, y0, x1, y1)
			/// 
			/// The result depends upon the chosen selection mode in the grid. For example, if current selection mode
			/// does not allow multiple selection the previous selection will be removed.
			///
			/// Code example: selectionObj.addRange(0, 0, 1, 1);
			/// </summary>
			/// <param name="cellRange" type="$.wijmo.wijgrid.cellInfoRange">Cell range to select.</param>
			/// <param name="x0" type="Number" integer="true">The x-coordinate that represents the top left cell of the range.</number>
			/// <param name="y0" type="Number" integer="true">The y-coordinate that represents the top left cell of the range.</number>
			/// <param name="x1" type="Number" integer="true">The x-coordinate that represents the bottom right cell of the range.</number>
			/// <param name="y1" type="Number" integer="true">The y-coordinate that represents the bottom right cell of the range.</number>

			if (!cellRange && (arguments.length === 1)) {
				throw "invalid argument";
			}

			var range = (arguments.length === 4)
				? new $.wijmo.wijgrid.cellInfoRange(new $.wijmo.wijgrid.cellInfo(cellRange, y0), new $.wijmo.wijgrid.cellInfo(x1, y1))
				: cellRange._clone();

			range._normalize();

			if (!range._isValid()) {
				throw "invalid argument";
			}

			this.beginUpdate();

			this._startNewTransaction(gridView._field("currentCell"));
			this._selectRange(range, false, true, 0 /* none*/, null);

			this.endUpdate();
		};

		this.clear = function () {
			/// <summary>
			/// Clears the selection.
			/// Code example: selectionObj.clear();
			/// </summary>
			this.beginUpdate();

			_removedCells._clear();
			_removedCells._addFrom(_selectedCells);

			this.endUpdate();
		};

		this.selectAll = function () {
			/// <summary>
			/// Selects all the cells in a grid.
			///
			/// The result depends upon the chosen selection mode in the grid.
			/// For example, if the selection mode is "singleCell", only the top left cell will be selected.
			///
			/// Code example: selectionObj.selectAll();
			/// </summary>
			this.beginUpdate();

			this._selectRange(gridView._getDataCellsRange(), false, false, 0 /* none */, null);

			this.endUpdate();
		};

		this.beginUpdate = function () {
			/// <summary>
			/// Begins the update.
			/// The changes won't have effect until endUpdate() is called.
			/// Code example: selectionObj.beginUpdate();
			/// </summary>
			_updates++;
		};

		this.endUpdate = function () {
			/// <summary>
			/// Ends the update.
			/// The pending changes are executed and the corresponding events are raised.
			/// Code example: selectionObj.endUpdate();
			/// </summary>
			if (_updates > 0) {
				_updates--;

				if (_updates === 0) {
					doSelection(); // values must be clipped before this step

					if (_addedCells.length() || _removedCells.length()) {

						if (_selectedColumns !== null) {
							_selectedColumns.UnderlyingDataChanged(); // notify
						}

						if (_selectedRows !== null) {
							_selectedRows.UnderlyingDataChanged(); // notify
						}

						gridView._trigger("selectionChanged", null, { addedCells: _addedCells, removedCells: _removedCells });
					}

					_addedCells = new $.wijmo.wijgrid.cellInfoOrderedCollection(gridView);
					_removedCells._clear();
				}
			}
		};

		// * internal

		this._multipleRangesAllowed = function () {
			var mode = gridView.options.selectionMode;

			return (mode && ((mode = mode.toLowerCase()) === "multicolumn" || mode === "multirow" || mode === "multirange"));
		};

		this._anchorCell = function () {
			return _anchorCell;
		};

		this._startNewTransaction = function (dataCellInfo) {
			if (dataCellInfo) {
				_anchorCell = dataCellInfo._clone();
				_addedDuringCurTransactionCells = new $.wijmo.wijgrid.cellInfoOrderedCollection(gridView);
			}
		};

		this._clearRange = function (range, extendMode) {
			var selectionMode = gridView.options.selectionMode.toLowerCase(),
				rangeToClear, rowsLen, cellsLen, flag, row, cell,
				i, len, cellInfo;

			if (range._isValid() && (selectionMode !== "none") && (_selectedCells.length() > 0)) {
				rangeToClear = range._clone();

				rangeToClear._normalize();
				rangeToClear._clip(gridView._getDataCellsRange());

				if (!range._isValid()) {
					return;
				}

				rangeToClear = extendRangeBySelectionMode(rangeToClear, selectionMode, extendMode, null);

				this.beginUpdate();

				switch (selectionMode) {
					case "singlecell":
						if (rangeToClear._containsCellInfo(_selectedCells.item(0))) {
							this.clear();
						}
						break;

					case "singlecolumn":
					case "singlerow":
					case "singlerange":
						rowsLen = rangeToClear.bottomRight().rowIndex();
						cellsLen = rangeToClear.bottomRight().cellIndex();

						flag = false;
						for (row = rangeToClear.topLeft().rowIndex(); !flag && row <= rowsLen; row++) {
							for (cell = rangeToClear.topLeft().cellIndex(); !flag && cell <= cellsLen; cell++) {
								flag = _selectedCells.indexOf(cell, row) >= 0;
								if (flag) {
									this.clear();
								}
							}
						}
						break;

					case "multicolumn":
					case "multirow":
					case "multirange":
						for (i = 0, len = _selectedCells.length(); i < len; i++) {
							cellInfo = _selectedCells.item(i);

							if (rangeToClear._containsCellInfo(cellInfo)) {
								_removedCells._add(cellInfo);
							}
						}

						break;
				}

				this.endUpdate();
			}
		};

		this._selectRange = function (range, ctrlKey, shiftKey, extendMode, endPoint) {
			var selectionMode = gridView.options.selectionMode.toLowerCase(),
				rangeToSelect;

			if ((selectionMode !== "none") && range._isValid()) {
				rangeToSelect = range._clone();
				rangeToSelect._normalize();
				rangeToSelect._clip(gridView._getDataCellsRange());

				if (!rangeToSelect._isValid()) {
					return;
				}

				this.beginUpdate();

				if (!this._multipleRangesAllowed()) {
					this.clear();
				}
				else {
					if (ctrlKey || shiftKey) {
						if (shiftKey) {
							_removedCells._clear();
							_removedCells._addFrom(_addedDuringCurTransactionCells);
						}
					}
					else {
						this.clear();
					}
				}

				rangeToSelect = extendRangeBySelectionMode(rangeToSelect, selectionMode, extendMode, endPoint);
				doRange(rangeToSelect, true);

				this.endUpdate();
			}
		};

		// * internal

		// * private
		function extendRangeBySelectionMode(range, selectionMode, preferredExtendMode, endPoint) {
			var dataRange = gridView._getDataCellsRange();

			switch (selectionMode) {
				case "singlecell":
					range = (endPoint === null)
						? new $.wijmo.wijgrid.cellInfoRange(range.topLeft(), range.topLeft())
						: new $.wijmo.wijgrid.cellInfoRange(endPoint, endPoint);

					break;

				case "singlecolumn":
					range = (endPoint === null)
						? new $.wijmo.wijgrid.cellInfoRange(range.topLeft(), range.topLeft())
						: new $.wijmo.wijgrid.cellInfoRange(endPoint, endPoint);
					range._extend(1 /* extendToColumn */, dataRange);

					break;

				case "singlerow":
					range = (endPoint === null)
						? new $.wijmo.wijgrid.cellInfoRange(range.topLeft(), range.topLeft())
						: new $.wijmo.wijgrid.cellInfoRange(endPoint, endPoint);
					range._extend(2 /* extendToRow */, dataRange);
					break;

				case "singlerange":
					range._extend(preferredExtendMode, dataRange);
					break;

				case "multicolumn":
					range._extend(1 /* extendToColumn */, dataRange);
					break;

				case "multirow":
					range._extend(2 /* extendToRow */, dataRange);
					break;

				case "multirange":
					range._extend(preferredExtendMode, dataRange);
					break;
			}

			return range;
		}

		function doSelection() {
			var offsets = gridView._getDataToAbsOffset(),
				cellOffset = offsets.x,
				rowOffset = offsets.y,
				view = gridView._view(),
				i, len, info, cell, $cell, index,
				$rs = $.wijmo.wijgrid.renderState,
				rowInfo, state,
				prevRowIndex = -1;

			for (i = 0, len = _removedCells.length(); i < len; i++) {
				info = _removedCells.item(i);

				if (_addedCells.indexOf(info) < 0) {
					cell = view.getCell(info.cellIndex() + cellOffset, info.rowIndex() + rowOffset);

					if (cell) {
						if (prevRowIndex !== info.rowIndex()) {
							rowInfo = gridView._createRowInfo(info._row());
							prevRowIndex = info.rowIndex();
						}

						$cell = $(cell);
						state = gridView._changeRenderState($cell, $rs.selected, false);
						gridView.cellStyleFormatter.format($cell, info.cellIndex(), info.column(), rowInfo, state);
					}

					_selectedCells._remove(info);
					_addedDuringCurTransactionCells._remove(info);
				}
				else {
					_removedCells._removeAt(i);
					i--;
					len--;
				}
			}

			prevRowIndex = -1;

			for (i = 0, len = _addedCells.length(); i < len; i++) {
				info = _addedCells.item(i);

				index = _selectedCells.indexOf(info);
				if (index < 0) {
					cell = view.getCell(info.cellIndex() + cellOffset, info.rowIndex() + rowOffset);
					if (cell) {
						if (prevRowIndex !== info.rowIndex()) {
							rowInfo = gridView._createRowInfo(info._row());
							prevRowIndex = info.rowIndex();
						}

						$cell = $(cell);
						state = gridView._changeRenderState($cell, $rs.selected, true);
						gridView.cellStyleFormatter.format($cell, info.cellIndex(), info.column(), rowInfo, state);
					}
					_selectedCells._insertUnsafe(info, ~index);
					_addedDuringCurTransactionCells._add(info);
				}
				else {
					_addedCells._removeAt(i);
					i--;
					len--;
				}
			}
		}

		function doRange(range, add) {
			var x0 = range.topLeft().cellIndex(),
				y0 = range.topLeft().rowIndex(),
				x1 = range.bottomRight().cellIndex(),
				y1 = range.bottomRight().rowIndex(),
				cnt, row, col, cell;

			if (add) {
				cnt = _addedCells.length();
				for (row = y0; row <= y1; row++) {
					if (gridView.dataTable[row].rowType & $.wijmo.wijgrid.rowType.data) {
						for (col = x0; col <= x1; col++) {
							cell = new $.wijmo.wijgrid.cellInfo(col, row);

							if (cnt === 0) {
								_addedCells._appendUnsafe(cell);
							}
							else {
								_addedCells._add(cell);
							}
						}
					}
				}
			}
			else {
				cnt = _removedCells.length();
				for (row = y0; row <= y1; row++) {
					for (col = x0; col <= x1; col++) {
						cell = new $.wijmo.wijgrid.cellInfo(col, row);

						if (cnt === 0) {
							_removedCells._appendUnsafe(cell);
						}
						else {
							_removedCells._add(cell);
						}
					}
				}
			}
		}
		// * private
	};

	$.wijmo.wijgrid.cellInfoOrderedCollection = function (gridView) {
		/// <summary>
		/// Ordered read-only collection of a $.wijmo.wijgrid.cellInfo objects.
		/// Code example: var collection = new $.wijmo.wijgrid.cellInfoOrderedCollection(gridView);
		/// </summary>
		/// <param name="gridView" type="$.wijmo.wijgrid" mayBeNull="false">gridView</param>
		/// <returns type="$.wijmo.wijgrid.cellInfoOrderedCollection" />
		if (!gridView) {
			throw "argument is null";
		}

		var _list = [];

		// public
		this.item = function (index) {
			/// <summary>
			/// Gets an item at the specified index.
			/// Code example: var cellInfoObj = collection.item(0);
			/// </summary>
			/// <param name="index" type="Number" integer="true">The zero-based index of the item to get.</param>
			/// <returns type="$.wijmo.wijgrid.cellInfo">The $.wijmo.wijgrid.cellInfo object at the specified index.</returns>
			return _list[index];
		};

		this.length = function () {
			/// <summary>
			/// Gets the total number of the items in the collection.
			/// Code example: var len = collection.length();
			/// </summary>
			/// <returns type="Number" integet="true">The total number of the items in the collection.</returns>
			return _list.length;
		};

		// (cellInfo)
		// (cellIndex, rowIndex)
		this.indexOf = function (cellIndex, rowIndex) {
			/// <summary>
			/// Returns the zero-based index of specified collection item.
			///
			/// Usage:
			/// 1. indexOf(cellInfo) (note: search is done by value, not by reference).
			/// 2. indexOf(cellIndex, rowIndex)
			///
			/// Code example: var index = collection.indexOf(0, 0);
			/// </summary>
			///
			/// <param name="cellInfo" type="$.wijmo.wijgrid.cellInfo">A cellInfo object to return the index of.</param>
			/// <param name="cellIndex" type="Number" integer="true">A zero-based cellIndex component of the cellInfo object to return the index of.</param>
			/// <param name="rowIndex" type="Number" integer="true">A zero-based rowIndex component of the cellInfo object to return the index of.</param>
			/// <returns type="Number" integer="true">The zero-based index of the specified object, or -1 if the specified object is not a member of the collection.</returns>
			if (arguments.length === 1) {
				rowIndex = cellIndex.rowIndex();
				cellIndex = cellIndex.cellIndex();
			}

			var lo = 0,
				hi = _list.length - 1,
				med, current, cmp;

			while (lo <= hi) {
				med = lo + ((hi - lo) >> 1);
				current = _list[med];

				cmp = current.rowIndex() - rowIndex;
				if (cmp === 0) {
					cmp = current.cellIndex() - cellIndex;
				}

				if (cmp < 0) {
					lo = med + 1;
				} else {
					if (cmp > 0) {
						hi = med - 1;
					} else {
						return med;
					}
				}
			}

			return ~lo;
		};

		this.toString = function () {
			var val = "",
				i, len;

			for (i = 0, len = _list.length; i < len; i++) {
				val += _list[i].toString() + "\n";
			}

			return val;
		};

		// public *

		// internal

		this._add = function (value) {
			var idx = this.indexOf(value);
			if (idx < 0) {
				_list.splice(~idx, 0, value);
				value._setGridView(gridView);
				return true;
			}

			return false;
		};

		// addFrom - an cellInfoOrderedCollection instance
		this._addFrom = function (addFrom) {
			if (addFrom) {
				var fromLen = addFrom.length(),
				thisLen = _list.length,
				i;

				if (thisLen === 0) {
					_list.length = fromLen;

					for (i = 0; i < fromLen; i++) {
						_list[i] = addFrom.item(i);
						_list[i]._setGridView(gridView);
					}
				} else {
					for (i = 0; i < fromLen; i++) {
						this._add(addFrom.item(i));
					}
				}
			}
		};

		this._appendUnsafe = function (value) {
			_list[_list.length] = value;
			value._setGridView(gridView);
		};

		this._insertUnsafe = function (value, index) {
			_list.splice(index, 0, value);
		};

		this._clear = function () {
			_list.length = 0;
		};

		this._remove = function (value) {
			var idx = this.indexOf(value);
			if (idx >= 0) {
				_list.splice(idx, 1);
				return true;
			}

			return false;
		};

		this._removeAt = function (index) {
			_list.splice(index, 1);
		};

		this._getColumnsIndicies = function () {
			var columns = [],
				len = _list.length,
				tmpColumns, i, len2;

			if (len) {
				tmpColumns = [];
				for (i = 0; i < len; i++) {
					tmpColumns[_list[i].cellIndex()] = 1;
				}

				len = tmpColumns.length;
				len2 = 0;
				for (i = 0; i < len; i++) {
					if (tmpColumns[i]) {
						columns[len2++] = i;
					}
				}
			}

			return columns;
		};

		this._getSelectedRowsIndicies = function () {
			var rows = [],
				len = _list.length,
				tmpRows, i, len2;

			if (len) {
				tmpRows = [];
				for (i = 0; i < len; i++) {
					tmpRows[_list[i].rowIndex()] = 1;
				}

				len = tmpRows.length;
				len2 = 0;
				for (i = 0; i < len; i++) {
					if (tmpRows[i]) {
						rows[len2++] = i;
					}
				}
			}

			return rows;
		};

		this._rectangulate = function () {
			var len = _list.length,
				x0 = 0xFFFFFFFF,
				y0 = 0xFFFFFFFF,
				x1 = 0,
				y1 = 0,
				i, cellInfo;

			if (len) {
				for (i = 0; i < len; i++) {
					cellInfo = _list[i];

					x0 = Math.min(x0, cellInfo.cellIndex());
					y0 = Math.min(y0, cellInfo.rowIndex());
					x1 = Math.max(x1, cellInfo.cellIndex());
					y1 = Math.max(y1, cellInfo.rowIndex());
				}

				return new $.wijmo.wijgrid.cellInfoRange(new $.wijmo.wijgrid.cellInfo(x0, y0),
					new $.wijmo.wijgrid.cellInfo(x1, y1));
			}

			return null;
		};

		// internal *
	};
})(jQuery);(function ($) {
	"use strict";
	$.extend($.wijmo.wijgrid, {
		selectionui: function (gridView) {
			var _gap_to_start = 10,
				_evntFormat = "{0}." + gridView.widgetName + ".selectionui",
				_addedCells = new $.wijmo.wijgrid.cellInfoOrderedCollection(gridView),
				_startPos,
				_startCellInfo,
				_endCellInfo,
				_prevMouseMoveRange,
				_inProgress = false,
				_additionalEventsAttached = false,
				_view = gridView._view(),
				_visLeavesLen = gridView._field("visibleLeaves").length;

			gridView.element.bind(_eventKey("mousedown"), _onGridMouseDown);

			this.dispose = function () {
				gridView.element.unbind(_eventKey("mousedown"), _onGridMouseDown);
				_detachAdditionalEvents();
			};

			function _onGridMouseDown(args) {
				if (!gridView._canInteract() || gridView.options.selectionMode.toLowerCase() === "none") {
					return;
				}

				var visibleBounds = _view.getVisibleAreaBounds(),
					mouse = { x: args.pageX, y: args.pageY },
					tag = ((args.target && args.target.tagName !== undefined)
						? args.target.tagName.toLowerCase()
						: undefined),
					$target = $(args.target);

				/*if ((!tag || ((tag === "td" || tag === "th") && $target.hasClass("wijgridtd")) ||
				(tag === "div" && $target.hasClass("wijgriddiv"))) &&
				(mouse.x > visibleBounds.left && mouse.x < visibleBounds.left + visibleBounds.width) &&
				(mouse.y > visibleBounds.top && mouse.y < visibleBounds.top + visibleBounds.height)) {*/

				if ((!tag || $target.is("td.wijgridtd, th.wijgridtd, div.wijmo-wijgrid-innercell")) &&
				(mouse.x > visibleBounds.left && mouse.x < visibleBounds.left + visibleBounds.width) &&
				(mouse.y > visibleBounds.top && mouse.y < visibleBounds.top + visibleBounds.height)) {

					_attachAdditionalEvents();
					_startPos = mouse;

					_startCellInfo = _coordToDataCellInfo(_startPos);
				}
			}

			function _onDocumentMouseMove(args) {
				if (!_startCellInfo || !_startCellInfo._isValid()) {
					return;
				}

				var mouse = { x: args.pageX, y: args.pageY },
					tmp, range, dataOffset, desiredCells, rowsLen, cellsLen,
					row, cell, i, len, info, $cell,
					rowInfo, prevRowIndex, state,
					$rs = $.wijmo.wijgrid.renderState;

				if (!_inProgress) {
					_inProgress = (Math.abs(_startPos.x - mouse.x) > _gap_to_start) ||
						(Math.abs(_startPos.y - mouse.y) > _gap_to_start);
				}

				if (_inProgress) {
					tmp = _coordToDataCellInfo(mouse);
					if (!tmp._isValid()) {
						return;
					}

					_endCellInfo = tmp;

					range = new $.wijmo.wijgrid.cellInfoRange(_startCellInfo, _endCellInfo);
					range._normalize();
					range._clip(gridView._getDataCellsRange());

					if (range._isValid() && !range.isEqual(_prevMouseMoveRange)) {
						dataOffset = gridView._getDataToAbsOffset();

						_prevMouseMoveRange = range;

						desiredCells = new $.wijmo.wijgrid.cellInfoOrderedCollection(gridView);
						rowsLen = range.bottomRight().rowIndex();
						cellsLen = range.bottomRight().cellIndex();

						for (row = range.topLeft().rowIndex(); row <= rowsLen; row++) {
							if (gridView.dataTable[row].rowType & $.wijmo.wijgrid.rowType.data) {
								for (cell = range.topLeft().cellIndex(); cell <= cellsLen; cell++) {
									desiredCells._appendUnsafe(new $.wijmo.wijgrid.cellInfo(cell, row));
								}
							}
						}

						prevRowIndex = -1;
						for (i = 0, len = _addedCells.length(); i < len; i++) {
							info = _addedCells.item(i);
							if (desiredCells.indexOf(info) < 0) // remove css
							{
								if (gridView.selection().selectedCells().indexOf(info) < 0) {
									cell = _view.getCell(info.cellIndex() + dataOffset.x, info.rowIndex() + dataOffset.y);
									if (cell) {
										if (prevRowIndex !== info.rowIndex()) {
											rowInfo = gridView._createRowInfo(info._row());
											prevRowIndex = info.rowIndex();
										}

										$cell = $(cell);
										state = gridView._changeRenderState($cell, $rs.selected, false);
										gridView.cellStyleFormatter.format($cell, info.cellIndex(), info.column(), rowInfo, state);
									}
								}

								_addedCells._removeAt(i);
								i--;
								len--;
							}
						}

						prevRowIndex = -1;
						for (i = 0, len = desiredCells.length(); i < len; i++) {
							info = desiredCells.item(i);
							if (_addedCells.indexOf(info) < 0 && gridView.selection().selectedCells().indexOf(info) < 0) {
								if (_addedCells._add(info)) {
									cell = _view.getCell(info.cellIndex() + dataOffset.x, info.rowIndex() + dataOffset.y);
									if (cell) {
										if (prevRowIndex !== info.rowIndex()) {
											rowInfo = gridView._createRowInfo(info._row());
											prevRowIndex = info.rowIndex();
										}

										$cell = $(cell);
										state = gridView._changeRenderState($cell, $rs.selected, true);
										gridView.cellStyleFormatter.format($cell, info.cellIndex(), info.column(), rowInfo, state);
									}
								}
							}
						}
					} // end if
				}
			}

			function _onDocumentMouseUp(args) {
				_detachAdditionalEvents();

				if (_inProgress) {
					_inProgress = false;

					if (_prevMouseMoveRange && _prevMouseMoveRange._isValid()) {
						gridView._changeCurrentCell(_endCellInfo);

						if (!args.shiftKey || (!gridView.selection()._multipleRangesAllowed() && gridView.options.selectionMode.toLowerCase() !== "singleRange")) {
							gridView.selection()._startNewTransaction(_startCellInfo);
						}

						gridView.selection().beginUpdate();
						gridView.selection()._selectRange(_prevMouseMoveRange, args.shiftKey, args.ctrlKey, 0 /* none */, _endCellInfo);
						gridView.selection().endUpdate();

						var view = gridView._view(),
							dataOffset = gridView._getDataToAbsOffset(),
							i, len, info, cell, $cell,
							prevRowIndex = -1, rowInfo, state,
							$rs = $.wijmo.wijgrid.renderState;

						// clear remained cells
						for (i = 0, len = _addedCells.length(); i < len; i++) {
							info = _addedCells.item(i);
							if (gridView.selection().selectedCells().indexOf(info) < 0) {
								cell = view.getCell(info.cellIndex() + dataOffset.x, info.rowIndex() + dataOffset.y);
								if (cell !== null) {
									if (prevRowIndex !== info.rowIndex()) {
										rowInfo = gridView._createRowInfo(info._row());
										prevRowIndex = info.rowIndex();
									}

									$cell = $(cell);
									state = gridView._changeRenderState($cell, $rs.selected, false);
									gridView.cellStyleFormatter.format($cell, info.cellIndex(), info.column(), rowInfo, state);
								}
							}
						}

						_addedCells._clear();
						_startCellInfo = _endCellInfo = _prevMouseMoveRange = null;

						return false; // cancel bubbling
					}
				}
			}

			/*function _onSelectStart(e) {
			e.preventDefault();
			};*/

			function _attachAdditionalEvents() {
				if (!_additionalEventsAttached) {
					try {
						gridView.element.disableSelection();
						gridView.element.css({ "MozUserSelect": "none", "WebkitUserSelect": "none" });


						$(document)
						.bind(_eventKey("mousemove"), _onDocumentMouseMove)
						.bind(_eventKey("mouseup"), _onDocumentMouseUp);

						/*if ($.browser.msie) {
						$(document.body).bind("selectstart", _onSelectStart);
						}*/
					}
					finally {
						_additionalEventsAttached = true;
					}
				}
			}

			function _detachAdditionalEvents() {
				if (_additionalEventsAttached) {
					try {
						gridView.element.enableSelection();
						gridView.element.css({ "MozUserSelect": "", "WebkitUserSelect": "" });

						$(document)
						.unbind(_eventKey("mousemove"), _onDocumentMouseMove)
						.unbind(_eventKey("mouseup"), _onDocumentMouseUp);

						/*if ($.browser.msie) {
						$(document.body).unbind("selectstart", _onSelectStart);
						}*/
					} finally {
						_additionalEventsAttached = false;
					}
				}
			}

			function _eventKey(eventType) {
				return $.wijmo.wijgrid.stringFormat(_evntFormat, eventType);
			}

			function _coordToDataCellInfo(pnt /* {x, y} */) {
				var left = 0,
					right = _visLeavesLen - 1,
					median = 0,
					cellIdx = -1,
					bounds,
					gridRowsAccessor = new $.wijmo.wijgrid.rowAccessor(_view, 2 /* tbody */, 0, 0),
					rowIdx, rowObj, dataOffset, result;

				// get cell index
				while (left <= right) {
					median = ((right - left) >> 1) + left;

					bounds = $.wijmo.wijgrid.bounds(_view.getHeaderCell(median)); // get header cell
					if (!bounds) { // no header?
						rowObj = gridRowsAccessor.item(0);
						bounds = $.wijmo.wijgrid.bounds(gridRowsAccessor.getCell(rowObj, median)); // get data cell
					}

					if (!bounds) {
						break;
					}

					if (pnt.x < bounds.left) { // -1 
						right = median - 1;
					}
					else
						if (pnt.x > bounds.left + bounds.width) { // 1
							left = median + 1;
						} else { // 0
							cellIdx = median;
							break;
						}
				}

				if (cellIdx === -1) {
					return $.wijmo.wijgrid.cellInfo.prototype.outsideValue;
				}

				gridRowsAccessor = new $.wijmo.wijgrid.rowAccessor(_view, 0 /* all */, 0, 0);

				rowIdx = -1;
				left = 0;
				right = gridRowsAccessor.length() - 1;
				median = 0;

				// get row index
				while (left <= right) {
					median = ((right - left) >> 1) + left;

					/*var bounds = _trBoundsHash[median];
					if (!bounds) {
					var rowObj = allGridRowsAccessor.item(median);
					_trBoundsHash[median] = bounds = $.wijmo.wijgrid.bounds(allGridRowsAccessor.getCell(rowObj, 0));
					}*/
					rowObj = gridRowsAccessor.item(median);
					bounds = $.wijmo.wijgrid.bounds(gridRowsAccessor.getCell(rowObj, 0));

					if (pnt.y < bounds.top) { // -1
						right = median - 1;
					}
					else
						if (pnt.y > bounds.top + bounds.height) { // 1
							left = median + 1;
						} else { // 0
							rowIdx = median;
							break;
						}
				} // end while { }


				if (rowIdx === -1) {
					return $.wijmo.wijgrid.cellInfo.prototype.outsideValue;
				}

				dataOffset = gridView._getDataToAbsOffset();

				result = new $.wijmo.wijgrid.cellInfo(cellIdx - dataOffset.x, rowIdx - dataOffset.y);
				result._clip(gridView._getDataCellsRange());

				return result;
			}
		}
	});
})(jQuery);(function ($) {
	"use strict";
	$.wijmo.wijgrid.rowAccessor = function (view, scope, offsetTop, offsetBottom) {
		/// <summary>
		/// Object for convenient access to rows of a wijgrid widget.
		/// </summary>

		if (!offsetTop) {
			offsetTop = 0;
		}

		if (!offsetBottom) {
			offsetBottom = 0;
		}

		this.item = function (index) {
			/// <summary>
			/// Gets an array of the table row elements that represents a wijgrid widget row at the specified index.
			/// remark: size of returning array is always two.
			/// </summary>
			/// <param name="index" type="Number" integer="true">
			/// The zero-based index of the row to retrieve.
			/// </param>
			/// <returns type="Array" elementType="object" elementDomElement="true">
			/// The array of the table row elements at the specified index.
			/// </returns>
			var len = this.length();

			return (index < len)
				? view.getJoinedRows(index + offsetTop, scope)
				: null;
		};

		this.length = function () {
			/// <summary>
			/// Gets the total number of elements.
			/// </summary>
			var joinedTables = view.getJoinedTables(true, 0),
				len = 0, htmlAccessor;

			if (htmlAccessor = joinedTables[0]) {
				len = htmlAccessor.getSectionLength(scope);
			}

			if (htmlAccessor = joinedTables[1]) {
				len += htmlAccessor.getSectionLength(scope);
			}

			len -= offsetTop + offsetBottom;

			if (len < 0) {
				len = 0;
			}

			return len;
		};

		this.iterateCells = function (rowObj, callback, param) {
			/// <summary>
			/// Sequentially iterates the cells in a <paramref name="rows"/> array.
			///
			/// example:
			/// Suppose rows is an array containing the following data:
			/// [ ["a", "b"], ["c", "d", "e"] ]
			///
			/// When it is iterated it will sequentially return:
			/// "a", "b", "c", "d", "e"
			/// </summary>
			/// <param name="rowObj" type="Array" elementType="Object" elementDomElement="true">Array of rows to be iterated.</param>
			/// <param name="callback" type="Function">Function that will be called each time a new cell is reached.</param>
			/// <param name="param" type="Object" optional="true">Parameter that can be handled within the callback function.</param>
			if (rowObj && callback) {
				var globCellIdx = 0,
					i, len, domRow, j, cellLen, result;

				for (i = 0, len = rowObj.length; i < len; i++) {
					domRow = rowObj[i];

					if (domRow) {
						for (j = 0, cellLen = domRow.cells.length; j < cellLen; j++) {
							result = callback(domRow.cells[j], globCellIdx++, param);
							if (result !== true) {
								return;
							}
						}
					}
				}
			}
		};

		this.getCell = function (rowObj, globCellIndex) {
			/// <summary>
			/// Gets a cell by its global index in a row's array passed in rowObj.
			/// 
			/// example:
			/// Suppose rows is an array containing the following data:
			/// [ ["a", "b"], ["c", "d", "e"] ]
			///
			/// "a" symbol has a global index 0.
			/// "c" symbol has a global index 2.
			/// </summary>
			/// <param name="rowObj" type="Array" elementType="Object" elementDomElement="true">Array of table row elements.</param>
			/// <param name="index" type="Number" integer="true">Zero-based global index of a cell.</param>
			/// <returns type="Object" domElement="true" elementMayBeNull="true">
			/// A cell or null if a cell with provided index is not found.
			/// </returns>
			var domRow, cellLen;

			if (rowObj && (domRow = rowObj[0])) {
				cellLen = domRow.cells.length;
				if (globCellIndex < cellLen) {
					return domRow.cells[globCellIndex];
				}

				globCellIndex -= cellLen;

				if (domRow = rowObj[1]) {
					cellLen = domRow.cells.length;
					if (globCellIndex < cellLen) {
						return domRow.cells[globCellIndex];
					}
				}
			}

			return null;
		};

		this.cellsCount = function (rowObj) {
			/// <summary>
			/// Gets the number of cells in a array of table row elements.
			/// </summary>
			/// <param name="rowObj" type="Array" elementType="Object" elementDomElement="true">Array of table row elements.</param>
			/// <returns type="Number" integer="true">The number of cells in a array of table row elements.</returns>
			var res = 0,
				domRow;

			if (rowObj && (domRow = rowObj[0])) {
				res = domRow.cells.Length;

				if (domRow = rowObj[1]) {
					res += domRow.cells.Length;
				}
			}

			return res;
		};
	};
})(jQuery);(function ($) {
	"use strict";
	$.extend($.wijmo.wijgrid, {
		cellEditorHelper: function () {
			this.currentCellEditStart = function (grid, e) {
				var result = false,
					currentCell = grid.currentCell(),
					rowObj, args, $innerDiv, rowType;

				if (currentCell._isValid() && !currentCell._isEdit() && (currentCell.column().dataIndex >= 0)) {
					rowObj = currentCell._row();

					if (rowObj && rowObj.length) {
						//rowType = $.wijmo.wijgrid.dataPrefix($(rowObj[0]), grid._data$prefix, "rowType");
						rowType = $.wijmo.wijgrid.dataPrefix(rowObj[0], grid._data$prefix, "rowType");

						if (rowType & $.wijmo.wijgrid.rowType.data) {

							args = {
								cell: currentCell,
								event: e,
								handled: false
							};

							if (result = grid._trigger("beforeCellEdit", null, args)) { // todo
								if (!args.handled) {
									result = defaultBeforeCellEdit(grid, args);
								}
							}

							if (result) {
								currentCell._isEdit(true);

								if (grid.options.showRowHeader) {
									$innerDiv = $(rowObj[0].cells[0]).children("div.wijmo-wijgrid-innercell");
									if ($innerDiv.length) {
										$innerDiv.empty();
										$innerDiv.append($("<div>&nbsp;</div>").addClass("ui-icon ui-icon-pencil"));
									}
								}
							}
						}
					}
				}

				return result;
			};

			this.currentCellEditEnd = function (grid, e) {
				var currentCell = grid.currentCell(),
					result = false,
					rowObj, rowType, escPressed, args, valueIsChanged, a, b;

				if (!currentCell._isValid() || !currentCell._isEdit()) {
					return;
				}

				rowObj = currentCell._row();
				if (rowObj && rowObj.length) {
					//rowType = $.wijmo.wijgrid.dataPrefix($(rowObj[0]), grid._data$prefix, "rowType");
					rowType = $.wijmo.wijgrid.dataPrefix(rowObj[0], grid._data$prefix, "rowType");

					if (!(rowType & $.wijmo.wijgrid.rowType.data)) {
						return result;
					}

					escPressed = (e && e.which === $.ui.keyCode.ESCAPE);

					if (!e || (!escPressed)) {
						args = {
							cell: currentCell,
							value: undefined
						};

						if (result = grid._trigger("beforeCellUpdate", null, args)) {
							if (args.value === undefined) {
								args.value = getCellValue(grid, currentCell); // trying to get value using default implementation.
							}

							valueIsChanged = false;
							if (args.cell.column().dataType === "datetime") {
								a = args.value ? args.value.getTime() : null;
								b = currentCell.value() ? currentCell.value().getTime() : null;
								valueIsChanged = a !== b;

							} else {
								valueIsChanged = args.value !== currentCell.value();
							}

							if (valueIsChanged) {
								// ** update datasource
								try {
									currentCell.value(args.value);
								} catch (ex) {
									result = false;
									grid._trigger("invalidCellValue", null, { cell: currentCell, value: args.value });
								}

								if (result) {
									grid._trigger("afterCellUpdate", null, { cell: currentCell });
								}
							}
						}
					} else {
						// ESC key
						result = true;
					}

					if (result) {
						args = {
							cell: currentCell,
							event: e,
							handled: false
						};

						grid._trigger("afterCellEdit", null, args);

						if (!args.handled) {
							result = defaultAfterCellEdit(grid, args);
						}

						if (result) {
							currentCell._isEdit(false);
						}

						if (grid.options.showRowHeader) {
							$(rowObj[0].cells[0]).children("div.wijmo-wijgrid-innercell").html("&nbsp;"); // remove ui-icon-pencil
						}

						grid.element.focus();
						$(grid._view().focusableElement()).focus();
						currentCell.tableCell().focus();
					}
				}

				return result;
			};

			// private

			function defaultBeforeCellEdit(grid, args) {
				var leafOpt = args.cell.column(),
					result = false,
					value, $container, $input, len, kbEvent;

				if (leafOpt.dataIndex >= 0) {
					value = args.cell.value();
					result = true;

					try {
						$container = args.cell.container();

						if (leafOpt.dataType === "boolean") {
							/*input = document.createElement("input");
							input.type = "checkbox";
							input.className = "wijgridinput ui-wijinput ui-state-focus";

							$(input).bind("keydown", grid, checkBoxOrInputKeyDown);

							content.innerHTML = "";
							content.appendChild(input);

							input.focus();

							if ($.browser.msie) {
							setTimeout(function () {
							input.focus();
							}, 0);
							}
							input.checked = value;*/
							$input = $container.children("input");
							// setting checked value manually after input getting focused.
							// because browsers other than FF will not check correctly.
							// modified by Jeffrey on Jan 21st 2011
							// because we should distinguish two ways for entering the editing status.
							// one is clicking the mouse, the other is pressing the key.
							/*
							$input.focus().one("keyup", function (e) {
							if (e.which === $.ui.keyCode.SPACE) {
							e.preventDefault();
							$input[0].checked = !value;
							}
							});
							*/
							$input.focus();
							if (args.event && args.event.type === "keypress") {
								$input.one("keyup", function (e) {
									if (e.which === $.ui.keyCode.SPACE) {
										e.preventDefault();
										$input[0].checked = !value;
									}
								});
							}
							// end by Jeffrey
						} else {
							$input = $("<input />")
								.attr("type", "text")
								.addClass("wijgridinput wijmo-wijinput ui-state-focus")
								.bind("keydown", grid, checkBoxOrInputKeyDown);

							if (args.event && args.event.type === "keypress" && args.event.which) {
								$input.val(String.fromCharCode(args.event.which));
							} else {
								switch (args.cell.column().dataType) {
									case "currency":
									case "number":
										if (value !== null) {
											$input.val(value); // ignore formatting
											break;
										}
										// fall through
									default:
										$input.val(grid._toStr(args.cell.column(), value));
										break;
								}
							}

							$container
								.empty()
								.append($input);

							// move caret to the end of the text
							len = $input.val().length;
							new $.wijmo.wijgrid.domSelection($input[0]).setSelection({ start: len, end: len });

							$input.focus();

							if ($.browser.msie) {
								setTimeout(function () {
									$input.focus();
								}, 0);
							}

							// FF issue: text does not track to the new position of the caret
							if ($.browser.mozilla && document.createEvent && $input[0].dispatchEvent) {
								kbEvent = document.createEvent("KeyboardEvent");
								kbEvent.initKeyEvent("keypress", false, true, null, false, false, false, false, 0, $.ui.keyCode.SPACE);
								$input[0].dispatchEvent(kbEvent);
								kbEvent = document.createEvent("KeyboardEvent");
								kbEvent.initKeyEvent("keypress", false, true, null, false, false, false, false, $.ui.keyCode.BACKSPACE, 0);
								$input[0].dispatchEvent(kbEvent);
							}
						}
					}
					catch (ex) {
						alert(ex.message);
						result = false;
					}
				}

				return result;
			}

			function defaultAfterCellEdit(grid, args) {
				var leafOpt = args.cell.column(),
					result = false,
					$container, cellValue, dataRow, sourceDataRow, input;

				if (leafOpt.dataIndex >= 0) {
					result = true;

					try {
						$container = args.cell.container();
						cellValue = grid._toStr(leafOpt, args.cell.value());

						dataRow = grid.dataTable[args.cell.rowIndex()];
						sourceDataRow = grid.data()[dataRow.originalRowIndex];
						if (leafOpt.dataType === "boolean") {
							input = $container.children("input");

							if (cellValue === "true") {
								input.attr("checked", "checked");
							}
							else {
								input.removeAttr("checked");
							}
						}
						else {
							grid.cellFormatter.format($container, leafOpt, cellValue, dataRow.rowType, sourceDataRow);
						}
					}
					catch (ex) {
						alert("defaultAfterCellEdit: " + ex.message);
						result = false;
					}
				}

				return result;
			}

			function checkBoxOrInputKeyDown(args) {
				if (args.which === $.ui.keyCode.ENTER) { // stop editing when Enter key is pressed
					var grid = args.data;

					if (grid) {
						grid._endEditInternal(args);
						return false; // prevent submit behaviour.
					}
				}
			}

			function getCellValue(gridView, currentCell) {
				var $input = currentCell.container().find(":input:first"),
					result = null;

				if ($input.length) {
					result = ($input.attr("type") === "checkbox")
						? $input[0].checked
						: $input.val();

					result = gridView._parse(currentCell.column(), result);
				}

				return result;
			}

			// private *
		}
	});
})(jQuery);/*
Dependencies:
jquery.ui.mouse.js
jquery.ui.draggable.js
*/
(function ($) {
	"use strict";
	$.extend($.wijmo.wijgrid, {
		fixedView: function (gridView) {
			var _rowsCount, // total rows count
				_viewTables = {}, // rendered DOM tables
				_table00,
				_table01,
				_table10,
				_table11,
				_scroller, // scrolling div
				verScrollBarSize = 18; // scroll bar sizes

			// table element
			this.element = gridView.element;

			this.initialize = function () {
				this._createLayout();
			};

			this._createLayout = function () {
				gridView.outerDiv.wrapInner("<div class=\"wijmo-wijgrid-fixedview\"><div class=\"wijmo-wijgrid-scroller\"><div class=\"wijmo-wijgrid-split-area-se wijmo-wijgrid-content-area\"></div></div></div>");
				_scroller = gridView.outerDiv.find(".wijmo-wijgrid-scroller");

				_scroller.after("<div class=\"wijmo-wijgrid-split-area wijmo-wijgrid-split-area-nw\" style=\"overflow:hidden;position:absolute;z-index:4;top:0px;left:0px;\"></div>");
				_scroller.after("<div class=\"wijmo-wijgrid-split-area wijmo-wijgrid-split-area-ne\" style=\"overflow:hidden;position:absolute;z-index:4;top:0px;left:0px;\"></div>");
				_scroller.after("<div class=\"wijmo-wijgrid-split-area wijmo-wijgrid-split-area-sw\" style=\"overflow:hidden;position:absolute;z-index:4;top:0px;left:0px;\"></div>");
			};

			this._onScrolled = function (e, data) {
				gridView.outerDiv.find(".wijmo-wijgrid-split-area-ne")[0].scrollLeft = parseInt((gridView.outerDiv.find(".wijmo-wijsuperpanel-templateouterwrapper").css("left") + "").replace("px", ""), 10) * -1;
				gridView.outerDiv.find(".wijmo-wijgrid-split-area-sw")[0].scrollTop = parseInt((gridView.outerDiv.find(".wijmo-wijsuperpanel-templateouterwrapper").css("top") + "").replace("px", ""), 10) * -1;
			};

			this._testNeedVBar = function (outerDiv, gridEle, tableNE, mode, autoHeight) {
				var excludeVbarWidth, gridWidth, gridHeight, outerWidth, outerHeight;

				gridWidth = tableNE.width();
				gridHeight = gridEle.height() + gridView.options.splitDistanceY;
				outerWidth = outerDiv.width();
				outerHeight = outerDiv.height();
				// remove auto width to make width 100%  take effect. 

				if (mode === "both" || mode === "vertical") {
					excludeVbarWidth = true;
				}
				else if (mode === "auto") {
					if (gridHeight > outerHeight) {
						excludeVbarWidth = true;
					}
					//modified by Jeffrey on 21st Feb 2011
					//When the height needs to be auto adjusted,
					//the vertical scrollbar should not be shown
					//else if (gridWidth > outerWidth && gridHeight > outerHeight - verScrollBarSize) {
					else if (!autoHeight && gridWidth > outerWidth && gridHeight > outerHeight - verScrollBarSize) {
						//end by Jeffrey
						excludeVbarWidth = true;
					}
				}
				return excludeVbarWidth;
			};

			this.updateSplits = function (scrollValue) {
				var o = gridView.options,
					thsWithWidth = [],
					self = this, expandToColumn,
					visibleLeaves, widthArray, $tableSE, mode, rowObj, fooRow,
					outerDiv, beforeWidth, diff, after, len, colIndex, $tableNE, needExpand, headerWidth;

				try {
					if (o.staticRowIndex >= 0) { // interpreted as bool
						o.splitDistanceY = gridView.outerDiv.find(".wijmo-wijgrid-split-area-ne table")[0].offsetHeight;
					} else {
						o.splitDistanceY = 0;
					}
					if (gridView._staticColumnIndex >= 0 /*o.staticColumnIndex >= 0*/) {
						o.splitDistanceX = gridView.outerDiv.find(".wijmo-wijgrid-split-area-nw table")[0].offsetWidth;
					} else {
						o.splitDistanceX = 0;
					}
				} catch (ex) { }

				this._updateSplitAreaBounds();

				// handle autosizing
				/*
				var fixedColIdx = gridView._staticColumnIndex; //gridView.options.staticColumnIndex; // YK
				var fixedRowIdx = gridView.options.staticRowIndex; // interpreted as bool
				if (fixedColIdx >= 0 && fixedColIdx < gridView._field("leaves").length - 1 || fixedRowIdx >= 0) {
				this.adjustColumnSizes(_viewTables['nw'], _viewTables['sw']);
				this.adjustColumnSizes(_viewTables['ne'], _viewTables['se']);
				}
				*/

				$tableSE = $(_table11.element());
				$tableNE = $(_table01.element());
				// clone a row to expand table in grouping mode.
				rowObj = $tableSE.find("tbody .wijmo-wijgrid-row:not(.wijmo-wijgrid-groupheaderrow):first");

				self.fooRow = fooRow = rowObj
					.clone()
				//.removeClass() // remove all classes
					.removeAttr("datarowindex")
					.addClass("wijmo-wijgrid-foorow")
					.appendTo(rowObj.parent()).show().height(0).css({ "font-size": "0" });

				// fooRowCells belong to the bottom table
				self.fooRowCells = fooRow
					.find(">td")
				//.removeClass() // remove all classes
					.height(0)
					.css({ "border-top": "0", "border-bottom": "0" })
					.find(">div.wijmo-wijgrid-innercell")
				//force the height of fooRow to 0
					.css({ "padding-top": "0px", "padding-bottom": "0px" })
						.empty();

				// hide foo row because it has a 1px height in IE6&7
				//fooRow.hide();
				fooRow.css("visibility", "hidden"); // using "visibility:hidden" instead of "display:none"

				//if there is no data in table, we must enlarge the table to prevent the width from being 0
				if (fooRow.length === 0) {
					gridView.element.css("width", "100%");
				}

				// set width to top table th and bottom table td in first row.
				visibleLeaves = gridView._field("visibleLeaves");
				widthArray = [];

				mode = o.scrollMode;
				outerDiv = gridView.outerDiv;
				// if any column has width option, we will set the width for inner cells.
				$.each(visibleLeaves, function (index, leaf) {
					var th, isPercentage,
						w = leaf.width;

					if (w) {
						isPercentage = typeof w === "string";
						th = self.getHeaderCell(index);
						if (!isPercentage && o.ensureColumnsPxWidth) {
							self.setColumnWidth(index, w);
							leaf._realWidth = true;
							thsWithWidth.push({ th: $(th), clientWidth: th.clientWidth, index: index, isPercentage: isPercentage, ensurePxWidth: true });
						}
						else {
							th.width = w;
							thsWithWidth.push({ th: $(th), clientWidth: th.clientWidth, index: index, isPercentage: isPercentage });
						}
					}
				});

				if (!o.ensureColumnsPxWidth && self._testNeedVBar(gridView.outerDiv, $tableSE, $tableNE, mode, gridView._autoHeight)) {
					headerWidth = _scroller.width() - verScrollBarSize;
				}
				else {
					headerWidth = _scroller.width();
				}
				_scroller.width(headerWidth);
				$tableNE.parent().width(headerWidth);
				if (!o.ensureColumnsPxWidth) {
					needExpand = $tableNE.width() < outerDiv.innerWidth();
					expandToColumn = o.autoExpandColumnIndex;
					if (needExpand && !expandToColumn) {
						$tableNE.css("width", "100%");
						beforeWidth = $tableNE.width();
					}
				}
				$.each(visibleLeaves, function (index, leaf) {
					self.setColumnWidth(index, null, widthArray);
				});
				// remove th width
				$.each(thsWithWidth, function (index, widthObject) {
					if (widthObject.ensurePxWidth) {
						return;
					}
					widthObject.th.removeAttr("width");
				});
				$.each(widthArray, function (index, width) {
					var leaf = visibleLeaves[index];
					if (leaf._realWidth) {
						delete leaf._realWidth;
						return;
					}
					self.setColumnWidth(index, width);
				});
				if (needExpand) {
					if (expandToColumn) {
						beforeWidth = $tableNE.width();
					}
					else {
						$tableNE.css("width", "auto");
					}
					after = o.autoExpandColumnIndex ? _scroller.width() : $tableNE.width();
					diff = after - beforeWidth;
					if (!expandToColumn) {
						// if we are expanding table with 100% width,
						// there may be a 1px difference before 
						// and after adding width on each inner cell div.
						// we need to substract it from one of columns.
						diff = -diff;
					}
				}
				// fix width to account for difference.
				if (diff && visibleLeaves.length > 0) {
					len = widthArray.length - 1;
					colIndex = o.autoExpandColumnIndex || len;
					if (colIndex > len) {
						colIndex = len;
					}
					self.setColumnWidth(colIndex, widthArray[colIndex] + diff);
				}
				//removed by Jeffrey on 21st Feb 2011
				//the height is set to a wrong value for the height of footer is not taken into account.
				//because the height has already been set, there is no need setting it again.
				//if (self._noHeight) {
				//	_scroller.height($tableSE.height() + o.splitDistanceY);
				//}
				//end by Jeffrey

				//fooRow.show();

				self.refreshPanel(scrollValue);
			};

			this.getScrollValue = function () {
				var superPanelObj = this.getSuperPanel();

				return (superPanelObj)
					? {
						type: "fixed",
						hScrollValue: superPanelObj.options.hScroller.scrollValue,
						vScrollValue: superPanelObj.options.vScroller.scrollValue
					}
					: {
						type: "fixed",
						hScrollValue: null,
						vScrollValue: null
					};
			};

			this.getSuperPanel = function () {
				return _scroller
					? _scroller.data("wijsuperpanel")
					: null;
			};

			this.scrollTo = function (currentCell) {
				var o = gridView.options,
					superPanelObj = this.getSuperPanel(),
					element = currentCell.tableCell(),
					$dom = element.nodeType ? $(element) : element,
					contentElement, wrapperElement,
					visibleLeft, visibleTop, visibleWidth, visibleHeight,
					elementPosition, elementLeft, elementTop, elementWidth, elementHeight,
					resultLeft = null, resultTop = null;

				if (superPanelObj && $dom.is(":visible")) {
					contentElement = superPanelObj.getContentElement();
					wrapperElement = contentElement.parent();
					visibleLeft = parseInt((contentElement.css("left") + "").replace("px", ""), 10) * -1;
					visibleTop = parseInt((contentElement.css("top") + "").replace("px", ""), 10) * -1;
					visibleWidth = wrapperElement.outerWidth() - o.splitDistanceX;
					visibleHeight = wrapperElement.outerHeight() - o.splitDistanceY;
					elementPosition = $dom.position();
					elementLeft = Math.abs(elementPosition.left);
					elementTop = Math.abs(elementPosition.top);
					elementWidth = $dom.outerWidth();
					elementHeight = $dom.outerHeight();

					if (elementTop + elementHeight > visibleTop + visibleHeight) {
						visibleTop = resultTop = elementTop + elementHeight - visibleHeight;
					}
					if (elementLeft + elementWidth > visibleLeft + visibleWidth) {
						visibleLeft = resultLeft = elementLeft + elementWidth - visibleWidth;
					}
					if (elementTop < visibleTop) {
						resultTop = elementTop;
					}
					if (elementLeft < visibleLeft) {
						resultLeft = elementLeft;
					}
					if (resultLeft !== null) {
						superPanelObj.hScrollTo(resultLeft);
					}
					if (resultTop !== null) {
						superPanelObj.vScrollTo(resultTop);
					}
				}
			};

			this.setColumnWidth = function (index, px, widthArray) {
				/// <summary>
				/// Set column width.
				/// </summary>
				/// <param name="index" type="Number">
				/// The index of the column. Start with 0.
				/// </param>
				/// <param name="px" type="Number">
				/// The width of the column.  If px value is undefined, the offset width will be used.
				/// </param>

				var th = this.getHeaderCell(index),
				//$fooRow = null,
					colWidth = th.clientWidth;
				//flag = false;

				if (px) {
					if (!widthArray) {
						$(th).children("div.wijmo-wijgrid-innercell").setOutWidth(px);
						this.fooRowCells.eq(index).setOutWidth(px);
					}

					this.forEachColumnCell(index, function (cell, index) {
						var $row = $(cell.parentNode);

						if ($row.parent().is("tbody") && !$row.is(".wijmo-wijgrid-emptydatarow", ".wijmo-wijgrid-groupheaderrow", ".wijmo-wijgrid-groupfooterrow")) {
							if (widthArray) {
								widthArray.push(px);
								return false;
							}
							else {
								$(cell).children("div.wijmo-wijgrid-innercell").setOutWidth(px);
							}
						}

						return true;
					});
				} else { // set column and outer width of td and th.
					this.forEachColumnCell(index, function (cell, index) {
						var $row = $(cell.parentNode);

						if ($row.parent().is("tbody") && !$row.is(".wijmo-wijgrid-groupheaderrow", ".wijmo-wijgrid-groupfooterrow")) {

							/*if (!flag) {
							if (!$row.is(":visible")) {
							$fooRow = $row;
							$row.show();
							}

							flag = true;
							}*/

							if (!widthArray) {
								$(cell).children("div.wijmo-wijgrid-innercell").setOutWidth(colWidth);
							}
							else {
								return false;
							}
						}

						return true;
					});
					if (widthArray) {
						widthArray.push(colWidth);
					}
					else {
						$(th).children("div.wijmo-wijgrid-innercell").setOutWidth(colWidth);
					}

					/*if ($fooRow) {
					$fooRow.hide();
					}*/
				}
			};

			this._getMappedScrollMode = function () {
				var scrollMode = gridView.options.scrollMode,
					vScrollBarVisibility = "auto",
					hScrollBarVisibility = "auto";

				switch (scrollMode) {
					case "horizontal":
						vScrollBarVisibility = "hidden";
						hScrollBarVisibility = "visible";
						break;

					case "vertical":
						vScrollBarVisibility = "visible";
						hScrollBarVisibility = "hidden";
						break;

					case "both":
						vScrollBarVisibility = "visible";
						hScrollBarVisibility = "visible";
						break;
				}
				return { vScrollBarVisibility: vScrollBarVisibility, hScrollBarVisibility: hScrollBarVisibility };
			};


			this.refreshPanel = function (scrollValue) {
				var self = this,
					panelModes = self._getMappedScrollMode(),
					areaNE;
				//fooRow = this.fooRow;

				//fooRow.hide();

				_scroller.width(this._getGridWidth(gridView.options.scrollMode));

				if (!_scroller.data("wijsuperpanel")) {
					_scroller.wijsuperpanel({
						scrolled: this._onScrolled,
						bubbleScrollingEvent: false,
						vScroller: { scrollBarVisibility: panelModes.vScrollBarVisibility, scrollValue: scrollValue.type === "fixed" ? scrollValue.vScrollValue : null },
						hScroller: { scrollBarVisibility: panelModes.hScrollBarVisibility, scrollValue: scrollValue.type === "fixed" ? scrollValue.hScrollValue : null },
						//added by Jeffrey on 21st Feb 2011
						//auto adjusting height with hscrollbar shown
						hScrollerActivating: function (e, data) {
							var diff, areaSW;
							if (gridView._autoHeight) {
								diff = gridView.element.height() + gridView.options.splitDistanceY - data.contentLength;
								if (diff > 0) {
									areaSW = gridView.outerDiv.find(".wijmo-wijgrid-split-area-sw");
									areaSW.height(areaSW.height() + diff);
									_scroller.height(_scroller.height() + diff);
									_scroller.wijsuperpanel("paintPanel");
									return false;
								}
							}
						}
						//end by Jeffrey
					});
				}
				else {
					_scroller.wijsuperpanel("paintPanel");
				}

				areaNE = gridView.outerDiv.find(".wijmo-wijgrid-split-area-ne");
				areaNE.width(_scroller.wijsuperpanel("getContentElement").parent().width());

				//fooRow.show();

				// synchronize scroll left of top table with bottom table
				this._onScrolled();
			};

			this._getGridWidth = function (mode, y) {
				var tableWidth = gridView.element.outerWidth(true),
					outWidth = gridView.outerDiv.innerWidth();

				if (this._testNeedVBar(gridView.outerDiv, gridView.element, $(_table01.element()), mode, gridView._autoHeight)) {
					tableWidth += verScrollBarSize;
				}
				if (tableWidth > outWidth) {
					tableWidth = outWidth;
				}

				return tableWidth;
			};

			this._updateSplitAreaBounds = function () {
				var o = gridView.options,
					controlWidth = o.width || gridView.outerDiv.width(),
					controlHeight = o.height || gridView.outerDiv.height(),
					areaNW, areaNE, areaSW, areaSE,
					self = this;

				if (controlHeight <= 0) {
					controlHeight = gridView.outerDiv.find(".wijmo-wijgrid-split-area-se > table")[0].offsetHeight;
				}

				//if (gridView.outerDiv[0].style.height !== "" && gridView.outerDiv[0].style.height !== "auto") {
				if (!gridView._autoHeight) {
					_scroller.height(controlHeight);
				}
				else {
					// no height is set for outer div, we need to expand the grid.
					_scroller.height(controlHeight + o.splitDistanceY);
					//self._noHeight = true;
				}

				_scroller.width(controlWidth);

				areaNW = gridView.outerDiv.find(".wijmo-wijgrid-split-area-nw");
				areaNE = gridView.outerDiv.find(".wijmo-wijgrid-split-area-ne");
				areaSW = gridView.outerDiv.find(".wijmo-wijgrid-split-area-sw");
				areaSE = gridView.outerDiv.find(".wijmo-wijgrid-split-area-se");

				// update splits bounds:
				areaNW.height(o.splitDistanceY);
				areaNE.height(o.splitDistanceY);
				//if (gridView.$topPagerDiv !== null) {
				//	areaNE.css("top", gridView.$topPagerDiv.outerHeight(true) + "px");
				if (gridView.$superPanelHeader !== null) {
					areaNE.css("top", gridView.$superPanelHeader.outerHeight(true) + "px");
				}
				//this.element.find(".wijmo-wijgrid-split-area-sw").height(controlHeight - o.splitDistanceY - (!o.splits ? horScrollBarSize : 0)).css("top", o.splitDistanceY);
				//modified by Jeffrey on 21st Feb 2011
				//the height of areaSW is supposed to match that of areaSE
				//areaSW.height(controlHeight - o.splitDistanceY).css("top", o.splitDistanceY);
				if (!gridView._autoHeight) {
					areaSW.height(controlHeight - o.splitDistanceY);
				}
				else {
					areaSW.height(controlHeight);
				}
				areaSW.css("top", o.splitDistanceY);
				//end by Jeffrey
				areaNW.width(o.splitDistanceX);
				areaSW.width(o.splitDistanceX);

				//areaNE.width(controlWidth - o.splitDistanceX - (!o.splits ? verScrollBarSize : 0)).css("left", o.splitDistanceX); //-17 is for scrollbars

				//this.element.find(".wijmo-wijgrid-split-area-se").height(controlHeight - o.splitDistanceY).css("top", o.splitDistanceY);
				//this.element.find(".wijmo-wijgrid-split-area-se").width(controlWidth - o.splitDistanceX).css("left", o.splitDistanceX);
				areaSE.css("marginLeft", o.splitDistanceX);
				areaSE.css("marginTop", o.splitDistanceY);
				//alert("kk?" + (controlWidth - o.splitDistanceX - (!o.splits ? verScrollBarSize : 0)));
				//ui-wijgrid-split-area-se ui-wijgrid-content-area
			};

			this.render = function (updateMode) {
				var visibleLeaves = gridView._field("visibleLeaves"),
					docFragment = document.createDocumentFragment(),
					spanTable = gridView._field("spanTable"),
					staticRowIndex = gridView._getRealStaticRowIndex(),
					staticColumnIndex = gridView._staticColumnIndex,
					tHeads = {},
					width, ri, height,
					dataRow, dataRowLen,
					leftDomRow, rightDomRow,
					thX, ci, span, $domCell,
					i, len, leaf,
					correspondTables, key, colGroup, col, table,
					data,
					tBodies = {},
					staticDataRowIndex, rowLen,
					cellLen, dataIndex, cellIndex, doBreak, $container, cellValue, dataValue,
					nwArea, neArea, swArea, seArea,
					cellAttr, cellStyle, rowInfo,
					dataRowIndex = -1,
					virtualDataItemIndexBase = 0,
					$rt = $.wijmo.wijgrid.rowType,
					$rs = $.wijmo.wijgrid.renderState,
					isDataRow;

				_viewTables.nw = docFragment.appendChild(document.createElement("table"));
				_viewTables.ne = docFragment.appendChild(document.createElement("table"));
				_viewTables.sw = docFragment.appendChild(document.createElement("table"));
				// docFragment.appendChild(document.createElement("table"));
				$(docFragment).append(gridView.element);
				_viewTables.se = gridView.element[0];

				// create header
				if (spanTable && spanTable.length) {
					tHeads.nw = _viewTables.nw.createTHead();
					tHeads.ne = _viewTables.ne.createTHead();
					/*tHeads.sw = _viewTables.sw.createTHead(); // <-- user can fix the whole header only, not a random row.
					tHeads.sw = _viewTables.se.createTHead();*/

					width = spanTable[0].length;

					for (ri = 0, height = spanTable.length; ri < height; ri++) {
						leftDomRow = null;
						rightDomRow = null;

						//if (ri <= staticRowIndex) {
						// now header rows are always fixed by design, so we can create header cells inside the fixed areas (nw + ne) only.
						//leftDomRow = tHeads.nw.insertRow(-1);
						//rightDomRow = tHeads.ne.insertRow(-1);
						leftDomRow = gridView._createRow(tHeads.nw, $rt.header, ri);
						rightDomRow = gridView._createRow(tHeads.ne, $rt.header, ri);
						/*} else {
						leftDomRow = _viewTables["sw"].tHead.insertRow(-1);
						rightDomRow = _viewTables["se"].tHead.insertRow(-1);
						}*/

						rowInfo = gridView._createRowInfo([leftDomRow, rightDomRow], $rt.header, $rs.rendering, -1, -1, -1, -1);

						thX = 0;

						for (ci = 0; ci < width; ci++) {
							span = spanTable[ri][ci];

							if (span.column && span.column.parentVis) {
								span.column.thX = thX++;
								span.column.thY = ri;

								//$domCell = $("<th><div class=\"wijmo-wijgrid-innercell\"></div></th>");
								$domCell = $(gridView._createCell($rt.header, ri, ci));

								$container = $domCell.children("div");

								if (ci <= staticColumnIndex) {
									leftDomRow.appendChild($domCell[0]);
								} else {
									rightDomRow.appendChild($domCell[0]);
								}

								gridView.cellFormatter.format($container, span.column, span.column.headerText, rowInfo);
								gridView._cellCreated($domCell, ci, span.column, rowInfo, $rs.rendering, { colSpan: span.colSpan, rowSpan: span.rowSpan });
							} // end if
						} // for ci

						gridView._rowCreated(rowInfo);
					} // for ri

				} // end if
				// create header end

				// create filter -- now only the whole header can be fixed by design, so the tHeads can contain only "nw" or (and) "ne" keys.
				if (gridView.options.showFilter) {
					if (tHeads.nw) { // fixed columns area
						//leftDomRow = tHeads.nw.insertRow(-1);
						leftDomRow = gridView._createRow(tHeads.nw, $rt.filter, -1);
					}

					if (tHeads.ne) { // unfixed columns area
						//rightDomRow = tHeads.ne.insertRow(-1);
						rightDomRow = gridView._createRow(tHeads.ne, $rt.filter, -1);
					}

					rowInfo = gridView._createRowInfo([leftDomRow, rightDomRow], $rt.filter, $rs.rendering, -1, -1, -1, -1);

					for (i = 0, len = visibleLeaves.length; i < len; i++) {
						leaf = visibleLeaves[i];

						/*$domCell = (i <= staticColumnIndex)
						? $(leftDomRow.insertCell(-1))
						: $(rightDomRow.insertCell(-1));*/
						$domCell = $(gridView._createCell($rt.filter, undefined, i));

						if (i <= staticColumnIndex) {
							leftDomRow.appendChild($domCell[0]);
						} else {
							rightDomRow.appendChild($domCell[0]);
						}

						gridView.cellFormatter.format($domCell, leaf, leaf.filterValue, rowInfo);
						gridView._cellCreated($domCell, i, leaf, rowInfo, $rs.rendering);
					}

					gridView._rowCreated(rowInfo);
				}
				// create filter end

				// colgroup

				// nw - sw
				correspondTables = { t0: _viewTables.nw, t1: _viewTables.sw };
				for (key in correspondTables) {
					if (correspondTables.hasOwnProperty(key)) {
						colGroup = document.createElement("colgroup");
						for (i = 0; i <= staticColumnIndex; i++) {
							col = document.createElement("col");
							colGroup.appendChild(col);
						}
						table = correspondTables[key];
						table.appendChild(colGroup);
					}
				}

				// ne - se
				correspondTables = { t0: _viewTables.ne, t1: _viewTables.se };
				for (key in correspondTables) {
					if (correspondTables.hasOwnProperty(key)) {
						colGroup = document.createElement("colgroup");
						for (i = staticColumnIndex + 1; i < visibleLeaves.length; i++) {
							col = document.createElement("col");
							colGroup.appendChild(col);
						}
						table = correspondTables[key];
						table.appendChild(colGroup);
					}
				}
				// end colgroup

				// create body **
				data = gridView.dataTable;

				tBodies = {};
				tBodies.nw = $.wijmo.wijgrid.ensureTBody(_viewTables.nw);
				tBodies.ne = $.wijmo.wijgrid.ensureTBody(_viewTables.ne);
				tBodies.sw = $.wijmo.wijgrid.ensureTBody(_viewTables.sw);
				tBodies.se = $.wijmo.wijgrid.ensureTBody(_viewTables.se);

				staticDataRowIndex = staticRowIndex - (spanTable.length + (gridView.options.showFilter ? 1 : 0));

				if (gridView._dataStore.dataMode() === $.wijmo.wijgrid.dataMode.dynamical) {
					virtualDataItemIndexBase = gridView.options.pageIndex * gridView.options.pageSize;
				}

				// render rows
				for (ri = 0, rowLen = data.length; ri < rowLen; ri++) {
					dataRow = data[ri];
					dataRowLen = dataRow.length;
					isDataRow = (dataRow.rowType & $rt.data) !== 0;

					leftDomRow = null;
					rightDomRow = null;

					if (ri <= staticDataRowIndex) {
						//leftDomRow = tBodies.nw.insertRow(-1);
						//rightDomRow = tBodies.ne.insertRow(-1);
						leftDomRow = gridView._createRow(tBodies.nw, dataRow.rowType, dataRow.originalRowIndex);
						rightDomRow = gridView._createRow(tBodies.ne, dataRow.rowType, dataRow.originalRowIndex);
					} else {
						//leftDomRow = tBodies.sw.insertRow(-1);
						//rightDomRow = tBodies.se.insertRow(-1);
						leftDomRow = gridView._createRow(tBodies.sw, dataRow.rowType, dataRow.originalRowIndex);
						rightDomRow = gridView._createRow(tBodies.se, dataRow.rowType, dataRow.originalRowIndex);
					}

					rowInfo = gridView._createRowInfo([leftDomRow, rightDomRow], dataRow.rowType, $rs.rendering,
						ri,
						isDataRow ? ++dataRowIndex : -1,
						isDataRow ? dataRow.originalRowIndex : -1,
						isDataRow ? virtualDataItemIndexBase + dataRow.originalRowIndex : -1);

					// render cells
					for (ci = 0, cellLen = visibleLeaves.length; ci < cellLen; ci++) {
						leaf = visibleLeaves[ci];
						dataIndex = leaf.dataIndex;

						cellIndex = 0;
						doBreak = false;

						switch (dataRow.rowType) {
							case $rt.data:
							case $rt.data | $rt.dataAlt:
								cellIndex = dataIndex; // use [leaf -> data] mapping

								if (cellIndex >= 0 && (!dataRow[cellIndex] || (dataRow[cellIndex].visible === false))) {
									continue; // spanned cell ?
								}
								break;

							case $rt.emptyDataRow:
							case $rt.groupHeader:
							case $rt.groupFooter:
								cellIndex = ci; // just iterate through all dataRow cells.

								if (cellIndex >= dataRowLen) {
									doBreak = true; // don't extend group headers\ footers with additional cells
								}
								break;
						}

						if (doBreak) {
							break;
						}

						//$domCell = $("<td><div class=\"wijmo-wijgrid-innercell\"></div></td>");
						$domCell = $(gridView._createCell(dataRow.rowType, dataRow.originalRowIndex, cellIndex));

						$container = $domCell.children("div");

						if (ci <= staticColumnIndex) {
							leftDomRow.appendChild($domCell[0]);
						} else {
							rightDomRow.appendChild($domCell[0]);
						}

						if ((dataRow.rowType & $rt.data) && leaf.dataParser) {
							cellValue = null;

							if (cellIndex >= 0) { // cellIndex is equal to leaf.dataIndex here
								dataValue = dataRow[cellIndex].value;
								cellValue = gridView._toStr(leaf, dataValue);

							} else { // unbound column
							}

							gridView.cellFormatter.format($container, leaf, cellValue, rowInfo);
						} else {
							if (cellIndex >= 0) {
								$container.html(dataRow[cellIndex].html); // use original html
							}
						}

						cellAttr = (cellIndex >= 0) ? dataRow[cellIndex].__attr : null;
						cellStyle = (cellIndex >= 0) ? dataRow[cellIndex].__style : null;

						gridView._cellCreated($domCell, ci, leaf, rowInfo, $rs.rendering, cellAttr, cellStyle);
					} // for ci

					if (ri <= staticDataRowIndex) {
						if (!leftDomRow.cells.length) {
							tBodies.nw.removeChild(leftDomRow);
							leftDomRow = null;
						}

						if (!rightDomRow.cells.length) {
							tBodies.ne.removeChild(rightDomRow);
							rightDomRow = null;
						}

						if (leftDomRow || rightDomRow) {
							gridView._rowCreated(rowInfo, dataRow.__attr, dataRow.__style);
						}
					} else {
						if (!leftDomRow.cells.length) {
							tBodies.sw.removeChild(leftDomRow);
							leftDomRow = null;
						}

						if (!rightDomRow.cells.length) {
							tBodies.se.removeChild(rightDomRow);
							rightDomRow = null;
						}

						if (leftDomRow || rightDomRow) {
							gridView._rowCreated(rowInfo, dataRow.__attr, dataRow.__style);
						}
					}
				} // for ri
				// ** create body

				// create footer **
				if (gridView.options.showFooter) {
					//leftDomRow = _viewTables.sw.createTFoot().insertRow(-1);
					//rightDomRow = _viewTables.se.createTFoot().insertRow(-1);
					leftDomRow = gridView._createRow(_viewTables.sw.createTFoot(), $rt.footer, -1);
					rightDomRow = gridView._createRow(_viewTables.se.createTFoot(), $rt.footer, -1);

					rowInfo = gridView._createRowInfo([leftDomRow, rightDomRow], $rt.footer, $rs.rendering, -1, -1, -1, -1);

					for (ci = 0, cellLen = visibleLeaves.length; ci < cellLen; ci++) {
						leaf = visibleLeaves[ci];

						//$domCell = $("<td><div class=\"wijmo-wijgrid-innercell\"></div></td>");
						$domCell = $(gridView._createCell($rt.footer, undefined, ci));

						$container = $domCell.children("div");

						if (ci <= staticColumnIndex) {
							leftDomRow.appendChild($domCell[0]);
						} else {
							rightDomRow.appendChild($domCell[0]);
						}

						gridView.cellFormatter.format($container, leaf, "", rowInfo);
						gridView._cellCreated($domCell, i, leaf, rowInfo, $rs.rendering);
					}

					gridView._rowCreated(rowInfo);
				}
				// ** create footer

				nwArea = gridView.outerDiv.find(".wijmo-wijgrid-split-area-nw");
				neArea = gridView.outerDiv.find(".wijmo-wijgrid-split-area-ne");
				swArea = gridView.outerDiv.find(".wijmo-wijgrid-split-area-sw");
				seArea = gridView.outerDiv.find(".wijmo-wijgrid-content-area");

				nwArea[0].innerHTML = "";
				neArea[0].innerHTML = "";
				swArea[0].innerHTML = "";
				seArea[0].innerHTML = "";

				//alert("staticRowIndex=" + staticRowIndex + "\n" + _viewTables['se'].innerHTML);
				/* Note, empty() throws exception */
				$(_viewTables.nw).appendTo(nwArea);
				$(_viewTables.ne).appendTo(neArea);
				$(_viewTables.sw).appendTo(swArea);
				$(_viewTables.se).appendTo(seArea);

				postRender();
			};

			this.attachEvents = function () {
			};

			this.updateCss = function () {
			};

			// array of a htmlTableAccessor instances
			this.subTables = function () {
				//return [_dataTable];/*todo*/
				return [_table00, _table01, _table10, _table11];
			};

			this.focusableElement = function () {
				return _table11.element();
			};

			this.forEachRowCell = function (rowIndex, callback, param) {
				var joinedTables = this.getJoinedTables(false, rowIndex),
					table0 = joinedTables[0],
					table1 = joinedTables[1],
					relIdx, callbackResult;

				if (table0 !== null) {
					relIdx = joinedTables[2];
					if (relIdx < table0.element().rows.length) {
						callbackResult = table0.forEachRowCell(relIdx, callback, param);
						if (callbackResult !== true) {
							return callbackResult;
						}
					}
					if ((table1 !== null) && (relIdx < table1.element().rows.length)) {
						callbackResult = table1.forEachRowCell(relIdx, callback, param);
						if (callbackResult !== true) {
							return callbackResult;
						}
					}
				}

				return true;
			};

			this.forEachColumnCell = function (columnIndex, callback, param) {
				var joinedTables = this.getJoinedTables(true, columnIndex),
					relIdx, callbackRes;

				if (joinedTables[0] !== null) {
					relIdx = joinedTables[2];
					callbackRes = joinedTables[0].forEachColumnCell(relIdx, callback, param);
					if (callbackRes !== true) {
						return callbackRes;
					}

					if (joinedTables[1] !== null) {
						callbackRes = joinedTables[1].forEachColumnCell(relIdx, callback, param);
						if (callbackRes !== true) {
							return callbackRes;
						}
					}
				}

				return true;
			};

			this.ensureWidth = function (width, index) {
				if (arguments.length > 0) {
					this.setColumnWidth(index, width);
				}
				this.refreshPanel();
			};

			this.getCell = function (absColIdx, absRowIdx) {
				var joinedTablesRow = this.getJoinedTables(false, absRowIdx),
					joinedTablesCol, relRowIdx, relColIdx, table, cellIdx;

				if (joinedTablesRow[0] !== null) {
					joinedTablesCol = this.getJoinedTables(true, absColIdx);
					if (joinedTablesCol[0] !== null) {
						relRowIdx = joinedTablesRow[2];
						relColIdx = joinedTablesCol[2];

						table = null;
						if (joinedTablesRow[1] !== null) {
							table = (absColIdx === relColIdx) ? joinedTablesRow[0] : joinedTablesRow[1];
						}
						else {
							table = joinedTablesRow[0];
						}

						cellIdx = table.getCellIdx(relColIdx, relRowIdx);
						if (cellIdx >= 0) {
							return table.element().rows[relRowIdx].cells[cellIdx];
						}
					}
				}

				return null;
			};

			this.getColumnIndex = function (cell) {
				var owner = null,
					htmlTable = null,
					flag = false,
					colIdx;

				for (owner = cell.parentNode; owner.tagName.toLowerCase() !== "table"; owner = owner.parentNode) {
				}

				if (owner !== null) {
					if (owner === _table00.element()) {
						htmlTable = _table00;
					}
					else {
						if (owner === _table01.element()) {
							htmlTable = _table01;
							flag = true;
						}
						else {
							if (owner === _table10.element()) {
								htmlTable = _table10;
							}
							else {
								if (owner === _table11.element()) {
									htmlTable = _table11;
									flag = true;
								}
							}
						}
					}

					if (htmlTable !== null) {
						colIdx = htmlTable.getColumnIdx(cell);
						if (flag) {
							colIdx += gridView._staticColumnIndex + 1;
						}
						return colIdx;
					}
				}

				return -1;
			};

			this.getAbsoluteRowIndex = function (domRow) {
				var index = domRow.rowIndex,
					table = domRow.parentNode;

				while (table.tagName.toLowerCase() !== "table") {
					table = table.parentNode;
				}

				//return (table == _table00.element() || table == _table01.element()) ? index : index + gridView.options.staticRowIndex + 1;
				return (table === _table00.element() || table === _table01.element()) ? index : index + gridView._getRealStaticRowIndex() + 1;
			};

			this.getJoinedCols = function (columnIndex) {
				var result = [],
					joinedTables = this.getJoinedTables(true, columnIndex);

				joinedTables.splice(joinedTables.length - 1, 1);
				$.each(joinedTables, function (index, table) {
					result.push($(table.element()).find("col")[columnIndex]);
				});

				return result;
			};

			this.getJoinedRows = function (index, scope) {
				var row0 = null, row1 = null,
					table0 = null, table1 = null,
					fixedRowIdx = gridView._getRealStaticRowIndex(),
					fixedColIdx = gridView._staticColumnIndex,
					lastColIdx = gridView._field("leaves").length - 1,
					lastRowIdx = _rowsCount - 1,
					allRowsFixed = (fixedRowIdx === lastRowIdx),
					allsRowUnfixed = (fixedRowIdx < 0),
					rowsFixedSlice = !allRowsFixed && !allsRowUnfixed,
					sectionLength = 0;

				if (allRowsFixed || rowsFixedSlice) {
					if (fixedColIdx >= 0 && fixedColIdx < lastColIdx) {
						table0 = _table00;
						table1 = _table01;
					}
					else {
						table0 = (fixedColIdx < 0) ? _table01 : _table00;
					}
					sectionLength = table0.getSectionLength(scope);
					if (index < sectionLength) {
						row0 = table0.getSectionRow(index, scope);
						if (table1 !== null) {
							row1 = table1.getSectionRow(index, scope);
						}
					}
				}

				if (allsRowUnfixed || (rowsFixedSlice && (row0 === null))) {
					if (!allsRowUnfixed) {
						index -= sectionLength;
					}

					if (fixedColIdx >= 0 && fixedColIdx < lastColIdx) {
						table0 = _table10;
						table1 = _table11;
					}
					else {
						table0 = (fixedColIdx < 0) ? _table11 : _table10;
					}

					row0 = table0.getSectionRow(index, scope);

					if (table1 !== null) {
						row1 = table1.getSectionRow(index, scope);
					}
				}

				return (row0 === null && row1 === null) ? null : [row0, row1];
			};

			this.getJoinedTables = function (byColumn, index) {
				var t0 = null,
					t1 = null,
					idx = index,
				//var fixedRowIdx = gridView.options.staticRowIndex;
					fixedRowIdx = gridView._getRealStaticRowIndex(),
					fixedColIdx = gridView._staticColumnIndex; //gridView.options.staticColumnIndex; //YK

				if (byColumn) {
					if (index <= fixedColIdx) {
						t0 = _table00;
						t1 = _table10;
					}
					else {
						t0 = _table01;
						t1 = _table11;

						idx = idx - (fixedColIdx + 1);
					}

					if (fixedRowIdx < 0) {
						t0 = null;
					}

					if (fixedRowIdx === _rowsCount - 1) // fixed row is the last row
					{
						t1 = null;
					}
				}
				else {
					if (index <= fixedRowIdx) {
						t0 = _table00;
						t1 = _table01;
					}
					else {
						t0 = _table10;
						t1 = _table11;

						idx = idx - (fixedRowIdx + 1);
					}

					if (fixedColIdx < 0) {
						t0 = null;
					}
					if (fixedColIdx === gridView._field("leaves").length - 1) {
						t1 = null;
					}
				}

				if (t0 === null) {
					t0 = t1;
					t1 = null;
				}
				return [t0, t1, idx];
			};

			this.getHeaderCell = function (absColIdx) {
				var leaf = gridView._field("visibleLeaves")[absColIdx],
					headerRow;

				if (leaf && (headerRow = gridView._headerRows())) {
					return new $.wijmo.wijgrid.rowAccessor().getCell(headerRow.item(leaf.thY), leaf.thX);
				}

				return null;
			};

			this.getAbsCellInfo = function (cell) {
				return new $.wijmo.wijgrid.cellInfo(this.getColumnIndex(cell), this.getAbsoluteRowIndex(cell.parentNode));
			};

			this.getVisibleAreaBounds = function () {
				return $.wijmo.wijgrid.bounds(gridView.outerDiv.find(".wijmo-wijsuperpanel-contentwrapper:first"));
			};

			/*
			this.adjustColumnSizes = function(topTable, bottomTable) {
			if (topTable.rows.length > 0 && bottomTable.rows.length > 0) {
			var topRowCells = topTable.rows[0].cells;
			var bottomRowCells = bottomTable.rows[0].cells;
			if (topRowCells.length == bottomRowCells.length) {
			for (var i = 0; i < topRowCells.length; i++) {
			topRowCells[i].style.width = bottomRowCells[i].style.width = Math.max(topRowCells[i].offsetWidth, bottomRowCells[i].offsetWidth);
			}
			}
			}

			topTable.style.width = bottomTable.style.width = Math.max(topTable.offsetWidth, bottomTable.offsetWidth) + "px";
			//alert(topTable.style.width + "?w=" + Math.max(topTable.offsetWidth, bottomTable.offsetWidth));

			topTable.style.tableLayout = "fixed";
			bottomTable.style.tableLayout = "fixed";
			};
			*/

			this.adjustCellsSizes = function () {
				//$.wijmo.wijgrid.rowAccessor = function (view, scope, offsetTop, offsetBottom)
				var accessor = new $.wijmo.wijgrid.rowAccessor(this, 9/*all*/, 0),
					rowLen = accessor.length(),
					heights = [], // int[rowLen];
					i, j, rowObj,
					row0, len0, row0Span, row0h,
					row1, len1, row1Span, row1h,
					row;

				for (i = 0; i < rowLen; i++) {
					rowObj = this.getJoinedRows(i, 9/*all*/); // = accessor[i];

					row0 = rowObj[0];
					len0 = (row0 !== null) ? row0.cells.length : 0;
					row0Span = false;

					for (j = 0; j < len0 && !row0Span; j++) {
						row0Span = (row0.cells[j].rowSpan > 1);
					}

					row1 = rowObj[1];
					len1 = (row1 !== null) ? row1.cells.length : 0;
					row1Span = false;

					if (!row0Span) {
						for (j = 0; j < len1 && !row1Span; j++) {
							row1Span = (row1.cells[j].rowSpan > 1);
						}
					}

					row0h = (row0 !== null && len0 > 0) ? row0.offsetHeight : 0;
					row1h = (row1 !== null && len1 > 0) ? row1.offsetHeight : 0;

					heights[i] = (row0Span || row1Span) ? Math.min(row0h, row1h) : Math.max(row0h, row1h);
				}

				for (i = 0; i < rowLen; i++) {
					row = this.getJoinedRows(i, 9/*all*/); // = accessor[i];
					accessor.iterateCells(row, this.setCellContentDivHeight, heights[i]);
				}
			};

			this.setCellContentDivHeight = function (cell, param) {
				cell.style.height = param + "px";
				return true;
			};

			// private
			function postRender() {
				var key;

				for (key in _viewTables) {
					if (_viewTables.hasOwnProperty(key)) {
						$(_viewTables[key])
							.addClass("wijmo-wijgrid-table")
							.attr("role", "grid")
							.find("> tbody")
								.addClass("ui-widget-content wijmo-wijgrid-data");
					}
				}

				_table00 = new $.wijmo.wijgrid.htmlTableAccessor(_viewTables.nw);
				_table01 = new $.wijmo.wijgrid.htmlTableAccessor(_viewTables.ne);
				_table10 = new $.wijmo.wijgrid.htmlTableAccessor(_viewTables.sw);
				_table11 = new $.wijmo.wijgrid.htmlTableAccessor(_viewTables.se);

				_rowsCount = Math.max(_viewTables.nw.rows.length, _viewTables.ne.rows.length) +
					Math.max(_viewTables.sw.rows.length, _viewTables.se.rows.length);

				// use separate instead of collapse to avoid a disalignment issue in chrome.
				$(_viewTables.ne)
					.attr({ "cellpadding": "0", "border": "0", "cellspacing": "0" })
					.css("border-collapse", "separate");

				$(_viewTables.se)
					.attr({ "cellpadding": "0", "border": "0", "cellspacing": "0" })
					.css("border-collapse", "separate");
			}
			// private
		}
	});
})(jQuery);(function ($) {
	"use strict";
	$.extend($.wijmo.wijgrid, {

		resizer: function (gridView) {
			var _elements = [],
				_gap = 10,
				_step = 1,
				_evntFormat = "{0}." + gridView.widgetName + ".resizer",
				_inProgress = false,
				_hoveredField = null,
				_docCursor,
				_startLocation = null,
				_lastLocation = null,
				_proxy = null;

			this.addElement = function (c1basefield) {
				if (c1basefield && c1basefield.element) {
					c1basefield.element
					.bind(eventKey("mousemove"), _onMouseMove)
					.bind(eventKey("mousedown"), _onMouseDown)
					.bind(eventKey("mouseout"), _onMouseOut);

					_elements.push(c1basefield);
				}
			};

			this.dispose = function () {
				$.each(_elements, function (index, c1basefield) {
					c1basefield.element
						.unbind(eventKey("mousemove"), _onMouseMove)
						.unbind(eventKey("mousedown"), _onMouseDown)
						.unbind(eventKey("mouseout"), _onMouseOut);
				});

				detachDocEvents();
			};

			this.inProgress = function () {
				return _inProgress;
			};

			function _onMouseMove(e) {
				if (!_inProgress) {
					var hoveredField = getFieldByPos({ x: e.pageX, y: e.pageY });
					if (hoveredField && hoveredField._canSize() && gridView._canInteract()) {
						hoveredField.element.css("cursor", "e-resize");
						//hoveredField.element.find("> a").css("cursor", "e-resize");
						_hoveredField = hoveredField;
					} else {
						_onMouseOut(e);
					}
				}
			}

			function _onMouseOut(e) {
				if (!_inProgress) {
					if (_hoveredField) {
						_hoveredField.element.css("cursor", "");
						//_hoveredField.element.find("> a").css("cursor", "");
						_hoveredField = null;
					}
				}
			}

			function _onMouseDown(e) {
				_hoveredField = getFieldByPos({ x: e.pageX, y: e.pageY });
				if (_hoveredField && _hoveredField._canSize() && gridView._canInteract()) {
					try {
						_hoveredField.element.css("cursor", "");
						//_hoveredField.element.find("> a").css("cursor", "");

						_docCursor = document.body.style.cursor;
						document.body.style.cursor = "e-resize";
						_startLocation = _lastLocation = $.wijmo.wijgrid.bounds(_hoveredField.element);

						_proxy = $("<div class=\"wijmo-wijgrid-resizehandle ui-state-highlight\">&nbsp;</div>");

						_proxy.css({ "left": e.pageX, "top": _startLocation.top,
							"height": gridView._view().getVisibleAreaBounds().height/* - _hoveredField.element[0].offsetTop*/
						});

						$(document.body).append(_proxy);
					}
					finally {
						attachDocEvents();
						_inProgress = true;
					}
				}
			}

			function _onDocumentMouseMove(e) {
				var deltaX = _step * Math.round((e.pageX - _lastLocation.left) / _step);

				_lastLocation = { left: _lastLocation.left + deltaX, top: e.pageY };
				_proxy.css("left", _lastLocation.left);
			}

			function _onDocumentMouseUp(e) {
				try {
					document.body.style.cursor = _docCursor;

					// destroy proxy object
					_proxy.remove();

					if (_startLocation !== _lastLocation) {
						gridView._fieldResized(_hoveredField, _startLocation.width, _lastLocation.left - _startLocation.left);
					}
				}
				finally {
					_hoveredField = null;
					_proxy = null;
					detachDocEvents();
					_inProgress = false;
				}
			}

			function _onSelectStart(e) {
				e.preventDefault();
			}

			function attachDocEvents() {
				if (!_inProgress) {
					$(document)
						.bind(eventKey("mousemove"), _onDocumentMouseMove)
						.bind(eventKey("mouseup"), _onDocumentMouseUp);

					$(document.body).disableSelection();

					if ($.browser.msie) {
						$(document.body).bind("selectstart", _onSelectStart);
					}
				}
			}

			function detachDocEvents() {
				if (_inProgress) {
					$(document)
						.unbind(eventKey("mousemove"), _onDocumentMouseMove)
						.unbind(eventKey("mouseup"), _onDocumentMouseUp);

					$(document.body).enableSelection();
					if ($.browser.msie) {
						$(document.body).unbind("selectstart", _onSelectStart);
					}
				}
			}

			function getFieldByPos(mouse) {
				var i, len, c1basefield, bounds, res;

				for (i = 0, len = _elements.length; i < len; i++) {
					c1basefield = _elements[i];
					bounds = $.wijmo.wijgrid.bounds(c1basefield.element);

					res = $.ui.isOver(mouse.y, mouse.x,
					bounds.top, bounds.left + bounds.width - _gap,
					bounds.height, _gap);

					if (res) {
						return c1basefield;
					}
				}

				return null;
			}

			function eventKey(eventType) {
				return $.wijmo.wijgrid.stringFormat(_evntFormat, eventType);
			}
		}
	});
})(jQuery);(function ($) {
	"use strict";
	$.extend($.wijmo.wijgrid, {
		cellFormatterHelper: function () {
			this.format = function ($container, column, formattedValue, rowInfo) {
				if (rowInfo.type & $.wijmo.wijgrid.rowType.footer) {
					if (column.aggregate && (column.aggregate !== "none"))  {
						formattedValue = $.wijmo.wijgrid.stringFormat(column.footerText || "{0}", column._totalsValue || "");
					} else {
						formattedValue = column.footerText || column._footerTextDOM || "";
					}
				}

				var useDefault = true,
					defaultFormatter = null,
					args = {
						$container: $container,
						column: column,
						formattedValue: formattedValue,
						row: rowInfo,
						afterDefaultCallback: null
					};

				if ($.isFunction(column.cellFormatter)) {
					useDefault = !column.cellFormatter(args);
				}

				if (useDefault) {
					switch (column.dataType) {
						case "boolean":
							defaultFormatter = boolFormatter;
							break;

						default:
							defaultFormatter = textFormatter;
					}

					if (defaultFormatter) {
						defaultFormatter(args);

						if ($.isFunction(args.afterDefaultCallback)) {
							args.afterDefaultCallback(args);
						}
					}
				}
			};

			// * private
			function textFormatter(args) {
				switch (args.row.type) {
					case $.wijmo.wijgrid.rowType.filter:
						defFormatFilterCell(args);
						break;

					default:
						args.$container.html(args.formattedValue ? args.formattedValue : "&nbsp;");
				}
			}

			function boolFormatter(args) {
				var grid, allowEditing, disableStr = "disabled='disabled'", targetElement, currentCell,
					$rt = $.wijmo.wijgrid.rowType;

				switch (args.row.type) {
					case $rt.data:
					case $rt.data | $rt.dataAlt:
						grid = args.column.owner;
						allowEditing = grid.options.allowEditing && (args.column.readOnly !== true);

						if (allowEditing) {
							disableStr = "";
						}

						if (grid._parse(args.column, args.row.data[args.column.dataKey]) === true) {
							args.$container.html("<input class='wijgridinput' type='checkbox' checked='checked' " + disableStr + " />");
						} else {
							args.$container.html("<input class='wijgridinput' type='checkbox' " + disableStr + " />");
						}

						if (allowEditing) {
							args.$container.children("input").bind("mousedown", function (e) {
								targetElement = args.$container.parent()[0];
								currentCell = grid.currentCell();
								if (currentCell.tableCell() !== targetElement) {
									grid._onClick({ target: targetElement });
								}
								if (!currentCell._isEdit()) {
									grid.beginEdit();
								}
							}).bind("keydown", function (e) {
								if (e.which === $.ui.keyCode.ENTER) {
									grid._endEditInternal(e);
									return false;
								}
							});
						}
						break;

					case $rt.filter:
						defFormatFilterCell(args);
						break;
				}
			}

			function defFormatFilterCell(args) {
				if ((args.column.dataIndex >= 0) && !args.column.isBand && args.column.showFilter) {
					args.$container.html("<div class=\"wijmo-wijgrid-filter ui-widget ui-state-default ui-corner-all\"><span class=\"wijmo-wijgrid-filtericon\"></span><input type=\"text\" class=\"wijmo-wijgrid-filter-input\" style=\"width:1px\" /><a class=\"wijmo-wijgrid-filter-trigger ui-corner-right ui-state-default\" href=\"#\"><span class=\"ui-icon ui-icon-triangle-1-s\"></span></a></div>");
				} else {
					args.$container.html("&nbsp;");
				}
			}

			// * private
		}
	});
})(jQuery);(function ($) {
	"use strict";
	$.extend($.wijmo.wijgrid, {
		dragAndDropHelper: function (wijgrid) {
			var _scope_guid = "scope_" + new Date().getTime(),
				_$bottomArrow = null,
				_$topArrow = null,
				_droppableWijField = null, // to use inside the draggable.drag event.
				_dragEnd = false,
				_dropTargetRedirected, // handles the situation when draggable is moved over the non-empty group area, in this case we assume the rightmost header in the group area as droppable instead of group area itself.
				_wrapHtml = "<div class=\"ui-widget wijmo-wijgrid ui-widget-content ui-corner-all\">" +
								"<table class=\"wijmo-wijgrid-root wijmo-wijgrid-table\">" +
									"<tr class=\"wijmo-wijgrid-headerrow\">" +
									"</tr>" +
								 "</table>" +
							"</div>";

			this.attachGroupArea = function (element) {
				var draggedWijField;
				element.droppable({
					scope: _scope_guid,
					tolerance: "pointer",
					greedy: true,

					accept: function (draggable) {
						if (wijgrid.options.allowColMoving) {
							draggedWijField = _getWijFieldInstance(draggable);

							if (draggedWijField) {
								// The rightmost column header in the the group area can't be dragged to the end of the group area again.
								if ((draggedWijField instanceof $.wijmo.c1groupedfield) && (draggedWijField.options.groupedIndex === wijgrid._field("groups").length - 1)) {
									return false;
								}

								return !draggedWijField.options.isBand && (draggedWijField.options.groupedIndex === undefined || (draggedWijField instanceof $.wijmo.c1groupedfield));
							}
						}
						return false;
					},

					drop: function (e, ui) {
						if (!_isInElement(e, ui.draggable) && (draggedWijField = _getWijFieldInstance(ui.draggable))) {
							_dragEnd = true;
						}
					},

					over: function (e, ui) {
						var cnt = wijgrid._field("groupWidgets").length;

						_dropTargetRedirected = (cnt > 0);
						_droppableWijField = (cnt > 0)
							? wijgrid._field("groupWidgets")[cnt - 1] // use the rightmost header as a drop target
							: element; // special case, the drop target is the group area itself

						element.data("thisDroppableWijField", _droppableWijField);
					},

					out: function (e, ui) {
						if (_droppableWijField === element.data("thisDroppableWijField")) {
							_droppableWijField = null;
						}

						//if (draggedWijField = _getWijFieldInstance(ui.draggable)) {
						//	_hideArrows();
						//}
					}
				});
			};

			this.attach = function (wijField) {
				var element, draggedWijField;

				if (!wijField || !(element = wijField.element)) {
					return;
				}

				element
				.draggable({
					helper: function (e) {
						if (wijField instanceof $.wijmo.c1groupedfield) {
							return element
								.clone()
								.addClass("wijmo-wijgrid-dnd-helper");
						} else {
							return element
								.clone()
								.wrap(_wrapHtml)
								.width(element.width())
								.height(element.height())
								.closest(".wijmo-wijgrid")
								.addClass("wijmo-wijgrid-dnd-helper");

							/*return element
							.clone()
							.width(element.width())
							.height(element.height())
							.addClass("wijmo-wijgrid-dnd-helper");*/
						}
					},

					appendTo: "body",
					//cursor: "pointer",
					scope: _scope_guid,

					drag: function (e, ui) {
						_hideArrows();

						if (_droppableWijField && !_isInElement(e, element)) {
							// indicate insertion position

							var $arrowsTarget = _droppableWijField.element;
							if (!$arrowsTarget) { // _droppableWijField is the group area element
								$arrowsTarget = _droppableWijField;
							}

							_showArrows($arrowsTarget, _getPosition(wijField, _droppableWijField, e, ui));
						}
					},

					start: function (e, ui) {
						if (wijgrid._canInteract() && wijgrid.options.allowColMoving && !wijgrid._field("resizer").inProgress()) {
							//return (wijField._canDrag() === true);

							var column = wijField.options,
								travIdx = wijField.options.travIdx,
								dragInGroup = (wijField instanceof $.wijmo.c1groupedfield),
								dragSource = dragInGroup ? "groupArea" : "columns";

							if (dragInGroup) {
								column = $.wijmo.wijgrid.search(wijgrid.columns(), function (test) {
									return test.options.travIdx === travIdx;
								});

								column = (!column.found) // grouped column is invisible?
									? $.wijmo.wijgrid.getColumnByTravIdx(wijgrid.options.columns, travIdx).found
									: column.found.options;
							}

							if (wijField._canDrag() && wijgrid._trigger("columnDragging", null, { drag: column, dragSource: dragSource })) {
								wijgrid._trigger("columnDragged", null, { drag: column, dragSource: dragSource });
								return true;
							}
						}

						return false;
					},

					stop: function (e, ui) {
						_hideArrows();

						try {
							if (_dragEnd) {
								if (!_droppableWijField.element) { // _droppableWijField is the group area element
									wijgrid._handleDragnDrop(wijField.options.travIdx,
											-1,
											"left",
											wijField instanceof $.wijmo.c1groupedfield,
											true
										);
								} else {
									wijgrid._handleDragnDrop(wijField.options.travIdx,
										_droppableWijField.options.travIdx,
										_getPosition(wijField, _droppableWijField, e, ui),
										wijField instanceof $.wijmo.c1groupedfield,
										_droppableWijField instanceof $.wijmo.c1groupedfield
									);
								}
							}
						}
						finally {
							_droppableWijField = null;
							_dragEnd = false;
						}
					}
				}) // ~draggable

				.droppable({
					hoverClass: "ui-state-hover",
					scope: _scope_guid,
					tolerance: "pointer",
					greedy: true,

					accept: function (draggable) {
						if (wijgrid.options.allowColMoving) {
							if (element[0] !== draggable[0]) { // different DOM elements
								draggedWijField = _getWijFieldInstance(draggable); // dragged column

								if (draggedWijField) {
									return draggedWijField._canDropTo(wijField);
								}
							}
						}
						return false;
					},

					drop: function (e, ui) {
						if (draggedWijField = _getWijFieldInstance(ui.draggable)) {
							// As droppable.drop fires before draggable.stop, let draggable to finish action.
							// Otherwise exception is thrown as during re-rendering element bound to draggable will be already deleted.
							_dragEnd = true;

							// an alternative:
							//window.setTimeout(function () {
							//wijgrid._handleDragnDrop(draggedWijField, wijField, _getPosition(draggedWijField, wijField, e, ui));
							//}, 100);
						}
					},

					over: function (e, ui) {
						_dropTargetRedirected = false;
						_droppableWijField = wijField;

						// to track when droppable.over event of other element fires before droppable.out of that element.
						element.data("thisDroppableWijField", _droppableWijField);
					},

					out: function (e, ui) {
						if (_droppableWijField === wijField.element.data("thisDroppableWijField")) {
							_droppableWijField = null;
						}

						//if (draggedWijField = _getWijFieldInstance(ui.draggable)) {
						//	_hideArrows();
						//}
					}
				}); // ~droppable
			};

			this.detach = function (wijField) {
				var element;

				if (wijField && (element = wijField.element)) {
					if (element.data("draggable")) {
						element.draggable("destroy");
					}

					if (element.data("droppable")) {
						element.droppable("destroy");
					}
				}
			};

			this.dispose = function () {
				if (_$topArrow) {
					_$topArrow.remove();
					_$topArrow = null;
				}

				if (_$bottomArrow) {
					_$bottomArrow.remove();
					_$bottomArrow = null;
				}
			};

			// private
			function _getWijFieldInstance(draggable) {
				var widgetName = draggable.data($.wijmo.c1basefield.prototype._data$prefix + "widgetName");
				if (!widgetName) {
					return draggable.data($.wijmo.c1groupedfield.prototype._data$prefix);
				} else {
					return draggable.data(widgetName);
				}
			}

			// position: "left", "right", "center"
			function _showArrows($element, position) {
				_topArrow()
					.show()
					.position({
						my: "center",
						at: position + " top",
						of: $element
					});

				_bottomArrow()
					.show()
					.position({
						my: "center",
						at: position + " bottom",
						of: $element
					});
			}

			function _hideArrows() {
				_topArrow().hide();
				_bottomArrow().hide();
			}

			function _topArrow() {
				if (!_$topArrow) {
					_$topArrow = $("<div />")
						.addClass("wijmo-wijgrid-dnd-arrow-top")
						.append($("<span />").addClass("ui-icon ui-icon-arrowthick-1-s"))
						.hide()
						.appendTo(document.body);
				}

				return _$topArrow;
			}

			function _bottomArrow() {
				if (!_$bottomArrow) {
					_$bottomArrow = $("<div />")
						.addClass("wijmo-wijgrid-dnd-arrow-bottom")
						.append($("<span />").addClass("ui-icon ui-icon-arrowthick-1-n"))
						.hide()
						.appendTo(document.body);
				}

				return _$bottomArrow;
			}

			function _isInElement(e, element) {
				var bounds = $.wijmo.wijgrid.bounds(element, false);
				return ((e.pageX > bounds.left && e.pageX < bounds.left + bounds.width) && (e.pageY > bounds.top && e.pageY < bounds.top + bounds.height));
			}

			function _getPosition(drag, drop, e, dragui) {
				if (!drop.element) { // drop is the group area element
					return "left";
				}

				if (_dropTargetRedirected) {
					return "right";
				}

				var bounds = $.wijmo.wijgrid.bounds(drop.element, false),
					sixth = bounds.width / 6,
					centerX = bounds.left + (bounds.width / 2),
					result = "right",
					distance;

				if (e.pageX < centerX) {
					result = "left";
				}

				if (drop instanceof $.wijmo.c1groupedfield) { // drag is moved over a grouped column
					if (drag instanceof $.wijmo.c1groupedfield) { // drag is a grouped column too
						distance = drop.options.groupedIndex - drag.options.groupedIndex;

						if (Math.abs(distance) === 1) {
							result = (distance < 0)
								? "left"
								: "right";
						}
					}

					return result;
				}

				// both drag and drop are non-grouped columns
				distance = drop.options.linearIdx - drag.options.linearIdx;

				if (drop.options.isBand &&
					(drag.options.parentIdx !== drop.options.travIdx) && // drag is not an immediate child of drop
					(Math.abs(e.pageX - centerX) < sixth)) {
					return "center";
				}

				// drag and drop are contiguous items of the same level
				if (drag.options.parentIdx === drop.options.parentIdx && Math.abs(distance) === 1) {
					result = (distance < 0)
						? "left"
						: "right";
				}

				return result;
			}
			// ~private
		}
	});
})(jQuery);(function ($) {
	"use strict";
	$.extend($.wijmo.wijgrid, {
		cellStyleFormatterHelper: function (wijgrid) {
			if (!wijgrid) {
				throw "invalid arguments";
			}

			this.format = function ($cell, cellIndex, column, rowInfo, state, cellAttr, cellStyle) {
				var $rs = $.wijmo.wijgrid.renderState,
					$rt = $.wijmo.wijgrid.rowType,
					rowType = rowInfo.rowType,
					args;

				if ((cellIndex === 0 && wijgrid.options.showRowHeader) ||
					(rowType === $rt.groupHeader || rowType === $rt.groupFooter)) {
					column = null;
				}

				args = {
					$cell: $cell,
					state: state,
					row: rowInfo,
					column: column,
					_cellIndex: cellIndex
				};

				if (state === $rs.rendering) {
					renderingStateFormatter(args, cellAttr, cellStyle);
				} else {
					currentStateFormatter(args, state & $rs.current);
					//hoveredStateFormatter(args, state & $rs.hovered);
					selectedStateFormatter(args, state & $rs.selected);
				}

				if ($.isFunction(wijgrid.options.cellStyleFormatter)) {
					wijgrid.options.cellStyleFormatter(args);
				}
			};

			// private ---

			function renderingStateFormatter(args, cellAttr, cellStyles) {
				var $rt = $.wijmo.wijgrid.rowType,
					key, value,
					leaf = args.column,
					rowType = args.row.type;

				if (rowType !== $rt.header && rowType !== $rt.filter) {
					args.$cell.addClass("wijgridtd");
				} else if (rowType === $rt.header) {
					args.$cell.addClass("wijgridth");
				}

				// copy attributes
				if (cellAttr) {
					for (key in cellAttr) {
						if (cellAttr.hasOwnProperty(key)) {
							value = cellAttr[key];

							if ((key === "colSpan" || key === "rowSpan") && !(value > 1)) {
								continue;
							}

							if (key === "class") {
								args.$cell.addClass(value);
							} else {
								args.$cell.attr(key, value);
							}
						}
					}
				}

				// copy inline css
				if (cellStyles) {
					for (key in cellStyles) {
						if (cellStyles.hasOwnProperty(key)) {
							if (key === "paddingLeft") { // groupIndent
								args.$cell.children(".wijmo-wijgrid-innercell").css(key, cellStyles[key]);
								continue;
							}
							args.$cell.css(key, cellStyles[key]);
						}
					}
				}

				if (args._cellIndex === 0 && wijgrid.options.showRowHeader) {
					args.$cell
						.attr({ "role": "rowheader", "scope": "row" })
						.addClass(rowType === $rt.header ? "ui-state-default" : "")
						.addClass("wijmo-wijgrid-rowheader");
				} else {
					switch (rowType) {
						case ($rt.header):
							args.$cell.attr({ "role": "columnheader", "scope": "col" });
							break;
						case ($rt.footer):
							args.$cell.attr({ "role": "columnfooter", "scope": "col" });
							break;
						default:
							args.$cell.attr("role", "gridcell");
					}
				}

				//if ((rowType & $rt.data) === $rt.data) {
				if (rowType & $rt.data) {
					if (args._cellIndex >= 0 && leaf && leaf.dataParser) {
						args.$cell.attr("headers", escape(leaf.headerText));

						if (leaf.readOnly) {
							args.$cell.attr("aria-readonly", true);
						}

						if (leaf.dataIndex >= 0) {
							args.$cell.addClass("wijdata-type-" + (leaf.dataType || "string"));
						}
					}
				}
			}

			function currentStateFormatter(args, add) {
				var $rt = $.wijmo.wijgrid.rowType;

				if (add) {
					args.$cell.addClass("ui-state-active");

					if (args.row.type === $rt.header) {
						args.$cell.addClass("wijmo-wijgrid-current-headercell");
					} else {
						args.$cell.addClass("wijmo-wijgrid-current-cell");
					}
				} else {
					args.$cell.removeClass("ui-state-active");

					if (args.row.type === $rt.header) {
						args.$cell.removeClass("wijmo-wijgrid-current-headercell");
					} else {
						args.$cell.removeClass("wijmo-wijgrid-current-cell");
					}
				}
			}

			function hoveredStateFormatter(args, add) {
				if (add) {
				} else {
				}
			}

			function selectedStateFormatter(args, add) {
				if (add) {
					args.$cell
						.addClass("ui-state-highlight")
						.attr("aria-selected", "true");
				} else {
					args.$cell
						.removeClass("ui-state-highlight")
						.removeAttr("aria-selected");
				}
			}

			// --- private
		}
	});
})(jQuery);(function ($) {
	"use strict";
	$.extend($.wijmo.wijgrid, {
		rowStyleFormatterHelper: function (wijgrid) {
			if (!wijgrid) {
				throw "invalid arguments";
			}

			this.format = function (rowInfo, rowAttr, rowStyle) {
				var $rs = $.wijmo.wijgrid.renderState,
					state = rowInfo.state,
					args = rowInfo;

				if (state === $rs.rendering) {
					renderingStateFormatter(args, rowAttr, rowStyle);
				} else {
					currentStateFormatter(args, state & $rs.current);
					hoveredStateFormatter(args, state & $rs.hovered);
					selectedStateFormatter(args, state & $rs.selected);
				}

				if ($.isFunction(wijgrid.options.rowStyleFormatter)) {
					wijgrid.options.rowStyleFormatter(args);
				}
			};

			// * private
			function renderingStateFormatter(args, rowAttr, rowStyle) {
				var className = "wijmo-wijgrid-row ui-widget-content",
					contentClass = "wijmo-wijgrid-row ui-widget-content",
					$rt = $.wijmo.wijgrid.rowType,
					key;

				args.$rows.attr("role", "row");

				// copy attributes
				if (rowAttr) {
					for (key in rowAttr) {
						if (rowAttr.hasOwnProperty(key)) {
							if (key === "class") {
								args.$rows.addClass(rowAttr[key]);
							} else {
								args.$rows.attr(key, rowAttr[key]);
							}
						}
					}
				}

				// copy inline css
				if (rowStyle) {
					for (key in rowStyle) {
						if (rowStyle.hasOwnProperty(key)) {
							args.$rows.css(key, rowStyle[key]);
						}
					}
				}

				switch (args.type & ~$rt.dataAlt) { // clear dataAlt modifier
					case ($rt.header):
						className = "wijmo-wijgrid-headerrow";
						break;

					case ($rt.data):
						className = contentClass + " wijmo-wijgrid-datarow";

						if (args.type & $rt.dataAlt) {
							className += " wijmo-wijgrid-alternatingrow";
						}

						break;

					case ($rt.emptyDataRow):
						className = contentClass + " wijmo-wijgrid-emptydatarow";
						break;

					case ($rt.filter):
						className = "wijmo-wijgrid-filterrow";
						break;

					case ($rt.groupHeader):
						className = contentClass + " wijmo-wijgrid-groupheaderrow";
						break;

					case ($rt.groupFooter):
						className = contentClass + " wijmo-wijgrid-groupfooterrow";
						break;

					case ($rt.footer):
						className = "wijmo-wijgrid-footerrow ui-state-highlight";
						break;

					default:
						throw $.wijmo.wijgrid.stringFormat("unknown rowType: {0}", args.row.type);
				}

				args.$rows.addClass(className);
			}

			function currentStateFormatter(args, flag) {
				if (wijgrid.options.showRowHeader) {
					// make deal with the row header cell
					if (flag) { // add formatting
						$(args.$rows[0].cells[0]).addClass("ui-state-active wijmo-wijgrid-current-rowheadercell");
					} else { // remove formatting
						$(args.$rows[0].cells[0]).removeClass("ui-state-active wijmo-wijgrid-current-rowheadercell");
					}
				}
			}

			function hoveredStateFormatter(args, flag) {
				if (flag) { // add formatting
					args.$rows.addClass("ui-state-hover");
				} else {  // remove formatting
					args.$rows.removeClass("ui-state-hover");
				}
			}

			function selectedStateFormatter(args, flag) {
				if (flag) { // add formatting
				} else { // remove formatting
				}
			}

			// private *
		}
	});
})(jQuery);(function ($) {
	"use strict";
	$.extend($.wijmo.wijgrid, {

		tally: function () {
			var _sum = 0,
				_sum2 = 0,
				_cntNumbers = 0,
				_cntStrings = 0,
				_max = 0,
				_min = 0,
				_minString,
				_maxString;

			this.add = function (value) {
				if (value === null || value === "") {
					return;
				}

				_cntStrings++;

				if (typeof (value) === "string") {

					if ((_minString === undefined) || (value < _minString)) {
						_minString = value;
					}

					if ((_maxString === undefined) || (value > _maxString)) {
						_maxString = value;
					}

					// value = _parseValue(value);
				}

				if (!isNaN(value)) { // number
					if (_cntNumbers === 0) {
						_min = value;
						_max = value;
					}

					_cntNumbers++;
					_sum += value;
					_sum2 += value * value;

					if (value < _min) {
						_min = value;
					}

					if (value > _max) {
						_max = value;
					}
				}
			};

			this.getValueString = function (column) {
				if (_cntNumbers) {
					var value = _getValue(column.aggregate),
						gridView = column.owner;

					return gridView._toStr(column, value);
				}

				if (_cntStrings) {
					// we only support max/min and count for strings
					switch (column.aggregate) {
						case "max":
							return _maxString;

						case "min":
							return _minString;

						case "count":
							return _cntStrings.toString();
					}
				}

				return "";
			};

			function _getValue(aggregate) {
				switch (aggregate) {
					case "average":
						return (_cntNumbers === 0)
							? 0
							: _sum / _cntNumbers;

					case "count":
						return _cntStrings;

					case "max":
						return _max;

					case "min":
						return _min;

					case "sum":
						return _sum;

					case "std":
						if (_cntNumbers <= 1) {
							return 0;
						}

						return Math.sqrt(_getValue("var"));

					case "stdPop":
						if (_cntNumbers <= 1) {
							return 0;
						}

						return Math.sqrt(_getValue("varPop"));

					case "var":
						if (_cntNumbers <= 1) {
							return 0;
						}

						return _getValue("varPop") * _cntNumbers / (_cntNumbers - 1);

					case "vapPop":
						if (_cntNumbers <= 1) {
							return 0;
						}

						var tmp = _sum / _cntNumbers;
						return _sum2 / _cntNumbers - tmp * tmp;
				}

				return 0;
			}

			// strings only
			/*function _parseValue(value) {
			var percent = false,
			len = value.length,
			val;

			if ((len > 0) && (value.indexOf("%") === len - 1)) {
			percent = true;
			value = value.substr(0, len - 1);
			}

			val = parseFloat(value);
			if (isNaN(val)) {
			return NaN;
			}

			return (percent)
			? val / 100 // "12%" -> 0.12f
			: val;
			}*/
		}
	});
})(jQuery);(function ($) {
	"use strict";
	$.extend($.wijmo.wijgrid, {
		columnsGenerator: function (gridView) {
			this.generate = function (mode, dataStore, columns) {
				switch (mode) {
					case "append":
						_processAppendMode(dataStore, columns);
						break;

					case "merge":
						_processMergeMode(dataStore, columns);
						break;

					default:
						throw $.wijmo.wijgrid.stringFormat("Unsupported value: \"{0}\"", mode);
				}
			};

			function _processAppendMode(dataStore, columns) {
				var availableDataKeys = dataStore.getFieldNames(),
					i, len, leaf;

				for (i = 0, len = availableDataKeys.length; i < len; i++) {
					leaf = _createAutoField(availableDataKeys[i]);
					columns.push(leaf);
				}
			}

			function _processMergeMode(dataStore, columns) {
				var columnsHasNoDataKey = [],
					dataFields = dataStore.getFieldNames(),
					dataKeys = {},
					i, len, dataKey, key, leaf;

				for (i = 0, len = dataFields.length; i < len; i++) {
					dataKeys[key = dataFields[i]] = key;
				}

				$.wijmo.wijgrid.traverse(columns, function (column) {
					if (column.isLeaf && !column.isBand) {
						dataKey = column.dataKey;

						if ($.wijmo.wijgrid.validDataKey(dataKey)) {
							if (dataKeys[dataKey] !== undefined) {
								delete dataKeys[dataKey];
							}
						} else {
							if (dataKey !== null) { // don't linkup with any data field if dataKey is null
								columnsHasNoDataKey.push(column);
							}
						}
					}
				});

				if (columnsHasNoDataKey.length) {
					i = 0;
					for (dataKey in dataKeys) {
						if (dataKeys.hasOwnProperty(dataKey)) {
							leaf = columnsHasNoDataKey[i++];
							if (leaf) {
								leaf.dataKey = dataKeys[dataKey];
								delete dataKeys[dataKey];
							}
						}
					}
				}

				for (dataKey in dataKeys) {
					if (dataKeys.hasOwnProperty(dataKey)) {
						leaf = _createAutoField(dataKeys[dataKey]);
						columns.push(leaf);
					}
				}
			}

			function _createAutoField(dataKey) {
				return $.wijmo.wijgrid.createDynamicField({ dataKey: dataKey });
			}
		}
	});
})(jQuery);
/*globals $, Raphael, jQuery, document, window*/
/*
 *
 * Wijmo Library 1.4.0
 * http://wijmo.com/
 *
 * Copyright(c) ComponentOne, LLC.  All rights reserved.
 * 
 * Dual licensed under the Wijmo Commercial or GNU GPL Version 3 licenses.
 * licensing@wijmo.com
 * http://wijmo.com/license
 *
 *
 * * Wijmo Chart Core Widget.
 *
 * Depends:
 *  raphael.js
 *  jquery.glob.min.js
 *  jquery.svgdom.js
 *  jquery.ui.widget.js
 *
 */

(function () {
	"use strict";
	/*
	Raphael.el.wijGetBBox = function () {
	var box = this.getBBox();
	if (Raphael.vml && this.type === 'text') {
	this.shape.style.display = "inline";
	box.width = this.shape.scrollWidth;
	box.height = this.shape.scrollHeight;
	}
	return box;
	};
	*/

	if (!window.Raphael) {
		return;
	}

	Raphael.prototype.htmlText = function (x, y, text, attrs, wordSpace, lineSpace) {
		function applyStyle(txt, sp, attrs) {
			var strongRegx = /<(b|strong)>/,
				italicRegx = /<(i|em)>/,
				hrefRegex = /href=[\"\']([^\"\']+)[\"\']/,
				aRegex = /<a/;
			if (attrs) {
				txt.attr(attrs);
			}
			if (strongRegx.test(sp)) {
				txt.attr("font-weight", "bold");
			}
			if (italicRegx.test(sp)) {
				txt.attr("font-style", "italic");
			}
			if (aRegex.test(sp)) {
				if (sp.match(hrefRegex)[1]) {
					txt.attr("href", sp.match(hrefRegex)[1]);
				}
			}
		}

		var texts = text.toString().split(/<br\s?\/>|\\r/i),
			self = this,
			st = self.set(),
			totalX = 0,
			totalY = 0;
		//set default value of word spacing and line spacing
		wordSpace = wordSpace || 3;
		lineSpace = lineSpace || 5;

		$.each(texts, function (ridx, item) {
			var maxHeight = 0,
				spans = item.split('|||');
			item = item.replace(/<([A-Za-z]+(.|\n)*?)>/g, '|||<$1>')
				.replace(/<\/([A-Za-z]*)>/g, '</$1>|||');

			$.each(spans, function (cidx, span) {
				var temp = null,
					box = null,
					offsetX = 0,
					offsetY = 0;
				if (span !== '') {
					temp = span;
					temp = $.trim(temp.replace(/<(.|\n)*?>/g, ''));
					text = self.text(0, 0, temp);
					applyStyle(text, span, attrs);

					box = text.wijGetBBox();
					offsetX = box.width / 2 + totalX;
					offsetY = -box.height / 2 + totalY;
					totalX = totalX + box.width + wordSpace;
					text.translate(offsetX, offsetY);

					st.push(text);
					if (maxHeight < box.height) {
						maxHeight = box.height;
					}
				}
			});
			totalY += maxHeight + lineSpace;
			totalX = maxHeight = 0;
		});
		totalY = 0;
		st.translate(x - st.getBBox().x, y - st.getBBox().y);

		return st;
	};

	var defaultOptions = {
		content: "",
		contentStyle: {},
		title: "",
		titleStyle: {},
		style: {
			fill: "white",
			"fill-opacity": 0.5
		},
		closeBehavior: "auto",
		mouseTrailing: true,
		triggers: "hover",
		animated: "fade",
		showAnimated: null,
		hideAnimated: null,
		duration: 500,
		showDuration: 500,
		hideDuration: 500,
		easing: null,
		showEasing: null,
		hideEasing: null,
		showDelay: 150,
		hideDelay: 150,
		relativeTo: "mouse",
		compass: "east",
		offsetX: 0,
		offsetY: 0,
		showCallout: true,
		calloutFilled: false,
		calloutFilledStyle: {
			fill: "black"
		},
		calloutLength: 12,
		calloutOffset: 0,
		calloutAnimation: {
			easing: null,
			duration: 500
		},
		calloutSide: null,
		width: null,
		height: null,
		beforeShowing: null
	};

	Raphael.fn.closeBtn = function (x, y, length) {
		var offset = Math.cos(45 * Math.PI / 180) * length,
			set = this.set(),
			arrPath = ["M", x - offset, y - offset, "L", x + offset, y + offset,
				"M", x - offset, y + offset, "L", x + offset, y - offset],
			path = this.path(arrPath.concat(" ")),
			rect = null;
		path.attr({ cursor: "pointer" });
		set.push(path);

		rect = this.rect(x - length, y - length, length * 2, length * 2);
		rect.attr({
			fill: "white",
			"fill-opacity": 0,
			cursor: "pointer",
			stroke: "none"
		});
		set.push(rect);
		return set;
	};

	Raphael.fn.tooltip = function (selector, options) {
		var o = $.extend(true, {}, defaultOptions, options),
			self = this,
			position = null,
			offsetX = 0,
			offsetY = 0,
			content,
			title,
			container,
			//containerPath,
			closeBtn,
			callout,
			intentShowTimer = null,
			intentHideTimer = null,
			lastPoint = null,
			closeBtnLength = 5,
			elements = null,
			animations = self.tooltip.animations,
			calloutOffset = o.calloutOffset,
			width = o.width,
			height = o.height,
			gapLength = o.calloutLength / 2,
			offsetLength = 0,
			//oX,oY is the default offset of the tooltip
			oX = 0,
			oY = 0,

			_getShowPoint = function (raphaelObj, compass) {
				var box = raphaelObj.getBBox(),
					point = {
						x: 0,
						y: 0
					};
				switch (compass) {
				case "east":
					point.x = box.x + box.width;
					point.y = box.y + box.height / 2;
					break;
				case "eastnorth":
					point.x = box.x + box.width;
					point.y = box.y;
					break;
				case "eastsouth":
					point.x = box.x + box.width;
					point.y = box.y + box.height;
					break;
				case "west":
					point.x = box.x;
					point.y = box.y + box.height / 2;
					break;
				case "westnorth":
					point.x = box.x;
					point.y = box.y;
					break;
				case "westsouth":
					point.x = box.x;
					point.y = box.y + box.height;
					break;
				case "north":
					point.x = box.x + box.width / 2;
					point.y = box.y;
					break;
				case "northeast":
					point.x = box.x + box.width;
					point.y = box.y;
					break;
				case "northwest":
					point.x = box.x;
					point.y = box.y;
					break;
				case "south":
					point.x = box.x + box.width / 2;
					point.y = box.y + box.height;
					break;
				case "southeast":
					point.x = box.x + box.width;
					point.y = box.y + box.height;
					break;
				case "southwest":
					point.x = box.x;
					point.y = box.y + box.height;
					break;
				}
				return point;
			},

			_clearIntentTimer = function (timer) {
				if (timer) {
					window.clearTimeout(timer);
					timer = null;
				}
			},

			_removeTooltip = function (duration) {
				if (elements) {
					var animated,
						d,
						op;
					if (o.hideAnimated || o.animated) {
						animated = o.hideAnimated;
						if (!animated) {
							animated = o.animated;
						}
						if (animated && animations[animated]) {
							op = {
								animated: animated,
								duration: o.hideDuration || o.duration,
								easing: o.hideEasing || o.easing,
								context: elements,
								show: false
							};
							animations[animated](op);
						}
					}
					d = o.hideDuration;
					if (duration) {
						d = duration;
					}
					window.setTimeout(function () {
						var i,
							ii;
						if (content) {
							content.wijRemove();
							content = null;
						}
						if (title) {
							title.wijRemove();
							title = null;
						}
						if (container) {
							container.wijRemove();
							container = null;
						}
						if (closeBtn) {
							for (i = 0, ii = closeBtn.length; i < ii; i++) {
								closeBtn[i].unclick();
							}
							closeBtn.wijRemove();
							closeBtn = null;
						}
						if (callout) {
							callout.wijRemove();
							callout = null;
						}
						lastPoint = null;
						elements = null;
					}, d);
				}
			},

			_hide = function () {
				if (intentShowTimer) {
					_clearIntentTimer(intentShowTimer);
				}
				if (intentHideTimer) {
					_clearIntentTimer(intentHideTimer);
				}
				if (o.hideDelay) {
					intentHideTimer = window.setTimeout(function () {
						_removeTooltip();
					}, o.hideDelay);
				} else {
					_removeTooltip();
				}
			},

			_convertCompassToPosition = function (compass) {
				var position = "";
				switch (compass) {
				case "east":
					position = "right-middle";
					oX = 2;
					oY = 0;
					break;
				case "eastnorth":
					position = "right-top";
					oX = 2;
					oY = -2;
					break;
				case "eastsouth":
					position = "right-bottom";
					oX = 2;
					oY = 2;
					break;
				case "west":
					position = "left-middle";
					oX = -2;
					oY = 0;
					break;
				case "westnorth":
					position = "left-top";
					oX = -2;
					oY = -2;
					break;
				case "westsouth":
					position = "left-bottom";
					oX = -2;
					oY = 2;
					break;
				case "north":
					position = "top-middle";
					oX = 0;
					oY = -2;
					break;
				case "northeast":
					position = "top-right";
					oX = 2;
					oY = -2;
					break;
				case "northwest":
					position = "top-left";
					oX = -2;
					oY = -2;
					break;
				case "south":
					position = "bottom-middle";
					oX = 0;
					oY = 2;
					break;
				case "southeast":
					position = "bottom-right";
					oX = 2;
					oY = 2;
					break;
				case "southwest":
					position = "bottom-left";
					oX = -2;
					oY = 2;
					break;
				}
				return position;
			},

			_getCalloutArr = function (p, offset) {
				var arr = [],
					compass = o.compass;
				if (o.calloutSide) {
					compass = o.calloutSide;
				}
				switch (compass) {
				case "east":
				case "eastsouth":
				case "eastnorth":
					arr = ["M", p.x + offset, p.y + offset, "l",
						-offset, -offset, "l", offset, -offset, "Z"];
					break;
				case "west":
				case "westsouth":
				case "westnorth":
					arr = ["M", p.x - offset, p.y - offset, "l",
						offset, offset, "l", -offset, offset, "Z"];
					break;
				case "north":
				case "northeast":
				case "northwest":
					arr = ["M", p.x - offset, p.y - offset, "l",
						offset, offset, "l", offset, -offset, "Z"];
					break;
				case "south":
				case "southeast":
				case "southwest":
					arr = ["M", p.x - offset, p.y + offset, "l",
						offset, -offset, "l", offset, offset, "Z"];
					break;
				}
				return arr;
			},

			_getFuncText = function (text, e) {
				if ($.isFunction(text)) {
					var fmt = null, objTar,
						obj = {
							target: null,
							fmt: text
						};
					if (e && e.target) {
						//obj.target = $(e.target).data("raphaelObj");
						objTar = $(e.target).data("raphaelObj");
						if (!objTar) {
							objTar = $(e.target.parentNode).data("raphaelObj");
						}
						obj.target = objTar;
					}
					fmt = $.proxy(obj.fmt, obj);
					return fmt().toString();
				}
				return text;
			},

			_translateCallout = function (duration) {
				if (o.calloutSide) {
					var offset = gapLength || offsetLength;
					switch (o.calloutSide) {
					case "south":
					case "north":
						if (duration) {
							callout.animate({
								"translation": (-width / 2 + offset + calloutOffset) +
									",0"
							}, duration);
						} else {
							callout.translate(-width / 2 + offset + calloutOffset, 0);
						}
						break;
					case "east":
					case "west":
						if (duration) {
							callout.animate({
								"translation": "0," + (-height / 2 +
								offset + calloutOffset)
							}, duration);
						} else {
							callout.translate(0, -height / 2 + offset + calloutOffset);
						}
						break;
					}
				}
			},

			tokenRegex = /\{([^\}]+)\}/g,
		// matches .xxxxx or ["xxxxx"] to run over object properties
			objNotationRegex = /(?:(?:^|\.)(.+?)(?=\[|\.|$|\()|\[('|")(.+?)\2\])(\(\))?/g,
			replacer = function (all, key, obj) {
				var res = obj;
				key.replace(objNotationRegex,
					function (all, name, quote, quotedName, isFunc) {
						name = name || quotedName;
						if (res) {
							if (res[name] !== typeof ('undefined')) {
								res = res[name];
							}
							if (typeof res === "function" && isFunc) {
								res = res();
							}
						}
					});
				res = (res === null || res === obj ? all : res).toString();
				return res;
			},
			fill = function (str, obj) {
				return String(str).replace(tokenRegex, function (all, key) {
					return replacer(all, key, obj);
				});
			},
			_createPath = function (point, position, set, gapLength, offsetLength) {
				var pos = position.split("-"),
					r = 5,
					bb = set.getBBox(),
					w = Math.round(bb.width),
					h = Math.round(bb.height),
					x = Math.round(bb.x) - r,
					y = Math.round(bb.y) - r,
					gap = 0,
					off = 0,
					dx = 0,
					dy = 0,
					shapes = null,
					mask = null,
					out = null;
				if (o.width) {
					w = w > o.width ? w : o.width;
				}
				if (o.height) {
					h = h > o.height ? h : o.height;
				}
				width = w;
				height = h;
				gap = Math.min(h / 4, w / 4, gapLength);
				if (offsetLength) {
					offsetLength = Math.min(h / 4, w / 4, offsetLength);
				}
				if (offsetLength) {
					off = offsetLength;
					shapes = {
						top: "M{x},{y}h{w4},{w4},{w4},{w4}a{r},{r},0,0,1,{r},{r}" +
							"v{h4},{h4},{h4},{h4}a{r},{r},0,0,1,-{r},{r}l-{right}," +
							"0-{offset},0,-{left},0a{r},{r},0,0,1-{r}-{r}" +
							"v-{h4}-{h4}-{h4}-{h4}a{r},{r},0,0,1,{r}-{r}z",
						bottom: "M{x},{y}l{left},0,{offset},0,{right},0a{r},{r}," +
							"0,0,1,{r},{r}v{h4},{h4},{h4},{h4}a{r},{r},0,0,1,-{r}," +
							"{r}h-{w4}-{w4}-{w4}-{w4}a{r},{r},0,0,1-{r}-{r}" +
							"v-{h4}-{h4}-{h4}-{h4}a{r},{r},0,0,1,{r}-{r}z",
						right: "M{x},{y}h{w4},{w4},{w4},{w4}a{r},{r},0,0,1,{r},{r}" +
							"v{h4},{h4},{h4},{h4}a{r},{r},0,0,1,-{r},{r}" +
							"h-{w4}-{w4}-{w4}-{w4}a{r},{r},0,0,1-{r}-{r}" +
							"l0-{bottom},0-{offset},0-{top}a{r},{r},0,0,1,{r}-{r}z",
						left: "M{x},{y}h{w4},{w4},{w4},{w4}a{r},{r},0,0,1,{r},{r}" +
							"l0,{top},0,{offset},0,{bottom}a{r},{r},0,0,1,-{r}," +
							"{r}h-{w4}-{w4}-{w4}-{w4}a{r},{r},0,0,1-{r}-{r}" +
							"v-{h4}-{h4}-{h4}-{h4}a{r},{r},0,0,1,{r}-{r}z"
					};
				} else {
					shapes = {
						top: "M{x},{y}h{w4},{w4},{w4},{w4}a{r},{r},0,0,1,{r},{r}" +
							"v{h4},{h4},{h4},{h4}a{r},{r},0,0,1,-{r},{r}" +
							"l-{right},0-{gap},{gap}-{gap}-{gap}-{left},0a{r},{r},0,0,1" +
							"-{r}-{r}v-{h4}-{h4}-{h4}-{h4}a{r},{r},0,0,1,{r}-{r}z",
						bottom: "M{x},{y}l{left},0,{gap}-{gap},{gap},{gap},{right},0" +
							"a{r},{r},0,0,1,{r},{r}v{h4},{h4},{h4},{h4}a{r},{r},0,0,1," +
							"-{r},{r}h-{w4}-{w4}-{w4}-{w4}a{r},{r},0,0," +
							"1-{r}-{r}v-{h4}-{h4}-{h4}-{h4}a{r},{r},0,0,1,{r}-{r}z",
						right: "M{x},{y}h{w4},{w4},{w4},{w4}a{r},{r},0,0,1,{r},{r}" +
							"v{h4},{h4},{h4},{h4}a{r},{r},0,0,1,-{r},{r}h-{w4}-{w4}" +
							"-{w4}-{w4}a{r},{r},0,0,1-{r}-{r}l0-{bottom}-{gap}-{gap}," +
							"{gap}-{gap},0-{top}a{r},{r},0,0,1,{r}-{r}z",
						left: "M{x},{y}h{w4},{w4},{w4},{w4}a{r},{r},0,0,1,{r},{r}" +
							"l0,{top},{gap},{gap}-{gap},{gap},0,{bottom}a{r},{r},0,0,1," +
							"-{r},{r}h-{w4}-{w4}-{w4}-{w4}a{r},{r},0,0,1-{r}-{r}" +
							"v-{h4}-{h4}-{h4}-{h4}a{r},{r},0,0,1,{r}-{r}z"
					};
				}
				mask = [{
					x: x + r,
					y: y,
					w: w,
					w4: w / 4,
					h4: h / 4,
					left: 0,
					right: w - gap * 2 - off * 2,
					top: 0,
					bottom: h - gap * 2 - off * 2,
					r: r,
					h: h,
					gap: gap,
					offset: off * 2
				}, {
					x: x + r,
					y: y,
					w: w,
					w4: w / 4,
					h4: h / 4,
					left: w / 2 - gap - off,
					right: w / 2 - gap - off,
					top: h / 2 - gap - off,
					bottom: h / 2 - gap - off,
					r: r,
					h: h,
					gap: gap,
					offset: off * 2
				}, {
					x: x + r,
					y: y,
					w: w,
					w4: w / 4,
					h4: h / 4,
					right: 0,
					left: w - gap * 2 - off * 2,
					bottom: 0,
					top: h - gap * 2 - off * 2,
					r: r,
					h: h,
					gap: gap,
					offset: off * 2
				}][pos[1] === "middle" ? 1 : (pos[1] === "left" || pos[1] === "top") * 2];
				out = self.path(fill(shapes[pos[0]], mask));
				switch (pos[0]) {
				case "top":
					dx = point.x - (x + r + mask.left + gap + offsetLength);
					dy = point.y - (y + r + h + r + gap + offsetLength);
					break;
				case "bottom":
					dx = point.x - (x + r + mask.left + gap + offsetLength);
					dy = point.y - (y - gap - offsetLength);
					break;
				case "left":
					dx = point.x - (x + r + w + r + gap + offsetLength);
					dy = point.y - (y + r + mask.top + gap + offsetLength);
					break;
				case "right":
					dx = point.x - (x - gap - off);
					dy = point.y - (y + r + mask.top + gap + off);
					break;
				}
				out.translate(dx, dy);
				set.translate(dx, dy);
				return out;
			},

			_isWindowCollision = function (container, compass, offset) {
				var box = container.getBBox(),
					counter = -1,
					cps;
				if (box.x + offset.x < 0) {
					counter++;
					cps = compass.replace("west", "east");
					if (cps.indexOf("east") === -1) {
						cps += "east";
					}
				}
				if (box.y + offset.y < 0) {
					counter++;
					cps = compass.replace("north", "south");
					if (cps.indexOf("south") === -1) {
						cps += "south";
					}
				}
				if (box.x + box.width + offset.x > self.width) {
					counter++;
					cps = compass.replace("east", "west");
					if (cps.indexOf("west") === -1) {
						cps += "west";
					}
				}
				if (box.y + box.height + offset.y > self.height) {
					counter++;
					cps = compass.replace("south", "north");
					if (cps.indexOf("north") === -1) {
						cps += "north";
					}
				}
				if (counter) {
					return cps;
				}
				return false;
			},

			_createTooltip = function (point, e) {
				var titleBox, contentBox, position,
					set = self.set(),
					tit = o.title,
					cont = o.content,
					arrPath = null,
					animated = null,
					op = null,
					fmt = null,
					obj = null,
					ox = 0,
					oy = 0,
					duration = 250,
					idx = 0,
					len = 0,
					objTar,
					isWindowCollision;
				if ($.isFunction(o.beforeShowing)) {
					fmt = null;
					obj = {
						target: null,
						options: o,
						fmt: o.beforeShowing
					};
					if (e && e.target) {
						objTar = $(e.target).data("raphaelObj");
						if (!objTar) {
							objTar = $(e.target.parentNode).data("raphaelObj");
						}
						obj.target = objTar;
					}
					fmt = $.proxy(obj.fmt, obj);
					fmt();
				}
				position = _convertCompassToPosition(o.compass);
				point.x += o.offsetX + oX;
				point.y += o.offsetY + oY;
				elements = self.set();
				if (title) {
					title.wijRemove();
				}
				tit = _getFuncText(tit, e);
				if (tit && tit.length > 0) {
					title = self.htmlText(-1000, -1000, tit, o.titleStyle);
					elements.push(title);
					titleBox = title.getBBox();
				} else {
					titleBox = {
						left: -1000,
						top: -1000,
						width: 0,
						height: 0
					};
				}
				if (content) {
					content.wijRemove();
				}
				cont = _getFuncText(cont, e);
				if (cont && cont.length > 0) {
					content = self.htmlText(-1000, -1000, cont, o.contentStyle);
					elements.push(content);
					contentBox = content.getBBox();
				} else {
					contentBox = {
						left: -1000,
						top: -1000,
						width: 0,
						height: 0
					};
				}
				if (closeBtn) {
					for (idx = 0, len = closeBtn.length; idx < len; idx++) {
						closeBtn[idx].unclick();
					}
					closeBtn.wijRemove();
				}
				if (content) {
					content.translate(0, titleBox.height / 2 + contentBox.height / 2);
				}
				if (o.closeBehavior === "sticky") {
					closeBtn = self.closeBtn(-1000, -1000, closeBtnLength);
					elements.push(closeBtn);
					if (o.width && o.width > titleBox.width + closeBtnLength * 2 &&
							o.width > contentBox.width + closeBtnLength * 2) {
						closeBtn.translate(o.width - closeBtnLength, closeBtnLength);
					} else if (titleBox.width >= contentBox.width - closeBtnLength * 2) {
						closeBtn.translate(titleBox.width +
							closeBtnLength, closeBtnLength);
					} else {
						closeBtn.translate(contentBox.width -
							closeBtnLength, closeBtnLength);
					}

					//bind click event.
					$.each(closeBtn, function () {
						this.click(function (e) {
							_hide(e);
						});
					});
				}
				if (title) {
					set.push(title);
				}
				if (content) {
					set.push(content);
				}
				if (closeBtn) {
					set.push(closeBtn);
				}
				if (!o.showCallout) {
					gapLength = 0;
				}
				if (o.calloutSide || o.calloutFilled) {
					gapLength = 0;
					offsetLength = o.calloutLength / 2;
					if (o.calloutSide) {
						position = _convertCompassToPosition(o.calloutSide);
					}
				}
				if (o.calloutSide && set.length === 0) {
					content = self.htmlText(-1000, -1000, " ");
					set.push(content);
				}
				if (callout) {
					callout.wijRemove();
				}
				if (container) {
					container.wijRemove();
				}
				container = self.path();
				if (lastPoint) {
					if (o.calloutSide || o.calloutFilled) {
						arrPath = _getCalloutArr(lastPoint, offsetLength);

						callout = self.path(arrPath.concat(" "));
						if (o.calloutFilled) {
							callout.attr(o.calloutFilledStyle);
						}
						if (o.calloutSide) {
							_translateCallout(0);
						}
					}
					container = _createPath(lastPoint, position,
						set, gapLength, offsetLength);
					elements.push(callout);
					elements.push(container);
					ox = point.x - lastPoint.x;
					oy = point.y - lastPoint.y;
					if (title) {
						title.animate({ "translation": ox + "," + oy }, duration);
					}
					if (content) {
						content.animate({ "translation": ox + "," + oy }, duration);
					}
					if (closeBtn) {
						closeBtn.animate({ "translation": ox + "," + oy }, duration);
					}
					if (callout) {
						callout.animate({ "translation": ox + "," + oy }, duration);
					}
					if (container) {
						container.animate({ "translation": ox + "," + oy }, duration);
					}
				} else {
					if (o.calloutSide || o.calloutFilled) {
						arrPath = _getCalloutArr(point, offsetLength);
						callout = self.path(arrPath.concat(" "));
						if (o.calloutFilled) {
							callout.attr(o.calloutFilledStyle);
						}
						if (o.calloutSide) {
							_translateCallout(0);
						}
					}
					container = _createPath(point, position,
						set, gapLength, offsetLength);
					isWindowCollision = _isWindowCollision(container,
						o.compass, { x: 0, y: 0 });
//					//TODO: window collision
//					if (isWindowCollision) {
//					}
					elements.push(callout);
					elements.push(container);
					if (o.showAnimated || o.animated) {
						animated = o.showAnimated;
						if (!animated) {
							animated = o.animated;
						}
						if (animated && animations[animated]) {
							op = {
								animated: animated,
								duration: o.showDuration || o.duration,
								easing: o.showEasing || o.easing,
								context: elements,
								show: true
							};
							animations[animated](op);
						}
					}
				}
				lastPoint = point;
				container.attr(o.style);
				container.toFront();
				set.toFront();
			},

			_showAt = function (point, e) {
				if (intentShowTimer) {
					_clearIntentTimer(intentShowTimer);
				}
				if (intentHideTimer) {
					_clearIntentTimer(intentHideTimer);
				}
				if (o.showDelay) {
					intentShowTimer = window.setTimeout(function () {
						_createTooltip(point, e);
					}, o.showDelay);
				} else {
					_createTooltip(point, e);
				}
			},

			_show = function (e) {
				position = $(self.canvas.parentNode).offset();
				offsetX = position.left;
				offsetY = position.top;
				var relativeTo = o.relativeTo,
					point = {
						x: 0,
						y: 0
					},
					raphaelObj = null;
				switch (relativeTo) {
				case "mouse":
					point.x = e.pageX - offsetX;
					point.y = e.pageY - offsetY;
					break;
				case "element":
					raphaelObj = $(e.target).data("raphaelObj");
					if (!raphaelObj) {
						raphaelObj = $(e.target.parentNode).data("raphaelObj");
					}
					point = _getShowPoint(raphaelObj, o.compass);
					break;
				}
				_showAt(point, e);
			},

			_bindEvent = function (selector) {
				$(selector.node).data("raphaelObj", selector);
				switch (o.triggers) {
				case "hover":
					$(selector.node).bind("mouseover.Rtooltip", function (e) {
						_show(e);
					}).bind("mouseout.Rtooltip", function (e) {
						if (o.closeBehavior === "auto") {
							_hide(e);
						}
					});
					if (o.mouseTrailing && o.relativeTo === "mouse") {
						$(selector.node).bind("mousemove.Rtooltip", function (e) {
							_show(e);
						});
					}
					break;
				case "click":
					$(selector.node).bind("click.Rtooltip", function (e) {
						_show(e);
					});
					break;
				case "custom":
					break;
				/*
				case "rightClick":
				$(selector.node).bind("contextmenu.Rtooltip", function (e) {
				_show(e);
				});
				break;
				*/ 
				}
			},

			_bindLiveEvent = function () {
				var i,
					ii;
				if (selector) {
					if (selector.length) {
						for (i = 0, ii = selector.length; i < ii; i++) {
							_bindEvent(selector[i]);
						}
					} else {
						_bindEvent(selector);
					}
				}
			},

			_unbindLiveEvent = function () {
				var i,
					ii;
				if (selector) {
					if (selector.length) {
						for (i = 0, ii = selector.length; i < ii; i++) {
							$(selector[i].node).unbind(".Rtooltip");
						}
					} else {
						$(selector.node).unbind(".Rtooltip");
					}
				}
			},

			_destroy = function () {
				_unbindLiveEvent();
				_removeTooltip(0);
			},

			Tooltip = function () {

				this.hide = function () {
					_hide();
				};

				//this.show = function () {
				//};

				this.showAt = function (point) {
					_showAt(point);
				};

				this.resetCalloutOffset = function (offset) {
					var currentOffset = o.calloutOffset,
						side = o.calloutSide,
						ani = o.calloutAnimation;
					if (callout) {
						if (side === "south" || side === "north") {
							callout.animate({
								"translation": (offset - currentOffset) + ",0"
							}, ani.duration, ani.easing);
						} else if (side === "east" || side === "west") {
							callout.animate({
								"translation": "0," + (offset - currentOffset)
							}, ani.duration, ani.easing);
						}
					}
					o.calloutOffset = offset;
				};

				this.destroy = function () {
					_destroy();
				};

				this.getOptions = function () {
					return o;
				};
			};


		//bind event.
		if (selector) {
			_bindLiveEvent();
		}

		return new Tooltip();

	};


	Raphael.fn.tooltip.animations = {
		fade: function (options) {
			var eles = options.context;
			if (options.show) {
				eles.attr({ "opacity": 0 });
				eles.animate({ "opacity": 1 }, options.duration, options.easing);
			} else {
				eles.animate({ "opacity": 0 }, options.duration, options.easing);
			}
		}
	};

	Raphael.fn.wij = {
		moveTo: function (x, y) {
			return this.path("M " + x + " " + y);
		},

		lineTo: function (x, y) {
			return this.path("M " + this.wij.lastX + " " +
					this.wij.lastY + "L " + x + " " + y);
		},

		line: function (startX, startY, endX, endY) {
			return this.path(["M", startX, startY, "L", endX, endY]);
		},

		sector: function (cx, cy, r, startAngle, endAngle) {
			var start = this.wij.getPositionByAngle(cx, cy, r, startAngle),
				end = this.wij.getPositionByAngle(cx, cy, r, endAngle);
			return this.path(["M", cx, cy, "L", start.x, start.y, "A", r, r, 0,
							+(endAngle - startAngle > 180), 0, end.x, end.y, "z"]);
		},

		donut: function (cx, cy, outerR, innerR, startAngle, endAngle) {
			var outerS = this.wij.getPositionByAngle(cx, cy, outerR, startAngle),
				outerE = this.wij.getPositionByAngle(cx, cy, outerR, endAngle),
				innerS = this.wij.getPositionByAngle(cx, cy, innerR, startAngle),
				innerE = this.wij.getPositionByAngle(cx, cy, innerR, endAngle),
				largeAngle = endAngle - startAngle > 180;

			return this.path(["M", outerS.x, outerS.y,
					"A", outerR, outerR, 0, +largeAngle, 0, outerE.x, outerE.y,
					"L", innerE.x, innerE.y,
					"A", innerR, innerR, 0, +largeAngle, 1, innerS.x, innerS.y,
					"L", outerS.x, outerS.y, "z"]);
		},

		roundRect: function (x, y, width, height, tlCorner,
				lbCorner, brCorner, rtCorner) {
			var rs = [],
				posFactors = [-1, 1, 1, 1, 1, -1, -1, -1],
				orientations = ["v", "h", "v", "h"],
				pathData = null,
				lens = null;
			$.each([tlCorner, lbCorner, brCorner, rtCorner], function (idx, corner) {
				if (typeof (corner) === "number") {
					rs = rs.concat({ x: corner, y: corner });
				} else if (typeof (corner) === "object") {
					rs = rs.concat(corner);
				} else {
					rs = rs.concat({ x: 0, y: 0 });
				}
			});

			pathData = ["M", x + rs[0].x, y];
			lens = [height - rs[0].y - rs[1].y, width - rs[1].x - rs[2].x,
					rs[2].y + rs[3].y - height, rs[3].x + rs[0].x - width];

			$.each(rs, function (idx, r) {
				if (r.x && r.y) {
					pathData = pathData.concat("a", r.x, r.y, 0, 0, 0,
							posFactors[2 * idx] * r.x, posFactors[2 * idx + 1] * r.y);
				}

				pathData = pathData.concat(orientations[idx], lens[idx]);
			});

			pathData.push("z");

			return this.path(pathData);
		},

		wrapText: function (x, y, text, width, textAlign, textStyle) {
			var self = this,
				rotation = textStyle.rotation,
				style = rotation ? $.extend(true, {}, textStyle, { rotation: 0 })
					: textStyle,
				top = y,
				texts = self.set(),
				bounds = null,
				center = null,
				textBounds = [];

			function splitString(text, width, textStyle) {
				var tempText = null,
					bounds = null,
					words = text.split(' '),
					lines = [],
					line = [],
					tempTxt = "";
				while (words.length) {
					tempTxt += ' ' + words[0];
					tempText = self.text(-1000, -1000, tempTxt);
					tempText.attr(textStyle);
					bounds = tempText.wijGetBBox();

					if (bounds.width > width) {
						if (line.length) {
							lines.push(line);
							tempTxt = words[0];
						}
						line = [words.shift()];
					} else {
						line.push(words.shift());
					}

					if (words.length === 0) {
						lines.push(line);
					}

					tempText.wijRemove();
					tempText = null;
				}

				return lines;
			}

			$.each(splitString(text, width, style), function (idx, line) {
				var lineText = line.join(' '),
					align = textAlign || "near",
					txt = self.text(x, top, lineText),
					offsetX = 0,
					offsetY = 0;

				txt.attr(style);
				bounds = txt.wijGetBBox();

				switch (align) {
				case "near":
					offsetX = width - bounds.width / 2;
					offsetY += bounds.height / 2;
					top += bounds.height;
					break;
				case "center":
					offsetX += width / 2;
					offsetY += bounds.height / 2;
					top += bounds.height;
					break;
				case "far":
					offsetX += bounds.width / 2;
					offsetY += bounds.height / 2;
					top += bounds.height;
					break;
				}
				bounds.x += offsetX;
				bounds.y += offsetY;
				txt.translate(offsetX, offsetY);
				texts.push(txt);
				textBounds.push(bounds);
			});

			if (rotation) {
				if (texts.length > 1) {
					bounds = texts.wijGetBBox();
					center = {
						x: bounds.x + bounds.width / 2,
						y: bounds.y + bounds.height / 2
					};

					$.each(texts, function (idx, txt) {
						var math = Math,
							tb = textBounds[idx],
							txtCenter = {
								x: tb.x + tb.width / 2,
								y: tb.y + tb.height / 2
							},
							len = math.sqrt(math.pow(txtCenter.x - center.x, 2) +
								math.pow(txtCenter.y - center.y, 2)),
							theta = 0,
							rotatedTB = null,
							newTxtCenter = null;

						txt.attr({ rotation: rotation });

						if (len === 0) {
							return true;
						}

						theta = Raphael.deg(math.asin(math.abs(txtCenter.y
							- center.y) / len));

						if (txtCenter.y > center.y) {
							if (txtCenter.x > center.x) {
								theta -= 360;
							} else {
								theta = -1 * (theta + 180);
							}
						} else {
							if (txtCenter.x > center.x) {
								theta *= -1;
							} else {
								theta = -1 * (180 - theta);
							}
						}
						newTxtCenter = self.wij.getPositionByAngle(center.x,
							center.y, len, -1 * (rotation + theta));

						rotatedTB = txt.wijGetBBox();

						txt.translate(newTxtCenter.x - rotatedTB.x - rotatedTB.width / 2,
								newTxtCenter.y - rotatedTB.y - rotatedTB.height / 2);
					});
				} else {
					texts[0].attr({ rotation: rotation });
				}
			}

			return texts;
		},

		getPositionByAngle: function (cx, cy, r, angle) {
			var point = {},
				rad = Raphael.rad(angle);
			point.x = cx + r * Math.cos(-1 * rad);
			point.y = cy + r * Math.sin(-1 * rad);

			return point;
		},

		getSVG: function () {
			function createSVGElement(type, options) {
				var element = '<' + type + ' ',
					val = null,
					styleExist = false;

				$.each(options, function (name, val) {
					if (name === "text" || name === "opacity" ||
							name === "transform" || name === "path" ||
							name === "w" || name === "h" || name === "translation") {
						return true;
					}

					if (val) {
						if (name === "stroke" && val === 0) {
							val = "none";
						}

						element += name + "='" + val + "' ";
					}
				});
				/*
				for (name in options) {
				if (name === "text" || name === "opacity" ||
				name === "transform" || name === "path" ||
				name === "w" || name === "h" || name === "translation") {
				continue;
				}
	
				if ((val = options[name]) !== null) {
				if (name === "stroke" && val === 0) {
				val = "none";
				}
	
				element += name + "='" + val + "' ";
				}
				}
				*/
				if (options.opacity) {
					val = options.opacity;
					element += "opacity='" + val + "' style='opacity:" + val + ";";
					styleExist = true;
				}

				if (options.transform && options.transform.length > 0) {
					val = options.transform;
					if (styleExist) {
						element += "transform:" + val;
					} else {
						element += "style='transform:" + val;
						styleExist = true;
					}
				}

				if (styleExist) {
					element += "'";
				}

				if (options.text) {
					val = options.text;
					element += "><tspan>" + val + "</tspan>";
				} else {
					element += ">";
				}

				element += "</" + type + ">";

				return element;
			}

			var paper = this,
				svg = '<svg xmlns="http://www.w3.org/2000/svg" ' +
					'xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="' +
					paper.canvas.offsetWidth + '" height="' + paper.canvas.offsetHeight +
					'"><desc>Created with Raphael</desc><defs></defs>',
				node,
				path = "",
				trans,
				group,
				value,
				idx = 0,
				len1 = 0,
				index = 0,
				len2 = 0;

			for (node = paper.bottom; node; node = node.next) {
				if (node && node.type) {
					switch (node.type) {
					case "path":
						for (idx = 0, len1 = node.attrs.path.length; idx < len1; idx++) {
							group = node.attrs.path[idx];

							for (index = 0, len2 = group.length; index < len2; index++) {
								value = group[index];

								if (index < 1) {
									path += value;
								} else {
									if (index === (len2 - 1)) {
										path += value;
									} else {
										path += value + ',';
									}
								}
							}
						}

						if (path && path.length > 0) {
							node.attrs.d = path.replace(/,/g, ' ');
						}
						break;
					case "text":
						if (!node.attrs["text-anchor"]) {
							node.attrs["text-anchor"] = "middle";
						}
						break;
					case "image":
						trans = node.transformations;
						node.attrs.transform = trans ? trans.join(' ') : '';
						break;
					case "ellipse":
					case "rect":
						svg += createSVGElement(node.type, node.attrs);
						break;
					}
				}
			}

			svg += '</svg>';

			return svg;
		}
	};

	Raphael.el.wijRemove = function () {
		if (this.removed) {
			return;
		}
		if (this.node.parentNode) {
			this.remove();
		}
	};

	Raphael.st.wijRemove = function () {
		$.each(this, function (idx, obj) {
			if (obj.wijRemove) {
				obj.wijRemove();
			}
		});
	};

	Raphael.el.wijGetBBox = function () {
		var box = this.getBBox(),
			degreesAsRadians = null,
			points = [],
			newX,
			newY,
			newWidth,
			newHeight,
			p,
			bb = { left: 0, right: 0, top: 0, bottom: 0 },
			_px = 0;
		if (this.attrs && this.attrs.rotation) {
			degreesAsRadians = this._.rt.deg * Math.PI / 180;
			points.push({ x: 0, y: 0 });
			points.push({ x: box.width, y: 0 });
			points.push({ x: 0, y: box.height });
			points.push({ x: box.width, y: box.height });
			for (_px = 0; _px < points.length; _px++) {
				p = points[_px];
				newX = parseInt((p.x * Math.cos(degreesAsRadians)) +
					(p.y * Math.sin(degreesAsRadians)), 10);
				newY = parseInt((p.x * Math.sin(degreesAsRadians)) +
					(p.y * Math.cos(degreesAsRadians)), 10);
				bb.left = Math.min(bb.left, newX);
				bb.right = Math.max(bb.right, newX);
				bb.top = Math.min(bb.top, newY);
				bb.bottom = Math.max(bb.bottom, newY);
			}
			newWidth = parseInt(Math.abs(bb.right - bb.left), 10);
			newHeight = parseInt(Math.abs(bb.bottom - bb.top), 10);
			newX = (box.x + (box.width) / 2) - newWidth / 2;
			newY = (box.y + (box.height) / 2) - newHeight / 2;

			return { x: newX, y: newY, width: newWidth, height: newHeight };
		}

		box = this.getBBox();
		if (Raphael.vml && this.type === 'text') {
			this.shape.style.display = "inline";
			box.width = this.shape.scrollWidth;
			box.height = this.shape.scrollHeight;
		}
		return box;
	};

	Raphael.el.wijAnimate = function (params, ms, easing, callback) {
		if (!params || $.isEmptyObject(params)) {
			return;
		}

		var shadow = this.shadow,
			offset = 0,
			jQEasing = {
				easeInCubic: ">",
				easeOutCubic: "<",
				easeInOutCubic: "<>",
				easeInBack: "backIn",
				easeOutBack: "backOut",
				easeOutElastic: "elastic",
				easeOutBounce: "bounce"
			};
		
		if (jQEasing[easing]) {
			easing = jQEasing[easing];
		}
		this.animate(params, ms, easing, callback);

		if (shadow && shadow.offset) {
			offset = shadow.offset;
			if (params.x) {
				params.x += offset;
			}
			if (params.y) {
				params.y += offset;
			}
			this.shadow.animate(params, ms, easing, callback);
		}
	};

	Raphael.el.wijAttr = function (name, value) {
		this.attr(name, value);

		if (this.shadow) {
			if (typeof (name) === "object") {
				var newName = $.extend(true, {}, name);
				if (newName.fill) {
					delete newName.fill;
				}
				if (newName.stroke) {
					delete newName.stroke;
				}
				if (newName["stroke-width"]) {
					delete newName["stroke-width"];
				}
				this.shadow.attr(newName, value);
			} else if (typeof (name) === "string") {
				switch (name) {
				case "clip-rect":
				case "cx":
				case "cy":
				case "fill-opacity":
				case "font":
				case "font-family":
				case "font-size":
				case "font-weight":
				case "height":
				case "opacity":
				case "path":
				case "r":
				case "rotation":
				case "rx":
				case "ry":
				case "scale":
				case "stroke-dasharray":
				case "stroke-linecap":
				case "stroke-linejoin":
				case "stroke-miterlimit":
				case "stroke-opacity":
				case "stroke-width":
				case "translation":
				case "width":
					this.shadow.attr(name, value);
					break;
				case "x":
					this.shadow.attr(name, value);
					this.shadow.attr("translation", "1 0");
					break;
				case "y":
					this.shadow.attr(name, value);
					this.shadow.attr("translation", "0 1");
					break;
				default:
					break;
				}
			}
		}
	};

	Raphael.st.wijAttr = function (name, value) {
		$.each(this.items, function (idx, item) {
			item.wijAttr(name, value);
		});
		return this;
	};

	Raphael.st.wijAnimate = function (params, ms, easing, callback) {
		var i = 0,
			ii = 0,
			item = null;
		for (i = 0, ii = this.items.length; i < ii; i++) {
			item = this.items[i];
			item.wijAnimate(params, ms, easing, callback);
		}
		return this;
	};

	Raphael.st.wijGetBBox = function () {
		var x = [],
			y = [],
			w = [],
			h = [],
			mmax = Math.max,
			mmin = Math.min,
			push = "push",
			apply = "apply",
			box = null,
			i = 0;
		for (i = this.items.length - 1; i >= 0; i--) {
			box = this.items[i].wijGetBBox();
			x[push](box.x);
			y[push](box.y);
			w[push](box.x + box.width);
			h[push](box.y + box.height);
		}
		x = mmin[apply](0, x);
		y = mmin[apply](0, y);
		return {
			x: x,
			y: y,
			width: mmax[apply](0, w) - x,
			height: mmax[apply](0, h) - y
		};
	};

	function isSVGElem(node) {
		var svgNS = "http://www.w3.org/2000/svg";
		return (node.nodeType === 1 && node.namespaceURI === svgNS);
	}

	$.expr.filter.CLASS = function (elem, match) {
		var className = (!isSVGElem(elem) ? elem.className :
			(elem.className ? elem.className.baseVal : elem.getAttribute('class')));
		return (' ' + className + ' ').indexOf(match) > -1;
	};

	$.expr.preFilter.CLASS = function (match, curLoop, inplace, result, not, isXML) {
		var i = 0,
			elem = null,
			className = null;
		match = ' ' + match[1].replace(/\\/g, '') + ' ';
		if (isXML) {
			return match;
		}
		for (i = 0, elem = {}; elem; i++) {
			elem = curLoop[i];
			if (!elem) {
				try {
					elem = curLoop.item(i);
				} catch (e) { }
			}
			if (elem) {
				className = (!isSVGElem(elem) ? elem.className :
					(elem.className ? elem.className.baseVal : '') ||
					elem.getAttribute('class'));
				if (not ^ (className && (' ' + className + ' ').indexOf(match) > -1)) {
					if (!inplace) {
						result.push(elem);
					}
				} else if (inplace) {
					curLoop[i] = false;
				}
			}
		}
		return false;
	};

}());

(function ($) {
	"use strict";

	$.widget("wijmo.wijchartcore", {
		options: {
			/// <summary>
			/// A value that indicates the width of wijchart.
			/// Default: null.
			/// Type: Number.
			/// Code example:
			///  $("#chartcore").wijchartcore({
			///      width: 600
			///  });
			/// <remarks>
			/// If the value is null, then the width will be calculated
			/// by dom element which is used to put the canvas.
			/// </remarks>
			/// </summary>
			width: null,
			/// <summary>
			/// A value that indicates the height of wijchart.
			/// Default: null.
			/// Type: Number.
			/// Code example:
			///  $("#chartcore").wijchartcore({
			///      height: 400
			///  });
			/// <remarks>
			/// If the value is null, then the height will be calculated
			/// by dom element which is used to put the canvas.
			/// </remarks>
			/// </summary>
			height: null,
			/// <summary>
			/// An array collection that contains the data to be charted.
			/// Default: [].
			/// Type: Array.
			///	Code example: 
			///	$("#chartcore").wijchartcore({
			///				seriesList: [{
			///                 label: "Q1",
			///                 legendEntry: true,
			///                 data: {
			///						x: [1, 2, 3, 4, 5],
			///						y: [12, 21, 9, 29, 30]
			///					},
			///				offset: 0
			///             }, {
			///					label: "Q2",
			///					legendEntry: true,
			///					data: {
			///						xy: [1, 21, 2, 10, 3, 19, 4, 31, 5, 20]
			///					},
			///					offset: 0
			///				}]
			///				OR
			///				seriesList: [{
			///					label: "Q1",
			///					legendEntry: true,
			///					data: {
			///						x: ["A", "B", "C", "D", "E"],
			///						y: [12, 21, 9, 29, 30]
			///					},
			///					offset: 0
			///				}]
			///				OR
			///				seriesList: [{
			///					label: "Q1",
			///					legendEntry: true,
			///					data: {
			///						x: [new Date(1978, 0, 1), new Date(1980, 0, 1), 
			///							new Date(1981, 0, 1), new Date(1982, 0, 1), 
			///							new Date(1983, 0, 1)],
			///						y: [12, 21, 9, 29, 30]
			///					},
			///					offset: 0
			///				}]
			///  });
			/// </summary>
			seriesList: [],
			/// <summary>
			/// An array collection that contains the style to be charted.
			/// Default: [{stroke: "#77b3af", opacity: 0.9, "stroke-width": 1}, {
			///				stroke: "#67908e", opacity: 0.9, "stroke-width": 1}, {
			///				stroke: "#465d6e", opacity: 0.9, "stroke-width": 1}, {
			///				stroke: "#5d3f51", opacity: 0.9, "stroke-width": 1}, {
			///				stroke: "#682e32", opacity: 0.9, "stroke-width": 1}, {
			///				stroke: "#8c5151", opacity: 0.9, "stroke-width": 1}, {
			///				stroke: "#ce9262", opacity: 0.9, "stroke-width": 1}, {
			///				stroke: "#ceb664", opacity: 0.9, "stroke-width": 1}, {
			///				stroke: "#7fb34f", opacity: 0.9, "stroke-width": 1}, {
			///				stroke: "#2a7b5f", opacity: 0.9, "stroke-width": 1}, {
			///				stroke: "#6079cb", opacity: 0.9, "stroke-width": 1}, {
			///				stroke: "#60a0cb", opacity: 0.9, "stroke-width": 1}].
			/// Type: Array.
			///	Code example: 
			///	$("#chartcore").wijchartcore({
			///				seriesStyles: [
			///					{fill: "rgb(255,0,0)", stroke:"none"}, 
			///					{ fill: "rgb(255,125,0)", stroke: "none" }
			///				]});
			/// </summary>
			seriesStyles: [{
				stroke: "#77b3af", 
				opacity: 0.9, 
				"stroke-width": 1
			}, {
				stroke: "#67908e", 
				opacity: 0.9, 
				"stroke-width": 1
			}, {
				stroke: "#465d6e", 
				opacity: 0.9, 
				"stroke-width": 1
			}, {
				stroke: "#5d3f51", 
				opacity: 0.9, 
				"stroke-width": 1
			}, {
				stroke: "#682e32", 
				opacity: 0.9, 
				"stroke-width": 1
			}, {
				stroke: "#8c5151", 
				opacity: 0.9, 
				"stroke-width": 1
			}, {
				stroke: "#ce9262", 
				opacity: 0.9, 
				"stroke-width": 1
			}, {
				stroke: "#ceb664", 
				opacity: 0.9, 
				"stroke-width": 1
			}, {
				stroke: "#7fb34f", 
				opacity: 0.9, 
				"stroke-width": 1
			}, {
				stroke: "#2a7b5f", 
				opacity: 0.9, 
				"stroke-width": 1
			}, {
				stroke: "#6079cb", 
				opacity: 0.9, 
				"stroke-width": 1
			}, {
				stroke: "#60a0cb", 
				opacity: 0.9, 
				"stroke-width": 1
			}],
			/// <summary>
			/// An array collection that contains the style to 
			/// be charted when hovering the chart element.
			/// Default: [{opacity: 1, "stroke-width": 1.5}, {
			///				opacity: 1, "stroke-width": 1.5}, {
			///				opacity: 1, "stroke-width": 1.5}, {
			///				opacity: 1, "stroke-width": 1.5}, {
			///				opacity: 1, "stroke-width": 1.5}, {
			///				opacity: 1, "stroke-width": 1.5}, {
			///				opacity: 1, "stroke-width": 1.5}, {
			///				opacity: 1, "stroke-width": 1.5}, {
			///				opacity: 1, "stroke-width": 1.5}, {
			///				opacity: 1, "stroke-width": 1.5}, {
			///				opacity: 1, "stroke-width": 1.5}, {
			///				opacity: 1, "stroke-width": 1.5}].
			/// Type: Array.
			///	Code example: 
			///	$("#chartcore").wijchartcore({
			///				seriesHoverStyles: [
			///					{fill: "rgb(255,0,0)", stroke:"none"}, 
			///					{ fill: "rgb(255,125,0)", stroke: "none" }
			///				]});
			/// </summary>
			seriesHoverStyles: [{
				opacity: 1, 
				"stroke-width": 1.5
			}, {
				opacity: 1, 
				"stroke-width": 1.5
			}, {
				opacity: 1, 
				"stroke-width": 1.5
			}, {
				opacity: 1, 
				"stroke-width": 1.5
			}, {
				opacity: 1, 
				"stroke-width": 1.5
			}, {
				opacity: 1, 
				"stroke-width": 1.5
			}, {
				opacity: 1, 
				"stroke-width": 1.5
			}, {
				opacity: 1, 
				"stroke-width": 1.5
			}, {
				opacity: 1, 
				"stroke-width": 1.5
			}, {
				opacity: 1, 
				"stroke-width": 1.5
			}, {
				opacity: 1, 
				"stroke-width": 1.5
			}, {
				opacity: 1, 
				"stroke-width": 1.5
			}],
			/// <summary>
			/// A value that indicates the top margin of the chart area.
			/// Default: 25.
			/// Type: Number.
			/// Code example:
			///  $("#chartcore").wijchartcore({
			///      marginTop: 25
			///  });
			/// </summary>
			marginTop: 25,
			/// <summary>
			/// A value that indicates the right margin of the chart area.
			/// Default: 25.
			/// Type: Number.
			/// Code example:
			///  $("#chartcore").wijchartcore({
			///      marginRight: 25
			///  });
			/// </summary>
			marginRight: 25,
			/// <summary>
			/// A value that indicates the bottom margin of the chart area.
			/// Default: 25.
			/// Type: Number.
			/// Code example:
			///  $("#chartcore").wijchartcore({
			///      marginBottom: 25
			///  });
			/// </summary>
			marginBottom: 25,
			/// <summary>
			/// A value that indicates the left margin of the chart area.
			/// Default: 25.
			/// Type: Number.
			/// Code example:
			///  $("#chartcore").wijchartcore({
			///      marginLeft: 25
			///  });
			/// </summary>
			marginLeft: 25,
			/// <summary>
			/// A value that indicates the style of the chart text.
			/// Default: {fill:"#888", "font-size": "10pt", stroke:"none"}.
			/// Type: Object.
			/// </summary>
			textStyle: {
				fill: "#888",
				"font-size": "10pt",
				stroke: "none"
			},
			/// <summary>
			/// An object that value indicates the header of the chart element.
			/// Type: Object.
			/// Default: {visible:true, style:{fill:"none", stroke:"none"},
			///			textStyle:{"font-size": "18pt", fill:"#666", stroke:"none"}, 
			///			compass:"north", orientation:"horizontal"}		
			/// Code example:
			///  $("#chartcore").wijchartcore({
			///      header: {
			///			text:"header",
			///			style:{
			///				fill:"#f1f1f1",
			///				stroke:"#010101"
			///				}}
			///  });
			/// </summary>
			header: {
				/// <summary>
				/// A value that indicates the text of the header.
				/// Default: "".
				/// Type: String.
				/// </summary>
				text: "",
				/// <summary>
				/// A value that indicates the style of the header.
				/// Default: {fill:"none", stroke:"none"}.
				/// Type: Object.
				/// </summary>
				style: {
					fill: "none",
					stroke: "none"
				},
				/// <summary>
				/// A value that indicates the style of the header text.
				/// Default: {"font-size": "18pt", fill:"#666", stroke:"none"}.
				/// Type: Object.
				/// </summary>
				textStyle: {
					"font-size": "18pt",
					fill: "#666",
					stroke: "none"
				},
				/// <summary>
				/// A value that indicates the compass of the header.
				/// Default: "north".
				/// Type: String.
				/// </summary>
				/// <remarks>
				/// Options are 'north', 'south', 'east' and 'west'.
				/// </remarks>
				compass: "north",
				/// <summary>
				/// A value that indicates the orientation of the header.
				/// Default: "horizontal".
				/// Type: String.
				/// </summary>
				/// <remarks>
				/// Options are 'horizontal' and 'vertical'.
				/// </remarks>
				orientation: "horizontal",
				/// <summary>
				/// A value that indicates the visibility of the header.
				/// Default: true.
				/// Type: Boolean.
				/// </summary>
				visible: true
			},
			/// <summary>
			/// An object value that indicates the footer of the chart element.
			/// Type: Object.
			/// Default: {visible:false, style:{fill:"#fff", stroke:"none"}, 
			///			textStyle:{fille:"#000", stroke:"none"}, compass:"south", 
			///			orientation:"horizontal"}
			/// Code example:
			///  $("#chartcore").wijchartcore({
			///      footer: {
			///			text:"footer",
			///			style:{
			///				fill:"#f1f1f1",
			///				stroke:"#010101"
			///				}}
			///  });
			/// </summary>
			footer: {
				/// <summary>
				/// A value that indicates the text of the footer.
				/// Default: "".
				/// Type: String.
				/// </summary>
				text: "",
				/// <summary>
				/// A value that indicates the style of the footer.
				/// Default: {fill:"#fff", stroke:"none"}.
				/// Type: Object.
				/// </summary>
				style: {
					fill: "#fff",
					stroke: "none"
				},
				/// <summary>
				/// A value that indicates the style of the footer text.
				/// Default: {fill:"#000", stroke:"none"}.
				/// Type: Object.
				/// </summary>
				textStyle: {
					fill: "#000",
					stroke: "none"
				},
				/// <summary>
				/// A value that indicates the compass of the footer.
				/// Default: "south".
				/// Type: String.
				/// </summary>
				/// <remarks>
				/// Options are 'north', 'south', 'east' and 'west'.
				/// </remarks>
				compass: "south",
				/// <summary>
				/// A value that indicates the orientation of the footer.
				/// Default: "horizontal".
				/// Type: String.
				/// </summary>
				/// <remarks>
				/// Options are 'horizontal' and 'vertical'.
				/// </remarks>
				orientation: "horizontal",
				/// <summary>
				/// A value that indicates the visibility of the footer.
				/// Default: false.
				/// Type: Boolean.
				/// </summary>
				visible: false
			},
			/// <summary>
			/// An object value indicates the legend of the chart element.
			/// Type: Object.
			/// Default: {text:"", textMargin:{left:2,top:2,right:2,bottom:2},
			///			titleStyle:{"font-weight":"bold",fill:"#000",stroke:"none},
			///			visible:true, style:{fill:"#none", stroke:"none"}, 
			///			textStyle:{fille:"#333", stroke:"none"}, compass:"east", 
			///			orientation:"vertical"}
			/// Code example:
			///  $("#chartcore").wijchartcore({
			///      legend: {
			///			text:"legend",
			///			style:{
			///				fill:"#f1f1f1",
			///				stroke:"#010101"
			///				}}
			///  });
			/// </summary>
			legend: {
				/// <summary>
				/// A value that indicates the text of the legend.
				/// Default: "".
				/// Type: String.
				/// </summary>
				text: "",
				/// <summary>
				/// A value that indicates the text margin of the legend item.
				/// Default: {left:2, top:2, right:2, bottom:2}.
				/// Type: Number.
				/// </summary>
				textMargin: { left: 2, top: 2, right: 2, bottom: 2 },
				/// <summary>
				/// A value that indicates the style of the legend.
				/// Default: {fill:"#none", stroke:"none"}.
				/// Type: Object.
				/// </summary>
				style: {
					fill: "none",
					stroke: "none"
				},
				/// <summary>
				/// A value that indicates the style of the legend text.
				/// Default: {fill:"#333", stroke:"none"}.
				/// Type: Object.
				/// </summary>
				textStyle: {
					fill: "#333",
					stroke: "none"
				},
				/// <summary>
				/// A value that indicates the style of the legend title.
				/// Default: {"font-weight": "bold", fill:"#000", stroke:"none"}.
				/// Type: Object.
				/// </summary>
				titleStyle: {
					"font-weight": "bold",
					fill: "#000",
					stroke: "none"
				},
				/// <summary>
				/// A value that indicates the compass of the legend.
				/// Default: "east".
				/// Type: String.
				/// </summary>
				/// <remarks>
				/// Options are 'north', 'south', 'east' and 'west'.
				/// </remarks>
				compass: "east",
				/// <summary>
				/// A value that indicates the orientation of the legend.
				/// Default: "vertical".
				/// Type: String.
				/// </summary>
				/// <remarks>
				/// Options are 'horizontal' and 'vertical'.
				/// </remarks>
				orientation: "vertical",
				/// <summary>
				/// A value that indicates the visibility of the legend.
				/// Default: true.
				/// Type: Boolean.
				/// </summary>
				visible: true
			},
			/// <summary>
			/// A value that provides information about the axes.
			/// Default: {x:{alignment:"center",
			///		style:{stroke:"#999999","stroke-width":0.5}, visible:true, 
			///		textVisible:true, textStyle:{fill: "#888", "font-size": "15pt",
			///		"font-weight": "bold"},labels: {style: {fill: "#333", 
			///		"font-size": "11pt"},textAlign: "near", width: null},
			///		compass:"south",
			///		autoMin:true,autoMax:true,autoMajor:true,autoMinor:true, 
			///		gridMajor:{visible:false,style:{stroke:"#CACACA",
			///		"stroke-dasharray":"- "}}},gridMinor:{visible:false, 
			///		style:{stroke:"#CACACA","stroke-dasharray":"- "}}},
			///		tickMajor:{position:"none",style:{fill:"black"},factor:1},
			///		tickMinor:{position:"none",style:{fill:"black"},factor:1},
			///		annoMethod:"values",valueLabels:[]},
			///		y:{alignment:"center",style:{stroke: "#999999",
			///		"stroke-width": 0.5},visible:false, textVisible:true, 
			///		textStyle: {fill: "#888","font-size": "15pt",
			///		"font-weight": "bold"},labels: {style: {fill: "#333",
			///		"font-size": "11pt"},textAlign: "center", width: null},
			///		compass:"west",
			///		autoMin:true,autoMax:true,autoMajor:true,autoMinor:true,
			///		gridMajor:{visible:true, style:{stroke:"#999999", 
			///		"stroke-width": "0.5","stroke-dasharray":"none"}}},
			///		gridMinor:{visible:false, style:{stroke:"#CACACA",
			///		"stroke-dasharray":"- "}}},tickMajor:{position:"none",
			///		style:{fill:"black"},factor:1},tickMinor:{position:"none",
			///		style:{fill:"black"},factor:1},annoMethod:"values",valueLabels:[]}.
			/// Type: Object.
			/// </summary>
			axis: {
				/// <summary>
				/// A value that provides information for the X axis.
				/// Default: {alignment:"center",style:{stroke:"#999999",
				///		"stroke-width":0.5}, visible:true, textVisible:true, 
				///		textStyle:{fill: "#888", "font-size": "15pt", 
				///		"font-weight": "bold"}, labels: {style: {fill: "#333", 
				///		"font-size": "11pt"},textAlign: "near", width: null},
				///		compass:"south",
				///		autoMin:true,autoMax:true,autoMajor:true,autoMinor:true,
				///		gridMajor:{visible:false, style:{stroke:"#CACACA",
				///		"stroke-dasharray":"- "}}},gridMinor:{visible:false, 
				///		style:{stroke:"#CACACA","stroke-dasharray":"- "}}},
				///		tickMajor:{position:"none",style:{fill:"black"},factor:1},
				///		tickMinor:{position:"none",style:{fill:"black"},factor:1},
				///		annoMethod:"values",valueLabels:[]}.
				/// Type: Object.
				/// </summary>
				x: {
					/// <summary>
					/// A value that indicates the alignment of the X axis text.
					/// Default: "center".
					/// Type: String.
					/// </summary>
					/// <remarks>
					/// Options are 'center', 'near', 'far'.
					/// </remarks>
					alignment: "center",
					/// <summary>
					/// A value that indicates the style of the X axis.
					/// Default: {stroke: "#999999", "stroke-width": 0.5}.
					/// Type: Object.
					/// </summary>
					style: {
						stroke: "#999999",
						"stroke-width": 0.5
					},
					/// <summary>
					/// A value that indicates the visibility of the X axis.
					/// Default: true.
					/// Type: Boolean.
					/// </summary>
					visible: true,
					/// <summary>
					/// A value that indicates the visibility of the X axis text.
					/// Default: true.
					/// Type: Boolean.
					/// </summary>
					textVisible: true,
					/// <summary>
					/// A value that indicates the text of the X axis text.
					/// Default: "".
					/// Type: String.
					/// </summary>
					text: "",
					/// <summary>
					/// A value that indicates the style of text of the X axis.
					/// Default: {fill: "#888","font-size": "15pt","font-weight": "bold"}.
					/// Type: Object.
					/// </summary>
					textStyle: {
						fill: "#888",
						"font-size": "15pt",
						"font-weight": "bold"
					},
					/// <summary>
					/// A value that provides information for the labels.
					/// Default: {style: {fill: "#333","font-size": "11pt"},
					///			textAlign: "near", width: null}.
					/// Type: Object.
					/// </summary>
					labels: {
						/// <summary>
						/// A value that indicates the style of major text of the X axis.
						/// Default: {fill: "#333","font-size": "11pt"}.
						/// Type: Object.
						/// </summary>
						style: {
							fill: "#333",
							"font-size": "11pt"
						},
						/// <summary>
						/// A value that indicates the alignment
						/// of major text of the X axis.
						/// Default: "near".
						/// Type: String.
						/// </summary>
						/// <remarks>
						/// Options are 'near', 'center' and 'far'.
						/// </remarks>
						textAlign: "near",
						/// <summary>
						/// A value that indicates the width of major text of the X axis.
						/// Default: null.
						/// Type: Number.
						/// <remarks>
						/// If the value is null, then the width 
						/// will be calculated automatically.
						/// </remarks>
						/// </summary>
						width: null
					},
					/// <summary>
					/// A value that indicates the compass of the X axis.
					/// Default: "south".
					/// Type: String.
					/// </summary>
					/// <remarks>
					/// Options are 'north', 'south', 'east' and 'west'.
					/// </remarks>
					compass: "south",
					/// <summary>
					/// A value that indicates whether the minimum axis
					/// value is calculated automatically.
					/// Default: true.
					/// Type: Boolean.
					/// </summary>
					autoMin: true,
					/// <summary>
					/// A value that indicates whether the maximum axis
					/// value is calculated automatically.
					/// Default: true.
					/// Type: Boolean.
					/// </summary>
					autoMax: true,
					/// <summary>
					/// A value that indicates the minimum value of the X axis.
					/// Default: null.
					/// Type: Number.
					/// </summary>
					min: null,
					/// <summary>
					/// A value that indicates the maximum value of the X axis.
					/// Default: null.
					/// Type: Number.
					/// </summary>
					max: null,
					/// <summary>
					/// A value that indicates the origin value of the X axis.
					/// Default: null.
					/// Type: Number.
					/// </summary>
					origin: null,
					/// <summary>
					/// A value that indicates whether the major tick mark
					/// values are calculated automatically.
					/// Default: true.
					/// Type: Boolean.
					/// </summary>
					autoMajor: true,
					/// <summary>
					/// A value that indicates whether the minor tick mark
					/// values are calculated automatically.
					/// Default: true.
					/// Type: Boolean.
					/// </summary>
					autoMinor: true,
					/// <summary>
					/// A value that indicates the units between major tick marks.
					/// Default: null.
					/// Type: Number.
					/// </summary>
					unitMajor: null,
					/// <summary>
					/// A value that indicates the units between minor tick marks.
					/// Default: null.
					/// Type: Number.
					/// </summary>
					unitMinor: null,
					/// <summary>
					/// A value that provides information for the major grid line.
					/// Default: {visible:false,
					///		 style:{stroke:"#CACACA","stroke-dasharray":"- "}}.
					/// Type: Object.
					/// </summary>
					gridMajor: {
						/// <summary>
						/// A value that indicates the visibility of the major grid line.
						/// Default: false.
						/// Type: Boolean.
						/// </summary>
						visible: false,
						/// <summary>
						/// A value that indicates the style of the major grid line.
						/// Default: {stroke:"#CACACA", "stroke-dasharray": "- "}.
						/// Type: Object.
						/// </summary>
						style: {
							stroke: "#CACACA",
							"stroke-dasharray": "- "
						}
					},
					/// <summary>
					/// A value that provides information for the minor grid line.
					/// Default: {visible:false, 
					///			style:{stroke:"#CACACA","stroke-dasharray":"- "}}.
					/// Type: Object.
					/// </summary>
					gridMinor: {
						/// <summary>
						/// A value that indicates the visibility of the minor grid line.
						/// Default: false.
						/// Type: Boolean.
						/// </summary>
						visible: false,
						/// <summary>
						/// A value that indicates the style of the minor grid line.
						/// Default: {stroke:"#CACACA", "stroke-dasharray": "- "}.
						/// Type: Object.
						/// </summary>
						style: {
							stroke: "#CACACA",
							"stroke-dasharray": "- "
						}
					},
					/// <summary>
					/// A value that provides information for the major tick.
					/// Default: {position:"none", style:{fill:"black"}, factor:1}.
					/// Type: Object.
					/// </summary>
					tickMajor: {
						/// <summary>
						/// A value that indicates the type of major tick mark.
						/// Default: "none".
						/// Type: String.
						/// </summary>
						/// <remarks>
						/// Options are 'none', 'inside', 'outside' and 'cross'.
						/// </remarks>
						position: "none",
						/// <summary>
						/// A value that indicates the style of major tick mark.
						/// Default: {fill: "black"}.
						/// Type: Object.
						/// </summary>
						style: { fill: "black" },
						/// <summary>
						/// A value that indicates an integral
						/// factor for major tick mark length.
						/// Default: 1.
						/// Type: Number.
						/// </summary>
						factor: 1
					},
					/// <summary>
					/// A value that provides information for the minor tick.
					/// Default: {position:"none", style:{fill:"black"}, factor:1}.
					/// Type: Object.
					/// </summary>
					tickMinor: {
						/// <summary>
						/// A value that indicates the type of minor tick mark.
						/// Default: "none".
						/// Type: String.
						/// </summary>
						/// <remarks>
						/// Options are 'none', 'inside', 'outside' and 'cross'.
						/// </remarks>
						position: "none",
						/// <summary>
						/// A value that indicates the style of minor tick mark.
						/// Default: {fill: "black"}.
						/// Type: Object.
						/// </summary>
						style: { fill: "black" },
						/// <summary>
						/// A value that indicates an integral
						/// factor for minor tick mark length.
						/// Default: 1.
						/// Type: Number.
						/// </summary>
						factor: 1
					},
					/// <summary>
					/// A value that indicates the method of annotation.
					/// Default: "values".
					/// Type: String.
					/// </summary>
					/// <remarks>
					/// Options are 'values', 'valueLabels'.
					/// </remarks>
					annoMethod: "values",
					/// <summary>
					/// A value that indicates the format string of annotation.
					/// Default: "".
					/// Type: String.
					/// </summary>
					annoFormatString: "",
					/// <summary>
					/// A value that shows a collection of valueLabels for the X axis.
					/// Default: [].
					/// Type: Array.
					/// </summary>
					valueLabels: []
					//todo.
					//autoOrigin: true,
					//origin: null,
					//tickLabel: "nextToAxis",
				},
				/// <summary>
				/// A value that provides infomation for the Y axis.
				/// Default: {alignment:"center",style:{stroke: "#999999",
				///		"stroke-width": 0.5},visible:false, textVisible:true, 
				///		textStyle: {fill: "#888","font-size": "15pt",
				///		"font-weight": "bold"}, labels: {style: {fill: "#333",
				///		"font-size": "11pt"},textAlign: "center", width: null},
				///		compass:"west",
				///		autoMin:true,autoMax:true,autoMajor:true,autoMinor:true,
				///		gridMajor:{visible:true, style:{stroke:"#999999", 
				///		"stroke-width": "0.5", "stroke-dasharray":"none"}}},
				///		gridMinor:{visible:false, style:{stroke:"#CACACA",
				///		"stroke-dasharray":"- "}}},tickMajor:{position:"none",
				///		style:{fill:"black"},factor:1},tickMinor:{position:"none",
				///		style:{fill:"black"},factor:1},annoMethod:"values",
				///		valueLabels:[]}
				/// Type: Object.
				/// </summary>
				y: {
					/// <summary>
					/// A value that indicates the alignment of the Y axis text.
					/// Default: "center".
					/// Type: String.
					/// </summary>
					/// <remarks>
					/// Options are 'center', 'near', 'far'.
					/// </remarks>
					alignment: "center",
					/// <summary>
					/// A value that indicates the style of the Y axis.
					/// Default: {stroke:"#999999", "stroke-width": 0.5}.
					/// Type: Object.
					/// </summary>
					style: {
						stroke: "#999999",
						"stroke-width": 0.5
					},
					/// <summary>
					/// A value that indicates the visibility of the Y axis.
					/// Default: false.
					/// Type: Boolean.
					/// </summary>
					visible: false,
					/// <summary>
					/// A value that indicates the visibility of the Y axis text.
					/// Default: true.
					/// Type: Boolean.
					/// </summary>
					textVisible: true,
					/// <summary>
					/// A value that indicates the text of the Y axis text.
					/// Default: "".
					/// Type: String.
					/// </summary>
					text: "",
					/// <summary>
					/// A value that indicates the style of text of the Y axis.
					/// Default: {fill: "#888", "font-size": "15pt", 
					///			"font-weight": "bold"}.
					/// Type: Object.
					/// </summary>
					textStyle: {
						fill: "#888",
						"font-size": "15pt",
						"font-weight": "bold"
					},
					/// <summary>
					/// A value that provides information for the labels.
					/// Default: {style: {fill: "#333","font-size": "11pt"},
					///			textAlign: "center", width: null}.
					/// Type: Object.
					/// </summary>
					labels: {
						/// <summary>
						/// A value that indicates the style of major text of the Y axis.
						/// Default: {fill: "#333","font-size": "11pt"}.
						/// Type: Object.
						/// </summary>
						style: {
							fill: "#333",
							"font-size": "11pt"
						},
						/// <summary>
						/// A value that indicates the 
						/// of major text of the Y axis.
						/// Default: "center".
						/// Type: String.
						/// </summary>
						/// <remarks>
						/// Options are 'near', 'center' and 'far'.
						/// </remarks>
						textAlign: "center",
						/// <summary>
						/// A value that indicates the width major text of the Y axis.
						/// Default: null.
						/// Type: Number.
						/// <remarks>
						/// If the value is null, then the width
						/// will be calculated automatically.
						/// </remarks>
						/// </summary>
						width: null
					},
					/// <summary>
					/// A value that indicates the compass of the Y axis.
					/// Default: "west".
					/// Type: String.
					/// </summary>
					/// <remarks>
					/// Options are 'north', 'south', 'east' and 'west'.
					/// </remarks>
					compass: "west",
					/// <summary>
					/// A value that indicates whether the minimum axis
					/// value is calculated automatically.
					/// Default: true.
					/// Type: Boolean.
					/// </summary>
					autoMin: true,
					/// <summary>
					/// A value that indicates whether the maximum axis
					/// value is calculated automatically.
					/// Default: true.
					/// Type: Boolean.
					/// </summary>
					autoMax: true,
					/// <summary>
					/// A value that indicates the minimum value of the Y axis.
					/// Default: null.
					/// Type: Number.
					/// </summary>
					min: null,
					/// <summary>
					/// A value that indicates the maximum value of the Y axis.
					/// Default: null.
					/// Type: Number.
					/// </summary>
					max: null,
					/// <summary>
					/// A value that indicates the origin value of the Y axis.
					/// Default: null.
					/// Type: Number.
					/// </summary>
					origin: null,
					/// <summary>
					/// A value that indicates whether the major tick mark
					/// values are calculated automatically.
					/// Default: true.
					/// Type: Boolean.
					/// </summary>
					autoMajor: true,
					/// <summary>
					/// A value that indicates whether the minor tick mark
					/// values are calculated automatically.
					/// Default: true.
					/// Type: Boolean.
					/// </summary>
					autoMinor: true,
					/// <summary>
					/// A value that indicates the units between major tick marks.
					/// Default: null.
					/// Type: Number.
					/// </summary>
					unitMajor: null,
					/// <summary>
					/// A value that indicates the units between minor tick marks.
					/// Default: null.
					/// Type: Number.
					/// </summary>
					unitMinor: null,
					/// <summary>
					/// A value that provides information for the major grid line.
					/// Default: {visible:true, style:{stroke:"#999999", 
					///			"stroke-width": "0.5","stroke-dasharray":"none"}}.
					/// Type: Object.
					/// </summary>
					gridMajor: {
						/// <summary>
						/// A value that indicates the visibility of the major grid line.
						/// Default: true.
						/// Type: Boolean.
						/// </summary>
						visible: true,
						/// <summary>
						/// A value that indicates the style of the major grid line.
						/// Default: {stroke:"#999999", "stroke-width": "0.5", 
						///			"stroke-dasharray": "none"}.
						/// Type: Object.
						/// </summary>
						style: {
							stroke: "#999999",
							"stroke-width": "0.5",
							"stroke-dasharray": "none"
						}
					},
					/// <summary>
					/// A value that provides information for the minor grid line.
					/// Default: {visible:false, style:{stroke:"#CACACA",
					///			"stroke-dasharray":"- "}}.
					/// Type: Object.
					/// </summary>
					gridMinor: {
						/// <summary>
						/// A value that indicates the visibility of the minor grid line.
						/// Default: false.
						/// Type: Boolean.
						/// </summary>
						visible: false,
						/// <summary>
						/// A value that indicates the style of the minor grid line.
						/// Default: {stroke:"#CACACA", "stroke-dasharray": "- "}.
						/// Type: Object.
						/// </summary>
						style: {
							stroke: "#CACACA",
							"stroke-dasharray": "- "
						}
					},
					/// <summary>
					/// A value that provides information for the major tick.
					/// Default: {position:"none", style:{fill:"black"}, factor:1}.
					/// Type: Object.
					/// </summary>
					tickMajor: {
						/// <summary>
						/// A value that indicates the type of major tick mark.
						/// Default: "none".
						/// Type: String.
						/// </summary>
						/// <remarks>
						/// Options are 'none', 'inside', 'outside' and 'cross'.
						/// </remarks>
						position: "none",
						/// <summary>
						/// A value that indicates the style of major tick mark.
						/// Default: {fill: "black"}.
						/// Type: Object.
						/// </summary>
						style: { fill: "black" },
						/// <summary>
						/// A value that indicates an integral factor
						/// for major tick mark length.
						/// Default: 1.
						/// Type: Number.
						/// </summary>
						factor: 1
					},
					/// <summary>
					/// A value that provides information for the minor tick.
					/// Default: {position:"none", style:{fill:"black"}, factor:1}.
					/// Type: Object.
					/// </summary>
					tickMinor: {
						/// <summary>
						/// A value that indicates the type of minor tick mark.
						/// Default: "none".
						/// Type: String.
						/// </summary>
						/// <remarks>
						/// Options are 'none', 'inside', 'outside' and 'cross'.
						/// </remarks>
						position: "none",
						/// <summary>
						/// A value that indicates the style of minor tick mark.
						/// Default: {fill: "black"}.
						/// Type: Object.
						/// </summary>
						style: { fill: "black" },
						/// <summary>
						/// A value that indicates an integral
						/// factor for minor tick mark length.
						/// Default: 1.
						/// Type: Number.
						/// </summary>
						factor: 1
					},
					/// <summary>
					/// A value that indicates the method of annotation.
					/// Default: "values".
					/// Type: String.
					/// </summary>
					/// <remarks>
					/// options are 'values', 'valueLabels'.
					/// </remarks>
					annoMethod: "values",
					/// <summary>
					/// A value that indicates the format string of annotation.
					/// Default: "".
					/// Type: String.
					/// </summary>
					annoFormatString: "",
					/// <summary>
					/// A value that shows a collection of valueLabels for the y axis.
					/// Default: [].
					/// Type: Array.
					/// </summary>
					valueLabels: []
					//todo.
					//autoOrigin: true,
					//origin: null,
					//tickLabel: "nextToAxis",
				}
			},
			/// <summary>
			/// A value that is used to indicate whether to show
			/// and what to show on the open tooltip.
			/// Default: {enable:true, content:null, 
			///			contentStyle: {fill: "#d1d1d1","font-size": "16pt"},
			///			title:null, 
			///			titleStyle: {fill: "#d1d1d1","font-size": "16pt"},
			///			style: {fill: "270-#333333-#000000", "stroke-width": "2"},
			///			animated: "fade", showAnimated: "fade", hideAnimated: "fade",
			///			duration: 120, showDuration: 120, hideDuration: 120,
			///			showDelay: 150, hideDelay: 150, easing: "", 
			///			showEasing: "", hideEasing: "",
			///			compass:"north", offsetX: 0, offsetY: 0,  
			///			showCallout: true, calloutFilled: false, 
			///			calloutFilledStyle: {fill: "#000"}}.
			/// Type: Function.
			/// Code example:
			/// $("#chartcore").wijchartcore({
			///		hint: {
			///			enable:true,
			///			content:function(){
			///				return this.data.label + " : " + 
			///					this.value/this.total*100 + "%";
			///			}});
			/// </summary>
			hint: {
				/// <summary>
				/// A value that indicates whether to show the tooltip.
				/// Default: true.
				/// Type: Boolean.
				/// </summary>
				enable: true,
				/// <summary>
				/// A value that will be shown in the content part of the tooltip 
				///	or a function which is used to get a value for the tooltip shown.
				/// Default: null.
				/// Type: String or Function.
				/// </summary>
				content: null,
				/// <summary>
				/// A value that indicates the style of content text.
				/// Default: {fill: "#d1d1d1","font-size": "16pt"}.
				/// Type: Object.
				/// </summary>
				contentStyle: {
					fill: "#d1d1d1",
					"font-size": "16pt"
				},
				/// <summary>
				/// A value that will be shown in the title part of the tooltip 
				///	or a function which is used to get a value for the tooltip shown.
				/// Default: null.
				/// Type: String or Function.
				/// </summary>
				title: null,
				/// <summary>
				/// A value that indicates the style of title text.
				/// Default: {fill: "#d1d1d1","font-size": "16pt"}.
				/// Type: Object.
				/// </summary>
				titleStyle: {
					fill: "#d1d1d1",
					"font-size": "16pt"
				},
				/// <summary>
				/// A value that indicates the style of container.
				/// Default: {fill: "270-#333333-#000000", "stroke-width": "2"}.
				/// Type: Object.
				/// </summary>
				style: {
					fill: "270-#333333-#000000",
					"stroke-width": "2"
				},
				/// <summary>
				/// A value that indicates the effect during show or hide 
				///	when showAnimated or hideAnimated isn't specified.
				/// Default:"fade".
				/// Type:String.
				/// </summary>
				animated: "fade",
				/// <summary>
				/// A value that indicates the effect during show.
				/// Default:"fade".
				/// Type:String.
				/// </summary>
				showAnimated: "fade",
				/// <summary>
				/// A value that indicates the effect during hide.
				/// Default:"fade".
				/// Type:String.
				/// </summary>
				hideAnimated: "fade",
				/// <summary>
				/// A value that indicates the millisecond to show or hide the tooltip
				///	when showDuration or hideDuration isn't specified.
				/// Default:120.
				/// Type:Number.
				/// </summary>
				duration: 120,
				/// <summary>
				/// A value that indicates the millisecond to show the tooltip.
				/// Default:120.
				/// Type:Number.
				/// </summary>
				showDuration: 120,
				/// <summary>
				/// A value that indicates the millisecond to hide the tooltip.
				/// Default:120.
				/// Type:Number.
				/// </summary>
				hideDuration: 120,
				/// <summary>
				/// A value that indicates the easing during show or hide when
				///	showEasing or hideEasing isn't specified. 
				/// Default: "".
				/// Type: String.
				/// </summary>
				easing: "", 
				/// <summary>
				/// A value that indicates the easing during show. 
				/// Default: "".
				/// Type: String.
				/// </summary>
				showEasing: "", 
				/// <summary>
				/// A value that indicates the easing during hide. 
				/// Default: "".
				/// Type: String.
				/// </summary>
				hideEasing: "",
				/// <summary>
				/// A value that indicates the millisecond delay to show the tooltip.
				/// Default: 150.
				/// Type: Number.
				/// </summary>
				showDelay: 150,
				/// <summary>
				/// A value that indicates the millisecond delay to hide the tooltip.
				/// Default: 150.
				/// Type: Number.
				/// </summary>
				hideDelay: 150,				
				/// <summary>
				/// A value that indicates the compass of the tooltip.
				/// Default: "north".
				/// Type: String.
				/// </summary>
				/// <remarks>
				/// Options are 'west', 'east', 'south', 'north', 
				///	'southeast', 'southwest', 'northeast', 'northwest'.
				/// </remarks>
				compass: "north",
				/// <summary>
				/// A value that indicates the horizontal offset 
				///	of the point to show the tooltip.
				/// Default: 0.
				/// Type: Number.
				/// </summary>
				offsetX: 0,
				/// <summary>
				/// A value that indicates the vertical offset 
				///	of the point to show the tooltip.
				/// Default: 0.
				/// Type: Number.
				/// </summary>
				offsetY: 0,
				/// <summary>
				/// Determines whether to show the callout element.
				/// Default:true.
				/// Type:Boolean.
				/// </summary>
				showCallout: true,
				/// <summary>
				/// Determines whether to fill the callout.  
				///	If true, then the callout triangle will be filled.
				/// Default:false.
				/// Type:Boolean.
				/// </summary>
				calloutFilled: false,
				/// <summary>
				/// A value that indicates the style of the callout filled.
				/// Default: {fill: "#000"}.
				/// Type: Object.
				/// </summary>
				calloutFilledStyle: {
					fill: "#000"
				}
			},
			/// <summary>
			/// A value that indicates whether to show default chart labels.
			/// Default: true.
			/// Type: Boolean.		
			/// Code example:
			/// $("#chartcore").wijchartcore({
			///		showChartLabels:true
			///		});
			/// </summary>
			showChartLabels: true,
			/// <summary>
			/// A value that indicates style of the chart labels.
			/// Default: {}.
			/// Type: Object.
			/// </summary>
			chartLabelStyle: {},
			/// <summary>
			/// A value that indicates the format string of the chart labels.
			/// Default: "".
			/// Type: String.
			/// </summary>
			chartLabelFormatString: "",
			/// <summary>
			/// A value that indicates whether to disable the default text style.
			/// Default: false.
			/// Type: Boolean.
			/// Code example:
			/// $("#chartcore").wijchartcore({
			///		disableDefaultTextStyle:true
			///		});
			/// </summary>
			disableDefaultTextStyle: false,
			/// <summary>
			/// A value that indicates whether to show shadow for the chart.
			/// Default: false.
			/// Type: Boolean.
			/// Code example:
			/// $("#chartcore").wijchartcore({
			///		shadow:true
			///		});
			/// </summary>
			shadow: true,
			/// <summary>
			/// Occurs before the series changes.  This event can be cancelled. 
			/// "return false;" to cancel the event.
			/// Default: null.
			/// Type: Function.
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains old and new series values.
			/// data.oldSeriesList: old series list before change.
			///	data.newSeriesList: new series list that will replace old one.  
			///	</param>
			beforeSeriesChange: null,
			/// <summary>
			/// Occurs when the series changes. 
			/// Default: null.
			/// Type: Function.
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains new series values.  
			///	</param>
			seriesChanged: null,
			/// <summary>
			/// Occurs before the canvas is painted.  This event can be cancelled.
			/// "return false;" to cancel the event.
			/// Default: null.
			/// Type: Function.
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			beforePaint: null,
			/// <summary>
			/// Occurs after the canvas is painted. 
			/// Default: null.
			/// Type: Function.
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			painted: null
		},

		innerState: {},

		// handle option changes:
		_setOption: function (key, value) {
			var self = this,
				o = self.options,
				ev = null,
				len = 0,
				idx = 0,
				styleLen, 
				hoverStyleLen;

			if (key === "seriesList") {
				if (!value) {
					value = [];
				}
				ev = $.Event("beforeserieschange");
				if (self._trigger("beforeSeriesChange", ev, {
						oldSeriesList: o.seriesList,
						newSeriesList: value
					}) === false) {
					return false;
				}
				o.seriesList = value;
				self._trigger("seriesChanged", null, value);
				self.seriesTransition = true;
			} else {
				if ($.isPlainObject(o[key])) {
					$.extend(true, o[key], value);
				} else {
					$.Widget.prototype._setOption.apply(self, arguments);
					//o[key] = value;
				}
			}

			//Add for support disabled option at 2011/7/8
			if (key === "disabled") {
				self._handleDisabledOption(value, self.element);
			}
			//end for disabled option

			if (key === "seriesTransition" || key === "animation" 
				|| key === "disabled") {
				return;
			}

			len = o.seriesList.length;

			if (key === "seriesList" || key === "seriesStyles") {
				for (styleLen = o.seriesStyles.length, idx = styleLen; idx < len; idx++) {
					o.seriesStyles[idx] = o.seriesStyles[idx % styleLen];
				}
			}

			if (key === "seriesList" || key === "seriesHoverStyles") {
				hoverStyleLen = o.seriesHoverStyles.length;
				for (idx = hoverStyleLen; idx < len; idx++) {
					o.seriesHoverStyles[idx] = o.seriesHoverStyles[idx % hoverStyleLen];
				}
			}

			self.redraw();
		},

		// widget creation:
		_create: function () {
			var self = this,
				o = self.options,
				width = o.width || self.element.width(),
				height = o.height || self.element.height(),
				newEle = null;

			self.updating = 0;
			self.innerState = {};

			if (self.element.length > 0) {
				if (self.element.is("table")) {
					self._parseTable();
					newEle = $("<div></div>");

					if (width) {
						newEle.css("width", width);
					}

					if (height) {
						newEle.css("height", height);
					}

					self.element.after(newEle);
					self.chartElement = newEle;
				} else {
					self.chartElement = self.element;
				}

				//add for fixing bug 16039 by wuhao 2011/7/7
				if(o.disabled){
					self.disable();
				}
				//end for bug 16039

				self.chartElement.addClass("ui-widget");
				self.canvas = new Raphael(self.chartElement[0], width, height);
			}

			self.headerEles = [];
			self.footerEles = [];
			self.legendEles = [];
			self.axisEles = [];
			self.legends = [];
			self.legendIcons = [];
			self.chartLabelEles = [];
		},

		_handleDisabledOption: function (disabled, ele) {
			var self = this;

			if (disabled) {
				if (!self.disabledDiv) {
					self.disabledDiv = self._createDisabledDiv(ele);
				}
				self.disabledDiv.appendTo("body");
			}
			else {
				if (self.disabledDiv) {
					self.disabledDiv.remove();
					self.disabledDiv = null;
				}
			}
		},

		_createDisabledDiv: function (outerEle) {
			var self = this,
			//Change your outerelement here
				ele = outerEle? outerEle:self.element,
				eleOffset = ele.offset(),
				disabledWidth = ele.outerWidth(),
				disabledHeight = ele.outerHeight();

			return $("<div></div>")
						.addClass("ui-disabled")
						.css({
							"z-index": "99999",
							position: "absolute",
							width: disabledWidth,
							height: disabledHeight,
							left: eleOffset.left,
							top: eleOffset.top
						});
		},

		_init: function () {
			var self = this;

			if (!self.rendered) {
				self._paint();

				if (self.rendered) {
					self._bindLiveEvents();
				}
			}
		},

		destroy: function () {
			var self = this;
			self._unbindLiveEvents();
			self._clearChartElement();
			self.chartElement.removeClass("ui-widget");
			if (self.element !== self.chartElement) {
				self.chartElement.remove();
			}

			self.element.empty();

			//Add for fixing bug 16039
			if(self.disabledDiv){
				self.disabledDiv.remove();
				self.disabledDiv = null;
			} 
			//end for bug 16039

			$.Widget.prototype.destroy.apply(self, arguments);
		},

		/*****************************
		Widget specific implementation
		******************************/
		/** public methods */
		getCanvas: function () {
			/// <summary>
			/// Returns a reference to the Raphael canvas object.
			/// </summary>
			/// <returns type="Raphael">
			/// Reference to raphael canvas object.
			/// </returns>
			return this.canvas;
		},

		addSeriesPoint: function (seriesIndex, point, shift) {
			/// <summary>
			/// Add series point to the series list.
			/// </summary>
			/// <param name="seriesIndex" type="Number">
			/// The index of the series that the point will be inserted to.
			/// </param>
			/// <param name="point" type="Object">
			/// The point that will be inserted to.
			/// </param>
			/// <param name="shift" type="Boolean">
			/// A value that indicates whether to shift the first point.
			/// </param>
			var seriesList = this.options.seriesList,
				series = null, 
				data = null;

			if (seriesIndex >= seriesList.length) {
				return;
			}

			series = seriesList[seriesIndex];
			data = series.data || [];
			data.x.push(point.x);
			data.y.push(point.y);

			if (shift) {
				data.x.shift();
				data.y.shift();
			}

			this._setOption("seriesList", seriesList);
		},

		beginUpdate: function () {
			var self = this;
			self.updating++;
		},

		endUpdate: function () {
			var self = this;
			self.updating--;
			self.redraw();
		},

		redraw: function (drawIfNeeded) {
			/// <summary>
			/// Redraw the chart.
			/// </summary>
			/// <param name="drawIfNeeded" type="Boolean">
			/// A value that indicates whether to redraw the chart 
			///	no matter whether the chart is painted.
			/// If true, then only when the chart is not created before, 
			/// it will be redrawn.  Otherwise, the chart will be forced to redraw.  
			///	The default value is false.
			/// </param>
			var self = this,
				o = self.options,
				width = 0, 
				height = 0;

			if (self.updating > 0) {
				return;
			}

			if (drawIfNeeded && self.rendered) {
				return;
			}

			width = o.width || self.element.width();
			height = o.height || self.element.height();

			if (width < 1 || height < 1) {
				return;
			}
			 
			self.canvas.setSize(width, height);

			self._unbindLiveEvents();
			self._paint();
			self._bindLiveEvents();
		},

		getSVG: function () {
			if (Raphael.type === "SVG") {
				return this.chartElement.html();
			}

			return this.canvas.wij.getSVG();
		},

		exportChart: function () {
			var form = document.createElement("form"),
				svg = this.getSVG();

			form.action = "http://export.highcharts.com/";
			form.method = "post";
			form.style.display = "none";
			document.body.appendChild(form);

			$.each(['filename', 'type', 'width', 'svg'], function (idx, name) {
				var input = document.createElement("input");

				$(input).attr("name", name).attr("type", "hidden").attr("value", {
					filename: 'chart',
					type: "image/png",
					width: 600,
					svg: svg
				}[name]);

				form.appendChild(input);
			});

			form.submit();
			document.body.removeChild(form);
		},
		
		round: function (val, digits) {
			var factor = Math.pow(10, digits),
				tempVal = val * factor;
			tempVal = Math.round(tempVal);

			return tempVal / factor;
		},

		/** Private methods */
		_parseTable: function () {
			if (!this.element.is("table")) {
				return;
			}
			var self = this,
				ele = self.element,
				o = self.options,
				//header & footer
				captions = $("caption", ele),
				theaders = $("thead th", ele),
				seriesList = [],
				sList = $("tbody tr", ele);

			if (captions.length) {
				o.header = $.extend({
					visible: true,
					text: $.trim($(captions[0]).text())
				}, o.header);
				if (captions.length > 1) {
					o.footer = $.extend({
						visibel: true,
						text: $.trim($(captions[1]).text())
					}, o.footer);
				}
			}
			//legend
			o.legend = $.extend({
				visible: true
			}, o.legend);

			self._getSeriesFromTR(theaders, sList, seriesList);

			self.options.seriesList = seriesList;
		},

		_getSeriesFromTR: function (theaders, sList, seriesList) {
			var valuesX = [],
				val = null, 
				th = null,
				label = null, 
				valuesY = null,
				tds = null, 
				td = null,
				series = null;
			//seriesList
			if (theaders.length) {
				theaders.each(function () {
					val = $.trim($(this).text());
					valuesX.push(val);
				});
			}
			if (sList.length) {
				sList.each(function () {
					th = $("th", $(this));
					label = $.trim(th.text());
					valuesY = [];
					tds = $("td", $(this));
					if (tds.length) {
						tds.each(function () {
							td = $(this);
							valuesY.push(parseFloat($.trim(td.text())));
						});
					}
					series = {
						label: label,
						legendEntry: true,
						data: {
							x: valuesX,
							y: valuesY
						}
					};
					seriesList.push(series);
				});
			}
		},

		_clearChartElement: function () {
			var self = this;

			if (self.headerEles.length) {
				$.each(self.headerEles, function (idx, headerEle) {
					headerEle.wijRemove();
					headerEle = null;
				});
				self.headerEles = [];
			}
			if (self.footerEles.length) {
				$.each(self.footerEles, function (idx, footerEle) {
					footerEle.wijRemove();
					footerEle = null;
				});
				self.footerEles = [];
			}
			if (self.legendEles.length) {
				$.each(self.legendEles, function (idx, legendEle) {
					legendEle.wijRemove();
					legendEle = null;
				});
				self.legendEles = [];
			}
			if (self.legends.length) {
				$.each(self.legends, function (idx, legend) {
					legend.wijRemove();
					legend = null;
				});
				self.legends = [];
			}
			if (self.legendIcons.length) {
				$.each(self.legendIcons, function (idx, legendIcon) {
					legendIcon.wijRemove();
					legendIcon = null;
				});
				self.legendIcons = [];
			}
			if (self.axisEles.length) {
				$.each(self.axisEles, function (idx, axisEle) {
					axisEle.wijRemove();
					axisEle = null;
				});
				self.axisEles = [];
			}
			if (self.chartLabelEles.length) {
				$.each(self.chartLabelEles, function (idx, chartLabelEle) {
					chartLabelEle.wijRemove();
					chartLabelEle = null;
				});
				self.chartLabelEles = [];
			}

			self.canvas.clear();
			self.innerState = {};
		},

		_text: function (x, y, text) {
			var textElement = this.canvas.text(x, y, text);

			if (this.options.disableDefaultTextStyle) {
				textElement.node.style.cssText = "";
			}

			return textElement;
		},
		
		_getDiffAttrs: function (attrs, newAttrs) {
			var result = {};
			$.each(newAttrs, function (key, attr) {
				if (typeof (attrs) === "undefined") {
				}
				else if (typeof (attrs[key]) === "undefined") {
					result[key] = newAttrs[key];
				} else if (attrs[key] !== newAttrs[key]) {
					result[key] = newAttrs[key];
				}
			});
			return result;
		},

		_paintShadow: function (element, offset, stroke) {
			if (this.options.shadow) {
				offset = offset || 1;
				stroke = stroke || "#CCCCCC";
				var shadow = element.clone();
				shadow.insertBefore(element);
				shadow.attr({
					translation: offset + " " + offset,
					stroke: stroke,
					"stroke-width": offset
				});
				shadow.toBack();
				shadow.offset = offset;
				element.shadow = shadow;
			}
		},

		_paint: function () {
			var self = this,
				o = self.options,
				element = self.element,
				hidden = element.css("display") === "none" || 
						element.css("visibility") === "hidden",
				oldLeft = {},
				oldPosition = null;
				//ev = $.Event("beforepaint");

			if (hidden) {
				oldLeft = element.css("left");
				oldPosition = element.css("position");
				element.css("left", "-10000px");
				element.css("position", "absolute");
				element.show();
			}

			if (element.is(":hidden")) {
				return;
			}

			self._clearChartElement();
			if (self._trigger("beforePaint") === false) {
				return;
			}
			//self._trigger("beforepaint", ev);

			//if (ev.isImmediatePropagationStopped()) {
			//	return false;
			//}

			self.canvasBounds = {
				startX: 0,
				endX: o.width || element.width(),
				startY: 0,
				endY: o.height || element.height()
			};
			self._paintHeader();
			self._paintFooter();
			self._paintLegend();
			self._paintChartArea();
			self._paintChartLabels();
			self._trigger("painted");
			
			self.rendered = true;

			if (hidden) {
				element.css("left", oldLeft);
				element.css("position", oldPosition);
				element.hide();
			}
		},

		_calculatePosition: function (compass, width, height) {
			var point = { x: 0, y: 0 },
				marginX = 5,
				marginY = 5,
				canvasBounds = this.canvasBounds;
			switch (compass) {
			case "north":
				point.x = (canvasBounds.endX - canvasBounds.startX) / 2;
				point.y = canvasBounds.startY + height / 2 + marginY;
				canvasBounds.startY = canvasBounds.startY + marginY * 2 + height;
				break;
			case "south":
				point.x = (canvasBounds.endX - canvasBounds.startX) / 2;
				point.y = canvasBounds.endY - height / 2 - marginY;
				canvasBounds.endY = canvasBounds.endY - marginY * 2 - height;
				break;
			case "east":
				point.x = canvasBounds.endX - width / 2 - marginX;
				point.y = (canvasBounds.endY - canvasBounds.startY) / 2;
				canvasBounds.endX = canvasBounds.endX - marginX * 2 - width;
				break;
			case "west":
				point.x = canvasBounds.startX + width / 2 + marginX;
				point.y = (canvasBounds.endY - canvasBounds.startY) / 2;
				canvasBounds.startX = canvasBounds.startX + marginX * 2 + width;
				break;
			}
			return point;
		},

		_paintHeader: function () {
			var headerMargin = 2,
				self = this,
				o = self.options,
				header = o.header,
				compass = null, 
				headerText = null, 
				textStyle = null,
				bBox = null, 
				point = null, 
				box = null,
				rotation = 0, 
				headerContainer = null;

			if (header.text && header.text.length > 0 && header.visible) {
				compass = header.compass;
				headerText = self._text(0, 0, header.text);
				//update for fixing bug 15884 at 2011/7/5
				//textStyle = $.extend(true, {}, o.textStyle, header.textStyle);
				rotation = self._getRotationByCompass(compass);
				textStyle = $.extend(true, {}, o.textStyle, { rotation: rotation}, header.textStyle);
				//end for fixing bug 15884.

				headerText.attr(textStyle);
				bBox = headerText.wijGetBBox();
				point = self._calculatePosition(compass, bBox.width, bBox.height);

				headerText.translate(point.x, point.y);
				box = headerText.wijGetBBox();
				headerContainer = self.canvas.rect(
					box.x - headerMargin, 
					box.y - headerMargin, 
					box.width + 2 * headerMargin, 
					box.height + 2 * headerMargin
				);

				headerContainer.attr(header.style);
				headerContainer.toBack();

				self.headerEles.push(headerText);
				self.headerEles.push(headerContainer);
				
			}
		},

		_paintFooter: function () {
			var footerMargin = 2,
				self = this,
				o = self.options,
				footer = o.footer,
				compass = null, 
				footerText = null, 
				textStyle = null,
				bBox = null, 
				point = null, 
				box = null,
				rotation = 0,
				footerContainer = null;

			if (footer.text && footer.text.length > 0 && footer.visible) {
				compass = footer.compass;
				footerText = self._text(0, 0, footer.text);
				//update for fixing bug 15884 at 2011/7/5
				//textStyle = $.extend(true, {}, o.textStyle, footer.textStyle);
				rotation = self._getRotationByCompass(compass);
				textStyle = $.extend(true, {}, o.textStyle, { rotation: rotation}, footer.textStyle);
				//end for fixing bug 15884

				footerText.attr(textStyle);
				bBox = footerText.wijGetBBox();
				point = self._calculatePosition(compass, bBox.width, bBox.height);

				footerText.translate(point.x, point.y);
				box = footerText.wijGetBBox();
				footerContainer = self.canvas.rect(
					box.x - footerMargin, 
					box.y - footerMargin, 
					box.width + 2 * footerMargin, 
					box.height + 2 * footerMargin
				);

				footerContainer.attr(footer.style);
				footerContainer.toBack();

				self.footerEles.push(footerText);
				self.footerEles.push(footerContainer);
			}
		},

		_getRotationByCompass : function(compass){
			var rotation = 0;

			if(compass === "east"){
				rotation = 270;
			}else if(compass === "west"){
				rotation = -90;
			}

			return rotation;
		},

		_paintLegend: function () {
			var self = this,
				o = self.options,
				legend = {
					size: {
						width: 22,
						height: 10
					}
				},
				legendMargin = 2,
				seriesList = o.seriesList,
				seriesStyles = o.seriesStyles,
				tempSeriesList = seriesList,
				compass, 
				orientation, 
				legendTitle, 
				textStyle,
				legendLen, 
				textMargin,
				canvasBounds = self.canvasBounds,
				canvasWidth = canvasBounds.endX - canvasBounds.startX,
				canvasHeight = canvasBounds.endY - canvasBounds.startY,
				iconWidth = 0, 
				iconHeight = 0,
				titleHeight = 0, 
				maxWidth = 0, 
				maxHeight = 0,
				totalWidth = 0, 
				totalHeight = 0,
				columnNum = 1,
				rowNum = 0, 
				width = 0, 
				height = 0,
				offsetY = 0,
				index = 0, 
				point, 
				left, 
				top, 
				legendContainer,
				legendIconStyles = [];

			$.extend(true, legend, o.legend);
			if (!legend.visible) {
				return;
			}

			compass = legend.compass;
			orientation = legend.orientation;
			iconWidth = legend.size.width;
			iconHeight = legend.size.height;

			if (legend.text && legend.text.length) {
				legendTitle = self._text(0, 0, legend.text);
				textStyle = $.extend(true, {}, o.textStyle, 
					legend.textStyle, legend.titleStyle);
				legendTitle.attr(textStyle);
				self.legendEles.push(legendTitle);
			}

			if (legend.reversed) {
				tempSeriesList = [].concat(seriesList).reverse();
			}
			
			$.each(tempSeriesList, function (idx, series) {
				series = $.extend({ legendEntry: true }, series);
						
				var seriesStyle = seriesStyles[idx],
					chartStyle = $.extend(true, {
						fill: "none",
						opacity: 1,
						stroke: "black"
					}, seriesStyle),
					text, 
					textStyle, 
					chtStyle, 
					icon;

				if (series.legendEntry) {
					text = self._text(0, 0, series.label);
					textStyle = $.extend(true, {}, o.textStyle, legend.textStyle);
					text.attr(textStyle);
					self.legends.push(text);
					chtStyle = $.extend(chartStyle, { "stroke-width": 1 });
					icon = self.canvas.rect(0, 0, iconWidth, iconHeight);
					icon.attr(chtStyle);
					self.legendIcons.push(icon);

					legendIconStyles.push(chtStyle);
				}
			});

			legendLen = self.legends.length;
			textMargin = legend.textMargin;

			if (legendTitle) {
				titleHeight = legendTitle.wijGetBBox().height;
			}

			$.each(self.legends, function (idx, legend) {
				var bBox = legend.wijGetBBox();
					
				if (bBox.width > maxWidth) {
					maxWidth = bBox.width;
				}

				if (bBox.height > maxHeight) {
					maxHeight = bBox.height;
				}
			});

			if (compass === "east" || compass === "west") {
				if (orientation === "horizontal") {
					totalWidth = legendLen * (maxWidth + iconWidth + legendMargin) + 
						legendLen * (textMargin.left + textMargin.right);
					if (totalWidth > canvasWidth / 2) {
						columnNum = Math.floor(canvasWidth / 2 / maxWidth);
						if (columnNum < 1) {
							columnNum = 1;
						}
					} else {
						columnNum = legendLen;
					}
				} else if (orientation === "vertical") {
					totalHeight = maxHeight * legendLen + titleHeight + legendLen * 
						(textMargin.top + textMargin.bottom);
					if (totalHeight > canvasHeight) {
						columnNum = Math.ceil(totalHeight / canvasHeight);
					} else {
						columnNum = 1;
					}
				}
			} else if (compass === "south" || compass === "north") {
				if (orientation === "horizontal") {
					totalWidth = (maxWidth + iconWidth + legendMargin) * legendLen + 
						legendLen * (textMargin.left + textMargin.right);
					if (totalWidth > canvasWidth) {
						columnNum = Math.floor(legendLen / totalWidth * canvasWidth);
						if (columnNum < 1) {
							columnNum = 1;
						}
					} else {
						columnNum = legendLen;
					}
				} else if (orientation === "vertical") {
					totalHeight = maxHeight * legendLen + titleHeight + 
						legendLen * (textMargin.top + textMargin.bottom);
					if (totalHeight > canvasHeight / 2) {
						rowNum = Math.floor(canvasHeight - titleHeight) / 
							2 / maxHeight;
						columnNum = Math.ceil(legendLen / rowNum);
					} else {
						columnNum = 1;
					}
				}
			}

			width = columnNum * (maxWidth + iconWidth + legendMargin) + 
				columnNum * (textMargin.left + textMargin.right);
			height = maxHeight * Math.ceil(legendLen / columnNum) + 
				titleHeight + Math.ceil(legendLen / columnNum) * 
				(textMargin.top + textMargin.bottom);

			point = self._calculatePosition(compass, width, height);
			left = point.x - width / 2;
			top = point.y - height / 2;
			legendContainer = self.canvas.rect(left - legendMargin, top - legendMargin,
					width + 2 * legendMargin, height + 2 * legendMargin);
			legendContainer.attr(legend.style);
			legendContainer.toBack();
			self.legendEles.push(legendContainer);

			if (legendTitle) {
				legendTitle.translate(left + width / 2, top + titleHeight / 2);
			}
			
			offsetY = titleHeight;

			$.each(self.legends, function (idx, legend) {
				var bBox = legend.wijGetBBox(),
					icon = self.legendIcons[idx],
					x = left + index * (iconWidth + maxWidth + legendMargin) + 
						(index + 1) * textMargin.left + index * textMargin.right,
					y = top + offsetY + bBox.height / 2 + textMargin.top,
					iconY = y - icon.wijGetBBox().height / 2, chtStyle;

				icon.translate(x, y - icon.wijGetBBox().height / 2);

				icon.remove();
				icon = self.canvas.rect(x, iconY, iconWidth, iconHeight);
				self.legendIcons[idx] = icon;
				chtStyle = legendIconStyles[idx];
				if(chtStyle) {
					icon.attr(chtStyle);
				}

				legend.translate(x + iconWidth + legendMargin + bBox.width / 2, y);
				legend.toFront();

				index++;

				if (index === columnNum) {
					index = 0;
					offsetY += maxHeight + textMargin.top + textMargin.bottom;
				}
			});
		},

		_hasAxes: function () {
			if (this.widgetName === "wijpiechart") {
				return false;
			}
			return true;
		},

		_applyAxisText: function (axisOptions, axisInfo) {
			var	self = this, 
				text = axisOptions.text,
				textBounds = null,
				tempText = null,
				textStyle = null,
				textMarginVer = 0,
				textMarginHor = 0,
				canvasBounds = self.canvasBounds;

			if (text && text.length > 0) {
				tempText = self._text(-100, -100, text);
				textStyle = $.extend(true, {}, 
					self.options.textStyle, axisOptions.textStyle);
				tempText.attr(textStyle);
				textBounds = tempText.wijGetBBox();
				if (textStyle["margin-left"]) {
					textMarginHor += parseFloat(textStyle["margin-left"]);
				}
				if (textStyle["margin-top"]) {
					textMarginVer += parseFloat(textStyle["margin-top"]);
				}
				if (textStyle["margin-right"]) {
					textMarginHor += parseFloat(textStyle["margin-right"]);
				}
				if (textStyle["margin-bottom"]) {
					textMarginVer += parseFloat(textStyle["margin-bottom"]);
				}

				switch (axisOptions.compass) {
				case "north":
					canvasBounds.startY += (textBounds.height + textMarginVer);
					break;
				case "south":
					canvasBounds.endY -= (textBounds.height + textMarginVer);
					break;
				case "east":
					canvasBounds.endX -= (textBounds.height + textMarginHor);
					break;
				case "west":
					canvasBounds.startX += (textBounds.height + textMarginHor);
					break;
				}
				tempText.wijRemove();
			}

			return textBounds;
		},

		_paintChartArea: function () {
			var self = this,
				o = self.options,
				axisOption = o.axis,
				sl = o.seriesList,
				//The value is used to offset the tick major
				// text from the tick rect.
				axisTextOffset = 2,
				xTextBounds = null, 
				yTextBounds = null,
				extremeValue = null,
				maxtries = 5, 
				isDataEmpty = false,
				offsetX = 0, 
				offsetY = 0;

			self._applyMargins();
			if (!sl || sl.length === 0) {
				return;
			}
			$.each(sl, function (idx, s) {
				if (self._isPieChart()) {
					if (!s.data || !s.label || s.label.length === 0) {
						isDataEmpty = true;
					}
				} else {
					if (!s.data || ((!s.data.x || !s.data.y) && !s.data.xy)) {
						isDataEmpty = true;
					}
				}
			});
			if (isDataEmpty) {
				return;
			}

			if (self._hasAxes()) {
				//Restore from cache.
				if (self.innerState.axisInfo) {
					self.axisInfo = self.innerState.axisInfo;
					self.canvasBounds = self.innerState.canvasBounds;
				} else {
					xTextBounds = self._applyAxisText(axisOption.x, {});
					yTextBounds = self._applyAxisText(axisOption.y, {});

					self.axisInfo = {
						x: {
							id: "x",
							tprec: 0,
							isTime: false,
							offset: 0,
							vOffset: 0,
							max: 0,
							min: 0,
							majorTickRect: null,
							minorTickRect: null,
							annoFormatString: null,
							textBounds: xTextBounds,
							axisTextOffset: axisTextOffset,
							autoMax: true,
							autoMin: true,
							autoMajor: true,
							autoMinor: true
						},
						y: {
							id: "y",
							tprec: 0,
							isTime: false,
							offset: 0,
							vOffset: 0,
							max: 0,
							min: 0,
							majorTickRect: null,
							minorTickRect: null,
							annoFormatString: null,
							textBounds: yTextBounds,
							axisTextOffset: axisTextOffset,
							autoMax: true,
							autoMin: true,
							autoMajor: true,
							autoMinor: true
						}
					};
					extremeValue = self._getDataExtreme();
					if (axisOption.x.autoMin && self.axisInfo.x.autoMin) {
						axisOption.x.min = extremeValue.txn;
					} else if (axisOption.x.min && self._isDate(axisOption.x.min)) {
						//if is date time, convert to number.
						axisOption.x.min = self._toOADate(axisOption.x.min);
					}
					if (axisOption.x.autoMax && self.axisInfo.x.autoMax) {
						axisOption.x.max = extremeValue.txx;
					} else if (axisOption.x.max && self._isDate(axisOption.x.max)) {
						//if is date time, convert to number.
						axisOption.x.max = self._toOADate(axisOption.x.max);
					}
					if (axisOption.y.autoMin && self.axisInfo.y.autoMin) {
						axisOption.y.min = extremeValue.tyn;
					} else if (axisOption.y.min && self._isDate(axisOption.y.min)) {
						//if is date time, convert to number.
						axisOption.y.min = self._toOADate(axisOption.y.min);
					}
					if (axisOption.y.autoMax && self.axisInfo.y.autoMax) {
						axisOption.y.max = extremeValue.tyx;
					} else if (axisOption.y.max && self._isDate(axisOption.y.max)) {
						//if is date time, convert to number.
						axisOption.y.max = self._toOADate(axisOption.y.max);
					}

					do {
						offsetY = self._autoPosition(self.axisInfo, axisOption, "y");
						offsetX = self._autoPosition(self.axisInfo, axisOption, "x");

						if (offsetY === self.axisInfo.y.offset && 
								offsetX === self.axisInfo.x.offset) {
							maxtries = 0;
							break;
						}
						if (offsetY !== self.axisInfo.y.offset) {
							self.axisInfo.y.offset = offsetY;
							self.axisInfo.y.vOffset = offsetX;
						}
						if (offsetX !== self.axisInfo.x.offset) {
							self.axisInfo.x.offset = offsetX;
							self.axisInfo.x.vOffset = offsetY;
						}
						maxtries--;
					} while (maxtries > 0);

					self._adjustPlotArea(axisOption.x, self.axisInfo.x);
					self._adjustPlotArea(axisOption.y, self.axisInfo.y);

					self.innerState.axisInfo = self.axisInfo;
					self.innerState.canvasBounds = self.canvasBounds;
				}
				self._paintAxes();
				self._paintPlotArea();
			} else {
				self._paintPlotArea();
			}
		},

		_adjustPlotArea: function (axisOptions, axisInfo) {
			var canvasBounds = this.canvasBounds;
			axisOptions.max = axisInfo.max;
			axisOptions.min = axisInfo.min;

			switch (axisOptions.compass) {
			case "north":
				canvasBounds.startY += axisInfo.offset;
				break;
			case "south":
				canvasBounds.endY -= axisInfo.offset;
				break;
			case "east":
				canvasBounds.endX -= axisInfo.offset;
				break;
			case "west":
				canvasBounds.startX += axisInfo.offset;
				break;
			}
		},

		_autoPosition: function (axisInfo, axisOptions, dir) {
			//this._adjustCartesianCompass();
			//base._autoPosition();
			return this._autoPositionCartesianAxis(axisInfo, axisOptions, dir);
		},

		_autoPositionCartesianAxis: function (axisInfo, axisOptions, dir) {
			var self = this,
				extent = null,
				bounds = self.canvasBounds,
				compass = axisOptions[dir].compass,
				oppositeDir = dir === "x" ? "y" : "x",
				origin = axisOptions[oppositeDir].origin,
				max = axisInfo[oppositeDir].max,
				min = axisInfo[oppositeDir].min,
				d = 0, offset;

			if (origin !== null && self._isDate(origin)) {
				origin = self._toOADate(origin);
			}

			self._calculateParameters(axisInfo[dir], axisOptions[dir]);
			extent = self._getMaxExtents(axisInfo[dir], axisOptions[dir]);
			switch (compass) {
			case "north":
			case "south":
				offset = extent.height;
				axisInfo[dir].maxExtent = offset;
			
				if (origin !== null && origin >= min && origin <= max) {
					if (compass === "south") {
						d = (origin - min)/(max - min) * (bounds.endY - bounds.startY);
					} else {
						d = (max - origin)/(max - min) * (bounds.endY - bounds.startY);
					}

					offset -= d;

					if (offset < 0) {
						offset = 0;
					}
				}

				return offset;
			case "east":
			case "west":
				offset = extent.width;
				axisInfo[dir].maxExtent = offset;

				if (origin !== null && origin >= min && origin <= max) {
					if (compass === "west") {
						d = (origin - min)/(max - min) * (bounds.endX - bounds.startX);
					} else {
						d = (max - origin)/(max - min) * (bounds.endX - bounds.startX);
					}

					offset -= d;

					if (offset < 0) {
						offset = 0;
					}
				}

				return offset;
			}
		},

		_getMaxExtents: function (axisInfo, axisOptions, axisRect) {
			var self = this,
				o = self.options,
				majorTickValues = null,
				maxExtent = {
					width: 0,
					height: 0
				},
				min = axisInfo.min,
				max = axisInfo.max,
				isTime = axisInfo.isTime,
				formatString = axisOptions.annoFormatString,
				is100pc = o.is100Percent,
				index = 0,
				compass = axisOptions.compass,
				labels = axisOptions.labels,
				textStyle,
				hasDefaultRotation = false,
				canvasBounds = self.canvasBounds,
				width;

			axisInfo.majorTickRect = self._getTickRect(axisInfo, axisOptions, 
														true, true, axisRect);
			axisInfo.minorTickRect = self._getTickRect(axisInfo, axisOptions, 
														false, true, axisRect);
			majorTickValues = self._getMajorTickValues(axisInfo, axisOptions);

			if (!formatString || formatString.length === 0) {
				formatString = axisInfo.annoFormatString;
			}

			textStyle = $.extend(true, {}, o.textStyle, 
				axisOptions.textStyle, labels.style);
			hasDefaultRotation = typeof (textStyle.rotation) !== "undefined";
			textStyle = $.extend(true, textStyle, axisInfo.textStyle);
			width = canvasBounds.endX - canvasBounds.startX - 
				axisInfo.vOffset - axisInfo.axisTextOffset;
			if (majorTickValues && majorTickValues.length) {
				width = width / (majorTickValues.length - 1);
				$.each(majorTickValues, function (idx, mtv) {
					var txt,
						size,
						txtClone;

					if (mtv < min || mtv > max) {
						return true;
					}

					if (axisOptions.annoMethod === "valueLabels") {
						if (mtv < 0) {
							return true;
						}

						if (index >= axisOptions.valueLabels.length) {
							return false;
						}

						//mtv = axisOptions.valueLabels[index].text;
						mtv = axisOptions.valueLabels[index];
					} else if (axisOptions.annoMethod === "values") {
						if (formatString && formatString.length) {
							if (isTime) {
								mtv = self._fromOADate(mtv);
							}

							mtv = $.format(mtv, formatString);
						} else if (is100pc && axisInfo.id === "y") {
							mtv = $.format(mtv, "p0");
						}
					}

					if (labels.width) {
						txt = self.canvas.wij.wrapText(-100, -100, mtv, 
								labels.width, labels.textAlign, textStyle);
					} else {
						txt = self._text(-100, -100, mtv).attr(textStyle);
					}
						
					size = txt.wijGetBBox();
					
					if (!self._isVertical(compass) && !hasDefaultRotation && 
							axisOptions.annoMethod === "valueLabels") {
						if (size.width > width) {
							if (!txt.attr().rotation) {
								txt.attr({rotation: -45});
								textStyle.rotation = -45;
								axisInfo.textStyle = {
									rotation: -45
								};
								size = txt.wijGetBBox();
							}
						}
						if (idx === 0 && txt.attr().rotation && 
								txt.attr().rotation === -45) {
							txtClone = txt.clone();
							txtClone.attr({rotation: 0});
							size = txtClone.wijGetBBox();
							if (Math.sqrt(2) * size.height > width) {
								txt.attr({rotation: -90});
								textStyle.rotation = -90;
								axisInfo.textStyle = {
									rotation: -90
								};
							}
							txtClone.wijRemove();
							size = txt.wijGetBBox();
						}
					}
					txt.wijRemove();

					if (size.width > maxExtent.width) {
						maxExtent.width = size.width;
					}

					if (size.height > maxExtent.height) {
						maxExtent.height = size.height;
					}

					index++;
				});
			}
			if (maxExtent.width < labels.width) {
				maxExtent.width = labels.width;
			}
			
			axisInfo.labelWidth = maxExtent.width;
			return maxExtent;
		},

		_getMajorTickValues: function (axisInfo, axisOptions) {
			var rc = [];
			////var isTime = isTimeFormat;
			//// annoMethod will always be values right now.
			////if(axisOptions.annoMethod == "valueLabels") {
			////	rc = this._getSortedDataValues(axisOptions);
			////}
			//rc = this._getTickValues(axisInfo.max, axisInfo.min, 
			//	axisOptions.unitMajor, axisInfo.tprec, !axisInfo.isTime);
			rc = this._getTickValues(axisInfo.max, axisInfo.min, 
				axisOptions.unitMajor, axisInfo.tprec, !axisInfo.isTime,
				axisOptions.autoMajor);
			return rc;
		},

		_getMinorTickValues: function (axisInfo, axisOptions) {
			var rc = [];
			//rc = this._getTickValues(axisInfo.max, axisInfo.min, 
			//	axisOptions.unitMinor, axisInfo.tprec, !axisInfo.isTime);
			rc = this._getTickValues(axisInfo.max, axisInfo.min, 
				axisOptions.unitMinor, axisInfo.tprec, !axisInfo.isTime,
				axisOptions.autoMinor);
			return rc;
		},

		//_getTickValues: function (smax, smin, unit, tickprec, round) {
		_getTickValues: function (smax, smin, unit, tickprec, round, autoTick) {
			var self = this,
				vals = [],
				sminOriginal = smin,
				i = 0, 
				xs = 0, 
				imax = 0, 
				imin = 0, 
				n = 0, 
				smin2 = 0;

			try {
				if (unit === 0) {
					vals = [smax, smin];
				} else {
					if (autoTick) {
						if (tickprec + 1 < 0) {
							tickprec = -1;
						} else if (tickprec + 1 > 15) {
							tickprec = 14;
						}
						smin2 = self.round(self._signedCeiling(smin / unit) * unit, 
											tickprec + 1);
						if (smin2 < smax) {
							smin = smin2;
						}
						imax = parseInt(self.round(smax / unit, 5), 10);
						imin = parseInt(self.round(smin / unit, 5), 10);
						n = parseInt(imax - imin + 1, 10);
						if (n > 1) {
							xs = imin * unit;
							if (xs < smin) {
								n--;
								smin += unit;
							}
							xs = smin + (n - 1) * unit;
							if (xs > smax) {
								n--;
							}
						}
						if (n < 1) {
							n = 2;
							smin = sminOriginal;
							unit = smax - smin;
						}
					} else {
						n = parseInt((smax - smin) / unit + 1, 10);
						if (n > 1) {
							xs = smin + (n - 1) * unit;
							if (xs > smax) {
								n--;
							}
						}
						if (n < 1) {
							n = 2;
							unit = smax - smin;
						}
					}

					for (i = 0; i < n; i++) {
						if (round) {
							//vals[i] = self.round(smin + i * unit, tickprec + 1);
							if (autoTick) {
								vals[i] = self.round(smin + i * unit, tickprec + 1);
							} else {
								vals[i] = smin + i * unit;
							}
						} else {
							vals[i] = smin + i * unit;
						}
					}
				}
			} catch (error) { }

			return vals;
		},

		_getTickRect: function (axisInfo, axisOptions, isMajor, inAxisRect) {
			var compass = axisOptions.compass,
				sizeFactor = 0,
				tick = null,
				majorSizeFactor = 3,
				minorSizeFactor = 2,
				thickness = 2,
				r = {
					x: 0,
					y: 0,
					width: 0,
					height: 0
				};
			if (isMajor) {
				tick = axisOptions.tickMajor.position;
				sizeFactor = (majorSizeFactor * axisOptions.tickMajor.factor);
			} else {
				tick = axisOptions.tickMinor.position;
				sizeFactor = (minorSizeFactor * axisOptions.tickMinor.factor);
			}
			if (tick === "none" || (tick === "inside" && inAxisRect)) {
				sizeFactor = 0;
			}
			//if(isVertical) {
			if (compass === "east" || compass === "west") {
				r = {
					x: 0,
					y: -1,
					width: sizeFactor * thickness,
					height: thickness
				};
				if ((compass === "east" && (tick === "outside" || 
						(tick === "cross" && inAxisRect))) ||
						(compass === "west" && tick === "inside")) {
					//r.x = axisRect.x;
					//if(inAxisRect) {
					//	r.x += axisRect.width;
					//}
					//else {
					//	r.width += axisRect.width;
					//}
					r.width += 2; //default value of axisRect is 2.
				} else {
					//r.x = axisRect.x - sizeFactor * thickness;
					if (!inAxisRect) {
						if (tick === "corss") {
							r.width <<= 1;
						}
						//r.width += axisRect.width;
						r.width += 2;
					}
				}
			} else {
				r = {
					x: -1,
					y: 0,
					width: thickness,
					height: sizeFactor * thickness
				};
				if ((compass === "south" && (tick === "outside" || 
						(tick === "corss" && inAxisRect))) ||
						(compass === "north" && tick === "inside")) {
					//r.y = axisRect.y;
					//if(inAxisRect) {
					//	r.y += axisRect.height;
					//}
					//else {
					//	r.height += axisRect.height;
					//}
					r.height += 2;
				} else {
					//r.y = axisRect.y - sizeFactor * thickness;
					if (!inAxisRect) {
						if (tick === "cross") {
							r.height <<= 1;
						}
						//r.height += axisRect.height;
						r.height += 2;
					}
				}
			}
			return r;
		},

		_applyMargins: function () {
			var self = this,
				o = self.options,
				canvasBounds = self.canvasBounds;

			canvasBounds.startX += o.marginLeft;
			canvasBounds.endX -= o.marginRight;
			canvasBounds.startY += o.marginTop;
			canvasBounds.endY -= o.marginBottom;
		},

		_paintAxes: function () {
			//paint x axis
			var self = this,
				bounds = self.canvasBounds,
				axis = self.options.axis,
				axisInfo = self.axisInfo,
				ox = axis.x,
				oy = axis.y,
				x = axisInfo.x,
				y = axisInfo.y,
				max, min, origin, isVertical, offset, axisElements;

			axisElements = self._paintAxis(ox, x);

			if (oy.origin !== null) {
				self._translateAxisIfNeeded(axisElements, ox.compass, 
					oy.origin, oy.compass, y.max, y.min);
			}

			axisElements = self._paintAxis(oy, y);
			
			if (ox.origin !== null) {
				self._translateAxisIfNeeded(axisElements, oy.compass, 
					ox.origin, ox.compass, x.max, x.min);
			}
		},

		_translateAxisIfNeeded: function (xAxisElements, xCompass, yOrigin, yCompass, yMax, yMin) {
			var self = this,
				isVertical = yCompass === "west" || yCompass === "east",
				bounds = self.canvasBounds,
				origin = yOrigin,
				offset;
			
			if (self._isDate(origin)) {
				origin = self._toOADate(origin);
			}

			if (!isVertical) {
				if (xCompass === "west") {
					offset = (origin - yMin) / (yMax - yMin) * (bounds.endX - bounds.startX);
				} else {
					offset = (origin - yMax) / (yMax - yMin) * (bounds.endX - bounds.startX);
				}

				$.each(xAxisElements, function (idx, element) {
					element.translate(offset, 0);
				});
			} else {
				if (xCompass === "south") {
					offset = (yMin - origin) / (yMax - yMin) * (bounds.endY - bounds.startY);
				} else {
					offset = (yMax - origin) / (yMax - yMin) * (bounds.endY - bounds.startY);
				}

				$.each(xAxisElements, function (idx, element) {
					element.translate(0, offset);
				});
			}
		},

		_paintAxis: function (axisOptions, axisInfo) {
			var self = this,
				o = self.options,
				canvasBounds = self.canvasBounds,
				startPoint = {
					x: 0,
					y: 0
				},
				endPoint = {
					x: 0,
					y: 0
				},
				compass = axisOptions.compass,
				thickness = 2,
				isVertical = true,
				ax = null,
				//paint tick & ticklabel
				majorTickValues = [],
				tempMinorTickValues = [],
				minorTickValues = [],
				max = axisInfo.max,
				min = axisInfo.min,
				unitMajor = axisOptions.unitMajor,
				unitMinor = axisOptions.unitMinor,
				tickMajor = axisOptions.tickMajor.position,
				tickMinor = axisOptions.tickMinor.position,
				axisSize = axisInfo.maxExtent,//axisInfo.offset,
				tickMajorStyle = axisOptions.tickMajor.style,
				tickMinorStyle = axisOptions.tickMinor.style,
				tickRectMajor = axisInfo.majorTickRect,
				tickRectMinor = axisInfo.minorTickRect,
				axisTextOffset = axisInfo.axisTextOffset,
				gridMajor = axisOptions.gridMajor,
				gridMinor = axisOptions.gridMinor,
				labels = axisOptions.labels,
				maxLen = 0,
				textInfos = [],
				index = 0, 
				formatString = axisOptions.annoFormatString,
				textStyle = null,
				axisElements = [];

			if (!formatString || formatString.length === 0) {
				formatString = axisInfo.annoFormatString;
			}
			majorTickValues = self._getMajorTickValues(axisInfo, axisOptions);
			
			if (tickMinor !== "none") {
				tempMinorTickValues = self._getMinorTickValues(axisInfo, axisOptions);
				minorTickValues = self._resetMinorTickValues(tempMinorTickValues, 
						majorTickValues);
			}

			switch (compass) {
			case "south":
				startPoint.x = canvasBounds.startX;
				startPoint.y = canvasBounds.endY;
				endPoint.x = canvasBounds.endX;
				endPoint.y = canvasBounds.endY;
				isVertical = false;
				break;
			case "north":
				startPoint.x = canvasBounds.startX;
				startPoint.y = canvasBounds.startY - thickness;
				endPoint.x = canvasBounds.endX;
				endPoint.y = canvasBounds.startY - thickness;
				isVertical = false;
				break;
			case "east":
				startPoint.x = canvasBounds.endX;
				startPoint.y = canvasBounds.endY;
				endPoint.x = canvasBounds.endX;
				endPoint.y = canvasBounds.startY;
				break;
			case "west":
				startPoint.x = canvasBounds.startX - thickness;
				startPoint.y = canvasBounds.endY;
				endPoint.x = canvasBounds.startX - thickness;
				endPoint.y = canvasBounds.startY;
				break;
			}

			if (axisOptions.visible) {
				ax = self.canvas.wij
					.line(startPoint.x, startPoint.y, endPoint.x, endPoint.y)
					.attr(axisOptions.style);

				self.axisEles.push(ax);
				axisElements.push(ax);
			}

			$.each(majorTickValues, function (idx, val) {
				var text = val,
					isTime = axisInfo.isTime,
					is100Percent = o.is100Percent,
					retInfo, textInfo;

				if (val < min || val > max) {
					return true;
				}

				if (axisOptions.annoMethod === "valueLabels") {
					if (val < 0) {
						return true;
					}

					if (index >= axisOptions.valueLabels.length) {
						return false;
					}

					//text = axisOptions.valueLabels[index].text;
					text = axisOptions.valueLabels[index];
				} else if (axisOptions.annoMethod === "values") {
					if (formatString && formatString.length) {
						if (isTime) {
							text = self._fromOADate(val);
						}
						text = $.format(text, formatString);
					} else if (is100Percent && axisInfo.id === "y") {
						text = $.format(val, "p0");
					}
				}
				/*//TODO: mixed
				else {
				}*/

				textStyle = $.extend(true, {}, o.textStyle, 
						axisOptions.textStyle, labels.style, axisInfo.textStyle);

				retInfo = self._paintMajorMinor(max, min, val, tickMajor, 
						unitMajor, tickRectMajor,  compass, startPoint, 
						endPoint, axisSize, axisTextOffset, tickMajorStyle, 
						text, gridMajor, axisOptions.textVisible, textStyle, 
						labels.textAlign, labels.width ? axisInfo.labelWidth : null);

				if (retInfo) {
					if (retInfo.elements) {
						axisElements = axisElements.concat(retInfo.elements);
					}

					textInfo = retInfo.textInfo;
				}

				if (textInfo) {
					textInfos.push(textInfo);
					if (maxLen < textInfo.len) {
						maxLen = textInfo.len;
					}
				}

				index++;
			});

			if (!labels.width) {
				$.each(textInfos, function (idx, textInfo) {
					var textElement = textInfo.text,
						offset = (textInfo.len - maxLen) / 2;
					offset = labels.textAlign === "near" ? offset * -1 : offset;

					if (isVertical) {
						textElement.translate(offset, 0);
					} else {
						textElement.translate(0, offset);
					}
				});
			}

			$.each(minorTickValues, function (idx, val) {
				var retInfo;

				if (val > min && val < max) {
					retInfo = self._paintMajorMinor(max, min, val, tickMinor, 
						unitMinor, tickRectMinor, compass, startPoint, 
						endPoint, axisSize, axisTextOffset, tickMinorStyle, 
						null, gridMinor, axisOptions.textVisible, textStyle, 
						labels.textAlign, labels.width ? axisInfo.labelWidth : null);

					if (retInfo && retInfo.elements) {
						axisElements = axisElements.concat(retInfo.elements);
					}
				}
			});

			if (axisOptions.text && axisOptions.text.length > 0) {
				axisElements.push(self._paintAxisText(axisOptions, axisInfo));
			}

			return axisElements;
		},

		_paintAxisText: function (axisOptions, axisInfo) {
			if (!axisOptions.text || axisOptions.text.length === 0) {
				return;
			}

			var self = this,
				text = axisOptions.text,
				compass = axisOptions.compass,
				align = axisOptions.alignment,
				canvasBounds = self.canvasBounds,
				startX = canvasBounds.startX,
				startY = canvasBounds.startY,
				endX = canvasBounds.endX,
				endY = canvasBounds.endY,
				x = startX,
				y = startY,
				textBounds = axisInfo.textBounds,
				isVertical = self._isVertical(compass),
				axisTextOffset = axisInfo.axisTextOffset,
				tickRectMajor = axisInfo.majorTickRect,
				tick = axisOptions.tickMajor.position,
				tickLength = isVertical ? tickRectMajor.width : tickRectMajor.height,
				textStyle = null, 
				textElement = null,
				marginTop = 0, 
				marginLeft = 0, 
				marginRight = 0, 
				marginBottom = 0;

			textStyle = $.extend(true, {}, 
				self.options.textStyle, axisOptions.textStyle);
			if (textStyle["margin-top"]) {
				marginTop = parseFloat(textStyle["margin-top"]);
			}
			if (textStyle["margin-left"]) {
				marginLeft = parseFloat(textStyle["margin-left"]);
			}
			if (textStyle["margin-right"]) {
				marginRight = parseFloat(textStyle["margin-right"]);
			}
			if (textStyle["margin-bottom"]) {
				marginBottom = parseFloat(textStyle["margin-bottom"]);
			}
			if (tick === "cross") {
				tickLength = tickLength / 2;
			} else if (tick === "inside") {
				tickLength = 0;
			}

			if (isVertical) {
				switch (align) {
				case "near":
					y = endY - textBounds.width / 2;
					break;
				case "center":
					y = (startY + endY) / 2;
					break;
				case "far":
					y = startY + textBounds.width / 2;
					break;
				}

				if (compass === "west") {
					x = startX - (axisInfo.offset + axisTextOffset + 
						tickLength + textBounds.height / 2 + marginRight);
				} else {
					x = endX + axisInfo.offset + axisTextOffset + 
						tickLength + textBounds.height / 2 + marginLeft;
				}
			} else {
				switch (align) {
				case "near":
					x = startX + textBounds.width / 2;
					break;
				case "center":
					x = (startX + endX) / 2;
					break;
				case "far":
					x = endX - textBounds.width / 2;
					break;
				}

				if (compass === "north") {
					y = startY - (axisInfo.offset + axisTextOffset + 
						tickLength + textBounds.height / 2 + marginBottom);
				} else {
					y = endY + axisInfo.offset + axisTextOffset + 
						tickLength + textBounds.height / 2 + marginTop;
				}
			}

			textElement = self._text(x, y, text);
			self.axisEles.push(textElement);
			textElement.attr(textStyle);

			if (isVertical) {
				textElement.rotate(-90);
			}

			return textElement;
		},

		_resetMinorTickValues: function (minorTickValues, majorTickValues) {
			var i = 0, 
				j = 0,
				minorTickValue = null,
				majorTickValue = null;
			for (i = minorTickValues.length - 1; i >= 0; i--) {
				minorTickValue = minorTickValues[i];
				for (j = majorTickValues.length - 1; j >= 0; j--) {
					majorTickValue = majorTickValues[j];
					if (minorTickValue === majorTickValue) {
						minorTickValues.splice(i, 1);
					}
				}
			}

			return minorTickValues;
		},

		_paintMajorMinor: function (max, min, val, tick, unit, tickRect, compass, 
						startPoint, endPoint, axisSize, axisTextOffset, tickStyle, 
						text, grid, textVisible, textStyle, textAlign, labelWidth) {
			var self = this,
				x = startPoint.x,
				y = startPoint.y,
				tickX = -1,
				tickY = -1,
				isVertical = true,
				bs = self.canvasBounds,
				textInfo = null,
				tickElement = null,
				pathArr = [],
				arrPath = [],
				p = null,
				style = {"stroke-width": 2},
				txt = null, 
				textBounds = null,
				retInfo = {},
				majorMinorElements = [];
				
			switch (compass) {
			case "south":
				if (tick === "inside") {
					y -= tickRect.height;
				} else if (tick === "cross") {
					y -= tickRect.height / 2;
				}

				if (labelWidth) {
					tickY = y + axisTextOffset + tickRect.height;
				} else {
					tickY = y + axisTextOffset + tickRect.height + axisSize / 2;
				}
								
				isVertical = false;
				break;
			case "west":
				if (tick === "outside") {
					x -= tickRect.width;
				} else if (tick === "cross") {
					x -= tickRect.width / 2;
				}

				if (labelWidth) {
					tickX = x - (axisTextOffset + axisSize);
				} else {
					tickX = x - (axisTextOffset + axisSize / 2);
				}
				break;
			case "north":
				if (tick === "outside") {
					y -= tickRect.height;
				} else if (tick === "cross") {
					y -= tickRect.height / 2;
				}

				if (labelWidth) {
					tickY = y - (axisTextOffset + axisSize);
				} else {
					tickY = y - (axisTextOffset + axisSize / 2);
				}
				isVertical = false;
				break;
			case "east":
				if (tick === "inside") {
					x -= tickRect.width;
				} else if (tick === "cross") {
					x -= tickRect.width / 2;
				}
				
				if (labelWidth) {
					tickX = x + axisTextOffset + tickRect.width;
				} else {
					tickX = x + axisTextOffset + tickRect.width + axisSize / 2;
				}
				break;
			}

			if (isVertical) {
				y += (val - min) / (max - min) * (endPoint.y - startPoint.y);
				if (grid.visible) {
					if ((y !== bs.startY && compass === "east") || 
							(y !== bs.endY && compass === "west")) {
						arrPath = ["M", bs.startX, y, "H", bs.endX];
						p = self.canvas.path(arrPath.concat(" "));
						p.attr(grid.style);
						self.axisEles.push(p);
					}
				}

				tickY = y;

				if (tick !== "none") {
					pathArr = ["M", x, y, "h", tickRect.width];
					tickStyle["stroke-width"] = tickRect.height;
				}
			} else {
				x += (val - min) / (max - min) * (endPoint.x - startPoint.x);
				if (grid.visible) {
					if ((x !== bs.startX && compass === "south") || 
							(x !== bs.endX && compass === "north")) {
						arrPath = ["M", x, bs.startY, "V", bs.endY];
						p = self.canvas.path(arrPath.concat(" "));
						p.attr(grid.style);
						self.axisEles.push(p);
					}
				}

				if (labelWidth) {
					tickX = x - labelWidth / 2;
				} else {
					tickX = x;
				}
				
				if (tick !== "none") {
					pathArr = ["M", x, y, "v", tickRect.height];
					tickStyle["stroke-width"] = tickRect.width;
				}
			}

			if (tick !== "none") {
				tickElement = self.canvas.path(pathArr.concat(" "));
				style = $.extend(style, tickStyle);
				tickElement.attr(style);
				self.axisEles.push(tickElement);
				majorMinorElements.push(tickElement);
			}

			if (text !== null) {
				if (labelWidth) {
					txt = self.canvas.wij.wrapText(tickX, 
						tickY, text.toString(), labelWidth, textAlign, textStyle);
				
					if (isVertical) {
						txt.translate(0, -txt.getBBox().height / 2);
					}
				} else {
					txt = self._text(tickX, tickY, text.toString());
					txt.attr(textStyle);
				}

				self.axisEles.push(txt);
				majorMinorElements.push(txt);
				if (!textVisible) {
					txt.hide();
				}
				if (textAlign !== "center") {
					textBounds = txt.getBBox();
					textInfo = { 
						text: txt, 
						len: isVertical ? textBounds.width : textBounds.height
					};
				}
			}

			retInfo = {textInfo: textInfo, elements: majorMinorElements};

			return retInfo;
		},

		_paintPlotArea: function () {
		},

		_paintChartLabels: function () {
			var self = this,
				chartLabels = self.options.chartLabels;

			if (chartLabels && chartLabels.length) {
				$.each(chartLabels, function (idx, chartLabel) {
					var point;

					chartLabel = $.extend(true, {
						compass: "east",
						attachMethod: "coordinate",
						attachMethodData: {
							seriesIndex: -1,
							pointIndex: -1,
							x: -1,
							y: -1
						},
						offset: 0,
						visible: false,
						text: "",
						connected: false
					}, chartLabel);

					if (chartLabel.visible) {
						point = self._getChartLabelPointPosition(chartLabel);
						if (typeof (point.x) !== "number" || 
								typeof (point.y) !== "number") {
							return false;
						}
						self._setChartLabel(chartLabel, point);
					}
				});
			}
		},

		_getChartLabelPointPosition: function (chartLabel) {
		},

		_setChartLabel: function (chartLabel, point, angle, calloutStyle) {
			var self = this,
				compass = chartLabel.compass,
				o = self.options,
				textStyle = $.extend(true, {}, o.textStyle, o.chartLabelStyle),
				text = self._text(0, 0, chartLabel.text).attr(textStyle),
				offset = chartLabel.offset,
				transX = 0, 
				transY = 0,
				position = null,
				p = null;

			self.chartLabelEles.push(text);

			position = self._getCompassTextPosition(compass, 
							text.wijGetBBox(), offset, point, angle);

			if (offset && chartLabel.connected) {
				p = self.canvas.path("M" + point.x + " " + point.y + "L" + 
							position.endPoint.x + " " + position.endPoint.y);
				p.attr(calloutStyle);
				self.chartLabelEles.push(p);
			}

			transX = position.endPoint.x + position.offsetX;
			transY = position.endPoint.y + position.offsetY;

			text.translate(transX, transY)
				.toFront();
		},

		_getCompassTextPosition: function (compass, box, offset, point, angle) {
			var offsetX = 0, offsetY = 0,
				endPoint = { x: 0, y: 0 };

			switch (compass) {
			case "east":
				angle = 0;
				break;
			case "west":
				angle = 180;
				break;
			case "north":
				angle = 90;
				break;
			case "south":
				angle = 270;
				break;
			case "northeast":
				angle = 45;
				break;
			case "northwest":
				angle = 135;
				break;
			case "southeast":
				angle = 315;
				break;
			case "southwest":
				angle = 225;
				break;
			}

			if ((angle >= 0 && angle < 45 / 2) || (angle > 675 / 2 && angle < 360)) {
				offsetX = box.width / 2;
			} else if (angle >= 45 / 2 && angle < 135 / 2) {
				offsetX = box.width / 2;
				offsetY = -1 * box.height / 2;
			} else if (angle >= 135 / 2 && angle < 225 / 2) {
				offsetY = -1 * box.height / 2;
			} else if (angle >= 225 / 2 && angle < 315 / 2) {
				offsetX = -1 * box.width / 2;
				offsetY = -1 * box.height / 2;
			} else if (angle >= 315 / 2 && angle < 405 / 2) {
				offsetX = -1 * box.width / 2;
			} else if (angle >= 405 / 2 && angle < 495 / 2) {
				offsetX = -1 * box.width / 2;
				offsetY = box.height / 2;
			} else if (angle >= 495 / 2 && angle < 585 / 2) {
				offsetY = box.height / 2;
			} else {
				offsetX = box.width / 2;
				offsetY = box.height / 2;
			}

			endPoint = this.canvas.wij
				.getPositionByAngle(point.x, point.y, offset, angle);

			return {
				endPoint: endPoint,
				offsetX: offsetX,
				offsetY: offsetY
			};
		},

		_getXSortedPoints: function (series) {
			var seriesX = series.data.x,
				tempX = [].concat(seriesX),
				tempY = [].concat(series.data.y),
				points = [],
				sortedX = seriesX;

			if (seriesX.length === 0) {
				return;
			}

			function sortNumber(a, b) {
				return a - b;
			}

			if (typeof (seriesX[0]) === "number") {
				sortedX = [].concat(seriesX).sort(sortNumber);
			}

			$.each(sortedX, function (i, nSortedX) {
				$.each(tempX, function (j, nx) {
					if (nSortedX === nx) {
						if (typeof (nx) !== "number") {
							nx = i;
						}
						points.push({ x: nx, y: tempY[j] });
						tempX.splice(j, 1);
						tempY.splice(j, 1);
						return false;
					}
				});
			});

			return points;
		},

		_bindLiveEvents: function () {
		},

		_unbindLiveEvents: function () {
		},

		_isBarChart: function () {
			return false;
		},

		_isPieChart: function () {
			return false;
		},

		//methods for Axis
		_calculateParameters: function (axisInfo, axisOptions) {
			var self = this,
				maxData = axisOptions.max,
				minData = axisOptions.min,
				autoMax = axisOptions.autoMax && axisInfo.autoMax,
				autoMin = axisOptions.autoMin && axisInfo.autoMin,
				autoMajor = axisOptions.autoMajor && axisInfo.autoMajor,
				autoMinor = axisOptions.autoMinor && axisInfo.autoMinor,
				axisAnno = null, 
				prec = null,
				isVL = axisOptions.annoMethod === "valueLabels",
				major = 0,
				newmax = 0, 
				newmin = 0,
				dx = 0, 
				tinc = 0,
				isTime = axisInfo.isTime;

			if (autoMax && maxData !== Number.MIN_VALUE) {
				if (axisInfo.id !== "x" && self._isBarChart()) {
					if (maxData < 0.0 && (0.5 * (maxData - minData) > -maxData)) {
						maxData = 0.0;
					}
				}
			}

			if (autoMin && minData !== Number.MAX_VALUE) {
				if (axisInfo.id !== "x" && self._isBarChart()) {
					if (minData > 0.0 && (0.5 * (maxData - minData) > minData)) {
						minData = 0.0;
					}
				}
			}

			if (maxData === minData) {
				if (minData !== 0) {
					minData -= 1;
				}
				maxData += 1;
			}
			dx = maxData - minData;

			if (isTime) {
				axisAnno = axisOptions.annoFormatString;
				if (!axisAnno || axisAnno.length === 0) {
					axisAnno = self._getTimeDefaultFormat(maxData, minData);
					axisInfo.annoFormatString = axisAnno;
				}
				tinc = self._niceTimeUnit(0.0, axisAnno);
			}
			prec = self._nicePrecision(dx);
			axisInfo.tprec = prec;
			if (autoMax) {
				if (isTime) {
					newmax = self._roundTime(maxData, tinc, true);
					if (newmax < maxData) {
						maxData = newmax + tinc;
					} else {
						maxData = newmax;
					}
				} else {
					newmax = self._precCeil(-prec, maxData);
					if (typeof (newmax) === "number") {
						maxData = newmax;
					}
				}
			}
			if (autoMin) {
				if (isTime) {
					newmin = self._roundTime(minData, tinc, false);
					if (newmin > minData) {
						minData = newmin - tinc;
					} else {
						minData = newmin;
					}
				} else {
					newmin = self._precFloor(-prec, minData);
					if (typeof (newmin) === "number") {
						minData = newmin;
					}
				}
			}

			axisInfo.max = maxData;
			axisInfo.min = minData;
			axisInfo.annoFormatString = axisAnno;
			axisInfo.tinc = tinc;

			if (autoMajor || autoMinor) {
				dx = maxData - minData;
				self._calculateMajorMinor(axisOptions, axisInfo);
				//var minor = axisOptions.unitMinor;
				major = axisOptions.unitMajor;
				if (autoMax && major !== 0 && !isTime && !isVL) {
					dx = maxData - parseInt(maxData / major, 10) * major;

					if (dx !== 0) {
						maxData += (major - dx);
						maxData = self._precCeil(-prec, maxData);
					}
				}

				if (autoMin && major !== 0 && !isTime && !isVL) {
					dx = minData - parseInt(minData / major, 10) * major;

					if (dx !== 0) {
						if (dx < 0) {
							dx += major;
						}

						minData -= Math.abs(dx);// should always be less.
						minData = self._precFloor(-prec, minData);
					}
				}
			}

			/*//TODO:
			if (!autoMajor || !autoMinor) {				
			}*/

			axisInfo.max = maxData;
			axisInfo.min = minData;
		},

		_roundTime: function (timevalue, unit, roundup) {
			var self = this,
				//tunit = unit * self._tmInc.day,
				tunit = unit,
				tv = self._fromOADate(timevalue),
				th, 
				td, 
				tx, 
				tz;

			if (tunit > 0) {
				th = {
					year: tv.getFullYear(),
					month: tv.getMonth(),
					day: tv.getDate(),
					hour: tv.getHours(),
					minute: tv.getMinutes(),
					second: tv.getSeconds()
				};
				if (tunit < self._tmInc.minute) {
					th.second = self._tround(th.second, tunit, roundup);
					return self._getTimeAsDouble(th);
				}

				th.second = 0;
				if (tunit < self._tmInc.hour) {
					tunit /= self._tmInc.minute;
					th.minute = self._tround(th.minute, tunit, roundup);
					return self._getTimeAsDouble(th);
				}

				th.minute = 0;
				if (tunit < self._tmInc.day) {
					tunit /= self._tmInc.hour;
					th.hour = self._tround(th.hour, tunit, roundup);
					return self._getTimeAsDouble(th);
				}

				th.hour = 0;
				if (tunit < self._tmInc.month) {
					tunit /= self._tmInc.day;
					th.day = self._tround(th.day, tunit, roundup);
					return self._getTimeAsDouble(th);
				}

				th.day = 1;
				if (tunit < self._tmInc.year) {
					tunit /= self._tmInc.month;
					th.month = self._tround(th.month, tunit, roundup);
					return self._getTimeAsDouble(th);
				}

				//th.month = 1;
				th.month = 0; // the month start from 0 in javascript.
				tunit /= self._tmInc.year;
				th.year = self._tround(th.year, tunit, roundup);
				return self._getTimeAsDouble(th);
			} else {
				td = tv;
				tx = td - tunit;
				tz = parseInt(tx / unit, 10) * unit;
				if (roundup && tz !== tx) {
					tz += unit;
				}
				td = tunit + tz;
				return td;
			}
		},

		_tround: function (tval, tunit, roundup) {
			var test = parseInt((tval / tunit) * tunit, 10);
			if (roundup && test !== tval) {
				test += parseInt(tunit, 10);
			}
			return test;
		},

		_getTimeAsDouble: function (th) {
			var smon = 0, 
				sday = 0,
				newDate = null;
			if (th.day < 1) {
				sday = -1 - th.day;
				th.day = 1;
			} else if (th.day > 28) {
				sday = th.day - 28;
				th.day = 28;
			}

			/*
			if (th.month < 1) {
			smon = -1 - th.day;
			th.month = 1;
			}
			else if (th.month > 12) {
			smon = th.month - 12;
			th.month = 12;
			}
			*/
			//the month start from 0 & end with 11 in javascript.
			if (th.month < 0) {
				smon = -1 - th.day;
				th.month = 0;
			} else if (th.month > 11) {
				smon = th.month - 11;
				th.month = 11;
			}
			newDate = new Date(th.year, th.month, th.day, 
				th.hour, th.minute, th.second);
			newDate.setDate(newDate.getDate() + sday);
			newDate.setMonth(newDate.getMonth() + smon);
			return this._toOADate(newDate);
		},

		_getTimeDefaultFormat: function (max, min) {
			var self = this,
				//range = (max - min) * self._tmInc.day,
				range = max - min,
				format = "s";
			if (range > 2 * self._tmInc.year) {
				format = "yyyy";
			} else if (range > self._tmInc.year) {
				format = "MMM yy";
			} else if (range > 3 * self._tmInc.month) {
				format = "MMM";
			} else if (range > 2 * self._tmInc.week) {
				format = "MMM d";
			} else if (range > 2 * self._tmInc.day) {
				format = "ddd d";
			} else if (range > self._tmInc.day) {
				format = "ddd H:mm";
			} else if (range > self._tmInc.hour) {
				format = "H:mm";
			} else if (range >= 1000) {
				format = "H:mm:ss";
			}
			/*else if (range > 0) {
				//TODO: return millisecond
			}*/
			return format;
		},

		_niceTimeUnit: function (timeinc, manualFormat) {
			var self = this,
				//tsRange = timeinc * self._tmInc.day;
				tsRange = timeinc;

			tsRange = self._niceTimeSpan(tsRange, manualFormat);

			//return tsRange / self._tmInc.day;
			return tsRange;
		},

		_niceTimeSpan: function (range, manualFormat) {
			var self = this,
				minSpan = self._manualTimeInc(manualFormat),
				tsinc = 0, 
				tinc = 0;
			/*if (minSpan < this._tmInc.second) {
				//TODO: calculate when millisecond
			}*/
			tsinc = Math.ceil(range);
			if (tsinc === 0) {
				return self._timeSpanFromTmInc(minSpan);
			}
			tinc = 1;
			if (minSpan < self._tmInc.minute) {
				if (tsinc < self._tmInc.minute) {
					tinc = self._getNiceInc([1, 2, 5, 10, 15, 30], tsinc, minSpan);
					if (tinc !== 0) {
						return tinc;
					}
				}
				minSpan = self._tmInc.minute;
			}
			if (minSpan < self._tmInc.hour) {
				if (tsinc < self._tmInc.hour) {
					tinc = self._getNiceInc([1, 2, 5, 10, 15, 30], tsinc, minSpan);
					if (tinc !== 0) {
						return tinc;
					}
				}
				minSpan = self._tmInc.hour;
			}
			if (minSpan < self._tmInc.day) {
				if (tsinc < self._tmInc.day) {
					tinc = self._getNiceInc([1, 3, 6, 12], tsinc, minSpan);
					if (tinc !== 0) {
						return tinc;
					}
				}
				minSpan = self._tmInc.day;
			}
			if (minSpan < self._tmInc.month) {
				if (tsinc < self._tmInc.month) {
					tinc = self._getNiceInc([1, 2, 7, 14], tsinc, minSpan);
					if (tinc !== 0) {
						return tinc;
					}
				}
				minSpan = self._tmInc.month;
			}
			if (minSpan < self._tmInc.year) {
				if (tsinc < self._tmInc.year) {
					tinc = self._getNiceInc([1, 2, 3, 4, 6], tsinc, minSpan);
					if (tinc !== 0) {
						return tinc;
					}
				}
				minSpan = self._tmInc.year;
			}
			tinc = 100 * self._tmInc.year;
			if (tsinc < tinc) {
				tinc = self._getNiceInc([1, 2, 5, 10, 20, 50], tsinc, minSpan);
				if (tinc === 0) {
					tinc = 100 * self._tmInc.year;
				}
			}
			return tinc;
		},

		_getNiceInc: function (tik, ts, mult) {
			var i = 0, 
				tikm = 0, 
				ii = tik.length;

			for (i = 0; i < ii; i++) {
				tikm = tik[i] * mult;
				if (ts <= tikm) {
					return tikm;
				}
			}

			return 0;
		},

		_timeSpanFromTmInc: function (ti) {
			var rv = 1000,
				rti = ti,
				ticks = 1;

			if (ti !== this._tmInc.maxtime) {
				if (ti > this._tmInc.tickf1) {
					rv = ti;
				} else {
					ti += 7;
					while (rti > 0) {
						ticks *= 10;
						rti--;
					}
					rv = ticks;
				}
			}
			return rv;
		},

		_manualTimeInc: function (manualFormat) {
			var self = this,
				minSpan = self._tmInc.second;
			if (!manualFormat || manualFormat.length === 0) {
				return minSpan;
			}
			//var f = manualFormat.indexOf("f");
			//if (f > 0) {
			//	//TODO: when _getTimeDefaultFormat return millisecond
			//}
			//else if (manualFormat.indexOf("s") >= 0) {
			if (manualFormat.indexOf("s") >= 0) {
				minSpan = self._tmInc.second;
			} else if (manualFormat.indexOf("m") >= 0) {
				minSpan = self._tmInc.minute;
			} else if (manualFormat.indexOf("h") >= 0 || manualFormat.indexOf("H") >= 0) {
				minSpan = self._tmInc.hour;
			} else if (manualFormat.indexOf("d") >= 0) {
				minSpan = self._tmInc.day;
			} else if (manualFormat.indexOf("M") >= 0) {
				minSpan = self._tmInc.month;
			} else if (manualFormat.indexOf("y") >= 0) {
				minSpan = self._tmInc.year;
			}
			return minSpan;
		},

		_tmInc: {
			tickf7: -7000,
			tickf6: -6000,
			tickf5: -5000,
			tickf4: -4000,
			tickf3: -3000,
			tickf2: -2000,
			tickf1: -1,
			second: 1000,
			minute: 60 * 1000,
			hour: 60 * 60 * 1000,
			day: 24 * 60 * 60 * 1000,
			week: 7 * 24 * 60 * 60 * 1000,
			month: 31 * 24 * 60 * 60 * 1000,
			year: 365 * 24 * 60 * 60 * 1000,
			maxtime: 2147483647	//int.max
		},

		_niceTickNumber: function (x) {
			if (parseFloat(x) === 0.0) {
				return x;
			} else if (x < 0) {
				x = -x;
			}
			var log10 = Math.log(x) / Math.log(10),
				exp = parseInt(this._signedFloor(log10), 10),
				f = x / Math.pow(10.0, exp),
				nf = 10.0;
			if (f <= 1.0) {
				nf = 1.0;
			} else if (f <= 2.0) {
				nf = 2.0;
			} else if (f <= 5.0) {
				nf = 5.0;
			}
			return (nf * Math.pow(10.0, exp));
		},

		_niceNumber: function (x, exp, round) {
			if (parseFloat(x) === 0.0) {
				return x;
			} else if (x < 0) {
				x = -x;
			}

			var f = x / Math.pow(10.0, exp),
				nf = 10.0;

			if (round) {
				if (f < 1.5) {
					nf = 1.0;
				} else if (f < 3.0) {
					nf = 2.0;
				} else if (f < 7.0) {
					nf = 5.0;
				}
			} else {
				if (f <= 1.0) {
					nf = 1.0;
				} else if (f <= 2.0) {
					nf = 2.0;
				} else if (f <= 5.0) {
					nf = 5.0;
				}
			}

			return (nf * Math.pow(10.0, exp));
		},

		_nicePrecision: function (range) {
			if (range <= 0 || typeof (range) !== "number") {
				return 0;
			}

			var log10 = Math.log(range) / Math.log(10),
				exp = parseInt(this._signedFloor(log10), 10),
				f = range / Math.pow(10.0, exp);

			if (f < 3.0) {
				exp = -exp + 1;
			}

			return exp;
		},

		_precCeil: function (prec, value) {
			var f = Math.pow(10.0, prec),
				x = value / f;

			x = Math.ceil(x);

			return x * f;
		},

		_precFloor: function (prec, value) {
			var f = Math.pow(10.0, prec),
				x = value / f;

			x = Math.floor(x);

			return x * f;
		},

		_signedCeiling: function (val) {
			if (val < 0.0) {
				return Math.floor(val);
			}

			return Math.ceil(val);
		},

		_signedFloor: function (val) {
			if (val < 0.0) {
				return Math.ceil(val);
			}

			return Math.floor(val);
		},

		_getDataExtreme: function () {
			var val = {
				txx: 0,
				txn: 0,
				tyx: 0,
				tyn: 0
			};

			this._getDataExtremes(val);
			
			if (val.txn > val.txx) {
				val.txn = 0;
				val.txx = 1;
			}
			return val;
		},

		_getDataExtremes: function (val) {
			var self = this,
				o = self.options,
				seriesList = o.seriesList,
				stacked = o.stacked,
				is100Percent = o.is100Percent,
				axis = o.axis,
				axisInfo = self.axisInfo,
				valuesX = [],
				valuesY = [],
				valueLabels = [];

			if (!seriesList || seriesList.length === 0) {
				return val;
			}
			
			$.each(seriesList, function (idx, series) {
				var data = series.data,
					index = 0,
					k = 0,
					valuesXY = [].concat(data.xy),
					len = valuesXY.length,
					xMinMax, 
					yMinMax;

				valuesX = [].concat(data.x);
				valuesY = [].concat(data.y);
				
				if (data.xy && len) {
					valuesX = [];
					valuesY = [];

					while (k < len) {
						valuesX[index] = valuesXY[k];
						valuesY[index] = valuesXY[k + 1];
						k += 2;
						index++;
						data.x = valuesX;
						data.y = valuesY;
					}
				} else if (!data.x) {
					valuesX = [];
					
					$.each(valuesY, function (i) {
						valuesX.push(i);
					});
					
					data.x = valuesX;
				}

				if (stacked && idx > 0) {
					$.each(valuesY, function (j) {
						if (j === 0) {
							return true;
						}

						valuesY[j] += valuesY[j - 1];
					});
				}

				xMinMax = self._getMinMaxValue(valuesX);
				yMinMax = self._getMinMaxValue(valuesY);
				
				if (idx === 0) {
					val.txx = xMinMax.max;
					val.txn = xMinMax.min;
					val.tyx = yMinMax.max;
					val.tyn = yMinMax.min;
				} else {
					if (val.txx < xMinMax.max) {
						val.txx = xMinMax.max;
					}
					if (val.txn > xMinMax.min) {
						val.txn = xMinMax.min;
					}
					if (val.tyx < yMinMax.max) {
						val.tyx = yMinMax.max;
					}
					if (val.tyn > yMinMax.min) {
						val.tyn = yMinMax.min;
					}
				}
			});

			if (is100Percent) {
				val.tyx = 1;
				val.tyn = 0;
			}

			if (valuesX.length) {
				if (self._isDate(valuesX[0])) {
					axisInfo.x.isTime = true;
				} else if (typeof (valuesX[0]) !== "number") {
					$.each(valuesX, function (idx, valueX) {
						//valueLabels.push({
						//	text: valueX,
						//	value: idx
						//});
						valueLabels.push(valueX);
					});

					axis.x.annoMethod = "valueLabels";
					axis.x.valueLabels = valueLabels;
					axis.x.max = valuesX.length - 1;
					axis.x.min = 0;
					axis.x.unitMajor = 1;
					axis.x.unitMinor = 0.5;
					axisInfo.x.autoMax = false;
					axisInfo.x.autoMin = false;
					axisInfo.x.autoMajor = false;
					axisInfo.x.autoMinor = false;
				}
			}

			if (valuesY.length) {
				if (self._isDate(valuesY[0])) {
					axisInfo.y.isTime = true;
				} else if (typeof (valuesY[0]) !== "number") {
					$.each(valuesY, function (idx, valueY) {
						//valueLabels.push({
						//	text: valueY,
						//	value: idx
						//});
						//Add comments by RyanWu@20110707.
						//For fixing the issue#15881.
						//valueLabels.push(valueY);
						var formatString = axis.y.annoFormatString,
							value = valueY;

						if (formatString && formatString.length > 0) {
							value = $.format(value, formatString);
						} else {
							value = value.toString();
						}

						valueLabels.push(value);
						//end by RyanWu@20110707.
					});

					axis.y.annoMethod = "valueLabels";
					axis.y.valueLabels = valueLabels;
					axis.x.max = valuesY.length - 1;
					axis.x.min = 0;
					axis.y.unitMajor = 1;
					axis.x.unitMinor = 0.5;
					axisInfo.y.autoMax = false;
					axisInfo.y.autoMin = false;
					axisInfo.y.autoMajor = false;
					axisInfo.y.autoMinor = false;
				}
			}
			return val;
		},

		_isDate: function (obj) {
			return (typeof obj === 'object') && obj.constructor === Date;
		},

		_getMinMaxValue: function (array) {
			var self = this,
				val = {
					min: 0,
					max: 0
				},
				i = 0;

			if (!array.length) {
				return;
			}

			if (typeof (array[0]) !== "number") {
				if (self._isDate(array[0])) {
					val.min = array[0];
					val.max = array[0];
				} else {
					val.min = 0;
					val.max = array.length - 1;
					return val;
				}
			} else {
				val.min = array[0];
				val.max = array[0];
			}

			for (i = 0; i < array.length; i++) {
				if (array[i] < val.min) {
					val.min = array[i];
				} else if (array[i] > val.max) {
					val.max = array[i];
				}
			}

			if (self._isDate(val.min)) {
				val.min = self._toOADate(val.min);
				val.max = self._toOADate(val.max);
			}

			return val;
		},

		_toOADate: function (time) {
			//var oaDate = (time - new Date(1900, 0, 1)) / this._tmInc.day + 2;
			var oaDate = time - new Date(1900, 0, 1) + 2 * this._tmInc.day;

			return oaDate;
		},

		_fromOADate: function (oaDate) {
			//var time = new Date((oaDate - 2) * this._tmInc.day + 
			//	new Date(1900, 0, 1).getTime());
			var time = new Date(oaDate - 2 * this._tmInc.day + 
				new Date(1900, 0, 1).getTime());

			return time;
		},

		_isVertical: function (compass) {
			return compass === "west" || compass === "east";
		},

		_calculateMajorMinor: function (axisOptions, axisInfo) {
			var self = this,
				o = self.options,
				canvasBounds = self.canvasBounds,
				autoMajor = axisOptions.autoMajor,
				autoMinor = axisOptions.autoMinor,
				maxData = axisInfo.max,
				minData = axisInfo.min,
				isTime = axisInfo.isTime,
				tinc = axisInfo.tinc,
				formatString = axisInfo.annoFormatString,
				maxText = null, 
				minText = null,
				sizeMax = null, 
				sizeMin = null,
				mx = null, 
				mn = null, 
				prec = null,
				_prec = null, 
				textStyle = null,
				dx = maxData - minData,
				width = 0, 
				height = 0,
				nticks = 0, 
				major = 0;

			if (autoMajor) {
				textStyle = $.extend(true, {}, o.textStyle, 
					axisOptions.textStyle, axisOptions.labels.style);

				if (isTime) {
					maxText = $.format(self._fromOADate(maxData), formatString);
					minText = $.format(self._fromOADate(minData), formatString);

					mx = self._text(-1000, -1000, maxText).attr(textStyle);
					mn = self._text(-1000, -1000, minText).attr(textStyle);

					sizeMax = mx.wijGetBBox();
					sizeMin = mn.wijGetBBox();

					mx.wijRemove();
					mn.wijRemove();
				} else {
					prec = self._nicePrecision(dx);
					_prec = prec + 1;

					if (_prec < 0 || _prec > 15) {
						_prec = 0;
					}

					mx = self._text(-1000, -1000, 
						self.round(maxData, _prec)).attr(textStyle);
					mn = self._text(-1000, -1000, 
						self.round(minData, _prec)).attr(textStyle);

					sizeMax = mx.wijGetBBox();
					sizeMin = mn.wijGetBBox();

					mx.wijRemove();
					mn.wijRemove();
				}

				if (sizeMax.width < sizeMin.width) {
					sizeMax.width = sizeMin.width;
				}

				if (sizeMax.height < sizeMin.height) {
					sizeMax.height = sizeMin.height;
				}

				if (!self._isVertical(axisOptions.compass)) {
					//Add comments by RyanWu@20100907.
					//Subtract axisTextOffset because we must left
					// the space between major text and major rect.
					width = canvasBounds.endX - canvasBounds.startX - 
						axisInfo.vOffset - axisInfo.axisTextOffset;
					major = width / sizeMax.width;

					if (Number.POSITIVE_INFINITY === major) {
						nticks = 0;
					} else {
						nticks = parseInt(major, 10);
					}
				} else {
					height = canvasBounds.endY - canvasBounds.startY - 
						axisInfo.vOffset - axisInfo.axisTextOffset;
					major = height / sizeMax.height;

					if (Number.POSITIVE_INFINITY === major) {
						nticks = 0;
					} else {
						nticks = parseInt(major, 10);
					}
				}

				major = dx;
				if (nticks > 0) {
					dx /= nticks;
					if (isTime) {
						if (dx < tinc) {
							major = tinc;
						} else {
							major = self._niceTimeUnit(dx, axisInfo.annoFormatString);
						}
					} else {
						axisInfo.tprec = self._nicePrecision(dx);
						major = self._niceNumber(2 * dx, -prec, true);

						if (major < dx) {
							major = self._niceNumber(dx, -prec + 1, false);
						}

						if (major < dx) {
							major = self._niceTickNumber(dx);
						}
					}
				}

				axisOptions.unitMajor = major;
			}

			if (autoMinor && axisOptions.unitMajor && !isNaN(axisOptions.unitMajor)) {
				axisOptions.unitMinor = axisOptions.unitMajor / 2;
			}
		},

		_getScaling: function (isVertical, max, min, length) {
			var dx = max - min;

			if (dx === 0) {
				dx = 1;
			}

			if (isVertical) {
				dx = -dx;
			}

			return length / dx;
		},

		_getTranslation: function (isVertical, location, max, min, scaling) {
			var translation = 0;

			if (isVertical) {
				translation = location.y;
				translation -= scaling * max;
			} else {
				translation = location.x;
				translation -= scaling * min;
			}

			return translation;
		},
		//end of methods for Axis	

		//methods for jQuery extention
	
		_isSVGElem: function (node) {
			var svgNS = "http://www.w3.org/2000/svg";
			return (node.nodeType === 1 && node.namespaceURI === svgNS);
		},

		_addClass: function (ele, classNames) {
			var self = this;
			classNames = classNames || '';
			$.each(ele, function () {
				if (self._isSVGElem(this)) {
					var node = this;
					$.each(classNames.split(/\s+/), function (i, className) {
						var classes = (node.className ? 
							node.className.baseVal : node.getAttribute('class'));
						if ($.inArray(className, classes.split(/\s+/)) === -1) {
							classes += (classes ? ' ' : '') + className;
							
							if (node.className) {
								node.className.baseVal = classes;
							} else {
								node.setAttribute('class', classes);
							}
						}
					});
				} else {
					$(this).addClass(classNames);
				}
			});
		} /*,
	
	_removeClass: function(ele, classNames) {
		var self = this;
		classNames = classNames || '';
		$.each(ele, function() {
			if (isSVGElem(this)) {
				var node = this;
				$.each(classNames.split(/\s+/), function(i, className) {
					var classes = (node.className ? 
						node.className.baseVal : node.getAttribute('class'));
					classes = $.grep(classes.split(/\s+/), 
						function(n, i) { return n != className; }).
						join(' ');
					(node.className ? node.className.baseVal = classes :
						node.setAttribute('class', classes));
				});
			}
			else {
				$(this).removeClass(classNames);
			}
		});
	},

	_hasClass: function(ele, className) {
		var self = this;
		className = className || '';
		var found = false;
		$.each(ele, function() {
			if(isSVGElem(this)) {
				var classes = (this.className ? this.className.baseVal :
					this.getAttribute('class')).split(/\s+/);
				found = ($.inArray(className, classes) > -1);
			}
			else {
				found = $(this).hasClass(className);
			}
			return !found;
		});
		return found;
	}
	*/

		//end of methods
	});
}(jQuery));

/*globals jQuery*/
/*
 *
 * Wijmo Library 1.4.0
 * http://wijmo.com/
 *
 * Copyright(c) ComponentOne, LLC.  All rights reserved.
 * 
 * Dual licensed under the Wijmo Commercial or GNU GPL Version 3 licenses.
 * licensing@wijmo.com
 * http://wijmo.com/license
 *
 *
 * * Wijmo BarChart widget
 *
 * Depends:
 *  raphael.js
 *  jquery.glob.min.js
 *  jquery.ui.widget.js
 *  jquery.wijmo.wijchartcore.js
 *
 */

(function ($) {
	"use strict";

	$.widget("wijmo.wijbarchart", $.wijmo.wijchartcore, {
		options: {
			/// <summary>
			/// A value that determines whether the bar chart 
			///	renders horizontal or vertical.
			/// Default: true.
			/// Type: Boolean.
			/// Code example:
			///  $("#barchart").wijbarchart({
			///      horizontal: false
			///  });
			/// </summary>
			horizontal: true,
			/// <summary>
			/// A value that determines whether to show a stacked chart.
			/// Default: false.
			/// Type: Boolean.
			/// Code example:
			///  $("#barchart").wijbarchart({
			///      stacked: true
			///  });
			/// </summary>
			stacked: false,
			/// <summary>
			/// A value that determines whether to show a stacked and percentage chart.
			/// Default: false.
			/// Type: Boolean.
			/// Code example:
			///  $("#barchart").wijbarchart({
			///      is100Percent: true
			///  });
			/// </summary>
			is100Percent: false,
			/// <summary>
			/// A value that indicates the percentage of bar elements 
			///	in the same cluster overlap.
			/// Default: 0.
			/// Type: Number.
			/// Code example:
			///  $("#barchart").wijbarchart({
			///      clusterOverlap: 10
			///  });
			/// </summary>
			clusterOverlap: 0,
			/// <summary>
			/// A value that indicates the percentage of the plotarea 
			///	that each bar cluster occupies.
			/// Default: 85.
			/// Type: Number.
			/// Code example:
			///  $("#barchart").wijbarchart({
			///      clusterWidth: 75
			///  });
			/// </summary>
			clusterWidth: 85,
			/// <summary>
			/// A value that indicates the corner-radius for the bar.
			/// Default: 0.
			/// Type: Number.
			/// Code example:
			///  $("#barchart").wijbarchart({
			///      clusterRadius: 5
			///  });
			/// </summary>
			clusterRadius: 0,
			/// <summary>
			/// A value that indicates the spacing between the adjacent bars.
			/// Default: 0.
			/// Type: Number.
			/// Code example:
			///  $("#barchart").wijbarchart({
			///      clusterSpacing: 3
			///  });
			/// </summary>
			clusterSpacing: 0,
			/// <summary>
			/// A value that indicates whether to show animation 
			///	and the duration for the animation.
			/// Default: {enabled:true, duration:400, easing: ">"}.
			/// Type: Object.
			/// Code example:
			///  $("#barchart").wijbarchart({
			///      animation: {
			///			enabled: true, duration: 1000, easing: "<"
			///		}
			///  });
			/// </summary>
			animation: {
				/// <summary>
				/// A value that determines whether to show animation.
				/// Default: true.
				/// Type: Boolean.
				/// </summary>
				enabled: true,
				/// <summary>
				/// A value that indicates the duration for the animation.
				/// Default: 400.
				/// Type: Number.
				/// </summary>
				duration: 400,
				/// <summary>
				/// A value that indicates the easing for the animation.
				/// Default: ">".
				/// Type: string.
				/// </summary>
				easing: ">"
			},
			/// <summary>
			/// A value that indicates whether to show animation 
			///	and the duration for the animation when reload data.
			/// Default: {enabled:true, duration:400, easing: ">"}.
			/// Type: Object.
			/// Code example:
			///  $("#barchart").wijbarchart({
			///      animation: {enabled: true, duration: 1000, easing: "<"}
			///  });
			/// </summary>
			seriesTransition: {
				/// <summary>
				/// A value that determines whether to show animation when reload.
				/// Default: true.
				/// Type: Boolean.
				/// </summary>
				enabled: true,
				/// <summary>
				/// A value that indicates the duration for the series transition.
				/// Default: 400.
				/// Type: Number.
				/// </summary>
				duration: 400,
				/// <summary>
				/// A value that indicates the easing for the series transition.
				/// Default: ">".
				/// Type: string.
				/// </summary>
				easing: ">"
			},
			/// <summary>
			/// Occurs when the user clicks a mouse button.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#barchart").wijbarchart({mouseDown: function(e, data) { } });
			/// Bind to the event by type: wijbarchartmousedown
			/// $("#barchart").bind("wijbarchartmousedown", function(e, data) {} );
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains all the series infos of the mousedown bar.
			/// data.bar: the Raphael object of the bar.
			/// data.data: data of the series of the bar.
			/// data.hoverStyle: hover style of series of the bar.
			/// data.index: index of the bar.
			/// data.label: label of the series of the bar.
			/// data.legendEntry: legend entry of the series of the bar.
			/// data.style: style of the series of the bar.
			/// data.type: "bar"
			///	</param>
			mouseDown: null,
			/// <summary>
			/// Occurs when the user releases a mouse button
			/// while the pointer is over the chart element.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#barchart").wijbarchart({mouseUp: function(e, data) { } });
			/// Bind to the event by type: wijbarchartmouseup
			/// $("#barchart").bind("wijbarchartmouseup", function(e, data) {} );
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains all the series infos of the mouseup bar.
			/// data.bar: the Raphael object of the bar.
			/// data.data: data of the series of the bar.
			/// data.hoverStyle: hover style of series of the bar.
			/// data.index: index of the bar.
			/// data.label: label of the series of the bar.
			/// data.legendEntry: legend entry of the series of the bar.
			/// data.style: style of the series of the bar.
			/// data.type: "bar"
			///	</param>
			mouseUp: null,
			/// <summary>
			/// Occurs when the user first places the pointer over the chart element.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#barchart").wijbarchart({mouseOver: function(e, data) { } });
			/// Bind to the event by type: wijbarchartmouseover
			/// $("#barchart").bind("wijbarchartmouseover", function(e, data) {} );
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains all the series infos of the mouseover bar.
			/// data.bar: the Raphael object of the bar.
			/// data.data: data of the series of the bar.
			/// data.hoverStyle: hover style of series of the bar.
			/// data.index: index of the bar.
			/// data.label: label of the series of the bar.
			/// data.legendEntry: legend entry of the series of the bar.
			/// data.style: style of the series of the bar.
			/// data.type: "bar"
			///	</param>
			mouseOver: null,
			/// <summary>
			/// Occurs when the user moves the pointer off of the chart element.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#barchart").wijbarchart({mouseOut: function(e, data) { } });
			/// Bind to the event by type: wijbarchartmouseout
			/// $("#barchart").bind("wijbarchartmouseout", function(e, data) {} );
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains all the series infos of the mouseout bar.
			/// data.bar: the Raphael object of the bar.
			/// data.data: data of the series of the bar.
			/// data.hoverStyle: hover style of series of the bar.
			/// data.index: index of the bar.
			/// data.label: label of the series of the bar.
			/// data.legendEntry: legend entry of the series of the bar.
			/// data.style: style of the series of the bar.
			/// data.type: "bar"
			///	</param>
			mouseOut: null,
			/// <summary>
			/// Occurs when the user moves the mouse pointer
			/// while it is over a chart element.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#barchart").wijbarchart({mouseMove: function(e, data) { } });
			/// Bind to the event by type: wijbarchartmousemove
			/// $("#barchart").bind("wijbarchartmousemove", function(e, data) {} );
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains all the series infos of the mousemove bar.
			/// data.bar: the Raphael object of the bar.
			/// data.data: data of the series of the bar.
			/// data.hoverStyle: hover style of series of the bar.
			/// data.index: index of the bar.
			/// data.label: label of the series of the bar.
			/// data.legendEntry: legend entry of the series of the bar.
			/// data.style: style of the series of the bar.
			/// data.type: "bar"
			///	</param>
			mouseMove: null,
			/// <summary>
			/// Occurs when the user clicks the chart element. 
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#barchart").wijbarchart({click: function(e, data) { } });
			/// Bind to the event by type: wijbarchartclick
			/// $("#barchart").bind("wijbarchartclick", function(e, data) {} );
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains all the series infos of the clicked bar.
			/// data.bar: the Raphael object of the bar.
			/// data.data: data of the series of the bar.
			/// data.hoverStyle: hover style of series of the bar.
			/// data.index: index of the bar.
			/// data.label: label of the series of the bar.
			/// data.legendEntry: legend entry of the series of the bar.
			/// data.style: style of the series of the bar.
			/// data.type: "bar"
			///	</param>
			click: null
		},

		_create: function () {
			var defFill = [
					"0-#8ac4c0-#77b3af",
					"0-#73a19e-#67908e",
					"0-#4f687b-#465d6e",
					"0-#69475b-#5d3f51",
					"0-#7a3b3f-#682e32",
					"0-#9d5b5b-#8c5151",
					"0-#e5a36d-#ce9262",
					"0-#e6cc70-#ceb664",
					"0-#8ec858-#7fb34f",
					"0-#3a9073-#2a7b5f",
					"0-#6c88e3-#6079cb",
					"0-#6cb4e3-#60a0cb"
				],
				self = this,
				o = self.options;

			if (o.horizontal) {
				$.extend(true, o.axis, {
					x: {
						compass: "west"
					},
					y: {
						compass: "south"
					}
				});
			}

			$.extend(true, {
				compass: "east"
			}, o.hint);

			// default some fills
			$.each(o.seriesStyles, function (idx, style) {
				if (!style.fill) {
					style.fill = defFill[idx];
				}
			});

			self.bars = [];
			self.animatedBars = [];
			self.chartLabels = [];

			$.wijmo.wijchartcore.prototype._create.apply(self, arguments);
			self.chartElement.addClass("wijmo-wijbarchart");
		},

		_setOption: function (key, value) {
			if (key === "horizontal" && !value) {
				$.extend(true, this.options.axis, {
					x: {
						compass: "south"
					},
					y: {
						compass: "west"
					}
				});
			}

			$.wijmo.wijchartcore.prototype._setOption.apply(this, arguments);
		},

		destroy: function () {
			var self = this;
			self.chartElement
				.removeClass("wijmo-wijbarchart ui-helper-reset");
			$.wijmo.wijchartcore.prototype.destroy.apply(this, arguments);
			
			if (self.aniBarsAttr && self.aniBarsAttr.length) {
				$.each(self.aniBarsAttr, function (idx, barAttr) {
					barAttr = null;
				});
				self.aniBarsAttr = null;
			}
		},

		_isBarChart: function () {
			return true;
		},

		/*****************************
		Widget specific implementation
		******************************/
		/** public methods */
		getBar: function (index) {
			/// <summary>
			/// Returns the bar which has a set of the Raphael's objects(rects) 
			/// that represents bars for the series data with the given index.
			/// </summary>
			/// <param name="index" type="Number">
			/// The index of the bar.
			/// </param>
			/// <returns type="Raphael element">
			/// The bar object.
			/// </returns>
			return this.bars[index];
		},
		/** end of public methods */

		/** private methods */
		
		_paint: function () {
			var self = this,
				o = self.options,
				sl = o.seriesList,
				isChangeSL = false,
				xVal,
				newSL;
			if (sl.length && sl[0].data && sl[0].data.x && sl[0].data.x.length) {
				xVal = sl[0].data.x[0];
				if(self._isDate(xVal)) {
					isChangeSL = true;
				} 
			}
			if (isChangeSL) {
				self.seriesList = sl;
				newSL = self._cloneSeriesList(sl, o.axis.x.annoFormatString);
				o.seriesList = newSL;
			}
			
			$.wijmo.wijchartcore.prototype._paint.apply(self, arguments);
			if (isChangeSL) {
				o.seriesList = self.seriesList;
			}
		},
		
		_cloneSeriesList: function (seriesList, annoFormatString) {
			var sList = [];
			$.each(seriesList, function (idx, series) {
				var s = $.extend(true, {}, series);
				if (s.data && s.data.x && s.data.x.length) {
					$.each(s.data.x, function (i, x) {
						var val;
						if (annoFormatString && annoFormatString.length) {
							val = $.format(x, annoFormatString);
						} else {
							val = x.toString();
						}
						s.data.x[i] = val;
					});
				}
				sList.push(s);
			});
			return sList;
		},
		
		_clearChartElement: function () {
			var self = this;

			if (self.bars && self.bars.length) {
				$.each(self.bars, function (idx, bar) {
					if (bar.shadow) {
						bar.shadow.wijRemove();
						bar.shadow = null;
					}

					if (bar) {
						bar.wijRemove();
						bar = null;
					}
				});
				self.bars = [];
			}

			if (self.animatedBars && self.animatedBars.length) {
				$.each(self.animatedBars, function (idx, animatedBar) {
					if (animatedBar) {
						animatedBar.stop();
						animatedBar.wijRemove();
						animatedBar = null;
					}
				});
				self.animatedBars = [];
			}

			if (self.chartLabels && self.chartLabels.length) {
				$.each(self.chartLabels, function (idx, chartLabel) {
					if (chartLabel) {
						chartLabel.wijRemove();
						chartLabel = null;
					}
				});
				self.chartLabels = [];
			}

			$.wijmo.wijchartcore.prototype._clearChartElement.apply(self, arguments);
		},

		_adjustToLimits: function (val, min, max) {
			if (val < min) {
				return min;
			}

			if (val > max) {
				return max;
			}

			return val;
		},

		_transformPoints: function (inverted, xscale, yscale, xlate, ylate, points) {
			$.each(points, function (idx, point) {
				var x = point.x,
					y = point.y,
					temp = 0;
				point.x = xscale * x + xlate;
				point.y = yscale * y + ylate;

				if (inverted) {
					temp = point.x;
					point.x = point.y;
					point.y = temp;
				}
			});

			return points;
		},

		_paintPlotArea: function () {
			var self = this,
				o = self.options,
				inverted = o.horizontal,
				stacked = o.stacked,
				seriesList = [].concat(o.seriesList),
				nSeries = seriesList.length,
				seriesStyles = [].concat(o.seriesStyles.slice(0, nSeries)),
				seriesHoverStyles = [].concat(o.seriesHoverStyles.slice(0, nSeries)),
				canvasBounds = self.canvasBounds,
				startLocation = { x: canvasBounds.startX, y: canvasBounds.startY },
				width = canvasBounds.endX - startLocation.x,
				height = canvasBounds.endY - startLocation.y,
				xaxis = o.axis.x, //todo need add chartarea
				yaxis = o.axis.y,
				clusterInfos,
				xscale = self._getScaling(inverted, xaxis.max,
							xaxis.min, inverted ? height : width),
				yscale = self._getScaling(!inverted, yaxis.max,
							yaxis.min, inverted ? width : height),
				xlate = self._getTranslation(inverted, startLocation,
							xaxis.max, xaxis.min, xscale),
				ylate = self._getTranslation(!inverted, startLocation,
							yaxis.max, yaxis.min, yscale);

			if (inverted && !stacked) {
				seriesList.reverse();
				seriesStyles.reverse();
				seriesHoverStyles.reverse();
			}

			if (nSeries === 0) {
				return;
			}

			// plot a bar group for each datapoint
			clusterInfos = self._paintClusters(seriesList,
				seriesStyles,
				seriesHoverStyles, {
					min: xaxis.min,
					max: xaxis.max,
					late: xlate,
					scale: xscale
				}, {
					min: yaxis.min,
					max: yaxis.max,
					late: ylate,
					scale: yscale
				}, width, height, startLocation);

			self.chartElement.data("plotInfos", {
				xscale: xscale,
				xlate: xlate,
				yscale: yscale,
				ylate: ylate,
				rects: clusterInfos.rects
			});

			self._playAnimation(clusterInfos.animatedBars);
			self.bars = clusterInfos.bars;
			self.animatedBars = clusterInfos.animatedBars;
			self.chartLabels = clusterInfos.chartLabels;
		},

		_paintClusters: function (seriesList, seriesStyles, seriesHoverStyles,
								xAxisInfo, yAxisInfo, width, height, startLocation) {
			var self = this,
				o = self.options,
				stacked = o.stacked,
				clusterOverlap = o.clusterOverlap / 100,
				clusterWidth = o.clusterWidth / 100,
				shadowOffset = 1,
				clusterSpacing = o.clusterSpacing + shadowOffset,
				animation = o.animation,
				animated = animation && animation.enabled,
				nSeries = seriesList.length,
				bpl, 
				bw,
				chartLabels = [],
				bars = [],
				animatedBars = [],
				rects = [],
				isYTime = self.axisInfo.y.isTime,
				sList = [];

			if (isYTime) {
				$.each(seriesList, function (i, s) {
					var se = $.extend(true, {}, s);
					if (se.data && se.data.y && se.data.y.length) {
						$.each (se.data.y, function (idx, data) {
							se.data.y[idx] = self._toOADate(data);
						});
					}
					sList.push(se);
				});
				bpl = self._barPointList(sList);
			} else {
				bpl = self._barPointList(seriesList);
			}

			if (stacked) {
				bpl = self._stackValues(bpl);
			}

			bw = self._getMinDX(bpl) * clusterWidth;

			// adjust the bar width (bw) to account for overlap
			if (nSeries > 1 && !stacked) {
				clusterOverlap -= (bpl.length * (nSeries - 1) * clusterSpacing) /
					(o.horizontal ? height : width);
				bw /= (nSeries * (1 - clusterOverlap) + clusterOverlap);
			}

			$.each(bpl, function (pIdx, xs) {
				var ps = xs.paSpec,
					ns = ps.length,
					sx, 
					rp,
					bar, 
					barInfo;

				if (stacked) {
					sx = bw;
				} else {
					sx = (bw * (ns * (1 - clusterOverlap) + clusterOverlap));
				}

				// calculate the first series rectangle
				rp = { x: xs.x - sx / 2, y: 0, width: bw, height: ps[0].y };

				$.each(ps, function (sIdx, series) {
					if (!rects[sIdx]) {
						rects[sIdx] = [];
					}

					var idx = series.sIdx,
						seriesStyle = seriesStyles[idx];

					barInfo = self._paintBar(rp, series.y, height, xAxisInfo, yAxisInfo,
								seriesStyle, animated, shadowOffset, startLocation,
								clusterOverlap,
								sIdx > 0 ? ps[sIdx - 1].y : null, ps[ps.length - 1].y,
								isYTime);

					bar = barInfo.bar;
					self._addClass($(bar.node), "wijchart-canvas-object");
					$(bar.node).data("wijchartDataObj", $.extend(true, {
						index: pIdx,
						bar: bar,
						type: "bar",
						style: seriesStyle,
						hoverStyle: seriesHoverStyles[idx]
					}, seriesList[idx]));

					bars.push(bar);

					if (barInfo.animatedBar) {
						animatedBars.push(barInfo.animatedBar);
					}

					if (barInfo.dcl) {
						chartLabels.push(barInfo.dcl);
					}
					rects[sIdx][pIdx] = barInfo.rect;
				});
			});

			//set default chart label to front.
			$.each(chartLabels, function (idx, chartLabel) {
				chartLabel.toFront();
			});

			return { bars: bars, animatedBars: animatedBars,
				rects: rects, chartLabels: chartLabels };
		},

		_paintBar: function (rp, y, height, xAxisInfo, yAxisInfo, seriesStyle,
				animated, shadowOffset, startLocation, clusterOverlap, preY, lastY,
				isYTime) {
			var self = this,
				o = self.options,
				stacked = o.stacked,
				is100Percent = o.is100Percent,
				inverted = o.horizontal,
				xmin = xAxisInfo.min,
				xmax = xAxisInfo.max,
				ymin = yAxisInfo.min,
				ymax = yAxisInfo.max,
				xscale = xAxisInfo.scale,
				xlate = xAxisInfo.late,
				yscale = yAxisInfo.scale,
				ylate = yAxisInfo.late,
				hold, 
				x, 
				inPlotArea, 
				rf,
				defaultChartLabel = null,
				r,
				style = seriesStyle,
				strokeWidth = seriesStyle["stroke-width"],
				stroke = seriesStyle.stroke,
				bar, 
				animatedBar,
				canvas = self.canvas;

			if (stacked) {
				if (is100Percent) {
					if (lastY > 0) {
						rp.height = y / lastY;
					}

					if (preY || preY === 0) {
						rp.y = preY / lastY;
						rp.height -= rp.y;
					}
				} else {
					rp.height = y;

					if (preY || preY === 0) {
						rp.height -= preY;
						rp.y = preY;
					}
				}
			} else {
				if (preY || preY === 0) {
					// 1 bar over less overlap and 1 pixel
					rp.x += rp.width * (1 - clusterOverlap);
					rp.height = y;
				}
			}

			x = [{ x: rp.x, y: rp.y }, { x: rp.x + rp.width, y: rp.y + rp.height}];
			inPlotArea = ((xmin <= x[0].x && x[0].x <= xmax) ||
				(xmin <= x[1].x && x[1].x <= xmax)) &&
				((ymin <= x[0].y && x[0].y <= ymax) ||
				(ymin <= x[1].y && x[1].y <= ymax));

			x[0].x = self._adjustToLimits(x[0].x, xmin, xmax);
			x[0].y = self._adjustToLimits(x[0].y, ymin, ymax);
			x[1].x = self._adjustToLimits(x[1].x, xmin, xmax);
			x[1].y = self._adjustToLimits(x[1].y, ymin, ymax);

			x = self._transformPoints(inverted, xscale, yscale, xlate, ylate, x);

			if (x[0].x > x[1].x) {
				hold = x[0].x;
				x[0].x = x[1].x;
				x[1].x = hold;
			}

			if (x[0].y > x[1].y) {
				hold = x[0].y;
				x[0].y = x[1].y;
				x[1].y = hold;
			}

			rf = { 
				x: x[0].x, 
				y: x[0].y,
				width: x[1].x - x[0].x, 
				height: x[1].y - x[0].y
			};

			if (inPlotArea) {
				if (rf.width === 0) {
					rf.width = 0.5;
				}

				if (rf.height === 0) {
					rf.height = 0.5;
				}
			}

			if (o.showChartLabels) {
				defaultChartLabel = self._paintDefaultChartLabel(rf, y, isYTime);
			}

			r = seriesStyle.r ? seriesStyle.r : o.clusterRadius;

			if (r) {
				style = $.extend(true, {}, seriesStyle, {
					r: 0
				});
			}

			if (stroke !== "none" && strokeWidth) {
				strokeWidth = parseInt(strokeWidth, 10);
			}

			if (!strokeWidth || isNaN(strokeWidth)) {
				strokeWidth = 0;
			}

			if (animated) {
				if (r) {
					if (inverted) {
						bar = canvas.wij.roundRect(rf.x, rf.y, rf.width - strokeWidth,
										rf.height - strokeWidth, 0, 0, r, r).hide();
						animatedBar = canvas.rect(startLocation.x, rf.y, 0,
										rf.height - strokeWidth);
					} else {
						bar = canvas.wij.roundRect(rf.x, rf.y, rf.width - strokeWidth,
										rf.height - strokeWidth, r, 0, 0, r).hide();
						animatedBar = canvas.rect(rf.x,
										startLocation.y + height - strokeWidth,
										rf.width, 0);
					}

					self._paintShadow(animatedBar, shadowOffset);
					animatedBar.wijAttr(style);
					animatedBar.bar = bar;
				} else {
					if (inverted) {
						bar = canvas.rect(startLocation.x, rf.y,
									0, rf.height - strokeWidth);
					} else {
						bar = canvas.rect(rf.x,
									startLocation.y + height - strokeWidth,
									rf.width, 0);
					}
					animatedBar = bar;
				}

				if (defaultChartLabel) {
					defaultChartLabel.attr({ opacity: 0 });
					animatedBar.chartLabel = defaultChartLabel;
				}

				animatedBar.left = rf.x;
				animatedBar.top = rf.y;
				animatedBar.width = rf.width - strokeWidth;
				animatedBar.height = rf.height - strokeWidth;
				animatedBar.r = r;
			} else {
				if (r) {
					bar = canvas.wij.roundRect(rf.x, rf.y,
						rf.width - strokeWidth, rf.height - strokeWidth, 0, 0, r, r);
				} else {
					bar = canvas.rect(rf.x, rf.y,
						rf.width - strokeWidth, rf.height - strokeWidth);
				}
			}

			self._paintShadow(bar, shadowOffset);
			if (animated && r) {
				bar.shadow.hide();
			}
			bar.wijAttr(seriesStyle);

			return { 
				rect: rf, 
				dcl: defaultChartLabel,
				animatedBar: animatedBar, 
				bar: bar
			};
		},

		_playAnimation: function (animatedBars) {
			var self = this,
				o = self.options,
				animation = o.animation,
				seriesTransition = o.seriesTransition,
				duration, 
				easing,
				aniBarsAttr = [],
				diffAttr;

			if (animation && animation.enabled) {
				duration = animation.duration || 2000;
				easing = animation.easing || "linear";
				$.each(animatedBars, function (idx, animatedBar) {
					var params = o.horizontal ?
							{ width: animatedBar.width, x: animatedBar.left} :
							{ height: animatedBar.height, y: animatedBar.top };

					if (self.aniBarsAttr && seriesTransition.enabled) {
						diffAttr = self._getDiffAttrs(self.aniBarsAttr[idx],
							animatedBar.attr());

						if (o.horizontal) {
							diffAttr.left = self.aniBarsAttr[idx].left;
							diffAttr.width = self.aniBarsAttr[idx].width;
						} else {
							diffAttr.top = self.aniBarsAttr[idx].top;
							diffAttr.height = self.aniBarsAttr[idx].height;
						}

						if (diffAttr.path) {
							delete diffAttr.path;
						}
						animatedBar.attr(diffAttr);
						duration = seriesTransition.duration;
						easing = seriesTransition.easing;
					}
					aniBarsAttr.push($.extend(true, {}, animatedBar.attr(), params));
					
					animatedBar.stop().wijAnimate(params, duration, easing, function () {
						var b = this,
							r = b.r,
							bar = b;
						
						if (b.chartLabel) {
							b.chartLabel.wijAnimate({ opacity: 1 }, 250);
						}

						if (r) {
							bar = b.bar;
							bar.show();
							if (bar.shadow) {
								bar.shadow.show();
							}

							if (b.shadow) {
								b.shadow.wijRemove();
								b.shadow = null;
							}
							b.wijRemove();
							b = null;
						}
					});
				});
				self.aniBarsAttr = aniBarsAttr;
			}
		},

		_paintDefaultChartLabel: function (rf, y, isTime) {
			var self = this,
				o = self.options,
				inverted = o.horizontal,
				textStyle = $.extend(true, {}, o.textStyle, o.chartLabelStyle),
				pos = inverted ? { x: rf.x + rf.width, y: rf.y + rf.height / 2} :
								{ x: rf.x + rf.width / 2, y: rf.y },
				dclBox, 
				defaultChartLabel,
				text;
			if (isTime) {
				text = self._fromOADate(y);
			} else { 
				text = self.round(y, 2);
			}

			if (o.chartLabelFormatString && o.chartLabelFormatString.length) {
				text = $.format(text, o.chartLabelFormatString);
			}
			defaultChartLabel = self._text(pos.x, pos.y, text)
				.attr(textStyle);
			dclBox = defaultChartLabel.getBBox();
			if (inverted) {
				defaultChartLabel.attr({x: pos.x + dclBox.width / 2});
			} else {
				defaultChartLabel.attr({y: pos.y - dclBox.height / 2});
			}

			return defaultChartLabel;
		},

		_getChartLabelPointPosition: function (chartLabel) {
			var self = this,
				method = chartLabel.attachMethod,
				data = chartLabel.attachMethodData,
				point = { x: 0, y: 0 },
				pi, 
				seriesIndex, 
				pointIndex,
				x, 
				y, 
				rects, 
				rs, 
				rect, 
				barData;

			switch (method) {
			case "coordinate":
				point.x = data.x;
				point.y = data.y;
				break;
			case "dataCoordinate":
				pi = self.chartElement.data("plotInfos");
				x = data.x;
				y = data.y;
				if (self._isDate(x)) {
					x = self._toOADate(x);
				}
				if (self._isDate(y)) {
					y = self._toOADate(y);
				}
				point = self._transformPoints(pi.xscale, pi.yscale,
										pi.xlate, pi.ylate, { x: x, y: y });
				break;
			case "dataIndex":
				seriesIndex = data.seriesIndex;
				pointIndex = data.pointIndex;
				pi = self.chartElement.data("plotInfos");
				if (seriesIndex > -1) {
					rects = pi.rects;
					if (rects.length > seriesIndex) {
						rs = rects[seriesIndex];
						rect = rs[pointIndex];
						point.x = rect.x + rect.width;
						point.y = rect.y + rect.height / 2;
					}
				}
				break;
			case "dataIndexY":
				seriesIndex = data.seriesIndex;
				pointIndex = data.pointIndex;
				if (seriesIndex > -1) {
					barData = self.options.seriesList[seriesIndex].data;
					x = barData.x[pointIndex];
					y = data.y;
					pi = self.chartElement.data("plotInfos");
					if (self._isDate(x)) {
						x = self._toOADate(x);
					}
					if (self._isDate(y)) {
						y = self._toOADate(y);
					}
					point = self._transformPoints(pi.xscale, pi.yscale,
											pi.xlate, pi.ylate, { x: x, y: y });
				}
				break;
			}
			return point;
		},

		_getTooltipText: function (fmt, target) {
			var dataObj = $(target.node).data("wijchartDataObj"),
				index = dataObj.index,
				data = dataObj.data,
				valueX, 
				valueY, 
				obj;

			if (data.x) {
				valueX = data.x[index];
				valueY = data.y[index];
			} else {
				valueX = data.xy[2 * index];
				valueY = data.xy[2 * index + 1];
			}

			obj = {
				x: valueX,
				y: valueY,
				data: dataObj,
				target: target,
				fmt: fmt
			};

			return $.proxy(fmt, obj)();
		},

		_bindLiveEvents: function () {
			var self = this,
				o = self.options,
				hintEnable = o.hint.enable,
				tooltip = self.tooltip,
				hint, 
				title, 
				content;

			if (hintEnable && !tooltip) {
				hint = $.extend(true, {}, o.hint);
				hint.offsetY = hint.offsetY || -2;
				title = hint.title;
				content = hint.content;

				if ($.isFunction(title)) {
					hint.title = function () {
						return self._getTooltipText(title, this.target);
					};
				}

				if ($.isFunction(content)) {
					hint.content = function () {
						return self._getTooltipText(content, this.target);
					};
				}
				hint.beforeShowing = function () {
					if (this.target) {
						this.options.style.stroke = this.target.attrs.stroke ||
							this.target.attrs.fill;
					}
				};
				tooltip = self.canvas.tooltip(self.bars, hint);
				self.tooltip = tooltip;
			}

			$(".wijchart-canvas-object", self.chartElement[0])
				.live("mousedown.wijbarchart", function (e) {
					if (o.disabled) {
						return;
					}

					self._trigger("mouseDown", e, $(e.target).data("wijchartDataObj"));
				})
				.live("mouseup.wijbarchart", function (e) {
					if (o.disabled) {
						return;
					}

					self._trigger("mouseUp", e, $(e.target).data("wijchartDataObj"));
				})
				.live("mouseover.wijbarchart", function (e) {
					if (o.disabled) {
						return;
					}

					self._trigger("mouseOver", e, $(e.target).data("wijchartDataObj"));
				})
				.live("mouseout.wijbarchart", function (e) {
					if (o.disabled) {
						return;
					}

					var dataObj = $(e.target).data("wijchartDataObj"),
						bar = dataObj.bar;
					self._trigger("mouseOut", e, dataObj);

					if (!dataObj.hoverStyle) {
						if (bar) {
							bar.attr({ opacity: "1" });
						}
					} else {
						bar.attr(dataObj.style);
					}

					if (tooltip) {
						tooltip.hide();
					}
				})
				.live("mousemove.wijbarchart", function (e) {
					if (o.disabled) {
						return;
					}

					var dataObj = $(e.target).data("wijchartDataObj"),
						bar = dataObj.bar;
					self._trigger("mouseMove", e, dataObj);

					if (!dataObj.hoverStyle) {
						if (bar) {
							bar.attr({ opacity: "0.8" });
						}
					} else {
						bar.attr(dataObj.hoverStyle);
					}
					//end of code for adding hover state effect.
				})
				.live("click.wijbarchart", function (e) {
					if (o.disabled) {
						return;
					}

					self._trigger("click", e, $(e.target).data("wijchartDataObj"));
				});
		},

		_unbindLiveEvents: function () {
			var self = this;
			$(".wijchart-canvas-object", self.chartElement[0]).die("wijbarchart");
			if (self.tooltip) {
				self.tooltip.destroy();
				self.tooltip = null;
			}
		},

		_calculateParameters: function (axisInfo, options) {
			$.wijmo.wijchartcore.prototype._calculateParameters.apply(this, arguments);

			// check for bar chart and x axis expansion
			if (axisInfo.id === "x") {
				var minor = options.unitMinor,
				//autoMin = options.autoMin,
				//autoMax = options.autoMax,
					adj = this._getBarAdjustment(axisInfo);

				if (adj === 0) {
					adj = minor;
				} else {
					if (minor < adj && minor !== 0) {
						adj = Math.floor(adj / minor) * minor;
					}
				}

				/*if (autoMin) {
				axisInfo.min -= adj;
				}

				if (autoMax) {
				axisInfo.max += adj;
				}*/

				axisInfo.min -= adj;
				axisInfo.max += adj;

				this._calculateMajorMinor(options, axisInfo);
			}
		},

		_getBarAdjustment: function (axisInfo) {
			var len = 0,
				o = this.options,
				max = axisInfo.max,
				min = axisInfo.min,
				seriesList = o.seriesList,
				i = 0,
				xLen = 0;

			for (i = 0; i < seriesList.length; i++) {
				xLen = seriesList[i].data.x.length;

				if (len < xLen) {
					len = xLen;
				}
			}

			if (len > 1) {
				return (max - min) / len * o.clusterWidth * 0.0125;
			} else if (len === 1) {
				if (min === 0.0 && max === 1.0) {
					min = -1.0;
					axisInfo.min = min;
				}

				return (max - min) * 0.0125;
			} else {
				return 0;
			}
		}
	});

	$.extend($.wijmo.wijbarchart.prototype, {
		_barPointList: function (seriesList) {
			var x = [],
				getXSortedPoints = this._getXSortedPoints;

			function XSpec(nx) {
				this.x = nx;
				this.paSpec = [];

				this.stackValues = function () {
					var len = this.paSpec.length,
						ps0;

					if (len > 1) {
						ps0 = this.paSpec[0];
						$.each(this.paSpec, function (idx, ps) {
							if (idx === 0) {
								return true;
							}

							ps.y += ps0.y;
							ps0 = ps;
						});
					}
				};
			}

			function addSeriesData(idx, series) {
				var points = getXSortedPoints(series),
					nSeries = series.length,
					xs = null,
					lim = 0,
					j = 0,
					jlim = 0,
					first_point = true,
					xprev = 0,
					dupl = false;

				if (points) {
					lim = points.length;
				}

				if (x) {
					jlim = x.length;
				}

				$.each(points, function (p, point) {
					if (first_point) {
						first_point = false;
						xprev = point.x;
					} else {
						if (xprev === point.x) {
							dupl = true;
						} else {
							dupl = false;
						}
						xprev = point.x;
					}

					while (j < jlim && x[j].x < point.x) {
						j++;
					}

					if (j < jlim) {
						// use or insert before the existing item
						if (x[j].x !== point.x) {
							xs = new XSpec(point.x, nSeries);
							x.splice(j, 0, xs);
							jlim = x.length;
						} else {
							xs = x[j];
						}
					} else {
						// add a new item
						xs = new XSpec(point.x, nSeries);
						x.push(xs);
						jlim = x.length;
					}

					xs.paSpec.push({ y: point.y, sIdx: idx, pIdx: p, dupl: dupl });
				});
			}

			$.each(seriesList, function (idx, series) {
				addSeriesData(idx, series);
			});

			return x;
		},

		_getSpecWithValue: function (x) {
			var ret = null;

			$.each(x, function (idx, xs) {
				if (xs.x >= x) {
					if (xs.x === x) {
						ret = xs;
					}

					return false;
				}
			});

			return ret;
		},

		_getMinDX: function (x) {
			var minDx = Number.MAX_VALUE,
				len = x.length,
				idx, 
				dx;

			for (idx = 1; idx < len; idx++) {
				dx = x[idx].x - x[idx - 1].x;

				if (dx < minDx && dx > 0) {
					minDx = dx;
				}
			}

			if (minDx === Number.MAX_VALUE) {
				return 2;
			}

			return minDx;
		},

		_stackValues: function (x) {
			$.each(x, function (idx, xSpec) {
				xSpec.stackValues();
			});

			return x;
		}
	});
}(jQuery));

/*globals $, Raphael, jQuery, document, window*/
/*
 *
 * Wijmo Library 1.4.0
 * http://wijmo.com/
 *
 * Copyright(c) ComponentOne, LLC.  All rights reserved.
 * 
 * Dual licensed under the Wijmo Commercial or GNU GPL Version 3 licenses.
 * licensing@wijmo.com
 * http://wijmo.com/license
 *
 *
 * * Wijmo LineChart widget.
 *
 * Depends:
 *	raphael.js
 *	jquery.glob.min.js
 *	jquery.ui.widget.js
 *	jquery.wijmo.wijchartcore.js
 *
 */
 
(function () {
	"use strict";
	if (!window.Raphael) {
		return;
	}

	Raphael.fn.tri = function (x, y, length) {
		var x1 = x,
			y1 = y - length,
			offsetX = Math.cos(30 * Math.PI / 180) * length,
			offsetY = Math.tan(60 * Math.PI / 180) * offsetX,
			x2 = x + offsetX,
			y2 = y + offsetY,
			x3 = x - offsetX,
			y3 = y + offsetY,
			arrPath = ["M", x1, y1, "L", x2, y2, "L", x3, y3, "z"];
		return this.path(arrPath.concat(" "));
	};

	Raphael.fn.invertedTri = function (x, y, length) {
		var x1 = x,
			y1 = y + length,
			offsetX = Math.cos(30 * Math.PI / 180) * length,
			offsetY = Math.tan(60 * Math.PI / 180) * offsetX,
			x2 = x + offsetX,
			y2 = y - offsetY,
			x3 = x - offsetX,
			y3 = y - offsetY,
			arrPath = ["M", x1, y1, "L", x2, y2, "L", x3, y3, "z"];
		return this.path(arrPath.concat(" "));
	};

	Raphael.fn.box = function (x, y, length) {
		var offset = Math.cos(45 * Math.PI / 180) * length,
			arrPath = ["M", x - offset, y - offset, "L", x + offset, y - offset,
				"L", x + offset, y + offset, "L", x - offset, y + offset, "z"];
		return this.path(arrPath.concat(" "));
	};

	Raphael.fn.diamond = function (x, y, length) {
		var arrPath = ["M", x, y - length, "L", x + length, y, "L", x, y + length,
			"L", x - length, y, "z"];
		return this.path(arrPath.concat(" "));
	};

	Raphael.fn.cross = function (x, y, length) {
		var offset = Math.cos(45 * Math.PI / 180) * length,
			arrPath = ["M", x - offset, y - offset, "L", x + offset, y + offset,
				"M", x - offset, y + offset, "L", x + offset, y - offset];
		return this.path(arrPath.concat(" "));
	};

}());

(function ($) {
	"use strict";
	$.widget("wijmo.wijlinechart", $.wijmo.wijchartcore, {
		// widget options    
		options: {
			/// <summary>
			/// A value that indicates whether to show the animation
			/// and the duration for the animation.
			/// Default: {direction: "horizontal",enabled:true, 
			/// duration:2000, easing: ">"}.
			/// Type: Object.
			/// </summary>
			animation: {
				/// <summary>
				/// A value that determines whether to show the animation.
				/// Default: true.
				/// Type: Boolean.
				/// </summary>
				enabled: true,
				/// <summary>
				/// A value that determines the effect for the animation.
				/// Default: true.
				/// Type: String.
				/// </summary>
				/// <remarks>
				/// Options are 'horizontal', 'vertical'.
				/// </remarks>
				direction: "horizontal",
				/// <summary>
				/// A value that indicates the duration for the animation.
				/// Default: 2000.
				/// Type: Number.
				/// </summary>
				duration: 2000,
				/// <summary>
				/// A value that indicates the easing for the animation.
				/// Default: ">".
				/// Type: string.
				/// </summary>
				easing: ">"
			},
			/// <summary>
			/// A value that indicates whether to show animation 
			///	and the duration for the animation when reload data.
			/// Default: {enabled:true, duration:2000, easing: ">"}.
			/// Type: Object.
			/// Code example:
			///  $("#linechart").wijlinechart({
			///      animation: {enabled: true, duration: 1000, easing: "<"}
			///  });
			/// </summary>
			seriesTransition: {
				/// <summary>
				/// A value that determines whether to show animation when reload.
				/// Default: true.
				/// Type: Boolean.
				/// </summary>
				enabled: true,
				/// <summary>
				/// A value that indicates the duration for the series transition.
				/// Default: 2000.
				/// Type: Number.
				/// </summary>
				duration: 2000,
				/// <summary>
				/// A value that indicates the easing for the series transition.
				/// Default: ">".
				/// Type: string.
				/// </summary>
				easing: ">"
			},
			/// <summary>
			/// A value that indicates whether to zoom in on the line and marker on hover.
			/// Default: true.
			/// Type: Boolean.
			/// </summary>
			zoomOnHover: true,
			/// <summary>
			/// Occurs when the user clicks a mouse button.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#linechart").wijlinechart({mouseDown: function(e, data) { } });
			/// Bind to the event by type: wijlinechartmousedown
			/// $("#linechart").bind("wijlinechartmousedown", function(e, data) {} );
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains all the series infos
			/// of the mousedown line or marker. 
			/// data.type: type of the target. Its value is "line" or "marker".
			/// If data.type is "marker", the data's params are below:
			/// data.index: index of the marker.
			/// data.isSymbol: indicates whether the marker is symbol.
			/// data.lineSeries: the line infos of the marker.
			/// data.marker: the Raphael object of the marker.
			/// If data.type is "line", the data's params are below:
			/// data.data: data of the series of the line.
			/// data.fitType: fit type of the line.
			/// data.index: index of the line.
			/// data.label: label of the line.
			/// data.legendEntry: legend entry of the line.
			/// data.lineMarkers: collection of the markers of the line.
			/// data.lineStyle: style of the line.
			/// data.markers: marker type and visibility of the line.
			/// data.path: the Raphael object of the line.
			/// data.visible: visibility of the line.
			///	</param>
			mouseDown: null,
			/// <summary>
			/// Occurs when the user releases a mouse button
			/// while the pointer is over the chart element.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#linechart").wijlinechart({mouseUp: function(e, data) { } });
			/// Bind to the event by type: wijlinechartmouseup
			/// $("#linechart").bind("wijlinechartmouseup", function(e, data) {} );
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains all the series infos
			/// of the mouseup line or marker.  
			/// data.type: type of the target. Its value is "line" or "marker".
			/// If data.type is "marker", the data's params are below:
			/// data.index: index of the marker.
			/// data.isSymbol: indicates whether the marker is symbol.
			/// data.lineSeries: the line infos of the marker.
			/// data.marker: the Raphael object of the marker.
			/// If data.type is "line", the data's params are below:
			/// data.data: data of the series of the line.
			/// data.fitType: fit type of the line.
			/// data.index: index of the line.
			/// data.label: label of the line.
			/// data.legendEntry: legend entry of the line.
			/// data.lineMarkers: collection of the markers of the line.
			/// data.lineStyle: style of the line.
			/// data.markers: marker type and visibility of the line.
			/// data.path: the Raphael object of the line.
			/// data.visible: visibility of the line.
			///	</param>
			mouseUp: null,
			/// <summary>
			/// Occurs when the user first places the pointer over the chart element.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#linechart").wijlinechart({mouseOver: function(e, data) { } });
			/// Bind to the event by type: wijlinechartmouseover
			/// $("#linechart").bind("wijlinechartmouseover", function(e, data) {} );
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains all the series infos
			/// of the mouseover line or marker.  
			/// data.type: type of the target. Its value is "line" or "marker".
			/// If data.type is "marker", the data's params are below:
			/// data.index: index of the marker.
			/// data.isSymbol: indicates whether the marker is symbol.
			/// data.lineSeries: the line infos of the marker.
			/// data.marker: the Raphael object of the marker.
			/// If data.type is "line", the data's params are below:
			/// data.data: data of the series of the line.
			/// data.fitType: fit type of the line.
			/// data.index: index of the line.
			/// data.label: label of the line.
			/// data.legendEntry: legend entry of the line.
			/// data.lineMarkers: collection of the markers of the line.
			/// data.lineStyle: style of the line.
			/// data.markers: marker type and visibility of the line.
			/// data.path: the Raphael object of the line.
			/// data.visible: visibility of the line.
			///	</param>
			mouseOver: null,
			/// <summary>
			/// Occurs when the user moves the pointer off of the chart element.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#linechart").wijlinechart({mouseOut: function(e, data) { } });
			/// Bind to the event by type: wijlinechartmouseout
			/// $("#linechart").bind("wijlinechartmouseout", function(e, data) {} );
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains all the series infos
			/// of the mouseout line or marker. 
			/// data.type: type of the target. Its value is "line" or "marker".
			/// If data.type is "marker", the data's params are below:
			/// data.index: index of the marker.
			/// data.isSymbol: indicates whether the marker is symbol.
			/// data.lineSeries: the line infos of the marker.
			/// data.marker: the Raphael object of the marker.
			/// If data.type is "line", the data's params are below:
			/// data.data: data of the series of the line.
			/// data.fitType: fit type of the line.
			/// data.index: index of the line.
			/// data.label: label of the line.
			/// data.legendEntry: legend entry of the line.
			/// data.lineMarkers: collection of the markers of the line.
			/// data.lineStyle: style of the line.
			/// data.markers: marker type and visibility of the line.
			/// data.path: the Raphael object of the line.
			/// data.visible: visibility of the line.
			///	</param>
			mouseOut: null,
			/// <summary>
			/// Occurs when the user moves the mouse pointer
			/// while it is over a chart element.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#linechart").wijlinechart({mouseMove: function(e, data) { } });
			/// Bind to the event by type: wijlinechartmousemove
			/// $("#linechart").bind("wijlinechartmousemove", function(e, data) {} );
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains all the series infos
			/// of the mousemove line or marker. 
			/// data.type: type of the target. Its value is "line" or "marker".
			/// If data.type is "marker", the data's params are below:
			/// data.index: index of the marker.
			/// data.isSymbol: indicates whether the marker is symbol.
			/// data.lineSeries: the line infos of the marker.
			/// data.marker: the Raphael object of the marker.
			/// If data.type is "line", the data's params are below:
			/// data.data: data of the series of the line.
			/// data.fitType: fit type of the line.
			/// data.index: index of the line.
			/// data.label: label of the line.
			/// data.legendEntry: legend entry of the line.
			/// data.lineMarkers: collection of the markers of the line.
			/// data.lineStyle: style of the line.
			/// data.markers: marker type and visibility of the line.
			/// data.path: the Raphael object of the line.
			/// data.visible: visibility of the line.
			///	</param>
			mouseMove: null,
			/// <summary>
			/// Occurs when the user clicks the chart element. 
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#linechart").wijlinechart({click: function(e, data) { } });
			/// Bind to the event by type: wijlinechartclick
			/// $("#linechart").bind("wijlinechartclick", function(e, data) {} );
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains all the series infos
			/// of the clicked line or marker.  
			/// data.type: type of the target. Its value is "line" or "marker".
			/// If data.type is "marker", the data's params are below:
			/// data.index: index of the marker.
			/// data.isSymbol: indicates whether the marker is symbol.
			/// data.lineSeries: the line infos of the marker.
			/// data.marker: the Raphael object of the marker.
			/// If data.type is "line", the data's params are below:
			/// data.data: data of the series of the line.
			/// data.fitType: fit type of the line.
			/// data.index: index of the line.
			/// data.label: label of the line.
			/// data.legendEntry: legend entry of the line.
			/// data.lineMarkers: collection of the markers of the line.
			/// data.lineStyle: style of the line.
			/// data.markers: marker type and visibility of the line.
			/// data.path: the Raphael object of the line.
			/// data.visible: visibility of the line.
			///	</param>
			click: null
		},

		// widget creation:    
		_create: function () {
			var self = this;
			$.wijmo.wijchartcore.prototype._create.apply(self, arguments);
			self.chartElement.addClass("wijmo-wijlinechart");
			self.paths = [];
			self.shadowPaths = [];
			self.markersSet = [];
			self.animationSet = self.canvas.set();
			self.symbols = [];
			self.hoverPoint = null;
			self.hoverLine = null;
			self.linesStyle = [];
			self.shadow = true;
		},

		destroy: function () {
			var self = this;
			self.chartElement.removeClass("wijmo-wijlinechart");
			$.wijmo.wijchartcore.prototype.destroy.apply(self, arguments);

			if (self.aniPathsAttr && self.aniPathsAttr.length) {
				$.each(self.aniPathsAttr, function (idx, pathAttr) {
					pathAttr = null;
				});
				self.aniPathsAttr = null;
			}
		},

		/*****************************
		Widget specific implementation
		******************************/
		/** public methods */

		/* returns reference to raphael's path object
			for the line data with given index */
		getLinePath: function (lineIndex) {
			return this.paths[lineIndex];
		},

		/* returns reference to set of the raphael's objects(circles)
			what represents markers for the line data with given index */
		getLineMarkers: function (lineIndex) {
			var o = this.options,
				und;
			if (o.seriesList && o.seriesList[lineIndex].markers && 
					o.seriesList[lineIndex].markers.visible) {
				return this.markersSet[lineIndex];
			} else {
				return und;
			}
		},

		/** Private methods */
	
		_getAnchors: function (p1x, p1y, p2x, p2y, p3x, p3y) {
			var l1 = (p2x - p1x) / 2,
				l2 = (p3x - p2x) / 2,
				a = Math.atan((p2x - p1x) / Math.abs(p2y - p1y)),
				b = Math.atan((p3x - p2x) / Math.abs(p2y - p3y)),
				alpha = 0, 
				dx1 = 0, 
				dy1 = 0, 
				dx2 = 0, 
				dy2 = 0;
			a = p1y < p2y ? Math.PI - a : a;
			b = p3y < p2y ? Math.PI - b : b;
			alpha = Math.PI / 2 - ((a + b) % (Math.PI * 2)) / 2;
			dx1 = l1 * Math.sin(alpha + a);
			dy1 = l1 * Math.cos(alpha + a);
			dx2 = l2 * Math.sin(alpha + b);
			dy2 = l2 * Math.cos(alpha + b);
			return {
				x1: p2x - dx1,
				y1: p2y + dy1,
				x2: p2x + dx2,
				y2: p2y + dy2
			};
		},

		_paintLegend: function () {
			var o = this.options,
				i = 0, 
				ii = 0, 
				idx = 0,
				legendIcon = null,
				chartsSeries = o.seriesList,
				chartsSeriesStyles = o.seriesStyles,
				chartSeries = null, 
				chartSeriesStyle = null, 
				box = null,
				x = 0, 
				y = 0,
				markerStyle = null, 
				type = null, 
				dot = null;
			$.extend(true, o, {
				legend: {
					size: {
						width: 30,
						height: 3
					}
				}
			});

			$.wijmo.wijchartcore.prototype._paintLegend.apply(this, arguments);

			if (o.legend.visible) {
				//set fill attr to legendIcons
				if (this.legends.length && this.legendIcons.length) {
					for (i = 0, ii = this.legendIcons.length; i < ii; i++) {
						legendIcon = this.legendIcons[i];
						legendIcon.attr({
							fill: legendIcon.attr("stroke")
						});
					}
				}
				//add marker to legendIcons
				if (!o.legend.reversed) {
					for (i = 0, ii = chartsSeries.length; i < ii; i++) {
						chartSeries = chartsSeries[i];
						chartSeriesStyle = chartsSeriesStyles[i];
						if (chartSeries.legendEntry) {
							if (chartSeries.markers && chartSeries.markers.visible) {
								legendIcon = this.legendIcons[i];
								box = legendIcon.wijGetBBox();
								x = box.x + box.width / 2;
								y = box.y + box.height / 2;
								markerStyle = chartSeries.markerStyle;
								markerStyle = $.extend({
									fill: chartSeriesStyle.stroke,
									stroke: chartSeriesStyle.stroke,
									opacity: 1
								}, markerStyle);
								type = chartSeries.markers.type;
								if (!type) {
									type = "circle";
								}
								dot = this._paintMarker(type, x, y, 3);
								dot.attr(markerStyle);
								this.legendEles.push(dot);
							}
							idx++;
						}
					}
				} else {
					for (i = chartsSeries.length - 1; i >= 0; i--) {
						chartSeries = chartsSeries[i];
						chartSeriesStyle = chartsSeriesStyles[i];
						if (chartSeries.legendEntry && chartSeries.markers.visible) {
							if (chartSeries.markers.visible) {
								legendIcon = this.legendIcons[i];
								box = legendIcon.wijGetBBox();
								x = box.x + box.width / 2;
								y = box.y + box.height / 2;
								markerStyle = chartSeries.markerStyle;
								markerStyle = $.extend({
									fill: chartSeriesStyle.stroke,
									stroke: chartSeriesStyle.stroke,
									opacity: 1
								}, markerStyle);
								type = chartSeries.markers.type;
								if (!type) {
									type = "circle";
								}
								dot = this._paintMarker(type, x, y, 3);
								dot.attr(markerStyle);
							}
							idx++;
						}
					}
				}
			}
		},
	
		_clearChartElement: function () {
			var self = this;
			self.linesStyle = [];
			if (self.paths.length) {
				$.each(self.paths, function (idx, path) {
					path.wijRemove();
					path = null;
				});
				self.paths = [];
			}
			if (self.shadowPaths.length) {
				$.each(self.shadowPaths, function (idx, shadowPath) {
					shadowPath.wijRemove();
					shadowPath = null;
				});
				self.shadowPaths = [];
			}
			if (self.markersSet.length) {
				$.each(self.markersSet, function (idx, markerSet) {
					$.each(markerSet, function (idx, set) {
						set.wijRemove();
						set = null;
					});
					markerSet = null;
				});
				self.markersSet = [];
			}
			if (self.animationSet.length) {
				$.each(self.animationSet, function (idx, animationSet) {
					animationSet.wijRemove();
					animationSet = null;
				});
				self.animationSet = self.canvas.set();
			}
			if (self.symbols.length) {
				$.each(self.symbols, function (idx, symbol) {
					symbol.wijRemove();
					symbol = null;
				});
				self.symbols = [];
			}
			$.wijmo.wijchartcore.prototype._clearChartElement.apply(self, arguments);
		},
	
		_paintMarker: function (type, x, y, length) {
			var self = this,
				marker = null;
			switch (type) {
			case "circle":
				marker = self.canvas.circle(x, y, length);
				break;
			case "tri":
				marker = self.canvas.tri(x, y, length);
				break;
			case "invertedTri":
				marker = self.canvas.invertedTri(x, y, length);
				break;
			case "box":
				marker = self.canvas.box(x, y, length);
				break;
			case "diamond":
				marker = self.canvas.diamond(x, y, length);
				break;
			case "cross":
				marker = self.canvas.cross(x, y, length);
				break;
			}
			return marker;
		},

		_getPathArrByFitType: function (pathArr, fitType, j, jj, cBounds, valuesX,
				valuesY, X, Y, isXTime, isYTime, plotInfo, valX, valY) {
			var valY0 = null, 
				valY2 = null,
				Y0 = 0, 
				Y2 = 0, 
				X0 = 0, 
				X2 = 0,
				valX0 = null, 
				valX2 = null, 
				a = null,
				minY = plotInfo.minY, 
				minX = plotInfo.minX,
				kx = plotInfo.kx, 
				ky = plotInfo.ky;
			if (fitType === "line") {
				pathArr = pathArr.concat([j ? "L" : "M", X, Y]);
			} else if (fitType === "spline") {
				if (!j) {
					pathArr = ["M", X, Y, "C", X, Y];
				} else if (j && j < jj - 1) {
					valY0 = valuesY[j - 1];
					valY2 = valuesY[j + 1];
					if (isYTime) {
						valY0 = this._toOADate(valY0);
						valY2 = this._toOADate(valY2);
					}
					Y0 = cBounds.endY - (valY0 - minY) * ky;
					Y2 = cBounds.endY - (valY2 - minY) * ky;
					if (isNaN(valX) || typeof valX ===  "string") {
						X0 = cBounds.startX + (j - 1 - minX) * kx;
						X2 = cBounds.startX + (j + 1 - minX) * kx;
					} else {
						valX0 = valuesX[j - 1];
						valX2 = valuesX[j + 1];
						if (isXTime) {
							valX0 = this._toOADate(valX0);
							valX2 = this._toOADate(valX2);
						}
						X0 = cBounds.startX + (valX0 - minX) * kx;
						X2 = cBounds.startX + (valX2 - minX) * kx;
					}
					a = this._getAnchors(X0, Y0, X, Y, X2, Y2);
					pathArr = pathArr.concat([a.x1, a.y1, X, Y, a.x2, a.y2]);
				} else {
					pathArr = pathArr.concat([X, Y, X, Y]);
				}
			} else if (fitType === "bezier") {
				if (!j) {
					pathArr = pathArr.concat(["M", X, Y]);
				} else if (j === jj - 1 && j % 2 === 1) {
					pathArr = pathArr.concat(["Q", X, Y, X, Y]);
				} else {
					if (j % 2 === 0) {
						pathArr = pathArr.concat([X, Y]);
					} else {
						pathArr = pathArr.concat(["Q", X, Y]);
					}
				}
			}
			return pathArr;
		},

		_paintPlotArea: function () {
			var self  = this,
				o = self.options,
				ani = o.animation,
				duration = ani.duration,
				easing = ani.easing,
				seTrans = o.seriesTransition,
				cBounds = self.canvasBounds,
				width = cBounds.endX - cBounds.startX,
				height = cBounds.endY - cBounds.startY,
				linesSeries = o.seriesList,
				linesSeriesStyles = o.seriesStyles,
				i, 
				ii, 
				j, 
				jj, 
				k, 
				kk, 
				x, 
				xx, 
				X, 
				Y,
				lineSeries, 
				lineSeriesStyle, 
				lineData,
				lineStyle, 
				lineHoverStyle,
				lineMarkerStyle,
				lineMarkerHoverStyle,
				minX = o.axis.x.min, 
				minY = o.axis.y.min,
				maxX = o.axis.x.max, 
				maxY = o.axis.y.max,
				kx = width / (maxX - minX),
				ky = height / (maxY - minY),
				plotInfo = {
					minX: minX,
					minY: minY,
					maxX: maxX,
					maxY: maxY,
					width: width,
					height: height,
					kx: kx,
					ky: ky
				},
				isXTime = self.axisInfo.x.isTime,
				isYTime = self.axisInfo.y.isTime,
				valuesX, 
				valuesY, 
				markers, 
				pathArr,
				fitType, 
				paintSymbol, 
				defaultChartLabels,
				valX, 
				valY, 
				labelText, 
				defaultChartLabel, 
				dclBox,
				dot, 
				isSymbol, 
				symbols, 
				markerType, 
				markerWidth,
				markerData, 
				path, 
				symbol,
				aniPathsAttr = [],
				aniMarkersAttr,
				aniLabelsAttr,
				initAniY,
				firstYPoint,
				lastYPoint,
				initAniPath,
				val;

			self.plotInfos = [];
			for (k = 0, kk = linesSeries.length; k < kk; k++) {
				aniMarkersAttr = [];
				aniLabelsAttr = [];
				initAniPath = [];
				lineSeries = linesSeries[k];
				lineSeriesStyle = linesSeriesStyles[k];
				//set default value of line series
				lineSeries = $.extend(true, {
					fitType: "line",
					markers: {
						visible: false,
						type: "circle"
					},
					visible: true
				}, lineSeries);
				lineData = lineSeries.data;
				lineStyle = $.extend({
					stroke: "black",
					opacity: 1,
					fill: "none",
					//stroke: lineStyle.color,
					//"stroke-width": 2,
					"stroke-linejoin": "round",
					"stroke-linecap": "round"
				}, lineSeriesStyle);
				lineMarkerStyle = lineSeries.markerStyle;
				lineMarkerStyle = $.extend({
					fill: lineStyle.stroke,
					stroke: lineStyle.stroke,
					//Add comments by RyanWu@20110706.
					//I can't add scale: "1 1" here, because if so,
					//The marker will be disapperaed after animation played
					//in browsers which support vml(ie6/7/8).  I don't know
					//why.  So I use the scale(1, 1) method to recover the 
					//original state of the marker after mouse out.
					//scale: "1 1",
					//end by RyanWu@20110706.
					opacity: 1,
					width: 3
				}, lineMarkerStyle);
				lineHoverStyle = o.seriesHoverStyles[k];
				lineMarkerHoverStyle = $.extend(true, {},
					lineHoverStyle, {
						scale: "1.5 1.5",
						"stroke-width": 1
					}, linesSeries.markerHoverStyle);
				valuesX = lineData.x;
				valuesY = lineData.y;

				self.plotInfos.push(plotInfo);

				// Lines and markers:
				markers = self.canvas.set();
				pathArr = [];
				fitType = lineSeries.fitType;
				paintSymbol = false;
				if (lineSeries.markers.symbol && lineSeries.markers.symbol.length) {
					paintSymbol = true;
				}
				defaultChartLabels = self.canvas.set();
				
				if (!self.aniPathsAttr || (ani.enabled && !seTrans.enabled)) {
					if (valuesY.length > 0) {
						firstYPoint = valuesY[0];
						if (isYTime) {
							firstYPoint = self._toOADate(firstYPoint);
						}
						lastYPoint = valuesY[valuesY.length - 1];
						if (isYTime) {
							lastYPoint = self._toOADate(lastYPoint);
						}
					}
				}
				for (j = 0, jj = valuesY.length; j < jj; j++) {
					valX = valuesX[j];
					if (isXTime) {
						valX = self._toOADate(valX);
					}
					valY = valuesY[j];
					if (isYTime) {
						valY = self._toOADate(valY);
					}
					if (valX === undefined) {
						break;
					}
					X = 0;
					if (isNaN(valX) || typeof valX ===  "string") {
						val = j;
					} else {
						val = valX;
					}
					X = cBounds.startX + (val - minX) * kx;
					Y = cBounds.endY - (valY - minY) * ky;
					
					if (!self.aniPathsAttr || (ani.enabled && !seTrans.enabled)) {
						initAniY = firstYPoint + (lastYPoint - firstYPoint) / 
							(maxX - minX) * (val - minX);
						initAniY = cBounds.endY - (initAniY - minY) * ky;
						
						if (j === 0) {
							initAniPath.push("M");
						} else {
							initAniPath.push("L");
						}
						initAniPath.push(X);
						initAniPath.push(initAniY);
					}

					pathArr = self._getPathArrByFitType(pathArr, fitType, j, jj, cBounds,
						valuesX, valuesY, X, Y, isXTime, isYTime, plotInfo, valX, valY);

					if (o.showChartLabels) {
						//Add comments by RyanWu@20110707.
						//For supporting date time value on y axi.
						//labelText = valY;
						labelText = isYTime ? self._fromOADate(valY) : valY;
						//end by RyanWu@20110707.

						if (o.chartLabelFormatString && o.chartLabelFormatString.length) {
							labelText = $.format(labelText, o.chartLabelFormatString);
						}
						defaultChartLabel = self.canvas.text(X, Y, labelText);
						self.chartLabelEles.push(defaultChartLabel);
						dclBox = defaultChartLabel.wijGetBBox();
						defaultChartLabel.translate(0, -dclBox.height);
						defaultChartLabels.push(defaultChartLabel);
						aniLabelsAttr.push($.extend(true, {}, defaultChartLabel.attr()));
					}
				
					dot = null;
					isSymbol = false;
					if (paintSymbol) {
						symbols = lineSeries.markers.symbol;
						for (x = 0, xx = symbols.length; x < xx; x++) {
							symbol = symbols[x];
							if (symbol.index === j) {
								dot = self.canvas.image(symbol.url, X - symbol.width / 2,
									Y - symbol.height / 2, symbol.width, symbol.height);
								self.symbols.push(dot);
								isSymbol = true;
								if (!self.aniPathsAttr || 
										(ani.enabled && !seTrans.enabled)) {
									dot.straight = initAniY;
								}
								break;
							}
						}
					
					}
					if (dot === null) {
						markerType = lineSeries.markers.type;
						markerWidth = lineMarkerStyle.width;
						dot = self._paintMarker(markerType, X, Y, markerWidth);
						if (lineSeries.markers.visible) {
							dot.attr(lineMarkerStyle);
						}
						if (!self.aniPathsAttr || (ani.enabled && !seTrans.enabled)) {
							dot.straight = initAniY;
						}
					}
				
					self._addClass($(dot.node), 
						"wijchart-canvas-object wijchart-canvas-marker");
					markerData = {};
					markerData.marker = dot;
					markerData.index = j;
					markerData.type = "marker";
					markerData.lineSeries = lineSeries;
					markerData.x = X;
					markerData.y = Y;
					markerData.isSymbol = isSymbol;
					$(dot.node).data("wijchartDataObj", markerData);
					markers.push(dot);
				
					aniMarkersAttr.push($.extend(true, {}, dot.attr()));
					self.animationSet.push(dot);
				}
				path = self.canvas.path(pathArr.join(" "));
				path.straight = initAniPath.join(" ");
				//shadow
				self._paintShadow(path);

				path.wijAttr(lineStyle);

				aniPathsAttr.push({
					path: $.extend(true, {}, path.attr()),
					markers: aniMarkersAttr,
					labels: aniLabelsAttr
				});
				path.markers = markers;
				
				self.paths[k] = path;
				if (path.shadow) {
					self.shadowPaths[k] = path.shadow;
				}
				self.animationSet.push(path);
			
				self.linesStyle[k] = {
					lineStyle: lineStyle,
					lineHoverStyle: lineHoverStyle,
					markerStyle: lineMarkerStyle,
					markerHoverStyle: lineMarkerHoverStyle
				};

				if (!lineSeries.markers.visible) {
					markers.hide();
				}
				if (!lineSeries.visible) {
					path.hide();
				
					if (path.shadow) {
						path.shadow.hide();
					}
				}

				if (lineSeries.markers.style) {
					markers.attr(lineSeries.markers.style);
				}
				markers.toFront();
				if (defaultChartLabels.length) {
					defaultChartLabels.attr(o.chartLabelStyle);
					defaultChartLabels.toFront();
					path.labels = defaultChartLabels;
				}
				self.markersSet[k] = markers;
				lineSeries.index = k;
				lineSeries.type = "line";
				lineSeries.path = path;
				lineSeries.lineMarkers = markers;
				lineSeries.lineStyle = lineStyle;
				self._addClass($(path.node), "wijchart-canvas-object");
				$(path.node).data("wijchartDataObj", lineSeries);
			}
			
			if (ani.enabled || (seTrans.enabled && self.seriesTransition)) {
				if (ani.direction === "horizontal") {
					if (seTrans.enabled && self.seriesTransition) {
						duration = seTrans.duration;
						easing = seTrans.easing;
					}
					self.animationSet.wijAttr("clip-rect", cBounds.startX +
							" " + cBounds.startY + " 0 " + height);
					self.animationSet.wijAnimate({"clip-rect": cBounds.startX +
							" " + cBounds.startY + " " + width + " " + height},
							duration, easing, function () {
							if (Raphael.vml) {
								//delete clip-rect's div in vml
								for (i = 0, ii = self.animationSet.length; i < ii; i++) {
									var ele = self.animationSet[i],
										attrs = null, 
										group = null, 
										clipRect = null;
									if (ele.node.clipRect) {
										attrs = ele.attrs;
										delete attrs["clip-rect"];
										ele.node.clipRect = null;
										group = $(ele.node).parent();
										clipRect = group.parent();
										clipRect.before(group);
										//clipRect.wijRemove();
										clipRect.remove();
									
										ele.attr(attrs);
									}
								}
							}
						});
				} else {
					$.each(self.paths, function (idx, path) {
						var aniPathAttr,
							diffAttr,
							diffPath;
						if (self.aniPathsAttr && seTrans.enabled) {
							duration = seTrans.duration;
							easing = seTrans.easing;
							if (path.shadow) {
								path.shadow.hide();
							}
							aniPathAttr = self.aniPathsAttr[idx];
							diffAttr = self._getDiffAttrs(aniPathAttr.path, path.attr());
							path.attr(aniPathAttr.path);
							path.wijAnimate(diffAttr, duration, easing, function () {
								if (path.shadow) {
									path.shadow.show();
								}
							});
							$.each(path.markers, function (i, marker) {
								var diffMarkerAttr = 
									self._getDiffAttrs(aniPathAttr.markers[i], 
										marker.attr());
								marker.attr(aniPathAttr.markers[i]);
								marker.wijAnimate(diffMarkerAttr, duration, easing);
							});
							if (path.labels) {
								$.each(path.labels, function (i, label) {
									var diffLabelAttr = 
										self._getDiffAttrs(aniPathAttr.labels[i], 
											label.attr()),
										labelAttr = aniPathAttr.labels[i];
									if (labelAttr && labelAttr.text) {
										delete labelAttr.text;
									}
									label.attr(labelAttr);
									label.wijAnimate(diffLabelAttr, duration, easing);
								});
							}
						} else {
							if (path.straight) {
								if (path.shadow) {
									path.shadow.hide();
								}
								aniPathAttr = path.straight;
								diffPath = path.attr().path;
								path.attr({path: aniPathAttr});
								path.wijAnimate({path: diffPath}, duration, easing, 
									function () {
										if (path.shadow) {
											path.shadow.show();
										}
									});
								$.each(path.markers, function (i, marker) {
									if (marker.straight) {
										var cy = marker.attr().cy;
										marker.attr({cy: marker.straight});
										marker.wijAnimate({cy: cy}, duration, easing);
									}
								});
							}
						}
					});
				}
			}
			self.aniPathsAttr = aniPathsAttr;
		},

		_getChartLabelPointPosition: function (chartLabel) {
			var self = this,
				o = self.options,
				method = chartLabel.attachMethod,
				data = chartLabel.attachMethodData,
				point = { x: 0, y: 0 },
				seriesIndex = null, 
				plotInfos = null,
				x = 0, 
				y = 0, 
				kx = 0, 
				ky = 0,
				plotInfo = null, 
				lineData = null, 
				pointIndex = null;
			switch (method) {
			case "coordinate":
				point.x = data.x;
				point.y = data.y;
				break;
			case "dataCoordinate":
				seriesIndex = data.seriesIndex;
				if (seriesIndex > -1) {
					plotInfos = self.plotInfos;
					if (plotInfos.length > seriesIndex) {
						x = data.x;
						y = data.y;
						if (self._isDate(x)) {
							x = self._toOADate(x);
						}
						if (this._isDate(y)) {
							y = self._toOADate(y);
						}
						plotInfo = plotInfos[seriesIndex];
						kx = plotInfo.width / (plotInfo.maxX - plotInfo.minX);
						point.x = self.canvasBounds.startX + (x - plotInfo.minX) * kx;
						ky = plotInfo.height / (plotInfo.maxY - plotInfo.minY);
						point.y = self.canvasBounds.startY + plotInfo.height - 
							(y - plotInfo.minY) * ky;
					}
				}
				break;
			case "dataIndex":
				seriesIndex = data.seriesIndex;
				pointIndex = data.pointIndex;
				lineData = o.seriesList[seriesIndex].data;
				x = lineData.x[pointIndex];
				y = lineData.y[pointIndex];
				if (self._isDate(x)) {
					x = self._toOADate(x);
				}
				if (this._isDate(y)) {
					y = self._toOADate(y);
				}
				if (seriesIndex > -1) {
					plotInfos = self.plotInfos;
					if (plotInfos.length > seriesIndex) {
						plotInfo = plotInfos[seriesIndex];
						kx = plotInfo.width / (plotInfo.maxX - plotInfo.minX);
						point.x = self.canvasBounds.startX + (x - plotInfo.minX) * kx;
						ky = plotInfo.height / (plotInfo.maxY - plotInfo.minY);
						point.y = self.canvasBounds.startY + plotInfo.height - 
							(y - plotInfo.minY) * ky;
					}
				}
				break;
			case "dataIndexY":
				seriesIndex = data.seriesIndex;
				pointIndex = data.pointIndex;
				lineData = o.seriesList[seriesIndex].data;
				x = lineData.x[pointIndex];
				y = data.y;
				if (self._isDate(x)) {
					x = self._toOADate(x);
				}
				if (self._isDate(y)) {
					y = self._toOADate(y);
				}
				if (seriesIndex > -1) {
					plotInfos = self.plotInfos;
					if (plotInfos.length > seriesIndex) {
						plotInfo = plotInfos[seriesIndex];
						kx = plotInfo.width / (plotInfo.maxX - plotInfo.minX);
						point.x = self.canvasBounds.startX + (x - plotInfo.minX) * kx;
						ky = plotInfo.height / (plotInfo.maxY - plotInfo.minY);
						point.y = self.canvasBounds.startY + plotInfo.height - 
							(y - plotInfo.minY) * ky;
					}
				}
				break;
			}
			return point;
		},

		_bindLiveEvents: function () {
			var self = this,
				isNewLine = false,
				o = this.options,
				proxyObj = {
					element: this.chartElement,
					mousedown: function (e) {
						if (o.disabled) {
							return;
						}
			
						var tar = $(e.target),
							data = $(e.target).data("wijchartDataObj"),
							lineSeries = null;
						if (tar.hasClass("wijchart-canvas-marker")) {
							lineSeries = data.lineSeries;
							if (!lineSeries.markers.visible) {
								self._trigger("mouseDown", e, lineSeries);
							} else {
								self._trigger("mouseDown", e, data);
							}
						} else {
							self._trigger("mouseDown", e, data);
						}
					},
					mouseup: function (e) {
						if (o.disabled) {
							return;
						}
			
						var tar = $(e.target),
							data = $(e.target).data("wijchartDataObj"),
							lineSeries = null;
						if (tar.hasClass("wijchart-canvas-marker")) {
							lineSeries = data.lineSeries;
							if (!lineSeries.markers.visible) {
								self._trigger("mouseUp", e, lineSeries);
							} else {
								self._trigger("mouseUp", e, data);
							}
						} else {
							self._trigger("mouseUp", e, data);
						}
					},
					mouseover: function (e) {
						if (o.disabled) {
							return;
						}
			
						var tar = $(e.target),
							data = $(e.target).data("wijchartDataObj"),
							//zoomOnHover = self.options.zoomOnHover,
							lineSeries = null, 
							style = null,
							idx = 0;
						if (tar.hasClass("wijchart-canvas-marker")) {
							lineSeries = data.lineSeries;
							if (!lineSeries.markers.visible) {
								self._trigger("mouseOver", e, lineSeries);
							} else {
								self._trigger("mouseOver", e, data);
							}
							//for tooltip 
							if (self.hoverLine !== lineSeries) {
								isNewLine = true;
								//if (zoomOnHover) {
								if (self.hoverLine) {
									idx = self.hoverLine.index;
									style = self.linesStyle[idx];
//Add comments by RyanWu@20110705.
//For adding the seriesHoverStyle and markerHoverStyle support.
//										self.hoverLine.path.wijAttr({
//											"stroke-width": parseInt(style
//												.lineStyle["stroke-width"], 10)
//										});
//										if (self.hoverPoint && 
//												!self.hoverPoint.isSymbol) {
//											self.hoverPoint.marker.wijAttr({
//												"stroke": style.markerStyle.stroke
//											});
//											self.hoverPoint.marker.scale(1, 1);
//										}
									self.hoverLine.path.wijAttr(style.lineStyle);
									if (self.hoverPoint && 
										!self.hoverPoint.isSymbol) {
										self.hoverPoint.marker.wijAttr(style.markerStyle);
										self.hoverPoint.marker.scale(1, 1);
									}
									//end by RyanWu@20110705.
								}
							
								idx = lineSeries.index;
//Add comments by RyanWu@20110705.
//For adding the seriesHoverStyle and markerHoverStyle support.
//									if (self.linesStyle[idx] &&
//											self.linesStyle[idx].lineStyle) {
//										style = self.linesStyle[idx].lineStyle;
//										lineSeries.path.wijAttr({
//											"stroke-width":
//												parseInt(style["stroke-width"], 10) + 1
//										});
//									}
								style = self.linesStyle[idx];

								if (style && style.lineHoverStyle) {
									lineSeries.path.wijAttr(style.lineHoverStyle);
								}
								//end by RyanWu@20110705.
								//}
						
								self.hoverLine = lineSeries;
								self.hoverPoint = null;
						
							}
						} else {
							self._trigger("mouseOver", e, data);
							//for tooltip 
							if (data.type !== "line") {
								return;
							}
							if (self.hoverLine !== data) {
								isNewLine = true;
								//if (zoomOnHover) {
								if (self.hoverLine) {
									idx = self.hoverLine.index;
									style = self.linesStyle[idx];
//Add comments by RyanWu@20110705.
//For adding the seriesHoverStyle and markerHoverStyle support.
//										self.hoverLine.path.wijAttr({
//											"stroke-width": parseInt(style
//												.lineStyle["stroke-width"], 10)
//										});
//										if (self.hoverPoint && 
//												!self.hoverPoint.isSymbol) {
//											self.hoverPoint.marker.wijAttr({
//												"stroke": style.markerStyle.stroke
//											});
//											self.hoverPoint.marker.scale(1, 1);
//										}
									self.hoverLine.path.wijAttr(style.lineStyle);
									if (self.hoverPoint && 
										!self.hoverPoint.isSymbol) {
										self.hoverPoint.marker.wijAttr(style.markerStyle);
										self.hoverPoint.marker.scale(1, 1);
									}
									//end by RyanWu@20110705.
								}
							
								idx = data.index;
//Add comments by RyanWu@20110705.
//For adding the seriesHoverStyle and markerHoverStyle support.
//									if (self.linesStyle[idx] &&
//											self.linesStyle[idx].lineStyle) {
//										style = self.linesStyle[idx].lineStyle;
//										data.path.wijAttr({
//											"stroke-width": 
//												parseInt(style["stroke-width"], 10) + 1
//										});
//									}
								style = self.linesStyle[idx];

								if (style && style.lineHoverStyle) {
									data.path.wijAttr(style.lineHoverStyle);
								}
								//end by RyanWu@20110705.
								//}
						
								self.hoverLine = data;
								self.hoverPoint = null;
							}
						}
					},
					mouseout: function (e) {
						if (o.disabled) {
							return;
						}
			
						var tar = $(e.target),
							data = $(e.target).data("wijchartDataObj"),
							lineSeries = null;
						if (tar.hasClass("wijchart-canvas-marker")) {
							lineSeries = data.lineSeries;
							if (!lineSeries.markers.visible) {
								self._trigger("mouseOut", e, lineSeries);
							} else {
								self._trigger("mouseOut", e, data);
							}
						} else {
							self._trigger("mouseOut", e, data);
						}
					},
					mousemove: function (e) {
						if (o.disabled) {
							return;
						}
			
						var tar = $(e.target),
							data = $(e.target).data("wijchartDataObj"),
							lineSeries = null;
						if (tar.hasClass("wijchart-canvas-marker")) {
							lineSeries = data.lineSeries;
							if (!lineSeries.markers.visible) {
								self._trigger("mouseMove", e, lineSeries);
							} else {
								self._trigger("mouseMove", e, data);
							}
						} else {
							self._trigger("mouseMove", e, data);
						}
					},
					click: function (e) {
						if (o.disabled) {
							return;
						}
			
						var tar = $(e.target),
							data = $(e.target).data("wijchartDataObj"),
							lineSeries = null;
						if (tar.hasClass("wijchart-canvas-marker")) {
							lineSeries = data.lineSeries;
							if (!lineSeries.markers.visible) {
								self._trigger("click", e, lineSeries);
							} else {
								self._trigger("click", e, data);
							}
						} else {
							self._trigger("click", e, data);
						}
					}
				},
				hint = o.hint,
				h = null,
				bounds = self.canvasBounds,
				elePos = self.chartElement.offset();
				//zoomOnHover = o.zoomOnHover;
			$(".wijchart-canvas-object", this.chartElement[0])
				.live("mousedown.wijlinechart", 
					$.proxy(proxyObj.mousedown, proxyObj))
				.live("mouseup.wijlinechart", 
					$.proxy(proxyObj.mouseup, proxyObj))
				.live("mouseover.wijlinechart", 
					$.proxy(proxyObj.mouseover, proxyObj))
				.live("mouseout.wijlinechart", 
					$.proxy(proxyObj.mouseout, proxyObj))
				.live("mousemove.wijlinechart", 
					$.proxy(proxyObj.mousemove, proxyObj))
				.live("click.wijlinechart", 
					$.proxy(proxyObj.click, proxyObj));

			if (hint.enable) {
				h = $.extend(true, hint, {
					closeBehavior: "none",
					mouseTrailing: false,
					triggers: "custom",
					compass: hint.compass
				});
				if (!this.tooltip) {
					this.tooltip = this.canvas.tooltip(null, h);
				}
			}
		
			this.chartElement.bind("mousemove", function (e) {
				if (o.disabled) {
							return;
				}
			
				elePos = self.chartElement.offset();
				var mousePos = {
						left: e.pageX - elePos.left,
						top: e.pageY - elePos.top
					},
					markers = null,
					idx = 0, 
					distance = 0, 
					index = 0,
					box = null, 
					pos = 0, 
					dis = 0,
					point = null, 
					p = null, 
					style = null,
					valueX, 
					valueY, 
					seriesData = null, 
					s = null,
					dataObj = null, 
					op = null, 
					title = hint.title,
					content = hint.content,
					isTitleFunc = $.isFunction(title),
					isContentFunc = $.isFunction(content);
				
				if (self.tooltip) {
					op = self.tooltip.getOptions();
				}

				if (mousePos.left >= bounds.startX && mousePos.left <= bounds.endX && 
						mousePos.top >= bounds.startY && mousePos.top <= bounds.endY) {
					if (self.hoverLine) {
						if (isNewLine) {
							if (hint.enable && self.tooltip) {
								self.tooltip.hide();
							}
							isNewLine = false;
						}
						markers = self.hoverLine.lineMarkers;
						idx = -1;
						p = {x: 0, y: 0};
						$.each(markers, function (i, marker) {
							box = marker.wijGetBBox();
							pos = box.x + box.width / 2;
							dis = Math.abs(pos - mousePos.left);
							if (i === 0) {
								distance = dis;
								idx = i;
								p = {
									x: pos,
									y: box.y + box.height / 2
								};
							} else if (dis < distance) {
								distance = dis;
								idx = i;
								p = {
									x: pos,
									y: box.y + box.height / 2
								};
							}
						});
						if (self.hoverPoint && self.hoverPoint.index === idx) {
							return;
						}
						if (idx > -1) {
							point = $(markers[idx].node).data("wijchartDataObj");
							//Add comments by RyanWu@20110705.
							//For adding seriesHoverStyles and markerHoverStyles.
//							if (zoomOnHover && point) {
//								if (self.hoverPoint && !self.hoverPoint.isSymbol) {
//									index = self.hoverLine.index;
//									style = self.linesStyle[index];
//									self.hoverPoint.marker.wijAttr({
//										"stroke": style.markerStyle.stroke
//									});
//									self.hoverPoint.marker.scale(1, 1);
//								}
//								if (!point.isSymbol) {
//									point.marker.wijAttr({
//										"stroke": "white"
//									});
//									point.marker.scale(1.5, 1.5);
//								}
//							}
							if (point) {
								index = self.hoverLine.index;
								style = self.linesStyle[index];
								if (self.hoverPoint && !self.hoverPoint.isSymbol) {
									self.hoverPoint.marker.wijAttr(style.markerStyle);
									self.hoverPoint.marker.scale(1, 1);
								}
								if (!point.isSymbol) {
									point.marker.wijAttr(style.markerHoverStyle);
								}
							}
							//end by RyanWu@20110705.
							self.hoverPoint = point;
						}
						if (hint.enable && self.tooltip) {
							seriesData = self.hoverLine.data;
						
							if (seriesData.x) {
								valueX = seriesData.x[idx];
								valueY = seriesData.y[idx];
							} else {
								valueX = seriesData.xy[2 * idx];
								valueY = seriesData.xy[2 * idx + 1];
							}
							dataObj = self.hoverPoint;
							if (isTitleFunc || isContentFunc) {
								if (isTitleFunc) {
									op.title = function () {
										var obj = {
												x: valueX,
												y: valueY,
												data: dataObj,
												fmt: title
											},
											fmt = $.proxy(obj.fmt, obj),
											tit = fmt();
										return tit;
									};
								}
								if (isContentFunc) {
									op.content = function () {
										var obj = {
												x: valueX,
												y: valueY,
												data: dataObj,
												fmt: content
											},
											fmt = $.proxy(obj.fmt, obj),
											con = fmt();
										return con;
									};
								}
							}
							s = $.extend({
								stroke: self.hoverLine.path.attr("stroke")
							}, hint.style);
							op.style.stroke = s.stroke;
							self.tooltip.showAt(p);
						}
					}
				} else {
					if (hint.enable && self.tooltip) {
						self.tooltip.hide();
					}
				
					//Add comments by RyanWu@20110705.
					//For adding seriesHoverStyles and markerHoverStyles.
//					if (zoomOnHover) {
//						if (self.hoverLine) {
//							idx = self.hoverLine.index;
//							style = self.linesStyle[idx];
//							self.hoverLine.path.wijAttr({
//							"stroke-width": parseInt(style.lineStyle["stroke-width"],
//									10)
//							});
//							if (self.hoverPoint && !self.hoverPoint.isSymbol) {
//								self.hoverPoint.marker.wijAttr({
//									"stroke": style.markerStyle.stroke
//								});
//								self.hoverPoint.marker.scale(1, 1);
//							}
//						}
//					}
					if (self.hoverLine) {
						idx = self.hoverLine.index;
						style = self.linesStyle[idx];
						self.hoverLine.path.wijAttr(style.lineStyle);
						if (self.hoverPoint && !self.hoverPoint.isSymbol) {
							self.hoverPoint.marker.wijAttr(style.markerStyle);
							self.hoverPoint.marker.scale(1, 1);
						}
					}
					//end by RyanWu@20110705.
					self.hoverLine = null;
					self.hoverPoint = null;
				}
			});
		},

		_unbindLiveEvents: function () {
			$(".wijchart-canvas-object", this.chartElement[0]).die("wijlinechart");
		}

	});

}(jQuery));

/*globals Raphael,jQuery, window*/
/*
 *
 * Wijmo Library 1.4.0
 * http://wijmo.com/
 *
 * Copyright(c) ComponentOne, LLC.  All rights reserved.
 * 
 * Dual licensed under the Wijmo Commercial or GNU GPL Version 3 licenses.
 * licensing@wijmo.com
 * http://wijmo.com/license
 *
 *
 * * Wijmo PieChart widget.
 *
 * Depends:
 *  raphael.js
 *  jquery.glob.min.js
 *  jquery.ui.widget.js
 *  jquery.wijmo.wijchartcore.js
 *  
 */

(function ($) {
	"use strict";

	$.widget("wijmo.wijpiechart", $.wijmo.wijchartcore, {
		options: {
			/// <summary>
			/// A value indicates the radius used for a pie chart.
			/// Default: null.
			/// Type: Number.
			/// Code example:
			///  $("#piechart").wijpiechart({
			///      radius: 100
			///  });
			/// </summary>
			/// <remarks>
			/// If the value is null, then the radius will be calculated 
			///	by the width/height value of the pie chart.
			/// </remarks>
			radius: null,
			/// <summary>
			/// A value indicates the inner radius used for doughnut charts.
			/// Default: 0.
			/// Type: Number.
			/// Code example:
			///  $("#piechart").wijpiechart({
			///      innerRadius: 20
			///  });
			/// </summary>
			innerRadius: 0,
			/// <summary>
			/// A value that indicates whether to show animation 
			///	and the duration for the animation.
			/// Default: {enabled:true, duration:400, easing: ">", offset: 10}.
			/// Type: Object.
			/// Code example:
			///  $("#piechart").wijpiechart({
			///      animation: {enabled: true, duration: 1000, offset: 20}
			///  });
			/// </summary>
			animation: {
				/// <summary>
				/// A value that determines whether to show animation.
				/// Default: true.
				/// Type: Boolean.
				/// </summary>
				enabled: true,
				/// <summary>
				/// A value that indicates the duration for the animation.
				/// Default: 400.
				/// Type: Number.
				/// </summary>
				duration: 400,
				/// <summary>
				/// A value that indicates the easing for the animation.
				/// Default: ">".
				/// Type: string.
				/// </summary>
				easing: ">",
				/// <summary>
				/// A value that indicates the offset for explode animation.
				/// Default: 10.
				/// Type: Number.
				/// </summary>
				offset: 10
			},
			/// <summary>
			/// A value that indicates whether to show animation 
			///	and the duration for the animation when reload data.
			/// Default: {enabled:true, duration:1000, easing: "bounce"}.
			/// Type: Object.
			/// Code example:
			///  $("#piechart").wijpiechart({
			///      animation: {enabled: true, duration: 2000, easing: ">"}
			///  });
			/// </summary>
			seriesTransition: {
				/// <summary>
				/// A value that determines whether to show animation when reload.
				/// Default: true.
				/// Type: Boolean.
				/// </summary>
				enabled: true,
				/// <summary>
				/// A value that indicates the duration for the series transition.
				/// Default: 1000.
				/// Type: Number.
				/// </summary>
				duration: 1000,
				/// <summary>
				/// A value that indicates the easing for the series transition.
				/// Default: "bounce".
				/// Type: string.
				/// </summary>
				easing: "bounce"
			},
			/// <summary>
			/// Occurs when the user clicks a mouse button.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#piechart").wijpiechart({mouseDown: function(e, data) { } });
			/// Bind to the event by type: wijpiechartmousedown
			/// $("#piechart").bind("wijpiechartmousedown", function(e, data) {} );
			/// <param name="e" type="eventObj">
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains  the series infos of the mousedown sector. 
			/// data.data: value of the sector.
			/// data.index: index of the sector.
			/// data.label: label of the sector.
			/// data.legendEntry: legend entry of the sector.
			/// data.offset: offset of the sector.
			/// data.style: style of the sector.
			/// type: "pie"
			///	</param>
			mouseDown: null,
			/// <summary>
			/// Occurs when the user releases a mouse button
			/// while the pointer is over the chart element.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#piechart").wijpiechart({mouseUp: function(e, data) { } });
			/// Bind to the event by type: wijpiechartmouseup
			/// $("#piechart").bind("wijpiechartmouseup", function(e, data) {} );
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains all the series infos of the mouseup sector. 
			/// data.data: value of the sector.
			/// data.index: index of the sector.
			/// data.label: label of the sector.
			/// data.legendEntry: legend entry of the sector.
			/// data.offset: offset of the sector.
			/// data.style: style of the sector.
			/// type: "pie"
			///	</param>
			mouseUp: null,
			/// <summary>
			/// Occurs when the user first places the pointer over the chart element.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#piechart").wijpiechart({mouseOver: function(e, data) { } });
			/// Bind to the event by type: wijpiechartmouseover
			/// $("#piechart").bind("wijpiechartmouseover", function(e, data) {} );
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains all the series infos of the mouseover sector. 
			/// data.data: value of the sector.
			/// data.index: index of the sector.
			/// data.label: label of the sector.
			/// data.legendEntry: legend entry of the sector.
			/// data.offset: offset of the sector.
			/// data.style: style of the sector.
			/// type: "pie"
			///	</param>
			mouseOver: null,
			/// <summary>
			/// Occurs when the user moves the pointer off of the chart element.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#piechart").wijpiechart({mouseOut: function(e, data) { } });
			/// Bind to the event by type: wijpiechartmouseout
			/// $("#piechart").bind("wijpiechartmouseout", function(e, data) {} );
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains all the series infos of the mouseout sector. 
			/// data.data: value of the sector.
			/// data.index: index of the sector.
			/// data.label: label of the sector.
			/// data.legendEntry: legend entry of the sector.
			/// data.offset: offset of the sector.
			/// data.style: style of the sector.
			/// type: "pie"
			///	</param>
			mouseOut: null,
			/// <summary>
			/// Occurs when the user moves the mouse pointer
			/// while it is over a chart element.
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#piechart").wijpiechart({mouseMove: function(e, data) { } });
			/// Bind to the event by type: wijpiechartmousemove
			/// $("#piechart").bind("wijpiechartmousemove", function(e, data) {} );
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains all the series infos of the mousemove sector. 
			/// data.data: value of the sector.
			/// data.index: index of the sector.
			/// data.label: label of the sector.
			/// data.legendEntry: legend entry of the sector.
			/// data.offset: offset of the sector.
			/// data.style: style of the sector.
			/// type: "pie"
			///	</param>
			mouseMove: null,
			/// <summary>
			/// Occurs when the user clicks the chart element. 
			/// Default: null.
			/// Type: Function.
			/// Code example:
			/// Supply a function as an option.
			///  $("#piechart").wijpiechart({click: function(e, data) { } });
			/// Bind to the event by type: wijpiechartclick
			/// $("#piechart").bind("wijpiechartclick", function(e, data) {} );
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains all the series infos of the clicked sector. 
			/// data.data: value of the sector.
			/// data.index: index of the sector.
			/// data.label: label of the sector.
			/// data.legendEntry: legend entry of the sector.
			/// data.offset: offset of the sector.
			/// data.style: style of the sector.
			/// type: "pie"
			///	</param>
			click: null
		},

		// widget creation:    
		_create: function () {
			var self = this,
				defFill = [
					"0-#8ac4c0-#77b3af",
					"0-#73a19e-#67908e",
					"0-#4f687b-#465d6e",
					"0-#69475b-#5d3f51",
					"0-#7a3b3f-#682e32",
					"0-#9d5b5b-#8c5151",
					"0-#e5a36d-#ce9262",
					"0-#e6cc70-#ceb664",
					"0-#8ec858-#7fb34f",
					"0-#3a9073-#2a7b5f",
					"0-#6c88e3-#6079cb",
					"0-#6cb4e3-#60a0cb"
				];
			$.wijmo.wijchartcore.prototype._create.apply(self, arguments);
			self.chartElement.addClass("wijmo-wijpiechart");
			// default some fills
			$.each(this.options.seriesStyles, function (idx, style) {
				if (!style.fill) {
					style.fill = defFill[idx];
				}
			});
			self.canvas.customAttributes.segment =
				function (x, y, a1, a2, outerR, innerR) {
					var path = null,
						offset = 0.01;
					if (a2 - a1 > 360 - offset) {
						a2 -= offset;
					} else if (a2 - a1 < offset) {
						a2 += offset;
					}
					if (innerR) {
						path = self._donut(x, y, outerR, innerR, a1, a2);
					} else {
						path = self._sector(x, y, outerR, a1, a2);
					}
					return {
						"path": path
					};
				};
		},

		destroy: function () {
			var self = this;
			self.chartElement
				.removeClass("wijmo-wijpiechart ui-helper-reset");
			$.wijmo.wijchartcore.prototype.destroy.apply(this, arguments);
			if (self.aniSectors && self.aniSectors.length) {
				$.each(self.aniSectors, function (idx, sector) {
					sector = null;
				});
				self.aniSectors = null;
			}
			if (self.aniLabels && self.aniLabels.length) {
				$.each(self.aniLabels, function (idx, label) {
					label = null;
				});
				self.aniLabels = null;
			}
		},

		_isPieChart: function () {
			return true;
		},

		/*****************************
		Widget specific implementation
		******************************/
		/** public methods */
		getSector: function (index) {
			/// <summary>
			/// Returns the sector of the pie chart with the given index.
			/// </summary>
			/// <param name="index" type="Number">
			/// The index of the sector.
			/// </param>
			/// <returns type="Raphael element">
			/// Reference to raphael element object.
			/// </returns>
			return this.sectors[index];
		},
		/** end of public methods */

		/** private methods */
		_getSeriesFromTR: function (theaders, sList, seriesList) {
			var label = null, th = null, tds = null,
				data = null, series = null;
			if (sList.length) {
				sList.each(function () {
					th = $("th", $(this));
					label = $.trim(th.text());
					tds = $("td", $(this));
					if (tds.length) {
						data = parseFloat($.trim($(tds[0]).text()));
					}
					series = {
						label: label,
						legendEntry: true,
						data: data
					};
					seriesList.push(series);
				});
			}
		},

		_paintPlotArea: function () {
			var self = this,
				o = self.options,
				canvasBounds = self.canvasBounds,
				width = canvasBounds.endX - canvasBounds.startX,
				height = canvasBounds.endY - canvasBounds.startY,
				seriesList = o.seriesList,
				seriesStyles = o.seriesStyles,
				seriesHoverStyles = o.seriesHoverStyles,
				total = 0,
				sectors = [],
				tooltipTars = [],
				labels = [],
				angle = 0,
				paper = self.canvas,
				getPositionByAngle = paper.wij.getPositionByAngle,
				r,
				startX,
				startY,
				path,
				attr;

			if (!o.radius) {
				o.radius = Math.min(width, height) / 2;
			} else {
				if (width < 2 * o.radius) {
					o.radius = width / 2;
				}
				if (height < 2 * o.radius) {
					o.radius = height / 2;
				}
			}

			canvasBounds.startX += width / 2 - o.radius;
			canvasBounds.endX = canvasBounds.startX + 2 * o.radius;
			canvasBounds.startY += height / 2 - o.radius;
			canvasBounds.endY = canvasBounds.startY + 2 * o.radius;

			$.each(seriesList, function (idx, series) {
				if (series && typeof (series.data) === "number") {
					total += series.data;
				}
			});

			startX = canvasBounds.startX;
			startY = canvasBounds.startY;
			self.total = total;
			r = o.radius;

			$.each(seriesList, function (idx, series) {
				var seriesStyle = $.extend({
					opacity: 1,
					stroke: "gray",
					"stroke-width": 1
				}, seriesStyles[idx]),
					anglePlus = 360 * series.data / total,
					cx = startX + r,
					cy = startY + r,
					center, sector, label,
					pos, textStyle;

				series = $.extend(true, { offset: 0 }, series);
				if (series.offset) {
					center = getPositionByAngle(cx, cy,
									series.offset, angle + anglePlus / 2);
					cx = center.x;
					cy = center.y;
				}

				path = [cx, cy, angle, angle + anglePlus, r, o.innerRadius].concat(" ");
				if (self.aniSectors && o.seriesTransition.enabled) {
					seriesStyle.segment = path;
					if (idx < self.aniSectors.length) {
						attr = self.aniSectors[idx].attr();
						self.aniSectors[idx].stop();
					} else {
						attr = $.extend(true, {}, seriesStyle);
						attr.segment = [cx, cy, 0, 360, r, o.innerRadius].concat(" ");
					}
					sector = self.canvas.path().attr(attr);
					seriesStyle = self._getDiffAttrs(attr, seriesStyle);
					sector.wijAnimate(seriesStyle, o.seriesTransition.duration,
						o.seriesTransition.easing, function () {
							self._paintShadow(sector);
							delete seriesStyle.segment;
						});
				} else {
					sector = self.canvas.path().attr({ segment: path });
					self._paintShadow(sector);
					sector.wijAttr(seriesStyle);
				}
				sector.angles = { start: angle, end: angle + anglePlus };
				sector.getOffset = function (offset) {
					var pos = getPositionByAngle(cx, cy, offset,
									(sector.angles.start + sector.angles.end) / 2);
					return { x: pos.x - cx, y: pos.y - cy };
				};
				sector.center = { x: cx, y: cy };
				sector.radius = r;
				if (o.innerRadius) {
					sector.innerRadius = o.innerRadius;
				}
				self._addClass($(sector.node), "wijchart-canvas-object");
				$(sector.node).data("wijchartDataObj", series);

				if (o.showChartLabels) {
					pos = getPositionByAngle(cx, cy,
							series.offset + r * 2 / 3, angle + anglePlus / 2);
					textStyle = $.extend(true, {}, o.textStyle, o.chartLabelStyle);

					if (self.aniLabels && o.seriesTransition.enabled) {
						if (idx < self.aniLabels.length) {
							attr = self.aniLabels[idx].attr();
							self.aniLabels[idx].stop();
							attr.text = series.label;
							label = self.canvas.text(0, 0, "").attr(attr);
							textStyle = self._getDiffAttrs(attr, textStyle);
							textStyle.x = pos.x;
							textStyle.y = pos.y;
							label.wijAnimate(textStyle, o.seriesTransition.duration,
								o.seriesTransition.easing);
						} else {
							label = paper.text(pos.x, pos.y, series.label)
								.attr(textStyle);
						}
					} else {
						label = paper.text(pos.x, pos.y, series.label).attr(textStyle);
					}
					self._addClass($(label.node), "wijchart-canvas-object");
					$(label.node).data("wijchartDataObj", series);
					tooltipTars.push(label);
					labels.push(label);
				}

				sectors.push(sector);
				tooltipTars.push(sector);
				series.style = seriesStyle;
				series.hoverStyle = seriesHoverStyles[idx];
				series.index = idx;
				series.type = "pie";
				angle += anglePlus;
			});

			self.aniSectors = sectors;
			self.aniLabels = labels;

			self.sectors = sectors;
			self.tooltipTars = tooltipTars;
		},

		_paintChartLabels: function () {
			var self = this,
				o = self.options,
				chartLabels = o.chartLabels,
				angle = 0,
				r = o.radius;

			if (!chartLabels || !chartLabels.length) {
				return;
			}

			$.each(chartLabels, function (idx, chartlabel) {
				var cx = self.canvasBounds.startX + r,
					cy = self.canvasBounds.startY + r,
					chartLabel = $.extend(true, {
						compass: "east",
						attachMethod: "coordinate",
						attachMethodData: {
							seriesIndex: -1,
							x: -1,
							y: -1
						},
						offset: 0,
						visible: false,
						text: "",
						connected: false
					}, chartlabel),
					method,
					data,
					point,
					halfAngle,
					style,
					seriesIndex,
					series,
					value,
					anglePlus,
					seriesStyle,
					center,
					getPositionByAngle = self.canvas.wij.getPositionByAngle;

				if (!chartLabel.visible) {
					return true;
				}

				method = chartLabel.attachMethod;
				data = chartLabel.attachMethodData;
				point = { x: 0, y: 0 };
				halfAngle = 0;
				style = null;

				if (method === "dataIndex") {
					seriesIndex = data.seriesIndex;
					if (seriesIndex > -1) {
						series = o.seriesList[seriesIndex];
						value = series.data;
						anglePlus = 360 * value / self.total;
						seriesStyle = o.seriesStyles[seriesIndex];
						style = { stroke: seriesStyle.stroke || seriesStyle.fill };
						halfAngle = angle + anglePlus / 2;
						if (series.offset) {
							center = getPositionByAngle(cx, cy, series.offset, halfAngle);
							cx = center.x;
							cy = center.y;
						}
						point = getPositionByAngle(cx, cy, r, halfAngle);
						angle = angle + anglePlus;
					}
				}

				if (isNaN(point.x) || isNaN(point.y)) {
					return false;
				}

				self._setChartLabel(chartLabel, point, halfAngle, style);
			});
		},

		_getTooltipText: function (fmt, target) {
			var dataObj = $(target.node).data("wijchartDataObj"),
				value = dataObj.data,
				obj;

			obj = {
				value: value,
				total: this.total,
				data: dataObj,
				target: target,
				fmt: fmt
			};

			return $.proxy(fmt, obj)();
		},

		_bindLiveEvents: function () {
			var self = this,
				o = this.options,
				hintEnable = o.hint.enable,
				tooltip = self.tooltip,
				offset = { x: 0, y: 0 },
				hint,
				title,
				content,
				showAnimationTimers = [],
				hideAnimationTimers = [],
				explodeAnimationShowings = [];

			if (hintEnable && !tooltip) {
				hint = $.extend(true, {}, o.hint);
				hint.offsetY = hint.offsetY || -2;
				title = o.hint.title;
				content = o.hint.content;

				if ($.isFunction(title)) {
					hint.title = function () {
						return self._getTooltipText(title, this.target);
					};
				}

				if ($.isFunction(content)) {
					hint.content = function () {
						return self._getTooltipText(content, this.target);
					};
				}
				hint.beforeShowing = function () {
					if (this.target) {
						this.options.style.stroke = this.target.attrs.stroke ||
							this.target.attrs.fill;
					}
				};
				//tooltip = self.canvas.tooltip(self.sectors, hint);
				tooltip = self.canvas.tooltip(self.tooltipTars, hint);
				self.tooltip = tooltip;
			}

			$(".wijchart-canvas-object", this.chartElement[0])
				.live("mousedown.wijpiechart", function (e) {
					if (o.disabled) {
						return;
					}

					var dataObj = $(e.target).data("wijchartDataObj");
					if (!dataObj) {
						dataObj = $(e.target.parentNode).data("wijchartDataObj");
					}
					self._trigger("mouseDown", e, dataObj);
				})
				.live("mouseup.wijpiechart", function (e) {
					if (o.disabled) {
						return;
					}

					var dataObj = $(e.target).data("wijchartDataObj");
					if (!dataObj) {
						dataObj = $(e.target.parentNode).data("wijchartDataObj");
					}
					self._trigger("mouseUp", e, dataObj);
				})
				.live("mouseover.wijpiechart", function (e) {
					if (o.disabled) {
						return;
					}

					var dataObj = $(e.target).data("wijchartDataObj"),
						animation = o.animation,
						animated = animation && animation.enabled,
						index,
						sector,
						showAnimationTimer,
						hideAnimationTimer,
						explodeAnimationShowing;

					if (!dataObj) {
						dataObj = $(e.target.parentNode).data("wijchartDataObj");
					}
					index = dataObj.index;
					sector = self.getSector(index);
					showAnimationTimer = showAnimationTimers[index];
					hideAnimationTimer = hideAnimationTimers[index];
					explodeAnimationShowing = explodeAnimationShowings[index];
					sector.wijAttr(dataObj.hoverStyle);
					self._trigger("mouseOver", e, dataObj);

					if (animated) {
						if (hideAnimationTimer) {
							window.clearTimeout(hideAnimationTimer);
							hideAnimationTimer = null;
							hideAnimationTimers[index] = null;
						}

						if (showAnimationTimer) {
							window.clearTimeout(showAnimationTimer);
							showAnimationTimer = null;
							showAnimationTimers[index] = null;
						}

						if (explodeAnimationShowing) {
							return;
						}

						showAnimationTimer = window.setTimeout(function () {
							var duration = animation.duration,
								easing = animation.easing;

							offset = sector.getOffset(animation.offset);

							sector.wijAnimate({
								translation: offset.x + " " + offset.y
							}, duration, easing);

							explodeAnimationShowing = true;
							explodeAnimationShowings[index] = explodeAnimationShowing;
						}, 150);
						showAnimationTimers[index] = showAnimationTimer;
					}
				})
				.live("mouseout.wijpiechart", function (e) {
							//debugger;
					if (o.disabled) {
						return;
					}
					var dataObj = $(e.target).data("wijchartDataObj"),
						animation = o.animation,
						animated = animation && animation.enabled,
						index,
						sector,
						showAnimationTimer,
						hideAnimationTimer,
						explodeAnimationShowing;

					if (!dataObj) {
						dataObj = $(e.target.parentNode).data("wijchartDataObj");
					}
					index = dataObj.index;
					sector = self.getSector(index);
					showAnimationTimer = showAnimationTimers[index];
					hideAnimationTimer = hideAnimationTimers[index];
					explodeAnimationShowing = explodeAnimationShowings[index];
					self._trigger("mouseOut", e, dataObj);
					if (dataObj.style.segment) {
						delete dataObj.style.segment;
					}
					sector.wijAttr(dataObj.style);
					if (tooltip) {
						tooltip.hide();
					}

					if (animated) {
						if (hideAnimationTimer) {
							window.clearTimeout(hideAnimationTimer);
							hideAnimationTimer = null;
							hideAnimationTimers[index] = null;
						}

						if (showAnimationTimer) {
							window.clearTimeout(showAnimationTimer);
							showAnimationTimer = null;
							showAnimationTimers[index] = null;
						}

						if (!explodeAnimationShowing) {
							return;
						}

						hideAnimationTimer = window.setTimeout(function () {
							var duration = animation.duration,
								easing = animation.easing;

							sector.wijAnimate({
								translation: -offset.x + " " + -offset.y
							}, duration, easing);

							offset = { x: 0, y: 0 };
							explodeAnimationShowing = false;
							explodeAnimationShowings[index] = explodeAnimationShowing;
						}, 150);
						hideAnimationTimers[index] = hideAnimationTimer;
					}
				})
				.live("mousemove.wijpiechart", function (e) {
					if (o.disabled) {
						return;
					}

					var dataObj = $(e.target).data("wijchartDataObj");
					if (!dataObj) {
						dataObj = $(e.target.parentNode).data("wijchartDataObj");
					}
					self._trigger("mouseMove", e, dataObj);
				})
				.live("click.wijpiechart", function (e) {
					if (o.disabled) {
						return;
					}

					var dataObj = $(e.target).data("wijchartDataObj");
					if (!dataObj) {
						dataObj = $(e.target.parentNode).data("wijchartDataObj");
					}
					self._trigger("click", e, dataObj);
				});
		},

		_unbindLiveEvents: function () {
			var self = this;
			$(".wijchart-canvas-object", self.chartElement[0]).die("wijpiechart");
			if (self.tooltip) {
				self.tooltip.destroy();
				self.tooltip = null;
			}
		},

		_sector: function (cx, cy, r, startAngle, endAngle) {
			var self = this,
				start = self._getPositionByAngle(cx, cy, r, startAngle),
				end = self._getPositionByAngle(cx, cy, r, endAngle);
			return ["M", cx, cy, "L", start.x, start.y, "A", r, r, 0,
					+(endAngle - startAngle > 180), 0, end.x, end.y, "z"];
		},

		_donut: function (cx, cy, outerR, innerR, startAngle, endAngle) {
			var self = this,
				outerS = self._getPositionByAngle(cx, cy, outerR, startAngle),
				outerE = self._getPositionByAngle(cx, cy, outerR, endAngle),
				innerS = self._getPositionByAngle(cx, cy, innerR, startAngle),
				innerE = self._getPositionByAngle(cx, cy, innerR, endAngle),
				largeAngle = endAngle - startAngle > 180;

			return ["M", outerS.x, outerS.y,
					"A", outerR, outerR, 0, +largeAngle, 0, outerE.x, outerE.y,
					"L", innerE.x, innerE.y,
					"A", innerR, innerR, 0, +largeAngle, 1, innerS.x, innerS.y,
					"L", outerS.x, outerS.y, "z"];
		},

		_getPositionByAngle: function (cx, cy, r, angle) {
			var point = {},
				rad = Raphael.rad(angle);
			point.x = cx + r * Math.cos(-1 * rad);
			point.y = cy + r * Math.sin(-1 * rad);

			return point;
		}
		/** end of private methods */
	});
} (jQuery));

/*globals jQuery,window*/
/*
*
* Wijmo Library 1.4.0
* http://wijmo.com/
*
* Copyright(c) ComponentOne, LLC.  All rights reserved.
* 
* Dual licensed under the Wijmo Commercial or GNU GPL Version 3 licenses.
* licensing@wijmo.com
* http://wijmo.com/license
*
*
** Wijmo Tree widget.
*
* Depends:
*  jquery.ui.core.js
*  jquery.ui.widget.js
*  jquery.effects.core.js
*  jquery.ui.draggable.js
*  jquery.ui.droppable.js
*  jquery.wijmo.wijtextbox.js
*
*/
(function ($) {
	"use strict";
	$.widget("wijmo.wijtree", {

		options: {
			///	<summary>
			/// Allows tree nodes to be dragged
			/// Type:Boolean.
			/// Default:false.
			/// Code example:$(".selector").wijtree("allowDrag",true).
			///	</summary>
			allowDrag: false,
			///	<summary>
			///	Allows tree to be dropped within tree nodes.
			/// Type:Boolean.
			/// Default:false.
			/// Code example:$(".selector").wijtree("allowDrop",true).
			///	</summary>
			allowDrop: false,
			///	<summary>
			///	Allows tree nodes to be edited at run time.
			/// Type:Boolean.
			/// Default:false.
			/// Code example:$(".selector").wijtree("allowEdit",true).
			///	</summary>
			allowEdit: false,
			///	<summary>
			///	Allows tree nodes to be sorted at run time.
			/// Type:Boolean.
			/// Default:true.
			/// Code example:$(".selector").wijtree("allowSorting",false).
			///	</summary>
			allowSorting: true,
			///	<summary>
			///	Allow triState of checkBox.
			/// Type:Boolean.
			/// Default:true.
			/// Code example:$(".selector").wijtree("allowTriState",false).
			///	</summary>
			allowTriState: true,
			///	<summary>
			///	Allows sub-nodes to be checked upon parent node check.
			/// Type:Boolean.
			/// Default:true.
			/// Code example:$(".selector").wijtree("autoCheckNodes",false).
			///	</summary>
			autoCheckNodes: true,
			///	<summary>
			///	If this option is set to true, 
			/// the expanded node will be collapsed if another node is expanded.
			/// Type:Boolean.
			/// Default:true.
			/// Code example:$(".selector").wijtree("autoCollapse",false).
			///	</summary>
			autoCollapse: false,
			///	<summary>
			///	If set to true, the select, click, 
			/// and check operations are disabled too.
			/// Type:Boolean.
			/// Default:false.
			/// Code example:$(".selector").wijtree("disabled",true).
			///	</summary>
			disabled: false,
			///	<summary>
			///	If this option is set to true, the tree will be expand/Collapse 
			/// when the mouse hovers on the expand/Collapse button 
			/// Type:Boolean.
			/// Default:false.
			/// Code example:$(".selector").wijtree("expandCollapseHoverUsed",true).
			///	</summary>
			expandCollapseHoverUsed: false,
			///	<summary>
			///	Allows the CheckBox to be shown on tree nodes
			/// Type:Boolean.
			/// Default:true.
			/// Code example:$(".selector").wijtree("showCheckBoxes",false).
			///	</summary>
			showCheckBoxes: false,
			///	<summary>
			///	Allows tree nodes to be expanded or collapsed
			/// Type:Boolean.
			/// Default:true.
			/// Code example:$(".selector").wijtree("showExpandCollapse",false).
			///	</summary>
			showExpandCollapse: true,
			///	<summary>
			///	Animation options for showing the child nodes 
			/// when the parent node is expanded.
			/// Type:Object.
			/// Default:{ effect: "blind", easing: "easeOutExpo", duration: 200 }.
			/// Code example:$(".selector").wijtree("expandAnimation",
			/// { effect: "blind", easing: "easeOutExpo", duration: 200 }).
			///	</summary>
			expandAnimation: { effect: "blind", easing: "easeOutExpo", duration: 200 },
			///	<summary>
			///	The duration of the time to delay before the node is expanded.
			/// Type:Number.
			/// Default:0.
			/// Code example:$(".selector").wijtree("expandDelay",100).
			///	</summary>
			expandDelay: 0,
			///	<summary>
			/// Animation options for hiding the child nodes 
			/// when the parent node is collapsed.
			/// Type:Object.
			/// Default:{ effect: "blind", easing: "easeOutExpo", duration: 200 }.
			/// Code example:$(".selector").wijtree("collapseAnimation",
			/// { effect: "blind", easing: "easeOutExpo", duration: 200 }).
			///	</summary>
			collapseAnimation: { effect: "blind", easing: "easeOutExpo", duration: 200 },
			///	<summary>
			///	The duration of the time to delay before the node is collapsed.
			/// Type:Number.
			/// Default:0.
			/// Code example:$(".selector").wijtree("collapseDelay",100).
			///	</summary>
			collapseDelay: 0,
			/// <summary>
			/// The nodeBlur event handler. A function called when a node is blurred.
			/// Default: null
			/// Type: Function
			/// Code example: 
			/// Supply a function as an option.
			/// $(".selector").wijtree({ nodeBlur: function (e, data) { } });
			/// Bind to the event by type: wijtreenodeBlur
			/// $("#selector").bind("wijtreenodeBlur", function(e, data) { } );
			/// </summary>
			/// <param name="e" type="Object">
			/// jQuery.Event object.
			/// </param>
			/// <param name="data" type="Object">
			/// The node widget that relates to this event.
			/// </param>
			nodeBlur: null,
			/// <summary>
			/// The nodeClick event handler. A function called when a node is clicked.
			/// Default: null
			/// Type: Function
			/// Code example: 
			/// Supply a function as an option.
			/// $(".selector").wijtree({ nodeClick: function (e, data) { } });
			/// Bind to the event by type: wijtreenodeClick
			/// $("#selector").bind("wijtreenodeClick", function(e, data) { } );
			/// </summary>
			/// <param name="e" type="Object">
			/// jQuery.Event object.
			/// </param>
			/// <param name="data" type="Object">
			/// The node widget that relates to this event.
			/// </param>
			nodeClick: null,
			/// <summary>
			/// The nodeCheckChanged event handler. 
			/// A function called when a node is checked or unchecked.
			/// Default: null
			/// Type: Function
			/// Code example: 
			/// Supply a function as an option.
			/// $(".selector").wijtree({ nodeCheckChanged: function (e, data) { } });
			/// Bind to the event by type: wijtreenodeCheckChanged
			/// $("#selector").bind("wijtreenodeCheckChanged", function(e, data) { } );
			/// </summary>
			/// <param name="e" type="Object">
			/// jQuery.Event object.
			/// </param>
			/// <param name="data" type="Object">
			/// The node widget that relates to this event.
			/// </param>
			nodeCheckChanged: null,
			/// <summary>
			/// The nodeCollapsed event handler.
			/// A function called when a node is collapsed.
			/// Default: null
			/// Type: Function
			/// Code example: 
			/// Supply a function as an option.
			/// $(".selector").wijtree({ nodeCollapsed: function (e, data) { } });
			/// Bind to the event by type: wijtreenodeCollapsed
			/// $("#selector").bind("wijtreenodeCollapsed", function(e, data) { } );
			/// </summary>
			/// <param name="e" type="Object">
			/// jQuery.Event object.
			/// </param>
			/// <param name="data" type="Object">
			/// The node widget that relates to this event.
			/// </param>
			nodeCollapsed: null,
			/// <summary>
			/// The nodeExpanded event handler.
			/// A function called when a node is expanded.
			/// Default: null
			/// Type: Function
			/// Code example: 
			/// Supply a function as an option.
			/// $(".selector").wijtree({ nodeExpanded: function (e, data) { } });
			/// Bind to the event by type: wijtreenodeExpanded
			/// $("#selector").bind("wijtreenodeExpanded", function(e, data) { } );
			/// </summary>
			/// <param name="e" type="Object">
			/// jQuery.Event object.
			/// </param>
			/// <param name="data" type="Object">
			/// The node widget that relates to this event.
			/// </param>
			nodeExpanded: null,
			/// <summary>
			/// The nodeDragging event handler.A function called
			/// when the node is moved during a drag-and-drop operation. 
			/// Default: null
			/// Type: Function
			/// Code example: 
			/// Supply a function as an option.
			/// $(".selector").wijtree({ nodeDragging: function (e, data) { } });
			/// Bind to the event by type: wijtreenodeDragging
			/// $("#selector").bind("wijtreenodeDragging", function(e, data) { } );
			/// </summary>
			/// <param name="e" type="Object">
			/// jQuery.Event object.
			/// </param>
			/// <param name="data" type="Object">
			/// The node widget that relates to this event.
			/// </param>
			nodeDragging: null,
			/// <summary>
			/// The nodeDragStarted event handler.
			/// A function called when a user starts to drag a node. 
			/// Default: null
			/// Type: Function
			/// Code example: 
			/// Supply a function as an option.
			/// $(".selector").wijtree({ nodeDragStarted: function (e, data) { } });
			/// Bind to the event by type: wijtreenodeDragStarted
			/// $("#selector").bind("wijtreenodeDragStarted", function(e, data) { } );
			/// </summary>
			/// <param name="e" type="Object">
			/// jQuery.Event object.
			/// </param>
			/// <param name="data" type="Object">
			/// The node widget that relates to this event.
			/// </param>
			nodeDragStarted: null,
			/// <summary>
			/// The nodeDropped event handler.
			/// A function called when an acceptable draggable node 
			/// is dropped over to another position. 
			/// Default: null
			/// Type: Function
			/// Code example: 
			/// Supply a function as an option.
			/// $(".selector").wijtree({ nodeDropped: function (e, data) { } });
			/// Bind to the event by type: wijtreenodeDropped
			/// $("#selector").bind("wijtreenodeDropped", function(e, data) { } );
			/// </summary>
			/// <param name="e" type="Object">
			/// jQuery.Event object.
			/// </param>
			/// <param name="data" type="Object">
			/// The data relates to this event.
			/// data.sourceParent: 
			/// The source parent of current draggable node before it be dragged ,
			/// a jQuery object.
			/// data.sIndex: The Index of dragged node in source parent.
			/// data.targetParent: 
			/// The target parent of current draggable node after it be dropped ,
			/// a jQuery object.
			/// data.tIndex: The Index of dragged node in target parent.
			/// data.draggable: The current draggable node.
			/// data.offset: The current absolute position of the draggable helper.
			/// data.position: The current position of the draggable helper.
			/// </param>
			nodeDropped: null,
			/// <summary>
			/// The nodeMouseOver event handler.
			/// A function called when the user mouses over the node. 
			/// Default: null
			/// Type: Function
			/// Code example: 
			/// Supply a function as an option.
			/// $(".selector").wijtree({ nodeMouseOver: function (e, data) { } });
			/// Bind to the event by type: wijtreenodeMouseOver
			/// $("#selector").bind("wijtreenodeMouseOver", function(e, data) { } );
			/// </summary>
			/// <param name="e" type="Object">
			/// jQuery.Event object.
			/// </param>
			/// <param name="data" type="Object">
			/// The node widget that relates to this event.
			/// </param>
			nodeMouseOver: null,
			/// <summary>
			/// The nodeMouseOut event handler.
			/// A function called when the user mouses out of the node. 
			/// Default: null
			/// Type: Function
			/// Code example: 
			/// Supply a function as an option.
			/// $(".selector").wijtree({ nodeMouseOut: function (e, data) { } });
			/// Bind to the event by type: wijtreenodeMouseOut
			/// $("#selector").bind("wijtreenodeMouseOut", function(e, data) { } );
			/// </summary>
			/// <param name="e" type="Object">
			/// jQuery.Event object.
			/// </param>
			/// <param name="data" type="Object">
			/// The node widget that relates to this event.
			/// </param>
			nodeMouseOut: null,
			/// <summary>
			/// The nodeTextChanged event handler.
			/// A function called when the text of the node changes.
			/// Default: null
			/// Type: Function
			/// Code example: 
			/// Supply a function as an option.
			/// $(".selector").wijtree({ nodeTextChanged: function (e, data) { } });
			/// Bind to the event by type: wijtreenodeTextChanged
			/// $("#selector").bind("wijtreenodeTextChanged", function(e, data) { } );
			/// </summary>
			/// <param name="e" type="Object">
			/// jQuery.Event object.
			/// </param>
			/// <param name="data" type="Object">
			/// The node widget that relates to this event.
			/// </param>
			nodeTextChanged: null,
			/// <summary>
			/// The selectedNodeChanged event handler.
			/// A function called when the selected node changes.
			/// Default: null
			/// Type: Function
			/// Code example: 
			/// Supply a function as an option.
			/// $(".selector").wijtree({ selectedNodeChanged: function (e, data) { } });
			/// Bind to the event by type: wijtreeselectedNodeChanged
			/// $("#selector").bind("wijtreeselectedNodeChanged", function(e, data) { } );
			/// </summary>
			/// <param name="e" type="Object">
			/// jQuery.Event object.
			/// </param>
			/// <param name="data" type="Object">
			/// The node widget that relates to this event.
			/// </param>
			selectedNodeChanged: null
		},

		/* init methods*/
		_create: function () {
			this._initState();
			this._createTree();
			this._attachEvent();
			this._attachNodeEvent();
		},

		_setOption: function (key, value) {
			var self = this, isResetHitArea = false, check;

			switch (key) {
				case "allowDrag":
					self._setAllowDrag(value);
					break;
				case "allowDrop":
					self._setAllowDrop(value);
					break;
				case "showCheckBoxes":
					self._setCheckBoxes(value);
					break;
				case "showExpandCollapse":
					if (self.options.showExpandCollapse !== value) {
						isResetHitArea = true;
					}
					break;
				case "disabled":
					if (value) {
						self.widgetDom.addClass("ui-state-disabled");
					} else {
						self.widgetDom.removeClass("ui-state-disabled");
					}
					check = self.element.find(":wijmo-wijtreecheck");
					if (check.length) {
						check.wijtreecheck("option", "disabled", value);
					}
					break;
				default:
					break;
			}
			$.Widget.prototype._setOption.apply(self, arguments); //use Widget disable
			if (isResetHitArea === true) {
				self._setHitArea(value);
			}
		},

		_initState: function () { //declare the properties of tree
			var self = this;
			self._selectedNodes = [];
			self._checkedNodes = [];
			self._enabled = true;
			self._insertPosition = "unKnown"; //end,after,before
			self.nodeWidgetName = "wijtreenode";
		},

		_createTree: function () {//create by dom
			var self = this, o = self.options, nodes = [], check,
			treeClass = "wijmo-wijtree ui-widget ui-widget-content " +
			"ui-helper-clearfix ui-corner-all";

			if (self.element.is("ul")) {
				self.$nodes = self.element;
				self.element.wrap("<div></div>");
				self.widgetDom = self.element.parent();
			}
			else if (self.element.is("div")) {
				self.widgetDom = self.element;
				self.$nodes = self.widgetDom.children("ul:eq(0)");
			}

			if (self.$nodes.length) {
				self.widgetDom.addClass(treeClass)
				.attr({
					role: "tree",
					"aria-multiselectable": true
				});
				self.$nodes.addClass("wijmo-wijtree-list ui-helper-reset");

				nodes = self._createChildNodes();

				self._hasChildren = nodes.length > 0;
				self._setField("nodes", nodes);
				self.nodes = nodes;
				self.widgetDom.append($("<div>").css("clear", "both"));
			}

			if (o.disabled) {
				self.disable();
			}
		},

		_createChildNodes: function () {
			var self = this, options = self.options, nodes = [];
			self.$nodes.children("li").each(function () {
				var $li = $(this);
				self._createNodeWidget($li, options);
				nodes.push(self._getNodeWidget($(this)));
			});
			return nodes;
		},

		_createNodeWidget: function ($li, options) {
			var self = this, nodeWidgetName = self.nodeWidgetName;
			if ($.fn[nodeWidgetName]) {
				$li.data("owner", this);
				if (!!options && $.isPlainObject(options)) {
					$.extend(options, { treeClass: this.widgetBaseClass });
					$li[nodeWidgetName](options);
				}
				else {
					$li[nodeWidgetName]({ treeClass: this.widgetBaseClass });
				}
			}
			return $li;
		},

		/*tree event*/
		_attachEvent: function () {
			var self = this;
			self.element.bind($.browser.msie ? "focusin." : "focus." + self.widgetName,
			$.proxy(self._onFocus, self))
			.bind("mouseover." + this.widgetName, $.proxy(self._onMouseOver, self));
			if (self.options.allowDrop) {
				self._attachDroppable();
			}
		},

		_attachDroppable: function () {
			var self = this;
			self.widgetDom.droppable({
				drop: function (event, ui) {
					var d = ui.draggable, dragNode = self._getNodeWidget(d),
					dropNode, position, oldOwner, parent, brothers, idx, nodes, i,
					oldPosition, newPosition;
					if (dragNode) {
						dropNode = dragNode._dropTarget;
						if (dropNode) {
							position = dragNode._insertPosition;
							if (dropNode && position !== "unKnown") {
								oldOwner = d.data("owner");
								if (oldOwner) {
									oldPosition = d.index();
									oldOwner.remove(d);
								}
								if (!oldOwner.element.is(":" + self.widgetBaseClass) &&
								oldOwner._getField("nodes").length > 0) {
									if (self.options.showCheckBoxes &&
									self.options.allowTriState) {
										oldOwner._getField("nodes")[0]
										._setParentCheckState();
									}
								}
								if (position === "end") {
									d.show();
									newPosition = dropNode._getField("nodes").length;
									dropNode.add(d);
									parent = dropNode;
								}
								else if (position === "before" || position === "after") {
									parent = dropNode._getField("owner");
									brothers = parent._getField("nodes");
									idx = $.inArray(dropNode, brothers);
									if (idx !== -1) {
										d.show();
										if (position === "before") {
											newPosition = idx;
											parent.add(d, newPosition);
										}
										else if (position === "after") {
											newPosition = idx + 1;
											parent.add(d, newPosition);
										}
									}
								}

								//maybe remove to add method.
								if (!parent.element.is(":" + self.widgetBaseClass) &&
								parent._getField("nodes").length > 0) {
									if (self.options.showCheckBoxes &&
									self.options.allowTriState) {
										parent._getField("nodes")[0]
										._setParentCheckState();
									}
								}

								$("a:eq(0)", d).blur();

								/*reset the tree of node*/
								/*reset old tree*/
								dragNode._tree._isDragging = false;
								if (dragNode.options.selected) {
									dragNode._setSelected(false);
								}
								/*set new tree*/
								dragNode._tree = self;
								nodes = dragNode._getField("nodes");
								for (i = 0; i < nodes.length; i++) {
									nodes[i]._tree = self;
								}
								$.extend(ui, {
									sourceParent: oldOwner.element,
									sIndex: oldPosition,
									targetParent: parent.element,
									tIndex: newPosition,
									widget: dragNode
								});
								self._trigger("nodeDropped", event, ui);
							}
						}
						else {
							d.draggable("option", "revert", true);
						}
					}
				},
				accept: "li",
				scope: "tree"
			});
		},

		_attachNodeEvent: function () {
			this.element.bind("click." + this.widgetName, $.proxy(this._onClick, this))
			.bind("mouseout." + this.widgetName, $.proxy(this._onMouseOut, this))
			.bind("keydown." + this.widgetName, $.proxy(this._onKeyDown, this));
		},

		_onClick: function (event) {
			this._callEvent(event, '_onClick');
			if ($.browser.webkit) {
				this.widgetDom.focus();
			}
		},

		_onFocus: function (event) {
			this._callEvent(event, '_onFocus');
		},

		_onKeyDown: function (event) {
			this._callEvent(event, '_onKeyDown');
		},

		_onMouseOut: function (event) {
			this._callEvent(event, '_onMouseOut');
		},

		_onMouseOver: function (event) {
			this._callEvent(event, '_onMouseOver');
		},

		_callEvent: function (event, type) {
			var el = event.target, node;
			if (el) {
				node = this._getNodeWidgetByDom(el);
				if (node === null) {
					return;
				}
				node[type](event);
			}
		},

		_nodeSelector: function () {
			return ":wijmo-wijtreenode";
		},

		/*public methods*/
		getSelectedNodes: function () {
			/// <summary>
			/// Get the selected nodes
			/// </summary>
			return this._selectedNodes;
		},

		getCheckedNodes: function () {
			/// <summary>
			/// Get the checked nodes
			/// </summary>
			// return this._checkedNodes;
			var self = this, checkedNodes = [],
			nodeWidgetName = self.nodeWidgetName;
			$(self._nodeSelector(), self.element).each(function () {
				if ($(this)[nodeWidgetName]("option", "checked") &&
				$(this)[nodeWidgetName]("option", "checkState") !== "indeterminate") {
					checkedNodes.push($(this));
				}
			});
			return checkedNodes;
		},

		destroy: function () {
			/// <summary>
			/// Destroy the widget
			/// </summary>
			var self = this, $nodes = self.$nodes,
			c = "wijmo-wijtree ui-widget ui-widget-content " +
			"ui-helper-clearfix ui-corner-all";
			self.widgetDom.removeClass(c);

			if (self.widgetDom.data("droppable")) {
				self.widgetDom.droppable("destroy");
			}
			$nodes.removeData("nodes").removeClass("wijmo-wijtree-list ui-helper-reset");
			$nodes.children("li").each(function () {
				var nodeWidget = self._getNodeWidget($(this));
				if (nodeWidget) {
					nodeWidget.destroy();
				}
			});
			$.Widget.prototype.destroy.apply(this);
		},

		add: function (node, position) {
			/// <summary>
			/// Add a node to the element.
			/// </summary>
			/// <param name="node" type="String,Object">
			/// which node to be added
			/// 1.markup html.such as "<li><a>node</a></li>" as a node.
			/// 2.wijtreenode widget.
			/// 3.object options according to the options of wijtreenode.
			/// </param>
			/// <param name="position" type="Int">
			/// the position to insert at
			/// </param>
			var nodeWidget = null, o = this.options, $node, nodes, self = this,
			originalLength, itemDom = "<li><a href='{0}'>{1}</a></li>";
			if (typeof node === "string") {
				$node = $(itemDom.replace(/\{0\}/, "#")
				.replace(/\{1\}/, node));
				self._createNodeWidget($node, o);
				nodeWidget = $node.data($node.data("widgetName"));
			}
			else if (node.jquery) {
				if (!node.data("widgetName")) {
					self._createNodeWidget(node, o);
				}
				nodeWidget = node.data(node.data("widgetName"));
			}
			else if (node.nodeType) {
				$node = $(node);
				self._createNodeWidget($node, o);
				nodeWidget = $node.data($node.data("widgetName"));
			}
			else if ($.isPlainObject(node)) {
				$node = $(itemDom.replace(/\{0\}/, node.url)
				.replace(/\{1\}/, node.text)); //node
				self._createNodeWidget($node, node);
				nodeWidget = $node.data($node.data("widgetName"));
			}

			if (nodeWidget === null) {
				return;
			}
			nodes = self._getField("nodes");
			if (!position && position > nodes.length) {
				position = nodes.length;
			}

			nodeWidget._setField("owner", this);
			originalLength = nodes.length;
			if (originalLength > 0 && originalLength !== position) {
				if (nodeWidget.element.get(0) !== nodes[position].element.get(0)) {
					nodeWidget.element.insertBefore(nodes[position].element);
				}
			}
			else {
				self.$nodes.append(nodeWidget.element);
			}
			self._changeCollection(position, nodeWidget);
			self._refreshNodesClass();
		},

		remove: function (node) {
			/// <summary>
			/// Remove a node to the element.
			/// </summary>
			/// <param name="node" type="String,Object">
			/// which node to be removed
			/// 1.wijtreenode widget.
			/// 2.the index of which node you determined to remove.
			/// </param>
			var idx = -1, nodeWidget, nodes;
			if (node.jquery) {
				idx = node.index();
			}
			else if (typeof node === "number") {
				idx = node;
			}
			nodes = this._getField("nodes");
			if (idx < 0 && idx >= nodes.length) {
				return;
			}
			nodeWidget = nodes[idx];
			nodeWidget.element.detach();
			this._changeCollection(idx);
			this._refreshNodesClass();
		},

		_changeCollection: function (idx, nodeWidget) {
			var nodes = this._getField("nodes");
			if (nodeWidget) {
				nodes.splice(idx, 0, nodeWidget);
			}
			else {
				nodes.splice(idx, 1);
			}
		},

		findNodeByText: function (txt) {
			/// <summary>
			/// Find node by the node text
			/// </summary>
			/// <param name="txt" type="String">
			/// the text of which node you want to find
			/// </param>
			/// <returns type="wijtreenode" />
			var nodes = $(".wijmo-wijtree-node a>span", this.$nodes).filter(function () {
				return $(this).text() === txt;
			});
			if (nodes.length) {
				return this._getNodeWidgetByDom(nodes.get(0));
			}
			return null;
		},

		_setAllowDrag: function (value) {
			var self = this, $allNodes, nodeSelector = self._nodeSelector(),
			nodeWidgetName = self.nodeWidgetName;
			if (value) {
				$allNodes = self.element.find(nodeSelector);
				$allNodes.each(function () {
					var w = $(this).data(nodeWidgetName);
					if (!$(this).data("draggable") &&
					!w.$navigateUrl.data("events").mousedown) {
						w.$navigateUrl.one("mousedown", w, w._onMouseDown);
					}
				});
			}
			else {
				$allNodes = self.element.find(nodeSelector + ":ui-draggable");
				$allNodes.draggable("destroy");
			}
		},

		_setAllowDrop: function (value) {
			if (value) {
				if (!this.widgetDom.data("droppable")) {
					this._attachDroppable();
				}
			}
			else if (this.widgetDom.droppable) {
				this.widgetDom.droppable("destroy");
			}
		},

		_setCheckBoxes: function (value) {
			var self = this;
			self.$nodes.children("li").each(function () {
				var nodeWidget = self._getNodeWidget($(this));
				if (nodeWidget !== null) {
					nodeWidget._setCheckBoxes(value);
				}
			});
		},

		_setHitArea: function (value) {
			var self = this;
			self.$nodes.children("li").each(function () {
				var nodeWidget = self._getNodeWidget($(this));
				if (nodeWidget !== null) {
					nodeWidget._setHitArea(value);
				}
			});
		},

		/*region methods(private)*/
		_getNodeWidget: function ($node) {
			if ($node.is(this._nodeSelector())) {
				var widget = $node.data($node.data("widgetName"));
				return widget;
			}
			return null;
		},

		_getNodeWidgetByDom: function (el) {
			var node = this._getNodeByDom(el);
			return this._getNodeWidget(node);
		},

		_getNodeByDom: function (el) {//Arg :Dom Element
			return $(el).closest(this._nodeSelector());
		},

		_refreshNodesClass: function () {
			var nodes = this._getField("nodes"), i;
			for (i = 0; i < nodes.length; i++) {
				nodes[i]._initNodeClass();
			}
		},

		_getField: function (key) {
			return this.element.data(key);
		},

		_setField: function (key, value) {
			return this.element.data(key, value);
		}
	});
} (jQuery));

(function ($) {
	$.widget("wijmo.wijtreenode", {
		options: {
			accessKey: "",
			///	<summary>
			///	Checks the node when it set to true; otherwise, it unchecks the node. 
			/// Type:Boolean.
			/// Default:false.
			/// Code example:$(".selector").wijtreenode("checked",true).
			///	</summary>
			checked: false,
			///	<summary>
			///	Sets the collapsed icon (base on ui-icon) of the node
			/// Type:String.
			/// Default:"".
			/// Code example:
			/// $(".selector").wijtreenode("collapsedIconClass","ui-icon-file").
			///	</summary>
			collapsedIconClass: "",
			///	<summary>
			///	Sets the node to expanded (if true) or collapsed (if false).
			/// Type:Boolean.
			/// Default:false.
			/// Code example:$(".selector").wijtreenode("expanded",true).
			///	</summary>
			expanded: false,
			///	<summary>
			///	Sets the expanded icon (base on ui-icon) of the node
			/// Type:String.
			/// Default:"".
			/// Code example:$(".selector").wijtreenode("expandedIconClass","iconClass").
			///	</summary>
			expandedIconClass: "",
			///	<summary>
			///	Sets the icon (base on ui-icon) of the node
			/// It will displayed on both expanded and collapsed node 
			/// when expandedIconClass & collapsedIconClass is empty,
			/// Type:String.
			/// Default:"".
			/// Code example:$(".selector").wijtreenode("itemIconClass","iconClass").
			///	</summary>
			itemIconClass: "",
			///	<summary>
			///	Sets the navigate url link of the node
			/// Type:String.
			/// Default:"".
			/// Code example:$(".selector").wijtreenode("navigateUrl","http://google.com).
			///	</summary>
			navigateUrl: "",
			///	<summary>
			///	Selects this node when it set to true,otherwise unselects the node
			/// Type:Boolean.
			/// Default:false.
			/// Code example:$(".selector").wijtreenode("selected",true).
			///	</summary>
			selected: false,
			///	<summary>
			///	Sets the node's text. 
			/// Type:String.
			/// Default:"".
			/// Code example:$(".selector").wijtreenode("text","Hello World!").
			///	</summary>
			text: "",
			///	<summary>
			///	Sets the node's tooltip.
			/// Type:String.
			/// Default:"".
			/// Code example:$(".selector").wijtreenode("toolTip","Node 1 toolTip").
			///	</summary>
			toolTip: ""
		},

		/*widget Method*/
		_setOption: function (key, value) {
			var self = this, check;

			switch (key) {
				case "accessKey":
					if (self.$navigateUrl !== null) {
						self.$navigateUrl.attr("accesskey", value);
					}
					break;
				case "checked":
					self._checkState = value ? "checked" : "unChecked";
					self._setChecked(value);
					break;
				case "collapsedIconClass":
				case "expandedIconClass":
				case "itemIconClass":
					self.options[key] = value;
					self._initNodeImg();
					break;
				case "expanded":
					self._setExpanded(value);
					break;
				case "selected":
					self._setSelected(value);
					break;
				case "text":
					self._setText(value);
					break;
				case "toolTip":
					self._setToolTip(value);
					break;
				case "navigateUrl":
					self._setNavigateUrlHref(value);
					break;
				case "disabled":
					if (self._isClosestDisabled() && value === true) {
						return;
					}
					check = self.element.find(":wijmo-wijtreecheck");
					if (check.length) {
						check.wijtreecheck("option", "disabled", value);
					}
					break;
				default:
					break;
			}
			$.Widget.prototype._setOption.apply(self, arguments);
		},

		_initState: function () {// declare the properity of node
			this._tree = null;
			this._dropTarget = null;
			this._checkState = "unChecked"; //Checked,UnChecked,Indeterminate
			this._value = this._text = this._navigateUrl = "";
			this._insertPosition = "unKnown"; //end,after,before
			this._hasNodes = false; //for ajax load
		},

		_create: function () {
			this._initState();
			this._createTreeNode();
			this._initNode();
			this.element.data("widgetName", this.widgetName);
		},

		_createTreeNode: function () {
			var $li = this.element, self = this, nodes = [];
			this.$navigateUrl = $li.children("a");

			if (self._tree === null) {
				self._tree = self._getTree();
			}
			self.$nodeBody = null;
			self.$checkBox = null;
			self.$nodeImage = $("<span>");
			self.$hitArea = null;
			self.$nodes = null;
			self.$nodeBody = $("<div>")
			.attr({
				role: "treeitem",
				"aria-expanded": false,
				"aria-checked": false,
				"aria-selected": false
			});
			if (self._tree.options.showCheckBoxes === true) {
				self.$checkBox = $("<div>");
			}

			if (self.$navigateUrl.length === 0) {
				self.$navigateUrl = $li.children("div");
				self.$navigateUrl.addClass("wijmo-wijtree-template");
				self._isTemplate = true;
			}

			if (self.$navigateUrl.length === 0) {
				self.$navigateUrl = $("<a>");
				self.$navigateUrl.attr("href", "#");
			}

			if (!self._isTemplate) {
				self.$text = self.$navigateUrl.find("span:eq(0)");
				if (self.$text.length === 0) {
					self.$navigateUrl.wrapInner("<span></span>");
					self.$text = self.$navigateUrl.find("span:eq(0)");
				}
			}

			self._hasChildren = self._getChildren();
			self.$inner = $("<span></span>")
			.addClass("ui-helper-clearfix wijmo-wijtree-inner ui-corner-all");
			nodes = self._createChildNodes($li);
			self.$inner.append(self.$nodeImage);
			if (self.$checkBox !== null) {
				self.$inner.append(self.$checkBox);
				self.$checkBox.wijtreecheck();
			}
			self.$inner.append(self.$navigateUrl);
			self.$nodeBody.append(self.$inner);
			self._setField("nodes", nodes);
			$li.prepend(self.$nodeBody);
		},

		_createChildNodes: function ($li) {
			var self = this, nodes = [];
			if (self._hasChildren) {
				$li.addClass("wijmo-wijtree-parent");
				self.$nodeBody
				.addClass("wijmo-wijtree-node wijmo-wijtree-header ui-state-default");
				self.$hitArea = $("<span>");
				self.$inner.prepend(self.$hitArea);
				self.$nodes = $li.find("ul:eq(0)")
				.addClass("wijmo-wijtree-list ui-helper-reset wijmo-wijtree-child");
				nodes = self._createChildNode();
			}
			else {
				$li.addClass("wijmo-wijtree-item");
				self.$nodeBody.addClass("wijmo-wijtree-node ui-state-default");
			}
			return nodes;
		},

		_createChildNode: function () {
			var self = this, nodes = [];
			self.$nodes.children().filter("li").each(function (i) {
				var $li = $(this), nodeWidget;
				$li.data("owner", self);
				$li.wijtreenode(self.options);  //the arg must be jquerify
				nodeWidget = self._getNodeWidget($li);
				nodeWidget._index = i;
				nodes.push(nodeWidget);
			});
			return nodes;
		},

		_initNode: function () {//init node(children,class, tree)
			var self = this, o = self.options;
			if (!self._initialized) {
				self._initialized = true;
				self._initNavigateUrl();
				if (!self._isTemplate && self.$text) {
					self._text = self.$text.html();
					o.text = self.$text.html();
				}
				self._hasChildren = self._getChildren();
				self._initNodesUL();
				self._initNodeClass();
				self._initNodeImg();
				self._initCheckBox();
				self.$navigateUrl.one("mousedown", self, self._onMouseDown);
			}
		},

		_initNodeClass: function () {
			var self = this, o = self.options,
			hitClass = "ui-icon " +
			(o.expanded ? "ui-icon-triangle-1-se" : "ui-icon-triangle-1-e");
			if (self._tree.options.showExpandCollapse) {
				if (self._hasChildren || !!o.hasChildren) {
					if (self.$hitArea !== null) {
						self.$hitArea
						.removeClass('ui-icon ui-icon-triangle-1-se ui-icon-triangle-1-e')
						.addClass(hitClass);
					}
					else {
						self.$hitArea = $("<span>")
						.addClass(hitClass).prependTo(self.$inner);
						self.element
						.removeClass("wijmo-wijtree-node ui-state-default ui-corner-all")
						.addClass("wijmo-wijtree-parent");
					}
					if (self._hasChildren) {
						self.$nodes[o.expanded ? "show" : "hide"]();
					}
				}
				else if (self.$hitArea) {
					self.$hitArea.remove();
					self.$hitArea = null;
					self.element
					.removeClass("wijmo-wijtree-parent")
					.addClass("wijmo-wijtree-node ui-state-default ui-corner-all");
				}
			}

			if (o.selected && self.$inner) {
				self.$inner.addClass("ui-state-active");
			}
		},

		_initCheckBox: function () {
			var self = this, o = self.options;
			if (self.$checkBox && o.checkState) {
				switch (o.checkState) {
					case "checked":
						self.$checkBox.wijtreecheck("option", "checkState", "check");
						break;
					case "indeterminate":
						self.$checkBox.wijtreecheck("option", "checkState", "triState");
						break;
					case "unChecked":
						self.$checkBox.wijtreecheck("option", "checkState", "unCheck");
						break;
					default:
						self.$checkBox.wijtreecheck("option", "checkState", "unCheck");
						break;
				}
			}
		},

		_initNodesUL: function () {
			var self = this;
			if (self._tree.options.showExpandCollapse) {
				if (self._hasChildren) {
					self.$nodes[self._expanded ? 'show' : 'hide']();
				}
			}
		},

		_initNavigateUrl: function () {
			var self = this, href = self.$navigateUrl.attr("href");
			self.$navigateUrl.bind("blur." + self.widgetName, self, self._onBlur);

			if (!this._isTemplate) {
				self._navigateUrl = !!href ? href : "";
				self._setNavigateUrlHref(href);
			}
		},

		_initNodeImg: function () {//ui-icon instead of image
			var self = this, o = this.options;
			if (this.$nodeImage === null || !this.$nodeImage.length) {
				this.$nodeImage = $("<span>");
			}

			/* initial html has icon attribute for asp.net mvc*/
			if (self.element.attr("expandediconclass")) {
				self.options.expandedIconClass = self.element.attr("expandediconclass");
				self.element.removeAttr("expandediconclass");
			}
			if (self.element.attr("collapsediconclass")) {
				self.options.collapsedIconClass = self.element.attr("collapsediconclass");
				self.element.removeAttr("collapsediconclass");
			}
			if (self.element.attr("itemiconclass")) {
				self.options.itemIconClass = self.element.attr("itemiconclass");
				self.element.removeAttr("itemiconclass");
			}
			/* end */

			if (self.options.collapsedIconClass !== "" &&
			self.options.expandedIconClass !== "") {
				this.$nodeImage.removeClass().addClass("ui-icon")
				.addClass(o.expanded ? o.expandedIconClass : o.collapsedIconClass);
				if (!self._tree.options.showExpandCollapse) {
					this.$nodeImage.addClass(self.options.expandedIconClass);
				}
				this.$nodeImage.insertBefore(this.$checkBox);
			}
			else if (self.options.itemIconClass !== "") {
				this.$nodeImage.removeClass().addClass("ui-icon");
				this.$nodeImage.addClass(self.options.itemIconClass);
				this.$nodeImage.insertBefore(this.$checkBox);
			}
		},

		_setNavigateUrlHref: function (href) {
			if (this.$navigateUrl) {
				if (href === "" || typeof href === "undefined") {
					href = "#";
				}
				this.$navigateUrl.attr("href", href);
			}
		},

		_editNode: function () {//edit node
			this._tree._editMode = true;
			this.$navigateUrl.hide();
			if (!this.$editArea) {
				this.$editArea = $("<input>").wijtextbox();
			}
			this.$editArea.val(this.$text.html());
			this.$editArea.insertBefore(this.$navigateUrl);
			this.$editArea.bind("blur", this, this._editionComplete);
			this.$editArea.focus();
		},

		_editionComplete: function (event) {
			var self = event.data, text;
			self._tree._editMode = false;
			if (self.$editArea) {
				text = self.$editArea.val();
				self.$editArea.remove();
			}
			self.$navigateUrl.show();
			self.$editArea = null;
			self._changeText(text);
		},

		_changeText: function (text) {
			var self = this, o = self.options;
			if (self.$text !== null && text !== "") {
				self.$text.text(text);
				o.text = text;
				self._tree._trigger("nodeTextChanged", null, self);
			}
		},

		/*behavior Methods*/
		_expandCollapseItem: function () {//access
			var self = this, o = self.options;
			if (!self._tree.options.disabled && !self._isClosestDisabled()) {
				if (self._hasChildren || o.hasChildren) {
					self._setExpanded(!o.expanded);
				}
			}
		},

		_expandNode: function (expand) {
			var self = this, treeOption = self._tree.options;
			if (!treeOption.disabled && !self._isClosestDisabled()) {
				if (expand) {
					if (treeOption.expandDelay > 0) {
						if (typeof self._expandTimer !== "undefined") {
							self._expandTimer = window.clearTimeout(self._expandTimer);
						}
						self._expandTimer = window.setTimeout(function () {
							self._expandNodeVisually();
						}, treeOption.expandDelay);
					}
					else {
						self._expandNodeVisually();
					}
				}
				else {
					if (treeOption.collapseDelay > 0) {
						self._collapseTimer = window.clearTimeout(self._collapseTimer);
						self._collapseTimer = window.setTimeout(function () {
							self._collapseNodeVisually();
						}, treeOption.collapseDelay);
					}
					else {
						self._collapseNodeVisually();
					}
				}
			}

		},

		_expandNodeVisually: function () {
			var self = this, nodes;
			if (self._tree.options.autoCollapse) {//autoCollapse
				nodes = self.element.siblings(":" + this.widgetBaseClass);
				$.each(nodes, function (i) {
					var widget = self._getNodeWidget(nodes[i]);
					if (widget.options.expanded) {
						widget._setExpanded(false);
					}
				});
			}
			if (self.options.collapsedIconClass !== "" &&
			self.options.expandedIconClass !== "") {
				self.$nodeImage.removeClass(self.options.collapsedIconClass)
				.addClass(self.options.expandedIconClass);
			}
			self._internalSetNodeClass(true);
			self._show();
		},

		_collapseNodeVisually: function () {
			var self = this;
			if (self.options.collapsedIconClass !== "" &&
			self.options.expandedIconClass !== "") {
				self.$nodeImage.removeClass(self.options.expandedIconClass)
				.addClass(self.options.collapsedIconClass);
			}
			self._internalSetNodeClass(false);
			self._hide();
		},

		_internalSetNodeClass: function (expanded) {
			this.$hitArea
			.removeClass('ui-icon ui-icon-triangle-1-se ui-icon-triangle-1-e')
			.addClass("ui-icon " +
			(expanded ? "ui-icon-triangle-1-se" : "ui-icon-triangle-1-e"));
		},

		_show: function () {
			this._animation(true);
		},

		_hide: function () {
			this._animation(false);
		},

		_animation: function (show) {
			var self = this, el = self.$nodes,
			animation = show ? "expandAnimation" : "collapseAnimation",
			event = show ? "nodeExpanded" : "nodeCollapsed";
			if (el) {
				if (self._tree.options[animation]) {
					if ($.effects && !!self._tree.options[animation].duration) {
						el[show ? "show" : "hide"](self._tree.options[animation].effect,
								{},
								self._tree.options[animation].duration,
								function () {
									self._tree._trigger(event, null, self);
								});
					} else {
						el[show ? "show" : "hide"](self._tree.options[animation].duration,
								function () {
									self._tree._trigger(event, null, self);
								});
					}
				}
				else {
					el[show ? "show" : "hide"]();
					self._tree._trigger(event, null, self);
				}
			}
		},

		_getBounds: function ($el) {//get top,left,height,width of element
			var h = $el.height(), w = $el.width(),
			t = $el.offset().top, l = $el.offset().left;
			return { h: h, w: w, t: t, l: l };
		},

		_isMouseInsideRect: function (p, b) {//whether mouse is over a element
			if (p.x < b.l || p.x >= b.l + b.w) {
				return false;
			}
			if (p.y <= b.t + 1 || p.y >= b.t + b.h) {
				/*fix 1px on the mouse out the element 
				(e.g. 31<30.98 now 31<30.98+1 maybe 
				pageY/PageX are int but left/top are float)*/
				return false;
			}
			return true;
		},

		_getNodeByMouseOn: function (p) {
			$("li").each(function () {
				var b = this._getBounds($(this));
				if ($.ui.isOver(p.y, p.x, b.t, b.l, b.h, b.w)) {
					return $(this);
				}
			});
			return null;
		},

		_drowTemplate: function (p, temp, targetEl) {
			var position = "unKnown",
			body = targetEl.is(".wijmo-wijtree-node") ?
			targetEl :
			targetEl.children(".wijmo-wijtree-node"),
			n = this._getBounds(body);
			temp.width(body.width());

			if (p.y > n.t && p.y < n.t + n.h / 2) {
				temp.offset({ left: n.l, top: n.t });
				position = "before";
			}
			else if (p.y > n.t + n.h / 2 && p.y < n.t + n.h) {
				temp.offset({ left: n.l, top: n.t + n.h });
				position = "after";
			}
			return position;
		},

		_beginDrag: function (e) {   //set draggable
			var self = this, $item = self.element, temp;
			temp = this._insertionTemplate = $("<div>")
			.addClass("wijmo-wijtree-insertion ui-state-default").hide();

			$item.draggable({
				cursor: "point",
				cursorAt: { top: 15, left: -25 },
				helper: function () {
					return $("<div>" + self.$navigateUrl.html() + "</div>")
					.addClass("ui-widget-header ui-corner-all");
				},
				start: function (event) {
					self._tree._isDragging = true;
					self._tree._trigger("nodeDragStarted", event, self);
					self._tree.widgetDom.prepend(self._insertionTemplate);
					$item.hide();
				},
				distance: $.browser.msie ? 1 : 10,
				//this curse a draggable error in IE 7.0/6.0
				handle: self.$navigateUrl,
				scope: "tree",
				drag: function (event) {
					var t = event.srcElement || event.originalEvent.target,
					targetEl = $(t), dropNode, p = { x: event.pageX, y: event.pageY };
					if (temp) {
						temp.hide();
					}
					if (targetEl) {
						dropNode = self._getNodeWidget(targetEl);
						if (dropNode) {
							if (targetEl.closest(".wijmo-wijtree-inner", self.element)
							.length) {
								self._dropTarget = dropNode;
								self._insertPosition = "end"; //end,after,before
							}
							else {
								temp.show();
								self._insertPosition =
								self._drowTemplate(p, temp, dropNode.element);
								self._dropTarget = dropNode;
							}
						}
					}
					self._tree._trigger("nodeDragging", event, self);
				},
				stop: function () {
					$item.show();
					temp.remove();
					self._dropTarget = null;
					self._insertPosition = "unKnown";
					self._resetDrag();
				}
			}).trigger(e);
			if ($.browser.mozilla) {
				self._setFocused(true);
			}
		},

		_resetDrag: function () {
			var self = this, nodes, i;
			if (!self._tree.options.allowDrag && self.element.data("draggable")) {
				self.element.draggable("destroy");
			}
			nodes = self._getField("nodes");
			for (i = 0; i < nodes.length; i++) {
				nodes[i]._resetDrag();
			}
		},

		_checkClick: function () {//check , uncheck, indeterminate
			var self = this, o = self.options;
			if (!self._tree.options.disabled && !self._isClosestDisabled()) {
				if (o.checked && self._checkState === "indeterminate") {
					self._checkState = "checked";
					self._checkItem();
				}
				else {
					self._checkState = o.checked ? "unChecked" : "checked";
					self._setChecked(!o.checked);
				}
				self._tree._trigger("nodeCheckChanged", null, self);
			}
		},

		_checkItem: function () {//access
			var self = this, autoCheck = false, tree = self._tree;
			if (tree === null || !tree.options.showCheckBoxes) {
				return;
			}
			if (tree.options.autoCheckNodes &&
			self._checkState !== "indeterminate") {
				autoCheck = true;
				self._changeCheckState(self.options.checked);
			}
			if (tree.options.allowTriState) {
				self._setParentCheckState();
			}
			self[self.options.checked ?
			"_checkNode" : "_unCheckNode"](autoCheck);
		},

		_checkNode: function (autoCheck) {
			//todo: add to tree._checkedNodes
			var self = this, o = self.options, nodes = this._getField("nodes"), i;
			if (self._checkState === "checked") {
				self.$checkBox.wijtreecheck("option", "checkState", "check");
				o.checkState = "checked";
			}
			else if (self._checkState === "indeterminate") {//todo: tristate Style
				self.$checkBox.wijtreecheck("option", "checkState", "triState");
				o.checkState = "indeterminate";
			}

			if (autoCheck) {
				for (i = 0; i < nodes.length; i++) {
					nodes[i]._checkNode(true);
				}
			}
		},

		_unCheckNode: function (autoCheck) {
			//todo: remove to tree._checkedNodes
			var nodes = this._getField("nodes"), o = this.options, i;
			this.$checkBox.wijtreecheck("option", "checkState", "unCheck");
			o.checkState = "unChecked";
			if (autoCheck) {
				for (i = 0; i < nodes.length; i++) {
					nodes[i]._unCheckNode(true);
				}
			}
		},

		_changeCheckState: function (checked) {
			var nodes = this._getField("nodes");
			$.each(nodes, function (i, node) {
				node.options.checked = checked;
				node.$nodeBody.attr("aria-checked", checked);
				node._checkState = checked ? "checked" : "unChecked";
				node._changeCheckState(checked);
			});
		},

		_setParentCheckState: function () {//set parent check state

			var owner = this._getOwner(), nodes, allChecked = true,
			hasChildrenChecked = false, triState = false, i, self = this;
			if (owner.element.is(":" + self.options.treeClass)) {
				return;
			}
			nodes = owner._getField("nodes");
			for (i = 0; i < nodes.length; i++) {
				if (nodes[i]._checkState === "indeterminate") {
					triState = true;
				}
				if (nodes[i].options.checked) {
					hasChildrenChecked = true;
				}
				else {
					allChecked = false;
				}
				if (!allChecked && hasChildrenChecked) {
					break;
				}
			}
			if (triState) {
				owner._checkState = "indeterminate";
				owner._setChecked(true);
			}
			else {
				if (hasChildrenChecked) {
					if (allChecked) {
						owner._checkState = "checked";
						owner._checkNode(false);
					}
					else {
						owner._checkState = "indeterminate";
					}
					owner._setChecked(true);
				}
				else {
					owner._checkState = "unChecked";
					owner._setChecked(false);
					owner._unCheckNode(false);
				}
			}
			owner._setParentCheckState();
		},

		/*Events*/
		_onKeyDown: function (event) {
			var el = $(event.target), self = this;
			if (el.closest(".wijmo-wijtree-inner", self.element).length > 0) {
				self._keyAction(event);
			}
		},

		_onClick: function (event) {
			var el = $(event.target), self = this;
			if (el.closest(".wijmo-checkbox", self.element).length > 0) {
				self._checkClick(event);
				event.preventDefault();
				event.stopPropagation();
			}
			else if (el.hasClass("ui-icon-triangle-1-se") ||
			el.hasClass("ui-icon-triangle-1-e")) {
				self._expandCollapseItem(event);
				event.preventDefault();
				event.stopPropagation();
			}
			else if (el.closest(".wijmo-wijtree-inner", self.element).length > 0) {
				self._click(event);
			}
		},

		_onMouseDown: function (event) {
			var el = $(event.target), node = event.data;
			if (node._tree.options.allowDrag) {//prepare for drag
				if (el.closest(".wijmo-wijtree-node", node.element).length > 0) {
					node._beginDrag(event);
				}
			}
		},

		_onMouseOver: function (event) {
			var el = $(event.target), self = this, rel = $(event.relatedTarget);
			if (el.closest(".wijmo-wijtree-inner", self.element).length > 0 &&
			(this._tree._overNode !== self || rel.is(':' + this.widgetBaseClass))) {
				self._mouseOver(event);
				this._tree._overNode = self;
			}
			self._mouseOverHitArea(event);
		},

		_onMouseOut: function (event) {
			var el = $(event.target), self = this,
			rel = $(event.relatedTarget), node = this._getNodeWidget(rel);
			if (el.closest(".wijmo-wijtree-inner", self.element).length > 0 &&
			(this._tree._overNode !== node || rel.is(':' + this.widgetBaseClass))) {
				self._mouseOut(event);
				if (!node) {
					this._tree._overNode = null;
				}
			}
			self._mouseOutHitArea(event);
		},

		_onFocus: function (event) {
			var el = $(event.target), self = this;
			if (el.closest(".wijmo-wijtree-inner", self.element).length > 0 &&
			!self._tree.options.disabled && !self._isClosestDisabled() &&
			!(el.hasClass("ui-icon-triangle-1-se") ||
			el.hasClass("ui-icon-triangle-1-e")) &&
			!el.closest(".wijmo-checkbox", self.element).length) {
				if (self._tree._focusNode) {
					self._tree._focusNode.$navigateUrl.blur();
				}
				self._focused = true;
				self._tree._focusNode = this;
				self.$inner.addClass("ui-state-focus");
			}
		},

		_onBlur: function (event) {
			var el = $(event.target), self = event.data;
			if (!self._tree.options.disabled && !self._isClosestDisabled()) {
				self._focused = false;
				if (el.closest(".wijmo-wijtree-inner", self.element).length > 0) {
					self.$inner.removeClass("ui-state-focus");
				}
				self._tree._trigger("nodeBlur", event, self);
			}
		},

		_click: function (event) {
			var self = this, o = self.options, tree = self._tree;
			if (!tree.options.disabled && !self._isClosestDisabled()) {
				if (!/^[#,\s]*$/.test(self._navigateUrl)) {
					return;
				}
				self._isClick = true;
				tree._ctrlKey = event.ctrlKey;
				if (o.selected && tree._ctrlKey) {
					self._setSelected(false);
				}
				else if (o.selected &&
				tree.options.allowEdit &&
				!self._isTemplate) {
					self._editNode();
				}
				else {
					self._setSelected(!o.selected);
				}
				if(!self._isTemplate) {
					event.preventDefault();
					event.stopPropagation();
				}
			}
			else {
				self._setNavigateUrlHref("");
			}
		},

		_selectNode: function (select, event) {
			var self = this, ctrlKey, idx;
			if (!self._tree.options.disabled &&
			!self._isClosestDisabled() && !self._tree._isDragging) {
				ctrlKey = self._tree._ctrlKey;
				if (ctrlKey) {
					idx = $.inArray(self, self._tree._selectedNodes);
					if (idx !== -1 && !select) {
						self._tree._selectedNodes.splice(idx, 1);
						self.$inner.removeClass("ui-state-active");
					}
				}
				else {
					$.each(self._tree._selectedNodes, function (i, n) {
						n.$inner.removeClass("ui-state-active");
						n.options.selected = false;
						n.$nodeBody.attr("aria-selected", false);
					});
					self._tree._selectedNodes = [];
				}
				if (select) {
					idx = $.inArray(self, self._tree._selectedNodes);
					if (idx === -1) {
						this._tree._selectedNodes.push(self);
					}
					self.$inner.addClass("ui-state-active");
				}
				else {
					self.$inner.removeClass("ui-state-active");
				}
				if (self._isClick) {
					self._tree._trigger("nodeClick", event, self);
				}
				self._isClick = false;
				self._tree._ctrlKey = false;
				self._tree._trigger("selectedNodeChanged", event, self);
			}
		},

		_keyAction: function (e) {
			var el = e.target, self = this;
			if (self._tree.options.disabled || self._isClosestDisabled()) {
				return;
			}
			if (el) {
				if (self._tree._editMode && e.keyCode !== $.ui.keyCode.ENTER) {
					return;
				}
				switch (e.keyCode) {
				case $.ui.keyCode.UP:
					self._moveUp();
					break;
				case $.ui.keyCode.DOWN:
					self._moveDown();
					break;
				case $.ui.keyCode.RIGHT:
					if (self._tree.options.showExpandCollapse) {
						self._moveRight();
					}
					break;
				case $.ui.keyCode.LEFT:
					if (self._tree.options.showExpandCollapse) {
						self._moveLeft();
					}
					break;
				case 83: //key s
					if (!self._tree._editMode && self._tree.options.allowSorting) {
						self.sortNodes();
					}
					break;
				case 113: //key f2
					if (self._tree.options.allowEdit) {
						self._editNode();
					}
					break;
				case 109: //key -
					if (self._tree.options.showExpandCollapse && this._expanded) {
						self._setExpanded(false);
					}
					break;
				case 107: //key +
					if (self._tree.options.showExpandCollapse && !this._expanded) {
						self._setExpanded(true);
					}
					break;
				case $.ui.keyCode.ENTER:
					if (self._tree._editMode) {
						e.data = self;
						self._editionComplete(e);
					}

					break;
				case $.ui.keyCode.SPACE: //check
					if (self._tree.options.showCheckBoxes) {
						self._checkState = self.options.checked ? "unChecked" : "checked";
						self._setChecked(!self.options.checked);
					}
					break;
				}
				self._customKeyDown(e.keyCode);
				if(!self._isTemplate) {
					e.preventDefault();
					e.stopPropagation();
				}
			}
		},

		_customKeyDown: function (keyCode) {

		},

		_prevNode: function (node) {
			if (node.element.prev().length > 0) {
				return node.element.prev().data(this.widgetName);
			}
		},

		_nextNode: function (node) {
			if (node.element.next().length > 0) {
				return node.element.next().data(this.widgetName);
			}
		},

		_getNextExpandedNode: function (node) {
			var nextNode = node, nextNodes = node._getField("nodes"), newNode;
			if (node._expanded && nextNodes.length > 0) {
				newNode = nextNodes[nextNodes.length - 1];
				if (newNode !== null) {
					nextNode = this._getNextExpandedNode(newNode);
				}
			}
			return nextNode;
		},

		_getNextNode: function (owner) {
			var nextNode = null, self = this;
			if (owner.element.is(":" + self.options.treeClass)) {
				return null;
			}
			nextNode = self._nextNode(owner);
			if (nextNode) {
				return nextNode;
			}
			return self._getNextNode(owner._getOwner());
		},

		_moveUp: function () {
			var level = this._getCurrentLevel(), prevNode = this._prevNode(this);
			if (!prevNode) {
				if (level > 0) {
					this._getOwner()._setFocused(true);
				}
			}
			else {
				this._getNextExpandedNode(prevNode)._setFocused(true);
			}
		},

		_moveDown: function () {//sometimes blur
			var nodes = this._getField("nodes"), nextNode, owner, pNextNode;
			if (this._expanded && nodes.length > 0) {
				nodes[0]._setFocused(true);
			}
			else {
				nextNode = this._nextNode(this);
				if (nextNode) {
					nextNode._setFocused(true);
				}
				else {
					owner = this._getOwner();
					pNextNode = this._getNextNode(owner);
					if (pNextNode) {
						pNextNode._setFocused(true);
					}
				}
			}
		},

		_moveLeft: function () {
			var nextNode = this._getOwner();
			if (this._expanded) {
				this._setExpanded(false);
			}
			else if (nextNode !== null &&
			!nextNode.element.is(":" + this.options.treeClass)) {
				nextNode._setFocused(true);
			}
		},

		_moveRight: function () {
			if (this._hasChildren) {
				if (!this._expanded) {
					this._setExpanded(true);
				}
				else {
					var nextNode = this._getField("nodes")[0];
					if (nextNode !== null) {
						nextNode._setFocused(true);
					}
				}
			}
		},

		_mouseOver: function (event) {
			var self = this, tree = self._tree;
			if (!tree.options.disabled &&
			!self._isClosestDisabled() && !tree._editMode) {
				self._mouseOverNode();
				if (!tree._isDragging) {
					tree._trigger("nodeMouseOver", event, self);
				}
			}
		},

		_mouseOut: function (event) {
			var self = this, tree = self._tree;
			if (!tree.options.disabled &&
			 !self._isClosestDisabled() && !tree._editMode) {
				self._mouseOutNode();
				if (!tree._isDragging) {
					tree._trigger("nodeMouseOut", event, self);
				}
			}
		},

		_mouseOverNode: function () {
			if (this.$inner !== null && !this._isOverNode) {
				this.$inner.addClass("ui-state-hover");
				this._isOverNode = true;
			}
		},

		_mouseOutNode: function () {
			if (this.$inner !== null && this._isOverNode) {
				this.$inner.removeClass("ui-state-hover");
				this._isOverNode = false;
			}
		},

		_mouseOverHitArea: function (event) {
			var bound, p, self = this, tree = self._tree;
			if (!tree.options.disabled && !self._isClosestDisabled()) {
				if (tree.options.expandCollapseHoverUsed) {
					if (self._hasChildren && !self._isOverHitArea) {
						bound = self._getBounds(self.element);
						p = { x: event.pageX, y: event.pageY };
						if (self._isMouseInsideRect(p, bound)) {
							self._isOverHitArea = true;
							self._setExpanded(true);
						}
					}
				}
			}
		},

		_mouseOutHitArea: function (event) {
			var p = { x: event.pageX, y: event.pageY }, bound,
			self = this, tree = self._tree;
			if (!tree.options.disabled && !self._isClosestDisabled()) {
				if (tree.options.expandCollapseHoverUsed) {
					if (self._hasChildren && !!self._isOverHitArea) {
						bound = self._getBounds(self.element);
						if (!self._isMouseInsideRect(p, bound)) {
							self._isOverHitArea = false;
							self._setExpanded(false);
						}
					}
					else if (self._getOwner().element.is(":" + self.widgetBaseClass)) {
						bound = self._getBounds(self._getOwner().element);
						if (!self._isMouseInsideRect(p, bound)) {
							self._getOwner()._isOverHitArea = false;
							self._getOwner()._setExpanded(false);
						}
					}
				}
			}
		},

		/*public methods*/
		destroy: function () {
			/// <summary>
			/// Destroy the node widget
			/// </summary>
			var self = this, $nodes;
			if (self.element.data("draggable")) {
				self.element.draggable("destroy");
			}
			if (self.$hitArea) {
				self.$hitArea.remove();
			}
			if (self.$checkBox) {
				self.$checkBox.remove();
			}
			if (self.$nodeImage) {
				self.$nodeImage.remove();
			}
			self.$navigateUrl.unwrap().unwrap()
			.removeClass("ui-state-default ui-state-active")
			.unbind("mousedown")
			.unbind("blur");
			$nodes = this.element.find("ul:first").show();
			$nodes.removeClass();

			$nodes.children("li").each(function () {
				var nodeWidget = self._getNodeWidget($(this));
				nodeWidget.destroy();
			});

			self.element.removeData("nodes")
			.removeData("owner")
			.removeData("widgetName")
			.removeClass();

			$.Widget.prototype.destroy.apply(this);
		},

		add: function (node, position) {
			/// <summary>
			/// Adds a node to the element.
			/// </summary>
			/// <param name="node" type="String,Object">
			/// which node to be added
			/// 1.markup html.such as "<li><a>node</a></li>" as a node.
			/// 2.wijtreenode widget.
			/// 3.object options according to the options of wijtreenode.
			/// </param>
			/// <param name="position" type="Int">
			/// the position to insert at
			/// </param>
			var nodeWidget = null, $node, nodes, self = this,
			itemDom = "<li><a href='{0}'>{1}</a></li>", originalLength;
			if (typeof node === "string") {
				$node = $(itemDom.replace(/\{0\}/, "#")
				.replace(/\{1\}/, node));
				self._createNodeWidget($node);
				nodeWidget = $node.data($node.data("widgetName"));
			}
			else if (node.jquery) {
				if (!node.data("widgetName")) {
					self._createNodeWidget(node);
				}
				nodeWidget = node.data(node.data("widgetName"));
			}
			else if (node.nodeType) {
				$node = $(node);
				self._createNodeWidget($node);
				nodeWidget = $node.data($node.data("widgetName"));
			}
			else if ($.isPlainObject(node)) {
				$node = $(itemDom.replace(/\{0\}/, node.url)
				.replace(/\{1\}/, node.text)); //node
				self._createNodeWidget($node, node);
				nodeWidget = $node.data($node.data("widgetName"));
			}

			if (nodeWidget === null) {
				return;
			}
			nodes = self._getField("nodes");
			if (!position || position > nodes.length) {
				if (position !== 0) {
					position = nodes.length;
				}
			}

			nodeWidget._setField("owner", self);
			originalLength = nodes.length;
			if (!self.$nodes) {
				self.$nodes = $("<ul></ul>")
				.addClass("wijmo-wijtree-list ui-helper-reset wijmo-wijtree-child");
				self.element.append(self.$nodes);
			}
			if (originalLength > 0 && originalLength !== position) {
				if (nodeWidget.element.get(0) !== nodes[position].element.get(0)) {
					nodeWidget.element.insertBefore(nodes[position].element);
				}
			}
			else {
				self.$nodes.append(nodeWidget.element);
			}
			self._changeCollection(position, nodeWidget);
			self._collectionChanged("add");

		},

		remove: function (node) {
			/// <summary>
			/// Removes a node of this element.
			/// </summary>
			/// <param name="node" type="String,Object">
			/// which node to be removed
			/// 1.wijtreenode widget.
			/// 2.the index of which node you determined to remove.
			/// </param>
			var idx = -1, nodeWidget, self = this,
			nodes = this._getField("nodes");
			if (node.jquery) {
				idx = node.index();
			}
			else if (typeof node === "number") {
				idx = node;
			}
			if (idx < 0 && idx >= nodes.length) {
				return;
			}
			nodeWidget = nodes[idx];
			nodeWidget.element.detach();
			self._changeCollection(idx);
			self._collectionChanged("remove");

		},

		_changeCollection: function (idx, nodeWidget) {
			var nodes = this._getField("nodes");
			if (nodeWidget) {
				nodes.splice(idx, 0, nodeWidget);
			}
			else {
				nodes.splice(idx, 1);
			}
		},

		sortNodes: function () {
			/// <summary>
			/// Sorts the child nodes of the node.
			/// </summary>
			var nodes = this._getField("nodes");
			this._sort();
			$.each(nodes, function (i, childNode) {
				childNode._index = i;
				childNode._insertBefore(i);
			});
			this._refreshNodesClass();
		},

		check: function (value) {
			/// <summary>
			/// Checks or unchecks the node.
			/// </summary>
			/// <param name="value" type="Boolean">
			/// check or uncheck the node.
			/// </param>
			this._setOption("checked", value);
		},

		select: function (value) {
			/// <summary>
			/// Selects or unselects the node.
			/// </summary>
			/// <param name="value" type="Boolean">
			/// select or unselect the node.
			/// </param>
			this._setOption("selected", value);
		},

		expand: function () {
			/// <summary>
			/// Expands the node
			/// </summary>
			this._setOption("expanded", true);
		},

		collapse: function () {
			/// <summary>
			/// Collapses the node
			/// </summary>
			this._setOption("expanded", false);
		},

		/*region prvite Methods*/
		_insertBefore: function (i) {
			var $lis = this.element.parent().children("li");
			if (this.element.index() !== i) {
				this.element.insertBefore($lis.eq(i));
			}
		},

		_sort: function () {
			var nodes = this._getField("nodes");
			if (this._isSorted) {
				if (!this._isDecsSort) {
					nodes.sort(this._compare2NodeTextAcs);
					this._isDecsSort = true;
				}
				else {
					nodes.sort(this._compare2NodeTextDesc);
					this._isDecsSort = false;
				}
			}
			else {
				nodes.sort(this._compare2NodeTextAcs);
				this._isSorted = true;
				this._isDecsSort = true;
			}
		},

		_compare2NodeTextAcs: function (a, b) {
			if (a !== null && b !== null) {
				return a._text.localeCompare(b._text);
			}
		},

		_compare2NodeTextDesc: function (a, b) {
			if (a !== null && b !== null) {
				return -1 * a._text.localeCompare(b._text);
			}
		},

		_collectionChanged: function () {
			this._hasChildren = this._getChildren();
			this._initNodeClass();
			this._refreshNodesClass();
		},

		_refreshNodesClass: function () {
			var nodes = this._getField("nodes"), i;
			for (i = 0; i < nodes.length; i++) {
				nodes[i]._initNodeClass();
			}
		},

		_setChecked: function (value) {
			var self = this;
			if (self.options.checked === value &&
			self._checkState !== "indeterminate") {
				return;
			}
			self.options.checked = value;
			self.$nodeBody.attr("aria-checked", value);
			this._checkItem();
		},

		_isClosestDisabled: function () {
			var self = this;
			if (self.element.closest(".wijmo-wijtree-disabled," +
			".wijmo-wijtreenode-disabled", self._tree.element).length) {
				return true;
			}
			return false;
		},

		_setExpanded: function (value) {
			var self = this;
			if (self._expanded === value) {
				return;
			}
			if (self._hasChildren) {
				self._expanded = value;
				self.options.expanded = value;
				self.$nodeBody.attr("aria-expanded", value);
				self._expandNode(value);
			}
		},

		_setFocused: function (value) {
			if (value) {
				this.$navigateUrl.focus();
				if ($.browser.msie || $.browser.webkit) {
					this._setFocusNode();
				}
			}
			else {
				this.$navigateUrl.blur();
			}
		},

		_setFocusNode: function () {
			if (this._tree._focusNode && $.browser.webkit) {
				this._tree._focusNode.$navigateUrl.blur();
			}
			this._focused = true;
			this._tree._focusNode = this;
			this.$inner.addClass("ui-state-focus");
		},

		_setToolTip: function (value) {
			if (value.length) {
				this.element.attr("title", value);
			}
			else {
				this.element.removeAttr("title");
			}
		},

		_setText: function (value) {
			if (this._text !== value && value.length) {
				this._text = value;
				this._changeText(value);
			}
		},

		_setSelected: function (value) {
			var self = this, o = self.options;
			if (o.selected !== value) {
				o.selected = value;
				self.$nodeBody.attr("aria-selected", value);
				self._selectNode(value);
				self._setFocused(value);
			}
		},

		_setCheckBoxes: function (value) {
			var self = this;
			if (self.$checkBox) {
				self.$checkBox[value ? 'show' : 'hide']();
			}
			if (self.$nodes) {
				self.$nodes.children("li").each(function () {
					var nodeWidget = self._getNodeWidget($(this));
					if (nodeWidget !== null) {
						nodeWidget._setCheckBoxes(value);
					}
				});
			}
		},

		_setHitArea: function (value) {
			var self = this;
			if (self._hasChildren)//todo: initnode class
			{
				if (value) {
					self._initNodeClass();
					if (self.$hitArea) {
						self.$hitArea.show();
					}
				}
				else {
					self._expanded = true;
					self.options.expanded = true;
					self.$nodeBody.attr("aria-expanded", true);
					if (self.$nodes) {
						self.$nodes.show();
					}
					self._initNodeClass();
					if (self.$hitArea) {
						self.$hitArea.hide();
					}
				}
			}
			if (self.$nodes) {
				self.$nodes.children("li").each(function () {
					var nodeWidget = self._getNodeWidget($(this));
					if (nodeWidget !== null) {
						nodeWidget._setHitArea(value);
					}
				});
			}
		},

		_getOwner: function () {
			return this._getField("owner");
		},

		_getTree: function () {
			var owner = this._getOwner();
			if (owner) {
				if (owner.element.is(":" + this.options.treeClass)) {
					return owner;
				}
				else {
					return owner._getTree();
				}
			}
			return null;
		},

		_getChildren: function () {
			return this.element.find(">ul:first>li").length > 0 &&
			this.element.children("ul:first");
		},

		_getNodeWidget: function (el) {
			var node = this._getNodeByDom(el), widget;
			if (node.length > 0) {
				widget = node.data(node.data("widgetName"));
				return widget;
			}
			return null;
		},

		_createNodeWidget: function ($li, options) {
			if ($.fn.wijtreenode) {
				$li.data("owner", this);
				if (!!options && $.isPlainObject(options)) {
					$.extend(options, { treeClass: this.options.treeClass });
					$li.wijtreenode(options);
				}
				else {
					$li.wijtreenode({ treeClass: this.options.treeClass });
				}
			}
			return $li;
		},

		_getNodeByDom: function (el) {//Arg :Dom Element
			return $(el).closest(":" + this.widgetBaseClass);
		},

		_getCurrentLevel: function () {
			return this.element.parentsUntil(":" + this.options.treeClass).length - 1;
		},

		_getField: function (key) {
			return this.element.data(key);
		},

		_setField: function (key, value) {
			return this.element.data(key, value);
		}
	});
} (jQuery));

(function ($) {//check box for wijtree
	var checkClass = "ui-icon ui-icon-check",
	triStateClass = "ui-icon ui-icon-stop";
	$.widget("wijmo.wijtreecheck", {
		options: {
			checkState: "unCheck" //"check","triState"
		},
		_create: function () {
			var self = this, o = this.options;
			if (self.element.is("div")) {
				self.element.addClass("wijmo-checkbox ui-widget");
				self.$icon = $("<span>");
				self.$icon.addClass("wijmo-checkbox-icon");
				if (o.checkState === "check") {
					self.$icon.addClass("ui-icon ui-icon-check");
				}
				else if (o.checkState === "triState") {
					self.$icon.addClass("ui-icon ui-icon-stop");
				}
				self.$body = $('<div></div>')
				.addClass("wijmo-checkbox-box ui-widget ui-corner-all ui-state-default")
				.css({ position: "relative" }).append(self.$icon);
				self.element.append(self.$body);
				self.element.bind("mouseover.wijtreecheck", function () {
					if (!self.options.disabled) {
						self.$body.removeClass("ui-state-default")
						.addClass("ui-state-hover");
					}
				}).bind("mouseout.wijtreecheck", function () {
					if (!self.options.disabled) {
						self.$body.removeClass("ui-state-hover")
						.not(".ui-state-focus").addClass("ui-state-default");
					}
				});
			}
		},

		_setOption: function (key, value) {
			var self = this;
			if (key === "checkState") {
				if (value === "unCheck") {
					self.$body.removeClass("ui-state-active");
					self.$icon.removeClass("ui-icon ui-icon-check " +
					"ui-icon-stop ui-state-active");
				}
				else if (value === "check") {
					self.$body.addClass("ui-state-active");
					self.$icon.removeClass(triStateClass).addClass(checkClass);
				}
				else if (value === "triState") {
					self.$body.addClass("ui-state-active");
					self.$icon.removeClass(checkClass).addClass(triStateClass);
				}
			}
			$.Widget.prototype._setOption.apply(self, arguments);
		},

		destory: function () {
			this.element.children().remove();
			this.element.removeClass("wijmo-checkbox ui-widget");
			$.Widget.prototype.destroy.apply(this);
		}
	});
} (jQuery));
/*globals jQuery, window, XMLHttpRequest*/

/*
 * 
 * Wijmo Library 1.4.0
 * http://wijmo.com/
 * 
 * Copyright(c) ComponentOne, LLC.  All rights reserved.
 * 
 * Dual licensed under the Wijmo Commercial or GNU GPL Version 3 licenses.
 * licensing@wijmo.com
 * http://www.wijmo.com/license
 * 
 * 
 * Wijmo Upload widget.
 * 
 * Depends:
 *     jquery.ui.core.js
 *     jquery.ui.widget.js
 */

(function ($) {
	"use strict";
	var uploadClass = "wijmo-wijupload",
		uploadFileRowClass = "wijmo-wijupload-fileRow",
		isUploadFileRow = "." + uploadFileRowClass,
		uploadFilesListClass = "wijmo-wijupload-filesList",
		uploadCommandRowClass = "wijmo-wijupload-commandRow",
		uploadUploadAllClass = "wijmo-wijupload-uploadAll",
		uploadCancelAllClass = "wijmo-wijupload-cancelAll",
		uploadButtonContainer = "wijmo-wijupload-buttonContainer",
		uploadUploadClass = "wijmo-wijupload-upload",
		isUploadUpload = "." + uploadUploadClass,
		uploadCancelClass = "wijmo-wijupload-cancel",
		isUploadCancel = "." + uploadCancelClass,
		uploadFileClass = "wijmo-wijupload-file",
		uploadProgressClass = "wijmo-wijupload-progress",
		uploadLoadingClass = "wijmo-wijupload-loading",
		uiContentClass = "ui-widget-content",
		uiCornerClass = "ui-corner-all",
		uiHighlight = "ui-state-highlight",
		wijuploadXhr,
		wijuploadFrm;

	wijuploadXhr = function (uploaderId, fileRow, action) {

		var uploader,
			inputFile = $("input", fileRow),
			xhr = new XMLHttpRequest(),

			_getFileName = function (fileName) {
				if (fileName.indexOf("\\") > -1) {
					fileName = fileName.substring(fileName.lastIndexOf("\\") + 1);
				}
				return fileName;
			},

			_upload = function (xhr, iptFile) {
				var name = _getFileName(iptFile.val());

				xhr.open("POST", action, true);
				xhr.setRequestHeader("Wijmo-RequestType", "XMLHttpRequest");
				xhr.setRequestHeader("Cache-Control", "no-cache");
				xhr.setRequestHeader("Wijmo-FileName", name);
				xhr.setRequestHeader("Content-Type", "application/octet-stream");
				xhr.send(iptFile.get(0).files[0]);
			},

			_cancel = function (xhr) {
				if (xhr) {
					xhr.abort();
					xhr = null;
				}
			},

			_destroy = function (xhr) {
				if (xhr) {
					xhr = null;
				}
			},
			Uploader;

		Uploader = function () {
			var self = this;
			self.fileRow = fileRow;
			self.xhr = xhr;
			self.inputFile = inputFile;
			self.upload = function () {
				_upload(xhr, inputFile);
			};
			self.cancel = function () {
				_cancel(xhr);
				if ($.isFunction(self.onCancel)) {
					self.onCancel();
				}
			};
			self.destroy = function () {
				_destroy(xhr);
			};
			self.updateAction = function (act) {
				action = act;
			};
			self.onCancel = null;
			self.onComplete = null;
			self.onProgress = null;


			xhr.upload.onprogress = function (e) {
				if (e.lengthComputable) {
					var obj;
					if ($.isFunction(self.onProgress)) {
						obj = {
							supportProgress: true,
							loaded: e.loaded,
							total: e.total,
							fileName: _getFileName(inputFile.val())
						};
						self.onProgress(obj);
					}
				}
			};


			xhr.onreadystatechange = function (e) {
				if (xhr.readyState === 4) {
					var response = xhr.responseText,
						obj;
					if ($.isFunction(self.onComplete)) {
						obj = {
							e: e,
							response: response,
							supportProgress: true
						};
						self.onComplete(obj);
					}
				}
			};
		};
		uploader = new Uploader();
		return uploader;
	};

	wijuploadFrm = function (uploaderId, fileRow, action) {
		var uploader,
			inputFile = $("input", fileRow),
			inputFileId = inputFile.attr("id"),
			formId = "wijUploadForm_" + uploaderId,
			form = $("#" + formId),
			iframeId = "wijUploadIfm_" + inputFileId,
			isFirstLoad = true,
			iframe = $("<iframe id=\"" + iframeId + "\" name=\"" + iframeId + "\">"),
		//	ifm = $("<iframe src=\"javascript:false;\" id=\"" + 
		// id + "\" name=\"" + id + "\">");
		//"javascript".concat(":false;")
		//src="javascript:false;" removes ie6 prompt on https

			_upload = function (ifm, iptFile) {
				form.empty();
				form.attr("target", ifm.attr("name"));
				if (iptFile) {
					iptFile.parent().append(iptFile.clone());
					form.append(iptFile);
				}
				form.submit();
			},

			_cancel = function (ifm) {
				// to cancel request set src to something else
				// we use src="javascript:false;" because it doesn't
				// trigger ie6 prompt on https
				ifm.attr("src", "javascript".concat(":false;"));
			},

			_destroy = function (ifm, removeForm) {
				if (removeForm && form) {
					form.remove();
					form = null;
				}
				if (ifm) {
					ifm.remove();
					ifm = null;
				}
			},
			Uploader;

		if (form.length === 0) {
			form = $("<form method=\"post\" enctype=\"multipart/form-data\"></form>");
			form
				.attr("action", action)
				.attr("id", formId)
				.attr("name", formId)
				.appendTo("body");
		}
		iframe.css("position", "absolute")
			.css("top", "-1000px")
			.css("left", "-1000px");
		iframe.appendTo("body");

		Uploader = function () {
			var self = this;
			self.fileRow = fileRow;
			self.iframe = iframe;
			self.inputFile = inputFile;
			self.upload = function () {
				var obj;
				_upload(iframe, inputFile);
				if ($.isFunction(self.onProgress)) {
					obj = {
						supportProgress: false,
						loaded: 1,
						total: 1
					};
					self.onProgress(obj);
				}
			};
			self.doPost = function () {
				_upload(iframe);
			};
			self.cancel = function () {
				_cancel(iframe);
				if ($.isFunction(self.onCancel)) {
					self.onCancel();
				}
			};
			self.updateAction = function (act) {
				action = act;
				form.attr("action", act);
			};
			self.destroy = function (removeForm) {
				_destroy(iframe, removeForm);
			};
			self.onCancel = null;
			self.onComplete = null;
			self.onProgress = null;

			iframe.bind("load", function (e) {
				if (!$.browser.safari) {
					if (isFirstLoad) {
						isFirstLoad = false;
						return;
					}
				}
				if (iframe.attr("src") === "javascript".concat(":false;")) {
					return;
				}
				var target = e.target,
					response,
					doc,
					obj;
				try {
					doc = target.contentDocument ?
						target.contentDocument : window.frames[0].document;
					//if (doc.readyState && doc.readyState !== "complete") {
					//	return;
					//}
					if (doc.XMLDocument) {
						response = doc.XMLDocument;
					} else if (doc.body) {
						response = doc.body.innerHTML;
					} else {
						response = doc;
					}
					if ($.isFunction(self.onComplete)) {
						obj = {
							e: e,
							response: response,
							supportProgress: false
						};
						self.onComplete(obj);
					}
				} catch (ex) {
					response = "";
				} finally {
					//iframe.unbind("load");
				}
			});
		};
		uploader = new Uploader();
		return uploader;
	};

	$.widget("wijmo.wijupload", {

		options: {
			/// <summary>
			/// The server side handler which handle the post request.
			/// Type:String.
			/// Default:"".
			/// Code example:$(".selector","action", "upload.php").
			/// </summary>
			action: "",
			/// <summary>
			/// The value indicates whether to submit file as soon as it's selected.
			/// Type:String.
			/// Default:"".
			/// Code example:$(".selector","autoSubmit", true).
			/// </summary>
			autoSubmit: false,
			/// <summary>
			/// Occurs when user selects a file.  This event can be cancelled.
			/// "return false;" to cancel the event.
			/// Default: null.
			/// Type: Function.
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains the input file.  
			///	</param>
			change: null,
			/// <summary>
			/// Occurs before the file is uploaded.  This event can be cancelled. 
			/// "return false;" to cancel the event.
			/// Default: null.
			/// Type: Function.
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains the input file.  
			///	</param>
			upload: null,
			/// <summary>
			/// Occurs when click the uploadAll button.  This event can be cancelled. 
			/// "return false;" to cancel the event.
			/// Default: null.
			/// Type: Function.
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			totalUpload: null,
			/// <summary>
			/// Occurs when file uploading. 
			/// Default: null.
			/// Type: Function.
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains the file info,loadedSize and totalSize  
			///	</param>
			progress: null,
			/// <summary>
			/// Occurs when click the uploadAll button adn file uploading. 
			/// Default: null.
			/// Type: Function.
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains the loadedSize and totalSize  
			///	</param>
			totalProgress: null,
			/// <summary>
			/// Occurs when file upload is complete. 
			/// Default: null.
			/// Type: Function.
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			/// <param name="data" type="Object">
			/// An object that contains the file info.  
			///	</param>
			complete: null,
			/// <summary>
			/// Occurs when click the uploadAll button and file upload is complete. 
			/// Default: null.
			/// Type: Function.
			/// </summary>
			/// <param name="e" type="eventObj">
			/// jQuery.Event object.
			///	</param>
			totalComplete: null
		},

		_create: function () {
			var self = this,
				o = self.options,
				id = new Date().getTime(),
				useXhr = self.supportXhr();

			self.filesLen = 0;
			self.totalUploadFiles = 0;
			self.useXhr = useXhr;
			self.id = id;
			self.element.addClass(uploadClass);

			self._createContainers();
			self._createUploadButton();
			self._createFileInput();
			self._bindEvents();

			//Add for support disabled option at 2011/7/8
			if (o.disabled) {
				self.disable();
			}
			//end for disabled option
		},

		_setOption: function (key, value) {
			var self = this;

			$.Widget.prototype._setOption.apply(this, arguments);

			//Add for support disabled option at 2011/7/8
			if (key === "disabled") {
				self._handleDisabledOption(value, self.element);
			}
			//end for disabled option
		},

		_handleDisabledOption: function (disabled, ele) {
			var self = this;

			if (disabled) {
				if (!self.disabledDiv) {
					self.disabledDiv = self._createDisabledDiv(ele);
				}
				self.disabledDiv.appendTo("body");
			}
			else {
				if (self.disabledDiv) {
					self.disabledDiv.remove();
					self.disabledDiv = null;
				}
			}
		},

		_createDisabledDiv: function (outerEle) {
			var self = this,
			//Change your outerelement here
				ele = outerEle ? outerEle : self.element,
				eleOffset = ele.offset(),
				disabledWidth = ele.outerWidth(),
				disabledHeight = ele.outerHeight();

			return $("<div></div>")
						.addClass("ui-disabled")
						.css({
							"z-index": "99999",
							position: "absolute",
							width: disabledWidth,
							height: disabledHeight,
							left: eleOffset.left,
							top: eleOffset.top
						});
		},

		destroy: function () {
			var self = this;
			self.element.removeClass(uploadClass);
			self.element.undelegate(self.widgetName);
			self.input.remove();
			self.addBtn.remove();
			self.filesList.remove();
			self.commandRow.remove();

			if (self.uploaders) {
				$.each(self.uploaders, function (idx, uploader) {
					if (uploader.destroy) {
						uploader.destroy(true);
					}
					uploader = null;
				});
				self.uploaders = null;
			}

			//Add for support disabled option at 2011/7/8
			if (self.disabledDiv) {
				self.disabledDiv.remove();
				self.disabledDiv = null;
			}
			//end for disabled option
		},

		supportXhr: function () {
			var useXhr = false;
			if (typeof (new XMLHttpRequest().upload) === "undefined") {
				useXhr = false;
			} else {
				useXhr = true;
			}
			return useXhr;
		},

		_createContainers: function () {
			var self = this,
				filesList = $("<ul>").addClass(uploadFilesListClass)
					.appendTo(self.element),
				commandRow = $("<div>").addClass(uploadCommandRowClass)
					.appendTo(self.element);
			self.filesList = filesList;
			commandRow.hide();
			self.commandRow = commandRow;
			self._createCommandRow(commandRow);
		},

		_createCommandRow: function (commandRow) {
			var uploadAllBtn = $("<a>").attr("href", "#")
					.text("uploadAll")
					.addClass(uploadUploadAllClass)
					.button({
						icons: {
							primary: "ui-icon-circle-arrow-n"
						},
						label: "Upload All"
					}),
				cancelAllBtn = $("<a>").attr("href", "#")
					.text("cancelAll")
					.addClass(uploadCancelAllClass)
					.button({
						icons: {
							primary: "ui-icon-cancel"
						},
						label: "Cancel All"
					});
			commandRow.append(uploadAllBtn).append(cancelAllBtn);
		},

		_createUploadButton: function () {
			var self = this,
				addBtn = $("<a>").attr("href", "#").button({
					label: "Upload files"
				});
			addBtn.mousemove(function (e) {
				if (self.input) {
					var pageX = e.pageX,
						pageY = e.pageY;
					self.input.offset({
						left: pageX + 10 - self.input.width(),
						top: pageY + 10 - self.input.height()
					});
				}
			});
			self.addBtn = addBtn;
			self.element.prepend(addBtn);
		},

		_createFileInput: function () {
			var self = this,
				addBtn = self.addBtn,
				addBtnOffset = addBtn.offset(),
				id = "wijUpload_" + self.id + "_input" + self.filesLen,
				fileInput = $("<input>").attr("type", "file").prependTo(self.element);
			self.filesLen++;
			fileInput.attr("id", id)
				.attr("name", id)
				.css("position", "absolute")
				.offset({
					left: addBtnOffset.left + addBtn.width() - fileInput.width(),
					top: addBtnOffset.top
				})
				.css("z-index", "9999")
				.css("opacity", 0)
				.height(addBtn.height())
				.css("cursor", "pointer");

			self.input = fileInput;
			fileInput.bind("change", function (e) {
				var fileRow,
					uploadBtn;
				if (self._trigger("change", e, $(this)) === false) {
					return false;
				}
				self._createFileInput();
				fileRow = self._createFileRow($(this));
				if (self.options.autoSubmit) {
					uploadBtn = $(isUploadUpload, fileRow);
					if (uploadBtn) {
						uploadBtn.click();
					}
				}
				fileInput.unbind("change");
			});
			self.uploadAll = false;
		},

		_createFileRow: function (uploadFile) {
			var self = this,
				fileRow = $("<li>"),
				fileName = uploadFile.val(),
				file,
				progress,
				fileRows,
				buttonContainer = $("<span>").addClass(uploadButtonContainer),
				uploadBtn = $("<a>").attr("href", "#")
					.text("upload")
					.addClass(uploadUploadClass)
					.button({
						text: false,
						icons: {
							primary: "ui-icon-circle-arrow-n"
						},
						label: "upload"
					}),
				cancelBtn = $("<a>").attr("href", "#")
					.text("cancel")
					.addClass(uploadCancelClass)
					.button({
						text: false,
						icons: {
							primary: "ui-icon-cancel"
						},
						label: "cancel"
					});
			fileRow.addClass(uploadFileRowClass)
				.addClass(uiContentClass)
				.addClass(uiCornerClass);
			fileRow.append(uploadFile);
			uploadFile.hide();
			file = $("<span>" + self._getFileName(fileName) + "</span>")
				.addClass(uploadFileClass)
				.addClass(uiHighlight)
				.addClass(uiCornerClass);
			fileRow.append(file);
			fileRow.append(buttonContainer);
			progress = $("<span />").addClass(uploadProgressClass);
			buttonContainer.append(progress);
			buttonContainer.append(uploadBtn).append(cancelBtn);
			fileRow.appendTo(self.filesList);

			fileRows = $(isUploadFileRow, self.element);
			if (fileRows.length) {
				self.commandRow.show();
				self._createUploader(fileRow);
				self._resetProgressAll();
			}
			return fileRow;
		},

		_createUploader: function (fileRow) {
			var self = this,
				inputFile = $("input", fileRow),
				action = self.options.action,
				uploader;
			if (self.useXhr) {
				uploader = wijuploadXhr(self.id, fileRow, action);
			} else {
				uploader = wijuploadFrm(self.id, fileRow, action);
			}
			uploader.onCancel = function () {
				var t = this,
					uploader = self.uploaders[t.inputFile.attr("id")];
				self._trigger("cancel", null, t.inputFile);
				self.totalUploadFiles--;
				if (self.totalUploadFiles === 0 && self.uploadAll) {
					self._trigger("totalComplete");
				}
			}
			if (self._wijUpload()) {
				uploader.onProgress = function (obj) {
					var progressSpan = $("." + uploadProgressClass, this.fileRow);
					if (obj.supportProgress) {
						progressSpan.html(Math.round(1000 * obj.loaded /
							obj.total) / 10 + "%");
						self._trigger("progress", null, {
							sender: obj.fileName,
							loaded: obj.loaded,
							total: obj.total
						});
						self._progressTotal(obj.fileName, obj.loaded);
					} else {
						progressSpan.addClass(uploadLoadingClass);
					}
				};
				uploader.onComplete = function (obj) {
					var t = this,
						uploader = self.uploaders[t.inputFile.attr("id")],
						fileName = self._getFileName(t.inputFile.val()),
						fileSize = self._getFileSize(t.inputFile[0]),
						progressSpan = $("." + uploadProgressClass, t.fileRow);
					self._trigger("complete", obj.e, t.inputFile);
					progressSpan.removeClass(uploadLoadingClass);
					progressSpan.html("100%");
					self._removeFileRow(t.fileRow, uploader);
					self._progressTotal(fileName, fileSize);
					self.totalUploadFiles--;
					if (self.totalUploadFiles === 0 && self.uploadAll) {
						self._trigger("totalComplete", obj.e);
					}
				};
			}
			if (typeof (self.uploaders) === "undefined") {
				self.uploaders = {};
			}
			self.uploaders[inputFile.attr("id")] = uploader;
		},

		_progressTotal: function (fileName, loadedSize) {
			var self = this,
				progressAll = self.progressAll,
				loaded,
				total;
			if (!self.uploadAll) {
				return;
			}
			if (progressAll && progressAll.loadedSize) {
				progressAll.loadedSize[fileName] = loadedSize;
				loaded = self._getLoadedSize(progressAll.loadedSize);
				total = progressAll.totalSize;
			}
			self._trigger("totalProgress", null, {
				loaded: loaded,
				total: total
			});
		},

		_getLoadedSize: function (loadedSize) {
			var loaded = 0;
			$.each(loadedSize, function (key, value) {
				loaded += value;
			});
			return loaded;
		},

		_getTotalSize: function () {
			var self = this,
				total = 0;
			if (self.uploaders) {
				$.each(self.uploaders, function (key, uploader) {
					total += self._getFileSize(uploader.inputFile[0]);
				})
			}
			return total;
		},

		_resetProgressAll: function () {
			this.progressAll = {
				totalSize: 0,
				loadedSize: {}
			};
		},

		_wijUpload: function () {
			//return this.widgetName === "wijupload";
			return true;
		},

		_wijcancel: function (fileInput) {

		},

		_upload: function (fileRow) {
		},

		_bindEvents: function () {
			var self = this,
				progressAll = self.progressAll;
			self.element.delegate(isUploadCancel, "click." + self.widgetName,
				function (e) {
					var cancelBtn = $(this),
						fileRow = cancelBtn.parents(isUploadFileRow),
						fileInput = $("input", fileRow[0]),
						uploader = self.uploaders[fileInput.attr("id")];

					/*
					if (!self._wijUpload()) {
						self._wijcancel(fileInput);
						if (uploader) {
							uploader.cancel();
						}
					}
					*/
					self._wijcancel(fileInput);
					if (self._wijUpload() && uploader) {
						uploader.cancel();
					}

					if (progressAll) {
						progressAll.totalSize -= self._getFileSize(fileInput[0]);
						if (progressAll.loadedSize[fileInput.val()]) {
							delete progressAll.loadedSize[fileInput.val()];
						}
					}
					self._removeFileRow(fileRow, uploader);
				});
			self.element.delegate(isUploadUpload, "click." + self.widgetName,
				function (e) {
					var uploadBtn = $(this),
						fileRow = uploadBtn.parents(isUploadFileRow),
						fileInput = $("input", fileRow[0]),
						uploader = self.uploaders[fileInput.attr("id")];
					if (self._trigger("upload", e, fileInput) === false) {
						return false;
					}
					self.totalUploadFiles++;
					self._upload(fileRow);
					if (uploader && self._wijUpload()) {
						uploader.upload();
					}
				});
			self.element.delegate("." + uploadUploadAllClass, "click." + self.widgetName,
				function (e) {
					self.uploadAll = true;
					if (!self.progressAll) {
						self._resetProgressAll();
					}
					if (self._trigger("totalUpload", e, null) === false) {
						return false;
					}
					self.progressAll.totalSize = self._getTotalSize();
					self._wijuploadAll($(isUploadUpload, self.filesList[0]));
					if (self._wijUpload()) {
						$(isUploadUpload, self.filesList[0]).each(function (idx, uploadBtn) {
							$(uploadBtn).click();
						});
					}
				});
			self.element.delegate("." + uploadCancelAllClass, "click." + self.widgetName,
				function (e) {
					self._resetProgressAll();
					$(isUploadCancel, self.filesList[0]).each(function (idx, cancelBtn) {
						$(cancelBtn).click();
					});
				});
		},

		_wijuploadAll: function (uploadBtns) {
		},
		
		_wijFileRowRemoved: function (fileRow) {
		},

		_removeFileRow: function (fileRow, uploader) {
			var self = this,
				inputFileId,
				files;
			if (uploader) {
				inputFileId = uploader.inputFile.attr("id");
			}
			fileRow.fadeOut(1500, function () {
				fileRow.remove();
				self._wijFileRowRemoved(fileRow);
				if (self.uploaders[inputFileId]) {
					delete self.uploaders[inputFileId];
				}
				files = $(isUploadFileRow, self.element);
				if (files.length) {
					self.commandRow.show();
					if (uploader && uploader.destroy) {
						uploader.destroy();
					}
				} else {
					self.commandRow.hide();
					self._resetProgressAll();
					if (uploader && uploader.destroy) {
						uploader.destroy(true);
					}
				}
			});
		},

		_getFileName: function (fileName) {
			if (fileName.indexOf("\\") > -1) {
				fileName = fileName.substring(fileName.lastIndexOf("\\") + 1);
			}
			return fileName;
		},

		_getFileSize: function (file) {
			if (file.files && file.files.length > 0) {
				var obj = file.files[0];
				if (obj.size) {
					return obj.size;
				}
			}
			return 0;
		}
	});
} (jQuery));

/*
 *
 * Wijmo Library 1.4.0
 * http://wijmo.com/
 *
 * Copyright(c) ComponentOne, LLC.  All rights reserved.
 * 
 * Dual licensed under the Wijmo Commercial or GNU GPL Version 3 licenses.
 * licensing@wijmo.com
 * http://wijmo.com/license
 *
 *
 * * Wijmo Wizard widget.
 *
 * Depends:
 *	jquery-1.4.2.js
 *	jquery.ui.core.js
 *	jquery.ui.widget.js
 *	jquery.ui.position.js
 *	jquery.effects.core.js	
 *	jquery.cookie.js
 *	jquery.wijmo.wijsuperpanel.js
 *	jquery.wijmo.wijutil.js
 *
 */
 (function ($) {
	 "use strict";
	 $.widget("wijmo.wijwizard", {
		 options: {
			 ///	<summary>
			 ///		Determines the type of navigation buttons used with the wijwizard. 
			 ///		Possible values are 'auto', 'common', 'edge' and 'none'.
			 ///	</summary>
			 navButtons: 'auto',
			 ///	<summary>
			 ///		Determines whether panels are automatically displayed in order.
			 ///	</summary>
			 autoPlay: false,
			 ///	<summary>
			 ///		Determines the time span between panels in autoplay mode. 
			 ///	</summary>
			 delay: 3000,
			 ///	<summary>
			 ///		Determines whether start from the first panel when reaching the end in autoplay mode.
			 ///	</summary>
			 loop: false,
			 ///	<summary>
			 ///		This is an animation option for hiding the panel content.
			 ///	</summary>
			 hideOption: { fade: true }, // e.g. { blind: true, fade: true, duration: 200}
			 ///	<summary>
			 ///		This is an animation option for showing the panel content. 
			 ///	</summary>
			 showOption: { fade: true, duration: 400 }, // e.g. { blind: true, fade: true, duration: 200}
			 ///	<summary>
			 ///		Additional Ajax options to consider when loading panel content (see $.ajax).
			 ///	</summary>
			 ajaxOptions: null,
			 ///	<summary>
			 ///		Whether or not to cache remote wijwizard content; 
			 ///		Cached content is being lazy loaded; e.g once and only once for the panel is displayed. 
			 ///		Note that to prevent the actual Ajax requests from being cached by the browser you need to provide an extra cache: 
			 ///		false flag to ajaxOptions.
			 ///	</summary>
			 cache: false,
			 ///	<summary>
			 ///		Store the latest active index in a cookie. 
			 ///		The cookie is then used to determine the initially active index if the activeIndex option is not defined. 
			 ///		Requires cookie plugin. The object needs to have key/value pairs of the form the cookie plugin expects as options. 
			 ///	</summary>
			 cookie: null, // e.g. { expires: 7, path: '/', domain: 'jquery.com', secure: true }
			 ///	<summary>
			 ///		HTML template for step header when a new panel is added with the add method or
			 ///		when creating a panel for a remote panel on the fly.
			 ///	</summary>
			 stepHeaderTemplate: '',
			 ///	<summary>
			 ///		HTML template from which a new panel is created by adding a panel with the add method or
			 ///		when creating a panel for a remote panel on the fly.
			 ///	</summary>
			 panelTemplate: '',
			 ///	<summary>
			 ///		The HTML content of this string is shown in a panel while remote content is loading. 
			 ///		Pass in empty string to deactivate that behavior. 
			 ///	</summary>
			 spinner: '',
			 /// <summary>
			 /// The add event handler. A function called when a panel is added.
			 /// Default: null.
			 /// Type: Function.
			 /// Code example: $("#element").wijwizard({ add: function (e, ui) { } });
			 /// </summary>
			 ///
			 /// <param name="e" type="Object">jQuery.Event object.</param>
			 /// <param name="ui" type="Object">
			 /// The data that contains the related ui elements.
			 /// ui.panel: The panel element.
			 /// ui.index: The index of the panel.
			 ///</param>
			 add: null,
			 /// <summary>
			 /// The remove event handler. A function called when a panel is removed.
			 /// Default: null.
			 /// Type: Function.
			 /// Code example: $("#element").wijwizard({ remove: function (e, ui) { } });
			 /// </summary>
			 ///
			 /// <param name="e" type="Object">jQuery.Event object.</param>
			 /// <param name="ui" type="Object">
			 /// The data that contains the related ui elements.
			 /// ui.panel: The panel element.
			 /// ui.index: The index of the panel.
			 ///</param>
			 remove: null,
			 /// <summary>
			 /// The activeIndexChanged event handler. A function called when the activeIndex changed.
			 /// Default: null.
			 /// Type: Function.
			 /// Code example: $("#element").wijwizard({ activeIndexChanged: function (e, ui) { } });
			 /// </summary>
			 ///
			 /// <param name="e" type="Object">jQuery.Event object.</param>
			 /// <param name="ui" type="Object">
			 /// The data that contains the related ui elements.
			 /// ui.panel: The panel element.
			 /// ui.index: The index of the panel.
			 ///</param>
			 activeIndexChanged: null,
			 /// <summary>
			 /// The show event handler. A function called when a panel is shown.
			 /// Default: null.
			 /// Type: Function.
			 /// Code example: $("#element").wijwizard({ show: function (e, ui) { } });
			 /// </summary>
			 ///
			 /// <param name="e" type="Object">jQuery.Event object.</param>
			 /// <param name="ui" type="Object">
			 /// The data that contains the related ui elements.
			 /// ui.panel: The panel element.
			 /// ui.index: The index of the panel.
			 ///</param>
			 show: null,
			 /// <summary>
			 /// The load event handler. A function called after the content of a remote panel has been loaded.
			 /// Default: null.
			 /// Type: Function.
			 /// Code example: $("#element").wijwizard({ load: function (e, ui) { } });
			 /// </summary>
			 ///
			 /// <param name="e" type="Object">jQuery.Event object.</param>
			 /// <param name="ui" type="Object">
			 /// The data that contains the related ui elements.
			 /// ui.panel: The panel element.
			 /// ui.index: The index of the panel.
			 ///</param>
			 load: null,
			 /// <summary>
			 /// The validating event handler. A function called before moving to next panel. Cancellable.
			 /// Default: null.
			 /// Type: Function.
			 /// Code example: $("#element").wijwizard({ validating: function (e, ui) { } });
			 /// </summary>
			 ///
			 /// <param name="e" type="Object">jQuery.Event object.</param>
			 /// <param name="ui" type="Object">
			 /// The data that contains the related ui elements.
			 /// ui.panel: The panel element.
			 /// ui.index: The index of the panel.
			 /// ui.nextPanel: The next panel element.
			 /// ui.nextIndex: The index of the next panel.
			 ///</param>
			 validating: null
		 },
		 
		 _defaults: {
			 stepHeaderTemplate: '<li><h1>#{title}</h1>#{desc}</li>',
			 panelTemplate: '<div></div>',
			 spinner: '<em>Loading&#8230;</em>'
		 },

		 _create: function () {
			 this._pageLize(true);
		 },

		 _init: function () {
			 var o = this.options;
			 if (o.disabled){
				this.disable();
			 }else{
				 if (o.autoPlay) {
					 this.play();
				 }
			 }
		 },

		 _setOption: function (key, value) {
			 $.Widget.prototype._setOption.apply(this, arguments);

			 switch (key) {
				case 'activeIndex':
					this.show(value);
					break;
					
				case 'navButtons':
					this._createButtons();
					break;
					
				default:
					this._pageLize();
					break;
			 }
		 },

		 play: function () {
			 /// <summary>Start displaying the panels in order automatically.</summary>
			 var o = this.options, self = this;
			 if (!this.element.data('intId.wijwizard')) {
				 var id = window.setInterval(function () {
					 var index = o.activeIndex + 1;
					 if (index >= self.panels.length) {
						 if (o.loop) {
							 index = 0;
						 } else {
							 self.stop();
							 return;
						 }
					 }
					 self.show(index);
				 }, o.delay);

				 this.element.data('intId.wijwizard', id);
			 }
		 },

		 stop: function () {
			 /// <summary>Stop automatic displaying.</summary>
			 var id = this.element.data('intId.wijwizard');
			 if (id) {
				 window.clearInterval(id);
				 this.element.removeData('intId.wijwizard');
			 }
		 },

		 _normalizeBlindOption: function (o) {
			 if (o.blind === undefined) { o.blind = false; }
			 if (o.fade === undefined) { o.fade = false; }
			 if (o.duration === undefined) { o.duration = 200; }
			 if (typeof o.duration === 'string') {
				 try {
					 o.duration = parseInt(o.duration, 10);
				 }
				 catch (e) {
					 o.duration = 200;
				 }
			 }
		 },

		 _createButtons: function () {
			 var self = this, o = this.options;
			 
			 this._removeButtons();
			 if (o.navButtons === 'none') { return; }

			 if (!this.buttons) {
				 var bt = o.navButtons;
				 if (bt === 'auto') {
					 bt = this.list ? 'common' : 'edge';
				 }

				 this.buttons = $('<div/>');
				 this.buttons.addClass('wijmo-wijwizard-buttons');

				 var addState = function (state, el) {
					if (o.disabled) {return;}
					 if (el.is(':not(.ui-state-disabled)')) {
						 el.addClass('ui-state-' + state);
					 }
				 };
				 var removeState = function (state, el) {
					if (o.disabled) {return;}
					 el.removeClass('ui-state-' + state);
				 };

				 if (bt === 'common') {
					 this.backBtn = $("<a href='#'><span class='ui-button-text'>back</span></a>")
						.addClass('ui-widget ui-button ui-button-text-only ui-state-default ui-corner-all')
						.appendTo(this.buttons).bind({
							'click': function () { self.back(); return false; },
							'mouseover': function () { addState('hover', $(this)); },
							'mouseout': function () { removeState('hover', $(this)); },
							'mousedown': function () { addState('active', $(this)); },
							'mouseup': function () { removeState('active', $(this)); }
						}).attr("role", "button");

					 this.nextBtn = $("<a href='#'><span class='ui-button-text'>next</span></a>")
						.addClass('ui-widget ui-button ui-button-text-only ui-state-default ui-corner-all')
						.appendTo(this.buttons).bind({
							'click': function () { self.next(); return false; },
							'mouseover': function () { addState('hover', $(this)); },
							'mouseout': function () { removeState('hover', $(this)); },
							'mousedown': function () { addState('active', $(this)); },
							'mouseup': function () { removeState('active', $(this)); }
						}).attr("role", "button");
				 } else {
					 this.backBtn = $("<a href='#'/>")
						.addClass('wijmo-wijwizard-prev ui-state-default ui-corner-right')
						.append("<span class='ui-icon ui-icon-triangle-1-w'></span>")
						.appendTo(this.buttons).bind({
							'click': function () { self.back(); return false; },
							'mouseover': function () { addState('hover', $(this)); },
							'mouseout': function () { removeState('hover', $(this)); },
							'mousedown': function () { addState('active', $(this)); },
							'mouseup': function () { removeState('active', $(this)); }
						}).attr("role", "button");

					 this.nextBtn = $("<a href='#'/>")
						.addClass('wijmo-wijwizard-next ui-state-default ui-corner-left')
						.append("<span class='ui-icon ui-icon-triangle-1-e'></span>")
						.appendTo(this.buttons).bind({
							'click': function () { self.next(); return false; },
							'mouseover': function () { addState('hover', $(this)); },
							'mouseout': function () { removeState('hover', $(this)); },
							'mousedown': function () { addState('active', $(this)); },
							'mouseup': function () { removeState('active', $(this)); }
						}).attr("role", "button");
				 }

				 this.buttons.appendTo(this.element);
			 }
		 },

		 _removeButtons: function () {
			 if (this.buttons) {
				 this.buttons.remove();
				 this.buttons = undefined;
			 }
		 },

		 _pageLize: function (init) {
			 var self = this, o = this.options;

			 this.list = this.element.find('ol,ul').eq(0);
			 if (this.list && this.list.length === 0) { this.list = null; }
			 if (this.list) { this.lis = $('li', this.list); }
			 
			 if (init) {
				 this.panels = $('> div', this.element);

				 var fragmentId = /^#.+/; // Safari 2 reports '#' for an empty hash
				 this.panels.each(function (i, p) {
					 var url = $(p).attr('src');
					 // inline
					 if (url && !fragmentId.test(url)) {
						 $.data(p, 'load.wijwizard', url.replace(/#.*$/, '')); // mutable data
					 }
				 });

				 this.element.addClass('wijmo-wijwizard ui-widget ui-helper-clearfix');
				 if (this.list) {
					 this.list.addClass('ui-widget ui-helper-reset wijmo-wijwizard-steps ui-helper-clearfix').attr("role", "tablist");
					 this.lis.addClass('ui-widget-header ui-corner-all').attr("role", "tab");
				 }
				 this.container = $('<div/>');
				 this.container.addClass('wijmo-wijwizard-content ui-widget ui-widget-content ui-corner-all');
				 this.container.append(this.panels);
				 this.container.appendTo(this.element);
				 this.panels.addClass('wijmo-wijwizard-panel ui-widget-content').attr("role", "tabpanel");

				 // Active a panel
				 // use "activeIndex" option or try to retrieve:
				 // 1. from cookie
				 // 2. from actived class attribute on panel
				 if (o.activeIndex === undefined) {
					 if (typeof o.activeIndex != 'number' && o.cookie) {
						 o.activeIndex = parseInt(self._cookie(), 10);
					 }
					 if (typeof o.activeIndex != 'number' && this.panels.filter('.wijmo-wijwizard-actived').length) {
						 o.activeIndex = this.panels.index(this.panels.filter('.wijmo-wijwizard-actived'));
					 }
					 o.activeIndex = o.activeIndex || (this.panels.length ? 0 : -1);
				 } else if (o.activeIndex === null) { // usage of null is deprecated, TODO remove in next release
					 o.activeIndex = -1;
				 }

				 // sanity check - default to first page...
				 o.activeIndex = ((o.activeIndex >= 0 && this.panels[o.activeIndex]) || o.activeIndex < 0) ? o.activeIndex : 0;

				 this.panels.addClass('wijmo-wijwizard-hide').attr('aria-hidden', true);
				 if (o.activeIndex >= 0 && this.panels.length) { // check for length avoids error when initializing empty pages
					 this.panels.eq(o.activeIndex).removeClass('wijmo-wijwizard-hide').addClass('wijmo-wijwizard-actived').attr('aria-hidden', false);
					 this.load(o.activeIndex);
				 }

				 this._createButtons();
			 } else {
				this.panels = $('> div', this.container);
				 o.activeIndex = this.panels.index(this.panels.filter('.wijmo-wijwizard-actived'));
			 }

			 this._refreshStep();
			 this._initScroller();

			 // set or update cookie after init and add/remove respectively
			 if (o.cookie) {
				 this._cookie(o.activeIndex, o.cookie);
			 }

			 // reset cache if switching from cached to not cached
			 if (o.cache === false) {
				 this.panels.removeData('cache.wijwizard');
			 }

			 if (o.showOption === undefined || o.showOption === null) { o.showOption = {}; }
			 this._normalizeBlindOption(o.showOption);

			 if (o.hideOption === undefined || o.hideOption === null) { o.hideOption = {}; }
			 this._normalizeBlindOption(o.hideOption);

			 // remove all handlers
			 this.panels.unbind('.wijwizard');
		 },

		 _initScroller: function () {
			 if (!this.lis) { return; }

			 var width = 0;
			 this.lis.each(function () {
				 width += $(this).outerWidth(true);
			 });

			 if (this.element.innerWidth() < width) {
				 if (this.scrollWrap === undefined) {
					 this.list.wrap("<div class='scrollWrap'></div>");
					 this.scrollWrap = this.list.parent();
					 $.effects.save(this.list, ['width', 'height', 'overflow']);
				 }

				 this.list.width(width + 8);
				 this.scrollWrap.height(this.list.outerHeight(true));
				 this.scrollWrap.wijsuperpanel({
					 allowResize: false,
					 hScroller: {
						 scrollBarVisibility: 'hidden'
					 },
					 vScroller: {
						 scrollBarVisibility: 'hidden'
					 }
				 });
			 } else {
				 this._removeScroller();
			 }
		 },

		 _removeScroller: function () {
			 if (this.scrollWrap) {
				 this.scrollWrap.wijsuperpanel('destroy').replaceWith(this.scrollWrap.contents());
				 this.scrollWrap = undefined;
				 $.effects.restore(this.list, ['width', 'height', 'overflow']);
			 }
		 },

		 _refreshStep: function () {
			 var o = this.options;

			 if (this.lis) {
				 this.lis.removeClass('ui-priority-primary').addClass('ui-priority-secondary').attr('aria-selected', false);
				 if (o.activeIndex >= 0 && o.activeIndex <= this.lis.length - 1) {
					 if (this.lis) {
						 this.lis.eq(o.activeIndex).removeClass('ui-priority-secondary').addClass('ui-priority-primary').attr('aria-selected', true);
					 }
					 if (this.scrollWrap) {
						 this.scrollWrap.wijsuperpanel('scrollChildIntoView', this.lis.eq(o.activeIndex));
					 }
				 }
			 }

			 if (this.buttons && !o.loop) {
				 this.backBtn[o.activeIndex <= 0 ? 'addClass' : 'removeClass']('ui-state-disabled').attr('aria-disabled', o.activeIndex === 0);
				 this.nextBtn[o.activeIndex >= this.panels.length - 1 ? 'addClass' : 'removeClass']('ui-state-disabled').attr('aria-disabled', (o.activeIndex >= this.panels.length - 1));
			 }
		 },

		 _sanitizeSelector: function (hash) {
			 return hash.replace(/:/g, '\\:'); // we need this because an id may contain a ":"
		 },

		 _cookie: function () {
			 var cookie = this.cookie || (this.cookie = this.options.cookie.name);
			 return $.cookie.apply(null, [cookie].concat($.makeArray(arguments)));
		 },

		 _ui: function (panel) {
			 return {
				 panel: panel,
				 index: this.panels.index(panel)
			 };
		 },

		 _removeSpinner: function () {
			 // restore all former loading wijwizard labels
			 this.element.removeClass('ui-state-processing');
			 var spinner = this.element.data('spinner.wijwizard');
			 if (spinner) {
				 this.element.removeData('spinner.wijwizard');
				 spinner.remove();
			 }
		 },

		 // Reset certain styles left over from animation
		 // and prevent IE's ClearType bug...
		 _resetStyle: function ($el) {
			 $el.css({ display: '' });
			 if (!$.support.opacity) {
				 $el[0].style.removeAttribute('filter');
			 }
		 },

		 destroy: function () {
			 var o = this.options;
			 this.abort();
			 this.stop();
			 this._removeScroller();
			 this._removeButtons();
			 this.element.unbind('.wijwizard')
			.removeClass([
				'wijmo-wijwizard',
				'ui-widget',
				'ui-helper-clearfix'
				].join(' '))
			.removeData('wijwizard');

			 if (this.list) {
				 this.list.removeClass('ui-widget ui-helper-reset wijmo-wijwizard-steps ui-helper-clearfix').removeAttr('role');
			 }

			 if (this.lis) {
				 this.lis.removeClass('ui-widget-header ui-corner-all ui-priority-primary ui-priority-secondary').removeAttr('role');
				 this.lis.each(function () {
					 if ($.data(this, 'destroy.wijwizard')) {
						 $(this).remove();
					 } else {
						 $(this).removeAttr('aria-selected');
					 }
				 });
			 }

			 this.panels.each(function () {
				 var $this = $(this).unbind('.wijwizard');
				 $.each(['load', 'cache'], function (i, prefix) {
					 $this.removeData(prefix + '.wijwizard');
				 });

				 if ($.data(this, 'destroy.wijwizard')) {
					 $(this).remove();
				 } else {
					 $(this).removeClass([
					'ui-state-default',
					'wijmo-wijwizard-actived',
					'ui-state-active',
					'ui-state-hover',
					'ui-state-focus',
					'ui-state-disabled',
					'wijmo-wijwizard-panel',
					'ui-widget-content',
					'wijmo-wijwizard-hide'
					].join(' ')).css({ position: '', left: '', top: '' }).removeAttr('aria-hidden');
				 }
			 });

			 this.container.replaceWith(this.container.contents());

			 if (o.cookie) {
				 this._cookie(null, o.cookie);
			 }

			 return this;
		 },

		 add: function (index, title, desc) {
			 /// <summary>Add a new panel.</summary>
			 /// <param name="index" type="Number">Zero-based position where to insert the new panel.</param>
			 /// <param name="title" type="String">The step title.</param>
			 /// <param name="desc" type="String">The step description.</param>
			 if (index === undefined) {
				 index = this.panels.length; // append by default
			 }

			 if (title === undefined) {
				 title = "Step " + index;
			 }

			 var self = this, o = this.options;

			 var $panel = $(o.panelTemplate || self._defaults.panelTemplate).data('destroy.wijwizard', true), $li;
			 $panel.addClass('wijmo-wijwizard-panel ui-widget-content ui-corner-all wijmo-wijwizard-hide').attr('aria-hidden', true);

			 if (index >= this.panels.length) {
				 if (this.panels.length > 0) {
					 $panel.insertAfter(this.panels[this.panels.length - 1]);
				 } else {
					 $panel.appendTo(this.container);
				 }
			 } else {
				 $panel.insertBefore(this.panels[index]);
			 }

			 if (this.list && this.lis) {
				 $li = $((o.stepHeaderTemplate || self._defaults.stepHeaderTemplate).replace(/#\{title\}/g, title).replace(/#\{desc\}/g, desc));
				 $li.addClass('ui-widget-header ui-corner-all ui-priority-secondary').data('destroy.wijwizard', true);

				 if (index >= this.lis.length) {
					 $li.appendTo(this.list);
				 } else {
					 $li.insertBefore(this.lis[index]);
				 }
			 }

			 this._pageLize();
			 
			 if (this.panels.length == 1) { // after pagelize
				 o.activeIndex = 0;
				 $li.addClass('ui-priority-primary');
				 $panel.removeClass('wijmo-wijwizard-hide').addClass('wijmo-wijwizard-actived').attr('aria-hidden', false);
				 this.element.queue("wijwizard", function () {
					 self._trigger('show', null, self._ui(self.panels[0]));
				 });

				 this._refreshStep();
				 this.load(0);
			 }

			 // callback
			 this._trigger('add', null, this._ui(this.panels[index]));
			 return this;
		 },

		 remove: function (index) {
			 /// <summary>Remove a panel.</summary>
			 /// <param name="index" type="Number">The zero-based index of the panel to be removed.</param>
			 var o = this.options, $li = this.lis.eq(index).remove(),
			 $panel = this.panels.eq(index).remove();
			 
			 if (index < o.activeIndex){
				o.activeIndex--;
			 }
			
			this._pageLize();
			
			 //Ajust the active panel index in some case
			 if ($panel.hasClass('wijmo-wijwizard-actived') && this.panels.length >= 1) {
				 this.show(index + (index < this.panels.length ? 0 : -1));
			 }
			
			 // callback
			 this._trigger('remove', null, this._ui($panel[0]));
			 return this;
		 },

		 _showPanel: function (p) {
			 var self = this, o = this.options, $show = $(p);
			 $show.addClass('wijmo-wijwizard-actived');
			 if ((o.showOption.blind || o.showOption.fade) && o.showOption.duration > 0) {
				 var props = { duration: o.showOption.duration };
				 if (o.showOption.blind) { props.height = 'toggle'; }
				 if (o.showOption.fade) { props.opacity = 'toggle'; }
				 $show.hide().removeClass('wijmo-wijwizard-hide') // avoid flicker that way
					.animate(props, o.showOption.duration || 'normal', function () {
						self._resetStyle($show);
						self._trigger('show', null, self._ui($show[0]));
						self._removeSpinner();
						$show.attr('aria-hidden', false);
						self._trigger('activeIndexChanged', null, self._ui($show[0]));
					});
			 } else {
				 $show.removeClass('wijmo-wijwizard-hide').attr('aria-hidden', false);
				 self._trigger('show', null, self._ui($show[0]));
				 self._removeSpinner();
				 self._trigger('activeIndexChanged', null, self._ui($show[0]));
			 }
		 },

		 _hidePanel: function (p) {
			 var self = this, o = this.options, $hide = $(p);
			 $hide.removeClass('wijmo-wijwizard-actived');
			 if ((o.hideOption.blind || o.hideOption.fade) && o.hideOption.duration > 0) {
				 var props = { duration: o.hideOption.duration };
				 if (o.hideOption.blind) { props.height = 'toggle'; }
				 if (o.hideOption.fade) { props.opacity = 'toggle'; }
				 $hide.animate(props, o.hideOption.duration || 'normal', function () {
					 $hide.addClass('wijmo-wijwizard-hide').attr('aria-hidden', true);
					 self._resetStyle($hide);
					 self.element.dequeue("wijwizard");
				 });
			 } else {
				$hide.addClass('wijmo-wijwizard-hide').attr('aria-hidden', true);
				this.element.dequeue("wijwizard");
			 }
		 },

		 show: function (index) {
			 /// <summary>Selects a panel Active and display the panel at specified position.</summary>
			 /// <param name="index" type="Number">The zero-based index of the panel to be actived.</param>
			 if (index < 0 || index >= this.panels.length) { return this; }

			 // previous animation is still processing
			 if (this.element.queue("wijwizard").length > 0) { return this; }

			 var self = this, o = this.options;
			 var args = $.extend({}, this._ui(this.panels[o.activeIndex]));
			 args.nextIndex = index;
			 args.nextPanel = this.panels[index];
			 if (this._trigger('validating', null, args) === false) { return this; }

			 var $hide = this.panels.filter(':not(.wijmo-wijwizard-hide)'),
			 $show = this.panels.eq(index);
			 o.activeIndex = index;

			 this.abort();

			 if (o.cookie) {
				 this._cookie(o.activeIndex, o.cookie);
			 }

			 this._refreshStep();
			 // show new panel
			 if ($show.length) {
				 if ($hide.length) {
					 this.element.queue("wijwizard", function () {
						 self._hidePanel($hide);
					 });
				 }

				 this.element.queue("wijwizard", function () {
					 self._showPanel($show);
				 });

				 this.load(index);
			 }
			 else {
				 throw 'jQuery UI wijwizard: Mismatching fragment identifier.';
			 }

			 return this;
		 },

		 next: function () {
			 /// <summary>Moves to the next panel.</summary>
			 var o = this.options;
			 if (o.disabled) {return false;}
			 var index = o.activeIndex + 1;
			 if (o.loop) {
				 index = index % this.panels.length;
			 }

			 if (index < this.panels.length) {
				 this.show(index);
				 return true;
			 }
			 return false;
		 },

		 back: function () {
			 /// <summary>Moves to the previous panel.</summary>
			 var o = this.options;
			 if (o.disabled) {return false;}
			 var index = o.activeIndex - 1;
			 if (o.loop) {
				 index = index < 0 ? this.panels.length - 1 : index;
			 }

			 if (index >= 0) {
				 this.show(index);
				 return true;
			 }
			 return false;
		 },

		 load: function (index) {
			 /// <summary>Reload the content of an Ajax panel programmatically.</summary>
			 /// <param name="index" type="Number">The zero-based index of the panel to be loaded</param>
			 var self = this, o = this.options, p = this.panels.eq(index)[0], url = $.data(p, 'load.wijwizard');

			 this.abort();

			 // not remote or from cache
			 if (!url || this.element.queue("wijwizard").length !== 0 && $.data(p, 'cache.wijwizard')) {
				 this.element.dequeue("wijwizard");
				 return;
			 }

			 // load remote from here on
			 this.element.addClass('ui-state-processing');
			 if (o.spinner) {
				 var spinner = this.element.data('spinner.wijwizard');
				 if (!spinner) {
					 spinner = $('<div/>');
					 spinner.addClass('wijmo-wijwizard-spinner');
					 spinner.html(o.spinner || self._defaults.spinner);
					 spinner.appendTo(document.body);
					 this.element.data('spinner.wijwizard', spinner);
					 spinner.wijpopup({
						 showEffect: 'blind',
						 hideEffect: 'blind'
					 });
				 }

				 spinner.wijpopup('show', {
					 of: this.element,
					 my: 'center center',
					 at: 'center center'
				 });
			 }

			 this.xhr = $.ajax($.extend({}, o.ajaxOptions, {
				 url: url,
				 success: function (r, s) {
					 $(p).html(r);

					 if (o.cache) {
						 $.data(p, 'cache.wijwizard', true); // if loaded once do not load them again
					 }

					 // callbacks
					 self._trigger('load', null, self._ui(self.panels[index]));
					 try {
						 if (o.ajaxOptions && o.ajaxOptions.success) {
							 o.ajaxOptions.success(r, s);
						 }
					 }
					 catch (e1) { }
				 },
				 error: function (xhr, s, e) {
					 // callbacks
					 self._trigger('load', null, self._ui(self.panels[index]));
					 try {
						 // Passing index avoid a race condition when this method is
						 // called after the user has selected another panel.
						 if (o.ajaxOptions && o.ajaxOptions.error) {
							 o.ajaxOptions.error(xhr, s, index, p);
						 }
					 }
					 catch (e2) { }
				 }
			 }));

			 // last, so that load event is fired before show...
			 self.element.dequeue("wijwizard");

			 return this;
		 },

		 abort: function () {
			 /// <summary>Terminate all running panel ajax requests and animations.</summary>	    
			 this.element.queue([]);
			 this.panels.stop(false, true);

			 // "wijwizard" queue must not contain more than two elements,
			 // which are the callbacks for hide and show
			 this.element.queue("wijwizard", this.element.queue("wijwizard").splice(-2, 2));

			 // terminate pending requests from other wijwizard
			 if (this.xhr) {
				 this.xhr.abort();
				 delete this.xhr;
			 }

			 // take care of spinners
			 this._removeSpinner();
			 return this;
		 },

		 url: function (index, url) {
			 /// <summary>Change the url from which an Ajax (remote) panel will be loaded.</summary>
			 /// <param name="index" type="Number">The zero-based index of the panel of which its URL is to be updated.</param>
			 /// <param name="url" type="String">A URL the content of the panel is loaded from.</param>
			 this.panels.eq(index).removeData('cache.wijwizard').data('load.wijwizard', url);
			 return this;
		 },

		 count: function () {
			 /// <summary>Retrieve the number panels.</summary>
			 return this.panels.length;
		 }

	 });

 })(jQuery);

