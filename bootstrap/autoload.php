<?php

require __DIR__ . "/../vendor/autoload.php";

/** @var \Illuminate\Container\Container $container */
$container = new \Illuminate\Container\Container;
$container->singleton(Ytake\SequelGenerator\Configure::class, function () {
    return new \Ytake\SequelGenerator\Configure(require __DIR__ . '/../config.php');
});
