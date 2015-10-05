<?php

class ApplicationBootTest extends TestCase
{
    /**
     *
     */
    public function testApplicationInstance()
    {
        $instance = $this->bootApplication();
        $this->assertInstanceOf(
            \Ytake\SequelGenerator\Application::class,
            $instance
        );
    }
}
