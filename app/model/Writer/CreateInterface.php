<?php
namespace Model\Writer;

/**
 * Interface CreateInterface
 * @package Model\Writer
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
interface CreateInterface {

	/**
	 * @param array $array
	 * @return mixed
	 */
	public function create(array $array);
}