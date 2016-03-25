<?php namespace Core;

class Config
{
	/**
	 * Config file
	 * 
	 * @var array
	 */
	private $_file;
	
	/**
	 * Config file name
	 * 
	 * @var string
	 */
	private $_configName;

	/**
	 * Config instance
	 *
	 * @var \Core\Config
	 */
	private static $_config;

	/**
	 * Class Constructor
	 *
	 * @param string $config
	 */
	private function __construct($config)
	{
		$path = getcwd().'/config/'.$config.'.php';
		$this->_file = include $path;
		$this->_configName = $config;
	}
	
	/**
	 * Loads a config file in singleton instance
	 * 
	 * @param string $config
	 * @return \Core\Config
	 */
	public static function from($config)
	{
		return self::$_config = new Config($config);
	}
	
	/**
	 * Gets a config item
	 * 
	 * @param string $item
	 * @return string
	 * @throws \Exception
	 */
	public function get($item)
	{
		if(isset($this->_file[$item]))
			return $this->_file[$item];
		else
			throw new \Exception($item . ' is not defined in ' . $this->_configName);
	}
}