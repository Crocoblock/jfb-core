<?php


namespace JFBCore;


use JFBCore\Exceptions\BaseHandlerException;

trait SmartNotificationActionTrait {

	protected $_requestData;
	protected $_instance;
	protected $_settings;

	abstract public function run_action();

	protected function getRequestData() {
		return $this->_requestData;
	}

	protected function getInstance() {
		return $this->_instance;
	}

	protected function getSettings() {
		return $this->_settings;
	}

	protected function getSettingsWithGlobal() {
		throw new BaseHandlerException( 'failed', __METHOD__ );
	}

	protected function getGlobalOptionName() {
		return $this->get_id();
	}

	public function parseDynamicException( $type, $message ): string {
		return $message;
	}
}