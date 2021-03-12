<?php


namespace JFBCore\JetFormBuilder;


abstract class PreventFormSubmit {

	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'manage_hooks' ) );
	}

	public function manage_hooks() {
		if ( ! wp_doing_ajax() ) {
			return;
		}

		$handler = jet_form_builder()->form_handler;

		remove_action(
			'wp_ajax_' . $handler->hook_key,
			array( $handler, 'process_ajax_form' )
		);

		remove_action(
			'wp_ajax_nopriv_' . $handler->hook_key,
			array( $handler, 'process_ajax_form' )
		);

		add_action(
			'wp_ajax_' . $handler->hook_key,
			array( $this, '_prevent_ajax_submit' ), 0
		);
		add_action(
			'wp_ajax_nopriv_' . $handler->hook_key,
			array( $this, '_prevent_ajax_submit' ), 0
		);
	}

	abstract public function prevent_process_ajax_form( $handler );

	public function _prevent_ajax_submit() {
		$handler = jet_form_builder()->form_handler;

		$handler->is_ajax = true;
		$handler->setup_form();

		$this->prevent_process_ajax_form( $handler );
	}

}