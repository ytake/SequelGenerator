<?php
namespace Model\Writer\Framework\Laravel;
use Model\Writer\Framework\Laravel\Templates\View as Template;

/**
 * Class View
 * @package Model\Writer\Framework\Laravel
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class View
{
	// Soft delete field name
	const SOFT_DELETE = "is_enabled";

	/** @var \Model\Writer\Framework\Laravel\View */
	protected $template;
	/** @var array  */
	protected $form = array(
		'confirm', 'apply'
	);

	/**
	 * @param Template $template
	 */
	public function __construct(Template $template)
	{
		$this->template = $template;
	}

	public function create(array $array)
	{
		$blade = array();
		if(count($array))
		{
			if(isset($array['database']))
			{
				foreach($this->form as $form)
				{
					$template = $this->template->get();
					$action = str_replace('_', '/', $array['database']['table_name']);
					$blade[$form][] = "{{Form::open(['url' => '/$action/$form', 'method' => 'post'}}";
					foreach($array['elements'] as $element)
					{
						if($element['primary'] == "PRIMARY")
						{
							$blade[$form][] = "{{Form::hidden('{$element['field_name']}', Input::get('{$element['field_name']}'))}}";
						}else{
							if($form == 'confirm')
							{
								if($element['field_name'] != ''  && (
									$element['field_name'] != "created_at" && $element['field_name'] != "updated_at" && $element['field_name'] != "deleted_at"
									&& $element['field_name'] != "r_datetime" && $element['field_name'] != "m_datetime"
								))
								{
									if($element['field_name'] == self::SOFT_DELETE)
									{
										$blade[$form][] = "{{Form::radio('{$element['field_name']}', '1', (isset(\$data->{$element['field_name']}) && \$data->{$element['field_name']} == '1') ? true : true)}}:{$element['display_name']}";
									}else{
										$blade[$form][] = "<div class=\"@if(\$errors->has('{$element['field_name']}'))error @endif\">\n"
											."{{Form::label('{$element['field_name']}', '{$element['display_name']}')}}\n"
											."{{\$errors->first('{$element['field_name']}')}}\n"
											."{{Form::text('{$element['field_name']}', (isset(\$data->{$element['field_name']})) ? \$data->{$element['field_name']} : null, []}}\n"
											."</div>";
									}
								}

							}else{
								if($element['field_name'] != ''  && (
										$element['field_name'] != "created_at" && $element['field_name'] != "updated_at" && $element['field_name'] != "deleted_at"
										&& $element['field_name'] != "r_datetime" && $element['field_name'] != "m_datetime"
									))
								{
									$blade[$form][] = "{{Input::get('{$element['field_name']}'}}\n"
										."{{Form::hidden('{$element['field_name']}', Input::get('{$element['field_name']}')}}";

								}
							}
						}
					}
				}
			}
			var_dump($blade);
		}
		return $template;
	}
} 