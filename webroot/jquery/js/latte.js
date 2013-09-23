
var Navigation = function() {
	var me = this;
	var args = arguments;
	
	var self = {
		c: {
			navItems: '#navigation .home, #navigation .services, #navigation .portfolio, #navigation .about, #navigation .contact',
			
			navSpeed: ($.browser.safari ? 600 : 350),
			
			snOpeningSpeed: ($.browser.safari ? 400 : 250),
			snOpeningTimeout: 150,
			
			snClosingSpeed: function() {
				if (self.subnavHovered()) return 123450; return 150; 			
			},
			snClosingTimeout: 700 
		},
		
		init: function() {
			$('.level_1', this.c.navItems).css({
					'opacity': 0
				});
			
			this.initHoverFades();
			//this.initSubmenus();
		},
		
		subnavHovered: function() {
			var hovered = false;
			$(self.c.navItems).each(function() {
				if (this.hovered /* && $('.level_1', this).length > 0*/) hovered = true;
			});
			return hovered;
		},
		
		initHoverFades: function() {
			$('#navigation .main').append('<span class="hover"></span>');
			
			$('#navigation .hover').css('opacity', 0);
			
			/*$('#navigation .home, #navigation .contact,#logotype').hover(function() {*/
			$('#navigation .main,#subnavigation a').hover(function() {

				self.fadeNavIn.apply(this);
			}, function() {
				var el = this;
				
				setTimeout(function() {
					if (!el.open) self.fadeNavOut.apply(el);
				}, 10);
			});
		},
		
		fadeNavIn: function() {
			$('.hover', this).stop().animate({
				'opacity': 1
			}, self.c.navSpeed);
		},

		fadeSubnavIn: function() {
			var el = this;
			$('.level_1', this)
				.stop()
				.css('display', 'block')
				.animate({
					'top': '80px',
					'opacity': 1
				}, self.c.snOpeningSpeed, function() { el.open = true; });
		},

		fadeNavOut: function() {
			$('.hover', this).stop().animate({
				'opacity': 0
			}, self.c.navSpeed);
		
		},

		fadeSubnavOut: function() {
			$('.level_1', this)
				.stop()
				.animate({
					/*'top': '70px',*/
					'opacity': 0
				}, self.c.snClosingSpeed(), function() { $(this).css({'top': '70px', 'display': 'none'}); });
		},
		
		initSubmenus: function() {
			$(this.c.navItems).hover(function() {
				$(self.c.navItems).not(this).each(function() {
					self.fadeNavOut.apply(this);
					self.fadeSubnavOut.apply(this);
				});
				
				this.hovered = true;
				if ($('.level_1', this).length == 0) return;
		
				var el = this;
				
				self.fadeNavIn.apply(el);

				clearTimeout(el.level1);
				
				el.level1 = setTimeout(function() {						
					self.fadeSubnavIn.apply(el);
				}, self.c.snOpeningTimeout);
				
				
			}, function() {
				this.hovered = false;
				if ($('.level_1', this).length == 0) return;
				var el = this;
				
				clearTimeout(el.level1);
				if (!el.open) self.fadeNavOut.apply(el);

				el.level1 = setTimeout(function() {
					el.open = false;

					self.fadeSubnavOut.apply(el);
					self.fadeNavOut.apply(el);

				}, self.c.snClosingTimeout);


			});
		}
		
	};
	
	self.init.apply(self);
	return self;
};

function d(s) {
//	$('body').append	('<p>' + s + '</p>');
}

$(function(){
	new Navigation();
});/* Codename Rainbow */

function initGradients(s) {
	$(function() {
		$(s).each(function() {
			var el = this;
			// Parse the inputs
			var from = '#ffffff', to = '#000000';
			var
				fR = parseInt(from.substring(1, 3), 16),
				fG = parseInt(from.substring(3, 5), 16),
				fB = parseInt(from.substring(5, 7), 16),
				tR = parseInt(to.substring(1, 3), 16),
				tG = parseInt(to.substring(3, 5), 16),
				tB = parseInt(to.substring(5, 7), 16);

			
			var h = $(this).height() * 1.5;
			var html;
			
			if (this.initHTML)
				html = this.initHTML;
			else
				html = this.innerHTML;
			
			this.initHTML = html;
			this.innerHTML = '';
			
			for (var i = 0; i < h; i++) {
				var c = '#' +
					(Math.floor(fR * (h - i) / h + tR * (i / h))).toString(16) +
					(Math.floor(fG * (h - i) / h + tG * (i / h))).toString(16) +
					(Math.floor(fB * (h - i) / h + tB * (i / h))).toString(16);

				$('<span class="rainbow rainbow-' + i + '" style="color: ' + c + ';"><span style="top: ' + (-i - 1) + 'px;">' + html + '</span></span>').appendTo(this);
			}
			
			$('<span class="highlight">' + html + '</span>').appendTo(this);
			$('<span class="shadow">' + html + '</span>').appendTo(this);

		});
		
	});
}

