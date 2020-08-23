<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       Biol.me
 * @since      1.0.0
 *
 * @package    Biolme
 * @subpackage Biolme/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Biolme
 * @subpackage Biolme/public
 * @author     Biol.me <info@biol.me>
 */
class Biolme_Public {

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
	private $username;

	private $biolme_url = 'https://biol.me';

	private $biolme_oembed_api_url = 'https://biol.me/api/v1/oembed/';
	
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

	}

	public function replace_user_page_url( $html ) {
		$html = str_replace($this->biolme_url.'/'.$this->username,get_the_permalink(),$html);
		return $html;
	}

	public function clear_user_page_cache() {
		return delete_transient( 'biolme_user_page_cache' );
	}

	public function render_user_page( $token ) {
		$biolme_cache_schedule = get_settings( 'biolme_cache_schedule' );
		if(!$biolme_cache_schedule || empty($biolme_cache_schedule)){
			$biolme_cache_schedule = 3600;
		}
		// Get any existing copy of our transient data
		if ( false === ( $html = get_transient( 'biolme_user_page_cache' ) ) ) {
			$html = $this->get_user_page($token);
			$html = ($html && !empty($html)) ? $this->replace_user_page_url($html) : __("Can't connect to biol api, Please check Api token or contact us","biolme");
			set_transient( 'biolme_user_page_cache', $html, $biolme_cache_schedule );
		}
		return $html;
	}

	public function get_user_page($token){

		$response = wp_remote_get(
			esc_url_raw( $this->biolme_oembed_api_url ),
			array(
				'headers' => array(
					'Content-Type' => 'application/json',
					'Authorization' => esc_attr( $token ),
				)
			)
		);

		if ( $response['response']['code'] == 200 && is_array( $response ) && ! is_wp_error( $response ) ) {
			$body    = $response['body']; // use the content
			if( !empty($body) ){
				$obj = json_decode($body,true);
				$this->username = esc_attr( $obj['username'] );
				return $obj['html'];
			}
		}

		return false;

	}

	public function pre_page_load(){

		$page_id = get_settings( 'biolme_page_id' );

		if( !$page_id || empty($page_id)) {
			return;
		}

		$token = get_settings( 'biolme_apitoken' );

		if( is_page( $page_id) ){
			echo ($token && !empty($token)) ? $this->render_user_page($token) : __('Api token not set in settings','biolme');
			die();
		}

	}

}
