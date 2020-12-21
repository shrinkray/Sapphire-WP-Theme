<?php 



	class ewf_widget_flickr extends WP_Widget {

		function ewf_widget_flickr() {
			$widget_ops = array( 'classname' => 'ewf_widget_flickr', 'description' => __('A widget that displays brochure item', EWF_SETUP_THEME_DOMAIN) );
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'ewf_widget_flickr' );
			parent::__construct( 'ewf_widget_flickr', __('EWF - Flickr', EWF_SETUP_THEME_DOMAIN), $widget_ops, $control_ops );
		}
		
		/**
         * Added missing variable assignments, before_widget, $after_widget, $before_title, $after_title
		 * @param array $args
		 * @param array $instance
		 */

		function widget( $args, $instance ) {
			extract( $args );
			global $post;
			
			$before_widget  = '';
			$after_widget   = '';
			$before_title   = '';
			$after_title    = '';
			$title = apply_filters('widget_title', $instance['title'] );
			
			$gallery_id =  $instance['gallery_id'];
			
			$gallery_items =  $instance['gallery_items'];
			if ($gallery_items <= 0 ){ $gallery_items = 9; }
			
			echo $before_widget;

			if ( $title ) {
				echo $before_title . $title . $after_title;
			}
			
				
			if ($gallery_id){
				echo '<script type="text/javascript" src="http://www.flickr.com/badge_code.gne?count='.$gallery_items.'&amp;display=latest&amp;size=square&amp;nsid='.$gallery_id.'&amp;raw=1"></script>';
			}
			
			echo $after_widget;
		}
	 
		
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['gallery_id'] = strip_tags( $new_instance['gallery_id'] );
			$instance['gallery_items'] = strip_tags( $new_instance['gallery_items'] );

			return $instance;
		}
		

		function form( $instance ) {
			$defaults = array( 'title' => __(null , EWF_SETUP_THEME_DOMAIN), 'gallery_items' => 9, 'gallery_id' => 0 );
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			
			<div class="ewf-meta">
				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'gallery_id' ); ?>"><?php _e('Gallery or User ID:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'gallery_id' ); ?>" name="<?php echo $this->get_field_name( 'gallery_id' ); ?>" value="<?php echo $instance['gallery_id']; ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'gallery_items' ); ?>"><?php _e('Number of items:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'gallery_items' ); ?>" name="<?php echo $this->get_field_name( 'gallery_items' ); ?>" value="<?php echo $instance['gallery_items']; ?>" style="width:100%;" />
				</p>
			</div>
 
		<?php
		}
	}


?>