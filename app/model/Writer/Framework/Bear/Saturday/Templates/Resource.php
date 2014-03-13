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
		return <<<EOD
<?php
class App_Ro_{class} extends App_Ro {

{table_name}
	public function onInject(){
		parent::onInject();
		\$this->_query = BEAR::dependency('BEAR_Query', \$this->_queryConfig, false);
	}
	public function onRead(array \$values){
{read}
	}

	public function onCreate(array \$values){
{create}
	}

	public function onUpdate(array \$values){
{update}
	}

	public function onDelete(array \$values){
{delete}
	}
}
EOD;
	}
}