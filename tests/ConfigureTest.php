<?php

/**
 * Class ConfigureTest
 */
class ConfigureTest extends TestCase
{
    public function testConfigure()
    {
        $configure = new \Ytake\SequelGenerator\Configure(['testing' => true]);
        $result = $configure->get();
        $this->assertInternalType('array', $result);
        $this->assertNull($configure->get('aaa'));
        $this->assertTrue($configure->get('testing'));
    }
}
