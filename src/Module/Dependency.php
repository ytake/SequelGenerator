<?php

namespace Ytake\SequelGenerator\Module;

use Illuminate\Contracts\Container\Container;

/**
 * Class Dependency
 *
 * @package Ytake\SequelGenerator\Module
 */
class Dependency
{
    /**
     * @param Container $container
     */
    public function register(Container $container)
    {
        $container->bind(
            \Ytake\SequelGenerator\Parser\ReadInterface::class,
            \Ytake\SequelGenerator\Parser\ExcelParser::class
        );
        $container->bind(
            \Ytake\SequelGenerator\Writer\Database\SchemeInterface::class,
            \Ytake\SequelGenerator\Writer\Database\Mysql\Scheme::class
        );
    }
}
