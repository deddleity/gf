<?php

add_action( 'genesis_meta', 'optimal_home_genesis_meta' );
/**
 * Add widget support for homepage. If no widgets active, display the default loop.
 *
 */
function optimal_home_genesis_meta() {

	if ( is_active_sidebar( 'slider' ) || is_active_sidebar( 'welcome' ) || is_active_sidebar( 'home-feature-sidebar' ) || is_active_sidebar( 'home-feature-1' ) || is_active_sidebar( 'home-feature-2' ) || is_active_sidebar( 'home-bottom-sidebar' ) || is_active_sidebar( 'home-featured-posts' ) || is_active_sidebar( 'home-bottom-message' ) ) {

		remove_action( 'genesis_loop', 'genesis_do_loop' );
		add_action( 'genesis_after_header', 'optimal_home_loop_helper_top' );
		add_action( 'genesis_loop', 'optimal_home_loop_helper_middle' );		
		add_action( 'genesis_loop', 'optimal_home_loop_helper' );
		add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

	}
}

/**
 * Display widget content for "slider" and "welcome" sections.
 *
 */
function optimal_home_loop_helper_top() {
			
		if ( is_active_sidebar( 'slider' ) ) {
			echo '<div class="slider-wrap"><div class="slider-inner">';
			dynamic_sidebar( 'slider' );
			echo '</div><!-- end .slider-wrap --></div><!-- end .slider-inner -->';
		}
		
		if ( is_active_sidebar( 'welcome' ) ) {
			echo '<div class="welcome-wrap"><div class="welcome-inner">';
			dynamic_sidebar( 'welcome' );
			echo '</div><!-- end .welcome-wrap --></div><!-- end .welcome-inner -->';
		}
		
}

/**
 * Display widget content for "Home Feature" sections.
 *
 */
function optimal_home_loop_helper_middle() {

		echo '<div class="home-feature-wrap">';
			
		if ( is_active_sidebar( 'home-feature-sidebar' ) ) {
			echo '<div class="home-feature-sidebar">';
			dynamic_sidebar( 'home-feature-sidebar' );
			echo '</div><!-- end .home-feature-sidebar -->';
		}
		
		echo '<div class="home-feature-section">';
		
		if ( is_active_sidebar( 'home-feature-1' ) ) {
			echo '<div class="home-feature-1">';
			dynamic_sidebar( 'home-feature-1' );
			echo '</div><!-- end .home-feature-1 -->';
		}		
		
		if ( is_active_sidebar( 'home-feature-2' ) ) {
			echo '<div class="home-feature-2">';
			dynamic_sidebar( 'home-feature-2' );
			echo '</div><!-- end .home-feature-2 -->';
		}
		
		echo '</div><!-- end #home-feature-section --></div><!-- end #home-feature-wrap -->';
		
}

/**
 * Display widget content for "home bottom sidebar", "home featured posts", and "home bottom message" sections.
 *
 */
function optimal_home_loop_helper() {

		echo '<div class="home-bottom">';

		if ( is_active_sidebar( 'home-bottom-sidebar' ) ) {
			echo '<div class="home-bottom-sidebar">';
			dynamic_sidebar( 'home-bottom-sidebar' );
			echo '</div><!-- end .home-bottom-sidebar -->';
		}
		
		if ( is_active_sidebar( 'home-featured-posts' ) ) {
			echo '<div class="home-featured-posts">';
			dynamic_sidebar( 'home-featured-posts' );
			echo '</div><!-- end .home-featured-posts -->';
		}			
		
		echo '</div><!-- end #home-bottom -->';
		
		if ( is_active_sidebar( 'home-bottom-message' ) ) {
			echo '<div class="home-bottom-message">';
			dynamic_sidebar( 'home-bottom-message' );
			echo '</div><!-- end .home-bottom-message -->';
		}	
		
}

genesis();