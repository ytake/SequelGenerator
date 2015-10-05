<?php

namespace Ytake\SequelGenerator\Writer;

/**
 * Interface CreateInterface
 *
 * @package Ytake\SequelGenerator\Writer
 */
interface CreateInterface
{

    /**
     * @param array $array
     * @return mixed
     */
    public function create(array $array);
}
