<?php


namespace JFBCore\JetFormBuilder;


abstract class ActionsManager {

	use WithJFBInit;
	use EditorAssetsManager;

	public function _on_jbf_init() {
		add_action(
			'jet-form-builder/actions/register',
			array( $this, 'register_controller' )
		);

		$this->assets_init();
	}

	abstract public function register_controller( \Jet_Form_Builder\Actions\Manager $manager );

}