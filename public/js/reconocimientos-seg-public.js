(function( $ ) {
	'use strict';			
	$(function() {		
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
			placeholder: "Escribe el nombre de usuario",
			list: {
				maxNumberOfElements: 5,
				match: {
					enabled: true
				},
				onChooseEvent: function () {
					var value = $("#postTitle").getSelectedItemData().id;
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
		jQuery("#postTitle").easyAutocomplete(options);
	});
	/** funcion para tener un contador de caracteres */
	$(function() {
		$.fn.charCount = function(options){
			// default configuration properties
			var defaults = {	
				allowed: 140,		
				warning: 25,
				css: 'counter',
				counterElement: 'span',
				cssWarning: 'warning',
				cssExceeded: 'exceeded',
				counterText: ''
			}; 
				
			var options = $.extend(defaults, options); 
			
			function calculate(obj){
				var count = $(obj).val().length;
				var available = options.allowed - count;
				if(available <= options.warning && available >= 0){
					$(obj).next().addClass(options.cssWarning);
				} else {
					$(obj).next().removeClass(options.cssWarning);
				}
				if(available < 0){
					$(obj).next().addClass(options.cssExceeded);
				} else {
					$(obj).next().removeClass(options.cssExceeded);
				}
				$(obj).next().html(options.counterText + available);
				console.log( count );
			};
					
			this.each(function() {
				$('#postTitleHelp').after('<'+ options.counterElement +' class="' + options.css + '">'+ options.counterText +'</'+ options.counterElement +'>');
				calculate(this);
				$(this).keyup(function(){calculate(this)});
				$(this).change(function(){calculate(this)});
			});		
		}
		jQuery("#postContent").charCount({
		allowed: 140,		
		warning: 20
	});		
});
	$( function() {		
		$('#postLoad').on('click',function( event ) {	
			console.log("Size: "+ $('#reconocimiento_usuario').val());
			if ( $('#reconocimiento_usuario').val().length > 0 ) {
				return true;
			}else {
				alert("¡No olvides llenar los campos!");
				return false;
			}
			// return true
		})
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
