<?php
/**
 * Smarty.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/10 15:47
 */
namespace Model\Writer\Framework\Bear\Saturday\Templates;

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
	public function get()
	{
		return <<<EOD
<form{\$form.attributes}>
	{\$form.hidden}
{elements}
	<div>
		{\$form._freeze.html}
		{\$form.qf_group_1._modify.html}&nbsp;&nbsp;{\$form.qf_group_1._action.html}
	</div>
</form>
EOD;
	}
}