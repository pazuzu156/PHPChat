<?php namespace Core\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Core\Config;

class ClearCache extends Command
{
	private $_config;

	protected function configure()
	{
		$this->setName('clear-cache')
			 ->setDescription('Clears the views cache');

		$this->_config = Config::from('app');
	}

	protected function execute(InputInterface $input,
		OutputInterface $output)
	{
		$cacheDir = $this->_config->get('cache');

		$handle = opendir($cacheDir);
		$ignore = array('.', '..', '.gitkeep');
		while($file = readdir($handle))
		{
			if(!in_array($file, $ignore))
			{
				$output->writeln('Clearing cache file: ' . $file);
				unlink($cacheDir.$file);
			}
		}
	}
}