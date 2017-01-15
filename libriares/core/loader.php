<?php
/**
* 
 * PHPRender fast and simple to use PHP MVC framework
 *
 * MVC Framework for PHP 5.2 + with PHP files views part of YMVC System
 * Loader Class to easy get and show views
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
 * @subpackage Loader
 * @author     ydk2 <me@ydk2.tk>
 * @copyright  1997-2016 ydk2.tk
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    2.0.1
 * @link       http://ymvc.ydk2.tk
 * @see        YMVC System
 * @since      File available since Release 2.0.0
 
 */
class Loader {
	const XSL = 0;
	const PHP = 1;

/**
*  Load Controller Class 
* @access public
* static
* @param mixed $controller can be object or path
* @param string $view optional can set later
* @param mixed $model optional can set later, can be object or path
* @return XSLRender/PHPRender object or NULL
**/ 	
	final public static function get_module($controller,$view=NULL,$model = NULL){
		if(($controller instanceof XSLRender) || ($controller instanceof PHPRender)){
			return $controller;
		} else {
		$me = new self;
		$controller = str_replace(':',DS,$controller);
		$view = str_replace(':',DS,$view);
		if(!is_object($model) && $model!==NULL)
			$model = str_replace(':',DS,$model);
		$me->Inc(CORE.'phprender');
		$me->Inc(CORE.'xslrender');
		if($me->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
				$module= new $end($model,$view);
				return	$module;
		} 
		}
	}

/**
*  Load Controller Class and return rendered view
* @access public
* static
* @param mixed $controller can be object or path
* @param string $view optional can set later Path to view file
* @param mixed $model optional can set later, can be object or path
* @return string
**/ 
	final public static function get_module_view($controller,$view=NULL,$model = NULL){
		$module = self::get_module($controller,$view,$model);
		if(!$module) return FALSE;
		return	$module->View(); 
	}

/**
*  Load Controller Class and Print rendered view
* @access public
* static
* @param mixed $controller can be object or path
* @param string $view optional can set later Path to view file
* @param mixed $model optional can set later, can be object or path
**/ 
	final public static function show_module($controller,$view=NULL,$model = NULL){
		$module = self::get_module($controller,$view,$model);
		if(!$module) return FALSE;
		$module->Show(); 
	}

/**
*  Load Controller Class dirrectlly from Application directory and return rendered view
* @access public
* @param mixed $controller can be object or path
* @param string $view Path to view file
* @return XSLRender/PHPRender object or NULL
**/ 
	public final function returnapp($controller, $view){
		return self::get_module_view(APP.C.$controller,APP.V.$view);
	}

/**
*  Load Controller Class dirrectlly from System directory and return rendered view
* @access public
* @param mixed $controller can be object or path
* @param string $view 
* @return XSLRender/PHPRender object or NULL
**/ 
	public final function returnsys($controller, $view){
		return self::get_module_view(SYS.C.$controller,SYS.V.$view);	
	}

/**
*  Load Controller Class dirrectlly from Application directory and print rendered view
* @access public
* @param mixed $controller can be object or path
* @param string $view Path to view file
**/ 
	public final function showapp($controller, $view){
		self::show_module(APP.C.$controller,APP.V.$view);
	}
	public final function showsys($controller, $view){
		self::show_module(SYS.C.$controller,SYS.V.$view);	
	}

/**
* Class loader 
* @access public
* @param {string} $class path
* @return {boolean} 
**/
	final private function Inc($class){
		if(file_exists(ROOT.$class.EXT)  && is_file(ROOT.$class.EXT)){	
			require_once(ROOT.$class.EXT);
			return TRUE;
		}
		return FALSE;
	}


/**
*  Load Controller Class and return rendered view with restriction from configs
* @access public
* static
* @param mixed $controller can be object or path
* @param string $view optional can set later Path to view file
* @param mixed $model optional can set later, can be object or path
* @return string
**/ 
	final public static function get_restricted_view($controller,$view=NULL,$model = NULL){
		if(in_array($controller,Config::$data['enabled'])){
		$module = self::get_module($controller,$view,$model);
		if(!$module) return FALSE;
		$module->RegisterView($view);
		return	$module->View(); 
		}
		return "";
	}
/**
*  Load Controller Class and show rendered view with restriction from configs
* @access public
* static
* @param mixed $controller can be object or path
* @param string $view optional can set later Path to view file
* @param mixed $model optional can set later, can be object or path
* @return string
**/ 
	final public static function show_restricted_view($controller,$view=NULL,$model = NULL){
		if(in_array($controller,Config::$data['enabled'])){
		$module = self::get_module($controller,$view,$model);
		if(!$module) return FALSE;
		$module->RegisterView($view);
		return	$module->Show(); 
		}
		return "";
	}


	public function ordered_views($array,$disabled,$mode=SYS,$group='main'){
		sksort($array,'pos');
		$model = new stdClass;
		
		$layout = self::get_module(SYS.C.'layout:layout',SYS.V.'layout:views',$model);
		$layout->ViewData('layout', '');
		foreach ($array as $value) {
			if($value['group']==$group || $value['group']==""){
			if(in_array($mode.C.$value['module'], Config::$data['enabled']) && !in_array($mode.C.$value['module'],$disabled) && $layout->ControllerExists($mode.C.$value['module'])){
				$col = $this->data->layout->addChild('views', htmlspecialchars( self::get_restricted_view($mode.C.$value['module'],$mode.V.$value['view'])));

				if(isset($value['style'])) $col->addAttribute('style', $value['style']);
				if(isset($value['class'])) $col->addAttribute('class', $value['class']);
				if(isset($value['attrid'])) $col->addAttribute('id', $value['id']);	

			} elseif(in_array($value['module'], Config::$data['layouts'])){
				$layout->SetModule(SYS.V.'layout:views',SYS.C.'layout:layout');
				$content = $layout->GetModule(SYS.C.'layout:layout');
				$content->model->layout_group = $value['module'];
				$content = ($content)? htmlspecialchars($content->View()):"";
				$col = $this->data->layout->addChild('views', $content);

				if(isset($value['style'])) $col->addAttribute('style', $value['style']);
				if(isset($value['class'])) $col->addAttribute('class', $value['class']);
				if(isset($value['attrid'])) $col->addAttribute('id', $value['id']);	

			}
			}
		}
		return $layout->View();
	}

}
?>