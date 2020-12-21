
	jQuery(document).ready(function($) {
		"use strict";

		
		// console.log('Save input:'+jQuery('.wpb_bootstrap_modals .wpb_save_edit_form').length);
		
		
		
		$('.ewf-ui-options-item').click(function(){
			var $control = $(this).closest('.ewf-ui-control-options');
			var value = $(this).attr('data-value');
			
			$('.ewf-ui-options-item.ewf-state-active', $control).removeClass('ewf-state-active');
			$(this).addClass('ewf-state-active');
			
			$('input.ewf-ui-input-option').val(value);
		});
		
		
		$('.ewf-ui-cp-dropdown .ewf-cp-dropdown-current').click(function(){
			var $control = $(this).closest('.ewf-ui-cp-dropdown');
			$control.toggleClass('active');
		});
		
		$('.ewf-tooltip').tipsy();
		
		
		$(document).on( 'click', '.ewf-ui-cp-dropdown li', function(){
			var $control = $(this).closest('.ewf-ui-cp-dropdown');
			var value = $(this).attr('data-value');
			
			$('.ewf-cp-dropdown-current', $control).html(value).attr('data-value', value);
			$control.removeClass('active');
			
			var control = $(this).closest('.ewf-ui-hlp-property-set');
			ewf_ui_helper_serialize(control, '.ewf-ui-hlp-property-set-input');
		});
		
		
		$('.ewf-ui-cp-button-toggle').click(function(){
			if ($(this).hasClass('ewf-state-disabled')){
				return false;
			}
		
			$(this).toggleClass('ewf-state-active');
			
			if ($(this).hasClass('ewf-state-active')){
				$(this).attr('data-value', 'true');
			}else{
				$(this).attr('data-value', 'false');
			}
			
			var control = $(this).closest('.ewf-ui-hlp-property-set');
			ewf_ui_helper_serialize(control, '.ewf-ui-hlp-property-set-input');
		});
		
		
		
		
		$(document).on( 'click', '.ewf-ui-font-search li', function(){
			var control = $(this).closest('.ewf-ui.ewf-ui-font');
			var font = $(this).html();
			
			$('.ewf-ui-font-current', control).html(font).attr('data-value', font);
			
			var ajaxPath = siteURL+'/wp-admin/admin-ajax.php'; 
			var control_set = $(this).closest('.ewf-ui-hlp-property-set');
			var list = $('.ewf-ui-font-variant .ewf-ui-cp-dropdown ul', control_set);
			
			
			ewf_ui_helper_serialize(control_set, '.ewf-ui-hlp-property-set-input');
			$('li', list).remove();
			
			$.post( ajaxPath, { action:"ewf_ui_font_variants", font: font }, function(response){
				for(var i in response.data.variants) {
				
					// console.log('Font:'+font_variant);
					var font_variant = response.data.variants[i];
					$(list).append('<li data-value="'+font_variant+'">'+font_variant+'</li>');
					
				}
			}, "json");
			
			$('.ewf-ui-font-search', control).addClass('hidden');
		});
		
		
		$('.ewf-ui-font-current').click(function(){
			var control = $(this).closest('.ewf-ui.ewf-ui-font');
			
			if ($('.ewf-ui-font-search', control).hasClass('hidden')){
				$('.ewf-ui-font-search', control).removeClass('hidden');
				// $('.ewf-font-ui-selector', control).removeClass('active');
				$('.ewf-ui-input-font-search', control).val('').focus().change();
			}else{
				$('.ewf-ui-font-search', control).addClass('hidden');
				// $('.ewf-font-ui-selector', control).addClass('active');
			}
		});

		$(".ewf-ui-font .ewf-ui-input-font-search").each(function(){
			var control = $(this).closest('.ewf-ui.ewf-ui-font');
			var fontList = $('ul', control);
			
			$(this).fastLiveFilter(fontList);
		});
		
		
		
		
		
		
		
		
		
		$('.metabox-composer-content .vc_loading_block').on("DOMSubtreeModified", function(){ 
			console.log('Data loaded');
			ewf_composer_row_update();
		});
		
		
		$(document).on( "click", '.wpb-element-edit-modal button.wpb_save_edit_form', function(){	 		
			ewf_composer_row_update();
		});
		
		
		
		$('.ewf-ui-background-setting li').click(function() {
			if ($(this).hasClass('active')){
				return false;
			}
			
			var list = $(this).closest('ul');
			var property = $(this).attr('data-value');
			var preview = $(this).attr('data-preview');
			var setting = $(this).closest('.ewf-ui-background-setting');
			
			
			$(this).closest('.ewf-ui-background-image-property').find('.ewf-ui-background-image-preview').addClass('active');
			$(this).closest('.ewf-ui-background-image-property').find('.ewf-ui-background-image-preview > img').attr('src', preview);
			
			$(this).closest('.ewf-ui-background-image-property').removeClass('choose-pattern image-none').addClass('image-selected');
			
			$(this).closest('.ewf-ui-background-image').find('.ewf-ui-background-image-preview-property .active').attr('data-value', preview);
			$(this).closest('.ewf-ui-background-image-preview.active').attr('data-value', property);
			
			
			$('> li.active', list).removeClass('active');
			$(this).addClass('active');
			$('input', setting).val(property);
			

			var control = $(this).closest('.ewf-ui-control-background');
			ewf_ui_helper_serialize(control, '.ewf-ui-input-background');
		});

		
		


		// $(".ewf-ui-input-font-search").fastLiveFilter(".ewf-ui-font ul");
		
		
		
		// $(".ewf-ui-font .ewf-ui-input-font-search").on("keyup click input", function () {
			// var control = $(this).closest('.ewf-ui.ewf-ui-font');
			// var fontList = $('ul', control);

			// if (this.value.length > 0) {
			  // $("li", fontList).hide().filter(function () {
				// return $(this).text().toLowerCase().indexOf( $(fontList).val().toLowerCase()) != -1;
			  // }).show();
			// }
			// else {
			  // $("li", fontList).hide();
			// }
		 

			// var searchTerm = $(this).val();
			// var listItem = $('ul', control).children('li');
			// var fontItems = $('ul .in', control).length;

			// var searchSplit = searchTerm.replace(/ /g, "'):containsi('")

			// $.extend($.expr[':'], { 'containsi': function(elem, i, match, array){
				// return (elem.textContent || elem.innerText || '').toLowerCase()
				// .indexOf((match[3] || "").toLowerCase()) >= 0;
				// }
			// });


			// $('ul li', control).not(":containsi('" + searchSplit + "')").each(function(e)   {
			  // $(this).addClass('hiding out').removeClass('in');
			  // setTimeout(function() {
				  // $('.out').addClass('hidden');
				// }, 300);
			// });

			// $("ul li:containsi('" + searchSplit + "')", control).each(function(e) {
			  // $(this).removeClass('hidden out').addClass('in');
			  // setTimeout(function() {
				  // $('.in').removeClass('hiding');
				// }, 1);
			// });

			// if(fontItems == '0') {
			  // $('ul', control).addClass('empty');
			// }else{
			  // $('ul', control).removeClass('empty');
			// }

		// });

			
			
			
			
		
		
		
		
		
		
		

		
		
		
		
		$('.ewf-ui-background-image-pattern').click(function(event){
			$(this).closest('.ewf-ui-background-image-property').addClass('choose-pattern');
			return false;
		});
		
		$('.ewf-ui-background-image-cancel').click(function(){
			$(this).closest('.ewf-ui-background-image-property').removeClass('choose-pattern');
			return false;
		});
		
		
		$('.ewf-ui-background-image-remove').click(function(event){
			event.preventDefault();
			
			var component = $(this).closest('.ewf-ui-control-background');
			var property = $(this).closest('.ewf-ui-background-setting');
			
			property.removeClass('image-selected').addClass('image-none');
			
			$('input', property).val('');
			$('.ewf-ui-background-image-preview', property).attr('data-value', '');
			
			ewf_ui_helper_serialize(component, '.ewf-ui-input-background');
		});		

		
		$('.ewf-ui-background-image-upload').click(function(event){
			var button = this;
			var $control = $(this).closest('.ewf-ui-background-setting');
			var component = $(this).closest('.ewf-ui-control-background');
			var ajaxPath = siteURL+'/wp-admin/admin-ajax.php'; 
			
			$control.addClass('uploading-media');
			
			event.preventDefault();
			
			
			if ( file_frame ) {
				file_frame.open(); 
				return;
			}
			
			
			file_frame = wp.media.frames.file_frame = wp.media({
				title: jQuery(this).data( 'uploader_title' ),
				button: { text: jQuery(this).data( 'uploader_button_text' ) },
				multiple: false
			});
			
			
			file_frame.on( 'select', function() {
				var selection = file_frame.state().get('selection');
				// var image_size = $('.ewf-ui-control-image', $control).attr('data-image-size');
				
				$control = $('.ewf-ui-background-setting.uploading-media');

				selection.map(function( attachment) {
					attachment = attachment.toJSON(); 

					$control.removeClass('uploading-media image-none').addClass('image-selected');
					// console.log(attachment);
					// console.log(attachment.sizes.full.url);
					
					$control.find('input').val(attachment.sizes.full.url);
					$control.find('.ewf-ui-background-image-preview').attr('data-value', attachment.sizes.full.url);
					
					if (typeof(attachment.sizes.medium) != 'undefined' ){
						$control.find('.ewf-ui-background-image-preview img').attr('src', attachment.sizes.medium.url);
						$('.ewf-ui-background-image-preview-property input', component).val(attachment.sizes.medium.url);
						$('.ewf-ui-background-image-preview-property .active', component).attr('data-value', attachment.sizes.medium.url);
					}else{
						$control.find('.ewf-ui-background-image-preview img').attr('src', attachment.sizes.full.url);
						$('.ewf-ui-background-image-preview-property input', component).val(attachment.sizes.full.url);
						$('.ewf-ui-background-image-preview-property .active', component).attr('data-value', attachment.sizes.full.url);
					}
					
					
					
					
					ewf_ui_helper_serialize(component, '.ewf-ui-input-background');
					// $.post( ajaxPath, { action:"ewf_ui_setImage", image_id:attachment.id, image_size: image_size  }, function(response){
						
						// if (response.data.state == 1){
							
							// $('.ewf-ui-image-preview', $control).attr('src', response.data.image_url);
							// $('.ewf-ui-input-image', $control).val(response.data.image_url);
							// $('.ewf-ui-image-wrapper', $control).addClass('active'); 
							

						// }
						
					// }, "json");
					
				});
				
			});

			file_frame.open();
		});
		
		
		// $('.ewf-ui-background-tabs li').click(function(){
			// var control = $(this).closest('div');
			// var tabs = $(this).closest('ul');
			
			// var related_content = $(this).attr('data-related');
			
			// if ($(this).hasClass('active')){
					// return false;
			// }
			
			// $('.ewf-ui-background-tab-content.active', control).removeClass('active');
			// $('.ewf-ui-background-tab-content'+related_content).addClass('active');
			
			// $('li.active', tabs).removeClass('active');
			// $(this).addClass('active');
			
			// return false;
		// });
		
		
		$('.ewf-ui-background-setting').each(function(){
			var active = false;
			if ($('.active', this).attr('data-value') == 'true'){  active = true;  }
		
		
			$('.toggle', this).toggles({ on: active, type: 'compact' }).on('toggle', function (e, active){
				var control = $(this).closest('.ewf-ui-background-setting');
				
				$('.active', control).attr('data-value', active);
				$('input', control).val(active);
				
				var component = $(this).closest('.ewf-ui-control-background');
				ewf_ui_helper_serialize(component, '.ewf-ui-input-background');
			});
		});
		
		
		
		$('.ewf-ui-control-toggle').each(function(){
			var active = false;
			if ($(this).attr('data-enabled') == 'true'){  active = true;  }
			
			var data_dependency = $(this).closest('.ewf-ui[data-dependency]').attr('data-dependency');

				
			if ($(this).closest('.ewf-ui[data-dependency]').length){
				var dependency = data_dependency.split(" ");
				
				//	DEBUG
				// 	console.log('Dependency item: '+dependency);
			
				if (active){
					dependency.forEach(function(element) {
						$('.ewf-ui'+element).removeAttr('data-disabled');
					});
				}else{
					dependency.forEach(function(element) {
						$('.ewf-ui'+element).attr('data-disabled', 'true');
					});
				}
			}
			
			
			$('.toggle', this).toggles({ on: active, type: 'compact' }).on('toggle', function (e, active){
				var control = $(this).closest('.ewf-ui.ewf-ui-toggle');
				var options = $('.ewf-admin-options-wrapper');
				
				$('.ewf-ui-input-toggle', control).val(active);
				
				if ($('.ewf-ui.ewf-ui-toggle[data-dependency]').length){
					var data_dependency =  control.attr('data-dependency');
					
					if (data_dependency){
						var dependency = data_dependency.split(" ");
						
						if (active){
							dependency.forEach(function(element) {
								$('.ewf-ui'+element).removeAttr('data-disabled');
							});
						}else{
							dependency.forEach(function(element) {
								$('.ewf-ui'+element).attr('data-disabled', 'true');
							});
						}
					}
				}
				
			});
			
			
			
		});
		
		
		

		$('.ewf-ui-columns-tabs > div').click(function(){
			var related = $(this).attr('data-related');
			
			if ($(this).hasClass('active')){
				if ($('.ewf-ui-control-columns').hasClass('expanded') === false){
					$('.ewf-ui-control-columns').addClass('expanded');
				}else{
					return false;
				}
			}
			
			$('.ewf-ui-columns-tabs > div.active').removeClass('active');
			$(this).addClass('active');
			
			$('.ewf-ui-columns-tab-content.active').removeClass('active');
			$('.ewf-ui-columns-tab-content.'+related).addClass('active');
		});
		
		
		
		$('.ewf-ui-columns-setcol-wrapper a').click(function(){
			if ($(this).hasClass('active')){
				return false;
			}
			
			var control = $(this).closest('.ewf-ui-control-columns');
			var columns = parseInt($(this).attr('data-columns'), 10);
			var columns_size = $(this).attr('data-size');
			
			
			//	Change column selection on UI
			//
			$('.ewf-ui-columns-setcol-wrapper a.active', control).removeClass('active');
			$(this).addClass('active');
			
			
			$(control).attr('data-columns', columns);
			$('.ewf-ui-input-columns', control).val(columns_size);
			$('.ewf-ui-columns-tab-columns span', control).html(columns);

			
			ewf_ui_columns_generate(this);
			return false;
		});
		
		
		$('.ewf-ui-input-columns').each(function(){
			ewf_ui_columns_generate(this);
			ewf_ui_columns_resize(this);
		});
		
		
		$(document).on('click', '.ewf-ui-column-editor span', function(){
			var minSpan = 2;
			var src_columns = '';
			var src_tmp = '';
			var column_smaller = '';
			
			var control = $(this).closest('.ewf-ui-control-columns');
			var direction = $(this).attr('class');
			
			
			if (columns < 2){ 
				console.log('Not enough columns, minimum required: 2!');
				return false; 
			}

			var span_current = parseInt($(this).closest('div').attr('data-columns'), 10);
			var span_new = span_current+1;

			
			if (direction == 'right') {
				column_smaller =  $(this).closest('div').next();
			}else{
				column_smaller =  $(this).closest('div').prev();
			}

			var column_smaller_span = parseInt($(column_smaller).attr('data-columns'), 10);
			var column_smaller_span_new = column_smaller_span-1;
			
			
			if (column_smaller_span_new >= minSpan){
			
				$(this).closest('div').removeClass('ewf-ml-ftcol'+span_current).addClass('ewf-ml-ftcol'+span_new).attr('data-columns', span_new);
				$(column_smaller).removeClass('ewf-ml-ftcol'+column_smaller_span).addClass('ewf-ml-ftcol'+column_smaller_span_new).attr('data-columns', column_smaller_span_new);
			
			}else{
			
				console.log('Column cannot be resized, min span reached! ['+column_smaller_span_new+']');
			
			}			
			
			
			//	Generate columns size string
			//	
			$('.ewf-ui-column-editor > div', control).each(function(){
				if (src_columns === ''){
					src_tmp = $(this).attr('data-columns');
				}else{
					var current = ',' + $(this).attr('data-columns');
					src_tmp = src_columns + current;
				}

				src_columns = src_tmp;
			});	
			$('.ewf-ui-input-columns', control).val(src_columns);

			
			// console.log('columns:'+src_columns);
			
			return false;
		});

		
		function ewf_composer_row_update(){
		
			$('.wpb_vc_row.wpb_sortable').each(function(){
				var is_fullwidth = $('.wpb_element_wrapper .wpb_vc_param_value.fullwidth', this).html();
				console.log('Fullwidth: ' + is_fullwidth);
				
				
				
				if (is_fullwidth === '1'){
					$(this).addClass('ewf-row-full-width');
				}else{
					if ($(this).hasClass('ewf-row-full-width')){
						$(this).removeClass('ewf-row-full-width');
					}
				}
			});
		
		}
		
		
		function ewf_ui_columns_resize(element){
			var control = $(element).closest('.ewf-ui-control-columns');
			var columns_size = $('.ewf-ui-input-columns', control).val();			
			var sizes = columns_size.split(",");
			
			$('.ewf-ui-column-editor > div', control).each(function(index){
				$(this).attr('class', 'ewf-ml-ftcol'+sizes[index]).attr('data-columns', sizes[index]);
			});
		}
		
		
		function ewf_ui_columns_generate(element){
			var control = $(element).closest('.ewf-ui-control-columns');
			var columns = parseInt($(control).attr('data-columns'), 10);
			
			$('.ewf-ui-column-editor').html('');
			
			if (columns === 4){
				$('.ewf-ui-column-editor', control).append('<div class="ewf-ml-ftcol3" data-columns="3"><span class="right"></span></div>');
				$('.ewf-ui-column-editor', control).append('<div class="ewf-ml-ftcol3" data-columns="3"><span class="right"></span><span class="left"></span></div>');
				$('.ewf-ui-column-editor', control).append('<div class="ewf-ml-ftcol3" data-columns="3"><span class="right"></span><span class="left"></span></div>');
				$('.ewf-ui-column-editor', control).append('<div class="ewf-ml-ftcol3" data-columns="3"><span class="left"></span></div>');
			}
			
			if (columns === 3){
				$('.ewf-ui-column-editor', control).append('<div class="ewf-ml-ftcol4" data-columns="4"><span class="right"></span></div>');
				$('.ewf-ui-column-editor', control).append('<div class="ewf-ml-ftcol4" data-columns="4"><span class="right"></span><span class="left"></span></div>');
				$('.ewf-ui-column-editor', control).append('<div class="ewf-ml-ftcol4" data-columns="4"><span class="left"></span></div>');
			}
			
			if (columns === 2){
				$('.ewf-ui-column-editor', control).append('<div class="ewf-ml-ftcol6" data-columns="6"><span class="right"></span></div>');
				$('.ewf-ui-column-editor', control).append('<div class="ewf-ml-ftcol6" data-columns="6"><span class="left"></span></div>');
			}
			
			if (columns === 1){
				$('.ewf-ui-column-editor', control).append('<div class="ewf-ml-ftcol12" data-columns="12"></div>');
			}

			
			
			// console.log('Loading columns:'+columns);
		} 
	
		

		function ewf_ui_helper_serialize(control, field){
			var array_properties = [];
			
			$('.ewf-ui-hlp-property', control).each(function(index){
			
			
				var val_property = $('input[data-property]', this).attr('data-property');
				// var val_property = $('> input', this).attr('data-property');
				var val_value = $('.active', this).attr('data-value');


				// console.log('Iterate properties - '+index+' - ['+val_property+']['+val_value+']');
				array_properties.push({name: val_property, value: val_value});
			});
		
			var array_serialized = JSON.stringify(array_properties);
			$(field, control).val(array_serialized);
		}
		
		
		
		
		var file_frame;
		
		$('.ewf-ui-image-upload').click(function(event){
			var button = this;
			var $control = $(this).closest('.ewf-ui.ewf-ui-image');
			var ajaxPath = siteURL+'/wp-admin/admin-ajax.php'; 
			
			$control.addClass('uploading-media');
			
			event.preventDefault();
			
			
			if ( file_frame ) {
				file_frame.open(); 
				return;
			}
			
			
			file_frame = wp.media.frames.file_frame = wp.media({
				title: jQuery(this).data( 'uploader_title' ),
				button: { text: jQuery(this).data( 'uploader_button_text' ) },
				multiple: false
			});
			
			
			file_frame.on( 'select', function() {
				var selection = file_frame.state().get('selection');
				var image_size = $('.ewf-ui-control-image', $control).attr('data-image-size');
				
				$control = $('.ewf-ui.ewf-ui-image.uploading-media');

				selection.map(function( attachment) {
					attachment = attachment.toJSON(); 
					
					$.post( ajaxPath, { action:"ewf_ui_setImage", image_id:attachment.id, image_size: image_size  }, function(response){
						
						if (response.data.state == 1){
							
							$('.ewf-ui-image-preview', $control).attr('src', response.data.image_url);
							$('.ewf-ui-input-image', $control).val(response.data.image_url);
							$('.ewf-ui-image-wrapper', $control).addClass('active'); 
							
							$control.removeClass('uploading-media');

						}
						
					}, "json");
					
				});
				
			});

			file_frame.open();
		
		});
			
		$('a.media-button-select').on('click', function() {
			wp.media.model.settings.post.id = wp_media_post_id;
		});
		
		
		
		$('.ewf-ui-color .ewf-ui-input-color').wpColorPicker();
		$('.ewf-ui-background .ewf-ui-input-background-color').wpColorPicker({palettes: false, change: function(){
			var control = $(this).closest('.ewf-ui-control-background');
		
			$(this).attr('data-value', $(this).val());
			ewf_ui_helper_serialize(control, '.ewf-ui-input-background');
			
		}});
		
		
		
		$('.ewf-ui-slider').each(function(){
			var control = $(this);
			
			var value = parseInt($('.ewf-ui-input-slider', control).val(), 10);
			var value_max = parseInt($('.ewf-ui-control-slider', control).attr('data-max'), 10);
			var value_min = parseInt($('.ewf-ui-control-slider', control).attr('data-min'), 10);
			var value_step = '';
			
			if ($('.ewf-ui-control-slider[data-step]', control).size()){
				value_step = parseInt($('.ewf-ui-control-slider', control).attr('data-step'), 10);
			}else{
				value_step = 1;
			}

			$('.ewf-ui-control-slider', control).slider({
				orientation: "horizontal",
				range: 'min',
				min: value_min,
				max: value_max,
				value: value,
				step: value_step,
				slide: function( event, ui ) {
					$('.ewf-ui-input-slider', control).val( ui.value+'px' );
				},
				animate: true
			});
		});
		
		
		
		$('.ewf-admin-option-restore').click(function(){
			$('.ewf-admin-action').val("reset");
			$(this).closest('form').submit();
			return false;
		});
		
		
		
		$('.ewf-admin-vertical-nav li').click(function(){
			if ($(this).hasClass('active')){
				return false;
			}
		
			var panel = $(this).attr('data-panel');
			var tab = $(this);
			var ajaxPath = siteURL+'/wp-admin/admin-ajax.php'; 
			
			$('.ewf-admin-vertical-nav li.active').removeClass('active');
			$(this).addClass('active');
			
			if ($('.ewf-panel.active').length){
				$('.ewf-panel.active').fadeOut('fast', function(){
					$(this).removeClass('active').removeAttr('style');
					
					$('.'+panel).fadeIn('fast', function(){
						$.post( ajaxPath, { action:"ewf_ui_setTab", admin_tab: $(tab).attr('data-panel')  }, function(response){ });

						$(this).addClass('active');
					});
				});
			}else{
				$('.'+panel).fadeIn('fast', function(){
					$.post( ajaxPath, { action:"ewf_ui_setTab", admin_tab: $(tab).attr('data-panel')  }, function(response){ });
					
					$(this).addClass('active');
				});
			}
			
			return false;
		});
		
		
		if ($('.ewf-admin-options .ewf-admin-notice:visible').length){
			$('.ewf-admin-options .ewf-admin-notice').delay(4000).slideUp(400);
		}
		
		
		
		
		
		
		
		
		
		
		/*
		
		$('.ewf-post-image').hover(function(){
			$('div', this).stop(true,true).fadeIn('slow');
		}, function(){
			$('div', this).stop(true,true).fadeOut('slow');
		});
		
		
		$(document).on('click', '.ewf-post-image img', function() {	
			var widget = $(this).closest('.widget-content');
			var img_id = $(this).attr('alt');
			
			$('.img-id', widget).attr('value',img_id);
			$('.widget-article-post-imgs', widget).fadeOut('slow');
			
		});
		
		*/
		
		
		/*
		$('.ewf-ui-input-slider').click(function(event){
			event.preventDefault();
		});
		*/
		 
		 
		/*
		$(document).on('click', '.panel .controls', function(){
			var panelBody = $(this).closest('.panel');
			var panelContent = $('.panel-content', panelBody);
			
			
			if ($(this).hasClass('down')){
				$(panelContent).slideDown();
				$(this).removeClass('down');
			}else{
				$(panelContent).slideUp();
				$(this).addClass('down');
			}	
		});		 
		*/
		 
		 
		/*
		$(document).on('click', '.full-panel .tabs li', function (){
			var fullPanel = $(this).closest('.full-panel');
			var tabID = $(this).attr('id');
			
			$('.tabs li.current', fullPanel).removeClass('current');
			$(this).addClass('current');
			
			$('.panel:not(.'+tabID+')', fullPanel).css('display','none');
			$('.panel.'+tabID, fullPanel).css('display','block');
		});
		*/
		 
		 
		/*
		$('input.ewf-input-color').wpColorPicker();
		*/
		 
		 
		/*
		$(document).on('click', '.ewf-upload-input .button', function(){
			var parent = $(this).closest('.ewf-upload-input');
			
			window.send_to_editor = function(html) {
				var imgurl = $('img',html).attr('src');		
				$('.upload-path', parent).val(imgurl);
				
				tb_remove();
			};
		
			tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
			return false;
		});
		*/
		
		
		/*
		$(document).on('click', '.ewf-page-header', function() {	
			var img_id = $(this).attr('alt');
				
			$('.ewf-page-header').removeClass('current');
			$(this).addClass('current');
			
			$('#ewf-page-header-id').attr('value',img_id).addClass('current');
		});
		*/
		
		
	});
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
(function($){
	
/**
 * Implements JSON stringify and parse functions
 * v1.0
 *
 * By Craig Buckler, Optimalworks.net
 *
 * As featured on SitePoint.com
 * Please use as you wish at your own risk.
 *
 * Usage:
 *
 * // serialize a JavaScript object to a JSON string
 * var str = JSON.stringify(object);
 *
 * // de-serialize a JSON string to a JavaScript object
 * var obj = JSON.parse(str);
 */

var JSON = JSON || {};

// implement JSON.stringify serialization
JSON.stringify = JSON.stringify || function(obj) {

    var t = typeof(obj);
    if (t != "object" || obj === null) {

        // simple data type
        if (t == "string") obj = '"' + obj + '"';
        return String(obj);

    } else {

        // recurse array or object
        var n, v, json = [],
            arr = (obj && obj.constructor == Array);

        for (n in obj) {
            v = obj[n];
            t = typeof(v);

            if (t == "string") v = '"' + v + '"';
            else if (t == "object" && v !== null) v = JSON.stringify(v);

            json.push((arr ? "" : '"' + n + '":') + String(v));
        }

        return (arr ? "[" : "{") + String(json) + (arr ? "]" : "}");
    }
};


// implement JSON.parse de-serialization
JSON.parse = JSON.parse || function(str) {
    if (str === "") str = '""';
    eval("var p=" + str + ";");
    return p;
};


	
/**
 * fastLiveFilter jQuery plugin 1.0.3
 * 
 * Copyright (c) 2011, Anthony Bush
 * License: <http://www.opensource.org/licenses/bsd-license.php>
 * Project Website: http://anthonybush.com/projects/jquery_fast_live_filter/
 **/

	jQuery.fn.fastLiveFilter = function(list, options) {
		// Options: input, list, timeout, callback
		options = options || {};
		list = jQuery(list);
		var input = this;
		var lastFilter = '';
		var timeout = options.timeout || 0;
		var callback = options.callback || function() {};
		
		var keyTimeout;
		
		// NOTE: because we cache lis & len here, users would need to re-init the plugin
		// if they modify the list in the DOM later.  This doesn't give us that much speed
		// boost, so perhaps it's not worth putting it here.
		var lis = list.children();
		var len = lis.length;
		var oldDisplay = len > 0 ? lis[0].style.display : "block";
		callback(len); // do a one-time callback on initialization to make sure everything's in sync
		
		input.change(function() {
			// var startTime = new Date().getTime();
			var filter = input.val().toLowerCase();
			var li, innerText;
			var numShown = 0;
			for (var i = 0; i < len; i++) {
				li = lis[i];
				innerText = !options.selector ? 
					(li.textContent || li.innerText || "") : 
					$(li).find(options.selector).text();
				
				if (innerText.toLowerCase().indexOf(filter) >= 0) {
					if (li.style.display == "none") {
						li.style.display = oldDisplay;
					}
					numShown++;
				} else {
					if (li.style.display != "none") {
						li.style.display = "none";
					}
				}
			}
			callback(numShown);
			// var endTime = new Date().getTime();
			// console.log('Search for ' + filter + ' took: ' + (endTime - startTime) + ' (' + numShown + ' results)');
			return false;
		}).keydown(function() {
			clearTimeout(keyTimeout);
			keyTimeout = setTimeout(function() {
				if( input.val() === lastFilter ) return;
				lastFilter = input.val();
				input.change();
			}, timeout);
		});
		return this; // maintain jQuery chainability
	}


	
/*
 jQuery Toggles v2.0.5
Copyright 2013 Simon Tabor - MIT License
https://github.com/simontabor/jquery-toggles / http://simontabor.com/labs/toggles
*/


$.fn.toggles=function(d){function p(e,b,f,c){var r=e.toggleClass("active").hasClass("active");if(c!==r){var d=e.find(".toggle-inner").css(w);e.find(".toggle-off").toggleClass("active");e.find(".toggle-on").toggleClass("active");a.checkbox.prop("checked",r);if(!k){var l=r?0:-b+f;d.css("margin-left",l);setTimeout(function(){d.css(x);d.css("margin-left",l)},a.animate)}}}d=d||{};var a=$.extend({drag:!0,click:!0,text:{on:"ON",off:"OFF"},on:!1,animate:250,transition:"ease-in-out",checkbox:null,clicker:null,
width:50,height:20,type:"compact"},d),k="select"==a.type;a.checkbox=$(a.checkbox);a.clicker&&(a.clicker=$(a.clicker));d="margin-left "+a.animate+"ms "+a.transition;var w={"-webkit-transition":d,"-moz-transition":d,transition:d},x={"-webkit-transition":"","-moz-transition":"",transition:""};return this.each(function(){var e=$(this),b=e.height(),f=e.width();b&&f||(e.height(b=a.height),e.width(f=a.width));var c=$('<div class="toggle-slide">'),d=$('<div class="toggle-inner">'),t=$('<div class="toggle-on">'),
l=$('<div class="toggle-off">'),h=$('<div class="toggle-blob">'),m=b/2,s=f-m;t.css({height:b,width:s,textAlign:"center",textIndent:k?"":-m,lineHeight:b+"px"}).html(a.text.on);l.css({height:b,width:s,marginLeft:k?"":-m,textAlign:"center",textIndent:k?"":m,lineHeight:b+"px"}).html(a.text.off).addClass("active");h.css({height:b,width:b,marginLeft:-m});d.css({width:2*f-b,marginLeft:k?0:-f+b});k&&(c.addClass("toggle-select"),e.css("width",2*s),h.hide());e.html(c.html(d.append(t,h,l)));c.on("toggle",function(a,
d){a&&a.stopPropagation();p(c,f,b);e.trigger("toggle",!d)});e.on("toggleOn",function(){p(c,f,b,!1)});e.on("toggleOff",function(){p(c,f,b,!0)});a.on&&p(c,f,b);if(a.click&&(!a.clicker||!a.clicker.has(e).length))e.on("click touchstart",function(b){b.stopPropagation();b.target==h[0]&&a.drag||c.trigger("toggle",c.hasClass("active"))});if(a.clicker)a.clicker.on("click touchstart",function(b){b.stopPropagation();b.target==h[0]&&a.drag||c.trigger("toggle",c.hasClass("active"))});if(a.drag&&!k){var g,u=(f-
b)/4,v=function(k){e.off("mousemove touchmove");c.off("mouseleave");h.off("mouseup touchend");var q=c.hasClass("active");!g&&a.click&&"mouseleave"!==k.type?c.trigger("toggle",q):q?g<-u?c.trigger("toggle",q):d.animate({marginLeft:0},a.animate/2):g>u?c.trigger("toggle",q):d.animate({marginLeft:-f+b},a.animate/2)},n=-f+b;h.on("mousedown touchstart",function(a){g=0;h.off("mouseup touchend");c.off("mouseleave");var b=a.pageX;e.on("mousemove touchmove",h,function(a){g=a.pageX-b;c.hasClass("active")?(a=
g,0<g&&(a=0),g<n&&(a=n)):(a=g+n,0>g&&(a=n),g>-n&&(a=0));d.css("margin-left",a)});h.on("mouseup touchend",v);c.on("mouseleave",v)})}})};})(jQuery);



