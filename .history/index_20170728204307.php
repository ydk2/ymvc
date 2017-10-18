<?php
error_reporting(1);
define('DBDEBUG',1);
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);

define('ROOT', realpath(dirname(__FILE__)));

function loader($class)
{
    $filename = strtolower(ROOT . '/' . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php');
    require_once($filename);
}
spl_autoload_register('loader');

?>
<?php
	require_once 'tmp.php';
	use \test\controllers\test as test;

	$test = new test\Test();
	var_dump($test);
?>