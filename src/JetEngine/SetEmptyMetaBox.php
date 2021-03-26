<?php


namespace JFBCore\JetEngine;


trait SetEmptyMetaBox {

	final public function get_fields() {
		return array(
			$this->get_id() => array(
				'type' => 'html',
				'html' => '',
			)
		);
	}

}