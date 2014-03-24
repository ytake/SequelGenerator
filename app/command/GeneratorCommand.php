<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Comnect\Console\Controller;
use ErrorException;
/**
 * Class Command Controller
 * @package Comnect\Console\Command
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class GeneratorCommand extends Command
{
	const COMMAND_NAME = "generate:template";

	const DEFAULT_FRAMEWORK = "laravel";
	/** @var \Comnect\Console\Controller */
	protected $app;

	/**
	 * @param Controller $app
	 */
	public function __construct(Controller $app)
	{
		parent::__construct();
		$this->app = $app;
	}

	/**
	 * configure
	 */
	protected function configure()
	{
		$this->setName(self::COMMAND_NAME)
			->setDescription('read file, and template generate')
			->addOption('path', null, InputOption::VALUE_OPTIONAL, 'read directory')
			->addOption('output', null, InputOption::VALUE_OPTIONAL, 'output directory')
			->addOption('framework', null, InputOption::VALUE_OPTIONAL, 'framework');
	}

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return int|null|void
	 * @throws \Exception
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$array = array();
		if($input->getOption('path'))
		{
			$array['path'] = $input->getOption('path');
		}
		if($input->getOption('output'))
		{
			$array['output'] = $input->getOption('output');
		}

		$framework = ($input->getOption('framework')) ? $input->getOption('framework') : self::DEFAULT_FRAMEWORK;
		//
		set_error_handler(function ($errno, $errstr, $errfile, $errline)
			{
				if ($errno == E_RECOVERABLE_ERROR)
				{
					throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
				}
			});
		// perform process
		try {
			// container
			$this->app->bind("Model\ReadInterface", "Model\Excel\Reader");
			$this->app->bind("Model\Framework\WriterInterface", "Model\Writer\Framework\\" . ucfirst($framework));
			$this->app->bind("Model\Database\SchemeInterface", "Model\Writer\Database\Mysql\Scheme");

			$this->app->make("Controller\Generate")->perform($array);

		}catch(\Exception $e){
			throw new \Exception($e->getMessage(), 500);
		// reflectionException
		}
	}
}