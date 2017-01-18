<?php
/**
* 
 * PHPRender fast and simple to use PHP MVC framework
 *
 * MVC Framework for PHP 5.2 + with PHP files views part of YMVC System
 * YMVC Constants 
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Framework, MVC
 * @package    YMVC System
 * @subpackage Constants
 * @author     ydk2 <me@ydk2.tk>
 * @copyright  1997-2016 ydk2.tk
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    2.0.2
 * @link       http://ymvc.ydk2.tk
 * @see        YMVC System
 * @since      File available since Release 1.0.0
 
 */
if(!defined('DS')){
define('DS',DIRECTORY_SEPARATOR);
}
// global const
define('ERR_SUCCESS',0);
define('ERR_ACCESS',20503);
define('ERR_ENABLE',20502);
define('ERR_NOMODEL',20304);
define('ERR_NOEXIST',20404);
define('ERR_NOREGISTERED',20402);
define('ERR_NODEF',20401);
define('ERR_REQUIRED',20401);


define('ACCESS_ANY',10);
define('ACCESS_USER',5);
define('ACCESS_MODERATOR',5);
define('ACCESS_EDITOR',3);
define('ACCESS_SYSTEM',2);
define('ACCESS_ADMIN',1);


$url=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')?'https://'.dirname($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']).'/':'http://'.dirname($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']).'/';
if(!defined('ROOT')){
define('HOST_URL',$url);
}
if(!defined('ROOT')){
define('ROOT',dirname(dirname(dirname(__FILE__))).DS);
}
if(!defined('S')){
define('S',":");
}
if(!defined('EXT')){
define('EXT','.php');
}
if(!defined('VIEW')){
define('VIEW','.html');
}
if(!defined('XSL')){
define('XSL','.xsl');
}
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
define('CORE',LIBS.'core'.DS);
//define('LIBS','libriares'.DS);
?>