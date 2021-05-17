<?php


namespace JFBCore\JetEngine;


abstract class RegisterFormMetaBox {

	use WithInit;

	public function plugin_version_compare() {
		return '2.8.1';
	}

	public function on_plugin_init() {
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

	/**
	 * Added for override
	 * @return string
	 */
	public function component_slug() {
		return $this->get_id();
	}

	public function component_placeholder() {
		return "Use <pre>wp.hooks.addFilter( 'jet.engine.register.metaBoxes' ... </pre>";
	}

	public function get_fields() {
		$content = "<div id='jet-engine-meta-box-{$this->component_slug()}'>{$this->component_placeholder()}</div>";

		return array(
			$this->get_id() => array(
				'type' => 'html',
				'html' => $content,
			)
		);
	}

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
	 * Save gateways related meta
	 *
	 * @param $post_id
	 *
	 * @return void
	 */
	public function save_meta( $post_id ) {
		$data = isset( $_POST[ $this->get_id() ] ) ? json_encode( $_POST[ $this->get_id() ], JSON_UNESCAPED_UNICODE ) : '{}';

		update_post_meta( $post_id, $this->get_id(), wp_slash( $data ) );
	}

}