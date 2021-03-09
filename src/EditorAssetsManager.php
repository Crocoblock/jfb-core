<?php


namespace JFBCore;


trait EditorAssetsManager {

	public function assets_init() {
		add_action(
			'jet-form-builder/editor-assets/before',
			array( $this, 'before_init_editor_assets' )
		);
	}

	abstract public function before_init_editor_assets();

}