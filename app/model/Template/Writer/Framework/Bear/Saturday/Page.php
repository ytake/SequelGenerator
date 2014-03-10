<?php
/**
 * Smarty.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/10 15:56
 */
namespace Model\Template\Writer\Framework\Bear\Saturday;
use Model\Template\Writer\Framework\Bear\Saturday\Elements\Page as Template;

/**
 * Class Page
 * @package Model\Template\Writer\Framework\Bear\Saturday
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class Page {

	/** @var \Model\Template\Writer\Framework\Bear\Saturday\Elements\Page */
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
		return str_replace("{elements}", $views, $this->template->getTemplate());
	}
}