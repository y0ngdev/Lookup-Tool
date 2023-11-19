<?php

namespace App\Twilio;

class Lookup
{
	public array $data = [];

	public function fetch(string $number)
	{
		$phoneUtil = \libphonenumber\PhoneNumberUtil::getInstance();
		$phone_number = $phoneUtil->parse($number);

		$this->data = [
			'calling_country_code' => $phone_number->getCountryCode(),
			'country_code' => $phoneUtil->getRegionCodeForNumber($phone_number),
			'phone_number' => $phoneUtil->format($phone_number, \libphonenumber\PhoneNumberFormat::E164),
			'national_format' => $phoneUtil->format($phone_number, \libphonenumber\PhoneNumberFormat::NATIONAL),
			'valid' => $phoneUtil->isValidNumber($phone_number),
			'validation_errors' => $this->validationResult($phoneUtil->isPossibleNumberWithReason($phone_number)),
			'caller_name' => null,
			'sim_swap' => null,
			'call_forwarding' => null,
			'live_activity' => null,
			'line_type_intelligence' => null,
			'identity_match' => null,
			'url' => $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']
		];

		return json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
	}

	private function validationResult($reason): string
	{
		return match ($reason) {
			0 => 'NULL',
			1 => 'INVALID_COUNTRY_CODE',
			2 => 'TOO_SHORT',
			3 => 'TOO_LONG',
		};
	}
}
