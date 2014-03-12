<?php
/**
 * Mysql.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/07 17:58
 */
namespace Model\Writer\Database\Mysql;
use Model\SchemeInterface;
use Model\Writer\Database\Mysql\Templates\Database;
/**
 * Class Mysql
 * @package Model\Template\Writer\Database
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class Scheme implements SchemeInterface
{
	//MyISAM
	const DEFAULT_CHARSET = "utf8";

	const DEFAULT_COLLATE = "utf8_general_ci";

	/**
	 * @param Database $template
	 */
	public function __construct(Database $template)
	{
		$this->template = $template;
	}

	/**
	 * @param array $array
	 * @doc
	 * array(
	 *  'database' => array(),
	 *  'elements' => array(),
	 *  'indexes' => array()
	 * );
	 */
	public function scheme(array $array)
	{
		$return = array();
		echo "#parse start.\n";

		foreach($array as $row)
		{
			$createTable = null;
			$dbTemplate = $this->template->getTemplate();
			if(count($row['database']))
			{
				$row['database']['charset']	= (isset($row['database']['charset'])) ? $row['database']['charset'] : self::DEFAULT_CHARSET;
				$row['database']['collate'] = (isset($row['database']['collate'])) ? $row['database']['collate'] : self::DEFAULT_COLLATE;
				// mysql create scheme template
				foreach($row['database'] as $key => $database)
				{
					// replace
					if(preg_match_all("/\{$key\}/us", $dbTemplate, $matches))
					{
						$dbTemplate = str_replace($matches[0][0], $database, $dbTemplate);
					}
				}

				if(count($row['elements']))
				{
					$elements = $this->createElement($row['elements'], $row['indexes'], $row['database']['engine'], $row['database']['table_name']);
					$createTable = str_replace("{elements}", $elements, $dbTemplate);
				}else{
					$createTable = str_replace("{elements}", "", $dbTemplate);
				}
				echo "#create {$row['database']['table_name']}\n";
				$return[] = $createTable;
			}
		}
		echo "#parse end.\n";
		return $return;
	}

	/**
	 * @param array $elements
	 * @param array $indexes
	 * @param $engine
	 * @return string
	 */
	protected function createElement(array $elements, array $indexes, $engine, $tableName)
	{
		$array = array();
		$primary = array();
		$foreign = array();
		$index = array();
		//
		foreach($elements as $element)
		{
			//var_dump($element);
			if($element['field_name'] != '')
			{
				//
				$type = strtoupper($element['field_type']);
				// length
				$length = $this->createLength($type, $element['length']);
				// null, not null
				$null = ($element['null'] == "NOT NULL") ? $element['null'] : "NULL";
				// auto increment
				$increment = ($element['auto_increment'] == "AUTO INCREMENT") ? "\tAUTO_INCREMENT" : null;
				// default value
				$default = (is_null($increment)) ? $this->createDefault($type, $element["default_value"]) : null;
				$array[] =  "\t`{$element['field_name']}`\t$type$length\t$null\t$default$increment";
				if($element['primary'] == 'PRIMARY')
				{
					$primary[] = "`{$element['field_name']}`";
				}
				// MyISAM or NDB (Cluster), does not support this functionality natively
				if($engine != "MyISAM" && $element['foreign_key'] != '')
				{
					$keys = explode(".", $element['foreign_key']);
					$foreign[] = "FOREIGN KEY (`{$element['field_name']}`) REFERENCES `{$keys[0]}` (`$keys[1]`)"
							." ON DELETE CASCADE ON UPDATE CASCADE";
				}
			}
		}
		//
		if(count($indexes))
		{
			foreach($indexes as $row)
			{
				if($row['index_name'] != '')
				{
					if($row['index_type'] == "FULLTEXT INDEX" && $engine == "MyISAM")
					{
						$index[] = "{$row['index_type']} {$row['index_name']} (" . implode(',', $row['filed_names']) .")";
					}else{
						$index[] = "{$row['index_type']} {$row['index_name']} (" . implode(',', $row['filed_names']) .")";
					}
				}
			}
		}
		$create = implode(",\n", $array);
		$primaryKeys = implode(",\t", $primary);
		$foreignKeys = implode(",\n", $foreign);
		$indexKeys = implode(",\n", $index);
		if($primaryKeys != ''){
			$create .= ",\n\tPRIMARY KEY ($primaryKeys)";
		}
		if($foreignKeys != ''){
			$create .= ",\n\t$foreignKeys";
		}
		if($indexKeys != ''){
			$create .= ",\n\t$indexKeys";
		}
		return "$create\n";
	}

	/**
	 * @param $type
	 * @param $length
	 * @param array $array
	 * @return null|string
	 */
	protected function createLength($type, $length)
	{
		switch($type)
		{
			case "TINYTEXT":
			case "TEXT":
			case "MEDIUMTEXT":
			case "LONGTEXT":
			case "TINYBLOB":
			case "BLOB":
			case "MEDIUMBLOB":
			case "LONGBLOB":
			case "DATE":
			case "DATETIME":
			case "TIMESTAMP":
				$return = null;
				break;
			default:
				$return = "($length)";
				break;
		}
		return $return;
	}

	/**
	 * @param $type
	 * @param $value
	 * @return null|string
	 */
	protected function createDefault($type, $value)
	{
		switch($type)
		{
			case "TINYTEXT":
			case "TEXT":
			case "MEDIUMTEXT":
			case "LONGTEXT":
			case "TINYBLOB":
			case "BLOB":
			case "MEDIUMBLOB":
			case "LONGBLOB":
			case "TIMESTAMP":
				$default = null;
				break;
			case "DATE":
				$default = ($value == "") ? "0000-00-00" : $value;
				break;
			case "DATETIME":
				$default = ($value == "") ? "0000-00-00 00:00:00" : $value;
				break;
			case "TINYINT":
			case "SMALLINT":
			case "MEDIUMINT":
			case "INT":
			case "BIGINT":
			case "FLOAT":
				$default = ($value == "") ? "0" : $value;
				break;
			case "DECIMAL":
				$default = ($value == "") ? "10,0" : $value;
				break;
			case "DOUBLE":
				$default = ($value == "") ? "6,3" : $value;
				break;
			default:
				$default = $value;
				break;
		}
		return (!is_null($default)) ? "DEFAULT '$default'" : null;
	}
}