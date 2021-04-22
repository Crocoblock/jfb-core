<?php


namespace JFBCore\JetEngine;


abstract class BaseNotification {

	public function __construct() {
		add_action(
			'jet-engine/forms/editor/before-assets',
			array( $this, 'register_assets_before' )
		);
		add_action(
			'jet-engine/forms/editor/assets',
			array( $this, 'register_assets' )
		);
	}

	public function register_assets() {
	}

	public function register_assets_before() {
	}

	/**
	 * Fires on
	 * 'jet-engine/forms/booking/notifications/fields-after' action
	 *
	 * @return mixed
	 */
	public function notification_fields() {
		?>
		<template v-if="'<?= $this->get_id() ?>' === currentItem.type">
			<keep-alive>
				<jet-engine-notification-<?= $this->get_id() ?>
					v-model="currentItem.<?= $this->get_id() ?>"
					<?= $this->get_component_props_string(); ?>
				/>
			</keep-alive>
		</template>
		<?php
	}

	public function component_props() {
		return array(
			':fields' => 'availableFields'
		);
	}

	final public function get_component_props_string() {
		$result = array();

		foreach ( $this->component_props() as $prop => $value ) {
			$result[] = "$prop=\"$value\"";
		}

		return implode( ' ', $result );
	}

	/**
	 * Fires on
	 * 'jet-engine/forms/booking/notification/<notification_id>' action
	 *
	 * @param $settings array
	 * @param $notifications 'Jet_Engine_Booking_Forms_Notifications'
	 *
	 * @return mixed
	 */
	abstract public function do_action( array $settings, $notifications );

}