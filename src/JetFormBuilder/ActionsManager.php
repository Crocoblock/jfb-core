<?php


namespace JFBCore\JetFormBuilder;


abstract class ActionsManager {

	use WithInit;
	use EditorAssetsManager;

	public function plugin_version_compare() {
		return '1.2.0';
	}

	public function on_plugin_init() {
		add_action(
			'jet-form-builder/actions/register',
			array( $this, 'register_controller' )
		);

		$this->assets_init();
	}

	abstract public function register_controller( \Jet_Form_Builder\Actions\Manager $manager );

}