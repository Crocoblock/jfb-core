<?php


namespace JFBCore\JetEngine;


use JFBCore\WithBasePluginInit;

trait WithInit {

	use WithBasePluginInit;

	final public function base_condition() {
		return function_exists( 'jet_engine' );
	}

	public function plugin_version_compare() {
		return '2.8.0';
	}

	public function can_init() {
		return version_compare( jet_engine()->get_version(), $this->plugin_version_compare(), '>=' );
	}

}