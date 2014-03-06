<?php
/**
 * ReadInterface.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/04 16:16
 */
namespace Model\Template;
/**
 * Interface ReadInterface
 * @package Model\Template
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
interface ReadInterface {

	/**
	 * @param $file
	 * @return mixed
	 */
	public function read($file);
}