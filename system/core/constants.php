<?php
if(!defined('DS')){
define('DS',DIRECTORY_SEPARATOR);
}
// global const
define('ERR_SUCCESS',0);
define('ERR_CVACCESS',403);
define('ERR_CVENABLE',502);
define('ERR_CVDISABLE',501);
define('ERR_CVEXIST',404);


define('ACCESS_ANY',1000);
define('ACCESS_USER',500);
define('ACCESS_MODERATOR',200);
define('ACCESS_EDITOR',100);
define('ACCESS_SYSTEM',10);
define('ACCESS_ADMIN',0);

$url=(isset($_SERVER['HTTPS']))?'https://'.dirname($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']).'/':'http://'.dirname($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']).'/';
define('HOST_URL',$url);

// app scheme dirs
define('APP_M',DS.'application'.DS.'models'.DS);
define('APP_C',DS.'application'.DS.'controllers'.DS);
define('APP_V',DS.'application'.DS.'views'.DS);
define('APP_LIB',DS.'application'.DS.'libriares'.DS);
define('APP_THEMES',DS.'application'.DS.'templates'.DS);
define('APP_LANG',DS.'application'.DS.'languages'.DS);
// sys scheme dirs
define('SYS_M',DS.'system'.DS.'models'.DS);
define('SYS_C',DS.'system'.DS.'controllers'.DS);
define('SYS_V',DS.'system'.DS.'views'.DS);
define('SYS_LIB',DS.'system'.DS.'libriares'.DS);
define('SYS_THEMES',DS.'system'.DS.'templates'.DS);
define('SYS_LANG',DS.'system'.DS.'languages'.DS);
// global dirs
define('CORE',DS.'system'.DS.'core'.DS);
define('LIB',DS.'libriares'.DS);
?>