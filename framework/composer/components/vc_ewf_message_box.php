<?php

	add_shortcode( 'ewf-message', 'ewf_vc_message' );
	
	$_ewf_alert_type = array(
		'info' => array(
			'title' => __('Info', EWF_SETUP_THEME_DOMAIN),
			'icon' => 'fa-info-circle',
			'class' => 'info'
		),
		'success' => array(
			'title' => __('Success', EWF_SETUP_THEME_DOMAIN),
			'icon' => 'fa-check-circle-o',
			'class' => 'success'
		),
		'warning' => array(
			'title' => __('Warning', EWF_SETUP_THEME_DOMAIN),
			'icon' => 'fa-exclamation-triangle',
			'class' => 'warning'
		),
		'error' => array(
			'title' => __('Error', EWF_SETUP_THEME_DOMAIN),
			'icon' => 'fa-times-circle',
			'class' => 'error'
		),
	);
	
	
	function ewf_vc_message( $atts, $content ) {
		global $_ewf_alert_type;
		
		extract( shortcode_atts( array(
			'height' => 10,
			'type' => 'error',
		), $atts ) );
	 		
	
		return '<div data-type="'.$type.'" class="alert '.$_ewf_alert_type[$type]['class'].'"><i class="fa '.$_ewf_alert_type[$type]['icon'].'"></i> '.$content.'</div>';

	}

	
	vc_map( array(
	   "name" => __("Message box", EWF_SETUP_THEME_DOMAIN),
	   "base" => "ewf-message",
	   "class" => "",
	   "icon" => "icon-wpb-ewf-message",
	   "description" => __("Use to display notices, warnings, alerts", EWF_SETUP_THEME_DOMAIN),  
	   "category" => __('Typography', EWF_SETUP_THEME_DOMAIN),
	   "params" => array(
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Message type", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "type",
			 "value" => array($_ewf_alert_type['info']['title'] => $_ewf_alert_type['info']['class'], $_ewf_alert_type['error']['title'] => $_ewf_alert_type['error']['class'], $_ewf_alert_type['warning']['title'] => $_ewf_alert_type['warning']['class'], $_ewf_alert_type['success']['title'] => $_ewf_alert_type['success']['class'] ),
			 "description" => __("Specify", EWF_SETUP_THEME_DOMAIN)
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Message", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "content",
			 "value" => null,
			 "description" => __("Specify the content of the message", EWF_SETUP_THEME_DOMAIN)
		  ),
	   )
	));

?>