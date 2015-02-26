<?php
/**
 * Plugin Name: WDS Customizer CSS
 * Plugin URI: http://webdevstudios.com
 * Description: Adds the ability to easily customize a site.
 * Author: WebDevStudios
 * Author URI: http://webdevstudios.com
 * Version: 1.0.0
 * License: GPLv2
 * Text Domain: wds-customizer-css
 * Domain Path: languages
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'WDS_Custom_CSS' ) ) {

	class WDS_Custom_CSS {

		/**
		 * Construct function to get things started.
		 */
		public function __construct() {

			// Setup some base variables for the plugin
			$this->basename       = plugin_basename( __FILE__ );
			$this->directory_path = plugin_dir_path( __FILE__ );
			$this->directory_url  = plugins_url( dirname( $this->basename ) );

			// Load Textdomain
			load_plugin_textdomain( 'wds-customizer-css', false, dirname( $this->basename ) . '/languages' );
		}

		public function include_scripts() {
			wp_enqueue_script( 'wds-customizer-css-js', plugins_url( '/js/wds-customizer-css.js',  __FILE__ ), array( 'jquery', 'customize-preview' ), '1.0.0', true );
		}

		/**
		 * Register CPTs & taxonomies.
		 */
		public function do_hooks() {
			add_action( 'customize_register', array( $this, 'init_customizer' ) );
			add_action( 'wp_head', array( $this, 'add_styles' ) );
			add_action( 'customize_preview_init', array( $this, 'include_scripts' ) );
			add_action( 'admin_menu', array( $this, 'add_menu_page' ) );
		}

		public function init_customizer( $wp_customize ) {
			require_once $this->directory_path . '/includes/custom-control.php';

			$wp_customize->add_setting( 'wds_custom_css', array(
				'default' => '',
				'transport' => 'postMessage',
				)
			);
			$wp_customize->add_section( 'wds_custom_css_section' , array(
				'title'      => __( 'Custom CSS', 'wds-customizer-css' ),
				'priority'   => 30,
			) );

			$wp_customize->add_control( new WDS_Custom_CSS_Textarea_Control( $wp_customize, 'wds_custom_css', array(
				'label'      => __( 'Custom CSS', 'wds-customizer-css' ),
				'section'    => 'wds_custom_css_section',
				'settings'   => 'wds_custom_css',
				// 'type'       => 'textarea',
			) ) );

		}

		public function add_styles() {
			?>
			<!-- Begin Custom CSS --><style type="text/css" id="wds-customizer-css">
			<?php echo strip_tags( get_theme_mod( 'wds_custom_css', '' ) ); ?>
			</style><!-- End Custom CSS -->
			<?php
		}

		public function add_menu_page() {
			add_submenu_page( 'themes.php', __( 'Custom CSS', 'wds-customizer-css' ), __( 'Custom CSS', 'wds-customizer-css' ), 'edit_theme_options', 'wds-customizer-css', array( $this, 'custom_css_page' ) );
		}

		public function custom_css_page() {
			if( ! empty( $_POST[ 'wds_custom_css' ] ) ) {
				check_admin_referer( 'wds_custom_css_nonce' );

				if( isset ( $_POST[ 'wds_custom_css' ] ) ) {
					set_theme_mod( 'wds_custom_css', strip_tags( $_POST[ 'wds_custom_css' ] ) );
				}
			}

			$wds_custom_css = get_theme_mod( 'wds_custom_css' );

			echo "<h2>" .  __( 'WDS Custom CSS', 'wds-customizer-css' ) . "</h2>";
			echo "<a href=" . admin_url( 'customizer.php' ) . ">" . __( 'Want to see a real-time preview? Edit in the Customizer.', 'wds-customizer-css' ) . "</a>";
			echo "<form method='POST'>";

			wp_nonce_field( 'wds_custom_css_nonce' );

			echo "<table class='form-table'>\n";
			echo "<tr><th>" . __( 'Custom CSS', 'wds-customizer-css' ) . "</th><td><textarea  rows='25' cols='100' name='wds_custom_css'>{$wds_custom_css}</textarea></td></tr>\n";
			echo "</td></tr>\n";
			echo "</table>";
			echo "<p><input type='submit' class='button-primary' value='" .__( 'Save', 'wds-customizer-css' ). "' /></p></form>";
		}

	}

	$_GLOBALS['WDS_Custom_CSS'] = new WDS_Custom_CSS;
	$_GLOBALS['WDS_Custom_CSS']->do_hooks();
}
