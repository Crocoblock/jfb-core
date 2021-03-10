<?php


namespace JFBCore\JetFormBuilder;


abstract class PluginManager {

	use EditorAssetsManager;
	use WithJFBInit;

	public function _on_jbf_init() {
		$this->assets_init();
	}

}