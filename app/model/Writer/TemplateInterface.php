<?php
namespace Model\Writer;
/**
 * Interface ReadInterface
 * @package Model\Template
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
interface TemplateInterface {

	/**
	 * @return string
	 */
	public function get();
}