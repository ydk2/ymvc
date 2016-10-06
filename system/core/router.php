<?php

/**
 *
 */

class Router {
	private static $loader;
	private static $data;

	static function app_from_get($array = array()) {
		if ($_GET != NULL) {
			self::$data = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><data/>', null, false);
			//$retval = 
			self::$loader = new loader;
			foreach ($_GET as $controller => $view) {
				self::DataSet(self::$data,'section',self::$loader->returnapp($controller, $view));
				//echo self::$loader->returnapp($controller, $view);
			}
			return self::$data->asXML();
		} else {
			return false;
		}
	}

	static function app_from_array($array) {

	}

	static function sys_from_get($array = array()) {
		if ($_GET != NULL) {
			libxml_disable_entity_loader(true);
			self::$data = new SimpleXMLElement('<data/>', LIBXML_NOCDATA || LIBXML_NOENT );
			//$retval = 
			self::$loader = new loader;
			foreach ($_GET as $controller => $view) {
				self::DataSet(self::$data,'section', self::$loader->returnsys($controller, $view)) ;
				//echo self::$loader->returnapp($controller, $view);
			}
			return self::$data;
		} else {
			return false;
		}
	}

	static function sys_from_array($array) {

	}

	static function from_array($array) {

	}

	static function from_get($array = array()) {

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