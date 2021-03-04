<?php


namespace JFBCore;


abstract class JFBActionsManager {

	public static $instance = null;

	protected function __construct() {
		add_action(
			'jet-form-builder/actions/register',
			array( $this, 'register_controller' )
		);
		add_action(
			'jet-form-builder/editor-assets/before',
			array( $this, 'register_assets_for_editor' )
		);
	}

	abstract public function register_controller( \Jet_Form_Builder\Actions\Manager $manager );

	abstract public function register_assets_for_editor();

	public static function can_init() {
		return ( function_exists( 'jet_form_builder' )
		         && version_compare( JET_FORM_BUILDER_VERSION, '1.1.0', '>=' ) );
	}
}