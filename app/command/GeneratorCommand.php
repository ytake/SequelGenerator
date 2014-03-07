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
	/** @var \Comnect\Console\Perform */
	protected $perform;

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
			->setDescription('specify the namespace(controller)')
			->addArgument('controller', InputArgument::REQUIRED, 'specify the namespace(controller)')
			->addOption(
				'vars', null,
				InputOption::VALUE_OPTIONAL | InputOption::VALUE_IS_ARRAY,
				'if set, perform set variables'
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
		$controller = ucwords($input->getArgument('controller'));
		if ($input->getOption('vars'))
		{
			$array = $input->getOption('vars');
		}
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
			$this->app->make($controller)->perform($array);
			$output->writeln("perform controller:$controller");
		}catch(\Exception $e){
			throw new \Exception($e->getMessage(), 500);
		// reflectionException
		}catch(\ReflectionException $e){
			throw new \ReflectionException($e->getMessage(), 500);
		}
	}
}