<?php
namespace Model\Writer\Framework\Bear\Saturday;
use Model\Writer\Framework\Bear\Saturday\Templates\Resource as Template;

/**
 * Class Resource
 * @package Model\Writer\Framework\Bear\Saturday
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class Resource {

	/** @var \Model\Writer\Framework\Bear\Saturday\Templates\Resource */
	protected $template;

	/**
	 * @param Template $template
	 */
	public function __construct(Template $template)
	{
		$this->template = $template;
	}

	/**
	 * @param array $array
	 * @return array
	 */
	public function create(array $array)
	{
		$template = $this->template->get();
		$table = "\tprotected \$_table = \"{$array['database']['table_name']}\";\n\n";
		//
		$body = str_replace("{table_name}", $table, $template);
		//
		$body = str_replace("{class}", ucwords($array['database']['table_name']), $body);
		$create = null;
		$update = null;
		$delete = null;
		$read = null;
		$i = 0;
		$primaryKeys = array();
		if(count($array['elements']))
		{
			foreach($array['elements'] as $element)
			{
				if($element['field_name'] != '' && (
					$element['field_name'] == 'created_at' || $element['field_name'] == 'updated_at'
					|| $element['field_name'] == 'r_datetime' || $element['field_name'] == 'm_datetime'
				))
				{
					$create .= "\t\t\$values['{$element['field_name']}'] = _BEAR_DATETIME;\n";
					if($element['field_name'] == 'updated_at' || $element['field_name'] == 'm_datetime')
					{
						$update .= "\t\t\$values['{$element['field_name']}'] = _BEAR_DATETIME;\n";
					}
				}
				if($element['primary'] == "PRIMARY")
				{
					//
					$primaryKeys[] = $element['field_name'];
					$i++;
				}
			}
			$create .= "\t\t\$result = \$this->_query->insert(\$values);\n"
					."\t\tif(\$this->_query->isError(\$result)){\n"
					."\t\t\treturn false;\n"
					."\t\t}\n";
			if($i == 1)
			{
				$create .= "\t\treturn \$this->_db->lastInsertId(\$this->_table, '{$primaryKeys[0]}');\n";
				$update .= "\t\t\$where = \"{$primaryKeys[0]} =\" . \$this->_db->quote(\$values['{$primaryKeys[0]}'], 'integer');\n";
				$delete .= "\t\t\$where = \"{$primaryKeys[0]} =\" . \$this->_db->quote(\$values['{$primaryKeys[0]}'], 'integer');\n"
						."\t\t\$result = \$this->_query->delete(\$where);\n"
						."\t\treturn \$result;\n";

			}else{
				$create .= "\t\treturn true;\n";
			}
			$read .= "\t\t\$sql = \"SELECT * FROM {$array['database']['table_name']}\";\n"
					."\t\t\$result = \$this->_query->select(\$sql, array(), \$values);\n"
                    ."\t\treturn \$result;\n";
			$update .= "\t\t\$result = \$this->_query->update(\$values, \$where);\n"
				."\t\tif(\$this->_query->isError(\$result)){\n"
				."\t\t\treturn false;\n"
				."\t\t}";
			$delete .= "";
		}
		$body = str_replace("{create}", $create, $body);
		$body = str_replace("{update}", $update, $body);
		$body = str_replace("{delete}", $delete, $body);
		$body = str_replace("{read}", $read, $body);
		return $body;

	}
}