<?php


namespace JFBCore\JetEngine;


use JFBCore\VueComponentProps;

abstract class SingleField {

	use VueComponentProps;

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

}