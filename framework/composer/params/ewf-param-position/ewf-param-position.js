
(function($){
	"use strict";
	
	// wpb_el_type_position
	
    $('.wpb-element-edit-modal .ewf-position-box div').click(function(){
        // e.preventDefault();
		
		
		$(this).closest('.ewf-position-box').find('div').removeClass('active');
		$(this).addClass('active');
		
		
		console.log('execute param position shit!');
		
		var value = 'none';
		
		if ($(this).hasClass('ewf-pb-top')) 			{ value = 'top'; }
		if ($(this).hasClass('ewf-pb-top-right')) 		{ value = 'top-right'; }
		if ($(this).hasClass('ewf-pb-top-left')) 		{ value = 'top-left'; }
		if ($(this).hasClass('ewf-pb-bottom')) 			{ value = 'bottom'; }
		if ($(this).hasClass('ewf-pb-bottom-right')) 	{ value = 'bottom-right'; }
		if ($(this).hasClass('ewf-pb-bottom-left')) 	{ value = 'bottom-left'; }
		if ($(this).hasClass('ewf-pb-left')) 			{ value = 'left'; }
		if ($(this).hasClass('ewf-pb-right')) 			{ value = 'right'; }
		
		$(this).closest('.edit_form_line').find('input.wpb_vc_param_value').val(value);

    });
	
	
	
	
})(window.jQuery);