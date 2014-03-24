<?php
namespace Model\Excel;
/**
 * Reader.php
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * 2014/03/04 16:10
 */
use Model\ReadInterface;
error_reporting(E_ALL);
date_default_timezone_set('Asia/Tokyo');
/**
 * Class Reader
 * @package Model\Template
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Reader implements ReadInterface
{

	/** @var array  */
	protected $systemHeader = array(
		"system prefix" => "prefix",
		"database" => "dbname",
		"engine" => "engine",
		"table name" => "table_name",
		"description" => "description",
		"charset" => "charset",
		"collate" => "collate"
	);

	/** @var array  */
	protected $dataHeader = array(
		"No." => "row",
		"field name" => "field_name",
		"field type" => "field_type",
		"length" => "length",
		"default value" => "default_value",
		"primary" => "primary",
		"display name" => "display_name",
		"NULL" => "null",
		"auto increment" => "auto_increment",
		"description" => "description",
		"foreign key" => "foreign_key"
	);

	/** @var array  */
	protected $indexHeader = array(
		"INDEX NAME" => "index_name",
		"FIELD_NAMES" => "filed_names",
		"INDEX_TYPE" => "index_type"
	);

	/**
	 * @param $file
	 * @return mixed|void
	 */
	public function read($file)
	{
		$parseData = array();
		$excel = \PHPExcel_IOFactory::load($file);
		$sheetCount = $excel->getSheetCount();
		for($i = 1; $i < $sheetCount; $i++)
		{
			$activeSheetNum = $i - 1;
			$excel->setActiveSheetIndex($activeSheetNum);
			$activeSheet = $excel->getActiveSheet();
			$sheetData = $this->parseSheet($activeSheet);
			$parseData[] = $this->buildScheme($sheetData);
		}
		return $parseData;
	}


	/**
	 * @param \PHPExcel_Worksheet $obj
	 * @return array
	 */
	protected function parseSheet(\PHPExcel_Worksheet $obj)
	{
		$values = array();
		if(count($obj->getCellCollection()))
		{
			foreach($obj->getCellCollection() as $cell)
			{
				list($col, $row) = \PHPExcel_Cell::coordinateFromString($cell);
				$colIndex = \PHPExcel_Cell::columnIndexFromString($col) - 1;
				$values[] = array(
					'column' => $col,
					'column_index' => $colIndex,
					'number' => $row,
					'value' => trim($obj->getCellByColumnAndRow($colIndex, $row)->getValue())
				);
			}
		}
		return $values;
	}

	/**
	 * parse scheme
	 * @param array $array
	 * @return array
	 */
	protected function buildScheme(array $array)
	{
		$arrayValues = array_values($this->dataHeader);
		$indexValues = array_values($this->indexHeader);
		$system = array();
		$table = array();
		$elements = array();
		$indexes = array();
		//
		$systemDataCurrentRow = null;
		$elementCurrentRow = null;
		$indexCurrentRow = null;
		//
		if(count($array))
		{
			foreach($array as $row)
			{
				if(isset($this->systemHeader[$row['value']]))
				{
					if($row['column'] == 'A')
					{
						$systemDataCurrentRow = (int)$row['number'];
						$system[$systemDataCurrentRow] = $this->systemHeader[$row['value']];
					}
				}
				if($row['number'] == $systemDataCurrentRow)
				{
					if($row['column'] == 'C')
					{
						$table[$system[$systemDataCurrentRow]]
							= ($row['value'] != '') ? $row['value'] : "Parse Error";
					}
				}
				// element
				if($row['column'] == "A" && is_numeric($row['value']))
				{
					$elementCurrentRow = $row['number'];
				}

				// indexes
				if($row['column'] == "A" && $row['value'] == "KEY")
				{
					$indexCurrentRow = $row['number'];
				}

				if(!is_null($elementCurrentRow))
				{
					if($row['number'] == $elementCurrentRow)
					{
						$elements[$row['number']][$arrayValues[$row['column_index']]] = $row['value'];
					}
				}

				if(!is_null($indexCurrentRow))
				{
					if($row['number'] == $indexCurrentRow)
					{
						if($row['column'] != "A")
						{
							if(isset($indexValues[$row['column_index'] - 1]))
							{
								$indexes[$row['number']][$indexValues[$row['column_index'] - 1]]
									= ($row['column'] == "C") ? explode("\n", $row['value']) : $row['value'];
							}
						}
					}
				}
			}
		}
		return array(
			'database' => $table,
			'elements' => $elements,
			'indexes' => $indexes
		);
	}
}