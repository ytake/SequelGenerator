<?php
/**
 *
 */

namespace Ytake\SequelGenerator\Writer\Database;

/**
 * Interface SchemeInterface
 *
 * @package Ytake\SequelGenerator\Writer\Database
 */
interface SchemeInterface
{
    /**
     * @param array $array
     * @return mixed
     */
    public function prepare(array $array);
}
