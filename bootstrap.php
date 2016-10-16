<?php
if(!defined('DS')){
define('DS',DIRECTORY_SEPARATOR);
}
define('ROOT',dirname(__FILE__).DS);
define('EXT','.php');
define('VIEW','.html');
define('XSL','.xsl');
define('SQL','posql');
define('DEBUG',null);
define('MEDIA_LEN',100);
define('INDEX', 'start');
define('LANG', 'en');
define('DBPREFIX', '');
require_once(ROOT.'system'.DS.'core'.DS.'constants.php');
require_once(ROOT.CORE.'helper'.EXT);
Helper::Inc(CORE.'loader');
Helper::Inc(CORE.'phprender');
Helper::Inc(CORE.'xslrender');
Helper::Inc(CORE.'intl');
Helper::Inc(CORE.'config');
Helper::Inc(CORE.'dbconnect');
Helper::Inc(CORE.'systemexception');
Helper::Inc(SYS.HELP.'functions');


?>