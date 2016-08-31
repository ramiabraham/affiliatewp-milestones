<?php
namespace AffWP;

use \AffWP\REST\v1\Controller;
/**
 * Implements REST routes and endpoints for AffiliateWP Milestones.
 *
 * @since 1.0
 *
 * @see AffWP\REST\v1\Controller
 */
class Milestones_Endpoint extends Controller {

	/**
	 * Registers Milestones subscription route.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param \WP_REST_Server $wp_rest_server Server object.
	 */
	public function register_routes( $wp_rest_server ) {
		register_rest_route( $this->namespace, '/milestones/', array(
			'methods' => $wp_rest_server::READABLE,
			'callback' => array(
				$this, 'get_milestones'
				)
		) );
	}

	/**
	 * An endpoint which displays milestones.
	 *
	 * @since  1.0
	 * @access public
	 *
	 * @return array $milestones    The milestones presently active for this site.
	 *
	 */
	public function get_milestones() {
		$milestones = array();

		$ms_affiliates  = affiliate_wp()->settings->get( 'affwp_milestones_affiliates' );
		$ms_referrals   = affiliate_wp()->settings->get( 'affwp_milestones_referrals' );
		$ms_creatives   = affiliate_wp()->settings->get( 'affwp_milestones_creatives' );
		$ms_visits      = affiliate_wp()->settings->get( 'affwp_milestones_visits' );
		$ms_payouts     = affiliate_wp()->settings->get( 'affwp_milestones_payouts' );

		$milestones['affiliates'] = ( $ms_affiliates )  ? $this->affiliates() : '';
		$milestones['referrals']  = ( $ms_referrals )   ? $this->referrals()  : '';
		$milestones['creatives']  = ( $ms_creatives )   ? $this->creatives()  : '';
		$milestones['visits']     = ( $ms_visits )      ? $this->visits()     : '';
		$milestones['payouts']    = ( $ms_payouts )     ? $this->payouts()    : '';

		return $milestones;

	}

	/**
	 * Get affiliate milestones
	 *
	 * @since  1.0
	 *
	 * @return $affiliates The milestones for affiliates
	 */
	public function affiliates() {
		$affiliates = array();

		$affiliates = affiliate_wp()->affiliates->count();

		return $affiliates;
	}

	/**
	 * Get referral milestones
	 *
	 * @since  1.0
	 *
	 * @return $referrals The milestones for referrals
	 */
	public function referrals() {
		$referrals = array();

		$referrals = affiliate_wp()->referrals->count();

		return $referrals;
	}

	/**
	 * Get creative milestones
	 *
	 * @since  1.0
	 *
	 * @return $creatives The milestones for creatives
	 */
	public function creatives() {
		$creatives = array();

		$creatives = affiliate_wp()->creatives->count();

		return $creatives;
	}

	/**
	 * Get visit milestones
	 *
	 * @since  1.0
	 *
	 * @return $visits The milestones for visits
	 */
	public function visits() {
		$visits = array();

		$visits = affiliate_wp()->visits->count();

		return $visits;
	}

	/**
	 * Get payout milestones
	 *
	 * @since  1.0
	 *
	 * @return $payout The milestones for payouts
	 */
	public function payouts() {

		$payouts = affiliate_wp()->affiliates->payouts->count();

		return $payouts;
	}
}
new Milestones_Endpoint;
