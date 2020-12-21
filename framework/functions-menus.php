<?php

	#	Attach menu action
	#
	add_action('ewf-menu-top', 'ewf_action_menuTopInstall');
	
	#	To use it anyware on template add 
	#	do_action('ewf-menu-top');


	
	
	#	Register template menus
	#
	if ( function_exists( 'register_nav_menus' ) ) {
		register_nav_menus(
			array(
			  'top-menu' => __('Top Menu',EWF_SETUP_THEME_DOMAIN),
			)
		);
	}


	
	#	Attach menu action
	#
	function ewf_action_menuTopInstall(){
		$ewf_menu_registred = has_nav_menu('top-menu');
		#	$ewf_menu_walker = new ewf_topmenu_walker;
		
		if($ewf_menu_registred){					
			wp_nav_menu( array( 
			'theme_location' => 'top-menu',
			'container_class' => null,
			'container' => null,
			'menu_id' => 'menu',
			'class' => null,
			'menu_class' => 'sf-menu' ));  
		}else{
			echo '<p class="error-no-menu">'.__('Menu not selected - Please review documentation!',EWF_SETUP_THEME_DOMAIN).'</p>';
		}
	}
		
		
		
	
	/* Menu Active Class Fix for Custom Post Types
	http://wordpress.org/support/topic/why-does-blog-become-current_page_parent-with-custom-post-type
	function remove_parent_classes($class)
	{
	  // check for current page classes, return false if they exist.
	  return ($class == 'active') ? FALSE : TRUE;
	}
	 
	function add_class_to_wp_nav_menu($classes)
	{
		 switch (get_post_type())
		 {
			case 'EWF_PROJECTS_SLUG':
				// we're viewing a custom post type, so remove the 'current_page_xxx and current-menu-item' from all menu items.
				$classes = array_filter($classes, "remove_parent_classes");
	 
				// add the current page class to a specific menu item (replace ###).
				if (in_array('menu-filme', $classes))
				{
				   $classes[] = 'active';
				}
				break;
		 }
		return $classes;
	}
	add_filter('nav_menu_css_class', 'add_class_to_wp_nav_menu');
	*/
	
	
	
	/*
	*/
	function is_blog() {
		global $post;
		$posttype = get_post_type( $post );
		return ( ( $posttype == 'post' ) && ( is_home() || is_single() || is_archive() || is_category() || is_tag() || is_author() ) ) ? true : false;
	}

	function fix_blog_link_on_cpt( $classes, $item, $args ) {
		if( !is_blog() ) {
			$blog_page_id = intval( get_option('page_for_posts') );
			if( $blog_page_id != 0 && $item->object_id == $blog_page_id )
				unset($classes[array_search('current_page_parent', $classes)]);
		}
		return $classes;
	}
	add_filter( 'nav_menu_css_class', 'fix_blog_link_on_cpt', 10, 3 );
	
	
	/*
	class ewf_topmenu_walker extends Walker_Nav_Menu {
	
		function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			global $wp_query;
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			$current_url = strtolower($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			$item_url = str_replace(array('http://', 'https://'),'',strtolower($item->url));
			

			if ($item_url==$current_url){ 
				$class_selection = 'class="current"'; 
			}else{ 
				$class_selection = ''; 
			}
			
			$output .= $indent . '<li id="menu-item-'. $item->ID . '" '.$class_selection.'>';
		
			$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
			$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
			$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
			$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
			
			$item_output = $args->before;
			$item_output .= '<a'. $attributes .'>';
			$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ). $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;

			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}
	}
	*/
	
	
?>