initGradients('.rainbows');$(function() { 

	initTooltips({
		timeout: 3000
	}); 

});

function initTooltips(o) {
//alert($.browser.safari)

	var showTip = function() {
		var el = $('.tt', this).css('display', 'block')[0];
		
		var ttHeight = $(el).height();
		var ttOffset =  el.offsetHeight;
		var ttTop = ttOffset + ttHeight;

		$('.tt', this)
			.stop()
			.css({
				'opacity': 0,
				'top': 10 - ttOffset
			})
			.animate({
				'opacity': 1,
				'top': 5 - ttOffset
			}, 250);
	};

	var hideTip = function() {
	
		var self = this;
		var el = $('.tt', this).css('display', 'block')[0];

		var ttHeight = $(el).height();
		var ttOffset =  el.offsetHeight;
		var ttTop = ttOffset + ttHeight;
	//	alert(label.height());
	//	el.hiding = true;
		$('.tt', this)
			.stop()
			.animate({
				'opacity': 0,
				'top': 10 - ttOffset
			}, 250, function() {
				el.hiding = false;
				$(this).css('display', 'none');
			});
		
		
	};
	
	$('.tip .tt').hover(
		function() { return false; },
		function() { return true; }
	);
	
	$('.tip').hover(
		function(){
			var self = this;
			showTip.apply(this);
			if (o.timeout) this.tttimeout = setTimeout(function() { hideTip.apply(self) } , o.timeout);
		},
		function() {
			clearTimeout(this.tttimeout);
			hideTip.apply(this); 
		}
	);

}

Object.extend = function(destination, source) {
  for (property in source) {
    destination[property] = source[property];
  }
  return destination;
};

var Class = {
  create: function() {
    return function() {
      this.initialize.apply(this, arguments);
    }
  }
};

var Helper = {
	setCookie: function(name, value) {
		var expires = new Date();
		expires.setTime(expires.getTime() + 365 * 24 * 60 * 60 * 1000);
	  var curCookie = name + '=' + escape(value) + '; expires=' + expires.toGMTString();
	  document.cookie = curCookie;
	},

	getCookie: function(name) {
	  var dc = document.cookie;
	  var prefix = name + '=';
	  var begin = dc.indexOf('; ' + prefix);
	  if (begin == -1) {
	    begin = dc.indexOf(prefix);
	    if (begin != 0) return null;
	  } else
	    begin += 2;
	  var end = document.cookie.indexOf(';', begin);
	  if (end == -1)
	    end = dc.length;
	  return unescape(dc.substring(begin + prefix.length, end));
	}
};

String.prototype.format = function() {
  var params = String.prototype.format.arguments;
  var toReturn = this;

  for (var i = 0; i < params.length; i++) {
    var regex = new RegExp('\{[' + i + ']\}', 'g');
    toReturn = toReturn.replace(regex, params[i]);
  }
 return toReturn;
};

RegExp.escape = function(text) {
  if (!arguments.callee.sRE) {
    var specials = [
      '/', '.', '*', '+', '?', '|',
      '(', ')', '[', ']', '{', '}', '\\'
    ];
    arguments.callee.sRE = new RegExp(
      '(\\' + specials.join('|\\') + ')', 'g'
    );
  }
  return text.replace(arguments.callee.sRE, '\\$1');
};

// Elastic

var ElasticLayout = Class.create();

ElasticLayout.prototype = {
	initialize: function(options) {
		var dOptions = {
			small: 1,
			large: 980,
			cSmall: 'anorexia',
			cLarge: 'whale'
		};

		this.options = Object.extend(dOptions, options);

		this.addResizeHandler();
		this.checkWidth();
	},

	addResizeHandler: function() {
		var self = this;
		
		$(window).resize( function() {
			self.checkWidth.apply(self);
		});
	},

	checkWidth: function() {
		var winWidth = this.getWidth();
		var changeTo;
		 
		switch(true) {

			case winWidth >= this.options.large: 
				changeTo = this.options.cLarge;
				break;


			case winWidth >= this.options.small: 
				changeTo = this.options.cSmall;
				break;
		}
	
		if (changeTo != this.curClass) this.changeClass(changeTo);
	},

	getWidth: function() {
		if (window.innerWidth) return window.innerWidth;
		
		if (document.documentElement && document.documentElement.clientWidth != 0)
			return document.documentElement.clientWidth;
			
		if (document.body) return document.body.clientWidth;

		return 0;
	},
	
	changeClass: function(cName) {
		$('body')
			.removeClass(this.options.cSmall)
			.removeClass(this.options.cLarge)
			.addClass(cName);
	}

};

