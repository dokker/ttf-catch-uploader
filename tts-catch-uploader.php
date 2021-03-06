<?php
/*
Plugin Name: CNC TTS catch uploader
Plugin URI: http://colorandcode.hu
Description: Catch uploader wordpress plugin
Version: 1.0
Author: docker
Author URI: https://hu.linkedin.com/in/docker
 */


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Autoload
 */
$vendorAutoload = realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
if (is_file($vendorAutoload)) {
	require_once($vendorAutoload);
}

function __tts_catch_uploader_load_plugin()
{
	// load translations
	load_plugin_textdomain( 'tts-catch-uploader', false, 'tts-catch-uploader/languages' );

	$catches = new cncTTS\ContentType('catch',
		['menu_icon' => 'dashicons-camera', 'has_archive' => true, 'supports' => ['title']],
		['singular_name' => __('Catch', 'tts-catch-uploader'), 'plural_name' => __('Catches', 'tts-catch-uploader')],
		_x('catches', 'catches archive slug', 'tts-catch-uploader'));

	// instantiate classes to register hooks
	// require_once('inc/cncTTS/Controller.php');
	$controller = new cncTTS\Controller();
}
add_action('plugins_loaded', '__tts_catch_uploader_load_plugin');
