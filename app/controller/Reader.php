<?php
namespace Controller;
use Comnect\Support\Config;
use Model\Template\ReadInterface;
use Model\Template\Writer\Database\Mysql;
use Model\Template\Writer\Framework\Bear\Saturday;

/**
 * Reader.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/04 16:08
 */
class Reader extends \Comnect\Console\Controller
{
	/** @var \Model\Template\Excel\Reader */
	protected $reader;
	/** @var \Comnect\Support\Config */
	protected $config;
	/** @var \Model\Template\Writer\Framework\Bear\Saturday  */
	protected $writer;
	/** @var \Model\Template\Writer\Database\Mysql\Scheme  */
	protected $database;

	/**
	 * @param ReadInterface $reader
	 * @param Config $config
	 */
	public function __construct(ReadInterface $reader, Config $config, Saturday $writer, Mysql\Scheme $database)
	{
		$this->reader = $reader;
		$this->config = $config;
		$this->writer = $writer;
		$this->database = $database;
	}

	/**
	 * @param array $array
	 * @return mixed|void
	 */
	public function perform(array $array)
	{
		$configure = $this->config->get('config');
		$file = $configure['file_path'] . "/app/storage/template/template.xls";
		$output = $configure['file_path'] . "/app/storage/output";
		$parseData = $this->reader->read($file);
		$this->writer->write($parseData);
		$this->database->scheme($parseData);
	}
}