<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'bootstrap.php');
?>
<?php
Helper::Session_Start();
Helper::Inc(CORE.'router');
//Helper::Inc(CORE.'intl');
Config::Init();

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

Config::$data['default']['database']['type'] = 'sqlite';
    Config::$data['default']['cpu_limit'] = 15;
        //$model = new stdClass;
        //$views = new CoreRender;
        if(Helper::Get('access'))
        Helper::Session_Set('user_access',Helper::Get('access'));
        else
        if(!Helper::Session('user_access'))
        Helper::Session_Set('user_access',500);

		if(Helper::Get('setlocale')){
			Helper::Session_Set('locale',Helper::Get('setlocale'));
		} 
/*
		if(!Helper::Session('locale'))
				Helper::Session_Set('locale',Intl::get_browser_lang($langs));
				Intl::load_locale_simple(Helper::Session('locale'),'main_index');
*/

        //echo Helper::Session('locale');
		//var_dump($strings);
		//echo Intl::_('Comments are closed','main_index');
        $loader = new Loader;
        
        //echo htmlspecialchars_decode( Router::sys_routed($array,$disabled)->asXml());
        //echo $loader->showsys('layout','layout');
        //Loader::show_module(SYS.C.'phpexample',SYS.V.'phpexample');
        //echo $loader->showsys('phpcall','phpcall');
        Config::$data['enabled'][0] = SYS.C.'xslexample'; 
        if(Helper::Get('load')=="php"){
            Loader::show_restricted_view(SYS.C.'phpexample',SYS.V.'phpexample');
		} elseif(Helper::Get('load')=="xsl"){
            Loader::show_restricted_view(SYS.C.'xslexample',SYS.V.'xslexample');
		} elseif(Helper::Get('load')=="theme"){
            Loader::show_restricted_view(SYS.C.'theme',SYS.THEMES.'default'.DS.'theme');
		} elseif(Helper::Get('load')=="route"){
            Loader::show_restricted_view(SYS.C.'route',SYS.V.'route');
		} elseif(Helper::Get('load')=="test"){
            Helper::Inc('test');
		} elseif(Helper::Get('load')=="layout") {
            Loader::show_restricted_view(SYS.C.'layout',SYS.V.'layout');
		} else {
            Loader::show_restricted_view(SYS.C.'xslexample',SYS.V.'xslexample');
		}      
       // Loader::get_module_show(SYS.C.'layout',SYS.THEMES.'default'.DS.'theme');
        //$test = Helper::Call(SYS.C.'layout',SYS.V.'layout');
        //var_dump($test);
        //$test->Show();
        //$model = new stdClass;
        //$views = new Core();
        //$next = $views->Controller(SYS.C.'view');
        //$start = $loader->Controller(SYS.C.'index');
        
        //$next->show();
        //$start->show();
        //var_dump($next);
        //var_dump($start);
        ?>
    <?php
        //Encryption:

        //print "My Decrypted Text: ". $decryptedText;

		//echo Intl::_('Comments are closed','main_index');
?>