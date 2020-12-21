<?php


	// add_action( 'customize_register'							, 'ewf_load_customizer' );
	// add_action( 'wp_head'										, 'ewf_load_customizer_css');
	// add_action( 'customize_preview_init'						, 'ewf_load_customizer_js');
	
	

	function ewf_load_customizer( $wp_customize ) {
		$colors = array();
		
		
		$colors[] = array(
			'slug'=>'ewf_color_header', 
			'default' => '#000000',
			'label' => __('Header background', EWF_SETUP_THEME_DOMAIN)
		);	
		
		
		$colors[] = array(
			'slug'=>'ewf_color_footer', 
			'default' => '#88C34B',
			'label' => __('Footer background', EWF_SETUP_THEME_DOMAIN)
		);		
				
		$colors[] = array(
			'slug'=>'ewf_color_footerCredits', 
			'default' => '#333',
			'label' => __('Credits bar background', EWF_SETUP_THEME_DOMAIN)
		);
		

		
		foreach( $colors as $color ) {
			
			$wp_customize->add_setting($color['slug'], array(
					'default' 		=> $color['default'],
					'type' 			=> 'option', 
					'capability' 	=> 'edit_theme_options'
				)
			);
			
			$wp_customize->add_control(
				new WP_Customize_Color_Control( $wp_customize, $color['slug'], array(
					'label' 		=> $color['label'], 
					'section' 		=> 'colors',
					'settings' 		=> $color['slug']
					)
				)
			);
			
			
		}
		
		
		
	}
	
	
	function ewf_load_customizer_js(){
	
		wp_enqueue_script('ewf-customizer'						, get_template_directory_uri().'/framework/admin/includes/options-customizer.js'	, array('jquery', 'customize-preview'),'1.0', true );
	
	}
	
	
	
	function ewf_load_customizer_css(){

		$ewf_color_header = ewf_hex2rgb(get_option('ewf_color_header'));
		$ewf_color_footer = get_option('ewf_color_footer');
		$ewf_color_footerCredits = get_option('ewf_color_footerCredits');
			
		?>
		
		<style id="ewf-customizer" >
			
			#header { background-color: rgba( <?php  echo $ewf_color_header[0].','.$ewf_color_header[1].','.$ewf_color_header[2]; ?> , 0.5); } 
			#footer { background-color: <?php echo $ewf_color_footer; ?>; }
			
		</style>

		<?php
		
	}

	
	
	function ewf_hex2rgb($hex) {
	   $hex = str_replace("#", "", $hex);

	   if(strlen($hex) == 3) {
		  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
		  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
		  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	   } else {
		  $r = hexdec(substr($hex,0,2));
		  $g = hexdec(substr($hex,2,2));
		  $b = hexdec(substr($hex,4,2));
	   }
	   
	   $rgb = array($r, $g, $b);
	   
	   return $rgb;
	}
	


?>