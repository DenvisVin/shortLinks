<?

class UrlValidator
{
	public static $urlRegExp = "/^https?:\\/\\/(?:www\\.)?[-a-zA-Z0-9@:%._\\+~#=]{1,256}\\.[a-zA-Z0-9()]{1,6}\\b(?:[-a-zA-Z0-9()@:%_\\+.~#?&\\/=]*)$/";
	
	public function __construct()
	{
	}
	
	public static function isUrl($str)
	{
		return !!preg_match(
			self::$urlRegExp,
			trim($str)
		);
	}
}