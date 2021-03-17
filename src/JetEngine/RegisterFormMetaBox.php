<?php


namespace JFBCore\JetEngine;


abstract class RegisterFormMetaBox {

	public function __construct() {
		add_action(
			'jet-engine/forms/editor/meta-boxes',
			array( $this, 'register_meta_box' )
		);
		add_action(
			'jet-engine/forms/editor/assets',
			array( $this, 'register_assets' )
		);
		add_action(
			'jet-engine/forms/editor/save-meta',
			array( $this, 'save_meta' )
		);
	}

	abstract public function get_id();

	abstract public function get_title();

	abstract public function get_fields();

	final public function register_meta_box( $editor ) {
		new \Cherry_X_Post_Meta( array(
			'id'            => $this->get_id(),
			'title'         => $this->get_title(),
			'page'          => array( $editor->manager->slug() ),
			'context'       => 'normal',
			'priority'      => 'high',
			'callback_args' => false,
			'builder_cb'    => array( $editor, 'get_builder' ),
			'fields'        => $this->get_fields(),
		) );
	}

	public function register_assets() {
	}

	/**
	 * Returns gatewyas config for current form
	 *
	 * @param  [type] $post_id [description]
	 *
	 * @return [type]          [description]
	 */
	public function get_meta_box_settings( $form_id = 0 ) {
		if ( ! $form_id ) {
			$form_id = get_the_ID();
		}
		$meta = get_post_meta( $form_id, $this->get_id(), true );

		return $meta ? json_decode( $meta, true ) : array();
	}

	/**
	 * Save gateways related meta
	 *
	 * @param $post_id
	 *
	 * @return void
	 */
	public function save_meta( $post_id ) {
		$data = isset( $_POST[ $this->get_id() ] ) ? json_encode( $_POST[ $this->get_id() ] ) : json_encode( array() );

		update_post_meta( $post_id, $this->get_id(), wp_slash( $data ) );
	}

}