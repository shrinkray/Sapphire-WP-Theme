
(function($){
	"use strict";
	
	// wpb_el_type_position
	
    $('.wpb-element-edit-modal .wpb_el_type_ewf-icon i').click(function(){
		var value = $(this).attr('class');
		var seletected_field = $(this).closest('.wpb_el_type_ewf-icon');
		
		$(this).closest('ul').find('.selected').removeClass('selected');
		$(this).closest('li').addClass('selected');
		$(this).closest('.wpb_el_type_ewf-icon').find('input.wpb_vc_param_value').val(value);
		
		$('.ewf-icon-ct-selection i', seletected_field).attr('class', value);
		
	});
	
	
	$('.wpb-element-edit-modal .wpb_el_type_ewf-icon .ewf-icon-ct-cancel').click(function(){
		var field = $(this).closest('.wpb_el_type_ewf-icon');
		var cancel = $(this);
		
			
		$(cancel).hide();
		
		$('.ewf-icon-ct-change', field).html('Change Icon');
		$('.ewf-icon-filters', field).hide(); 

		return false;
		
	});
	
	$('.wpb-element-edit-modal .wpb_el_type_ewf-icon .ewf-icon-ct-selection').click(function(){
		var field = $(this).closest('.wpb_el_type_ewf-icon');
	
		$('.ewf-icon-ct-change').click(); 
	});
	
	$('.wpb-element-edit-modal .wpb_el_type_ewf-icon .ewf-icon-ct-change').click(function(){
		var field = $(this).closest('.wpb_el_type_ewf-icon');
		
		
		if ($(this).html() == "Change Icon"){
			$('.ewf-icon-filters', field).slideDown(); 
			$('.ewf-icon-ct-cancel', field).show();		
			$(this).html('Use Icon');

			return false;
		}
		
		if ($(this).html() == "Use Icon"){
			$('.ewf-icon-filters', field).slideUp(); 
			$('.ewf-icon-ct-cancel', field).hide();		
			$(this).html('Change Icon');

			return false;
		}
				


		

		
	});
	
	$('.wpb-element-edit-modal .wpb_el_type_ewf-icon ul').each(function(){
		var seletected_field = $(this).closest('.wpb_el_type_ewf-icon');
		var selected_icon = $('input.wpb_vc_param_value', seletected_field).val();
		
		
		if (selected_icon != ''){
			$('li', this).removeClass('selected');
			$('i[class="'+selected_icon+'"]', this).closest('li').addClass('selected');
		}
	});
	
	
})(window.jQuery);
