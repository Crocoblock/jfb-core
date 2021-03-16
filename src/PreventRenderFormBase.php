<?php


namespace JFBCore;


trait PreventRenderFormBase {

	public function __construct() {
		add_filter(
			$this->action_name(),
			array( $this, 'prevent_render_form' ), 10, 2
		);
	}

	abstract public function render_form( $form_id, $attrs );

	abstract public function form_id_key();

	abstract public function action_name();

	final public function prevent_render_form( $content, $attrs ) {
		$form_id = isset( $attrs[ $this->form_id_key() ] ) ? absint( $attrs[ $this->form_id_key() ] ) : 0;
		unset( $attrs[ $this->form_id_key() ] );

		return $this->render_form( $form_id, $attrs );
	}
}