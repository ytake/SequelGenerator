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
	public function get()
	{
		return <<<EOD
<?php
class App_Form_{changeMe} extends BEAR_Base {

	const REQUIRED_TEMPLATE = '';
	const ERROR_TEMPLATE = '{if \$error}<h4 class=\"alert_error\">{\$error}</h4>{/if}';

	public function onInject(){
		\$this->_form = array(
			'formName' => 'form',
			'method' => 'POST',
			'adapter'=> BEAR_Form::RENDERER_SMARTY_ARRAY
			'callback' => array(__CLASS__, 'onRenderer')
		);
	}

	public function onInjectFreeze(){
		\$this->_form = array(
			'formName' => 'form',
			'method' => 'POST',
			'adapter'=> BEAR_Form::RENDERER_SMARTY_ARRAY
			'callback' => array(__CLASS__, 'onRenderer')
		);
		\$this->_freeze = true;
		\$this->_separator = '&nbsp;';
	}

	public function onInjectModify(){
		\$this->_form = array(
			'formName' => 'form',
			'method' => 'POST',
			'adapter'=> BEAR_Form::RENDERER_SMARTY_ARRAY
			'callback' => array(__CLASS__, 'onRenderer')
		);
	}

	public function build(\$values){
		\$this->_form = BEAR::factory('BEAR_Form', \$this->_form);
		\$defaultValue = array();
{elements}
		//set default values
		\$this->_form->setDefaults(array());
		return \$this;
	}

	public function buildConfirmButton(){
		\$this->_form->addElement('submit', '_freeze', '登録情報更新', '');
	}

	public function buildSendButton(){
		\$buttons = array();
		\$buttons[] =& \$this->_form->createElement('submit', '_action', '登録', '');
		\$buttons[] =& \$this->_form->createElement('submit', '_modify', '修正', '');
		\$this->_form->addGroup(\$buttons);
		\$this->_form->freeze();
	}

	public function onRenderer(HTML_QuickForm_Renderer_ArraySmarty \$render){
		\$render->setRequiredTemplate(self::REQUIRED_TEMPLATE);
		\$render->setErrorTemplate(self::ERROR_TEMPLATE);
	}
}
EOD;
	}
}