<?php


namespace JFBCore\Exceptions;


class BaseHandlerException extends \Exception {

	private $additional_data;

	public function __construct( $message = "", ...$additional_data ) {
		parent::__construct( $message, 0, null );

		$this->additional_data = $additional_data;
	}

	public function getAdditional(): ?array {
		return $this->additional_data;
	}

}