<?php


namespace JFBCore\JetFormBuilder;


use JFBCore\RegisterMetaManager;

abstract class PluginManager {

	use EditorAssetsManager;
	use RegisterMetaManager;
	use WithJFBInit;

	final protected function _on_jbf_init() {
		$this->meta_manager_init();
		$this->assets_init();
	}

}