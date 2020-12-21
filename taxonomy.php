<?php 
	
	global $post, $wp_query;
	get_header();
	

#	 Get page layout & sidebar
#
	$page_portfolio = ewf_get_page_relatedID();
	
	$page_sidebar = ewf_get_sidebar_id('sidebar-page', $page_portfolio);		
	$page_layout = ewf_get_sidebar_layout("layout-full", $page_portfolio);
	$service_tax_term =  get_term_by( 'slug', $wp_query->query_vars['service'], EWF_PROJECTS_TAX_SERVICES);	
	
	#echo '<div class="row"><div class="alert alert-info"><strong>Portfolio blog ID</strong>:'.$page_portfolio.' &nbsp;&nbsp;&nbsp;&nbsp; <strong>Sidebar Settings</strong>:'.$page_layout.'</div></div>';
	
	
	switch ($page_layout) {
	
		case "layout-sidebar-single-left": 
			echo '<div class="row">';
				echo '<div class="span3">';
					dynamic_sidebar($page_sidebar);
				echo '</div>';
				echo '<div class="span9">';
				
						echo ewf_projects_sc_overview(array('service' => $service_tax_term->slug ), null); 
						
				echo '</div>';
			echo '</div>';
			break;
	
		case "layout-sidebar-single-right": 
			echo '<div class="row">';
				echo '<div class="span9">';

						echo ewf_projects_sc_overview(array('service' => $service_tax_term->slug ), null); 

				echo '</div>';
				echo '<div class="span3">';
					dynamic_sidebar($page_sidebar); 
				echo '</div>';
			echo '</div>';
			break; 
	
		case "layout-full": 
			echo '<div class="row">';
				echo '<div class="span12">';
			
					echo ewf_projects_sc_overview(array('service' => $service_tax_term->slug ), null); 
				
				echo '</div>';
			echo '</div>';
	}


	get_footer();  
 ?>