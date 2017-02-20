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
		 return $this->cache->splitData($data,$by,$filter);
    }
    public function itemsData($data,$by,$filter='group'){
		 return $this->cache->itemsData($data,$by,$filter);
    }
    public function othersData($data,$by,$filter='group'){
		 return $this->cache->othersData($data,$by,$filter);
    }
	function joinData($items,$others){
		 return $this->cache->joinData($items,$others);
	}
	function fixby($items,$by='pos'){
		 return $this->cache->fixby($items,$by);
	}
	public function freekey($data,$by='id'){
         return $this->cache->freekey($data,$by);
    }
}

?>