<?php

	namespace Vivait\SMSMailerBundle\Services;
	use Vivait\SettingsBundle\Interfaces\Settings;
	use Vivait\SettingsBundle\Services\SettingsService;
	use Vivait\SMSMailerBundle\Form\Type\Settings\PacketMediaSMSType;

	class PacketMediaSMSGateway extends SMSGateway implements Settings {
		public function getSettingsName() { return 'Packet Media SMS'; }
		public function getSettingsForm() { return new PacketMediaSMSType(); }

		protected $container;

		function __construct($container) {
			$this->container = $container;
		}

		public function sendSMS($number, $message) {
			$settings = $this->container->get('vivait_settings.registry');

			$username = $this->getSettingsRegistry()->get('username', 'sms_packetmedia');
			$password = $this->getSettingsRegistry()->get('password', 'sms_packetmedia');

			$ch = curl_init();
			$url = sprintf("https://sms.packetmedia.co.uk/sms.php?cmd=send&user=%s&password=%s&number=%s&msg=%s",
				$username,
				$password,
				$number,
				rawurlencode($message)
			);

			curl_setopt($ch, CURLOPT_URL, $url);


			$resultraw = 'Sent: ' . $url;

			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			$result = curl_exec($ch);
			$resultraw .= ', Received: ' . $result;


			if($result === false) {
				#curl returned an error
				$curlerror = curl_error($ch);
				curl_close($ch);
				return array('code' => parent::RESPONSE_FAIL_COMMS, 'raw' => $curlerror);

			} elseif(isset($result) && $result) {
				curl_close($ch);

				$result = json_decode($result,true);
				if(isset($result['ResponseCode'])) {
					if($result['ResponseCode'] == 'S1') {
						return array('code' => parent::RESPONSE_OK, 'raw' => $resultraw);
					} elseif($result['ResponseCode'] == 'F1') {
						return array('code' => parent::RESPONSE_FAIL_CREDENTIALS, 'raw' => $resultraw);
					} elseif($result['ResponseCode'] == 'F3') {
						return array('code' => parent::RESPONSE_FAIL_COMMS, 'raw' => $resultraw);
					} elseif($result['ResponseCode'] == 'F4') {
						return array('code' => parent::RESPONSE_FAIL_NUMBER, 'raw' => $resultraw);
					} elseif($result['ResponseCode'] == 'F5') {
						return array('code' => parent::RESPONSE_FAIL_NUMBER, 'raw' => $resultraw);
					} elseif($result['ResponseCode'] == 'F6') {
						return array('code' => parent::RESPONSE_FAIL_MESSAGE, 'raw' => $resultraw);
					} elseif($result['ResponseCode'] == 'F7') {
						return array('code' => parent::RESPONSE_FAIL_CREDENTIALS, 'raw' => $resultraw);
					} elseif($result['ResponseCode'] == 'F11') {
						return array('code' => parent::RESPONSE_FAIL_OUTOFHOURS, 'raw' => $resultraw);
					} else {
						return array('code' => parent::RESPONSE_FAIL_UNKNOWN, 'raw' => $resultraw);
					}
				} else {
					return array('code' => parent::RESPONSE_FAIL_COMMS, 'raw' => $resultraw);
				}
			} else {
				curl_close($ch);

				return array('code' => parent::RESPONSE_FAIL_COMMS, 'raw' => $resultraw);
			}

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