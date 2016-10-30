<?php
/**
 * Intl like Gettext 
 *
 *
 * This class can translate application texts from arrays or JSON or Gettext PO files with plurals.
 *
 * It can auto-detect the user preferred languages and load translation files in JSON format or PHP scripts with arrays of strings
 * can to work with Gettext PO files with plurals.
 * It can also format strings with placeholders %named_value to translated string 'named_value'.
 * If you find bug or bad logic for plurals, notify me, any support is welcome
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Localization
 * @package    Intl like Gettext 
 * @author     ydk2 <me@ydk2.tk>
 * @copyright  1997-2016 ydk2.tk
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    1.5.1.0
 * @link       none
 * @see        not yet
 * @since      File available since Release 1.5.0.0
 
 */

class Intl {
// {{{ constants

/**
 * Constants used for $mode and Intl::$mode
 */
	const PHP = 'php';
	const PO = 'po';
	const JSON = 'json';
// }}}
// {{{ properties

    /**
    * Array with translated strings
    * @access public
    * @static
    * @var array
    */
    public static $strings;
    
    /**
    * Default lang code
    * @access public
    * @static
    * @var string
    */
    public static $default_lang;
    
    /**
    * lang code
    * @access public
    * @static
    * @var string
    */
    public static $lang;
        
    /**
    * Path for locales dir
    * @access public
    * @static
    * @var string
    */
    private static $path;
        
    /**
    * mode for Intl work with Intl::PHP/PO/JSON
    * @access public
    * @static
    * @var string
    */
    private static $mode;
    
    /**
    * function helper property
    * @access private
    * @static
    * @var array of strings
    */
    private static $msgstr;
// }}}

/**
* Get formated string with array values
* @access public
* @static
* @param string $string
* @param array $vars
* @return string 
**/    
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

 /**
* Get formated translated string with array values
* @access public
* @static
* @param string $string
* @param array $array
* @param mixed $strings
* @return string 
**/     
    public static function _f($string,$array=array(),$strings=array()){
		$_strings=array();
		if(is_string($strings) && isset(self::$strings[strtolower($strings)]))
		$_strings = self::$strings[strtolower($strings)];
		if(is_array($strings))
		$_strings = $strings;
        return (isset($_strings[$string]) && $_strings[$string]!='')?self::format($_strings[$string],$array):self::format($_string,$array);
    }

 /**
* Get translated string with array values
* @access public
* @static
* @param string $string
* @param mixed $strings
* @return string 
**/ 
    public static function _($string,$strings=array()){
		$_strings=array();
		if(is_string($strings) && isset(self::$strings[strtolower($strings)]))
		$_strings = self::$strings[strtolower($strings)];
		if(is_array($strings))
		$_strings = $strings;
        return (isset($_strings[$string]) && $_strings[$string]!='')?$_strings[$string]:$string;
    }
    
 /**
* Get available locales from browser
* @access public
* @static
* @param string $lang
* @param array $short
* @return string 
**/     
    public static function get_browser_lang($lang=array(),$short = 'en'){
        if(is_array($lang) && !empty($lang)){
        $default_language_code = (self::$default_lang == NULL)? $short : self::$default_lang;
        $http_accept_language = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
        preg_match_all('~([\w-]+)(?:[^,\d]+([\d.]+))?~', strtolower($http_accept_language), $matches, PREG_SET_ORDER);
        $available_languages = array();
        foreach ($matches as $match) {
            $priority = isset($match[2]) ? (float) $match[2] : 1.0;
            $available_languages[$match[1]] = $priority;
        }
        arsort($available_languages);
        foreach ($available_languages as $key => $value) {
             if(in_array($key,$lang))
                return $key;
            $opt = explode('-', $key);
            if(in_array($opt[0],$lang))
                return $opt[0];
            $opt = explode('_', $key);
            if(in_array($opt[0],$lang))
                return $opt[0];
            if(in_array($default_language_code,$lang))
                return $default_language_code;
        }
        return $default_language_code;
        } else {
        $http_accept_language = $_SERVER["HTTP_ACCEPT_LANGUAGE"];
        preg_match_all('~([\w-]+)(?:[^,\d]+([\d.]+))?~', strtolower($http_accept_language), $matches, PREG_SET_ORDER);
        $available_languages = array();
        foreach ($matches as $match) {
            $priority = isset($match[2]) ? (float) $match[2] : 1.0;
            $available_languages[$priority] = $match[1];
        }
        return $available_languages[1];
        }
    }

