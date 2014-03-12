<?php
namespace Model\Writer\Framework\Laravel;
use Model\WriterInterface;

/**
 * Class Four
 * @package Model\Writer\Framework\Laravel
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class Four implements WriterInterface {

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