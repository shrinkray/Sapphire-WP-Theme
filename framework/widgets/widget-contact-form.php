<?php


	class ewf_widget_contact_forms extends WP_Widget {

		function ewf_widget_contact_forms() {
			$widget_ops = array( 'classname' => 'ewf_widget_contact_forms', 'description' => __('A widget that displays a contact form created with Contact Form 7', EWF_SETUP_THEME_DOMAIN) );
			$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'ewf_widget_contact_forms' );
			parent::__construct( 'ewf_widget_contact_forms', __('EWF - Contact Form 7', EWF_SETUP_THEME_DOMAIN), $widget_ops, $control_ops );
		}
		

		function widget( $args, $instance ) {
			extract( $args );
			global $post;

			$title = apply_filters('widget_title', $instance['title'] );
			$str_title = null;
			$form_id =  $instance['form_id'];

			echo $before_widget;

			if ( $title ){
				// echo $before_title . $title . $after_title;
				$str_title='title="'.$title.'"';
			}
							
				
			if ($form_id){
				$shortcode = '[contact-form-7 id="'.$form_id.'" '.$str_title.']';
				echo do_shortcode($shortcode);
			} 
				
				
			

			
			echo $after_widget;
		}
	 
		
		function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			
			$instance['title'] = strip_tags( $new_instance['title'] );
			$instance['form_id'] = strip_tags( $new_instance['form_id'] );

			return $instance;
		}
		 

		function form( $instance ) {
			$defaults = array( 'title' => __(null , EWF_SETUP_THEME_DOMAIN), 'form_id' => 0);
			$instance = wp_parse_args( (array) $instance, $defaults ); ?>
			
			<div class="ewf-meta">
				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', EWF_SETUP_THEME_DOMAIN); ?></label>
					<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
				</p>

				<p>
					<label for="<?php echo $this->get_field_id( 'form_id' ); ?>"><?php _e('Contact Form:', EWF_SETUP_THEME_DOMAIN); ?></label>
					
					<select id="<?php echo $this->get_field_id( 'form_id' ); ?>" name="<?php echo $this->get_field_name( 'form_id' ); ?>" style="width:100%;">
					
					<?php
					
						$ewf_contact_forms = ewf_get_contactForms();
						
						foreach($ewf_contact_forms as $form_title => $form_id ){
							if ($instance['form_id'] == $form_id){
								echo '<option value="'.$form_id.'" selected="selected" >'.$form_title.'</option>';
							}else{
								echo '<option value="'.$form_id.'" >'.$form_title.'</option>';
							}
						}
						
					?>
					</select>
					
				</p>

			</div>
			
		<?php
		}
	}


	
	function ewf_get_contactForms(){
		include_once(ABSPATH . 'wp-admin/includes/plugin.php'); // Require plugin.php to use is_plugin_active() below

		global $wpdb;
		$contact_forms = array();
		
		if (is_plugin_active('contact-form-7/wp-contact-form-7.php')) {
		
			$cf7 = $wpdb->get_results( "SELECT ID, post_title FROM $wpdb->posts WHERE post_type = 'wpcf7_contact_form' ");
			if ($cf7) {
				foreach ( $cf7 as $cform ) {
					$contact_forms[$cform->post_title] = $cform->ID;
				}
			} else {
				$contact_forms["No contact forms found"] = 0;
			}
	
		}
		
		return $contact_forms;
	}

?>