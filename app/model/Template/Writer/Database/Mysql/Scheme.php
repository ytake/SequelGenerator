<?php
/**
 * Mysql.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/07 17:58
 */
namespace Model\Template\Writer\Database\Mysql;
use Model\Template\Writer\Database\Mysql\Stub\Database;
/**
 * Class Mysql
 * @package Model\Template\Writer\Database
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class Scheme
{
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
		$databaseTemplate = null;
		foreach($array as $row)
		{
			if(count($row['database']))
			{
				$row['database']['charset']	= (isset($row['database']['charset'])) ? $row['database']['charset'] : self::DEFAULT_CHARSET;
				$row['database']['collate'] = (isset($row['database']['collate'])) ? $row['database']['collate'] : self::DEFAULT_COLLATE;
				// mysql create scheme template
				$databaseTemplate = $this->template->getTemplate();
				foreach($row['database'] as $key => $database)
				{
					// replace
					if(preg_match_all("/\{$key\}/us", $databaseTemplate, $matches))
					{
						$databaseTemplate = str_replace($matches[0][0], $database, $databaseTemplate);
					}
				}
			}
		}
		var_dump($databaseTemplate);
	}
}