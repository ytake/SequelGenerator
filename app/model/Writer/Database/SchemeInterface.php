<?php
namespace Model\Database;
/**
 * Interface SchemeInterface
 * @package Model
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
interface SchemeInterface {

	/**
	 * @param array $array
	 * @return mixed
	 */
	public function prepare(array $array);

	/**
	 * @param $output
	 * @return mixed
	 */
	public function write($output);
}