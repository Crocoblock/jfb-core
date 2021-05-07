<?php


namespace JFBCore\JetFormBuilder;


use Jet_Form_Builder\Actions\Action_Handler;
use Jet_Form_Builder\Actions\Types\Base;
use Jet_Form_Builder\Exceptions\Action_Exception;
use Jet_Form_Builder\Form_Messages\Manager;
use JFBCore\Exceptions\BaseHandlerException;
use JFBCore\SmartNotificationActionTrait;

abstract class SmartBaseAction extends Base {

	use SmartNotificationActionTrait;

	protected function getSettings() {
		return $this->settings;
	}

	protected function getGlobalSettingsKeys() {
		return array();
	}

	protected function getSettingsWithGlobal() {
		return array_merge(
			$this->getSettings(),
			$this->global_settings( $this->getGlobalSettingsKeys() )
		);
	}

	public function parseDynamicException( $type, $message ): string {
		switch ( $type ) {
			case 'error':
				return Manager::dynamic_error( $message );
			case 'success':
				return Manager::dynamic_success( $message );
		}
	}

	/**
	 * @param array $request
	 * @param Action_Handler $handler
	 *
	 * @return mixed|void
	 * @throws Action_Exception
	 */
	public function do_action( array $request, Action_Handler $handler ) {
		try {
			$this->_requestData = $request;
			$this->_instance = $handler;
			$this->option_name = $this->getGlobalOptionName();

			$this->run_action();

		} catch ( BaseHandlerException $exception ) {
			throw new Action_Exception( $exception->getMessage(), $exception->getAdditional() );
		}
	}

}