<?php

	namespace Viva\SMSMailerBundle\Services;

	use Viva\SettingsBundle\Services\SettingsService;
	use Viva\SMSMailerBundle\Form\Type\Settings\AndrewsAndArnoldSMSType;
	use Viva\SettingsBundle\Interfaces\Settings;

	class AndrewsAndArnoldSMSGateway extends SMSGateway implements Settings {
		public function getSettingsName() { return 'Andrews and Arnold SMS'; }
		public function getSettingsForm() { /*return new AndrewsAndArnoldSMSType;*/ }

		public function sendSMS($number, $message) {
			return null;
		}

		/**
		 * Sets settings_registry
		 * @param SettingsService $settings_registry
		 * @return $this
		 */
		public function setSettingsRegistry(SettingsService $settings_registry) {
			$this->settings_registry = $settings_registry;
			return $this;
		}

		/**
		 * @return SettingsService
		 */
		public function getSettingsRegistry() {
			return $this->settings_registry;
		}
	}