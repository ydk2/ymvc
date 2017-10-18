<?php
error_reporting(1);
define('DBDEBUG',1);
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);

define('ROOT', realpath(dirname(__FILE__)));

function Loader($class,$ext=".php"){
    $filename = strtolower(ROOT . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . $ext);
	if(file_exists($filename) && is_file($filename)){
    	require_once($filename);
	}
}

function Inc($class,$ext=".php"){
    if(file_exists($class) && is_file($class)){
        require_once($class);
        return TRUE;
    } else
    if(file_exists(ROOT.$class.$ext) && is_file(ROOT.$class.$ext)){
        require_once(ROOT.$class.$ext);
        return TRUE;
    }
    return FALSE;
}
spl_autoload_register('Loader');

?>
  <?php
require_once 'tmp.php';
use \test\controllers\test as test;

$test = new test\Test();
var_dump($test);
?>