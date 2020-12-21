<?php


	if (function_exists('register_sidebar')){
		
		
		#	Register sidebars
		#
		
		register_sidebar(array('id' => 'header-left'	 , 'name' => __('Header widget area left'	, EWF_SETUP_THEME_DOMAIN), 'description'   => __('In the header left column',EWF_SETUP_THEME_DOMAIN), 'before_title'  => '<h3 class="widget-title"><span>','after_title'   => '</span></h3>', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>' ));
		register_sidebar(array('id' => 'header-right'	 , 'name' => __('Header widget area right'	, EWF_SETUP_THEME_DOMAIN), 'description'   => __('In the header right column',EWF_SETUP_THEME_DOMAIN), 'before_title'  => '<h3 class="widget-title"><span>','after_title'   => '</span></h3>', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>' ));
		
		register_sidebar(array('id' => 'footer-widget-top', 'name' => __('Footer top widget area' ,EWF_SETUP_THEME_DOMAIN), 'description'   => __('The section located above footer',EWF_SETUP_THEME_DOMAIN), 'before_title'  => '<h3 class="widget-title"><span>','after_title'   => '</span></h3>', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>' ));
		
		register_sidebar(array('id' => 'footer-widgets-1', 'name' => __('Footer widget area 1',EWF_SETUP_THEME_DOMAIN), 'description'   => __('In the footer the left column',EWF_SETUP_THEME_DOMAIN), 'before_title'  => '<h3 class="widget-title"><span>','after_title'   => '</span></h3>', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>' ));
		register_sidebar(array('id' => 'footer-widgets-2', 'name' => __('Footer widget area 2',EWF_SETUP_THEME_DOMAIN), 'description'   => __('In the footer the left center column',EWF_SETUP_THEME_DOMAIN), 'before_title'  => '<h3 class="widget-title"><span>','after_title'   => '</span></h3>', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>' ));
		register_sidebar(array('id' => 'footer-widgets-3', 'name' => __('Footer widget area 3',EWF_SETUP_THEME_DOMAIN), 'description'   => __('In the footer the right center column',EWF_SETUP_THEME_DOMAIN), 'before_title'  => '<h3 class="widget-title"><span>','after_title'   => '</span></h3>', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>' ));
		register_sidebar(array('id' => 'footer-widgets-4', 'name' => __('Footer widget area 4',EWF_SETUP_THEME_DOMAIN), 'description'   => __('In the footer the right column',EWF_SETUP_THEME_DOMAIN), 'before_title'  => '<h3 class="widget-title"><span>','after_title'   => '</span></h3>', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>' ));
		
		
		register_sidebar(array('id' => 'footer-sub-widgets-1', 'name' => __('Footer bottom widget area left',EWF_SETUP_THEME_DOMAIN), 'description'   => __('The section located below footer on the left',EWF_SETUP_THEME_DOMAIN), 'before_title'  => '<h3 class="widget-title"><span>','after_title'   => '</span></h3>', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>' ));
		register_sidebar(array('id' => 'footer-sub-widgets-2', 'name' => __('Footer bottom widget area right',EWF_SETUP_THEME_DOMAIN), 'description'   => __('The section located below footer on the right',EWF_SETUP_THEME_DOMAIN), 'before_title'  => '<h3 class="widget-title"><span>','after_title'   => '</span></h3>', 'before_widget' => '<div id="%1$s" class="widget %2$s">', 'after_widget'  => '</div>' ));
	}

	
?>