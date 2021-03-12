<?php


namespace JFBCore\JetFormBuilder;


abstract class PreventFormSubmit {

	public function __construct() {
		if ( wp_doing_ajax() ) {
			add_action(
				'wp_ajax_' . jet_form_builder()->form_handler->hook_key,
				array( $this, '_prevent_ajax_submit' ), 0
			);
			add_action(
				'wp_ajax_nopriv_' . jet_form_builder()->form_handler->hook_key,
				array( $this, '_prevent_ajax_submit' ), 0
			);
		}
	}

	abstract public function prevent_process_ajax_form( $handler );

	public function _prevent_ajax_submit() {
		$handler = jet_form_builder()->form_handler;

		remove_action(
			'wp_ajax_' . $handler->hook_key,
			array( $handler, 'process_ajax_form' )
		);

		$handler->is_ajax = true;
		$handler->setup_form();

		$this->prevent_process_ajax_form( $handler );
	}

}