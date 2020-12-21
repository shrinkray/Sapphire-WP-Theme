<?php

	add_shortcode( 'ewf-service', 'ewf_vc_service' );
	
	
	function ewf_vc_service( $atts, $content ) {
		extract( shortcode_atts( array(
			'title' => __('Title', EWF_SETUP_THEME_DOMAIN),
			'url' => '#',
			'image_id' => 0
		), $atts ) );

		if ($image_id){
			$image_url = wp_get_attachment_image_src($image_id, 'large'); 
			$image_url = $image_url[0]; 
		}

		ob_start();
		
       echo '<div class="service-overview">';
			if ($image_id){
				echo '<img src="'.$image_url.'" alt="'.$image_id.'" />';
			}
			
            echo '<div class="service-overview-overlay">';
                echo '<h3><a href="'.$url.'">'.$title.'</a></h3>';
            echo '</div><!-- end .service-overlay -->';
        echo '</div><!-- end .service-overview -->';
		
		return ob_get_clean();
	}

	
	vc_map( array(
	   "name" => __("Service", EWF_SETUP_THEME_DOMAIN),
	   "base" => "ewf-service",
	   "class" => "",
	   "icon" => "icon-wpb-ewf-service",
	   "description" => __("Use an image and title to point to a service", EWF_SETUP_THEME_DOMAIN),  
	   "category" => __('Typography', EWF_SETUP_THEME_DOMAIN),
	   "params" => array(
		  array(
			 "type" => "attach_image",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Image", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "image_id",
			 // "description" => __("Add an image to the right side of the testimonial", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "title",
			 "value" => __("Title", EWF_SETUP_THEME_DOMAIN),
			 "description" => __("Title of the service", EWF_SETUP_THEME_DOMAIN)
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