// Visit Couner

var VisitCounter = Class.create();

VisitCounter.prototype = {
	initialize: function(options) {
		var dOptions = {
			bounds: [0, 1, 4, 5555],
			classnames: ['freshman', 'senior', 'professor']
		};

		this.options = Object.extend(dOptions, options);
		this.check();

	},

	check: function() {
		var visits = Helper.getCookie('visits');
		if (!visits) visits = 1;

		for (var i = 0; i < this.options.bounds.length - 1; i++) {
			if ((visits > this.options.bounds[i]) && (visits <= this.options.bounds[i + 1])) {
				$('body').addClass(this.options.classnames[i]);
				break;
			}
		}
		
		visits++;
		Helper.setCookie('visits', visits);
	}
};

// 5,4,3,1 OFFBLAST!!

$(document).ready( function() {

	new VisitCounter();

	
});$(function() {

// Body .safari class
	if ($.browser.safari) $('body').addClass('safari');
	
	$('body').addClass('mocha');

/* Hover effects */
	var fadeSpeed = ($.browser.safari ? 600 : 450);
	
	$('#logotype, ul.features a,#notice a').append('<span class="hover"></span>');
	$('.hover').css('opacity', 0);
	
/*$('#navigation .home, #navigation .contact,#logotype').hover(function() {*/
	$('.hover').parent().hover(function() {
		$('.hover', this).stop().animate({
			'opacity': 1
		}, fadeSpeed);
	}, function() {
		$('.hover', this).stop().animate({
			'opacity': 0
		}, fadeSpeed);
	});

/* Side Subnavigation */
	$('#subnavigation a').each(function() {	// Each <a>
		var html = this.innerHTML;
		$(this).html('<span class="hover"></span><span class="cap"></span><span>' + html + '</span>');
	});
	
/* Building Trailer */
	$('#trailer').html('<div class="loading"><img src="/lib/i/altar/bar.gif?x=' + Math.random() + '" class="bar" alt="" /><img src="/lib/i/altar/bar_reflect.gif?x=' + Math.random() + '" class="bar_reflect" alt=""/></div>');

/* Fading Trailer */

if( $('body').is('.timeline,.freshman') ) {
	setTimeout(function() {
			$('.#trailer').fadeOut(2500);
		}, 4500);
		setTimeout(function() {
			$('.#trailer img').animate({ opacity: 0 }, 1500);
		}, 2700);
}
else { $('#trailer').fadeOut(900); }

/* Fade Out Notice */

$('#notice .close').click(function() { $('#notice').fadeOut(2500); return false; }); 

/* Octopus Engine */

	$('.section').each(function() {	// Each .section
		var html = this.innerHTML;
		$(this).html('<div class="highlight"><div class="shadow">' + html + '</div></div>');
	});

/* List Classing */
$("#sideblade ul,.features").each(function(i) {
			var lis = $(this).children();

			lis.filter(":first").addClass("first").end().filter(":last").addClass("last");
			lis.each(function(x) {
				if (x % 2 == 0) { $(this).addClass("even"); }
				if (x % 2 == 1) { $(this).addClass("odd"); }
				if (x % 4 == 3) { $(this).addClass("doubleEven"); }
			})
});

// Parallax
/*
	if ($.browser.safari) {
		var p1 = new Parallax({
			cName: '.b1',
			time: 35000,
			animate: [
				['left', 1400]
			]
		});
	}
*/
});
function getURLAnchor(){
  var strReturn = "";
  var strHref = window.location.href;
  if ( strHref.indexOf("#") > -1 ){
   	strReturn = strHref.substr(strHref.indexOf("#") + 1).toLowerCase();
  }

  return strReturn;
}


$(function() {

var curSection = 'general';

$('#go-general').click(function() {
	if (curSection == 'general') return;
	curSection = 'general';
    $('.clearsection').css('display', 'none');
    $('#section-general').fadeIn(500);
    $('body').removeClass('book').removeClass('questions').addClass('general');
});

$('#go-questions').click(function() {
	if (curSection == 'questions') return;
	curSection = 'questions';
    $('.clearsection').css('display', 'none');
    $('#section-questions').fadeIn(500);
    $('body').removeClass('general').removeClass('book').addClass('questions');
});

$('#go-book').click(function() {
	if (curSection == 'book') return;
	curSection = 'book';
    $('.clearsection').css('display', 'none');
    $('#section-book').fadeIn(500);
    $('body').removeClass('general').removeClass('questions').addClass('book');
});

var anchor = getURLAnchor();

if (anchor.length > 0) {
	curSection = 'book';
    $('.clearsection').css('display', 'none');
    $('#section-' + anchor).css('display', 'block');
    $('body').removeClass('book').removeClass('questions').removeClass('general').addClass(anchor);
}

initContact('#c-general'); 
initContact('#c-questions'); 
initContact('#c-book'); 

});

