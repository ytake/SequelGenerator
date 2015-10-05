<?php

/**
 * Class TestCase
 */
class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @return \Ytake\SequelGenerator\Application
     */
    protected function bootApplication()
    {
        $container = new \Illuminate\Container\Container;
        $container->singleton(Ytake\SequelGenerator\Configure::class, function () {
            return new \Ytake\SequelGenerator\Configure(require __DIR__ . '/config.php');
        });
        return new \Ytake\SequelGenerator\Application($container);
    }
}
