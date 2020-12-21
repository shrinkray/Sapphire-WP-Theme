<?php

	add_shortcode( 'ewf-button', 'ewf_vc_button' );
	
	function ewf_vc_button( $atts, $content ) {
		extract( shortcode_atts( array(
			'title' => __("Sample title", EWF_SETUP_THEME_DOMAIN),
			'url' => '#',
			'icon' => null,
			'style' => 'btn',
			'color' => '#08AB89',
			'color_text' => '#ffffff',
			'size' => 'small',
			'link' => null
		), $atts ) );
		
		$link = vc_build_link($link); 
		$class_extra = null;
		$attr_target = null;
		$custom_color = null;
		
		if ($link['target'] != null){
			$attr_target .= ' target="_black" ';		
		}
		
		switch($style){
			
			case 'btn-black':
				$class_extra .= ' '.$style;
				break;
		
			case 'btn-green-dark':
				$class_extra .= ' '.$style;
				break;		
				
			case 'btn-green-light':
				$class_extra .= ' '.$style;
				break;
				
				
			case 'btn-custom':
				$class_extra .= ' '.$style;
				$custom_color = ' style="background-color:'.$color.';color:'.$color_text.'" ';
				break;
			
			default:
				$class_extra .= null;
				break;
		}

		if ($size == 'large') { $class_extra .= ' btn-large'; }
		
		
		$src = '<a href="'.$link['url'].'"class="btn '.$class_extra.'" '.$custom_color.$attr_target.'>'.$link['title'];
		if ($icon){	$src .= '<i class="'.$icon.'"></i>'; }
		$src .=  '</a>';
		
		
		return $src;
	}

	
	vc_map( array(
	   "name" => __("Button", EWF_SETUP_THEME_DOMAIN),
	   "base" => "ewf-button",
	   "class" => "",
	   "icon" => "icon-wpb-ewf-button",
	   "description" => __("Customizable button with text and icon", EWF_SETUP_THEME_DOMAIN),  
	   "category" => __('Typography', EWF_SETUP_THEME_DOMAIN),
	   "params" => array(
	   
		  array(
			 "type" => "vc_link",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Link title & URL", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "link",
			 "value" => null,
			 "description" => __("Specify the link pointing to another page", EWF_SETUP_THEME_DOMAIN) 
		  ),
		  array(
			 "type" => "ewf-icon",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Select Icon", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "icon",
			 "value" => null,
			 "description" => __("Select the icon you want", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Button Color", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "style",
			 "value" => array(__('Default', EWF_SETUP_THEME_DOMAIN) => 'btn', __('Black', EWF_SETUP_THEME_DOMAIN) => 'btn-black', __('Green', EWF_SETUP_THEME_DOMAIN) => 'btn-green-dark', __('Light Green', EWF_SETUP_THEME_DOMAIN) => 'btn-green-light', __('Custom color', EWF_SETUP_THEME_DOMAIN) => 'btn-custom'),
			 "description" => __("Specify the type size of the button", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "colorpicker",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Button Background Color", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "color",
			 "value" => '#08AB89',
			 "description" => __("Select the color of the text on button", EWF_SETUP_THEME_DOMAIN),
			 "dependency" => Array("element" => "style","value" => array("btn-custom"))
		  ),
		  array(
			 "type" => "colorpicker",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Button Text Color", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "color_text",
			 "value" => '#444444',
			 "description" => __("Select the color of the button", EWF_SETUP_THEME_DOMAIN),
			 "dependency" => Array("element" => "style","value" => array("btn-custom"))
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Button Size", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "size",
			 "value" => array(__('Small', EWF_SETUP_THEME_DOMAIN) => 'small', __('Large', EWF_SETUP_THEME_DOMAIN) => 'large'),
			 "description" => __("Specify the type size of the button", EWF_SETUP_THEME_DOMAIN)
		  )
	   )
	));

?>