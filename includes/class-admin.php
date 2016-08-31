<?php

/**
 * The AffiliateWP_Milestones_Admin class.
 *
 * Creates AffilaiteWP settings options for the AffiliateWP Milestones add-on.
 */
class AffiliateWP_Milestones_Admin {

	/**
	 * Get things started
	 *
	 * @access public
	 * @since 1.0
	 * @return void
	 */
	public function __construct() {
		add_filter( 'affwp_settings_tabs', array( $this, 'register_settings_tab' ) );
		add_filter( 'affwp_settings', array( $this, 'register_settings' ) );

		// Add milestone notifications
		add_action( 'admin_footer', array( $this, 'milestone_notice'    ) );

		add_action('admin_enqueue_scripts', array( $this, 'scripts' ) );
	}

	/**
	 * Register the Milestones settings tab
	 *
	 * @access public
	 * @since  1.0
	 * @return array The new tab name
	 */
	public function register_settings_tab( $tabs = array() ) {

		$tabs['milestones'] = __( 'Milestones', 'affiliatewp-milestones' );

		return $tabs;
	}

	/**
	 * Add our settings
	 *
	 * @access public
	 * @since  1.0
	 * @param  array $settings The existing settings
	 * @return array $settings The updated settings
	 */
	public function register_settings( $settings = array() ) {

		$settings[ 'milestones' ] = array(
			'enable_milestones' => array(
				'name' => __( 'Enable Milestones', 'affiliatewp-milestones' ),
				'desc' => __( 'Check this box to enable Milestones', 'affiliatewp-milestones' ),
				'type' => 'checkbox'
			),
			'affwp_milestones_affiliates' => array(
				'name' => __( 'Enable referral milestones', 'affiliatewp-milestones' ),
				'desc' => __( 'Check to enable', 'affiliatewp-milestones' ),
				'type' => 'checkbox'
			),
			'affwp_milestones_referrals' => array(
				'name' => __( 'Enable affiliate milestones', 'affiliatewp-milestones' ),
				'desc' => __( 'Check to enable', 'affiliatewp-milestones' ),
				'type' => 'checkbox'
			),
			'affwp_milestones_creatives' => array(
				'name' => __( 'Enable visit milestones', 'affiliatewp-milestones' ),
				'desc' => __( 'Check to enable', 'affiliatewp-milestones' ),
				'type' => 'checkbox'
			),
			'affwp_milestones_visits' => array(
				'name' => __( 'Enable payouts milestones', 'affiliatewp-milestones' ),
				'desc' => __( 'Check to enable', 'affiliatewp-milestones' ),
				'type' => 'checkbox'
			),
			'affwp_milestones_payouts' => array(
				'name' => __( 'Enable creatives milestones', 'affiliatewp-milestones' ),
				'desc' => __( 'Check to enable', 'affiliatewp-milestones' ),
				'type' => 'checkbox'
			),

		);

		return $settings;
	}

	/**
	 * Scripts
	 *
	 * @since 1.0
	 * @return void
	 */
	public function scripts() {
		wp_register_style( 'affwp-milestones-css', AFFWP_MILESTONES_PLUGIN_URL . 'includes/assets/css/affwp-milestones.css', array(), false, false );
		wp_register_script( 'affwp-milestones-js', AFFWP_MILESTONES_PLUGIN_URL . 'includes/assets/js/affwp-milestones.js', array( 'jquery' ), false, true );

		if ( affwp_is_admin_page() ) {
			wp_enqueue_style( 'affwp-milestones-css' );
			wp_enqueue_script( 'affwp-milestones-js' );
		}
	}

	/**
	 * Milestone notice for affiliates
	 *
	 * @since  1.0
	 *
	 * @return void  [description]
	 */
	public function milestone_notice_affiliates() {
		if ( ! affwp_is_admin_page() ) {
			return;
		}

	}

	/**
	 * Milestone notice for affiliates
	 *
	 * @since  1.0
	 *
	 * @return void  [description]
	 */
	public function milestone_notice_referrals() {
		if ( ! affwp_is_admin_page() ) {
			return;
		}

	}

	/**
	 * Milestone notice for affiliates
	 *
	 * @since  1.0
	 *
	 * @return void  [description]
	 */
	public function milestone_notice_visits() {
		if ( ! affwp_is_admin_page() ) {
			return;
		}

	}

	/**
	 * Milestone notice for affiliates
	 *
	 * @since  1.0
	 *
	 * @return void  [description]
	 */
	public function milestone_notice_creatives() {
		if ( ! affwp_is_admin_page() ) {
			return;
		}

	}

	/**
	 * Milestone notice for affiliates
	 *
	 * @since  1.0
	 *
	 * @return void  [description]
	 */
	public function milestone_notice_payouts() {
		if ( ! affwp_is_admin_page() ) {
			return;
		}

	}

	/**
	 * Notice for affiliates
	 *
	 * @since  1.0
	 *
	 * @return void  [description]
	 */
	public function milestone_notice() {
		if ( ! affwp_is_admin_page() ) {
			return;
		}

		$type = '';
		$screen    = get_current_screen();
		$screen_id = $screen->id;

		switch ( $screen_id ) {
			case 'affiliates_page_affiliate-wp-affiliates':
				$type = 'affiliates';
				# code...
				break;
			case 'affiliates_page_affiliate-wp-referrals':
				$type = 'referrals';
				# code...
				break;
			case 'affiliates_page_affiliate-wp-visits':
				$type = 'visits';
				# code...
				break;
			case 'affiliates_page_affiliate-wp-creatives':
				$type = 'creatives';
				# code...
				break;
			case 'affiliates_page_affiliate-wp-payouts':
				$type = 'payouts';
				# code...
				break;
			default:
				break;
		}

?>
	<script>
	jQuery(document).ready(function($) {
		$.ajax({
				url: '<?php echo get_site_url(); ?>' + '/wp-json/affwp/v1/milestones',
				type: 'get',
				data: {},
				success: function ( milestones ) {
					console.log( milestones.<?php echo $type; ?> );

					var type = milestones.<?php echo $type; ?>;

					if ( type === 6 ) {
						$('.affwp-milestones-notice').show();
						$('.affwp-milestones-notice').append('<div class="affwp-milestones-<?php echo $type; ?> ten"><h1>Congratulations on your tenth affiliate!</h1></div>');
					} else {
						$('.affwp-milestones-notice').hide();
					}
				}
		});
	});
	</script>

	<div class="affwp-milestones-notice"></div>
<?php

	}

}
new AffiliateWP_Milestones_Admin;
