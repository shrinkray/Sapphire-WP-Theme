<?php

		
#
#	Load text domain and translation files
#	
	load_theme_textdomain( EWF_SETUP_THEME_DOMAIN, get_template_directory() .'/language/' );
	
	
	
#
#	Current theme settings
#	
	
	$ewf_theme_settings = array(
	
		'blog' => array(
			'layout' 	=> 'layout-sidebar-single-right',
			'sidebar' 	=> 'sidebar-blog'
		),
	
	
	
	);
	
	
#
#	Manage includes from framework
#
	include_once ('functions-general.php'						);  
	
	
	#	Custom MCE Styles
	#
	include_once ('functions-mce-styles.php'					);	
	
	
	#	Custom post types
	#
	include_once ('functions-type-project.php'					);
	// include_once ('functions-type-slide.php'					);
	// include_once ('functions-type-study.php'					);
	
	
	# 	Modules
	#
	include_once ('modules/ewf-header/ewf-modHeader.php'		); 
	include_once ('modules/ewf-layout/ewf-modLayout.php'		);
	
	
	#	Menus & Sidebars
	#
	include_once ('functions-menus.php'							);
	include_once ('functions-sidebars.php'						);
	
	
	# 	Widgets
	#	
	// include_once ('widgets/widget-navigation.php'				);
	include_once ('widgets/widget-call-to-action.php'			);
	include_once ('widgets/widget-latest-posts.php'				);
	include_once ('widgets/widget-contact-form.php'				);
	include_once ('widgets/widget-social-media.php'				);
	include_once ('widgets/widget-flickr.php'					);
	
		
	#	Post & Template handles
	#
	include_once ('functions-blog.php'							);
	// include_once ('functions-meta-contact.php'				);
	
	
	#	Plugins
	#
	include_once ('plugins/plugins-activation.php'				);
	include_once ('plugins/plugins-required.php'				);
	
	
	#	Composer Components
	#	
	if (function_exists('vc_add_param')){
		include_once ('composer/components.php'					);
	}
	
	
	#	Admin Options
	#
	include_once ('admin/admin-fonts.php'						);	
	include_once ('admin/admin-options.php'						);
	include_once ('admin/admin-customizer.php'					);
	
	

	

	
	
	
#
#	Add theme support
#
	
	#	Add thumbnails to post types
	add_theme_support( 'post-thumbnails', array( 'post', 'page', 'slide', 'project') );
	
	
	#	Add automatically feed links
	add_theme_support( 'automatic-feed-links');
	
	
	#	Slider support 
	add_theme_support('ewf-slider-description');
	
	
	#	Add page excerpt support
	add_post_type_support( 'page', 'excerpt' );
	
	
	#	Add thumbnail default size
	set_post_thumbnail_size( 50, 50, true ); 


	

