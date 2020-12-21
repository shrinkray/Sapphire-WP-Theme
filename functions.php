<?php


	define( 'EWF_SETUP_PAGE'			, 'functions.php');				# page containing setup
	define( 'EWF_SETUP_THEME_DOMAIN'	, 'sapphire-wp');				# translation domain
	define( 'EWF_SETUP_THNAME'			, 'bitpub');					# theme options short name
	define( 'EWF_SETUP_TITLE'			, 'Sapphire Setup');			# wordpress menu title
	define( 'EWF_SETUP_THEME_NAME'		, 'Sapphire Wordpress');		# wordpress menu title
	define( 'EWF_SETUP_THEME_VERSION'	, '1.0');						# wordpress menu title
	
	include_once ('framework/framework-setup.php');
	


	function baw_hack_wp_title_for_home( $title ): string
	{
	  if( empty( $title ) && ( is_home() || is_front_page() ) ) {
	    return __( 'Home', 'theme_domain' ) . ' - ' . get_bloginfo( 'description' );
	  }
	  return $title;
	}

	add_filter( 'wp_title', 'baw_hack_wp_title_for_home' );


