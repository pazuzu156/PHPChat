<?php namespace Core;

class PageLoader
{
	public function load()
	{
		$page = (isset($_GET['page'])) ? $_GET['page'] : 'home.index';
		
		$view = new View;
		$view->render($page);
	}
}