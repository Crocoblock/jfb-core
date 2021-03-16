<?php


namespace JFBCore\JetEngine;


use JFBCore\PreventFormSubmitBase;

abstract class PreventFormSubmit extends PreventFormSubmitBase {

	protected $action = 'jet_engine_form_booking_submit';

	public function can_init() {
		return function_exists( 'jet_engine' );
	}

	public function action_init() {
		return 'init';
	}

	public function manage_hooks_data() {
		return array(
			jet_engine()->forms->handler,
			$this->action,
		);
	}


}