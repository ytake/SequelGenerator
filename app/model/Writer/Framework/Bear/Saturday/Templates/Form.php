<?php
namespace Model\Writer\Framework\Bear\Saturday\Templates;

/**
 * Class Form
 * @package Model\Writer\Framework\Bear\Saturday\Templates
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class Form {

	/**
	 * form
	 * @return string
	 */
	public function getTemplate()
	{
		return "<?php\n"
			."class App_Form_{changeMe} extends BEAR_Base {\n"
				."\tconst REQUIRED_TEMPLATE = '';\n"
				."\tconst ERROR_TEMPLATE = '{if \$error}<h4 class=\"alert_error\">{\$error}</h4>{/if}';\n\n"
				."\tpublic function onInject(){\n"
					."\t\t\$this->_form = array(\n"
					."\t\t\t'formName' => 'form',\n"
					."\t\t\t'method' => 'POST',\n"
					."\t\t\t'adapter'=> BEAR_Form::RENDERER_SMARTY_ARRAY\n"
					."\t\t\t'callback' => array(__CLASS__, 'onRenderer')\n"
					."\t\t);\n"
				."\t}\n\n\n"
				."\tpublic function onInjectFreeze(){\n"
					."\t\t\$this->_form = array(\n"
					."\t\t\t'formName' => 'form',\n"
					."\t\t\t'method' => 'POST',\n"
					."\t\t\t'adapter'=> BEAR_Form::RENDERER_SMARTY_ARRAY\n"
					."\t\t\t'callback' => array(__CLASS__, 'onRenderer')\n"
					."\t\t);\n"
					."\t\t\$this->_freeze = true;\n"
					."\t\t\$this->_separator = '&nbsp;';\n"
				."\t}\n\n\n"
				."\tpublic function onInjectModify(){\n"
					."\t\t\$this->_form = array(\n"
					."\t\t\t'formName' => 'form',\n"
					."\t\t\t'method' => 'POST',\n"
					."\t\t\t'adapter'=> BEAR_Form::RENDERER_SMARTY_ARRAY\n"
					."\t\t\t'callback' => array(__CLASS__, 'onRenderer')\n"
					."\t\t);\n"
				."\t}\n\n\n"
				."\tpublic function build(\$values){\n"
					."\t\t\$this->_form = BEAR::factory('BEAR_Form', \$this->_form);\n"
					."\t\t\$defaultValue = array();\n"
					."{elements}"
					."\t\t//set default values\n"
					."\t\t\$this->_form->setDefaults(array());\n"
					."\t\treturn \$this;\n"
				."\t}\n\n"
				."\tpublic function buildConfirmButton(){\n"
					."\t\t\$this->_form->addElement('submit', '_freeze', '登録情報更新', '');\n"
				."\t}\n\n"
				."\tpublic function buildSendButton(){\n"
					."\t\t\$buttons = array();\n"
					."\t\t\$buttons[] =& \$this->_form->createElement('submit', '_action', '登録', '');\n"
					."\t\t\$buttons[] =& \$this->_form->createElement('submit', '_modify', '修正', '');\n"
					."\t\t\$this->_form->addGroup(\$buttons);\n"
					."\t\t\$this->_form->freeze();\n"
				."\t}\n\n"
				."\tpublic function onRenderer(HTML_QuickForm_Renderer_ArraySmarty \$render){\n"
					."\t\t\$render->setRequiredTemplate(self::REQUIRED_TEMPLATE);\n"
					."\t\t\$render->setErrorTemplate(self::ERROR_TEMPLATE);\n"
				."\t}\n"
			."}";
	}
}