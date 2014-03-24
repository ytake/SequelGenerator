<?php
/**
 * WriteInterface.php
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * 2014/03/07 17:52
 */
namespace Model\Framework;

/**
 * Interface WriterInterface
 * @package Model\Framework
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
interface WriterInterface {

	/**
	 * @param array $array
	 * @return mixed
	 */
	public function prepare(array $array);

	/**
	 * @param string $output
	 * @return mixed
	 */
	public function write($output);
}