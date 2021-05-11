<?php


namespace JFBCore\JetEngine;


use JFBCore\VueComponentProps;

abstract class BaseNotification {

    use VueComponentProps;

	abstract public function get_id();

	abstract public function get_name();

	public function vue_component_props() {
		return array(
			':fields' => 'availableFields'
		);
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
				<jet-engine-notification-<?= $this->get_id() ?> v-model="currentItem.<?= $this->get_id() ?>" <?= $this->vue_component_props_string(); ?>/>
			</keep-alive>
		</template>
		<?php
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