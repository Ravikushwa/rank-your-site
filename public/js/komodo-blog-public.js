(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	jQuery(document).ready(function () {
		jQuery(".komodo-accordion .komodo-accordian-item:first-child() .komodo-accordian-title").addClass("active");
		jQuery(".komodo-accordion .komodo-accordian-item:first-child() .komodo-accordian-tab").slideDown();
		jQuery(".komodo-accordian-title").click(function () {
			jQuery(this)
			.toggleClass("active")
			.next(".komodo-accordian-tab")
			.slideToggle()
			.parent()
			.siblings()
			.find(".komodo-accordian-tab")
			.slideUp()
			.prev()
			.removeClass("active");
		});
		$('#checkAll').change(function() {
			// Check or uncheck all checkboxes based on the master checkbox state
			$('.checkItem').prop('checked', $(this).prop('checked'));
		});
	
		// When any individual checkbox is changed
		$('.checkItem').change(function() {			
			// If all individual checkboxes are checked, check the master checkbox
			if ($('.checkItem:checked').length === $('.checkItem').length) {
				$('#checkAll').prop('checked', true);
			} else {
				// Otherwise, uncheck the master checkbox
				$('#checkAll').prop('checked', false);
			}
		});
	});

})( jQuery );
