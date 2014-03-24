<?php
/**
 * ReadInterface.php
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 * 2014/03/04 16:16
 */
namespace Model;
/**
 * Interface ReadInterface
 * @package Model\Template
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
interface ReadInterface {

	/**
	 * @param $file
	 * @return mixed
	 */
	public function read($file);
}