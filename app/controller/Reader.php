<?php
namespace Controller;

use Comnect\Support\Config;

/**
 * Reader.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/04 16:08
 */
class Reader extends \Comnect\Console\Controller
{
	/** @var \Model\Template\Reader */
	protected $reader;
	/** @var \Comnect\Support\Config */
	protected $config;

	/**
	 * @param \Model\Template\Reader $reader
	 * @param Config $config
	 */
	public function __construct(\Model\Template\Reader $reader, Config $config)
	{
		$this->reader = $reader;
		$this->config = $config;
	}

	/**
	 * @param array $array
	 * @return mixed|void
	 */
	public function perform(array $array)
	{
		$configure = $this->config->get('config');
		$file = $configure['file_path'] . "/app/storage/template/template.xls";

		$this->reader->read($file);
	}
}