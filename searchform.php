<?php
	/*
	 * Search form adapted from 2017 theme
	*/
	$unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<form method="get" id="searchform" class="form-inline my-2 my-lg-0" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" id="<?php echo $unique_id; ?>" class="form-control mr-sm-2"
		   placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'sapphire-wp' ); ?>" <?php echo get_search_query(); ?>
		   name="s">
	<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
</form>
