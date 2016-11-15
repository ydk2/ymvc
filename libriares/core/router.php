<?php
/**
* 
 * PHPRender fast and simple to use PHP MVC framework
 *
 * MVC Framework for PHP 5.2 + with PHP files views part of YMVC System
 * Router to dynamic loading controllers from GET
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
 * @subpackage Router
 * @author     ydk2 <me@ydk2.tk>
 * @copyright  1997-2016 ydk2.tk
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    2.0.1
 * @link       http://ymvc.ydk2.tk
 * @see        YMVC System
 * @since      File available since Release 2.0.0
 
 */


class Router {
	private static $loader;
	private static $data;
/**
 * route views from array
 * 
 * @param Array $array (controller => view, ...)
 * @param Array $disabled (controller,...)
 * @param Array $default (controller => view, ...) 
 * @param String $mode using Constants APP, SYS or other Path
 * @return Xml String tree
 */
	public static function routing($array=array(),$disabled=array(),$default=array(),$mode=APP){
		//$loader = new Loader;
		//$disabled = array('error','errors','data','item','action','layout');
		$controller = key($default);
		$view = $default[key($default)];
		$data = new SimpleXMLElement('<data><items/></data>', NULL );
		
		foreach ($array as $key => $value) {
			if(!in_array($key,$disabled)){
				$viewer = Loader::get_module($mode.C.$value,$mode.V.$key);
				if(is_object($viewer)){
				$style = $data->items->addChild('rows','');

				simplexml_import_xml($style,$viewer->View());

				$style->div->addAttribute('style', "display:inline; float:left;");
				//var_dump($style);
				}
			}
		}
		if(!isset($data->items->section)){
			$viewer = Loader::get_module($mode.C.$view,$mode.V.$controller);
			if(is_object($viewer)){
				unset($data->items->section);
				$data->items->addChild('rows','');
				simplexml_import_xml($data->items->section,$viewer->View());
			}
		}
		//var_dump($data);
		return $data->items->asXml();
	}

}
?>