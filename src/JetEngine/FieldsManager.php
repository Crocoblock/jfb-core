<?php


namespace JFBCore\JetEngine;


class FieldsManager {

	private $_fields = array();

	use WithInit;

	public function plugin_version_compare() {
		return '2.8.1';
	}

	public function fields() {
		return [];
	}

	public function on_plugin_init() {
		$this->_register_fields();
		$this->_register_fields_hooks();

		add_filter(
			'jet-engine/forms/booking/field-types',
			array( $this, 'register_form_fields' )
		);
		add_action(
			'jet-engine/forms/editor/before-assets',
			array( $this, 'register_assets_before' )
		);
		add_action(
			'jet-engine/forms/editor/assets',
			array( $this, 'register_assets' )
		);
	}

	public function register_assets_before() {
	}

	public function register_assets() {
	}

	private function _register_fields() {
		foreach ( $this->fields() as $field ) {
			/** @var $field SingleField */

			if ( $field instanceof SingleField ) {
				$this->_fields[ $field->get_id() ] = $field;
			}
		}
	}

	private function _register_fields_hooks() {
		foreach ( $this->_fields as $field ) {
			/** @var $field SingleField */

			add_action(
				"jet-engine/forms/booking/field-template/{$field->get_id()}",
				array( $field, 'get_field_template' ),
				10, 3
			);

			add_action(
				'jet-engine/forms/edit-field/before',
				array( $field, 'render_field_edit' )
			);
		}
	}

	final public function register_form_fields( $fields ) {
		foreach ( $this->_fields as $field ) {
			/** @var $field SingleField */

			$fields[ $field->get_id() ] = $field->get_title();
		}

		return $fields;
	}


}