 /**
* Get available locales from dir with mode Intl::PHP/PO/JSON
* @access public
* @static
* @param string $mode
* @return array of strings
**/       
    public static function available_locales($mode=NULL){
		if(isset($mode)) self::$mode=$mode;
		if(!isset(self::$mode)) self::$mode='php';
        $array = array();
        foreach (glob(self::$path.DIRECTORY_SEPARATOR.'*.'.self::$mode) as $filename) {
            if(is_file($filename)) $array[] = basename($filename,'.'.self::$mode);
        }
        return $array;
    }

 /**
* Set lang code
* @access public
* @static
* @param string $lang
**/        
    public static function set_lang($lang){
        self::$lang = $lang;
    }

 /**
* Set default lang code
* @access public
* @static
* @param string $lang
**/  
    public static function set_default_lang($lang){
        self::$default_lang = $lang;
    }

/**
* Set default mode Intl::PHP/PO/JSON
* @access public
* @static
* @param string $mode
**/  
    public static function set_mode($mode){
        self::$mode = $mode;
    }

/**
* Set path for langs files
* @access public
* @static
* @param string $path
**/  
    public static function set_path($path){
        self::$path = $path;
    }

/**
* Load simple po lang files
* @access public
* @static
* @param string $lang
* @param string $name 
* @return array
**/      
    public static function po_locale_simple($lang,$name=FALSE){
        $string = '';
        $strings = array();
        if (file_exists(self::$path.DIRECTORY_SEPARATOR.$lang.'.po')) {
            self::$lang = $lang;
            $file = file_get_contents(self::$path.DIRECTORY_SEPARATOR.$lang.'.po');
			$keys = (is_string($name))?strtolower($name):basename(self::$path);
        } elseif(file_exists($lang)){
            $file = file_get_contents($lang);
			if(is_string($name)) $keys = strtolower($name);
        }
        if(isset($file)){
        $strings =  preg_replace(array("/\t+\n/"), "\n", $file);
        $strings =  preg_replace(array("/\s+\n/"), "\n", $strings);
        $strings = str_replace(array("msgid \"\"\nmsgstr","\"\n\""),array("msgid \"_PO_HEADER_\"\nmsgstr",''),$strings);
            preg_match_all ("/msgid \"(.*)\".*\nmsgstr \"(.*)\".*\n/", $strings, $array);
            //var_dump($array);
            foreach ($array[1] as $key => $value) {
                $string[$value] = $array[2][$key];
            }
        }
		if(isset($keys))
		self::$strings[$keys] = $string;
		else
        return $string;
    }

/**
* Load php lang files
* @access public
* @static
* @param string $lang
* @param string $name 
* @return array
**/     
    public static function php_locale($lang,$name=FALSE){
        $strings=array();
        if (file_exists(self::$path.DIRECTORY_SEPARATOR.$lang.'.php')) {
            self::$lang = $lang;
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

/**
* Load json lang files
* @access public
* @static
* @param string $lang
* @param string $name 
* @return array
**/     
    public static function json_locale($lang,$name=FALSE){
		$strings=array();
        if (file_exists(self::$path.DIRECTORY_SEPARATOR.$lang.'.json')) {
            self::$lang = $lang;
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

/**
* Load simple lang files not for plural
* @access public
* @static
* @param string $lang
* @param string $name 
* @return array
**/     
    public static function load_locale_simple($lang,$keys=FALSE){
		if(is_file($lang)) self::$mode = pathinfo($lang, PATHINFO_EXTENSION);
        switch (self::$mode) {
			case 'php':
				return self::php_locale($lang,$keys);
				break;
			case 'po':
				return self::po_locale_simple($lang,$keys);
				break;
			case 'json':
				return self::json_locale($lang,$keys);
				break;
			
			default:
				return self::php_locale($lang);
				break;
		}
    }

/**
* Merge arrays
* @access public
* @static
* @param array , array ...
* @return array
**/ 
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
 
/**
* Parse Gettext po file into array
* @access public
* @static
* @param string $path
* @return array of strings from po file
**/
public static function parse_po_file($path){
    $oarray = array();
    if(is_file($path)){
        $postring = file_get_contents($path);
        $oarray = self::parse_po_string($postring);
    }
    return $oarray;
}

/**
* Load and parse Gettext po file into array
* @access public
* @static
* @param string $lang
* @param string $name
* @return array of strings from po file
**/
    public static function po_locale_plural($lang,$name=FALSE){
        $strings = array();
        if (file_exists(self::$path.DIRECTORY_SEPARATOR.$lang.'.po')) {
            self::$lang = $lang;
            $file = file_get_contents(self::$path.DIRECTORY_SEPARATOR.$lang.'.po');
			$keys = (is_string($name))?strtolower($name):basename(self::$path);
        } elseif(file_exists($lang)){
            $file = file_get_contents($lang);
			if(is_string($name)) $keys = strtolower($name);
        }
        if(isset($file)){
            $strings = self::parse_po_string($file);
        }
		if(isset($keys))
		self::$strings[$keys] = $strings;
		else
        return $strings;
    }

/**
* Get translated string from array with plurals
* @access public
* @param string $msgid
* @param mixed $strings
* @param mixed $plurals = array('plural'=>$plural,'nplurals'=>$nplurals) auto if NULL
* @return string Translated string
**/
public static function _p($msgid, $strings=array(), $plural = NULL){
    $_strings=array();
	if(is_string($strings) && isset(self::$strings[strtolower($strings)]))
	$_strings = self::$strings[strtolower($strings)];
	if(is_array($strings))
	$_strings = $strings;
    if((!isset($plural['plural']) && !isset($plural['nplurals'])))
    $plurals = self::get_plural_by_lang($plural,self::$lang);
    else 
    $plurals = $plural;
    return self::_n_search($msgid,$_strings,$plurals['nplurals'],$plurals['plural']);
}

/**
* Get translated plural string from array with plurals
* @access public
* @param string $msgid
* @param string $msgid_plural
* @param integer $n
* @param mixed $strings
* @param array $plurals = array('plural'=>$plural,'nplurals'=>$nplurals) auto if NULL
* @return string Translated string
**/
public static function _n($msgid, $msgid_plural, $n, $strings=array(), $plural = NULL){
    $_strings=array();
	if(is_string($strings) && isset(self::$strings[strtolower($strings)]))
	$_strings = self::$strings[strtolower($strings)];
	if(is_array($strings))
	$_strings = $strings;
     if((!isset($plural['plural']) && !isset($plural['nplurals'])))
    $plurals = self::get_plural_by_lang($n,self::$lang);
    else 
    $plurals = $plural;
    return self::_n_search_plural($msgid,$msgid_plural,$n,$_strings,$plurals['nplurals'],$plurals['plural']);
}

/**
* Parse Gettext po string into array
* @access public
* @static
* @param string $postring
* @return array of strings from po file
**/
public static function parse_po_string($postring){
    $oarray = array();
    if(!empty($postring)){
        $strings =  preg_replace(array("/\t+\n/"), "\n", $postring);
        $strings =  preg_replace(array("/\s+\n/"), "\n", $strings);
        $strings = str_replace(array("msgid \"\"\nmsgstr","\"\n\""),array("msgid \"_PO_HEADER_\"\nmsgstr",''),$strings);
        $narray = explode("\n",$strings);
        $ikey = 0; $pkey = 0;$skey = 0; $ckey = 0;$sikey = 0;$cmkey = 0;$cikey = 0;
        $n = 0;
        for ($i=0; $i < count($narray); $i++) {
            $cmsgid = preg_match("/^msgid \"(.*)\"/",$narray[$i],$msgid);
            $cmsgidp = preg_match("/^msgid_plural \"(.*)\"/",$narray[$i],$msgidp);
            $cmsgstr = preg_match("/^msgstr \"(.*)\"/",$narray[$i],$msgstr);
            $cmsgstri = preg_match("/^msgstr\[([0-9]+)\] \"(.*)\"/",$narray[$i],$msgstri);
            //$cstr = preg_match("/^\"(.*)\"/",$narray[$i],$str);
            if($cmsgid){
                $ikey = $i;
                $n++;
            }
            if($cmsgidp){
                $pkey = $i;
            }
            if($cmsgstr){
                $skey = $i;
            }
            if($cmsgstri){
                $sikey = $i;
            }
            
            if($ikey <= $i){
                if($ikey == $i){
                    if($n == 1){
                        $oarray[$n]['HEADER']=$msgid[1];
                    } else {
                        $oarray[$n]['msgid']=$msgid[1];
                    }
                }
                if($ikey < $pkey && $pkey == $i){
                    $oarray[$n]['msgid_plural']=$msgidp[1];
                }
                if($ikey < $skey && $skey == $i){
                    if($n == 1){
                        $oarray[$n]['HEADER_STR']=explode('\n',$msgstr[1]);
                    } else {
                        $oarray[$n]['msgstr']=$msgstr[1];
                    }
                }
                if($ikey < $sikey && $sikey == $i){
                    $oarray[$n]['msgstr'][$msgstri[1]]=$msgstri[2];
                }
            }
        }
    }
    return $oarray;
}

/**
*  Return translated string from parsed po array*
* @access public
* @static
* @param string $msgid
* @param array $domain
* @param integer $nplurals
* @param integer $plural
* @return string Translated string or $msgid
**/
public static function _n_search($msgid, array $domain, $nplurals = 2, $plural = 1){
    $retstr = $msgid;
    foreach ($domain as $value) {
        if(isset($value['msgid']) && isset($value['msgstr']) && !isset($value['msgid_plural']) && !is_array($value['msgstr']))
        	if($value['msgid']==$msgid)
        		$retstr = $value['msgstr'];
                if($retstr == "")
                    $retstr = $msgid;
        if(isset($value['msgid']) && isset($value['msgid_plural']) && is_array($value['msgstr']))
        		foreach($value['msgstr'] as $i=>$values):
       				if($i == 0)
        				if($value['msgid']==$msgid)
        					$retstr = (isset($value['msgstr'][0])) ? $value['msgstr'][0] : $msgid;
                            if($retstr == "")
                                $retstr = $msgid;
    				else
        				if($value['msgid_plural']==$msgid)
                            $retstr = (isset($value['msgstr'][$plural])) ? $value['msgstr'][$plural] : $msgid;
                            if($retstr == "")
                                $retstr = $msgid;
    			endforeach;
    }
	return $retstr;
}

/**
*  Return translated plural string from parsed po array
* @access public
* @static
* @param string $msgid
* @param string $msgid_plural
* @param integer $n
* @param array $domain
* @param integer $nplurals
* @param integer $plural
* @return string Translated string
**/
public static function _n_search_plural($msgid, $msgid_plural, $n, array $domain, $nplurals = 1, $plural = 0){
    return ($n == 1) ? self::_n_search($msgid, $domain, $nplurals, $plural) : _n_search($msgid_plural, $domain, $nplurals, $plural);
}

/**
*  Return plural by language code and numeric value
* @info work in process missing logic for some langs
* @access public
* @static
* @param integer $n
* @param string $lang
* @return array('plural'=>$plural,'nplurals'=>$nplurals)
**/
public static function get_plural_by_lang($n, $lang = NULL){

switch ($lang) {
    case 'cy':
    // nplurals=4; plural=(n==1) ? 0 : (n==2) ? 1 : (n != 8 && n != 11) ? 2 : 3;
        $nplurals = 4;
        $plural = ($n==1) ? 0 : (($n==2) ? 1 : (($n != 8 && $n != 11) ? 2 : 3));
        break;
    case 'ga':
    // nplurals=5; plural=n==1 ? 0 : n==2 ? 1 : (n>2 && n<7) ? 2 :(n>6 && n<11) ? 3 : 4;
        $nplurals = 5;
        $plural = ($n==1) ? 0 : (($n==2) ? 1 : (($n > 2 && $n < 7) ? 2 : (($n>6 && $n<11) ? 3 : 4)));
        break;
    case 'gd':
    // nplurals=4; plural=(n==1 || n==11) ? 0 : (n==2 || n==12) ? 1 : (n > 2 && n < 20) ? 2 : 3;
        $nplurals = 4;
        $plural = ($n==1 || $n==11) ? 0 : (($n==2 || $n==12) ? 1 : (($n > 2 && $n < 20) ? 2 : 3));
        break;
    case 'is':
    // nplurals=2; plural=(n%10!=1 || n%100==11);
        $nplurals = 2;
        $plural = (($n % 10!=1) || ($n % 100==11)) ? 1 : 0;
        break;
    case 'kw':
    // nplurals=4; plural=(n==1) ? 0 : (n==2) ? 1 : (n == 3) ? 2 : 3;
        $nplurals = 4;
        $plural = ($n==1) ? 0 : (($n==2) ? 1 : (($n == 3) ? 2 : 3));
        break;
    case 'lt':
    // nplurals=3; plural=(n%10==1 && n%100!=11 ? 0 : n%10>=2 && (n%100<10 || n%100>=20) ? 1 : 2);
        $nplurals = 3;
        $plural = ($n%10==1 && $n%100!=11) ? 0 : ($n%10>=2 && ($n%100<10 || $n%100>=20) ? 1 : 2);
        break;
    case 'lv':
    // nplurals=3; plural=(n%10==1 && n%100!=11 ? 0 : n != 0 ? 1 : 2);
        $nplurals = 3;
        $plural = ($n%10==1 && $n%100!=11) ? 0 :(($n != 0) ? 1 : 2);
        break;
    case 'mk':
    // nplurals=2; plural= n==1 || n%10==1 ? 0 : 1; Can’t be correct needs a 2 somewhere
        $nplurals = 2;
        $plural = ($n==1 || $n%10==1) ? 0 : 1; // Can’t be correct needs a 2 somewhere
        break;
    case 'mnk':
    // nplurals=3; plural=(n==0 ? 0 : n==1 ? 1 : 2);
        $nplurals = 3;
        $plural = ($n==0) ? 0 : (($n==1) ? 1 : 2);
        break;
    case 'mt':
    // nplurals=4; plural=(n==1 ? 0 : n==0 || ( n%100>1 && n%100<11) ? 1 : (n%100>10 && n%100<20 ) ? 2 : 3);
        $nplurals = 4;
        $plural = ($n==1) ? 0 : ($n==0 || ( $n%100>1 && $n%100<11) ? 1 : ($n%100>10 && $n%100<20 ) ? 2 : 3);
        break;
    case 'ro':
    // nplurals=3; plural=(n==1 ? 0 : (n==0 || (n%100 > 0 && n%100 < 20)) ? 1 : 2);
        $nplurals = 3;
        $plural = ($n==1) ? 0 : (($n==0 || ($n%100 > 0 && $n%100 < 20)) ? 1 : 2);
        break;
    case 'sl':
    // nplurals=4; plural=(n%100==1 ? 1 : n%100==2 ? 2 : n%100==3 || n%100==4 ? 3 : 0);
        $nplurals = 4;
        $plural = ($n%100==1) ? 1 : (($n%100==2) ? 2 : ($n%100==3 || $n%100==4) ? 3 : 0);
        break;
    case 'ru':
    case 'sr':
    case 'hr':
    case 'bs':
    case 'be':
    case 'uk':
    //     
        // nplurals=3; plural=(n%10==1 && n%100!=11 ? 0 : n%10>=2 && n%10<=4 && (n%100<10 || n%100>=20) ? 1 : 2);
        $nplurals = 3;
        $plural = ($n % 10==1 && $n % 100!=11) ? 0 : ((($n % 10>=2 && $n % 10<=4 && $n % 100<10) || $n % 100>=20) ? 1 : 2);
        break;

    case 'ar':
        // nplurals=6; plural=(n==0 ? 0 : n==1 ? 1 : n==2 ? 2 : n%100>=3 && n%100<=10 ? 3 : n%100>=11 ? 4 : 5);
        $nplurals = 6;
        $plural = ($n == 0) ? 0 : (($n == 1) ? 1 : (($n == 2) ? 2 : (($n % 100 >= 3 && $n% 100<= 10) ? 3 : (($n % 100 >= 11) ? 4 : 5))));
        break;

    case 'cs':
    case 'sk':
        // nplurals=3; plural=(n==1) ? 0 : (n>=2 && n<=4) ? 1 : 2;
        $nplurals = 3;
        $plural = ($n == 1) ? 0 : (($n % 10 >= 2 && $n % 10 <=4) ? 1 : 2 );
        break;
  
    case 'pl': 
    case 'csb':
        // polski pl nplurals=3; plural=(n==1 ? 0 : n%10>=2 && n%10<=4 && (n%100<10 || n%100>=20) ? 1 : 2);$nplurals = 3;
        $nplurals = 3;
        $plural = ($n == 1) ? 0 : ((($n % 10 >= 2 && $n % 10 <=4) && ($n % 100<=10 || $n % 100 >= 20)) ? 1 : 2 );
        break;

    case 'ach':
    case 'ak':
    case 'am':
    case 'arn':
    case 'br':
    case 'fr':
    case 'gun':
    case 'ln':
    case 'mfe':
    case 'mi':
    case 'oc':
    case 'pt_BR':
    case 'pt-br':
    case 'uz':
    case 'wa':
    case 'zh':
    //  nplurals=2; plural=(n > 1);
        $nplurals = 2;
        $plural = ($n > 1) ? 1 : 0;
        break;
    case 'af':
    case 'an':
    case 'anp':
    case 'as':
    case 'ast':
    case 'az':
    case 'bg':
    case 'bn':
    case 'brx':
    case 'ca':
    case 'da':
    case 'de':
    case 'doi':
    case 'el':
    case 'en':
    case 'eo':
    case 'es':
    case 'et':
    case 'eu':
    case 'ff':
    case 'fi':
    case 'fo':
    case 'fur':
    case 'fy':
    case 'gl':
    case 'gu':
    case 'ha':
    case 'he':
    case 'hi':
    case 'hne':
    case 'hu':
    case 'hy':
    case 'ia':
    case 'it':
    case 'kl':
    case 'kn':
    case 'ku':
    case 'lb':
    case 'mai':
    case 'mn':
    case 'mni':
    case 'mr':
    case 'nah':
    case 'nap':
    case 'nb':
    case 'ne':
    case 'nl':
    case 'nn':
    case 'no':
    case 'nso':
    case 'or':
    case 'pa':
    case 'pap':
    case 'pms':
    case 'ps':
    case 'pt':
    case 'rm':
    case 'rw':
    case 'sat':
    case 'sco':
    case 'sd':
    case 'se':
    case 'si':
    case 'so':
    case 'son':
    case 'sq':
    case 'sv':
    case 'sw':
    case 'ta':
    case 'te':
    case 'tk':
    case 'ur':
    case 'yo':
    // default english en nplurals=2; plural=(n != 1);
        $nplurals = 2;
        $plural = ($n != 1) ? 1 : 0;
        break;
    default:
    // default nplurals=1; plural=0;
        $nplurals = 1;
        $plural = 0;
        break;
}
return array('plural'=>$plural,'nplurals'=>$nplurals);
}


/**
* Save as json lang files
* @access public
* @static
* @param array $array
* @param string $file
* @return boolean
**/    
    public static function json_save($array,$file) {
        if (file_put_contents($file, json_encode($array))) {
            return true;
        } else {
            return false;
        }
    }

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */    
}
?>