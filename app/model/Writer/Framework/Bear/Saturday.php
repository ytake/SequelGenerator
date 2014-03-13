<?php
/**
 * Saturday.php
 * @author yuuki.takezawa<yuuki.takezawa@excite.jp>
 * 2014/03/07 17:51
 */
namespace Model\Writer\Framework\Bear;
use Exceptions\WriterErrorException;
use Model\File;
use Model\Framework\WriterInterface;
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
	/** @var \Model\File */
	protected $file;

	/** @var array  */
	protected $scheme = array(
		'view' => array(),
		'form' => array(),
		'page' => array(),
		'resource' => array()
	);

	/**
	 * @param Smarty $view
	 * @param Form $form
	 * @param Page $page
	 * @param Resource $resource
	 */
	public function __construct(Smarty $view, Form $form, Page $page, Resource $resource, File $file)
	{
		$this->view = $view;
		$this->form = $form;
		$this->page = $page;
		$this->resource = $resource;
		$this->file = $file;
	}

	/**
	 * @param string $output
	 * @return mixed|void
	 */
	public function write($output)
	{
		if(!count($this->scheme)){
			throw new WriterErrorException('parse data not found', 500);
		}
		// extract
		foreach($this->scheme as $arrayKey => $element)
		{
			if(!$this->file->isDirectory("$output/$arrayKey"))
			{
				if(!$this->file->makeDirectory("$output/$arrayKey"))
				{
					throw new WriterErrorException("cannot create directory \"$output/$arrayKey\": Permission denied", 500);
				}
			}
			//
			foreach($element as $key => $row)
			{
				if($arrayKey == "view")
				{
					$this->file->put("$output/$arrayKey/$key.tpl", $row);
				}else{
					$this->file->put("$output/$arrayKey/$key.php", $row);
				}
			}
		}
	}

	/**
	 * @param array $array
	 * @return array|mixed
	 */
	public function prepare(array $array)
	{
		foreach($array as $row)
		{
			if(count($row['database']))
			{
				if(count($row['elements']))
				{
					$this->scheme['view'][$row['database']['table_name']] = $this->view->create($row['elements']);
					$this->scheme['form'][$row['database']['table_name']] = $this->form->create($row['elements']);
					$this->scheme['page'][$row['database']['table_name']] = $this->page->create(array());
					$this->scheme['resource'][$row['database']['table_name']] = $this->resource->create($row);
				}
			}
		}
		return $this;
	}
}