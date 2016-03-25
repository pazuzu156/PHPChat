<?php namespace Core;

class App
{
	public function exec()
	{
		$this->setDefaultTimezone();
		$this->execPageLoader();
	}

	private function setDefaultTimezone()
	{
		$c = Config::from('app');
		date_default_timezone_set($c->get('timezone'));
	}
	
	private function execPageLoader()
	{
		$pl = new PageLoader;
		$pl->load();
	}
}