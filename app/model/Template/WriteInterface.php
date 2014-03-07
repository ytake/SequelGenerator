<?php
/**
 * WriteInterface.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/07 17:52
 */
namespace Model\Template;
/**
 * Interface WriterInterface
 * @package Model\Template
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
interface WriterInterface {

	/**
	 * @param array $array
	 * @return mixed
	 */
	public function write(array $array);
}