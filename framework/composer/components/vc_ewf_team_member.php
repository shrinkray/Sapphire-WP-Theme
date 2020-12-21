<?php

	add_shortcode( 'ewf-team-member', 'ewf_vc_team_member' );
	
	
	function ewf_vc_team_member( $atts, $content ) {
	   extract( shortcode_atts( array(
		  'name' 			=> 'John Doe',
		  'job_title' 		=> __('Sample job title', EWF_SETUP_THEME_DOMAIN),
		  'image_id' 		=> 0,
		  'image_url' 		=> '#',
		  'link' 			=> '#',
		  'url_google' 		=> null,
		  'url_facebook' 	=> null,
		  'url_twitter' 	=> null,
		  'url_pinterest' 	=> null,
		  'url_youtube' 	=> null,
		  'url_dribbble' 	=> null,
		  'url_tumblr' 		=> null,
		  'url_instagram' 	=> null
	   ), $atts ) );
	   
	   $link = vc_build_link($link); 
	   
		if ($image_id){
			$image_url = wp_get_attachment_image_src($image_id, 'large'); 
			$image_url = $image_url[0]; 
		}
	   
		ob_start();
		
		echo '<div class="team-member">';
				
				if ($image_id){
					echo '<img src="'.$image_url.'" alt="'.$image_id.'" />';
				}
				
				echo '<br class="clear">';
				
            
				if ($name){
					echo '<h3>'.$name.'</h3>';
				}
				
				if ($job_title){
					echo '<p>'.$job_title.'</p>';
				}
				
				if ($content){
					echo '<p>'.$content.'</p>';
				}
				
				
				echo '<div class="social-media">';
				
					if ($url_twitter){
						echo ' <a class="twitter-icon social-icon" href="'.$url_twitter.'">';
							echo '<i class="fa fa-twitter"></i>';
						echo '</a> ';
					}
					
					if ($url_facebook){
						echo '<a class="facebook-icon social-icon" href="'.$url_facebook.'">';
						   echo '<i class="fa fa-facebook"></i>';
						echo '</a> ';
					}
					
					if ($url_google){
						echo '<a class="google-plus-icon social-icon" href="'.$url_google.'">';
							echo '<i class="fa fa-google-plus"></i>';
						echo '</a>';
					}
					
					if ($url_pinterest){
						echo '<a class="pinterest-icon social-icon" href="'.$url_pinterest.'">';
							echo '<i class="fa fa-pinterest"></i>';
						echo '</a>';
					}
					
					if ($url_youtube){
						echo '<a class="youtube-icon social-icon" href="'.$url_youtube.'">';
							echo '<i class="fa fa-youtube"></i>';
						echo '</a>';
					}
					
					if ($url_dribbble){
						echo '<a class="dribbble-icon social-icon" href="'.$url_dribbble.'">';
							echo '<i class="fa fa-dribbble"></i>';
						echo '</a>';
					}
					
					if ($url_tumblr){
						echo '<a class="tumblr-icon social-icon" href="'.$url_tumblr.'">';
							echo '<i class="fa fa-tumblr"></i>';
						echo '</a>';
					}
					
					if ($url_instagram){
						echo '<a class="instagram-icon social-icon" href="'.$url_instagram.'">';
							echo '<i class="fa fa-instagram"></i>';
						echo '</a>';
					}
					
				echo '</div><!-- end .social-icon -->';
            
        echo '</div><!-- end .team-member -->';
		
		return ob_get_clean();
	}

	
	vc_map( array(
	   "name" => __("Team Member", EWF_SETUP_THEME_DOMAIN),
	   "base" => "ewf-team-member",
	   "class" => "",
	   "category" => __('Typography', EWF_SETUP_THEME_DOMAIN),
	   "icon" => "icon-wpb-ewf-team-member",
	   "description" => __("Name, image and description", EWF_SETUP_THEME_DOMAIN),  
	   "params" => array(
		  array(
			 "type" => "attach_image",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Image", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "image_id",
			 "description" => __("Add the image of the team member", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Name", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "name",
			 "value" => __('Sample Name', EWF_SETUP_THEME_DOMAIN),
			 "description" => __("Specify the name of the member", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __('Job Title', EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "job_title",
			 "value" => __('Job Title', EWF_SETUP_THEME_DOMAIN),
			 // "description" => __("Specify the text of the testimonial", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => "Google Plus",
			 "param_name" => "url_google",
			 "value" => null,
			 "description" => __("Add an optional link to Google Plus profile page, leave blank if not available", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => "Facebook",
			 "param_name" => "url_facebook",
			 "value" => null,
			 "description" => __("Add an optional link to Facebook profile page, leave blank if not available", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => "Twitter",
			 "param_name" => "url_twitter",
			 "value" => null,
			 "description" => __("Add an optional link to Twitter profile page, leave blank if not available", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => "Pinterest",
			 "param_name" => "url_pinterest",
			 "value" => null,
			 "description" => __("Add an optional link to Pinterest profile page, leave blank if not available", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => "YouTube",
			 "param_name" => "url_youtube",
			 "value" => null,
			 "description" => __("Add an optional link to YouTube profile page, leave blank if not available", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => "Dribbble",
			 "param_name" => "url_dribbble",
			 "value" => null,
			 "description" => __("Add an optional link to Dribbble profile page, leave blank if not available", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => "Tumblr",
			 "param_name" => "url_tumblr",
			 "value" => null,
			 "description" => __("Add an optional link to Tumblr profile page, leave blank if not available", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => "Instagram",
			 "param_name" => "url_instagram",
			 "value" => null,
			 "description" => __("Add an optional link to Instagram profile page, leave blank if not available", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textarea_html",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Member details", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "content",
			 "value" => "<p>".__("I am test text block. Click edit button to change this text.", EWF_SETUP_THEME_DOMAIN)."</p>",
			 "description" => __("Add details about the member", EWF_SETUP_THEME_DOMAIN) 
		  )
		  // array(
			 // "type" => "vc_link",
			 // "holder" => "div",
			 // "class" => "",
			 // "heading" => __("Read more link", EWF_SETUP_THEME_DOMAIN),
			 // "param_name" => "link",
			 // "value" => '#',
			 // "description" => __("Specify the link pointing to member", EWF_SETUP_THEME_DOMAIN) 
		  // )
	   )
	));


?>