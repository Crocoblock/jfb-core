<?php


namespace JFBCore\JetEngine;


trait RegisterFormTabs {

	abstract public function tabs(): array;

	public function condition() {
		return class_exists( 'Jet_Engine\Modules\Forms\Tabs\Tab_Manager' );
	}

	public static function register() {
		add_action( 'jet-engine/forms/init', function () {
			$instance = ( new static() );

			if ( $instance->condition() ) {
				$instance->init();
			}
		} );
	}

	public function init() {
		add_filter( 'jet-engine/dashboard/form-tabs', function ( $tabs ) {
			$tabs = array_merge( $tabs, $this->tabs() );

			return $tabs;
		} );
	}
}