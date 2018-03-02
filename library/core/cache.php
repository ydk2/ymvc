<?php
/**
 * Created on Thu Mar 01 2018
 *
 * YMVC framework License
 * Copyright (c) 1996 - 2018 ydk2 All rights reserved.
 * 
 * YMVC version 3 fast and simple to use 
 * PHP MVC framework for PHP 5.4 + with PHP and XSLT files 
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * Redistribution and use of this software in source and binary forms, with or without modification,
 * are permitted provided that the following condition is met:
 * Redistributions of source code must retain the above copyright notice, 
 * this list of conditions and the following disclaimer.
 *   
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, 
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, 
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; 
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, 
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 * For more information on the YMVC project, 
 * please see <http://ydk2.tk>. 
 *   
 **/

/**
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

namespace Library\Core;

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
        if(!empty($cache)){
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

    public function exists($items,$item,$by='id'){
		$chk = 0;
		reset($items);
	    while (list($a, $value) = each($items)) {
            if($value[$by] == $item){
                $chk += 1;
            }
        }
		return $chk;
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

    public function update(&$items,$item,$values=array(),$by='id'){
		reset($items);
	    while (list($i, $value) = each($items)) {
            if($value[$by] == $item && !empty($values)){
                foreach ($values as $k => $v) {
                    $items[$i][$k]=$v;
                }
                if(!isset($items[$i][$by])) $items[$i][$by]=$item;
                return $items[$i];
            }
            return FALSE;
        }
		return FALSE;
    }

    public function insert(&$items,$item,$values=array(),$by='id'){
        if(!$this->exists($items,$item,$by)){
            $values[$by]=$item;
            array_push($items,$values);
            return TRUE;
        }
        return FALSE;
    }

    public function set(&$items,$item,$values=array(),$by='id'){
        if($this->exists($items,$item,$by)){
            return $this->update($items,$item,$values,$by);
        } else {
            return $this->insert($items,$item,$values,$by);;
        }
        return FALSE;
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

    public function filter($cache,$by,$filter='group',$negative=FALSE){
		$items=array();
        if(!empty($cache)){
            foreach ($cache as $entry) {
                if(!$negative){
                    if($entry[$filter]==$by){
                        $items[]=$entry;
                    }
                } else {
                    if($entry[$filter]!=$by){
                        $items[]=$entry;
                    }
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
        $i = 0;
        $freekey = count($cache)+1;
        foreach ($cache as $pos => $val) {
            $i = $pos+1;
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