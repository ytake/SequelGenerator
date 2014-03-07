<?php
/**
 * global.php
 * for dependency injection, service locator etc..
 */
$app = new \Comnect\Console\Controller;
$app->bind("Model\Template\ReadInterface", "Model\Template\Excel\Reader");
return $app;