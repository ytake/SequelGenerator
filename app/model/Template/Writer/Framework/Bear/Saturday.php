<?php
/**
 * Saturday.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/07 17:51
 */
namespace Model\Template\Writer\Framework\Bear;
use Model\Template\WriterInterface;
use Model\Template\Writer\Framework\Bear\Saturday\Form;
use Model\Template\Writer\Framework\Bear\Saturday\Page;
use Model\Template\Writer\Framework\Bear\Saturday\Smarty;

/**
 * Class Saturday
 * @package Model\Template\Writer\Framework\Bear
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class Saturday implements WriterInterface {

	/** @var \Model\Template\Writer\Framework\Bear\Saturday\Smarty */
	protected $view;
	/** @var \Model\Template\Writer\Framework\Bear\Saturday\Form */
	protected $form;
	/** @var \Model\Template\Writer\Framework\Bear\Saturday\Page */
	protected $page;

	public function __construct(Smarty $view, Form $form, Page $page)
	{
		$this->view = $view;
		$this->form = $form;
		$this->page = $page;
	}

	/**
	 * @param array $array
	 * @return mixed|void
	 */
	public function write(array $array)
	{
		foreach($array as $row)
		{
			if(count($row['database']))
			{
				if(count($row['elements']))
				{
					//var_dump($this->view->create($row['elements']));
					var_dump($this->form->create($row['elements']));
					var_dump($this->page->create(array()));
					//$elements = $this->createElement($row['elements'], $row['indexes'], $row['database']['engine'], $row['database']['table_name']);
					//$dbTemplate = str_replace("{elements}", $elements, $dbTemplate);
				}else{
					//$dbTemplate = str_replace("{elements}", "", $dbTemplate);
				}
			}
		}
	}
}