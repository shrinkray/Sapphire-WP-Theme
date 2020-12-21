	jQuery(document).ready(function($) {
		"use strict";
		
		
		

		
		
		$('.ewf-modLayout-metaBox .ewf-ml-layoutUI').click(function(){
			var wrapper = $('.ewf-modLayout-metaBox');
			var layout = $(this).attr('id');
			
			
			if ($(this).hasClass('ewf-ml-layoutUI-active')){
				return false;
				}
			
			$('.ewf-ml-layoutUI-active', wrapper).removeClass('ewf-ml-layoutUI-active');
			$(this).addClass('ewf-ml-layoutUI-active');

			$('#ewf-page-layout').attr('value', layout);	
			
			if (layout == 'layout-sidebar-single-left' || layout == 'layout-sidebar-single-right'){
				$('.ewf-ml-layout-boxFooter ', wrapper).addClass('expanded');
			}else{
				$('.ewf-ml-layout-boxFooter ', wrapper).removeClass('expanded');
			}
			
		});
		

		
		//	Tabs handler
		//
		$('.ewf-ml-tabsBar ul a').click(function(){
			var wrapper = $('.ewf-modLayout-metaBox');
			var related = $(this).attr('rel');
			
			$('.ewf-ml-tabsBar li.active').removeClass('active');
			$(this).closest('li').addClass('active');
			
			$('.ewf-ml-tabscontent .ewf-ml-tab-content.active').removeClass('active');
			$('.ewf-ml-tabscontent .ewf-ml-tab-content.'+related, wrapper).addClass('active');
			
			return false;
		});
		
		
		var $modLayout = $('.ewf-modLayout-metaBox');
		var modLayout_sidebarID = 0;
		
		$('#ewf-ml-formCreateNewTitle, #ewf-ml-formCreateNewDescription', $modLayout).val('');
		$('#ewf-ml-formEditID, #ewf-ml-formEditTitle, #ewf-ml-formEditDescription', $modLayout).val('');
		
		
		
		$('.ewf-ml-formCreateSidebar .action-step-1 .ewf-ml-btn-createSidebar', $modLayout).click(function(){
			if ($('.ewf-ml-formCreateSidebar', $modLayout).hasClass('step-1')){
				$('.ewf-ml-formCreateSidebar', $modLayout).removeClass('step-1').addClass('step-2');
			}
			
			$('#ewf-ml-formCreateNewTitle').focus();
			
			return false;
		});
		
		
		
		$('.ewf-ml-formCreateSidebar .action-step-2 .ewf-ml-btn-cancelSidebar', $modLayout).click(function(){
			if ($('.ewf-ml-formCreateSidebar', $modLayout).hasClass('step-2')){
				$('.ewf-ml-formCreateSidebar', $modLayout).removeClass('step-2').addClass('step-1');
			} 
			
			$('#ewf-ml-formCreateNewTitle, #ewf-ml-formCreateNewDescription', $modLayout).val('');
			
			return false;
		});

		
		
		$('.ewf-ml-formCreateSidebar .action-step-2 .ewf-ml-btn-createSidebar', $modLayout).click(function(){
			var sidebar_title 			= $('#ewf-ml-formCreateNewTitle', $modLayout).val();
			var sidebar_description 	= $('#ewf-ml-formCreateNewDescription', $modLayout).val();
			var sidebar_newID 			= 'sidebar_'+$('.ewf-ml-sidebarsList li', $modLayout).length;

			var sidebar_code 			= '';
			
			
			if (sidebar_title){
				if (sidebar_description){
					sidebar_code = '<li style="display:none" id="'+sidebar_newID+'"><h4>'+sidebar_title+'</h4><p>'+sidebar_description+'</p><span class="ewf-button remove"></span><span class="ewf-button edit"></span></li>';
				}else{
					sidebar_code =  '<li style="display:none" id="'+sidebar_newID+'" class="no-description"><h4>'+sidebar_title+'</h4><p></p><span class="ewf-button remove"></span><span class="ewf-button edit"></span></li>';
				}
			}
			
			
			if (sidebar_title){
				
				$.post( siteURL+'/wp-admin/admin-ajax.php', { action:"ewf_modlayout_createsidebar", title: sidebar_title, description: sidebar_description, id: sidebar_newID   }, function(data){
					if (data.success){
						$('.ewf-ml-sidebarsList', $modLayout).append(sidebar_code);
						$('.ewf-ml-sidebarsList #'+sidebar_newID, $modLayout).slideDown();
						
						$('#ewf-page-sidebar', $modLayout).append($('<option>', {value: sidebar_newID, text: sidebar_title}));
												
						
						$('#ewf-ml-formCreateNewTitle, #ewf-ml-formCreateNewDescription', $modLayout).val('');
						$('.ewf-ml-formCreateSidebar .ewf-ml-btn-cancelSidebar', $modLayout).click();
					}
				
					console.log(data);
				}, "json"); 
			
			}else{
				$('#ewf-ml-formCreateNewTitle', $modLayout).focus();
			}
			
			
			return false;
		});
		
		
		$('.ewf-ml-formDeleteSidebar .ewf-ml-btn-deleteSidebar', $modLayout).click(function(){
		
			var sidebar_default = $('#ewf-page-sidebar', $modLayout).attr('data-default');
			var sidebar_active = $('#ewf-page-sidebar', $modLayout).val();
			var post_id = $('#ewf-upload-header-postID').val();
			
			// console.log('Default: '+sidebar_default+' - Active:'+sidebar_active);
			
		
			if (modLayout_sidebarID){
				$.post( siteURL+'/wp-admin/admin-ajax.php', { action:"ewf_modlayout_deletesidebar", id: modLayout_sidebarID, post: post_id  }, function(data){
					if (data.success){
						 
						if (sidebar_active == modLayout_sidebarID){
							$('#ewf-page-sidebar', $modLayout).val(sidebar_default);
							// console.log('Restore to default: '+sidebar_default);
						}
						
						
						$('#ewf-page-sidebar option[value="'+modLayout_sidebarID+'"]', $modLayout).remove();
						
						$('.ewf-ml-sidebarsList #'+modLayout_sidebarID).slideUp('fast');
						modLayout_sidebarID = 0;
				
						$('.ewf-ml-sidebarsList li.ewf-ml-HighlightBackground', $modLayout).removeClass('ewf-ml-HighlightBackground');

				
						ewf_ml_showSidebarAction('.ewf-ml-formCreateSidebar');
					}
				
					console.log(data);
				}, "json"); 
			}
			
			return false;
		});
		
		
		function ewf_ml_showSidebarAction(selector){
			
			$('.ewf-ml-formCreateSidebar.expanded, .ewf-ml-formDeleteSidebar.expanded, .ewf-ml-formEditSidebar.expanded', $modLayout).removeClass('expanded');
			$(selector, $modLayout).addClass('expanded');
			
			$('.ewf-ml-sidebarsList', $modLayout).removeClass('ewf-ml-editMode ewf-ml-deleteMode')
			
			if (selector == '.ewf-ml-formDeleteSidebar'){
				$('.ewf-ml-sidebarsList', $modLayout).addClass('ewf-ml-deleteMode');
			}
			
			if (selector == '.ewf-ml-formEditSidebar'){
				$('.ewf-ml-sidebarsList', $modLayout).addClass('ewf-ml-editMode');
			}
		}
		
		$('.ewf-ml-formDeleteSidebar .ewf-ml-btn-cancelDeleteSidebar', $modLayout).click(function(){
			modLayout_sidebarID = 0;
			ewf_ml_showSidebarAction('.ewf-ml-formCreateSidebar');
			
			$('.ewf-ml-sidebarsList li.ewf-ml-HighlightBackground', $modLayout).removeClass('ewf-ml-HighlightBackground');

			return false; 
		});
		
		
		
		$(document).on('click', '.ewf-ml-sidebarsList .ewf-button.remove', function(){
			if ($(this).closest('li').hasClass('ewf-ml-HighlightBackground')){
				return false;
				}
			
			
			var sidebar = $(this).closest('li');
			
			var sidebar_id = $(sidebar).attr('id');
			var sidebar_title = $('h4', sidebar).html();
			
			
			
			$(this).closest('ul li').removeClass('ewf-ml-HighlightBackground');
			$(sidebar).addClass('ewf-ml-HighlightBackground');


			ewf_ml_showSidebarAction('.ewf-ml-formDeleteSidebar');
			modLayout_sidebarID = sidebar_id;

			$('.ewf-ml-formDeleteSidebar label strong', $modLayout).html(sidebar_title);
			
			return false;
		});
		
		$(document).on('click', '.ewf-ml-sidebarsList .ewf-button.edit', function(){
			var sidebar_id = $(this).closest('li').attr('id');
			var sidebar_title = $(this).closest('li').find('h4').html();
			var sidebar_description = $(this).closest('li').find('p').html();
			
			$(this).closest('ul').removeClass('ewf-ml-HighlightBackground');
			$(this).closest('li').addClass('ewf-ml-HighlightBackground');
			

			ewf_ml_showSidebarAction('.ewf-ml-formEditSidebar');
			
		
			$('#ewf-ml-formEditID', $modLayout).val(sidebar_id);
			$('#ewf-ml-formEditTitle', $modLayout).val(sidebar_title).focus(); 
			$('#ewf-ml-formEditDescription', $modLayout).val(sidebar_description);
			
			$('#ewf-ml-formEditOldTitle', $modLayout).val(sidebar_title);
			$('#ewf-ml-formEditOldDescription', $modLayout).val(sidebar_description);
			
			modLayout_sidebarID = sidebar_id;
			
			console.log('Edit on: '+sidebar_id);
			return false;
		});
		
		$('#ewf-ml-formEditTitle', $modLayout).keyup(function(){
			if (!modLayout_sidebarID) {
				return false;
			}
		 	
			var sidebar_title = $(this).val();
			$('.ewf-ml-sidebarsList #'+modLayout_sidebarID+' h4').html(sidebar_title);
		});
		
		$('#ewf-ml-formEditDescription', $modLayout).keyup(function(){
			if (!modLayout_sidebarID) {
				return false;
			}
			
			var sidebar_description = $(this).val();
			
			if (sidebar_description){
				// console.log('remove no-description');
				$('#'+modLayout_sidebarID, $modLayout).removeClass('no-description'); 
				$('#'+modLayout_sidebarID+' p', $modLayout).html(sidebar_description); 
			}else{
				// console.log('add no-description');
				$('#'+modLayout_sidebarID, $modLayout).addClass('no-description'); 
				$('#'+modLayout_sidebarID+' p', $modLayout).html(''); 
			}
			
		});  
		
		
		$('.ewf-ml-formEditSidebar .ewf-ml-btn-updateSidebar', $modLayout).click(function(){
		
			if (modLayout_sidebarID){
			
				var sidebar_title = $('#'+modLayout_sidebarID + ' h4').html();
				var sidebar_description = $('#'+modLayout_sidebarID+' p').html();
			
				$.post( siteURL+'/wp-admin/admin-ajax.php', { action:"ewf_modlayout_updatesidebar", id: modLayout_sidebarID, title: sidebar_title, description: sidebar_description }, function(data){
					if (data.success){
						
						modLayout_sidebarID = 0;
						
						$('#ewf-ml-formEditOldTitle', $modLayout).val('');
						$('#ewf-ml-formEditOldDescription', $modLayout).val('');
						
						$('.ewf-ml-sidebarsList li.ewf-ml-HighlightBackground', $modLayout).removeClass('ewf-ml-HighlightBackground');
						ewf_ml_showSidebarAction('.ewf-ml-formCreateSidebar');
					}
				
					console.log(data);
				}, "json"); 
			}
		
			return false;
		});
		
		
		$('.ewf-ml-formEditSidebar .ewf-ml-btn-cancelSidebar').click(function(){
			ewf_ml_showSidebarAction('.ewf-ml-formCreateSidebar');

			$('.ewf-ml-sidebarsList li.ewf-ml-HighlightBackground', $modLayout).removeClass('ewf-ml-HighlightBackground');
			
			var sidebar_title = $('#ewf-ml-formEditOldTitle', $modLayout).val();
			var sidebar_description = $('#ewf-ml-formEditOldDescription', $modLayout).val();
			
			$('#'+modLayout_sidebarID+' h4', $modLayout).html(sidebar_title);
			$('#'+modLayout_sidebarID+' p', $modLayout).html(sidebar_description);
			
			modLayout_sidebarID = 0;
			$('#ewf-ml-formEditOldTitle', $modLayout).val('');
			$('#ewf-ml-formEditOldDescription', $modLayout).val('');
			
	
			return false; 
		});
		
		$('#ewf-ml-formEditTitle, #ewf-ml-formEditDescription', $modLayout).keypress(function(event) {
			if (event.which == 13) {
				event.preventDefault();
				
				$('.ewf-ml-formEditSidebar .ewf-ml-btn-updateSidebar', $modLayout).click();
			}
		});
		
		$('#ewf-ml-formCreateNewTitle, #ewf-ml-formCreateNewDescription', $modLayout).keypress(function(event) {
			if (event.which == 13) {
				event.preventDefault();
				
				$('.ewf-ml-formCreateSidebar .action-step-2 .ewf-ml-btn-createSidebar', $modLayout).click();
			}
		});

				
		$("input.label", $modLayout).label_better({
			position: "top",
			animationTime: 180, 
			//easing: "ease-in-out", 
			offset: 8,
			hidePlaceholderOnFocus: true 
		});
		
		
		
		


		
		
		
	});
		


	
	
	
	