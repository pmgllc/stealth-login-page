<?php
/**
 * Weclome Page Class
 *
 * @package     SLP
 * @subpackage  Admin/Welcome
 * @copyright   Copyright (c) 2013, Jesse Petersen
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * SLP_Welcome Class
 *
 * A general class for About and Credits page.
 *
 * @since 4.0
 */
class SLP_Welcome {
	/**
	 * @var string The capability users should have to view the page
	 */
	public $minimum_capability = 'manage_options';

	/**
	 * Get things started
	 *
	 * @access  public
	 * @since 4.0
	 * @return void
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menus') );
		add_action( 'admin_head', array( $this, 'admin_head' ) );
		add_action( 'admin_init', array( $this, 'welcome'    ) );
	}

	/**
	 * Register the Dashboard Pages which are later hidden but these pages
	 * are used to render the Welcome and Credits pages.
	 *
	 * @access public
	 * @since 4.0
	 * @return void
	 */
	public function admin_menus() {
		// About Page
		add_dashboard_page(
			__( 'Welcome to Stealth Login Page', 'slp' ),
			__( 'Welcome to Stealth Login Page', 'slp' ),
			$this->minimum_capability,
			'slp-about',
			array( $this, 'about_screen' )
		);

		// Credits Page
		add_dashboard_page(
			__( 'Welcome to Stealth Login Page', 'slp' ),
			__( 'Welcome to Stealth Login Page', 'slp' ),
			$this->minimum_capability,
			'slp-credits',
			array( $this, 'credits_screen' )
		);
	}

	/**
	 * Hide Individual Dashboard Pages
	 *
	 * @access public
	 * @since 4.0
	 * @return void
	 */
	public function admin_head() {
		remove_submenu_page( 'index.php', 'slp-about' );
		remove_submenu_page( 'index.php', 'slp-credits' );

		// Badge for welcome page
		$badge_url = SLP_PLUGIN_URL . 'assets/images/slp-badge.png';
		?>
		<style type="text/css" media="screen">
		/*<![CDATA[*/
		.slp-badge {
			padding-top: 150px;
			height: 52px;
			width: 185px;
			color: #666;
			font-weight: bold;
			font-size: 14px;
			text-align: center;
			text-shadow: 0 1px 0 rgba(255, 255, 255, 0.8);
			margin: 0 -5px;
			background: url('<?php echo $badge_url; ?>') no-repeat;
		}

		.about-wrap .slp-badge {
			position: absolute;
			top: 0;
			right: 0;
		}

		.slp-welcome-screenshots {
			float: right;
			margin-left: 10px!important;
		}
		/*]]>*/
		</style>
		<?php
	}

