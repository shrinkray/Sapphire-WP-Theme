<?php

	add_shortcode( 'ewf-process-item', 'ewf_vc_process_item' );
	
	function ewf_vc_process_item( $atts, $content ) {
	   extract( shortcode_atts( array(
		  'title' => __('Sample title', EWF_SETUP_THEME_DOMAIN),
		  'number' => '1', 
		  'position' => __('Number first', EWF_SETUP_THEME_DOMAIN)
	   ), $atts ) );
	 
		$src = null;
		
		if ($position == 'Number first'){
			$src .= '<div class="process alt fixed">';
				$src .= '<h1>'.$number.'</h1>';
				$src .= '<h5><span>'.$title.'</span></h5>';
				$src .= '<div class="services-description">'.$content.'</div>';
			$src .= '</div><!-- end .process -->';
		}elseif($position == 'Title first'){
			$src .= '<div class="process fixed">';
				$src .= '<h5><span>'.$title.'</span></h5>';
				$src .= '<h1>'.$number.'</h1>';
				$src .= '<div class="services-description">'.$content.'</div>';
			$src .= '</div><!-- end .process -->';
		}
		
		return $src;
	}
		

	vc_map( array(
	   "name" => __("Single Process", EWF_SETUP_THEME_DOMAIN),
	   "base" => "ewf-process-item",
	   "class" => "",
	   "icon" => "icon-wpb-ewf-process",
	   "description" => __("Add a process title with number and details", EWF_SETUP_THEME_DOMAIN),  
	   "category" => __('Typography', EWF_SETUP_THEME_DOMAIN),
	   "params" => array(
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "title",
			 "value" => __("Process title", EWF_SETUP_THEME_DOMAIN),
			 "description" => __("Specify the title that will fit in the hexagon.", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Number", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "number",
			 "value" => 1,
			 "description" => __("Specify the number positioned in front or after the hexagon.", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Position", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "position",
			 "value" => array(__('Number first', EWF_SETUP_THEME_DOMAIN), __('Title first', EWF_SETUP_THEME_DOMAIN)),
			 "description" => __("Specify the arrangement of number and hexagon", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textarea_html",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Process description", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "content",
			 "value" => __("I am test text block. Click edit button to change this text.", EWF_SETUP_THEME_DOMAIN), 
		  )
	   )
	));

?>