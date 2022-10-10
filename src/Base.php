<?php

namespace piyo2\util\base;

class Base
{
	/** @var string */
	const BASE_10 = '0123456789';

	/** @var string */
	const BASE_NUM_LOWER = '0123456789abcdefghijklmnopqrstuvwxyz';

	/** @var string */
	const BASE_NUM_ALPHA = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

	/**
	 * Convert base
	 *
	 * @param string $number
	 * @param string $fromBase
	 * @param string $toBase
	 * @return string
	 */
	public static function convert(string $number, string $fromBase, string $toBase): string
	{
		if ($fromBase === $toBase) {
			return $number;
		}

		$fromLen = strlen($fromBase);
		$toLen = strlen($toBase);
		$numberLen = strlen($number);

		if ($toBase === self::BASE_10) {
			$value = '0';
			for ($i = 1; $i <= $numberLen; $i++) {
				$value = bcadd($value, bcmul(strpos($fromBase, $number[$i - 1]), bcpow($fromLen, $numberLen - $i)));
			}
			return $value;
		}

		if ($fromBase !== self::BASE_10) {
			$base10 = self::convert($number, $fromBase, self::BASE_10);
		} else {
			$base10 = $number;
		}

		if ($base10 < strlen($toBase)) {
			return $toBase[$base10];
		}

		$value = '';
		while ($base10 !== '0') {
			$value = $toBase[bcmod($base10, $toLen)] . $value;
			$base10 = bcdiv($base10, $toLen, 0);
		}
		return $value;
	}
}
