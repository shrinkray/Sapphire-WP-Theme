<?php

	add_shortcode( 'ewf-milestone', 'ewf_vc_milestone' );
	
	
	function ewf_vc_milestone( $atts, $content ) {
	   extract( shortcode_atts( array(
		  'title' => __('Title', EWF_SETUP_THEME_DOMAIN),
		  'number' => '1',
		  'speed' => '2000'
	   ), $atts ) );
	 
		$number = intval($number);
	 
		ob_start();
		
		echo '<div class="milestone fixed">';
			echo '<div class="milestone-content">';
				echo '<span data-speed="'.$speed.'" data-stop="'.$number.'" class="milestone-value"></span>';
				echo '<div class="milestone-description">'.$title.'</div>';
			echo '</div>';
		echo '</div>';
		
		return ob_get_clean();
	}

	
	vc_map( array(
	   "name" => __("Milestone", EWF_SETUP_THEME_DOMAIN),
	   "base" => "ewf-milestone",
	   "class" => "",
	   "icon" => "icon-wpb-ewf-milestone",
	   "description" => __("Animated count from 0 to specified number", EWF_SETUP_THEME_DOMAIN),  
	   "category" => __('Typography', EWF_SETUP_THEME_DOMAIN),
	   "params" => array(
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "title",
			 "value" => __("Title", EWF_SETUP_THEME_DOMAIN),
			 "description" => __("The milestone title", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Number", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "number",
			 "value" => 1,
			 "description" => __("The final value will animate to, from 0 to the number provided by you", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Speed", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "speed",
			 "value" => 2000,
			 "description" => __("Specify the animation speed", EWF_SETUP_THEME_DOMAIN)
		  )
	   )
	));


?>