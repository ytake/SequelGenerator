<?php
namespace Model\Writer\Framework\Laravel\Templates;
use Model\Writer\TemplateInterface;
/**
 * Class Model
 * @package Model\Writer\Framework\Laravel
 * @author  yuuki.takezawa<yuuki.takezawa@excite.jp>
 */
class View implements TemplateInterface {

	/**
	 * @return string|void
	 */
	public function get()
	{
		return <<<EOD
{{--@extends('layout.default')--}}
{{--@section('content')--}}
{elements}
{{--@stop--}}
EOD;
	}
} 