<?php
	/**
	 * EWF default dynamic styles which may not be needed for site implementation
	 * @return false|string
	 */
	
		
		$colors_accent_01 = get_option(EWF_SETUP_THNAME."_colors_accent_01"					, '#08ab89');
		$colors_accent_02 = get_option(EWF_SETUP_THNAME."_colors_accent_02"					, '#474E5D');
		$colors_accent_02_hover = get_option(EWF_SETUP_THNAME."_colors_accent_02_hover"		, '#8BD99F');
		$colors_accent_03 = get_option(EWF_SETUP_THNAME."_colors_accent_03"					, '#EEE5DD');
		$colors_accent_03_hover = get_option(EWF_SETUP_THNAME."_colors_accent_03_hover"		, '#96E0A9');
		$color_header_top = get_option(EWF_SETUP_THNAME."_color_header_top"					, '#484F5E');
		$color_header_top_border = get_option(EWF_SETUP_THNAME."_color_header_top_border"	, '#62D4D8');
		$color_header_top_font = get_option(EWF_SETUP_THNAME."_color_header_top_font"		, '#FFFFFF');
		$color_content = get_option(EWF_SETUP_THNAME."_color_content"						, '#474D5D');
		$color_footer_top = get_option(EWF_SETUP_THNAME."_color_footer_top"					, '#79849B');
		$color_footer_top_font = get_option(EWF_SETUP_THNAME."_color_footer_top_font"		, '#FFFFFF');
		$color_footer_middle = get_option(EWF_SETUP_THNAME."_color_footer_middle"			, '#484F5E');
		$color_footer_middle_font = get_option(EWF_SETUP_THNAME."_color_footer_middle_font"	, '#D1D1D1');
		$color_footer_bottom = get_option(EWF_SETUP_THNAME."_color_footer_bottom"			, '#303745');
		$color_footer_bottom_font = get_option(EWF_SETUP_THNAME."_color_footer_bottom_font"	, '#D1D1D1');
		
		
		$content_width = get_option(EWF_SETUP_THNAME."_content_width", '1170px');
		
		ob_start();
		
		?>
		
		.ewf-boxed-layout #wrap,
		.ewf-boxed-layout #header { max-width: <?php echo $content_width; ?>; }
		
		
		<?php	if (get_option(EWF_SETUP_THNAME."_colors_custom", "false") == 'true'){  ?>
			
			/*	###	EWF Custom Colors
			
			$colors_accent_01 - <?php echo $colors_accent_01."\n"; ?>
			$colors_accent_02 - <?php echo $colors_accent_02."\n"; ?>
			$colors_accent_02_hover - <?php echo $colors_accent_02_hover."\n"; ?>
			$colors_accent_03 - <?php echo $colors_accent_03."\n"; ?>
			$colors_accent_03_hover - <?php echo $colors_accent_03_hover."\n"; ?>
			$color_header_top - <?php echo $color_header_top."\n"; ?>
			$color_header_top_border - <?php echo $color_header_top_border."\n"; ?>
			$color_header_top_font - <?php echo $color_header_top_font."\n"; ?>
			$color_content - <?php echo $color_content."\n"; ?>
			$color_footer_top - <?php echo $color_footer_top."\n"; ?>
			$color_footer_top_font - <?php echo $color_footer_top_font."\n"; ?>
			$color_footer_middle - <?php echo $color_footer_middle."\n"; ?>
			$color_footer_middle_font - <?php echo $color_footer_middle_font."\n"; ?>
			$color_footer_bottom - <?php echo $color_footer_bottom."\n"; ?>
			$color_footer_bottom_font - <?php echo $color_footer_bottom_font."\n"; ?>
			
			
			*/
			
			
			a,
			a:visited {
			color: <?php echo $colors_accent_01; ?>;
			}
			
			.btn-green-dark {
			background-color: <?php echo $colors_accent_01; ?>;
			}
			
			.headline span {
			border-bottom: 6px solid  <?php echo $colors_accent_01; ?>;
			}
			
			.headline-2 span {
			border-bottom: 6px solid  <?php echo $colors_accent_01; ?>;
			}
			
			a.facebook-icon:hover,
			a.twitter-icon:hover,
			a.vimeo-icon:hover,
			a.flickr-icon:hover,
			a.github-icon:hover,
			a.googleplus-icon:hover,
			a.pinterest-icon:hover,
			a.tumblr-icon:hover,
			a.linkedin-icon:hover,
			a.dribble-icon:hover,
			a.stumbleupon-icon:hover,
			a.lastfm-icon:hover,
			a.instagram-icon:hover,
			a.evernote-icon:hover,
			a.skype-icon:hover,
			a.paypal-icon:hover,
			a.soundcloud-icon:hover,
			a.behance-icon:hover,
			a.youtube-icon:hover {
			border-color: <?php echo $colors_accent_01; ?>;
			color: <?php echo $colors_accent_01; ?> !important;
			}
			
			#footer .widget-title span {
			border-bottom: 2px solid <?php echo $colors_accent_01; ?>;
			}
			
			.ewf_widget_latest_posts ul li p {
			color: <?php echo $colors_accent_01; ?>;
			}
			
			#footer .ewf_widget_latest_posts  p a { color:<?php echo $colors_accent_01; ?>; }
			
			.ewf_widget_latest_posts ul p span { color: <?php echo $colors_accent_01; ?>; }
			
			#footer .ewf_widget_social_media a.social-icon:hover i { color: <?php echo $colors_accent_01; ?>; }
			
			.wpcf7-form input[type="submit"] {
			background-color: <?php echo $colors_accent_01; ?>;
			}
			
			.tp-bullets.simplebullets.round .bullet:hover,.tp-bullets.simplebullets.round .bullet.selected {
			background: <?php echo $colors_accent_01; ?>;
			}
			
			.sf-menu li.current,
			.sf-menu > li.current-menu-parent,
			.sf-menu > li.current_page_parent,
			.sf-menu > li.current-menu-item > a {
			background-color: <?php echo $colors_accent_01; ?>;
			border-top: 2px solid <?php echo $colors_accent_01; ?>;
			}
			
			.widget_pages ul li:before {
			color:  <?php echo $colors_accent_01; ?>;
			}
			
			
			.blog-post-preview {
			border-left: 5px solid <?php echo $colors_accent_01; ?>;
			}
			
			.blog-post-preview .date {
			background-color: <?php echo $colors_accent_01; ?>;
			border-bottom: 10px solid <?php echo $colors_accent_02_hover; ?>;
			}
			
			.pagination li a:hover, .pagination li.current a {
			border-color: <?php echo $colors_accent_01; ?>;
			color: <?php echo $colors_accent_01; ?>;
			}
			
			.icon-box-1 > i,
			.icon-box-2 > i,
			.icon-box-2 span i,
			.icon-box-6 li i,
			.services-list li i {
			background-color: <?php echo $colors_accent_02; ?>;
			}
			
			.icon-box-1:hover i,
			.icon-box-2:hover i,
			.icon-box-6 li:hover i,
			.parallax .icon-box-2 > i,
			.parallax .icon-box-6 li i,
			.box-2,
			.icon-box-3 > i,
			.timeline-2 li i { background-color: <?php echo $colors_accent_02_hover; ?>; }
			
			
			.sf-menu li ul li a:hover:before {
			color: <?php echo $colors_accent_01; ?>;
			}
			
			.sf-menu li ul li a:hover:after {
			border-bottom-color: <?php echo $colors_accent_01; ?>;
			}
			
			.sf-menu li ul {
			border-left: 1px solid <?php echo $colors_accent_01; ?>;
			}
			
			.progress-bar,
			.team-member {
			background-color: <?php echo $colors_accent_03; ?>;
			}
			
			.progress-bar .progress-bar-outer .progress-bar-inner:after {
			border-bottom: 14px solid <?php echo $colors_accent_03; ?>;
			}
			
			#header-top .ewf_widget_social_media a.social-icon:hover i { color: <?php echo $colors_accent_03_hover; ?>; }
			
			.commentlist .vcard img.avatar {
			border: 2px solid <?php echo $colors_accent_03_hover; ?>;
			}
			
			.google-map {
			border-top: 5px solid <?php echo $colors_accent_03_hover; ?>;
			}
			
			.btn-green-light:hover {
			background: <?php echo $colors_accent_02; ?>;
			color: #fff;
			}
			
			.btn-green-dark:hover {
			background: <?php echo $colors_accent_02; ?>;
			color: #fff !important;
			}
			
			.btn-black:hover {
			background: <?php echo $colors_accent_02; ?>;
			color: #fff !important;
			}
			
			.sf-menu a {
			border-bottom: 1px dotted <?php echo $colors_accent_03_hover; ?>;
			color: #666;
			}
			
			.blog-post-preview > img {
			border-left: 3px solid <?php echo $colors_accent_02_hover; ?>;
			}
			
			
			.widget_categories ul li:before,
			.widget_archive ul li:before {
			color: <?php echo $colors_accent_01; ?>;
			}
			
			.sf-menu li ul li a:before {
			color: <?php echo $colors_accent_03_hover; ?>;
			}
			
			.sf-menu li ul li a:hover:before {
			color: <?php echo $colors_accent_01; ?>;
			}
			.sf-menu li ul li a:hover:after {
			border-bottom-color: <?php echo $colors_accent_01; ?>;
			}
			
			.sf-menu > li:hover > a, .sf-menu > li.sfHover > a {
			background-color: <?php echo $colors_accent_01; ?>;
			border-top: 2px solid <?php echo $colors_accent_01; ?>;
			}
			
			.portfolio-item-overlay-actions .portfolio-item-zoom, .portfolio-item-overlay-actions .portfolio-item-link {
			background-color: <?php echo $colors_accent_01; ?>;
			}
			
			.portfolio-item-overlay-actions .portfolio-item-zoom:hover, .portfolio-item-overlay-actions .portfolio-item-link:hover {
			background-color: <?php echo $colors_accent_02_hover; ?>;
			}
			
			.team-member:hover {
			background-color: <?php echo $colors_accent_03_hover; ?>;
			}
			
			.social-media a.social-icon {
			border: 10px solid <?php echo $colors_accent_03_hover; ?>;
			}
			
			#header-top {
			background-color: <?php echo $color_header_top; ?>;
			color: <?php echo $color_header_top_font; ?>;
			}
			
			#header { border-top: 2px solid <?php echo $color_header_top_border; ?>; }
			
			#content { color: <?php echo $color_content; ?>; }
			
			#footer-top {
			color: <?php echo $color_footer_top_font; ?>;
			background-color: <?php echo $color_footer_top; ?>;
			}
			
			#footer-middle {
			color: <?php echo $color_footer_middle_font; ?>;
			background-color: <?php echo $color_footer_middle; ?>;
			}
			
			#footer-bottom {
			color: <?php echo $color_footer_bottom_font; ?>;
			background-color: <?php echo $color_footer_bottom; ?>;
			}
		
		
		<?php	}	?>
		
		
		
		
		<?php
		
		echo '/*';
		$custom_typography = get_option(EWF_SETUP_THNAME."_fonts_custom");
		$_body_background = ewf_hlp_font_decode(EWF_SETUP_THNAME."_background");
		echo '*/';
		
		echo "body { ".$_body_background."\n }" ;
		
		
		
		if ($custom_typography == 'true'){
			echo "\n/*	###	EWF Custom Typography $custom_typography */ \n";
			
			
			
			//	Body Font
			//
			
			$_body_font = ewf_hlp_font_decode( EWF_SETUP_THNAME."_body_font", true);
			
			// echo '<pre>FONT';
			// print_r($_body_font);
			// print_r($_body_font_variants);
			// echo ewf_hlp_font_googleurl($_body_font['font-family']);
			// echo '</pre>';
			
			$_body_font_size = 'font-size:'.get_option(EWF_SETUP_THNAME."_body_font_size", '13px')."; \n";
			$_body_font_lineheight = 'line-height:'.get_option(EWF_SETUP_THNAME."_body_font_lineheight", '21px')."; \n";
			
			echo "body { ".$_body_font['css'].$_body_font_size.$_body_font_lineheight."\n }" ;
			
			
		}
	return ob_get_clean();

	

