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
	public function get()
	{
		return <<<EOD
<?php
require_once 'App.php';
class Page_{changeMe} extends App_Page{

	public function onInject(){
		parent::onInject();
		if (isset(\$_POST['_freeze'])){
			\$formInjector = 'onInjectFreeze';

		}elseif(isset(\$_POST['_modify'])){
			\$formInjector = 'onInjectModify';

		}else{
			\$formInjector = 'onInject';
		}
		\$this->injectArg('formInjector', \$formInjector);
	}

	public function onInit(array \$args){
		parent::onInit(\$args);
		\$options = array(
			'injector' => \$args['formInjector']
		);
		\$this->_form = BEAR::dependency('App_Form_{changeMe}', array(), \$options);
		\$this->_form->build(\$args);
	}

	public function onOutput(){
		\$this->display();
	}

	public function onAction(array \$submit){
		// apply
		if (isset(BEAR_Form::\$submitValue['_action'])){
			\$this->display('{changeMe}');
		// modify
		} elseif(isset(BEAR_Form::\$submitValue['_modify'])){
			\$this->_form->buildConfirmButton();
			\$this->display('{changeMe}');
		// confirm
		} else {
			\$this->_form->buildSendButton();
			\$this->display('{changeMe}');
		}
	}
}
\$options = array();
App_Main::run('Page_{changeMe}', \$options);
EOD;
	}
}