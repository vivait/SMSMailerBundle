<?php

	namespace Vivait\SMSMailerBundle\Services;


	use Vivait\SettingsBundle\Services\SettingsService;
	use Vivait\SMSMailerBundle\Form\Type\Settings\EsendexSMSType;
	use Vivait\SettingsBundle\Interfaces\Settings;

	class EsendexSMSGateway extends SMSGateway implements Settings {
		protected $settings_registry;

		public function getSettingsName() { return 'Esendex SMS'; }
		public function getSettingsForm() { /*return new EsendexSMSType();*/ }

		public function sendSMS($number, $message) {
			$settings = $this->getSettingsRegistry();
			$message = new \Esendex\Model\DispatchMessage(
				"WebApp", // Send from
				$number, // Send to any valid number
				$message,
				\Esendex\Model\Message::SmsType
			);
			$authentication = new \Esendex\Authentication\LoginAuthentication(
				$settings->get('accountref', 'sms_esendex'), // Your Esendex Account Reference
				$settings->get('username', 'sms_esendex'), // Your login email address
				$settings->get('password', 'sms_esendex') // Your password
			);
			$service = new \Esendex\DispatchService($authentication);
			$result = $service->send($message);

			print $result->id();
			print $result->uri();
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