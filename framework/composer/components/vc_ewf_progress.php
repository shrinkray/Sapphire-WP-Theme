<?php

	add_shortcode( 'ewf-progress', 'ewf_vc_progress' );
	
	
	function ewf_vc_progress( $atts, $content ) {
	   extract( shortcode_atts( array(
		  'title' => __('Sample progress bar', EWF_SETUP_THEME_DOMAIN),
		  'value' => '90',
		  'bar' => '#0AAB8A',
		  'background' => '#EEE5DD'
		  
	   ), $atts ) );
	 
		$value = intval($value);
	 
		ob_start();
		

		echo '<div class="progress-bar-description">'.$title.'<span>'.$value.'%</span></div>';

		echo '<div class="progress-bar">'; 
			echo '<span class="progress-bar-outer" data-width="'.$value.'" style="background-color:'.$bar.'">';
				echo '<span class="progress-bar-inner"></span>';
			echo '</span>';
		echo '</div><!-- end .progress-bar -->';
		
		return ob_get_clean();
	}

	
	vc_map( array(
	   "name" => __("Progress Bar", EWF_SETUP_THEME_DOMAIN),
	   "base" => "ewf-progress",
	   "icon" => "icon-wpb-ewf-progress",
	   // "description" => __("Add atitle and a percentage loaded", EWF_SETUP_THEME_DOMAIN), 
	   "class" => "",
	   "category" => __('Typography', EWF_SETUP_THEME_DOMAIN),
	   "params" => array(
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "title",
			 "value" => __("Title", EWF_SETUP_THEME_DOMAIN),
			 "description" => __("The title of the progress bar", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Value", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "value",
			 "value" => 90,
			 "description" => __("Specify a value between 1 and 100, it represents the loaded percentage", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "colorpicker",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Bar Color", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "bar",
			 "value" => '#0AAB8A',
			 "description" => __("Select the color of the bar", EWF_SETUP_THEME_DOMAIN)
		  )
	   )
	));


?>