<?php


namespace JFBCore;


abstract class PreventFormSubmitBase {

	public function __construct() {
		if ( $this->can_init() ) {
			add_action(
				$this->action_init(),
				array( $this, 'manage_hooks' )
			);
		}
	}

	/**
	 * Can be overridden in JFBCore space
	 *
	 * @return boolean
	 */
	abstract public function can_init();

	/**
	 * Can be overridden in JFBCore space
	 *
	 * @return array
	 */
	abstract public function manage_hooks_data();

	/**
	 * Can be overridden in JFBCore space
	 *
	 * @return string
	 */
	abstract public function action_init();

	/**
	 * Can be overridden in client code space
	 *
	 * @param $handler
	 *
	 * @return void
	 */
	abstract public function prevent_process_ajax_form( $handler );

	/**
	 * Can be overridden in client code space
	 *
	 * @param $handler
	 *
	 * @return void
	 */
	abstract public function prevent_process_reload_form( $handler );

	public function manage_hooks() {
		[ $handler, $action_name ] = $this->manage_hooks_data();

		if ( wp_doing_ajax() ) {
			remove_action(
				'wp_ajax_' . $action_name,
				array( $handler, 'process_ajax_form' )
			);

			remove_action(
				'wp_ajax_nopriv_' . $action_name,
				array( $handler, 'process_ajax_form' )
			);
			add_action(
				'wp_ajax_' . $action_name,
				array( $this, '_prevent_ajax_submit' ), 0
			);
			add_action(
				'wp_ajax_nopriv_' . $action_name,
				array( $this, '_prevent_ajax_submit' ), 0
			);

			return;
		} elseif ( isset( $_REQUEST[ $handler->hook_key ] ) && $handler->hook_val === $_REQUEST[ $handler->hook_key ] ) {
			remove_action(
				'wp_loaded',
				array( $handler, 'process_form' ), 0
			);
			add_action(
				'wp_loaded',
				array( $this, '_prevent_reload_submit' )
			);
		}
	}

	public function _prevent_ajax_submit() {
		[ $handler ] = $this->manage_hooks_data();

		$handler->is_ajax = true;
		$handler->setup_form();

		$this->prevent_process_ajax_form( $handler );
	}

	public function _prevent_reload_submit() {
		[ $handler ] = $this->manage_hooks_data();

		$handler->setup_form();

		$this->prevent_process_reload_form( $handler );
	}

}