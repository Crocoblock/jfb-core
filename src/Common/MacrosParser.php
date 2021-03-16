<?php


namespace JFBCore;


class MacrosParser {

	private $source;
	private $handler_callbacks;

	public function __construct( $source, ParserCallbacks $handler_callbacks ) {
		$this->source = $source;
		$this->handler_callbacks = $handler_callbacks;
	}

	/**
	 * Parse macros in content
	 *
	 * @param  [type] $content [description]
	 *
	 * @return [type]          [description]
	 */
	public function simple_parse( $content ) {
		return preg_replace_callback( '/%(.*?)%/', function( $matches ) {
			return $this->handler_callbacks->call_parse( $matches[1], $this->source );
		}, $content );

	}



}