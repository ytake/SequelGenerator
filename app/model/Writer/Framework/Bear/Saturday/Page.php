<?php
/**
 * Smarty.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/10 15:56
 */
namespace Model\Writer\Framework\Bear\Saturday;
use Model\Writer\Framework\Bear\Saturday\Templates\Page as Template;

/**
 * Class Page
 * @package Model\Writer\Framework\Bear\Saturday
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class Page {

	/** @var \Model\Writer\Framework\Bear\Saturday\Templates\Page */
	protected $template;

	/**
	 * @param Template $template
	 */
	public function __construct(Template $template)
	{
		$this->template = $template;
	}

	/**
	 * @param array $array
	 * @return array
	 */
	public function create(array $array)
	{
		$views = null;
		return str_replace("{elements}", $views, $this->template->get());
	}
}