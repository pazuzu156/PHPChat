<?php namespace Core;

class Hash
{
	public static function make($string)
	{
		return password_hash($string, PASSWORD_BCRYPT);
	}

	public static function check($string, $hash)
	{
		return password_verify($string, $hash);
	}
}