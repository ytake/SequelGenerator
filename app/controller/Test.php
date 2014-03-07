<?php
namespace Controller;

/**
 * Reader.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/04 16:08
 */
class Test extends \Comnect\Console\Controller
{
	/** @var \Model\Template\Excel\Reader */
	protected $reader;
	/** @var \Comnect\Support\Config */
	protected $config;

	/**
	 * @param \Model\Template\Excel\Reader $reader
	 * @param Config $config
	 */
	public function __construct()
	{
	}

	/**
	 * @param array $array
	 * @return mixed|void
	 */
	public function perform(array $array)
	{
		//$configure = $this->config->get('config');
		//$file = $configure['file_path'] . "/app/storage/template/template.xls";

		//$this->reader->read($file);
	}
}