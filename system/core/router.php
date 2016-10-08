<?php

/**
 *
 */

class Router {
	private static $loader;
	private static $data;

	public static function routing($array=array(),$disabled=array(),$default=array(),$mode=SYS){
		$loader = new Loader;
		//$disabled = array('error','errors','data','item','action','layout');
		$controller = $default[0];
		$view = $default[1];
		self::$data = new SimpleXMLElement('<data/>', NULL );
		
		foreach ($array as $key => $value) {
			if(!in_array($key,$disabled)){
				$viewer = $loader->Load($mode.V.$value,$mode.C.$key);
				if(is_object($viewer))
				self::$data->data->addChild('content',$viewer->View());
			}
		}
		if(!isset(self::$data->data->content)){
			$viewer = $loader->Load($mode.V.$view,$mode.C.$controller);
			if(is_object($viewer)){
				unset($this->data->content);
				self::$data->data->addChild('content',$viewer->View());
			}
		}
		return self::$data->data->content;
	}

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