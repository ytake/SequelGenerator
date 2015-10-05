<?php

class SchemeTest extends TestCase
{
    /** @var \Ytake\SequelGenerator\Writer\Database\Mysql\Scheme */
    protected $scheme;

    /** @var array  */
    protected $attributes = [
        [
            'database' => [
                'prefix' => 'name',
                'dbname' => 'database_name',
                'engine' => 'db',
                'table_name' => 'tests',
                'description' => 'desc'
            ]
        ]
    ];

    protected function setUp()
    {
        parent::setUp();
        $this->scheme = new \Ytake\SequelGenerator\Writer\Database\Mysql\Scheme(
            new \Ytake\SequelGenerator\Writer\Database\Mysql\Templates\Database
        );
    }

    public function testPrepareScheme()
    {
        $this->assertCount(0, $this->scheme->getScheme());
        $this->scheme->prepare($this->attributes);
        $this->assertNotCount(0, $this->scheme->getScheme());
    }
}
