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
    
    public function storeWrite($store,$data,$table="sitedata"){
        $string = $this->cache->setCacheString($data);
        if($string)
        return $this->TInsertUpdate($table,array("name"=>$store,"string"=>$string),"WHERE name='".$store."'",array());
        else
        return FALSE;
    }
    
    public function storeRead($store,$table="sitedata"){
        $string = $this->Select($table,array('*'),"WHERE name=?",array($store));
        if($string){
            return $this->cache->getCacheString($string[0]['string']);
        }
        return array();
    }
    public function storeReadString($store,$table="sitedata"){
        $string = $this->TSelect($table,array('*'),"WHERE name=?",array($store));
        if($string){
            return $string[0]['string'];
        }
        return FALSE;
    }
    
    public function Data($settings){
        return $this->cache->getCache($settings);
    }
    public function setData($settings,$data){
        return $this->cache->setCache($settings,$data);
    }
    public function getData($settings){
        return $this->cache->getCache($settings);
    }
    
    public function unsetItem(&$items,$item,$by='id'){
        return $this->cache->unsetItem($items,$item,$by);
    }
    
    public function filter_list($data,$filter='group'){
        return $this->cache->filter_list($data,$filter);
    }
    public function splitData($data,$by,$filter='group'){
        return $this->cache->splitCache($data,$by,$filter);
    }
    public function itemsData($data,$by,$filter='group'){
        return $this->cache->itemsCache($data,$by,$filter);
    }
    public function othersData($data,$by,$filter='group'){
        return $this->cache->othersCache($data,$by,$filter);
    }
    function joinData($items,$others){
        return $this->cache->joinCache($items,$others);
    }
    function fixby($items,$by='pos'){
        return $this->cache->fixby($items,$by);
    }
    public function freekey($data,$by='id'){
        return $this->cache->freekey($data,$by);
    }
}

?>