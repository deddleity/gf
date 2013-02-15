<?php
/** Start the engine */
require_once( get_template_directory() . '/lib/init.php' );

/** Child theme (do not remove) */
define( 'CHILD_THEME_NAME', 'Optimal Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/themes/optimal' );

/** Create additional color style options */
add_theme_support( 'genesis-style-selector', array( 'optimal-black' => 'Black', 'optimal-brown' => 'Brown', 'optimal-dark-blue' => 'Dark Blue', 'optimal-dark-gray' => 'Dark Gray', 'optimal-green' => 'Green', 'optimal-orange' => 'Orange', 'optimal-purple' => 'Purple', 'optimal-red' => 'Red', 'optimal-silver' => 'Silver', ) );

/** Add support for custom background */
add_custom_background();

/** Add new image sizes */
add_image_size( 'featured-image', 620, 320, TRUE );
add_image_size( 'featured-sidebar', 270, 150, TRUE );
add_image_size( 'home-featured-posts', 210, 150, TRUE );
add_image_size( 'portfolio-thumbnail', 210, 150, TRUE );

/** Add Viewport meta tag for mobile browsers */
add_action( 'genesis_meta', 'optimal_viewport_meta_tag' );
function optimal_viewport_meta_tag() {
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0"/>';
}

/** Add support for custom header */
add_theme_support( 'genesis-custom-header', array( 'width' => 960, 'height' => 120 ) );

/** Reposition the Primary Navigation */
remove_action( 'genesis_after_header', 'genesis_do_subnav' ) ;
add_action( 'genesis_before_header', 'genesis_do_subnav' );

/** Before Header Wrap */
add_action('genesis_before_header', 'before_header_wrap');
function before_header_wrap() {
	echo '<div class="head-wrap">';
}

/** After Header Wrap */
add_action('genesis_after_header', 'before_after_wrap');
function before_after_wrap() {
	echo '</div>';
}

/** Add support for 4-column footer widgets */
add_theme_support( 'genesis-footer-widgets', 4 );

/** Add Portfolio Settings box to Genesis Theme Settings */
add_action( 'admin_menu', 'optimal_add_portfolio_settings_box', 11 );
function optimal_add_portfolio_settings_box() {
	global $_genesis_theme_settings_pagehook;
	add_meta_box('genesis-theme-settings-optimal-portfolio', __('Portfolio Page Settings', 'optimal'), 'optimal_theme_settings_portfolio', 	'toplevel_page_genesis', 'column2');
}
	
function optimal_theme_settings_portfolio() {
?>
	<p><?php _e("Display which category:", 'genesis'); ?>
	<?php wp_dropdown_categories(array('selected' => genesis_get_option('optimal_portfolio_cat'), 'name' => GENESIS_SETTINGS_FIELD.'[optimal_portfolio_cat]', 'orderby' => 'Name' , 'hierarchical' => 1, 'show_option_all' => __("All Categories", 'genesis'), 'hide_empty' => '0' )); ?></p>
	
	<p><?php _e("Exclude the following Category IDs:", 'genesis'); ?><br />
	<input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[optimal_portfolio_cat_exclude]" value="<?php echo esc_attr( genesis_get_option('optimal_portfolio_cat_exclude') ); ?>" size="40" /><br />
	<small><strong><?php _e("Comma separated - 1,2,3 for example", 'genesis'); ?></strong></small></p>
	
	<p><?php _e('Number of Posts to Show', 'genesis'); ?>:
	<input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[optimal_portfolio_cat_num]" value="<?php echo esc_attr( genesis_option('optimal_portfolio_cat_num') ); ?>" size="2" /></p>
	
	<p><span class="description"><?php _e('<b>NOTE:</b> The Portfolio Page displays the "Portfolio Page" image size plus the excerpt or full content as selected below.', 'optimal'); ?></span></p>
	
	<p><?php _e("Select one of the following:", 'genesis'); ?>
	<select name="<?php echo GENESIS_SETTINGS_FIELD; ?>[optimal_portfolio_content]">
		<option style="padding-right:10px;" value="full" <?php selected('full', genesis_get_option('optimal_portfolio_content')); ?>><?php _e("Display post content", 'genesis'); ?></option>
		<option style="padding-right:10px;" value="excerpts" <?php selected('excerpts', genesis_get_option('optimal_portfolio_content')); ?>><?php _e("Display post excerpts", 'genesis'); ?></option>
	</select></p>
	
	<p><label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[optimal_portfolio_content_archive_limit]"><?php _e('Limit content to', 'genesis'); ?></label> <input type="text" name="<?php echo GENESIS_SETTINGS_FIELD; ?>[optimal_portfolio_content_archive_limit]" id="<?php echo GENESIS_SETTINGS_FIELD; ?>[optimal_portfolio_content_archive_limit]" value="<?php echo esc_attr( genesis_option('optimal_portfolio_content_archive_limit') ); ?>" size="3" /> <label for="<?php echo GENESIS_SETTINGS_FIELD; ?>[optimal_portfolio_content_archive_limit]"><?php _e('characters', 'genesis'); ?></label></p>
	
	<p><span class="description"><?php _e('<b>NOTE:</b> Using this option will limit the text and strip all formatting from the text displayed. To use this option, choose "Display post content" in the select box above.', 'genesis'); ?></span></p>
<?php
}	

/** Register widget areas */
genesis_register_sidebar( array(
	'id'			=> 'slider',
	'name'			=> __( 'Slider', 'optimal' ),
	'description'	=> __( 'This is the slider section of the homepage.', 'optimal' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'welcome',
	'name'			=> __( 'Welcome', 'optimal' ),
	'description'	=> __( 'This is the welcome section of the homepage.', 'optimal' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-feature-sidebar',
	'name'			=> __( 'Home Feature Sidebar', 'optimal' ),
	'description'	=> __( 'This is the home feature sidebar of the homepage.', 'optimal' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-feature-1',
	'name'			=> __( 'Home Feature #1', 'optimal' ),
	'description'	=> __( 'This is the first column in the middle section of the homepage.', 'optimal' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-feature-2',
	'name'			=> __( 'Home Feature #2', 'optimal' ),
	'description'	=> __( 'This is the second column in the middle section of the homepage.', 'optimal' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-bottom-sidebar',
	'name'			=> __( 'Home Bottom Sidebar', 'optimal' ),
	'description'	=> __( 'This is the left sidebar at the bottom section of the homepage.', 'optimal' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-featured-posts',
	'name'			=> __( 'Home Featured Posts', 'optimal' ),
	'description'	=> __( 'This is the posts column at the bottom section of the homepage.', 'optimal' ),
) );
genesis_register_sidebar( array(
	'id'			=> 'home-bottom-message',
	'name'			=> __( 'Home Bottom Message', 'optimal' ),
	'description'	=> __( 'This is the bottom section of the homepage right before the footer.', 'optimal' ),
) );