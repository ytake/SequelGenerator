<?php
/**
 * Saturday.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/07 17:51
 */
namespace Model\Writer\Framework\Bear;
use Model\WriterInterface;
use Model\Writer\Framework\Bear\Saturday\Form;
use Model\Writer\Framework\Bear\Saturday\Page;
use Model\Writer\Framework\Bear\Saturday\Smarty;
use Model\Writer\Framework\Bear\Saturday\Resource;
/**
 * Class Saturday
 * @package Model\Writer\Framework\Bear
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class Saturday implements WriterInterface {

	/** @var \Model\Writer\Framework\Bear\Saturday\Smarty */
	protected $view;
	/** @var \Model\Writer\Framework\Bear\Saturday\Form */
	protected $form;
	/** @var \Model\Writer\Framework\Bear\Saturday\Page */
	protected $page;
	/** @var \Model\Writer\Framework\Bear\Saturday\Resource */
	protected $resource;

	/**
	 * @param Smarty $view
	 * @param Form $form
	 * @param Page $page
	 * @param Resource $resource
	 */
	public function __construct(Smarty $view, Form $form, Page $page, Resource $resource)
	{
		$this->view = $view;
		$this->form = $form;
		$this->page = $page;
		$this->resource = $resource;
	}

	/**
	 * @param array $array
	 * @return array|mixed
	 */
	public function write(array $array)
	{
		$return = array(
			'view' => array(),
			'form' => array(),
			'page' => array(),
			'resource' => array()
		);
		foreach($array as $row)
		{
			if(count($row['database']))
			{
				if(count($row['elements']))
				{
					$return['view'][] = $this->view->create($row['elements']);
					$return['form'][] = $this->form->create($row['elements']);
					$return['page'][] = $this->page->create(array());
					$return['resource'][] = $this->resource->create($row);
				}
			}
		}
		return $return;
	}
}