#
#	Include all required scripts & css files in the theme
#
	add_action('wp_enqueue_scripts'								, 'ewf_load_frontend_includes');
	add_action('admin_enqueue_scripts'							, 'ewf_load_admin_includes');

	
	add_action('init'  											, 'ewf_loat_tinyMCE_style');
	function  ewf_loat_tinyMCE_style() {
		add_editor_style ( get_template_directory_uri().'/layout/css/mce.css');
	}
	

	
	function ewf_load_admin_includes(){
	
		#  Style  - Font Awesome
		wp_enqueue_style('plugin-fontawesome-css'			, get_template_directory_uri().'/layout/css/fontawesome/font-awesome.min.css' );

		#  Style  - Font Iconfontcustom
		wp_enqueue_style('plugin-iconfontcustom-css'		, get_template_directory_uri().'/layout/css/iconfontcustom/iconfontcustom.css' );

		
		wp_enqueue_script('setup-js'						, get_template_directory_uri().'/framework/admin/includes/options-panel.js', array('jquery')); 		
		wp_enqueue_style('setup-css'						, get_template_directory_uri().'/framework/admin/includes/options-panel.css');
		
	}
	
	function ewf_load_frontend_includes(){
		$protocol = is_ssl() ? 'https' : 'http';
	
		

		
		
		#  Style  - Animate 
		wp_enqueue_style('plugin-animate-css'				, get_template_directory_uri().'/layout/css/animate/animate.min.css' );
		
		
		#  Style  - Font Awesome
		wp_enqueue_style('plugin-fontawesome-css'			, get_template_directory_uri().'/layout/css/fontawesome/font-awesome.min.css' );
		

		#  Style  - Font Iconfontcustom
		wp_enqueue_style('plugin-iconfontcustom-css'		, get_template_directory_uri().'/layout/css/iconfontcustom/iconfontcustom.css' );
	
		
		
		$_body_font = ewf_hlp_font_decode( EWF_SETUP_THNAME."_body_font", true);
		if ($_body_font['font-family']){
			$font_url = ewf_hlp_font_googleurl($_body_font['font-family']);
			
			#  Style - Google Fonts
			wp_enqueue_style('plugin-googlefonts'			, $font_url);
		}

		
		
		
		#  Plugin - Viewport
		wp_enqueue_script('plugin-viewport'					, get_template_directory_uri().'/layout/js/viewport/jquery.viewport.js'					, array('jquery'),'1.0', true );    		
		
		
		#  Plugin - Easing
		wp_enqueue_script('plugin-easing'					, get_template_directory_uri().'/layout/js/easing/jquery.easing.1.3.js'					, array('jquery'),'1.0', true );    		
		
		
		#  Plugin - Simpleplaceholder
		wp_enqueue_script('plugin-simpleplaceholder'		, get_template_directory_uri().'/layout/js/simpleplaceholder/jquery.simpleplaceholder.js'	, array('jquery'),'1.0', true );    		
		
		
		#  Plugin - Superfish
		wp_enqueue_script('plugin-superfish'				, get_template_directory_uri().'/layout/js/superfish/superfish.js'						, array('jquery'),'1.0', true );    		
		wp_enqueue_script('plugin-superfish-intent'			, get_template_directory_uri().'/layout/js/superfish/hoverIntent.js'					, array('jquery'),'1.0', true );    		
		
		
		#  Plugin - BX Slider
		wp_enqueue_script('plugin-bxslider'					, get_template_directory_uri().'/layout/js/bxslider/jquery.bxslider.min.js'				, array('jquery'),'1.0', true );    		
		wp_enqueue_style('plugin-bxslider-css'				, get_template_directory_uri().'/layout/js/bxslider/jquery.bxslider.css' );
		
		#  Plugin - Magnific Popup
		wp_enqueue_script('plugin-magnificpopup'			, get_template_directory_uri().'/layout/js/magnificpopup/jquery.magnific-popup.min.js'	, array('jquery'),'1.0', true );    		
		wp_enqueue_style('plugin-magnificpopup-css'			, get_template_directory_uri().'/layout/js/magnificpopup/magnific-popup.css' );
	
		#  Plugin - Waypoints
		wp_enqueue_script('plugin-waypoints'				, get_template_directory_uri().'/layout/js/waypoints/waypoints.min.js'					, array('jquery'),'1.0', true );    		
		wp_enqueue_script('plugin-waypoints-sticky'			, get_template_directory_uri().'/layout/js/waypoints/waypoints-sticky.min.js'			, array('jquery'),'1.0', true );    		
		
		
		#  Plugin - Isotope
		# wp_enqueue_script('plugin-isotope'					, get_template_directory_uri().'/layout/js/isotope/isotope.pkgd.min.js'					, array('jquery'),'1.0', true );    		
			
			
		#  Plugin - Easy Piechart
		wp_enqueue_script('plugin-piechart'					, get_template_directory_uri().'/layout/js/easypiechart/jquery.easypiechart.min.js'		, array('jquery'),'1.0', true );    		
		
		
		#  Plugin - Parallax
		wp_enqueue_script('plugin-parallax'					, get_template_directory_uri().'/layout/js/parallax/jquery.parallax.min.js'				, array('jquery'),'1.0', true );    		
					
		
		#  Plugin - Google Maps & GMap
//		wp_enqueue_script('plugin-gapi'						, '//maps.google.com/maps/api/js?sensor=false'  									, array('jquery'),'1.0', true );
//		wp_enqueue_script('plugin-gmap'						, get_template_directory_uri().'/layout/js/gmap/jquery.gmap.min.js'						, array('jquery'),'1.0', true );
		
		
		#  Plugin - Fontawesome
		wp_enqueue_style('plugin-fontawesome-css'			, get_template_directory_uri().'/layout/js/fontawesome/font-awesome.min.css');
		
		
		
		#  General style
		wp_enqueue_style('theme-style'						, get_stylesheet_directory_uri().'/style.css' );
		wp_add_inline_style('theme-style'					, ewf_admin_load_dynamicStyles() );
		
		
		#  Load Scripts & Plugins
		wp_enqueue_script('plugins-js'						, get_template_directory_uri().'/layout/js/plugins.js'									, array('jquery'),'1.0', true );    		
		wp_enqueue_script('scripts-js'						, get_template_directory_uri().'/layout/js/scripts.js'									, array('jquery'),'1.0', true );    		
	
	}

	

	

#	Load Dynamic Javascript Variables in the header
#
	add_action('admin_head'										, 'ewf_load_JSVariables', 1);
	add_action('wp_head'										, 'ewf_load_JSVariables', 1); 

	
	
#	Load Widgets
#	
	add_action( 'widgets_init'									, 'ewf_load_widgets' );
	
	function ewf_load_JSVariables(){
		echo '
		<script type="text/javascript">
			var ajaxURL = "'.site_url().'/wp-admin/admin-ajax.php";
			var siteURL = "'.site_url().'";
			var themePath = "'.get_template_directory_uri().'";
		</script>';
	}

	function ewf_load_widgets(){ 
		
		// register_widget( 'ewf_widget_contact_info' 	);
		// register_widget( 'ewf_widget_navigation' 	);
		register_widget( 'ewf_widget_latest_posts' 	);
		register_widget( 'ewf_widget_contact_forms' );
		register_widget( 'ewf_widget_social_media' 	);
		register_widget( 'ewf_widget_flickr' 		);
		register_widget( 'ewf_widget_calltoaction' 	);
		
	}
	

?>