<?php


namespace JFBCore\JetEngine;


trait RegisterFormTabs {

	use WithInit;

	abstract public function tabs(): array;

	public function can_init() {
		return class_exists( 'Jet_Engine\\Modules\\Forms\\Tabs\\Tab_Manager' );
	}

	public function customize_init( $callable ) {
		add_action( 'jet-engine/forms/init', $callable );
	}

	public function on_plugin_init() {
		add_filter( 'jet-engine/dashboard/form-tabs', function ( $tabs ) {
			$tabs = array_merge( $tabs, $this->tabs() );

			return $tabs;
		} );
	}
}