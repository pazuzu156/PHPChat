<?php namespace Core;

class Validate
{
	public static function check()
	{
		$input = Input::all();
		foreach($input as $item)
		{
			if(empty($item))
				return false;
		}

		return true;
	}
}