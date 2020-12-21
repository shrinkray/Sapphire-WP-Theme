<?php

	add_action('admin_menu', 'ewf_pgContact_metaRegister');
	add_action('save_post', 'ewf_pgContact_metaUpdate');
	
	
	
	function ewf_pgContact_metaRegister() {
		if (array_key_exists('post', $_GET) || array_key_exists('post', $_GET)){
			$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ; 
		  
		
			if (get_post_meta($post_id,'_wp_page_template',TRUE) == 'page-contact.php') {
				
				add_meta_box( 'ewf-contact-meta', __('Contact details', EWF_SETUP_THEME_DOMAIN), 'ewf_pgContact_metaSource', 'page', 'normal', 'high' );
			}
		}
	}
		
		
	function ewf_pgContact_metaSource() {
			global $post;
			
			$contact_meta = get_post_custom($post->ID);

			$contact_address = 'New York, NY';
			$contact_zoom = 14;
			$contact_caption = "There's no place like home!";
			
			
			if (array_key_exists('_ewf-contact-address', $contact_meta)){
				$contact_address = $contact_meta["_ewf-contact-address"][0];
				}
			
			if (array_key_exists('_ewf-contact-zoom', $contact_meta)){			
				$contact_zoom = $contact_meta["_ewf-contact-zoom"][0];
				}
			
			if (array_key_exists('_ewf-contact-caption', $contact_meta)){			
				$contact_caption = $contact_meta["_ewf-contact-caption"][0];
				}
				
			
			echo '
			<div class="ewf-meta"> 
				<p>
					<label>'.__('Address:', EWF_SETUP_THEME_DOMAIN).'</label><input name="_ewf-contact-address" value="'.$contact_address.'" />
				</p>
				
				<p>
					<label>'.__('Zoom:', EWF_SETUP_THEME_DOMAIN).'</label><input min="0" max="19" name="_ewf-contact-zoom" value="'.$contact_zoom.'" />
				</p>
				<p>
					<label>'.__('Caption:', EWF_SETUP_THEME_DOMAIN).'</label><input name="_ewf-contact-caption" value="'.$contact_caption.'" />
				</p>
			</div>';
	}

	
	function ewf_pgContact_metaUpdate() {
		global $post;
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return $post->ID;
		}
		
		if (is_object($post)){
			$contact_meta = get_post_custom($post->ID);
			
			if (array_key_exists('_ewf-contact-address', $_POST)){
				update_post_meta($post->ID, "_ewf-contact-address"	, $_POST["_ewf-contact-address"]);
				update_post_meta($post->ID, "_ewf-contact-zoom"		, $_POST["_ewf-contact-zoom"]	);
				update_post_meta($post->ID, "_ewf-contact-caption"	, $_POST["_ewf-contact-caption"]);
				// echo '<pre>Saving data!</pre>';
			}
		}
	}




?>