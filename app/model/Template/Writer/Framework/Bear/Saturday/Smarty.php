<?php
/**
 * Smarty.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/10 15:56
 */
namespace Model\Template\Writer\Framework\Bear\Saturday;
use Model\Template\Writer\Framework\Bear\Saturday\Elements\Smarty as Template;

/**
 * Class Smarty
 * @package Model\Template\Writer\Framework\Bear\Saturday\Elements
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class Smarty {

	/** @var \Model\Template\Writer\Framework\Bear\Saturday\Elements\Smarty */
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
		$views = null;
		if(count($array))
		{
			foreach($array as $row)
			{
				// 内部的に挿入する様なfiledは入力フォームを作成しない
				if($row['field_name'] != '' && (
						$row['field_name'] != "created_at" && $row['field_name'] != "updated_at" && $row['field_name'] != "deleted_at"
						&& $row['field_name'] != "r_datetime" && $row['field_name'] != "m_datetime"
				))
				{
					$views .= "\t<div>\n\t\t{\$form.{$row['field_name']}.label}\n\t</div>\n"
							."\t<div>\n\t\t{\$form.{$row['field_name']}.error}\n\t\t{\$form.{$row['field_name']}.html}\n\t</div>\n";
				}
			}
		}
		return str_replace("{elements}", $views, $this->template->getTemplate());
	}
}