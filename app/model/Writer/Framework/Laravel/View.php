<?php
namespace Model\Writer\Framework\Laravel;
use Model\Writer\CreateInterface;
use Model\Writer\Framework\Laravel\Templates\View as Template;

/**
 * Class View
 * @package Model\Writer\Framework\Laravel
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class View implements CreateInterface
{
	// Soft delete field name
	const SOFT_DELETE = "is_enabled";

	/** @var \Model\Writer\Framework\Laravel\View */
	protected $template;
	/** @var array  */
	protected $form = array(
		'form' => 'confirm',
		'confirm' => 'apply'
	);

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
		$blade = array();
		$templates = array();
		if(count($array))
		{
			if(isset($array['database']))
			{
				foreach($this->form as $key => $form)
				{
					$template = $this->template->get();
					$action = str_replace('_', '/', $array['database']['table_name']);
					$blade[$key][] = "{{Form::open(['url' => '/$action/$form', 'method' => 'post'}}";

					foreach($array['elements'] as $element)
					{
						if($element['primary'] == "PRIMARY")
						{
							$blade[$key][] = "\t{{Form::hidden('{$element['field_name']}', Input::get('{$element['field_name']}'))}}";
						}else{
							if($key == 'form')
							{
								if($element['field_name'] != ''  && (
									$element['field_name'] != "created_at" && $element['field_name'] != "updated_at" && $element['field_name'] != "deleted_at"
									&& $element['field_name'] != "r_datetime" && $element['field_name'] != "m_datetime"
								))
								{

									// sof delete
									if($element['field_name'] == self::SOFT_DELETE)
									{
										$blade[$key][] = "\t{{Form::radio('{$element['field_name']}', '1', (isset(\$data->{$element['field_name']}) && \$data->{$element['field_name']} == '1') ? true : true)}}:{$element['display_name']}";
										$blade[$key][] = "\t{{Form::radio('{$element['field_name']}', '0', (isset(\$data->{$element['field_name']}) && \$data->{$element['field_name']} == '0') ? true : false)}}:{$element['display_name']}";
									// FK指定
									}elseif($element['foreign_key'] != ''){

										$blade[$key][] = "\t{{Form::label('{$element['field_name']}', '{$element['display_name']}')}}\n"
											."\t{{Form::select('{$element['field_name']}', [], (isset(\$data->{$element['field_name']})) ? \$data->{$element['field_name']} : null)}}";

									}else{

										$blade[$key][] = "\t<div class=\"@if(\$errors->has('{$element['field_name']}'))error @endif\">\n"
											."\t\t{{Form::label('{$element['field_name']}', '{$element['display_name']}')}}\n"
											."\t\t{{\$errors->first('{$element['field_name']}')}}\n"
											."\t\t{{Form::text('{$element['field_name']}', (isset(\$data->{$element['field_name']})) ? \$data->{$element['field_name']} : null, []}}\n"
											."\t</div>";
									}
								}

							}else{
								if($element['field_name'] != ''  && (
										$element['field_name'] != "created_at" && $element['field_name'] != "updated_at" && $element['field_name'] != "deleted_at"
										&& $element['field_name'] != "r_datetime" && $element['field_name'] != "m_datetime"
									))
								{
									$blade[$key][] = "\t{{Input::get('{$element['field_name']}'}}\n"
										."\t{{Form::hidden('{$element['field_name']}', Input::get('{$element['field_name']}')}}";
								}
							}
						}
					}
					if($key == 'form')
					{
						$blade[$key][] = "\t{{Form::submit('登録', ['class' => ''])}}";
					}
					if($key == 'confirm')
					{
						$blade[$key][] = "\t{{Form::submit('戻る', ['class' => '', 'name' => '_return'])}}";
						$blade[$key][] = "\t{{Form::submit('登録', ['class' => '', 'name' => '_apply'])}}";
					}
					$blade[$key][] = "{{Form::close()}}";
					$templates[$key] = str_replace("{elements}", implode("\n", $blade[$key]), $template);
				}
			}
		}
		return $templates;
	}
} 