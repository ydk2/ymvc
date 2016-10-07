<?php

/**
 *
 */

class Router {
	private static $loader;
	private static $data;

	static function app_routed($array = NULL, $disabled=array()) {
		if ($array != NULL) {
			self::$data = new SimpleXMLElement('<data/>', LIBXML_NOCDATA || LIBXML_NOENT );
			//$retval = 
			self::$loader = new loader;
			foreach ($array as $controller => $view) {
				if(!in_array($controller,$disabled))
				self::DataSet(self::$data,'section', self::$loader->returnapp($controller, $view)) ;
				//echo self::$loader->returnapp($controller, $view);
			}
			return self::$data;
		} else {
			return false;
		}
	}

	static function sys_routed($array = NULL, $disabled=array()) {
		if ($array != NULL) {
			self::$data = new SimpleXMLElement('<data/>', LIBXML_NOCDATA || LIBXML_NOENT );
			//$retval = 
			self::$loader = new loader;
			foreach ($array as $controller => $view) {
				if(!in_array($controller,$disabled))
				self::DataSet(self::$data,'section', self::$loader->returnsys($controller, $view)) ;
				//echo self::$loader->returnapp($controller, $view);
			}
			return self::$data;
		} else {
			return false;
		}
	}

	static function from_array($array) {

	}

	final private static  function DataSet($obj,$name, $value = '') {
		if($obj instanceof SimpleXMLElement){
		//	unset($obj->$name);
			$obj->addChild($name,$value);
		} else {
			$obj->$name = $newvalue;
		}
		//return (isset($obj->$name)) ? $obj->$name: '';
	}
}
?>