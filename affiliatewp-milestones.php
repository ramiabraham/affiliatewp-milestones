<?php
/**
 * Plugin Name: AffiliateWP - Milestones
 * Plugin URI: https://affiliatewp.com
 * Description: Add milestone notifications to AffiliateWP
 * Author: AffiliateWP
 * Author URI: http://affiliatewp.com
 * Version: 1.0
 * Text Domain: affiliatewp-milestones
 * Domain Path: languages
 *
 * AffiliateWP is distributed under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * AffiliateWP is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with AffiliateWP. If not, see <http://www.gnu.org/licenses/>.
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'AffiliateWP_Milestones' ) ) {

	final class AffiliateWP_Milestones {

		/**
		 * Holds the instance
		 *
		 * Ensures that only one instance of AffiliateWP_Milestones exists in memory at any one
		 * time and it also prevents needing to define globals all over the place.
		 *
		 * TL;DR This is a static property property that holds the singleton instance.
		 *
		 * @var object
		 * @static
		 * @since 1.0
		 */
		private static $instance;


		/**
		 * The version number of AffiliateWP - Zapier
		 *
		 * @since 1.0
		 */
		private $version = '1.0';

		/**
		 * Main AffiliateWP_Milestones Instance
		 *
		 * @since 1.0
		 * @static var array $instance
		 * @return The one true AffiliateWP_Milestones
		 */
		public static function instance() {

			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof AffiliateWP_Milestones ) ) {

				self::$instance = new AffiliateWP_Milestones;
				self::$instance->setup_constants();
				self::$instance->load_textdomain();
				self::$instance->includes();
				self::$instance->hooks();
			}

			return self::$instance;
		}

		/**
		 * Throw error on object clone
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @since 1.0
		 * @access protected
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'affiliatewp-milestones' ), '1.0' );
		}

		/**
		 * Disable unserializing of the class
		 *
		 * @since 1.0
		 * @access protected
		 * @return void
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'affiliatewp-milestones' ), '1.0' );
		}

		/**
		 * Constructor Function
		 *
		 * @since 1.0
		 * @access private
		 */
		private function __construct() {
			self::$instance = $this;
		}

		/**
		 * Reset the instance of the class
		 *
		 * @since 1.0
		 * @access public
		 * @static
		 */
		public static function reset() {
			self::$instance = null;
		}

		/**
		 * Setup plugin constants
		 *
		 * @access private
		 * @since 1.0
		 * @return void
		 */
		private function setup_constants() {
			// Plugin version
			if ( ! defined( 'AFFWP_MILESTONES_VERSION' ) ) {
				define( 'AFFWP_MILESTONES_VERSION', $this->version );
			}

			// Plugin Folder Path
			if ( ! defined( 'AFFWP_MILESTONES_PLUGIN_DIR' ) ) {
				define( 'AFFWP_MILESTONES_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin Folder URL
			if ( ! defined( 'AFFWP_MILESTONES_PLUGIN_URL' ) ) {
				define( 'AFFWP_MILESTONES_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin Root File
			if ( ! defined( 'AFFWP_MILESTONES_PLUGIN_FILE' ) ) {
				define( 'AFFWP_MILESTONES_PLUGIN_FILE', __FILE__ );
			}
		}

		/**
		 * Loads the plugin language files
		 *
		 * @access public
		 * @since 1.0
		 * @return void
		 */
		public function load_textdomain() {

			// Set filter for plugin's languages directory
			$lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';
			$lang_dir = apply_filters( 'affiliatewp_milestones_languages_directory', $lang_dir );

			// Traditional WordPress plugin locale filter
			$locale   = apply_filters( 'plugin_locale',  get_locale(), 'affiliatewp-milestones' );
			$mofile   = sprintf( '%1$s-%2$s.mo', 'affiliatewp-milestones', $locale );

			// Setup paths to current locale file
			$mofile_local  = $lang_dir . $mofile;
			$mofile_global = WP_LANG_DIR . '/affiliatewp-milestones/' . $mofile;

			if ( file_exists( $mofile_global ) ) {
				// Look in global /wp-content/languages/affiliatewp-milestones/ folder
				load_textdomain( 'affiliatewp-milestones', $mofile_global );
			} elseif ( file_exists( $mofile_local ) ) {
				// Look in local /wp-content/plugins/affiliatewp-milestones/languages/ folder
				load_textdomain( 'affiliatewp-milestones', $mofile_local );
			} else {
				// Load the default language files
				load_plugin_textdomain( 'affiliatewp-milestones', false, $lang_dir );
			}
		}

		/**
		 * Include necessary files
		 *
		 * @access      private
		 * @since       1.0
		 * @return      void
		 */
		private function includes() {
			require_once AFFWP_MILESTONES_PLUGIN_DIR . 'includes/class-admin.php';

			// Check that Zapier is enabled
			if( ! affiliate_wp()->settings->get( 'enable_milestones' ) ) {
				return;
			}

			require_once AFFWP_MILESTONES_PLUGIN_DIR . 'includes/class-affwp-milestones-endpoint.php';
		}

		/**
		 * Setup the default hooks and actions
		 *
		 * @since 1.0
		 * @return void
		 */
		private function hooks() {
			register_activation_hook( AFFWP_MILESTONES_PLUGIN_FILE, array( $this, 'flush' ) );
		}


		/**
		 * Determine if the user is on version 1.8 of AffiliateWP
		 *
		 * @todo   Set minimum version to 1.9
		 *
		 * @since  1.0
		 * @return boolean
		 */
		public function has_1_9() {

			$return = true;

			if ( version_compare( AFFILIATEWP_VERSION, '1.9', '<' ) ) {
				$return = false;
			}

			return $return;
		}

		/**
		 * Flushes rewrite rules on activation.
		 *
		 * @since  1.0
		 *
		 * @return void
		 */
		public function flush() {
			flush_rewrite_rules();
		}
	}
}
/**
 * The main function responsible for returning the one true AffiliateWP_Milestones
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $affiliatewp_milestones = affiliatewp_milestones(); ?>
 *
 * @since 1.0
 * @return object The one true AffiliateWP_Milestones Instance
 */
function affiliatewp_milestones() {
	if ( ! class_exists( 'Affiliate_WP' ) ) {
		if ( ! class_exists( 'AffiliateWP_Activation' ) ) {
			require_once 'includes/class-activation.php';
		}

		$activation = new AffiliateWP_Activation( plugin_dir_path( __FILE__ ), basename( __FILE__ ) );
		$activation = $activation->run();
	} else {
		return AffiliateWP_Milestones::instance();
	}
}
add_action( 'plugins_loaded', 'affiliatewp_milestones', 100 );
