<?php 



	class ewf_widget_latest_posts extends WP_Widget {

		function ewf_widget_latest_posts() {
			$widget_ops = array( 'classname' => 'ewf_widget_latest_posts', 'description' => __('A widget that displays popular posts from blog', EWF_SETUP_THEME_DOMAIN) );
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'ewf_widget_latest_posts' );
			parent::__construct( 'ewf_widget_latest_posts', __('EWF - Latest Posts', EWF_SETUP_THEME_DOMAIN), $widget_ops, $control_ops );
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
			$items =  $instance['items'];
			$before_widget  = '';
			$after_widget   = '';
			$before_title   = '';
			$after_title    = '';
			
			if ($items == null){
				$items = 3;
			}
			
			echo $before_widget;

			if ( $title ) 
				echo $before_title . $title . $after_title;
				
			$popular_posts = new WP_Query('orderby=date&posts_per_page='.$items); 
			$posts_count = 0;
			$extra_class = null;
			
			echo '<ul>';
				 while ($popular_posts->have_posts()) : $popular_posts->the_post();
					global $post;
					$posts_count++;
					
					# 	Get post categories
					#
					$ewf_post_categories = null;
					
					foreach((get_the_category( $post->ID )) as $category) { 
						if ($ewf_post_categories == null){
							$ewf_post_categories.= '<a href="'.get_category_link( $category->term_id ).'" >'.$category->cat_name.'</a>';
							break;
						}
					}
					
					
					# Get post featured image
					#
					$ewf_image_id = get_post_thumbnail_id($post->ID);  
					$ewf_image_url = wp_get_attachment_image_src($ewf_image_id,'thumbnail'); 
					
					
					if ($posts_count == 1){
						$extra_class = 'first'; 
					}elseif($posts_count == $items){
						$extra_class = 'last'; 
					}else{
						$extra_class = null;
					}
					
					$image_id = get_post_thumbnail_id($post->ID);  
					$image_url = wp_get_attachment_image_src($image_id,'blog-featured-thumb');  
					
					echo'<li class="fixed '.$extra_class.'">';

						if ($ewf_image_id){
							echo '<img src="'.$ewf_image_url[0].'" alt="'.$post->post_title.'" width="42" >';
						}
						
						echo '<p>'.$ewf_post_categories.' <span>'.get_the_time('d.m.Y').'</span></p>';
						echo '<p><a href="'. get_permalink($post->ID) .'">'.$post->post_title.'</a></p>';
						// echo '<p>'.ewf_excerpt_max_charlength(100).'</p>';
						// echo '<a class="btn" href="'. get_permalink($post->ID) .'">'.__('read more', EWF_SETUP_THEME_DOMAIN).'</a>';
					echo '</li>'; 
					
				endwhile;
			echo '</ul>';
			
			
			echo $after_widget;
		}
	 
		
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['items'] = strip_tags( $new_instance['items'] );

			return $instance;
		}
		

		function form( $instance ) {
			$defaults = array( 'title' => __(null , EWF_SETUP_THEME_DOMAIN), 'items' => 2);
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			<div class="ewf-meta">
				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'items' ); ?>"><?php _e('How many post to show:', EWF_SETUP_THEME_DOMAIN); ?></label>
					
					<select id="<?php echo $this->get_field_id( 'items' ); ?>" name="<?php echo $this->get_field_name( 'items' ); ?>" style="width:100%;">
					<?php
						
						for($i = 1; $i <= 10; $i++){
							#$instance['items']
							
							if ($i == $instance['items']){
								echo '<option  selected="selected">'.$i.'</option>';
							}else{
								echo '<option>'.$i.'</option>';
							}
						}

					?>
					</select>
				</p>
			</div>
 
		<?php
		}
	}


?>