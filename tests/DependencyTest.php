<?php


/**
 * Class DependencyTest
 */
class DependencyTest extends TestCase
{
    /**
     *
     */
    public function testApplicationDependency()
    {
        $app = $this->bootApplication();
        $module = new \Ytake\SequelGenerator\Module\Dependency;
        $module->register($app->getContainer());
        $this->assertInstanceOf(
            \Ytake\SequelGenerator\Parser\ExcelParser::class,
            $app->getContainer()->make(\Ytake\SequelGenerator\Parser\ReadInterface::class)
        );
        $this->assertInstanceOf(
            \Ytake\SequelGenerator\Writer\Database\Mysql\Scheme::class,
            $app->getContainer()->make(\Ytake\SequelGenerator\Writer\Database\SchemeInterface::class)
        );
    }
}
