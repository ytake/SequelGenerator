<?php
/**
 * Smarty.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/10 15:56
 */
namespace Model\Template\Writer\Framework\Bear\Saturday;
use Model\Template\Writer\Framework\Bear\Saturday\Elements\Form as Template;

/**
 * Class Smarty
 * @package Model\Template\Writer\Framework\Bear\Saturday\Elements
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class Form {

	// Soft delete field name
	const SOFT_DELETE = "is_enabled";

	/** @var \Model\Template\Writer\Framework\Bear\Saturday\Elements\Form */
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
					if($row['field_name'] == self::SOFT_DELETE)
					{
						$views .= "\t\t\$radio[] =& HTML_QuickForm::createElement('radio', null, null, '有効', '1');" . "\n"
							."\t\t\$radio[] =& HTML_QuickForm::createElement('radio', null, null, '無効', '0');" . "\n"
							."\t\t\$this->_form->addGroup(\$radio, \"{$row['field_name']}\", \"{$row['field_name']}\");\n";
					}else{
						if($row['primary'] == "PRIMARY")
						{
							$views .= "\t\t\$this->_form->addElement('hidden', \"{$row['field_name']}\", \$values['{$row['field_name']}'], '');\n";

						}else{
							$views .= "\t\t\$this->_form->addElement('text', \"{$row['field_name']}\", \"{$row['field_name']}\", '');\n";
							if($row['null'] == "NOT NULL")
							{
								$views .= "\t\t\$this->_form->addRule(\"{$row['field_name']}\", \"{$row['display_name']}を入力して下さい。\", \"required\");\n";
							}
						}
					}
				}
			}
		}
		return str_replace("{elements}", $views, $this->template->getTemplate());
	}
}