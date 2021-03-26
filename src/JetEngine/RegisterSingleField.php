<?php


namespace JFBCore\JetEngine;


trait RegisterSingleField {

	private function add_hooks() {
		add_filter(
			'jet-engine/forms/booking/field-types',
			array( $this, 'register_form_fields' )
		);
		add_action(
			"jet-engine/forms/booking/field-template/{$this->get_id()}",
			array( $this, 'get_field_template' ),
			10, 3
		);
		add_action(
			'jet-engine/forms/edit-field/before',
			array( $this, 'render_field_edit' )
		);
	}

	public static function register() {
		if ( function_exists( 'jet_engine' ) ) {
			( new static() )->add_hooks();
		}
	}


	abstract public function get_id();

	abstract public function get_title();

	abstract public function get_field_template();

	abstract public function render_field_edit();

	final public function register_form_fields( $fields ) {
		$fields[ $this->get_id() ] = $this->get_title();

		return $fields;
	}

}