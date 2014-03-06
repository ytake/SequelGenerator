<?php
namespace Model\Template;
/**
 * Reader.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/04 16:10
 */
error_reporting(E_ALL);
date_default_timezone_set('Asia/Tokyo');

/**
 * Class Reader
 * @package Model\Template
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class Reader implements ReadInterface{

	/** @var array  */
	protected $systemHeader = array(
		"system prefix" => "prefix",
		"database" => "dbname",
		"engine" => "engine",
		"table name" => "table_name",
		"description" => "description"
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
		"fk" => "fk"
	);

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
		$excel = \PHPExcel_IOFactory::load($file);

		$sheetCount = $excel->getSheetCount();
		for($i = 1; $i <= 1; $i++)
		{
			$activeSheetNum = $i - 1;
			$excel->setActiveSheetIndex($activeSheetNum);
			$activeSheet = $excel->getActiveSheet();
			//var_dump($activeSheet->getRowDimensions());
			//var_dump($activeSheet->getCellCollection());
			//\PHPExcel_Cell::coordinateFromString($activeSheet->getCellCollection());
			//var_dump($activeSheet->getCellByColumnAndRow(0, 1)->getValue());
			$sheetData = $this->parseSheet($activeSheet);
			$this->buildScheme($sheetData);

		}
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
					'value' => $obj->getCellByColumnAndRow($colIndex, $row)->getValue()
				);
			}
		}
		return $values;
	}

	/**
	 * @param array $array
	 */
	protected function buildScheme(array $array)
	{
		$tables = array();
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
						$tables[$system[$systemDataCurrentRow]] = ($row['value'] != '') ? $row['value'] : "Parse Error";
					}
				}
				//
				if((int)$systemDataCurrentRow < (int)$row['number'])
				{

					if(isset($this->dataHeader[$row['value']]))
					{
						$dataCurrentColumnRow = (int)$row['number'];
						$elements[$this->dataHeader[$row['value']]][$row['column']] = null;
					}

					if(isset($this->indexHeader[$row['value']]))
					{
						$queryElements = $elements;
						unset($elements);
						$indexCurrentColumnRow = (int)$row['number'];
					}

					if(!is_null($dataCurrentColumnRow) && $dataCurrentColumnRow < (int)$row['number'])
					{
						if(isset($elements))
						{
							$query[$row['number']] = $this->separateSystemValue($this->dataHeader, $row);


						}
						/*
						//var_dump($elements, $row);
						if(isset($elements))
						{
							//$query[$row['number']] =
							for($i = 0; $i < count($elements); $i++)
							{
								var_dump($i);
							}

							//var_dump($row["value"]);
						}
*/
						if((int)$indexCurrentColumnRow > (int)$row['number'])
						{
							//var_dump($row["value"]);
						}
					}

				}
			}
		}
		//var_dump($query);
		//var_dump($tables);
	}

	/**
	 * @param array $array
	 */
	public function separateSystemValue($array, $data)
	{
		var_dump($array, $data);
	}
}