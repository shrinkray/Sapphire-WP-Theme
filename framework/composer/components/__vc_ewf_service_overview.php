<?php

	add_shortcode( 'ewf-service-overview', 'ewf_vc_service_overview' );
	
	
	function ewf_vc_service_overview( $atts, $content ) {
		extract( shortcode_atts( array(
			'title' => __('Title', EWF_SETUP_THEME_DOMAIN),
			'link_title' => __('read more', EWF_SETUP_THEME_DOMAIN),
			'url' => '#',
			'icon' => null
		), $atts ) );

		ob_start();
		
			echo '<div class="icon-box-2">';
				
				if ($icon){
					echo '<div class="icon">';
							echo '<i class="fa '.$icon.'"></i>';
					echo '</div>';
				}
				
				echo '<div class="icon-box-content">';
					echo '<h4><strong><a href="#">'.$title.'</a></strong></h4>';
					echo '<p>'.$content.'</p>';
					echo '<a href="'.$url.'">'.$link_title.' <i class="fa fa-angle-right"></i></a>';
				echo '</div><!-- end .icon-box-content -->';

			echo '</div>';
		
		return ob_get_clean();
	}

	
	vc_map( array(
	   "name" => __("Service Overview", EWF_SETUP_THEME_DOMAIN),
	   "base" => "ewf-service-overview",
	   "class" => "",
	   "category" => __('Typography', EWF_SETUP_THEME_DOMAIN),
	   "icon" => "icon-wpb-ewf-service-overview",
	   "description" => __("Add a service title, with icon and description", EWF_SETUP_THEME_DOMAIN ),  
	   "params" => array(
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "title",
			 "value" => __("Title", EWF_SETUP_THEME_DOMAIN),
			 "description" => __("The service title", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "ewf-icon",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Select Icon", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "icon",
			 "value" => null,
			 "description" => __("Select the icon you want to have at the top of the section", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textarea_html",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Content", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "content",
			 "value" => __("I am test text block. Click edit button to change this text.", EWF_SETUP_THEME_DOMAIN),
			 "description" => __("Add description text for the service", EWF_SETUP_THEME_DOMAIN) 
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Link title", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "link_title",
			 "value" => __('read more', EWF_SETUP_THEME_DOMAIN),
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => "URL",
			 "param_name" => "url",
			 "value" => '#',
			 "description" => __("Add the link that points to the service", EWF_SETUP_THEME_DOMAIN)
		  )
	   )
	));


?>