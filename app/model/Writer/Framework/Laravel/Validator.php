<?php
namespace Model\Writer\Framework\Laravel;
use Model\Writer\CreateInterface;
use Model\Writer\Framework\Laravel\Templates\Validator as Template;

/**
 * Class Controller
 * @package Model\Writer\Framework\Laravel
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Validator implements CreateInterface
{
	/** @var \Model\Writer\Framework\Laravel\Validator */
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
	 * @return string|void
	 */
	public function create(array $array)
	{
		$template = $this->template->get();
		$validator = array();

		if(count($array))
		{
			foreach($array as $row)
			{
				if($row['field_name'] != '')
				{
					if($row['primary'] == '')
					{
						$rules = array();
						if($row['field_name'] != ''  && (
								$row['field_name'] != "created_at" && $row['field_name'] != "updated_at"
								&& $row['field_name'] != "deleted_at" && $row['field_name'] != "r_datetime"
								&& $row['field_name'] != "m_datetime"
							))
						{
							if($row['null'] == 'NOT NULL')
							{
								//$validateData = "\"{$row['field_name']}\" => ";
								$rules[] = "required";
							}
							if(strstr(strtoupper($row['field_type']), 'INT'))
							{
								$rules[] = "max:{$row['length']}";
								$rules[] = "numeric";
							}
							if(strstr(mb_strtolower($row['field_name']), 'mail'))
							{
								$rules[] = "email";
							}
							//
							if(count($rules))
							{
								$validator[] = "\t\"{$row['field_name']}\" => \"" . implode("|", $rules) . "\"";
							}
						}
					}
				}
			}
		}
		//
		if($validator)
		{
			$validateTemplate = str_replace("{elements}", implode(",\n", $validator), $template);

		}else{
			$validateTemplate = $template;
		}
		return $validateTemplate;
	}
} 