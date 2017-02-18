<?php
/**
*
*/
class SystemData extends DBConnect {
    public $dump;
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
    }
    public function setData($settings,$data){
        if(!empty($data)){
            $save = file_put_contents(Config::$data[$settings],serialize($data));
            if(!$save){
                return FALSE;
            } else {
                return TRUE;
            }
        }
    }
    public function getData($settings){
        return unserialize(file_get_contents(Config::$data[$settings]));
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
	function fixby($updateditems,$by='pos'){
		$fixedpos = array();
        if(!empty($updateditems)){
            $this->sortby($updateditems,$by);
            $p = 1;
            foreach ($updateditems as $fix) {
                $fix[$by]=$p;
                $fixedpos[]=$fix;
                $p++;
            }
        }
		return $fixedpos;
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