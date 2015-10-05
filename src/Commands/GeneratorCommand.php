<?php
/**
 *
 */

namespace Ytake\SequelGenerator\Commands;

use Ytake\SequelGenerator\Configure;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Ytake\SequelGenerator\Services\SchemeGeneratorService;

/**
 * Class GeneratorCommand
 *
 * @package Ytake\SequelGenerator\Commands
 */
class GeneratorCommand extends Command
{
    /** @var string  command name */
    protected $command = "generate:ddl";

    /** @var string  command description */
    protected $description = "generate DDL from Excel";

    /** @var SchemeGeneratorService */
    protected $service;

    /** @var Configure */
    protected $config;

    /** @var Filesystem  */
    protected $filesystem;

    /**
     * @param SchemeGeneratorService $service
     * @param Configure              $config
     * @param Filesystem             $filesystem
     */
    public function __construct(SchemeGeneratorService $service, Configure $config, Filesystem $filesystem)
    {
        $this->service = $service;
        $this->config = $config;
        $this->filesystem = $filesystem;
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function arguments()
    {
        $this->addOption(
            'excel',
            'ex',
            InputOption::VALUE_OPTIONAL,
            'read excel file',
            $this->config->get('read_excel')
        );
        $this->addOption(
            'put',
            'p',
            InputOption::VALUE_OPTIONAL,
            'put directory',
            $this->config->get('put_path')
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function action(InputInterface $input, OutputInterface $output)
    {
        $scheme = $this->service->parseScheme($input->getOption('excel'));
        $putPath = $input->getOption('put');
        $this->filesystem->dumpFile("{$putPath}/scheme.sql", implode("\n", $scheme));
    }
}
