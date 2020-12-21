		

	jQuery(document).ready(function($) {
		"use strict";
		
		var modHeader_fieldDropdown = false;
		
		
		
		ewf_modHeader_handleTabs();
		
		ewf_modHeader_handleToggles();

		ewf_modHeader_handleDropdown();
		
		ewf_modHeader_handleImage();
		
		ewf_modHeader_handleColor();
		
		ewf_modHeader_handleSettings_Templates();
		
		
		
		
		

		

		
		//	Change master page
		//
		$( "#_ewf_modHeader_master_id" ).change(function(){
			var master_id 				= $(this).val();
			var master_page 			= $('.ewf-mh-stgroup .ewf-mh-pages-data-cache a[data-id="'+master_id+'"]');
			var master_header_title 	= $(master_page).attr('data-header-title');
			var master_title 			= $(master_page).attr('data-title');
			var master_excerpt 			= $(master_page).attr('data-excerpt');				
			var master_image 			= $(master_page).attr('data-image');
			var master_background_color = $(master_page).attr('data-background-color');
			
			
			/*
			if (master_id == '0'){
				$('.ewf-mh-stgroup .ewf-mh-stfield').addClass('no-master');
				
				//	If Dropdown Is active
				$('.ewf-mh-stgroup .ewf-mh-stfield').each(function(){
				
					if ($(this).hasClass('mh-type-custom') == false){
						$('.ewf-mh-selDropdown .mh-type-custom', this).click();
					}
				
				});
				
			}else{
			*/
			
			
			$('.ewf-mh-stgroup .ewf-mh-stfield').removeClass('no-master');
				
			
			$('.ewf-mh-stgroup .ewf-mh-fielddrop .mh-type-page-header-title').attr('rel', master_header_title);
			$('.ewf-mh-stgroup .ewf-mh-fielddrop .mh-type-page-title').attr('rel', master_title);
			$('.ewf-mh-stgroup .ewf-mh-fielddrop mh-type-page-excerpt').attr('rel', master_excerpt);
			
			
			$('.ewf-mh-stgroup .ewf-mh-stfield').each(function(){
			
				if ($(this).hasClass('mh-type-title')){
					$('input[type="text"], textarea', this).val(master_title);
				}
				
				if ($(this).hasClass('mh-type-excerpt')){
					$('input[type="text"], textarea', this).val(master_excerpt);
				}
				
				if ($(this).hasClass('mh-type-page-header-title')){
					$('input[type="text"], textarea', this).val(master_header_title);
				}
				
			});
			
			if (master_background_color){
				$('.mh-field-color .wp-color-result').css('background-color', master_background_color)
			}else{
				var page_color = $('.mh-field-color').attr('data-color');
				$('.mh-field-color .wp-color-result').css('background-color', page_color);
				
				// console.log('No Background Color ['+master_id+']');
				// var original_background_color = $('.mh-field-color input').attr('data-original-color');
				// $('.mh-field-color .wp-color-result').attr('background-color', original_background_color) ;
			}
			
			$('.ewf-headerMeta-image .preview').addClass('master-image');
			
			if (master_image){
				$('.ewf-headerMeta-image .ewf-modHeader-master-image').attr('src', master_image);
				$('.ewf-headerMeta-image .preview').removeClass('no-image');
			}else{
				$('.ewf-headerMeta-image .preview').addClass('no-image');
			}
			
			
		}).keyup(function(e){
			var code = (e.keyCode ? e.keyCode : e.which);
			
			if (code == 40) {
				$(this).change();
			} else if (code == 38) {
				$(this).change();
			}
		});
	

		
		function ewf_modHeader_setMasterTitle(field_selector){
		
			var field = $(field_selector);
			var fieldClass = $('input[type="hidden"]', field).val();
			
			var fieldVal = $('.ewf-mh-selDropdown ul a[class="'+fieldClass+'"]', field).attr('rel');
			var currentVal = $('input[type="text"], textarea', field).val();
			
			$('.ewf-mh-fielddrop .'+fieldClass ,field).attr('data-post', currentVal);
			
			
			//	#TODO - Enable change field source
			//
			// $(field).removeClass('mh-type-custom mh-type-title mh-type-excerpt mh-type-page-header-title').addClass(fieldClass);	
			
			
			$('input[type="text"], textarea', field).val(fieldVal);
			$('input[type="hidden"], input[type="text"], textarea', field).prop('disabled', true);

		}
		
		function ewf_modHeader_removeMasterTitle(field_selector){
			var field = $(field_selector);
			var fieldClass = $('input[type="hidden"]', field).val();
			
			var post_header_title 	= $('.mh-type-page-header-title', field).attr('data-post');
			var post_title 			= $('.mh-type-page-title', field).attr('data-post');
			var post_excerpt 		= $('.mh-type-page-excerpt', field).attr('data-post');				
			
			
			$('.ewf-mh-fielddrop .mh-type-page-header-title', field).attr('rel', post_header_title);
			$('.ewf-mh-fielddrop .mh-type-page-title', field).attr('rel', post_title);
			$('.ewf-mh-fielddrop .mh-type-page-excerpt', field).attr('rel', post_excerpt);
			
					
			//	If the field is custom save it's value and replace it with the new one
			//
			var fieldVal = $('.ewf-mh-selDropdown ul a[class="'+fieldClass+'"]', field).attr('rel');
			
			
			//	#TODO - Enable change field source
			//
			// $(field).removeClass('mh-type-custom mh-type-title mh-type-excerpt mh-type-page-header-title').addClass(fieldClass);				
			
			var header_title_value = $('.ewf-mh-fielddrop .'+fieldClass, field).attr('rel');
			
			$('input[type="text"], textarea', field).val(header_title_value);
			$('input[type="hidden"], input[type="text"], textarea', field).prop('disabled', false);
		}
		
	

		function ewf_modHeader_handleColor(){
			$('.mh-field-color input[type="text"]').wpColorPicker( {
				palletes: false,
				change: function(event, ui){
					$(this).closest('.mh-field-color').attr('data-color',  ui.color.toString());
				}
			});
		}	

		function ewf_modHeader_handleDropdown(){
				
				//	Add class on hover & click
				//
				$('.ewf-mh-selDropdown').hover(function(){
				
					$(this).addClass('hover');
					
				}, function(){
				
					if ($(this).hasClass('active')){
						$(this).removeClass('active');
					}
					
					$(this).removeClass('hover');
					
				}).click(function(){
					$(this).addClass('active');
					
					return false;
				});
				
				
				
				$('.ewf-mh-selDropdown ul a').click(function(){
					var field = $(this).closest('.ewf-mh-stfield');
					var fieldType = $(this).text();
					var fieldVal = $(this).attr('rel');
					var fieldClass = $(this).attr('class');
					
					
					//	Close the menu after click
					//
					$(this).closest('.ewf-mh-selDropdown').removeClass('active hover');
					
					
					//	Set field data type
					//
					$(this).closest('.ewf-mh-fielddrop').find('.ewf-mh-selLabel').html(fieldType);
					$('input[type="hidden"]', field).val(fieldClass);
					
					
					
					//	If the field is custom save it's value and replace it with the new one
					//
					if ($(field).hasClass('mh-type-custom')){
						var currentVal = $('input[type="text"], textarea', field).val();
						$('.ewf-mh-fielddrop .mh-type-custom' ,field).attr('rel', currentVal);
					}
					

					
					//	Remove classes from stfield and change field type
					//
					$(field).removeClass('mh-type-custom mh-type-title mh-type-excerpt').addClass(fieldClass);
					
					
					if (fieldClass == 'mh-type-custom'){
						var oldVal = $('.ewf-mh-fielddrop .mh-type-custom'  ,field).attr('rel');
						$('input[type="text"], textarea', field).val(oldVal).prop('disabled', false);
						
						console.log('Restore text: '+oldVal);
					}else{
						$('input[type="text"], textarea', field).val(fieldVal).prop('disabled', true);
					}

					
				});
				
		}
		
		function ewf_modHeader_handleImage(){
		
			//	Upload or choose image from media
			//
			$('#ewf-upload-header-image').click(function(){
				var postID = $('#ewf-upload-header-postID').val();
			
				window.send_to_editor = function(html) {
					var imgurl = $('img',html).attr('src');
					var img_id = $('img',html).attr('class');
					var postID = $('#ewf-upload-header-postID').val();
					var ajaxPath = siteURL+'/wp-admin/admin-ajax.php'; 
					
					tb_remove();
					
					$.post( ajaxPath, { action:"ewf_modHeader_setImage", url:imgurl, post:postID, img:img_id  }, function(response){
						 
						if (response.data.state == 1){ 
							$('#ewf-upload-header-imageURL').val(response.data.thumb_url); 
							$('#ewf-upload-header-imageID').val(response.data.image_id); 
							$('.ewf-modHeader-metaBox .preview .ewf-header-meta-preview').attr('src', response.data.thumb_url);
							$('.ewf-modHeader-metaBox .preview').addClass('active');
						}
						 
					}, "json"); 
				};
			
				tb_show('', 'media-upload.php?post_id='+postID+'&type=image&amp;TB_iframe=true');
				return false;
			});
			
		
			// Remove the current image
			//
			$('#ewf-header-image-remove').click(function(){
				var ajaxPath = siteURL+'/wp-admin/admin-ajax.php';
				var postID = $('#ewf-upload-header-postID').val();
				
				$.post( ajaxPath, { action:"ewf_modHeader_removeImage", "post":postID }, function(response){
					if (response.data.state == 1){
						$('.ewf-modHeader-metaBox .preview').removeClass('active');					
					}
				}, "json"); 
				
				$('#ewf-upload-header-imageID').val(''); 
				
				return false;
			});
		
			
		}

		function ewf_modHeader_handleTabs(){
		

			$('.ewf-mh-tabsBar ul a').click(function(){
				var disabled = $(this).closest('.ewf-mh-tabsBar').hasClass('disabled');
			
				if (disabled) {
					return false;
				}
			
				$('.ewf-mh-tabsBar li.active').removeClass('active');
				$(this).closest('li').addClass('active');
				
				
				var content_class = $(this).attr('data-content');
				
				$('.ewf-mh-tabscontent > div').removeClass('tab-active');
				$('.ewf-mh-tabscontent > div.'+content_class).addClass('tab-active');
				
				
				return false;
			});
		}
		
		function ewf_modHeader_handleToggles(){
			
			
			//	General handler for toggle buttons added in field types
			$('.ewf-mh-stfield.mh-field-toggle').each(function(){
				var active = false;
				
				if ($(this).attr('data-enabled') == 'true'){
					active = true;
				}
				
				$('.toggle', this).toggles({on: active, type: 'compact', checkbox: $('input[type="checkbox"]', this) });
			});
			
			
			
			//	Activate / Deactivate parallax
			//
			$('.ewf-mh-parallax .toggle').on('toggle', function (e, active) {
				var postID = $('#ewf-upload-header-postID').val();
				var ajaxPath = siteURL+'/wp-admin/admin-ajax.php';
				
				if (active) { active = 1; }else{ active = 0; }
				
				$.post( ajaxPath, { "action":'ewf_modHeader_parallax', 'parallax':active, 'post':postID  }, function(data){ }, "json"); 
			});
			
			
			
			//	Activate / Deactivate master page
			//
			$('.ewf-mh-useMaster .toggle').on('toggle', function (e, active) {
				var postID = $('#ewf-upload-header-postID').val();
				var ajaxPath = siteURL+'/wp-admin/admin-ajax.php';
				
				$.post( ajaxPath, { "action":'ewf_modHeader_master_use', 'master_use':active, 'post':postID  }, function(data){
				
					if (active){
						ewf_modHeader_setMasterTitle('.stfield_ewf_modHeader_title');
						
						
						$('.ewf-mh-master-settings').removeClass('disabled');
						
						var master_id = $('#_ewf_modHeader_master_id').val();
						var master_image = $('.ewf-mh-pages-data-cache a[data-id="'+master_id+'"]').attr('data-image');
						var master_background_color = $('.ewf-mh-pages-data-cache a[data-id="'+master_id+'"]').attr('data-background-color');
						
						
						$('.mh-field-color').addClass('disabled');
						if (master_background_color){
							var style_current = $('.mh-field-color .wp-color-result').attr('style');
							$('.mh-field-color .wp-color-result').attr('style-original', style_current) ;
							$('.mh-field-color .wp-color-result').css('background-color', master_background_color)
						}
						
						
						// If the master page does not have an image
						if (master_image){
							$('.ewf-modHeader-master-image').attr(master_image);
							$('.ewf-headerMeta-image .preview').addClass('master-image').removeClass('no-image');
						}else{
							$('.ewf-headerMeta-image .preview').addClass('no-image');
						}
						
						$( "#_ewf_modHeader_master_id" ).change();
					}else{
						var page_color = $('.mh-field-color').attr('data-color');
						$('.mh-field-color .wp-color-result').css('background-color', page_color);
						
						$('.mh-field-color').removeClass('disabled');
						$('.ewf-headerMeta-image .preview').removeClass('master-image');
						ewf_modHeader_removeMasterTitle('.stfield_ewf_modHeader_title');
						$('.ewf-mh-master-settings').addClass('disabled');
						
						$('.ewf-headerMeta-image .preview').removeClass('no-image');
					}
				
				}, "json"); 
			});
			
			
			
			//	Activate / Deactivate page header	
			//
			var ewf_mh_active = true;
			
			if ($('.ewf-mh-mainToggle .toggle').is("[off]")){ ewf_mh_active = false; }
			
			$('.ewf-mh-mainToggle .toggle').toggles({on: ewf_mh_active, type: 'compact' });
			
			$('.ewf-mh-mainToggle .toggle').on('toggle', function (e, active) {
				var postID = $('#ewf-upload-header-postID').val();
				var ajaxPath = siteURL+'/wp-admin/admin-ajax.php';
				
				
				if (active) {
					active = 1;
					$('.ewf-modHeader-metaBox .ewf-mh-tabscontent').removeClass('disabled');
					$('.ewf-modHeader-metaBox .ewf-mh-tabsBar').removeClass('disabled');
					$('.ewf-modHeader-metaBox .ewf-mh-tabsBar ul li:first').addClass('active');
				} else {
					active = 0;
					$('.ewf-modHeader-metaBox .ewf-mh-tabscontent').addClass('disabled');
					$('.ewf-modHeader-metaBox .ewf-mh-tabsBar').addClass('disabled');
				}
				
				$.post( ajaxPath, { "action":'ewf_modHeader_activate', 'active':active, 'post':postID  }, function(data){}, "json"); 
						
				return false;
			});
			
			
			
			
			
		
		}
		
		function ewf_modHeader_handleSettings_Templates(){
			
			
			//	Activate toggles
			//
			$('.ewf-mh-page-templates .toggle').each(function(){
				var active = false;
				
				if ($(this).attr('data-enabled') == 'true'){ 
					active = true; 
				}
				
				$(this).toggles({on: active, type: 'compact' });
			});
			
			
			$('.ewf-mh-page-templates .toggle').on('toggle', function (e, active) {
				var postID = $('#ewf-upload-header-postID').val();
				var ajaxPath = siteURL+'/wp-admin/admin-ajax.php';
				var template = $(this).closest('li').attr('data-setting'); 
				 
				if (active) { 
					active = 1; 
					$(this).closest('li').addClass('header-enabled');
				}else{ 
					$(this).closest('li').removeClass('header-enabled');
					active = 0;
				}
				
				 $.post( ajaxPath, { "action":'ewf_modHeader_useTemplate', 'active':active, 'template':template }, function(data){ }, "json"); 
			});
			
			$('.ewf-mh-page-templates select').change(function(){
				var postID = $('#ewf-upload-header-postID').val();
				var ajaxPath = siteURL+'/wp-admin/admin-ajax.php';			
				var post_id = $(this).val();
				var template = $(this).closest('li').attr('data-setting'); 
				
				 $.post( ajaxPath, { "action":'ewf_modHeader_setTemplate', 'master_id':post_id, 'template':template }, function(data){ }, "json"); 
			});
			
			
			
			
			
		
		}
		
		
		
		function ewf_modHeader_checkMetaSize(){
			var modHeaderWidth = $('.ewf-modHeader-metaBox').width();
			
			if (modHeaderWidth < 260){
				$('.ewf-modHeader-metaBox').removeClass('size-max size-small').addClass('size-side');
			}else{
				$('.ewf-modHeader-metaBox').removeClass('size-max size-small')
			}
		}
		
	});
	