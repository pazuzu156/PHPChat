<?php namespace Core;

use Philo\Blade\Blade;

class View
{
	private $_view;
	
	private $_data = array();
	
	private $_blade;
	
	private $_factory;
	
	private $_config;
	
	public function __construct()
	{
		$this->_config = Config::from('app');
		$this->_blade = new Blade($this->_config->get('views'),
				$this->_config->get('cache'));
		
		$this->_view = $this->_blade->view();
	}
	
	public function render($path)
	{
		$this->parseContent($path, $this->_data);
		echo $this->_factory->render();
	}
	
	public function with($key, $value=null)
	{
		if(is_array($key))
			$this->_data = array_merge($this->_data, $key);
		else
			$this->_data[$key] = $value;
		
		return $this;
	}
	
	public function hasData()
	{
		if(empty($this->_data))
			return true;
		
		return false;
	}
	
	private function parseContent($path, $data)
	{
		$path = str_replace('.', '/', $path);
		$this->_factory = $this->_view->make($path, $data);
	}
}