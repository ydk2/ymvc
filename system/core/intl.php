<?php
class Intl {
	
public static $strings;
public static $langlen;
public static $lang;
public static $langdirpath;

public static function format($string='', $vars=array())
{
    if (!$string) return '';
    if (count($vars) > 0)
    {
        foreach ($vars as $subs)
        {
            $string = str_replace('%'.$subs, self::_($subs), $string);
        }
    }
    return $string;
}

public static function getlocales($current_lang='',$lang_lists=NULL) {
    if($lang_lists==NULL) $lang_lists=self::availablelocales();
    $browser_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, (self::$langlen==null)?2:self::$langlen);
    foreach($lang_lists as $i => $lang_code){
		if($lang_code == $current_lang){
            return $current_lang;
        } 
    }
	return FALSE;
}

public static function browserlocale($lang='',$long = 2) {
    $browser_lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, (self::$langlen==null)?$łong:self::$langlen);
        if($lang != '' || $lang == $browser_lang){
            return $lang;
        }
	return $browser_lang;
}

public static function availablelocalesdir(){
//echo basename($_SERVER['SCRIPT_FILENAME'])."<br>";
$array = array();
foreach (glob(self::$langdirpath.DIRECTORY_SEPARATOR.'*') as $filename) {
	if(is_dir($filename)): 
	$array[] = basename($filename).DIRECTORY_SEPARATOR.strstr(basename($_SERVER['SCRIPT_FILENAME']), '.', true);
	endif;   
}
return $array;	
}



public static function availablelocales(){
$array = array();
foreach (glob(self::$langdirpath.DIRECTORY_SEPARATOR.'*') as $filename) {
	if(is_file($filename)) $array[] = strstr(basename($filename), '.', true);   
}
return $array;	
}

public static function setlangcode($lang){
	self::$lang = $lang;		
}

public static function phplocale($lang){
	$strings=array();
	if (file_exists(self::$langdirpath.DIRECTORY_SEPARATOR.$lang.'.php')) {
		require_once self::$langdirpath.DIRECTORY_SEPARATOR.$lang.'.php';
	} elseif (file_exists($lang)) {
		require_once $lang;
	} 
	self::$strings = $strings;
}

public static function jsonlocale($lang){
	if (file_exists(self::$langdirpath.DIRECTORY_SEPARATOR.$lang.'.json')) {
		self::$strings = json_decode(file_get_contents(self::$langdirpath.DIRECTORY_SEPARATOR.$lang.'.json'), TRUE);
	} elseif (file_exists($lang)) {
		self::$strings = json_decode(file_get_contents($lang), TRUE);
	} else {
		self::$strings = array();
	}
}

public static function loadlocale($lang){
	$a = self::$strings;
	self::phplocale($lang);
	$b = self::$strings;
	self::jsonlocale($lang);
	$c = self::$strings;
	self::$strings = self::mergestrings($a,$b,$c);
}

public static function autoloadlocale($lang=''){
	self::loadlocale(self::getlocales(self::defaultlocale($lang)));
}

private static Function mergestrings() {
	$out=array();
      $arg_list = func_get_args();
      foreach((array)$arg_list as $arg){
          foreach((array)$arg as $k => $v){
              $out[$k]=$v;
          }
      }
    return $out;
}

public static function jsonsave($jsonstring,$file) {
	if (file_put_contents($file, json_encode($jsonstring))) {
		return true;
	} else {
		return false;
	}
}

public static function _($string,$array=array(),$strings=array()){
	if (empty(self::$strings)) {
		self::$strings=$strings;
	}
    return (isset(self::$strings[$string]) && self::$strings[$string]!='')?self::format(self::$strings[$string],$array):self::format($string,$array);
}
public static function __($string,$strings=array()){
	if (empty(self::$strings)) {
		self::$strings=$strings;
	}
	return (isset(self::$strings[$string]) && self::$strings[$string]!='')?self::$strings[$string]:$string;
}
}
?>