// tipsy, facebook style tooltips for jquery
// version 1.0.0a
// (c) 2008-2010 jason frame [jason@onehackoranother.com]
// releated under the MIT license

(function($) {

    function fixTitle($ele) {
        if ($ele.attr('title') || typeof($ele.attr('original-title')) != 'string') {
            $ele.attr('original-title', $ele.attr('title') || '').removeAttr('title');
        }
    }

    function Tipsy(element, options) {
        this.$element = $(element);
        this.options = options;
        this.enabled = true;
        fixTitle(this.$element);
    }

    Tipsy.prototype = {
        show: function() {
            var title = this.getTitle();
            if (title && this.enabled) {
                var $tip = this.tip();

                $tip.find('.tipsy-inner')[this.options.html ? 'html' : 'text'](title);
                $tip[0].className = 'tipsy'; // reset classname in case of dynamic gravity
                $tip.remove().css({
                    top: 0,
                    left: 0,
                    visibility: 'hidden',
                    display: 'block'
                }).appendTo(document.body);

                var pos = $.extend({}, this.$element.offset(), {
                    width: this.$element[0].offsetWidth,
                    height: this.$element[0].offsetHeight
                });

                var actualWidth = $tip[0].offsetWidth,
                    actualHeight = $tip[0].offsetHeight;
                var gravity = (typeof this.options.gravity == 'function') ? this.options.gravity.call(this.$element[0]) : this.options.gravity;

                var tp;
                switch (gravity.charAt(0)) {
                    case 'n':
                        tp = {
                            top: pos.top + pos.height + this.options.offset,
                            left: pos.left + pos.width / 2 - actualWidth / 2
                        };
                        break;
                    case 's':
                        tp = {
                            top: pos.top - actualHeight - this.options.offset,
                            left: pos.left + pos.width / 2 - actualWidth / 2
                        };
                        break;
                    case 'e':
                        tp = {
                            top: pos.top + pos.height / 2 - actualHeight / 2,
                            left: pos.left - actualWidth - this.options.offset
                        };
                        break;
                    case 'w':
                        tp = {
                            top: pos.top + pos.height / 2 - actualHeight / 2,
                            left: pos.left + pos.width + this.options.offset
                        };
                        break;
                }

                if (gravity.length == 2) {
                    if (gravity.charAt(1) == 'w') {
                        tp.left = pos.left + pos.width / 2 - 15;
                    } else {
                        tp.left = pos.left + pos.width / 2 - actualWidth + 15;
                    }
                }

                $tip.css(tp).addClass('tipsy-' + gravity);

                if (this.options.fade) {
                    $tip.stop().css({
                        opacity: 0,
                        display: 'block',
                        visibility: 'visible'
                    }).animate({
                        opacity: this.options.opacity
                    });
                } else {
                    $tip.css({
                        visibility: 'visible',
                        opacity: this.options.opacity
                    });
                }
            }
        },

        hide: function() {
            if (this.options.fade) {
                this.tip().stop().fadeOut(function() {
                    $(this).remove();
                });
            } else {
                this.tip().remove();
            }
        },

        getTitle: function() {
            var title, $e = this.$element,
                o = this.options;
            fixTitle($e);
            var title, o = this.options;
            if (typeof o.title == 'string') {
                title = $e.attr(o.title == 'title' ? 'original-title' : o.title);
            } else if (typeof o.title == 'function') {
                title = o.title.call($e[0]);
            }
            title = ('' + title).replace(/(^\s*|\s*$)/, "");
            return title || o.fallback;
        },

        tip: function() {
            if (!this.$tip) {
                this.$tip = $('<div class="tipsy"></div>').html('<div class="tipsy-arrow"></div><div class="tipsy-inner"/></div>');
            }
            return this.$tip;
        },

        validate: function() {
            if (!this.$element[0].parentNode) {
                this.hide();
                this.$element = null;
                this.options = null;
            }
        },

        enable: function() {
            this.enabled = true;
        },
        disable: function() {
            this.enabled = false;
        },
        toggleEnabled: function() {
            this.enabled = !this.enabled;
        }
    };

    $.fn.tipsy = function(options) {

        if (options === true) {
            return this.data('tipsy');
        } else if (typeof options == 'string') {
            return this.data('tipsy')[options]();
        }

        options = $.extend({}, $.fn.tipsy.defaults, options);

        function get(ele) {
            var tipsy = $.data(ele, 'tipsy');
            if (!tipsy) {
                tipsy = new Tipsy(ele, $.fn.tipsy.elementOptions(ele, options));
                $.data(ele, 'tipsy', tipsy);
            }
            return tipsy;
        }

        function enter() {
            var tipsy = get(this);
            tipsy.hoverState = 'in';
            if (options.delayIn == 0) {
                tipsy.show();
            } else {
                setTimeout(function() {
                    if (tipsy.hoverState == 'in') tipsy.show();
                }, options.delayIn);
            }
        };

        function leave() {
            var tipsy = get(this);
            tipsy.hoverState = 'out';
            if (options.delayOut == 0) {
                tipsy.hide();
            } else {
                setTimeout(function() {
                    if (tipsy.hoverState == 'out') tipsy.hide();
                }, options.delayOut);
            }
        };

        if (!options.live) this.each(function() {
            get(this);
        });

        if (options.trigger != 'manual') {
            var binder = options.live ? 'live' : 'bind',
                eventIn = options.trigger == 'hover' ? 'mouseenter' : 'focus',
                eventOut = options.trigger == 'hover' ? 'mouseleave' : 'blur';
            this[binder](eventIn, enter)[binder](eventOut, leave);
        }

        return this;

    };

    $.fn.tipsy.defaults = {
        delayIn: 0,
        delayOut: 0,
        fade: false,
        fallback: '',
        gravity: 'n',
        html: false,
        live: false,
        offset: 0,
        opacity: 0.8,
        title: 'title',
        trigger: 'hover'
    };

    // Overwrite this method to provide options on a per-element basis.
    // For example, you could store the gravity in a 'tipsy-gravity' attribute:
    // return $.extend({}, options, {gravity: $(ele).attr('tipsy-gravity') || 'n' });
    // (remember - do not modify 'options' in place!)
    $.fn.tipsy.elementOptions = function(ele, options) {
        return $.metadata ? $.extend({}, options, $(ele).metadata()) : options;
    };

    $.fn.tipsy.autoNS = function() {
        return $(this).offset().top > ($(document).scrollTop() + $(window).height() / 2) ? 's' : 'n';
    };

    $.fn.tipsy.autoWE = function() {
        return $(this).offset().left > ($(document).scrollLeft() + $(window).width() / 2) ? 'e' : 'w';
    };

})(jQuery);
