<?php

namespace Ytake\SequelGenerator\Parser;

/**
 * Interface ReadInterface
 *
 * @package Model\Template
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
interface ReadInterface
{
    /**
     * @param $file
     * @return mixed
     */
    public function read($file);
}
