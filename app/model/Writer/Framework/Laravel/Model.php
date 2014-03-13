<?php
namespace Model\Writer\Framework\Laravel;
use Model\Writer\Framework\Laravel\Templates\Model as Template;

/**
 * Class Model
 * @package Model\Writer\Framework\Laravel
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class Model {

	/** @var \Model\Writer\Framework\Laravel\Templates\Model  */
	protected $template;

	/**
	 * @param Template $template
	 */
	public function __construct(Template $template)
	{
		$this->template = $template;
	}

	public function create(array $array)
	{
		$template = $this->template->get();
		$primaries = array();
		$update = array();
		$insert = array();
		//
		if(count($array))
		{
			if(isset($array['database']))
			{
				$explode = explode("_", $array['database']['table_name']);
				$methodName = $explode;

				$method = null;
				$namespace = null;
				if(count($methodName))
				{
					array_walk($methodName, function(&$value) use(&$method){
						$method .= ucwords($value);
					});
				}

				$class = end($explode);
				array_pop($explode);
				if(count($explode))
				{
					array_walk($explode, function(&$value) use(&$space){
						$space .= "\\".ucwords($value);
					});
					$namespace = $space;
				}
				$template = str_replace("{namespace}", $namespace, $template);
				$template = str_replace("{method}", $method, $template);
				$template = str_replace("{class}", ucwords($class), $template);
				$template = str_replace("{table_name}", $array['database']['table_name'], $template);
			}
			if(count($array['elements']))
			{
				foreach($array['elements'] as $element)
				{
					if($element['primary'] == "PRIMARY")
					{
						$primaries[] = $element['field_name'];
					}

					if($element['field_name'] != '' && (
							$element['field_name'] == 'created_at' || $element['field_name'] == 'updated_at'
							|| $element['field_name'] == 'r_datetime' || $element['field_name'] == 'm_datetime'
						))
					{
						$insert[] = "\t\t\$array['{$element['field_name']}'] = Carbon::now()->toDateTimeString();";
						//
						if($element['field_name'] == 'updated_at' || $element['field_name'] == 'm_datetime')
						{
							$update[] =	"\t\t\$array['{$element['field_name']}'] = Carbon::now()->toDateTimeString();";
						}
					}
				}
				if(count($primaries) === 1)
				{
					$template = str_replace("{primary}", $primaries[0], $template);
				}
				$template = str_replace("{primary}", 'something else', $template);
			}
		}
		$template = str_replace("{insert}", implode("\n", $insert), $template);
		$template = str_replace("{update}", implode("\n", $update), $template);
		return $template;
	}
} 