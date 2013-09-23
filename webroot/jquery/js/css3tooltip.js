// Function name
jQuery.fn.css3Tooltip = function() {

	// For each instance of this element
	return this.each(function(){

		// Add the new attribute with title's current value and then remove the title attribute
		jQuery(this).attr({'data-sbtooltip': jQuery(this).attr("title")}).removeAttr("title");

	});

};
