<?php  get_header(); ?>
	


<?php

	##	 Get page layout & sidebar
	##
	
	$page_404 = get_option(EWF_SETUP_THNAME."_page_404", 0);
	
	if ($page_404){
	
		$page_sidebar = ewf_get_sidebar_id('sidebar-page', $page_404);		
		$page_layout = ewf_get_sidebar_layout('layout-full', $page_404);
		$page_data 	= get_post($page_404);
		
		switch ($page_layout) {
		
			case "layout-sidebar-single-left": 
				echo '<div class="ewf-row">';
					echo '<div class="ewf-span4">';
						dynamic_sidebar($page_sidebar);
					echo '</div>';
					echo '<div class="ewf-span8">';
						
						echo do_shortcode($page_data->post_content);
						
					echo '</div>';
				echo '</div>';
				break;
		
			case "layout-sidebar-single-right": 
				echo '<div class="ewf-row">';
					echo '<div class="ewf-span8">';

						echo do_shortcode($page_data->post_content);

					echo '</div>';
					echo '<div class="ewf-span4">';
						dynamic_sidebar($page_sidebar);
					echo '</div>';
				echo '</div>';
				break; 
		
			case "layout-full": 
				echo do_shortcode($page_data->post_content);
		}
		
	
	}else{
	
		echo '<div id="content" style=" padding-top:160px; min-height: 300px;">';
			echo '<div class="ewf-row">';
				echo '<div class="ewf-span12">';
					echo '<div class="alert alert-info"><p class="archive-title">'.__('Error 404 - Page not found!', EWF_SETUP_THEME_DOMAIN).'</p></div>';
				echo '</div>'; 
			echo '</div>'; 	
		echo '</div>'; 
		
	}

?>
 

	
<?php	get_footer();  ?>