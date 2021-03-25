<?php


namespace JFBCore\JetFormBuilder;



trait RegisterSingleField {

	public static function register() {
		if ( ! function_exists( 'jet_form_builder' ) ) {
			return;
		}

		add_action( 'jet-form-builder/blocks/register', function ( $manager ) {
			$manager->register_block_type( new static() );
		} );
	}

}