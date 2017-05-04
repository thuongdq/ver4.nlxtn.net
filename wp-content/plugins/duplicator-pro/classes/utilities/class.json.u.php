<?php
if (!class_exists('DUP_PRO_JSON_U'))
{
	class DUP_PRO_JSON_U
	{
		protected static $_messages = array(
			JSON_ERROR_NONE => 'No error has occurred',
			JSON_ERROR_DEPTH => 'The maximum stack depth has been exceeded',
			JSON_ERROR_STATE_MISMATCH => 'Invalid or malformed JSON',
			JSON_ERROR_CTRL_CHAR => 'Control character error, possibly incorrectly encoded',
			JSON_ERROR_SYNTAX => 'Syntax error',
			JSON_ERROR_UTF8 => 'Malformed UTF-8 characters, possibly incorrectly encoded. To resolve see https://snapcreek.com/duplicator/docs/faqs-tech/#faq-package-170-q'
		);

		static function utf8ize($mixed)
		{
			if (is_array($mixed))
			{
				foreach ($mixed as $key => $value)
				{
					$mixed[$key] = self::utf8ize($value);
				}
			}
			else if (is_string($mixed))
			{
				return utf8_encode($mixed);
			}
			return $mixed;
		}

		static function escape_string($str)
		{
			return addcslashes($str, "\v\t\n\r\f\"\\/");
		}

		static function custom_encode($value, $iteration = 1)
		{
			if (version_compare(PHP_VERSION, '5.4.0') >= 0)
			{
				$encoded = json_encode($value, JSON_PRETTY_PRINT);
			}
			else
			{
				$encoded = json_encode($value);
			}

			switch (json_last_error())
			{
				case JSON_ERROR_NONE:
					DUP_PRO_U::log("#### no json errors so returning");
					return $encoded;
				case JSON_ERROR_DEPTH:
					throw new RuntimeException('Maximum stack depth exceeded'); // or trigger_error() or throw new Exception()
				case JSON_ERROR_STATE_MISMATCH:
					throw new RuntimeException('Underflow or the modes mismatch'); // or trigger_error() or throw new Exception()
				case JSON_ERROR_CTRL_CHAR:
					throw new RuntimeException('Unexpected control character found');
				case JSON_ERROR_SYNTAX:
					throw new RuntimeException('Syntax error, malformed JSON'); // or trigger_error() or throw new Exception()
				case JSON_ERROR_UTF8:
					if($iteration == 1)
					{
						DUP_PRO_U::log("#### utf8 error so redoing");
						$clean = self::utf8ize($value);
						return self::custom_encode($clean, $iteration + 1);
					}
					else
					{
						throw new RuntimeException('UTF-8 error loop');
					}
				default:
					throw new RuntimeException('Unknown error'); // or trigger_error() or throw new Exception()
			}
		}

		public static function encode($value, $options = 0)
		{
			$result = json_encode($value, $options);

			if ($result !== FALSE)
			{

				return $result;
			}

			if (function_exists('json_last_error'))
			{
				$message = self::$_messages[json_last_error()];
			}
			else
			{
				$message = DUP_PRO_U::__('One or more filenames isn\'t compatible with JSON encoding');
			}

			throw new RuntimeException($message);
		}

		public static function decode($json, $assoc = false)
		{
			$result = json_decode($json, $assoc);

			if ($result)
			{
				return $result;
			}

			throw new RuntimeException(self::$_messages[json_last_error()]);
		}

	}

}
?>