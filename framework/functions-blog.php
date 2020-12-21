<?php


	#	posts_per_page	-	Show at most x many posts on blog pages.
	#	page_for_posts 	-	The ID of the page that displays posts. Useful when show_on_front's value is page.
	
	$ewf_page_for_posts = get_option('page_for_posts');
	
	
	
	add_image_size( 'blog-featured-image'	,620	,280	,true 	);
	add_image_size( 'blog-featured-thumb'	,50		,50		,true 	);
 
	add_shortcode("blog-recent"				,"ewf_sc_blog_summary"  );
	add_shortcode("blog"					,"ewf_sc_blog_overview"	);
	
		
	function ewf_blog_navigation_default( $range = 5, $query){
		
		$args = array(
			'base'         => '%_%',
			'format'       => '?page=%#%',
			'total'        => 5,
			'current'      => 0,
			'show_all'     => False,
			'end_size'     => 1,
			'mid_size'     => 2,
			'prev_next'    => True,
			'type'         => 'plain',
			'add_args'     => False,
			'add_fragment' => ''
		);
		
		paginate_links( $args );
	}



	add_action('wp_ajax_ewf_blog_timelinePosts'				, 'ewf_blog_timelinePosts' );
	
	
	function ewf_blog_timelinePosts(){
		$response = array();
		
		if (is_array($_POST) && array_key_exists('page', $_POST)){ 
			
			$posts = ewf_sc_blog_timelinePages(array('page'=>$_POST['page']));
			
			wp_send_json_success(array('page'=>$_POST['page'], 'state'=>1, 'posts'=>$posts ));
		}else{
			wp_send_json_error(array('state' => 0, 'message'=>'Inconsistent data'));
		}
		
		exit;
	} 
	
	
	function ewf_sc_blog_navigation_pages( $range = 5, $query){
		$src_nav = null;
		$max_page = 0;
		
		$data_pages = array();
		
		$class_current = 'current';
		$current_page = $query->query_vars['paged'];
		
		
		
		if ($current_page == 0) { 
			$current_page = 1; 
			}
	
	
	# 	How much pages do we have?
	
		if ( !$max_page ) {
			$max_page = $query->max_num_pages;
			}
			
			
			

	  // We need the pagination only if there are more than 1 page
	  if($max_page > 1){
	  
		if ( !$current_page ) 		{ $current_page = 1; }
		
		if($max_page > $range){
		  // When closer to the beginning
		  if($current_page < $range){
			for($i = 1; $i <= ($range + 1); $i++){		  
			  $data_pages['curent'] = $current_page;
			  $data_pages['pages'][$i] =  get_pagenum_link($i);
			}
		  } 
		  // When closer to the end
		  elseif($current_page >= ($max_page - ceil(($range/2)))){
			$extra = 0;
		  
			if (($max_page - ($max_page - $range)) < 2 ) $extra = 1;
		  
			for($i = $max_page - $range - $extra; $i <= $max_page; $i++){
			  $data_pages['curent'] = $current_page;
			  $data_pages['pages'][$i] =  get_pagenum_link($i); 
			}
		  }
		  // Somewhere in the middle
		  elseif($current_page >= $range && $current_page < ($max_page - ceil(($range/2)))){
			$extra = 0;
			if ($current_page - ceil($range/2) == 0 ) $extra = 1;
			
			for($i = ( $current_page - ceil($range/2) + $extra); $i <= ($current_page + ceil(($range/2))+$extra); $i++){
			  $data_pages['curent'] = $current_page;
			  $data_pages['pages'][$i] =  get_pagenum_link($i);  
			}
		  }
		} 
		// Less pages than the range, no sliding effect needed
		else{
		  for($i = 1; $i <= $max_page; $i++){
			$data_pages['curent'] = $current_page;
			$data_pages['pages'][$i] =  get_pagenum_link($i);
		  }
		}

		// On the last page, don't put the Last page link
		if($current_page != $max_page){}
	  }
	   
		$src_nav = null;
		
		#	$label_prev = get_option(EWF_SETUP_THNAME."_blog_older", __('Older Posts', EWF_SETUP_THEME_DOMAIN)); 
		#	$label_next = get_option(EWF_SETUP_THNAME."_blog_newer", __('Newer Posts', EWF_SETUP_THEME_DOMAIN));

			
		// echo '<pre>';
			// print_r($data_pages);
		// echo '</pre>';
			

		
		if (array_key_exists('pages', $data_pages)){
			$pos_curent = $data_pages['curent'];
			
			$src_nav.= '<ul class="pagination">';
				$count = 0;
				
				foreach($data_pages['pages'] as $key => $url){
					$count++;

					if($pos_curent == $key){
						$src_nav.= '<li class="current">'.$key.'</li>';
					}else{
					#	$src_nav.= '<li><a href="'.$url.'">&gt;</a></li>';
						$src_nav.= '<li><a href="'.$url.'">'.$key.'</a></li>';
					}
				}
				
			$src_nav.= '</ul>';
		}
		
		/* 		
		<ul class="pagination">
			<li class="current"><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">5</a></li>
			<li><a href="#">&gt;</a></li>
		</ul>
		 */
		 
		 
		/*
		$src_nav.= '<div class="fixed">';	
			$src_nav .= '<div class="col315">';
				if ($pos_curent < (count($data_pages['pages']))){
					$src_nav.= '<a href="'.$data_pages['pages'][$pos_curent+1].'">'.$label_prev.'</a>'; 
				}
			$src_nav .= '&nbsp;</div>';
			
			$src_nav .= '<div class="col315 last text-right">&nbsp;';
				if ($pos_curent != 1){
					$src_nav.= '<a href="'.$data_pages['pages'][$pos_curent-1].'">'.$label_next.'</a>';
				}
			$src_nav .= '</div>';
		$src_nav.= '</div>'; 
		*/

	  
		return $src_nav;
	
	}
	
	
	
	
	
	function ewf_sc_blog_navigation_steps( $range = 4, $query, $label_next = null, $label_prev = null ){
		$src_nav = null;
		$max_page = 0;
		
		$data_pages = array();
		
		$class_current = 'current';
		
		$current_page = $query->query_vars['paged'];
		if ($current_page == 0) { $current_page = 1; }
	
	  // How much pages do we have?
	  if ( !$max_page ) {
		$max_page = $query->max_num_pages;
	  }

	  // We need the pagination only if there are more than 1 page
	  if($max_page > 1){
	  
		if ( !$current_page ) 		{ $current_page = 1; }
		if ( $current_page != 1 )	{ }
		
		if($max_page > $range){
		  // When closer to the beginning
		  if($current_page < $range){
			for($i = 1; $i <= ($range + 1); $i++){		  
			  $data_pages['curent'] = $current_page;
			  $data_pages['pages'][$i] =  get_pagenum_link($i);
			}
		  } 
		  // When closer to the end
		  elseif($current_page >= ($max_page - ceil(($range/2)))){
			$extra = 0;
		  
			if (($max_page - ($max_page - $range)) < 2 ) $extra = 1;
		  
			for($i = $max_page - $range - $extra; $i <= $max_page; $i++){
			  $data_pages['curent'] = $current_page;
			  $data_pages['pages'][$i] =  get_pagenum_link($i); 
			}
		  }
		  // Somewhere in the middle
		  elseif($current_page >= $range && $current_page < ($max_page - ceil(($range/2)))){
			$extra = 0;
			if ($current_page - ceil($range/2) == 0 ) $extra = 1;
			
			for($i = ( $current_page - ceil($range/2) + $extra); $i <= ($current_page + ceil(($range/2))+$extra); $i++){
			  $data_pages['curent'] = $current_page;
			  $data_pages['pages'][$i] =  get_pagenum_link($i);  
			}
		  }
		} 
		// Less pages than the range, no sliding effect needed
		else{
		  for($i = 1; $i <= $max_page; $i++){
			$data_pages['curent'] = $current_page;
			$data_pages['pages'][$i] =  get_pagenum_link($i);
		  }
		}

		// On the last page, don't put the Last page link
		if($current_page != $max_page){}
	  }
	   
		$src_nav = null;
		$last_nav = false;
		
		$label_prev = get_option(EWF_SETUP_THNAME."_blog_older", __('Older Posts', EWF_SETUP_THEME_DOMAIN)); 
		$label_next = get_option(EWF_SETUP_THNAME."_blog_newer", __('Newer Posts', EWF_SETUP_THEME_DOMAIN));
	  
		$pos_curent = $data_pages['curent'];

		$src_nav.= '<div class="blog-navigation fixed">';
			if ($pos_curent < (count($data_pages['pages']))){
				$src_nav.= '<a href="'.$data_pages['pages'][$pos_curent+1].'">&#8249; '.$label_prev.'</a>';
				$last_nav = true;
			}

			if ($last_nav){
				$src_nav.= ' | ';
			}
			
			if ($pos_curent != 1){
				$src_nav.= '<a href="'.$data_pages['pages'][$pos_curent-1].'">'.$label_next.' &#8250;</a>';
			}
		$src_nav.= '</div>';	
		
		
		// echo '<pre>';
		// print_r($data_pages);
		// echo '</pre>';
		
		
		/*
		$src_nav.= '<div class="fixed">';	
			$src_nav .= '<div class="col315">';
				if ($pos_curent < (count($data_pages['pages']))){
					$src_nav.= '<a href="'.$data_pages['pages'][$pos_curent+1].'">'.$label_prev.'</a>'; 
				}
			$src_nav .= '&nbsp;</div>';
			
			$src_nav .= '<div class="col315 last text-right">&nbsp;';
				if ($pos_curent != 1){
					$src_nav.= '<a href="'.$data_pages['pages'][$pos_curent-1].'">'.$label_next.'</a>';
				}
			$src_nav .= '</div>';
		$src_nav.= '</div>'; 
		*/

	  
	  return $src_nav; 
	}
	
	function ewf_sc_blog_summary( $atts, $content = null ){
		global $post;
		$src = null;
		
		extract(shortcode_atts(array(
			"posts" => 3,
			"id" => null, 
			"exclude" => null,
			"order" => "ASC",
			"showreadmore" => "true",
			"title" => __('blog archive', EWF_SETUP_THEME_DOMAIN),
			"url" => null
		), $atts));
		
		
		$query = array( 'post_type' => 'post',
						'order'=> 'DESC', 
						'orderby' => 'date',  
						'posts_per_page'=>$posts); 
		
		
		if ($exclude != null){
			if (is_numeric($id)){
				$exclude_items[] = $id ;
			}else{
				$tmp_id = explode(',', trim($id));
				foreach($tmp_id as $key => $item_id){
					if (is_numeric($item_id)){
						$exclude_items[] = $item_id ;
					}
				}
			}
			
			$query['post__not_in'] = $exclude_items;
		}
		
		
		if ($id != null){
			if (is_numeric($id)){
				$include_posts[] = $id ;
			}else{
				$tmp_id = explode(',', trim($id));
				foreach($tmp_id as $key => $item_id){
					if (is_numeric($item_id)){
						$include_posts[] = $item_id ;
					}
				}
			}
			
			unset($query['post__not_in']);
			unset($query['tax_query']);
			
			$query['post__in'] = $include_posts;
			$query['posts_per_page'] = count($include_posts);
		}
		
		$posts_count = 0;
		$src .= '<ul id="news-box">';
		
			$blog_summary = new WP_Query($query);
			 while ($blog_summary->have_posts()) : $blog_summary->the_post();
				global $post;
				$posts_count++;
				
				
				$image_id = get_post_thumbnail_id($post->ID);  
				$image_url = wp_get_attachment_image_src($image_id,'blog-featured-thumb');  
				
				#$src .= '<li class="'.$extra_class.'">';
				$src .= '<li>';
					
					#if ($image_id){
					#$src .=  '<img width="50" height="50" alt="" src="'.$image_url[0].'">'; 
					#}
						$src .=  '<a href="'. get_permalink($post->ID) .'">'.$post->post_title.'</a>';
						$src .=  '<br /><span>'.get_the_time('F d').', '.get_the_time('Y').'</span>';
					$src .= '</li>'; 
				
			endwhile;
			
			if ($url != null){
				$src .= '<li><a href="'.$url.'">'.$title.'</a></li>';
			}
			
			# if ($showreadmore == "true"){
			# 	$src .= '<li class="last fixed"><a href="#">'.$readmoretitle.'</a></li>';
			# }
			
		$src .=  '</ul>';
			
		return $src;
	
	}
	
	
	
	function ewf_sc_blog_timelinePages( $atts, $content = null ){
		global $post;
		
		extract(shortcode_atts(array(
			"posts" => get_option('posts_per_page'),
			"categ_include" => null, 
			"categ_exclude" => null,
			"posts_exclude" => null,
			"layout"		=> "single", 
			"height"		=> "auto",
			"width" 		=> "auto",
			"date"			=> "true",
			"info"			=> "true",
			"nav"			=> "true",
			"sidebar"		=> "false",
			"page"			=> 2,
			"style" 		=> "featured",
			"template"		=> "default"	#	default | columns | timeline
		), $atts));
		
		wp_reset_query();
		

		# Build the query
		#
		$wp_query_blog = new WP_Query(array( 'post_type' => 'post', 'posts_per_page' => $posts, 'orderby'=>'date', 'order'=>'DESC','paged' =>$page ));
		
		
		
		$ewf_blog_items = array();
		
		# Timeline template
		#
			// $ewf_vars 	= array( 'count' => 0, 'last' => 'left', 'pair' => null, 'src_left' => null, 'src_right' => null );
		
			// echo '<div class="ewf-row">';			
			while ($wp_query_blog->have_posts()) : $wp_query_blog->the_post();

				// if ($ewf_vars['row-items'] == 0){
					// echo '<div class="ewf-row">';			
				// }

				
			#	Prepare internal variables
			// #
				// $ewf_vars['count']++;
				// $ewf_vars['row-items']++;

				// if ($ewf_vars['last'] == 'left'){
					ob_start();
						get_template_part('templates/blog-columns-full');
					
					$ewf_blog_items[] = ob_get_clean();
					
					
					// $ewf_vars['last'] = 'right';
				// }else{
					// ob_start();
					// get_template_part('templates/blog-columns-full');
					
					// $ewf_blog_items[] = ob_get_clean();
					// $ewf_vars['last'] = 'left';
				// }

				
			endwhile;
			// echo '</div>';
			

			return $ewf_blog_items;
		// }
					
		// return $src;
	}	


	
	
	function ewf_sc_blog_overview( $atts, $content = null ){
		global $post;
		
		extract(shortcode_atts(array(
			"posts" => get_option('posts_per_page'),
			"readmorelabel" => get_option(EWF_SETUP_THNAME."_blog_read_more", __('&#8212; Read More', EWF_SETUP_THEME_DOMAIN)),
			"categ_include" => null, 
			"categ_exclude" => null,
			"posts_exclude" => null,
			"layout"		=> "single", 
			"height"		=> "auto",
			"width" 		=> "auto",
			"date"			=> "true",
			"info"			=> "true",
			"nav"			=> "true",
			"sidebar"		=> "false",
			"style" 		=> "featured",
			"template"		=> "default"	#	default | columns | timeline
		), $atts));
		
		wp_reset_query();
		
		
		$src = null;
		$ewf_paged 	= get_query_var('paged') ? get_query_var('paged') : 1;
		// $ewf_page_template = get_post_meta($post->ID,'_wp_page_template',TRUE);
	
		# Build the query
		#
		$wp_query_blog = new WP_Query(array( 'post_type' => 'post', 'posts_per_page' => $posts, 'orderby'=>'date', 'order'=>'DESC','paged' =>$ewf_paged ));
		
		
		

		
		ob_start();
		
		
		
		// echo '<div class="alert info"><i class="fa fa-info-circle"></i>Page template: <strong>'.$ewf_page_template.'</strong></div>';
		// echo '<div class="alert info"><i class="fa fa-info-circle"></i>Using template: <strong>'.$template.'</strong></div>';
		
		# Default blog template
		#
		if ($template == 'default'){
			$ewf_vars 	= array( 'count' => 0, 'pair' => null );
			
			while ($wp_query_blog->have_posts()) : $wp_query_blog->the_post();
				
			#	Prepare internal variables
			#
				$ewf_vars['count']++;
				$ewf_vars['pair'] = $ewf_vars['count'] % 2;			
			
			
			#	Load template
			#
				get_template_part('templates/blog-item-default');
				
			endwhile;
			
		}
			
		
		
		
		
		# 2 Columns full width template
		#
		if ($template == 'columns'){
			$ewf_vars 	= array( 'count' => 0, 'per-row' => 2, 'row-items' => 0, 'close-item-separator' => false, 'last-row' => false, 'pair' => null );
		
			// echo '<div class="ewf-row">';			
			while ($wp_query_blog->have_posts()) : $wp_query_blog->the_post();

				if ($ewf_vars['row-items'] == 0){
					echo '<div class="ewf-row">';			
				}

				
			#	Prepare internal variables
			#
				$ewf_vars['count']++;
				$ewf_vars['row-items']++;

				
				
				if ( (($wp_query_blog->post_count - ($wp_query_blog->current_post)) == $ewf_vars['per-row']) && $ewf_vars['close-item-separator'] ) {
					$ewf_vars['last-row'] = true;
					$ewf_vars['close-item-separator'] = false;
				}else{
					$ewf_vars['close-item-separator'] = true;
				}
				
				// echo '<pre>';
					// print_r($ewf_vars);
					// print_r($wp_query_blog);
					// echo '<br/>Post count:'.$wp_query_blog->post_count;
					// echo '<br/>Post curremt:'.$wp_query_blog->current_post;
				// echo '</pre>';
			

				
			#	Load template
			#
				echo '<div class="ewf-span6">';			
					get_template_part('templates/blog-columns-full');
					
					// if ($ewf_vars['last-row'] != true || $ewf_vars['close-item-separator'] == false ){
						echo '<div class="divider single-line"></div>';
					// }
				echo '</div>';
				
				
				if ($ewf_vars['row-items'] == 2 || ($wp_query_blog->post_count == ($wp_query_blog->current_post+1)) ){
					echo '</div>';
					
					$ewf_vars['close-item-separator'] = true;
				}
				
				if ($ewf_vars['row-items'] == $ewf_vars['per-row']){
					$ewf_vars['row-items'] = 0;
				}
				
			endwhile;
			// echo '</div>';
			
		}
		
		$src .= ob_get_clean();
		
		
		
		# Timeline template
		#
		if ($template == 'timeline'){
			$ewf_vars 	= array( 'count' => 0, 'last' => 'left', 'pair' => null, 'src_left' => null, 'src_right' => null );
		
			// echo '<div class="ewf-row">';			
			while ($wp_query_blog->have_posts()) : $wp_query_blog->the_post();

				// if ($ewf_vars['row-items'] == 0){
					// echo '<div class="ewf-row">';			
				// }

				
			#	Prepare internal variables
			#
				$ewf_vars['count']++;
				// $ewf_vars['row-items']++;

				if ($ewf_vars['last'] == 'left'){
					ob_start();
					get_template_part('templates/blog-columns-full');
					
					
					$ewf_vars['src_left'] .= ob_get_clean();
					$ewf_vars['last'] = 'right';
				}else{
					ob_start();
					get_template_part('templates/blog-columns-full');
					
					$ewf_vars['src_right'] .=  ob_get_clean();
					$ewf_vars['last'] = 'left';
				}
				
				
				
				
				
				// if ( (($wp_query_blog->post_count - ($wp_query_blog->current_post)) == $ewf_vars['per-row']) && $ewf_vars['close-item-separator'] ) {
					// $ewf_vars['last-row'] = true;
					// $ewf_vars['close-item-separator'] = false;
				// }else{
					// $ewf_vars['close-item-separator'] = true;
				// }
				
				// echo '<pre>';
					// print_r($ewf_vars);
					// print_r($post);
					// echo '<br/>Post count:'.$wp_query_blog->post_count;
					// echo '<br/>Post curremt:'.$wp_query_blog->current_post;
				// echo '</pre>';
			

				
			#	Load template
			#
				// echo '<div class="ewf-span6">';			
					
					
					
					// if ($ewf_vars['last-row'] != true || $ewf_vars['close-item-separator'] == false ){
						// echo '<div class="divider single-line"></div>';
					// }
				// echo '</div>';
				
				
				// if ($ewf_vars['row-items'] == 2 || ($wp_query_blog->post_count == ($wp_query_blog->current_post+1)) ){
					// echo '</div>';
					
					// $ewf_vars['close-item-separator'] = true;
				// }
				
				// if ($ewf_vars['row-items'] == $ewf_vars['per-row']){
					// $ewf_vars['row-items'] = 0;
				// }
				
			endwhile;
			// echo '</div>';
			
			
			ob_start();
			
			echo '<div class="timeline fixed">';
				
				echo '<div class="left-side">';
					echo $ewf_vars['src_left'];
				echo '</div>';
				
				echo '<div class="separator"></div>';
				
				echo '<div class="right-side">';
					echo $ewf_vars['src_right'];
				echo '</div>';
				
			echo '</div>';
			
			
			
			echo '<div class="ewf-row timeline-nav">';
            	echo '<div class="ewf-span12">';
                    echo '<a href="#" class="read-more" data-page="1">More</a>';
                echo '</div><!-- end .span12 -->';
            echo '</div>';
			
			$src .= ob_get_clean();
			
		}
		
		
		
		
		
		
		#	Load navigation
		#		
		if ($nav == 'true' && $template != 'timeline'){
			if ($wp_query_blog->max_num_pages > 1){
				#	echo'<div class="hr"></div>'; 
			 	#	echo ewf_sc_blog_navigation_steps(4, $wp_query_blog); 
				$src .= ewf_sc_blog_navigation_pages(4, $wp_query_blog); 
			}
		}
			
			
		return $src;
	}	

 
	function ewf_comments( $comment, $args, $depth ) {
		$GLOBALS['comment'] = $comment;
		switch ( $comment->comment_type ) :
			case '' :
		?>
		<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
			<div class="comment-body">
				
				<div class="comment-author vcard">
					<?php echo get_avatar( $comment, 80 ); ?>
					<strong><?php comment_author();  ?></strong>
					<span class="says">says:</span>
				</div>
					
				<div class="comment-meta commentmetadata">
					<span class="date"><?php comment_date('d M Y'); ?></span> 
					<span class="comment-reply"> <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ) ?> </span>
					<?php 
					
						edit_comment_link( __( 'Edit', EWF_SETUP_THEME_DOMAIN ), ' ' );
					
					?>
				</div>
				
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em><?php _e( 'Your comment is awaiting moderation.', EWF_SETUP_THEME_DOMAIN ); ?></em>
				<?php endif; ?>
				
				<?php comment_text(); ?>
				
				<?php ?>
			</div> 
		<?php
				break;
			case 'pingback'  :
			case 'trackback' :
		?>
		
		<li class="post pingback">
			<p><?php _e( 'Pingback:', EWF_SETUP_THEME_DOMAIN ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('Edit', EWF_SETUP_THEME_DOMAIN), ' ' ); ?></p>
		<?php
				break;
		endswitch;
	}


?>