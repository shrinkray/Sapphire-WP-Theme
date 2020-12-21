<?php

	add_shortcode( 'ewf-iconbox', 'ewf_vc_iconbox' );
	
	
	function ewf_vc_iconbox( $atts, $content ) {
		extract( shortcode_atts( array(
			'title' => __('Title', EWF_SETUP_THEME_DOMAIN),
			'style' => 'icon-box-01',
			'link_style' => 'button', 
			'link' => null, 
			'align' => 'center', 
			'icon' => null
		), $atts ) );
	
			
		ob_start();
		

			$link = vc_build_link($link); 
		
			if ($link['title'] != null){
				$class_link = null;	
				
				if ($link_style == 'button'){
					$class_link .= 'class="btn" ';
				}
				
				if ($link['target'] != null){
					$class_link .= 'target="_black" ';		
				}
				
				$content .= '<p class="last text-'.$align.'"><a '.$class_link.'href="'.$link['url'].'">'.$link['title'].'</a></p>';
			}
		
		
			switch($style){
			
				case 'icon-box-01':
					echo '
					<div class="icon-box-1">
						<i class="'.$icon.'"></i>
						<div class="icon-box-content">
							<h3>
								<a href="#">'.$title.'</a>
							</h3>
							
							'.$content.'
						</div><!-- end .icon-box-content -->
					</div><!-- end .icon-box-1 -->';
					break;
					
			
				case 'icon-box-02':
					echo '
					<div class="icon-box-2">
						<i class="'.$icon.'"></i>
						<div class="icon-box-content">
							<h3 class="text-uppercase text-center">
								<a href="#">'.$title.'</a>
							</h3>
							
							<p class="text-center">'.$content.'</p>
						</div><!-- end .icon-box-content -->
					</div><!-- end .icon-box-2 -->';
					break;
					
			
				case 'icon-box-03':
					echo '
					<div class="icon-box-3">
						<i class="'.$icon.'"></i>
							<h3 class="text-uppercase">
								<strong><a href="#">'.$title.'</a></strong>
							</h3>
							
							<br class="clear">
						
							<p>'.$content.'</p>
						</div><!-- end .icon-box-3 -->';
					break;
				
				
				case 'icon-box-04':
					echo '
					<div class="icon-box-2">
						<span><i class="'.$icon.'"></i></span>
						<div class="icon-box-content">
							<h3 class="text-uppercase text-center">
								<a href="#">'.$title.'</a>
							</h3>
							
							<p class="text-center">'.$content.'</p>
						</div><!-- end .icon-box-content -->
					</div><!-- end .icon-box-4 -->';
					break;
						
				
				
				default:
					echo '
					<div class="icon-box-1">
						<i class="'.$icon.'"></i>
						<div class="icon-box-content">
							<h3>
								<a href="#">'.$title.'</a>
							</h3>
							
							'.$content.'
						</div><!-- end .icon-box-content -->
					</div><!-- end .icon-box-1 -->';
					break;

			}
			
			
		return ob_get_clean();
	}

	
	vc_map( array(
	   "name" => __("Icon Box", EWF_SETUP_THEME_DOMAIN),
	   "base" => "ewf-iconbox",
	   "class" => "",
	   "category" => __('Typography', EWF_SETUP_THEME_DOMAIN),
	   "icon" => "icon-wpb-ewf-iconbox",
	   "description" => __("Add an icon box, with icon and description", EWF_SETUP_THEME_DOMAIN ),  
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
			"type" => "dropdown",
			"holder" => "div",
			"class" => "",
			"heading" => __("Style", EWF_SETUP_THEME_DOMAIN),
			"param_name" => "style",
			"value" => array( 
				__('Style 1', EWF_SETUP_THEME_DOMAIN) => 'icon-box-01', 
				__('Style 2', EWF_SETUP_THEME_DOMAIN) => 'icon-box-02', 
				__('Style 3', EWF_SETUP_THEME_DOMAIN) => 'icon-box-03', 
				__('Style 4', EWF_SETUP_THEME_DOMAIN) => 'icon-box-04'
			),
			"description" => __("There are 4 styles, the diferences consists on iconsize and placement inside of iconbox", EWF_SETUP_THEME_DOMAIN)
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
			 "type" => "vc_link",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Read more link", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "link",
			 "value" => '#',
			 "description" => __("Specify an optional link to another page", EWF_SETUP_THEME_DOMAIN) 
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Read more link placement", EWF_SETUP_THEME_DOMAIN),
			 "param_name" => "align",
			 "value" => array(__('Left', EWF_SETUP_THEME_DOMAIN) => 'left', __('Center', EWF_SETUP_THEME_DOMAIN) => 'center', __('Right', EWF_SETUP_THEME_DOMAIN) => 'right'),
			 "description" => __("How the read more link should be aligned inside of iconbox", EWF_SETUP_THEME_DOMAIN),
			 // "dependency" => Array("element" => "link","value" => array("url"))
		  )
		  
		  ))
		);


?>