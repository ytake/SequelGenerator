<?php
namespace Model\Writer\Framework;
use Exceptions\WriterErrorException;
use Model\File;
use Model\Framework\WriterInterface;
use Model\Writer\Framework\Laravel\Controller;
use Model\Writer\Framework\Laravel\Model;
use Model\Writer\Framework\Laravel\View;

/**
 * Class Laravel
 * @package Model\Writer\Framework
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class Laravel implements WriterInterface {

	/** @var array  */
	protected $scheme = array(
		'view' => array(),
		'validator' => array(),
		'controller' => array(),
		'model' => array(),
		'migrate' => array()
	);

	/** @var \Model\Writer\Framework\Laravel\Controller */
	protected $controller;
	/** @var \Model\Writer\Framework\Laravel\Model */
	protected $model;
	/** @var \Model\Writer\Framework\Laravel\View */
	protected $view;

	public function __construct(Controller $controller, Model $model, View $view)
	{
		$this->controller = $controller;
		$this->model = $model;
		$this->view = $view;
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
					$this->scheme['view'][$row['database']['table_name']] = $this->view->create($row);
					//$this->scheme['validator'][$row['database']['table_name']] = $this->validator->create($row['elements']);
					$this->scheme['controller'][$row['database']['table_name']] = $this->controller->create($row);
					$this->scheme['model'][$row['database']['table_name']] = $this->model->create($row);
					//$this->scheme['migrate'][$row['database']['table_name']] = $this->migrate->create($row);
				}
			}
		}

		return $this;
	}
}