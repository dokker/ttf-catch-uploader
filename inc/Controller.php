<?php
namespace cncTTS;

class Controller {
	public function __construct() {
		$this->plugin_path = plugin_dir_path(dirname(__FILE__));
		$this->plugin_url = plugin_dir_url(dirname(__FILE__));
		$this->readConfig();

		// Register ACF fields
		$this->acf = new ACF();
		$this->view = new View();
		add_action('wp_enqueue_scripts', [$this, 'registerScripts']);
		add_action('acf/init', [$this, 'tts_set_google_api']);
		add_filter('acf/update_value', [$this, 'tts_kses_post'], 10, 1);
		add_action( 'get_header', [$this, 'tts_do_acf_form_head'], 1 );
		add_shortcode('cnc_tts_upload_form', [$this, 'shortcodeUploadForm']);
		add_filter('single_template', [$this, 'tts_catch_single_template']);
	}

	public function registerScripts()
	{
		wp_register_script('tts-catch-main-js', $this->plugin_url . DIRECTORY_SEPARATOR . 'assets/js/main.js', array('jquery'));
		wp_register_script('tts-catch-upload-js', $this->plugin_url . DIRECTORY_SEPARATOR . 'assets/js/upload.js', array('jquery'));
		wp_register_script('tts-googlemaps', 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=' . $this->tts_config['google_api_key'], null, null, true);
	}

	public function shortcodeUploadForm()
	{
		wp_enqueue_script('tts-catch-upload-js');

		if (!is_user_logged_in()) {
			$notloggedin = $this->view->render('tts-notloggedin');
			return $notloggedin;
		}

		acf_form(array(
			'post_title' => true,
			'post_id'		=> 'new_post',
			'new_post'		=> array(
				'post_type'		=> 'catch',
				'post_status'		=> 'pending'
				),
			'submit_value'		=> __('Upload catch', 'tts-catch-uploader'),
			'updated_message'	=> __('Catch saved.', 'tts-catch-uploader'),
			'uploader'	=> 'basic',
			'honeypot'	=> true,
		));
	}


	/**
	 * http://thestizmedia.com/front-end-posting-with-acf-pro/
	 * Fine ACF form example
	 */

	/**
	 * ‘clean’ all values that are saved from the ACF form
	 * https://www.advancedcustomfields.com/resources/acf_form/#security
	 * @param  array $value Form input value
	 * @return array        Sanitized value
	 */
	function tts_kses_post( $value ) {
		// is array
		if(is_array($value)) {
			return array_map('tts_kses_post', $value);
		}
		// return
		return wp_kses_post( $value );
	}

	/**
	 * Add required acf_form_head() function to head of page
	 * @uses Advanced Custom Fields Pro
	 */
	function tts_do_acf_form_head() {
		// Bail if not logged in or not able to post
		if (!is_user_logged_in()) {
			return;
		}
		acf_form_head();
	}

	/**
	 * Set ACF google map API key
	 */
	public function tts_set_google_api()
	{
		acf_update_setting('google_api_key', $this->tts_config['google_api_key']);
	}

	/**
	 * Read configuration from file
	 */
	private function readConfig()
	{
		$config_path = $this->plugin_path . DIRECTORY_SEPARATOR . 'config.php';
		if (file_exists($config_path)) {
			$this->tts_config = include($config_path);
		} else {
			trigger_error('Config file missing', E_USER_WARNING);
		}
	}

	/**
	 * Give the single catch content type template file
	 * @param  string $template Template file path
	 * @return string           Template file path
	 */
	function tts_catch_single_template( $template ) {
		if(get_post_type() == 'catch') {
			wp_enqueue_script('tts-googlemaps');
			wp_enqueue_style($this->plugin_url . DIRECTORY_SEPARATOR . 'assets/css/main.css');
			$template = $this->plugin_path . DIRECTORY_SEPARATOR . 'templates/single-catch.php';
			if (file_exists($template)) {
				return $template;
			} else {
				trigger_error('Failed to load single-catch template', E_USER_NOTICE);
			}
		}
		return $template;
	}

}