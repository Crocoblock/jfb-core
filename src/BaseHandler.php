<?php


namespace JFBCore;


use JFBCore\Exceptions\ApiHandlerException;

abstract class BaseHandler {
	protected $api_base_url = '';
	protected $api_key = '';
	protected $api_request_args = array();
	public static $instance = null;

	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new static();
		}

		return self::$instance;
	}

	private function __construct() {
		if ( wp_doing_ajax() && ! empty( $this->ajax_action() ) ) {
			add_action( 'wp_ajax_' . $this->ajax_action(), array( $this, 'get_api_data' ) );
		}
	}

	public function api_key( $api_key = '' ) {
		if ( $api_key ) {
			$this->api_key = $api_key;
		}

		return $this;
	}

	abstract public function ajax_action(): string;

	abstract public function get_all_data();

	public function get_api_request_args() {
		return array();
	}

	public function get_api_data() {
		if ( empty( $_REQUEST['api_key'] ) ) {
			wp_send_json_error();
		}

		try {
			$this->api_key( sanitize_text_field( $_REQUEST['api_key'] ) );
			$this->filter_result();
		} catch ( ApiHandlerException $exception ) {
			wp_send_json_error( $this->parse_exception( $exception ) );
		}
	}

	protected function parse_exception( ApiHandlerException $exception ) {
		return array_merge( array(
			'message' => $exception->getMessage()
		), $exception->getAdditional() );
	}

	public function filter_result() {
		$data = $this->get_all_data();

		if ( empty( $data ) ) {
			wp_send_json_error();
		} else {
			wp_send_json_success( $data );
		}
	}

	public function request( $end_point, $request_args = array() ) {
		$args = $this->get_api_request_args();

		$args     = array_merge_recursive( $args, $request_args );
		$response = wp_remote_request( $this->api_base_url . $end_point, $args );

		if ( ! $response || is_wp_error( $response ) ) {
			return false;
		}

		$data = wp_remote_retrieve_body( $response );

		if ( ! $data ) {
			return array();
		}

		$data = json_decode( $data, true );

		return $data;
	}

}