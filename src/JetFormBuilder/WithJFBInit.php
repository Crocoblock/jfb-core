<?php


namespace JFBCore\JetFormBuilder;


trait WithJFBInit {

	public function jfb_maybe_init() {
		if ( $this->can_init() ) {
			$this->_on_jbf_init();
		}
	}

	public function can_init() {
		return ( function_exists( 'jet_form_builder' )
		         && version_compare( JET_FORM_BUILDER_VERSION, '1.1.0', '>=' ) );
	}

	abstract public function _on_jbf_init();
}