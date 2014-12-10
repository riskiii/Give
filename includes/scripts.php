<?php
/**
 * Scripts
 *
 * @package     Give
 * @subpackage  Functions
 * @copyright   Copyright (c) 2014, WordImpress
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load Scripts
 *
 * Enqueues the required scripts.
 *
 * @since 1.0
 * @global $give_options
 * @global $post
 * @return void
 */
function give_load_scripts() {

}

add_action( 'wp_enqueue_scripts', 'give_load_scripts' );

/**
 * Register Styles
 *
 * Checks the styles option and hooks the required filter.
 *
 * @since 1.0
 * @global $give_options
 * @return void
 */
function give_register_styles() {

}

add_action( 'wp_enqueue_scripts', 'give_register_styles' );

/**
 * Load Admin Scripts
 *
 * Enqueues the required admin scripts.
 *
 * @since 1.0
 * @global       $post
 *
 * @param string $hook Page hook
 *
 * @return void
 */
function give_load_admin_scripts( $hook ) {

	if ( ! apply_filters( 'give_load_admin_scripts', give_is_admin_page(), $hook ) ) {
		return;
	}

	global $wp_version, $post;

	$js_dir  = GIVE_PLUGIN_URL . 'assets/js/';
	$css_dir = GIVE_PLUGIN_URL . 'assets/css/';

	// Use minified libraries if SCRIPT_DEBUG is turned off
	$suffix  = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_script( 'give-admin-scripts', $js_dir . 'admin-scripts' . $suffix . '.js', array( 'jquery' ), GIVE_VERSION, false );
	wp_localize_script( 'give-admin-scripts', 'give_vars', array(
		'post_id'                 => isset( $post->ID ) ? $post->ID : null,
	));

	wp_enqueue_style( 'give-admin', $css_dir . 'give-admin' . $suffix . '.css', GIVE_VERSION );


}

add_action( 'admin_enqueue_scripts', 'give_load_admin_scripts', 100 );

/**
 * Admin Downloads Icon
 *
 * Echoes the CSS for the Give post type icon.
 *
 * @since 1.0
 * @global $post_type
 * @global $wp_version
 * @return void
 */
function give_admin_downloads_icon() {
	global $wp_version;

	$menu_icon = '\f507';

	?>
	<style type="text/css" media="screen">
		<?php if( version_compare( $wp_version, '3.8-RC', '>=' ) || version_compare( $wp_version, '3.8', '>=' ) ) { ?>
		#adminmenu #menu-posts-give_forms .wp-menu-image:before {
			content: '<?php echo $menu_icon; ?>';
		}
		<?php }  ?>

	</style>
<?php
}

add_action( 'admin_head', 'give_admin_downloads_icon' );