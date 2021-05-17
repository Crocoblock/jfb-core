<?php


namespace JFBCore\JetFormBuilder;


trait RegisterSingleField {

	/**
	 * For backward compatibility.
	 * Now this value is set via block.json
	 * @return string
	 */
	public function get_title() {
		return '';
	}

	/**
	 * For backward compatibility.
	 * Now this value is set via block.json
	 * @return array
	 */
	public function get_attributes() {
		return array();
	}

}