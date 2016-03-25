<?php namespace Core;

class Input
{
	/**
	 * Checks if an input exists
	 *
	 * @param string $type
	 * @return boolean
	 */
	public static function exists($type = 'post')
	{
		switch($type)
		{
			case 'post':
				return (!empty($_POST)) ? true : false;
			case 'get':
				return (!empty($_GET)) ? true : false;
			default:
				return false;
		}
	}

	/**
	 * Gets an input
	 *
	 * @param $item
	 * @return string
	 */
	public static function get($item)
	{
		if(isset($_POST[$item]))
			return $_POST[$item];
		elseif(isset($_GET[$item]))
			return $_GET[$item];

		return '';
	}

	public static function all()
	{
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'GET':
				return $_GET;
			case 'POST':
				return $_POST;
			default:
				return $_GET;
		}
	}
}