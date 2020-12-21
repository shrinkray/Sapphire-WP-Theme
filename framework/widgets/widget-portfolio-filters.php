<?php 



	class ewf_widget_portfolio_filters extends WP_Widget {

		function ewf_widget_portfolio_filters() {
			$widget_ops = array( 'classname' => 'ewf_widget_portfolio_filters', 'description' => __('A widget that displays sub pages navigation', EWF_SETUP_THEME_DOMAIN) );
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'ewf_widget_portfolio_filters' );
			parent::__construct( 'ewf_widget_portfolio_filters', __('EWF - Project Filter', EWF_SETUP_THEME_DOMAIN), $widget_ops, $control_ops );
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
			$show_parent =  $instance['show-parent'];
			$extra_link =  $instance['extra-link'];
			$before_widget  = '';
			$after_widget   = '';
			$before_title   = '';
			$after_title    = '';
			$full = 0;
			
			
			$ext_title = $instance['all-work'];
			$ext_url = null;
			
			echo $before_widget; 

			if ( $title ) 
				echo $before_title . $title . $after_title;
				
			$page_id = 0; 
			$page_portfolio_title = get_option(EWF_SETUP_THNAME."_page_portfolio", null );
			$page_portfolio = get_page_by_title( $page_portfolio_title );
				
				
			if (is_object($page_portfolio)){
				$page_id = $page_portfolio->ID;
				}
			
			if ($page_id) { 
				apply_filters('debug', 'Filter Widget - Page ID:'.$page_id);
					
				if ($ext_url == null) { $ext_url = get_permalink($page_id); }
				if ($ext_title == null) { $ext_title =  __('All Work', EWF_SETUP_THEME_DOMAIN); }
			}		
			
			$terms = get_terms ('service');

			$current_url = strtolower($_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
			$current_url = str_replace(array('http://', 'https://', 'page/2/', 'page/3/', 'page/4/', 'page/5/', 'page/6/', 'page/7/', 'page/8/', 'page/9/', 'page/10/', 'page/11/', 'page/12/', 'page/13/', 'page/14/', 'page/15/' ),'',strtolower($current_url));
			
			echo '<div class="side-nav"><ul class="side-nav">';
				if ($extra_link == "on") { 
					$full_url = str_replace(array('http://', 'https://'),'',strtolower($ext_url));
			
					$extra = null;
					if ($current_url==$full_url){ $extra = "class='current' "; }
					echo '<li '.$extra.'><a href="'.$ext_url.'">'.$ext_title.'</a></li>';
				}  
				 
				foreach($terms as $key => $service){
					$item_permalink = get_term_link($service->name, 'service');
					$item_url = str_replace(array('http://', 'https://'),'',strtolower($item_permalink));
			
					$extra = null;
					if ($current_url==$item_url){ $extra = "class='current' "; }
					
					echo '<li '.$extra.'><a href="'.get_term_link($service->name, 'service').'">'.$service->name.'</a></li>';
				}
			echo '</ul></div>';   
			 
			echo $after_widget;
		}  
	
		
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['show-parent'] = strip_tags( $new_instance['show-parent'] );
			$instance['extra-link'] = strip_tags( $new_instance['extra-link'] );
			$instance['all-work'] = strip_tags( $new_instance['all-work'] );

			return $instance; 
		} 
		

		function form( $instance ) {
			$defaults = array( 'title' => __(null , EWF_SETUP_THEME_DOMAIN), 'all-work' => __('All Work', EWF_SETUP_THEME_DOMAIN));
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Section title:', EWF_SETUP_THEME_DOMAIN); ?></label>
				<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:95%;" /> 
			</p>
			 
			<p>
				<label for="<?php echo $this->get_field_id( 'all-work' ); ?>"><?php _e('All Work Title:', EWF_SETUP_THEME_DOMAIN); ?></label>
				<input id="<?php echo $this->get_field_id( 'all-work' ); ?>" name="<?php echo $this->get_field_name( 'all-work' ); ?>" value="<?php echo $instance['all-work']; ?>" style="width:95%;" /> 
			</p> 
			 		
			<p>
				<input type="checkbox" id="<?php echo $this->get_field_id( 'extra-link' ); ?>" name="<?php echo $this->get_field_name( 'extra-link' ); ?>" <?php check_checkbox( $instance['extra-link']); ?> />
				<label for="<?php echo $this->get_field_id( 'extra-link' ); ?>"><?php _e('Show portfolio link', EWF_SETUP_THEME_DOMAIN); ?></label>
			</p>
 
		<?php
		} 
	}
	 
	
	if (!function_exists('check_checkbox')){
		function check_checkbox($value){
			if ($value == "on"){
				echo " checked='yes' ";
			}
		}
	} 

?>