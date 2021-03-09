<?php


namespace JFBCore;


abstract class JFBPluginManager {

	use EditorAssetsManager;
	use WithJFBInit;

	public function _on_jbf_init() {
		$this->assets_init();
	}

}