<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Comp_Form
 * @subpackage Comp_Form/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Comp_Form
 * @subpackage Comp_Form/public
 * @author     Developer Junayed <admin@easeare.com>
 */
class Comp_Form_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_shortcode( 'comp_login', [$this, 'comp_login_view'] );
		add_shortcode( 'comp_registration', [$this, 'comp_registration_view'] );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Comp_Form_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Comp_Form_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/comp-form-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Comp_Form_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Comp_Form_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/comp-form-public.js', array( 'jquery' ), $this->version, false );

	}

	function competition_wp_head(){
		global $post;
		if(get_comp_page_url_by_shortcode('comp_registration') || get_comp_page_url_by_shortcode('comp_login')){
			?>
			<style>
				body {
					background-image: url("<?php echo get_template_directory_uri() ?>/assets/img/bg-texture-01.jpg") !important;
				}
			</style>
			<?php
		}
	}

	function comp_login_view(){
		ob_start();
		require_once plugin_dir_path( __FILE__ )."partials/login.php";
		return ob_get_clean();
	}

	function comp_registration_view(){
		ob_start();
		require_once plugin_dir_path( __FILE__ )."partials/registration.php";
		return ob_get_clean();
	}

	function login_registration_actions(){
		global $compRegAlerts, $comploginAlerts, $wpdb;
		if(isset($_POST['comp_registration']) && wp_verify_nonce( $_POST['comp_reg_nonce'], 'comp_nonce' )){
			try {
				$email = sanitize_email( $_POST['comp_reg_email'] );
				if(empty($email) || $email === null){
					$compRegAlerts = '<strong>ERROR</strong>: Please type your email.';
					return;
				}

				$first_name = sanitize_text_field( $_POST['comp_first_name'] );
				if(empty($first_name)){
					$compRegAlerts = '<strong>ERROR</strong>: You must have to your first name.';
					return;
				}
				$last_name = sanitize_text_field( $_POST['comp_last_name'] );

				
				$password = sanitize_text_field( $_POST['comp_password'] );
				if(empty($password)){
					$compRegAlerts = '<strong>ERROR</strong>: You must need a password.';
					return;
				}

				$comp_role = sanitize_text_field( $_POST['comp_role'] );
				if ( $comp_role === '' ) {
					$compRegAlerts = '<strong>ERROR</strong>: Please select a role.';
					return;
				}

				$username = explode("@", $email)[0];

				$user_id = wp_create_user( $username, $password, $email );
				if(is_wp_error( $user_id )){
					$code = $user_id->get_error_code();
					$compRegAlerts = $user_id->get_error_messages($code)[0];
					return;
				}

				$user_id_role = new WP_User($user_id);
				$user_id_role->set_role($comp_role);

				if ( ! empty( $first_name ) ) {
					wp_update_user( array( 'ID' => $user_id, 'display_name' => $first_name.' '.$last_name ) );
					$profileMeta = [
						'avatar' => null,
						'name' => $first_name.' '.$last_name,
						'userBio' => '....',
						'school' => '....',
						'country' => '....',
						'grade' => '',
						'age' => '',
						'multiapplications' => [],
						'multiGrades' => [],
						'multiAges' => []
					];

					update_user_meta( $user_id, 'comp_profile_informations', $profileMeta );
				}

				wp_new_user_notification( $user_id, null, 'both' );
				
				set_transient( 'user_created_success', 'Your account has been created successfully.', 30 );
				wp_safe_redirect( get_the_permalink( get_comp_page_url_by_shortcode('comp_registration') ) );
				exit;
				
			} catch (\Throwable $th) {
				print_r($th->getMessage());
			}
		}

		if(isset($_POST['comp_login']) && wp_verify_nonce( $_POST['comp_login_nonce'], 'comp_nonce' )){
			$email = $_POST['comp_login_email'];
			$username = '';
			if($email){
				$username = explode("@", $email)[0];
			}

			if(!$username){
				$comploginAlerts = "Invalid username or email.";
			}

			$password = sanitize_text_field( $_POST['comp_login_password'] );
			if(!$password){
				$comploginAlerts = "Invalid username and password.";
			}
			
			$remember = false;
			if(isset($_POST['comp_login_remember'])){
				if($_POST['comp_login_remember'] === 'on'){
					$remember = true;
				}
			}
			
			if(!empty($username) && !empty($password)){
				$creds = array(
					'user_login'    => $username,
					'user_password' => $password,
					'remember'      => $remember
				);
	
				$user = wp_signon( $creds, true );
				if ( is_wp_error( $user ) ) {
					$comploginAlerts = $user->get_error_message();
					return;
				}

				wp_safe_redirect( home_url(  ) );
				exit;
			}
		}
	}

}
