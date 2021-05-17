<?php


namespace JFBCore\JetEngine;


use JFBCore\FieldModifierIT;
use JFBCore\FieldModifierTrait;
use JFBCore\VueComponentProps;

abstract class BaseFieldModifier implements FieldModifierIT {

    use FieldModifierTrait;
	use VueComponentProps;
	use WithInit;

	public function plugin_version_compare() {
		return '2.8.1';
	}

	public function on_plugin_init() {
		add_action(
			"jet-engine/forms/render/{$this->type()}",
			array( $this, 'renderHandler' ), 10, 2
		);
		add_action(
			'jet-engine/forms/edit-field/before',
			array( $this, 'renderFieldControls' )
		);
		add_action(
			'jet-engine/forms/editor/assets',
			array( $this, 'editorAssets' )
		);
	}

	public function getComponentSlug() {
	    return "modify_{$this->type()}";
    }

	public function condition(): bool {
		return true;
	}

	public function vue_component_props() {
		return array();
	}

	/**
	 * Displays a template
	 *
	 * @return void
	 */
	public function renderFieldControls() {
		?>
		<template v-if="'<?= $this->type(); ?>' === currentItem.settings.type">
			<keep-alive>
				<jet-engine-field-<?= $this->getComponentSlug(); ?> v-model="currentItem.settings" <?= $this->vue_component_props_string(); ?>>
			</keep-alive>
		</template>
		<?php
	}

	public function getFormId(): int {
		return $this->getClass()->form_id;
	}

	public function getArgs(): array {
		return $this->_args;
	}

	public function getClass(): \Jet_Engine_Booking_Forms_Builder {
		return $this->_class;
	}
}