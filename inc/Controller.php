<?php
namespace cncTTS;

class Controller {
	public function __construct() {
		$this->readConfig();

		// Register ACF fields
		$this->acf = new ACF();
		$this->view = new View();
		add_action('acf/init', [$this, 'tts_set_google_api']);
		add_filter('acf/update_value', [$this, 'tts_kses_post'], 10, 1);
		add_action( 'get_header', [$this, 'tsm_do_acf_form_head'], 1 );
		add_shortcode('cnc_tts_upload_form', [$this, 'shortcodeUploadForm']);
	}

	public function shortcodeUploadForm()
	{
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
		$config_path = plugin_dir_path(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'config.php';
		if (file_exists($config_path)) {
			$this->tts_config = include($config_path);
		} else {
			trigger_error('Config file missing', E_USER_WARNING);
		}
	}
}