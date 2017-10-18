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

require_once(dirname(__FILE__).DS.'config.php');
define('DEBUG',null);
define('MEDIA_LEN',100);
define('INDEX', 'start');
define('LANG', 'en');
define('DBPREFIX', '');

/*
require_once(dirname(__FILE__).DS.'libriares'.DS.'core'.DS.'constants.php');
require_once(ROOT.CORE.'helper'.EXT);
Helper::Inc(CORE.'loader');
Helper::Inc(CORE.'render');
Helper::Inc(CORE.'phprender');
Helper::Inc(CORE.'xslrender');
Helper::Inc(CORE.'intl');
Helper::Inc(CORE.'config');
Helper::Inc(CORE.'dbconnect');
Helper::Inc(CORE.'systemexception');
Helper::Inc(CORE.'staticcache');
Helper::Inc(HELP.'functions');
Helper::Inc(CORE.'layout');

// db connection

Config::Init();
Config::$data['default']['database']['name'] = DBNAME;
Config::$data['default']['database']['host'] = DBHOST;
Config::$data['default']['database']['user'] = DBUSER;
Config::$data['default']['database']['pass'] = DBPASS;
Config::$data['default']['database']['type'] = DBTYPE;
*/
?>