<?php
error_reporting(1);
define('DBDEBUG',1);
ini_set('xdebug.var_display_max_depth', -1);
ini_set('xdebug.var_display_max_children', -1);
ini_set('xdebug.var_display_max_data', -1);
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'bootstrap.php');

//echo "The previous session name was $previous_id<br />";
Helper::Session_Start();
//Helper::Inc(CORE.'router');
//Helper::Inc(CORE.'intl');


/**
* @annotation
* YMVC System fast and simple to use PHP MVC framework
*
* MVC Framework for PHP 5.2 + with XSLT and PHP files views
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
* @subpackage XSLRender
* @author     ydk2 <me@ydk2.tk>
* @copyright  1997-2016 ydk2.tk
* @license    http://www.php.net/license/3_01.txt  PHP License 3.01
* @version    2.0.0
* @link       http://ymvc.ydk2.tk
* @see        PHPRender
* @since      File available since Release 1.0.0

*/

Config::$data['template']['admin'] = 'default';
Config::$data['template']['user'] = 'default';
Config::$data['template']['system'] = 'default';
Config::$data['template']['application'] = 'default';
Config::$data['template']['default'] = 'default';
Config::$data['template']['any'] = 'empty';
Config::$data['template']['user'] = 'empty';
Config::$data['template']['appid'] = 'empty';

Config::$data['time'] = get_time();
//var_dump($this);
//echo sha1("admin");

//Config::$data['default']['database']['name'] = 'database'; 
//Config::$data['default']['database']['type'] = 'sqlite';
Config::$data['default']['cpu_limit'] = 15;

if(Helper::Get('access')){
	Helper::Session_Set('user_access',Helper::Get('access'));
} else {
	if(!Helper::Session('user_access')){
		Helper::Session_Set('user_access',10);
	}
}

    $loader = new Loader;
    
    Config::$data['enabled'] = array(
    SYS.C.'other:one',
    SYS.C.'other:two',
    SYS.C.'errors:systemerror',
    SYS.C.'check:gettime',
    SYS.C.'elements:menu',
    SYS.C.'login:form',
    SYS.C.'admin:mngaccount',
    );

    Config::$data['layouts'] = array(
    'sections',
    'section'
    );

    Config::$data['default']['allowregister']=true;
    Config::$data['default']['group']='any';
    Config::$data['default']['layout']='any';
    Config::$data['inuse'] = ROOT.CACHE."inuse.data";
    Config::$data['group_data'] = ROOT.STORE."groups.data";
    Config::$data['modules_data'] = ROOT.STORE."modules.data";
    Config::$data['layout_data'] = ROOT.STORE."layouts.data";
    Config::$data['menu_data'] = ROOT.STORE."menus.data";
    Config::$data['mainitems'] = 'modules';
    Config::$data['modules']['default']=HOST.'';
    ?>
<?php
	
	$layouts = array(
		array('group'=>'index','class'=>'index','module'=>'test-test','view'=>'test-test','mode'=>'system','pos'=>'1','path'=>DS.SYS.C.'test'.DS.'test'),
		//array('module'=>'','view'=>'','mode'=>'','pos'=>''),
	);        
    $items = array();
    foreach ($layouts as $module) {
        $items[]= str_replace('/',DS,$module['path']);
    }
    $content = new Layout;
	$content->Init();
    $content->tag = 'div';
    $content->Layouts($layouts,'index',$items,array());

    echo $content->Render();
	var_dump($layouts);
?>