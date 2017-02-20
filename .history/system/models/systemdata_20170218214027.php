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
            $this->cache = Helper::Loader(CORE.'cache');
            //var_dump(return $this->cache->);
    }
    public function setData($settings,$data){
        return $this->cache->setData($settings,$data);
    }
    public function getData($settings){
        return $this->cache->getData($settings);
    }

    public function unsetItem(&$items,$item,$by='id'){
        return $this->cache->unsetItem($items,$item,$by);
    }

    public function filter_list($data,$filter='group'){
         return $this->cache->filter_list($data,$filter);
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