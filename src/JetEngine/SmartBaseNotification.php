<?php


namespace JFBCore\JetEngine;


use JFBCore\Exceptions\BaseHandlerException;
use JFBCore\SmartNotificationActionTrait;

abstract class SmartBaseNotification extends BaseNotification {

	use SmartNotificationActionTrait;

	protected function getSettingsWithGlobal() {
		$settings = $this->getSettings();

		if ( empty( $settings ) ) {
			throw new BaseHandlerException( 'failed' );
		}

		return $this->getInstance()->get_settings_with_global(
			$settings[ $this->get_id() ], $this->getGlobalOptionName()
		);
	}

	/**
	 * @inheritDoc
	 */
	public function do_action( array $settings, $notifications ) {
		try {
			$this->_requestData = $notifications->data;
			$this->_instance    = $notifications;
			$this->_settings    = isset( $settings[ $this->get_id() ] )
				? $settings[ $this->get_id() ]
				: array();

			$this->run_action();

			$notifications->log[] = true;

		} catch ( BaseHandlerException $exception ) {
			return $notifications->set_specific_status( $exception->getMessage() );
		}
	}
}