<?php
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
 * @version    3.0.0
 * @link       http://ymvc.ydk2.tk
 * @see        YMVC System
 * @since      File available since Release 2.1.0
**/
class Cache
{
	public $items;
	public $others;
	public function __construct(){

	}
	public function setData($settings,$data){
        if(!empty($data)){
            $save = file_put_contents($settings,serialize($data));
            if(!$save){
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }
    public function getData($settings){
        return unserialize(file_get_contents($settings));
    }

    public function unsetItem(&$items,$item,$by='id'){
		$chk = 0;
		reset($items);
	    while (list($a, $value) = each($items)) {
            if($value[$by] == $item){
                unset($items[$a]);
                if(!isset($items[$a])) $chk += 1;
            }
        }
		return $chk;
    }

    public function filter_list($data,$filter='group'){
        if(!empty($data)){
            $group_list = array();
            foreach ($data as $item) {
                $group_list[] = $item[$filter];
            }
            $resultgrp = array_unique($group_list);


            return $resultgrp;
        } else {
            return array();
        }
    }
    public function splitData($data,$by,$filter='group'){
        if(!empty($data)){
            foreach ($data as $entry) {
                if($entry[$filter]==$by){
                    $this->items[]=$entry;
                } else {
                    $this->others[]=$entry;
                }
            }
        }
    }
    public function itemsData($data,$by,$filter='group'){
		$items=array();
        if(!empty($data)){
            foreach ($data as $entry) {
                if($entry[$filter]==$by){
                    $items[]=$entry;
                }
            }
        }
		return $items;
    }
    public function othersData($data,$by,$filter='group'){
		$items=array();
        if(!empty($data)){
            foreach ($data as $entry) {
                if($entry[$filter]!=$by){
                    $items[]=$entry;
                }
            }
        }
		return $items;
    }
	public function joinData($items,$others){
		$updated = array();
		if(!empty($others)){
			$updated = $others;
        if(!empty($items)){
            reset($items);
            while (list($a, $value) = each($items)) {
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
	public function freekey($data,$by='id'){
        $freekey = count($data)+1;
        foreach ($data as $pos => $val) {
            $i =$pos+1;
            if ($i > $val[$by]) {
                $freekey =  $i;
            }
        }
        return $freekey;
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