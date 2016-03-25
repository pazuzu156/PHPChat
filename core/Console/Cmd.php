<?php namespace Core\Console;

class Cmd
{
	public function register($cmd)
	{
		$classexp = explode('/', $cmd);
		for($i = 0; $i < count($classexp); $i++)
			$classexp[$i] = ucwords($classexp[$i]);

		$class = __NAMESPACE__.'\\'.implode('\\', $classexp);
		return new $class();
	}
}