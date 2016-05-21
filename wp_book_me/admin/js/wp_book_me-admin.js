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

		 $('.wp_book_me_time_picker').timepicker( {
			 'timeFormat': 'H:i',
			 'disableTextInput': true
		 });


		//validation script for admin group options

		 $("#wp_book_me_adminGroupOptionsForm").validate({

			  rules: {

				  "wp_book_me[groupName]":  {
					  required: true,
					  minlength: 3,
					  //limited by SQL database
					  maxlength: 50
				  },

				  "wp_book_me[numOfRooms]": {
					  required: true,
					  digits: true

				  },

				  "wp_book_me[roomsAvailableUntil]": {
					  required: function(element) {
						  return $("#wp_book_me_roomsAvailableFrom").val().length!= "" ;
					  }
				  },

				  "wp_book_me[roomsAvailableFrom]": {
					  required: true
				  }


			  },

			  messages: {

				  "wp_book_me[groupName]": {
					  minlength: "Please, at least 3 characters are necessary",
					  maxlength: "Max length of 50 characters"
				  },

				  "wp_book_me[numOfRooms]": {
					  digits: "Only numbers are allowed"
				  },

				  "wp_book_me[roomsAvailableUntil]": {
					  required: "Rooms available from field is required first"
				  }

			  }




		 });

          
          //validation script for edit-rooms option page

          $("#wp_book_me_editRoomsSaveAllForm").validate({

              rules: {

                  "wp_book_me[roomOptionName]":  {
                      required: true,
                      minlength: 3,
                      //limited by SQL database
                      maxlength: 50
                  },

                  "wp_book_me[roomOptionCapacity]": {
                      required: true,
                      digits: true

                  },

                  "wp_book_me[roomOptionServices]": {
                      //limited by SQL database
                      maxlength: 100
                  },

                  "wp_book_me[roomOptionDescription]": {
                      //limited by SQL database
                      maxlength: 100
                  }


              },

              messages: {

                  "wp_book_me[roomOptionName]": {
                      minlength: "Please, at least 3 characters are necessary",
                      maxlength: "Max length of 50 characters"
                  },

                  "wp_book_me[roomOptionCapacity]": {
                      digits: "Only numbers are allowed"
                  },

                  "wp_book_me[roomOptionServices]": {
                      maxlength: "Max length of 100 characters"
                  },
                  "wp_book_me[roomOptionDescription]": {
                      maxlength: "Max length of 100 characters"
                  }

              }




          });









      }); // End of DOM Ready

}( jQuery ));