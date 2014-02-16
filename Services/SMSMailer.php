<?php

	namespace Vivait\SMSMailerBundle\Services;

	use Symfony\Component\DependencyInjection\ContainerInterface;
	use Vivait\SettingsBundle\Interfaces\Settings;
	use Vivait\SettingsBundle\Services\SettingsService;

	class SMSMailer implements Settings {

		public function getSettingsName() { return 'SMS Service provider'; }
		public function getSettingsForm() { /*return new SMSMailerType();*/ }

		protected $settings_registry;
		private $gateway;
		private $container;

		public function __construct(ContainerInterface $container) {
			$this->container = $container;

			$config = $container->getParameter('vivait_sms_mailer');
			if($config['type']=='packetmedia') {
				$this->gateway = $container->get('vivait_sms.packetmedia');
			} elseif($config['type']=='esendex') {
				$this->gateway = $container->get('vivait_sms.esendex');
			} elseif($config['type']=='andrewsandarnold') {
				$this->gateway = $container->get('vivait_sms.andresandarnold');
			}

		}

		private function smsEnabled() {
			return $this->container->getParameter('sms_enabled') == true;
		}

		/**
		 * Send a SMS through the configured gateway
		 * @param $number
		 * @param $message
		 * @return array
		 */
		public function sendSMS($number, $message) {

			if($this->smsEnabled()) {
				$result = $this->gateway->sendSMS($number, $message);
			} else {
				$result['code'] = SMSGateway::RESPONSE_DISABLED;
				$result['raw'] = "SMS Gateway has been disabled in the config";
			}

			if($result['code'] == SMSGateway::RESPONSE_OK) {
				$description = 'SMS was sent OK';
			} elseif($result['code'] == SMSGateway::RESPONSE_FAIL_CREDENTIALS) {
				$description = 'SMS was not sent: Invalid Credentials';
			} elseif($result['code'] == SMSGateway::RESPONSE_FAIL_CREDIT) {
				$description = 'SMS was not sent: Insuffient Credit';
			} elseif($result['code'] == SMSGateway::RESPONSE_FAIL_NUMBER) {
				$description = 'SMS was not sent: Invalid Number';
			} elseif($result['code'] == SMSGateway::RESPONSE_FAIL_MESSAGE) {
				$description = 'SMS was not sent: Invalid Message';
			} elseif($result['code'] == SMSGateway::RESPONSE_FAIL_OUTOFHOURS) {
				$description = 'SMS was not sent: Out of Hours';
			} elseif($result['code'] == SMSGateway::RESPONSE_FAIL_COMMS) {
				$description = 'SMS was not sent: Gateway Failure';
			} elseif($result['code'] == SMSGateway::RESPONSE_DISABLED) {
				$description = 'SMS was not sent: SMS Features Disabled';
			} else {
				$description = 'SMS was not sent: Unknown Error';
			}

			if($result['code'] >= 200 && $result['code'] < 400) {
				$severity = 'success';
			} elseif($result['code'] >= 400 && $result['code'] < 500) {
				$severity = 'error';
			} elseif($result['code'] >= 500 && $result['code'] < 600) {
				$severity = 'error';
			} else {
				$severity = 'unknown';
			}

			return array('code'=>$result,'description'=>$description,'severity'=>$severity,'raw'=>$result['raw']);

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