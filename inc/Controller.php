<?php
namespace cncTTS;

class Controller {
	public function __construct() {
		add_action( 'get_header', [$this, 'tsm_do_acf_form_head'], 1 );
		add_shortcode('cnc_tts_upload_form', [$this, 'shortcodeUploadForm']);
	}

	public function shortcodeUploadForm()
	{
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
	 * Add required acf_form_head() function to head of page
	 * @uses Advanced Custom Fields Pro
	 */
	function tsm_do_acf_form_head() {
		// Bail if not logged in or not able to post
		if ( ! ( is_user_logged_in() ) ) {
			return;
		}
		acf_form_head();
	}
}