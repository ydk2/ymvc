<?php
/**
*
*/
class SystemData extends DBConnect {
    public $cache;
    public $datalist;
    public $items;
    public $others;
    function __construct($import=FALSE)
    {
        # code...

        $this->items = array();
        $this->others = array();
        $data=Config::$data['default']['database'];
            $this->time = get_time();
            $this ->Connect($data['type'], $data['name'], $data['host'],$data['user'], $data['pass']);
            $this->cache = Helper::Loader(DOCROOT.DS.CORE.'cache');
            var_dump(DOCROOT.DS.CORE.'cache');
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
	function joinData($items,$others){
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
	function fixby($items,$by='pos'){
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
}

?>