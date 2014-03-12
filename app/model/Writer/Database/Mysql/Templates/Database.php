<?php
/**
 * Database.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/07 18:11
 */
namespace Model\Writer\Database\Mysql\Templates;
/**
 * Class Database
 * @package Model\Template\Writer\Database\Mysql\Templates
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class Database {

	/**
	 * create sql template
	 * @return string
	 */
	public function getTemplate()
	{
		return "CREATE TABLE IF NOT EXISTS {table_name}(\n"
				."{elements}"
			." ) DEFAULT CHARACTER SET {charset} COLLATE {collate} ENGINE={engine};\n";
	}
}