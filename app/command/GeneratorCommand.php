<?php
namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
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
	/** @var \Comnect\Console\Controller */
	protected $app;

	/**
	 * @param Controller $app
	 * @param Perform $perform
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
			->addOption(
				'path', null,
				InputOption::VALUE_OPTIONAL,
				'if set, switch read directory'
			);

	}

	/**
	 * @param InputInterface $input
	 * @param OutputInterface $output
	 * @return int|null|void
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$array = array();
		/**
		 */
		set_error_handler(function ($errno, $errstr, $errfile, $errline)
		{
			if ($errno == E_RECOVERABLE_ERROR)
			{
				throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
			}
		});
		// perform process
		try {
			// path to perform
			$this->app->make("Controller\Reader")->perform($array);
		}catch(\Exception $e){
			throw new \Exception($e->getMessage(), 500);
		// reflectionException
		}catch(\ReflectionException $e){
			throw new \ReflectionException($e->getMessage(), 500);
		}
	}
}