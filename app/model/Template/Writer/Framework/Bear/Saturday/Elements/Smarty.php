<?php
/**
 * Smarty.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/10 15:47
 */
namespace Model\Template\Writer\Framework\Bear\Saturday\Elements;

/**
 * Class Smarty
 * @package Model\Template\Writer\Database\Mysql\Stub
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class Smarty {

	/**
	 * form
	 * @return string
	 */
	public function getTemplate()
	{
		return "<form{\$form.attributes}>\n"
				."\t{\$form.hidden}\n"
					."{elements}"
				."\t<div>\n"
					."\t\t{\$form._freeze.html}\n"
					."\t\t{\$form.qf_group_1._modify.html}&nbsp;&nbsp;{\$form.qf_group_1._action.html}\n"
				."\t</div>\n"
				."</form>";
	}
}