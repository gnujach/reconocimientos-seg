(function( $ ) {
	'use strict';			
	$(function() {			
		$("#btn1" ).on('click', function (event){			
			var data = {
				'action':	'my_action',
				'whatever':	ajax_object.we_value,
				'search_term':	$('#reconocimiento_usuario').val(),
				'security':	ajax_object.security
			};			
			event.preventDefault();
			jQuery.post(ajax_object.ajax_url, data, function( response ){				
				var respuesta = new Array();
				var respuesta = JSON.stringify( response );
				console.log( respuesta );
			},'json');
		});
		var options = {		
			url: ajax_object.ajax_url,
			getValue: "name",
			ajaxSettings: {
				'dataType': "json",
				data: {
					'method':	"POST",
					'action':	'my_action',
					'security': ajax_object.security,
				}
			},
			placeholder: "Escribe el nombre",
			list: {
				maxNumberOfElements: 5,
				match: {
					enabled: true
				},
				onChooseEvent: function () {
					var value = $("#autocomplete").getSelectedItemData().id;
					$('#reconocimiento_usuario').val(value).trigger("change");
					console.log("Select user: "+ $('#reconocimiento_usuario').val())
				},
				showAnimation: {
					type: "fade", //normal|slide|fade
					time: 400,
					callback: function() {}
				},
				hideAnimation: {
					type: "slide", //normal|slide|fade
					time: 400,
					callback: function() {}
				}
			},
			theme: "blue-light",
			template: {
				type: "iconLeft",
				fields: {
					iconSrc: "icon"
				}
			}
		}
		jQuery("#autocomplete").easyAutocomplete(options);
	});
	

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

})( jQuery );