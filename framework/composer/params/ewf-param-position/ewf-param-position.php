<?php


	if ( function_exists('add_shortcode_param'))
	{
	
		add_shortcode_param('ewf-position', 'ewf_vc_param_position_settings', get_template_directory_uri().'/admin/ewf-components/ewf-param-position/ewf-param-position.js');
		
		function ewf_vc_param_position_settings($settings, $value){
			$dependency = vc_generate_dependencies_attributes($settings);
			$param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
			$type = isset($settings['type']) ? $settings['type'] : '';
			$min = isset($settings['min']) ? $settings['min'] : '';
			$max = isset($settings['max']) ? $settings['max'] : '';

			$class = isset($settings['class']) ? $settings['class'] : '';
		
			$extra_class = array( 'top'=>null, 'top-left'=>null, 'top-right'=>null, 'bottom'=>null, 'bottom-right'=>null, 'bottom-left'=>null, 'left'=>null, 'right'=>null );
			$extra_class[$value] = ' active';
		
			$output = '<div class="ewf_param_position"></div>';
				
				$output .= '<div class="ewf-position-box-wrapper">
					<div class="ewf-position-box">
						<div class="ewf-pb-top-right'.$extra_class['top-right'].'"></div>
						<div class="ewf-pb-top-left'.$extra_class['top-left'].'"></div>
						<div class="ewf-pb-top'.$extra_class['top'].'"></div>
						<div class="ewf-pb-bottom'.$extra_class['bottom'].'"></div>
						<div class="ewf-pb-bottom-right'.$extra_class['bottom-right'].'"></div>
						<div class="ewf-pb-bottom-left'.$extra_class['bottom-left'].'"></div>
						<div class="ewf-pb-left'.$extra_class['left'].'"></div>
						<div class="ewf-pb-right'.$extra_class['right'].'"></div>
					</div> 
				</div>';
				$output .= '<input type="hidden" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="'.$value.'" />';
				
			$output .= '</div>';
			
			return $output;
		}
	}

	
	
	
?>