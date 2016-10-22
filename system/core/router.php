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
		//$loader = new Loader;
		//$disabled = array('error','errors','data','item','action','layout');
		$controller = key($default);
		$view = $default[key($default)];
		$data = new SimpleXMLElement('<data><items/></data>', NULL );
		
		foreach ($array as $key => $value) {
			if(!in_array($key,$disabled)){
				$viewer = Loader::get_module($mode.C.$value,$mode.V.$key);
				if(is_object($viewer)){
				$style = $data->items->addChild('section','');

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
				$data->items->addChild('section','');
				simplexml_import_xml($data->items->section,$viewer->View());
			}
		}
		//var_dump($data);
		return $data->items->asXml();
	}

}
?>