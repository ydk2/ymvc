<?php
class Intl {
	const PHP = 'php';
	const PO = 'po';
	const JSON = 'json';

    public static $strings;
    public static $langlen;
    public static $lang;
    private static $path;
    private static $mode;

    private static $msgstr;
    
    public static function format($string='', $vars=array())
    {
        if (!$string) return '';
        if (count($vars) > 0)
        {
            foreach ($vars as $k=>$subs)
            {
                $string = str_replace('%'.$k, self::_($subs), $string);
            }
        }
        return $string;
    }
    
    public static function _f($string,$array=array(),$strings=array()){
		$_strings=array();
		if(is_string($strings) && isset(self::$strings[strtolower($strings)]))
		$_strings = self::$strings[strtolower($strings)];
		if(is_array($strings))
		$_strings = $strings;
        return (isset($strings[$string]) && $strings[$string]!='')?self::format($strings[$string],$array):self::format($string,$array);
    }
    public static function _($string,$strings=array()){
		$_strings=array();
		if(is_string($strings) && isset(self::$strings[strtolower($strings)]))
		$_strings = self::$strings[strtolower($strings)];
		if(is_array($strings))
		$_strings = $strings;
        return (isset($_strings[$string]) && $_strings[$string]!='')?$_strings[$string]:$string;
    }
    
    
    public static function get_browser_lang($lang=array(),$default_language_code = 'en'){
        $supported_languages = array_flip($lang);
        $http_accept_language = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
        preg_match_all('~([\w-]+)(?:[^,\d]+([\d.]+))?~', strtolower($http_accept_language), $matches, PREG_SET_ORDER);
        $available_languages = array();
        foreach ($matches as $match) {
            $language = explode('-', $match[1]) + array('', '');
            $priority = isset($match[2]) ? (float) $match[2] : 1.0;
            $available_languages[][$language[0]] = $priority;
        }
        $default_priority = (float) 0;
        foreach ($available_languages as $key => $value) {
            $language_code = key($value);
            $priority = $value[$language[0]];
            if ($priority > $default_priority && array_key_exists($language[0],$supported_languages)) {
                $default_priority = $priority;
                $default_language_code = $language[0];
            }
        }
        return $default_language_code;
    }
    
    public static function available_locales($mode=NULL){
		if(isset($mode)) self::$mode=$mode;
		if(!isset(self::$mode)) self::$mode='php';
        $array = array();
        foreach (glob(self::$path.DIRECTORY_SEPARATOR.'*.'.self::$mode) as $filename) {
            if(is_file($filename)) $array[] = basename($filename,'.'.self::$mode);
        }
        return $array;
    }
    
    public static function set_lang($lang){
        self::$lang = $lang;
    }

    public static function set_mode($mode){
        self::$mode = $mode;
    }

    public static function set_path($path){
        self::$path = $path;
    }
    
    public static function po_locale($lang,$name=FALSE){
        $strings = array();
        if (file_exists(self::$path.DIRECTORY_SEPARATOR.$lang.'.po')) {
            $file = file_get_contents(self::$path.DIRECTORY_SEPARATOR.$lang.'.po');
			$keys = (is_string($name))?strtolower($name):basename(self::$path);
        } elseif(file_exists($lang)){
            $file = file_get_contents($lang);
			if(is_string($name)) $keys = strtolower($name);
        }
        if(isset($file)){
			$file = str_replace(array("\"\"\n","\"\n\"",'\n"'),array('',"",'\n'),$file);
            preg_match_all ("/msgid \"(.*)\".*\nmsgstr \"(.*)\".*\n/", $file, $array);
            foreach ($array[1] as $key => $value) {
                $strings[$value] = $array[2][$key];
            }
        }
		if(isset($keys))
		self::$strings[$keys] = $strings;
		else
        return $strings;
    }
    
    public static function php_locale($lang,$name=FALSE){
        $strings=array();
        if (file_exists(self::$path.DIRECTORY_SEPARATOR.$lang.'.php')) {
			$keys = (is_string($name))?strtolower($name):basename(self::$path);
            require_once self::$path.DIRECTORY_SEPARATOR.$lang.'.php';
        } elseif (file_exists($lang)) {
			if(is_string($name)) $keys = strtolower($name);
            require_once $lang;
        } else {
			self::$msgstr = $strings;
		}
		if(isset($keys))
		self::$strings[$keys] = self::$msgstr;
		else
        return self::$msgstr;
    }
    
    public static function json_locale($lang,$name=FALSE){
		$strings=array();
        if (file_exists(self::$path.DIRECTORY_SEPARATOR.$lang.'.json')) {
			$keys = (is_string($name))?strtolower($name):basename(self::$path);
           $strings= json_decode(file_get_contents(self::$path.DIRECTORY_SEPARATOR.$lang.'.json'), TRUE);
        } elseif (file_exists($lang)) {
			if(is_string($name)) $keys = strtolower($name);
            $strings= json_decode(file_get_contents($lang), TRUE);
        } 
		if(isset($keys))
		self::$strings[$keys] = $strings;
		else
		return $strings;
    }
    
    public static function load_locale($lang,$keys=FALSE){
		if(is_file($lang)) self::$mode = pathinfo($lang, PATHINFO_EXTENSION);
        switch (self::$mode) {
			case 'php':
				return self::php_locale($lang,$keys);
				break;
			case 'po':
				return self::po_locale($lang,$keys);
				break;
			case 'json':
				return self::json_locale($lang,$keys);
				break;
			
			default:
				return self::php_locale($lang);
				break;
		}
    }

    private static function mergestrings() {
        $out=array();
        $arg_list = func_get_args();
        foreach((array)$arg_list as $arg){
            foreach((array)$arg as $k => $v){
                $out[$k]=$v;
            }
        }
        return $out;
    }
    
    public static function json_save($jsonstring,$file) {
        if (file_put_contents($file, json_encode($jsonstring))) {
            return true;
        } else {
            return false;
        }
    }
    
}
?>