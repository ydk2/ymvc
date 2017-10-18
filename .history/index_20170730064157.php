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
    $filename = strtolower(ROOT . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . $ext);
    if(file_exists(ROOT.$filename.$ext) && is_file(ROOT.$filename.$ext)){
        require_once(ROOT.$filename.$ext);
        return TRUE;
    }
    return FALSE;
}

spl_autoload_register('Loader');

?>
  <?php
require_once 'tmp.php';
//use \test\controllers\test as test;

$test = new \test\controllers\test\one();
var_dump($test);
?>