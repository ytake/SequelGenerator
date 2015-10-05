<?php
/**
 *
 */

namespace Ytake\SequelGenerator\Services;

use Ytake\SequelGenerator\Parser\ReadInterface;
use Ytake\SequelGenerator\Writer\Database\SchemeInterface;

/**
 * Class SchemeGeneratorService
 *
 * @package Ytake\SequelGenerator\Services
 */
class SchemeGeneratorService
{
    /** @var ReadInterface */
    protected $reader;

    /** @var SchemeInterface */
    protected $database;

    public function __construct(
        ReadInterface $reader,
        SchemeInterface $database
    ) {
        $this->reader = $reader;
        $this->database = $database;
    }

    /**
     * @param $readPath
     * @return string[]
     */
    public function parseScheme($readPath)
    {
        // scheme parse
        $parseData = $this->reader->read($readPath);

        // create database scheme
        return $this->database->prepare($parseData)->getScheme();
    }
}
