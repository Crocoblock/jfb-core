<?php


namespace JFBCore\JetEngine;


use JFBCore\Common\Path;

class EditorComponents {

	public static function register_components() {
		if ( function_exists( 'jet_engine' ) ) {
			self::_add_components_hooks();
		}
	}

	private static function _add_components_hooks() {
		add_action(
			'jet-engine/forms/editor/before-assets',
			function () {
				wp_enqueue_script(
					'jet-form-editor-base-components',
					Path::assets( 'dist/engine.bundle.js' ),
					array(),
					false,
					true
				);
			}, -999
		);
	}

}