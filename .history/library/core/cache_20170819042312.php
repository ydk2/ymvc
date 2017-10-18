<?php
namespace Library\Core;
/**
*
 * PHPRender fast and simple to use PHP MVC framework
 *
 * MVC Framework for PHP 5.2 + with PHP files views part of YMVC System
 * Class with preconfigured values used as glogals
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Framework, MVC, Cache
 * @package    YMVC System
 * @subpackage Cache
 * @author     ydk2 <me@ydk2.tk>
 * @copyright  1997-2016 ydk2.tk
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    1.0.0
 * @link       http://ymvc.ydk2.tk
 * @see        YMVC System
 * @since      File available since Release 2.1.0
**/
class Cache
{
	public $cached=array();
	public $used=array();
    public $rest=array();
    
	public function __construct(){

	}
    
    public function encode($cache){
        if(!empty($cache)){
            return serialize($cache);
        }
        return FALSE;
    }

    public function decode($string){
        if($this->isencoded($string))
        return unserialize($string);
        else return array();
    }

	public function write($file,$cache){
        if(!empty($cache) && file_exists($file)){
            $save = file_put_contents($file,serialize($cache));
            if(!$save){
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }

    public function read($file){
        if(file_exists($file)){
            $string = file_get_contents($file);
            if($this->isencoded($string))
            return unserialize($string);
        } else return array();
    }

    public function inCache($items,$item,$by='id'){
		$chk = 0;
		reset($items);
	    while (list($a, $value) = each($items)) {
            if($value[$by] == $item){
                $chk += 1;
            }
        }
		return $chk;
    }


    public function GetItemByGroup($items,$one,$by='id',$two,$and='group'){

		reset($items);
	    while (list($a, $value) = each($items)) {
            if($value[$by] == $one && $value[$and] == $two){
                return $value;
            }
        }
		return FALSE;
    }

    public function get($items,$item,$by='id'){
		reset($items);
	    while (list($i, $value) = each($items)) {
            if($value[$by] == $item){
                return $value;
            }
        }
		return FALSE;
    }

    public function set(&$items,$item,$string,$k='id',$v='value'){
		$chk = 0;
		reset($items);
	    while (list($i, $value) = each($items)) {
            if($value[$k] == $item){
                //unset($items[$i]);
                $value[$v]=$string;
                if(isset($items[$i])) $chk += 1;
            }
        }
		return $chk;
    }

    public function del(&$items,$item,$by='id'){
		$chk = 0;
		reset($items);
	    while (list($i, $value) = each($items)) {
            if($value[$by] == $item){
                unset($items[$i]);
                if(!isset($items[$i])) $chk += 1;
            }
        }
		return $chk;
    }

    public function groups($cache,$filter='group'){
        if(!empty($cache)){
            $group = array();
            foreach ($cache as $item) {
                $group[] = $item[$filter];
            }
            $result = array_unique($group);
            return $result;
        } else {
            return array();
        }
    }

    public function split($cache,$by,$filter='group'){
        if(!empty($cache)){
            foreach ($cache as $entry) {
                if($entry[$filter]==$by){
                    $this->used[]=$entry;
                } else {
                    $this->rest[]=$entry;
                }
            }
        }
    }

    public function filter($cache,$by,$filter='group'){
		$items=array();
        if(!empty($cache)){
            foreach ($cache as $entry) {
                if($entry[$filter]==$by){
                    $items[]=$entry;
                }
            }
        }
		return $items;
    }

    public function rest($cache,$by,$filter='group'){
		$items=array();
        if(!empty($cache)){
            foreach ($cache as $entry) {
                if($entry[$filter]!=$by){
                    $items[]=$entry;
                }
            }
        }
		return $items;
    }

	public function join($items,$rest){
		$updated = array();
		if(!empty($rest)){
			$updated = $rest;
        if(!empty($items)){
            reset($items);
            while (list($i, $value) = each($items)) {
                $updated[]=$value;
            }
        }
		} else {
			$updated = $items;
		}
		return $updated;
    }
    
	public function fixby($items,$by='id'){
		$fixed = array();
        if(!empty($items)){
            $this->sortby($items,$by);
            $p = 1;
            foreach ($items as $fix) {
                $fix[$by]=$p;
                $fixed[]=$fix;
                $p++;
            }
        }
		return $fixed;
    }
    
	public function freeby($cache,$by='id'){
        if(empty($cache)) return 1;
        $freekey = count($cache)+1;
        foreach ($cache as $pos => $val) {
            $i =$pos+1;
            if ($i > $val[$by]) {
                $freekey =  $i;
            }
        }
        return $freekey;
    }
    public function isencoded($str) {
        return ($str == serialize(false) || @unserialize($str) !== false);
    }
/**
* Sort array by key
* @param Array $array
* @param String $subkey
* @param bool $sort_ascending
*/
	public function sortby(&$array, $subkey="", $sort_ascending=TRUE) {
	if (count($array))
	$temp_array[key($array)] = array_shift($array);
	foreach($array as $key => $val){
		$offset = 0;
		$found = false;
		foreach($temp_array as $tmp_key => $tmp_val) {
			if(!$found and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey])) {
				$temp_array = array_merge((array)array_slice($temp_array,0,$offset), array($key => $val), array_slice($temp_array,$offset));
				$found = true;
			}
			$offset++;
		}
		if(!$found) $temp_array = array_merge($temp_array, array($key => $val));
	}
	if ($sort_ascending) $array = array_reverse($temp_array);
	else $array = $temp_array;
	}

}


?>