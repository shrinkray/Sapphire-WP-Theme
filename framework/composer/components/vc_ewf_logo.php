<?php

	add_shortcode( 'ewf-client-logo', 'ewf_vc_client_logo' );
	
	
	function ewf_vc_client_logo( $atts, $content ) {
	   extract( shortcode_atts( array(
		  'image_id' 		=> 0,
		  'image_url' 		=> null,
		  'link' 			=> '#',
	   ), $atts ) );
	   
	   $link = vc_build_link($link); 
	   
		if ($image_id){
			$image_url = wp_get_attachment_image_src($image_id, 'large'); 
			$image_url = $image_url[0]; 
		}
	   
		ob_start();
		
		if ($link['url']){
			echo '<a href="'.$link['url'].'" class="client logo" title="'.$link['title'].'" ';
				if (trim($link['target'])){
					echo ' target="'.trim($link['target']).'"';
				}
			echo ' >';
		}
		
			if ($image_id){
				echo '<img src="'.$image_url.'" alt="'.$image_id.'" />';
			}
		
		if ($link['url']){
			echo '</a>';
		}
		
		return ob_get_clean();
	}

	
	vc_map( array(
	   "name" => __("Client logo", EWF_SETUP_THEME_DOMAIN),
	   "base" => "ewf-client-logo",
	   "class" => "",
	   "category" => __('Typography', EWF_SETUP_THEME_DOMAIN),
	   "icon" => "icon-wpb-ewf-client-logo",
	   // "description" => __("Image and link", EWF_SETUP_THEME_DOMAIN),  
	   "params" => array(
		  array(
			 "type" => "attach_image",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Image", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "image_id",
			 "description" => __("Add the logo image", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "vc_link",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Link", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "link",
			 "value" => '#',
			 "description" => __("Specify an optional link pointing to an URL", EWF_SETUP_THEME_DOMAIN) 
		  )
	   )
	));


?>