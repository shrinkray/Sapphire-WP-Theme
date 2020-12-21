<?php
	
	
	$ewf_modLayout_settings = array(
	
		'sidebars' => array(
			
			#	Fallback sidebar - when you delete the current sidebar this is the default one
			'default' => 'sidebar-page',
			
			
			#	The list with uneditable sidebars
			'uneditable' => array(
				'sidebar-page' 		=> array( 'title' => __('Page Sidebar'			, EWF_SETUP_THEME_DOMAIN), 'description' => null ),
			), 
			
			
			#	The list with uneditable sidebars
			'install' => array(
				'sidebar-blog'		=> array( 'title' => __('Blog Sidebar'			, EWF_SETUP_THEME_DOMAIN), 'description' => null ),
				'sidebar-services'	=> array( 'title' => __('Services Sidebar'		, EWF_SETUP_THEME_DOMAIN), 'description' => null ),
				'sidebar-about'		=> array( 'title' => __('About Sidebar'			, EWF_SETUP_THEME_DOMAIN), 'description' => null ),
				'sidebar-portfolio'	=> array( 'title' => __('Portfolio Sidebar'		, EWF_SETUP_THEME_DOMAIN), 'description' => null ),
				'sidebar-contact'	=> array( 'title' => __('Contact Sidebar'		, EWF_SETUP_THEME_DOMAIN), 'description' => null ),
			),
			
			
			#	User registred sidebars
			'registred' => ewf_modLayout_get_registredSidebars(),
			
		),
		
		
		'layout' => array(
			
			#	Sidebar options
			#
			#	layout-sidebar-single-left
			#	layout-sidebar-single-right
			# 	layout-full
	
			'default' => 'layout-full'		
		),
		
		
		#	Post types supported
		#
		'support' => array( 'page', EWF_PROJECTS_SLUG )
	);

	
	ewf_modLayout_registerSidebars();

	
	
	
	#
	#	Attach required css & js in admin scripts header
	#
		add_action('admin_enqueue_scripts'						, 'ewf_modLayout_load_includes');
		add_action('ewf_modLayout_resetSidebars'				, 'ewf_modLayout_resetSidebars');
		
		
		function ewf_modLayout_load_includes(){
			$includes = '/framework/modules/ewf-layout/includes';
			
		   wp_enqueue_script ('wp-color-picker');
		   wp_enqueue_style ('wp-color-picker');
		   
		   wp_enqueue_style ('thickbox');
		   wp_enqueue_script ('thickbox');
			
		   wp_enqueue_script ('media-upload');
			
			
		
			wp_enqueue_script ('ewf-modLayout-js'				, get_template_directory_uri().$includes.'/ewf-modLayout.js'		, array('jquery')); 		
			wp_enqueue_script ('ewf-modLayout-labels-js'		, get_template_directory_uri().$includes.'/jquery.label.min.js'		, array('jquery')); 		
			
			wp_register_style ( 'ewf-modLayout-css'				, get_template_directory_uri().$includes.'/ewf-modLayout.css',  array('dashicons') );
			wp_enqueue_style ( 'ewf-modLayout-css');
			
			wp_add_inline_style( 'ewf-modLayout-css'			, ewf_modLayout_load_styles_dynamic() );
		}
		
		function ewf_modLayout_load_styles_dynamic() {
			global $_wp_admin_css_colors;
			
			$color_scheme = get_user_option( 'admin_color' ); 
			$color_scheme_highlight =  ewf_modLayout_hex2rgb($_wp_admin_css_colors[$color_scheme]->colors[2]);
			
			
			// echo '<pre>';
				// print_r($color_scheme);
				// print_r($color_scheme_highlight);
				//echo '<br/>--------------------------------------------------------';
				//print_r($_wp_admin_css_colors);
			// echo '</pre>';

			
			$custom_css = '
				.ewf-ml-layoutUI.ewf-ml-layoutUI-active { border:2px solid rgba('.$color_scheme_highlight[0].', '.$color_scheme_highlight[1].', '.$color_scheme_highlight[2].', 0.7); }
				.ewf-ml-sidebarsList li.wp-ui-notification:hover  { background:'.$_wp_admin_css_colors[$color_scheme]->colors[2].';color:#fff; }
				
				.ewf-ml-HighlightBackground { background:rgba('.$color_scheme_highlight[0].', '.$color_scheme_highlight[1].', '.$color_scheme_highlight[2].', 0.09); }
				.ewf-ml-sidebarsList li.ewf-ml-HighlightBackground:hover { background:rgba('.$color_scheme_highlight[0].', '.$color_scheme_highlight[1].', '.$color_scheme_highlight[2].', 0.09); }
			'; 
			
			return $custom_css; 
		}
			
		
		
		
		add_action('wp_ajax_ewf_modlayout_createsidebar'		, 'ewf_modLayout_ajax_create_sidebar');
		add_action('wp_ajax_ewf_modlayout_updatesidebar'		, 'ewf_modLayout_ajax_update_sidebar');
		add_action('wp_ajax_ewf_modlayout_deletesidebar'		, 'ewf_modLayout_ajax_delete_sidebar');
		
		function ewf_modLayout_ajax_delete_sidebar(){
			global $ewf_modLayout_settings;
			
			$result_ajax = array();
			$sidebar_id = 0;
			$sidebars_registred = unserialize(get_option('ewf_modLayout_sidebars', null));
			
			

			if (array_key_exists('id', $_POST)){
				$post_id = intval($_POST['post']);
				$post_sidebar = ewf_get_sidebar_id('*', $post_id);
				
				$sidebar_id = $_POST['id'];
				
				$result_ajax['sidebar_id'] = $sidebar_id;
				$result_ajax['post_id'] = $post_id;
				$result_ajax['sidebar_active'] = false;
				
				
				unset ($sidebars_registred[$sidebar_id]);
				$result_update = update_option('ewf_modLayout_sidebars', stripslashes(serialize($sidebars_registred)));
				
				ewf_modLayout_removeSidebarFromPages($sidebar_id);
				
				if ($result_update && $post_id){
					$result_ajax['sidebar_current'] = $post_sidebar;
					
					if ($post_sidebar == $sidebar_id){
						$result_ajax['sidebar_active'] = true;
						$result_ajax['reset'] = update_post_meta($post_id, "_ewf-page-sidebar",  $ewf_modLayout_settings['sidebars']['default']);
					}
				}
				
				
				if ($result_update){
					wp_send_json_success($result_ajax);
				}else{
					wp_send_json_error($result_ajax);
				}
				
			}else{
				wp_send_json_error($result_ajax);
			}
		}
		
		function ewf_modLayout_ajax_update_sidebar(){
			$sidebars_registred = unserialize(get_option('ewf_modLayout_sidebars', null));
		
			if (array_key_exists('title', $_POST) && array_key_exists('id', $_POST) && array_key_exists('description', $_POST) ){
				$sidebar_id = $_POST['id'];
				
				if (array_key_exists($sidebar_id, $sidebars_registred)){
					$sidebars_registred[$sidebar_id]['title'] = stripslashes($_POST['title']);
					$sidebars_registred[$sidebar_id]['description'] = stripslashes($_POST['description']);
				
		
					$result = update_option('ewf_modLayout_sidebars', serialize($sidebars_registred));
					
					if ($result){
						wp_send_json_success(array('sidebar_id' => $sidebar_id));
					}else{
						wp_send_json_error(array('sidebar_id' => $sidebar_id));
					}
				}else{
						wp_send_json_error(array('sidebar_id' => $sidebar_id));
				}
				
			}

		}
				
		function ewf_modLayout_ajax_create_sidebar(){
			$sidebars_registred = unserialize(get_option('ewf_modLayout_sidebars', null));

			if (array_key_exists('title', $_POST) && array_key_exists('id', $_POST)){
				$sidebar_id = strtolower(str_replace(array('#', '@', '$', '-', '_', ' '), '_', $_POST['id'])); 
				
				if (array_key_exists($sidebar_id, $sidebars_registred)){
					$sidebar_id = $sidebar_id.rand(1000, 9999);
				}
				
				if (! array_key_exists($sidebar_id, $sidebars_registred)){
					$sidebars_registred[$sidebar_id] = array();
					$sidebars_registred[$sidebar_id]['title'] = stripslashes($_POST['title']);
					$sidebars_registred[$sidebar_id]['description'] = stripslashes($_POST['description']);
					
					$result = update_option('ewf_modLayout_sidebars', serialize($sidebars_registred));
					
					if ($result){
						wp_send_json_success(array('sidebar_id' => $sidebar_id));
					}else{
						wp_send_json_error(array('sidebar_id' => $sidebar_id));
					}
					
				}else{
					wp_send_json_error(array('sidebar_id' => $sidebar_id));
				} 
			}
			
			exit;
		}
		
		
    


	

	
	#
	#	Register meta box & update meta info
	#
		add_action('save_post'									, 'ewf_modLayout_meta_update');
		add_action('admin_menu'									, 'ewf_modLayout_meta_register');
		
		
		function ewf_modLayout_meta_update(){
			global $post;
			
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
				return $post->ID;
			}
			
			
			if (!is_object($post)){
				 return false;
			}
				
			
			if (is_array($_POST) && array_key_exists('ewf-page-layout', $_POST) && array_key_exists('ewf-page-sidebar', $_POST) ){
				update_post_meta($post->ID, "_ewf-page-layout", $_POST["ewf-page-layout"]);
				update_post_meta($post->ID, "_ewf-page-sidebar", $_POST["ewf-page-sidebar"]);
			}
		}
		
		function ewf_modLayout_meta_register() {
			global $ewf_modLayout_settings;
			
			if (is_array($ewf_modLayout_settings['support'])){
			
				foreach($ewf_modLayout_settings['support'] as $key => $post_type){
					add_meta_box( 'ewf-layout-sidebars-setup',__('Page layout & sidebars',EWF_SETUP_THEME_DOMAIN), 'ewf_modLayout_meta_source', $post_type, 'normal', 'high');
				}
				
			}
		}
		
		function ewf_modLayout_meta_source() {
				global $post, $ewf_modLayout_settings; 
				
				$layouts = array(
					array(
						'icon' => 'layout-sidebar-single-left.png',
						'name' => 'layout-sidebar-single-left',
						'title' => __('Sidebar Left', EWF_SETUP_THEME_DOMAIN)
					),
					array(
						'icon' => 'layout-full.png',
						'name' => 'layout-full',
						'title' => __('No Sidebar', EWF_SETUP_THEME_DOMAIN)
					),
					array(
						'icon' => 'layout-sidebar-single-right.png',
						'name' => 'layout-sidebar-single-right',
						'title' => __('Sidebar Right', EWF_SETUP_THEME_DOMAIN)
					)
				);
				
				$layout_sidebar_id = ewf_modLayout_getSidebarID( $ewf_modLayout_settings['sidebars']['default'] );
				
				$ewf_page_layout = null;
				$custom = get_post_custom($post->ID);
				
				# 	Check if there is a setup layout
				#
					if (array_key_exists('_ewf-page-layout',$custom)){
						$ewf_page_layout = $custom["_ewf-page-layout"][0];
					}else{
						$ewf_page_layout = $ewf_modLayout_settings['layout']['default']; 
					}
				
				
				echo '<div class="ewf-modLayout-metaBox">';
					
					echo'<div class="ewf-ml-tabsBar clearfix">
							<ul>
								<li class="active"><a href="#" rel="ewf-ml-tab-layout" class="ewf-icon-layout">'.__('Layout', EWF_SETUP_THEME_DOMAIN).'</a></li>
								<li><a href="#" rel="ewf-ml-tab-sidebars" class="ewf-icon-sidebars">'.__('Sidebars', EWF_SETUP_THEME_DOMAIN).'</a></li> 
							</ul>
						</div>';
					
					
					
					echo '<div class="ewf-ml-tabscontent clearfix">';
						
						echo '<div class="ewf-ml-tab-layout ewf-ml-tab-content active">';

							echo '<label class="side-new">'.__('Choose the position the sidebar should have on the page', EWF_SETUP_THEME_DOMAIN).'</label>'; 

							echo '<div class="ewf-ml-page-layout">';
									if ($ewf_page_layout == 'layout-sidebar-single-left'){ $class_active = ' ewf-ml-layoutUI-active'; }else{ $class_active = null; }
									echo '<div id="layout-sidebar-single-left" class="ewf-ml-layoutUI sidebar-left'.$class_active.'"><div></div><span class="wp-ui-highlight"></span></div>';
								
									if ($ewf_page_layout == 'layout-full'){ $class_active = ' ewf-ml-layoutUI-active'; }else{ $class_active = null; }
									echo '<div id="layout-full" class="ewf-ml-layoutUI no-sidebar'.$class_active.'"><div></div></div>';
									
									if ($ewf_page_layout == 'layout-sidebar-single-right'){ $class_active = ' ewf-ml-layoutUI-active'; }else{ $class_active = null; }
									echo '<div id="layout-sidebar-single-right" class="ewf-ml-layoutUI sidebar-right'.$class_active.'"><div></div><span class="wp-ui-highlight"></span></div>';
							echo '</div>';
						
							/*
							
							#Footer layout, not available for the moment
							
							echo '<p>Footer layout</p>';
							echo '<div class="ewf-ml-footer-layout">';
								echo '<input type="hidden" autocomplete="off" name="ewf-footer-layout-columns" class="ewf-footer-layout-columns" value="3"  />';
								echo '<input type="hidden" autocomplete="off" name="ewf-footer-layout-columns-size" class="ewf-footer-layout-columns-size" value="4,4,4"  />'; 
								
								
								echo '<div class="ewf-ml-footer-tabs">';
									echo '<div class="ewf-ml-footer-tab-columns active" data-related="ewf-footer-layout-setcol-wrapper"><span>3</span> Columns</div>';
									echo '<div class="ewf-ml-footer-tab-editor" data-related="ewf-footer-layout-editor-wrapper">Edit Size</div>';
								echo '</div>';
								
								
								echo '<div class="ewf-footer-layout-setcol-wrapper ewf-ml-footer-tab-content">';
										
									echo '<span>Layout</span>';
									
									echo '<ul class="ewf-layout-footer-setnumbers ewf-ml-footer-tab-content">';
										echo '<li><a class="ft-col1" data-columns="1" data-size="12" href="#"></a></li>';
										echo '<li><a class="ft-col2" data-columns="2" data-size="6,6" href="#"></a></li>';
										echo '<li><a class="ft-col3 active" data-columns="3" data-size="4,4,4" href="#"></a></li>';
										echo '<li><a class="ft-col4" data-columns="4" data-size="3,3,3,3" href="#"></a></li>';
									echo '</ul>';
								
								echo '</div>';
								
								

								
								echo '<div class="ewf-footer-layout-editor-wrapper ewf-ml-footer-tab-content">';
									echo '<p>Press the plus button to increase column size</p>';
									
									echo '<div class="ewf-footer-layout-column-editor" data-columns="3"></div>';
									echo '<a href="#" type="button" class="button button-primary button-large" ><span></span>Save footer</a>';
									
								echo '</div>';
								
							echo '</div>';
							*/
							
						
						
							$class_layoutBoxFooter = null;
							if ($ewf_page_layout == 'layout-sidebar-single-left' || $ewf_page_layout == 'layout-sidebar-single-right'){
								$class_layoutBoxFooter = 'expanded';
							}
							
							echo '<div class="ewf-ml-layout-boxFooter '.$class_layoutBoxFooter.'">';
								echo '<label>'.__('Choose from the existing sidebars, the one you want this page to use.', EWF_SETUP_THEME_DOMAIN).'</label>';
								
								echo '<select id="ewf-page-sidebar" name="ewf-page-sidebar" data-default="'.$ewf_modLayout_settings['sidebars']['default'].'">';
									
								
									if (is_array($ewf_modLayout_settings['sidebars']['uneditable'])){
										foreach($ewf_modLayout_settings['sidebars']['uneditable'] as $sidebar_item_id => $sidebar_item){
											if ($layout_sidebar_id == $sidebar_item_id){
												echo '<option value="'.$sidebar_item_id.'" selected="selected">'.$sidebar_item['title'].'</option>';
											}else{
												echo '<option value="'.$sidebar_item_id.'">'.$sidebar_item['title'].'</option>';
											}
										}									
									}
									
									if (is_array($ewf_modLayout_settings['sidebars']['registred'])){
										foreach($ewf_modLayout_settings['sidebars']['registred'] as $sidebar_item_id => $sidebar_item){
											if ($layout_sidebar_id == $sidebar_item_id){
												echo '<option value="'.$sidebar_item_id.'" selected="selected">'.$sidebar_item['title'].'</option>';
											}else{
												echo '<option value="'.$sidebar_item_id.'">'.$sidebar_item['title'].'</option>';
											}
										}
									}
									
								echo '</select>';
								
								echo '<a href="#" type="button" class="button button-primary button-large" ><span></span>'.__('Use sidebar', EWF_SETUP_THEME_DOMAIN).'</a>';
							echo '</div>';
							
						echo '</div>';
						
						
						
						
						
						echo '<div class="ewf-ml-tab-sidebars ewf-ml-tab-content">';
							echo '<label class="side-new">'.__('You can choose the page layout from by clicking one for the following icons.', EWF_SETUP_THEME_DOMAIN).'</label>'; 
							
							echo '<ul class="ewf-ml-sidebarsList">';
									
									foreach($ewf_modLayout_settings['sidebars']['registred'] as $sidebar_item_id => $sidebar_item){
										$sidebar_extra_class = null;
										
										if (trim($sidebar_item['description']) == null){ 
											$sidebar_extra_class = ' class="no-description" ';
										}
										
										  echo '<li '.$sidebar_extra_class.' id="'.$sidebar_item_id.'">
													<h4>'.$sidebar_item['title'].'</h4>
													<p>'.$sidebar_item['description'].'</p>
													<span class="ewf-button remove"></span>
													<span class="ewf-button edit"></span>
												</li>';
									}
									
							echo '</ul>
								<div class="ewf-ml-sidebarsListLoading"><span class="load"></span></div>';
								
								
							echo '<div class="ewf-ml-sidebars-boxFooter">';
								
								
								
								echo '<div class="ewf-ml-formCreateSidebar step-1 expanded">';
									
									echo '
									<div class="ewf-ml-create">
										<p><input type="text" value="" name="ewf-ml-formCreateNewTitle" id="ewf-ml-formCreateNewTitle" class="label" data-new-placeholder="'.__('Specify the sidebar title', EWF_SETUP_THEME_DOMAIN).'" placeholder="'.__('Sidebar title', EWF_SETUP_THEME_DOMAIN).'"  maxlength="30" /></p>
										<p><input type="text" value="" name="ewf-ml-formCreateNewDescription" id="ewf-ml-formCreateNewDescription" class="label" data-new-placeholder="'.__('Add a sidebar description', EWF_SETUP_THEME_DOMAIN).'" placeholder="'.__('Sidebar description', EWF_SETUP_THEME_DOMAIN).'" /></p>

										<input type="hidden" name="ewf-ml-formCreateOldTitle" id="ewf-ml-formCreateOldTitle" maxlength="30" />
										<input type="hidden" name="ewf-ml-formCreateOldDescription" id="ewf-ml-formCreateOldDescription" />
									</div>
									
									<div class="sidebars-action">
										
										<div class="action-step-1">
											<div class="action-apply">
												<a href="#" type="button" class="button button-primary button-large ewf-ml-btn-createSidebar">'.__('Create sidebar', EWF_SETUP_THEME_DOMAIN).'</a>
											</div>										
										</div>
										 
										<div class="action-step-2">
											<div class="action-cancel"><a href="#" class="ewf-ml-btn-cancelSidebar">'.__('Cancel', EWF_SETUP_THEME_DOMAIN).'</a></div>
											<div class="action-apply">
												<a href="#" type="button" class="button button-primary button-large ewf-ml-btn-createSidebar">'.__('Create sidebar', EWF_SETUP_THEME_DOMAIN).'</a>
											</div>
										</div>
										
									</div>';
									
									
								echo '</div>';
								
								echo '<div class="ewf-ml-formDeleteSidebar">';
									echo '<label>'.__('Are you sure you want to delete sidebar: <strong>Blog Sidebar</strong>', EWF_SETUP_THEME_DOMAIN).'</label>'; 
									
								echo '<div class="sidebars-action">
											<div class="action-cancel"><a href="#" class="ewf-ml-btn-cancelDeleteSidebar">'.__('Cancel', EWF_SETUP_THEME_DOMAIN).'</a></div>
											<div class="action-apply"><a href="#" type="button" class="button button-primary button-large ewf-ml-btn-deleteSidebar">'.__('Delete sidebar', EWF_SETUP_THEME_DOMAIN).'</a></div>
										</div>';
								echo '</div>'; 
								
								echo '<div class="ewf-ml-formEditSidebar">
									<p><input type="text" value="" name="ewf-ml-formEditTitle" id="ewf-ml-formEditTitle" class="label" data-new-placeholder="'.__('Specify the sidebar title', EWF_SETUP_THEME_DOMAIN).'" placeholder="'.__('Sidebar title', EWF_SETUP_THEME_DOMAIN).'"  maxlength="30"  /></p>
									<p><input type="text" value="" name="ewf-ml-formEditDescription" id="ewf-ml-formEditDescription" class="label" data-new-placeholder="'.__('Add a sidebar description', EWF_SETUP_THEME_DOMAIN).'" placeholder="'.__('Sidebar description', EWF_SETUP_THEME_DOMAIN).'" /></p>
									<p><input type="hidden" value="" name="" name="ewf-ml-formEditID" id="ewf-ml-formEditID" /></p>
									
									<input type="hidden" value="" id="ewf-ml-formEditOldTitle" />
									<input type="hidden" value="" id="ewf-ml-formEditOldDescription" />
									
									<div class="sidebars-action">
										<div class="action-cancel"><a href="#" class="ewf-ml-btn-cancelSidebar">'.__('Cancel', EWF_SETUP_THEME_DOMAIN).'</a></div>
										<div class="action-apply">
											<a href="#" type="button" class="button button-primary button-large ewf-ml-btn-updateSidebar" >'.__('Save changes', EWF_SETUP_THEME_DOMAIN).'</a>
										</div>
									</div>';
									
								echo '</div>';
								
								
								
							echo '</div>';
							
						echo '</div>';
						
						
		
						
					echo '</div>';
					
					
					echo '<input type="hidden" id="ewf-page-layout" name="ewf-page-layout" value="'.$ewf_page_layout.'" />';
				echo '</div>';
				
				
				
				
				// global $_wp_admin_css_colors; 
				// $color_scheme = get_user_option( 'admin_color' ); 

				// echo '<pre>';
					// print_r($_wp_admin_css_colors[$color_scheme]->colors);
					
					// echo '<div class="wp-ui-primary">.wp-ui-primary</div>';
					// echo '<div class="wp-ui-text-primary">.wp-ui-text-primary</div>';
					// echo '<div class="wp-ui-highlight">.wp-ui-highlight</div>';
					// echo '<div class="wp-ui-notification">.wp-ui-notification</div>';
					// echo '<div class="wp-ui-text-notification">.wp-ui-text-notification</div>';
					// echo '<div class="wp-ui-text-highlight">.wp-ui-text-highlight</div>';
					// echo '<div class="wp-ui-text-icon">.wp-ui-text-icon</div>';
				// echo '</pre>';
				
				
				
		}


		
	#	Remove the deleted sidebars from all the pages
	#
	function ewf_modLayout_removeSidebarFromPages($sidebar_id, $default_id = null){
		global $post;
		
		$data_return = array();
		
		$wp_query_pages = new wp_query(array('showposts' => -1, 'post_type' => 'page'));
		while ($wp_query_pages->have_posts()) : $wp_query_pages->the_post();		
		
			$page_custom_meta = get_post_custom($post->ID);
			if ( is_array($page_custom_meta) &&  array_key_exists('_ewf-page-sidebar',$page_custom_meta)){
				
				if (  $page_custom_meta["_ewf-page-sidebar"][0] == $sidebar_id){
					$data_return[$post->ID] = "true";
					update_post_meta($post->ID, "_ewf-page-sidebar", $default_id); 
				}else{
					$data_return[$post->ID] = "false";
				}
			}
			
		endwhile;
		wp_reset_query();
		
		return $data_return;
	}
	
	function ewf_modLayout_hex2rgb($hex) {
	   $hex = str_replace("#", "", $hex);

	   if(strlen($hex) == 3) {
		  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
		  $r = hexdec(substr($hex,0,2));
		  $g = hexdec(substr($hex,2,2));
		  $b = hexdec(substr($hex,4,2));
	   }
	   $rgb = array($r, $g, $b);
	   //return implode(",", $rgb); // returns the rgb values separated by commas
	   return $rgb; // returns an array with the rgb values
	}
	
	function ewf_modLayout_getSidebarID($default = null, $post_id = 0){
		global $post;
		
		if ($post_id){
			$item_meta = get_post_custom($post_id);
		}else{
			if (is_object($post)){
				$item_meta = get_post_custom($post->ID);
			}else{
				$item_meta = null;
			}
		}
		
	
		if ( is_array($item_meta) &&  array_key_exists('_ewf-page-sidebar',$item_meta)){
			$sidebar_id = $item_meta["_ewf-page-sidebar"][0];
			
			if ($sidebar_id != null) { 
				$default = $sidebar_id; 
			}		
		}
			
		ewf_debug_log("debug", "ewf_modLayout_getSidebarID - Sidebar ID:".$default);
			
		return $default;	
	}
	
	function ewf_modLayout_registerSidebars(){
		global $ewf_modLayout_settings;
		
		
		$sidebars = $ewf_modLayout_settings['sidebars']['uneditable'] + $ewf_modLayout_settings['sidebars']['registred'];
		if (is_array($sidebars)){
		
			foreach($sidebars as $sidebar_item_id => $sidebar_item){
					register_sidebar(array(
						'id' => $sidebar_item_id, 
						'name' => $sidebar_item['title'], 
						'description'   => $sidebar_item['description'], 
						'before_title'  => '<h3 class="widget-title"><span>',
						'after_title'   => '</span></h3>', 
						'before_widget' => '<div id="%1$s" class="widget %2$s">', 
						'after_widget'  => '</div>' 
					));
			}
		}
	}
	
	function ewf_modLayout_resetSidebars(){
		global $ewf_modLayout_settings;
		
		update_option('ewf_modLayout_sidebars', serialize($ewf_modLayout_settings['sidebars']['install']));
	}
	
	function ewf_modLayout_get_registredSidebars(){
		$registred_sidebars = array();
		
		if (get_option('ewf_modLayout_sidebars', null) == null){
			update_option('ewf_modLayout_sidebars', serialize(null));
		}else{
			$registred_sidebars = unserialize(get_option('ewf_modLayout_sidebars'));
			
			if (!is_array($registred_sidebars) || $registred_sidebars == null){
				$registred_sidebars = array();
			}
		}
		
		return $registred_sidebars;
	}
	
	
	
	#
	# 	It get's the related ID, returns the following
	# 	- Page ID if this is a single page
	# 	- Blog page ID from admin reading settings if this is a blog post or an archive page
	# 	- Parent page ID if this is a child page
	#
		
	function ewf_get_page_relatedID( $headerCheck = false, $page_for_posts = 0 ){
		global $post;
		
		$ewf_page_id = 0;
		 
		##	Check if there's a blog page ID provided
		##
		if ($page_for_posts == 0){
			$page_for_posts = get_option('page_for_posts');
			}
		
		
		if (is_object($post)){
			ewf_debug_log("debug", "Related ID: Post Object");
			
			#echo '<pre>';
			#	print_r($post);
			#echo '</pre>';
			
			$ewf_page_id = $post->ID;
			}
		
		
		if (is_single()){
			$ewf_page_data = null;
			
			switch($post->post_type){
				case "post":
					#$ewf_page_data = get_page_by_title( get_option(EWF_SETUP_THNAME."_page_blog", null ) );
					$ewf_page_data = get_post($page_for_posts);
					ewf_debug_log("debug", "Related ID: Post Single");
					
					break;
			
				// case EWF_PROJECTS_SLUG:
					// $ewf_page_data = get_page_by_title( get_option(EWF_SETUP_THNAME."_page_portfolio", null ) );
					// ewf_debug_log("debug", "Related ID: EWF_PROJECTS_SLUG Single"); 
					
					// break;		
			}
			
			if (is_object($ewf_page_data)){
				$ewf_page_id = $ewf_page_data->ID;
				}	

		}elseif(is_page() && count($post->ancestors)){
		 
			$ewf_page_id = $post->ancestors[0];
			ewf_debug_log("debug", "Related ID: Child Page");
			
			## Check if the child's parent has a header image
			##
			if ($headerCheck){
				$ewf_child_page_parent_imgID = ewf_getHeaderImageID($ewf_page_id);
				$ewf_child_page_imgID = ewf_getHeaderImageID($post->ID);
				
				
				ewf_debug_log("debug", "Parent does not have header image, returning child ID [".$ewf_child_page_parent_imgID.']['.$ewf_child_page_imgID.']');
				 
				## If the child have an image but the parent also has one, return the child ID
				##
				if ($ewf_child_page_imgID > 0){
					$ewf_page_id = $post->ID;
					
					ewf_debug_log("debug", "Parent does have header image, but child also has one, returning child ID [".$ewf_child_page_parent_imgID.']['.$ewf_child_page_imgID.']');
				}
				
				
				## If the parent does not have an image niether the child return null
				if ( $ewf_child_page_parent_imgID == 0 &&  $ewf_child_page_imgID == 0){
					$ewf_page_id = 0;
				}
			}
		
		}elseif(is_archive()){
			
			if (is_tax(EWF_PROJECTS_TAX_SERVICES)){
				
				$ewf_page_data = get_page_by_title( get_option(EWF_SETUP_THNAME."_page_portfolio", null ) );
				ewf_debug_log("debug", "Related ID: EWF_PROJECTS_SLUG Taxonomy"); 			
				
			}else{
			
				$ewf_page_data = get_post($page_for_posts);
				ewf_debug_log("debug", "Related ID: Archive Page - Return Blog Page ID");
				
			}
			
			if (is_object($ewf_page_data)){
				$ewf_page_id = $ewf_page_data->ID;
			}else{
				$ewf_page_id = 0;
			} 

		}elseif(is_search()){
			$ewf_page_data = get_post($page_for_posts);
			if (is_object($ewf_page_data)){
			
				$ewf_page_id = $ewf_page_data->ID; 
				ewf_debug_log("debug", "Related ID: Search Page - Return Blog Page ID: ".$ewf_page_data->ID);
			}
		}elseif(is_home() && is_front_page() == false){
			$ewf_page_data = get_post($page_for_posts);
			if (is_object($ewf_page_data)){
				
				$ewf_page_id = $ewf_page_data->ID; 
				ewf_debug_log("debug", "Related ID: Static Posts Page ID: ".$ewf_page_data->ID);
				
			}
		}

		
		
		return $ewf_page_id;
	}
		
	
	function ewf_get_sidebar_id($default = null, $post_id = 0){
		global $post;
		
		if ($post_id){
			$item_meta = get_post_custom($post_id);
		}else{
			if (is_object($post)){
				$item_meta = get_post_custom($post->ID);
			}else{
				$item_meta = null;
			}
		}
		
	
		if ( is_array($item_meta) &&  array_key_exists('_ewf-page-sidebar',$item_meta)){
			$sidebar_id = $item_meta["_ewf-page-sidebar"][0];
			
			if ($sidebar_id != null) { 
				$default = $sidebar_id; 
			}		
		}
			
		ewf_debug_log("debug", "ewf_get_sidebar_id - Sidebar ID:".$default);
			
		return $default;	
	}

	function ewf_get_sidebar_layout($default = "layout-full", $post_id = 0){
		global $post;
		$item_meta = array();
		
		if (!$post_id){
			if (is_object($post)){
				$post_id = $post->ID;
			}else{
				$post_id = 0;
			}
		}
		
		if ($post_id > 0){
			$item_meta = get_post_custom($post_id);	// get the item custom variables
		}
		
		if (array_key_exists('_ewf-page-layout',$item_meta)){
			$layout = $item_meta["_ewf-page-layout"][0];
			
			if ($layout!=null) { 
				$default = $layout;
			}			
		}
			
		ewf_debug_log("debug", "ewf_get_sidebar_layout - Layout:".$default);
		
		return $default;	 
	} 
	
	
?>