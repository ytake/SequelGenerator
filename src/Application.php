<?php
/**
 *
 */

namespace Ytake\SequelGenerator;

use Ytake\SequelGenerator\Commands;
use Illuminate\Contracts\Container\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Application as SymfonyConsole;
use Ytake\SequelGenerator\Module\Dependency;

/**
 * Class Application
 *
 * @package Ytake\SequelGenerator
 */
class Application extends SymfonyConsole
{
    /** @var string  console application name */
    private $name = "SequelGenerator";

    /** @var float  console application version */
    private $version = 0.1;

    /** @var Container $container */
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($this->name, $this->version);
        $this->container = $container;
    }

    /**
     * @param InputInterface|null  $input
     * @param OutputInterface|null $output
     *
     * @return int|void
     * @throws \Exception
     */
    public function run(InputInterface $input = null, OutputInterface $output = null)
    {
        (new Dependency())->register($this->container);

        $this->registerCommand(
            $this->container->make(Commands\GeneratorCommand::class)
        );
        parent::run($input, $output);
    }

    /**
     * @param Command $command
     *
     * @return Command
     */
    public function registerCommand(Command $command)
    {
        return $this->add($command);
    }

    /**
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }
}
