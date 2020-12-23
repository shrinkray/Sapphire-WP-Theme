<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/> 
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1,requiresActiveX=true">
	<meta name="robots" content="index,follow">
    <meta name="google-site-verification" content="WVejzaD6JpbIW-HzlrUx_AtjuAYcihLf3iFYbR2Fj_g" />
	
	<title><?php if(is_home()) { echo bloginfo("name"); echo " :: "; echo bloginfo("description"); } else { echo wp_title(" :: ", false, "right"); echo bloginfo("name"); } ?></title>
	
    <!-- /// Favicons ////////  -->
	<?php
		$favicon = get_option(EWF_SETUP_THNAME."_favicon", get_template_directory_uri().'/favicon.png');
		echo '<link rel="shortcut icon" href="'.$favicon.'" />';
	?>

	<?php wp_head(); 

// New Google ReCaptcha V3 Script (below), 12-16-2018 //

?>
<style>#info-area{overflow:hidden;}#info-area::after{clear:both; content:' '; display:block}#info-area>*{width:819px; float:left; margin:0}#info-area>#info-areas{margin-left:-819px; background-color:rgb(51, 51, 51); width:100%}</style>
	<script src="https://www.google.com/recaptcha/api.js?render=6LeZOYIUAAAAAHA_6ZOJ5MWfhX0GzvBfauwVwCYh"></script>
  <script>
  grecaptcha.ready(function() {
      grecaptcha.execute('6LeZOYIUAAAAAHA_6ZOJ5MWfhX0GzvBfauwVwCYh', {action: 'homepage'}).then(function(token) {
         
      });
  });
  </script>

	
</head>
<body <?php body_class(); ?>> 

<!-- Google Analytics Code -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-35868397-1', 'auto');
  ga('send', 'pageview');
</script>
<!-- End Google Analytics Code -->

<?php
	
	$siteUrl = get_site_url();

?>
<!-- Sales Force Tracking Script -->
<script type="text/javascript" language="JavaScript" src="<?php echo $siteUrl ?>/js/frs-app-96429.js"></script>
<script type="text/javascript"></script>

<!-- 

8-9-18 GM:  This was found inside frs-app-96429.js script tags:   frt(96429); ... it was removed
8-10-18 GM: Changed link from src="//links.plan2winsoftware.com/js/frs-app-96429.js" ... reason due to console error generated from SSL issue

End Sales Force Script -->

	<div id="wrap">
	
    	<div id="header-top">
        
        <!-- /// HEADER TOP  //////////////////////////////////////////////////////////////////////////////////////////////////////// -->
        
            <div class="ewf-row">
                <div class="ewf-span6" id="header-top-widget-area-1">
				<?php
					
					if (is_active_sidebar('header-left')){
						dynamic_sidebar('header-left');
					}else{
						echo __('Header widget area left', EWF_SETUP_THEME_DOMAIN);
					}
					
				?>
                </div><!-- end .span6 -->

                <div class="ewf-span6 text-right" id="header-top-widget-area-2">
				<?php
					
					if (is_active_sidebar('header-right')){
						dynamic_sidebar('header-right');
					}else{
						echo __('Header widget area right', EWF_SETUP_THEME_DOMAIN);
					}
					
				?>
                </div><!-- end .span6 -->
            </div><!-- end .row -->
            
        <!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
            
        </div><!-- end #header-top -->
		
		<div id="header">
		
		<!-- /// HEADER  //////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

			<div class="ewf-row">
				<div class="ewf-span3">
				
					<!-- // Logo // -->
					<?php 
									
						if (get_option(EWF_SETUP_THNAME."_logo_url",null) != null){
							$logo_url = get_option(EWF_SETUP_THNAME."_logo_url");
						}else{
							$logo_url = get_template_directory_uri().'/layout/images/logo.png';
						}
						
						echo '<a href="'.get_bloginfo('url').'" id="logo">
								<img class="responsive-img" src="'.$logo_url.'" alt="" data-no-lazy="1" >
							</a><!-- end #logo -->';
							
					?>		

				</div><!-- end .span4 -->
				<div class="ewf-span9">
				
                	<div id="mobile-menu-trigger">
                    	<i class="fa fa-bars"></i>
                    </div>
									
					<!-- // Menu // -->
					<?php  	do_action('ewf-menu-top'); ?>
									
				</div><!-- end .span8 -->
			</div><!-- end .row -->		

		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

		
		</div><!-- end #header -->
		<div id="content">

		<!-- /// CONTENT  //////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		
		<?php	
		
			#	Load page header
			#				
			get_template_part('framework/modules/ewf-header/templates/page-header');  
		
		?>
	