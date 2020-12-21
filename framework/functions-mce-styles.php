<?php



#	Attach functions to filters
#
	add_filter( 'tiny_mce_before_init'							, 'ewf_load_mce_styles' );
	add_filter( 'mce_buttons_2'									, 'my_mce_buttons_2' );


	
#	Show the style dropdown by default
#
	function my_mce_buttons_2( $buttons ) {
		array_unshift( $buttons, 'styleselect' );
		return $buttons;
	}

	

#	Attach new styles to dropdown
#
	function ewf_load_mce_styles( $settings ) {

		$style_formats = array(
			array(
				'title' => 'List - Checked',
				'selector' => 'ul',
				'classes' => 'check'
			),
			array(
				'title' => 'List - Square',
				'selector' => 'ul',
				'classes' => 'square'
			),
			array(
				'title' => 'List - Circle',
				'selector' => 'ul',
				'classes' => 'circle'
			),
			// array(
				// 'title' => 'Callout Box',
				// 'block' => 'div',
				// 'classes' => 'callout',
				// 'wrapper' => true
			// ),
			// array(
				// 'title' => 'Bold Red Text',
				// 'inline' => 'span',
				// 'styles' => array(
					// 'color' => '#f00',
					// 'fontWeight' => 'bold'
				// )
			// )
		);

		$settings['style_formats'] = json_encode( $style_formats );
		return $settings;
		
	}


?>