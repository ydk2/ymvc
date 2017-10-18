<?php
if(!defined('DS')){
define('DS',DIRECTORY_SEPARATOR);
}
if(!defined('ROOT')){
define('ROOT', realpath(dirname(__FILE__)));
}

$url=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')?'https://'.dirname($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']).'/':'http://'.dirname($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']).'/';
if(!defined('HOST')){
define('HOST',$url);
}


define('DEBUG',null);
define('MEDIA_LEN',100);
define('INDEX', 'start');
define('LANG', 'en');
define('DBPREFIX', '');

function Loader($class, $ext = ".php")
{
    $filename = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ROOT . DIRECTORY_SEPARATOR . $class) . $ext);
    if (file_exists($filename) && is_file($filename)) {
        require_once ($filename);
    }
}

spl_autoload_register('Loader');

?>