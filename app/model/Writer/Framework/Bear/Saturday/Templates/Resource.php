<?php
/**
 * Resource.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/12 13:45
 */
namespace Model\Writer\Framework\Bear\Saturday\Templates;

/**
 * Class Resource
 * @package Model\Template\Writer\Framework\Bear\Saturday\Elements
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class Resource{

	/**
	 * @return string
	 */
	public function get()
	{
		$template = "<?php\n"
			."class App_Ro_{class} extends App_Ro {\n\n"
			."{table_name}"
			."\tpublic function onInject(){\n\n"
			."\t\tparent::onInject();\n"
			."\t\t\$this->_query = BEAR::dependency('BEAR_Query', \$this->_queryConfig, false);\n"
			."\t}\n\n"
			."\tpublic function onRead(array \$values){\n\n"
			."{read}\n"
			."\t}\n\n"
			."\tpublic function onCreate(array \$values){\n\n"
			."{create}\n"
			."\t}\n\n"
			."\tpublic function onUpdate(array \$values){\n\n"
			."{update}\n"
			."\t}\n\n"
			."\tpublic function onDelete(array \$values){\n\n"
			."{delete}\n"
			."\t}\n\n";
		return $template;
	}
}