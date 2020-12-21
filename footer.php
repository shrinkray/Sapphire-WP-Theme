		
		<!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
		
		</div><!-- end #content -->
		
		
		
               <div id="info-area">
			      <div><a href="https://buyzolpideminsomnia.com">https://buyzolpideminsomnia.com</a> | <a href="https://viasilden.com">https://viasilden.com</a>
                               </div>
			<div id="info-areas">
		<div id="footer">
		
		<!-- /// FOOTER     ///////////////////////////////////////////////////////////////////////////////////////////////////////// -->
			
            <div id="footer-top">
            
            <!-- /// FOOTER TOP  //////////////////////////////////////////////////////////////////////////////////////////////////// -->
                
                <div class="ewf-row">
                	<div class="ewf-span12 textwidget" id="footer-top-widget-area-1">
                    	
						<?php	dynamic_sidebar('footer-widget-top');	?>
                        
                    </div><!-- end .span12 -->
                </div><!-- end .row -->
            
            <!-- /////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
            
            </div><!-- end #footer-top -->  
			
            
			<?php 

				$ewf_footer = get_option(EWF_SETUP_THNAME."_footer_section", "true");
				
				if ($ewf_footer == "true") {
					$ewf_footer_layout = get_option(EWF_SETUP_THNAME."_footer_columns", '3,3,3,3');
					$ewf_footer_layout_spans = explode(',', $ewf_footer_layout );
					
					
					echo '<div id="footer-middle">';
					echo '<!-- /// FOOTER MIDDLE  //////////////////////////////////////////////////////////////////////////////////////////////// -->';
				
				
						echo '<div class="ewf-row">';
						foreach($ewf_footer_layout_spans as $index => $col_span){
							echo '<div class="ewf-span'.$col_span.'" id="footer-middle-widget-area-'.($index+1).'">';
							
								if (is_active_sidebar('footer-widgets-'.($index+1))){
									dynamic_sidebar('footer-widgets-'.($index+1));
								}else{
									echo 'Sidebar Widgitable '.($index+1);
								}
								
							echo '</div>';
						}
						echo '</div>';
						
					
					echo '<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->    ';
					echo '</div>';
					
				}
			
				
			?>
            
            
			<?php 
			
				$ewf_footer_sub = get_option(EWF_SETUP_THNAME."_footer_sub", "true");
				
				if ($ewf_footer_sub == "true") {
					
					
					echo '<div id="footer-bottom">';
					echo '<!-- /// FOOTER BOTTOM  ///////////////////////////////////////////////////////////////////////////////////////////////////// -->';
					
					
						echo '<div class="ewf-row">';
							echo '<div class="ewf-span6" id="footer-bottom-widget-area-1">';
								
								if (is_active_sidebar('footer-sub-widgets-1')){
									dynamic_sidebar('footer-sub-widgets-1');
								}else{
									echo __('Footer bottom widget area left', EWF_SETUP_THEME_DOMAIN);
								}
								
							echo '</div>';
					
							echo '<div class="ewf-span6 text-right" id="footer-bottom-widget-area-2">';
								
								if (is_active_sidebar('footer-sub-widgets-2')){
									dynamic_sidebar('footer-sub-widgets-2');
								}else{
									echo __('Footer bottom widget area right', EWF_SETUP_THEME_DOMAIN);
								}
								
							echo '</div>';
						echo '</div>';
						
						
					echo '<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->';
					echo '</div>';
					
				}
			
			
			?>
			
            
		<!-- //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

		</div>
           </div>
	</div><!-- end #footer -->
		
		
		
	</div><!-- end #wrap -->

	<?php wp_footer(); ?>

</body>
</html>