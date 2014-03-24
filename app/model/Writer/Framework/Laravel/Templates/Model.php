<?php
namespace Model\Writer\Framework\Laravel\Templates;
use Model\Writer\TemplateInterface;
/**
 * Class Model
 * @package Model\Writer\Framework\Laravel
 * @author  yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class Model implements TemplateInterface {

	/**
	 * @return string|void
	 */
	public function get()
	{
		return <<<EOD
<?php
namespace Models{namespace};
use Carbon\Carbon;

class {class}
{
	const CACHE_KEY = "{table_name}";

	public function get{method}All(){
		return \DB::connection()->table('{table_name}')->get();
	}

	/**
	 * @param integer \$id
	 */
	public function get{method}(\$id)
	{
		return \DB::connection()->table('{table_name}')
			->where('{primary}', \$id)->first();
	}

	/**
	 * @param array \$array
	 * @return \stdClass
	 */
	public function update{method}(array \$array, \$id)
	{
{update}
		return \DB::connection()->table('{table_name}')
			->where('{primary}', \$id)->update(\$array);
	}

	/**
	 * @param array \$array
	 * @return \stdClass
	 */
	public function insert{method}(array \$array)
	{
{insert}
		return \DB::connection()->table('{table_name}')->insertGetId(\$array);
	}

	/**
	 * example).
	 * \DB::connection('master')->table()
	 * \DB::connection('slave')->table()
	 */
}
EOD;
	}
} 