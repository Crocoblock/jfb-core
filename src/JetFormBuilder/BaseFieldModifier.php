<?php


namespace JFBCore\JetFormBuilder;


use Jet_Form_Builder\Blocks\Render\Base;
use JFBCore\FieldModifierIT;
use JFBCore\FieldModifierTrait;

abstract class BaseFieldModifier implements FieldModifierIT {

	use FieldModifierTrait;

	public function blockAttributes( $args ): array {
		return $args;
	}

	public static function register(): void {
		$self = new static();

		if ( ! $self->condition() ) {
			return;
		}

		add_action(
			"jet-form-builder/render/{$self->type()}",
			array( $self, 'renderHandler' ), 10, 2
		);
		add_action(
			'jet-form-builder/editor-assets/before',
			array( $self, 'editorAssets' )
		);
		add_filter(
			'register_block_type_args',
			array( $self, '_blockAttributes' ), 10, 2
		);
	}

	public function condition(): bool {
		return true;
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