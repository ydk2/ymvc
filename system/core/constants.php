<?php
if(!defined('DS')){
define('DS',DIRECTORY_SEPARATOR);
}
// global const
define('ERR_SUCCESS',0);
define('ERR_CVACCESS',12403);
define('ERR_CVENABLE',12502);
define('ERR_CVDISABLE',12501);
define('ERR_CVEXIST',12404);


define('ACCESS_ANY',1000);
define('ACCESS_USER',500);
define('ACCESS_MODERATOR',200);
define('ACCESS_EDITOR',100);
define('ACCESS_SYSTEM',10);
define('ACCESS_ADMIN',0);

$url=(isset($_SERVER['HTTPS']))?'https://'.dirname($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']).'/':'http://'.dirname($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']).'/';
define('HOST_URL',$url);
if(!defined('ROOT')){
define('ROOT',dirname(dirname(dirname(__FILE__))).DS);
}
define('EXT','.php');
define('VIEW','.html');
define('XSL','.xsl');
// app scheme dirs

define('APP','application'.DS);
define('SYS','system'.DS);
define('M','models'.DS);
define('C','controllers'.DS);
define('V','views'.DS);
define('LIBS','libriares'.DS);
define('THEMES','templates'.DS);
define('LANGS','languages'.DS);

define('HELP',LIBS.'helpers'.DS);
define('DATA',LIBS.'data'.DS);
define('VENDORS',LIBS.'vendors'.DS);
define('CONF',LIBS.'config'.DS);
define('STORE',LIBS.'stored'.DS);
define('CACHE',LIBS.'cache'.DS);
define('CLASSES',LIBS.'classes'.DS);
// sys scheme dirs
// global dirs
define('CORE',SYS.'core'.DS);
//define('LIBS','libriares'.DS);
?>