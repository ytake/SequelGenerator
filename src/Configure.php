<?php

namespace Ytake\SequelGenerator;

/**
 * Class Configure
 *
 * @package Ytake\SequelGenerator
 */
class Configure
{
    /** @var string[] */
    protected $dir;

    /**
     * @param array $dir
     */
    public function __construct(array $dir)
    {
        $this->dir = $dir;
    }

    /**
     * @param null $key
     * @return mixed|null
     */
    public function get($key = null)
    {
        $configure = $this->dir;
        if (!is_null($key)) {
            return (isset($configure[$key])) ? $configure[$key] : null;
        }

        return $configure;
    }
}
