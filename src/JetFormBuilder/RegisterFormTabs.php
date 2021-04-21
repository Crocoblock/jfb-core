<?php


namespace JFBCore\JetFormBuilder;


trait RegisterFormTabs {

	use WithJFBInit;

	abstract public function tabs(): array;

	public function jfb_version_compare() {
		return '1.2.0';
	}

	public static function register() {
		( new static() )->jfb_maybe_init();
	}

	public function _on_jbf_init() {
		add_filter( 'jet-form-builder/register-tabs-handlers', function ( $tabs ) {
			$tabs = array_merge( $tabs, $this->tabs() );

			return $tabs;
		} );
	}
}