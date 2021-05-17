<?php


namespace JFBCore\JetFormBuilder;


use Jet_Form_Builder\Blocks\Render\Base;
use JFBCore\FieldModifierIT;
use JFBCore\FieldModifierTrait;

abstract class BaseFieldModifier implements FieldModifierIT {

	use FieldModifierTrait;
	use WithInit;

	public function plugin_version_compare() {
		return '1.2.0';
	}

	public function on_plugin_init() {
		add_action(
			"jet-form-builder/render/{$this->type()}",
			array( $this, 'renderHandler' ), 10, 2
		);
		add_action(
			'jet-form-builder/editor-assets/before',
			array( $this, 'editorAssets' )
		);
		add_filter(
			'register_block_type_args',
			array( $this, '_blockAttributes' ), 10, 2
		);
	}

	public function blockAttributes( $args ): array {
		return $args;
	}

	public function getFormId(): int {
		return $this->getClass()->form_id;
	}

	public function getArgs(): array {
		return $this->_args;
	}

	public function getClass(): Base {
		return $this->_class;
	}

	final public function _blockAttributes( $args, $name ) {
		if ( $name === "jet-forms/{$this->type()}" ) {
			return $this->blockAttributes( $args );
		}

		return $args;
	}
}