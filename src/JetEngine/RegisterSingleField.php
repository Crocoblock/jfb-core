<?php


namespace JFBCore\JetEngine;


use JFBCore\VueComponentProps;

trait RegisterSingleField {

	use VueComponentProps;

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


	/**
	 * @return string
	 */
	abstract public function get_id();

	/**
	 * @return string
	 */
	abstract public function get_title();

	/**
	 * @param $template
	 * @param $args
	 * @param $builder
	 *
	 * @return string
	 */
	abstract public function get_field_template( $template, $args, $builder );

	/**
	 * Displays a template
	 *
	 * @return void
	 */
	public function render_field_edit() {
		?>
		<template v-if="'<?= $this->get_id(); ?>' === currentItem.settings.type">
			<keep-alive>
				<jet-engine-field-<?= $this->get_id(); ?> v-model="currentItem.settings.<?= $this->get_id(); ?>" <?= $this->vue_component_props_string(); ?>>
			</keep-alive>
		</template>
		<?php
	}

	final public function register_form_fields( $fields ) {
		$fields[ $this->get_id() ] = $this->get_title();

		return $fields;
	}

}