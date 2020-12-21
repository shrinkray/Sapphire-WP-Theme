<?php 



	class ewf_widget_brochure extends WP_Widget {

		function ewf_widget_brochure() {
			$widget_ops = array( 'classname' => 'ewf_widget_brochure', 'description' => __('A widget that displays brochure item', EWF_SETUP_THEME_DOMAIN) );
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'ewf_widget_brochure' );
			parent::__construct( 'ewf_widget_brochure', __('EWF - Brochure', EWF_SETUP_THEME_DOMAIN), $widget_ops, $control_ops );
		}
		
		/**
         * Added missing variable assignments, before_widget, $after_widget, $before_title, $after_title
		 * @param array $args
		 * @param array $instance
		 */

		function widget( $args, $instance ) {
			extract( $args );
			global $post;

			$title = apply_filters('widget_title', $instance['title'] );
			$brochure_url =  $instance['brochure-url'];
			$brochure_title =  $instance['brochure-title'];
			$before_widget  = '';
			$after_widget   = '';
			$before_title   = '';
			$after_title    = '';

			echo $before_widget;

			if ( $title ) 
				echo $before_title . $title . $after_title;
				
			echo '<div class="pdf"><a href="'.$brochure_url.'">'.$brochure_title.'</a></div>';
			
			echo $after_widget;
		}
	 
		
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['brochure-url'] = strip_tags( $new_instance['brochure-url'] );
			$instance['brochure-title'] = strip_tags( $new_instance['brochure-title'] );

			return $instance;
		}
		

		function form( $instance ) {
			$defaults = array( 'title' => __(null , EWF_SETUP_THEME_DOMAIN));
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Section title:', EWF_SETUP_THEME_DOMAIN); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'brochure-title' ); ?>"><?php _e('Link title:', EWF_SETUP_THEME_DOMAIN); ?></label>
				<input id="<?php echo $this->get_field_id( 'brochure-title' ); ?>" name="<?php echo $this->get_field_name( 'brochure-title' ); ?>" value="<?php echo $instance['brochure-title']; ?>" style="width:100%;" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id( 'brochure-url' ); ?>"><?php _e('File URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
				<input id="<?php echo $this->get_field_id( 'brochure-url' ); ?>" name="<?php echo $this->get_field_name( 'brochure-url' ); ?>" value="<?php echo $instance['brochure-url']; ?>" style="width:100%;" />
			</p>
 
		<?php
		}
	}


?>