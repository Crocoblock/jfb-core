<?php


namespace JFBCore\JetFormBuilder;


use JFBCore\WithBasePluginInit;

trait WithInit {

	use WithBasePluginInit;

	final public function base_condition() {
		return function_exists( 'jet_form_builder' );
	}

	public function plugin_version_compare() {
		return '1.1.0';
	}

	public function can_init() {
		return version_compare( JET_FORM_BUILDER_VERSION, $this->plugin_version_compare(), '>=' );
	}
}