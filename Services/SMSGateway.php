<?php

	namespace Viva\SMSMailerBundle\Services;


	abstract class SMSGateway {

		const RESPONSE_OK = 201;

		const RESPONSE_FAIL_CREDENTIALS = 401;
		const RESPONSE_FAIL_CREDIT      = 403;
		const RESPONSE_FAIL_NUMBER      = 404;
		const RESPONSE_FAIL_MESSAGE     = 405;
		const RESPONSE_FAIL_OUTOFHOURS  = 406;
		const RESPONSE_FAIL_COMMS       = 407;
		const RESPONSE_DISABLED         = 408;

		const RESPONSE_FAIL_UNKNOWN = 502;


		public abstract function sendSMS($number, $message);

	}