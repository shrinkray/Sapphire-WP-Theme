<?php 



	class ewf_widget_social_media extends WP_Widget {

		function ewf_widget_social_media() {
			$widget_ops = array( 'classname' => 'ewf_widget_social_media', 'description' => __('A widget that displays social media icons designed for header top', EWF_SETUP_THEME_DOMAIN) );
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'ewf_widget_social_media' );
			parent::__construct( 'ewf_widget_social_media', __('EWF - Social Media', EWF_SETUP_THEME_DOMAIN), $widget_ops, $control_ops );
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
			$profile_facebook 	=  $instance['profile_facebook'];
			$profile_twitter 	=  $instance['profile_twitter'];
			$profile_plus 		=  $instance['profile_plus'];
			$profile_pinterest	=  $instance['profile_pinterest'];
			$profile_youtube 	=  $instance['profile_youtube'];
			$profile_dribbble 	=  $instance['profile_dribbble'];
			$profile_tumblr 	=  $instance['profile_tumblr'];
			$profile_instagram 	=  $instance['profile_instagram'];
			$profile_rss 		=  $instance['profile_rss'];
			
			$before_widget  = '';
			$after_widget   = '';
			$before_title   = '';
			$after_title    = '';


			echo $before_widget;

			if ( $title ) 
				echo $before_title . $title . $after_title;
			
			
			echo '<div class="fixed">';

				if ($profile_facebook){
					echo '<a class="facebook-icon social-icon" href="'.$profile_facebook.'"><i class="fa fa-facebook"></i></a>';
				}
				
				if ($profile_twitter){
					echo '<a class="twitter-icon social-icon" href="'.$profile_twitter.'"><i class="fa fa-twitter"></i></a>';
				}
				
				if ($profile_plus){
					echo '<a class="googleplus-icon social-icon" href="'.$profile_plus.'"><i class="fa fa-google-plus"></i></a>';
				}
				
				if ($profile_pinterest){
					echo '<a class="pinterest-icon social-icon" href="'.$profile_pinterest.'"><i class="fa fa-pinterest"></i></a>';
				}
				
				if ($profile_youtube){
					echo '<a class="youtube-icon social-icon" href="'.$profile_youtube.'"><i class="fa fa-youtube"></i></a>';
				}
				
				if ($profile_dribbble){
					echo '<a class="dribble-icon social-icon" href="'.$profile_dribbble.'"><i class="fa fa-dribbble"></i></a>';
				}
				
				if ($profile_tumblr){
					echo '<a class="tumblr-icon social-icon" href="'.$profile_tumblr.'"><i class="fa fa-tumblr"></i></a>';
				}	
				
				if ($profile_instagram){
					echo '<a class="instagram-icon social-icon" href="'.$profile_instagram.'"><i class="fa fa-instagram"></i></a>';
				}

				if ($profile_rss){
					echo '<a class="rss-icon social-icon" href="'.$profile_rss.'"><i class="fa fa-rss"></i></a>';
				}
			echo '</div>';
			

			
			echo $after_widget;
		}
	 
		
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			$instance['title'] 				= $new_instance['title'] ;
			$instance['profile_facebook'] 	= $new_instance['profile_facebook'] ;
			$instance['profile_twitter'] 	= $new_instance['profile_twitter'] ;
			$instance['profile_plus'] 		= $new_instance['profile_plus'] ;
			$instance['profile_pinterest'] 	= $new_instance['profile_pinterest'] ;
			$instance['profile_youtube'] 	= $new_instance['profile_youtube'] ;
			$instance['profile_dribbble'] 	= $new_instance['profile_dribbble'] ;
			$instance['profile_tumblr'] 	= $new_instance['profile_tumblr'] ;
			$instance['profile_instagram'] 	= $new_instance['profile_instagram'] ;
			$instance['profile_rss'] 	= $new_instance['profile_rss'] ;


			return $instance;
		}
		 

		function form( $instance ) {
			$defaults = array( 
				'title' => null, 
				'profile_facebook' => null, 
				'profile_twitter' => null, 
				'profile_plus' => null, 
				'profile_pinterest' => null, 
				'profile_youtube' => null,
				'profile_dribbble' => null,
				'profile_tumblr' => null,
				'profile_instagram' => null,
				'profile_rss' => null
			);
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			
			<div class="ewf-meta">
				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'profile_facebook' ); ?>"><?php _e('Facebook profile URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_facebook' ); ?>" name="<?php echo $this->get_field_name( 'profile_facebook' ); ?>" value="<?php echo $instance['profile_facebook']; ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'profile_twitter' ); ?>"><?php _e('Twitter profile URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_twitter' ); ?>" name="<?php echo $this->get_field_name( 'profile_twitter' ); ?>" value="<?php echo $instance['profile_twitter']; ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'profile_plus' ); ?>"><?php _e('Google Plus profile URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_plus' ); ?>" name="<?php echo $this->get_field_name( 'profile_plus' ); ?>" value="<?php echo $instance['profile_plus']; ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'profile_pinterest' ); ?>"><?php _e('Pinterest profile URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_pinterest' ); ?>" name="<?php echo $this->get_field_name( 'profile_pinterest' ); ?>" value="<?php echo $instance['profile_pinterest']; ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'profile_youtube' ); ?>"><?php _e('YouTube profile URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_youtube' ); ?>" name="<?php echo $this->get_field_name( 'profile_youtube' ); ?>" value="<?php echo $instance['profile_youtube']; ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'profile_dribbble' ); ?>"><?php _e('Dribbble profile URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_dribbble' ); ?>" name="<?php echo $this->get_field_name( 'profile_dribbble' ); ?>" value="<?php echo $instance['profile_dribbble']; ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'profile_tumblr' ); ?>"><?php _e('Tumblr profile URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_tumblr' ); ?>" name="<?php echo $this->get_field_name( 'profile_tumblr' ); ?>" value="<?php echo $instance['profile_tumblr']; ?>" style="width:100%;" />
				</p>			
				
				<p>
					<label for="<?php echo $this->get_field_id( 'profile_instagram' ); ?>"><?php _e('Instagram profile URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_instagram' ); ?>" name="<?php echo $this->get_field_name( 'profile_instagram' ); ?>" value="<?php echo $instance['profile_instagram']; ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'profile_rss' ); ?>"><?php _e('RSS Feed URL:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'profile_rss' ); ?>" name="<?php echo $this->get_field_name( 'profile_rss' ); ?>" value="<?php echo $instance['profile_rss']; ?>" style="width:100%;" />
				</p>
			</div>
			
		<?php
		}
	}


?>