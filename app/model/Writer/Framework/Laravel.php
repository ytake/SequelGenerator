<?php
namespace Model\Writer\Framework;
use Exceptions\WriterErrorException;
use Model\File;
use Model\Framework\WriterInterface;
use Model\Writer\Framework\Laravel\View;
use Model\Writer\Framework\Laravel\Model;
use Model\Writer\Framework\Laravel\Validator;
use Model\Writer\Framework\Laravel\Controller;
/**
 * Class Laravel
 * @package Model\Writer\Framework
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
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
	/** @var \Model\Writer\Framework\Laravel\Validator */
	protected $validator;
	/** @var \Model\File */
	protected $file;

	/**
	 * @param Controller $controller
	 * @param Model $model
	 * @param View $view
	 * @param Validator $validator
	 * @param File $file
	 */
	public function __construct(
		Controller $controller, Model $model, View $view, Validator $validator, File $file
	)
	{
		$this->controller = $controller;
		$this->model = $model;
		$this->view = $view;
		$this->validator = $validator;
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

			foreach($element as $key => $row)
			{
				if($arrayKey == "view")
				{
					foreach($row as $file => $data)
					{
						if(!$this->file->isDirectory("$output/$arrayKey/$key"))
						{
							if(!$this->file->makeDirectory("$output/$arrayKey/$key"))
							{
								throw new WriterErrorException("cannot create directory \"$output/$arrayKey\/$key\": Permission denied", 500);
							}
						}
						$this->file->put("$output/$arrayKey/$key/$file.blade.php", $data);
					}
				}elseif($arrayKey == "controller"){
					$fileName = ucfirst("{$key}Controller.php");
					$this->file->put("$output/$arrayKey/$fileName", $row);

				}else{
					$fileName = ucfirst("$key.php");
					$this->file->put("$output/$arrayKey/$fileName", $row);
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
					$this->scheme['validator'][$row['database']['table_name']] = $this->validator->create($row['elements']);
					$this->scheme['controller'][$row['database']['table_name']] = $this->controller->create($row);
					$this->scheme['model'][$row['database']['table_name']] = $this->model->create($row);
					//$this->scheme['migrate'][$row['database']['table_name']] = $this->migrate->create($row);
				}
			}
		}
		return $this;
	}
}