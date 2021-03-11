<?php


namespace JFBCore\JetFormBuilder;


trait WithJFBInit {

	final public function jfb_maybe_init() {
		if ( $this->can_init() ) {
			$this->_on_jbf_init();
		}
	}

	public function jfb_version_compare() {
		return '1.1.0';
	}

	final public function can_init() {
		return ( function_exists( 'jet_form_builder' )
		         && version_compare( JET_FORM_BUILDER_VERSION, $this->jfb_version_compare(), '>=' ) );
	}

	abstract public function _on_jbf_init();
}