	/**
	 * Render About Screen
	 *
	 * @access public
	 * @since 4.0
	 * @return void
	 */
	public function about_screen() {
		list( $display_version ) = explode( '-', SLP_VERSION );
		?>
		<div class="wrap about-wrap">
			<h1><?php printf( __( 'Welcome to Stealth Login Page %s', 'slp' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for updating to the latest version! Stealth Login Page %s is ready to make your online store faster, safer and better!', 'slp' ), $display_version ); ?></div>
			<div class="slp-badge"><?php printf( __( 'Version %s', 'slp' ), $display_version ); ?></div>

			<h2 class="nav-tab-wrapper">
				<a class="nav-tab nav-tab-active" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'slp-about' ), 'index.php' ) ) ); ?>">
					<?php _e( "What's New", 'slp' ); ?>
				</a><a class="nav-tab" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'slp-credits' ), 'index.php' ) ) ); ?>">
					<?php _e( 'Credits', 'slp' ); ?>
				</a>
			</h2>

			<div class="changelog">
				<h3><?php _e( 'Bundled Products', 'slp' ); ?></h3>

				<div class="feature-section">

					<img src="<?php echo SLP_PLUGIN_URL . 'assets/images/screenshots/bundles.png'; ?>" class="slp-welcome-screenshots"/>

					<h4><?php _e( 'Combine Multiple Products into Bundles', 'slp' ); ?></h4>
					<p><?php _e( 'A bundled product is a group of other Downloads in your store that are purchased as a single item, usually at a discount.', 'slp' ); ?></p>

					<h4><?php _e( 'Simplify Your Admin Tasks', 'slp' ); ?></h4>
					<p><?php _e( 'Prior to Bundles, you were forced to create a new product and then manually add all of the necessary files from the other Downloads to it. No longer! Bundled products automatically grab the file downloads from products included in the bundle.', 'slp' ); ?></p>

				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'Improved Developer Documentation', 'slp' ); ?></h3>

				<div class="feature-section">

					<h4><?php _e( 'Code Reference', 'slp' ); ?></h4>
					<p><?php _e( 'A complete code reference has been made available for developers at <a href="https://easydigitaldownloads.com/codex/index.html">/codex</a> on the Stealth Login Page website.', 'slp' );  ?></p>

					<h4><?php _e( 'Action Hooks', 'slp' ); ?></h4>
					<p><?php _e( 'Along with the complete code reference, we have been working to bring the <a href="https://easydigitaldownloads.com/docs/section/actions/">Actions reference</a> up to date with all of the action hooks available in Stealth Login Page.', 'slp' );  ?></p>

				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'Additional Updates', 'slp' ); ?></h3>

				<div class="feature-section col three-col">
					<div>
						<h4><?php _e( 'SLP_Cron Class', 'slp' ); ?></h4>
						<p><?php printf( __( 'The new %SLP_Cron class%s provides a simple way to hook into routinely scheduled events in Stealth Login Page.', 'slp' ), '<a href="https://github.com/easydigitaldownloads/Easy-Digital-Downloads/blob/master/includes/class-slp-cron.php" target="_blank">', '</a>' ); ?></p>

						<h4><?php _e( 'Improved Country and State / Province Fields ', 'slp' ); ?></h4>
						<p><?php _e( 'We have added drop down fields for the states / provinces of 12 additional countries, providing customers in those countries a much better checkout experience.', 'slp' ); ?></p>
					</div>

					<div>
						<h4><?php _e( 'More Reliable File Download Methods', 'slp' ); ?></h4>
						<p><?php _e( 'SLP now supports delivering file downloads via X-Sendfile, X-Lighttpd-Sendfile, and X-Accel-Redirect depending on your server config.', 'slp' ); ?></p>

						<h4><?php _e( 'Lookup Previous Guest Purchases on User Registration', 'slp' ); ?></h4>
						<p><?php _e( 'Anytime a new user is added, SLP will look up any purchases the user may have made as a guest and attribute them to the newly created account.', 'slp' ); ?></p>
					</div>

					<div class="last-feature">
						<h4><?php _e( 'Itemized PayPal Purchases', 'slp' ); ?></h4>
						<p><?php _e( 'Purchases made through PayPal will now show itemized details in the PayPal order summary box.', 'slp' ); ?></p>

						<h4><?php _e( 'SKU Support', 'slp' ); ?></h4>
						<p><?php _e( 'Adding product SKUs to Downloads is now supported and can be enabled in Downloads > Settings > Misc.', 'slp' ); ?></p>
					</div>
				</div>
			</div>

			<div class="return-to-dashboard">
				<a href="<?php echo esc_url( admin_url( add_query_arg( array( 'post_type' => 'download', 'page' => 'slp-settings' ), 'edit.php' ) ) ); ?>"><?php _e( 'Go to Stealth Login Page Settings', 'slp' ); ?></a>
			</div>
		</div>
		<?php
	}

	/**
	 * Render Credits Screen
	 *
	 * @access public
	 * @since 1.4
	 * @return void
	 */
	public function credits_screen() {
		list( $display_version ) = explode( '-', SLP_VERSION );
		?>
		<div class="wrap about-wrap">
			<h1><?php printf( __( 'Welcome to Stealth Login Page %s', 'slp' ), $display_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Thank you for updating to the latest version! Stealth Login Page %s is ready to make your online store faster, safer and better!', 'slp' ), $display_version ); ?></div>
			<div class="slp-badge"><?php printf( __( 'Version %s', 'slp' ), $display_version ); ?></div>

			<h2 class="nav-tab-wrapper">
				<a class="nav-tab" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'slp-about' ), 'index.php' ) ) ); ?>">
					<?php _e( "What's New", 'slp' ); ?>
				</a><a class="nav-tab nav-tab-active" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'slp-credits' ), 'index.php' ) ) ); ?>">
					<?php _e( 'Credits', 'slp' ); ?>
				</a>
			</h2>

			<p class="about-description"><?php _e( 'Stealth Login Page is created by a worldwide team of developers who aim to provide the #1 eCommerce platform for selling digital goods through WordPress.', 'slp' ); ?></p>

			<?php echo $this->contributors(); ?>
		</div>
		<?php
	}


	/**
	 * Render Contributors List
	 *
	 * @since 4.0
	 * @uses SLP_Welcome::get_contributors()
	 * @return string $contributor_list HTML formatted list of all the contributors for SLP
	 */
	public function contributors() {
		$contributors = $this->get_contributors();

		if ( empty( $contributors ) )
			return '';

		$contributor_list = '<ul class="wp-people-group">';

		foreach ( $contributors as $contributor ) {
			$contributor_list .= '<li class="wp-person">';
			$contributor_list .= sprintf( '<a href="%s" title="%s">',
				esc_url( 'https://github.com/' . $contributor->login ),
				esc_html( sprintf( __( 'View %s', 'slp' ), $contributor->login ) )
			);
			$contributor_list .= sprintf( '<img src="%s" width="64" height="64" class="gravatar" alt="%s" />', esc_url( $contributor->avatar_url ), esc_html( $contributor->login ) );
			$contributor_list .= '</a>';
			$contributor_list .= sprintf( '<a class="web" href="%s">%s</a>', esc_url( 'https://github.com/' . $contributor->login ), esc_html( $contributor->login ) );
			$contributor_list .= '</a>';
			$contributor_list .= '</li>';
		}

		$contributor_list .= '</ul>';

		return $contributor_list;
	}

	/**
	 * Retreive list of contributors from GitHub.
	 *
	 * @access public
	 * @since 4.0
	 * @return array $contributors List of contributors
	 */
	public function get_contributors() {
		$contributors = get_transient( 'slp_contributors' );

		if ( false !== $contributors )
			return $contributors;

		$response = wp_remote_get( 'https://api.github.com/repos/pmgllc/stealth-login-page/contributors', array( 'sslverify' => false ) );

		if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) )
			return array();

		$contributors = json_decode( wp_remote_retrieve_body( $response ) );

		if ( ! is_array( $contributors ) )
			return array();

		set_transient( 'slp_contributors', $contributors, 3600 );

		return $contributors;
	}

	/**
	 * Sends user to the Welcome page on first activation of SLP as well as each
	 * time SLP is upgraded to a new version
	 *
	 * @access public
	 * @since 4.0
	 * @global $slp_options Array of all the SLP Options
	 * @return void
	 */
	public function welcome() {
		global $slp_options;

		// Bail if no activation redirect
		if ( ! get_transient( '_slp_activation_redirect' ) )
			return;

		// Delete the redirect transient
		delete_transient( '_slp_activation_redirect' );

		// Bail if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) )
			return;

		wp_safe_redirect( admin_url( 'index.php?page=slp-about' ) ); exit;
	}
}
new SLP_Welcome();