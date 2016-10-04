<?php
if(!defined('DS')){
define('DS',DIRECTORY_SEPARATOR);
}
define('APP',dirname(__FILE__));
define('EXT','.php');
define('VIEW','.html');
define('XSL','.xsl');
define('SQL','posql');
define('DEBUG',null);
define('MEDIA_LEN',100);
define('INDEX', 'start');
define('LANG', 'en');
define('DBPREFIX', '');
require_once(APP.DS.'system'.DS.'core'.DS.'constants.php');
require_once(APP.CORE.'helper'.EXT);
Helper::Inc(CORE.'loader');
Helper::Inc(CORE.'corerender');
Helper::Inc(CORE.'xcorerender');
Helper::Inc(CORE.'intl');
Helper::Inc(CORE.'config');
Helper::Inc(CORE.'dbconnect');
Helper::Inc(CORE.'systemexception');
Helper::Inc(SYS_LIB.'helpers'.DS.'functions');


?>