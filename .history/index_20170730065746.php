<?php
error_reporting(1);
define('DBDEBUG',1);
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);

define('ROOT', realpath(dirname(__FILE__)));

function Loader($class,$ext=".php"){
    $filename = strtolower(str_replace('\\', DIRECTORY_SEPARATOR, ROOT.DIRECTORY_SEPARATOR.$class) . $ext);
	if(file_exists($filename) && is_file($filename)){
    	require_once($filename);
	}
}

function Inc($class,$ext=".php"){
    $filename = strtolower(str_replace(array('\\','/'), DIRECTORY_SEPARATOR, ROOT.DIRECTORY_SEPARATOR.$class) . $ext);
    if(file_exists($filename) && is_file($filename)){
        require_once($filename);
        return TRUE;
    }
    return FALSE;
}

function View($view,$ext=".php"){
    ob_start();
    $filename = strtolower(str_replace(array('\\','/'), DIRECTORY_SEPARATOR, ROOT.DIRECTORY_SEPARATOR.$view) . $ext);
    if(file_exists($filename) && is_file($filename)){
        require_once($filename);
    }
    return ob_get_clean();
}

spl_autoload_register('Loader');

?>
<?php
use \test\controllers\test as test;

$data = new \Library\Core\Data();

$test = new test\one();

var_dump($test);
?>