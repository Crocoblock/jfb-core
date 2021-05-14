<?php


namespace JFBCore;

use JFBCore\Exceptions\BaseHandlerException;

/**
 * @var $this FieldModifierIT
 *
 * Trait FieldModifierTrait
 * @package JFBCore
 */
trait FieldModifierTrait {

	public $_args;
	public $_class;

	public function renderHandler( $args, $instance ): void {
		try {
			$this->_args  = $args;
			$this->_class = $instance;

			$this->onRender();


		} catch ( BaseHandlerException $exception ) {
			//
		}
	}


	public function editorAssets(): void {
	}

}