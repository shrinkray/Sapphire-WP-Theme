<?php 



	class ewf_widget_calltoaction extends WP_Widget {

		function ewf_widget_calltoaction() {
			$widget_ops = array( 'classname' => 'ewf_widget_calltoaction', 'description' => __('A widget that displays a call to action section', EWF_SETUP_THEME_DOMAIN) );
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'ewf_widget_calltoaction' );
			parent::__construct( 'ewf_widget_calltoaction', __('EWF - Call to action', EWF_SETUP_THEME_DOMAIN), $widget_ops, $control_ops );
		}
		
		/**
         * Added assignments for $before_widget and $after_widget
         * This would be a wrapper but no content makes sense for it right now set to '' null;
		 * @param array $args
		 * @param array $instance
		 */

		function widget( $args, $instance ) {
			extract( $args );
			global $post;

			$description 	=  $instance['description'];
			$button_title 	=  $instance['button-title'];
			$button_link 	=  $instance['button-link'];
			$before_widget  = '';
			$after_widget   = '';

			echo $before_widget;

			echo '
			<div class="ewf-row">
				<div class="ewf-span9">
					<h1 class="last">'.$description.'</h1>
				</div><!-- end .ewf-span -->
				<div class="ewf-span3 text-right">
					<a href="'.$button_link.'" class="btn btn-black btn-large">'.$button_title.'</a>
				</div><!-- end .ewf-span -->
			</div>';
			
			echo $after_widget;
		}
	 
		
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			$instance['description'] 	= strip_tags( $new_instance['description'] );
			$instance['button-link'] 	= strip_tags( $new_instance['button-link'] );
			$instance['button-title'] 	= strip_tags( $new_instance['button-title'] );

			return $instance;
		}
		

		function form( $instance ) {
			$defaults = array( 'title' => null, 'button-title' => __('Sample title' , EWF_SETUP_THEME_DOMAIN), 'button-link' => '#', 'description' => null);
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			
			<div class="ewf-meta">
			
				<p>
					<label for="<?php echo $this->get_field_id( 'button-title' ); ?>"><?php _e('Button title:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'button-title' ); ?>" name="<?php echo $this->get_field_name( 'button-title' ); ?>" value="<?php echo $instance['button-title']; ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'button-link' ); ?>"><?php _e('Button link:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'button-link' ); ?>" name="<?php echo $this->get_field_name( 'button-link' ); ?>" value="<?php echo $instance['button-link']; ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'description' ); ?>"><?php _e('Text:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'description' ); ?>" name="<?php echo $this->get_field_name( 'description' ); ?>" value="<?php echo $instance['description']; ?>" style="width:100%;" />
				</p>
			
			</div>
			
		<?php
		}
	}


?>