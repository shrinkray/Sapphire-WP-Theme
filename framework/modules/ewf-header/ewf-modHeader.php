<?php


if(!class_exists('EWF_ModHeader'))
{ 

	class EWF_ModHeader {
		
		public $settings = array(
		
			'support' 	=> array( 'page', EWF_PROJECTS_SLUG ),
			'defaults'	=> array(
							'active' => '*', 
							'image_id' => null, 
							'image_url' => null, 
							'title' => null, 
							'title_src' => 'mh-type-page-header-title', 
							'description' => null, 
							'description_src' => null, 
							'background_color' => '#7DD1A3', 
							'parallax' => 0, 
							'master_id' => 0, 
							'master_use' => 0
						)
		);
		
		function __construct(){
		

		
		#	Theme support
		#	
		#	add_theme_support('ewf-modHeader-description');				#	Add a header description
		#	add_theme_support('ewf-modHeader-templates');				#	Add templates support
		#	add_theme_support('ewf-modHeader-parallax');				#	Add a parallax effect to header image, it requires an image having 685px height
			add_theme_support('ewf-modHeader-background-color');		#	Add background color support

		
			
		
		#	Register image sizes used by Mod Header
		#
			add_image_size( 'ewf-modHeader-img-parallax'				, 9999	, 685, true); 
			add_image_size( 'ewf-modHeader-img-large'					, 9999	, 485, true); 
			add_image_size( 'ewf-modHeader-img-thumbnail'				, 246	, 135, true);

			
			
		
		#	Attach required css & js in admin scripts header
		#
			add_action('admin_enqueue_scripts'							, array(&$this, 'load_includes'));
			
		
		

		#	Register meta box & update meta info
		#
			add_action('save_post'										, array(&$this, 'meta_update'));
			add_action('admin_menu'										, array(&$this, 'meta_register'));
			
		
		
		#	Register actions for AJAX callback functions
		#	
			add_action('wp_ajax_ewf_modHeader_master_use'				, array(&$this, 'ajax_use_master' ));
			add_action('wp_ajax_ewf_modHeader_activate'					, array(&$this, 'ajax_set_active' ));
			add_action('wp_ajax_ewf_modHeader_removeImage'				, array(&$this, 'ajax_remove_image' ));
			add_action('wp_ajax_ewf_modHeader_setImage'					, array(&$this, 'ajax_set_image' ));

			if (current_theme_supports('ewf-modHeader-templates')){		
				add_action('wp_ajax_ewf_modHeader_useTemplate'			, array(&$this, 'ajax_use_template' ));
				add_action('wp_ajax_ewf_modHeader_setTemplate'			, array(&$this, 'ajax_set_template' ));
			}
			
			if (current_theme_supports('ewf-modHeader-parallax')){		
				add_action('wp_ajax_ewf_modHeader_parallax'				, array(&$this,'ajax_set_parallax' ));
			}
		

		
		}
		
		
		
		function set_mod_settings($settings){
			$result = update_option('ewf_modHeader_settings', json_encode($settings));
			
			return $result;
		}
		
		function get_mod_settings(){
			$defaults = array(
				'templates' => array()
				);
			
			$settings = json_decode(get_option('ewf_modHeader_settings'), true);

			return $settings;
		}
		
		
		
		function ajax_use_master(){
			$response = array();
			
			if (is_array($_POST) && array_key_exists('master_use', $_POST)){ 
				
				if (strtolower(trim($_POST['master_use'])) == 'true'){ 
					$_POST['master_use'] = 1; 
				}else{ 
					$_POST['master_use'] = 0; 
				}
				
				$post_modHeader_settings = $this->get_postSettings($_POST['post']);
				$post_modHeader_settings['master_use'] = intval($_POST['master_use']);
				
				$this->set_postSettings($post_modHeader_settings, $_POST['post']);
				
				wp_send_json_success(array('title'=>$post_modHeader_settings['title'], 'master_id'=>$_POST['master_use'], 'post'=>$_POST['post']));
			}else{
				wp_send_json_error(array('state'=>$_POST['master_use'], 'post'=>$_POST['post']));
			}
			
			exit;
		} 
		
		function ajax_use_template(){
			 if (is_array($_POST) && array_key_exists('active', $_POST) && array_key_exists('template', $_POST)){ 
				$template = $_POST['template'];
				$active = intval($_POST['active']);
				
				$modHeader_settings = $this->get_mod_settings();
				$modHeader_settings['templates'][$template]['active'] = $active;
				
				$result = $this->set_mod_settings($modHeader_settings);
				
				wp_send_json_success(array('state'=>$result, 'active'=>$active, 'template'=>$template));		
				exit;
			}
		}
			
		function ajax_set_active(){
			$response = array();
			
			if (is_array($_POST) && array_key_exists('active', $_POST)){ 
				
				$post_modHeader_settings = $this->get_postSettings($_POST['post']);
				$post_modHeader_settings['active'] = $_POST['active'];
				
				$result = $this->set_postSettings($post_modHeader_settings, $_POST['post']);
				
				wp_send_json_success(array('state'=>$result, 'post'=>$_POST['post']));		
			}
			
			exit;
		} 
				
		function ajax_set_parallax(){
			$response = array();
			
			if (is_array($_POST) && array_key_exists('parallax', $_POST)){ 				
				$post_modHeader_settings = $this->get_postSettings($_POST['post']);
				$post_modHeader_settings['parallax'] = intval($_POST['parallax']);
				$this->set_postSettings($post_modHeader_settings, $_POST['post']);
				
				wp_send_json_success(array('parallax'=>$_POST['parallax'], 'post'=>$_POST['post']));
			}else{
				wp_send_json_error(array('parallax'=>$_POST['parallax'], 'post'=>$_POST['post']));
			}
			
			exit;
		}
		
		function ajax_set_template(){
			 if (is_array($_POST) && array_key_exists('master_id', $_POST) && array_key_exists('template', $_POST)){ 
				$template = $_POST['template'];
				$master_id = intval($_POST['master_id']);
				
				$modHeader_settings = $this->get_mod_settings();
				$modHeader_settings['templates'][$template]['master_id'] = $master_id;
				
				$result = $this->set_mod_settings($modHeader_settings);
				
				wp_send_json_success(array('state'=>$result, 'master_id'=>$master_id, 'template'=>$template));		
				exit;
			}
		}
		
		function ajax_set_image(){
			global $post;
			$response = array();
			
			if (array_key_exists('url', $_POST)){
				$image_id = intval(str_replace('-','',filter_var($_POST['img'] , FILTER_SANITIZE_NUMBER_INT)));
			
				if ($image_id){
					$cr_header_full = wp_get_attachment_image_src( $image_id, 'full');
					$cr_header_preview = wp_get_attachment_image_src( $image_id, 'ewf-modHeader-img-large');
					$cr_header_thumb = wp_get_attachment_image_src( $image_id, 'ewf-modHeader-img-thumbnail');
					
					if ($cr_header_preview[0] == $_POST['url'] || $cr_header_full[0] == $_POST['url']){
						
						$post_modHeader_settings = $this->get_postSettings($_POST['post']);
						$post_modHeader_settings['image_id'] = $image_id;
						$post_modHeader_settings['image_url'] = $cr_header_thumb[0];
						$this->set_postSettings($post_modHeader_settings, $_POST['post']);
						
						$response['image_id'] = $image_id;
						$response['thumb_url'] = $cr_header_thumb[0];
						$response['post'] = $_POST['post'];
						$response['state'] = '1'; 
						
						echo wp_send_json_success($response);
						exit;
					}
				}else{
					echo wp_send_json_error('Error image id!');
					exit;
				}
				
			}else{
				echo wp_send_json_error('Error data check!');
				exit;
			} 

			
		}

		function ajax_remove_image(){
			$response = array();
			
			if (array_key_exists('post', $_POST)){
				
				$post_modHeader_settings = $this->get_postSettings($_POST['post']);
				$post_modHeader_settings['image_id'] = 0;
				$post_modHeader_settings['image_url'] = '';
				$this->set_postSettings($post_modHeader_settings, $_POST['post']);
				
			 
				echo wp_send_json_success(array('state'=>1, 'post'=>$_POST['post']));
				exit;
			}else{
				echo wp_send_json_error('Error data check!');
				exit;
			}
		}

		
		function load_includes(){
			$includes = '/framework/modules/ewf-header/includes';
		
		
		
		   wp_enqueue_script ('media-upload');
		   
		   wp_enqueue_script ('wp-color-picker');
		   wp_enqueue_style ('wp-color-picker');
		   
		   wp_enqueue_script ('thickbox');
		   wp_enqueue_style ('thickbox');
		
		
		
			wp_enqueue_script ('ewf-modHeader-toggles-js'			, get_template_directory_uri().$includes.'/toggles/toggles.min.js'	, array('jquery')); 		
			wp_enqueue_script ('ewf-modHeader-resize-js'			, get_template_directory_uri().$includes.'/resize/jquery.resize.js'	, array('jquery')); 					
			wp_enqueue_script ('ewf-modHeader-js'					, get_template_directory_uri().$includes.'/ewf-modHeader.js'		, array('jquery')); 		
			
			wp_register_style ( 'ewf-modHeader-toggles-css'			, get_template_directory_uri().$includes.'/toggles/toggles.css' );
			wp_enqueue_style ( 'ewf-modHeader-toggles-css');
			
			wp_register_style ( 'ewf-modHeader-toggles-css-light'	, get_template_directory_uri().$includes.'/toggles/toggles-light.css' );
			wp_enqueue_style ( 'ewf-modHeader-toggles-css-light');
			
			wp_register_style ( 'ewf-modHeader-css'					, get_template_directory_uri().$includes.'/ewf-modHeader.css' );
			wp_enqueue_style ( 'ewf-modHeader-css');
		
		}

		
		
		function meta_register(){
			// $supported_post_types = array( 'pages', 'post', EWF_PROJECTS_SLUG );
			
			if (is_array($this->settings['support'])){
				foreach( $this->settings['support'] as $key => $post_type){
					add_meta_box( 'ewf-modHeader-meta', __('Page header', EWF_SETUP_THEME_DOMAIN), array(&$this, 'meta_source') , $post_type , 'normal', 'high');
				}
			}else{
				add_meta_box( 'ewf-modHeader-meta', __('Page header', EWF_SETUP_THEME_DOMAIN), array(&$this, 'meta_source') , $this->settings['support'] , 'normal', 'high');
			}

		}

		function meta_update(){
			global $post;
			
			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {  
					return $post->ID; 
				}
			
			if (!is_object($post)){
				 return false;
				}
			
	
			$post_modHeader_settings = $this->get_postSettings($post->ID);
			

			
			if (array_key_exists('_ewf_modHeader_master_id', $_POST)){
				$post_modHeader_settings['master_id'] = $_POST['_ewf_modHeader_master_id'];
			}
			
			if (array_key_exists('_ewf_modHeader_master_use',  $_POST)){
				$post_modHeader_settings['master_use'] = $_POST['_ewf_modHeader_master_use'];
			}
			
			
			
			if (array_key_exists('_ewf_modHeader_title', $_POST)){
				$post_modHeader_settings['title'] = $_POST['_ewf_modHeader_title'];
			}
			
			if (array_key_exists('_ewf_modHeader_title_src', $_POST)){
				$post_modHeader_settings['title_src'] = $_POST['_ewf_modHeader_title_src'];
			}
			
			
			
			if (array_key_exists('_ewf_modHeader_background_color', $_POST)){
				$post_modHeader_settings['background_color'] = $_POST['_ewf_modHeader_background_color'];
			}			
			
			if (array_key_exists('_ewf_modHeader_description', $_POST)){
				$post_modHeader_settings['description'] = $_POST['_ewf_modHeader_description'];
			}
			
			if (array_key_exists('_ewf_modHeader_description_src', $_POST)){
				$post_modHeader_settings['description_src'] = $_POST['_ewf_modHeader_description_src'];
			}
			
			
			$this->set_postSettings($post_modHeader_settings , $post->ID);
		}

		function meta_source(){
			global $post, $modHeader;
			
			$ewf_modHeader_settings = $this->get_postSettings($post->ID);
			$cache_pages = $this->cache_getPages();
				
			if ($ewf_modHeader_settings['active'] == '*'){
				$ewf_modHeader_active = 1;
			}else{
				$ewf_modHeader_active = $ewf_modHeader_settings['active'];
			}
			
			
			$ewf_modHeader_activeContent_class = null;
			$ewf_modHeader_active_class = null;
			
			if ($ewf_modHeader_active == '0'){
				$ewf_modHeader_activeContent_class = 'disabled';
				$ewf_modHeader_active_class = 'off';
			}
			
			
			$ewf_headerMeta_imgID = $ewf_modHeader_settings['image_id'];

			$ewf_postTypes_cache = array( 
				'post' => array('list' => $this->cache_getPostType('post'), 'source' => null), 
				'page' => array('list' => $this->cache_getPostType('page'), 'source' => null), 
			);
			
			
			$header_templates_data = array(
				'Blog' => array(
					array( 
						'id' => 'blog',
						'title' => 'Blog page',
						'type' => 'post'),
						
					array( 
						'id' => 'blog-single',
						'title' => 'Blog Single',
						'type' => 'post'),
						
					array( 
						'id' => 'blog-archive-tags',
						'title' => 'Blog Archive - Tags',
						'type' => 'post'),
					
					array( 
						'id' => 'blog-archive-date',
						'title' => 'Blog Archive - Date',
						'type' => 'post'),
						
					array( 
						'id' => 'blog-archive-categories',
						'title' => 'Blog Archive - Categories',
						'type' => 'post'),
				),
				
				'Page' => array(
					array( 
						'id' => 'page',
						'title' => 'Page',
						'type' => 'page'),
						
					array( 
						'id' => 'page-404',
						'title' => 'Page 404',
						'type' => 'page'),
				),
				
			);
			
			
			
			ob_start();
			
			echo '<div class="ewf-modHeader-metaBox">';		
					
			
					#	Load Tabs & Activation bar
					#
					echo'<div class="ewf-mh-tabsBar clearfix '.$ewf_modHeader_activeContent_class.'">';
							
							# Load toggle bar
							#
							echo '<div>';
								echo '<div class="ewf-mh-mainToggle">';
									echo '<div class="toggle-light"><div class="toggle" '.$ewf_modHeader_active_class.'></div></div>';
								echo '</div>';
								echo '<span>'.__('Use page header', EWF_SETUP_THEME_DOMAIN).'</span>';
							echo '</div>';
							
							
							#	Load tabs
							#
							echo '<ul>';
								echo '<li class="active"><a href="#" data-content="ewf-mh-tbcontent-header" class="ewf-mh-tab-header">'.__('Header', EWF_SETUP_THEME_DOMAIN).'</a></li>';
								if (current_theme_supports('ewf-modHeader-templates')){
									echo '<li><a href="#" data-content="ewf-mh-tbcontent-templates">'.__('Templates', EWF_SETUP_THEME_DOMAIN).'</a></li>';
								}
							echo '</ul>';
		
					echo '</div>';
					

					
					#	Load tabs content
					#
					echo '<div class="ewf-mh-tabscontent clearfix '.$ewf_modHeader_activeContent_class.'">';
						
						
						#	Load page templates if we have support for it
						#
						if (current_theme_supports('ewf-modHeader-templates')){
					   
							echo '<div class="ewf-mh-tbcontent-templates">';
								echo '<span>'.__('Keep in mind that these settings are global', EWF_SETUP_THEME_DOMAIN).'</span>';
								
								echo '<div class="ewf-mh-page-templates">';
									
									$settings = $this->get_mod_settings();
									
									foreach($header_templates_data as $section_title => $section_data){
										echo '<h2>'.$section_title.'</h2>';
										
										echo '<ul class="ewf-mh-templates-set">';
											foreach($section_data as $template_index => $template_data){
												
												$data_enabled = null;
												$header_enabled = null;
												
												if ( is_array($settings['templates']) && array_key_exists($template_data['id'], $settings['templates']) && array_key_exists('active', $settings['templates'][$template_data['id']])){
													if ($settings['templates'][$template_data['id']]['active'] == 1){
														$data_enabled = ' data-enabled="true"';
														$header_enabled = ' header-enabled';
													}
												}
												
												echo 
												'<li class="template-'.$template_data['id'].' '.$header_enabled.'" data-setting="'.$template_data['id'].'" >
													<div class="ewf-template-section">
														<span>'.$template_data['title'].'</span>
														<div class="toggle-light"><div '.$data_enabled.' class="toggle"></div></div>
													</div>
													<div class="ewf-template-details">';
														
														$selected_id = 0;
														
														if ( is_array($settings['templates']) && array_key_exists($template_data['id'], $settings['templates']) && array_key_exists('master_id', $settings['templates'][$template_data['id']] )){
															$selected_id = $settings['templates'][$template_data['id']]['master_id'];
														}
														
														echo $this->generate_inputSelectList($ewf_postTypes_cache[$template_data['type']]['list'], $selected_id);
													
												  echo '<label for="">'.__('Get header settings from other page', EWF_SETUP_THEME_DOMAIN).'</label>
													</div>
												</li>';
											
											}
										echo '</ul>';
									}
									
									// echo '<pre>';
										// print_r($ewf_postTypes_cache);
										// print_r($header_settings_data);
										// print_r($settings);
									// echo '</pre>';
									
								echo '</div>';
							echo '</div>';
							
						}

						
						#	Load page header settings
						#
						echo '<div class="ewf-mh-tbcontent-header tab-active">';
						
							echo '<div class="ewf-headerMeta-image">';
								$ewf_modHeader_backgroundColorClass = null;
								$ewf_modHeader_uploadedClass = null;
								$ewf_modHeader_uploadedUrl = null;
								
								$ewf_modHeader_uploadedMasterUrl = null;
								$has_master = false; 
								
								$ewf_master_settings = null;
								
								//	If it uses a master and is activated
								//
								if ( array_key_exists('master_use', $ewf_modHeader_settings) && $ewf_modHeader_settings['master_use'] > 0 && $ewf_modHeader_settings['master_id'] > 0){
									$ewf_master_settings = $this->get_postSettings($ewf_modHeader_settings['master_id']);
									$ewf_modHeader_settings['debug'][] = '# User master page ID:'.$ewf_modHeader_settings['master_id'];	// DEBUG
									
									
									if ($ewf_master_settings['image_id'] > 0){
										$ewf_modHeader_uploadedMasterUrl = wp_get_attachment_image_src( $ewf_master_settings['image_id'], 'ewf-modHeader-img-thumbnail');
										$ewf_modHeader_uploadedClass .= 'master-image ';
										$has_master = true;
										
										$ewf_modHeader_settings['debug'][] = '# Master Image ID:'.$ewf_master_settings['image_id'];	// DEBUG
									}else{
										$ewf_modHeader_settings['debug'][] = '# Master Image NOT Set';	// DEBUG
										$ewf_modHeader_uploadedClass .= ' no-image';
									}
								
								//	If it has a master but is not activated
								}elseif ( array_key_exists('master_use', $ewf_modHeader_settings) && $ewf_modHeader_settings['master_use'] == 0 && $ewf_modHeader_settings['master_id'] > 0 ){
									$ewf_master_settings = $this->get_postSettings($ewf_modHeader_settings['master_id']);
									$ewf_modHeader_settings['debug'][] = '# Has master but use is false';	// DEBUG
									
									if ($ewf_master_settings['image_id'] > 0){
										$ewf_modHeader_uploadedMasterUrl = wp_get_attachment_image_src( $ewf_master_settings['image_id'], 'ewf-modHeader-img-thumbnail');
									}
								}
								
								
								
								if ( $ewf_modHeader_settings['image_id'] || ($ewf_modHeader_settings['image_id'] && $has_master == false) ){
									$ewf_modHeader_uploadedClass .= 'active';
									$ewf_modHeader_uploadedUrl =  wp_get_attachment_image_src( $ewf_modHeader_settings['image_id'], 'ewf-modHeader-img-thumbnail');
								}
									
								echo '<div class="preview '.$ewf_modHeader_uploadedClass.'">'; 
									echo '<img class="ewf-header-meta-preview" src="'.$ewf_modHeader_uploadedUrl[0].'" width="246" height="135" />';					
									echo '<img class="ewf-modHeader-master-image" src="'.$ewf_modHeader_uploadedMasterUrl[0].'" width="246" height="135" />';					
									
									echo '<a id="ewf-upload-header-image" class="button button-primary button-large" type="button" href="#" ><span></span>'.__('Upload Image', EWF_SETUP_THEME_DOMAIN).'</a>'; 
									echo '<a id="ewf-header-image-remove" class="button button-primary button-large" type="button" href="#" ><span></span>'.__('Remove Image', EWF_SETUP_THEME_DOMAIN).'</a>'; 
								echo '</div>';
							echo '</div>'; 
							
							
							if (array_key_exists('master_use', $ewf_modHeader_settings) && $ewf_modHeader_settings['master_use'] == 1){
								$st_master_use = 'true';
								$st_master_class = null;
								$ewf_modHeader_backgroundColorClass = ' disabled';
							}else{
								$st_master_class = ' disabled';
								$st_master_use = 'false';
							}
							
							echo '<div class="ewf-mh-stgroup">';
							
								#	Page header - Title field
								#
								$this->generate_inputText( array( 'field_id' => '_ewf_modHeader_title', 'field_id_setting' => 'title', 'master_id_setting' => 'master_id', 'field_src' => 'mh-type-page-header-title' ), $ewf_modHeader_settings, $cache_pages);
								
								#	Page header - Description field
								#
								if (current_theme_supports('ewf-modHeader-description')){
									$this->generate_inputTextarea( array( 'field_id' => '_ewf_modHeader_description', 'field_id_setting' => 'description', 'master_id_setting' => 'master_id' ), $ewf_modHeader_settings, $cache_pages);
								}
								
								
								
								
								#	Page header - Background color field
								#	
								if (current_theme_supports('ewf-modHeader-background-color')){	
								
									if (!array_key_exists('background_color', $ewf_modHeader_settings)){	
										$ewf_modHeader_settings['background_color'] = $this->settings['defaults']['background_color'];
									}
								
									$ewf_modHeader_backgroundColor = $ewf_modHeader_settings['background_color'];
									if ($ewf_modHeader_backgroundColorClass && $ewf_master_settings['background_color']){
										$ewf_modHeader_backgroundColor = $ewf_master_settings['background_color'];
									}
									
									echo '<div class="ewf-mh-stfield mh-field-color clearfix'.$ewf_modHeader_backgroundColorClass.'" data-color="'.$ewf_modHeader_settings['background_color'].'">';					
										echo '<label>'.__('Background color', EWF_SETUP_THEME_DOMAIN).'</label>';
										echo '<input name="_ewf_modHeader_background_color" type="text" id="_ewf_modHeader_background_color" value="'.$ewf_modHeader_backgroundColor.'" data-default-color="#000" >';
										echo '<div class="disabled-overlay"></div>';
									echo '</div>';
								}
								
								
								#	Page header - Parallax Effect
								#
								if (current_theme_supports('ewf-modHeader-parallax')){
									if (array_key_exists('parallax', $ewf_modHeader_settings) && $ewf_modHeader_settings['parallax'] == 1){
										$st_parallax = 'true';
									}else{
										$st_parallax = 'false';
									}
									
									echo '<div class="ewf-mh-stfield mh-field-toggle ewf-mh-parallax clearfix" data-enabled="'.$st_parallax.'" >';
										echo '<label>'.__('Add a parallax effect to header', EWF_SETUP_THEME_DOMAIN).'<input type="checkbox" class="" id="_ewf_modHeader_parallax" ></label>';
										
										echo '<div class="toggle-light">';
											echo '<div class="toggle"></div>';
										echo '</div>';
									echo '</div>';
								}

								
								
								


								
								
								echo '<div class="ewf-mh-stfield mh-field-toggle ewf-mh-useMaster clearfix" data-enabled="'.$st_master_use.'" >';
									echo '<label>'.__('Use header from another page', EWF_SETUP_THEME_DOMAIN).'<input type="checkbox" class="" id="_ewf_modHeader_master_use" ></label>';
									
									echo '<div class="toggle-light">';
										echo '<div class="toggle"></div>';
									echo '</div>';
								echo '</div>';
								 
								
								
								 
								echo '<div class="ewf-mh-master-settings '.$st_master_class.'">';
									//unset($cache_pages[$post->ID]);
									$this->generate_inputPages( array( 'field_id' => '_ewf_modHeader_master_id', 'field_id_setting' => 'master_id' ), $ewf_modHeader_settings, $cache_pages);
								echo '</div>';
								
								
								
								
								
							echo '</div>';
						echo '</div>';
						
		
				   echo '</div>';
					
					
					// echo '<pre>';
						// print_r($ewf_modHeader_settings);
					// echo '</pre>';
					
				
				echo '<input id="ewf-upload-header-imageID" name="ewf-upload-header-imageID" type="hidden" value="'.$ewf_modHeader_settings['image_id'].'" />'; 
				echo '<input id="ewf-upload-header-postID" type="hidden" value="'.$post->ID.'" />'; 
			echo '</div>';
			
			
			echo ob_get_clean();
		}

		
		
		function generate_inputText($prop, $post_custom_meta, $cache_pages ){
			global $post;
			
			$field_type_title = array('mh-type-page-header-title' => __('Header Title', EWF_SETUP_THEME_DOMAIN), 'mh-type-page-title' => __('Page Title', EWF_SETUP_THEME_DOMAIN), 'mh-type-page-excerpt' => __('Page excerpt', EWF_SETUP_THEME_DOMAIN) );
			
			$prop = (object) $prop;
			#	field_id
			#	field_id_setting
			#	field_src	-	mh-type-page-header-title / mh-type-page-title / mh-type-page-excerpt / mh-type-custom
			#	master_id_setting
			
			
			#	If the post has master activated disable the field;
			#
			$field_disabled = null;
			if (!array_key_exists('master_use', $post_custom_meta)){
				$post_custom_meta['master_use'] = 0;
			}
			
			
			if ($post_custom_meta['master_use'] == 1 && $post_custom_meta['master_id'] > 1){
				$field_disabled = 'disabled';
			}
			
			
			#	Load field value
			#
			$field_value = $post_custom_meta[$prop->field_id_setting];
			$cached_page_title = $post->post_title;
			$cached_page_header_title = $post_custom_meta['title'];
			$cached_page_excerpt = $post->post_excerpt;
			
			
			#	Attempt to load master page id value 
			#
			$class_master = null;
			$master_id = $post_custom_meta[$prop->master_id_setting];
			
			// echo '<pre>';
				// print_r($post_custom_meta);
			// echo '</pre>';
			
			if ($master_id && $post_custom_meta['master_use'] > 0){
			
				// echo '<pre>';
					// print_r($cache_pages[$master_id]);
				// echo '</pre>'; 
			
				$cached_page_title = $cache_pages[$master_id]['mh-type-page-title'];
				$cached_page_excerpt = $cache_pages[$master_id]['mh-type-page-excerpt'];
				$cached_page_header_title = $cache_pages[$master_id]['mh-type-page-header-title'];
				
				$field_value = $cache_pages[$master_id][$prop->field_src];
			}else{
				$class_master = 'no-master';  
				
				switch($prop->field_src){
				
					case 'mh-type-page-title':
						$field_value = 'Page Title';	#TODO - load page title here
						break;
				
					case 'mh-type-page-excerpt':
						$field_value = 'Page Title';	#TODO - load page excerpt here
						break;
					
					case 'mh-type-page-header-title':
						$field_value = $post_custom_meta[$prop->field_id_setting];
						break;
				
				
				}
			}
			
			
			$src = '<div class="ewf-mh-stfield stfield'.$prop->field_id.' '.$prop->field_src.' '.$class_master.' no-dropdown clearfix">
						<div class="ewf-mh-fielddrop">
							<label>'.__('Title', EWF_SETUP_THEME_DOMAIN).'</label>
							
							<div class="ewf-mh-selDropdown">
								<a href="#"></a>
								<ul>
									<li><a href="#" class="mh-type-custom" data-post="'.$post_custom_meta[$prop->field_id_setting].'" rel="'.$post_custom_meta[$prop->field_id_setting].'">'.__('Custom text', EWF_SETUP_THEME_DOMAIN).'</a></li>
									<li><a href="#" class="mh-type-page-title" data-post="'.$post->post_title.'" rel="'.$cached_page_title.'">'.$field_type_title['mh-type-page-title'].'</a></li>
									<li><a href="#" class="mh-type-page-excerpt" data-post="'.$post->post_excerpt.'" rel="'.$cached_page_excerpt.'">'.$field_type_title['mh-type-page-excerpt'].'</a></li>
									<li><a href="#" class="mh-type-page-header-title" data-post="'.$post_custom_meta['title'].'" rel="'.$cached_page_header_title.'">'.$field_type_title['mh-type-page-header-title'].'</a></li>
								</ul>
							</div>
							<span class="ewf-mh-selLabel">'.$field_type_title[$prop->field_src].'</span>
						</div> 
						
						<input autocomplete="off" type="text" '.$field_disabled.' name="'.$prop->field_id.'" value="'.$field_value.'" >
						<input autocomplete="off" type="hidden" '.$field_disabled.' name="'.$prop->field_id.'_src" value="'.$prop->field_src.'" >
					</div>';
			
			echo $src;
		}
		
		function generate_inputTextarea($prop, $post_custom_meta, $cache_pages){
			$prop = (object) $prop;
			#	field_id
			#	field_id_setting
			#	master_id_setting
			
			
			
			$field_value = null;
			$field_master_value = null;
			
			$cached_custom = 'Sample';
			$cached_title = 'Sample title';
			$cached_excerpt = 'Sample excerpt';
			
			$field_type_value = 'mh-type-custom';
			$field_type_text = 'Custom text';
			$field_disabled = null;
			
			
			#	Attempt to load the previous saved value of the field
			#
			$field_value = $post_custom_meta[$prop->field_id_setting];
			
			
			if ($field_value == 'mh-type-title' || $field_value == 'mh-type-excerpt'){
				$field_type = $field_value;
			}else{
				$field_type = 'mh-type-custom'; 
			}
			
			
			#	Attempt to load master page id value 
			#
			$field_master_value = $post_custom_meta[$prop->master_id_setting];
			
			
			if ($field_master_value == '0'){ 
				$field_master_value = 'no-master'; 
			}else{
			
				$cached_title = $cache_pages[$field_master_value]['title'];
				$cached_excerpt = $cache_pages[$field_master_value]['excerpt'];
				
				if ($field_value == 'mh-type-title'){
					$field_value = $cached_title;
					$field_type_value = 'mh-type-title';
					$field_type_text = 'Page Title';
					$field_disabled = 'disabled';
				}elseif($field_value == 'mh-type-excerpt'){
					$field_value = $cached_excerpt; 
					$field_type_value = 'mh-type-excerpt';		
					$field_type_text = 'Page Excerpt';
					$field_disabled = 'disabled';
				}

			}
			
			
			
			$src = '<div class="ewf-mh-stfield '.$field_type_value.' '.$field_master_value.' clearfix">
						<div class="ewf-mh-fielddrop">
							<label>'.__('Description', EWF_SETUP_THEME_DOMAIN).'</label>
							
							<div class="ewf-mh-selDropdown">
								<a href="#"></a>
								<ul>
									<li><a href="#" class="mh-type-custom" rel="'.$cached_custom.'">'.__('Custom text', EWF_SETUP_THEME_DOMAIN).'</a></li>
									<li><a href="#" class="mh-type-title" rel="'.$cached_title.'">'.__('Page title', EWF_SETUP_THEME_DOMAIN).'</a></li>
									<li><a href="#" class="mh-type-excerpt" rel="'.$cached_excerpt.'">'.__('Page excerpt', EWF_SETUP_THEME_DOMAIN).'</a></li>
								</ul>
							</div>
							<span class="ewf-mh-selLabel">'.$field_type_text.'</span>
						</div>
						
						<textarea '.$field_disabled.' name="'.$prop->field_id.'">'.$field_value.'</textarea>
						<input type="hidden" name="'.$prop->field_id.'_type" value="'.$field_type.'" >
					</div>';
			
			echo $src;
		}
		
		function generate_inputPages($prop, $post_custom_meta, $cache_pages, $export_pages = false){
			$prop = (object) $prop;
			#	field_id
			#	field_id_setting
			#	field_title
			
			
			$filter_master = true;		#	Remove all the pages that have a master page
		
			$field_value = 'None';
			$export = null;
			
			
			#	Attempt to load the previous saved value of the field
			#
			$field_value = $post_custom_meta[$prop->field_id_setting];
			
			$src = '<div class="ewf-mh-stfield clearfix">';
					
					if (isset($prop->field_title) && $prop->field_title){
					
						$src.= '<div class="ewf-mh-fielddrop">					
									<label>'.$prop->field_title.'</label>
								</div>';
					}

					
					#	Filter pages with master ID
					#
					if ($filter_master){
						foreach($cache_pages as $key => $page_item){
							if ($page_item['master_use']){
								unset($cache_pages[$key]);
								
								// echo '<pre>';
									// print_r($page_item);
								// echo '</pre>';
							}
						}
					}
					
					
						
					$src.= '<select autocomplete="off" name="'.$prop->field_id.'" id="'.$prop->field_id.'">';
						#	$src .='<option value="0">None</option>';
							
							foreach($cache_pages as $key => $page_item){
								
								if ($field_value == $page_item['id']){
									$src .= '<option selected="selected" value="'.$page_item['id'].'">'.$page_item['title'].'</option>';
								}else{
									$src .= '<option value="'.$page_item['id'].'">'.$page_item['title'].'</option>';
								}
								
								$export .= '<a data-excerpt="'.esc_attr($page_item['excerpt']).'" data-id="'.$page_item['id'].'" data-image="'.$page_item['image_url'].'" data-background-color="'.$page_item['background_color'].'" data-title="'.esc_attr($page_item['title']).'" data-header-title="'.esc_attr($page_item['header_title']).'">Page</a>, ';
							}
				$src .= '</select>
		
						<span>'.__('Get the header image and title from another page', EWF_SETUP_THEME_DOMAIN).'</span>
					</div>';
					
			echo $src.'<div class="ewf-mh-pages-data-cache">'.$export.'</div>';
		} 

		function generate_inputSelectList($list, $selected_id = 0){
			$src = null;
			
			if(is_array($list)){
				
				$list[0] = 'Select page';
				
				$src .= '<select>';
					foreach($list as $key => $value){
						if ($selected_id == $key){
							$src .= '<option value="'.$key.'" selected="selected">'.$value.'</options>';
						}else{
							$src .= '<option value="'.$key.'">'.$value.'</options>';
						}
					}
				$src .= '</select>';
			
			}
		
			return $src;
		}
		

		
		function set_postSettings($post_modHeader_settings, $post_id){
			global $post;
			
			return update_post_meta($post_id, '_ewf_modHeader_settings', json_encode($post_modHeader_settings));
		}
		
		function get_postSettings($post_id = 0){
			global $post;
			
			$post_modHeader_settings = array();
			$post_modHeader_defaults = $this->settings['defaults'];
			
			if (!$post_id) {
				if (is_object($post)){
					$post_id = $post->ID;
				}else{
					return $post_modHeader_defaults;
				}
			}
			
			$post_meta = get_post_custom($post_id);
			
			if (!array_key_exists('_ewf_modHeader_settings', $post_meta)){
				$post_modHeader_settings = $post_modHeader_defaults;
			}else{
				$post_modHeader_settings = json_decode($post_meta['_ewf_modHeader_settings'][0], true);
			}
			
			return $post_modHeader_settings;
		}
		
		
		
		function get_pageTemplate( $headerCheck = false, $page_for_posts = 0 ){
			global $post;
			
			$template_type = array();
			$debug = array();
			 
			##	Check if there's a blog page ID provided
			##
			if ($page_for_posts == 0){
				$page_for_posts = get_option('page_for_posts');
				}
			
			
			
			if (is_singular() && is_object($post)){
				$debug[] = $post->post_type.'-single';
		
			}elseif(is_archive()){
				// echo '<br/>Is post type archive:'.is_post_type_archive('post');
				
				$post_type = 'post-';
				
				if (is_tag()){
					$debug[] = $post_type.'archive-tag';
				}elseif(is_date()){
					$debug[] = $post_type.'archive-date';
				}elseif(is_category()){
					$debug[] = $post_type.'archive-category';
				
				}
			}elseif(is_home() && is_front_page() == false){
				$debug[] = 'page-posts';
				// $debug[] = 'Post ID:'.$post->ID;
				// $debug[] = 'Post Page:'.$page_for_posts;
			}elseif(is_page() && count($post->ancestors)){
				$debug[] = 'page-parent';
			
			}
			
			
			// $debug[] = 'Singular: '.is_singular();
			// $debug[] = 'Type: '.$post->post_type;
			
			
			// echo '<pre>';
				// print_r($wp_query);
			// echo '</pre>';

			/*
			
			if (is_single()){
				$ewf_page_data = null;
				
				switch($post->post_type){
					case "post":
						$debug = "Related ID: Page Single - ".$post->ID;
						break;
					
					case "post":
						#$ewf_page_data = get_page_by_title( get_option(EWF_SETUP_THNAME."_page_blog", null ) );
						$ewf_page_data = get_post($page_for_posts);
						
						// ewf_debug_log("debug", "Related ID: Post Single");
						$debug[] = "Related ID: Post Single - ".$ewf_page_data->ID;
						
						break;
				
					case EWF_PROJECTS_SLUG:
						$ewf_page_data = get_page_by_title( get_option(EWF_SETUP_THNAME."_page_portfolio", null ) );
						// ewf_debug_log("debug", "Related ID: EWF_PROJECTS_SLUG Single"); 
						
						break;		
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
					
					
					// ewf_debug_log("debug", "Parent does not have header image, returning child ID [".$ewf_child_page_parent_imgID.']['.$ewf_child_page_imgID.']');
					 
					## If the child have an image but the parent also has one, return the child ID
					##
					if ($ewf_child_page_imgID > 0){
						$ewf_page_id = $post->ID;
						
						// ewf_debug_log("debug", "Parent does have header image, but child also has one, returning child ID [".$ewf_child_page_parent_imgID.']['.$ewf_child_page_imgID.']');
					}
					
					
					## If the parent does not have an image niether the child return null
					if ( $ewf_child_page_parent_imgID == 0 &&  $ewf_child_page_imgID == 0){
						$ewf_page_id = 0;
					}
				}
			
			}elseif(is_archive()){
				
				if (is_tax(EWF_PROJECTS_TAX_SERVICES)){
					
					$ewf_page_data = get_page_by_title( get_option(EWF_SETUP_THNAME."_page_portfolio", null ) );
					// ewf_debug_log("debug", "Related ID: EWF_PROJECTS_SLUG Taxonomy"); 			
					
				}else{
				
					$ewf_page_data = get_post($page_for_posts);
					// ewf_debug_log("debug", "Related ID: Archive Page - Return Blog Page ID");
					
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
					// ewf_debug_log("debug", "Related ID: Search Page - Return Blog Page ID: ".$ewf_page_data->ID);
				}
			}elseif(is_home() && is_front_page() == false){
				$ewf_page_data = get_post($page_for_posts);
				if (is_object($ewf_page_data)){
					
					$ewf_page_id = $ewf_page_data->ID; 
					// ewf_debug_log("debug", "Related ID: Static Posts Page ID: ".$ewf_page_data->ID);
					
				}
			}

			*/
			
			// echo '<pre>';
				// print_r($debug);
			// echo '</pre>';
			
			
			// return $ewf_page_id;
		}
		
		
	#	Get all the pages with id, title and content for cache purpose
		function cache_getPages($exclude_id = 0, $filter = false){
			$pages_list = get_pages();
			$pages_return = array(); 
			
			foreach($pages_list as $current_page){
				$post_modHeader_settings = $this->get_postSettings($current_page->ID);
				
				$title = trim($current_page->post_title);
				$header_title = null;
				$excerpt = trim($current_page->post_excerpt); 
				
				
				if (is_array($post_modHeader_settings)){
					
					
					if (array_key_exists('master_use', $post_modHeader_settings) && $post_modHeader_settings['master_use'] == 1){
						$title = '* '.$title;
					}
					
					#	If there is an Image URL also save the title
					#
					if (array_key_exists('image_url', $post_modHeader_settings)){
						$header_title = $post_modHeader_settings['title'];
						}
				
					if ($header_title == null) { 
						$header_title = __('The page has no header title', EWF_SETUP_THEME_DOMAIN); 
						}
						
					if ($title == null) { 
						$title = __('The page has no title', EWF_SETUP_THEME_DOMAIN); 
						}
											
					if ($excerpt == null) { 
						$excerpt = __('The page has no excerpt', EWF_SETUP_THEME_DOMAIN); 
						}
					
					$current_page_data = array(
						'id' =>$current_page->ID, 
						'master_use' => $post_modHeader_settings['master_use'], 

						'title'=> $title, 
						'excerpt'=> $excerpt, 
						'header_title'=> $header_title,
						
						'mh-type-page-title' => $title, 
						'mh-type-page-excerpt' => $excerpt, 
						'mh-type-page-header-title' => $header_title,
						'image_url'=> null, 
						'background_color' => null
					);
				
				
					if (array_key_exists('background_color', $post_modHeader_settings)){
						$current_page_data['background_color'] = $post_modHeader_settings['background_color'];
					}

					if (is_array($post_modHeader_settings) && array_key_exists('image_url', $post_modHeader_settings)){
						$current_page_data['image_url'] = $post_modHeader_settings['image_url'];
					}
					
					
					if ($filter == true && ($post_modHeader_settings['master_use'] == 0)){
						$pages_return[$current_page->ID] = $current_page_data;
					}elseif($filter == false){
						$pages_return[$current_page->ID] = $current_page_data;
					}
					
				} 
				
			}
			
			
			if ($exclude_id){
				unset($pages_return[$exclude_id]);
			}
			
			return $pages_return;
		}
		
		
	#	Get all the posts from a specified post type
		function cache_getPostType($type = 'page'){
			$posts_list = array();
			
			// $query = array( 'post_type' => $type, 'posts_per_page' => -1 ); 
			// $wp_query_posts_type = new WP_Query($query);
			
			// while ($wp_query_posts_type->have_posts()) : $wp_query_posts_type->the_post();
				// $posts_list[$post->ID] = get_the_title();
			// endwhile;

			// wp_reset_query();
			
			return $posts_list;
		}

		
		
		
		
		
	#
	#	Add image size into media properties on upload
	#
	#	add_filter('image_size_names_choose'			, 'ewf_modHeader_additionalImageSizes');					
	#
	#	function ewf_modHeader_additionalImageSizes($sizes) {	
	#	   $myimgsizes 	= array("ewf-modHeader-img-large" => __('Page Header', EWF_SETUP_THEME_DOMAIN));
	#	   $newimgsizes = array_merge($sizes, $myimgsizes);
	#	   
	#	   return $newimgsizes;
	#	}
	#

		
	
	}

	
	#	Remove all the meta information from the pages
	#
	function remove_pages_meta(){
		global $post;
		
		$wp_query_pages = new wp_query(array('showposts' => -1, 'post_type' => 'page'));
		
		while ($wp_query_pages->have_posts()) : $wp_query_pages->the_post();		
			delete_post_meta($post->ID, "_ewf_modHeader_settings"); 
		endwhile;
		
		wp_reset_query();
	}
	
}


	$ewf_modHeader = new EWF_ModHeader;
	
	// remove_pages_meta();
	
	function ewf_getHeaderImageID($post_id) {
		global $ewf_modHeader;
	
		$ewf_data = $ewf_modHeader->get_postSettings();
		$ewf_image_id = 0;
		
		if (array_key_exists('_ewf-headerMeta-imgID',$ewf_data) && $ewf_data["_ewf-headerMeta-imgID"][0] != null){
			return $ewf_data["_ewf-headerMeta-imgID"][0];
		}else{
			return 0;
		}
	}

	
	
	
	
	
	
?>