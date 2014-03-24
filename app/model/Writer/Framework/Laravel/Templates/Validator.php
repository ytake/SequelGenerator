<?php
namespace Model\Writer\Framework\Laravel\Templates;
use Model\Writer\TemplateInterface;
/**
 * Class Model
 * @package Model\Writer\Framework\Laravel
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Validator implements TemplateInterface {

	/**
	 * @return string|void
	 */
	public function get()
	{
		return <<<EOD
<?php
\$array = [
{elements}
];
EOD;
	}
}