<?php
namespace Model\Writer\Framework\Laravel;
use Model\Writer\CreateInterface;
use Model\Writer\Framework\Laravel\Templates\Controller as Template;

/**
 * Class Controller
 * @package Model\Writer\Framework\Laravel
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Controller implements CreateInterface
{
	/** @var \Model\Writer\Framework\Laravel\Controller */
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
	 * @return mixed|string|void
	 */
	public function create(array $array)
	{
		$template = $this->template->get();
		if(count($array))
		{
			if(isset($array['database']))
			{
				$templateName = str_replace('_', '.', $array['database']['table_name']);
				$classNames = explode("_", $array['database']['table_name']);
				$class = end($classNames);
				array_pop($classNames);
				if(count($classNames))
				{
					array_walk($classNames, function(&$value) use(&$space){
						$space .= "\\".ucwords($value);
					});
					$namespace = $space;
				}else{
					$namespace = null;
				}
				$template = str_replace("{namespace}", $namespace, $template);
				$template = str_replace("{class}", ucwords($class), $template);
				$template = str_replace("{template}", $templateName, $template);
			}
		}
		return $template;
	}
} 