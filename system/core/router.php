<?php

/**
 *
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
		$loader = new Loader;
		//$disabled = array('error','errors','data','item','action','layout');
		$controller = key($default);
		$view = $default[key($default)];
		$data = new SimpleXMLElement('<data><items/></data>', NULL );
		
		foreach ($array as $key => $value) {
			if(!in_array($key,$disabled)){
				$viewer = $loader->Load($mode.V.$value,$mode.C.$key);
				if(is_object($viewer))
				$data->items->addChild('item',$viewer->View());
			}
		}
		if(!isset($data->items->item)){
			$viewer = $loader->Load($mode.V.$view,$mode.C.$controller);
			if(is_object($viewer)){
				unset($data->items->item);
				$data->items->addChild('item',$viewer->View());
			}
		}
		//var_dump($data);
		return $data->items->asXml();
	}

}
?>