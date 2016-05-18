(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
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
	 
	  $(function(){
 
             


         // WordPress specific plugins - color picker
         $( '.wp_book_me_calendarColor_class' ).wpColorPicker();

		 $('.wp_book_me_time_picker').timepicker({'timeFormat': 'H:i'});
		  
		  
		 $("#wp_book_me_adminGroupOptionsForm").validate({
			  rules: {
				  "wp_book_me[groupName]":  {
					  required: true,
					  minlength: 6
				  },

				  "wp_book_me[numOfRooms]": {
					  required: true,
					  digits: true

				  },
				  "wp_book_me[roomsAvailableUntil]": {
					  required: {
						  depends: function(element) {
							  var status = false;
								//not working properly
							  if( $("#wp_book_me[roomsAvailableFrom]").val() > 0){
								  var status = true;
							  }
							  return status;
						  }
					  }
				  }
			  },
			  messages: {
				  "wp_book_me[groupName]": {
					  minlength: "Please, at least 6 characters are necessary"
				  },
				  "wp_book_me[numOfRooms]": {
					  digits: "Only numbers are allowed"
				  }
			  }

		 });




	  }); // End of DOM Ready

}( jQuery ));