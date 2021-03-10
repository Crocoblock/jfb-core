<?php


namespace JFBCore;


trait RegisterMetaManager {

	public function meta_manager_init() {
		add_action( 'init', array( $this, '_register_meta' ), 100 );
	}

	abstract public function meta_data();

	final public function _register_meta() {
		$meta_data = $this->meta_data();

		if ( ! $meta_data ) {
			return;
		}

		foreach ( $meta_data as $meta_key => $meta_params ) {
			register_meta(
				'post',
				$meta_key,
				array_merge( [
					'single'            => true,
					'type'              => 'string',
					'show_in_rest'      => true,
					'auth_callback'     => [ $this, 'auth_callback' ],
					'sanitize_callback' => [ $this, 'sanitize_callback' ],
				], $meta_params )
			);
		}
	}

	public function auth_callback( $res, $key, $post_id, $user_id, $cap ) {
		return true;
	}

	public function sanitize_callback( $meta_value, $meta_key, $object_type ) {
		return $meta_value;
	}
}