function initContact(form) {
	var tests = {
		alpha: [
			'The field must contain only letters of the alphabet.',
			function(s) { return /^[a-zA-Z]+$/.test(s); }
		],
		
		num: [
			'The field must contain a valid number.',
			function(s) { return (s.length > 0) && !isNaN(s); /* /^\d+$/.test(s); */ }
		],
		
		alphanum: [
			'The field must contain only alphanumeric characters (A-Z, 0-9).',
			function(s) { return /^[a-zA-Z0-9]+$/.test(s); }
		],
		
		digit: [
			'The field must contain one digit.',
			function(s) { return /^\d$/.test(s); }
		],
		
		letter: [
			'The field must contain one letter.',
			function(s) { return /^[a-zA-Z]$/.test(s); }
		],
		
		url: [
			'The field must contain a valid URL. Include the http://.',
			function(s) { return /^(("[\w-\s]+")|([\w-]+(?:\.[\w-]+)*)|("[\w-\s]+")([\w-]+(?:\.[\w-]+)*))(@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][0-9]\.|1[0-9]{2}\.|[0-9]{1,2}\.))((25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\.){2}(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[0-9]{1,2})\]?$)/i.test(s); }
		],
		
		req: ['The field is required.',
			function(s) { return (s.length > 0) && (s != null) && !/^\s+$/.test(s); }
		],
		
		phone: [
			'The field must contain a valid phone number.',
			function(s) { s = s.replace(/[\(\)\.\-\ ]/g, ''); return (tests['num'][1](s)) && (s.length == 10); }
		],
		
		email: [
			'The field must contain a valid email.',
			function(s) { return /^.+@.+\..{2,3}$/.test(s) && !/[\(\)\<\>\,\;\:\\\/\"\[\]]/.test(s); }
		]
	};
//	alert(tests['phone'][1]('212 111 2213'));
	
	var showError = function(el, msg) {
		$(el).addClass('input-error').attr('title', msg);
	};
	
	var clearError = function(el) {
		$(el).removeClass('input-error').attr('title', '');
	};

	var validate = function() {
		var numValid = 0;
		
		
		var total = $(this).each(function() {
			var validated = true;
			var v = '';
			
			$('.req', this).each(function() {
				v = $(this).val();

				if (!tests['req'][1](v)) {
					showError(this, tests['req'][0]);
					validated = false;
				} else
					clearError(this);
			});
			
			$('.email', this).each(function() {
				v = $(this).val();
				if (!$(this).is('.req') && v == '') return;
				
				if (!tests['email'][1](v)) {
					showError(this, tests['email'][0]);
					validated = false;
				} else
					clearError(this);

			});
			
//			if (!validated) { alert(message); return false; }
//			if (!validated) { alert('Please fill in the form correctly!'); return false; }
			
			$('.url', this).each(function() {
				v = $(this).val();
				if (!$(this).is('.req') && v == '') return;
				
				if (!tests['url'][1](v)) {
					showError(this, tests['url'][0]);
					validated = false;
				} else
					clearError(this);
			});

//			if (!validated) { alert('Please fill in the form correctly!'); return false; }


			
			if (!validated) { return false; }

			numValid++;
			return true;
		}).length;
	
		if (numValid == total) return true;
		return false;	
	};

	$(form).submit(function() {
	
	$('.submit_button').blur();
	//alert(validate.apply(this) ? 'yes' : 'no');
	if (!validate.apply(this)) return false;
		
		$('#trailer')
		.find('.bar').attr('src', '/lib/i/altar/bar.gif?x=' + Math.random() + '.gif').css({display: 'block', 'opacity': '1'}).end()
		.find('.bar_reflect').attr('src', '/lib/i/altar/bar_reflect.gif?x=' + Math.random() + '.gif').css({display: 'block', 'opacity': '1'}).end()
		.fadeIn();
		
//		alert();;return;
		
		setTimeout(function() {
			$('#altar h2 span span,#altar h2 .highlight,#altar h2 .shadow').html('Your Message has Been Sent!');
			$('#altar h3').html('You should hear from us shortly.');
			$('#trailer').fadeOut(900);
		}, 4000);
		
		$.post('http://dragoninteractive.com/lib/p/contact.php', {
			name: $('#c-name').val(),
			email: $('#c-email').val(),
			website: $('#c-website').val(),
			message: $('#c-message').val(),
			spam: 'nope'
		}, function(r) {
			//alert(r);
			setTimeout(function() {
			$('.c-item input,.c-item textarea').val('');
			}, 3700);
		});


		return false;
	});
}