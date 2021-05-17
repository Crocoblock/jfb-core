<?php


namespace JFBCore\JetFormBuilder;


trait RegisterFormTabs {

	use WithInit;

	abstract public function tabs(): array;

	public function plugin_version_compare() {
		return '1.2.0';
	}

	public function on_plugin_init() {
		add_filter( 'jet-form-builder/register-tabs-handlers', function ( $tabs ) {
			$tabs = array_merge( $tabs, $this->tabs() );

			return $tabs;
		} );
	}
}