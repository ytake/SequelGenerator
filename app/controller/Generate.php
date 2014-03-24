<?php
namespace Controller;
use Comnect\Support\Config;
use Comnect\Console\Controller;
use Model\ReadInterface;
use Model\Database\SchemeInterface;
use Model\Framework\WriterInterface;

/**
 * Class Generate
 * @package Controller
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Generate extends Controller {

	/** @var \Model\Excel\Reader */
	protected $reader;
	/** @var \Comnect\Support\Config */
	protected $config;
	/** @var \Model\Framework\WriterInterface  */
	protected $writer;
	/** @var \Model\Writer\Database\Mysql\Scheme  */
	protected $database;

	/**
	 * @param ReadInterface $reader
	 * @param Config $config
	 */
	public function __construct(ReadInterface $reader, Config $config, WriterInterface $writer, SchemeInterface $database)
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
		// scheme parse
		$parseData = $this->reader->read($file);
		// create database scheme
		$this->database->prepare($parseData)->write($output);
		// create framework template
		$this->writer->prepare($parseData)->write($output);
	}
}