<?php
/**
 * global.php
 * for dependency injection, service locator etc..
 */
$app = new \Comnect\Console\Controller;
$app->bind("Model\ReadInterface", "Model\Excel\Reader");
return $app;