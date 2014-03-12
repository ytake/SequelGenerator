<?php
/**
 * Page.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/10 18:03
 */
namespace Model\Writer\Framework\Bear\Saturday\Templates;

/**
 * Class Page
 * @package Model\Template\Writer\Framework\Bear\Saturday\Elements
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class Page {

	/**
	 *
	 */
	public function getTemplate()
	{
		$views = "<?php\n"
		."require_once 'App.php';\n\n"
		."class Page_{changeMe} extends App_Page\n"
		."{\n"
		."\tpublic function onInject()\n"
		."\t{\n"
		."\t\tparent::onInject();\n"
		."\t\tif (isset(\$_POST['_freeze']))\n"
		."\t\t{\n\n"
		."\t\t\t\$formInjector = 'onInjectFreeze';\n\n"
		."\t\t}elseif(isset(\$_POST['_modify'])){\n"
		."\t\t\t\$formInjector = 'onInjectModify';\n\n"
		."\t\t}else{\n"
		."\t\t\t\$formInjector = 'onInject';\n"
		."\t\t}\n"
		."\t\t\$this->injectArg('formInjector', \$formInjector);\n"
		."\t}\n\n"
		."\tpublic function onInit(array \$args)\n"
		."\t{\n"
		."\t\tparent::onInit(\$args);\n"
		."\t\t\$options = array(\n"
		."\t\t\t'injector' => \$args['formInjector']\n"
		."\t\t);\n"
		."\t\t\$this->_form = BEAR::dependency('App_Form_{changeMe}', array(), \$options);\n"
		."\t\t\$this->_form->build(\$args);\n"
		."\t}\n\n"
		."\tpublic function onOutput()\n"
		."\t{\n"
		."\t\t\$this->display();\n"
		."\t}\n\n"
		."\tpublic function onAction(array \$submit)\n"
		."\t{\n"
		."\t\tif (isset(BEAR_Form::\$submitValue['_action']))\n"
		."\t\t{\n"
		."\t\t\t// process\n"
		."\t\t\t\$this->display('{changeMe}');\n"
		."\t\t// mod\n"
		."\t\t} elseif(isset(BEAR_Form::\$submitValue['_modify'])){\n"
		."\t\t\t\$this->_form->buildConfirmButton();\n"
		."\t\t\t\$this->display('{changeMe}');\n"
		."\t\t// confirm\n"
		."\t\t} else {\n"
		."\t\t\t\$this->_form->buildSendButton();\n"
		."\t\t\t\$this->display('{changeMe}');\n"
		."\t\t}\n"
		."\t}\n"
		."}\n"
		."App_Main::run('Page_{changeMe}');";
		return $views;
	}
}