<?php
namespace Model\Writer\Framework\Laravel\Templates;
use Model\Writer\TemplateInterface;

/**
 * Class Controller
 * @package Model\Writer\Framework\Laravel\Templates
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Controller implements TemplateInterface {

	/**
	 * @return string|void
	 */
	public function get()
	{
		return <<<EOD
<?php
namespace Controller{namespace};

class {class}Controller extends \BaseController
{
	// session keys
	const SESSION_KEY = '{template}:';

	public function __construct()
	{

	}

	public function getForm()
	{
		\$view = \View::make('{template}.form');
		\Session::put(self::SESSION_KEY, \Session::token());
		// example). view assign
		//\$view->with('something', \$something);
		return \$view;
	}

	public function postConfirm()
	{
		if(!\Session::get(self::SESSION_KEY))
		{
			return \Redirect::to("/");
		}
		\$validator = \Validator::make(\Input::all(), []);

		if (\$validator->fails())
		{
			return \Redirect::to("/")->withErrors(\$validator)->withInput();
		}
		\$view = \View::make('{template}.confirm');
		return \$view;
	}

	public function postApply()
	{
		if(!\Session::get(self::SESSION_KEY))
		{
			return \Redirect::to("/");
		}
		//
		if(\Input::get('_return'))
		{
			return \Redirect::to("/")->withInput();
		}
		//
		\Session::forget(self::SESSION_KEY);
		if(\Input::get('_apply'))
		{
			// something else..
		}
		\$view = \View::make('{template}.apply');
		return \$view;
	}

	public function getList()
	{
		\$view = View::make('{template}.list');
		return \$view;
	}
}
EOD;
	}
} 