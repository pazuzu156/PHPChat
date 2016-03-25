<?php namespace Core;

class Session
{
	public static function get($key)
	{
		if(self::exists($key))
			return $_SESSION[$key];

		return false;
	}

	public static function set($key, $value)
	{
		return $_SESSION[$key] = $value;
	}

	public static function exists($key)
	{
		return isset($_SESSION[$key]);
	}

	public static function delete($key)
	{
		if(self::exists($key))
			unset($_SESSION[$key]);
	}

	public static function flash($key, $value = '')
	{
		if(empty($value))
		{
			if(self::exists($key))
			{
				$flash = self::get($key);
				self::delete($key);
				return $flash;
			}
		}
		else
		{
			self::set($key, $value);
		}

		return false;
	}
}