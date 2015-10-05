<?php
/**
 *
 */

namespace Ytake\SequelGenerator\Writer\Database\Mysql\Templates;

/**
 * Class Database
 *
 * @package Ytake\SequelGenerator\Writer\Database\Mysql\Templates
 */
class Database
{
    /**
     * database scheme template
     *
     * @return string
     */
    public function getTemplate()
    {
        return "CREATE TABLE IF NOT EXISTS {table_name}(\n"
        . "{elements}"
        . " ) DEFAULT CHARACTER SET {charset} COLLATE {collate} ENGINE={engine};\n";
    }
}
